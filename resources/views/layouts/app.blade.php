<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIORTISOFT</title>

    <!-- Bootstrap & Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/loguito.png') }}" alt="Logo Institucional">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Nosotros
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('/somos') }}">¿Quiénes Somos?</a></li>
                            <li><a class="dropdown-item" href="{{ url('/mision') }}">Misión</a></li>
                            <li><a class="dropdown-item" href="{{ url('/vision') }}">Visión</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Iniciar Sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/registro') }}">Registrarse</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="padding-top: 70px;"></div>

    <!-- Hero section (solo aparece en el home) -->
    @if (Request::is('/'))
      <section id="inicio" class="hero-section text-center">
            <div class="container">
                <h1 class="display-3 fw-bold mb-4">BIENVENIDOS A SIORTISOFT</h1>
                <p class="lead mb-5">Soluciones innovadoras y seguras para colegios, universidades y entidades
                    gubernamentales.</p>
                <a href="{{ url('/soluciones') }}" class="btn btn-fondo btn-lg me-2">
                    <i class="fa-solid fa-lightbulb"></i> Descubre Nuestras Soluciones
                </a>
                <a href="https://web.whatsapp.com/" class="btn btn-fondo btn-lg">
                    <i class="bi bi-whatsapp"></i> Contáctanos
                </a>
            </div>
        </section>

        <!-- Texto "Hablemos de tu Institución" debajo del hero -->
        <section class="text-center py-5 bg-light">
            <div class="container">
                <h2 class="fw-bold">Hablemos de tu Institución</h2>
                <p class="lead">
                    Cuéntanos tus necesidades y te ayudaremos a encontrar la mejor solución.
                </p>
                <a href="{{ route('contacto') }}" class="btn btn-dark btn-lg mt-3">
                    Enviar Solicitud
                </a>
            </div>
        </section>
    @endif

    <!-- Contenido dinámico -->
    <main class="py-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-text mb-3">
                <p class="mb-0">&copy; 2025 SIORTISOFT. Todos los derechos reservados.</p>
                <p class="mb-0">Sistemas de Gestión para Instituciones Públicas.</p>
            </div>
            <div class="footer-horizontal text-center">
                <div class="footer-icons d-flex justify-content-center gap-4 mb-2">
                    <a href="https://web.whatsapp.com/" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <a href="https://www.facebook.com/" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://x.com/" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                    <a href="https://www.instagram.com/" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                </div>
                <div class="footer-links d-flex justify-content-center flex-wrap gap-4">
                    <a href="{{ url('/politica') }}">Política de Privacidad</a>
                    <a href="{{ url('/terminos') }}">Términos de Servicio</a>
                    <a href="{{ url('/faq') }}">Preguntas Frecuentes</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
