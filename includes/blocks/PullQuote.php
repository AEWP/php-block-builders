<?php
/**
 * Class PullQuote
 *
 * @package PhpBlockBuilders\Blocks
 */

namespace PhpBlockBuilders\Blocks;

/**
 * Class PullQuote
 *
 * @package PhpBlockBuilders\Blocks
 */
class PullQuote implements BlockInterface {


	/**
	 * Creates a pullquote block
	 *
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create(  array $attrs ): string {
		$classname = isset( $attrs['classname'] ) ? "{$attrs['classname']} pullquote" : 'pullquote';
		$content = "<figure class=\"wp-block-pullquote\"><blockquote><p>{$attrs['content']}</p></blockquote></figure>";

		$data = [
			'blockName'    => 'core/pullquote',
			'innerContent' => [ $content ],
			'attrs'        => $classname,
		];

		return serialize_block( $data );
	}

}
