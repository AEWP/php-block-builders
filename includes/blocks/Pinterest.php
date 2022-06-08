<?php
/**
 * Class Pinterest
 *
 * @package PhpBlockBuilders\Blocks
 */

namespace PhpBlockBuilders\Blocks;

/**
 * Class Pinterest
 *
 * @package PhpBlockBuilders\Blocks
 */
class Pinterest extends Embed {

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
		$inner_content = "<div class=\"wp-block-bauer-blocks-pinterest bauer-block-embed\">{$url}</div>";

		$data = [
			'blockName'    => 'bauer-blocks/pinterest',
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'url'              => $url,
				'providerNameSlug' => $provider,
			],
		];

		return serialize_block( $data );
	}

}
