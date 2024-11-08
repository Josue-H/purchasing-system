<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BodegueroController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;



Route::get('/', [ProductoController::class, 'shopIndex'])->name('shop');


Route::get('/login', [UsuarioController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UsuarioController::class, 'login'])->name('login.submit');
Route::get('/2fa', [UsuarioController::class, 'show2faForm'])->name('2fa.show');
Route::post('/2fa', [UsuarioController::class, 'verify2fa'])->name('2fa.verify');
Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');

Route::get('/register', [UsuarioController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UsuarioController::class, 'register']);

// Otras rutas para Cliente
Route::post('/cliente/crear', [ClienteController::class, 'crearCliente']);

Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart/show', [CartController::class, 'showCart'])->name('cart.show');
Route::get('/cart/get', [CartController::class, 'getCart'])->name('cart.get');
Route::post('/cart/confirm', [CartController::class, 'confirmPurchase'])->name('cart.confirm');




Route::get('/shop', [ProductoController::class, 'shopIndex'])->name('shop.index');
Route::get('/403', function () {
    return view('403');
});
Route::view('/403', '403')->name('403');


Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard')->middleware(["adminRequired"]);
Route::get('/admin/create-user', [AdminController::class, 'createUserForm'])->name('admin.createUser')->middleware(["adminRequired"]);;
Route::post('/admin/create-user', [AdminController::class, 'storeUser'])->name('admin.storeUser')->middleware(["adminRequired"]);;
Route::get('/admin/products', [ProductoController::class, 'index'])->name('admin.products')->middleware(["adminRequired"]);;
Route::post('admin/productos/crear', [ProductoController::class, 'store'])->name('productos.store')->middleware(["adminRequired"]);;;

Route::resource('productos', ProductoController::class)->middleware(["adminRequired"]);



Route::get('/bodeguero/dashboard', [BodegueroController::class, 'bodegueroDashboard'])->name('bodeguero.dashboard')->middleware(["bodegueroRequired"]);
Route::get('/bodeguero/pedidos', [PedidoController::class, 'index'])->name('bodeguero.pedidos.index')->middleware(["bodegueroRequired"]);
Route::get('/bodeguero/pedidos/{id}', [PedidoController::class, 'show'])->name('bodeguero.pedidos.show')->middleware(["bodegueroRequired"]);
Route::post('/bodeguero/pedidos/{id}/generar-factura', [PedidoController::class, 'generarFactura'])->name('bodeguero.pedidos.generarFactura')->middleware(["bodegueroRequired"]);

Route::match(['get', 'post'], '/botman', function () {
    app('botman')->listen();
});

Route::post('/botman', [BotManController::class, 'handle']);
