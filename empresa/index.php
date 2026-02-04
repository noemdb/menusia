<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SIA CONFIGURACIÓN Y MANTENIMIENTO</title>
  <link rel="SHORTCUT ICON" href="../imagenes/sia.ico">

  <!-- Modern UI Styles -->
  <link href="../class/modern.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../menu/vendor/fontawesome/5.2.0/css/all.css" rel="stylesheet">

  <script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
  <script language="JavaScript" type="text/JavaScript">
    function revisar(){var f=document.form1; var i; var Str;
        Str=f.txtusuario.value;for (i = 0; i <= Str.length - 1; i++) {if ((Str.charAt(i)== "'") || (Str.charAt(i) == '-') ) { alert("Valor Login Invalido"); return false;} }
        Str=f.txtclave.value;for (i = 0; i <= Str.length - 1; i++) {if ((Str.charAt(i)== "'") || (Str.charAt(i) == '-') ) { alert("Valor Clave Invalida"); return false;} }
        if(f.txtempresa.value==""){alert("Empresa no puede estar Vacio");return false;}  else{f.txtempresa.value=f.txtempresa.value.toUpperCase();}
        if(f.txtclave.value==""){alert("Clave no puede estar Vacia");return false;}  else{f.txtclave.value=f.txtclave.value.toUpperCase();}
        if(f.txtusuario.value==""){alert("Login de Usuario no puede estar Vacio");return false; } else{f.txtusuario.value=f.txtusuario.value.toUpperCase();}
    document.form1.submit;
    return true;}
    </script>
</head>

<body>
  <div class="cover-container d-flex flex-column align-items-center justify-content-center"
    style="min-height: 100vh; padding-top: 0;">
    <div class="login-container">
      <header class="text-center mb-4">
        <div class="mb-4">
          <!-- Assuming a cog icon for configuration module -->
          <i class="fas fa-cogs fa-3x" style="color: var(--primary)"></i>
        </div>
        <h2 class="module-title" style="font-size: 1.5rem;">CONFIGURACIÓN Y MANTENIMIENTO</h2>
        <p class="module-desc">SISTEMA INTEGRADO ADMINISTRATIVO SIPAP 6.0</p>
      </header>

      <form name="form1" action="control.php" method="post" onSubmit="return revisar()">
        <div class="mb-4">
          <label for="txtempresa" class="sr-only">Clave de Empresa</label>
          <input name="txtempresa" type="text" id="txtempresa" class="form-control" value="DATOS"
            placeholder="Clave de Empresa" onFocus="encender(this);" onBlur="apagar(this);">

          <label for="txtusuario" class="sr-only">Login de Usuario</label>
          <input name="txtusuario" type="text" id="txtusuario" class="form-control" placeholder="Login de Usuario"
            onFocus="encender(this);" onBlur="apagar(this);">

          <label for="txtclave" class="sr-only">Contraseña</label>
          <input name="txtclave" type="password" id="txtclave" class="form-control" placeholder="Contraseña"
            onFocus="encender(this);" onBlur="apagar(this);">
        </div>

        <button class="btn-primary w-100" type="submit" name="Aceptar" value="Aceptar">Iniciar Sesión</button>
      </form>
    </div>

    <footer class="mastfoot text-center mt-4">
      <p>&copy; <?php echo date('Y'); ?> SIPAP 6.0 | Configuración</p>
    </footer>
  </div>
  <?php if ($_GET) {
    if ($_GET["errorusuario"] == "si") { ?>
      <script language="JavaScript"> muestra('DATOS DEL USUARIO NO VALIDO'); </script> <?php }
  } ?>
</body>

</html>