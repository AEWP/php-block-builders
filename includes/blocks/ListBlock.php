<?php

namespace PhpBlockBuilders\Blocks;

use UK_CONTENT_PUBLISH_MIGRATION_PLUGIN\Modules\Set\Base;

/**
 * Class ListBlock
 *
 * @package PhpBlockBuilders\Blocks
 */
class ListBlock extends Base implements BlockInterface {

	/**
	 * Return a Gutenberg Block element including commented attributes from a DomElement Node
	 *
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create( array $attrs ):string {

		$content = $this->create_content_string( $attrs['content'], $attrs['type'] );
		$data = [
			'blockName'    => 'core/list',
			'innerContent' => [ $content ],
			'attrs'        => [
				'className' => $attrs['classname'],
				'ordered'   => 'ordered' === $attrs['type'],
			],
		];

		return serialize_block( $data );

	}

	/**
	 * Cleanup and convert list items to html
	 *
	 * @param  array $block_content
	 *
	 * @return string
	 */
	public function create_content_string( array $block_content, string $type ): string {

		$content     = [];
		$remove_tags = [ '<p>', '</p>', '{:target=_blank}' ];
		// some list content is in one item and possibly a long string formatted with markdown
		if ( 1 === count( $block_content ) ) {
			$content = [ str_replace( $remove_tags, '', (string) $this->get_markdown_converter()->convert( current( $block_content ) ) ) ];
		} else {
			// most include list items that are separate array items
			foreach ( $block_content as  $c ) {
				$content[] = str_replace( $remove_tags, '', (string) $this->get_markdown_converter()->convert( $c ) );
			}
		}

		$content = implode( '</li><li>', $content );
		$type    = ( $type === 'ordered' ) ? 'ol' : 'ul';
		return "<{$type}><li>{$content}</li></{$type}>";


	}


}
