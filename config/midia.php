<?php
return [
    // DEFAULT Target directory
    'directory' => public_path().'/images',
    // For URL (e.g: http://base/media/filename.ext)
    'directory_name' => 'images',
    'url_prefix' => 'media',
    'prefix' => 'midia',
    // Multiple target directories
    'directories' => [
    	// Examples:
    	// ---------
    	// 'home' => [
    	// 	'path' => storage_path('media/home'),
    	// 	'name' => 'media/home' // as url prefix
    	// ],
		'brand' => [
    		'path' => public_path().'/images/brands',
    		'name' => 'brand' // as url prefix
    	],
		'logo' => [
    		'path' => public_path().'/images/genral',
    		'name' => 'logo' // as url prefix
    	],
		'simple_products' => [
    		'path' => public_path().'/images/simple_products',
    		'name' => 'simple_products' // as url prefix
    	],
		'product_files' => [
    		'path' => storage_path().'/digitalproducts/files',
    		'name' => 'product_files' // as url prefix
    	],
		
		'category' => [
    		'path' => public_path().'/images/category',
    		'name' => 'category' // as url prefix
    	],
		'subcategory' => [
    		'path' => public_path().'/images/subcategory',
    		'name' => 'subcategory' // as url prefix
    	],
		'blog' => [
    		'path' => public_path().'/images/blog',
    		'name' => 'blog' // as url prefix
    	],
		'manual_payment' => [
    		'path' => public_path().'/images/manual_payment',
    		'name' => 'manual_payment' // as url prefix
    	],
		'simple_products_gallery' => [
    		'path' => public_path().'/images/simple_products/gallery',
    		'name' => 'simple_products_gallery' // as url prefix
    	]
    ],

    // Thumbnail size will be generated
	'thumbs' => [100/*, 80, 100*/],
];
