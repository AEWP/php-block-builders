<?php
/**
 * Trait StringTrait
 *
 * @package PhpBlockBuilders\Helper
 */

namespace PhpBlockBuilders\Helper;

/**
 * Trait StringTrait
 *
 * @package PhpBlockBuilders\Helper
 */
trait StringTrait {

	/**
	 * Hot-wires serialize_block_attributes as for some specific data this is causing double encoding issues
	 *
	 * @param string $input The Input string.
	 *
	 * @return string
	 */
	public static function json_encode_clean_string( string $input ): string {
		$rtn = trim( $input );

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
