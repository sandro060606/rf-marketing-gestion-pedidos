
// Muestra un mensaje temporal en la esquina
function mostrarToast(mensaje, tipo = 'exito') {
    const t = document.getElementById('toast')
    t.textContent = mensaje
    t.className = 'mostrar ' + tipo
    clearTimeout(t._timer)
    t._timer = setTimeout(() => t.className = '', 3000)
}

// Abre el modal genérico del layout
let _modal = null
function abrirModal(titulo, cuerpo, botones = '') {
    document.getElementById('modal-titulo').textContent = titulo
    document.getElementById('modal-cuerpo').innerHTML   = cuerpo
    document.getElementById('modal-pie').innerHTML =
        `<button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>` + botones
    if (!_modal) _modal = new bootstrap.Modal(document.getElementById('modal'))
    _modal.show()
}
function cerrarModal() { _modal?.hide() }

// Obtiene el valor de un input por su id
function valor(id) {
    return document.getElementById(id)?.value ?? ''
}

// POST con JSON — devuelve promesa con la respuesta
function enviarJSON(url, datos) {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
        },
        body: JSON.stringify(datos)
    }).then(r => r.json())
}

// Filtra filas de una tabla por texto
function filtrarTabla(input, idTbody) {
    const texto = input.value.toLowerCase()
    document.querySelectorAll(`#${idTbody} tr`).forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(texto) ? '' : 'none'
    })
}






// Despligue del menú de empresas en el header
document.addEventListener('click', function(e) {
    // Si haces clic en el botón de despliegue
    if (e.target.closest('#btn-empresas-toggle')) {
        const menu = document.getElementById('menu-empresas');
        const arrow = document.querySelector('#btn-empresas-toggle .arrow-icon');
        
        menu.classList.toggle('show');
        if (arrow) arrow.classList.toggle('rotate-180');
        return;
    }

    // Si haces clic en cualquier enlace <a>, NO HACEMOS NADA. 
    // Dejamos que el navegador cambie de página solo.
});


//Scroll horizontal con la rueda del mouse en el menú de empresas
const empScroll = document.getElementById('empScroll');
if (empScroll) {
    empScroll.addEventListener('wheel', function (e) {
        e.preventDefault();
        empScroll.scrollLeft += e.deltaY;
    }, { passive: false });
}