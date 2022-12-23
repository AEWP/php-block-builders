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
	 * Block Classname
	 *
	 * @var string
	 */
	public static string $block_classname = '';

	/**
	 * Insert a Core Heading block to the page.
	 *
	 * @param  string $content  The block content.
	 * @param  array  $attrs  ['level' => 1, 'lock_move' => bool].
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data           = self::get_data( $attrs );
		$level          = $attrs['attrs']['level'] ?? 1;
		$font_size      = $attrs['attrs']['fontSize'] ?? '';
		$text_align     = $attrs['attrs']['textAlign'] ?? 'left';
		$class_name_att = 'class="' . self::get_element_classname( $data ) . '"';

		$block_template = <<<'TEMPLATE'
		<h%1$s %2$s>%3$s</h%1$s>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\absint( $level ), // 1
			$class_name_att, // 2
			\filter_block_kses_value( $content, 'post' ) // 3
		);

		$data['innerContent']       = [ $inner_content ];
		$data['attrs']['content']   = self::json_encode_clean_string( $content );
		$data['attrs']['fontSize']  = $font_size;
		$data['attrs']['level']     = $level;
		$data['attrs']['textAlign'] = $text_align;

		return parent::return_block_html( $data, $render );
	}
}
