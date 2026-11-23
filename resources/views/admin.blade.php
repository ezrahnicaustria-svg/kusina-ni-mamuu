<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Kusina ni Mamu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/kusina ni mamu.css') }}">
    <style>
        .admin-page-wrap {
            padding: 36px 0 60px;
        }
        .admin-header-box {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
            align-items: start;
        }
        .admin-card {
            background: #FFFFFF;
            color: #111111;
            border: 2.5px solid #111111;
            border-radius: 16px;
            padding: 22px;
        }
        .admin-card h2 {
            margin-bottom: 14px;
            font-size: 22px;
            color: #111111;
        }
        .admin-field {
            margin-bottom: 14px;
        }
        .admin-field label {
            display: block;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 6px;
            color: #111111;
        }
        .order-item-card {
            background: #FFFDF5;
            border: 2px solid #111111;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 14px;
            color: #111111;
        }
        .order-status-badge {
            display: inline-block;
            background: #FFC814;
            color: #111111;
            border: 1.5px solid #111111;
            border-radius: 999px;
            padding: 2px 10px;
            font-size: 12px;
            font-weight: 800;
        }
        .order-status-form {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
            align-items: center;
        }
        .order-status-select {
            padding: 8px 12px;
            border: 2px solid #111111;
            border-radius: 10px;
            background: #FFFFFF;
            color: #111111;
            font-weight: 700;
        }
        .admin-btn-yellow {
            background: #FFC814;
            color: #111111;
            border: 2px solid #111111;
            border-radius: 10px;
            padding: 10px 16px;
            font-weight: 800;
            cursor: pointer;
        }
        .admin-btn-dark {
            background: #111111;
            color: #FFC814;
            border: 2px solid #111111;
            border-radius: 10px;
            padding: 9px 14px;
            font-weight: 800;
            cursor: pointer;
        }
        .admin-alert {
            background: #FFEC99;
            color: #111111;
            border: 2px solid #111111;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-weight: 700;
        }
    </style>
