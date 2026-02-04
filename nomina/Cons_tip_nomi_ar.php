<?include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){
  $ced_rif='';$p_letra="";
  $sql="SELECT * FROM PRE099 ORDER BY ced_rif";}
else {
  $ced_rif = $_GET["Gced_rif"];
  $p_letra=substr($ced_rif, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$ced_rif=substr($ced_rif,1,12);}
   else{$ced_rif=substr($ced_rif,0,12);}
  $sql="Select * from PRE099 where ced_rif='$ced_rif' ";
  if ($p_letra=="P"){$sql="SELECT * FROM PRE099 ORDER BY ced_rif";}
  if ($p_letra=="U"){$sql="SELECT * From PRE099 Order by ced_rif desc";}
  if ($p_letra=="S"){$sql="SELECT * From PRE099 Where (ced_rif>'$ced_rif') Order by ced_rif";}
  if ($p_letra=="A"){$sql="SELECT * From PRE099 Where (ced_rif<'$ced_rif') Order by ced_rif desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Consulta Tipos De N&oacute;minas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Gced_rif = "";
function Llamar_Ventana(url)
{
var murl;
    Gced_rif=document.form1.txtced_rif.value;
    murl=url+Gced_rif;
    if (Gced_rif=="")
        {alert("Cédula/Rif debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos)
{
var murl;
   murl="Act_codigos.php";
   if(MPos=="P"){murl="Act_beneficiarios.php?Gced_rif=P"}
   if(MPos=="U"){murl="Act_beneficiarios.php?Gced_rif=U"}
   if(MPos=="S"){murl="Act_beneficiarios.php?Gced_rif=S"+document.form1.txtced_rif.value;}
   if(MPos=="A"){murl="Act_beneficiarios.php?Gced_rif=A"+document.form1.txtced_rif.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url;
var r;
  r=confirm("Esta seguro en Eliminar el Beneficiario ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar el Beneficiario ?");
    if (r==true) {
       url="Delete_beneficiario.php?Gced_rif="+document.form1.txtced_rif.value;
       VentanaCentrada(url,'Eliminar Beneficiario','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
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
.Estilo10 {font-size: 12px}
.Estilo12 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>
<?
$nombre="";$cedula="";
$rif="";$nit="";
$direccion="";$tipo_benef="";
$res=pg_query($sql);
$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * From PRE099 ORDER BY ced_rif";}
  if ($p_letra=="A"){$sql="SELECT * From PRE099 ORDER BY ced_rif desc";}
  $res=pg_query($sql);
  $filas=pg_num_rows($res);
}
if($filas>=1){
  $registro=pg_fetch_array($res,0);
  $ced_rif=$registro["ced_rif"];
  $nombre=$registro["nombre"];$cedula=$registro["cedula"];
  $rif=$registro["rif"];$nit=$registro["nit"];
  $direccion=$registro["direccion"];$tipo_benef=$registro["tipo_benef"];
  $ced_rif_aut=$registro["ced_rif_autorizado"];$nombre_auto=$registro["nombre_autorizado"];
  $ciudad=$registro["ciudad"];$municipio=$registro["municipio"];
  $region=$registro["region"];$estado=$registro["estado"];
  $pais=$registro["pais"];$telefono=$registro["telefono"];
  $fax=$registro["fax"];$tlf_movil=$registro["tlf_movil"];
  $pasaporte=$registro["pasaporte"];$nacionalidad=$registro["nacionalidad"];
  $residente=$registro["residente"];$observaciones=$registro["observaciones"];
  $clasificacion=$registro["clasificacion"];$rep_legal=$registro["representante_legal"];
  $cod_postal=$registro["cod_postal"];$aptd_postal=$registro["aptd_postal"];
  $tipo_orden=$registro["tipo_orden"];
  $des_tipo_orden="";
  $inf_usuario=$registro["inf_usuario"];
}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> CONSULTAR - TIPOS DE N&Oacute;MINAS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="468" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="462"><table width="92" height="457" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_tip_nomi_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Act_tip_nomi_ar.php">Atras</a></div></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr>
   </table></td>
    <td width="892"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:861px; height:452px; z-index:1; top: 71px; left: 114px;">
         <table width="852" border="0" align="center" >
           <tr>
             <td><table width="846">
               <tr>
                 <td width="108" scope="col"><div align="left"><span class="Estilo5">TIPO DE N&Oacute;MINA  :</span></div></td>
                 <td width="717" scope="col"><div align="left"><span class="Estilo5">
                     <span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txttipo_nomina" type="text" class="Estilo5" id="txttipo_nomina"  onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5">
                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></span>                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="848">
               <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N  :</span></div></td>
                 <td width="726" scope="col"><div align="left"><span class="Estilo5">
                 <span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                 <textarea name="txtdescripcion" cols="115" class="Estilo5" id="txtdescripcion" readonly></textarea>
                 </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="34"><table width="846">
               <tr>
                 <td width="83" scope="col"><div align="left"><span class="Estilo5">FRECUENCIA  : </span></div></td>
                 <td width="106" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10">
                     <strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtfrecuencia" type="text" class="Estilo5" id="txtfrecuencia"   size="5" maxlength="5" readonly>
                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                     </strong></strong></strong></strong>                 </span></strong></strong> </strong></strong></span> </span></div></td>
                 <td width="152" scope="col"><div align="left"><span class="Estilo5">ULTIMA FECHA PROCESO  : </span></div></td>
                 <td width="114" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo10">
                     <strong><strong><strong><strong><strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtultima_fecha" type="text" class="Estilo5" id="txtultima_fecha"  size="15" maxlength="15" readonly>
                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong>                 </span></strong></strong></strong></strong> </strong></strong></span> </span></div></td>
                 <td width="158" scope="col"><span class="Estilo5">Nro. SEMANAL/QUINCENAL : </span></td>
                 <td width="52" scope="col"><span class="Estilo5">
                   <span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtnro_semana" type="text" class="Estilo5" id="txtnro_semana"  size="5" maxlength="5" readonly>
                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></span>                 </span></td>
                 <td width="81" scope="col"><span class="Estilo5">REDONDEAR  : </span></td>
                 <td width="64" scope="col"><span class="Estilo5"><span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong>
                   <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtredondear" type="text" class="Estilo5" id="txtredondear"  size="6" maxlength="5" readonly>
                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </strong></strong></strong></strong></span></strong></strong></strong></strong></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="847">
               <tr>
                 <td width="132" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N GRUPO:</span></div></td>
                 <td width="703" scope="col"><div align="left"><span class="Estilo5">
                 <span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                 <textarea name="texdesc_grupo" cols="111" class="Estilo5" id="texdesc_grupo" readonly></textarea>
                 </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="32"><table width="848">
               <tr>
                 <td width="186" scope="col"><div align="left"><span class="Estilo5">CONCEPTO SUELDO  B&Aacute;SICO : </span></div></td>
                 <td width="103" scope="col"><div align="left"><span class="Estilo5">                     <span class="menu"><strong><strong><strong><strong><span class="Estilo10">
                   <strong><strong><strong><strong>
                   <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtcon_sue_bas" type="text" class="Estilo5" id="txtcon_sue_bas"  size="5" maxlength="5" readonly>
                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                   </strong></strong></strong></strong>                 </span></strong></strong> </strong></strong></span> </span></div></td>
                 <td width="170" scope="col"><div align="left"><span class="Estilo5">CONCEPTO COMPENSACI&Oacute;N  : </span></div></td>
                 <td width="71" scope="col"><div align="left"><span class="Estilo5">
                     <span class="menu"><strong><strong><strong><strong><span class="Estilo10">
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcon_compen" type="text" class="Estilo5" id="txtcon_compen"  size="5" maxlength="5" readonly>
                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                    </span></strong></strong></strong></strong></span>                     <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                 <td width="226" scope="col"><span class="Estilo5">CONCEPTO TOTAL COMPENSACIONES  : </span></td>
                 <td width="64" scope="col"><span class="Estilo5">
                   <span class="menu"><strong><strong><strong><strong><span class="Estilo10">
                   <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtcon_tot_compen" type="text" class="Estilo5" id="txtcon_tot_compen"  size="5" maxlength="5" readonly>
                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                   </span></strong></strong></strong></strong></span>                 </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="849">
               <tr>
                 <td width="185" scope="col"><div align="left"><span class="Estilo5">CONCEPTO TOTAL PRIMAS : </span></div></td>
                 <td width="93" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcon_tot_prima" type="text" class="Estilo5" id="txtcon_tot_prima"  size="5" maxlength="5" readonly>
                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
                 <td width="184" scope="col"><div align="left"><span class="Estilo5">CONCEPTO SUELDO INTEGRAL : </span></div></td>
                 <td width="126" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10">
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcon_sue_int" type="text" class="Estilo5" id="txtcon_sue_int"  size="5" maxlength="5" readonly>
                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </span></strong></strong></strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                 <td width="169" scope="col"><span class="Estilo5">CONCEPTO SUELDO TOTAL : </span></td>
                 <td width="64" scope="col"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10">
                   <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtcon_sue_tot" type="text" class="Estilo5" id="txtcon_sue_tot"  size="5" maxlength="5" readonly>
                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </span></strong></strong></strong></strong></span> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="34"><table width="846">
               <tr>
                 <td width="185" scope="col"><div align="left"><span class="Estilo5">CONCEPTO BONO VACACIONAL : </span></div></td>
                 <td width="62" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcon_bon_vac" type="text" class="Estilo5" id="txtcon_bon_vac"  size="5" maxlength="5" readonly>
                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
                 <td width="211" scope="col"><div align="left"><span class="Estilo5">CONCEPTO BONO VAC. POR PAGAR : </span></div></td>
                 <td width="71" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10">
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txt****" type="text" class="Estilo5" id="txt****"  size="5" maxlength="5" readonly>
                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </span></strong></strong></strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                 <td width="220" scope="col"><span class="Estilo5">CONCEPTO C&Aacute;LCULO VACACIONALES : </span></td>
                 <td width="59" scope="col"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10">
                   <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtcon_cal_vac" type="text" class="Estilo5" id="txtcon_cal_vac"  size="5" maxlength="5" readonly>
                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </span></strong></strong></strong></strong></span> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="846">
               <tr>
                 <td width="235" scope="col"><div align="left"><span class="Estilo5">CONCEPTO C&Aacute;LCULO  LIQUIDACI&Oacute;N : </span></div></td>
                 <td width="287" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong>
                   <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtcon_cal_liqui" type="text" class="Estilo5" id="txtcon_cal_liqui"  size="5" maxlength="5" readonly>
                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong></strong></strong> </strong></strong></span> </span></div></td>
                 <td width="243" scope="col"><div align="left"><span class="Estilo5">CONCEPTO C&Aacute;LCULO D&Iacute;AS ADICIONALES  : </span></div></td>
                 <td width="61" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong>
                   <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txt****" type="text" class="Estilo5" id="txt****"  size="5" maxlength="5" readonly>
                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="30"><table width="848">
               <tr>
                 <td width="234" scope="col"><div align="left"><span class="Estilo5">GENERA INFORMACI&Oacute;N ORDEN DE PAGO  : </span></div></td>
                 <td width="309" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo10">
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtg_orden_pago" type="text" class="Estilo5" id="txtg_orden_pago"  size="5" maxlength="5" readonly>
                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </span></strong></strong></strong></strong> </strong></strong></span> </span></div></td>
                 <td width="226" scope="col"><div align="left"><span class="Estilo5">CALCULA INTERESES DE FIDECOMISO  : </span></div></td>
                 <td width="59" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10">
                     <strong><strong><strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txt****" type="text" class="Estilo5" id="txt****"  size="5" maxlength="5" readonly>
                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                     </strong></strong></strong></strong></strong></strong>                 </span></strong></strong> </strong></strong></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="846">
               <tr>
                 <td width="225" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA O/P N&Oacute;MINA : </span></div></td>
                 <td width="150" scope="col"><div align="left"><span class="Estilo5">                     <span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong>
                   <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txt***" type="text" class="Estilo5" id="txt***"  size="20" maxlength="20" readonly>
                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </strong></strong></strong></strong>
                 </span></strong></strong></strong></strong> </strong></strong></span> </span></div></td>
                 <td width="318" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA O/P N&Oacute;MINA EXTRAORDINARIA : </span></div></td>
                 <td width="133" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txt***" type="text" class="Estilo5" id="txt***"  size="20" maxlength="20" readonly>
                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                 </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="27"><table width="847" height="27">
               <tr>
                 <td width="225" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA O/P N&Oacute;MINA 2 : </span></div></td>
                 <td width="610" scope="col"><div align="left"><span class="Estilo5">
                     <span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txt***" type="text" class="Estilo5" id="txt***"  size="20" maxlength="20" readonly>
                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                     </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>                     </strong></strong></strong></strong></span></strong></strong></strong></strong></strong></strong></span>                 </span></div></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <table width="812">
           <tr>
             <td width="664">&nbsp;</td>
             <td width="88">&nbsp;</td>
             <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
           </tr>
         </table>
       </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>