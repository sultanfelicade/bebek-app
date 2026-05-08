<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;

Route::get('/', function () {
	return redirect('/login');
});

Route::get('/setup-dummy', function () {
	DB::beginTransaction();

	try {
		$branchExists = DB::table('m_branches')->where('id_branch', 1)->exists();
		if (!$branchExists) {
			DB::table('m_branches')->insert([
				'id_branch' => 1,
				'branch_name' => 'Pusat',
				'address' => null,
			]);
		}

		DB::table('m_users')->delete();

		DB::table('m_users')->insert([
			[
				'username' => 'kasir_pusat',
				'password' => Hash::make('kasir123'),
				'id_branch' => 1,
				'role' => 'kasir',
			],
			[
				'username' => 'admin_pusat',
				'password' => Hash::make('admin123'),
				'id_branch' => 1,
				'role' => 'admin',
			],
		]);

		DB::commit();
		return 'Setup Kasir dan Admin Berhasil!';
	} catch (\Throwable $e) {
		DB::rollBack();
		return response('Gagal membuat dummy user: ' . $e->getMessage(), 500);
	}
});

Route::get('/login', [UserController::class, 'loginView']);
Route::post('/login', [UserController::class, 'loginProcess']);

Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware(['session.user', 'role.admin']);
Route::get('/admin/menu', [AdminController::class, 'menu'])->middleware(['session.user', 'role.admin']);
Route::get('/admin/cabang', [AdminController::class, 'cabang'])->middleware(['session.user', 'role.admin']);
Route::get('/admin/kategori', [AdminController::class, 'kategori'])->middleware(['session.user', 'role.admin']);
Route::get('/admin/manajemen-kasir', [AdminController::class, 'manajemenKasir'])->middleware(['session.user', 'role.admin']);
Route::get('/admin/inventaris', [AdminController::class, 'inventaris'])->middleware(['session.user', 'role.admin']);
Route::get('/admin/laporan', [AdminController::class, 'laporan'])->middleware(['session.user', 'role.admin']);

Route::get('/kasir', [KasirController::class, 'index'])->middleware(['session.user', 'role.kasir', 'auto.sync']);
Route::get('/kasir/dashboard', [KasirController::class, 'dashboard'])->middleware(['session.user', 'role.kasir', 'auto.sync']);
Route::get('/kasir/transaksi', [KasirController::class, 'transaksi'])->middleware(['session.user', 'role.kasir', 'auto.sync']);
Route::post('/kasir/transaksi/checkout', [KasirController::class, 'store'])->middleware(['session.user', 'role.kasir', 'auto.sync']);
Route::get('/kasir/riwayat', [KasirController::class, 'riwayat'])->middleware(['session.user', 'role.kasir', 'auto.sync']);

Route::post('/checkout', [KasirController::class, 'store'])->middleware(['session.user', 'role.kasir', 'auto.sync']);
Route::get('/struk/{id_sales}', [KasirController::class, 'receipt'])->middleware(['session.user', 'role.kasir', 'auto.sync']);

Route::get('/inventory', [InventoryController::class, 'index'])->middleware(['session.user', 'role.admin', 'auto.sync']);
Route::post('/inventory/mutations', [InventoryController::class, 'storeMutation'])->middleware(['session.user', 'role.admin', 'auto.sync']);

Route::get('/reports', [ReportsController::class, 'index'])->middleware(['session.user', 'role.admin']);

Route::prefix('master')->middleware(['session.user', 'role.admin'])->group(function () {
	Route::get('/branches', [BranchController::class, 'index']);
	Route::get('/branches/create', [BranchController::class, 'create']);
	Route::post('/branches', [BranchController::class, 'store']);
	Route::get('/branches/{id}/edit', [BranchController::class, 'edit']);
	Route::put('/branches/{id}', [BranchController::class, 'update']);
	Route::post('/branches/{id}/toggle-disable', [BranchController::class, 'toggleDisable']);

	Route::get('/categories', [CategoryController::class, 'index']);
	Route::get('/categories/create', [CategoryController::class, 'create']);
	Route::post('/categories', [CategoryController::class, 'store']);
	Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
	Route::put('/categories/{id}', [CategoryController::class, 'update']);

	Route::get('/products', [ProductController::class, 'index']);
	Route::get('/products/create', [ProductController::class, 'create']);
	Route::post('/products', [ProductController::class, 'store']);
	Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
	Route::put('/products/{id}', [ProductController::class, 'update']);

	Route::get('/users', [UserManagementController::class, 'index']);
	Route::get('/users/create', [UserManagementController::class, 'create']);
	Route::post('/users', [UserManagementController::class, 'store']);
	Route::get('/users/{id}/edit', [UserManagementController::class, 'edit']);
	Route::put('/users/{id}', [UserManagementController::class, 'update']);
});

Route::get('/logout', [UserController::class, 'logout']);