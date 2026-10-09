
@extends('layouts.app')

@section('title', 'Editar publicación | PENSARIUM')
@section('page-title', 'Editar publicación')
@section('page-subtitle', 'Actualiza el contenido de tu pensamiento.')

@section('content')

<div style="max-width: 800px; margin: 0 auto;">

    <div class="page-heading">

        <h1>Editar pensamiento</h1>

        <p>
            Puedes actualizar el contenido de tu publicación
            cuando lo necesites.
        </p>

    </div>

    <div class="card editor-card">

        <div class="post-header">

            <span class="avatar">
                {{ mb_strtoupper(mb_substr(auth()->user()->nombre, 0, 1)) }}
            </span>

            <div class="post-author">

                <span class="post-author-name">
                    {{ auth()->user()->nombre }}
                </span>

                <span class="post-meta">
                    Publicado
                    {{ $publicacion->created_at->diffForHumans() }}
                </span>

            </div>

        </div>

        <div class="composer-divider"></div>

        <form
            action="{{ route('publicaciones.actualizar', $publicacion) }}"
            method="POST"
            data-prevent-double-submit
        >
            @csrf
            @method('PUT')

            <div class="form-group">

                <label
                    for="contenido"
                    class="form-label"
                >
                    Contenido de la publicación
                </label>

                <textarea
                    id="contenido"
                    name="contenido"
                    class="form-control editor-textarea"
                    maxlength="5000"
                    data-character-count="contador-edicion"
                    data-auto-resize
                    required
                >{{ old('contenido', $publicacion->contenido) }}</textarea>

                @error('contenido')
                    <p class="form-error">
                        {{ $message }}
                    </p>
                @enderror

                <div
                    id="contador-edicion"
                    class="character-counter"
                    aria-live="polite"
                >
                    0 / 5000
                </div>

            </div>

            <div class="editor-actions">

                <a
                    href="{{ route('inicio') }}"
                    class="btn btn-secondary"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>

                    Guardar cambios
                </button>

            </div>

        </form>

    </div>

    <div class="card card-body mt-3">

        <h2 class="card-title">
            Información de la publicación
        </h2>

        <div class="stat-list mt-3">

            <div class="stat-row">

                <span>Fecha de creación</span>

                <span class="stat-value">
                    {{ $publicacion->created_at->format('d/m/Y') }}
                </span>

            </div>

            <div class="stat-row">

                <span>Última actualización</span>

                <span class="stat-value">
                    {{ $publicacion->updated_at->format('d/m/Y H:i') }}
                </span>

            </div>

        </div>

    </div>

</div>

@endsection
