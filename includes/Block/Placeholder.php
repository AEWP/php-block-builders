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
 * Placeholder Gutenberg block.
 */
class Placeholder extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'block/placeholder';


	/**
	 * Insert a Placeholder block to the page.
	 *
	 * @param  string $content  String text/html/url content.
	 * @param  array  $attrs  All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$attrs = self::get_block_names( $attrs );

		$data = [
			'blockName'    => $attrs['block_name'],
			'innerContent' => [],
			'attrs'        => [
				'text' => wp_strip_all_tags( $content, true ),
				'lock' => [
					'move'   => $attrs['lock_move'],
					'remove' => true,
				],
			],
		];

		return serialize_block( $data );
	}
}
