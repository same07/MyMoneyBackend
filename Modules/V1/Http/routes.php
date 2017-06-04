<?php

Route::group(['middleware' => 'web', 'prefix' => 'v1', 'namespace' => 'Modules\V1\Http\Controllers'], function()
{
    Route::get('/', 'V1Controller@index');

    Route::any('/revenue/load','V1Controller@revenueLoad');

    Route::any('/expenses/load','V1Controller@expensesLoad');

    Route::any('/transaction/view/{id}','V1Controller@TransactionsView');
    Route::any('/transaction/delete/{id}','V1Controller@TransactionsDelete');
    Route::any('/transaction/revenue/save','V1Controller@revenueStore');
    Route::any('/transaction/expenses/save','V1Controller@expensesStore');
    Route::any('/transaction/save','V1Controller@transactionSave');

    Route::any('/category/revenue/load','V1Controller@categoryRevenueLoad');
    Route::any('/category/expenses/load','V1Controller@categoryExpensesLoad');
    Route::any('/category/load','V1Controller@categoryLoad');
    Route::any('/category/view/{id}','V1Controller@categoryGet');
    Route::any('/category/delete/{id}','V1Controller@categoryDelete');
    Route::any('/category/save','V1Controller@categoryStore');
    
    Route::any('/uploadImage','V1Controller@uploadImage');


});
