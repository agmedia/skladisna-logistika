<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//
// Test routes
//
Route::get('/login-as', 'Front\HomeController@loginAs')->name('login.as');

/**
 * BACK routes.
 */
Auth::routes();

Route::middleware('auth', 'noCustomers')->group(function () {
    //
    // Admin Group
    Route::prefix('admin')->group(function () {
        //Dashboard
        Route::get('/dashboard', 'Back\DashboardController@index')->name('dashboard');
        Route::get('/dashboard/test', 'Back\DashboardController@test')->name('dashboard.test');
        Route::get('/dashboard/test2', 'Back\DashboardController@testTwo')->name('dashboard.test2');

        // CATALOG
        Route::prefix('catalog')->middleware('emptyClientData')->group(function () {
            // MANUFACTURERS
            Route::prefix('manufacturers')->middleware('emptyClientData')->group(function () {
                Route::get('/', 'Back\Catalog\ManufacturerController@index')->name('manufacturers');
                Route::get('create', 'Back\Catalog\ManufacturerController@create')->name('manufacturer.create');
                Route::post('/', 'Back\Catalog\ManufacturerController@store')->name('manufacturer.store');
                Route::get('{id}/edit', 'Back\Catalog\ManufacturerController@edit')->name('manufacturer.edit');
                Route::patch('{manufacturer}', 'Back\Catalog\ManufacturerController@update')->name('manufacturer.update');
            });
        });

        // Categories
        Route::get('categories', 'Back\CategoryController@index')->name('categories');
        Route::middleware('strike.editor')->group(function () {
            Route::get('category/create', 'Back\CategoryController@create')->name('category.create');
            Route::post('category', 'Back\CategoryController@store')->name('category.store');
            Route::get('category/{category}/edit', 'Back\CategoryController@edit')->name('category.edit');
            Route::patch('category/{category}', 'Back\CategoryController@update')->name('category.update');
        });
        // Products
        Route::prefix('products')->middleware('emptyClientData')->group(function () {
            Route::get('/', 'Back\ProductController@index')->name('products');
            Route::get('create', 'Back\ProductController@create')->name('product.create');
            Route::post('/', 'Back\ProductController@store')->name('product.store');
            Route::get('{id}/edit', 'Back\ProductController@edit')->name('product.edit');
            Route::get('{id}/edit/image', 'Back\ProductController@imageEdit')->name('product.edit.image');
            Route::patch('{product}', 'Back\ProductController@update')->name('product.update');
        });
        //
        // ORDERS Group
        Route::prefix('orders')->middleware('emptyClientData')->group(function () {
            // Orders
            Route::get('/', 'Back\Orders\OrderController@index')->name('orders');
            Route::get('create', 'Back\Orders\OrderController@create')->name('order.create');
            Route::post('/', 'Back\Orders\OrderController@store')->name('order.store');
            Route::get('show/{id}', 'Back\Orders\OrderController@show')->name('order.show');
            Route::get('{id}/edit', 'Back\Orders\OrderController@edit')->name('order.edit');
            Route::patch('{order}', 'Back\Orders\OrderController@update')->name('order.update');
            // Actions
            Route::get('transactions', 'Back\Orders\TransactionController@index')->name('transactions');
            Route::get('transaction/create', 'Back\Orders\TransactionController@create')->name('transaction.create');
            Route::post('transaction', 'Back\Orders\TransactionController@store')->name('transaction.store');
            Route::get('transaction/{id}/edit', 'Back\Orders\TransactionController@edit')->name('transaction.edit');
            Route::patch('transaction/{transaction}', 'Back\Orders\TransactionController@update')->name('transaction.update');
        });
        //
        // MARKETING Group
        Route::prefix('marketing')->middleware('emptyClientData')->group(function () {
            // Actions
            Route::get('actions', 'Back\Marketing\ActionController@index')->name('actions');
            Route::get('action/create', 'Back\Marketing\ActionController@create')->name('action.create');
            Route::post('action', 'Back\Marketing\ActionController@store')->name('action.store');
            Route::get('action/{id}/edit', 'Back\Marketing\ActionController@edit')->name('action.edit');
            Route::patch('action/{action}', 'Back\Marketing\ActionController@update')->name('action.update');
            // Sliders
            /*Route::get('sliders', 'Back\Marketing\SliderController@index')->name('sliders');
            Route::get('slider/create', 'Back\Marketing\SliderController@create')->name('slider.create');
            Route::post('slider', 'Back\Marketing\SliderController@store')->name('slider.store');
            Route::get('slider/{id}/edit', 'Back\Marketing\SliderController@edit')->name('slider.edit');
            Route::patch('slider/{id}', 'Back\Marketing\SliderController@update')->name('slider.update');
            Route::get('slider/{id}/edit/sliders', 'Back\Marketing\SliderController@editSliders')->name('slider.edit.sliders');*/
            // Blogs
            Route::get('/news', 'Back\Marketing\BlogController@index')->name('blogs');
            Route::get('/news/create', 'Back\Marketing\BlogController@create')->name('blog.create');
            Route::post('/news', 'Back\Marketing\BlogController@store')->name('blog.store');
            Route::get('/news/{blog}/edit', 'Back\Marketing\BlogController@edit')->name('blog.edit');
            Route::patch('news/{blog}', 'Back\Marketing\BlogController@update')->name('blog.update');
            // Landings
            Route::prefix('landing')->group(function () {
                Route::get('/', 'Back\Marketing\LandingController@index')->name('landings');
                Route::get('create', 'Back\Marketing\LandingController@create')->name('landing.create');
                Route::post('/', 'Back\Marketing\LandingController@store')->name('landing.store');
                Route::get('{landing}/edit', 'Back\Marketing\LandingController@edit')->name('landing.edit');
                Route::patch('{landing}', 'Back\Marketing\LandingController@update')->name('landing.update');
            });
        });
        //
        // USERS Group
        Route::prefix('users')->middleware('emptyClientData')->group(function () {
            // Users
            Route::get('users', 'Back\Users\UserController@index')->name('users');
            Route::get('user/create', 'Back\Users\UserController@create')->name('user.create');
            Route::post('user', 'Back\Users\UserController@store')->name('user.store');
            Route::get('user/{id}', 'Back\Users\UserController@show')->name('user.show');
            Route::get('user/{id}/edit', 'Back\Users\UserController@edit')->name('user.edit');
            Route::patch('user/{user}', 'Back\Users\UserController@update')->name('user.update');
            Route::get('user/{id}/edit/users', 'Back\Users\UserController@editSliders')->name('user.edit.users');
            // Clients
            Route::get('clients', 'Back\Users\ClientController@index')->name('clients');
            Route::get('client/create', 'Back\Users\ClientController@create')->name('client.create');
            Route::post('client', 'Back\Users\ClientController@store')->name('client.store');
            Route::get('client/{id}/edit', 'Back\Users\ClientController@edit')->name('client.edit');
            Route::patch('client/{client}', 'Back\Users\ClientController@update')->name('client.update');
            // Messages
            Route::get('messages', 'Back\Users\MessageController@index')->name('messages');
            Route::get('message/create', 'Back\Users\MessageController@create')->name('message.create');
            Route::post('message', 'Back\Users\MessageController@send')->name('message.send');
            Route::get('message/{message}/edit', 'Back\Users\MessageController@edit')->name('message.edit');
        });
        //
        // SETTINGS Group
        Route::prefix('settings')->group(function () {
            // STORE SETTINGS
            Route::prefix('store')->group(function () {
                // GEO ZONES
                Route::get('geo-zones', 'Back\Settings\Store\GeoZoneController@index')->name('geo-zones');
                // ORDER STATUSES
                Route::get('order-status', 'Back\Settings\Store\OrderStatusController@index')->name('order-status');
                // PAYMENTS
                Route::get('payments', 'Back\Settings\Store\PaymentController@index')->name('payments');
                // SHIPMENTS
                Route::get('shipments', 'Back\Settings\Store\ShipmentController@index')->name('shipments');
                // TAXES
                Route::get('taxes', 'Back\Settings\Store\TaxController@index')->name('taxes');
                // TOTALS
                Route::get('totals', 'Back\Settings\Store\TotalController@index')->name('totals');
            });
            // Profile
            Route::get('profile', 'Back\Settings\ProfileController@index')->name('profile');
            Route::patch('profile/{profile}', 'Back\Settings\ProfileController@update')->name('profile.update');
            //Route::post('profile/store/client', 'Back\Settings\ProfileController@storeClient')->name('profile.client.store');
            Route::patch('profile/client/{client}', 'Back\Settings\ProfileController@updateClient')->name('profile.client.update');
            // Pages
            Route::get('pages', 'Back\Settings\PageController@index')->name('pages');
            Route::get('page/create', 'Back\Settings\PageController@create')->name('page.create');
            Route::post('page', 'Back\Settings\PageController@store')->name('page.store');
            Route::get('page/{id}/edit', 'Back\Settings\PageController@edit')->name('page.edit');
            Route::patch('page/{page}', 'Back\Settings\PageController@update')->name('page.update');
            // Pages
            Route::get('plans', 'Back\Settings\PlanController@index')->name('plans');
            Route::get('plan/create', 'Back\Settings\PlanController@create')->name('plan.create');
            Route::post('plan', 'Back\Settings\PlanController@store')->name('plan.store');
            Route::get('plan/{plan}/edit', 'Back\Settings\PlanController@edit')->name('plan.edit');
            Route::patch('plan/{plan}', 'Back\Settings\PlanController@update')->name('plan.update');
        });
        //
        // Back API routes.
        Route::prefix('apiv1')->group(function () {
            // Products
            Route::prefix('products')->group(function () {
                Route::post('save-block', 'Back\Api1\ProductController@saveBlock')->name('product.save.block');
                Route::post('destroy-block', 'Back\Api1\ProductController@destroyBlock')->name('product.destroy.block');
                Route::post('destroy-image', 'Back\Api1\ProductController@destroyImage')->name('product.destroy.image');
            });
            // Products
            Route::prefix('landing')->group(function () {
                Route::get('get-section3', 'Back\Api1\LandingController@getSectionBlock')->name('landing.get.section3');
            });
            // Delete routes (javascript POST)
            Route::post('category/destroy', 'Back\CategoryController@destroy')->name('category.destroy');
            Route::post('product/destroy', 'Back\ProductController@destroy')->name('product.destroy');
            Route::post('manufacturer/destroy', 'Back\Catalog\ManufacturerController@destroy')->name('manufacturer.destroy');
            Route::post('order/destroy', 'Back\Orders\OrderController@destroy')->name('order.destroy');
            Route::post('action/destroy', 'Back\Marketing\ActionController@destroy')->name('action.destroy');
            Route::post('blog/destroy', 'Back\Marketing\BlogController@destroy')->name('blog.destroy');
            Route::post('landing/destroy', 'Back\Marketing\LandingController@destroy')->name('landing.destroy');
            Route::post('landing/destroy/doc', 'Back\Marketing\LandingController@destroyDoc')->name('landing.destroy.doc');
            Route::post('slider/destroy', 'Back\Marketing\SliderController@destroy')->name('slider.destroy');
            Route::post('user/destroy', 'Back\Users\UserController@destroy')->name('user.destroy');
            Route::post('client/destroy', 'Back\Users\ClientController@destroy')->name('client.destroy');
            Route::post('page/destroy', 'Back\Settings\PageController@destroy')->name('page.destroy');
            Route::post('plan/destroy', 'Back\Settings\PlanController@destroy')->name('plan.destroy');
            // Autocomplete and Autosuggestion routes
            Route::get('/products/autocomplete', 'Back\Api1\ProductController@autocomplete')->name('products.autocomplete');
            Route::get('/users/autocomplete', 'Back\Api1\UserController@autocomplete')->name('users.autocomplete');
            // Sliders
            Route::get('/sliders/{group}/get', 'Back\Api1\SliderController@get')->name('api.sliders.get');
            Route::post('/sliders/store', 'Back\Api1\SliderController@store')->name('api.sliders.store');
            // Notifications
            Route::post('notifications/read', 'Back\Api1\UserController@notificationsRead')->name('notifications.read');
            // Charts
            Route::prefix('chart')->group(function () {
                Route::post('orders/bar', 'Back\Api1\ChartController@orders')->name('chart.bar.orders');
                Route::post('products/bar/horizontal', 'Back\Api1\ChartController@products')->name('chart.bar.products');
                Route::post('orders/pie/status', 'Back\Api1\ChartController@ordersStatus')->name('chart.pie.order.status');
                Route::get('stats/totals', 'Back\Api1\ChartController@totals')->name('stats.total');
            });
            // Clear Cache
            Route::prefix('cache')->group(function () {
                Route::get('/', 'Back\Api1\SettingController@cache')->name('cache');
                Route::get('config', 'Back\Api1\SettingController@clearConfigCache')->name('config.clear');
                Route::get('views', 'Back\Api1\SettingController@clearViewsCache')->name('views.clear');
                Route::get('routes', 'Back\Api1\SettingController@clearRoutesCache')->name('routes.clear');
            });
            // Maintenance Mode
            Route::prefix('maintenance')->group(function () {
                Route::get('on', 'Back\Api1\SettingController@maintenanceModeON')->name('maintenance.on');
                Route::get('off', 'Back\Api1\SettingController@maintenanceModeOFF')->name('maintenance.off');
            });
            // SETTINGS
            Route::prefix('settings')->group(function () {
                // STORE SETTINGS
                Route::prefix('store')->group(function () {
                    // GEO ZONE
                    Route::prefix('geo-zone')->group(function () {
                        Route::post('get-state-zones', 'Back\Settings\Store\GeoZoneController@getStateZones')->name('geo-zone.get-state-zones');
                        Route::post('store', 'Back\Settings\Store\GeoZoneController@store')->name('geo-zone.store');
                        Route::post('destroy', 'Back\Settings\Store\GeoZoneController@destroy')->name('geo-zone.destroy');
                    });
                    // ORDER STATUS
                    Route::prefix('order-status')->group(function () {
                        Route::post('store', 'Back\Settings\Store\OrderStatusController@store')->name('order-status.store');
                        Route::post('destroy', 'Back\Settings\Store\OrderStatusController@destroy')->name('order-status.destroy');
                    });
                    // PAYMENTS
                    Route::prefix('payment')->group(function () {
                        Route::post('store', 'Back\Settings\Store\PaymentController@store')->name('payment.store');
                        Route::post('destroy', 'Back\Settings\Store\PaymentController@destroy')->name('payment.destroy');
                    });
                    // SHIPMENTS
                    Route::prefix('shipment')->group(function () {
                        Route::post('store', 'Back\Settings\Store\ShipmentController@store')->name('shipment.store');
                        Route::post('destroy', 'Back\Settings\Store\ShipmentController@destroy')->name('shipment.destroy');
                    });
                    // TAXES
                    Route::prefix('taxes')->group(function () {
                        Route::post('store', 'Back\Settings\Store\TaxController@store')->name('taxes.store');
                        Route::post('destroy', 'Back\Settings\Store\TaxController@destroy')->name('taxes.destroy');
                    });
                    // TOTALS
                    Route::prefix('totals')->group(function () {
                        Route::post('store', 'Back\Settings\Store\TotalController@store')->name('totals.store');
                        Route::post('destroy', 'Back\Settings\Store\TotalController@destroy')->name('totals.destroy');
                    });
                });
                // Maintenance Mode
                Route::get('on', 'Back\Api1\SettingController@sidebarInverseToggle')->name('sidebar.inverse.toggle');
            });
            // Images Upload
            Route::prefix('images')->group(function () {
                Route::post('/upload/temporary', 'Back\Api1\ImagesController@imagesUploadTemporary')->name('images.upload.temp');
                Route::post('/upload', 'Back\Api1\ImagesController@imagesUpload')->name('images.upload');
                Route::post('/upload/ajax', 'Back\Api1\ImagesController@imagesAjaxUpload')->name('images.ajax.upload');
                Route::post('/upload/edited', 'Back\Api1\ImagesController@imagesUploadEdited')->name('images.upload.edited');
                Route::post('/destroy', 'Back\Api1\ImagesController@destroy')->name('images.destroy');
                Route::post('/set/default', 'Back\Api1\ImagesController@setDefault')->name('images.set.default');
            });
        });
    });


});

