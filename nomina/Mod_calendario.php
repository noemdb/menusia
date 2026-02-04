<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$mes='01'; $ano='2013'; $ini='N'; $fecha_c='2013-01-01'; } else{$fecha_c=$_GET["fecha_c"];$ano=$_GET["ano"]; $mes=$_GET["mes"];}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Modificar Calendario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">

function llamar_anterior(){ document.location ='Det_def_calendario.php?mes=<?echo $mes?>&ano=<?echo $ano?>&ini=N'; }
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtfecha.value==""){alert("Fecha no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $observacion=""; $des_feriado=""; $status_feriado="N"; $cant_horas=8; $status1=""; $status2=""; $campo_str1=""; $campo_num1=0; 
$sql="select * FROM nom049 Where (fecha_c='$fecha_c')";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){   $fecha_c=$registro["fecha_c"]; $fechac=formato_ddmmaaaa($fecha_c); $campo_str1=$registro["campo_str1"]; $status_feriado=$registro["status_feriado"]; $cant_horas=$registro["cant_horas"]; $observacion=$registro["des_feriado"]; $status1=$registro["status1"]; $status2=$registro["status2"];  $campo_num1=$registro["campo_num1"]; }
pg_close(); 
?>
<body>
<form name="form1" method="post" action="Update_calendario.php" onSubmit="return revisar()">
  <table width="661" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="660" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR DIA CALENDARIO </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="50"><span class="Estilo5"> FECHA :</span> </td>
                <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="15" maxlength="15"  value="<?echo $fechac?>" readonly ></span></td>
				<td width="50"><span class="Estilo5"> DIA :</span> </td>
                <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtdia" type="text" id="txtdia" size="15" maxlength="15"  value="<?echo $campo_str1?>" readonly ></span></td>
				<td width="60"><span class="Estilo5"> FERIADO :</span> </td>
				<td width="100"><span class="Estilo5"><select class="Estilo10" name="txtstatus_feriado" size="1" id="txtstatus_feriado" onFocus="encender(this)" onBlur="apagar(this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   
               </tr>
          </table></td>
        </tr>
		
		 <tr> <td>&nbsp;</td> </tr>
<script language="JavaScript" type="text/JavaScript">
var mvalor='<?echo $status_feriado;?>'; var f=document.form1; 
if(mvalor=="S"){document.form1.txtstatus_feriado.options[0].selected = true;}else{document.form1.txtstatus_feriado.options[1].selected = true;}
</script>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="126"><span class="Estilo5">OBSERVACION : </span></td>
                <td width="534"><textarea name="txtobservacion" cols="70" class="Estilo10" onFocus="encender(this)" onBlur="apagar(this)" id="txtobservacion"><? echo $observacion ?></textarea></td>
              </tr>
           </table></td>
        </tr>

        <tr> <td>&nbsp;</td> </tr>
        <tr> <td>&nbsp;</td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
		    <td width="5"><input class="Estilo10" name="txtmes" type="hidden" id="txtmes" value="<?echo $mes?>" ></td>
			<td width="5"><input class="Estilo10" name="txtano" type="hidden" id="txtano" value="<?echo $ano?>" ></td>
		    <td width="5"><input class="Estilo10" name="txtcant_horas" type="hidden" id="txtcant_horas" value="<?echo $cant_horas?>" ></td>
			<td width="5"><input class="Estilo10" name="txtcampo_num1" type="hidden" id="txtcampo_num1" value="<?echo $campo_num1?>" ></td>
			<td width="5"><input class="Estilo10" name="txtstatus1" type="hidden" id="txtstatus1" value="<?echo $status1?>" ></td>
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
			<td width="100">&nbsp;</td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>