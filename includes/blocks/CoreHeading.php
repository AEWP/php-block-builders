<?php
/**
 * Mecum Salesforce Connector
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

use PhpBlockBuilders\BlockBase;

/**
 * Core Heading Gutenberg block.
 */
class CoreHeading extends BlockBase {

	public static string $block_name = 'core/heading';
	/**
	 * Insert a Core Heading block to the page.
	 *
	 * @param  string  $content  The block content.
	 * @param  array  $attrs ['level' => 1, 'lock_move' => bool]
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = array() ): string {

		$level     = $attrs['level'] ?? 1;
		$lock_move = $attrs['lock_move'] ?? true;

		$inner_content = sprintf(
			'<h%1$s>%2$s</h%1$s>',
			\absint( $level ), // 1
			\filter_block_kses_value( $content, 'post' ) // 3
		);

		$attrs = array(
			'blockName'    => self::$block_name,
			'innerContent' => array( $inner_content ),
			'attrs'        => array(
				'level' => absint( $level ),
				'lock'  => array(
					'move' => $lock_move,
				),
			),
		);

		return serialize_block( $attrs );
	}
}
