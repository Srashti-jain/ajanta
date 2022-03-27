<?php



/*

    |--------------------------------------------------------------------------

    | admin.php

    |--------------------------------------------------------------------------

    |

    | All Admin routes can be found here.

    |

*/



use App\Http\Controllers\BrandController;

use App\Http\Controllers\CategoryController;

use App\Http\Controllers\DeviceController;

use App\Http\Controllers\GenralController;

use App\Http\Controllers\GrandcategoryController;

use App\Http\Controllers\OtaUpdateController;

use App\Http\Controllers\PinCodController;

use App\Http\Controllers\SEODirectoryController;

use App\Http\Controllers\SubCategoryController;

use App\SEODirectory;

use Illuminate\Support\Facades\Route;







Route::group(['middleware' => ['auth','admin_access','switch_lang']], function () {



    Route::post('vue/sync-translation','LanguageController@sync_vue_translation');



    Route::resource("admin/multiCurrency", "MultiCurrencyController");



    Route::get('remove-public-and-force-https','Others\OtherController@getsettings')->name('others.settings');

    Route::post('force-https','Others\OtherController@forcehttps')->name('do.forcehttps');

    Route::post('remove-public','Others\OtherController@removepublic')->name('do.removepublic');



    Route::get('/clear-cache',function(){

        \Artisan::call('cache:clear');

        \Artisan::call('view:cache');

        \Artisan::call('view:clear');



        notify()->success(__("Cache has been cleared !"));



        return back();

    });



    Route::prefix('/admin/')->group(function(){

        Route::resource('roles','Roles\RolesController');

        Route::view('permission','per');

        Route::view('permission/bulk','perbulk');

        Route::post('permission/bulk','Roles\RolesController@bulkPermission');

        Route::post('permission','Roles\RolesController@createPermission');

    });



    Route::name('admin.affilate.')->prefix('/admin/affiliate')->group(function(){



        Route::get('/settings','AffilateController@settings')->name('settings');

        Route::post('/settings','AffilateController@update')->name('update');

        Route::get('/reports','AffilateController@reports')->name('dashboard');



    });

    Route::name('admin.pos.')->prefix('/admin/pos')->group(function(){ 
        
        Route::get('/', 'POSController@index')->name('index');
        Route::get('quick-view', 'POSController@quick_view')->name('quick-view');
        Route::post('variant_price', 'POSController@variant_price')->name('variant_price');
        Route::post('add-to-cart', 'POSController@addToCart')->name('add-to-cart');
        Route::post('remove-from-cart', 'POSController@removeFromCart')->name('remove-from-cart');
        Route::post('cart-items', 'POSController@cart_items')->name('cart_items');
        Route::post('update-quantity', 'POSController@updateQuantity')->name('updateQuantity');
        Route::post('empty-cart', 'POSController@emptyCart')->name('emptyCart');
        Route::post('tax', 'POSController@update_tax')->name('tax');
        Route::post('discount', 'POSController@update_discount')->name('discount');
        Route::get('customers', 'POSController@get_customers')->name('customers');
        Route::post('order', 'POSController@place_order')->name('order');
        Route::get('orders', 'POSController@order_list')->name('orders');
        Route::get('order-details/{id}', 'POSController@order_details')->name('order-details');
        Route::get('invoice/{id}', 'POSController@generate_invoice');
        Route::any('store-keys', 'POSController@store_keys')->name('store-keys');
    });




    



    Route::get('/admin/addon-manger','AddOnManagerController@index')->name('addonmanger.index');



    Route::post('/admin/toggle/module','AddOnManagerController@toggle');



    Route::post('/admin/addon/install','AddOnManagerController@install')->name('addon.install');



    Route::post('/admin/addon/delete','AddOnManagerController@delete')->name('addon.delete');



    Route::get('/admin/reports/stock-report','ReportController@stockreport')->name('admin.stock.report');



    Route::get('/admin/reports/stock-report-sp','ReportController@stockreportsp')->name('admin.stock.report.sp');



    Route::get('/admin/reports/sales-report','ReportController@salesreport')->name('admin.sales.report');



    Route::get('/admin/reports/most-view-products-report','ReportController@mostviewproducts')->name('admin.report.mostviewed');



    Route::get('/admin/reports/most-view-simple-products-report','ReportController@mostviewsimpleproducts')->name('admin.report.mostviewed.sp');



    Route::get('system-status',function(){



        abort_if(!auth()->user()->can('others.systemstatus'),403,'User does not have the right permissions.');

        return view('systemstatus');



    })->name('systemstatus');



    Route::post('/return/final/procceed/paytosuser/{id}', 'ReturnOrderController@paytouser')->name('final.process');



    Route::post('/save/twillo/settings','TwilloController@savesettings')->name('change.twilo.settings');



    Route::post('/save/amarpay/settings','KeyController@saveamarpaysettings')->name('change.amarpay.settings');



    Route::post('/change/msg/channel','TwilloController@changechannel')->name('change.channel');



    Route::get('/admin/push-notifications','PushNotificationsController@index')->name('admin.push.noti.settings');



    Route::post('/admin/one-signal/keys','PushNotificationsController@updateKeys')->name('admin.onesignal.keys');



    Route::post('/admin/push-notifications','PushNotificationsController@push')->name('admin.push.notif');

    

    Route::get('/admin/offer-popup','OfferPopUpController@getSettings')->name('offer.get.settings');



    Route::post('/admin/offer-popup','OfferPopUpController@updateSettings')->name('offer.update.settings');



    Route::post('/update-dump-path','BackupController@updatedumpPath')->name('dump.path.update');



    Route::get('/admin/sms/settings','Msg91Controller@getSettings')->name('sms.settings');



    Route::post('/admin/sms/settings','Msg91Controller@updateSettings')->name('sms.update.settings');



    Route::get('admin/manual-payment-settings','ManualPaymentGatewayController@getindex')->name('manual.payment.gateway');



    Route::post('admin/manual-payment-settings','ManualPaymentGatewayController@store')->name('manual.payment.gateway.store');



    Route::post('admin/manual-payment-settings-update/{id}','ManualPaymentGatewayController@update')->name('manual.payment.gateway.update');



    Route::post('admin/manual-payment-settings-delete/{id}','ManualPaymentGatewayController@delete')->name('manual.payment.gateway.delete');



    Route::get('visiter-data','AdminController@visitorData')->name('get.visitor.data');



    Route::get('/admin/import-demo',function(){

       abort_if(!auth()->user()->can('others.importdemo'),403,'User does not have the right permissions.');

       return view('admin.demo');

    })->name('admin.import.demo');



    Route::post('/admin/import/import-demo',function(){



        if(env('DEMO_LOCK') == 1){

            notify()->error('This action is disabled in demo !');

            return back();

        }





        abort_if(!auth()->user()->can('others.importdemo'),403,'User does not have the right permissions.');



        \Artisan::call('import:demo');

        notify()->success('Demo Imported successfully !');

        return back();

    });



    Route::post('/admin/reset-demo',function(){



        if(env('DEMO_LOCK') == 1){

            notify()->error('This action is disabled in demo !');

            return back();

        }



        abort_if(!auth()->user()->can('others.importdemo'),403,'User does not have the right permissions.');



        \Artisan::call('demo:reset');



        notify()->success('Demo reset successfully !');

        return back();

    });



    Route::post('admin/save/exchange/key',function(){



        if(env('DEMO_LOCK') == 1){

            notify()->error(__('This action is disabled in demo !'));

            return back();

        }

        

        $env_keys_save = \DotenvEditor::setKeys([

            'OPEN_EXCHANGE_RATE_KEY' => request()->OPEN_EXCHANGE_RATE_KEY

        ]);



        $env_keys_save->save();



        notify()->success('Exchange key has been updated !');



        return back();

       

    });



    Route::get('/admin/theme-settings','ThemeController@index')->name('admin.theme.index');



    Route::get('/admin/pre-orders','OrderController@preorders')->name('admin.preorders');



    Route::post('/admin/pre-orders/notify','OrderController@preordernotify')->name('admin.preorders.notify');



    Route::post('/admin/theme-settings/update','ThemeController@applytheme')->name('admin.theme.update');



    Route::post('/login/as/{userid}/', 'GuestController@adminLoginAs')->name('login.as');



    Route::get('admin/backups/','BackupController@get')->name('admin.backup.settings');



    Route::get('admin/download/{filename}','BackupController@download')->name('admin.backup.download');



    Route::get('admin/backups/process','BackupController@process')->name('admin.backup.process');



    Route::get('/sitemap', 'SiteMapController@sitemapGenerator');



    Route::get('/sitemap/download', 'SiteMapController@download');



    Route::post('admin/iyzico/settings/update', 'KeyController@iyzicoUpdate')->name('iyzico.settings.update');



    Route::post('admin/sslcommerze/settings/update', 'KeyController@sslcommerzeUpdate')->name('sslcommerze.settings.update');



    Route::post('admin/payhere/settings/update', 'KeyController@payhereUpdate')->name('payhere.settings.update');



    Route::get('/user/term/settings/', 'TermsController@userterms')->name('get.user.terms');



    Route::post('/user/term/settings/{key}', 'TermsController@postuserterms')->name('update.term.setting');



    



    Route::view('image/conversion', 'ota.imageconversion');



    Route::post('image/conversion/proccess', 'UpdaterScriptController@convert');



    Route::get('admin/excel', 'ProductController@excel')->name('index');

    Route::post('admin/import', 'ProductController@import')->name('import');



    



    Route::get('/admin/mail-settings', 'Configcontroller@getset')->name('mail.getset');

    Route::post('admin/mail-settings', 'Configcontroller@changeMailEnvKeys')->name('mail.update');



    Route::post('admin/update/paypal/setting', 'KeyController@savePaypal')->name('paypal.setting.update');

    Route::post('admin/update/stripe/setting', 'KeyController@saveStripe')->name('stripe.setting.update');

    Route::post('admin/update/braintree/setting', 'KeyController@saveBraintree')->name('bt.setting.update');



    //All variant Link//

    Route::get('/product/{id}/allvariants', 'ProductController@allvariants')->name('pro.vars.all');



    Route::get('/user/terms/settings', 'TermsController@userterms')->name('get.user.term.settings');



    Route::post('/user/terms/settings', 'TermsController@postuserterms')->name('post.user.term.settings');



    Route::get('/user/seller-terms/settings', 'TermsController@sellerterms')->name('get.seller.term.settings');



    Route::post('/user/seller-terms/settings', 'TermsController@postsellerterms')->name('post.seller.term.settings');



    Route::get('admin/wallet/settings', 'WalletController@adminWalletSettings')->name('admin.wallet.settings');



    Route::get('admin/wallet/settings/update', 'WalletController@updateWalletSettings')->name('admin.update.wallet.settings');



    Route::get('admin/widget/settings', 'WidgetsettingController@getSetting')->name('widget.setting');

    

    Route::post('admin/whatsapp/update/settings','WhatsappSettingsController@update')->name('wp.setting.update');



    Route::get('/maintaince-mode', 'MaintainenceController@getview')->name('get.view.m.mode');



    Route::post('/store/maintaince-mode', 'MaintainenceController@post')->name('get.m.post');



    Route::get('getsecretkey', 'GenerateApiController@getkey')->name('get.api.key');



    Route::post('createkey', 'GenerateApiController@createKey')->name('apikey.create');



    //Route::post('/admin/gift/wallet/point/{id}', 'WalletController@giftPoint')->name('admin.gift.point');



    Route::get('/admin/payment/setting/', 'KeyController@paymentsettings')->name('payment.gateway.settings');



    Route::delete('menu/topmenu/bulk_delete_top_menu', 'MenuController@bulk_delete_top_menu')->name('bulk.delete.topmenu');



    Route::delete('menu/footermenu/bulk_delete_top_menu', 'MenuController@bulk_delete_footer_menu')->name('bulk.delete.fm');



    Route::post('footermenu/store', 'FooterMenuController@store')->name('footermenu.store');

    Route::post('footermenu/udpate/{id}', 'FooterMenuController@update')->name('footermenu.update');

    Route::delete('delete/footermenu/{id}', 'FooterMenuController@delete')->name('footermenu.delete');



    Route::post('/reposition/category/', 'CategoryController@reposition')->name('cat.repos');



    Route::post('admin/quick/confirm/fullorder/{orderid}', 'QuickConfirmOrderController@quickconfirmfullorder')->name('quick.pay.full.order');



    Route::post('/reposition/subcategory/', 'SubCategoryController@reposition')->name('subcat.repos');



    Route::post('/reposition/childcategory/', 'GrandcategoryController@reposition')->name('childcat.repos');



    Route::post('/post/api/paytmupdate', 'KeyController@updatePaytm')->name('post.paytm.setting');



    Route::post('/admin/razorpay/setting', 'KeyController@updaterazorpay')->name('post.rpay.setting');



    Route::get('/admin/pwa/setting', 'PWAController@index')->name('pwa.setting.index');



    Route::post('/admin/pwa/update/setting', 'PWAController@updatesetting')->name('pwa.setting.update');



    Route::post('/admin/pwa/update/icons/setting', 'PWAController@updateicons')->name('pwa.icons.update');



    Route::get('/admin/advertise/', 'AdvController@selectLayout')->name('select.layout');



    Route::get('/admin/importproducts', 'ProductController@importPage')->name('import.page');



    Route::get('/admin/language', 'LanguageController@index')->name('site.lang');



    Route::get('/admin/edit/{lang}/staticTranslations', 'LanguageController@editStaticTrans')->name('static.trans');



    Route::post('/admin/update/{lang}/staticTranslations/content', 'LanguageController@updateStaticTrans')->name('static.trans.update');



    Route::post('/admin/language/store/lang/', 'LanguageController@store')->name('site.lang.store');



    Route::post('/admin/language/update/lang/{id}', 'LanguageController@update')->name('site.lang.update');



    Route::delete('/admin/language/delete/lang/{id}', 'LanguageController@delete')->name('site.lang.delete');



    Route::post('paytoseller/{venderid}/{orderid}', 'SellerPaymenyController@payoutprocess')->name('seller.pay');



    Route::post('paytoseller/via/bank/{venderid}/{orderid}', 'SellerPaymenyController@payoutviabank')->name('payout.bank');



    Route::post('paytoseller/via/manual/{venderid}/{orderid}', 'SellerPaymenyController@manualPayout')->name('manual.seller.payout');



    Route::get('/enablepincodesystem', 'PinCodController@enablesystem')->name('enable.pincode.system');



    Route::get('/admin/frontCategorySlider', 'CategorySliderController@get')->name('front.slider');



    Route::post('/admin/frontCategorySlider', 'CategorySliderController@post')->name('front.slider.post');



    Route::get('/admin/returnOrders', 'ReturnOrderController@index')->name('return.order.index');



    Route::get('/admin/update/returnOrder/{id}', 'ReturnOrderController@show')->name('return.order.show');



    Route::get('admin/ord/canceled', 'OrderController@getCancelOrders')->name('admin.can.order');



    Route::get('/admin/all/pro/reported', 'ReportProductController@get')->name('get.rep.pro');



    Route::get('/admin/setdef/using/ajax/{id}', 'AddSubVariantController@quicksetdefault');



    Route::get('/admin/onload/subcat', 'MenuController@onloadchildpanel');



    Route::get('/manage/stock/{id}', 'AddSubVariantController@getIndex')->name('manage.stock');



    Route::post('manage/stock/{id}', 'AddSubVariantController@post')->name('manage.stock.post');



    /*Product Attribute Routes*/

    Route::get('admin/product/attr', 'ProductAttributeController@index')->name('attr.index');



    Route::get('admin/product/attr/create', 'ProductAttributeController@create')->name('attr.add');



    Route::post('admin/product/attr/create', 'ProductAttributeController@store')->name('opt.str');



    Route::get('admin/product/attr/edit/{id}', 'ProductAttributeController@edit')->name('opt.edit');



    Route::post('admin/product/attr/edit/{id}', 'ProductAttributeController@update')->name('opt.update');



    

    Route::get("admin/add_curr", "MultiCurrencyController@add_currency_ajax");

    Route::get("admin/currency_codeShow", "MultiCurrencyController@show");

    Route::get("admin/enable_multicurrency", "MultiCurrencyController@auto_detect_location");

    Route::get("admin/setDefault", "MultiCurrencyController@setDefault");

    Route::get("admin/editCurrency", "MultiCurrencyController@editCurrency");

    Route::get("admin/auto_change", "MultiCurrencyController@auto_change");

    Route::get("admin/auto_detect_location", "MultiCurrencyController@auto_detect_location");

    Route::post("/admin/auto_update_currency", "MultiCurrencyController@auto_update_currency")->name('auto.update.rates');

    Route::get("admin/deleteCurrency/{id}", "MultiCurrencyController@destroy");

    Route::post("admin/location", "MultiCurrencyController@addLocation");

    Route::get("admin/editlocation/", "MultiCurrencyController@editLocation");

    Route::get("admin/deleteLocation/", "MultiCurrencyController@deleteLocation");

    Route::get("admin/checkOutUpdate/", "MultiCurrencyController@checkOutUpdate");

    Route::get("admin/defaul_check_checkout/", "MultiCurrencyController@defaul_check_checkout");

    /*End*/



    /*Product Values*/

    Route::get('admin/product/manage/values/{id}', 'ProductValueController@get')->name('pro.val');



    Route::post('admin/product/manage/values/store/{id}', 'ProductValueController@store')->name('pro.val.store');



    Route::get('admin/product/manage/values/update/{id}/{attr_id}', 'ProductValueController@update')->name('pro.val.update');

    /*End*/



    /*Product Add Variant Route*/

    Route::get('admin/product/addvariant/{id}', 'AddProductVariantController@getPage')->name('add.var');



    Route::post('admin/product/addvariant/{id}', 'AddProductVariantController@store')->name('add.str');



    Route::delete('admin/product/delete/variant/{id}', 'AddProductVariantController@destroy')->name('del.subvar');



    Route::post('admin/product/update/variant/{id}', 'AddProductVariantController@update')->name('updt.var2');

    /*AJAX ROUTE*/



    Route::get('admin/get/productvalues', 'AddProductVariantController@getProductValues');



    Route::get('admin/product/editvariant/{id}', 'AddSubVariantController@edit')->name('edit.var');



    Route::post('admin/product/editvariant/{id}', 'AddSubVariantController@update')->name('updt.var');



    Route::delete('admin/product/delete/var/{id}', 'AddSubVariantController@delete')->name('del.var');

    /*END*/



    Route::post('admin/product/bulk_delete', 'ProductController@bulk_delete')->name('pro.bulk.delete');

    Route::post('admin/update/instamojo/settings', 'KeyController@instamojoupdate')->name('instamojo.update');

    Route::post('admin/update/payu/settings', 'KeyController@payuupdate')->name('store.payu.settings');

    Route::post('admin/update/paystack/settings', 'KeyController@paystackUpdate')->name('store.paystackupdate.settings');



    Route::post('admin/update/cashfree/settings','KeyController@updateCashfree')->name('cashfree.settings');

    Route::post('admin/update/skrill/settings','KeyController@updateSkrill')->name('skrill.settings');

    Route::post('admin/update/omise/settings','KeyController@updateOmise')->name('omise.settings');

    Route::post('admin/update/moli/settings','KeyController@updateMoli')->name('moli.settings');



    Route::post('admin/update/rave/settings','KeyController@updateRave')->name('rave.settings');



    Route::resource("admin/users", "UserController");

    Route::resource("admin/category", "CategoryController");

    Route::resource("admin/grandcategory", "GrandcategoryController");

    Route::resource("admin/subcategory", "SubCategoryController");

    Route::resource("admin/country", "CountryController");

    Route::resource("admin/state", "StateController");

    Route::resource("admin/city", "CityController");

    Route::resource("admin/pincode", "PinCodController");

    Route::get("myadmin", "AdminController@index")->name('admin.main');

    Route::get("admin/appliedform", "UserController@appliedform")->name('get.store.request');

    Route::get('admin/social-login-settings', 'Configcontroller@socialget')->name('gen.set');

    Route::resource('admin/invoice', 'InvoiceController');



    Route::post('admin/social/login/settings/update/{service}', 'Configcontroller@socialLoginUpdate')->name('social.login.service.update');



    Route::post('setting/sociallogin/fb', 'Configcontroller@slfb')->name('sl.fb');

    Route::post('setting/sociallogin/gl', 'Configcontroller@slgl')->name('sl.gl');

    Route::post('setting/sociallogin/gitlab', 'Configcontroller@gitlabupdate')->name('gitlab.update');



    Route::get('/admin/paytoseller/{id}', 'SellerPaymenyController@show')->name('seller.payfororder');



    Route::get("admin/icon", "AdminController@icon");

    Route::resource("admin/stores", "StoreController");

    Route::resource("admin/brand", "BrandController");

    Route::get('admin/requested-brands', 'BrandController@requestedbrands')->name('requestedbrands.admin');

    Route::resource("admin/tax", "TaxController");

    Route::resource("admin/tax_class", "TaxClassController");

    Route::get("admin/taxclassAdd", "TaxClassController@addRow");

    Route::get("admin/taxclassUpdate", "TaxClassController@update");

    Route::resource("admin/coupan", "CoupanController");

    Route::resource("admin/commission", "CommissionController");

    Route::resource("admin/commission_setting", "CommissionSettingController");

    Route::get("admin/sellerpayouts", "SellerPaymenyController@index")->name('seller.payouts.index');

    Route::get('admin/completed/payouts', 'SellerPaymenyController@complete')->name('seller.payout.complete');

    Route::get('admin/payout/complete/print/{id}/payouts', 'SellerPaymenyController@printSlip')->name('seller.print.slip');

    Route::get('admin/payout/completed/show/{id}/payout', 'SellerPaymenyController@showCompletePayout')->name('seller.payout.show.complete');



    Route::post("admin/recipt_show/", "SellerPaymenyController@recipt_show");

    Route::get("admin/subcat", "MenuController@upload_info");

    Route::resource("admin/shipping", "ShippingController");

    Route::get('/admin/shipping-price-weight', 'ShippingWeightController@get')->name('get.wt');

    Route::post('admin/shipping-price-weight/update', 'ShippingWeightController@update')->name('update.ship.wt');

    Route::resource("admin/order", "OrderController");

    Route::get('admin/pending/order', 'OrderController@pendingorder')->name('admin.pending.orders');

    Route::delete('order/bulkdelete', 'OrderController@bulkdelete')->name('order.bulk.delete');



    Route::get('admin/order/view/{id}', 'OrderController@show')->name('show.order');

    Route::get('/order/print/{id}', 'OrderController@printOrder')->name('order.print');

    Route::get('/order/{orderid}/invoice/{id}', 'OrderController@printInvoice')->name('print.invoice');

    Route::get('/admin/order/edit/{orderid}/', 'OrderController@editOrder')->name('admin.order.edit');



    Route::get("order/pending/", "OrderController@pending");

    Route::get("order/deliverd", "OrderController@deliverd");

    Route::resource("admin/slider", "SliderController");

    Route::resource("admin/faq", "FaqController");

    Route::resource("admin/cod", "CodController");



    Route::get("admin/product_faq/create/{id}", "FaqProductController@create");

    Route::resource('admin/return-policy/', 'ReturnProductController');

    Route::get('admin/return_policy/edit/{id}', 'ReturnProductController@edit');

    Route::PUT('admin/return_policy/update/{id}', 'ReturnProductController@update');

    Route::get("pincode-add", "PinCodController@pincode_add");

    Route::get("admin/available-destination", "PinCodController@show_destination");

    Route::get("admin/destination", "PinCodController@destination")->name('admin.desti');



    Route::get('admin/destination/listbycountry/{country}/pincode', 'PinCodController@getDestinationdata')->name('country.list.pincode');

    /** Custom CSS and JS */

    Route::get('/admin/custom-style-settings', 'CustomStyleController@addStyle')->name('customstyle');

    Route::post('/admin/custom-style-settings/addcss', 'CustomStyleController@storeCSS')->name('css.store');

    Route::post('/admin/custom-style-settings/addjs', 'CustomStyleController@storeJS')->name('js.store');

    /** End */

    Route::resource('admin/abuse/', 'AbusedController');

    Route::get('abuse/', 'AbusedController@show');



    Route::get('admin/tickets', 'HelpDeskController@viewbyadmin')->name('tickets.admin');



    Route::get('admin/ticket/{id}', 'HelpDeskController@show')->name('ticket.show');



    Route::get('admin/update/ticket/{id}', 'HelpDeskController@updateTicket');



    Route::post('/admin/replay/ticket/{id}', 'HelpDeskController@replay')->name('ticket.replay');



    Route::get('admin/return_policy/destroy/{id}', 'ReturnProductController@destroy');

    Route::get('admin/return_products_show/edit/{id}', 'ReturnProductController@edit_return_product');

    Route::put('admin/return_products_show/edit/{id}', 'ReturnProductController@update_return_product');

    Route::resource("admin/menu", "MenuController");

    Route::resource("admin/page", "PageController");

    Route::resource("admin/genral", "GenralController");

    Route::resource("admin/review", "ReviewController");

    Route::get("admin/review_approval", "ReviewController@review_approval")->name('r.ap');

    Route::resource("admin/seo", "SeoController");

    Route::resource("admin/social", "SocialController");

    Route::resource("admin/unit", "UnitController");

    Route::get('admin/unit/{id}/values', 'UnitController@getValues')->name('unit.values');

    Route::post('admin/unit/{id}/values', 'UnitController@storeValue')->name('store.val.unit');

    Route::put('admin/unit/edit/{id}/value', 'UnitController@editValue')->name('edit.val.unit');

    Route::delete('admin/units/delete/{id}', 'UnitController@unitvaldelete')->name('del.unit.val');



    Route::resource("admin/widget", "WidgetsettingController");

    Route::resource("admin/zone", "ZoneController");

    Route::resource("admin/testimonial", "TestimonialController");

    Route::resource("admin/special", "SpecialOfferController");

    Route::get("admin/sp_offer_widget", "SpecialOfferController@show_widget")->name('sp.offer.widget');

    Route::put("admin/sp_offer_widget", "SpecialOfferController@update_widget");

    Route::resource("admin/hotdeal", "HotdealController");

    Route::get("admin/reletd_Product/{id}", "RealatedProductController@create");

    Route::get("admin/product_image/", "ProductController@show_all_pro_image");

    Route::get("admin/product_image/delete/{id}", "ProductController@pro_delete");

    Route::resource("admin/reletdProduct", "RealatedProductController");

    Route::get("admin/reletdProduct_setting", "RealatedProductController@setting_show");

    Route::post("admin/reletdProduct_update", "RealatedProductController@setting_update");

    Route::resource("admin/products", "ProductController");

    Route::resource("admin/adv", "AdvController");

    Route::get("admin/shipping_update", "ShippingController@shipping");



    Route::post('/update/cancel-full-order/status/{id}', 'FullOrderCancelController@fullOrderStatus')->name('full.can.order');



    Route::get("admin/caty", "ProductController@gcat");

    Route::post("admin/images", "ProductController@images");

    Route::post('admin/edit_images/{id}', 'ProductController@edit_images');



    Route::resource('admin/bank_details', 'BankDetailController');

    Route::resource('admin/blog', 'BlogController');

    Route::resource('admin/blog_comment', 'BlogController');

    Route::resource('admin/footer', 'FooterController');

    Route::resource('admin/widget_footer', 'WidgetFooterController');

    Route::resource('admin/NewProCat', 'FrontCatController');



    Route::get("admin/order_print/{id}", "AdminController@order_print");



    Route::resource('admin/detailadvertise', 'DetailAdsController');



    Route::get("admin/dashbord-setting", "DashboardController@dashbordsetting")->name('admin.dash');

    Route::post("admin/dashbord-setting/{id}", "DashboardController@dashbordsettingu")->name('admin.dash.update');



    Route::post('admin/dashbord-setting/fb/{id}', 'DashboardController@fbSetting')->name('fb.update');

    Route::post('admin/dashbord-setting/tw/{id}', 'DashboardController@twSetting')->name('tw.update');

    Route::post('admin/dashbord-setting/ins/{id}', 'DashboardController@insSetting')->name('ins.update');



    Route::post('/merge-quick-update',[OtaUpdateController::class,'mergeQuickupdate']);

    Route::post('/update-quick-setting',[GenralController::class,'quicksettings']);

    Route::post('/import/brands',[BrandController::class,'importbrands']);

    Route::post('/import/categories',[CategoryController::class,'import']);

    Route::post('/import/subcategories',[SubCategoryController::class,'import']);

    Route::post('/import/childcategories',[GrandcategoryController::class,'import']);



    Route::get('/offline_reports','OfflineReportController@index')->name('offline.orders.reports');



    Route::get('/customer/search','OfflineOrderController@customerSearch')->name('offline.customer.search');



    Route::get('/offline-billing/product/search','OfflineOrderController@productsearch')->name('offline.product.search');



    Route::resource('/admin/offline-orders','OfflineOrderController');



    Route::get('/admin/offline-orders/print/{id}','OfflineOrderController@print')->name('offline-order.print');



    Route::get('/admin/quick/get/order/detail', 'OrderController@QuickOrderDetails')->name('quickorderdtls');



    Route::resource('admin/flash-sales','FlashSaleController');



    Route::resource('admin/rma','RMAController');



    Route::get('/admin/search/products','FlashSaleController@searchproduct');



    Route::get('/admin/invoice/design','InvoiceController@getInvoiceDesign')->name('get.invoice.design');

    Route::post('/admin/invoice/design','InvoiceController@updateInvoiceDesign')->name('update.invoice.design');



    Route::get('/device-logs',[DeviceController::class,'index'])->name('device.logs');



    Route::post('export-pincodes',[PinCodController::class,'export'])->name('pincode.export');

    Route::post('import-pincodes',[PinCodController::class,'import'])->name('pincode.import');

    Route::view('media-manager','mediamanager')->name('media.manager');

    Route::resource('admin/seo-directory','SEODirectoryController');

});