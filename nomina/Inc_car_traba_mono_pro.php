<?include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
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
<title>SIA CONTROL N&Oacute;MINA Y PERSONAL (Actualiza Carga Montos de Conceptos por Trabajador)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
        {alert("C�dula/Rif debe ser Seleccionada");}
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
  r=confirm("Esta seguro en Eliminar el Trabajador ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar el Trabajador ?");
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
<div id="Layer3" style="position:absolute; width:807px; height:177px; z-index:2; left: 117px; top: 115px;">
  
  <?include ("../class/class_tab.php");?>
  <script type="text/javascript" language="javascript"> DrawTabs(); </script>
  <!-- PESTA�A 1 -->
  <div id="T11" class="tab-body">
    <iframe src="Det_carga_trabajador.php?criterio=<?echo $cod_estructura?>"  width="846" height="170" scrolling="auto" frameborder="0"> </iframe>
  </div>
</div>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CARGA MONTO DE CONCEPTOS  POR TRABAJADOR </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="391" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="385"><table width="92" height="379" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_car_traba_mono_pro.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Act_car_traba_mono_pro.php">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td height="305">&nbsp;</td>
      </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:867px; height:363px; z-index:1; top: 68px; left: 115px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td height="27"><table width="837">
               <tr>
                 <td width="134" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA IDENTIDAD  :</span></div></td>
                 <td width="44" scope="col"><div align="left"><span class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txttipo_nomina" type="text" class="Estilo5" id="txttipo_nomina"  onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5">
                    </strong></strong></strong></strong></strong></strong></strong></strong>                    </strong></strong></strong></strong></strong></strong></strong></strong></span></span></span></div></td>
                 <td width="42" scope="col"><span class="Estilo5">
                   <input type="submit" name="Submit3" value="...">
                 </span></td>
                 <td width="597" scope="col"><span class="Estilo5">
                   <span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                   <strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtcedula332" type="text" class="Estilo5" id="txtcedula332" size="103" maxlength="103" readonly>
                   </strong></strong></strong></strong></strong></strong></strong></strong>                   </strong></strong></strong></strong></strong></strong></strong></strong></span></span>                 </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="838">
               <tr>
                 <td width="136" scope="col"><div align="left"><span class="Estilo5">NOMBRE TRABAJADOR  :</span></div></td>
                 <td width="52" scope="col"><div align="left"><span class="Estilo5"> <span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txttipo_nomina2" type="text" class="Estilo5" id="txttipo_nomina2"  onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5">
                    </strong></strong></strong></strong></strong></strong></strong></strong>                 </strong></strong></strong></strong></strong></strong></strong></strong></span></span> </span></div></td>
                 <td width="634" scope="col"><span class="Estilo5"> <span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtcedula33" type="text" class="Estilo5" id="txtcedula33" size="110" maxlength="111" readonly>
                 </strong></strong></strong></strong></strong></strong></strong></strong></span></span> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="14">&nbsp;</td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <table width="833" dwcopytype="CopyTableRow">
           <tr>
             <td width="664">&nbsp;</td>
             <td width="88"><input name="Submit" type="submit" id="Submit2"  value="Grabar"></td>
             <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
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