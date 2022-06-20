<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

use function absint;
use function filter_block_kses_value;

/**
 * Core Heading Gutenberg block.
 */
class CoreHeading extends BlockBase {

	/**
	 * Block Name
	 *
	 * @var string
	 */
	public static string $block_name = 'core/heading';

	/**
	 * Insert a Core Heading block to the page.
	 *
	 * @param  string $content  The block content.
	 * @param  array  $attrs  ['level' => 1, 'lock_move' => bool].
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$attrs = self::get_block_names( $attrs );
		$level = $attrs['level'] ?? 1;

		$inner_content = sprintf(
			'<h%1$s>%2$s</h%1$s>',
			absint( $level ), // 1
			filter_block_kses_value( $content, 'post' ) // 3
		);

		$data = self::get_data(
			$attrs,
			[ $inner_content ],
			[
				'attrs' => [
					'level' => absint( $level ),
				],
			]
		);

		return serialize_block( $data );
	}
}
