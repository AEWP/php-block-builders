<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Placeholder Gutenberg block.
 */
class Placeholder extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'generic/placeholder';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = '';


	/**
	 * Insert a Placeholder block to the page.
	 *
	 * @param  string $content  String text/html/url content.
	 * @param  array  $attrs  All required block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data                  = self::get_data( $attrs );
		$data['innerContent']  = [];
		$data['attrs']['text'] = \wp_strip_all_tags( $content, true );

		return parent::return_block_html( $data, $render );
	}
}
