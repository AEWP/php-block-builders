<?php
/**
 * Class CustomHtml
 *
 * @package PhpBlockBuilders\Blocks
 */

namespace PhpBlockBuilders\Blocks;

/**
 * Class CustomHtml
 *
 * @package PhpBlockBuilders\Blocks
 */
class CustomHtml implements BlockInterface {


	/**
	 * Creates a custom html block
	 *
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create( array $attrs ): string {
		$classname = isset( $attrs['classname'] ) ? "{$attrs['classname']} html-insert" : 'html-insert';

		$data = [
			'blockName'    => 'core/html',
			'innerContent' => [ $attrs['content'] ],
			'attrs'        => $classname,
		];

		return serialize_block( $data );
	}

}
