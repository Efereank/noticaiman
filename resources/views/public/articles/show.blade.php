@extends('layouts.app')

@section('content')
<div class="article-show-container">
    <div class="article-layout">
        <!-- Columna principal -->
        <div class="article-main">
            <article class="article-card">
                @if($article->image)
                <div class="article-image-container">
                    <img src="{{ Storage::url($article->image) }}"
                         alt="{{ $article->title }}"
                         class="article-image-full">
                </div>
                @endif

                <div class="article-content-wrapper">
                    <div class="breadcrumb">
                        <a href="{{ route('home') }}" class="breadcrumb-link">Inicio</a>
                        <span class="breadcrumb-separator">›</span>
                        <span class="breadcrumb-current">{{ $article->category->name ?? 'Noticias' }}</span>
                    </div>

                    <h1 class="article-title-full">{{ $article->title }}</h1>

                    <div class="article-meta-full">
                        <div class="meta-item">
                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $article->user->name ?? 'Administrador' }}
                        </div>
                        <div class="meta-item">
                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $article->published_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="meta-item">
                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ $article->views }} vistas
                        </div>
                    </div>

                    @if($article->excerpt)
                    <div class="article-excerpt-full">
                        {{ $article->excerpt }}
                    </div>
                    @endif

                    <div class="article-body-full">
                        {!! nl2br(e($article->body)) !!}
                    </div>

                    <div class="article-footer-full">
                        <a href="{{ route('home') }}" class="back-button">
                            <svg class="back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Volver a todas las noticias
                        </a>
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <aside class="article-sidebar">
            <div class="sidebar-widget">
                <h3 class="sidebar-title">Noticias relacionadas</h3>

                @if($relatedArticles->count() > 0)
                    <div class="related-articles-list">
                        @foreach($relatedArticles as $related)
                        <div class="related-article-item">
                            @if($related->image)
                            <div class="related-article-image">
                                <img src="{{ Storage::url($related->image) }}"
                                     alt="{{ $related->title }}">
                            </div>
                            @endif
                            <div class="related-article-content">
                                <h4 class="related-article-title">
                                    <a href="{{ route('article.show', $related->slug) }}" class="related-article-link">
                                        {{ $related->title }}
                                    </a>
                                </h4>
                                <div class="related-article-date">
                                    {{ $related->published_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="sidebar-empty">No hay noticias relacionadas</p>
                @endif
            </div>

            <div class="sidebar-widget">
                <h3 class="sidebar-title">Categorías</h3>
                <ul class="sidebar-categories">
                    @php
                        use App\Models\Category;
                        $categories = Category::withCount('articles')->get();
                    @endphp
                    @foreach($categories as $category)
                    <li class="sidebar-category-item">
                        <a href="{{ route('category.articles', $category) }}" class="sidebar-category-link">
                            {{ $category->name }}
                            <span class="category-count">{{ $category->articles_count }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</div>
@endsection
