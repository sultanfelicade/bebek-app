@extends('layouts.kasir')

@section('title', 'Transaksi Kasir')
@section('section', 'Kasir')
@section('pageTitle', 'Transaksi')

@section('content')
	<div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
		<div class="lg:col-span-3 bg-white border border-gray-200 rounded-lg p-4">
			<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
				<div>
					<h2 class="font-semibold text-gray-900">Pilih Menu</h2>
					<div class="text-xs text-gray-600">Pilih kategori, lalu klik menu untuk masuk keranjang.</div>
				</div>

				<div class="w-full sm:w-64">
					<label for="category-filter" class="block text-xs font-medium text-gray-700">Kategori</label>
					<select id="category-filter" class="mt-1 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900">
						<option value="all">Semua Kategori</option>
						@foreach ($categories as $category)
							<option value="{{ $category->id_category }}">{{ $category->category_name }}</option>
						@endforeach
						<option value="none">Tanpa Kategori</option>
					</select>
				</div>
			</div>

			<div id="products-grid" class="mt-4 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
				@forelse ($products as $product)
					<div
						class="product-card border border-gray-200 rounded-lg p-3 flex flex-col justify-between"
						data-category="{{ $product->id_category ?? 'none' }}"
					>
						<div class="min-w-0">
							<div class="font-medium text-gray-900 truncate">{{ $product->product_name }}</div>
							<div class="mt-1 text-sm text-gray-600">Rp {{ number_format((float) $product->price, 2, ',', '.') }}</div>
							<div class="mt-2">
								<span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-2 py-0.5 text-xs font-medium">
									{{ $product->category_name ?? 'Tanpa Kategori' }}
								</span>
							</div>
						</div>

						<button
							type="button"
							class="mt-3 w-full rounded-md bg-gray-900 text-white px-3 py-2 text-sm font-semibold hover:bg-gray-800"
							data-action="add"
							data-id="{{ $product->id_product }}"
							data-name="{{ $product->product_name }}"
							data-price="{{ $product->price }}"
						>
							Tambah
						</button>
					</div>
				@empty
					<div class="py-6 text-sm text-gray-600">Belum ada produk.</div>
				@endforelse
			</div>
		</div>

		<div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg p-4">
			<h2 class="font-semibold text-gray-900">Keranjang</h2>

			<form id="checkout-form" class="mt-3 space-y-3" method="POST" action="{{ url('/kasir/transaksi/checkout') }}">
				@csrf
				<input type="hidden" name="cart_data" id="cart_data" value="[]" />

				<div id="cart-empty" class="text-sm text-gray-600">Belum ada pesanan.</div>
				<div id="cart-items" class="space-y-2"></div>

				<div class="pt-3 border-t border-gray-100 flex items-center justify-between">
					<div class="font-semibold text-gray-900">Total</div>
					<div class="font-semibold text-gray-900">Rp <span id="total-harga">0</span></div>
				</div>

				<button
					id="btn-checkout"
					type="submit"
					class="w-full rounded-md bg-gray-900 text-white py-2 font-semibold disabled:opacity-50"
					disabled
				>
					Proses Pembayaran
				</button>
			</form>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		(function () {
			const categoryFilter = document.getElementById('category-filter');
			const productCards = Array.from(document.querySelectorAll('.product-card'));
			const addButtons = Array.from(document.querySelectorAll('[data-action="add"]'));

			const cartDataInput = document.getElementById('cart_data');
			const cartEmptyEl = document.getElementById('cart-empty');
			const cartItemsEl = document.getElementById('cart-items');
			const totalHargaEl = document.getElementById('total-harga');
			const checkoutButton = document.getElementById('btn-checkout');

			let cart = [];

			function rupiah(number) {
				return new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(number || 0);
			}

			function syncHiddenInput() {
				cartDataInput.value = JSON.stringify(cart);
			}

			function recalcTotals() {
				cart = cart.map(item => ({
					...item,
					qty: Math.max(0, parseInt(item.qty, 10) || 0),
					price: parseFloat(item.price) || 0,
				})).filter(item => item.qty > 0);

				cart = cart.map(item => ({
					...item,
					subtotal: item.qty * item.price,
				}));
			}

			function totalCart() {
				return cart.reduce((sum, item) => sum + (parseFloat(item.subtotal) || 0), 0);
			}

			function findItem(idProduct) {
				return cart.find(item => item.id_product === idProduct);
			}

			function addToCart(product) {
				const idProduct = String(product.id_product);
				const existing = findItem(idProduct);

				if (existing) {
					existing.qty += 1;
				} else {
					cart.push({
						id_product: idProduct,
						product_name: String(product.product_name),
						price: parseFloat(product.price) || 0,
						qty: 1,
						subtotal: parseFloat(product.price) || 0,
					});
				}

				render();
			}

			function increment(idProduct) {
				const item = findItem(idProduct);
				if (!item) return;
				item.qty += 1;
				render();
			}

			function decrement(idProduct) {
				const item = findItem(idProduct);
				if (!item) return;
				item.qty -= 1;
				render();
			}

			function removeItem(idProduct) {
				cart = cart.filter(item => item.id_product !== idProduct);
				render();
			}

			function render() {
				recalcTotals();
				syncHiddenInput();

				const isEmpty = cart.length === 0;
				cartEmptyEl.style.display = isEmpty ? 'block' : 'none';
				checkoutButton.disabled = isEmpty;

				cartItemsEl.innerHTML = '';

				if (!isEmpty) {
					cart.forEach((item) => {
						const row = document.createElement('div');
						row.className = 'border border-gray-200 rounded-md p-3';
						row.innerHTML = `
							<div class="flex items-start justify-between gap-3">
								<div class="min-w-0">
									<div class="font-medium text-gray-900 truncate">${item.product_name}</div>
									<div class="text-sm text-gray-600">Rp ${rupiah(item.price)} / item</div>
								</div>
								<button type="button" class="text-sm text-gray-700 underline" data-action="remove" data-id="${item.id_product}">Hapus</button>
							</div>
							<div class="mt-3 flex items-center justify-between">
								<div class="inline-flex items-center gap-2">
									<button type="button" class="w-8 h-8 rounded border border-gray-300 text-gray-900" data-action="dec" data-id="${item.id_product}">-</button>
									<div class="w-10 text-center font-semibold text-gray-900">${item.qty}</div>
									<button type="button" class="w-8 h-8 rounded border border-gray-300 text-gray-900" data-action="inc" data-id="${item.id_product}">+</button>
								</div>
								<div class="font-semibold text-gray-900">Rp ${rupiah(item.subtotal)}</div>
							</div>
						`;
						cartItemsEl.appendChild(row);
					});
				}

				totalHargaEl.textContent = rupiah(totalCart());
			}

			function applyCategoryFilter() {
				const value = categoryFilter ? categoryFilter.value : 'all';
				productCards.forEach((card) => {
					const cardCategory = card.getAttribute('data-category') || 'none';
					const visible = value === 'all' ? true : (String(cardCategory) === String(value));
					card.style.display = visible ? '' : 'none';
				});
			}

			addButtons.forEach((button) => {
				button.addEventListener('click', () => {
					const product = {
						id_product: button.dataset.id,
						product_name: button.dataset.name,
						price: button.dataset.price,
					};
					addToCart(product);
				});
			});

			cartItemsEl.addEventListener('click', (event) => {
				const target = event.target;
				if (!(target instanceof HTMLElement)) return;
				const action = target.getAttribute('data-action');
				const idProduct = target.getAttribute('data-id');
				if (!action || !idProduct) return;

				if (action === 'inc') increment(idProduct);
				if (action === 'dec') decrement(idProduct);
				if (action === 'remove') removeItem(idProduct);
			});

			if (categoryFilter) {
				categoryFilter.addEventListener('change', applyCategoryFilter);
				applyCategoryFilter();
			}

			render();
		})();
	</script>
@endsection
