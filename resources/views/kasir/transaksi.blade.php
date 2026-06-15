@extends('layouts.kasir')

@section('title', 'Transaksi Kasir')
@section('section', 'Kasir')
@section('pageTitle', 'Transaksi Baru')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
	<!-- Left: Products -->
	<div class="lg:col-span-8">
		<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
			<div>
				<h2 class="text-lg font-bold text-gray-900">Pilih Menu</h2>
				<p class="text-sm text-gray-500 mt-0.5">Klik menu untuk menambah ke keranjang.</p>
			</div>
			<div class="w-full sm:w-56">
				<select id="category-filter" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none font-medium">
					<option value="all">Semua Kategori</option>
					@foreach ($categories as $category)
						<option value="{{ $category->id_category }}">{{ $category->category_name }}</option>
					@endforeach
					<option value="none">Tanpa Kategori</option>
				</select>
			</div>
		</div>

		<div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
			@forelse ($products as $product)
				<div class="product-card group bg-white border border-gray-200 rounded-xl p-5 hover:border-brand-300 hover:shadow-md transition-all cursor-pointer flex flex-col justify-between"
					data-category="{{ $product->id_category ?? 'none' }}"
					data-action="add"
					data-id="{{ $product->id_product }}"
					data-name="{{ $product->product_name }}"
					data-price="{{ $product->price }}">
					<div>
						<span class="inline-flex px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 text-[11px] font-bold uppercase tracking-wide mb-3">
							{{ $product->category_name ?? 'Tanpa Kategori' }}
						</span>
						<h3 class="font-bold text-gray-900 text-base group-hover:text-brand-600 transition-colors">{{ $product->product_name }}</h3>
					</div>
					<div class="mt-4 flex items-center justify-between">
						<span class="font-bold text-brand-600">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
						<span class="w-8 h-8 rounded-lg bg-brand-50 text-brand-500 flex items-center justify-center group-hover:bg-brand-500 group-hover:text-white transition-all">
							<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v12m6-6H6"/></svg>
						</span>
					</div>
				</div>
			@empty
				<div class="col-span-full py-12 text-center text-gray-400 bg-white rounded-xl border border-dashed border-gray-300">
					Belum ada menu produk yang tersedia.
				</div>
			@endforelse
		</div>
	</div>

	<!-- Right: Cart -->
	<div class="lg:col-span-4">
		<div class="sticky top-24 bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col" style="max-height: calc(100vh - 120px);">
			<div class="p-5 border-b border-gray-100 flex items-center gap-2">
				<svg class="w-5 h-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
				<h2 class="text-lg font-bold text-gray-900">Keranjang</h2>
			</div>

			<form id="checkout-form" class="flex-1 flex flex-col overflow-hidden" method="POST" action="{{ url('/kasir/transaksi/checkout') }}">
				@csrf
				<input type="hidden" name="cart_data" id="cart_data" value="[]" />

				<div class="flex-1 overflow-y-auto p-5">
					<div id="cart-empty" class="flex flex-col items-center justify-center text-gray-400 gap-3 py-8">
						<svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
						<p class="text-sm">Keranjang masih kosong</p>
					</div>
					<div id="cart-items" class="space-y-3"></div>
				</div>

				<div class="p-5 border-t border-gray-100 bg-gray-50">
					<div class="flex items-center justify-between mb-4">
						<span class="text-sm font-semibold text-gray-500">Total Tagihan</span>
						<span class="text-xl font-bold text-gray-900">Rp <span id="total-harga">0</span></span>
					</div>
					<button type="button" id="btn-show-modal" class="w-full rounded-lg bg-brand-500 text-white py-3 font-bold text-sm hover:bg-brand-600 shadow-sm transition-colors disabled:opacity-40 disabled:cursor-not-allowed" disabled>
						Proses Pembayaran
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Konfirmasi -->
<div id="confirmation-modal" class="fixed inset-0 z-50 hidden">
	<div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity opacity-0" id="modal-backdrop"></div>
	<div class="absolute inset-0 flex items-center justify-center p-4">
		<div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm transform scale-95 opacity-0 transition-all duration-300" id="modal-panel">
			<div class="p-8 text-center">
				<div class="w-14 h-14 rounded-full bg-brand-50 flex items-center justify-center mx-auto mb-4 text-brand-600">
					<svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
				</div>
				<h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Pembayaran</h3>
				<p class="text-gray-500 text-sm mb-6">Total yang harus dibayar:</p>
				<div class="bg-gray-50 rounded-xl p-5 border border-gray-100 mb-6">
					<p class="text-2xl font-bold text-brand-600">Rp <span id="modal-total-harga">0</span></p>
				</div>
				<div class="flex gap-3">
					<button type="button" id="btn-cancel" class="flex-1 py-3 px-4 rounded-lg text-gray-700 bg-white border border-gray-300 font-bold text-sm hover:bg-gray-50 transition-colors">
						Batal
					</button>
					<button type="button" id="btn-confirm-checkout" class="flex-1 py-3 px-4 rounded-lg text-white bg-brand-500 font-bold text-sm hover:bg-brand-600 shadow-sm transition-colors">
						Bayar Sekarang
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
	(function () {
		const categoryFilter = document.getElementById('category-filter');
		const productCards = Array.from(document.querySelectorAll('.product-card'));
		const cartDataInput = document.getElementById('cart_data');
		const cartEmptyEl = document.getElementById('cart-empty');
		const cartItemsEl = document.getElementById('cart-items');
		const totalHargaEl = document.getElementById('total-harga');
		const btnShowModal = document.getElementById('btn-show-modal');
		const modal = document.getElementById('confirmation-modal');
		const modalBackdrop = document.getElementById('modal-backdrop');
		const modalPanel = document.getElementById('modal-panel');
		const modalTotalHarga = document.getElementById('modal-total-harga');
		const btnCancel = document.getElementById('btn-cancel');
		const btnConfirmCheckout = document.getElementById('btn-confirm-checkout');
		const checkoutForm = document.getElementById('checkout-form');

		let cart = [];

		function rupiah(number) {
			return new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(number || 0);
		}

		function syncHiddenInput() { cartDataInput.value = JSON.stringify(cart); }
		function totalCart() { return cart.reduce((sum, item) => sum + (parseFloat(item.subtotal) || 0), 0); }
		function findItem(idProduct) { return cart.find(item => item.id_product === idProduct); }

		function addToCart(product) {
			const idProduct = String(product.id_product);
			const existing = findItem(idProduct);
			if (existing) { existing.qty += 1; existing.subtotal = existing.qty * existing.price; }
			else { cart.push({ id_product: idProduct, product_name: String(product.product_name), price: parseFloat(product.price) || 0, qty: 1, subtotal: parseFloat(product.price) || 0 }); }
			render();
		}

		function increment(idProduct) { const item = findItem(idProduct); if (!item) return; item.qty += 1; item.subtotal = item.qty * item.price; render(); }
		function decrement(idProduct) { const item = findItem(idProduct); if (!item) return; item.qty -= 1; if (item.qty <= 0) { removeItem(idProduct); return; } item.subtotal = item.qty * item.price; render(); }
		function removeItem(idProduct) { cart = cart.filter(item => item.id_product !== idProduct); render(); }

		function render() {
			syncHiddenInput();
			const isEmpty = cart.length === 0;
			cartEmptyEl.style.display = isEmpty ? 'flex' : 'none';
			btnShowModal.disabled = isEmpty;
			cartItemsEl.innerHTML = '';
			if (!isEmpty) {
				cart.forEach((item) => {
					const row = document.createElement('div');
					row.className = 'p-3 bg-white border border-gray-200 rounded-lg';
					row.innerHTML = `
						<div class="flex items-start justify-between gap-2 mb-2">
							<div class="min-w-0 flex-1">
								<p class="font-bold text-gray-900 text-sm leading-tight">${item.product_name}</p>
								<p class="text-xs text-gray-500 mt-0.5">Rp ${rupiah(item.price)}</p>
							</div>
							<button type="button" class="w-7 h-7 flex items-center justify-center rounded text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors shrink-0" data-action="remove" data-id="${item.id_product}">
								<svg class="w-4 h-4 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
							</button>
						</div>
						<div class="flex items-center justify-between">
							<div class="inline-flex items-center gap-1 bg-gray-100 rounded-lg p-0.5">
								<button type="button" class="w-7 h-7 flex items-center justify-center rounded text-gray-600 hover:bg-white hover:shadow-sm transition-all font-bold" data-action="dec" data-id="${item.id_product}">−</button>
								<span class="w-7 text-center font-bold text-sm text-gray-900">${item.qty}</span>
								<button type="button" class="w-7 h-7 flex items-center justify-center rounded text-brand-600 hover:bg-white hover:shadow-sm transition-all font-bold" data-action="inc" data-id="${item.id_product}">+</button>
							</div>
							<span class="font-bold text-gray-900 text-sm">Rp ${rupiah(item.subtotal)}</span>
						</div>
					`;
					cartItemsEl.appendChild(row);
				});
			}
			const total = totalCart();
			totalHargaEl.textContent = rupiah(total);
			modalTotalHarga.textContent = rupiah(total);
		}

		function applyCategoryFilter() {
			const value = categoryFilter ? categoryFilter.value : 'all';
			productCards.forEach((card) => {
				const cardCategory = card.getAttribute('data-category') || 'none';
				card.style.display = (value === 'all' || String(cardCategory) === String(value)) ? '' : 'none';
			});
		}

		productCards.forEach((card) => { card.addEventListener('click', () => { addToCart({ id_product: card.dataset.id, product_name: card.dataset.name, price: card.dataset.price }); }); });

		cartItemsEl.addEventListener('click', (event) => {
			const target = event.target.closest('button');
			if (!target) return;
			const action = target.getAttribute('data-action');
			const idProduct = target.getAttribute('data-id');
			if (!action || !idProduct) return;
			if (action === 'inc') increment(idProduct);
			if (action === 'dec') decrement(idProduct);
			if (action === 'remove') removeItem(idProduct);
		});

		if (categoryFilter) { categoryFilter.addEventListener('change', applyCategoryFilter); applyCategoryFilter(); }

		function openModal() { modal.classList.remove('hidden'); setTimeout(() => { modalBackdrop.classList.remove('opacity-0'); modalPanel.classList.remove('opacity-0', 'scale-95'); modalPanel.classList.add('opacity-100', 'scale-100'); }, 10); }
		function closeModal() { modalBackdrop.classList.add('opacity-0'); modalPanel.classList.remove('opacity-100', 'scale-100'); modalPanel.classList.add('opacity-0', 'scale-95'); setTimeout(() => { modal.classList.add('hidden'); }, 300); }

		btnShowModal.addEventListener('click', openModal);
		btnCancel.addEventListener('click', closeModal);
		modalBackdrop.addEventListener('click', closeModal);
		btnConfirmCheckout.addEventListener('click', () => { btnConfirmCheckout.innerHTML = 'Memproses...'; btnConfirmCheckout.disabled = true; checkoutForm.submit(); });

		render();
	})();
</script>
@endsection
