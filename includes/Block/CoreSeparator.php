<?php
/**
 * Class CoreSeparator
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class CoreSeparator
 *
 * @package PhpBlockBuilders\Block
 */
class CoreSeparator extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/separator';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-separator';
	/**
	 * Create a Core Separator Block
	 *
	 * @param  string $content In this instance content is ignored.
	 * @param  array  $attrs Block attributes.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data          = self::get_data( $attrs );
		$inner_content = sprintf(
			'<hr class="%s"/>',
			\esc_attr( $data['attrs']['className'] )
		);

		$data['innerContent'] = [ $inner_content ];

		return serialize_block( $data );
	}


}
