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
	 * Insert a  Quote block to the page.
	 *
	 * @param  string $content  String text/html/url content.
	 * @param  array  $attrs  All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$attrs         = self::get_block_attrs( $attrs );
		$cite          = $attrs['cite'] ? sprintf( '<cite>%s</cite>', $attrs['cite'] ) : '';
		$class_name    = $attrs['classname'] ? $attrs['classname'] . ' wp-block-quote' : 'wp-block-quote';
		$inner_content = sprintf( '<blockquote class="%1s"><p>%2s</p>%3s</blockquote>', $class_name, $content, $cite );

		$data = [
			'blockName'    => self::$block_name,
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'lock' => self::get_lock( $attrs ),
			],
		];

		return serialize_block( $data );

	}


}
