@extends('layouts.app')

@section('title', 'Kasir')
@section('section', 'Kasir Cabang')
@section('pageTitle', 'Transaksi')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Daftar Menu</h2>
                <div class="text-xs text-gray-600">Pilih menu untuk menambah ke keranjang</div>
            </div>
            <div class="mt-3 divide-y divide-gray-100">
                @forelse ($products as $product)
                    <div class="py-3 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <div class="font-medium text-gray-900 truncate">{{ $product->product_name }}</div>
                            <div class="text-sm text-gray-600">Rp {{ number_format((float) $product->price, 2, ',', '.') }}</div>
                        </div>

                        <button
                            type="button"
                            class="shrink-0 rounded-md bg-gray-900 text-white px-3 py-2 text-sm font-medium hover:bg-gray-800"
                            data-action="add"
                            data-id="{{ $product->id_product }}"
                            data-name="{{ $product->product_name }}"
                            data-price="{{ $product->price }}"
                        >
                            + Tambah
                        </button>
                    </div>
                @empty
                    <div class="py-6 text-sm text-gray-600">Belum ada produk.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <h2 class="font-semibold text-gray-900">Keranjang</h2>

            <form id="checkout-form" class="mt-3 space-y-3" method="POST" action="{{ url('/checkout') }}">
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

            document.querySelectorAll('[data-action="add"]').forEach((button) => {
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

            render();
        })();
    </script>
@endsection