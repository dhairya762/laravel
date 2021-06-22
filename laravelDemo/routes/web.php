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

Route::get('/', 'App\Http\Controllers\DashboardController@index');

Route::get('dashboard', 'App\Http\Controllers\DashboardController@index');

Route::get('customers', 'App\Http\Controllers\CustomersController@index');
Route::get('customers/page={number}', 'App\Http\Controllers\CustomersController@index');
Route::get('customers-details', 'App\Http\Controllers\CustomersController@getCustomerDetails');
// Route::post('customers', 'App\Http\Controllers\CustomersController@index');
Route::get('customers/add/{customer}', 'App\Http\Controllers\CustomersController@create');
Route::post('customers/store/{customer}', 'App\Http\Controllers\CustomersController@store');
Route::get('customers/edit/{customer}', 'App\Http\Controllers\CustomersController@edit');
Route::get('customers/destroy/{customer}', 'App\Http\Controllers\CustomersController@destroy');
Route::get('customers/address/{customer}', 'App\Http\Controllers\CustomersController@addressAction');
Route::post('customers/save-address/{customer}', 'App\Http\Controllers\CustomersController@saveAddressAction');

//Category
Route::get('categories', 'App\Http\Controllers\CategoryController@index');
// Route::get('categories-new', 'App\Http\Controllers\CategoryController@newIndex');
Route::get('categories/add/{category}', 'App\Http\Controllers\CategoryController@create');
Route::post('categories/store/{category}', 'App\Http\Controllers\CategoryController@store');
Route::get('categories/destroy/{category}', 'App\Http\Controllers\CategoryController@destroy');
Route::get('categories/edit/{category}', 'App\Http\Controllers\CategoryController@edit');

//Product
Route::get('products', 'App\Http\Controllers\ProductController@index');
Route::get('products/page={number}', 'App\Http\Controllers\ProductController@index');
// Route::get('products?page', 'App\Http\Controllers\ProductController@index');
Route::get('products/add/{product}', 'App\Http\Controllers\ProductController@create');
Route::post('products/store/{product}', 'App\Http\Controllers\ProductController@store');
Route::get('products/destroy/{product}', 'App\Http\Controllers\ProductController@destroy');
Route::get('products/edit/{product}', 'App\Http\Controllers\ProductController@edit');
Route::get('products/media/{product}', 'App\Http\Controllers\ProductController@mediaAction');
Route::post('products/save-media/{product}', 'App\Http\Controllers\ProductController@saveMediaAction');
Route::post('products/upload-media/{product}', 'App\Http\Controllers\ProductController@uploadMediaAction');

//Category
Route::get('category', ['uses' => 'App\Http\Controllers\CategoryController@manageCategory']);
Route::post('add-category', ['as' => 'add.category', 'id'=>'0','uses' => 'App\Http\Controllers\CategoryController@addCategory']);
Route::post('category/add_category', 'App\Http\Controllers\CategoryController@addCategory');
Route::post('category/add/{id}', 'App\Http\Controllers\CategoryController@addCategory');
Route::get('category/destroy/{id}', 'App\Http\Controllers\CategoryController@destroy');
Route::get('category/create', 'App\Http\Controllers\CategoryController@create');
Route::post('category/edit/{id}', 'App\Http\Controllers\CategoryController@edit');
Route::post('category/show/{id}', 'App\Http\Controllers\CategoryController@show');
Route::post('category/update/{id}', 'App\Http\Controllers\CategoryController@update');

//Cart
Route::get('cart', 'App\Http\Controllers\CartController@index');
Route::POST('cart/select_customer', 'App\Http\Controllers\CartController@selectCustomerAction');
Route::POST('cart/billing_address', 'App\Http\Controllers\CartController@billingAddressAction');
Route::POST('cart/shipping_address', 'App\Http\Controllers\CartController@shippingAddressAction');
Route::POST('cart/payment_method', 'App\Http\Controllers\CartController@paymentAction');
Route::POST('cart/shipping_method', 'App\Http\Controllers\CartController@shippingAction');
Route::POST('cart/add_product', 'App\Http\Controllers\CartController@addProductAction');
Route::POST('cart/update_product_quantity', 'App\Http\Controllers\CartController@updateQuantityAction');
Route::GET('cart/clear_cart', 'App\Http\Controllers\CartController@clearCartAction');
Route::POST('cart/delete_product', 'App\Http\Controllers\CartController@deletProductAction');
Route::GET('cart/place_order', 'App\Http\Controllers\CartController@placeOrderAction');
// Route::get('placeOrder', 'App\Http\Controllers\cartController@placeOrderA');

//placeOrder
Route::get('placeorder', 'App\Http\Controllers\PlaceOrderController@index');
Route::get('placeorder/page={number}', 'App\Http\Controllers\PlaceOrderController@index');
Route::get('placeorder/show/{order}', 'App\Http\Controllers\PlaceOrderController@show');
Route::post('placeorder/comments/{order}', 'App\Http\Controllers\PlaceOrderController@saveComment');

//Payment
Route::get('payment', 'App\Http\Controllers\PaymentController@index');
Route::get('payment/page={number}', 'App\Http\Controllers\PaymentController@index');
Route::get('payment/add/{payment}', 'App\Http\Controllers\PaymentController@create');
Route::post('payment/store/{payment}', 'App\Http\Controllers\PaymentController@store');
Route::get('payment/destroy/{payment}', 'App\Http\Controllers\PaymentController@destroy');
Route::get('payment/edit/{payment}', 'App\Http\Controllers\PaymentController@edit');

//Shipping
Route::get('shipping', 'App\Http\Controllers\ShippingController@index');
Route::get('shipping/page={number}', 'App\Http\Controllers\ShippingController@index');
Route::get('shipping/add/{shipping}', 'App\Http\Controllers\ShippingController@create');
Route::post('shipping/store/{shipping}', 'App\Http\Controllers\ShippingController@store');
Route::get('shipping/destroy/{shipping}', 'App\Http\Controllers\ShippingController@destroy');
Route::get('shipping/edit/{shipping}', 'App\Http\Controllers\ShippingController@edit');

//SalesMan
Route::get('salesman', 'App\Http\Controllers\SalesManController@index');
Route::post('salesman/search', 'App\Http\Controllers\SalesManController@index');
Route::post('salesman/create', 'App\Http\Controllers\SalesManController@create');
Route::get('salesman/salesmanId/{id}', 'App\Http\Controllers\SalesManController@salesManId');
Route::post('salesman/product', 'App\Http\Controllers\SalesManController@product');
Route::post('salesman/update/{id}', 'App\Http\Controllers\SalesManController@update');
Route::get('salesman/clear', 'App\Http\Controllers\SalesManController@clearAction');
Route::get('salesman/destroy/{id}', 'App\Http\Controllers\SalesManController@destroy');

//CSV
Route::get('csv', 'App\Http\Controllers\CsvController@index');
// Route::post('csv/upload', 'App\Http\Controllers\CsvController@upload');
Route::post('csv/import', 'App\Http\Controllers\CsvController@import');
// Route::post('csv/export', 'App\Http\Controllers\CsvController@export');
Route::post('csv/exportIntoCSV', 'App\Http\Controllers\CsvController@exportIntoCSV');
