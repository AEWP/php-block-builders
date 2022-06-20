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

		$attrs = self::get_attributes( $attrs );

		if ( isset( $attrs['classname'] ) ) {
			$content = trim( str_replace( '<p>', "<p class=\"{$attrs['classname']}\">", $content ) );
		}

		$data = [
			'blockName'    => $attrs['block_name'],
			'innerContent' => [ '<p>' . trim( $content ) . '</p>' ],
			'attrs'        => [
				'className' => $attrs['classname'] ?? '',
				'lock'      => [
					'move'   => $attrs['lock_move'],
					'remove' => $attrs['remove'],
				],
			],
		];

		return serialize_block( $data );

	}

}
