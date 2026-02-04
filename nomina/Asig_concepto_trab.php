<?include ("../class/conect.php"); include ("../class/funciones.php");  $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$cod_empleado="";} else{$cod_empleado=$_GET["Gcod_empleado"];} $conn=pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP NOMINA Y PERSONAL (Asignar Concepto a Trabajadores)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){  window.close(); }
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtgrupo.value==""){alert("Grupo no puede estar Vacio");return false;}
 document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<? $sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res);   $grupo="";
if($filas>=1){ $registro=pg_fetch_array($res,0); $grupo=$registro["calculo_grupos"]; }   pg_close();
?>
<body>
<form name="form1" method="post" action="Update_asig_conc_trab.php" onSubmit="return revisar()">
  <table width="390" height="40" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="390" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">ASIGNAR CONCEPTOS AL TRABAJADOR </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="380" border="0">
              <tr>
                <td width="180" align="center"><span class="Estilo5"> GRUPO DE CONCEPTOS :</span> </td>
                <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtgrupo" type="text" id="txtgrupo" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $grupo;?>"></span></td>
              </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
      </table>
        <table width="390" align="center">
          <tr>
            <td width="80"><input name="txtcod_empleado" type="hidden" id="txtcod_empleado" value="<?echo $cod_empleado?>" ></td>
            <td width="80" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="80">&nbsp;</td>
            <td width="80" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:llamar_anterior()"></td>
            <td width="70">&nbsp;</td>
          </tr>
          <tr> <td><p>&nbsp;</p> </td>
        </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>