</head>
<body class="mamu-body" data-page="admin">
    <header class="site-header">
        <div class="container header-inner">
            <a href="/home" class="brand-link">
                <span class="brand-logo-box mamu-card-shadow">
                    <svg viewBox="0 0 120 120" class="svg-full" aria-label="Kusina ni Mamu">
                        <rect width="120" height="120" fill="#FFC814" />
                        <text x="60" y="24" text-anchor="middle" fill="#111111" font-family="Outfit, sans-serif" font-weight="900" font-size="12" letter-spacing="1">KUSINA NI</text>
                        <ellipse cx="60" cy="40" rx="12" ry="8" fill="#111111" />
                        <path d="M 32,62 C 32,45 88,45 88,62 L 83,70 C 71,62 49,62 37,70 Z" fill="#111111" />
                        <circle cx="46" cy="76" r="10" fill="none" stroke="#111111" stroke-width="4.5" />
                        <circle cx="74" cy="76" r="10" fill="none" stroke="#111111" stroke-width="4.5" />
                        <line x1="56" y1="75" x2="64" y2="75" stroke="#111111" stroke-width="4.5" stroke-linecap="round" />
                        <path d="M 52,90 Q 60,96 68,90" fill="none" stroke="#111111" stroke-width="4.5" stroke-linecap="round" />
                    </svg>
                </span>
                <span class="brand-text">
                    <span class="brand-kicker">Kusina ni</span>
                    <span class="brand-name font-display">MAMU</span>
                </span>
            </a>

            <nav class="desktop-nav">
                <a href="/home">Home</a>
                <a href="/menu">Menu</a>
                <a href="/party-trays">Party Trays</a>
                <a href="/about">About Mamu</a>
                <a href="/social">Social</a>
            </nav>

            <div class="header-actions">
                <a href="/admin" class="btn-tray mamu-card-shadow active-nav">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Admin</span>
                </a>
                <button type="button" onclick="toggleMobileMenu()" class="mobile-menu-btn" aria-label="Toggle menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        <div id="mobileMenu" class="mobile-menu hidden">
            <a href="/home">Home</a>
            <a href="/menu">Menu</a>
            <a href="/party-trays">Party Trays</a>
            <a href="/about">About Mamu</a>
            <a href="/social">Social</a>
            <a href="/admin">Admin</a>
        </div>
    </header>

    <main class="container admin-page-wrap">
        <div class="admin-header-box">
            <div>
                <span class="section-pill">Store Management</span>
                <h1 class="section-title font-display" style="margin-top: 6px;">Admin Panel</h1>
            </div>
        </div>

        @if (session('status'))
            <div class="admin-alert mamu-card-shadow">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="admin-alert mamu-card-shadow" style="background: #ffd6d6;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-grid">
            <section class="admin-card mamu-card-shadow">
                <h2 class="font-display">Add Menu Item (menu.json)</h2>
                <form action="/admin/menu" method="POST">
                    @csrf

                    <div class="admin-field">
                        <label for="dishName">Dish Name</label>
                        <input id="dishName" type="text" name="name" value="{{ old('name') }}" required class="form-input">
                    </div>

                    <div class="admin-field">
                        <label for="dishCategory">Category</label>
                        <input id="dishCategory" type="text" name="category" value="{{ old('category', 'Lutong Bahay') }}" class="form-input">
                    </div>

                    <div class="admin-field">
                        <label for="dishDescription">Description</label>
                        <input id="dishDescription" type="text" name="description" value="{{ old('description') }}" class="form-input">
                    </div>

                    <div class="admin-field">
                        <label for="dishPrice">Price</label>
                        <input id="dishPrice" type="text" name="price" value="{{ old('price', '35 AED') }}" class="form-input">
                    </div>

                    <button type="submit" class="admin-btn-yellow mamu-card-shadow">
                        <i class="fa-solid fa-plus"></i> Save Dish
                    </button>
                </form>
            </section>

            <section class="admin-card mamu-card-shadow">
                <h2 class="font-display">Orders (orders.json)</h2>

                @forelse ($orders ?? [] as $order)
                    @php
                        $orderId = $order['id'] ?? $loop->iteration;
                        $currentStatus = $order['status'] ?? 'Pending';
                        $dishDisplay = $order['dish'] ?? '';
                        if ($dishDisplay === '' && !empty($order['items']) && is_array($order['items'])) {
                            $dishDisplay = collect($order['items'])->map(function ($item) {
                                $name = $item['name'] ?? 'Dish';
                                $qty = $item['qty'] ?? $item['quantity'] ?? 1;
                                return $name . ' x' . $qty;
                            })->implode(', ');
                        }
                    @endphp

                    <div class="order-item-card">
                        <div style="font-weight: 800; font-size: 16px; margin-bottom: 4px;">
                            {{ $orderId }} — {{ $order['customer_name'] ?? 'Guest' }} ({{ $dishDisplay }})
                        </div>
                        <div style="font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                            Address: {{ $order['address'] ?? '' }}
                            | Payment: {{ $order['payment_method'] ?? 'Cash on Delivery' }}
                            | Notes: {{ $order['notes'] ?? '' }}
                            | Status: <span class="order-status-badge">{{ $currentStatus }}</span>
                        </div>

                        <form action="/admin/orders/{{ $orderId }}/status" method="POST" class="order-status-form">
                            @csrf
                            <select name="status" class="order-status-select">
                                <option value="Pending" {{ $currentStatus === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Preparing" {{ $currentStatus === 'Preparing' ? 'selected' : '' }}>Preparing</option>
                                <option value="Done" {{ $currentStatus === 'Done' ? 'selected' : '' }}>Done</option>
                            </select>
                            <button type="submit" class="admin-btn-dark mamu-card-shadow">Update Status</button>
                        </form>
                    </div>
                @empty
                    <p style="font-weight: 600;">No orders found in orders.json.</p>
                @endforelse
            </section>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container footer-bottom">
            <span>&copy; 2026 Kusina ni Mamu UAE.</span>
            <span>Lutong Bahay na May Pagmamahal 🇵🇭</span>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>