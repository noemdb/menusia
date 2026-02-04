<?php  include ("../class/conect.php"); include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME"); $mcod_m="COMP017".$usuario_sia.$equipo;
if (!$_GET){$codigo_mov=substr($mcod_m,0,49); }else{$codigo_mov=$_GET["codigo_mov"]; } 
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$rif_proveedor=""; $nombre=""; $p_precio=100; $p_dias_credito=0; $p_tiempo=0; $p_garantia=0;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Incluir Cotizacion al Analisis)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../class/sia.js" type=text/javascript></script>
<script language="javascript" src="ajax_comp.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_res_anal.php?codigo_mov=<?php echo $codigo_mov?>'; }
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtp_precio.value==""){alert("Porcentaje no puede estar Vacio");return false;}
   if(f.txtp_dias_credito.value==""){alert("Porcentaje no puede estar Vacio");return false;}
   if(f.txtp_tiempo.value==""){alert("Porcentaje no puede estar Vacio");return false;}
   if(f.txtp_garantia.value==""){alert("Porcentaje no puede estar Vacio");return false;}
   r=confirm("Desea Calcular el Analisis de Cotizacion ?");  if (r==true) { valido=true;} else{return false;} 
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;  }
.Estilo10 {font-size: 10px}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Update_cal_anal.php" onSubmit="return revisar()">
  <table width="810" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="805" border="0"  align="center">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CALCULAR ANALISIS DE COTIZACION</span></td>
        </tr>
        <tr>
          <td><table width="800">
            <tr>
              <td width="300"><span class="Estilo5">PORCENTAJE (%) PARA EVALUAR PRECIO:</span></td>
              <td width="100"><input name="txtp_precio" type="text"  id="txtp_precio" size="6" maxlength="6" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $p_precio?>" class="Estilo5" ></td>
              <td width="300"><span class="Estilo5">PORCENTAJE (%) PARA DIAS CREDITO:</span></td>
              <td width="100"><input name="txtp_dias_credito" type="text"  id="txtp_dias_credito" size="6" maxlength="6" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $p_dias_credito?>" class="Estilo5" ></td>
                                  
			</tr>
          </table></td>
        </tr>
		<tr>
          <td><table width="800">
            <tr>
              <td width="300"><span class="Estilo5">PORCENTAJE (%) PARA EVALUAR TIEMPO DE ENTREGA:</span></td>
              <td width="100"><input name="txtp_tiempo" type="text"  id="txtp_tiempo" size="6" maxlength="6" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $p_tiempo?>" class="Estilo5" ></td>
              <td width="300"><span class="Estilo5">PORCENTAJE (%) PARA EVALUAR GARANTIA:</span></td>
              <td width="100"><input name="txtp_garantia" type="text"  id="txtp_garantia" size="6" maxlength="6" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $p_garantia?>" class="Estilo5" ></td>
                                  
			</tr>
          </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="57"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="30">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="97">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>