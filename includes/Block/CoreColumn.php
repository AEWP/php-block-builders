<?php
/**
 * Class CoreColumn
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class CoreColumn
 *
 * @package PhpBlockBuilders\Block
 */
class CoreColumn extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/column';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-column';

	/**
	 * Create a Core Columns Block
	 *
	 * @param  string $content The column block.
	 * @param  array  $attrs Block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data = self::get_data( $attrs );

		$block_template = <<<'TEMPLATE'
		<div class="%1$s" style="%2$s">%3$s</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			\esc_attr( $data['attrs']['style'] ), // 1
			\filter_block_kses_value( $content, 'post' ) // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return parent::return_block_html( $data, $render );

	}


}
