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
  
<body>
<header>
  <div class="navegacion d-flex justify-content-between align-items-center">
    <!-- Logo a la izquierda -->
    <div>
      <img src="logo.jpg" alt="Logo" class="logo">
    </div>
    <!-- Menú de navegación -->
    <ul class="menu d-flex mb-0">
      <li><a href="inicio.php">Inicio</a></li>
      <li><a href="gestionstock.php">Gestionar stock</a></li>
      <li><a href="remitosdepositero.php">Gestionar y visualizar remitos</a></li>
      <li><a href="formulariofechas.php">Consultar stock por intervalos de fechas</a></li>
      <li><a href="formulario_auditoria.php">Auditoria de materiales</a></li>
      <li><a href="inicio.php">Ayuda</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php">Salir</a></li>

    </ul>
  </div>
</header>

  <section>
  <center><h1 class="titulo">Formulario de materiales</h1></center><br>
  <div class="container__form">
    <form action="cargar_materiales.php" class="form" method="POST" enctype="multipart/form-data">
      <label for="nombre_material">Material:</label>
      <input type="text" name="nombre_material">
      <br><br>
      <label for="image">Imagen:</label>
      <input type="text" name="image">
      <br><br>
      <label for="descripcion">Descripción:</label>
      <textarea name="descripcion" id=""></textarea>
      <br><br>

      <input type="submit" value="Cargar Material">
    </form>

    <?php 
    if(isset($_GET['ok'])){
      echo "<p> Mensaje enviado con éxito </p>";
    }
    
    ?>

  </div>

</section>


  </body>
  </html>
