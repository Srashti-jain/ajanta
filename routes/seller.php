<?php

/*
    |--------------------------------------------------------------------------
    | seller.php
    |--------------------------------------------------------------------------
    |
    | All seller routes can be found here.
    |
*/

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'is_verified', 'two_fa', 'switch_lang', 'is_vendor']], function () {

    Route::prefix('seller')->group(function () {

        Route::get("sellerdashboard", "VenderController@dashbord")->name('seller.dboard');

        Route::get('categories', 'ShippingInfoController@getcategories')->name('seller.get.categories');

        Route::get('subcategories', 'ShippingInfoController@getsubcategories')->name('seller.get.subcategories');

        Route::get('childcategories', 'ShippingInfoController@getchildcategories')->name('seller.get.childcategories');

        Route::get('available/shipping', 'ShippingInfoController@getinfo')->name('seller.shipping.info');

        Route::get('payout/complete/print/{id}/payouts', 'SellerPayoutController@printSlip')->name('vender.print.slip');

        Route::get('payout/completed/show/{id}/payout', 'SellerPayoutController@showCompletePayout')->name('vender.payout.show.complete');

        Route::get('/payouts', 'SellerPayoutController@index')->name('seller.payout.index');

        Route::get('return/orders', 'SellerReturnController@index')->name('seller.return.index');

        Route::get('/returnOrders/detail/{id}', 'SellerReturnController@detail')->name('seller.order.detail');

        Route::get('show/returnOrder/{id}', 'SellerReturnController@show')->name('seller.return.order.show');

        Route::get('brands', 'SellerBrandController@index')->name('seller.brand.index');

        Route::get('product/attributes', 'SellerProductAttributeController@index')->name('seller.product.attr');

        Route::post('requestforbrand/store', 'SellerBrandController@requestStore')->name('request.brand.store');

        //Route::post('/full/order/update/{id}', 'SellerCancelOrderController@updatefullcancelorder')->name('seller.full.cancel.order.update');

        Route::get('/ord/cancelled', 'SellerCancelOrderController@index')->name('seller.canceled.orders');

        Route::get('/setdef/using/ajax/{id}', 'SellerAddvariantController@quicksetdefault');

        Route::post('product/bulk_delete', 'VenderProductController@bulk_delete')->name('seller.pro.bulk.delete');

        Route::get('/product/{id}/allvariants', 'VenderProductController@allvariants')->name('seller.pro.vars.all');

        Route::post('/add/common/variant/{id}', 'SellerVariantController@storeCommon')->name('seller.add.common');

        Route::delete('/delete/common/variant/{id}', 'SellerVariantController@delCommon')->name('seller.del.common');

        /*Product Add Variant Route*/
        Route::get('product/addvariant/{id}', 'SellerVariantController@getPage')->name('seller.add.var');

        Route::post('product/addvariant/{id}', 'SellerVariantController@store')->name('seller.add.str');

        Route::DELETE('product/delete/variant/{id}', 'SellerVariantController@destroy')->name('seller.del.subvar');

        Route::post('product/update/variant/{id}', 'SellerVariantController@update')->name('seller.updt.var2');
        /*AJAX ROUTE*/

        Route::get('/manage/stock/{id}', 'SellerAddvariantController@getIndex')->name('seller.manage.stock');

        Route::post('manage/stock/{id}', 'SellerAddvariantController@post')->name('seller.manage.stock.post');

        Route::get('get/productvalues', 'SellerVariantController@getProductValues');

        Route::get('product/editvariant/{id}', 'SellerAddvariantController@edit')->name('seller.edit.var');

        Route::post('product/editvariant/{id}', 'SellerAddvariantController@update')->name('seller.updt.var');

        Route::delete('product/delete/var/{id}', 'SellerAddvariantController@delete')->name('seller.del.var');
        /*END*/

        Route::get('importproducts', 'VenderProductController@importPage')->name('seller.import.product');

        Route::post('importproducts', 'VenderProductController@storeImportProducts')->name('seller.import.store');

        Route::get('invoicesetting', 'VenderController@getInvoiceSetting')->name('vender.invoice.setting');

        Route::post('invoicesetting', 'VenderController@createInvoiceSetting')->name('vender.invoice.sop');

        Route::delete("store/delete/{id}", "VenderController@destroy")->name('req.for.delete.store');
        Route::resource("store", "VenderController");
        Route::get("orders", "VenderController@order");
        Route::get("enable", "VenderController@enable");

        Route::name('my.')->group(function () {
            Route::resource("products", "VenderProductController");
        });

        Route::get("commission", "VenderController@commission")->name('seller.commission');
        Route::get("myprofile", "VenderController@profile")->name('get.profile');
        Route::post("myprofile", "VenderController@updateprofile")->name('seller.profile.update');
        Route::get("cod", "CodController@showcashOn");
        Route::put("seller/cod/{id}", "CodController@editupdateOn");
        Route::get("cod/edit/{id}", "CodController@editcashOn");
        Route::resource("shipping", "VenderShippingController");
        Route::get("shipping_update", "ShippingController@shipping");
        Route::get("shipping_updates", "VenderShippingController@shipping");
        Route::resource("reletdProduct", "RealatedProductController");
        Route::get("reletdProduct_setting", "RealatedProductController@setting_show");
        Route::post("reletdProduct_update", "RealatedProductController@setting_update");
        Route::post("recipt_show/", "SellerPaymenyController@vendor_recipt_show");
        Route::post('update/ship', 'ShippingWeightController@update');

        Route::get('view/order/{id}', 'VenderOrderController@viewOrder')->name('seller.view.order');

        Route::get('print/order/{id}', 'VenderOrderController@printOrder')->name('seller.print.order');

        Route::get('print/{orderid}/invoice/{id}', 'VenderOrderController@printInvoice')->name('seller.print.invoice');

        Route::get('order/{orderid}/edit', 'VenderOrderController@editOrder')->name('seller.order.edit');

    });

});

/*Seller Routes END*/
