<?php

use App\Models\Brand;
use App\Models\Order;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\user\StripeController;
use App\Http\Controllers\user\AllUserController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\user\CartPageController;
use App\Http\Controllers\user\CheckoutController;
use App\Http\Controllers\backend\CouponController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\user\WhishlistController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\frontend\LanguageController;
use App\Http\Controllers\backend\SubCategoryController;
use App\Http\Controllers\backend\AdminProfileController;
use App\Http\Controllers\backend\ShippingAreaController;
use App\Http\Controllers\frontend\UserProfileController;
use App\Http\Controllers\backend\SubSubCategoryController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    $allprods = Product::latest()->offset(3)->limit(10)->get();

    //$prods = Product::latest()->where('status', '=', 1)->offset(3)->limit(3)->get();
    $nprods = Product::latest()->where('status', '=', 1)->limit(3)->get();
    $slides = Slider::latest()->where('status', '=', 1)->limit(3)->get();
    $brands = Brand::all();
    //$cats = Category::all();
    return view('fronted.index', compact('allprods', 'slides', 'brands', 'nprods'));
});

/* Language Change */

Route::get('/language/hebrew', [LanguageController::class, 'heb'])->name('heb.language');

Route::get('/language/english', [LanguageController::class, 'eng'])->name('eng.language');

/* Product Details */
Route::get('/product/details/{prodId}/{slug}', [ProductController::class, 'single'])->name('prod.details');
Route::get('/product/allsales/', [ProductController::class, 'sale'])->name('prod.allsales');
Route::get('/product/allhot/', [ProductController::class, 'hot'])->name('prod.allhot');
Route::get('/product/allcategory/{catId}/{slug}', [ProductController::class, 'allCateg'])->name('prod.allcateg');
Route::get('/product/allsubcategory/{subId}/{slug}', [ProductController::class, 'allSubcateg'])->name('prod.allsubcateg');
Route::get('/product/allsubsubcategory/{subsubId}/{slug}', [ProductController::class, 'allSubsubcateg'])->name('prod.allsubsubcateg');

/* Product View with Modal */
Route::get('/product/view/modal/{id}', [ProductController::class, 'productViewAjax']);


/* Admin Login & Logout */

Route::group(['prefix' => 'admin', 'middleware' => ['admin:admin']], function () {
    Route::get('/login', [AdminController::class, 'index']);
    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
});

Route::middleware(['auth:sanctum,admin', 'verified', 'auth:admin'])->post('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');

/* Routes for Admin */

