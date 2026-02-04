<?php include("../class/seguridad.inc");
include("../class/conects.php");
include("../class/funciones.php");
include("../class/configura.inc");
$conn = pg_connect("host=" . $host . " port=" . $port . " password=" . $password . " user=" . $user . " dbname=" . $dbname . "");
if (pg_ErrorMessage($conn)) { ?>
  <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script>
<?php } else {
  $Nom_Emp = busca_conf();
}
if ($dbname <> "DATOS") {
  $Nom_Emp = $Nom_Emp . " (" . $dbname . ")";
}
$sql = "SELECT campo036 FROM sia000";
$resultado = pg_exec($conn, $sql);
$filas = pg_numrows($resultado);
$campo036 = "";
if ($filas > 0) {
  $registro = pg_fetch_array($resultado);
  $campo036 = $registro["campo036"];
}
if (substr($campo036, 2, 1) == "S") {
  $etiq_contab = "Conf. Contabilidad Fiscal";
  $llama_contab = "Act_Conf_Contab_Fiscal.php";
} else {
  $etiq_contab = "Conf. Contabilidad Financiera";
  $llama_contab = "Act_Conf_Contab_Finac.php";
}
//echo $campo036;
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
    function LlamarURL(url){
        document.location = url;
    }
    </script>
</head>

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
          <a class="nav-link" href="menu.php">Menú Principal</a>
          <a class="nav-link" href="salir.php">Salir</a>
        </nav>
      </div>
    </header>

    <main role="main" class="inner text-center">
      <h1 class="cover-heading"><?php echo $Nom_Emp ?></h1>
      <p class="lead mb-4">Menú de Configuración</p>

      <div class="module-grid">
        <!-- Configuracion General -->
        <a href="Act_Configuracion.php" class="glass-card">
          <i class="fas fa-sliders-h"></i>
          <div class="module-title">Configuración General</div>
          <div class="module-desc">Parámetros globales</div>
        </a>

        <?php if ($SIA_Cierre == "N") {
          if (substr($campo036, 4, 1) == "S") { ?>
            <a href="Act_Conf_Contab_Presup.php" class="glass-card">
              <i class="fas fa-file-invoice-dollar"></i>
              <div class="module-title">Contabilidad Presupuestaria</div>
              <div class="module-desc">Configuración contable</div>
            </a>
          <?php }
          if ((substr($campo036, 2, 1) == "S") OR (substr($campo036, 5, 1) == "S")) { ?>
            <a href="<?php echo $llama_contab ?>" class="glass-card">
              <i class="fas fa-balance-scale"></i>
              <div class="module-title"><?php echo $etiq_contab ?></div>
              <div class="module-desc">Configuración financiera/fiscal</div>
            </a>
          <?php }
          if (substr($campo036, 0, 1) == "S") { ?>
            <a href="Act_Conf_Pagos.php" class="glass-card">
              <i class="fas fa-money-check-alt"></i>
              <div class="module-title">Ordenamiento de Pago</div>
              <div class="module-desc">Configuración de pagos</div>
            </a>
          <?php }
          if (substr($campo036, 1, 1) == "S") { ?>
            <a href="Act_Conf_Banco.php" class="glass-card">
              <i class="fas fa-university"></i>
              <div class="module-title">Control Bancario</div>
              <div class="module-desc">Cuentas y bancos</div>
            </a>
          <?php }
          if (substr($campo036, 8, 1) == "S") { ?>
            <a href="Act_Conf_Compras.php" class="glass-card">
              <i class="fas fa-shopping-cart"></i>
              <div class="module-title">Compras y Servicios</div>
              <div class="module-desc">Configuración de compras</div>
            </a>
          <?php }
          if (substr($campo036, 3, 1) == "S") { ?>
            <a href="Act_Conf_Nomina.php" class="glass-card">
              <i class="fas fa-users"></i>
              <div class="module-title">Nómina y Personal</div>
              <div class="module-desc">Configuración de RRHH</div>
            </a>
          <?php }
          if (substr($campo036, 6, 1) == "S") { ?>
            <a href="Act_Conf_Ingresos.php" class="glass-card">
              <i class="fas fa-chart-line"></i>
              <div class="module-title">Presupuesto de Ingresos</div>
              <div class="module-desc">Configuración de ingresos</div>
            </a>
          <?php }
          if (substr($campo036, 12, 1) == "S") { ?>
            <a href="Act_Conf_Bienes.php" class="glass-card">
              <i class="fas fa-boxes"></i>
              <div class="module-title">Bienes Nacionales</div>
              <div class="module-desc">Control de bienes</div>
            </a>
          <?php }
        } ?>
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