//
// FRONT API routes
//
Route::prefix('api/v1')->group(function () {
    Route::get('/user', 'Api\v1\CartController@getUser')->name('api.user');
    Route::get('/product/{id}', 'Api\v1\CartController@getProduct')->name('api.product');
    Route::get('/users/autocomplete', 'Api\v1\UserController@autocomplete')->name('api.vendor.autocomplete');

    // TESTING
    Route::prefix('tests')->group(function () {
        Route::get('/order/{id?}', 'Back\TestController@index')->name('tests');
    });

    Route::prefix('cart')->group(function () {
        Route::get('/get', 'Api\v1\CartController@get')->name('api.cart.get');
        Route::post('/add', 'Api\v1\CartController@add')->name('api.cart.add');
        Route::post('/update/{id}', 'Api\v1\CartController@update')->name('api.cart.update');
        Route::get('/remove/{id}', 'Api\v1\CartController@remove')->name('api.cart.remove');
        Route::post('/sync', 'Api\v1\CartController@sync')->name('api.cart.sync');
        Route::get('clients/data', 'Api\v1\CartController@clientData')->name('api.cart.client.data');
    });

    Route::get('/newsletter-subscribe', 'Api\v1\NewsletterController@subscribe')->name('newsletter.subscribe');

    Route::get('trazi', 'Api\v1\SearchController@index')->name('api.search');
});

