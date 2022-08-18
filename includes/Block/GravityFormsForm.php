<?php
/**
 * Class GravityFormsForm
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class GravityFormsForm
 *
 * @package PhpBlockBuilders\Block
 */
class GravityFormsForm extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'gravityforms/form';

	/**
	 * Create a Gravity Forms Form Block
	 *
	 * @param  string $content Gravity Form ID.
	 * @param  array  $attrs Block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data                    = self::get_data( $attrs );
		$data['attrs']['formId'] = $content;
		$data['innerContent']    = [];

		// These attributes break this block in the editor.
		unset( $data['attrs']['className'], $data['attrs']['lock'] );

		return parent::return_block_html( $data, $render );

	}


}