Route::prefix('admin')->middleware(['auth:sanctum,admin', 'verified', 'auth:admin'])->group(
    function () {
        Route::get('/dashboard', function () {
            $products = DB::table('products')
                ->where('products.product_qty', '>', 0)
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->select('products.*', 'brands.name_en as brand')
                ->get()
                ->groupBy('brand');
            $brands = [];
            $qtys = [];
            $i = 0;
            foreach ($products as $key => $prod) {
                $brands[] = $key;
                $qtys[] = $prod->sum('product_qty');
            }
            //dd($qtys);
            return view('admin.index', ['products' => $products, 'brands' => $brands, 'qtys' => $qtys]);
        })->name('admin.dashboard');

        /* Brands routes */
        Route::post('/brand/add', [BrandController::class, 'store'])->name('store.brand');
        Route::get('/brands/show', [BrandController::class, 'index'])->name('admin.show.brand');
        Route::get('/brand/{brand}/edit', [BrandController::class, 'edit'])->name('admin.brand.edit');
        Route::put('/brand/{editId}/update', [BrandController::class, 'update'])->name('admin.brand.update');
        Route::delete('/brand/{delId}/delete', [BrandController::class, 'destroy'])->name('admin.brand.delete');

        /* Category routes */
        Route::post('/category/add', [CategoryController::class, 'store'])->name('store.category');
        Route::get('/category/show', [CategoryController::class, 'index'])->name('admin.show.category');
        Route::get('/category/{catId}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/category/{editId}/update', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/category/{delId}/delete', [CategoryController::class, 'destroy'])->name('admin.category.delete');

        /* SubCategory routes */
        Route::post('/category/subcategory/add', [SubCategoryController::class, 'store'])->name('store.subcategory');
        Route::get('/category/subcategory/show', [SubCategoryController::class, 'index'])->name('admin.show.subcategory');
        Route::get('/category/subcategory/{subId}/edit', [SubCategoryController::class, 'edit'])->name('admin.subcategory.edit');
        Route::put('/category/subcategory/{editId}/update', [SubCategoryController::class, 'update'])->name('admin.subcategory.update');
        Route::delete('/subcategory/{delId}/delete', [SubCategoryController::class, 'destroy'])->name('admin.subcategory.delete');
        Route::get('/subcategory/ajax/{category_id}', [SubSubCategoryController::class, 'getSubCategory']);

        /* SubSubCategory routes */
        Route::post('/category/subcategory/subsubcategory/add', [SubSubCategoryController::class, 'store'])->name('store.subsubcategory');
        Route::get('/category/subsubcategory/show', [SubSubCategoryController::class, 'index'])->name('admin.show.subsubcategory');
        Route::get('/category/subcategory/subsubcategory/{subId}/edit', [SubSubCategoryController::class, 'edit'])->name('admin.subsubcategory.edit');
        Route::put('/category/subcategory/subsubcategory/{editId}/update', [SubSubCategoryController::class, 'update'])->name('admin.subsubcategory.update');
        Route::delete('/subsubcategory/{delId}/delete', [SubSubCategoryController::class, 'destroy'])->name('admin.subsubcategory.delete');

        /* Product Routes */
        Route::get('/subsubcategory/ajax/{category_id}', [ProductController::class, 'getSubSubCategory']);
        Route::post('/product/add', [ProductController::class, 'store'])->name('admin.store.product');
        Route::get('/product/show', [ProductController::class, 'index'])->name('admin.show.product');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/product/{updateId}/update', [ProductController::class, 'updateProd'])->name('admin.product.update');
        Route::put('/product/{updateId}/thumbnail', [ProductController::class, 'updateThumbnail'])->name('admin.update.thumbnail');
        Route::put('/product/{updateId}/features', [ProductController::class, 'updateFeatures'])->name('admin.update.features');
        Route::put('/product/image/{updateId}/update', [ProductController::class, 'updateImage'])->name('admin.update.prod.image');
        Route::get('/product/image/{imageId}/edit', [ProductController::class, 'imageEdit'])->name('admin.image.edit');
        Route::post('/product/{updateId}/multi', [ProductController::class, 'storeMulti'])->name('admin.store.multi');
        Route::delete('/product/{delId}/delete', [ProductController::class, 'destroy'])->name('admin.product.delete');

        /* Sliders */
        Route::get('/slider/show', [SliderController::class, 'index'])->name('admin.show.slider');
        Route::post('/slider/add', [SliderController::class, 'store'])->name('store.slider');
        Route::get('/slider/{editId}/edit', [SliderController::class, 'edit'])->name('admin.slider.edit');
        Route::put('/slider/{updateId}/update', [SliderController::class, 'update'])->name('admin.slider.update');

        /* Coupons */
        Route::get('/coupon/show', [CouponController::class, 'index'])->name('admin.show.coupon');
        Route::post('/coupon/add', [CouponController::class, 'store'])->name('admin.store.coupon');
        Route::get('/coupon/{coupon}/edit', [CouponController::class, 'edit'])->name('admin.coupon.edit');
        Route::put('/coupon/{updateId}/update', [CouponController::class, 'updateCoup'])->name('admin.coupon.update');

        /* Shipping Area */
        /* Division */
        Route::get('/shipping/division/show', [ShippingAreaController::class, 'viewDivisions'])->name('admin.show.shipping.division');
        Route::post('/shipping/division/add', [ShippingAreaController::class, 'storeDivision'])->name('admin.store.shipping.division');
        Route::get('/shipping/division/{division}/edit', [ShippingAreaController::class, 'editDivision'])->name('admin.shipping.division.edit');
        Route::put('/shipping/division/{updateId}/update', [ShippingAreaController::class, 'updateDivision'])->name('admin.shipping.division.update');
        Route::delete('/shipping/division/{division}/delete', [ShippingAreaController::class, 'deleteDivision'])->name('admin.shipping.division.delete');
        /* District */
        Route::get('/shipping/district/show', [ShippingAreaController::class, 'viewDistricts'])->name('admin.show.shipping.district');
        Route::post('/shipping/district/add', [ShippingAreaController::class, 'storeDistrict'])->name('admin.store.shipping.district');
        Route::get('/shipping/district/{district}/edit', [ShippingAreaController::class, 'editDistrict'])->name('admin.shipping.district.edit');
        Route::put('/shipping/district/{updateId}/update', [ShippingAreaController::class, 'updateDistrict'])->name('admin.shipping.district.update');
        Route::delete('/shipping/district/{district}/delete', [ShippingAreaController::class, 'deleteDistrict'])->name('admin.shipping.district.delete');
        /* State */
        Route::get('/shipping/state/show', [ShippingAreaController::class, 'viewStates'])->name('admin.show.shipping.state');
        Route::post('/shipping/state/add', [ShippingAreaController::class, 'storeState'])->name('admin.store.shipping.state');
        Route::get('/shipping/state/{state}/edit', [ShippingAreaController::class, 'editState'])->name('admin.shipping.state.edit');
        Route::put('/shipping/state/{updateId}/update', [ShippingAreaController::class, 'updateState'])->name('admin.shipping.state.update');
        Route::delete('/shipping/state/{state}/delete', [ShippingAreaController::class, 'deleteState'])->name('admin.shipping.state.delete');
        Route::get('/shipping/district/ajax/{id}', [ShippingAreaController::class, 'getDistrict']);


        /* Profile routes */
        Route::get('/profile', [AdminProfileController::class, 'show'])->name('admin.profile');
        Route::put('/profile/update', [AdminProfileController::class, 'updateProfileInformation'])->name('admin.profile.update');
        Route::post('/profile/password/update', [AdminProfileController::class, 'updatePassword'])->name('admin.password.update');
    }
);
/* add this or admin to the livewire route: middleware(['auth:sanctum,web', 'verified', 'auth:web'])-> */
Route::get('/contact', function () {
    return view('contact');
});



/* 
fronted.index just for now...for /dashboard
*/

Route::middleware(['auth:sanctum,web', 'verified', 'auth:web', 'user'])->get('/dashboard', function () {
    //dd(Auth::id());
    $orders = Order::where('user_id', '=', Auth::id())->get();
    //dd($orders);
    $amount = 0;
    $delivered = 0;
    $pending = 0;
    foreach ($orders as $order) {
        $amount += $order->amount;
        if ($order->status == 'Delivered') {
            $delivered += 1;
        }
        if ($order->status == 'Pending') {
            $pending += 1;
        }
    }
    //$cats = Category::all();, compact('cats')
    return view('dashboard', compact('orders', 'amount', 'delivered', 'pending'));
})->name('dashboard');
/* User Profile */
Route::prefix('user')->middleware(['auth:sanctum,web', 'verified', 'auth:web'])->group(
    function () {
        Route::get('/profile', [UserProfileController::class, 'show'])->name('user.profile');
        Route::put('/profile/update', [UserProfileController::class, 'updateProfileInformation'])->name('user.profile.update');
        Route::post('/profile/password/update', [UserProfileController::class, 'updatePassword'])->name('user.password.update');
    }
);
/* Add to Cart */
Route::post('/cart/data/store/{id}', [CartController::class, 'addProduct']);
/* Mini Cart Show numbers */
Route::get('/product/mini/cart/', [CartController::class, 'showMiniCart']);
/* Remove mini cart*/
Route::get('/minicart/product-remove/{rowId}', [CartController::class, 'removeMiniCart']);

/* add to wishlist */
Route::post('/add-to-wishlist/{product_id}', [CartController::class, 'addToWishlist']);
/* view wishlist */
Route::group(
    ['prefix' => 'user', 'middleware' => ['user', 'auth'], 'namespace' => 'User'],
    function () {
        Route::get('/wishlist', [WhishlistController::class, 'index'])->name('wishlist');
        Route::get('/get-wishlist-product', [WhishlistController::class, 'getWishlistProduct']);
        Route::delete('/wishlist/{id}/delete', [WhishlistController::class, 'destroyOne'])->name('removeFromWishlist');
        Route::post('/checkout/store', [CheckoutController::class, 'checkoutStore'])->name('checkout.store');
        Route::post('/stripe/order', [StripeController::class, 'stripeOrder'])->name('stripe.order');
        Route::get('/my/orders', [AllUserController::class, 'getAllOrders'])->name('my.orders');
        Route::get('/my/order/{orderId}/details', [AllUserController::class, 'getOrderDetails'])->name('my.order.details');
    }
);
/* manage cart from cart page */
Route::get('/user/get-cart-product', [CartPageController::class, 'getCartProduct']);
Route::get('/user/mycart', [CartPageController::class, 'index'])->name('mycartpage');
Route::get('/user/cart-remove/{rowId}', [CartPageController::class, 'removeCartProduct']);
Route::get('/cart-increment/{rowId}', [CartPageController::class, 'cartIncrement']);
Route::get('/cart-decrement/{rowId}', [CartPageController::class, 'cartDecrement']);
/* apply coupon from cart page*/
Route::post('/coupon-apply/{name}', [CartController::class, 'couponApply']);
Route::get('/coupon-remove', [CartController::class, 'couponRemove']);
Route::get('/checkout', [CartController::class, 'checkoutCreate'])->name('checkoutPage')->middleware('auth');
Route::get('/shipping/district/ajax/{id}', [CheckoutController::class, 'getDistrict']);
Route::get('/shipping/state/ajax/{id}', [CheckoutController::class, 'getState']);
