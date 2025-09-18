<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIORTISOFT</title>
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
                    {{-- Inicio --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Inicio</a>
                    </li>

                    {{-- Solo mostrar si el usuario NO está logueado --}}
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

                    {{-- Si está logueado, mostrar link al panel e incluir logout --}}
                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('index2') ? 'active' : '' }}"
                            href="{{ route('index2') }}">Panel</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Cerrar sesión</button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('registro_admin') }}" class="btn btn-link nav-link">Registro</a>
                    </li>

                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
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

    {{-- 👇 Esto permite que @push('scripts') funcione --}}
    @stack('scripts')
</body>

</html>