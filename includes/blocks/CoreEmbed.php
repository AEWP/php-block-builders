<?php
/**
 * Class Embed
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

use PhpBlockBuilders\BlockBase;

/**
 * Class Embed
 *
 * @package PhpBlockBuilders\Blocks
 */
class CoreEmbed extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/embed';

	/**
	 * Create an embed block chosen by the provider
	 *
	 * @param  string $content String text/html/url content.
	 * @param  array  $attrs All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		if ( empty( $attrs ) && ! is_array( $attrs ) ) {
			return '';
		}

		switch ( $attrs['provider'] ) {
			case 'twitter':
				$rtn = Twitter::create( $content, $attrs );
				break;

			case 'tiktok':
				$rtn = TikTok::create( $content, $attrs );
				break;

			case 'instagram':
				$rtn = Instagram::create( $content, $attrs );
				break;

			case 'giphy':
				$rtn = Giphy::create( $content, $attrs );
				break;

			case 'youtube':
				$rtn = YouTube::create( $content, $attrs );
				break;

			case 'engage-sciences':
			case 'engagesciences':
			case 'wayin':
				$rtn = Cheetah::create( $content, $attrs );
				break;

			case 'pinterest':
				$rtn = Pinterest::create( $content, $attrs );
				break;

			default:
				$rtn = self::create_generic_block( $content, $attrs );
				break;
		}

		return $rtn ?? '';
	}

	/**
	 * Creates a generic embed block
	 *
	 * @param  string $content Embed Url.
	 * @param  array  $attrs  Attributes array.
	 *
	 * @return string
	 */
	private static function create_generic_block( string $content = '', array $attrs = [] ): string {
		$provider = $attrs['provider'];

		if ( empty( $content ) ) {
			return '';
		}

		$class_names = [
			'wp-block-embed',
			'wp-embed-aspect-16-9',
			'wp-has-aspect-ratio',
		];

		return self::create_gutenberg_block( $content, $provider, $class_names ) ?? '';
	}


	/**
	 * Return the Gutenberg serialized block string
	 *
	 * @param  string $url Embed social url.
	 * @param  string $provider Provider name.
	 * @param  array  $class_names Extra classnames..
	 *
	 * @return string
	 */
	public static function create_gutenberg_block( string $url, string $provider, array $class_names = [] ): string {

		$inner_content = self::create_inner_content( $url, $provider, $class_names );

		$data = [
			'blockName'        => self::$block_name,
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
	 * @param  string $url Embed social url.
	 * @param  string $provider Provider name.
	 * @param  array  $class_names Any additional classnames required..
	 *
	 * @return string
	 */
	public static function create_inner_content( string $url, string $provider, array $class_names ): string {
		$class_names = array_merge(
			$class_names,
			[
				'wp-block-embed',
				'is-provider-' . $provider,
				'wp-block-embed-' . $provider,
				'is-type-' . $provider,
			]
		);

		$rtn  = '<figure class="' . implode( ' ', $class_names ) . '">';
		$rtn .= '<div class="wp-block-embed__wrapper">';
		$rtn .= $url;
		$rtn .= '</div></figure>';

		return $rtn;
	}

}
