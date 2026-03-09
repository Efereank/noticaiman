@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1 class="admin-title">Administrar Banners</h1>
        <div class="header-buttons">
            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                + Nuevo Banner
            </a>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                Volver a Noticias
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Orden</th>
                    <th>Imagen</th>
                    <th>Título</th>
                    <th>Subtítulo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                <tr>
                    <td data-label="Orden">{{ $banner->order }}</td>
                    <td data-label="Imagen">
                        @if($banner->image)
                            <img src="{{ Storage::url($banner->image) }}" 
                                 alt="{{ $banner->title }}" 
                                 class="banner-thumbnail">
                        @else
                            <span class="text-gray-400">Sin imagen</span>
                        @endif
                    </td>
                    <td data-label="Título">{{ $banner->title ?? 'Sin título' }}</td>
                    <td data-label="Subtítulo">{{ $banner->subtitle ?? 'Sin subtítulo' }}</td>
                    <td data-label="Estado">
                        @if($banner->is_active)
                            <span class="status-badge status-published">Activo</span>
                        @else
                            <span class="status-badge status-draft">Inactivo</span>
                        @endif
                    </td>
                    <td data-label="Acciones" class="actions-cell">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn-edit">
                            Editar
                        </a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('¿Eliminar este banner?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-state">
                        <div class="empty-icon">🖼️</div>
                        <p class="empty-text">No hay banners creados aún</p>
                        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary mt-4">
                            Crear primer banner
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $banners->links() }}
    </div>
</div>
@endsection