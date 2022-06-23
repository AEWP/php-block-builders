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


	public static string $block_classname = '';


	/**
	 * Convert paragraphs to Gutenberg Block.
	 *
	 * @param  string $content  String text/html content.
	 * @param  array  $attrs  All required block attributes.
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		// Don't create empty paragraphs - this exists due to older editors allowing for empty p tags.
		if ( empty( trim( $content ) ) ) {
			return '';
		}

		$data = self::get_data( $attrs );

		// Ensure the content has surrounding <p> tags.
		if ( 0 !== strpos( $content, '<p>' ) ) {
			$content = sprintf( '<p>%s</p>', trim( str_replace( [ '<p>', '</p>' ], ' ', $content ) ) ); // Force remove any opening or closing p tags just in case of broken html - it's cheap.
		}

		if ( ! empty( $data['attrs']['className'] ) ) {
			$content = trim( str_replace( '<p>', "<p class=\"{$data['attrs']['className']}\">", $content ) );
		}

		$data['innerContent'] = [ $content ];

		return serialize_block( $data );

	}

}
