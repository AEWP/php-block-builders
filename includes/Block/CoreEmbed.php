<?php
/**
 * Class Embed
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class Embed
 *
 * @package PhpBlockBuilders\Block
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
	 * @param  string $content  String text/html/url content.
	 * @param  array  $attrs  All required block attributes.
	 * @param  bool   $render Render boolean - edit or fe.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {
		if ( empty( $attrs ) && ! is_array( $attrs ) ) {
			return '';
		}

		switch ( $attrs['provider'] ) {
			case 'twitter':
				$rtn = EmbedTwitter::create( $content, $attrs, $render );
				break;

			case 'tiktok':
				$rtn = EmbedTikTok::create( $content, $attrs, $render );
				break;

			case 'instagram':
				$rtn = EmbedInstagram::create( $content, $attrs, $render );
				break;

			case 'giphy':
				$rtn = EmbedGiphy::create( $content, $attrs, $render );
				break;

			case 'youtube':
				$rtn = EmbedYouTube::create( $content, $attrs, $render );
				break;

			case 'engage-sciences':
			case 'engagesciences':
			case 'wayin':
				$rtn = EmbedCheetah::create( $content, $attrs, $render );
				break;

			case 'pinterest':
				$rtn = EmbedPinterest::create( $content, $attrs, $render );
				break;

			default:
				$rtn = self::create_block( $content, $attrs, $render );
				break;
		}

		return $rtn ?? '';
	}

	/**
	 * Creates a generic embed block
	 *
	 * @param  string $content  Embed Url.
	 * @param  array  $attrs  Attributes array.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	private static function create_block( string $content = '', array $attrs = [], bool $render = false ): string {
		if ( empty( $content ) ) {
			return '';
		}

		$provider_name = $attrs['provider'];

		$class_names = [
			'wp-block-embed',
			'wp-embed-aspect-16-9',
			'wp-has-aspect-ratio',
		];

		return self::create_gutenberg_block( $content, $provider_name, $class_names, $render ) ?? '';
	}


	/**
	 * Return the Gutenberg serialized block string
	 *
	 * @param  string $url  Embed social url.
	 * @param  string $provider  Provider name.
	 * @param  array  $class_names  Extra classnames..
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create_gutenberg_block( string $url, string $provider, array $class_names = [], bool $render = false ): string {
		$inner_content = self::create_inner_content( $url, $provider, $class_names );

		$data = [
			'blockName'        => self::$block_name,
			'providerNameSlug' => $provider,
			'responsive'       => true,
			'innerContent'     => [ $inner_content ],
			'url'              => $url,
		];

		$data['attrs'] = array_intersect_key(
			$data,
			array_flip(
				[ 'type', 'providerNameSlug', 'responsive', 'url', 'className' ]
			),
		);

		return parent::return_block_html( $data, $render );
	}


	/**
	 * Creates the block inner content for embeds
	 *
	 * @param  string $url  Embed social url.
	 * @param  string $provider  Provider name.
	 * @param  array  $class_names  Any additional classnames required..
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
