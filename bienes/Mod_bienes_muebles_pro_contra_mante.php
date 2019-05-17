<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_bien_mue='';}else {$cod_bien_mue=$_GET["Gcod_bien_mue"];}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Modifica Contrato de Mantenimiento de Bienes Muebles)</title>
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
    if(f.txtcod_bien_mue.value==""){alert("El Codigo del Mueble no puede estar Vacio");return false;}else{f.txtcod_bien_mue.value=f.txtcod_bien_mue.value.toUpperCase();}
    if(f.txtced_rif_proveedor.value==""){alert("La Cedula no puede estar Vacia"); return false; } else{f.txtced_rif_proveedor.value=f.txtced_rif_proveedor.value.toUpperCase();}
    if(f.txtnumero_contrato.value==""){alert("El Numero Contrato no puede estar Vacio");return false;}else{f.txtnumero_contrato.value=f.txtnumero_contrato.value.toUpperCase();}
    if(f.txtfecha_contrato.value==""){alert("La Fecha del Contrato no puede estar Vacio");return false;}else{f.txtfecha_contrato.value=f.txtfecha_contrato.value.toUpperCase();}
    if(f.txtfecha_desde.value==""){alert("La Fecha desde no puede estar Vacia");return false;}else{f.txtfecha_desde.value=f.txtfecha_desde.value.toUpperCase();}
    if(f.txtfecha_hasta.value==""){alert("La Fecha hasta no puede estar Vacia");return false;}else{f.txtfecha_hasta.value=f.txtfecha_hasta.value.toUpperCase();}
    if(f.txtmonto_contrato.value==""){alert("El Monto del Contrato no puede estar Vacio");return false;}else{f.txtmonto_contrato.value=f.txtmonto_contrato.value.toUpperCase();}
    if(f.txtobservacion.value==""){alert("La Observacion no puede estar Vacia");return false;}else{f.txtobservacion.value=f.txtobservacion.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?
$sql="SELECT * From BIEN019 where cod_bien_mue='$cod_bien_mue'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){
$registro=pg_fetch_array($res,0); 
$cod_bien_mue=$registro["cod_bien_mue"]; 
$numero_contrato=$registro["numero_contrato"];
$ced_rif_proveedor=$registro["ced_rif_proveedor"];
$fecha_contrato=$registro["fecha_contrato"];
if($fecha_contrato==""){$fecha_contrato="";}else{$fecha_contrato=formato_ddmmaaaa($fecha_contrato);}
$fecha_desde=$registro["fecha_desde"]; 
if($fecha_desde==""){$fecha_desde="";}else{$fecha_desde=formato_ddmmaaaa($fecha_desde);}
$fecha_hasta=$registro["fecha_hasta"];
if($fecha_hasta==""){$fecha_hasta="";}else{$fecha_hasta=formato_ddmmaaaa($fecha_hasta);}
$monto_contrato=$registro["monto_contrato"]; 
$inf_usuario=$registro["inf_usuario"]; 
$observacion=$registro["observacion"];
}
//Bienes muebles
$Ssql="SELECT * FROM BIEN015 where cod_bien_mue='".$cod_bien_mue."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion=$registro["denominacion"];$marca=$registro["marca"];$modelo=$registro["modelo"];$color=$registro["color"];$matricula=$registro["matricula"];$serial1=$registro["serial1"];$serial2=$registro["serial2"];}
//Arrendatario
$Ssql="SELECT * FROM pre099 where ced_rif='".$ced_rif_proveedor."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre=$registro["nombre"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR CONTRATO DE MANTENIMIENTOS  BIENES MUEBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="450" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="385"><table width="92" height="450" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_bienes_muebles_pro_contra_mante.php?Gcod_bien_mue=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_bienes_muebles_pro_contra_mante.php?Gcod_bien_mue=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Archivos</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
               <form name="form1" method="post" action="Update_bienes_muebles_pro_contra_mante.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >

           <tr>
             <td height="32"><table width="962">
               <tr>
                 <td width="120" scope="col"><span class="Estilo5">C&Oacute;DIGO DE L BIEN MUEBLES :</span></td>
                 <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcod_bien_mue" type="text" id="txtcod_bien_mue" size="30" maxlength="30"  value="<?echo $cod_bien_mue?>" readonly class="Estilo5">
                     <strong><strong>
                     <input name="bttipo_codeingre2242222224326" type="button" id="bttipo_codeingre2242222224326" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                    </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="120" scope="col"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="847" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtdenominacion" type="text" id="txtdenominacion" size="85" maxlength="100"  value="<?echo $denominacion?>"  readonly class="Estilo5">
                </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">MARCA :</span></div></td>
                <td width="210" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtmarca" type="text" id="txtmarca" size="30" maxlength="30" value="<?echo $marca?>"   readonly class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="61" scope="col"><div align="left"><span class="Estilo5">MODELO :</span></div></td>
                <td width="620" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtmodelo" type="text" id="txtmodelo" size="30" maxlength="30" value="<?echo $modelo?>"   readonly class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">COLOR :</span></div></td>
                <td width="208" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcolor" type="text" id="txtcolor" size="30" maxlength="30"  value="<?echo $color?>"  readonly class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="79" scope="col"><div align="left"><span class="Estilo5">MATRICULA :</span></div></td>
                <td width="601" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtmatricula" type="text" id="txtmatricula" size="30" maxlength="30"  value="<?echo $matricula?>"  readonly class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">SERIAL :</span></div></td>
                <td width="213" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtserial1" type="text" id="txtserial1" size="30" maxlength="30"  value="<?echo $serial1?>"  readonly class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="64" scope="col"><div align="left"><span class="Estilo5">SERIAL 2 :</span></div></td>
                <td width="614" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtserial2" type="text" id="txtserial2" size="30" maxlength="30" value="<?echo $serial2?>"  readonly class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
           <tr>
             <td height="34"><div align="center">
               <table width="962">
                 <tr>
                   <td width="140" scope="col"><span class="Estilo5">C&Eacute;DULA/RIF PROVEEDOR DEl SERVICIO DE MANTENIMIENTO :</span></td>
                   <td width="767" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                       <input name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12"  value="<?echo $ced_rif_proveedor?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                       <strong><strong>
                      
                   </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td><div align="left">
               <table width="962">
                 <tr>
                   <td width="150" scope="col"><span class="Estilo5">NOMBRE DE PROVEEDOR :</span></td>
                   <td width="799" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                       <input name="txtnombre" type="text" id="txtmonbre" size="80" maxlength="150" value="<?echo $nombre?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                       <strong><strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="150" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO CONTRATO :</span></div></td>
                 <td width="90" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtnumero_contrato" type="text" id="txtnumero_contrato" size="10" maxlength="10"  value="<?echo $numero_contrato?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="115" scope="col"><div align="left"><span class="Estilo5">FECHA CONTRATO :</span></div></td>
                 <td width="611" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_contrato" type="text" id="txtfecha_contrato" size="15" maxlength="15"  value="<?echo $fecha_contrato?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="34"><div align="left">
               <table width="963">
                 <tr>
                   <td width="170" scope="col"><div align="left"><span class="Estilo5">PERIODO CONTRATO DESDE :</span></div></td>
                   <td width="122" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                       <input name="txtfecha_desde" type="text" id="txtfecha_desde" size="15" maxlength="15" value="<?echo $fecha_desde?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                       <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                   <td width="51" scope="col"><div align="left"><span class="Estilo5">HASTA :</span></div></td>
                   <td width="119" scope="col"><div align="left"><span class="Estilo5">
                       <input name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="15" maxlength="15" value="<?echo $fecha_hasta?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                       <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                   <td width="145" scope="col"><span class="Estilo5">MONTO DEL CONTRATO :</span></td>
                   <td width="379" scope="col"><span class="Estilo5">
                     <input name="txtmonto_contrato" type="text" id="txtmonto_contrato" size="25" maxlength="15"  value="<?echo $monto_contrato?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                   </span></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td height="14">
               <div align="left">
                 <table width="962">
                   <tr>
                     <td width="150" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                     <td width="855" scope="col"><div align="left">
                         <textarea name="txtobservacion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="txtobservacion"><?echo $observacion?></textarea>
                     </div></td>
                   </tr>
                 </table>
               </div></td>
           </tr>
           <tr>

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
<? pg_close();?>
