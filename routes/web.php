<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\FlagMiddleware;
use App\Models\Expense;
use App\Models\FinancialReport;
use App\Models\Phone;
use App\Models\Post;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    return view('home');
});

Route::resource('students', StudentController::class);

Route::resource('customers', CustomerController::class);
Route::delete('customers/{customer}/forceDestroy', [CustomerController::class, 'forceDestroy'])
    ->name('customers.forceDestroy');

Route::resource('employees', EmployeeController::class);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/movies', function () {
    return view('movies');
})->name('movies')->middleware('check.age');


Route::middleware('check.auth:admin')->group(function () {
    Route::get('/admin', function () {
        echo 'PAGE ADMIN';
        die;
    })->name('admin');
});

Route::middleware('check.auth:admin,employee')->group(function () {
    Route::get('/orders', function () {
        echo 'PAGE ORDERS';
        die;
    })->name('orders');
});

Route::middleware('check.auth:admin,client')->group(function () {
    Route::get('/profile', function () {
        echo 'PAGE PROFILE';
        die;
    })->name('profile');;
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        echo 'PAGE DASHBOARD';
        die;
    })->name('dashboard');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot-password');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::post('/reset-password',        [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/transactions',                      [TransactionController::class, 'index'])->name('transactions');
    Route::get('/transactions/create',               [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('/transactions/confirm-transaction',  [TransactionController::class, 'confirmTransaction'])->name('transactions.confirm');
    Route::post('/start-transaction',                [TransactionController::class, 'startTransaction'])->name('transactions.start');
    Route::post('/update-transaction-status',        [TransactionController::class, 'completeTransactionStatus'])->name('transactions.complete');
    Route::post('/cancel-transaction',               [TransactionController::class, 'cancelTransaction'])->name('transactions.cancel');
});

Route::get('/users', function () {
    $data = User::with('phone')->paginate(10);

    return view('user-list', compact('data'));
});

Route::get('/phones/{id}', function ($id) {
    $phone = Phone::with(['user'])->find($id);

    dd($phone->user);
});

Route::get('/posts/{id}', function ($id) {
    $post = Post::with('comments')->find($id);

    dd($post->toArray());
});

Route::get('/users/{id}/add-role', function ($id) {
    $roles = [1,2,4,6,7];

    $user = User::find($id);

    $user->roles()->attach($roles);

    dd($user->load('roles')->toArray());
});

Route::get('/users/{id}/remove-role', function ($id) {
    $roles = [6,7];

    $user = User::find($id);

    $user->roles()->detach($roles);

    dd($user->load('roles')->toArray());
});

Route::get('/users/{id}/sync-role', function ($id) {
    $roles = [2,3,6,8,5];

    $user = User::find($id);

    $user->roles()->sync($roles); 

    dd($user->load('roles')->toArray());
});



// Route::get('/query', function () {

//     // 1
//     // DB::table('users','u')
//     //     ->join('orders as o', 'u.id','=','o.user_id')
//     //     ->select('u.name', DB::raw('SUM(o.amount) as total_spent'))
//     //     ->groupBy('u.name')
//     //     ->having('total_spent','>',1000)
//     //     ->ddRawSql();

//     // 2
//     // DB::table('orders')
//     //     ->select([
//     //         DB::raw('DATE(order_date) as date'),
//     //         DB::raw('COUNT(*) as orders_count'),
//     //         DB::raw('total_amount as total_sales')
//     //     ])
//     //     ->whereBetween('order_date',['2024-01-01','2024-09-30'])
//     //     ->groupByRaw('DATE(order_date)')
//     //     ->ddRawSql();

//     // 3
//     // DB::table('products','p')
//     //     ->select('product_name')
//     //     ->whereNotExists(
//     //         DB::table('orders','o')
//     //             ->select(DB::raw(1))
//     //             ->where('o.product_id','p.id')
//     //     )
//     //     ->ddRawSql();

//     // 4
//     // $sales_cte = DB::table('sales')
//     // ->select([
//     //     'product_id',
//     //     DB::raw('SUM(quantity) as total_sold')
//     // ])
//     // ->groupBy('product_id');

//     // DB::table('products','p')
//     // ->select('p.product_name', 's.total_sold')
//     // ->joinSub($sales_cte, 's', 'p.id','=','s.product_id')
//     // ->where('s.total_sold','>',100)
//     // ->ddRawSql();

