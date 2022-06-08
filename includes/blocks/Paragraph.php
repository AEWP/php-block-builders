<?php
/**
 * Paragraph Blocks
 *
 * @package PhpBlockBuilders\Blocks
 */

namespace PhpBlockBuilders\Blocks;


use PhpBlockBuilders\BlockBase;

/**
 * Class Paragraph
 *
 * @package PhpBlockBuilders\Blocks
 */
class Paragraph extends BlockBase {

	public const BLOCK_NAME = 'core/paragraph';

	/**
	 * Create a core paragraph block
	 *
	 * @param  string  $content
	 * @param  array  $attrs  attributes
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$rtn = '';

		if ( isset( $attrs['classname'] ) ) {
			$content = trim( str_replace( '<p>', "<p class=\"{$attrs['classname']}\">", $content ) );
		}

		if ( ! empty( $content ) ) {
			$data = [
				'blockName'    => self::BLOCK_NAME,
				'innerContent' => [ $content ],
				'attrs'        => [
					'className' => $attrs['classname'] ?? '',
					// 'name'      => $attrs['name'],
					// 'type'      => $attrs['type'],
					// 'free'      => $attrs['free'],
				],
			];

			$rtn = serialize_block( $data );
		}

		return $rtn;

	}

}
