<?php
/**
 * Mecum Salesforce Connector
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

/**
 * Mecum Placeholder Gutenberg block.
 */
class MecumPlaceholder {
	/**
	 * Insert a Mecum Placeholder block to the page.
	 *
	 * @param string $content    The placeholder text.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function insert( string $content ): string {

		$attrs = [
			'blockName'    => 'mecum/placeholder',
			'innerContent' => [],
			'attrs'        => [
				'text' => wp_strip_all_tags( $content, true ),
				'lock' => [
					'move'   => true,
					'remove' => true,
				],
			],
		];

		return serialize_block( $attrs );
	}
}
