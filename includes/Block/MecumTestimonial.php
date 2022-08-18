<?php
/**
 * Class MecumTestimonial
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumTestimonial
 *
 * @package PhpBlockBuilders\Block
 */
class MecumTestimonial extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/testimonial';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-testimonial';

	/**
	 * Create a Mecum Banner Block
	 *
	 * @param  string $content  The banner content.
	 * @param  array  $attrs  Block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data = self::get_data( $attrs );

		$image = CoreImage::create(
			(string) $attrs['image_id'],
			[
				'attrs' => [
					'className' => 'aligncenter',
					'align'     => 'center',
				],
			]
		);

		// @todo refactor this into sprintf, wrap the image in the div
		$image = str_replace(
			[ '<figure', '</figure>' ],
			[ '<div class="wp-block-image is-style-rounded"><figure', '</figure></div>' ],
			$image
		);

		$quote = CoreQuote::create(
			$content,
			[
				'cite'  => $attrs['cite'] ?? '',
				'attrs' => [
					'className' => 'wp-block-quote has-text-align-center',
					'align'     => 'center',
				],
			]
		);

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">%2$s</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			$image . $quote, // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return parent::return_block_html( $data, $render );

	}

}
