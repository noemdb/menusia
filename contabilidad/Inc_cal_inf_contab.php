<?php include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();  
if (!$_GET){$tipo_informe="";$linea="00000000";}else{$tipo_informe=$_GET["tipo_informe"];$linea=$_GET["linea"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT * FROM CON006 where (tipo_informe='$tipo_informe') and (linea='$linea')";  $res=pg_query($sql);$filas=pg_num_rows($res);  
$codigo_cuenta=""; $nombre_cuenta=""; 
if($filas>=1){$registro=pg_fetch_array($res,0); $codigo_cuenta=$registro["codigo_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Agregar Linea Informes Contables)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_cal_informes.php?linea=<?php echo $linea?>&cod_informe=<?php echo $tipo_informe?>'; }

function revisar(){var f=document.form1; var Valido=true;
   if(f.txtlinea.value==""){alert("Linea no puede estar Vacio");return false;}
   if(f.txtCodigo_Cuenta.value==""){alert("Codigo no puede estar Vacio");return false;}
   if(f.txtNombre_Cuenta.value==""){alert("Nombre no puede estar Vacio");return false;}
   
   if(f.txtlinea.value.length==8){valido=true;}else{alert("Longitud Linea Invalida");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Insert_cal_inf_contab.php" onSubmit="return revisar()">
  <table width="832" height="120" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="831" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR CALCULO INFORME CONTABLE</span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
		<tr>
		   <td><table width="840">
		      <tr>
			    <td width="70"><span class="Estilo5">LINEA :</span></td>
			    <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtlinea" type="text" id="txtlinea" size="10" maxlength="10"  value="<?php echo $linea?>" readonly></span></td>
			    <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtcod_cuenta" type="text" id="txtcod_cuenta" size="20" maxlength="30"  value="<?php echo $codigo_cuenta?>" readonly></span></td>
			    <td width="510"><span class="Estilo5"> <input class="Estilo10" name="txtnom_cuenta" type="text" id="txtnom_cuenta" size="80" maxlength="100"  value="<?php echo $nombre_cuenta?>" readonly></span></td>
		      </tr>
		   </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="80"><span class="Estilo5">CUENTA :</span> </td>
				<td width="200"><span class="Estilo5"><input  class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" class="Estilo5"  size="30" maxlength="30" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
                <td width="50"><input  class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Codigo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIPAP','','750','500','true')" value="..."></td>                   
			    <td width="500"><span class="Estilo5"> <input  class="Estilo10" name="txtNombre_Cuenta" type="text" class="Estilo5" id="txtNombre_Cuenta"   size="70" maxlength="200" readonly>   </span></td>
			 </tr>
          </table></td>
        </tr>
		
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="100"><span class="Estilo5">OPERACION : </span></td>
                <td width="300"><span class="Estilo5"><select class="Estilo10" name="txtoperacion" size="1" id="txtoperacion" onFocus="encender(this)" onBlur="apagar(this)"><option>+</option> <option>-</option></select> </span></td>
                <td width="130"><span class="Estilo5">TOMAR MONTO : </span></td>
				<td width="300"><span class="Estilo5"><select class="Estilo10" name="txtstatus_c" size="1" id="txtstatus_c" onFocus="encender(this)" onBlur="apagar(this)"><option>SALDO</option> <option>DEBITO</option> <option>CREDITO</option> </select> </span></td>
              </tr>
           </table></td>
        </tr>		
        <tr><td>&nbsp;</td></tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input name="txttipo_informe" type="hidden" id="txttipo_informe" value="<?php echo $tipo_informe?>"></td>
            <td width="80">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="120">&nbsp;</td>
          </tr>
          <tr><td><p>&nbsp;</p></td></tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>