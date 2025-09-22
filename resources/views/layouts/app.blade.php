<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIORTISOFT</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">SIORTISOFT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    {{-- Link Inicio (siempre visible) --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Inicio</a>
                    </li>

                    {{-- Si el usuario NO está logueado --}}
                    @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                            href="{{ route('login') }}">Iniciar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('registro') ? 'active' : '' }}"
                            href="{{ route('registro') }}">Registrarse</a>
                    </li>
                    @endguest

                    {{-- Si el usuario SÍ está logueado --}}
                    @auth
                    {{-- Link al panel (visible para admin y vigilantes) --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('index2') ? 'active' : '' }}"
                            href="{{ route('index2') }}">Panel</a>
                    </li>

                    {{-- Solo los administradores ven el Dashboard --}}
                    @if(Auth::user()->rol == 1)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">Usuarios</a>
                    </li>
                    @endif

                    {{-- Botón de cierre de sesión --}}
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Cerrar sesión</button>
                        </form>
                    </li>

                    {{-- Registro de usuarios internos (solo para admin) --}}
                    @if(Auth::user()->rol == 1)
                    <li class="nav-item">
                        <a href="{{ route('registro_admin') }}" class="btn btn-link nav-link">Registro</a>
                    </li>
                    @endif
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">

        {{-- 🔔 Mensajes Flash --}}
        @if(session('success'))
        <div class="alert alert-success flash-message">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger flash-message">
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-3">© 2025 SIORTISOFT. Todos los derechos reservados.</p>
            <div class="footer-icons d-flex justify-content-center gap-4 mb-2">
                <a href="https://web.whatsapp.com/" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                <a href="https://www.facebook.com/" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://x.com/" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                <a href="https://www.instagram.com/" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            </div>
            <small>Diseñado con ❤️ por E-JARD Ventures</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- 👇 Script para autodestruir alertas --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const alerts = document.querySelectorAll('.flash-message');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500);
                }, 5000); // 5 segundos
            });
        });
    </script>

    @stack('scripts')
</body>

</html>