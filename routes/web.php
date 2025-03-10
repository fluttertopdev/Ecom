<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|

| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear', function () {
  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('view:clear');
  Artisan::call('route:clear');
  return "Cache is cleared";
});

Route::get('/schedule-notification', function () {
  Artisan::call('schedule:run');
  return "Scheduler runs sucessfully.";
});
Route::middleware('admin-language:web')->group(function () {
  // ==================================Auth=======================================
  // Route::get('/','App\Http\Controllers\Auth\LoginController@getLoginView');

  Route::get('/admin-login', 'App\Http\Controllers\Auth\LoginController@getLoginView')->middleware(['check.app.installation', 'check.app.code_verified']);
  Route::post('do-login', 'App\Http\Controllers\Auth\LoginController@authenticate');

  Route::post('admin-logout', 'App\Http\Controllers\Auth\LoginController@adminlogout')->name('admin.admin-logout');

  // =================================Admin=======================================
  Route::get('/', function () {
    return view('welcome');
  })->middleware(['check.app.installation', 'check.app.code_verified']);

  Route::get('/licenses-verify', 'App\Http\Controllers\LicenseController@index')->middleware('check.app.installation');
  Route::post('/licenses-verify', 'App\Http\Controllers\LicenseController@verify')
    ->name('license.verify')
    ->middleware('check.app.installation');
  Route::middleware(['permission', 'check.app.installation', 'check.app.code_verified'])->group(function () {
    Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'admin']], function () {
      /******************** Dashboard Routing Starts Here *******************/
      Route::get('/dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
      Route::get('/', 'App\Http\Controllers\Admin\DashboardController@index');
      /******************* Dashboard Routing Ends Here ***********************/

      /*********************** Order Routing Starts Here ***********************/
      Route::get('/all-orders', 'App\Http\Controllers\Admin\OrdersController@index');
      Route::get('/inhouse-orders', 'App\Http\Controllers\Admin\OrdersController@inhouseorders');
      Route::get('/delivered-orders', 'App\Http\Controllers\Admin\OrdersController@deliveredorders');
      Route::get('/sellers-orders', 'App\Http\Controllers\Admin\OrdersController@sellersorders');
      Route::get('/order-details/{id}', 'App\Http\Controllers\Admin\OrdersController@orderDetails');
      Route::post('/update-order-status', 'App\Http\Controllers\Admin\OrdersController@updateorderproductStatus');
      Route::get('/orders-data', 'App\Http\Controllers\Admin\OrdersController@getOrderData');
      Route::get('/get-revenue-data', 'App\Http\Controllers\Admin\OrdersController@admingetRevenueData');
      Route::get('/admin-delete-order/{id}', 'App\Http\Controllers\Admin\OrdersController@destroy');

      /************************ Order Routing End Here ************************/

      /********************** Category Routing Starts Here **********************/

      Route::get('/category', 'App\Http\Controllers\Admin\CategoryController@index');
      Route::get('/add-category', 'App\Http\Controllers\Admin\CategoryController@create');
      Route::post('/save-category', 'App\Http\Controllers\Admin\CategoryController@store');
      Route::get('/edit-category/{id}', 'App\Http\Controllers\Admin\CategoryController@edit');
      Route::post('/update-category', 'App\Http\Controllers\Admin\CategoryController@update');
      Route::get('/delete-category/{id}', 'App\Http\Controllers\Admin\CategoryController@destroy');
      Route::get('/update-category-column/{id}', 'App\Http\Controllers\Admin\CategoryController@updateColumn');
      Route::get('/update-is-featured-category-column/{id}', 'App\Http\Controllers\Admin\CategoryController@updateIsFeaturedColumn');
      Route::post('fatch-categorydata', 'App\Http\Controllers\Admin\CategoryController@fatchcategorydata');
      Route::post('deletecategory', 'App\Http\Controllers\Admin\CategoryController@categoryDelete');
      Route::get('categories/translation/{id}', 'App\Http\Controllers\Admin\CategoryController@translation');
      Route::post('categories/translation/{id}', 'App\Http\Controllers\Admin\CategoryController@updateTranslation')->name('categories.update.translate');
      /********************* Category Routing End Here **********************/

      /******************** Subcategory Routing Starts Here *******************/

      Route::get('/subcategory', 'App\Http\Controllers\Admin\SubcategoryController@index');
      Route::get('/add-subcategory', 'App\Http\Controllers\Admin\SubcategoryController@create');
      Route::post('/save-subcategory', 'App\Http\Controllers\Admin\SubcategoryController@store');
      Route::get('/edit-subcategory/{id}', 'App\Http\Controllers\Admin\SubcategoryController@edit');
      Route::post('/update-subcategory', 'App\Http\Controllers\Admin\SubcategoryController@update');
      Route::get('/delete-subcategory/{id}', 'App\Http\Controllers\Admin\SubcategoryController@destroy');
      Route::get('/update-subcategory-column/{id}', 'App\Http\Controllers\Admin\SubcategoryController@updateColumn');
      Route::get('/update-popular-column/{id}', 'App\Http\Controllers\Admin\SubcategoryController@updatepopular');

      Route::post('/fatch-subcategorydata', 'App\Http\Controllers\Admin\SubcategoryController@fatchsubcategorydata');

      Route::post('/deletesubcategory', 'App\Http\Controllers\Admin\SubcategoryController@deletesubcategory');
      Route::get('subcategory/translation/{id}', 'App\Http\Controllers\Admin\SubcategoryController@translation');
      Route::post('subcategory/translation/{id}', 'App\Http\Controllers\Admin\SubcategoryController@updateTranslation')->name('subcategory.update.translate');
      /******************* Subcategory Routing End Here **********************/

      /*********************** Bulk Routing Starts Here *********************/

      Route::get('/category-bulk', 'App\Http\Controllers\Admin\CategoryBulkController@categoryBulk');
      Route::post('/export-categories', 'App\Http\Controllers\Admin\CategoryBulkController@export');
      Route::get('/download-category-sample-without-data', 'App\Http\Controllers\Admin\CategoryBulkController@downloadSampleWithoutData');
      Route::get('/download-category-sample-with-data', 'App\Http\Controllers\Admin\CategoryBulkController@downloadSampleWithData');
      Route::post('/import-categories', 'App\Http\Controllers\Admin\CategoryBulkController@import');

      /************************* Bulk Routing End Here ************************/

      /********************** Banner Routing Starts Here **********************/

      Route::get('/banner', 'App\Http\Controllers\Admin\BannerController@index');
      Route::get('/home-icon', 'App\Http\Controllers\Admin\BannerController@Homepageicon');
      Route::post('/save-banner', 'App\Http\Controllers\Admin\BannerController@store');

      Route::post('/homepageupdateIcons', 'App\Http\Controllers\Admin\BannerController@homepageupdateIcons');
      Route::get('/product-coustom-section', 'App\Http\Controllers\Admin\BannerController@productcoustomsection');
      Route::post('/storeproducttag', 'App\Http\Controllers\Admin\BannerController@storeproducttag');
      Route::get('/visibilities', 'App\Http\Controllers\Admin\BannerController@visibilities');
      Route::post('/storevisibilities', 'App\Http\Controllers\Admin\BannerController@storevisibilities');
      Route::post('/update-visibilities', 'App\Http\Controllers\Admin\BannerController@updatevisibilities');
      Route::get('/visibilities-destroy/{id}', 'App\Http\Controllers\Admin\BannerController@visibilitiesdestroy');
      Route::post('/update-banner', 'App\Http\Controllers\Admin\BannerController@update');
      Route::get('/delete-banner/{id}', 'App\Http\Controllers\Admin\BannerController@destroy');
      Route::get('/update-banner-column/{id}', 'App\Http\Controllers\Admin\BannerController@updateColumn');
      Route::get('/update-coustom-column/{id}', 'App\Http\Controllers\Admin\BannerController@updatecoustomColumn');

      Route::get('/create-coustom-section', 'App\Http\Controllers\Admin\BannerController@createcoustomsection');
      Route::post('/store-coustom-section', 'App\Http\Controllers\Admin\BannerController@storecoustomsection');
      Route::get('/edit-coustom-section/{id}', 'App\Http\Controllers\Admin\BannerController@editcoustomsection');
      Route::post('/update-coustom-section', 'App\Http\Controllers\Admin\BannerController@updatecoustomsection');
      Route::get('/delete-coustom-section/{id}', 'App\Http\Controllers\Admin\BannerController@coustomsectiondestroy');
      Route::post('/coustom-section-sortable', 'App\Http\Controllers\Admin\BannerController@sorting');

      Route::get('/cms', 'App\Http\Controllers\Admin\BannerController@cms');
      Route::get('/add-cms', 'App\Http\Controllers\Admin\BannerController@addcms');
      Route::post('/store-cms', 'App\Http\Controllers\Admin\BannerController@storecms');
      Route::get('/edit-cms/{slug}/{id}', 'App\Http\Controllers\Admin\BannerController@editcms');
      Route::post('/update-cms', 'App\Http\Controllers\Admin\BannerController@updatecms');
      Route::get('/update-cms-column/{id}', 'App\Http\Controllers\Admin\BannerController@updatecmscolumn');
      Route::get('/admin-cms-destroy/{id}', 'App\Http\Controllers\Admin\BannerController@cmsdestroy');
      Route::get('cms/translation/{id}', 'App\Http\Controllers\Admin\BannerController@translation');
      Route::post('cms/translation/{id}', 'App\Http\Controllers\Admin\BannerController@updateTranslation')->name('cms.update.translate');
      Route::get('coustom-section/translation/{id}', 'App\Http\Controllers\Admin\BannerController@coustomsectiontranslation');
      Route::post('coustomsectionupdate/translation/{id}', 'App\Http\Controllers\Admin\BannerController@updatecoustomsectiontranslate')->name('coustomsectionupdate.update.coustomsectionupdate');
      /********************* Banner Routing End Here **********************/

      /************************* Brands Routing  start Here ************************/
      Route::get('/brand', 'App\Http\Controllers\Admin\BrandController@index');
      Route::get('/add-brand', 'App\Http\Controllers\Admin\BrandController@create');
      Route::post('/save-brand', 'App\Http\Controllers\Admin\BrandController@store');
      Route::post('/update-brand', 'App\Http\Controllers\Admin\BrandController@update');
      Route::get('/update-brand-column/{id}', 'App\Http\Controllers\Admin\BrandController@updateColumn');
      Route::get('/delete-brand/{id}', 'App\Http\Controllers\Admin\BrandController@destroy');
      Route::get('brand/translation/{id}', 'App\Http\Controllers\Admin\BrandController@translation');
      Route::post('brand/translation/{id}', 'App\Http\Controllers\Admin\BrandController@updateTranslation')->name('brand.update.translate');

      /************************* Brands   Routing End Here ************************/

      /************************* currency Routing  start Here ************************/
      Route::get('/currency', 'App\Http\Controllers\Admin\CurrenciesController@index');
      Route::post('/save-currency', 'App\Http\Controllers\Admin\CurrenciesController@store');

      Route::post('/update-currency', 'App\Http\Controllers\Admin\CurrenciesController@update');
      Route::get('/currency-column/{id}', 'App\Http\Controllers\Admin\CurrenciesController@updateColumn');
      Route::get('/delete-currency/{id}', 'App\Http\Controllers\Admin\CurrenciesController@destroy');

      /************************* currency   Routing End Here ************************/

      /************************* Variations Routing  start Here ************************/
      Route::get('/variations', 'App\Http\Controllers\Admin\VariationController@index');
      Route::post('/save-variations', 'App\Http\Controllers\Admin\VariationController@store');
      Route::post('/update-brand', 'App\Http\Controllers\Admin\BrandController@update');
      Route::get('/update-brand-column/{id}', 'App\Http\Controllers\Admin\BrandController@updateColumn');

      /************************* Variations   Routing End Here ************************/

      /************************* Attributes Routing  start Here ************************/
      Route::get('/attributes', 'App\Http\Controllers\Admin\AttributeController@index');
      Route::get('/add-attributes', 'App\Http\Controllers\Admin\AttributeController@create');
      Route::post('/save-attributes', 'App\Http\Controllers\Admin\AttributeController@store');
      Route::post('/update-attributes', 'App\Http\Controllers\Admin\AttributeController@update');
      Route::get('/attributes-values/{id}', 'App\Http\Controllers\Admin\AttributevalueController@index');
      Route::post('/save-attributes-values', 'App\Http\Controllers\Admin\AttributevalueController@store');
      Route::post('/update-attributes-value', 'App\Http\Controllers\Admin\AttributevalueController@update');
      Route::get('/delete-attributes/{id}', 'App\Http\Controllers\Admin\AttributeController@destroy');
      Route::get('/delete-attributes-value/{id}', 'App\Http\Controllers\Admin\AttributevalueController@destroy');

      /************************* Attributes   Routing End Here ************************/

      /********************** Tax Routing Starts Here **********************/

      Route::get('/tax-list', 'App\Http\Controllers\Admin\TaxController@index');
      Route::post('/tax-save', 'App\Http\Controllers\Admin\TaxController@store');
      Route::post('/update-tax', 'App\Http\Controllers\Admin\TaxController@update');
      Route::get('/update-tax-column/{id}', 'App\Http\Controllers\Admin\TaxController@updateColumn');
      Route::get('/delete-tax/{id}', 'App\Http\Controllers\Admin\TaxController@destroy');

      /********************* Tax Routing End Here ***********************/

      /********************** shipping Routing Starts Here **********************/

      Route::get('/location', 'App\Http\Controllers\Admin\ShippingController@index');

      Route::post('/country-change-filters', 'App\Http\Controllers\Admin\ShippingController@countrychangefilters');
      Route::post('/state-change-filters', 'App\Http\Controllers\Admin\ShippingController@statechangecountrychangefilters');
      Route::post('/store-shipping', 'App\Http\Controllers\Admin\ShippingController@store');
      Route::get('/edit-location/{id}', 'App\Http\Controllers\Admin\ShippingController@editlocation');
      Route::post('/shipping-update', 'App\Http\Controllers\Admin\ShippingController@update');
      Route::post('/postcodefilters', 'App\Http\Controllers\Admin\ShippingController@postcodefilters');

      Route::get('/update-location-column/{id}', 'App\Http\Controllers\Admin\ShippingController@updatelocationColumn');
      Route::get('/delete-shipping/{id}', 'App\Http\Controllers\Admin\ShippingController@destroy');

      /********************* shipping Routing End Here ***********************/

      /********************** shipping price Routing Starts Here **********************/

      Route::get('/shipping-rate-type', 'App\Http\Controllers\Admin\ShippingController@shippingrate');
      Route::get('/update-type-status/{id}', 'App\Http\Controllers\Admin\ShippingController@updateColumn');
      Route::get('/shipping-rate/{id}', 'App\Http\Controllers\Admin\ShippingController@shippingrates');
      Route::post('/shipping-rate-update', 'App\Http\Controllers\Admin\ShippingController@shippingrateupdate');

      Route::get('/edit-shipping-rate/{type}', 'App\Http\Controllers\Admin\ShippingController@editshippingrate');
      Route::post('/update-for-shipping-city', 'App\Http\Controllers\Admin\ShippingController@updateforshippingcity');
      Route::post('/addnewcity', 'App\Http\Controllers\Admin\ShippingController@addnewcity');
      Route::post('/geteditcity', 'App\Http\Controllers\Admin\ShippingController@geteditcity');
      Route::post('/addnewstate', 'App\Http\Controllers\Admin\ShippingController@addnewstate');
      Route::post('/geteditstate', 'App\Http\Controllers\Admin\ShippingController@geteditstate');
      Route::post('/update-for-shipping-state', 'App\Http\Controllers\Admin\ShippingController@updateforshippingstate');

      /********************** shipping price Routing Starts Here **********************/

      /********************** Shipping Carriers Routing Starts Here **********************/

      Route::get('/carriers', 'App\Http\Controllers\Admin\ShippingCarriersController@index');
      Route::post('/save-carriers', 'App\Http\Controllers\Admin\ShippingCarriersController@store');
      Route::post('/update-carriers', 'App\Http\Controllers\Admin\ShippingCarriersController@update');
      Route::get('/delete-carriers/{id}', 'App\Http\Controllers\Admin\ShippingCarriersController@destroy');
      Route::get('/update-carriers-column/{id}', 'App\Http\Controllers\Admin\ShippingCarriersController@updateColumn');

      /********************* Category Carriers Routing End Here **********************/

      /********************** Refund Routing Starts Here **********************/

      Route::get('/refund-request', 'App\Http\Controllers\Admin\RefundController@index');
      Route::get('/approved-refund', 'App\Http\Controllers\Admin\RefundController@approvedRefund');

      Route::get('/rejected-refund', 'App\Http\Controllers\Admin\RefundController@rejectedrefund');

      /********************* Refund Routing End Here **********************/

      /********************** CustomNotification Routing Starts Here **********************/

      Route::get('/custom-notification', 'App\Http\Controllers\Admin\CustomNotificationController@index');

      Route::post('/save-notification', 'App\Http\Controllers\Admin\CustomNotificationController@store');
      Route::get('/delete-noti/{id}', 'App\Http\Controllers\Admin\CustomNotificationController@destroy');

      /********************* CustomNotification  Routing End Here **********************/

      /********************** coupns Routing Starts Here **********************/

      Route::get('/coupon', 'App\Http\Controllers\Admin\CouponController@index');
      Route::post('/save-coupon', 'App\Http\Controllers\Admin\CouponController@store');

      Route::post('/update-coupon', 'App\Http\Controllers\Admin\CouponController@update');
      Route::get('/delete-coupon/{id}', 'App\Http\Controllers\Admin\CouponController@destroy');
      Route::get('/update-coupon-column/{id}', 'App\Http\Controllers\Admin\CouponController@updateColumn');

      /********************* coupns Routing End Here **********************/

      /************************ User Routing Start Here *********************/
      Route::get('/profile', 'App\Http\Controllers\Admin\UserController@adminProfile');
      Route::post('/update-profile', 'App\Http\Controllers\Admin\UserController@updateAdminProfile');

      Route::get('/customer', 'App\Http\Controllers\Admin\UserController@customerList');
      Route::post('/save-customer', 'App\Http\Controllers\Admin\UserController@store');
      Route::post('/update-customer', 'App\Http\Controllers\Admin\UserController@update');
      Route::get('/delete-customer/{id}', 'App\Http\Controllers\Admin\UserController@destroy');
      Route::get('/update-customer-column/{id}', 'App\Http\Controllers\Admin\UserController@updateColumn');
      Route::get('/view-customer/{id}', 'App\Http\Controllers\Admin\UserController@viewCustomer');
      /************************ User Routing End Here *********************/

      /********************** Deliveryman Routing Starts Here *****************/

      Route::get('/deliveryman', 'App\Http\Controllers\Admin\DeliverymanController@index');
      Route::get('/add-deliveryman', 'App\Http\Controllers\Admin\DeliverymanController@create');
      Route::post('/save-deliveryman', 'App\Http\Controllers\Admin\DeliverymanController@store');
      Route::get('/edit-deliveryman/{id}', 'App\Http\Controllers\Admin\DeliverymanController@edit');
      Route::post('/update-deliveryman', 'App\Http\Controllers\Admin\DeliverymanController@update');
      Route::get('/delete-deliveryman/{id}', 'App\Http\Controllers\Admin\DeliverymanController@destroy');
      Route::get('/update-deliveryman-column/{id}', 'App\Http\Controllers\Admin\DeliverymanController@updateColumn');
      Route::get('/view-deliveryman/{id}', 'App\Http\Controllers\Admin\DeliverymanController@viewDeliveryman');
      Route::get('/delivery-man-reviews', 'App\Http\Controllers\Admin\DeliverymanController@deliverymanReviews');

      /********************** Deliveryman Routing End Here ***********************/

      /********************** Sellers Routing Starts Here *****************/

      Route::get('/all-sellers', 'App\Http\Controllers\Admin\SellersController@index');
      Route::get('/add-sellers', 'App\Http\Controllers\Admin\SellersController@create');
      Route::post('/save-sellers', 'App\Http\Controllers\Admin\SellersController@store');
      Route::get('/edit-sellers/{id}', 'App\Http\Controllers\Admin\SellersController@edit');
      Route::post('/update-sellers', 'App\Http\Controllers\Admin\SellersController@update');
      Route::get('/delete-sellers/{id}', 'App\Http\Controllers\Admin\SellersController@destroy');
      Route::get('/update-sellers-column/{id}', 'App\Http\Controllers\Admin\SellersController@updateColumn');
      Route::post('/update-commison', 'App\Http\Controllers\Admin\SellersController@updatecommison');
      Route::get('/sellers-payout', 'App\Http\Controllers\Admin\SellersController@sellerspayout');
      Route::get('/payout-requests', 'App\Http\Controllers\Admin\SellersController@payoutrequests');
      Route::get('/seller-view', 'App\Http\Controllers\Admin\SellersController@sellersview');
      Route::get('/seller-disbursement', 'App\Http\Controllers\Admin\SellersController@sellerDisbursement');
      Route::get('/withdraw-request/{id}', 'App\Http\Controllers\Admin\SellersController@sellerwithrawrequest');
      Route::post('/withdraw-request-approved', 'App\Http\Controllers\Admin\SellersController@requestupdate');

      /********************** Sellers Routing End Here ***********************/

      /********************* Role Routing Starts Here ***********************/
      Route::get('/role', 'App\Http\Controllers\Admin\RoleController@index');
      Route::post('/role', 'App\Http\Controllers\Admin\RoleController@index');
      Route::post('/add-role', 'App\Http\Controllers\Admin\RoleController@store');
      Route::post('/update-role', 'App\Http\Controllers\Admin\RoleController@update');
      Route::get('/delete-role/{id}', 'App\Http\Controllers\Admin\RoleController@destroy');
      Route::get('/update-role-status/{id}/{value}', 'App\Http\Controllers\Admin\RoleController@updateColumn');
      /********************** Role Routing End Here ***********************/

      /***************** Setting Routing Starts Here ******************/
      Route::get('/settings/all-setting', 'App\Http\Controllers\Admin\SettingController@index');
      Route::post('/update-setting', 'App\Http\Controllers\Admin\SettingController@update');
      Route::post('/store-heading', 'App\Http\Controllers\Admin\SettingController@storeheading');
      Route::post('/delete-heading', 'App\Http\Controllers\Admin\SettingController@deleteHeadline');
      Route::get('/setlang', 'App\Http\Controllers\Admin\SettingController@setLanguage');

      /***************** Setting Routing End Here ********************/

      /*************** Push Notification Routing Starts Here *******************/

      Route::get('/push-notification', 'App\Http\Controllers\Admin\PushNotificationController@index');
      Route::get('/add-push-notification', 'App\Http\Controllers\Admin\PushNotificationController@create');
      Route::post('/send-push-notification', 'App\Http\Controllers\Admin\PushNotificationController@store');
      Route::get('/delete-push-notification/{id}', 'App\Http\Controllers\Admin\PushNotificationController@destroy');

      /************** Push Notification Routings Starts Here *********************/

      /************************* Subadmin Routing Starts Here **********************/

      Route::get('/sub-admin', 'App\Http\Controllers\Admin\SubAdminController@index');
      Route::post('/sub-admin', 'App\Http\Controllers\Admin\SubAdminController@index');
      Route::post('/add-sub-admin', 'App\Http\Controllers\Admin\SubAdminController@store');
      Route::post('/update-sub-admin', 'App\Http\Controllers\Admin\SubAdminController@update');
      Route::get('/delete-sub-admin/{id}', 'App\Http\Controllers\Admin\SubAdminController@destroy');
      Route::get('/update-sub-admin-status/{id}', 'App\Http\Controllers\Admin\SubAdminController@updateColumn');

      /************************* Subadmin Routing Ends Here **************************/

      /************************* Languages Routing Starts Here **************************/

      Route::get('/languages', 'App\Http\Controllers\Admin\LanguageController@index');
      Route::post('/languages', 'App\Http\Controllers\Admin\LanguageController@index');
      Route::post('/add-language', 'App\Http\Controllers\Admin\LanguageController@store');
      Route::post('/update-language', 'App\Http\Controllers\Admin\LanguageController@update');
      Route::delete('/delete-language/{id}', 'App\Http\Controllers\Admin\LanguageController@destroy');
      Route::get('/update-language-status/{id}/{value}', 'App\Http\Controllers\Admin\LanguageController@changeStatus');

      /************************* Languages Routing Starts Here **************************/

      /************************* Languages Routing Starts Here **************************/

      Route::get('/translation/{language_id}', 'App\Http\Controllers\Admin\TranslationController@index');
      Route::post('/translation', 'App\Http\Controllers\Admin\TranslationController@index');
      Route::post('/add-translation', 'App\Http\Controllers\Admin\TranslationController@store');
      Route::get('/update-translation/{id}', 'App\Http\Controllers\Admin\TranslationController@edit');
      Route::post('/update-translation', 'App\Http\Controllers\Admin\TranslationController@update');
      // Route::delete('/delete-translation/{id}', 'App\Http\Controllers\Admin\LanguageController@destroy');
      // Route::get('/update-translation-status/{id}/{value}', 'App\Http\Controllers\Admin\LanguageController@changeStatus');

      /************************* Languages Routing Starts Here **************************/

      /************************* Product Routing  start Here ************************/
      Route::get('/products', 'App\Http\Controllers\Admin\ProductController@index');
      Route::get('/product-create', 'App\Http\Controllers\Admin\ProductController@create');

      Route::post('/product-store', 'App\Http\Controllers\Admin\ProductController@store');
      Route::get('/edit-product/{id}', 'App\Http\Controllers\Admin\ProductController@editproduct');
      Route::post('/product-update', 'App\Http\Controllers\Admin\ProductController@productupdate');

      Route::get('/sellers-products', 'App\Http\Controllers\Admin\ProductController@sellersproduct');

      Route::get('product/translation/{id}', 'App\Http\Controllers\Admin\ProductController@translation');
      Route::post('product/translation/{id}', 'App\Http\Controllers\Admin\ProductController@updateTranslation')->name('product.update.translate');

      Route::post('/multi-delete-product', 'App\Http\Controllers\Admin\ProductController@multiDelete');

      Route::get('/delete-product/{id}', 'App\Http\Controllers\Admin\ProductController@destroy');
      Route::get('exportAllOrders', 'App\Http\Controllers\Admin\ProductController@exportAllOrders')->name('exportAllOrders');
      Route::get('sellerexportAllproduct', 'App\Http\Controllers\Admin\ProductController@sellerexportAllproduct')->name('sellerexportAllproduct');

      Route::get('/update-product-column/{id}', 'App\Http\Controllers\Admin\ProductController@updateColumn');
      Route::get('/FeaturedColumn/{id}', 'App\Http\Controllers\Admin\ProductController@updateFeaturedColumn');
      Route::get('/bestsellerColumn/{id}', 'App\Http\Controllers\Admin\ProductController@updatebest_sellerColumn');

      /************************* Product   Routing End Here ************************/
    });
    Route::post('admin/category-change', 'App\Http\Controllers\Admin\ProductController@categorychange');
    Route::post('admin/country-change', 'App\Http\Controllers\Admin\ShippingController@countrychange');
    Route::post('admin/state-change', 'App\Http\Controllers\Admin\ShippingController@statechange');
    Route::post('admin/city-change', 'App\Http\Controllers\Admin\ShippingController@citychange');
    Route::post('admin/upload-product-images', 'App\Http\Controllers\Admin\ProductController@uploadproductImages');
    Route::post('admin/delete-product-image', 'App\Http\Controllers\Admin\ProductController@deleteProductImage');
    Route::post('admin/genrate-vriant', 'App\Http\Controllers\Admin\ProductController@genratevriant');
    Route::post('admin/feach-vriant', 'App\Http\Controllers\Admin\ProductController@feachvriant');
    Route::post('admin/save-variants', 'App\Http\Controllers\Admin\ProductController@savevriant');
    Route::get('admin/get-product-variants/{id}', 'App\Http\Controllers\Admin\ProductController@getProductVariants');
    Route::post('admin/upload-variant-images', 'App\Http\Controllers\Admin\ProductController@uploadVariantImages');
    Route::post('admin/updategenratevriant', 'App\Http\Controllers\Admin\ProductController@updategenratevriant');
    Route::post('admin/update-variants', 'App\Http\Controllers\Admin\ProductController@updatevriant');
    Route::post('admin/delete-variant-image', 'App\Http\Controllers\Admin\ProductController@deleteVariantImage');
  });
});

