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
 * Mecum Placeholder Gutenberg block.
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
	 * @param  string $content String text/html/url content.
	 * @param  array  $attrs All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$lock_move = $attrs['lock_move'] ?? true;

		$data = [
			'blockName'    => self::$block_name,
			'innerContent' => [],
			'attrs'        => [
				'text' => wp_strip_all_tags( $content, true ),
				'lock' => [
					'move'   => $lock_move,
					'remove' => true,
				],
			],
		];

		return serialize_block( $data );
	}
}
