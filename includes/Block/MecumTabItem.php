<?php
/**
 * Class MecumTabItem
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumTabItem
 *
 * @package PhpBlockBuilders\Block
 */
class MecumTabItem extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/tab-item';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-tab-item';

	/**
	 * Create a Mecum Tabs Block
	 *
	 * @param  string $content The tab container.
	 * @param  array  $attrs Block attributes.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data = self::get_data( $attrs );

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">
		%2$s
		%3$s
		</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			\esc_attr( sprintf( '<h3>%s</h3>', $attrs['attrs']['title'] ) ), // 2
			\filter_block_kses_value( $content, 'post' ) // 3
		);

		$data['innerContent'] = [ $inner_content ];

		return serialize_block( $data );

	}


}
