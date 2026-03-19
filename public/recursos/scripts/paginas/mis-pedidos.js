document.addEventListener('DOMContentLoaded', function () {

    const buscador = document.getElementById('buscador');
    if (!buscador) return;

    buscador.addEventListener('keyup', function () {
        const termino = this.value.trim().toLowerCase();
        const filas   = document.querySelectorAll('#tablaPedidos tbody tr');

        filas.forEach(function (fila) {
            // Si el término es un número → buscar SOLO por número del cliente
            // Así el cliente busca su pedido #1, #2, #3 sin confusión
            if (/^\d+$/.test(termino)) {
                const numero = fila.dataset.numero || '';
                fila.style.display = numero === termino ? '' : 'none';
            } else {
                // Si es texto → buscar en título, servicio y estado
                const titulo   = fila.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                const servicio = fila.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                const estado   = fila.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
                fila.style.display =
                    (titulo.includes(termino) || servicio.includes(termino) || estado.includes(termino))
                    ? '' : 'none';
            }
        });
    });

});