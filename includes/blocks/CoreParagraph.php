<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

use PhpBlockBuilders\BlockBase;

/**
 * Core Paragraph Gutenberg block.
 *
 * @package PhpBlockBuilders\Blocks
 */
class CoreParagraph extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/paragraph';


	/**
	 * Convert paragraphs to Gutenberg blocks.
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

		if ( isset( $attrs['classname'] ) ) {
			$content = trim( str_replace( '<p>', "<p class=\"{$attrs['classname']}\">", $content ) );
		}

		$data = [
			'blockName'    => self::$block_name,
			'innerContent' => [ '<p>' . trim( $content ) . '</p>' ],
			'attrs'        => [
				'className' => $attrs['classname'] ?? '',
				// 'name'      => $attrs['name'],
				// 'type'      => $attrs['type'],
				// 'free'      => $attrs['free'],
			],
		];

		return serialize_block( $data );

	}

	/**
	 * Parse Salesforce content and split it into separate paragraphs if too long.
	 *
	 * @param  string $content  multipart html content.
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
				$html          .= self::create( $countable_html );
				$countable_html = '';
			}
		}

		return $html;
	}


}
