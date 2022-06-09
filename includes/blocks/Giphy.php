<?php
/**
 * Class Giphy
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

/**
 * Class Giphy
 *
 * @package PhpBlockBuilders\Blocks
 */
class Giphy extends CoreEmbed {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'embed/giphy';


	/**
	 * Creates a Giphy block
	 *
	 * @param  string $content String url content.
	 * @param  array  $attrs All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$class_names = [
			'wp-block-embed-blocks-giphy',
			'wp-block-embed',
		];
		return self::create_gutenberg_block( $content, $attrs['provider'], $class_names ) ?? '';
	}

}
