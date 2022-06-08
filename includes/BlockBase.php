<?php
/**
 * Class BlockBase
 *
 * @package PhpBlockBuilders
 */
namespace PhpBlockBuilders;

/**
 * Class BlockBase
 *
 * @package PhpBlockBuilders
 */
abstract class BlockBase implements BlockInterface {

	/**
	 * The container block name.
	 */
	public static string $block_name = 'block/base';

	/**
	 * Optional item block name.
	 */
	public static string $item_block_name = 'block/base-item';

	/**
	 * Return a string representation of each block.
	 *
	 * @param  string  $content String text/html/url content.
	 * @param  array  $attrs All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = array() ): string {

		$data = array(
			'blockName'    => self::$block_name,
			'innerContent' => array( $content ),
			'attrs'        => $attrs,
		);

		return serialize_block( $data );

	}

	/**
	 * Create all the block inner / content items.
	 *
	 * @param  array  $attrs
	 *
	 * @return array
	 */
	protected static function create_items( array $attrs ) : array {
		return array();
	}






}
