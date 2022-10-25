<?php
/**
 * Class MecumLotSelector
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumLotSelector
 *
 * @package PhpBlockBuilders\Block
 */
class MecumLotSelector extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/lot-selector';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-lot-selector';

	/**
	 * Create a Mecum Newsletter CTA Block
	 *
	 * @param  string $content  Content array as a json string.
	 * @param  array  $attrs  Block attributes. eg: {"auctionTerm":{"id":1656,"name":"Chicago 2014 [1656]"},"collectionTerm":{"id":1668,"name":"The Deery Collection [1668]"},"isDynamic":true,"maxResults":100,"selectedLotIDs":[3533,3535]}.
	 * @param  bool   $render  Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data                 = self::get_data( $attrs );
		$data['innerContent'] = [];
		return parent::return_block_html( $data, $render );

	}


}
