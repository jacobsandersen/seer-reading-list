<?php
// This file is generated. Do not modify it manually.
return array(
	'book-author' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'seer-reading-list/book-author',
		'version' => '1.0.0',
		'title' => 'Seer Book Author',
		'category' => 'widgets',
		'icon' => 'nametag',
		'description' => 'Displays the author of a Seer book. Only valid inside a Seer Book Query block.',
		'attributes' => array(
			'size' => array(
				'type' => 'integer',
				'default' => 14
			)
		),
		'supports' => array(
			'html' => false,
			'align' => array(
				'left',
				'center',
				'right'
			)
		),
		'textdomain' => 'seer-reading-list',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'book-cover' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'seer-reading-list/book-cover',
		'version' => '1.0.0',
		'title' => 'Seer Book Cover',
		'category' => 'widgets',
		'icon' => 'format-image',
		'description' => 'Displays the cover image of a Seer book. Only valid inside a Seer Book Query block.',
		'attributes' => array(
			'imageWidth' => array(
				'type' => 'integer',
				'default' => 200
			)
		),
		'supports' => array(
			'html' => false,
			'align' => array(
				'left',
				'center',
				'right'
			)
		),
		'textdomain' => 'seer-reading-list',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'book-meta-count' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'seer-reading-list/book-meta-count',
		'version' => '1.0.0',
		'title' => 'Seer Read Count',
		'category' => 'widgets',
		'icon' => 'chart-bar',
		'description' => 'Displays how many times a Seer book was read. Hidden when the book has not been read. Best used inside a Seer Book Query block.',
		'attributes' => array(
			'size' => array(
				'type' => 'integer',
				'default' => 12
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'seer-reading-list',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'book-meta-last-read' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'seer-reading-list/book-meta-last-read',
		'version' => '1.0.0',
		'title' => 'Seer Last Read',
		'category' => 'widgets',
		'icon' => 'calendar',
		'description' => 'Displays when a Seer book was last read. Hidden when the date is unavailable. Best used inside a Seer Book Query block.',
		'attributes' => array(
			'size' => array(
				'type' => 'integer',
				'default' => 12
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'seer-reading-list',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'book-title' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'seer-reading-list/book-title',
		'version' => '1.0.0',
		'title' => 'Seer Book Title',
		'category' => 'widgets',
		'icon' => 'heading',
		'description' => 'Displays the title of a Seer book. Only valid inside a Seer Book Query block.',
		'attributes' => array(
			'size' => array(
				'type' => 'integer',
				'default' => 16
			)
		),
		'supports' => array(
			'html' => false,
			'align' => array(
				'left',
				'center',
				'right'
			)
		),
		'textdomain' => 'seer-reading-list',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'pagination' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'seer-reading-list/pagination',
		'version' => '1.0.0',
		'title' => 'Seer Pagination',
		'category' => 'widgets',
		'icon' => 'ellipsis',
		'description' => 'Pagination controls for a Seer Book Query block. Rendered once below the book list; omit this block to hide pagination.',
		'attributes' => array(
			'size' => array(
				'type' => 'integer',
				'default' => 14
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'seer-reading-list',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'query' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'seer-reading-list/query',
		'version' => '1.0.0',
		'title' => 'Seer Book Query',
		'category' => 'widgets',
		'icon' => 'book',
		'description' => 'Query books from Seer and render each one using an inner block template.',
		'keywords' => array(
			'seer',
			'books',
			'reading',
			'query'
		),
		'attributes' => array(
			'component' => array(
				'type' => 'string',
				'enum' => array(
					'read',
					'current',
					'wanted'
				),
				'default' => 'current'
			),
			'limit' => array(
				'type' => 'integer',
				'default' => 10
			),
			'columns' => array(
				'type' => 'integer',
				'default' => 1
			),
			'uid' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false,
			'align' => true
		),
		'textdomain' => 'seer-reading-list',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	)
);
