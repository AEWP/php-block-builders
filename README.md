# PHP Block Builders

Sometimes it is necessary to build Gutenberg Blocks in PHP, for example when migrating content from another system or some external API integration. Whilst WordPress provides the very helpful [serialize_block](https://developer.wordpress.org/reference/functions/serialize_block/) function for actually creating the required HTML for each block this needed to be populated with a correctly formatted array of content and attributes, this package exposes factory objects which prescribe to a common pattern to more easily build all the Core blocks from PHP.

## Installation

This is a PHP package with the intent to be used from the codebase, not a WordPress plugin, therefore you should include it in your composer.json for use.

``` json
"repositories" : {
	{
		"type": "vcs",
		"url": "https://github.com/AEWP/php-block-builders"
	  }
},
"require": {
	"americaneagle/php-block-builders" : "dev-main",
}
```

## Usage

All blocks follow a standard pattern, import the class and then call a static create method injecting in the required content string and any specific block attributes, general and standard required attributes for each block are automatically added.

For instance to create a Paragraph block:

```php

use PhpBlockBuilders\Block\CoreParagraph;

/**
 * Returns a core paragraph block HTML.
 * 
 * @return string
 */
function create_a_paragraph():string {

	$text_content = 'hello, this is some paragraph content';
	
	$attrs = [
		// The attrs param should include the block attributes extras as a named attrs array, this allows for blocks to include other data which may not be directly passed to the block as part of the block attrs collection. Usually this parameter is optional.
		'attrs' => [
			'className' => 'additional-custom-classname'
		]
	];
	
	return CoreParagraph::create($text_content, $attrs);
}
```

Some other block creations require the $content param to be a post id or url, depending on what the gutenberg block uses, please investigate the comments for each block class to ensure you pass the correct value, this will however always be a string so that the interface can remain constant.

So to create an image block, you will need to inject an attachment post ID as the content:

```php
use PhpBlockBuilders\Block\CoreImage;

/**
 * Returns an image block HTML string.
 * 
* @return string
 */
function create_an_image_block():string {

	// An attachment post id as a string
	$content = (string) 1;
	
	$attrs = [
				// An example of a custom attribute that isnt part of the block attrs array.
				'figcaption' => 'this is an image',
				'attrs' => [
					'className' => 'additional-custom-classname'
				]
			];

	return CoreImage::create($content, $attrs);
}
```

Other more complicated blocks such as Columns require you to build the innerBlocks content and then inject this in, using the example of columns you will need to inject several Column blocks into the content:

```php

use PhpBlockBuilders\Block\CoreParagraph;
use PhpBlockBuilders\Block\CoreColumn;
use PhpBlockBuilders\Block\CoreColumns;

/**
 * Returns a two column columns block HTML string made up of example paragraph text.
 * 
* @return string
 */
function create_two_columns_block():string {
	
	$paragraph = CoreParagraph::create('this is some text');
	$column_one = CoreColumn::create($paragraph);
	$column_two = CoreColumn::create($paragraph);
	
	return CoreColumns::create($column_one . $column_two);

}
```


