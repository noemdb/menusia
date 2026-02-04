<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000065"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$codigo="";}else{$codigo=$_GET["Gcodigo"];} $fecha_hoy=asigna_fecha_hoy();
$cod_fuente=substr($codigo,0,2);  $cod_presup=substr($codigo,2,32);  $asignado=0;    $denominacion="";   $des_fuente="";
$sSQL="Select * from codigos where cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";$resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas==0){$error=1;  }
 else {  $registro=pg_fetch_array($resultado); $asignado=$registro["asignado"];  $denominacion=$registro["denominacion"];   $des_fuente=$registro["des_fuente_financ"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Consulta Disponibilidad Presupuestaria)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_diferidos.php?codigo_mov=<?echo $codigo_mov?>'; }
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio");return false;}
   if(f.txtcod_fuente.value==""){alert("Codigo de Fuente no puede estar Vacio"); return false; }
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo16 {        font-size: 10pt;        font-weight: bold;}
.Estilo19 {font-size: 12pt}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="Mostrar_Consulta_disp.php" onSubmit="return revisar()">
  <table width="634" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="628" border="0" cellpadding="0" cellspacing="0">
        <tr>
           <td height="31" align="center" bgcolor="#000066"><span class="Estilo9 Estilo2 Estilo16"><span class="Estilo9 Estilo2 Estilo19">CONSULTA DISPONIBLIDAD PRESUPUESTARIA</span></span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="620" border="0">
              <tr> <td width="169"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO : </span></td>
                <td width="219"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo de la Cuenta"  size="30" maxlength="30" readonly value="<?echo $cod_presup?>">    </span></td>
                <td width="63"><input name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('Cat_codigos_presup_nom.php?criterio=','SIA','','750','500','true')" value="..."></td>
                <td width="45"><input name="txtcod_contable" type="hidden" id="txtcod_contable"></td>
                <td width="45"><input name="txtdisponible" type="hidden" id="txtdisponible"></td>
                <td width="53"><input name="txtdes_contable" type="hidden" id="txtdes_contable"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="623" border="0">
            <tr>
              <td width="184"><span class="Estilo5">FUENTE DE FINANCIAMIENTO : </span></td>
              <td width="38"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2" readonly value="<?echo $cod_fuente?>">  </span></td>
              <td width="24">&nbsp;</td>
              <td width="359"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" size="50" readonly value="<?echo $des_fuente?>"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="621" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N :    </span></td>
                <td width="494"><span class="Estilo5"><textarea name="txtdenominacion" cols="58" rows="2" readonly="readonly" id="txtdenominacion"><?echo $denominacion?></textarea>    </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="620" border="0">
                <tr>
                  <td width="109"><span class="Estilo5">FECHA:</span></td>
                  <td width="190"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" value="<?echo $fecha_hoy?>" size="12" maxlength="12" onChange="checkrefechad(this.form)">  </span></td>
                  <td width="109">&nbsp;</td>
                  <td width="180"><span class="Estilo5">
                  </span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>
              <p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo?>"></td>
            <td width="10"><input name="txtasignado" type="hidden" id="txtasignado" value="<?echo $asignado?>"></td>
            <td width="100">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Mostrar Disponibilidad"></td>
            <td width="100">&nbsp;</td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Cerrar" onClick="javascript:LlamarURL('menu.php')"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>