<?php
/**
 * Class Pinterest
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

/**
 * Class Pinterest
 *
 * @package PhpBlockBuilders\Blocks
 */
class EmbedPinterest extends CoreEmbed {

	/**
	 * Creates an Instagram block
	 *
	 * @param  string $content Embed url.
	 * @param  array  $attrs Attributes array.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		return self::create_gutenberg_block( $content, $attrs['provider'] ) ?? '';
	}

}
