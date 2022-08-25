<?php
/**
 * Class CoreSpacer
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class CoreSpacer
 *
 * @package PhpBlockBuilders\Block
 */
class CoreSpacer extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/spacer';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-spacer';

	/**
	 * Create a Core Spacer Block
	 *
	 * @param  string $content In this instance content is ignored.
	 * @param  array  $attrs Block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data = self::get_data( $attrs );

		$height      = $attrs['height'] ?? 100;
		$aria_hidden = $attrs['hidden'] ?? 'true';

		$inner_content = sprintf(
			'<div class="%1$s" style="height:%2$dpx" aria-hidden="%3$s"></div>',
			\esc_attr( $data['attrs']['className'] ), // 1
			\absint( $height ), // 2
			\esc_attr( $aria_hidden ) // 3
		);

		$data['innerContent'] = [ $inner_content ];

		return parent::return_block_html( $data, $render );
	}


}
