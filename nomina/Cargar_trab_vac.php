<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME"); $nombre="";$cod_empleado=""; $fecha_hoy=asigna_fecha_hoy();
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Calculo de Vacaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function llamar_anterior(){  history.back(); }
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtcod_empleado.value==""){alert("Codigo de Empleado no puede estar Vacia");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;font-weight: bold;color: #FFFFFF;}
-->
</style>
</head>
<? $dia=substr($fecha_hoy,0,2); $error=0; $fecha_hasta=$fecha_hoy;
$StrSQL="select frecuencia,ultima_fecha,proxima_fecha,nro_semana from nom001 order by tipo_nomina";$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $frec=$registro["frecuencia"]; $ultima_fecha=$registro["ultima_fecha"]; $proxima_fecha=$registro["proxima_fecha"]; $num_semana=$registro["nro_semana"]; $fecha_desde=formato_ddmmaaaa($ultima_fecha); $fecha_hasta=formato_ddmmaaaa($proxima_fecha); $nro_semanas=0;
  $fecha_desde=nextDate($fecha_desde,1); if($frec=="M"){$fecha_hasta=colocar_udiames($fecha_desde);} if($frec=="S"){$fecha_hasta=nextDate($fecha_desde,6);$nro_semanas=$num_semana+1;} if($frec=="Q"){$dia=substr($fecha_desde,0,2); $fecha_hasta=colocar_udiames($fecha_desde); if($dia=='01'){$fecha_hasta=nextDate($fecha_desde,14);}}
}  $fechah=formato_aaaammdd($fecha_hasta);
$sSQL="Select cod_empleado,fecha_reincorp from NOM024 Where (fecha_reincorp<='$fechah')";$resultado=pg_query($sSQL);$filas=pg_num_rows($resultado); if($filas>=1){$error=1;?><script language="JavaScript">muestra('Existen Trabajadores en Vacaciones, los Cuales deben ser Retornados');</script><?
  echo "TRABAJADORES POR RETORNAR DE VACACIONES","<br>";
  $sql="SELECT cod_empleado,cedula,nombre,fecha_c_hasta,fecha_reincorp from TRABAJADOR_VACACION  Where (fecha_reincorp<='$fechah') order by fecha_reincorp"; $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){  $fecha_reincorp=$registro["fecha_reincorp"]; $fecha_reincorp=formato_ddmmaaaa($fecha_reincorp); 
      echo "Trabjador : ".$registro["cod_empleado"]." ".$registro["nombre"]." Fecha Reincorporarse: ".$fecha_reincorp,"<br>";
  }
} 
$sSQL="Select cod_empleado,fecha_desde FROM NOM022 Where (fecha_desde<='$fechah') ";$resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);if($filas>=1){$error=1;?><script language="JavaScript">muestra('Existen Trabajadores con Calculo Vacaciones, los Cuales deben tener Salida de Vacaciones');</script><?
  echo "","<br>";
  echo "TRABAJADORES POR DARLE SALIDA DE VACACIONES","<br>";
  $sql="SELECT cod_empleado,cedula,nombre,fecha_caus_hasta,fecha_desde from CALCULO_VACACIONES Where (fecha_desde<='$fechah') "; $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){  $fecha_desde=$registro["fecha_desde"]; $fecha_desde=formato_ddmmaaaa($fecha_desde); 
      echo "Trabjador : ".$registro["cod_empleado"]." ".$registro["nombre"]." Fecha Calculo Desde: ".$fecha_desde,"<br>";
  }
} 
$error=0;
/*
if($error==1){?><script language="JavaScript">history.back();</script><?}
*/
pg_close();?>
<body>
<form name="form1" method="post" action="carga_cal_vac.php" onSubmit="return revisar()">
  <table width="751" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="744" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CALCULO DE VACACIONES</span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
		<tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR  : </span></td>
                   <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                   <td width="600"><input class="Estilo10" name="btconcepto" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trabajadores.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 </tr>
             </table></td>
        </tr>        
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="740" border="0">
              <tr>
                <td width="92"><span class="Estilo5">NOMBRE :</span></td>
                <td width="589"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="95" maxlength="250" readonly value="<?echo $nombre?>">
                </span></td>
              </tr>
            </table> </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>  </td>
        </tr>
        <tr><td>&nbsp;</td> </tr>       
      </table>
        <table width="540" align="center">
          <tr>
            <td width="32"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value=""></td>
            <td width="80"><input name="txtref_comp" type="hidden" id="txtref_comp" value=""></td>
			<?if($error==0){?>
            <td width="97" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
			<?}?>
            <td width="94" align="center">&nbsp;</td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="113">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>