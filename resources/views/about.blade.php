@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    .about-hero {
        min-height: 420px;
        background: linear-gradient(135deg, #1C2833 0%, #2C3E50 60%, #1a252f 100%);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    .about-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .about-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.05) 0%, transparent 70%);
        pointer-events: none;
    }
    .gold-divider {
        width: 60px;
        height: 2px;
        background: linear-gradient(90deg, #D4AF37, #F0D060, #D4AF37);
        margin: 0 auto 1.5rem;
    }
    .gold-divider-left {
        margin: 0 0 1.5rem;
    }
    .value-card {
        border: 1px solid rgba(28, 40, 51, 0.07);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        background: #fff;
    }
    .value-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(28, 40, 51, 0.08) !important;
        border-color: #D4AF37;
    }
    .value-icon {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(212, 175, 55, 0.08);
        margin: 0 auto 1.25rem;
        transition: all 0.3s ease;
    }
    .value-card:hover .value-icon {
        background: #1C2833;
        color: #D4AF37 !important;
    }
    .founder-card {
        background: #fff;
        border: 1px solid rgba(28, 40, 51, 0.07);
    }
    .founder-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1C2833, #2C3E50);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 4px solid #D4AF37;
        font-size: 3rem;
        color: #D4AF37;
    }
    .stat-number {
        font-family: 'Outfit', sans-serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #1C2833;
        line-height: 1;
    }
    .stat-label {
        font-size: 0.8rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #6c757d;
    }
    .section-label {
        font-size: 0.75rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #D4AF37;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<section class="about-hero">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <p class="section-label mb-3">Nuestra Historia</p>
                <h1 class="display-4 fw-light text-white mb-4" style="font-family: 'Outfit', sans-serif; line-height: 1.2;">
                    Sobre <span class="fw-bold" style="color: #D4AF37;">Nosotros</span>
                </h1>
                <p class="lead fw-light" style="color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto; line-height: 1.7;">
                    Somos una marca dedicada a transformar tu rutina de cuidado personal con productos premium, sostenibles y cuidadosamente seleccionados.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Stats Bar --}}
<section class="py-5 bg-white border-bottom">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div class="stat-number">500+</div>
                <div class="stat-label mt-1">Productos</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">10K+</div>
                <div class="stat-label mt-1">Clientes felices</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">50+</div>
                <div class="stat-label mt-1">Marcas premium</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">5</div>
                <div class="stat-label mt-1">Años de experiencia</div>
            </div>
        </div>
    </div>
</section>

{{-- Mission & Vision --}}
<section class="py-6" style="padding: 80px 0; background: #FCFCFC;">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <p class="section-label mb-3">Quiénes somos</p>
                <div class="gold-divider gold-divider-left"></div>
                <h2 class="fw-light mb-4" style="font-family: 'Outfit', sans-serif; font-size: 2.2rem; color: #1C2833; line-height: 1.3;">
                    Belleza con propósito,<br><span class="fw-bold">con conciencia</span>
                </h2>
                <p class="text-muted mb-4" style="line-height: 1.8; font-size: 1.05rem;">
                    En <strong style="color: #1C2833;">EcoSkin Cosmetics</strong> creemos que la belleza verdadera comienza con ingredientes honestos. Desde nuestros inicios, hemos construido una comunidad de personas que entienden que cuidarse a uno mismo y cuidar el planeta no son objetivos opuestos.
                </p>
                <p class="text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                    Seleccionamos cada producto de forma rigurosa, priorizando fórmulas limpias, envases sostenibles y marcas comprometidas con el bienestar. Porque cuando compras en EcoSkin, no solo te cuidas tú — cuidas el mundo.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="p-4 value-card rounded-3">
                            <div class="d-flex align-items-start gap-4">
                                <div class="value-icon flex-shrink-0">
                                    <i class="bi bi-award fs-4" style="color: #D4AF37;"></i>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-2" style="color: #1C2833; font-family: 'Outfit', sans-serif;">Nuestra Misión</h5>
                                    <p class="text-muted mb-0" style="line-height: 1.7; font-size: 0.95rem;">Ofrecer productos de cosmética y bienestar de la más alta calidad, seleccionados con criterios éticos y sostenibles, para que cada persona pueda sentirse bien consigo misma.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-4 value-card rounded-3">
                            <div class="d-flex align-items-start gap-4">
                                <div class="value-icon flex-shrink-0">
                                    <i class="bi bi-eye fs-4" style="color: #D4AF37;"></i>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-2" style="color: #1C2833; font-family: 'Outfit', sans-serif;">Nuestra Visión</h5>
                                    <p class="text-muted mb-0" style="line-height: 1.7; font-size: 0.95rem;">Ser la referencia líder en cosmética consciente en habla hispana, haciendo accesible la belleza premium y responsable para todos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section style="padding: 80px 0; background: #fff;">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-label mb-3">Lo que nos define</p>
            <div class="gold-divider"></div>
            <h2 class="fw-light" style="font-family: 'Outfit', sans-serif; font-size: 2rem; color: #1C2833;">Nuestros <span class="fw-bold">Valores</span></h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-card rounded-3 p-4 text-center h-100">
                    <div class="value-icon">
                        <i class="bi bi-leaf fs-4" style="color: #D4AF37;"></i>
                    </div>
                    <h5 class="fw-semibold mb-3" style="color: #1C2833; font-family: 'Outfit', sans-serif;">Sostenibilidad</h5>
                    <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.7;">Cada decisión que tomamos considera su impacto en el planeta. Priorizamos marcas con empaques reciclables y fórmulas libres de crueldad animal.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card rounded-3 p-4 text-center h-100">
                    <div class="value-icon">
                        <i class="bi bi-gem fs-4" style="color: #D4AF37;"></i>
                    </div>
                    <h5 class="fw-semibold mb-3" style="color: #1C2833; font-family: 'Outfit', sans-serif;">Calidad Premium</h5>
                    <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.7;">Cuestionamos, investigamos y probamos cada producto antes de incluirlo en nuestro catálogo. Solo ofrecemos lo que consideramos digno de ti.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card rounded-3 p-4 text-center h-100">
                    <div class="value-icon">
                        <i class="bi bi-heart fs-4" style="color: #D4AF37;"></i>
                    </div>
                    <h5 class="fw-semibold mb-3" style="color: #1C2833; font-family: 'Outfit', sans-serif;">Bienestar Real</h5>
                    <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.7;">Creemos en la belleza que cuida de adentro hacia afuera. Nuestros productos no solo mejoran tu apariencia — nutren tu bienestar integral.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Founder Section --}}
