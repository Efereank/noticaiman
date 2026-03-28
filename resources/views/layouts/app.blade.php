<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Noticaimán') }}</title>

    <!-- Preconnect para fuentes (mejora velocidad) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Estilos adicionales -->
    @stack('styles')
</head>
<body class="site-body">
    <!-- Barra de navegación pública -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-wrapper">
                <!-- Logo -->
                <div class="navbar-left">
                    <a href="{{ route('home') }}" class="logo">
                        <div class="logo-wrapper">
                            <img src="{{ asset('img/logo.png') }}"
                                alt="Alcaldía"
                                class="logo-img"
                                loading="eager"
                                width="75"
                                height="75">
                        </div>
                        <span class="logo-text">NOTICAIMÁN</span>
                    </a>
                </div>

                <!-- Botón hamburguesa -->
                <button class="hamburger-btn" id="hamburgerBtn" aria-label="Menú">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Menú de navegación -->
                <div class="nav-menu" id="navMenu">
                    <a href="{{ route('home') }}" class="nav-link">Inicio</a>
                    <a href="#" class="nav-link">Nuestra Historia</a>

                    <!-- Dropdown Categorías -->
                    <div class="dropdown" x-data="{ open: false }">
                        <button @click="open = !open" class="dropdown-trigger nav-link">
                            Categorías
                            <svg class="dropdown-icon" :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div class="dropdown-menu" x-show="open" x-cloak>
                            @php
                                use App\Models\Category;
                                $categories = Category::all();
                            @endphp
                            @foreach($categories as $category)
                                <a href="{{ route('category.articles', $category) }}" class="dropdown-item">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <a href="#" class="nav-link">Contacto</a>

                    <!-- Botones de usuario para móvil -->
                    <div class="mobile-user-buttons">
                        @auth
                            <a href="{{ route('admin.articles.index') }}" class="nav-link mobile-admin-link">Admin</a>
                            <form method="POST" action="{{ route('logout') }}" class="mobile-logout-form">
                                @csrf
                                <button type="submit" class="nav-link mobile-logout-btn">Salir</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="nav-link mobile-login-link">Login</a>
                        @endauth
                    </div>
                </div>

                <!-- Botones de usuario escritorio -->
                <div class="navbar-right desktop-only">
                    @auth
                        <a href="{{ route('admin.articles.index') }}" class="admin-link">Admin</a>
                        <form method="POST" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="logout-btn">Salir</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>

        <div class="eslogan">
            <span class="eslogan-texto">Sígueme en</span>
            <a href="https://www.facebook.com/soyericjose" class="eslogan-enlace" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669c1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </a>
            <span class="eslogan-texto eslogan-usuario">@soyericJosé</span>
        </div>
    </nav>

    <!-- Overlay para móvil -->
    <div class="menu-overlay" id="menuOverlay"></div>

    <!-- Contenido principal -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-container">
            NotiCaimán. Todos los derechos reservados© {{ date('Y') }}.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
