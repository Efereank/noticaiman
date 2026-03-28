@extends('layouts.app')

@section('content')
<div class="public-index">
    <!-- ===== BANNER + SIDEBAR EN DOS COLUMNAS ===== -->
    @if(isset($banners) && $banners->count() > 0)
    <div class="banner-layout">
        <!-- Columna del banner -->
        <div class="banner-column">
            <div class="carousel-container">
                <div class="carousel-slides" id="carouselSlides">
                    @foreach($banners as $index => $banner)
                    <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                        <div class="carousel-image" style="background-image: url('{{ Storage::url($banner->image) }}')">
                            <div class="carousel-overlay"></div>
                            <div class="carousel-content">
                                @if($banner->title)
                                    <h2 class="carousel-title">{{ $banner->title }}</h2>
                                @endif
                                @if($banner->subtitle)
                                    <p class="carousel-subtitle">{{ $banner->subtitle }}</p>
                                @endif
                                @if($banner->link)
                                    <a href="{{ $banner->link }}" class="carousel-btn">Ver más</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Controles -->
                <button class="carousel-control prev" id="prevSlide">❮</button>
                <button class="carousel-control next" id="nextSlide">❯</button>

                <!-- Indicadores -->
                <div class="carousel-indicators">
                    @foreach($banners as $index => $banner)
                    <span class="carousel-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Columna del sidebar (más leídas) -->
        <aside class="sidebar-column">
            <div class="sidebar-widget">
                <h3 class="sidebar-title">Más leídas</h3>

                @php
                    $mostViewedArticles = App\Models\Article::with('category')
                        ->published()
                        ->orderBy('views', 'desc')
                        ->limit(3)
                        ->get();
                @endphp

                @if($mostViewedArticles->count() > 0)
                    <div class="most-read-grid">
                        @foreach($mostViewedArticles as $mostViewed)
                        <a href="{{ route('article.show', $mostViewed->slug) }}" class="most-read-card">
                            <div class="most-read-image">
                                @if($mostViewed->image)
                                    <img src="{{ Storage::url($mostViewed->image) }}"
                                         alt="{{ $mostViewed->title }}">
                                @else
                                    <div class="most-read-placeholder">
                                        <span>📰</span>
                                    </div>
                                @endif
                                <div class="most-read-overlay">
                                    <span class="most-read-views-count">
                                        <svg class="views-icon-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $mostViewed->views }}
                                    </span>
                                </div>
                            </div>
                            <div class="most-read-info">
                                <h4 class="most-read-card-title">{{ $mostViewed->title }}</h4>
                                <div class="most-read-meta">
                                    <span class="most-read-category">{{ $mostViewed->category->name ?? 'General' }}</span>
                                    <span class="most-read-date">
                                        <svg class="calendar-icon" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $mostViewed->published_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <p class="sidebar-empty">No hay noticias con vistas aún</p>
                @endif
            </div>
        </aside>
    </div>
    @endif

    <!-- ===== DROPDOWN DE CATEGORÍAS EN COLORES ===== -->
    @php
        use App\Models\Category;
        $categories = Category::all();
        $colors = ['#e74c3c', '#3498db', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c', '#e67e22', '#34495e'];
    @endphp

    @if($categories->count() > 0)
    <div class="dropdown categories-dropdown categories-section-mobile" x-data="{ open: false }">
        <button @click="open = !open" @click.away="open = false" class="dropdown-trigger nav-link categories-trigger">
            <span>Categorías</span>
            <svg class="dropdown-icon" :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>

        <div class="dropdown-menu categories-dropdown-menu" x-show="open" x-cloak>
            <div class="categories-color-grid">
                @foreach($categories as $index => $category)
                <a href="{{ route('category.articles', $category) }}"
                   class="category-color-item"
                   style="background-color: {{ $colors[$index % count($colors)] }};">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Contenido principal con grid de 2 columnas en desktop -->
    <div class="content-with-sidebar">
        <!-- Columna principal (noticias) -->
        <div class="main-column">
            <!-- Título de la sección -->
            <h2 class="section-title">Últimas Noticias</h2>

            <!-- Grid de noticias -->
            <div class="articles-grid">
                @forelse($articles as $article)
                <article class="article-card">
                    <!-- Imagen destacada -->
                    @if($article->image)
                        <img src="{{ Storage::url($article->image) }}"
                             alt="{{ $article->title }}"
                             class="article-image">
                    @else
                        <div class="article-image-placeholder">
                            <span class="placeholder-icon">📰</span>
                        </div>
                    @endif

                    <!-- Contenido -->
                    <div class="article-content">
                        <!-- Categoría y fecha -->
                        <div class="article-meta">
                            @if($article->category)
                            <span class="article-category">
                                {{ $article->category->name }}
                            </span>
                            @else
                            <span class="article-category">
                                Sin categoría
                            </span>
                            @endif
                            <span class="article-date">
                                {{ $article->published_at->format('d/m/Y') }}
                            </span>
                        </div>

                        <!-- Título -->
                        <h3 class="article-title">
                            <a href="{{ route('article.show', $article->slug) }}" class="article-link">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <!-- Extracto -->
                        <p class="article-excerpt">
                            {{ Str::limit(strip_tags($article->excerpt ?? $article->body), 120) }}
                        </p>

                        <!-- Leer más y vistas -->
                        <div class="article-footer">
                            <a href="{{ route('article.show', $article->slug) }}" class="read-more">
                                Leer más
                                <svg class="read-more-icon" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <span class="article-views">
                                <svg class="views-icon" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ $article->views }}
                            </span>
                        </div>
                    </div>
                </article>
                @empty
                <div class="no-articles">
                    <div class="no-articles-icon">📭</div>
                    <p class="no-articles-text">No hay noticias publicadas aún</p>
                    @auth
                        <a href="{{ route('admin.articles.create') }}" class="create-first-btn">
                            Crear primera noticia
                        </a>
                    @else
                        <p class="no-articles-subtext">Vuelve pronto para ver las novedades del municipio</p>
                    @endauth
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
