<?php include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php } else{ $Nom_Emp=busca_conf(); }
if (!$_GET){$codigo="";}else{$codigo=$_GET["Gcodigo"];} $fecha_hoy=asigna_fecha_hoy();
$cod_fuente=substr($codigo,0,2);  $cod_presup=substr($codigo,2,32);  $asignado=0;    $denominacion="";   $des_fuente="";
if($cod_presup==""){$asignado="";  $denominacion="";}else{
$sSQL="Select * from codigos where cod_presup='$cod_presup' and cod_fuente='$cod_fuente'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('C�DIGO PRESUPUESTARIO NO EXISTE'); window.close();  </script> <?php }
 else {  $registro=pg_fetch_array($resultado); $asignado=$registro["asignado"];  $denominacion=$registro["denominacion"];   $des_fuente=$registro["des_fuente_financ"]; } }
$fecha_a=formato_aaaammdd($fecha_hoy); $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
if($fecha_a>$Fec_Fin_Ejer){$fecha_hoy=$fecha_h;}

 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Consulta Disponibilidad PreSupuestaria)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_diferidos.php?codigo_mov=<?php echo $codigo_mov?>'; }
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio");return false;}
   if(f.txtcod_fuente.value==""){alert("Codigo de Fuente no puede estar Vacio"); return false; }

document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo16 {	font-size: 10pt;	font-weight: bold;}
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
                <td width="219"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo de la Cuenta"  size="35" maxlength="35" readonly value="<?php echo $cod_presup?>">
                </span></td>
				 <td width="63"><input class="Estilo10" name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('Cat_codigos_presup_comp.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                <td width="45"><input class="Estilo10" name="txtcod_contable" type="hidden" id="txtcod_contable"></td>
				<td width="45"><input class="Estilo10" name="txtdisponible" type="hidden" id="txtdisponible"></td>
				<td width="53"><input class="Estilo10" name="txtdes_contable" type="hidden" id="txtdes_contable"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="623" border="0">
            <tr>
              <td width="184"><span class="Estilo5">FUENTE DE FINANCIAMIENTO : </span></td>
              <td width="38"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2" readonly value="<?php echo $cod_fuente?>">
              </span></td>
              <td width="24">&nbsp;</td>
              <td width="359"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" size="50" readonly value="<?php echo $des_fuente?>">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="621" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N :

                </span></td>
                <td width="494"><span class="Estilo5"><textarea name="txtdenominacion" class="Estilo10" cols="58" rows="2" readonly="readonly" id="txtdenominacion"><?php echo $denominacion?></textarea>   </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="620" border="0">
                <tr>
                  <td width="109"><span class="Estilo5">FECHA:</span></td>
                  <td width="190"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_hoy?>" size="12" maxlength="12" onChange="checkrefechad(this.form)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
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
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo?>"></td>
			<td width="1o"><input name="txtasignado" type="hidden" id="txtasignado" value="<?php echo $asignado?>"></td>
            <td width="100">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Mostrar Disponibilidad"></td>
            <td width="100">&nbsp;</td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Cerrar" onClick="JavaScript:window.close()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>