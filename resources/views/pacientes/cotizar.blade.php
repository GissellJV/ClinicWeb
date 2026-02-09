@extends('layouts.plantilla')
@section('contenido')
    <div class="container mt-5">
        <h3 class="mb-3 text-center">Consulta y Cotización de Medicamentos</h3>

        <!-- Buscador -->
        <input
            type="text"
            id="buscar"
            class="form-control mb-3"
            placeholder="Buscar medicamento"
        >

        <!-- Resultados -->
        <div id="resultados">
            @if($medicamentos->count() > 0)
                <table class="table table-striped bg-white">
                    <thead>
                    <tr>
                        <th>Medicamento</th>
                        <th>Disponible</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($medicamentos as $med)
                        <tr>
                            <td>{{ $med->nombre }}</td>
                            <td>{{ $med->cantidad }}</td>
                            <td class="precio">{{ number_format($med->precio_unitario,2) }}</td>
                            <td>
                                <input type="number"
                                       class="form-control cantidad"
                                       min="1"
                                       max="{{ $med->cantidad }}"
                                       value="1">
                            </td>
                            <td class="total">L. {{ number_format($med->precio_unitario,2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $medicamentos->withQueryString()->links() }}
                </div>
            @elseif(request('buscar'))
                <div class="alert alert-warning">
                    No se encontraron medicamentos disponibles
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const inputBuscar = document.getElementById('buscar');
            const resultados = document.getElementById('resultados');

            function actualizarTotales() {
                document.querySelectorAll('.cantidad').forEach(input => {
                    input.addEventListener('input', function () {
                        let fila = this.closest('tr');
                        let precio = parseFloat(fila.querySelector('.precio').innerText);
                        let cantidad = parseInt(this.value) || 0;
                        fila.querySelector('.total').innerText =
                            'L. ' + (precio * cantidad).toFixed(2);
                    });
                });
            }

            // Totales iniciales
            actualizarTotales();

            // Autocompletado en tiempo real
            inputBuscar.addEventListener('keyup', function() {
                let query = this.value;

                if(query.length === 0){
                    // Si borró la búsqueda, recargamos la tabla completa (10 en 10)
                    fetch('{{ route("paciente.cotizar") }}?buscar=')
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            resultados.innerHTML = doc.querySelector('#resultados').innerHTML;
                            actualizarTotales();
                        });
                    return;
                }

                // Si escribe, usamos AJAX para filtrar
                fetch('{{ route("paciente.medicamentos.buscar") }}?q=' + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(data => {
                        resultados.innerHTML = data.html;
                        actualizarTotales();
                    })
                    .catch(err => console.error(err));
            });

        });
    </script>
@endsection
