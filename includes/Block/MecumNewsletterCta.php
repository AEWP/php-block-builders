<?php
/**
 * Class MecumNewsletterCta
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumNewsletterCta
 *
 * @package PhpBlockBuilders\Block
 */
class MecumNewsletterCta extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/newsletter-cta';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-newsletter-cta';

	/**
	 * Create a Mecum Newsletter CTA Block
	 *
	 * @param  string $content
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data       = self::get_data( $attrs );
		$items_html = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">%2$s</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			$items_html, // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return serialize_block( $data );

	}

	public static function create_items( array $attrs ): string {

			$title        = CoreHeading::create( $attrs['title'] ?? '', [ 'level' => 2 ] );
			$paragraph    = CoreParagraph::create( $attrs['paragraph'] ?? '' );
			$gravity_form = GravityFormsForm::create( (string) ( $attrs['gravity_form_id'] ?? '' ) );

			return CoreCover::create( $title . $paragraph . $gravity_form, [ 'id' => (string) ( $attrs['image_id'] ?? 0 ) ] );

	}


}
