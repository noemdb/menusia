<?php include ("../class/conect.php");  include ("../class/funciones.php");
$sia_periodo="00"; $cod_modulo="01";    $periodo="01";
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="04-0000050"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"];
$tipo_op=$registro["campo504"];$tipo_opd=$registro["campo505"];$tipo_opf=$registro["campo506"];$tipo_opfa=$registro["campo507"];$tipo_opa=$registro["campo508"];$tipo_aju=$registro["campo509"];

$cod_modulo="02";   $periodotes=$periodo;
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){ $periodotes=$registro["campo503"]; }
}
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA  (Periodo de Trabajo)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">

function llamar_anterior(){document.location ='menu.php';}

function revisar(){var f=document.form1; var Valido=true; var r;
   if(f.txtperiodo.value==""){alert("Periodo no puede estar Vacio");return false;}
   r=confirm("Desea Actualizar Periodo de Trabajo desde ?");
    if (r==true) { r=confirm("Esta Realmente Seguro en Actualizar Periodo de Trabajo desde ?");
      if (r==true) {valido=true;} else{return false;} } else{return false;}	
   document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 { font-size: 16px; font-weight: bold;  color: #FFFFFF;  }
-->
</style>
</head>
<body>
<form name="form1" method="post" action="Update_periodo_pag_tes.php" onSubmit="return revisar()">
  <table width="534" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="530" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">PERIODO DE TRABAJO PAGOS/TESORERIA</span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="520">
            <tr>
              <td width="20">&nbsp;</td>
			  <td width="330"><span class="Estilo5">PERIODO TRABAJO DESDE DEL MODULO PAGOS :</span></td>
              <td width="170"><div align="center"><span class="Estilo5"><input name="txtperiodo" type="text" id="txtperiodo"  size="3" maxlength="2" value="<?php echo $periodo ?>"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
             </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="520">
            <tr>
              <td width="20">&nbsp;</td>
			  <td width="330"><span class="Estilo5">PERIODO TRABAJO DESDE DEL MODULO TESORERIA :</span></td>
              <td width="170"><div align="center"><span class="Estilo5"><input name="txtperiodotes" type="text" id="txtperiodotes"  size="3" maxlength="2" value="<?php echo $periodotes ?>"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
             </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
      </table>
        <table width="500" align="center">
          <tr>
            <td width="100">&nbsp;</td>
            <td width="150" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="150" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>