document.addEventListener('DOMContentLoaded', function () {
    //Localizar el Buscador
    const buscador = document.getElementById('buscador');
    if (!buscador) return;
    /* keyup: Funcion cada vez que se suelta la Tecla  */
    buscador.addEventListener('keyup', function () {
        const termino = this.value.trim().toLowerCase();                        //Limpia el Texto buscado
        const filas   = document.querySelectorAll('#tablaPedidos tbody tr');    //Guarda Lista de las Filas

        filas.forEach(function (fila) {
            // Termino es Numero → El cliente busca su pedido #1, #2, #3 sin confusión
            if (/^\d+$/.test(termino)) {
                //Almacena el Numero desde data-numero
                const numero = fila.dataset.numero || '';
                //Filtro (Si Conincide deja Visible, si no Oculta)
                fila.style.display = numero === termino ? '' : 'none';
            //Termino es Texto → buscar en título, servicio y estado
            } else {
                //Extra el Texto / Info de los Campos
                const titulo   = fila.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                const servicio = fila.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                const estado   = fila.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
                //Filtro (Si Conincide deja Visible, si no Oculta)
                fila.style.display =
                    (titulo.includes(termino) || servicio.includes(termino) || estado.includes(termino))
                    ? '' : 'none';
            }
        });
    });
});