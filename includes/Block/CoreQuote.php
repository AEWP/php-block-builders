<?php
/**
 * Class BlockQuote
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class BlockQuote
 *
 * @package PhpBlockBuilders\Block
 */
class CoreQuote extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/quote';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-quote';

	/**
	 * Insert a  Quote block to the page.
	 *
	 * @param  string $content  String text/html/url content.
	 * @param  array  $attrs  All required block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data                 = self::get_data( $attrs );
		$cite                 = $attrs['cite'] ? sprintf( '<cite>%s</cite>', $attrs['cite'] ) : '';
		$inner_content        = sprintf(
			'<blockquote class="%1s"><p>%2s</p>%3s</blockquote>',
			\esc_attr( $data['attrs']['className'] ),
			\filter_block_kses_value( $content, 'post' ),
			\filter_block_kses_value( $cite, 'post' )
		);
		$data['innerContent'] = [ $inner_content ];

		return parent::return_block_html( $data, $render );

	}


}
