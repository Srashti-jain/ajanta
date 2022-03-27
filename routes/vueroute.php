<?php

use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | vueroutes.php
    |--------------------------------------------------------------------------
    |
    | All vue session based api's can be found and created here.
    |
*/

Route::group(['middleware' => ['web','switch_lang']], function () {

    Route::get('/homepage','Web\HomeController@index');

    // Route::get('/vue/tabbed-products','Web\HomeController@getTabbedProducts')->name('tabbed.products');

    Route::get('/vue/tabbed/products','Web\HomeController@getTabbedProducts');

    Route::get('/vue/click-tabbed-products/{type}','Web\HomeController@getProducts')->name('tabbed.click.products');

    Route::get('/vue/top-products','Web\HomeController@topProducts')->name('top.products');

    Route::post('vue/add_item/{id}/{variantid}/{varprice}/{varofferprice}/{qty}', 'Web\CartController@add_item')->name('add.cart.vue');

    Route::post('vue/simpleproduct/add_item/{pro_id}/{price}/{offerprice}', 'CartController@vuesimpeproductincart')->name('add.cart.vue.simple');

    Route::get('vue/sidebar/categories','Web\HomeController@sidebarcategories');
    ;

    Route::post('vue/add/to/comparison','Web\HomeController@addtoCompare');

    Route::get('vue/get/category/url','Web\HomeController@getCategoryUrl');
    Route::get('vue/get/subcategory/url','Web\HomeController@getSubCategoryUrl');
    Route::get('vue/get/childcategory/url','Web\HomeController@getChildCategoryUrl');

    Route::get('vue/top/menus','Web\HomeController@topmenus');

    Route::get('vue/get/slider','Web\HomeController@slider');

    Route::get('/cart/total','Web\HomeController@totalCart');

    Route::get('vue/blogs','Web\HomeController@blog');

    Route::get('vue/user/notifications','Web\HomeController@notifications');

    Route::get('/vue/addtowishlist/','Web\HomeController@addtowishlist');

    Route::get('/vue/add_or_removewishlist/','Web\HomeController@add_or_removewishlist');

    Route::get('/vue/wishlist/count','Web\HomeController@wishlistcount');

    Route::get('/vue/compare/count','Web\HomeController@comparecount');

    Route::get('/vue/top/category/products','Web\HomeController@topProducts');

    

    /** Advertisement API'S */

    Route::get('/vue/ads/beforeslider','Web\AdvController@index');
    
    Route::get('/vue/sidebarconfigs','Web\HomeController@sidebarconfigs');

    Route::post('/vue/remove/cart/login/{id}','Web\CartController@removeitemlogin');
    Route::post('/vue/remove/cart/guest/{variantid}','Web\CartController@removeitemguest');
    Route::post('/vue/remove/cart/guest/{variantid}','Web\CartController@removeitemguest');


});
