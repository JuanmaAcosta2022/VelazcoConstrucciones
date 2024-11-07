<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema para empresas constructoras</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

  <link rel="stylesheet" href="estilos.css">

  <style>
  .navegacion {
    padding: 10px;
    background-color: black;
  }
  
  .logo {
    height: 40px; /* Ajusta la altura según tus necesidades */
    margin-right: 10px;
  }

  .menu {
    list-style: none;
    padding-left: 0;
  }

  .menu li {
    margin-left: 15px;
  }

  .menu li a {
    color: white;
    text-decoration: none;
  }

  .menu li a:hover {
    text-decoration: underline;
  }

  @media (max-width: 768px) {
    /* Estilo para dispositivos móviles */
    .navegacion {
      flex-direction: column;
      align-items: center;
    }

    .menu {
      flex-direction: column;
      align-items: center;
    }

    .menu li {
      margin: 5px 0;
    }
  }
</style>
</head>
  
<body style="background-color: #d3d3d3;">
<header>
  <div class="navegacion d-flex justify-content-between align-items-center">
    <!-- Logo a la izquierda -->
    <div>
      <img src="logo.jpg" alt="Logo" class="logo">
    </div>
    <!-- Menú de navegación -->
    <ul class="menu d-flex mb-0">
      <li><a href="gestionstock.php">Gestionar stock</a></li>
      <li><a href="remitos.php">Gestionar y visualizar remitos</a></li>
      <li><a href="formulariofechas.php">Consultar stock por intervalos de fechas</a></li>
      <li><a href="inicio.php">Ayuda</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php">Salir</a></li>

    </ul>
  </div>
</header>

<section class="container">
  <table id="materialesTable" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Nombre del Material</th>
        <th>Imagen</th>
        <th>Descripción</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      include('conexion.php'); 
      $consulta_db = mysqli_query($conexion, "SELECT * FROM materiales");
      while($mostrar_datos = mysqli_fetch_assoc($consulta_db)){
      ?>
        <tr>
          <td><?php echo $mostrar_datos['nombre_material']; ?></td>
          <td><img src="img/<?php echo $mostrar_datos['imagen']; ?>" alt="<?php echo $mostrar_datos['nombre_material']; ?>" width="100"></td>
          <td><?php echo $mostrar_datos['descripcion']; ?></td>
        </tr>
      <?php 
      } 
      ?>
    </tbody>
  </table>
</section>

<script>
  $(document).ready(function() {
    $('#materialesTable').DataTable({
      "paging": true,
      "searching": true,
      "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "No se encontraron resultados",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "search": "Buscar:",
        "paginate": {
          "first": "Primero",
          "last": "Último",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      }
    });
  });
</script>

</body>
</html>