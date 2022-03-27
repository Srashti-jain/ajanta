<?php


use App\Http\Controllers\FlashSaleController;
use App\Http\Controllers\PaymentProcessController;
use App\Http\Controllers\PreorderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use JoeDixon\Translation\Http\Controllers\LanguageController;
use JoeDixon\Translation\Translation;
use Spatie\Permission\Models\Role;

/** Development Routes */

Route::get('/phpinfo',function(){
    return phpinfo();
});



/** Should Removed in Production mode -- start */

// Route::get('/ana',function(){
    
//     $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::months(6));

//     dd($analyticsData);

// });


/** Should Removed in Production mode -- end */

Route::any('/stripe/3ds','StripController@complete3ds');

Route::any('/notify/payhere', 'PayhereController@notify');

Route::get('/ota/update', 'OtaUpdateController@getotaview');

Route::post('/ota/update/proccess', 'OtaUpdateController@update')->name('update.proccess');

Route::post('prelogin/ota/check','OtaUpdateController@prelogin')->name('prelogin.ota.check');

Route::get('/dont-show-popup','OfferPopUpController@dontShow')->name('offer.pop.not.show');


Route::post('/sendsms','TwilloController@sendsms');

Route::get('/change-currency/{id}', 'MainController@currency');

Route::post('/change-domain','MainController@changedomain');

