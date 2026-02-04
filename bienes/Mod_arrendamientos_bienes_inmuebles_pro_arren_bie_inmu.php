<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_bien_inm='';}else {$cod_bien_inm=$_GET["Gcod_bien_inm"];}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Modificar Arrendamiento Bienes Inmuebles)</title>
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
function revisar(){
var f=document.form1;
    if(f.txtcod_bien_inm.value==""){alert("El codigo del Inmueble no puede estar Vacio");return false;}else{f.txtcod_bien_inm.value=f.txtcod_bien_inm.value.toUpperCase();}
    if(f.txtced_arrendatario.value==""){alert("La Cedula no puede estar Vacia"); return false; } else{f.txtced_arrendatario.value=f.txtced_arrendatario.value.toUpperCase();}
    if(f.txtnumero_contrato.value==""){alert("El Numero Contrato no puede estar Vacio");return false;}else{f.txtnumero_contrato.value=f.txtnumero_contrato.value.toUpperCase();}
    if(f.txtfecha_contrato.value==""){alert("La Fecha Contrato no puede estar Vacia"); return false; } else{f.txtfecha_contrato.value=f.txtfecha_contrato.value.toUpperCase();}
    if(f.txtfecha_desde.value==""){alert("La Fecha Desde no puede estar Vacia"); return false; } else{f.txtfecha_desde.value=f.txtfecha_desde.value.toUpperCase();}
    if(f.txtfecha_hasta.value==""){alert("La Fecha Hasta no puede estar Vacia"); return false; } else{f.txtfecha_hasta.value=f.txtfecha_hasta.value.toUpperCase();}
    if(f.txtcanon_arr.value==""){alert("El Canon no puede estar Vacio");return false;}else{f.txtcanon_arr.value=f.txtcanon_arr.value.toUpperCase();}
    if(f.txtgarantia_fianza.value==""){alert("La Garantia no puede estar Vacia");return false;}else{f.txtgarantia_fianza.value=f.txtgarantia_fianza.value.toUpperCase();}
    if(f.txtobservacion.value==""){alert("La Observacion no puede estar Vacio");return false;}else{f.txtobservacion.value=f.txtobservacion.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?php 
$sql="SELECT * From BIEN017 where cod_bien_inm='$cod_bien_inm'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); 
$cod_bien_inm=$registro["cod_bien_inm"]; 
$numero_contrato=$registro["numero_contrato"];
$ced_arrendatario=$registro["ced_arrendatario"];
$fecha_contrato=$registro["fecha_contrato"];
$fecha_desde=$registro["fecha_desde"]; 
$fecha_hasta=$registro["fecha_hasta"];
$canon_arr=$registro["canon_arr"]; 
$garantia_fianza=$registro["garantia_fianza"];
$observacion=$registro["observacion"];}
//Bienes inmuebles
$Ssql="SELECT * FROM BIEN014 where cod_bien_inm='".$cod_bien_inm."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion=$registro["denominacion"];}
//Arrendatario
$Ssql="SELECT * FROM pre099 where ced_rif='".$ced_arrendatario."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre=$registro["nombre"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR ARRENDAMIENTOS BIENES INMUBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="450" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="385"><table width="92" height="450" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php?Gcod_bien_inm=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php?Gcod_bien_inm=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Archivos</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
               <form name="form1" method="post" action="Update_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >

           <tr>
             <td height="32"><table width="962">
               <tr>
                 <td width="100" scope="col"><span class="Estilo5">C&Oacute;DIGO DE L BIEN INMUEBLES :</span></td>
                 <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcod_bien_inm" type="text" class="Estilo5" id="txtcod_bien_inm" size="30" maxlength="30"  value="<?php echo $cod_bien_inm?>" readonly class="Estilo5">
                     <strong><strong>
                    </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="100" scope="col"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                 <td width="847" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtdenominacion" type="text" class="Estilo5" id="txtdenominacion" size="80" maxlength="150"  value="<?php echo $denominacion?>" readonly class="Estilo5">
                     <strong><strong>                 </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><div align="center">
               <table width="962">
                 <tr>
                   <td width="170" scope="col"><span class="Estilo5">C&Eacute;DULA DE ARRENDATARIO :</span></td>
                   <td width="784" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                       <input name="txtced_arrendatario" type="text" class="Estilo5" id="txtced_arrendatario" size="" maxlength="12"  value="<?php echo $ced_arrendatario?>" >
                       <strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_arrendatariosd.php?criterio=','SIPAP','','750','500','true')" value="...">
                   </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td><div align="left">
               <table width="962">
                 <tr>
                   <td width="170" scope="col"><span class="Estilo5">NOMBRE DE ARRENDATARIO :</span></td>
                   <td width="780" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                       <input name="txtnombre_arrendatario" type="text" class="Estilo5" id="txtnombre_arrendatario" size="70" maxlength="150" value="<?php echo $nombre?>" >
                       <strong><strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="170" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO CONTRATO :</span></div></td>
                 <td width="90" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtnumero_contrato" type="text" class="Estilo5" id="txtnumero_contrato" size="10" maxlength="10"  value="<?php echo $numero_contrato?>" >
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="115" scope="col"><div align="left"><span class="Estilo5">FECHA CONTRATO :</span></div></td>
                 <td width="611" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_contrato" type="text" class="Estilo5" id="txtfecha_contrato" size="15" maxlength="15"  value="<?php echo $fecha_contrato?>" >
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="32"><div align="left">
               <table width="963">
                 <tr>
                   <td width="170" scope="col"><div align="left"><span class="Estilo5">PERIODO ARRENDAMIENTO DESDE :</span></div></td>
                   <td width="125" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                       <input name="txtfecha_desde" type="text" class="Estilo5" id="txtfecha_desde" size="15" maxlength="15" value="<?php echo $fecha_desde?>" >
                       <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                   <td width="50" scope="col"><div align="left"><span class="Estilo5">HASTA :</span></div></td>
                   <td width="610" scope="col"><div align="left"><span class="Estilo5">
                       <input name="txtfecha_hasta" type="text" class="Estilo5" id="txtfecha_hasta" size="15" maxlength="15"  value="<?php echo $fecha_hasta?>" >
                       <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td height="14">
               <div align="left">
                 <table width="963">
                   <tr>
                     <td width="170" scope="col"><div align="left"><span class="Estilo5">CANON DE ARRENDAMIENTO :</span></div></td>
                     <td width="122" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                         <input name="txtcanon_arr" type="text" class="Estilo5" id="txtcanon_arr" size="15" maxlength="15" value="<?php echo $canon_arr?>" >
                         <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                     <td width="163" scope="col"><div align="left"><span class="Estilo5">VALOR GARANTIA/FINANZA :</span></div></td>
                     <td width="548" scope="col"><div align="left"><span class="Estilo5">
                         <input name="txtgarantia_fianza" type="text" class="Estilo5" id="txtgarantia_fianza" size="20" value="<?php echo $garantia_fianza?>" >
                         <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                   </tr>
                 </table>
              </div></td>
           </tr>
         </table>
         <table width="974" align="center">
           <tr>
             <td>
               <div align="left">
                 <table width="962">
                   <tr>
                     <td width="170" scope="col"><div align="left"><span class="Estilo5">ODSERVACI&Oacute;N :</span></div></td>
                     <td width="855" scope="col"><div align="left">
                         <textarea name="txtobservacion" cols="70" class="headers" id="txtobservacion"><?php echo $observacion?></textarea>
                     </div></td>
                   </tr>
                 </table>
               </div></td>
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
