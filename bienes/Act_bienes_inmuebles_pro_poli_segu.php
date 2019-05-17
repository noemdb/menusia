<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){
  $cod_bien_inm='';$p_letra="";
  $sql="SELECT * FROM BIEN021 ORDER BY cod_bien_inm";}
else {
  $cod_bien_inm = $_GET["Gcod_bien_inm"];
  $p_letra=substr($cod_bien_inm, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$cod_bien_inm=substr($cod_bien_inm,1,12);}
   else{$cod_bien_inm=substr($cod_bien_inm,0,12);}
  $sql="Select * from BIEN021 where cod_bien_inm='$cod_bien_inm' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN021 ORDER BY cod_bien_inm";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN021 Order by cod_bien_inm desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN021 Where (cod_bien_inm>'$cod_bien_inm') Order by cod_bien_inm";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN021 Where (cod_bien_inm<'$cod_bien_inm') Order by cod_bien_inm desc";}
  //echo $sql="";"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Ficha de Bienes Muebles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Gcod_bien_inm = "";
function Llamar_Ventana(url)
{
var murl;
    Gcod_bien_inm=document.form1.txtcod_bien_inm.value;
    murl=url+Gcod_bien_inm;
    if (Gcod_bien_inm=="")
        {alert("Cédula/Rif debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos)
{
var murl;
   murl="Act_cod_bien_inms.php";
   if(MPos=="P"){murl="Act_beneficiarios.php?Gcod_bien_inm=P"}
   if(MPos=="U"){murl="Act_beneficiarios.php?Gcod_bien_inm=U"}
   if(MPos=="S"){murl="Act_beneficiarios.php?Gcod_bien_inm=S"+document.form1.txtcod_bien_inm.value;}
   if(MPos=="A"){murl="Act_beneficiarios.php?Gcod_bien_inm=A"+document.form1.txtcod_bien_inm.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url;
var r;
  r=confirm("Esta seguro en Eliminar el Beneficiario ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar el Beneficiario ?");
    if (r==true) {
       url="Delete_beneficiario.php?Gcod_bien_inm="+document.form1.txtcod_bien_inm.value;
       VentanaCentrada(url="";'Eliminar Beneficiario'="";''="";'400'="";'400'="";'true');}
    }
   else { url="Cancelado=""; no elimino"; }
}
</script>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo9 {font-size: 8pt}
-->
</style>
</head>
<?
$cod_bien_inm=""; $numero_poliza="";$ced_rif_proveedor="";$fecha_poliza="";$fecha_desde=""; $fecha_hasta="";$monto_poliza=""; $tasa_cobertura=""; $monto_cobertura="";$inf_usuario=""; $observacion="";
$res=pg_query($sql);
$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * From BIEN021 ORDER BY cod_bien_inm";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN021 ORDER BY cod_bien_inm desc";}
  $res=pg_query($sql);
  $filas=pg_num_rows($res);
}
if($filas>=1){
$registro=pg_fetch_array($res,0);
$cod_bien_inm=$registro["cod_bien_inm"]; 
$numero_poliza=$registro["numero_poliza"];
$ced_rif_proveedor=$registro["ced_rif_proveedor"];
$fecha_poliza=$registro["fecha_poliza"];
$fecha_desde=$registro["fecha_desde"]; 
$fecha_hasta=$registro["fecha_hasta"];
$monto_poliza=$registro["monto_poliza"]; 
$tasa_cobertura=$registro["tasa_cobertura"];
$monto_cobertura=$registro["monto_cobertura"];
$inf_usuario=$registro["inf_usuario"]; 
$observacion=$registro["observacion"];
}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">POLIZA DE SEGURO BIENES INMUBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="438" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="432"><table width="92" height="428" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_bienes_inmuebles_pro_poli_segu.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_bienes_inmuebles_pro_poli_segu.php">Incluir</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_beneficiario.php?Gced_rif=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_beneficiario.php?Gced_rif=');">Modificar</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_beneficiario.php?Gced_rif=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_beneficiario.php?Gced_rif=');">Consultar</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_beneficiarios.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Catalago</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_beneficiario.php?Gced_rif=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_beneficiario.php?Gced_rif=');">Eliminar</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Imprimir</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_a.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_a.php">Ayuda</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_polizas_seguros.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu_polizas_seguros.php">Menu Polizas De Seguros </A></td>
      </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:954px; height:523px; z-index:1; top: 75px; left: 120px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td height="32"><table width="962">
               <tr>
                 <td width="120" scope="col"><span class="Estilo5">C&Oacute;DIGO DE L BIEN INMUEBLES :</span></td>
                 <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcod_bien_inm" type="text" id="txtcod_bien_inm" size="30" maxlength="30"  value="<?echo $cod_bien_inm?>" class="Estilo5" readonly>
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
                 <td width="847" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtdenominacion" type="text" id="txtdenominacion" size="80" maxlength="150" class="Estilo5" readonly>
                     <strong><strong>                 </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="120" scope="col"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="872" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                      <textarea name="textdireccion" cols="70" readonly class="Estilo5" class="headers" id="textdireccion"></textarea>
                     <strong><strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="34">
               <div align="left">
                 <table width="962">
                   <tr>
                     <td width="120" scope="col"><span class="Estilo5">C&Eacute;DULA/RIF EMPRESA ASEGURADORA :</span></td>
                     <td width="820" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                         <input name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12" class="Estilo5" value="<?echo $ced_rif_proveedor?>" readonly>
                         <strong><strong>
                         <input name="bttipo_codeingre22422222243262" type="button" id="bttipo_codeingre224222222432623" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                     </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                   </tr>
                 </table>
              </div></td>
           </tr>
           <tr>
             <td><div align="left">
               <table width="962">
                 <tr>
                   <td width="120" scope="col"><span class="Estilo5">NOMBRE EMPRESA ASEGURADORA :</span></td>
                   <td width="842" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                       <input name="txtdenominacion" type="text" id="txtdenominacion" size="80" maxlength="150" class="Estilo5" readonly>
                       <strong><strong>                   </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DE P&Oacute;LIZA :</span></div></td>
                 <td width="92" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtnumero_poliza" type="text" id="txtnumero_poliza" size="20" maxlength="20" class="Estilo5" value="<?echo $numero_poliza?>" readonly>
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="146" scope="col"><div align="left"><span class="Estilo5">FECHA EMISI&Oacute;N P&Oacute;LIZA :</span></div></td>
                 <td width="580" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_poliza" type="text" id="txtfecha_poliza" size="15" maxlength="15" class="Estilo5" value="<?echo $fecha_poliza?>" readonly>
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="14"><div align="left">
               <table width="963">
                 <tr>
                   <td width="138" scope="col"><div align="left"><span class="Estilo5">PERIODO COBERTURA DE P&Oacute;LIZA DESDE :</span></div></td>
                   <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                       <input name="txtfecha_desde" type="text" id="txtfecha_desde" size="15" maxlength="15" class="Estilo5" value="<?echo $fecha_desde?>" readonly>
                       <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                   <td width="50" scope="col"><div align="left"><span class="Estilo5">HASTA :</span></div></td>
                   <td width="635" scope="col"><div align="left"><span class="Estilo5">
                       <input name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="15" maxlength="15" class="Estilo5" value="<?echo $fecha_hasta?>" readonly>
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
                     <td width="134" scope="col"><div align="left"><span class="Estilo5">MONTO DE LA P&Oacute;LIZA :</span></div></td>
                     <td width="147" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                         <input name="txtmonto_poliza" type="text" id="txtmonto_poliza" size="20" maxlength="15"  value="<?echo $monto_poliza?>" class="Estilo5" readonly>
                         <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                     <td width="82" scope="col"><div align="left"><span class="Estilo5">TASA DE COBERTURA :</span></div></td>
                     <td width="85" scope="col"><div align="left"><span class="Estilo5">
                         <input name="txttasa_cobertura" type="text" id="txttasa_cobertura" size="10" maxlength="15"class="Estilo5" value="<?echo $tasa_cobertura?>" readonly>
                         <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                     <td width="150" scope="col"><span class="Estilo5">MONTO DEL COBERTURA :</span></td>
                     <td width="337" scope="col"><span class="Estilo5">
                       <input name="txtmonto_cobertura" type="text" id="txtmonto_cobertura" size="25" maxlength="15" class="Estilo5" value="<?echo $monto_cobertura?>" readonly>
                     </span></td>
                   </tr>
                 </table>
</div></td>
           </tr>
           <tr>
             <td height="14"><table width="962">
               <tr>
                 <td width="95" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                 <td width="855" scope="col"><div align="left">
                     <textarea name="textobservacion" cols="70" readonly class="Estilo5" class="headers" id="textarea11"><?echo $observacion?></textarea>
                 </div></td>
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
