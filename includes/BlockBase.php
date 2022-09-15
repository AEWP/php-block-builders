<?php
/**
 * Class BlockBase
 *
 * @package PhpBlockBuilders
 */

declare( strict_types=1 );

namespace PhpBlockBuilders;

/**
 * Class BlockBase
 *
 * @package PhpBlockBuilders
 */
abstract class BlockBase implements BlockInterface {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'block/base';

	/**
	 * Optional item block name.
	 *
	 * @var string
	 */
	public static string $item_block_name = 'block/base-item';

	/**
	 * Optional block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-base';

	/**
	 * Optional item block classname
	 *
	 * @var string
	 */
	public static string $item_block_classname = 'wp-block-base-item';

	/**
	 * Return a string representation of each block.
	 *
	 * @param  string $content  String text/html/url content.
	 * @param  array  $attrs  All required block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data                 = self::get_data( $attrs );
		$data['innerContent'] = [ $content ];

		return self::return_block_html( $data, $render );
	}

	/**
	 * Return the block html as either full serialized html or rendered without
	 *
	 * @param  array $data Block data.
	 * @param  bool  $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function return_block_html( array $data = [], bool $render = false ): string {
		if ( true === $render ) {
			return render_block( $data );
		}

		return serialize_block( $data );
	}


	/**
	 * Create all the block inner / content items.
	 *
	 * @param  array $attrs  Array of item attrs and content.
	 *
	 * @return string
	 */
	protected static function create_items( array $attrs ): string {
		$rtn = [];

		if ( empty( $attrs ) ) {
			return implode( PHP_EOL, $rtn );
		}

		foreach ( $attrs as $block_attr ) {
			$rtn[] = serialize_block( array_merge_recursive( [ 'blockName' => $attrs['item_block_name'] ?? self::$item_block_name ], $block_attr ) );
		}

		return implode( PHP_EOL, $rtn );
	}


	/**
	 * Shortcut to set the lock attributes for all blocks.
	 *
	 * @param  array $input_data  All of the current block attributes.
	 *
	 * @return array
	 */
	public static function get_data( array $input_data ) : array {

		$default = [
			'blockName' => $input_data['block_name'] ?? static::$block_name,
			'attrs'     => [
				'className' => $input_data['attrs']['className'] ?? static::$block_classname,
				'id'        => $input_data['attrs']['id'] ?? '',
				'fontSize'  => $input_data['attrs']['fontSize'] ?? '',
				'lock'      => [
					'move'   => $input_data['attrs']['lock']['move'] ?? true,
					'remove' => $input_data['attrs']['lock']['remove'] ?? true,
				],
			],
		];

		// Set the class variables, so they can be reused with any input values.
		self::$block_name = $default['blockName'];

		self::$block_classname = $default['attrs']['className'];

		if ( isset( $input_data['item_block_name'] ) && ! empty( $input_data['item_block_name'] ) ) {
			self::$item_block_name = $input_data['item_block_name'];
		}

		if ( isset( $input_data['item_block_classname'] ) && ! empty( $input_data['item_block_classname'] ) ) {
			self::$item_block_classname = $input_data['item_block_classname'];
		}

		return self::merge_arrays_deep( $input_data, $default );

	}

	/**
	 * If an elementClassName attribute exists return that to use for actual dom elements
	 *
	 * @todo this should be based on values in attrs sub array
	 * @param  array $data Input data array.
	 *
	 * @return string
	 */
	public static function get_element_classname( array $data ) : string {
		return $data['elementClassName'] ?? $data['attrs']['className'];
	}



	/**
	 * Recursively replace all data in defaults with $args - works on multidimensional arrays
	 *
	 * @param  array $args  Arguments array.
	 * @param  array $defaults  Defaults array.
	 *
	 * @return array
	 */
	protected static function merge_arrays_deep( array $args, array $defaults ) : array {
		$rtn = (array) $defaults;

		foreach ( $args as $key => $value ) {
			if ( is_array( $value ) && isset( $rtn[ $key ] ) ) {
				$rtn[ $key ] = self::merge_arrays_deep( $value, $rtn[ $key ] );
			} else {
				$rtn[ $key ] = $value;
			}
		}

		return $rtn;
	}

	/**
	 * Hot-wires serialize_block_attributes as for some specific data this is causing double encoding issues
	 *
	 *
	 * @param  string  $string The Input string
	 *
	 * @return string
	 */
	public static function json_encode_clean_string( string $string ): string {
		$rtn = trim( $string );

		if ( ! empty( $rtn ) ) {
			$rtn = str_replace( '<br>', '', $rtn );
			$rtn = rtrim( $rtn, '"' );
			$rtn = ltrim( $rtn, '"' );
			$rtn = wp_json_encode( $rtn, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
			$rtn = rtrim( $rtn, '"' );
			$rtn = ltrim( $rtn, '"' );
			$rtn = preg_replace( '/--/', '\\u002d\\u002d', $rtn );
			$rtn = preg_replace( '/</', '\\u003c', $rtn );
			$rtn = preg_replace( '/>/', '\\u003e', $rtn );
			$rtn = preg_replace( '/&/', '\\u0026', $rtn );
			$rtn = preg_replace( '/\\\\"/', '\\u0022', $rtn );
			$rtn = preg_replace( '/£/', '\\u00a3', $rtn );
			$rtn = preg_replace( '/ – /', ' \\u2013 ', $rtn );
			$rtn = preg_replace( '/’ /', '\\u2019 ', $rtn );
		}

		return $rtn;

	}



}