Route::prefix('api/v2')->group(function () {
    Route::prefix('cart')->group(function () {
        Route::get('/get', 'Api\v2\CartController@get');
        Route::post('/add', 'Api\v2\CartController@add');
        Route::post('/update/{id}', 'Api\v2\CartController@update');
        Route::get('/remove/{id}', 'Api\v2\CartController@remove');
        Route::get('/coupon/{coupon}', 'Api\v2\CartController@coupon');;
    });
});

Route::get('pretraga', 'Api\v1\SearchController@all')->name('search.all');

/*******************************************************************************
*                                Copyright : AGmedia                           *
*                              email: filip@agmedia.hr                         *
*******************************************************************************/
//
// FRONT routes
//
Route::get('/', 'Front\HomeController@home')->name('index');
Route::get('info/{page}', 'Front\HomeController@page')->name('info.page');
Route::get('info/o-nama', 'Front\HomeController@page')->name('o-nama');
Route::get('info/servis-vilicara', 'Front\HomeController@page')->name('servis');
Route::get('access/vip/{landing}', 'Front\LandingController@index')->name('landing');
Route::get('tal/{page?}', 'Front\HomeController@tal')->name('tal');
//
Route::get('kontakt', 'Front\HomeController@contact')->name('kontakt');
Route::post('kontakt-poruka', 'Front\HomeController@message')->name('kontakt.form');
//
Route::get('blogs/{cat}/{subcat?}/{page?}', 'Front\BlogController@index')->name('blogovi');
//
Route::get('toyota-vilicari', 'Front\CategoryController@toyota')->name('toyota-vilicari');
//
Route::get('{group}/{cat?}/{subcat?}', 'Front\CategoryController@index')->name('kategorija');
//
Route::get('toyota-vilicari/{cat?}/{subcat?}/{prod?}', 'Front\ProductController@index')->name('proizvod');
/**
 * Postavke računa korisnika.
 */
