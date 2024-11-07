$(document).ready(function() {
    // Función para cargar los remitos en el data table
    function cargarRemitos() {
        $.ajax({
            url: 'obtener_remitos.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var tbody = $('#remitoTable tbody');
                tbody.empty();
                data.forEach(function(remito) {
                    var tr = $('<tr>');
                    tr.append('<td>' + remito.fecha + '</td>');
                    tr.append('<td>' + remito.origen + '</td>');
                    tr.append('<td>' + remito.destino + '</td>');
                    tr.append('<td>' + remito.codigo_material + '</td>');
                    tr.append('<td>' + remito.detalle + '</td>');
                    tr.append('<td>' + remito.unidad + '</td>');
                    tr.append('<td>' + remito.cantidad + '</td>');
                    tr.append('<td>' + remito.observacion + '</td>');
                    tr.append('<td><button class="btn btn-primary imprimir-btn" data-id="' + remito.id_remito + '">Imprimir</button></td>');
                    tbody.append(tr);
                });
            }
        });
    }

    // Cargar remitos al cargar la página
    cargarRemitos();

    // Manejar el envío del formulario
    $('#remitoForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'agregar_remito.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                alert(response);
                cargarRemitos();
                $('#remitoForm')[0].reset();
            }
        });
    });

    // Manejar la impresión del remito
    $(document).on('click', '.imprimir-btn', function() {
        var id = $(this).data('id');
        window.location.href = 'imprimir_remito.php?id=' + id;
    });
});



