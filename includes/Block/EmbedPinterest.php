<?php
/**
 * Class Pinterest
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

/**
 * Class Pinterest
 *
 * @package PhpBlockBuilders\Block
 */
class EmbedPinterest extends CoreEmbed {

	/**
	 * Creates an Instagram block
	 *
	 * @param  string $content  Embed url.
	 * @param  array  $attrs  Attributes array.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		return self::create_gutenberg_block( $content, $attrs['provider'] ) ?? '';
	}

}
