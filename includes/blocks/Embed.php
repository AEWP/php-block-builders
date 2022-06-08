<?php
/**
 * Class Embed
 *
 * @package PhpBlockBuilders\Blocks
 */

namespace PhpBlockBuilders\Blocks;

use PhpBlockBuilders\BlockBase;

/**
 * Class Embed
 *
 * @package PhpBlockBuilders\Blocks
 */
class Embed extends BlockBase {

	public const BLOCK_NAME = 'core/embed';

	/**
	 * Create an embed block chosen by the provider
	 *
	 * @param  string  $content
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		if ( empty( $attrs ) && ! is_array( $attrs ) ) {
			return '';
		}

		switch ( $attrs['provider'] ) {
			case 'twitter':
				$rtn = Twitter::create( $attrs );
				break;

			case 'tiktok':
				$rtn = TikTok::create( $attrs );
				break;

			case 'instagram':
				$rtn = Instagram::create( $attrs );
				break;

			case 'giphy':
				$rtn = Giphy::create( $attrs );
				break;

			case 'youtube':
				$rtn = YouTube::create( $attrs );
				break;

			case 'engage-sciences':
			case 'engagesciences':
			case 'wayin':
				$rtn = Cheetah::create( $attrs );
				break;

			case 'pinterest':
				$rtn = Pinterest::create( $attrs );
				break;

			default:
				$rtn = self::create_generic_block( $attrs );
				break;
		}

		return $rtn ?? '';
	}

	/**
	 * Creates a generic embed block
	 *
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	private static function create_generic_block( array $attrs ): string {
		$url      = esc_url( $attrs['url'] );
		$provider = $attrs['provider'];

		if ( empty( $url ) ) {
			return '';
		}

		$class_names   = [
			'wp-block-embed',
			'wp-embed-aspect-16-9',
			'wp-has-aspect-ratio',
		];
		$inner_content = self::create_inner_content( $url, $provider, $class_names );

		return self::create_gutenberg_block( $url, $provider, $inner_content ) ?? '';
	}


	/**
	 * Return the Gutenberg serialized block string
	 *
	 * @param  string  $url
	 * @param  string  $provider
	 * @param  string  $inner_content
	 *
	 * @return string
	 */
	public static function create_gutenberg_block( string $url, string $provider, string $inner_content ): string {
		$data = [
			'blockName'        => self::BLOCK_NAME,
			'providerNameSlug' => $provider,
			'responsive'       => true,
			'innerContent'     => [ $inner_content ],
			'url'              => $url,
		];

		$attributes = array_intersect_key(
			$data,
			array_flip(
				[ 'type', 'providerNameSlug', 'responsive', 'url', 'className' ]
			)
		);

		$data['attrs'] = $attributes;

		return serialize_block( $data );
	}


	/**
	 * Creates the block inner content for embeds
	 *
	 * @param  string  $url
	 * @param  string  $provider
	 * @param  array  $class_names
	 *
	 * @return string
	 */
	public static function create_inner_content( string $url, string $provider, array $class_names ): string {
		$class_names = array_merge(
			$class_names,
			[
				'is-provider-' . $provider,
				'wp-block-embed-' . $provider,
				'is-type-' . $provider,
			]
		);

		$rtn = '<figure class="' . implode( ' ', $class_names ) . '">';
		$rtn .= '<div class="wp-block-embed__wrapper">';
		$rtn .= $url;
		$rtn .= '</div></figure>';

		return $rtn;
	}

}
