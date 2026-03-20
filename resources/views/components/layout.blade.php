<!doctype html>
<html lang="en">

<head>
    <title>Yana's page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">

    <!-- Slot para CSS personalizado -->
    {{-- {{ $css ?? '' }} --}}
    @yield('css')

    <style>
        :root {
            --brand-green: #58624A;
            --brand-tan: #BA9B72;
            --bs-primary: #58624A;
            --bs-primary-rgb: 88, 98, 74;
            --light-bg: #f8faf8;
        }
        body { background-color: #fff; }
        .navbar-brand div { transition: transform 0.3s ease; }
        .btn-brand-green { background-color: #58624A; color: white; border: none; transition: all 0.3s ease; }
        .btn-brand-green:hover { background-color: #4a533e; color: white; transform: scale(1.05); }
        .text-primary { color: var(--brand-green) !important; }
        .search-group { background: #f1f3f1; border-color: #e1e4e1 !important; transition: all 0.3s ease; }
        .search-group:focus-within { background: #fff; box-shadow: 0 0 0 3px rgba(88, 98, 74, 0.1); border-color: #58624A !important; }
        .focus-none:focus { box-shadow: none; background: transparent; }
        
        .page-item.active .page-link {
            background-color: var(--brand-green) !important;
            border-color: var(--brand-green) !important;
        }
        .page-link { color: var(--brand-green); }
        .form-control:focus {
            border-color: var(--brand-green);
            box-shadow: 0 0 0 0.25rem rgba(88, 98, 74, 0.25);
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
                        @else
                            <div class="dropdown">
                                <a id="userDropdown" class="text-decoration-none text-dark d-flex flex-column align-items-center dropdown-toggle" 
                                   href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-person fs-4"></i>
                                    <span class="small d-none d-lg-block">{{ Auth::user()->name }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-3" aria-labelledby="userDropdown">
                                    <a class="dropdown-item py-2" href="#">
                                        <i class="bi bi-person-gear me-2"></i> Editar Perfil
                                    </a>
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
        {{ $slot }}
    </main>
    <!-- Main Footer -->
    <footer class="bg-success text-white py-5 mt-5" style="background-color: #58624A !important;">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <h5 class="fw-bold mb-4">Ayuda</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none"><i class="bi bi-chat-dots me-2"></i>Preguntas frecuentes</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none"><i class="bi bi-envelope me-2"></i>Formulario de contacto</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h5 class="fw-bold mb-4">Sobre Nosotros</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Quiénes somos</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Compromiso sostenible</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Programa de fidelidad</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-2">
                    <h5 class="fw-bold mb-4">Marcas</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Todas las marcas</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Procare Health</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Solgar</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">SVR</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Sesderma</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold mb-4">Descarga nuestra APP</h5>
                    <div class="d-flex gap-2 mb-4">
                        <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store" style="height: 35px;"></a>
                        <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" style="height: 35px;"></a>
                    </div>
                    <div class="social-icons d-flex gap-3">
                        <a href="#" class="text-white fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-white opacity-25">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <div class="payment-icons d-flex justify-content-center align-items-center gap-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" style="height: 25px; filter: brightness(0) invert(1);">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" alt="Stripe" style="height: 20px; filter: brightness(0) invert(1);">
                        <span class="small ms-3">© {{ date('Y') }} EcoSkin Cosmetics. Todos los derechos reservados.</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Slot para JS personalizado -->
    {{-- {{ $js ?? '' }} --}}
    @yield('js')
</body>

</html>
