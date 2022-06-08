<?php
/**
 * Mecum Salesforce Connector
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

/**
 * Core Paragraph Gutenberg block.
 */
class CoreParagraph {
	/**
	 * Parse Salesforce content and split it into separate paragraphs if too long.
	 *
	 * @param string $content Salesforce content.
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function convert_to_paragraph_blocks( string $content ): string {
		$html           = '';
		$countable_html = '';

		$parts = array_filter( explode( '.', $content ) );

		foreach ( $parts as $key => $part ) {
			// Restore the full stop.
			$new_part = "{$part}.";

			$countable_html .= $new_part;

			if ( str_word_count( $countable_html ) > 70 || $key === array_key_last( $parts ) ) {
				$html          .= self::convert_to_paragraph_block( $countable_html );
				$countable_html = '';
			}
		}

		return $html;
	}

	/**
	 * Convert Salesforce paragraphs to Gutenberg equivalent.
	 *
	 * @param string $content Salesforce content.
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function convert_to_paragraph_block( string $content ): string {

		$attrs = [
			'blockName'    => 'core/paragraph',
			'innerContent' => [ '<p>' . trim( $content ) . '</p>' ],
		];

		return serialize_block( $attrs );

	}
}
