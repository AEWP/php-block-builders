<?php
/**
 * Class MecumSection
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumSection
 *
 * @package PhpBlockBuilders\Block
 */
class MecumSection extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/section';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-section';

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
		<div class="%1$s">%2$s</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( self::get_element_classname( $data ) ), // 1
			\filter_block_kses_value( $content, 'post' ) // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return parent::return_block_html( $data, $render );

	}


}
