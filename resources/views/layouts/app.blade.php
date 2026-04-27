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
            --brand-green: #1C2833; /* Elegant Deep Slate */
            --brand-tan: #D4AF37; /* Elegant Gold */
            --light-bg: #F8F9FA;
        }
        body { background-color: #FCFCFC; color: #2C3E50; font-family: 'Nunito', sans-serif; }
        .top-bar { letter-spacing: 0.5px; }
        .search-group { background: #F1F3F5; border-color: #E9ECEF !important; transition: all 0.3s ease; }
        .search-group:focus-within { background: #fff; box-shadow: 0 0 0 3px rgba(28, 40, 51, 0.1); border-color: #1C2833 !important; }
        .focus-none:focus { box-shadow: none; background: transparent; }
        .hover-green:hover { color: #D4AF37 !important; background-color: transparent; }
        .nav-link { transition: all 0.3s ease; font-weight: 500; letter-spacing: 0.5px; }
        header.sticky-top { top: 0; z-index: 1020; border-bottom: 1px solid rgba(0,0,0,0.05) !important; box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important; }
        .navbar-brand div { transition: transform 0.3s ease; }
        .badge { font-weight: 600; letter-spacing: 0.5px; }
        .text-shadow { text-shadow: 0 2px 5px rgba(0,0,0,0.15); }
        .shadow-hover { transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .shadow-hover:hover { transform: translateY(-6px); box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important; }
        .btn-brand-green { background-color: #1C2833; color: white; border: none; transition: all 0.3s ease; font-weight: 600; }
        .btn-brand-green:hover { background-color: #151E27; color: white; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(28, 40, 51, 0.2); }
        .btn-outline-brand-green { border: 2px solid #1C2833; color: #1C2833; background: transparent; transition: all 0.3s ease; font-weight: 600; }
        .btn-outline-brand-green:hover { background-color: #1C2833; color: white; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(28, 40, 51, 0.2); }
        .text-brand-green { color: #1C2833 !important; }
        .bg-brand-green { background-color: #1C2833 !important; }
        .x-small { font-size: 0.65rem; letter-spacing: 1.5px; text-transform: uppercase; }
        .cat-item { cursor: pointer; transition: all 0.4s ease; border: 1px solid #E9ECEF; }
        .cat-item:hover { transform: scale(1.05); background-color: #1C2833 !important; border-color: #1C2833; box-shadow: 0 10px 20px rgba(28, 40, 51, 0.15); }
        .cat-item:hover i { color: #fff !important; }
        .newsletter-section { background-color: #FCFCFC; padding: 80px 0; border-top: 1px solid #E9ECEF; }
        .footer-main { background-color: #1C2833; color: #E9ECEF; padding: 70px 0; }
        .footer-main h5 { color: #D4AF37; font-family: 'Outfit', sans-serif; letter-spacing: 1px; text-transform: uppercase; font-size: 1rem; }
        .footer-main a { color: #ADB5BD; text-decoration: none; transition: all 0.3s ease; }
        .footer-main a:hover { color: #fff; padding-left: 8px; }
        .footer-bottom { background-color: #151E27; padding: 25px 0; border-top: 1px solid rgba(255,255,255,0.05); }
        .app-badge { height: 40px; transition: transform 0.3s ease; border-radius: 8px; }
        .app-badge:hover { transform: scale(1.05); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .social-icons a { font-size: 1.2rem; color: #ADB5BD; transition: all 0.3s ease; background: rgba(255,255,255,0.05); width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; }
        .social-icons a:hover { color: #fff; background: #D4AF37; transform: translateY(-3px); }
        .payment-icons img { height: 25px; filter: grayscale(100%) opacity(0.7); transition: all 0.3s ease; margin: 0 12px; }
        .payment-icons img:hover { filter: grayscale(0%) opacity(1); }

        /* Global Bootstrap Primary Overrides */
        :root {
            --bs-primary: #1C2833;
            --bs-primary-rgb: 28, 40, 51;
            --bs-link-color: #1C2833;
            --bs-link-hover-color: #D4AF37;
        }

        .btn-primary {
            --bs-btn-bg: #1C2833;
            --bs-btn-border-color: #1C2833;
            --bs-btn-hover-bg: #151E27;
            --bs-btn-hover-border-color: #151E27;
            --bs-btn-active-bg: #151E27;
            --bs-btn-active-border-color: #151E27;
        }

        .btn-outline-primary {
            --bs-btn-color: #1C2833;
            --bs-btn-border-color: #1C2833;
            --bs-btn-hover-bg: #1C2833;
            --bs-btn-hover-border-color: #1C2833;
            --bs-btn-active-bg: #1C2833;
            --bs-btn-active-border-color: #1C2833;
        }

        .text-primary { color: #1C2833 !important; }
        .bg-primary { background-color: #1C2833 !important; }
        
        /* Pagination overrides */
        .page-item.active .page-link {
            background-color: #1C2833;
            border-color: #1C2833;
        }
        .page-link {
            color: #1C2833;
        }
        .page-link:hover {
            color: #D4AF37;
            background-color: #F8F9FA;
        }

        /* Form focus overrides */
        .form-control:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
        }

    </style>
</head>
<body>
    <div id="app">

        <!-- Main Header -->
        <header class="bg-white shadow-sm py-3 border-bottom sticky-top">
            <div class="container mt-2">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-6 col-md-3 mb-3 mb-md-0">
                        <a class="navbar-brand py-0 d-flex align-items-center text-decoration-none" href="{{ url('/') }}">
                            <span class="fw-bold fs-3 text-brand-green" style="letter-spacing: 1px; font-family: 'Outfit', sans-serif;">EcoSkin <small class="fw-normal text-muted" style="font-size: 0.6em;">Cosmetics</small></span>
                        </a>
                    </div>

                    <!-- Search Bar Center -->
                    <div class="col-12 col-md-5 order-3 order-md-2">
                        <form action="{{ Auth::check() ? route('home') : url('/') }}" method="GET">
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
                            <div class="text-center">
                                <a href="{{ route('register') }}" class="text-decoration-none text-dark d-flex flex-column align-items-center">
                                    <i class="bi bi-person-plus fs-4"></i>
                                    <span class="small d-none d-lg-block">Registrarse</span>
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
                                    <a class="dropdown-item py-2" href="{{ url('/') }}">
                                        <i class="bi bi-house me-2"></i> Inicio
                                    </a>
                                    <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-gear me-2"></i> Editar Perfil
                                    </a>
                                    <a class="dropdown-item py-2" href="{{ route('orders.index') }}">
                                        <i class="bi bi-box-seam me-2"></i> Mis Pedidos
                                    </a>
                                    @role('admin')
                                        <hr class="dropdown-divider">
                                        <a class="dropdown-item py-2" href="{{ route('admin.orders.index') }}">
                                            <i class="bi bi-speedometer2 me-2"></i> Panel de Admin
                                        </a>
                                    @endrole
                                    <hr class="dropdown-divider">
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
                            <li class="mb-2"><a href="{{ route('about') }}">Quiénes somos</a></li>
                            <li class="mb-2"><a href="{{ route('about') }}#valores">Compromiso sostenible</a></li>
                            <li class="mb-2"><a href="{{ route('about') }}#fundadora">Nuestra fundadora</a></li>
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
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" style="height: 25px;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" alt="Stripe" style="height: 20px;">
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
