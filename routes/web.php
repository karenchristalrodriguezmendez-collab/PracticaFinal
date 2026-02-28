<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderAdminController;


Route::get("/", function (Request $request) {
    $search = $request->input("search");
    $query = \App\Models\Product::query();

    if ($search) {
        $query->where("name", "like", "%{$search}%")
              ->orWhere("description", "like", "%{$search}%");
    }

    $products = $query->paginate(6);
    return view("welcome-simple", compact("products", "search"));
});

// Custom auth routes with better control
Route::get("login", [LoginController::class, "showLoginForm"])->name("login");
Route::post("login", [LoginController::class, "login"]);
Route::match(["get", "post"], "logout", [LoginController::class, "logout"])
    ->name("logout")
    ->middleware(["auth", "security:logout"]);

Route::get("register", [
    RegisterController::class,
    "showRegistrationForm",
])->name("register");
Route::post("register", [RegisterController::class, "register"]);

Route::get("password/reset", [
    ForgotPasswordController::class,
    "showLinkRequestForm",
])->name("password.request");
Route::post("password/email", [
    ForgotPasswordController::class,
    "sendResetLinkEmail",
])->name("password.email");
Route::get("password/reset/{token}", [
    ResetPasswordController::class,
    "showResetForm",
])->name("password.reset");
Route::post("password/reset", [ResetPasswordController::class, "reset"])->name(
    "password.update",
);
Route::get("password/confirm", [
    ConfirmPasswordController::class,
    "showConfirmForm",
])->name("password.confirm");
Route::post("password/confirm", [ConfirmPasswordController::class, "confirm"]);

Route::middleware(["auth", "security:auth"])->group(function () {
    Route::get("/home", [HomeController::class, "index"])->name("home");

    // Rutas del carrito
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/cart/checkout', function() { return redirect()->route('cart.index'); });
    Route::get('/cart/success', [App\Http\Controllers\CartController::class, 'success'])->name('cart.success');

    // Rutas de productos
    Route::resource("products", ProductController::class)->except([
        "show",
        "update",
    ]);
    Route::get("productos", [ProductController::class, "index"])->name(
        "productos.index",
    );
    Route::get("productos/agregar", [ProductController::class, "create"])->name(
        "productos.create",
    );
    Route::get("products/data", [ProductController::class, "dataTable"])->name(
        "products.data",
    );
    Route::get("products/{product}/download-image", [
        ProductController::class,
        "downloadImage",
    ])->name("products.download-image");

    // Rutas de empresas
    Route::resource('companies', CompanyController::class)->except(['show', 'update']);
    Route::get('companies/data', [CompanyController::class, 'dataTable'])->name('companies.data');

    // Rutas de usuarios (Solo Admin)
    Route::middleware(["role:admin"])->group(function () {
        Route::resource("users", UserController::class)->except([
            "show",
            "update",
        ]);
        Route::get("users/data", [UserController::class, "dataTable"])->name(
            "users.data",
        );
        Route::get("users/{user}/download-avatar", [
            UserController::class,
            "downloadAvatar",
        ])->name("users.download-avatar");

        // Gestión de Pedidos Administrativa
        Route::get('admin/orders', [OrderAdminController::class, 'index'])->name('admin.orders.index');
        Route::get('admin/orders/{order}', [OrderAdminController::class, 'show'])->name('admin.orders.show');
        Route::patch('admin/orders/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    });

});
