<?php
/**
 * Class Figure
 *
 * @package PhpBlockBuilders\Element
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Element;

/**
 * Class Figure
 *
 * @package PhpBlockBuilders\Element
 */
class Figure {

	/**
	 * This is not a gutenberg block, but potentially the html generated should be reusable
	 *
	 * @param  string $content  figure content.
	 * @param  array  $attrs  Attribute array.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$classname  = $attrs['classname'] ?? '';
		$figcaption = ( isset( $attrs['figcaption'] ) ) ? sprintf( '<figcaption>%s</figcaption>', $attrs['figcaption'] ) : '';

		$template = <<<'TEMPLATE'
			<figure class="%1s">%2s%3s</figure>
			TEMPLATE;

		return sprintf( $template, esc_attr( $classname ), $content, $figcaption );

	}


}