// sellers route staert here
Route::middleware('seller-language:web')->group(function () {
  Route::get('seller-login', 'App\Http\Controllers\Auth\LoginController@getSellersLoginView')->name('seller.login');
  Route::post('do-seller-login', 'App\Http\Controllers\Auth\LoginController@doSellerLogin');
  Route::group(['middleware' => ['auth:seller', 'seller']], function () {
    // Your route definitions here

    Route::get('/seller-dashboard', 'App\Http\Controllers\Sellers\DashboardController@index')->name('seller.dashboard');

    Route::get('/seller-profile', 'App\Http\Controllers\Sellers\DashboardController@sellersProfile');
    Route::post('sellers-logout', 'App\Http\Controllers\Sellers\DashboardController@logoutSellers')->name('seller.sellerslogout');
    Route::post('/sellers-update-profile', 'App\Http\Controllers\Sellers\DashboardController@updateSellersProfile');

    Route::get('/seller-orders-data', 'App\Http\Controllers\Sellers\OrdersController@sellergetOrderData');

    Route::get('/seller-revenue-data', 'App\Http\Controllers\Sellers\OrdersController@getRevenueData');

    /********************** sellers coupns Routing Starts Here **********************/

    Route::get('sellers-coupon', 'App\Http\Controllers\Sellers\CouponController@index');
    Route::post('sellers-save-coupon', 'App\Http\Controllers\Sellers\CouponController@store');

    Route::post('sellers-update-coupon', 'App\Http\Controllers\Sellers\CouponController@update');
    Route::get('sellers-delete-coupon/{id}', 'App\Http\Controllers\Sellers\CouponController@destroy');
    Route::get('sellers-update-coupon-column/{id}', 'App\Http\Controllers\Sellers\CouponController@updateColumn');

    /********************* sellers coupns Routing End Here **********************/

    /********************** sellers my-income  Routing Starts Here **********************/

    Route::get('my-income', 'App\Http\Controllers\Sellers\MyincomeController@index');
    Route::post('send-withdrawl-request', 'App\Http\Controllers\Sellers\MyincomeController@storerequest');
    Route::get('/delete-withdrawl-request/{id}', 'App\Http\Controllers\Sellers\MyincomeController@destroy');

    /********************* sellers my-income Routing End Here **********************/

    /***************** Setting Routing Starts Here ******************/
    Route::get('seller-setting', 'App\Http\Controllers\Sellers\SettingController@index');
    Route::post('seller-update-setting', 'App\Http\Controllers\Sellers\SettingController@update');
    Route::post('seller-country-change', 'App\Http\Controllers\Sellers\SettingController@countrychange');
    Route::post('/seller-state-change', 'App\Http\Controllers\Sellers\SettingController@statechange');
    Route::post('/seller-update-taxinfo', 'App\Http\Controllers\Sellers\SettingController@updatetaxinfo');
    Route::post('/seller-update-bankinfo', 'App\Http\Controllers\Sellers\SettingController@updatebankinfo');
    Route::get('/commission-history', 'App\Http\Controllers\Sellers\SettingController@commissionhistory');
    Route::get('seller-setlang', 'App\Http\Controllers\Sellers\SettingController@sellersetLanguage');
    /***************** Setting Routing End Here ********************/

    /************************* Sellers Product Routing  start Here ************************/
    Route::get('sellersproducts', 'App\Http\Controllers\Sellers\SellerproductController@index');

    Route::get('/sellers-product-create', 'App\Http\Controllers\Sellers\SellerproductController@sellerproduct_create');
    Route::post('sellers-product-store', 'App\Http\Controllers\Sellers\SellerproductController@sellerproductstore');
    Route::get('/sellers-edit-product/{id}', 'App\Http\Controllers\Sellers\SellerproductController@sellereditproduct');
    Route::post('sellerproductupdate', 'App\Http\Controllers\Sellers\SellerproductController@sellerproductupdate');
    Route::get('/update-product-column/{id}', 'App\Http\Controllers\Sellers\SellerproductController@sellersupdateColumn');

    Route::get('/sellers-FeaturedColumn/{id}', 'App\Http\Controllers\Sellers\SellerproductController@sellerupdateIsFeaturedColumn');

    Route::get('sellerexportAllOrders', 'App\Http\Controllers\Sellers\SellerproductController@sellerexportAllOrders')->name('sellerexportAllOrders');

    /************************* Sellers Product   Routing End Here ************************/

    /**********************Sellers  shipping price Routing Starts Here **********************/

    Route::get('sellers-shipping-rate-type', 'App\Http\Controllers\Sellers\ShippingController@shippingrate');
    Route::get('/seller-update-type-status/{id}', 'App\Http\Controllers\Sellers\ShippingController@updatestatus');
    Route::get('/sellers-shipping-rate/{id}', 'App\Http\Controllers\Sellers\ShippingController@shippingrates');
    Route::post('seller-shipping-rate-update', 'App\Http\Controllers\Sellers\ShippingController@shippingrateupdate');

    Route::get('/sellers-edit-shipping-rate/{type}', 'App\Http\Controllers\Sellers\ShippingController@editshippingrate');
    Route::post('/seller-update-for-shipping-city', 'App\Http\Controllers\Sellers\ShippingController@updateforshippingcity');
    Route::post('seller-addnewcity', 'App\Http\Controllers\Sellers\ShippingController@addnewcity');
    Route::post('seller-geteditcity', 'App\Http\Controllers\Sellers\ShippingController@geteditcity');
    Route::post('sellers-addnewstate', 'App\Http\Controllers\Sellers\ShippingController@addnewstate');
    Route::post('seller-geteditstate', 'App\Http\Controllers\Sellers\ShippingController@geteditstate');
    Route::post('update-for-shipping-state', 'App\Http\Controllers\Sellers\ShippingController@updateforshippingstate');

    /**********************Sellers shipping price Routing Starts Here **********************/

    /***************** sellers orders Routing Starts Here ******************/
    Route::get('seller-allorders', 'App\Http\Controllers\Sellers\OrdersController@index');

    Route::get('seller-orderDetails/{id}', 'App\Http\Controllers\Sellers\OrdersController@orderDetails');
    Route::get('seller-pending-order', 'App\Http\Controllers\Sellers\OrdersController@pendingorder');
    Route::get('seller-delivered-order', 'App\Http\Controllers\Sellers\OrdersController@deliveredorder');
    Route::get('seller-cancelled-order', 'App\Http\Controllers\Sellers\OrdersController@cancelledorder');
    Route::get('seller-refund-order', 'App\Http\Controllers\Sellers\OrdersController@refundorder');
    Route::get('/delete-delivered-order/{id}', 'App\Http\Controllers\Sellers\MyincomeController@deletedeliveredorder');

    /***************** sellers orders Routing End Here ********************/

    /***************** sellers Refund request Routing Starts Here ******************/
    Route::get('seller-refund-request', 'App\Http\Controllers\Sellers\RefundrequestController@index');
  });
});

