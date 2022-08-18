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
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {
		return self::create_gutenberg_block( $content, $attrs['provider'], [], $render ) ?? '';
	}

}
