<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Ficha de Bienes Muebles Desincorporado por Correcion)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function llamar_anterior(){  history.back(); }
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtcod_bien_mue.value==""){alert("Codigo de Bien no puede estar Vacia");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;font-weight: bold;color: #FFFFFF;}
-->
</style>
</head>
<? $dia=substr($fecha_hoy,0,2); $error=0; $fecha_hasta=$fecha_hoy; $denominacion=""; $cod_bien_mue=""; ?>
<body>
<form name="form1" method="post" action="carga_bien_desin.php" onSubmit="return revisar()">
  <table width="751" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="744" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">BIENES </span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
		<tr>
             <td><table width="845">
                 <tr>
				   <td width="220"><span class="Estilo5">C&Oacute;DIGO DEL BIEN INMUEBLE :</span></td>
                   <td width="250"><span class="Estilo5"><input name="txtcod_bien_mue" type="text" id="txtcod_bien_mue"  size="40" maxlength="40" value="" readonly class="Estilo10"> </span></td>
                   <td width="375"><input class="Estilo10" name="btbienes" type="button" id="btbienes" title="Abrir Catalogo Bienes"  onClick="VentanaCentrada('Cat_bienes_muebles.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 </tr>
             </table></td>
        </tr>        
        <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">DENOMINACI&Oacute;N DEL BIEN :</span></td>
                 <td width="670"><span class="Estilo5"><input name="txtdenominacion" type="text" id="txtdenominacion" size="100" maxlength="250" value="<?echo $denominacion?>" readonly class="Estilo10"></div></td>
               </tr>
             </table></td>
           </tr>
        <tr>
          <td><span class="Estilo5"> </span>  </td>
        </tr>
        <tr><td>&nbsp;</td> </tr>       
      </table>
        <table width="540" align="center">
          <tr>            
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
