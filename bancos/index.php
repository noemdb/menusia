<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>

<head>
  <title>SIPAP CONTROL BANCARIO</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
  <SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
  <style type="text/css">
    <!--
    .Estilo1 {
      font-family: Verdana, Arial, Helvetica, sans-serif;
      font-size: 12px;
      color: #000066;
    }

    .Estilo4 {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
    }

    .Estilo5 {
      color: #FFFFFF;
      font-size: 16px;
    }

    .Estilo6 {
      font-size: 14px
    }
    -->
  </style>
</head>
<script language="JavaScript" type="text/JavaScript">
function revisar(){var f=document.form1; var i; var Str;
    Str=f.txtusuario.value;for (i = 0; i <= Str.length - 1; i++) {if ((Str.charAt(i)== "'") || (Str.charAt(i) == '-') ) { alert("Valor Login Invalido"); return false;} }
  Str=f.txtclave.value;for (i = 0; i <= Str.length - 1; i++) {if ((Str.charAt(i)== "'") || (Str.charAt(i) == '-') ) { alert("Valor Clave Invalida"); return false;} }
    if(f.txtempresa.value==""){alert("Empresa no puede estar Vacio");return false;}else{f.txtempresa.value=f.txtempresa.value.toUpperCase();}
    if(f.txtclave.value==""){alert("Clave no puede estar Vacia");return false;} else{f.txtclave.value=f.txtclave.value.toUpperCase();}
    if(f.txtusuario.value==""){alert("Login de Usuario no puede estar Vacio");return false; }  else{f.txtusuario.value=f.txtusuario.value.toUpperCase();}
document.form1.submit;
return true;}
</script>

<body>
  <form name="form1" action="control.php" method="post" onSubmit="return revisar()">
    <table width="350" height="328" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#0000CC">
      <tr>
        <td>
          <table width="346" height="28" border="0" cellpadding="0" cellspacing="0" bgcolor="#000066">
            <tr>
              <td align="center"><span class="Estilo6 Estilo4 Estilo2 Estilo5"><strong>CONTROL BANCARIO</strong></span>
              </td>
            </tr>
          </table>
          <table width="346" height="298" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="140">
                <table width="281" height="120" border="0" align="center">
                  <tr>
                    <td width="131" rowspan="3"><img src="../imagenes/Logo_sia.gif" alt="Ceinco Logo" width="126"
                        height="99" longdesc="http://www.ceinco.com/"></td>
                    <td width="99" height="20">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="71" align="center" valign="middle" class="Estilo9 Estilo14"><span
                        class="Estilo9  Estilo14"><span class="Estilo14 Estilo9"><strong><strong><span
                                class="Estilo9  Estilo14 Estilo15 Estilo10 Estilo1">SISTEMA INTEGRADO ADMINISTRATIVO
                                SIPAP 6.0 </span></strong></strong></span></span></td>
                  </tr>
                  <tr>
                    <td height="20">&nbsp;</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td height="110">
                <table width="305" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="144">
                      <pre class="Estilo4">CLAVE DE EMPRESA : </pre>
                    </td>
                    <td width="216"><input name="txtempresa" type="text" id="txtempresa" value="DATOS"
                        onFocus="encender(this); " onBlur="apagar(this);"> </td>
                  </tr>
                  <tr>
                    <td>
                      <pre class="Estilo4">LOGIN DE USUARIO : </pre>
                    </td>
                    <td><input name="txtusuario" type="text" id="txtusuario" value="" onFocus="encender(this); "
                        onBlur="apagar(this);"></td>
                  </tr>
                  <tr>
                    <td>
                      <pre class="Estilo4">CONTRASE&Ntilde;A : </pre>
                    </td>
                    <td><input name="txtclave" type="password" id="txtclave" value="" onFocus="encender(this); "
                        onBlur="apagar(this);"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td height="48">
                <table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center"><input type="submit" name="Submit" value="Aceptar"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
      </tr>
    </table>
  </form>
  <? foreach ($_GET as $key => $val) {
    ${$key} = $val;
  }
  if ($_GET) {
    if ($_GET["errorusuario"] == "si") { ?>
      <script language="JavaScript"> muestra('DATOS DEL USUARIO NO VALIDO'); </script> <? }
  } ?>
</body>

</html>