//     // 5
//     // DB::table('users')
//     //     ->join('orders'       ,'users.id'               ,'orders.user_id')
//     //     ->join('order_items'  ,'orders.id'              ,'order_items.order_id')
//     //     ->join('products'     ,'order_items.product_id' ,'products.id')
//     //     ->select(['users.name','products.product_name','orders.order_date'])
//     //     ->where('orders.order_date','>=',now()->subDays(30))
//     //     ->ddRawSql();

//     // 6
//     // DB::table('orders')
//     //     ->join('order_items', 'orders.id', 'order_items.order_id')
//     //     ->select([
//     //         DB::raw("DATE_FORMAT(orders.order_date, '%Y-%m') as order_month"),
//     //         DB::raw("SUM(order_items.quantity * order_items.price) as total_revenue")
//     //         ])
//     //     ->groupBy('order_month')
//     //     ->orderByDesc('order_month')
//     //     ->where('orders.status', '=', 'completed')
//     //     ->ddRawSql();

//     // 7
//     // DB::table('products')
//     //     ->leftJoin('order_items','products.id','order_items.product_id')
//     //     ->select('products.product_name')
//     //     ->whereNull('order_items.product_id')
//     //     ->ddRawSql();
    
//     // 8
//     // DB::table('products','p')
//     //     ->joinSub(
//     //         DB::table('order_items')
//     //             ->select(['product_id', DB::raw('SUM(quantity * price) AS total')])
//     //             ->groupBy('product_id'),
//     //             'oi','p.id','=','oi.product_id'
//     //     )
//     //     ->select(['p.category_id','p.product_name',DB::raw('MAX(oi.total) AS max_revenue')])
//     //     ->groupBy('p.category_id','p.product_name')
//     //     ->orderByDesc('max_revenue')
//     //     ->ddRawSql();

//     // 9
//     // DB::table('orders')
//     //     ->join('users'      ,'users.id' ,'orders.user_id')
//     //     ->join('order_items','orders.id','order_items.order_id')
//     //     ->select(['orders.id','users.name','orders.order_date',
//     //             DB::raw('SUM(order_items.quantity * order_items.price) AS total_value')
//     //     ])
//     //     ->groupBy('orders.id','users.name','orders.order_date')
//     //     ->havingRaw('total_value > (SELECT AVG(total) FROM (SELECT SUM(quantity * price) AS total FROM order_items GROUP BY order_id) AS avg_order_value')
//     //     ->ddRawSql();
    
//     // 10
//     // DB::table('products','p')
//     //     ->join('order_items as oi','p.id','oi.product_id')
//     //     ->select(['p.category_id', 'p.product_name',
//     //             DB::raw('SUM(quantity) AS total_sold')
//     //     ])
//     //     ->groupBy('p.category_id', 'p.product_name')
//     //     ->havingRaw('total_sold = (SELECT MAX(sub.total_sold) FROM (SELECT product_name, SUM(quantity) AS total_sold FROM order_items JOIN products ON order_items.product_id = products.id WHERE products.category_id = p.category_id GROUP BY product_name) as sub')
//     //     ->ddRawSql();
// });

// Route::get('/report', function () {
//     // Tính tổng doanh thu theo tháng
//     $salesData = Sale::query()
//         ->select([
//             DB::raw('SUM(total) as total_sale'),
//             DB::raw('EXTRACT(MONTH FROM sale_date) as month'),
//             DB::raw('EXTRACT(YEAR FROM sale_date) as year')
//         ])
//         ->groupByRaw('EXTRACT(MONTH FROM sale_date), EXTRACT(YEAR FROM sale_date)')
//         ->get();

//     // Tính tổng chi phí theo tháng
//     $expensesData = Expense::query()
//         ->select([
//             DB::raw('SUM(amount) as total_expenses'),
//             DB::raw('EXTRACT(MONTH FROM expense_date) as month'),
//             DB::raw('EXTRACT(YEAR FROM expense_date) as year')
//         ])
//         ->groupByRaw('EXTRACT(MONTH FROM expense_date), EXTRACT(YEAR FROM expense_date)')
//         ->get();
    
//     $financialReports = FinancialReport::all();

//     return view('reports', compact('salesData','expensesData','financialReports'));
// });