Route::get('moj-racun', 'Front\CustomerController@index')->name('moj');
Route::get('moj-racun/narudzbe', 'Front\CustomerController@orders')->name('moj.narudzbe');
Route::get('moj-racun/narudzba/{order}', 'Front\CustomerController@viewOrder')->name('moj.narudzba');
Route::get('moj-racun/narudzba/ponovi/{order}', 'Front\CustomerController@repeatOrder')->name('moj.narudzba.ponovi');
Route::get('moj-racun/narudzba/ispis/{order}', 'Front\CustomerController@printOrder')->name('moj.narudzba.ispis');
Route::get('moj-racun/servis', 'Front\CustomerController@service')->name('moj.servis');
Route::get('moj-racun/poruke', 'Front\CustomerController@messages')->name('moj.poruke');
Route::get('moj-racun/poruka/nova/{subject?}', 'Front\CustomerController@newMessage')->name('moj.poruka.nova');
Route::get('moj-racun/poruka/{message}', 'Front\CustomerController@viewMessage')->name('moj.poruka');
Route::post('moj-racun/poruka', 'Front\CustomerController@sendMessage')->name('moj.poruka.salji');
Route::get('moj-racun/postavke', 'Front\CustomerController@settings')->name('moj.postavke');
Route::post('moj-racun/postavke/promjeni', 'Front\CustomerController@updateAccount')->name('moj.postavke.promijeni');
/**
 * Cart and checkout controllers.
 * Together with cart API endpoints.
 */
Route::get('kosarica', 'Front\CartController@index')->name('kosarica');
Route::get('kosarica/naplata', 'Front\CartController@checkout')->name('naplata');
Route::post('kosarica/naplata', 'Front\CheckoutController@proccessOrder')->name('napravi.narudzbu');
Route::get('kosarica/success', 'Front\CheckoutController@success')->name('narudzba.ok');
Route::get('kosarica/error', 'Front\CheckoutController@error')->name('narudzba.error');
/*
 * Front TEST routes.
 */
Route::prefix('temp')->group(function () {
    Route::get('/customer/dashboard', 'Back\DashboardController@tempCustomerDashboard')->name('customer.dashboard');
});


