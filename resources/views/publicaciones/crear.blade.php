
@extends('layouts.app')

@section('title', 'Nueva publicación | PENSARIUM')
@section('page-title', 'Nueva publicación')
@section('page-subtitle', 'Comparte una idea con la comunidad.')

@section('content')

<div style="max-width: 800px; margin: 0 auto;">

    <div class="page-heading">
        <h1>¿Qué estás pensando?</h1>

        <p>
            A veces una pequeña idea puede comenzar
            una gran conversación.
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
                    {{ '@' . auth()->user()->username }}
                </span>

            </div>

        </div>

        <div class="composer-divider"></div>

        <form
            action="{{ route('publicaciones.guardar') }}"
            method="POST"
            data-prevent-double-submit
        >
            @csrf

            <div class="form-group">

                <label
                    for="contenido"
                    class="form-label"
                >
                    Tu pensamiento
                </label>

                <textarea
                    id="contenido"
                    name="contenido"
                    class="form-control editor-textarea"
                    placeholder="Escribe aquí lo que quieras compartir..."
                    maxlength="5000"
                    data-character-count="contador-publicacion"
                    data-auto-resize
                    required
                    autofocus
                >{{ old('contenido') }}</textarea>

                @error('contenido')
                    <p class="form-error">
                        {{ $message }}
                    </p>
                @enderror

                <div
                    id="contador-publicacion"
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
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>

                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <path d="M12 5v14"/>
                        <path d="M5 12h14"/>
                    </svg>

                    Publicar pensamiento
                </button>

            </div>

        </form>

    </div>

    <div class="card card-body mt-3">

        <h2 class="card-title">
            Un espacio para expresarte
        </h2>

        <p class="text-muted mb-0">
            Comparte reflexiones, experiencias, preguntas
            o cualquier pensamiento que quieras expresar.
            Recuerda que tus publicaciones podrán ser
            vistas y comentadas por otros usuarios.
        </p>

    </div>

</div>

@endsection
