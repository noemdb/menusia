<?include ("../class/conect.php");  include ("../class/funciones.php");  $fecha_hoy=asigna_fecha_hoy(); $cod_dependencia="";
if (!$_GET){$codigo_mov="";}else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'";$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas>0) { $registro=pg_fetch_array($resultado); $cod_dependencia=$registro["nro_orden"];}
pg_close(); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Cargar Movimiento Bienes Muebles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">

function llamar_anterior(){ document.location ='Det_inc_bienes_mue_movimientos.php?codigo_mov=<?echo $codigo_mov?>'; }


</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;  }
.Estilo10 {font-size: 10px}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="Insert_mov_bienes_carga.php" onSubmit="return revisar()">
   <table width="640" height="300" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="635" height="290" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CARGAR MOVIMIENTO BIENES MUEBLES</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
          <tr>
            <td><table width="630">
              <tr>
			    <td width="50"><span class="Estilo5"></span></td>
                <td width="230"><span class="Estilo5">TIPOS DE MOVIMIENTO :</span></td>
                <td width="350"><span class="Estilo5"><select name="txttipo" size="1" id="txttipo" onFocus="encender(this)" onBlur="apagar(this)">
                      <option selected>INCORPORACION</option>  <option>DESINCORPORACION POR CORRECCION</option>    </select> </span></td>
              </tr>
            </table></td>
          </tr>
		  <tr> <td>&nbsp;</td></tr>
		  <tr>
            <td>
              <table width="630" border="0">
                <tr>
				  <td width="50"><span class="Estilo5"></span></td>
                  <td width="230"><span class="Estilo5">FECHA MOVIMIENTOS DESDE: </span></td>
				  <td width="150"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" size="15" maxlength="15"  value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" >  </span></td>
				  <td width="50"><span class="Estilo5">HASTA: </span></td>
				  <td width="150"><span class="Estilo5"><input name="txtfechah" type="text" id="txtfechah" size="15" maxlength="15"  value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" >  </span></td>
				  
                 </span></td>
                </tr>
              </table>  </td>
          </tr>        
        <tr> <td>&nbsp;</td></tr>
		<tr> <td>&nbsp;</td></tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td> 
            <td width="100"><input name="txtcod_dependencia" type="hidden" id="txtcod_dependencia" value="<?echo $cod_dependencia?>"></td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"></td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
		  <tr> <td>&nbsp;</td></tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>
