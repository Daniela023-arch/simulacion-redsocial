
import '../css/app.css';

/*
|--------------------------------------------------------------------------
| PENSARIUM - INTERACCIONES GENERALES
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {
    inicializarTema();
    inicializarMenu();
    inicializarComentarios();
    inicializarConfirmaciones();
    inicializarContadores();
    inicializarAlertas();
});

/*
|--------------------------------------------------------------------------
| MODO CLARO / OSCURO
|--------------------------------------------------------------------------
*/

function inicializarTema() {
    const botones = document.querySelectorAll('[data-theme-toggle]');
    const raiz = document.documentElement;

    const temaGuardado = localStorage.getItem('pensarium-theme');
    const temaSistema = window.matchMedia(
        '(prefers-color-scheme: dark)'
    ).matches ? 'dark' : 'light';

    aplicarTema(temaGuardado || temaSistema);

    botones.forEach(boton => {
        boton.addEventListener('click', () => {
            const temaActual = raiz.getAttribute('data-theme');

            const nuevoTema = temaActual === 'dark'
                ? 'light'
                : 'dark';

            aplicarTema(nuevoTema);
            localStorage.setItem('pensarium-theme', nuevoTema);
        });
    });

    function aplicarTema(tema) {
        raiz.setAttribute('data-theme', tema);

        botones.forEach(boton => {
            boton.setAttribute(
                'aria-label',
                tema === 'dark'
                    ? 'Activar modo claro'
                    : 'Activar modo oscuro'
            );

            boton.setAttribute(
                'title',
                tema === 'dark'
                    ? 'Modo claro'
                    : 'Modo oscuro'
            );
        });
    }
}

/*
|--------------------------------------------------------------------------
| MENÚ LATERAL RESPONSIVE
|--------------------------------------------------------------------------
*/

function inicializarMenu() {
    const boton = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-sidebar]');
    const fondo = document.querySelector('[data-sidebar-overlay]');

    if (!boton || !menu) return;

    function cerrarMenu() {
        menu.classList.remove('is-open');
        fondo?.classList.remove('is-visible');
        boton.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('menu-open');
    }

    function abrirMenu() {
        menu.classList.add('is-open');
        fondo?.classList.add('is-visible');
        boton.setAttribute('aria-expanded', 'true');
        document.body.classList.add('menu-open');
    }

    boton.addEventListener('click', () => {
        if (menu.classList.contains('is-open')) {
            cerrarMenu();
        } else {
            abrirMenu();
        }
    });

    fondo?.addEventListener('click', cerrarMenu);

    document.addEventListener('keydown', evento => {
        if (evento.key === 'Escape') {
            cerrarMenu();
        }
    });

    menu.querySelectorAll('a').forEach(enlace => {
        enlace.addEventListener('click', cerrarMenu);
    });
}

/*
|--------------------------------------------------------------------------
| MOSTRAR / OCULTAR COMENTARIOS
|--------------------------------------------------------------------------
*/

function inicializarComentarios() {
    document.querySelectorAll('[data-comments-toggle]').forEach(boton => {
        boton.addEventListener('click', () => {
            const id = boton.dataset.commentsToggle;
            const contenedor = document.getElementById(`comments-${id}`);

            if (!contenedor) return;

            const estaOculto = contenedor.hidden;

            contenedor.hidden = !estaOculto;

            boton.setAttribute(
                'aria-expanded',
                String(estaOculto)
            );
        });
    });
}

/*
|--------------------------------------------------------------------------
| CONFIRMACIÓN DE ELIMINACIÓN
|--------------------------------------------------------------------------
*/

function inicializarConfirmaciones() {
    document.querySelectorAll('[data-confirm]').forEach(formulario => {
        formulario.addEventListener('submit', evento => {
            const mensaje = formulario.dataset.confirm
                || '¿Estás seguro de realizar esta acción?';

            if (!window.confirm(mensaje)) {
                evento.preventDefault();
            }
        });
    });
}

/*
|--------------------------------------------------------------------------
| CONTADOR DE CARACTERES
|--------------------------------------------------------------------------
*/

function inicializarContadores() {
    document.querySelectorAll('[data-character-count]').forEach(campo => {
        const identificador = campo.dataset.characterCount;
        const contador = document.getElementById(identificador);

        if (!contador) return;

        const limite = Number(campo.getAttribute('maxlength')) || 0;

        function actualizarContador() {
            const cantidad = [...campo.value].length;

            contador.textContent = limite > 0
                ? `${cantidad} / ${limite}`
                : `${cantidad} caracteres`;

            contador.classList.toggle(
                'is-limit',
                limite > 0 && cantidad >= limite
            );
        }

        campo.addEventListener('input', actualizarContador);
        actualizarContador();
    });
}

/*
|--------------------------------------------------------------------------
| CERRAR NOTIFICACIONES
|--------------------------------------------------------------------------
*/

function inicializarAlertas() {
    document.querySelectorAll('[data-alert-close]').forEach(boton => {
        boton.addEventListener('click', () => {
            const alerta = boton.closest('[data-alert]');

            if (alerta) {
                alerta.remove();
            }
        });
    });
}
