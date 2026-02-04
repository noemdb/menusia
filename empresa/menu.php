<?php include("../class/seguridad.inc");
include("../class/conects.php");
include("../class/funciones.php");
include("../class/configura.inc");
$conn = pg_connect("host=" . $host . " port=" . $port . " password=" . $password . " user=" . $user . " dbname=" . $dbname . "");
if (pg_last_error($conn)) { ?>
  <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script>
<?php } else {
  $Nom_Emp = busca_conf();
}
if ($dbname <> "DATOS") {
  $Nom_Emp = $Nom_Emp . " (" . $dbname . ")";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SIPAP CONFIGURACIÓN Y MANTENIMIENTO</title>
  <link rel="SHORTCUT ICON" href="../imagenes/sia.ico">

  <!-- Modern UI Styles -->
  <link href="../class/modern.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../menu/vendor/fontawesome/5.2.0/css/all.css" rel="stylesheet">

  <script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
  <script language="JavaScript" type="text/JavaScript">
    function Llamar_comp(def,url){
     if (def=="N"){ alert('ETAPA DE DEFINICION INICIAL ABIERTA'); }
      else {document.location = url;}
    }
    
    function LlamarURL(url){
        document.location = url;
    }
    </script>
</head>
<?php
$sql = "SELECT campo103, campo104 FROM sia001 where campo101='$usuario_sia'";
$resultado = pg_query($conn, $sql);
$filas = pg_num_rows($resultado);
$tipo_u = "U";
$Nom_usuario = "";
if ($filas > 0) {
  $registro = pg_fetch_array($resultado);
  $tipo_u = $registro["campo103"];
  $Nom_usuario = $registro["campo104"];
  $tiene_acceso = "S";
}
$Nom_usuario = "USUARIO: " . $Nom_usuario;
error_reporting(E_ALL ^ E_NOTICE);
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$nombre_serv = $_SERVER['SERVER_NAME'];
error_reporting(E_ALL);
$userAgent = strtolower($userAgent);
$var_so = "";
$PHP_OS = PHP_OS;
if (strpos($userAgent, "windows") !== false) {
  $var_so = "Sistema Operativo Cliente : Windows" . "<br>";
}
if (strpos($userAgent, "linux") !== false) {
  $var_so = "Sistema Operativo Cliente : Linux ";
}
$var_so = $var_so . " Sistema Operativo Servidor : " . $PHP_OS . " " . $nombre_serv;
?>

<body>
  <div class="cover-container d-flex flex-column">
    <!-- Navigation Header -->
    <header class="masthead d-flex justify-content-center align-items-center">
      <div class="inner w-100 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <img src="../imagenes/Logo_sia.gif" alt="Logo" style="height: 40px; margin-right: 1rem;">
          <h3 class="masthead-brand">Configuración</h3>
        </div>
        <nav class="nav nav-masthead">
          <span class="nav-link active"><?php echo $Nom_usuario; ?></span>
          <a class="nav-link" href="salir.php">Salir</a>
        </nav>
      </div>
    </header>

    <main role="main" class="inner text-center">
      <h1 class="cover-heading"><?php echo $Nom_Emp ?></h1>
      <p class="lead mb-4"><?php echo $var_so ?></p>

      <div class="module-grid">
        <!-- Configuracion SIPAP -->
        <a href="menu_conf.php" class="glass-card">
          <i class="fas fa-cogs"></i>
          <div class="module-title">Configuración SIPAP</div>
          <div class="module-desc">Parámetros generales del sistema</div>
        </a>

        <!-- Seguridad -->
        <a href="usuarios.php" class="glass-card">
          <i class="fas fa-user-shield"></i>
          <div class="module-title">Seguridad</div>
          <div class="module-desc">Gestión de usuarios y accesos</div>
        </a>

        <!-- Auditoria -->
        <a href="menu_aud.php" class="glass-card">
          <i class="fas fa-clipboard-check"></i>
          <div class="module-title">Auditoría</div>
          <div class="module-desc">Registro de actividades y control</div>
        </a>

        <!-- Utilidades -->
        <a href="menu_u.php" class="glass-card">
          <i class="fas fa-tools"></i>
          <div class="module-title">Utilidades</div>
          <div class="module-desc">Herramientas de mantenimiento</div>
        </a>
      </div>
    </main>

    <footer class="mastfoot text-center">
      <div class="inner">
        <p>&copy; <?php echo date('Y'); ?> SIPAP 6.0 | Sistema Integrado Administrativo</p>
      </div>
    </footer>
  </div>
</body>

</html>
<?php pg_close($conn); ?>