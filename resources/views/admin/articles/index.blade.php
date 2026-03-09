@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1 class="admin-title">Administrar Noticias</h1>
        <div class="header-buttons">
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                + Crear Noticia
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                Ver Categorías
            </a>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-info">
                <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M4 3a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm4 3a2 2 0 100 4 2 2 0 000-4z"/>
                    <path d="M2 13h16v2H2v-2z"/>
                </svg>
                Banners
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- FILTROS -->
    <div class="filters-container">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="filters-form">
            <div class="filter-group">
                <label for="search">Buscar:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Título, contenido...">
            </div>

            <div class="filter-group">
                <label for="category_id">Categoría:</label>
                <select name="category_id" id="category_id">
                    <option value="">Todas</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="date_from">Desde:</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">
            </div>

            <div class="filter-group">
                <label for="date_to">Hasta:</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>
    </div>

    <!-- TABLA DE NOTICIAS -->
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Fecha de Publicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td data-label="ID">{{ $article->id }}</td>
                    <td data-label="Título" class="title-cell">{{ $article->title }}</td>
                    <td data-label="Categoría">
                        <span class="category-badge">
                            {{ $article->category->name ?? 'Sin categoría' }}
                        </span>
                    </td>
                    <td data-label="Estado">
                        @if($article->status == 'published')
                            <span class="status-badge status-published">Publicado</span>
                        @else
                            <span class="status-badge status-draft">Borrador</span>
                        @endif
                    </td>
                    <td data-label="Fecha">
                        @if($article->published_at)
                            <span class="date-cell">
                                <svg class="date-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                {{ $article->published_at->format('d/m/Y H:i') }}
                            </span>
                        @else
                            <span class="date-empty">—</span>
                        @endif
                    </td>
                    <td data-label="Acciones" class="actions-cell">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn-edit">Editar</a>
                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('¿Eliminar esta noticia?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-state">
                        <p>No hay noticias creadas aún</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINACIÓN -->
    <div class="pagination-wrapper">
        {{ $articles->links() }}
    </div>
</div>
@endsection