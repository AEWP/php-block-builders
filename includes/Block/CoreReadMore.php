<?php
/**
 * Class CoreReadMore
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class CoreReadMore
 *
 * @package PhpBlockBuilders\Block
 */
class CoreReadMore extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/read-more';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-read-more';
	/**
	 * Create a Core Separator Block
	 *
	 * @param  string $content In this instance content is ignored.
	 * @param  array  $attrs Block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data                 = self::get_data( $attrs );
		$data['innerContent'] = [];

		return parent::return_block_html( $data, $render );
	}


}
