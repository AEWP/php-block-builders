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
	 * Create a Core Spacer Block
	 *
	 * @param  string $content In this instance content is ignored.
	 * @param  array  $attrs Block attributes.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$attrs       = self::get_block_attrs( $attrs );
		$classname   = $attrs['classname'] ?? 'wp-block-spacer';
		$height      = $attrs['height'] ?? 100;
		$aria_hidden = $attrs['hidden'] ?? 'true';

		$inner_content = sprintf(
			'<div class="%1$s" style="height:%2$dpx" aria-hidden="%3$s"></div>',
			\esc_attr( $classname ),
			\absint( $height ),
			\esc_attr( $aria_hidden )
		);

		$data = self::get_data(
			$attrs,
			[ trim( $inner_content ) ]
		);

		return serialize_block( $data );
	}


}
