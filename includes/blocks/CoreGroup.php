<?php
/**
 * Group Block
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

use PhpBlockBuilders\BlockBase;

/**
 * Core Group Gutenberg block.
 */
class CoreGroup extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/group';

	/**
	 * Insert an empty Core Group block to the page.
	 *
	 * @param  string $content  The block content.
	 * @param  array  $attrs ['tagname' => 'div', 'lock_move' => bool].
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$tagname   = $attrs['tagname'] ?? 'div';
		$lock_move = $attrs['lock_move'] ?? true;

		$inner_content = sprintf(
			'<%1$s class="wp-block-group">%2$s</%1$s>',
			\esc_attr( $tagname ), // 1
			\filter_block_kses_value( $content, 'post' ) // 3
		);

		$attrs = [
			'blockName'    => self::$block_name,
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'tagName' => \esc_attr( $tagname ),
				'lock'    => [
					'move'   => $lock_move,
					'remove' => true,
				],
			],
		];

		return serialize_block( $attrs );
	}
}
