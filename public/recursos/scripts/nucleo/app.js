/* Funciones disponibles en todas las páginas del admin */

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