<section style="padding: 80px 0; background: #FCFCFC;">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-label mb-3">El equipo</p>
            <div class="gold-divider"></div>
            <h2 class="fw-light" style="font-family: 'Outfit', sans-serif; font-size: 2rem; color: #1C2833;">Conoce a <span class="fw-bold">la Fundadora</span></h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="founder-card rounded-3 p-5 text-center shadow-sm">
                    <div class="founder-avatar mb-4">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif; color: #1C2833; font-size: 1.5rem;">Karen Christal Rodriguez Mendez</h3>
                    <p class="mb-1" style="color: #D4AF37; letter-spacing: 2px; font-size: 0.8rem; text-transform: uppercase; font-weight: 600;">Fundadora & CEO</p>
                    <div class="gold-divider mt-3"></div>
                    <p class="text-muted mb-4" style="line-height: 1.8; font-size: 0.97rem;">
                        Apasionada por la cosmética natural y el bienestar holístico, Karen fundó EcoSkin con una convicción simple pero poderosa: <em>todos merecen acceso a productos que cuiden su piel sin dañar el planeta</em>.
                    </p>
                    <p class="text-muted mb-4" style="line-height: 1.8; font-size: 0.97rem;">
                        Con años de experiencia en el sector de la salud y la cosmética, Karen construyó EcoSkin desde cero, seleccionando personalmente cada producto y marca que forma parte del catálogo, garantizando los más altos estándares de calidad y ética.
                    </p>
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <a href="#" class="btn btn-sm rounded-0 text-uppercase" style="background: #1C2833; color: #fff; letter-spacing: 1.5px; font-size: 0.75rem; padding: 10px 24px;">
                            <i class="bi bi-linkedin me-2"></i>LinkedIn
                        </a>
                        <a href="#" class="btn btn-sm rounded-0 text-uppercase" style="border: 1px solid #1C2833; color: #1C2833; letter-spacing: 1.5px; font-size: 0.75rem; padding: 10px 24px;">
                            <i class="bi bi-envelope me-2"></i>Contactar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section style="padding: 80px 0; background: #1C2833;">
    <div class="container text-center">
        <p class="mb-3" style="color: #D4AF37; letter-spacing: 3px; font-size: 0.8rem; text-transform: uppercase; font-weight: 600;">Únete a nuestra comunidad</p>
        <h2 class="fw-light text-white mb-4" style="font-family: 'Outfit', sans-serif; font-size: 2rem;">¿Lista para descubrir tu mejor versión?</h2>
        <a href="{{ url('/') }}" class="btn btn-lg px-5 py-3 rounded-0 text-uppercase" style="background: #D4AF37; color: #1C2833; font-weight: 700; letter-spacing: 2px; font-size: 0.85rem;">
            Explorar Productos
        </a>
    </div>
</section>

@endsection
