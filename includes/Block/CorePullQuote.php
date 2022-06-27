<?php
/**
 * Class PullQuote
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;
use PhpBlockBuilders\Element\Figure;

/**
 * Class PullQuote
 *
 * @package PhpBlockBuilders\Block
 */
class CorePullQuote extends BlockBase {


	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/pullquote';


	/**
	 * Creates a Pull Quote block
	 *
	 * @param  string $content  String text/html/url content.
	 * @param  array  $attrs  All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$attrs         = self::get_block_attrs( $attrs );
		$cite          = $attrs['cite'] ? sprintf( '<cite>%s</cite>', $attrs['cite'] ) : '';
		$html          = sprintf( '<blockquote><p>%1$s</p>%2$s</blockquote>', $content, $cite );
		$inner_content = Figure::create( $html, [ 'classname' => 'wp-block-pullquote' ] );

		$data = self::get_data(
			$attrs,
			[ $inner_content ]
		);

		return serialize_block( $data );
	}

}
