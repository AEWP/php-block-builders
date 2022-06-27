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
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-button';

	/**
	 * Create a Core Button Block
	 *
	 * @param  string $content The button text.
	 * @param  array  $attrs Link attributes: ['href' => link, 'target' => '_blank', 'rel' => 'noreferrer nopener'].
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data = self::get_data( $attrs );

		$href       = $attrs['href'];
		$link_attrs = '';

		foreach ( $attrs as $k => $v ) {
			if ( $k === 'target' || $k === 'rel' ) {
				if ( ! empty( $v ) ) {
					$link_attrs .= esc_attr( $k . '=' . $v . ' ' );
				}
			}
		}

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">
			<a class=%2$s href=%3$s %4$s>%5$s</a>
		</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			sprintf( '%s__link', $data['attrs']['className'] ), // 2
			\esc_url_raw( $href ), // 3
			\esc_attr( $link_attrs ), // 4
			\filter_block_kses_value( $content, 'post' ) // 4
		);

		$data['innerContent'] = [ $inner_content ];

		return serialize_block( $data );

	}


}
