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

Route::group([ 'namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin-panel' ], function(){
  Route::group(['middleware' => ['limitReq']], function(){
          
      // login routes
      Route::get('/', 'AuthController@login'); 
      Route::get('login', 'AuthController@login')->name('admin/login');
      Route::post('login', 'AuthController@check_login')->name('admin/check-login');
      
      Route::group(['middleware' => ['adminLogin']],function(){

          Route::get('get/users', 'HomeController@users')->name('get/users');
          Route::get('get/countries', 'HomeController@countries')->name('get/countries');
          Route::get('get/categories', 'HomeController@categories')->name('get/categories');
          
          Route::get('/home', 'HomeController@home')->name('admin/index');
          Route::get('logout', 'AuthController@logout')->name('admin/logout');

          // admin routes
          Route::get('admins/info', 'AdminController@info')->name('admin/admins/info');
          Route::post('admins/info-update', 'AdminController@info_update')->name('admin/admins/info-update');
          Route::post('admins/change-password', 'AdminController@change_password')->name('admin/admins/change-password');
          
          Route::get('admins/index/{offset?}/{limit?}', 'AdminController@index')->name('admin/admins/index');
          Route::get('admins/create', 'AdminController@create')->name('admin/admins/create');
          Route::post('admins/create', 'AdminController@store')->name('admin/admins/store');
          Route::get('admins/activate', 'AdminController@activate')->name('admin/admins/activate');
          Route::get('admins/delete', 'AdminController@delete')->name('admin/admins/delete');
          Route::post('admins/pagination/{offset?}/{limit?}', 'AdminController@pagination')->name('admin/admins/pagination');
          Route::post('admins/search', 'AdminController@search')->name('admin/admins/search');
          Route::post('admins/search/byColumn', 'AdminController@searchByColumn')->name('admin/admins/search/byColumn'); 
          Route::get('admins/archives/{offset?}/{limit?}', 'AdminController@archives')->name('admin/admins/archives');
          Route::get('admins/back', 'AdminController@back')->name('admin/admins/back');
          Route::post('admins/pagination/archives/{offset?}/{limit?}', 'AdminController@archivesPagination')->name('admin/admins/pagination/archives');
          Route::post('admins/search/archives', 'AdminController@archivesSearch')->name('admin/admins/search/archives');
          Route::post('admins/search/byColumn/archives', 'AdminController@archivesSearchByColumn')->name('admin/admins/search/byColumn/archives');

          
              
          // user routes
          Route::get('users/index/{offset?}/{limit?}', 'UserController@index')->name('admin/users/index');
          Route::get('users/create', 'UserController@create')->name('admin/users/create');
          Route::post('users/create', 'UserController@store')->name('admin/users/store');
          Route::get('users/edit/{id?}', 'UserController@edit')->name('admin/users/edit');
          Route::post('users/edit/{id}', 'UserController@update')->name('admin/users/update');
          Route::get('users/activate', 'UserController@activate')->name('admin/users/activate');
          Route::get('users/delete', 'UserController@delete')->name('admin/users/delete');
          Route::post('users/pagination/{offset?}/{limit?}', 'UserController@pagination')->name('admin/users/pagination');
          Route::post('users/search', 'UserController@search')->name('admin/users/search');
          Route::post('users/search/byColumn', 'UserController@searchByColumn')->name('admin/users/search/byColumn');
          Route::get('users/archives/{offset?}/{limit?}', 'UserController@archives')->name('admin/users/archives');
          Route::get('users/back', 'UserController@back')->name('admin/users/back');
          Route::post('users/pagination/archives/{offset?}/{limit?}', 'UserController@archivesPagination')->name('admin/users/pagination/archives');
          Route::post('users/search/archives', 'UserController@archivesSearch')->name('admin/users/search/archives');
          Route::post('users/search/byColumn/archives', 'UserController@archivesSearchByColumn')->name('admin/users/search/byColumn/archives');

          
            
          // category routes
          Route::get('categories/index/{offset?}/{limit?}', 'CategoryController@index')->name('admin/categories/index');
          Route::get('categories/create', 'CategoryController@create')->name('admin/categories/create');
          Route::post('categories/create', 'CategoryController@store')->name('admin/categories/store');
          Route::get('categories/edit/{id?}', 'CategoryController@edit')->name('admin/categories/edit');
          Route::post('categories/edit/{id}', 'CategoryController@update')->name('admin/categories/update');
          Route::get('categories/activate', 'CategoryController@activate')->name('admin/categories/activate');
          Route::get('categories/delete', 'CategoryController@delete')->name('admin/categories/delete');
          Route::post('categories/pagination/{offset?}/{limit?}', 'CategoryController@pagination')->name('admin/categories/pagination');
          Route::post('categories/search', 'CategoryController@search')->name('admin/categories/search');
          Route::post('categories/search/byColumn', 'CategoryController@searchByColumn')->name('admin/categories/search/byColumn');
          Route::get('categories/archives/{offset?}/{limit?}', 'CategoryController@archives')->name('admin/categories/archives');
          Route::get('categories/back', 'CategoryController@back')->name('admin/categories/back');
          Route::post('categories/pagination/archives/{offset?}/{limit?}', 'CategoryController@archivesPagination')->name('admin/categories/pagination/archives');
          Route::post('categories/search/archives', 'CategoryController@archivesSearch')->name('admin/categories/search/archives');
          Route::post('categories/search/byColumn/archives', 'CategoryController@archivesSearchByColumn')->name('admin/categories/search/byColumn/archives');

          
            
          // product routes
          Route::get('products/index/{offset?}/{limit?}', 'ProductController@index')->name('admin/products/index');
          Route::get('products/create', 'ProductController@create')->name('admin/products/create');
          Route::post('products/create', 'ProductController@store')->name('admin/products/store');
          Route::get('products/edit/{id?}', 'ProductController@edit')->name('admin/products/edit');
          Route::post('products/edit/{id}', 'ProductController@update')->name('admin/products/update');
          Route::get('products/activate', 'ProductController@activate')->name('admin/products/activate');
          Route::get('products/delete', 'ProductController@delete')->name('admin/products/delete');
          Route::post('products/pagination/{offset?}/{limit?}', 'ProductController@pagination')->name('admin/products/pagination');
          Route::post('products/search', 'ProductController@search')->name('admin/products/search');
          Route::post('products/search/byColumn', 'ProductController@searchByColumn')->name('admin/products/search/byColumn');
          Route::get('products/archives/{offset?}/{limit?}', 'ProductController@archives')->name('admin/products/archives');
          Route::get('products/back', 'ProductController@back')->name('admin/products/back');
          Route::post('products/pagination/archives/{offset?}/{limit?}', 'ProductController@archivesPagination')->name('admin/products/pagination/archives');
          Route::post('products/search/archives', 'ProductController@archivesSearch')->name('admin/products/search/archives');
          Route::post('products/search/byColumn/archives', 'ProductController@archivesSearchByColumn')->name('admin/products/search/byColumn/archives');

          
            
          // country routes
          Route::get('countries/index/{offset?}/{limit?}', 'CountryController@index')->name('admin/countries/index');
          Route::get('countries/create', 'CountryController@create')->name('admin/countries/create');
          Route::post('countries/create', 'CountryController@store')->name('admin/countries/store');
          Route::get('countries/edit/{id?}', 'CountryController@edit')->name('admin/countries/edit');
          Route::post('countries/edit/{id}', 'CountryController@update')->name('admin/countries/update');
          Route::get('countries/activate', 'CountryController@activate')->name('admin/countries/activate');
          Route::get('countries/delete', 'CountryController@delete')->name('admin/countries/delete');
          Route::post('countries/pagination/{offset?}/{limit?}', 'CountryController@pagination')->name('admin/countries/pagination');
          Route::post('countries/search', 'CountryController@search')->name('admin/countries/search');
          Route::post('countries/search/byColumn', 'CountryController@searchByColumn')->name('admin/countries/search/byColumn');
          Route::get('countries/archives/{offset?}/{limit?}', 'CountryController@archives')->name('admin/countries/archives');
          Route::get('countries/back', 'CountryController@back')->name('admin/countries/back');
          Route::post('countries/pagination/archives/{offset?}/{limit?}', 'CountryController@archivesPagination')->name('admin/countries/pagination/archives');
          Route::post('countries/search/archives', 'CountryController@archivesSearch')->name('admin/countries/search/archives');
          Route::post('countries/search/byColumn/archives', 'CountryController@archivesSearchByColumn')->name('admin/countries/search/byColumn/archives');

          
            
          // order routes
          Route::get('orders/index/{offset?}/{limit?}', 'OrderController@index')->name('admin/orders/index');
          Route::get('orders/create', 'OrderController@create')->name('admin/orders/create');
          Route::post('orders/create', 'OrderController@store')->name('admin/orders/store');
          Route::get('orders/edit/{id?}', 'OrderController@edit')->name('admin/orders/edit');
          Route::post('orders/edit/{id}', 'OrderController@update')->name('admin/orders/update');
          Route::get('orders/activate', 'OrderController@activate')->name('admin/orders/activate');
          Route::get('orders/delete', 'OrderController@delete')->name('admin/orders/delete');
          Route::post('orders/pagination/{offset?}/{limit?}', 'OrderController@pagination')->name('admin/orders/pagination');
          Route::post('orders/search', 'OrderController@search')->name('admin/orders/search');
          Route::post('orders/search/byColumn', 'OrderController@searchByColumn')->name('admin/orders/search/byColumn');
          Route::get('orders/archives/{offset?}/{limit?}', 'OrderController@archives')->name('admin/orders/archives');
          Route::get('orders/back', 'OrderController@back')->name('admin/orders/back');
          Route::post('orders/pagination/archives/{offset?}/{limit?}', 'OrderController@archivesPagination')->name('admin/orders/pagination/archives');
          Route::post('orders/search/archives', 'OrderController@archivesSearch')->name('admin/orders/search/archives');
          Route::post('orders/search/byColumn/archives', 'OrderController@archivesSearchByColumn')->name('admin/orders/search/byColumn/archives');

          
            
          // coupon routes
          Route::get('coupons/index/{offset?}/{limit?}', 'CouponController@index')->name('admin/coupons/index');
          Route::get('coupons/create', 'CouponController@create')->name('admin/coupons/create');
          Route::post('coupons/create', 'CouponController@store')->name('admin/coupons/store');
          Route::get('coupons/edit/{id?}', 'CouponController@edit')->name('admin/coupons/edit');
          Route::post('coupons/edit/{id}', 'CouponController@update')->name('admin/coupons/update');
          Route::get('coupons/activate', 'CouponController@activate')->name('admin/coupons/activate');
          Route::get('coupons/delete', 'CouponController@delete')->name('admin/coupons/delete');
          Route::post('coupons/pagination/{offset?}/{limit?}', 'CouponController@pagination')->name('admin/coupons/pagination');
          Route::post('coupons/search', 'CouponController@search')->name('admin/coupons/search');
          Route::post('coupons/search/byColumn', 'CouponController@searchByColumn')->name('admin/coupons/search/byColumn');
          Route::get('coupons/archives/{offset?}/{limit?}', 'CouponController@archives')->name('admin/coupons/archives');
          Route::get('coupons/back', 'CouponController@back')->name('admin/coupons/back');
          Route::post('coupons/pagination/archives/{offset?}/{limit?}', 'CouponController@archivesPagination')->name('admin/coupons/pagination/archives');
          Route::post('coupons/search/archives', 'CouponController@archivesSearch')->name('admin/coupons/search/archives');
          Route::post('coupons/search/byColumn/archives', 'CouponController@archivesSearchByColumn')->name('admin/coupons/search/byColumn/archives');

            
          // info routes
          Route::get('info/index/{offset?}/{limit?}', 'InfoController@index')->name('admin/info/index');
          Route::get('info/create', 'InfoController@create')->name('admin/info/create');
          Route::post('info/create', 'InfoController@store')->name('admin/info/store');
          Route::get('info/edit/{id?}', 'InfoController@edit')->name('admin/info/edit');
          Route::post('info/edit/{id}', 'InfoController@update')->name('admin/info/update');
          Route::get('info/activate', 'InfoController@activate')->name('admin/info/activate');
          Route::get('info/delete', 'InfoController@delete')->name('admin/info/delete');
          Route::post('info/pagination/{offset?}/{limit?}', 'InfoController@pagination')->name('admin/info/pagination');
          Route::post('info/search', 'InfoController@search')->name('admin/info/search');
          Route::post('info/search/byColumn', 'InfoController@searchByColumn')->name('admin/info/search/byColumn');
          Route::get('info/archives/{offset?}/{limit?}', 'InfoController@archives')->name('admin/info/archives');
          Route::get('info/back', 'InfoController@back')->name('admin/info/back');
          Route::post('info/pagination/archives/{offset?}/{limit?}', 'InfoController@archivesPagination')->name('admin/info/pagination/archives');
          Route::post('info/search/archives', 'InfoController@archivesSearch')->name('admin/info/search/archives');
          Route::post('info/search/byColumn/archives', 'InfoController@archivesSearchByColumn')->name('admin/info/search/byColumn/archives');
          
            
          // contact routes
          Route::get('contacts/index/{offset?}/{limit?}', 'ContactController@index')->name('admin/contacts/index');
          Route::get('contacts/create', 'ContactController@create')->name('admin/contacts/create');
          Route::post('contacts/create', 'ContactController@store')->name('admin/contacts/store');
          Route::get('contacts/edit/{id?}', 'ContactController@edit')->name('admin/contacts/edit');
          Route::post('contacts/edit/{id}', 'ContactController@update')->name('admin/contacts/update');
          Route::get('contacts/activate', 'ContactController@activate')->name('admin/contacts/activate');
          Route::get('contacts/delete', 'ContactController@delete')->name('admin/contacts/delete');
          Route::post('contacts/pagination/{offset?}/{limit?}', 'ContactController@pagination')->name('admin/contacts/pagination');
          Route::post('contacts/search', 'ContactController@search')->name('admin/contacts/search');
          Route::post('contacts/search/byColumn', 'ContactController@searchByColumn')->name('admin/contacts/search/byColumn');
          Route::get('contacts/archives/{offset?}/{limit?}', 'ContactController@archives')->name('admin/contacts/archives');
          Route::get('contacts/back', 'ContactController@back')->name('admin/contacts/back');
          Route::post('contacts/pagination/archives/{offset?}/{limit?}', 'ContactController@archivesPagination')->name('admin/contacts/pagination/archives');
          Route::post('contacts/search/archives', 'ContactController@archivesSearch')->name('admin/contacts/search/archives');
          Route::post('contacts/search/byColumn/archives', 'ContactController@archivesSearchByColumn')->name('admin/contacts/search/byColumn/archives');

            
          // rating routes
          Route::get('ratings/index/{offset?}/{limit?}', 'RatingController@index')->name('admin/ratings/index');
          Route::get('ratings/create', 'RatingController@create')->name('admin/ratings/create');
          Route::post('ratings/create', 'RatingController@store')->name('admin/ratings/store');
          Route::get('ratings/edit/{id?}', 'RatingController@edit')->name('admin/ratings/edit');
          Route::post('ratings/edit/{id}', 'RatingController@update')->name('admin/ratings/update');
          Route::get('ratings/activate', 'RatingController@activate')->name('admin/ratings/activate');
          Route::get('ratings/delete', 'RatingController@delete')->name('admin/ratings/delete');
          Route::post('ratings/pagination/{offset?}/{limit?}', 'RatingController@pagination')->name('admin/ratings/pagination');
          Route::post('ratings/search', 'RatingController@search')->name('admin/ratings/search');
          Route::post('ratings/search/byColumn', 'RatingController@searchByColumn')->name('admin/ratings/search/byColumn');
          Route::get('ratings/archives/{offset?}/{limit?}', 'RatingController@archives')->name('admin/ratings/archives');
          Route::get('ratings/back', 'RatingController@back')->name('admin/ratings/back');
          Route::post('ratings/pagination/archives/{offset?}/{limit?}', 'RatingController@archivesPagination')->name('admin/ratings/pagination/archives');
          Route::post('ratings/search/archives', 'RatingController@archivesSearch')->name('admin/ratings/search/archives');
          Route::post('ratings/search/byColumn/archives', 'RatingController@archivesSearchByColumn')->name('admin/ratings/search/byColumn/archives');
          
          
        //ROUTEFROMCOMMANDLINE

      });
  });
});
