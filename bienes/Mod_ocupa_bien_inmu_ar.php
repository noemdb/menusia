<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$ced_rif='';}else {$ced_rif=$_GET["Gced_rif"];}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Actualiza Ocupantes del Bien Inmueble)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function revisar(){
var f=document.form1;
    if(f.txtced_rif.value==""){alert("Cedula no puede estar Vacio");return false;}else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    if(f.txtnombre_ocupante.value==""){alert("Nombre no puede estar Vacio"); return false; } else{f.txtnombre_ocupante.value=f.txtnombre_ocupante.value.toUpperCase();}
    if(f.txtcedula.value==""){alert("Cedula no puede estar Vacio"); return false; } else{f.txtcedula.value=f.txtcedula.value.toUpperCase();}
    if(f.txtrif.value==""){alert("Rif no puede estar Vacio");return false;}else{f.txtrif.value=f.txtrif.value.toUpperCase();}
    if(f.txtnit.value==""){alert("Nit no puede estar Vacio"); return false; } else{f.txtnit.value=f.txtnit.value.toUpperCase();}
    if(f.txtobservacion.value==""){alert("Observacion no puede estar Vacio"); return false; } else{f.txtobservacion.value=f.txtobservacion.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?php 
$sql="SELECT * From BIEN011 where ced_rif='$ced_rif'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); 
  $ced_rif=$registro["ced_rif"];$nombre_ocupante=$registro["nombre_ocupante"];$cedula=$registro["cedula"];$rif=$registro["rif"];$nit=$registro["nit"];$tipo=$registro["tipo"];$observacion=$registro["observacion"]; }
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR OCUPANTES DEL BIEN INMUEBLE </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="450" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="385"><table width="92" height="450" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_ocupa_bien_inmu_ar.php?Gced_rif=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_ocupa_bien_inmu_ar.php?Gced_rif=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
               <form name="form1" method="post" action="Update_ocupa_bien_inmu_ar.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >

           <tr>
             <td><table width="795">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA/RIF :</span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtced_rif" type="text" class="Estilo5" id="txtced_rif" size="15" maxlength="12"   value="<?php echo $ced_rif?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="803">
               <tr>
                 <td width="130" scope="col"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                 <td width="730" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_ocupante" type="text" class="Estilo5" id="txtnombre_ocupante" size="80" maxlength="80"   value="<?php echo $nombre_ocupante?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="805">
               <tr>
                 <td width="110" scope="col"><span class="Estilo5">C&Eacute;DULA : </span></td>
                 <td width="122" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcedula" type="text" class="Estilo5" id="txtcedula" size="15" maxlength="12"   value="<?php echo $cedula?>">
                     <span class="menu"><strong><strong> </strong></strong></span> </span></span></div></td>
                 <td width="45" scope="col"><span class="Estilo5">R.I.F :</span></td>
                 <td width="129" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtrif" type="text" class="Estilo5" id="txtrif" size="15" maxlength="12"  value="<?php echo $rif?>">
                 </span></div></td>
                 <td width="43" scope="col"><div align="left"><span class="Estilo5">N.I.T :</span></div></td>
                 <td width="379" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnit" type="text" class="Estilo5" id="txtnit" size="15" maxlength="15"  value="<?php echo $nit?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
               <tr>
                 <td width="94" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                 <td width="694" scope="col"><div align="left">
                     <textarea name="txtobservacion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" id="txtobservacion"><?php echo $observacion?></textarea>
                 </div></td>
               </tr>
             </table></td>
           </tr>
        </table>
<table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
           </tr>
             </table></td>
           </tr>

         </table>
         <p>&nbsp;</p>
       </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>