Route::group(['middleware' => ['web','switch_lang']], function () {

    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

    Route::get('store/{uuid}/{title}','ViewStoreController@view')->name('store.view');

    Route::get('/simple_product/360/images','SimpleProductsController@front360');

    /** Installer Routes */

    Route::get('verifylicense', 'InstallerController@verifylicense')->name('verifylicense');

    Route::get('/install/procceed/verifyapp', 'InstallerController@verify')->name('verifyApp');

    Route::post('verifycode', 'InitializeController@verify');

    Route::get('/install/procceed/EULA', 'InstallerController@eula')->name('eulaterm');

    Route::get('/install/procceed/serverCheck', 'InstallerController@serverCheck')->name('servercheck');

    Route::post('/install/procceed/EULA', 'InstallerController@storeeula')->name('store.eula');

    Route::post('/install/procceed/serverCheck', 'InstallerController@storeserver')->name('store.server');

    Route::get('/install/procceed/step1', 'InstallerController@index')->name('installApp');

    Route::get('/search/items', 'SearchController@ajaxSearch')->name('ajaxsearch');

    Route::post('store/step1', 'InstallerController@step1')->name('store.step1');

    Route::get('/install/procceed/step2', 'InstallerController@getstep2')->name('get.step2');
    Route::get('/install/procceed/step3', 'InstallerController@getstep3')->name('get.step3');
    Route::get('/install/procceed/step4', 'InstallerController@getstep4')->name('get.step4');
    Route::get('/install/procceed/step5', 'InstallerController@getstep5')->name('get.step5');
    Route::post('stored/step2', 'InstallerController@step2')->name('store.step2');
    Route::post('stored/step3', 'InstallerController@storeStep3')->name('store.step3');
    Route::post('stored/step4', 'InstallerController@storeStep4')->name('store.step4');
    Route::post('stored/step5', 'InstallerController@storeStep5')->name('store.step5');

    /** End */
    

    Route::group(['middleware' => ['maintainence_mode']], function () {

            Auth::routes(['verify' => true]);

            Route::post('register', 'Auth\RegisterController@register')->name('register');

            Route::get('/contact-us','ContactController@index')->name('contact.us');

            Route::post('/contact-us','ContactController@getConnect')->name('get.connect');

            Route::group(['middleware' => ['IsInstalled', 'is_verified', 'isActive', 'two_fa','switch_lang']], function () {

                Route::post('proceed/to/payment',[PaymentProcessController::class,'processPayement'])->name("processTopayment");

                Route::get('proccess/to/preorder/payment/{id}',[PreorderController::class,'payment'])->name('preorder.remain.payment');

                Route::get('/flashdeals/list',[FlashSaleController::class,'list'])->name('flashdeals.list');

                Route::get('/flashdeals/view/{id}/{slug}',[FlashSaleController::class,'view'])->name('flashdeals.view');
                
                Route::get('/','Web\HomeController@newHomepage')->name('mainindex')->middleware('visiting_track');

                Route::post('/subscribe/for/product/stock/{varid}', 'ProductNotifyController@post')->name('pro.stock.subs');

                Route::get('/share', 'MainController@share')->name('share');

                Route::post('/menu/sort', 'MenuController@sort')->name('menu.sort');

                Route::get('/download/catlog/{catlog}','ProductController@download')->name('download.catlog');

                

                Route::get('products/{id}/{slug}','SimpleProductsController@show')->name('show.product');

                Route::post('/success/aamarpay','AamarpayController@success')->name('amarpay.success');

                Route::get('/blog', 'BlogController@frontindex')->name('front.blog.index');

                Route::get('/blogsearch', 'BlogController@search')->name('blog.search');

                Route::get('/blog/post/{slug}', 'BlogController@show')->name('front.blog.show');

                Route::get('details/{slug}/{id}', 'MainController@details_product'); // Product Detail Page

                Route::get('cart/', 'CartController@create_cart')->name('user.cart');
                
                Route::post('add_item/{id}/{variantid}/{varprice}/{varofferprice}/{qty}', 'CartController@add_item')->name('add.cart');

                Route::post('/simpleproduct/add_item/{pro_id}/{price}/{offerprice}', 'CartController@simpeproductincart')->name('add.cart.simple');

                Route::get('create_deal/', 'CartController@create_deal');
                Route::get('addtocart/{id}', 'CartController@index');
                Route::get('remove_cart/{id}', 'CartController@remove_cart')->name('rm.session.cart');
                Route::get('remove_table_cart/{id}', 'CartController@remove_table_cart')->name('rm.cart');
                Route::get('remove/from/cart/simpleproduct/{id}', 'CartController@removesimpleproduct')->name('rm.simple.cart');
                Route::post('update_table_cart/{id}', 'CartController@update_table_cart');
                Route::post('update_cart/{id}', 'CartController@update_cart');
                Route::get('update_cart/{id}', 'CartController@update_cart');
                Route::get('check/', 'MainController@check');
                Route::post('user_review/{id}', 'MainController@user_review');
                Route::post('user_review/simple/{id}', 'SimpleProductsController@user_review')->name('simpleproduct.rating');
                Route::get('category_show/{id}', 'MainController@category_show');
                Route::get('detail/{id}', 'MainController@detail');
                Route::get('brandshow/{id}/{catid}', 'MainController@brandshow');
                Route::get('tags/{id}/{catid}', 'MainController@tags');
                Route::get('shopbycat/{id}', 'MainController@shopbycat');
                Route::post('coupan_apply/', 'MainController@coupan_apply');
                Route::get('coupan_destroy/', 'MainController@coupan_destroy');

                Route::get('rentdays/', 'CartController@rent_update')->name('rentdays');

                Route::get('test/', 'CartController@test');
                Route::get('search/', 'MainController@search');
                Route::get('/comparisonlist', 'MainController@comparisonList')->name('compare.list');;
                Route::get('addto/comparison/{id}', 'MainController@docomparison')->name('compare.product');
                Route::get('/remove/product/{id}/comparsion', 'MainController@removeFromComparsion')->name('remove.compare.product');
                Route::get('bankDetail', 'MainController@bankdetail');
                Route::get('edit_blog/{id}', 'MainController@edit_blog');
            
                Route::post('newsletter', 'NewsletterController@store');
                Route::get('checkoutasguest', 'MainController@guestCheckout')->name('guest.checkout');
                Route::post('apply/for/seller/proccess', 'MainController@store_vender')->name('apply.seller.store');
                Route::get('return_product/{id}', 'ReturnProductController@show_return');
                Route::post('cancel_product/{id}', 'ReturnProductController@cancel_product')->name('cancel.item');
                Route::get('fcategory/', 'MainController@fcategory');
                Route::get('update/', 'MainController@refresh_data');

                Route::post('user/process_to_guest/', 'MainController@process_to_guest');

                Route::post('/feedback/send', 'SendFeedBackController@send')->name('send.feedback');

                Route::post('/comment/product', 'CommentController@store')->name('post.comment');
                Route::post('/comments/', 'CommentController@subcomment');

                Route::get('/home', function () {
                    return redirect('/');
                });

            });

            /*Seller Login Routes*/

            Route::get('/seller/login', 'GuestController@sellerloginview')->name('seller.login.page')->middleware('switch_lang');
            Route::post('/seller/secure/login', 'GuestController@dosellerlogin')->name('seller.login.do');

            /**/

            /*User Login Routes*/

            Route::post('/process/login/', 'CustomLoginController@doLogin')->name('normal.login');

            Route::post('/proccess/login/reftocart/', 'GuestController@cartlogin')->name('ref.cart.login');

            /*End*/

            /*Guest Checkout process*/

            Route::post('/process/to/checkout/as/guest', 'GuestController@guestregister')->name('ref.guest.register');

            /** End */

            /*Register routes if user coming from checkout window*/

            Route::get('/process/to/register', 'GuestController@referfromcheckoutwindow')->name('referfromcheckoutwindow');
            Route::post('/process/to/register', 'GuestController@storereferfromcheckoutwindow')->name('storeuserfromchwindow');

            /*end*/

            Route::get('/changelang', 'GuestController@changelang')->name('changelang');

            Route::post('/cart/removecoupan/', 'CouponApplyController@remove')->name('removecpn');

            Route::get('/shop', 'MainController@categoryf')->name('filtershop')->middleware('switch_lang');

            Route::get('choose_state', 'GuestController@choose_state');

            Route::get('choose_city', 'GuestController@choose_city');

            Route::post('cart/applycoupon', 'CouponApplyController@apply')->name('apply.cpn');

            Route::post('/comment/{postid}', 'BlogCommentController@store')->name('blog.comment.store');

            Route::get('/product/{id}/all/{type}/reviews', 'ProductController@allreviews')->name('allreviews');

            Route::get('/onloadvariant/{id}', 'AddSubVariantController@ajaxGet2');

            Route::get('/variantnotfound/{id}', 'AddSubVariantController@getDefaultforFailed');

            Route::get('login/{service}', 'Auth\LoginController@redirectToProvider')->name('sociallogin');

            Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.login.callback');

            Route::get('load/more/product/comment', 'CommentController@loadmore');

            Route::get('pincodeforaddress/', 'GuestController@getPinAddress')->name('pincodeforaddress');

            Route::get('/order-placed-successfully', function () {
                require_once base_path().'/app/Http/Controllers/price.php';
                return view('home.thankyou', compact('conversion_rate'));
            })->name('order.done')->middleware('switch_lang');

            Route::get('/setstart', 'GuestController@changeCur');

            Route::get('/category', 'MainController@category');
            Route::get('/categoryfilter', 'MainController@categoryfilter');

            Route::get('/faq', 'GuestController@faq')->middleware('switch_lang');

            Route::get('/show/{slug}', 'GuestController@showpage')->name('page.slug')->middleware('switch_lang');;

            Route::post('/empty/{token}/cart', 'CartController@emptyCart')->name('s.cart');

            Route::get('/onclickloadvariant/{id}', 'AddSubVariantController@ajaxGet');

            Route::view('checkoutProcess', 'front.chkoutnotlogin')->name('guest.check');

            Route::get('/getproductvar/testing', 'AddSubVariantController@gettingvar');

            Route::get('filter/brand/', 'MainController@brandfilter');

            Route::get('filter/variant/', 'MainController@variantfilter');

            Route::get("pincode-check", "PinCodController@pincode_check");

            Route::get("admin/gcat", "ProductController@gcato")->middleware('switch_lang');;
            Route::get("admin/dropdown", "ProductController@upload_info")->middleware('switch_lang');

            Route::get('admin/choose_state', 'UserController@choose_country');
            Route::get('admin/choose_city', 'UserController@choose_city');

            Route::get('/loadmore', 'LoadMoreController@index');
            Route::post('/loadmore/load_data', 'LoadMoreController@load_data')->name('loadmore.load_data');

            Route::get('ajax-form-submit', 'CommentController@ajex');
            Route::post('save-form', 'CommentController@ajex_submit');

            Route::get('checkout/', 'CheckoutController@index')->middleware('switch_lang');

            Route::post('/valid-2fa','TwoFactorController@login')->middleware('auth');

            /** Authorized Routes */

            Route::group(['middleware' => ['auth','is_verified','two_fa','switch_lang']], function () {

                Route::get('/user/affiliate/settings','AffilateController@userdashboard')->name('user.affiliate.settings');

                Route::get('/2fa','TwoFactorController@get2fa')->name('2fa.get');

                Route::post('/generate2faSecret','TwoFactorController@generate2faSecret');

                Route::post('/2fa-valid','TwoFactorController@valid2FA');

                Route::post('/disable-2fa','TwoFactorController@disable2FA');

                Route::get('/track/order','TrackOrderController@view')->name('track.order');

                Route::post('/track/order','TrackOrderController@get')->name('track.order.result');
                
                Route::get('apply-for-seller', 'MainController@applyforseller')->name('applyforseller');

                Route::post('paidvia/manualpay/{token}', 'ManualPaymentGatewayController@checkout')->name('manualpay.checkout');

                

                Route::post('payvia/iyzcio/proccess', 'IyzcioController@pay')->name('iyzcio.pay');
                Route::post('payvia/iyzcio/success', 'IyzcioController@callback')->name('iyzcio.callback');

                Route::post('/payvia/sslcommerze', 'SslCommerzPaymentController@index')->name('payvia.sslcommerze');
                Route::post('payvia/sslcommerze/success', 'SslCommerzPaymentController@success');
                Route::post('payvia/sslcommerze/fail', 'SslCommerzPaymentController@fail');
                Route::post('payvias/sslcommerze/cancel', 'SslCommerzPaymentController@cancel');
                Route::post('/payvia/sslcommerze/ipn', 'SslCommerzPaymentController@ipn');

                Route::get('check/variant/inwish', 'GuestController@checkInWish');

                Route::get('addtTocartfromWishList/{id}', 'MainController@addtTocartfromWishList');
                Route::get('AddToWishList/{id}', 'MainController@AddToWishList');

                Route::get('add/simple_pro/', 'SimpleProductsController@wishlist')->name('add.simple.pro.in.wishlist');

                Route::get('wishlist/', 'MainController@wishlist_show')->name('my.wishlist');
                Route::get('removeWishList/{id}', 'MainController@removeWishList');

                Route::post('process/billing-address', 'CheckoutController@add')->name('checkout');

                Route::get('order-review', 'CheckoutController@orderReview')->name('order.review');

                Route::get('profile/', 'CheckoutController@show_profile')->name('user.profile')->middleware('switch_lang');
                Route::get('edit_profile/', 'CheckoutController@edit_profile');
                Route::post('update_profile/{id}', 'CheckoutController@update');
                Route::get('/order', 'CheckoutController@order')->name('user.order')->middleware('switch_lang');
                Route::get('trackorder/{id}', 'CheckoutController@trackorder');
                Route::post('/changepass/{id}', 'CheckoutController@changepass')->name('pass.update');

                Route::get('/mywallet', 'WalletController@showWallet')->name('user.wallet.show')->middleware('switch_lang');;

                Route::post('/wallet/payment', 'WalletController@choosepaymentmethod')->name('wallet.choose.paymethod')->middleware('switch_lang');

                /*Add money using Paytm in wallet*/
                Route::post('/wallet/addmoney/using/paytm', 'WalletController@addMoneyViaPaytm')->name('wallet.add.using.paytm');
                Route::post('/wallet/success/using/paytm', 'WalletController@paytmsuccess');
                /*END*/

                /*Add money using Braintree in wallet*/
                Route::post('/wallet/braintree/accesstoken', 'WalletController@walletaccesstokenBT')->name('wallet.access.token.bt');
                Route::post('/wallet/addmoney/using/braintree', 'WalletController@addMoneyViaBraintree')->name('wallet.add.using.bt');
                Route::post('/wallet/success/using/braintree', 'WalletController@braintreesuccess');
                /*END*/

                /*Add money using Stripe in wallet*/
                Route::post('/wallet/addmoney/using/stripe', 'WalletController@addMoneyViaStripe')->name('wallet.add.using.stripe');
                Route::post('/wallet/success/using/stripe', 'WalletController@stripesuccess');
                /*END*/

                /*Add money using Paypal in wallet*/
                Route::post('/wallet/addmoney/using/paypal', 'WalletController@addMoneyViaPayPal')->name('wallet.add.using.paypal');
                Route::get('/wallet/success/using/paypal', 'WalletController@paypalSuccess');
                /*END*/

                /*Add money using razorpay in wallet*/
                Route::post('/wallet/addmoney/using/razorpay', 'WalletController@addMoneyViaRazorPay')->name('wallet.add.using.razorpay');
                /*End

                /*Add money using instamojo in wallet*/
                Route::post('/wallet/addmoney/using/instamojo', 'WalletController@addMoneyViaInstamojo')->name('wallet.add.using.instamojo');

                Route::get('/wallet/success/using/instamojo', 'WalletController@instaSuccess');
                /*End*/

                /*Wallet checkout*/

                Route::post('checkout/with/method/wallet', 'WalletController@checkout')->name('checkout.with.wallet');

                /** End */

                Route::get('/verifypayment', 'VerifyPaymentController@paymentReVerify');

                Route::get('/helpdesk', 'HelpDeskController@get')->name('hdesk')->middleware('switch_lang');

                Route::post('/helpdesk/store', 'HelpDeskController@store')->name('hdesk.store');

                Route::post('/cashfree/pay','CashfreeController@pay')->name('cashfree.pay');

                Route::post('payviacashfree/success', 'CashfreeController@success');

                Route::post('pay/via/omise', 'OmiseController@pay')->name('pay.via.omise');

                Route::post('/pay/via/rave', 'RavePaymentController@pay')->name('rave.pay');

                Route::get('/rave/callback', 'RavePaymentController@callback')->name('rave.callback');

                Route::post('/moli/pay/','MolliePaymentController@pay')->name('mollie.pay');

                Route::get('/moli/pay/callback','MolliePaymentController@callback')->name('mollie.callback');

                Route::post('pay/via/skrill', 'SkrillController@pay')->name('skrill.pay');

                Route::get('pay/via/skrill/success', 'SkrillController@success')->name('skrill.success');

                Route::get('/payhere/callback', 'PayhereController@callback');

                Route::get('/braintree/accesstoken', 'BrainTreeController@accesstoken')->name('bttoken');

                Route::post('/braintree/process', 'BrainTreeController@process')->name('pay.bt');

                Route::post('/payviapaytm', 'PaytmController@payProcess')->name('payviapaytm');

                Route::post('/paidviapaytmsuccess', 'PaytmController@paymentCallback');

                Route::post('/payviapaystack', 'PaystackController@pay')->name('pay.via.paystack');

                Route::get('/paystack/callback', 'PaystackController@callback')->name('paystack.callback');

                Route::post('rpay', 'PayViaRazorPayController@payment')->name('rpay');

                Route::get('/load/comments/on/post/{id}', 'BlogController@loadcommentsOneditpost')->name('load.edit.postcomments');

                Route::delete('/destroy/comment/{id}', 'BlogController@deletecomment')->name('comment.delete');

                Route::post('load/more/posts/comment', 'BlogCommentController@loadmore');

                Route::get('/myfailedtranscations', 'CheckoutController@getFailedTranscation')->name('failed.txn')->middleware('switch_lang');

                Route::get('/payment/process', 'BrainTreeController@process')->name('payment.process');

                Route::get('paidsuccess', 'InstamojoController@success');

                Route::get('payment/status', 'PayuController@status')->name('payupay.status');

                Route::post('payment', 'PayuController@payment')->name('payviapayu');

                Route::get('/check/localpickup/isApply', 'LocalpickupController@apply')->name('localpickup');

                Route::get('/back/localpickup/notapply', 'LocalpickupController@reset')->name('reset.localpickup');

                Route::post('/giftcharge/isApply', 'Web\CartController@applygiftcharge')->name('apply.giftcharge');

                Route::post('/giftcharge/reset', 'Web\CartController@resetgiftcharge')->name('reset.giftcharge');

                

                Route::get('/return/product/process/{id}', 'ReturnController@returnWindow')->name('return.window')->middleware('switch_lang');

                Route::post('/return/product/processed/{id}', 'ReturnController@process')->name('return.process');

                Route::get('/mybank', 'UserBankController@index')->name('mybanklist')->middleware('switch_lang');

                Route::post('/mybank', 'UserBankController@store')->name('user.bank.add');

                Route::post('/mybank/edit/{id}', 'UserBankController@update')->name('user.bank.update');

                Route::delete('mybank/{id}', 'UserBankController@delete')->name('user.bank.delete');

                Route::post('/cod/{token}', 'CodController@payviacod')->name('cod.process');

                Route::post('/bankTransfer/{token}', 'BankTransferController@payProcess')->name('bank.transfer.process');

                Route::post('/reportproduct/{id}', 'ReportProductController@post')->name('rep.pro');

                Route::get('/manageaddress', 'AddressController@getaddressView')->name('get.address')->middleware('switch_lang');

                Route::get('/pincode/finder', 'AddressController@pincodefinder')->name('findpincode');

                Route::post('/store/user/address/', 'AddressController@store')->name('address.store');

                Route::post('/store/user/address2/', 'AddressController@store2')->name('address.store2');

                Route::post('/store/user/address3/', 'AddressController@store3')->name('address.store3');

                Route::post('/update/user/address/{id}', 'AddressController@update')->name('address.update');

                Route::delete('/update/user/address/{id}', 'AddressController@delete')->name('address.del');

                Route::post('/empty/cart', 'CartController@empty')->name('empty.cart');

                Route::get('/process/billingaddress', 'CheckoutController@getBillingView')->name('get.billing.view');

                Route::post('process/billingaddress', 'CheckoutController@chooseaddress')->name('choose.address');

                Route::get('/getaddress/default', 'AddressController@ajaxaddress');

                Route::get('/getaddress/list', 'AddressController@ajaxaddressList');

                Route::get('/view/order/{orderid}', 'OrderController@viewUserOrder')->name('user.view.order')->middleware('switch_lang');

                Route::get('/download/order/{orderid}', 'OrderController@downloadDigitalProduct')->name('user.download.order')->middleware('switch_lang');

                Route::get('/getmyinvoice/{id}', 'OrderController@getUserInvoice')->name('user.get.invoice');

                Route::post('/order/complete/cancel/{id}', 'FullOrderCancelController@cancelOrder')->name('full.order.cancel');

                Route::get('markasread/user', 'AdminController@user_read')->name('mark_read_user');

                Route::get('markasread/order', 'AdminController@order_read')->name('mark_read_order');

                Route::get('markasread/ticket', 'AdminController@ticket_read')->name('mark_tkt_order');

                Route::get('clearall', 'AdminController@all_read')->name('clearall');

                Route::get('usermarkreadsingle', 'AdminController@single')->name('mrk');

                Route::get('mytickets', 'HelpDeskController@userticket')->name('user_t')->middleware('switch_lang');

                Route::get('paypal', 'PaymentController@index');
                Route::post('paypal', 'PaymentController@payWithpaypal');
                Route::get('status', 'PaymentController@getPaymentStatus');

                Route::get('payment/success', 'CheckoutController@success');
                Route::get('payment/payu', 'CheckoutController@payumoney');

                Route::get('instamojo', 'InstamojoController@index')->name('payment');
                Route::post('instamojo', 'InstamojoController@payment')->name('payviainsta');
                Route::get('strip', 'StripController@index');
                Route::post('strip', 'StripController@stripayment')->name('paytostripe');
                
                Route::get('/mychats','ChatController@userchat')->name('user.chat.screen');
                Route::get('/mychats/{conv_id}','ChatController@userchatview')->name('user.chat.view');
                Route::post('/send/message/chat/{conversion_id}','ChatController@sendmessage')->name('send.message');

                Route::post('/send/typing/indication/{conversion_id}','ChatController@typing')->name('typing.message');

                /*Admin + Seller Common Usable Routes */

                Route::group(['middleware' => ['SellerAdminMix']], function () {

                    Route::resource('manage/sizechart','SizeController');
                    Route::post('/sizechart/add/in/list','SizeController@addInList');       
                    Route::post('/sizechart/remove/in/list','SizeController@removefromlist');
                    Route::post('/sizechart/preview/view','SizeController@viewpreview');

                    Route::get('/manage/chats','ChatController@chatlist')->name('admin.chat.list');

                    Route::get('/chat/{userid}','ChatController@createchat')->name('chat.start');
                    
                    Route::get('/chat/view/{conversation}','ChatController@chatscreen')->name('chat.screen');

                    Route::get('/admin/returnOrders/detail/{id}', 'ReturnOrderController@detail')->name('return.order.detail');

                    Route::post('/admin/simpleproducts/preorder/settings/{id}', 'SimpleProductsController@preorderSettings')->name('preorder.settings');

                    Route::post('admin/import/simpleproducts/images', 'SimpleProductsController@importImages')->name('simple.product.import.images');

                    Route::post('admin/simple-products/upload/360_image/{id}','SimpleProductsController@upload360')->name('upload.360');

                    Route::post('admin/simple-products/delete/360_image','SimpleProductsController@delete360')->name('delete.360');

                    Route::post('delete/gallery/image','SimpleProductsController@deletegalleryImage');

                    Route::resource('manage/simple-products','SimpleProductsController');

                    Route::post('manage/simple-products/stock/manage/{id}','SimpleProductsController@manageInventory')->name('manage.inventory');

                    /*Quick Update Routes*/

                    Route::post('/admin/quickupdate/unit/{id}', 'QuickUpdateController@unitUpdate')->name('unit.quick.update');

                    Route::post('/admin/quickupdate/user/{id}', 'QuickUpdateController@userUpdate')->name('user.quick.update');

                    Route::post('/admin/quickupdate/store/{id}', 'QuickUpdateController@storeUpdate')->name('store.quick.update');

                    Route::get('/admin/quickupdate/menu/{id}', 'QuickUpdateController@menuUpdate')->name('menu.quick.update');

                    Route::post('/admin/quickupdate/product/{id}', 'QuickUpdateController@productUpdate')->name('product.quick.update');

                    Route::post('/admin/quickupdate/category/{id}', 'QuickUpdateController@catUpdate')->name('cat.quick.update');

                    Route::post('/admin/quickupdate/subcategory/{id}', 'QuickUpdateController@subUpdate')->name('sub.quick.update');

                    Route::post('/admin/quickupdate/childcategory/{id}', 'QuickUpdateController@childUpdate')->name('child.quick.update');

                    Route::post('/admin/quickupdate/brand/{id}', 'QuickUpdateController@brandUpdate')->name('brand.quick.update');

                    Route::post('/admin/quickupdate/detail_status/{id}', 'QuickUpdateController@detailUpdate')->name('detail_status.quick.update');

                    Route::post('/admin/quickupdate/detail_button/{id}', 'QuickUpdateController@detail_button_Update')->name('detail_button.quick.update');

                    Route::post('/admin/quickupdate/review/{id}', 'QuickUpdateController@reviewUpdate')->name('review.quick.update');

                    Route::post('/admin/quickupdate/coupon/{id}', 'QuickUpdateController@couponUpdate')->name('coupon.quick.update');

                    Route::post('/admin/quickupdate/tax/{id}', 'QuickUpdateController@taxUpdate')->name('tax.quick.update');

                    Route::post('/admin/quickupdate/taxclass/{id}', 'QuickUpdateController@taxclassUpdate')->name('taxclass.quick.update');

                    Route::post('/admin/quickupdate/commission/{id}', 'QuickUpdateController@commissionUpdate')->name('commission.quick.update');

                    Route::post('/admin/quickupdate/banks/{id}', 'QuickUpdateController@banksUpdate')->name('banks.quick.update');

                    Route::post('/admin/quickupdate/slider/{id}', 'QuickUpdateController@sliderUpdate')->name('slider.quick.update');

                    Route::post('/admin/quickupdate/faq/{id}', 'QuickUpdateController@faqUpdate')->name('faq.quick.update');

                    Route::post('/admin/quickupdate/blog/{id}', 'QuickUpdateController@blogUpdate')->name('blog.quick.update');

                    Route::post('/admin/quickupdate/page/{id}', 'QuickUpdateController@pageUpdate')->name('page.quick.update');

                    Route::post('/admin/quickupdate/social/{id}', 'QuickUpdateController@socialUpdate')->name('social.quick.update');

                    Route::post('/admin/quickupdate/hotdeal/{id}', 'QuickUpdateController@hotdealUpdate')->name('hot.quick.update');

                    Route::get('/admin/quickupdate/adv/{id}', 'QuickUpdateController@advUpdate')->name('adv.quick.update');

                    Route::post('/admin/quickupdate/clint/{id}', 'QuickUpdateController@clintUpdate')->name('clint.quick.update');

                    Route::post('/admin/quickupdate/home/widget/{id}', 'QuickUpdateController@widgethomeUpdate')->name('widget.home.quick.update');

                    Route::post('/admin/quickupdate/shop/widget/{id}', 'QuickUpdateController@widgetshopUpdate')->name('widget.shop.quick.update');

                    Route::post('/admin/quickupdate/page/widget/{id}', 'QuickUpdateController@widgetpageUpdate')->name('widget.page.quick.update');

                    Route::post('/admin/quickupdate/category/fea/{id}', 'QuickUpdateController@catfeaUpdate')->name('cat.featured.quick.update');

                    Route::post('/admin/quickupdate/subcategory/fea/{id}', 'QuickUpdateController@subfeaUpdate')->name('sub.featured.quick.update');

                    Route::post('/admin/quickupdate/childcategory/fea/{id}', 'QuickUpdateController@childfeaUpdate')->name('child.featured.quick.update');

                    Route::post('/admin/quickupdate/product/fea/{id}', 'QuickUpdateController@productfeaUpdate')->name('product.featured.quick.update');

                    Route::post('/admin/quickupdate/spa/status/{id}', 'QuickUpdateController@specialoffer')->name('spo.status.quick.update');

                    Route::post('/admin/quickupdate/store/request/{id}', 'QuickUpdateController@acpstore')->name('store.acp.quick.update');

                    Route::post('/admin/quickadd/category', 'QuickAddController@quickAddCat')->name('quick.cat.add');

                    Route::post('/admin/quickadd/subcategory', 'QuickAddController@quickAddSub')->name('quick.sub.add');

                    /** Quick Updates Routes end */

                    Route::get('update/orderstatus/{id}', 'VenderOrderController@updateStatus');

                    Route::delete('/delete/order/{id}', 'VenderOrderController@delete')->name('order.delete');

                    Route::post('/additonal/price/detail', 'VenderProductController@additionalPrice')->name('add.price.product');

                    Route::post('/add/common/variant/{id}', 'AddProductVariantController@storeCommon')->name('add.common');

                    Route::delete('/delete/common/variant/{id}', 'AddProductVariantController@delCommon')->name('del.common');

                    Route::resource("admin/product_faq", "FaqProductController");

                    Route::get('/track/payput/status/{batchid}', 'SellerPaymenyController@track')->name('payout.status');

                    Route::get('/update/{id}/relatedsetting/product', 'ProductController@prorelsetting')->name('prorelsetting');

                    Route::post('/store/list/product/{id}', 'ProductController@relatedProductStore')->name('rel.store');

                    Route::post('/product/{id}/specs/', 'ProductController@storeSpecs')->name('pro.specs.store');

                    Route::post('/product/{id}/update/specs', 'ProductController@updateSpecs')->name('pro.specs.update');

                    Route::delete('/products/{id}/delete/specs', 'ProductController@deleteSpecs')->name('pro.specs.delete');

                    Route::get('/admin/cod/{orderid}/orderpayconfirm', 'VenderOrderController@codorderconfirm')->name('cod.pay.confirm');

                    Route::post('/update/cancel-single-order/status/{id}', 'FullOrderCancelController@singleOrderStatus')->name('single.can.order');

                    Route::get('/delete/varimage1/{id}', 'DeleteImageController@deleteimg1');
                    Route::get('/delete/varimage2/{id}', 'DeleteImageController@deleteimg2');
                    Route::get('/delete/varimage3/{id}', 'DeleteImageController@deleteimg3');
                    Route::get('/delete/varimage4/{id}', 'DeleteImageController@deleteimg4');
                    Route::get('/delete/varimage5/{id}', 'DeleteImageController@deleteimg5');
                    Route::get('/delete/varimage6/{id}', 'DeleteImageController@deleteimg6');
                    Route::get('/setdef/var/image/{id}', 'DeleteImageController@setdef');

                    Route::get('/track/refund/live/api/{id}', 'TrackRefundController@singleOrderRefundTrack');

                    Route::get('/track/refund/fullorder/live/api/{id}', 'TrackRefundController@fullOrderRefundTrack');

                    Route::get('/admin/update/read-at/cancel/order', 'TrackRefundController@readorder');

                    Route::post('/updatelocalpickup/delivery/date/{id}', 'LocalpickupController@updateDelivery')->name('update.local.delivery');

                    Route::get('/admin/update/read-at/cancel/fullorder', 'TrackRefundController@readfullorder');

                    Route::post('/update/commonvar/{id}', 'AddProductVariantController@updatecommon')->name('common.update');

                    Route::get('update/order/{invoice}','UpdateOrderController@update')->name('update.invoice');

                    Route::post('update/order/{invoice}','UpdateOrderController@shipproduct')->name('ship.item');

                    Route::post('update/cashback/{product}','CashbackController@save')->name('cashback.save');

                });

                /*End*/

            });

            /** End Authorized Routes */

    });

    /** Admin Routes Start Not included in maintenance*/

    Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login.form')->middleware('switch_lang');

    Route::post('/admin/secure/login', 'GuestController@adminLogin')->name('admin.login');  

    /** Admin Routes End */

});
