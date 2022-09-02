<?php
/**
 * Group Block
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

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
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-group';

	/**
	 * Insert an empty Core Group block to the page.
	 *
	 * @param  string $content  The block content.
	 * @param  array  $attrs  ['tagname' => 'div', 'lock_move' => bool].
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data    = self::get_data( $attrs );
		$tagname = $attrs['attrs']['tagName'] ?? 'div';

		$block_template = <<<'TEMPLATE'
		<%1$s class="%2$s">%3$s</%1$s>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $tagname ), // 1
			\esc_attr( self::get_element_classname( $data ) ), // 2
			\filter_block_kses_value( $content, 'post' ) // 3
		);

		$data['innerContent']     = [ $inner_content ];
		$data['attrs']['tagName'] = \esc_attr( $tagname );

		return parent::return_block_html( $data, $render );
	}
}
