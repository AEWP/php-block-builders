<?php
/**
 * Group Block
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

use function esc_attr;
use function filter_block_kses_value;

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
	 * @param  array  $attrs  ['tagname' => 'div', 'lock_move' => bool].
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$attrs   = self::get_attributes( $attrs );
		$tagname = $attrs['tagname'] ?? 'div';

		$inner_content = sprintf(
			'<%1$s class="wp-block-group">%2$s</%1$s>',
			esc_attr( $tagname ), // 1
			filter_block_kses_value( $content, 'post' ) // 3
		);

		$attrs = [
			'blockName'    => $attrs['block_name'],
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'tagName' => esc_attr( $tagname ),
				'lock'    => [
					'move'   => $attrs['lock_move'],
					'remove' => $attrs['remove'],
				],
			],
		];

		return serialize_block( $attrs );
	}
}
