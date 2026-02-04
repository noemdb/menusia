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
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Asigna Tipos de n&oacute;minas a Usuarios)</title>
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
        {alert("Cídogo Empleado debe ser Seleccionado");}
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
  r=confirm("Esta seguro en Eliminar al Empleado ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar al Empleado ?");
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
.Estilo13 {color: #000000}
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
<table width="991" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="76"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="872"><div align="center" class="Estilo2 Estilo6">ASIGNA TIPOS DE NOMINAS A USUARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="992" height="442" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="436"><table width="92" height="438" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td height="400">&nbsp;</td>
      </tr>
    </table></td>
    <td width="884"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:880px; height:455px; z-index:1; top: 72px; left: 118px;">         
         <table width="813" height="89" border="0" align="center" >
           <tr>
             <td height="27"><table width="796">
               <tr>
                 <td width="129" scope="col"><div align="left"><span class="Estilo5">NOMBRE USUARIO :</span></div></td>
                 <td width="422" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcodigo2" type="text" class="Estilo5" id="txtcodigo2"  onFocus="encender(this)" onBlur="apagar(this)" size="40" maxlength="40">
                 </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                 <td width="229" scope="col"><span class="Estilo5"><span class="Estilo10">                 </span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="27"><table width="796">
               <tr>
                 <td width="128" scope="col"><div align="left"><span class="Estilo5">NOMBRE COMPLETO  :</span></div></td>
                 <td width="578" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcodigo3" type="text" class="Estilo5" id="txtcodigo3"  onFocus="encender(this)" onBlur="apagar(this)" size="40" maxlength="40">
                 </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                 <td width="74" scope="col"><span class="Estilo5"><span class="Estilo10">                 </span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td width="872" height="27"><table width="796">
               <tr>
                 <td width="128" scope="col"><div align="left"><span class="Estilo5">N&Oacute;MINA ACTUAL  :</span></div></td>
                 <td width="47" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcodigo" type="text" class="Estilo5" id="txtcodigo"  onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5">
                 </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> </span></div></td>
                 <td width="605" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtcodigo4" type="text" class="Estilo5" id="txtcodigo4"  onFocus="encender(this)" onBlur="apagar(this)" size="115" maxlength="40">
                 </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span>
                 </span></span></td>
                 </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <div id="Layer1" style="position:absolute; width:850px; height:153px; z-index:2; left: 5px; top: 73px;">
           
           <?include ("../class/class_tab.php");?>
           <script type="text/javascript" language="javascript"> DrawTabs(); </script>
           <!-- PESTAÑA 1 -->
           <div id="T11" class="tab-body">
             <iframe src="Det_selecionar_nomi_actual_uti.php?criterio=<?echo $cod_estructura?>"  width="850" height="230" scrolling="auto" frameborder="0"> </iframe>
           </div>
          </div>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <table width="812">
           <tr>
             <td width="284">&nbsp;</td>
             <td width="352">&nbsp;</td>
             <td width="52"><img src="../imagenes/ACTUALIZA.bmp"></td>
             <td width="48"><img src="../imagenes/Ayuda%2016.bmp"></td>
             <td width="52"><img src="../imagenes/SALIR.BMP"></td>
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