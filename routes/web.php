<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});



// Route::get('/customer', function () {
//     return view('customer.index');
// });

//customer

 Route::group(['middleware' => 'role:employee,admin'], function() {
Route::get('/customer', 'CustomerController@index')->name('customer');
Route::get('/customer/edit/{id}', 'CustomerController@edit')->name('customer.edit');
Route::delete('/customer/destroy/{id}', 'CustomerController@destroy')->name('customer.destroy');
Route::post('/customer/store', 'CustomerController@store')->name('customer.store');
Route::post('/customer/update/{id}', 'CustomerController@update')->name('customer.update');
Route::post('/customer/import', 'CustomerController@import')->name('customerImport');
Route::get('/customer/register', 'CustomerController@register')->name('customer.register');



Route::get('/allpets', 'PetController@allpets')->name('pets.all');
//pet



Route::get('/employee', 'EmployeeController@index')->name('employee');
Route::get('/employee/edit/{id}', 'EmployeeController@edit')->name('employee.edit');
Route::delete('/employee/destroy/{id}', 'employeeController@destroy')->name('employee.destroy');
Route::post('/employee/store', 'employeeController@store')->name('employee.store');
Route::post('/employee/update/{id}', 'employeeController@update')->name('employee.update');
Route::post('/employee/import', 'employeeController@import')->name('employeeImport');




Route::get('/employee/admin/edit/{id}', 'EmployeeController@adminedit')->name('employee.admin/edit');
Route::post('/employee/admin/update/{id}', 'employeeController@adminupdate')->name('employee.admin/update');



Route::get('/services', 'serviceController@index')->name('service');
Route::get('/service/edit/{id}', 'serviceController@edit')->name('service.edit');
Route::post('/service/destroy/{id}', 'serviceController@destroy')->name('service.destroy');
Route::post('/service/store', 'serviceController@store')->name('service.store');
Route::post('/service/update/{id}', 'serviceController@update')->name('service.update');
Route::post('/service/import', 'serviceController@import')->name('serviceImport');

});

Route::group(['middleware' => 'role:customer'], function() {
Route::get('/pet', 'PetController@index')->name('pet');
Route::get('/pet/edit/{id}', 'PetController@edit')->name('pet.edit');
Route::post('/pet/destroy/{id}', 'PetController@destroy')->name('pet.destroy');
Route::post('/pet/store', 'petController@store')->name('pet.store');
Route::post('/pet/update/{id}', 'petController@update')->name('pet.update');


});

Route::post('/pet/import', 'PetController@import')->name('petImport');

Route::get('/consultation', 'consultationController@index')->name('consultation');

Route::post('/postconsult', 'consultationController@store')->name('postconsult');


 Route::group(['middleware' => 'role:admin'], function() {
Route::get('/employee/admin', 'EmployeeController@admin')->name('employee.admin');
Route::get('/customer/admin', 'CustomerController@admin')->name('customer.admin');
Route::post('/customer/restore/{id}', 'CustomerController@restore')->name('customer.restore');





 Route::get('transactions', [
        'uses' => 'TransactController@transaction',
        'as' => 'transact.transaction']);
});


 Route::get('profile/{id}', 'App\Http\Controllers\CustomerController@customerprofile')->name('profile');
Route::post('profile/update/{id}', 'App\Http\Controllers\CustomerController@profileupdate')->name('profile.update');
Route::get('/signup', [
        'uses' => 'loginController@getSignup',
        'as' => 'login.signup',
        
    ]);
    Route::post('/signup', [
        'uses' => 'loginController@postSignup',
        'as' => 'login.signup1',
        
    ]);

    Route::get('profile', [
        'uses' => 'loginController@getProfile',
        'as' => 'login.profile',
    ]);

    Route::get('/signin', [
        'uses' => 'loginController@getSignin',
        'as' => 'login.signin'
        
    ]);

    Route::post('/signin', [
        'uses' => 'loginController@postSignin',
        'as' => 'login.signin1'
        
    ]);

    Route::get('logout', [
        'uses' => 'loginController@getLogout',
        'as' => 'login.logout'
        
    ]);






   






       Route::get('comment', [
        'uses' => 'CommentController@index',
        'as' => 'comment.create']);


       Route::get('comment/service/{id}', [
        'uses' => 'CommentController@comment',
        'as' => 'comment.comment']);

      Route::post('comment/store', [
        'uses' => 'CommentController@store',
        'as' => 'comment.store']);





      Route::get('/diseasechart', [
      'uses' => 'DiseaseDashController@index',
       'as' => 'dashboard.disease'
            ]);


      Route::get('/groomingchart', [
      'uses' => 'GroomDashController@index',
       'as' => 'dashboard.grooming'
            ]);


      Route::post('/groomingcharttime', [
      'uses' => 'GroomDashController@timepick',
       'as' => 'dashboard.groomingtimepick'
            ]);



      //Transaction


     Route::get('shopping-cart', [
    'uses' => 'TransactController@getCart',
    'as' => 'item.shoppingCart'
    ]);

Route::group(['middleware' => 'role:customer'], function() {
    Route::post('checkout',[
        'uses' => 'TransactController@postCheckout',
        'as' => 'checkout',
        'middleware' =>'auth'
    ]);

    });

    Route::get('add-to-cart/{id}',[
        'uses' => 'TransactController@getAddToCart',
        'as' => 'item.addToCart'
    ]);


    Route::get('remove/{id}',[
        'uses'=>'TransactController@getRemoveItem',
        'as' => 'item.remove'
    ]);

    
     Route::get('/grooms', [
      'uses' => 'TransactController@Index',
            'as' => 'Item.index'
    ]);


    Route::get('/choosepet', [
      'uses' => 'TransactController@pets',
            'as' => 'Item.pets'
    ]);


    //  Route::get('/receipt', [
    //   'uses' => 'TransactController@receipt',
    //         'as' => 'Item.receipt'
    // ]);



      Route::get('/receipt', [
      'uses' => 'TransactController@downloadPDF',
            'as' => 'Item.receipt'
    ]); 



      


       Route::get('transactions/{id}', [
        'uses' => 'TransactController@transactionedit',
        'as' => 'transact.transactionedit']);


       Route::post('transactions/update/{id}', [
        'uses' => 'TransactController@transactionupdate',
        'as' => 'transaction.update']);

Route::get('/registeremp', 'EmployeeController@register')->name('employee.register');
Route::post('/employee/postregister', 'EmployeeController@postregister')->name('employee.postregister');


 Route::get('search/customerhistory', [
        'uses' => 'SearchCustomerController@index',
        'as' => 'customer.show'
        
    ]);

    Route::get('search/result', [
        'uses' => 'SearchCustomerController@search',
        'as' => 'customer.result'
        
    ]);


     Route::get('search/pethistory', [
        'uses' => 'SearchPetController@index',
        'as' => 'pet.show'
        
    ]);

      Route::get('pet/petresult', [
        'uses' => 'SearchPetController@search',
        'as' => 'pet.result'
        
    ]);


    Route::get('/petshow/{id}', [
      'uses' => 'App\Http\Controllers\SearchPetController@show',
       'as' => 'petshow'
    ]);


    Route::get('/customershow/{id}', [
      'uses' => 'App\Http\Controllers\SearchCustomerController@show',
       'as' => 'customershow'
    ]);