/***************** sellers Refund request Routing Starts Here ******************/

Route::middleware('website-language:web')->group(function () {
  /********************** Frontend website  Routing Starts from Here **********************/
  Route::get('/', 'App\Http\Controllers\Website\HomeController@index');
  Route::get('index', 'App\Http\Controllers\Website\HomeController@index');

  Route::get('signup', 'App\Http\Controllers\Website\HomeController@userregister');
  Route::post('user-store', 'App\Http\Controllers\Website\HomeController@userstore');

  Route::get('login', 'App\Http\Controllers\Website\HomeController@userlogin')->name('user.login');
  Route::post('check-email', 'App\Http\Controllers\Website\HomeController@userauthenticate');
  Route::get('product-list-subcategory/{slug}', 'App\Http\Controllers\Website\HomeController@productlistviasubcategory');
  Route::get('product-list/{slug}', 'App\Http\Controllers\Website\HomeController@productlist');

  Route::get('productlist/{slug}', 'App\Http\Controllers\Website\HomeController@coustomproductlist');
  Route::get('product-details/{slug}', 'App\Http\Controllers\Website\HomeController@productdetails');

  Route::post('/chnage-product-variant', 'App\Http\Controllers\Website\HomeController@chnagevariant');
  Route::get('search-product', 'App\Http\Controllers\Website\HomeController@homepagefilter');

  /********************** cart Routing Starts from Here **********************/
  Route::post('add-to-cart', 'App\Http\Controllers\Website\HomeController@addCart');
  Route::get('cart', 'App\Http\Controllers\Website\HomeController@cartdetails');
  Route::post('featch-cart', 'App\Http\Controllers\Website\HomeController@cart_data');
  Route::post('update_Cart', 'App\Http\Controllers\Website\HomeController@updateCart');
  Route::post('removeCart', 'App\Http\Controllers\Website\HomeController@removeCart');
  Route::post('featch-cartnav', 'App\Http\Controllers\Website\HomeController@cart_datanav');
  Route::post('cartCount', 'App\Http\Controllers\Website\HomeController@cartCount');

  /********************** order place  Routing Starts from Here **********************/

  Route::get('checkout', 'App\Http\Controllers\Website\HomeController@checkout');
  Route::get('checkout/{slug}', 'App\Http\Controllers\Website\HomeController@buycheckout');
  Route::post('user-country-change', 'App\Http\Controllers\Website\HomeController@usercountrychange');
  Route::post('user-state-change', 'App\Http\Controllers\Website\HomeController@userstatechange');
  Route::post('getuserdatawithproduct', 'App\Http\Controllers\Website\HomeController@getuserdatawithproduct');
  Route::post('add-new-shipping-address', 'App\Http\Controllers\Website\HomeController@AddnewShippingAddress');
  Route::post('validate-quantity', 'App\Http\Controllers\Website\HomeController@validateQuantity');

  /********************** User Account  Routing Starts from Here **********************/
  Route::group(['middleware' => ['auth:customer', 'customer']], function () {
    Route::get('my-account', 'App\Http\Controllers\Website\HomeController@myaccount');
  });
  Route::post('update-my-account', 'App\Http\Controllers\Website\HomeController@userupdate');
  Route::get('edit-shipping-address/{id}', 'App\Http\Controllers\Website\HomeController@editshippingaddress');
  Route::get('delete-shipping-address/{id}', 'App\Http\Controllers\Website\HomeController@deleteshippingaddress');
  Route::post('update-shipping-address', 'App\Http\Controllers\Website\HomeController@UpdateShippingAddress');
  Route::post('user-logout', 'App\Http\Controllers\Website\HomeController@userlogout');
  Route::get('user-orderdetails/{id}', 'App\Http\Controllers\Website\HomeController@userorderdetails');

  /********************** Become a sellers   Routing Starts from Here **********************/

  Route::get('seller/signup', 'App\Http\Controllers\Website\HomeController@sellerregister');
  Route::post('store-sellers', 'App\Http\Controllers\Website\HomeController@storesellers');

  /********************** order Place   Routing Starts from Here **********************/

  Route::post('/create-cash-orders', 'App\Http\Controllers\Website\HomeController@placeOrders')->name('create.cash.order');
  Route::post('placeorderdirect', 'App\Http\Controllers\Website\HomeController@placeOrderdirect');
  Route::post('/create-razorpay-order', 'App\Http\Controllers\Website\HomeController@createRazorpayOrders')->name('create.razorpay.order');
  Route::post('/order-delete-cart', 'App\Http\Controllers\Website\HomeController@orderdeleteCart')->name('delete.ordercart');

  Route::post('/create-razorpay-single-order', 'App\Http\Controllers\Website\HomeController@createRazorpaysingleOrders')->name('create.razorpay.singleorder');
  Route::post('/update-payment-status', 'App\Http\Controllers\Website\HomeController@updatePaymentStatus')->name('update.payment.status');
  Route::post('create-payment-intent', 'App\Http\Controllers\Website\HomeController@createPaymentIntent');
  Route::get('checkout2', 'App\Http\Controllers\Website\HomeController@checkout2');

  Route::get('order-complete', 'App\Http\Controllers\Website\HomeController@ordercomplete');

  // Forgot password for user  start here
  Route::get('user-forgot-password', 'App\Http\Controllers\Auth\ForgotPasswordController@userforgotpassword');

  Route::post('user-do-forget-password', 'App\Http\Controllers\Auth\ForgotPasswordController@userforgetPasswordPost');

  Route::get('user-reset-password-show', 'App\Http\Controllers\Auth\ForgotPasswordController@user_reset_password');

  Route::post('douserresetpassword', 'App\Http\Controllers\Auth\ForgotPasswordController@userreset_PasswordPost');

  // Forgot password for user  end here

  Route::get('forgot-password', 'App\Http\Controllers\Auth\ForgotPasswordController@forgotpassword');
  Route::post('do-forget-password', 'App\Http\Controllers\Auth\ForgotPasswordController@forgetPasswordPost');
  Route::get('reset-password-show', 'App\Http\Controllers\Auth\ForgotPasswordController@resetpassword');

  Route::post('doresetpassword', 'App\Http\Controllers\Auth\ForgotPasswordController@reset_PasswordPost');

  // Forgot password for Admin/seller  end  here

  /********************** Wishlist Routing Starts Here **********************/

  Route::post('/save-wishlist', 'App\Http\Controllers\Website\HomeController@storewishlist');
  Route::post('wishCount', 'App\Http\Controllers\Website\HomeController@wishCount');
  Route::get('delete-wishlist/{id}', 'App\Http\Controllers\Website\HomeController@deletewishlist');

  /********************* Wishlist Routing End Here **********************/

  /********************** Review Routing Starts Here **********************/

  Route::post('/save-review', 'App\Http\Controllers\Website\HomeController@addReview');
  Route::post('wishCount', 'App\Http\Controllers\Website\HomeController@wishCount');
  Route::get('delete-wishlist/{id}', 'App\Http\Controllers\Website\HomeController@deletewishlist');

  /********************* Review Routing End Here **********************/

  /**********************Apply Coupns Routing Starts Here **********************/

  Route::post('/check-coupnscode', 'App\Http\Controllers\Website\HomeController@checkcoupnscode');

  Route::post('/check-coupnscode-single', 'App\Http\Controllers\Website\HomeController@singlecheckcoupnscode');

  /*********************Apply Coupns Routing End Here **********************/

  Route::get('/websitesetlang', 'App\Http\Controllers\Website\HomeController@setLanguage');

  Route::get('/{slug}', 'App\Http\Controllers\Website\HomeController@cmsPages')->name('cms.page');
});
