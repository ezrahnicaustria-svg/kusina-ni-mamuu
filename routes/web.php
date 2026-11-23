<?php

use App\Support\JsonStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', function () {
    return view('kusina ni mamu', [
        'menuItems' => JsonStore::read('menu.json'),
    ]);
});

Route::get('/menu', function () {
    return view('menu', [
        'menuItems' => JsonStore::read('menu.json'),
    ]);
});

Route::get('/party-trays', function () {
    return view('party-trays');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/social', function () {
    return view('social');
});

Route::get('/admin', function () {
    return view('admin', [
        'menu' => JsonStore::read('menu.json'),
        'orders' => JsonStore::read('orders.json'),
    ]);
});

Route::post('/admin/menu', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:100'],
        'category' => ['nullable', 'string', 'max:50'],
        'description' => ['nullable', 'string', 'max:255'],
        'price' => ['nullable', 'string', 'max:50'],
    ]);

    $menu = JsonStore::read('menu.json');

    $menu[] = [
        'id' => count($menu) + 1,
        'name' => trim($data['name']),
        'category' => trim($data['category'] ?? 'Lutong Bahay'),
        'description' => trim($data['description'] ?? ''),
        'price' => trim($data['price'] ?? '35 AED'),
    ];

    JsonStore::write('menu.json', $menu);

    return redirect('/admin')->with('status', 'Menu item saved to menu.json.');
});

Route::post('/admin/orders', function (Request $request) {
    $data = $request->validate([
        'customer_name' => ['required', 'string', 'max:100'],
        'dish' => ['required', 'string', 'max:100'],
        'notes' => ['nullable', 'string', 'max:200'],
    ]);

    $orders = JsonStore::read('orders.json');

    $orders[] = [
        'id' => count($orders) + 1,
        'customer_name' => trim($data['customer_name']),
        'dish' => trim($data['dish']),
        'notes' => trim($data['notes'] ?? ''),
        'status' => 'Pending',
    ];

    JsonStore::write('orders.json', $orders);

    return redirect('/admin')->with('status', 'Order added to orders.json.');
});

Route::post('/admin/orders/{id}/status', function (Request $request, string $id) {
    $data = $request->validate([
        'status' => ['required', 'string', 'in:Pending,Preparing,Done'],
    ]);

    $orders = JsonStore::read('orders.json');

    foreach ($orders as &$order) {
        if ((string) ($order['id'] ?? '') === $id) {
            $order['status'] = $data['status'];
            break;
        }
    }
    unset($order);

    JsonStore::write('orders.json', $orders);

    return redirect('/admin')->with('status', "Order {$id} updated to {$data['status']}.");
});

Route::post('/orders/submit', function (Request $request) {
    $orders = JsonStore::read('orders.json');
    $items = $request->input('items', []);

    $dishSummary = 'Order';
    if (is_array($items) && count($items) > 0) {
        $dishSummary = collect($items)->map(function ($item) {
            $name = $item['name'] ?? 'Dish';
            $qty = $item['qty'] ?? $item['quantity'] ?? 1;
            return $name . ' x' . $qty;
        })->implode(', ');
    }

    $orders[] = [
        'id' => 'ORD-' . strtoupper(substr(uniqid(), -6)),
        'customer_name' => trim((string) $request->input('customer_name', 'Guest')),
        'dish' => $dishSummary,
        'address' => trim((string) $request->input('address', '')),
        'payment_method' => trim((string) $request->input('payment_method', 'Cash on Delivery (AED)')),
        'notes' => trim((string) $request->input('notes', '')),
        'status' => 'Pending',
        'created_at' => now()->toDateTimeString(),
    ];

    JsonStore::write('orders.json', $orders);

    return response()->json(['ok' => true]);
});