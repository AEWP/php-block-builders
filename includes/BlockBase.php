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
	 * Optional block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-base';

	/**
	 * Optional item block classname
	 *
	 * @var string
	 */
	public static string $item_block_classname = 'wp-block-base-item';

	/**
	 * Return a string representation of each block.
	 *
	 * @param  string $content  String text/html/url content.
	 * @param  array  $attrs  All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data                 = self::get_data( $attrs );
		$data['innerContent'] = [ $content ];

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
	 * Shortcut to set the lock attributes for all blocks.
	 *
	 * @param  array $input_data  All of the current block attributes.
	 *
	 * @return array
	 */
	public static function get_data( array $input_data ) : array {

		$default = [
			'blockName' => $input_data['block_name'] ?? static::$block_name,
			'attrs'     => [
				'className' => $input_data['attrs']['className'] ?? static::$block_classname,
				'id'        => $input_data['attrs']['id'] ?? '',
				'fontSize'  => $input_data['attrs']['fontSize'] ?? '',
				'lock'      => [
					'move'   => $input_data['attrs']['lock']['move'] ?? false,
					'remove' => $input_data['attrs']['lock']['remove'] ?? false,
				],
			],
		];

		return self::merge_arrays_deep( $input_data, $default );

	}


	/**
	 * Recursively replace all data in defaults with $args - works on multidimensional arrays
	 *
	 * @param  array $args  Arguments array.
	 * @param  array $defaults  Defaults array.
	 *
	 * @return array
	 */
	protected static function merge_arrays_deep( array $args, array $defaults ) : array {
		$rtn = (array) $defaults;

		foreach ( $args as $key => $value ) {
			if ( is_array( $value ) && isset( $rtn[ $key ] ) ) {
				$rtn[ $key ] = self::merge_arrays_deep( $value, $rtn[ $key ] );
			} else {
				$rtn[ $key ] = $value;
			}
		}

		return $rtn;
	}



}
