<?php

Route::get('/', function () {
    $towers = \App\Tower::count();
    return view('welcome', compact('towers'));
});

/*Route::get('test', function () {
  //return \App\Tower::with('apartments')->get();
});*/

/*Route::get('/profile', function () {
    return view('profile');
});

Route::get('/users/1', function () {
    return [
        'id' => 1,
        'name' => 'abalozz',
        'email' => 'abalozz@example.com',
    ];
});*/


Route::get('/select', 'HomeController@select');
Route::post('/select', ['as' => 'auth.select', 'uses' => 'HomeController@select_store'] );

Route::middleware(['auth'])->group(function () {

  Route::get('routeHome', function(){
		return redirect()->action('HomeController@index');
	})->name('routeHome');

  Route::get('admin/config/towers', ['as' => 'configTowersInitial', 'uses' => 'AdminConfigInitialController@index']);
  Route::post('registerTowers', ['as' => 'registerTowers', 'uses' => 'AdminConfigInitialController@storeTowers']);
  Route::get('admin/config/apartment-admin', ['as' => 'apartAdmin', 'uses' => 'AdminConfigInitialController@apartAdmin']);
  Route::post('registerApartAdmin', ['as' => 'registerApartAdmin', 'uses' => 'AdminConfigInitialController@registerApartAdmin']);

  Route::get('admin/config/payment-deadline-config', ['as' => 'config.initialPaymentDeadline', 'uses' => 'AdminConfigInitialController@initialPaymentDeadline']);

  Route::post('admin/payment-deadline-config/store', ['as' => 'config.storeMoorInterestConfigurationInitial', 'uses' => 'AdminConfigInitialController@storeMoorInterestConfigurationInitial']);

  Route::patch('admin/notifications/{id}', ['as' => 'notifications.read', 'uses' => 'NotificationsController@read']);
  Route::resource('admin/notifications', 'NotificationsController');


Route::name('admin.')->group(function () {
    Route::get('config/payment-deadline/config', ['as' => 'config.paymentDeadline', 'uses' => 'AdminConfigInitialController@paymentDeadline']);
    Route::post('config/payment-deadline/store', ['as' => 'config.storeMoorInterestConfiguration', 'uses' => 'AdminConfigInitialController@storeMoorInterestConfiguration']);

    Route::get('config/payment-deadline', ['as' => 'config.indexPayConfiguration', 'uses' => 'ArrearsInterestsController@index']);
    Route::get('config/payment-deadline/edit', ['as' => 'config.editPaymentDeadlineConfiguration', 'uses' => 'ArrearsInterestsController@edit']);
    Route::post('config/payment-deadline/update', ['as' => 'config.updatePaymentDeadlineConfiguration', 'uses' => 'AdminConfigInitialController@updatePaymentDeadline']);


    Route::resource('admin/towers', 'TowersController', ['except' => ['show']]);
    Route::get('admin/admins/type', ['as' => 'typeAdmin', 'uses' => 'AdminsController@type']);
    Route::get('admin/admins/extern', ['as' => 'externAdmin', 'uses' => 'AdminsController@extern']);
    Route::get('admin/admins/intern', ['as' => 'internAdmin', 'uses' => 'AdminsController@intern']);
    Route::resource('admin/admins', 'AdminsController', ['except' => ['show', 'create']]);
    Route::resource('admin/common-areas', 'CommonAreasController', ['except' => ['show']]);
    Route::match(['get', 'post'],'admin/apartments/apart-by-floor', 'ApartmentsController@createByfloor')->name('apartByFloor');
    Route::resource('admin/apartments', 'ApartmentsController', ['except' => ['show']]);
    Route::resource('admin/owners', 'OwnersController');
    Route::resource('admin/expenses', 'ExpenseController');
    Route::resource('admin/invoices', 'InvoiceController');
    Route::resource('admin/billing-notices', 'BillingNoticeController');
    Route::resource('admin/banks', 'BankController', ['except' => ['show']]);
    Route::resource('admin/banks-condominium', 'BankCondominiumController', ['except' => ['show']]);
    Route::resource('admin/ways-to-pay', 'WaysToPayController', ['except' => ['show']]);
    Route::resource('admin/news', 'NoticeController');
    Route::resource('admin/categories', 'CategoryController', ['except' => ['show']]);
    Route::get('admin/payments/confirm/{id}', ['as' => 'payments.confirm', 'uses' => 'PaymentController@confirm']);
    Route::get('admin/payments/unconfirmed', ['as' => 'payments.unconfirmed', 'uses' => 'PaymentController@unconfirmed']);
    Route::get('admin/payments/create/owner', ['as' => 'payments.createOwner', 'uses' => 'PaymentController@create_owner']);
    Route::post('admin/payments/create/', ['as' => 'payments.create', 'uses' => 'PaymentController@create']);
    Route::resource('admin/payments', 'PaymentController');
    Route::resource('admin/banks-condominium', 'BanksCondominiumController');
    Route::get('admin/statistics/date-range', ['as' => 'statistics.dateRange', 'uses' => 'StatisticsController@date_range']);
    Route::get('admin/statistics/type-expense', ['as' => 'statistics.typeExpense', 'uses' => 'StatisticsController@typeExpense']);
    Route::post('admin/statistics/graphic-expense', ['as' => 'statistics.graphicExpense', 'uses' => 'StatisticsController@graphicExpense']);
    Route::post('admin/statistics/graphic-range', ['as' => 'statistics.graphicRange', 'uses' => 'StatisticsController@graphicRange']);
    Route::resource('admin/statistics', 'StatisticsController');
    Route::get('admin/defaulters', ['as' => 'defaulters.index', 'uses' => 'DefaultersController@index']);
});

Route::name('owners.')->group(function ()
{
  Route::get('owners/', ['as' => 'owners.home', 'uses' => 'OwnersController@home']);
  Route::get('owners/edit-info', ['as' => 'owners.editInfo', 'uses' => 'OwnersController@editInfo']);
  Route::post('owners/store-info', ['as' => 'owners.storeInfo', 'uses' => 'OwnersController@storeInfo']);

  Route::get('owners/properties', ['as' => 'owners.properties', 'uses' => 'OwnersController@properties']);

  Route::get('owners/billing-notices/', ['as' => 'billing-notices.list', 'uses' => 'BillingNoticeController@list']);
  Route::get('owners/billing-notices/{id}/{apart}', ['as' => 'billing-notices.showFromOwner', 'uses' => 'BillingNoticeController@showFromOwner']);
  Route::get('owners/download-condo-receipt/{id}/{apart}', ['as' => 'pdf.condoReceipt', 'uses' => 'BillingNoticeController@pdfCondoReceipt']);

  Route::get('owners/billboard', ['as' => 'billboard.index', 'uses' => 'NoticeController@index_owner']);
  Route::get('owners/billboard/{id}', ['as' => 'billboard.show', 'uses' => 'NoticeController@show_owner']);

  Route::get('owners/payments', ['as' => 'payments.index', 'uses' => 'PaymentController@index_owner']);
  Route::post('owners/payments/store', ['as' => 'payments.store', 'uses' => 'PaymentController@store_owner']);
  Route::get('owners/payments/history', ['as' => 'payments.history', 'uses' => 'PaymentController@history_pays']);


});

});


