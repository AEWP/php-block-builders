<?php
/**
 * Class PullQuote
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

use PhpBlockBuilders\BlockBase;
use PhpBlockBuilders\Elements\Figure;

/**
 * Class PullQuote
 *
 * @package PhpBlockBuilders\Blocks
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
	 * @param  string $content String text/html/url content.
	 * @param  array  $attrs All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$attrs         = self::get_attributes( $attrs );
		$html          = sprintf( '<blockquote><p>%s</p></blockquote>', $attrs['content'] );
		$inner_content = Figure::create( $html, [ 'classname' => 'wp-block-pullquote' ] );

		$data = [
			'blockName'    => $attrs['block_name'],
			'innerContent' => [ $inner_content ],
			'attrs'        => $attrs,
		];

		return serialize_block( $data );
	}

}
