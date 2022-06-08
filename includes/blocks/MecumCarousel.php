<?php
/**
 * MecumCarousel Blocks
 *
 * @package MecumMigration\Set\Block
 */

namespace PhpBlockBuilders\Blocks;

use MecumMigration\App;

/**
 * Class MecumCarousel
 *
 * @package MecumMigration\Set\Block
 */
class MecumCarousel {

	private const BLOCK_NAME      = 'mecum/carousel';
	private const ITEM_BLOCK_NAME = self::BLOCK_NAME . '-item';
	private const CLASSNAME       = 'wp-block-mecum-carousel';

	private $app;

	public function __construct() {
		$this->app = App::get_instance();
	}


	/**
	 * Create a core paragraph block
	 *
	 * @param  array $attrs  Block attributes.
	 *
	 * @return string
	 * @throws \JsonException Json_decode error.
	 * @throws \WP_CLI\ExitException Image creation error.
	 */
	public static function create( array $attrs ): string {

		$inner_content = sprintf( '<div class="%s">%s</div>', self::CLASSNAME, implode( PHP_EOL, $this->create_items( $attrs['images'] ) ) );

		$data = [
			'blockName'    => self::BLOCK_NAME,
			'innerContent' => [ $inner_content ],
			'attrs'        => [],
		];

		return serialize_block( $data );

	}

	/**
	 * Create each image item block
	 *
	 * @param  array $legacy_images  Array of legacy image ids.
	 *
	 * @return array
	 * @throws \JsonException Json_decode error.
	 * @throws \WP_CLI\ExitException Image creation error.
	 */
	public function create_items( array $legacy_images ): array {
		$rtn = [];
		foreach ( $legacy_images as $legacy_image_id ) {
			$rtn[] = $this->create_item_block( absint( $legacy_image_id ) );
		}
		return $rtn;
	}

	/**
	 * Create each carousel item
	 *
	 * @param  int $legacy_image_id Legacy image id.
	 *
	 * @return string
	 * @throws \JsonException Json_decode error.
	 * @throws \WP_CLI\ExitException Image creation error.
	 */
	public function create_item_block( int $legacy_image_id ) : string {

		// Get the legacy image data array.
		$legacy_img =  $this->app->get_services->get_media()->single( $legacy_image_id );

		if ( empty( $legacy_img ) ) {
			return '';
		}

		// Create the new image.
		$new_image_id = $this->app->set_services->set_media()->create( $legacy_img );
		$image_block  = $this->app->set_services->set_blocks()['Image']->create_block( $new_image_id );

		$inner_content = sprintf( '<div class="%s-item">%s</div', self::CLASSNAME, $image_block );

		$data = [
			'blockName'    => self::ITEM_BLOCK_NAME,
			'innerContent' => [ $inner_content ],
			'attrs'        => [],
		];

		return serialize_block( $data );

	}





}
