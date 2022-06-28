<?php
/**
 * Class CoreColumns
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class CoreColumns
 *
 * @package PhpBlockBuilders\Block
 */
class CoreColumns extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/columns';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-columns';

	/**
	 * Create a Core Columns Block
	 *
	 * @param  string $content The columns container.
	 * @param  array  $attrs Block attributes.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data = self::get_data( $attrs );

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">%2$s</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			\filter_block_kses_value( $content, 'post' ), // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return serialize_block( $data );

	}


}
