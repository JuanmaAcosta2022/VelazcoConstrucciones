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

  <style>
    .navegacion {
      padding: 10px;
      background-color: black;
    }

    .logo {
      height: 40px;
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

    table th.encabezado-resaltado {
      background-color: #d0d0d0;
      color: #000;
      font-weight: bold;
      padding: 10px;
    }
  </style>

  <script>
    $(document).ready(function() {
      $('#auditoriaMateriales').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
      });
    });
  </script>

</head>

<body>
<header>
  <div class="navegacion d-flex justify-content-between align-items-center">
    <div>
      <img src="logo.jpg" alt="Logo" class="logo">
    </div>
    <ul class="menu d-flex mb-0">
      <li><a href="gestionstock.php">Gestionar stock</a></li>
      <li><a href="remitosdepositero.php">Gestionar y visualizar remitos</a></li>
      <li><a href="formulariofechas.php">Consultar stock por intervalos de fechas</a></li>
      <li><a href="formularioauditoriademateriales.php">Auditoria de materiales</a></li>
      <li><a href="inicio.php">Ayuda</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php">Salir</a></li>

    </ul>
  </div>
</header>

<center><h1>Auditoría de materiales</h1></center><br>

<div class="container">
  <div class="mb-3">
    <label for="obra" class="form-label">Obra:</label>
    <input type="text" class="form-control" id="obra" name="obra" placeholder="Ingrese la obra">
  </div>

  <table id="auditoriaMateriales" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Código</th>
        <th>Material</th>
        <th>Unidad</th>
        <th>Total necesario</th>
        <th>Ingreso</th>
        <th>Salió a otra obra</th>
        <th>Disponible</th>
        <th>Falta</th>
        <th>Sobra</th>
      </tr>
    </thead>
    <tbody>
      <!-- Aquí puedes agregar filas de datos dinámicamente -->
    </tbody>
  </table>
</div>

</body>
</html>

