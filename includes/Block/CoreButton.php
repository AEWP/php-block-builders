<?php
/**
 * Class CoreButton
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class CoreButton
 *
 * @package PhpBlockBuilders\Block
 */
class CoreButton extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/button';

	/**
	 * @param  string $content The button text.
	 * @param  array  $attrs Link attributes: ['href' => link, 'target' => '_blank', 'rel' => 'noreferrer nopener'].
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$attrs      = self::get_block_names( $attrs );
		$classname  = $attrs['classname'] ?? 'wp-block-button';
		$href       = $attrs['href'];
		$link_attrs = '';

		foreach ( $attrs as $k => $v ) {
			if ( $k == 'target' || $k == 'rel' ) {
				if ( ! empty( $v ) ) {
					$link_attrs .= esc_attr( $k . '=' . $v . ' ' );
				}
			}
		}

		// if font size is added to attributes then customised classnames needs to be provided.
		if ( $attrs['font_size'] && ! empty( $attrs['font_size'] ) !== null ) {
			$font_size_string   = 'has-' . str_replace( [ '.', 'rem' ], [ '-', '-rem' ], $attrs['font_size'] ) . '-font-size';
			$attrs['classname'] = $font_size_string;
			$classname         .= ' has-custom-font-size ' . $font_size_string;
		}

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">
			<a class=%2$s href=%3$s %4$s>%5$s</a>
		</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $classname ), // 1
			'wp-block-button__link',
			\esc_url_raw( $href ), // 2
			\esc_attr( $link_attrs ), // 3
			\filter_block_kses_value( $content, 'post' ), // 4
		);

		$data = self::get_data(
			$attrs,
			[ trim( $inner_content ) ],
			[
				'attrs' => [
					'fontSize' => $attrs['font_size'] ?? '',
				],
			]
		);

		return serialize_block( $data );

	}


}
