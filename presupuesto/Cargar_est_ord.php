<?php include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$mcod_m="PRE006".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);$ref_comp="N";$desest="";$codest="";}
else{$codigo_mov=$_GET["codigo_mov"];$ref_comp=$_GET["ref_comp"];$desest="";$codest="";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Cargar Estructura de Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function llamar_anterior(){  history.back(); }
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtcod_est.value==""){alert("Codigo de Estructura no puede estar Vacia");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;font-weight: bold;color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="carga_est.php" onSubmit="return revisar()">
  <table width="751" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="744" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CARGAR ESTRUCTURA DE ORDEN </span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
        <tr>
          <td><table width="614" border="0">
              <tr>
                <td width="99"><span class="Estilo5">C&Oacute;DIGO  : </span></td>
                <td width="69"><span class="Estilo5"> <input class="Estilo10" name="txtcod_est" type="text" id="txtcod_est" title="Registre el C&oacute;digo de la Estructura"  size="10" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $codest?>">    </span></td>
                <td width="432"><input class="Estilo10" name="btCatest" type="button" id="btCatest" title="Abrir Catalogo C&oacute;digo de Estructuras"  onclick="VentanaCentrada('Cat_estructura.php?codigo_mov=<?php echo $codigo_mov?>&ref_comp=<?php echo $ref_comp?>','SIPAP','','750','500','true')" value="..."></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="740" border="0">
              <tr>
                <td width="92"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                <td width="589"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_est" type="text" id="txtdescripcion_est" size="95" maxlength="250" readonly value="<?php echo $desest?>">   </span></td>
              </tr>
            </table> </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>  </td>
        </tr>
        <tr><td>&nbsp;</td> </tr>
        <tr>
          <td><table width="740" border="0">
            <tr> <div id="inford">
              <td width="49"><input name="txtced_r" type="hidden" id="txtced_r"></td>
              <td width="45"><input name="txtnomb_r" type="hidden" id="txtnomb_r"></td>
              <td width="72"><input name="txtcon_est" type="hidden" id="txtcon_est"></td>
              <td width="80"><input name="txttipo_doc" type="hidden" id="txttipo_doc"></td>
              <td width="114"><input name="txtnro_doc" type="hidden" id="txtnro_doc"></td>
              <td width="114"><input name="txttipo_ord" type="hidden" id="txttipo_ord"></td>
              <td width="114"><input name="txtfecha_d" type="hidden" id="txtfecha_d"></td>
              <td width="118"><input name="txtfecha_h" type="hidden" id="txtfecha_h"></td> </div>
            </tr>
          </table></td>
        </tr>
        <tr> <td><p>&nbsp;</p> </td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="32"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="80"><input name="txtref_comp" type="hidden" id="txtref_comp" value="<?php echo $ref_comp?>"></td>
            <td width="97" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
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