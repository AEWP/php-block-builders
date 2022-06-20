<?php
/**
 * Class CoreButtons
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class CoreButtons
 *
 * @package PhpBlockBuilders\Block
 */
class CoreButtons extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/buttons';

	/**
	 * Insert an empty Core Buttons block to the page.
	 *
	 * @param  string $content  The block content.
	 * @param  array  $attrs  ['layout' => ['type' => 'flex', 'orientation' => 'vertical'].
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$attrs         = self::get_block_names( $attrs );
		$inner_content = sprintf(
			'<div class="wp-block-buttons">%1$s</div>',
			\filter_block_kses_value( $content, 'post' ) // 3
		);

		$data = self::get_data(
			$attrs,
			[ $inner_content ]
		);

		return \serialize_block( $data );
	}


}
