<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Core Paragraph Gutenberg block.
 *
 * @package PhpBlockBuilders\Block
 */
class CoreParagraph extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/paragraph';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = '';


	/**
	 * Convert paragraphs to Gutenberg Block.
	 *
	 * @param  string $content  String text/html content.
	 * @param  array  $attrs  All required block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {
		// Don't create empty paragraphs - this exists due to older editors allowing for empty p tags.
		if ( empty( trim( $content ) ) ) {
			return '';
		}

		$data              = self::get_data( $attrs );
		$element_classname = self::get_element_classname( $data );

		// Set the original content without wrapping <p> into attrs.
		$data['attrs']['content'] = self::json_encode_clean_string( $content );

		// Ensure the content has surrounding <p> tags.
		if ( 0 !== strpos( $content, '<p>' ) ) {
			$content = sprintf( '<p>%s</p>', trim( str_replace( [ '<p>', '</p>' ], ' ', $content ) ) ); // Force remove any opening or closing p tags just in case of broken html - it's cheap.
		}

		if ( $element_classname !== self::$block_classname ) {
			$content = trim( str_replace( '<p>', "<p class=\"{$element_classname}\">", $content ) );
		}

		$data['innerContent'] = [ $content ];

		return parent::return_block_html( $data, $render );

	}

}
