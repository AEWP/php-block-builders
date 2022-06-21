<?php
/**
 * Class CoreTable
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;
use PhpBlockBuilders\Element\Figure;

/**
 * Class CoreTable
 *
 * @package PhpBlockBuilders\Block
 */
class CoreTable extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/table';


	public static function create( string $content = '', array $attrs = [] ): string {

		$attrs     = self::get_block_attrs( $attrs );
		$classname = $attrs['classname'] ?? 'wp-block-table';

		$table_content = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );
		$inner_content = Figure::create(
			$table_content,
			[
				'classname'  => $classname,
				'figcaption' => $attrs['figcaption'] ?? '',
			]
		);

		$data = self::get_data(
			$attrs,
			[ trim( $inner_content ) ]
		);

		return serialize_block( $data );

	}


	public static function create_items( array $attrs ): string {

		return '<table><thead><tr><th></th><th></th></tr></thead><tbody><tr><td>ssss</td><td>sss</td></tr><tr><td>sssss</td><td>ssss</td></tr></tbody><tfoot><tr><td></td><td></td></tr></tfoot></table>';

	}


}
