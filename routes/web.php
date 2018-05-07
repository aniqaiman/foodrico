<?php

/*
|-----------------------------------------------------------------
| Web Routes
|-----------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', ['as' => 'welcome', 'uses' =>
    function () {
        return view('welcome');
    }]);

// ------------------------------------------- Dashboard ------------------------------------------- //

Route::post('dashboard', ['as' => 'createDashboard', 'uses' => 'DashboardController@createServiceDashboard']);
Route::get('dashboard', ['as' => 'dashboard', 'uses' =>
    'DashboardController@getDashboard']);

// ------------------------------------------- User ------------------------------------------- //

Route::prefix('users')
    ->name('users.')
    ->group(function () {

        Route::get('{user_id}', 'UserController@getUser')->name('json');
        
        // ------------------------------------------- Driver ------------------------------------------- //

        Route::get('drivers', 'DriverController@index')->name('drivers.index');
        Route::post('drivers', 'DriverController@store')->name('drivers.store');
        Route::get('drivers/{user_id}', 'DriverController@show')->name('drivers.show');
        Route::put('drivers/{user_id}', 'DriverController@update')->name('drivers.update');
        Route::delete('drivers/{user_id}', 'DriverController@destroy')->name('drivers.destroy');
        Route::get('drivers/{user_id}/edit', 'DriverController@edit')->name('drivers.edit');

        // ------------------------------------------- Seller ------------------------------------------- //

        Route::get('sellers', 'SellerController@index')->name('sellers.index');
        Route::post('sellers', 'SellerController@store')->name('sellers.store');
        Route::get('sellers/{user_id}', 'SellerController@show')->name('sellers.show');
        Route::put('sellers/{user_id}', 'SellerController@update')->name('sellers.update');
        Route::delete('sellers/{user_id}', 'SellerController@destroy')->name('sellers.destroy');
        Route::get('sellers/{user_id}/edit', 'SellerController@edit')->name('sellers.edit');

        // ------------------------------------------- Buyer ------------------------------------------- //

        Route::get('buyers', 'BuyerController@index')->name('buyers.index');
        Route::post('buyers', 'BuyerController@store')->name('buyers.store');
        Route::put('buyers/{user_id}', 'BuyerController@update')->name('buyers.update');
        Route::delete('buyers/{user_id}', 'BuyerController@destroy')->name('buyers.destroy');
        Route::get('buyers/{user_id}/edit', 'BuyerController@edit')->name('buyers.edit');

    });

// ------------------------------------------- Price ------------------------------------------- //

Route::post('fruit/{product_id}/price/add', ['as' => 'createFruitPrice', 'uses' => 'PriceController@createFruitPrice']);
Route::get('fruit/{product_id}/detail', ['as' => 'getFruitDetail', 'uses' => 'PriceController@getFruitDetail']);
Route::get('fruit/{product_id}/editFruitPrice/{price_id}', ['as' => 'editFruitPrice', 'uses' => 'PriceController@editFruitPrice']);
Route::post('updateFruitPrice', ['as' => 'updateFruitPrice', 'uses' => 'PriceController@updateFruitPrice']);
Route::delete('fruitprice/{price_id}', ['as' => 'deleteFruitPrice', 'uses' => 'PriceController@deleteFruitPrice']);

// ------------------------------------------- Detail Fruit ------------------------------------------- //

Route::post('vege/{product_id}/price/add', ['as' => 'createVegePrice', 'uses' => 'PriceController@createVegePrice']);
Route::get('vege/{product_id}/detail', ['as' => 'getVegeDetail', 'uses' => 'PriceController@getVegeDetail']);
Route::get('vege/{product_id}/editVegePrice/{price_id}', ['as' => 'editVegePrice', 'uses' => 'PriceController@editVegePrice']);
Route::post('updateVegePrice', ['as' => 'updateVegePrice', 'uses' => 'PriceController@updateVegePrice']);
Route::delete('vegeprice', ['as' => 'deleteVegePrice', 'uses' => 'PriceController@deleteVegePrice']);

Route::prefix('orders')
    ->name('orders.')
    ->group(function () {

        // ------------------------------------------- Order ------------------------------------------- //

        Route::get('receipts', 'OrderController@indexOrderReceipts')->name('index.receipts');
        Route::get('trackings', 'OrderController@indexOrderTrackings')->name('index.trackings');
        Route::get('rejects', 'OrderController@indexOrderRejects')->name('index.rejects');
        Route::get('transactions', 'OrderController@indexOrderTransactions')->name('index.transactions');

        Route::post('', 'OrderController@store')->name('store');
        Route::put('{order_id}', 'OrderController@update')->name('update');
        Route::get('{order_id}', 'OrderController@edit')->name('edit');
        Route::delete('{order_id}', 'OrderController@destroy')->name('destroy');

        Route::put('buyers/approve', 'OrderController@updateApproveBuyerOrder')->name('update.status.buyers.approve');
        Route::put('buyers/reject', 'OrderController@updateRejectBuyerOrder')->name('update.status.buyers.reject');

        Route::put('sellers/approve', 'OrderController@updateApproveSellerStock')->name('update.status.sellers.approve');
        Route::put('sellers/reject', 'OrderController@updateRejectSellerStock')->name('update.status.sellers.reject');

        Route::put('pending', 'OrderController@updatePendingOrderStock')->name('update.status.pending');
        Route::put('complete', 'OrderController@updateCompleteOrderStock')->name('update.status.complete');
    
    });

Route::prefix('products')
    ->name('products.')
    ->group(function () {

        // ------------------------------------------- Vegetable ------------------------------------------- //

        Route::post('vegetables', 'VegetableController@store')->name('vegetables.store');
        Route::get('vegetables', 'VegetableController@index')->name('vegetables.index');
        Route::put('vegetables/{product_id}', 'VegetableController@update')->name('vegetables.update');
        Route::delete('vegetables/{product_id}', 'VegetableController@destroy')->name('vegetables.destroy');
        Route::get('vegetables/{product_id}/edit', 'VegetableController@edit')->name('vegetables.edit');

        // ------------------------------------------- Fruit ------------------------------------------- //

        Route::post('fruits', 'FruitController@store')->name('fruits.store');
        Route::get('fruits', 'FruitController@index')->name('fruits.index');
        Route::put('fruits/{product_id}', 'FruitController@update')->name('fruits.update');
        Route::delete('fruits/{product_id}', 'FruitController@destroy')->name('fruits.destroy');
        Route::get('fruits/{product_id}/edit', 'FruitController@edit')->name('fruits.edit');

    });

// ------------------------------------------- Others ------------------------------------------- //

Route::post('send', 'EmailController@send');
Route::get('playground', 'ApiController@playground');
