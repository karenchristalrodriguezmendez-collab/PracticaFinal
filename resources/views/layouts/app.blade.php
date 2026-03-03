<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Page-specific styles -->
    @stack('styles')
    <style>
        :root {
            --brand-green: #58624A;
            --brand-tan: #BA9B72;
            --light-bg: #f8faf8;
        }
        body { background-color: #fff; }
        .top-bar { letter-spacing: 0.5px; }
        .search-group { background: #f1f3f1; border-color: #e1e4e1 !important; transition: all 0.3s ease; }
        .search-group:focus-within { background: #fff; box-shadow: 0 0 0 3px rgba(88, 98, 74, 0.1); border-color: #58624A !important; }
        .focus-none:focus { box-shadow: none; background: transparent; }
        .hover-green:hover { color: #58624A !important; background-color: #f8faf8; }
        .nav-link { transition: all 0.2s ease; }
        header.sticky-top { top: 0; z-index: 1020; }
        .navbar-brand div { transition: transform 0.3s ease; }
        .badge { font-weight: 600; }
        .text-shadow { text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .shadow-hover { transition: all 0.3s ease; }
        .shadow-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .btn-brand-green { background-color: #58624A; color: white; border: none; transition: all 0.3s ease; }
        .btn-brand-green:hover { background-color: #4a533e; color: white; transform: scale(1.05); }
        .btn-outline-brand-green { border: 2px solid #58624A; color: #58624A; background: transparent; transition: all 0.3s ease; }
        .btn-outline-brand-green:hover { background-color: #58624A; color: white; }
        .x-small { font-size: 0.65rem; letter-spacing: 1px; }
        .cat-item { cursor: pointer; transition: all 0.3s ease; }
        .cat-item:hover { transform: scale(1.1); background-color: #58624A !important; }
        .cat-item:hover i { color: #fff !important; }
        .newsletter-section { background-color: #fff; padding: 60px 0; border-top: 1px solid #eee; }
        .footer-main { background-color: #58624A; color: #fff; padding: 60px 0; }
        .footer-main a { color: rgba(255,255,255,0.8); text-decoration: none; transition: all 0.3s ease; }
        .footer-main a:hover { color: #fff; padding-left: 5px; }
        .footer-bottom { background-color: #fff; padding: 30px 0; border-top: 1px solid #eee; }
        .app-badge { height: 40px; transition: transform 0.3s ease; }
        .app-badge:hover { transform: scale(1.05); }
        .social-icons a { font-size: 1.5rem; color: #fff; opacity: 0.8; transition: opacity 0.3s ease; }
        .social-icons a:hover { opacity: 1; }
        .payment-icons img { height: 25px; filter: grayscale(100%); opacity: 0.6; transition: all 0.3s ease; margin: 0 10px; }
        .payment-icons img:hover { filter: grayscale(0%); opacity: 1; }

        /* Global Bootstrap Primary Overrides */
        :root {
            --bs-primary: #58624A;
            --bs-primary-rgb: 88, 98, 74;
            --bs-link-color: #58624A;
            --bs-link-hover-color: #3d4433;
        }

        .btn-primary {
            --bs-btn-bg: #58624A;
            --bs-btn-border-color: #58624A;
            --bs-btn-hover-bg: #3d4433;
            --bs-btn-hover-border-color: #3d4433;
            --bs-btn-active-bg: #3d4433;
            --bs-btn-active-border-color: #3d4433;
        }

        .btn-outline-primary {
            --bs-btn-color: #58624A;
            --bs-btn-border-color: #58624A;
            --bs-btn-hover-bg: #58624A;
            --bs-btn-hover-border-color: #58624A;
            --bs-btn-active-bg: #58624A;
            --bs-btn-active-border-color: #58624A;
        }

        .text-primary { color: #58624A !important; }
        .bg-primary { background-color: #58624A !important; }
        
        /* Pagination overrides */
        .page-item.active .page-link {
            background-color: #58624A;
            border-color: #58624A;
        }
        .page-link {
            color: #58624A;
        }
        .page-link:hover {
            color: #3d4433;
        }

        /* Form focus overrides */
        .form-control:focus {
            border-color: #58624A;
            box-shadow: 0 0 0 0.25rem rgba(88, 98, 74, 0.25);
        }

    </style>
</head>
<body>
    <div id="app">
    <div id="app">
        <!-- Top Bar -->
        <div class="top-bar text-white py-1 text-center" style="background-color: #58624A; font-size: 0.85rem;">
            <div class="container d-flex justify-content-between">
                <div><i class="bi bi-clock me-1"></i> Envío gratis en tu primer pedido</div>
                <div class="d-none d-md-block">¿Necesitas ayuda? <i class="bi bi-whatsapp ms-1"></i></div>
            </div>
        </div>

        <!-- Main Header -->
        <header class="bg-white shadow-sm py-3 border-bottom sticky-top">
            <div class="container mt-2">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-6 col-md-3 mb-3 mb-md-0">
                        <a class="navbar-brand d-flex align-items-center d-inline-block text-decoration-none" href="{{ url('/') }}">
                            <img src="{{ asset('images/logo.png') }}" alt="EcoSkin Cosmetics" style="height: 50px; object-fit: contain;" onerror="this.onerror=null; this.insertAdjacentHTML('afterend', '<span class=\'h4 mb-0 fw-bold\' style=\'color: #58624A; letter-spacing: 1px;\'>ECOSKIN</span>'); this.style.display='none';">
                        </a>
                    </div>

                    <!-- Search Bar Center -->
                    <div class="col-12 col-md-5 order-3 order-md-2">
                        <form action="{{ url('/') }}" method="GET">
                            <div class="input-group search-group rounded-pill overflow-hidden border">
                                <span class="input-group-text bg-white border-0 ps-3">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-0 py-2 focus-none" 
                                    placeholder="¿Qué buscas hoy?" value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>

                    <!-- Actions Right -->
                    <div class="col-6 col-md-4 order-2 order-md-3 text-end d-flex justify-content-end align-items-center gap-3">
                        @guest
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-decoration-none text-dark d-flex flex-column align-items-center">
                                    <i class="bi bi-person fs-4"></i>
                                    <span class="small d-none d-lg-block">Iniciar sesión</span>
                                </a>
                            </div>
                        @else
                            <div class="dropdown">
                                <a id="userDropdown" class="text-decoration-none text-dark d-flex flex-column align-items-center dropdown-toggle" 
                                   href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-person fs-4"></i>
                                    <span class="small d-none d-lg-block">{{ Auth::user()->name }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-3" aria-labelledby="userDropdown">
                                    @role('admin')
                                        <a class="dropdown-item py-2" href="{{ route('admin.orders.index') }}">
                                            <i class="bi bi-box-seam me-2"></i> Administrar Pedidos
                                        </a>
                                        <hr class="dropdown-divider">
                                    @endrole
                                    <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </div>
                        @endguest

                        <div class="text-center position-relative">
                            <a href="{{ route('orders.index') }}" class="text-decoration-none text-dark d-flex flex-column align-items-center">
                                <i class="bi bi-box-seam fs-4"></i>
                                <span class="small d-none d-lg-block">Mis pedidos</span>
                            </a>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark d-flex flex-column align-items-center position-relative">
                                <i class="bi bi-cart3 fs-4"></i>
                                <span class="small d-none d-lg-block">Carrito</span>
                                @php $cartCount = auth()->check() ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity') : 0; @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-badge" style="font-size: 10px;">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Categories Nav -->
        <nav class="bg-white border-bottom d-none d-md-block">
            <div class="container">
                <ul class="nav nav-fill py-1 justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium small hover-green" href="{{ url('/') }}">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium small hover-green" href="{{ route('companies.index') }}">Nuestras Marcas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium small hover-green" href="#">Cosmética</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium small hover-green" href="#">Higiene</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium small hover-green" href="#">Promociones</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <!-- Newsletter Section -->
        <section class="newsletter-section text-center">
            <div class="container text-center">
                <h2 class="fw-bold mb-2">Suscríbete a las mejores ofertas</h2>
                <p class="text-muted mb-4"><i class="bi bi-award text-success me-2"></i>Obtendrás <strong>50 puntos</strong> que podrás canjear por descuentos en tu próxima compra</p>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form class="d-flex gap-2">
                            <input type="email" class="form-control form-control-lg rounded-pill px-4 border-2" placeholder="Introduce tu correo electrónico *" required>
                            <button type="submit" class="btn btn-brand-green btn-lg rounded-pill px-5 fw-bold">Suscríbete</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Footer -->
        <footer class="footer-main">
            <div class="container">
                <div class="row g-4 text-start">
                    <div class="col-6 col-md-3">
                        <h5 class="fw-bold mb-4">Ayuda</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#"><i class="bi bi-chat-dots me-2"></i>Preguntas frecuentes</a></li>
                            <li class="mb-2"><a href="#"><i class="bi bi-envelope me-2"></i>Formulario de contacto</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <h5 class="fw-bold mb-4">Sobre Nosotros</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#">Quiénes somos</a></li>
                            <li class="mb-2"><a href="#">Compromiso sostenible</a></li>
                            <li class="mb-2"><a href="#">Programa de fidelidad</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-2">
                        <h5 class="fw-bold mb-4">Marcas</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#">Todas las marcas</a></li>
                            <li class="mb-2"><a href="#">Procare Health</a></li>
                            <li class="mb-2"><a href="#">Solgar</a></li>
                            <li class="mb-2"><a href="#">SVR</a></li>
                            <li class="mb-2"><a href="#">Sesderma</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 text-start">
                        <h5 class="fw-bold mb-4">Descarga nuestra APP</h5>
                        <div class="d-flex gap-2 mb-4">
                            <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store" class="app-badge"></a>
                            <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" class="app-badge"></a>
                        </div>
                        <p class="fw-bold mb-3">¿Quieres saber más sobre salud natural?</p>
                        <a href="#" class="btn btn-light rounded-pill px-4 fw-bold text-brand-green mb-4">Entra en nuestro blog</a>
                        <div class="social-icons d-flex gap-3">
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-youtube"></i></a>
                            <a href="#"><i class="bi bi-tiktok"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Footer Bottom -->
        <div class="footer-bottom text-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0 d-flex justify-content-center align-items-center gap-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/B_Corp_Logo.png" alt="B Corp" style="height: 40px;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e3/Trusted_Shops_logo.svg" alt="Trusted Shops" style="height: 30px;">
                    </div>
                    <div class="col-md-8">
                        <div class="payment-icons d-flex justify-content-center flex-wrap align-items-center">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b7/PayPal_Logo_Icon_2014.svg" alt="PayPal">
                            <span class="text-muted small ms-3">© {{ date('Y') }} EcoSkin Cosmetics. Todos los derechos reservados.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')

    <script>
        $(document).ready(function() {
            @guest
                // Redirect if cached page accessed without authentication
                $(window).on('pageshow', function(event) {
                    if (event.originalEvent && event.originalEvent.persisted) {
                        window.location.replace('/');
                    }
                });
            @endguest

            @auth
                // usuarios autentificados, redireccionarlos a su home
                if (window.location.pathname.includes('login') || window.location.pathname.includes('register')) {
                    window.location.replace('/home');
                }
            @endauth
        });
    </script>
</body>
</html>
