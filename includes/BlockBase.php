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
	 * @param  string $content String text/html/url content.
	 * @param  array  $attrs All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data = [
			'blockName'    => $attrs['block_name'] ?? self::$block_name,
			'innerContent' => [ $content ],
			'attrs'        => $attrs,
		];

		return serialize_block( $data );

	}

	/**
	 * Create all the block inner / content items.
	 *
	 * @param  array $attrs Array of item attrs and content.
	 *
	 * @return string
	 */
	protected static function create_items( array $attrs ) : string {

		$rtn = [];

		if ( empty( $attrs ) ) {
			return implode( PHP_EOL, $rtn );
		}

		foreach ( $attrs as $block_attr ) {
			$rtn[] = serialize_block( array_merge_recursive( [ 'blockName' => $attrs['item_block_name'] ?? self::$item_block_name ], $block_attr ) );
		}

		return implode( PHP_EOL, $rtn );
	}


}
