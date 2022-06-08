<?php
/**
 * Class Giphy
 *
 * @package PhpBlockBuilders\Blocks
 */

namespace PhpBlockBuilders\Blocks;

/**
 * Class Giphy
 *
 * @package PhpBlockBuilders\Blocks
 */
class Giphy extends Embed {

	/**
	 * Creates an Instagram block
	 *
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create( array $attrs ): string {
		$url           = esc_url( $attrs['content']['url'] );
		$provider      = $attrs['content']['provider'];
		$inner_content = '<div class="wp-block-bauer-blocks-giphy bauer-block-embed">' . $url . '</div>';

		$data = [
			'blockName'    => 'bauer-blocks/giphy',
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'url'              => $url,
				'providerNameSlug' => $provider,
			],
		];

		return serialize_block( $data );
	}

}
