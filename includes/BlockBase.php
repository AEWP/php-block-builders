<?php
/**
 * Class BlockBase
 *
 * @package PhpBlockBuilders
 */

declare( strict_types=1 );

namespace PhpBlockBuilders;

/**
 * Class BlockBase
 *
 * @package PhpBlockBuilders
 */
abstract class BlockBase implements BlockInterface {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'block/base';

	/**
	 * Optional item block name.
	 *
	 * @var string
	 */
	public static string $item_block_name = 'block/base-item';

	/**
	 * Return a string representation of each block.
	 *
	 * @param  string $content  String text/html/url content.
	 * @param  array  $attrs  All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$attrs = self::get_block_names( $attrs );

		$data = self::get_data(
			$attrs,
			[ $content ],
		);

		return serialize_block( $data );

	}

	/**
	 * Create all the block inner / content items.
	 *
	 * @param  array $attrs  Array of item attrs and content.
	 *
	 * @return string
	 */
	protected static function create_items( array $attrs ): string {
		$rtn = [];

		if ( empty( $attrs ) ) {
			return implode( PHP_EOL, $rtn );
		}

		foreach ( $attrs as $block_attr ) {
			$rtn[] = serialize_block( array_merge_recursive( [ 'blockName' => $attrs['item_block_name'] ?? self::$item_block_name ], $block_attr ) );
		}

		return implode( PHP_EOL, $rtn );
	}

	/**
	 * Set some sensible attributes that all Block can use, merge with input attrs.
	 *
	 * @param  array $attrs
	 *
	 * @return array
	 */
	public static function get_block_names( array $attrs ): array {
		$rtn = [
			'block_name'      => static::$block_name,
			'item_block_name' => static::$item_block_name,
		];

		return array_merge( $rtn, $attrs );

	}


	/**
	 * Shortcut to set the lock attributes for all blocks.
	 *
	 * @param  array $block_attrs  All of the current block attributes.
	 * @param  array $inner_content Inner content array.
	 * @param  array $unique_attrs  Unique attributes required for specific block.
	 *
	 * @return array
	 */
	public static function get_data( array $block_attrs, array $inner_content = [], array $unique_attrs = [] ) : array {

		$default = [
			'blockName'    => $block_attrs['block_name'],
			'innerContent' => $inner_content,
			'attrs'        => [
				'className' => $block_attrs['classname'] ?? '',
				'id'        => $block_attrs['id'] ?? '',
				'lock'      => [
					'move'   => $block_attrs['lock_move'] ?? false,
					'remove' => $block_attrs['remove'] ?? false,
				],
			],
		];

		return self::parse_all_args( $default, $unique_attrs );

	}

	/**
	 * Recursively replace all data in defaults with $args - works on multidimensional arrays
	 *
	 * @param  array $args  Arguments array.
	 * @param  array $defaults  Defaults array.
	 *
	 * @return array
	 */
	private static function parse_all_args( array $args, array $defaults ) : array {
		$rtn = (array) $defaults;

		foreach ( $args as $key => $value ) {
			if ( is_array( $value ) && isset( $rtn[ $key ] ) ) {
				$rtn[ $key ] = self::parse_all_args( $value, $rtn[ $key ] );
			} else {
				$rtn[ $key ] = $value;
			}
		}

		return $rtn;
	}



}
