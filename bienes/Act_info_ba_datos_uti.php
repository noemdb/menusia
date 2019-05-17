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
<title>SIA CONTABILIDAD PRESUPUESTARIA (Actualiza Información De Base De Datos)</title>
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
.Estilo12 {font-size: 10px; font-weight: bold; }
.Estilo10 {font-size: 12px}
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">ESTADISTICAS DEL MODULO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="467" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="461"><table width="92" height="457" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_u.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_u.php">Menu Utilidades</A></td>
      </tr>
  <td height="419">&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:861px; height:523px; z-index:1; top: 73px; left: 120px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><span class="Estilo12">INFORMACI&Oacute;N DE BASES DE DATOS </span></td>
           </tr>
           <tr>
             <td><div align="center">AQUI VA UNA TABLA </div></td>
           </tr>
           <tr>
             <td><span class="Estilo12">INFORMACI&Oacute;N DEL MODULO </span></td>
           </tr>
           <tr>
             <td><span class="Estilo12">INFORMACI&Oacute;N GENERAL </span></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="73" scope="col"><div align="left" class="Estilo5"> EJERCICIO :</div></td>
                 <td width="62" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txttaza_inte_mora222332" type="text" id="txttaza_inte_mora2223324" size="5" maxlength="15"  readonly class="Estilo5">
                     <span class="menu"><strong><strong> </strong></strong></span> </span></span></div></td>
                 <td width="62" scope="col"><span class="Estilo5">ESTATUS :</span></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txttaza_inte_mora22432" type="text" id="txttaza_inte_mora224325" size="15" maxlength="15"  readonly class="Estilo5">
                 </span></div></td>
                 <td width="140" scope="col"><div align="left"><span class="Estilo5">ENTRADAS AL M&Oacute;DULO :</span></div></td>
                 <td width="63" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtperio_mora22332" type="text" id="txtperio_mora223326" size="5" maxlength="15"  readonly class="Estilo5">
                 </span></div></td>
                 <td width="88" scope="col"><span class="Estilo5">TIPO DE USO :</span></td>
                 <td width="318" scope="col"><span class="Estilo5">
                   <input name="txttaza_inte_mora224322" type="text" id="txttaza_inte_mora22432" size="15" maxlength="15"  readonly class="Estilo5">
                 </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo12">INFORMACI&Oacute;N DE USUARIO </span></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="139" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL USUARIO :</span></div></td>
                 <td width="196" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcant_vence_fact22533" type="text" id="txtcant_vence_fact22533" size="25" maxlength="15"  readonly class="Estilo5">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="119" scope="col"><div align="left"><span class="Estilo5">NRO DEL USUARIO :</span></div></td>
                 <td width="489" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcant_vence_fact2533" type="text" id="txtcant_vence_fact2533" size="5" maxlength="15"  readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="105" scope="col"><div align="left"><span class="Estilo5">TOTAL USUARIO :</span></div></td>
                 <td width="94" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcant_vence_fact225332" type="text" id="txtcant_vence_fact225332" size="5" maxlength="15"  readonly class="Estilo5">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="255" scope="col"><div align="left">
                     <select name="select">
                       <option>LISTA DE USUARIO</option>
                     </select>
                 </div></td>
                 <td width="489" scope="col"><div align="left"><span class="Estilo5"> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <table width="828" align="center">
           <tr>
             <td><span class="Estilo12">AUDITORIA</span></td>
           </tr>
           <tr>
             <td><span class="Estilo12">ORDENAR</span></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="147" scope="col"><div align="left" class="Estilo5">
                     <input type="checkbox" name="checkbox" value="checkbox">
        NOMBRE USUARIO</div></td>
                 <td width="112" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2" value="checkbox">
      OPERACI&Oacute;N</span>
                     <div align="left"><span class="Estilo5"><span class="Estilo10"> </span></span></div></td>
                 <td width="157" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox3" value="checkbox">
      FECHA OPERACI&Oacute;N</span></td>
                 <td width="161" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox4" value="checkbox">
      FECHA DOCUMENTO</span>
                     <div align="left"></div></td>
                 <td width="237" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox5" value="checkbox">
        NINGUNO</span></div></td>
                 <td width="41" scope="col"><div align="left"><span class="Estilo5"> </span></div></td>
                 <td width="32" scope="col">&nbsp;</td>
                 <td width="39" scope="col"><span class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo12">FILTRAR</span></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="139" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL USUARIO :</span></div></td>
                 <td width="196" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcant_vence_fact225333" type="text" id="txtcant_vence_fact225333" size="25" maxlength="15"  readonly class="Estilo5">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="80" scope="col"><div align="left"><span class="Estilo5">REFERENCIA :</span></div></td>
                 <td width="528" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcant_vence_fact25332" type="text" id="txtcant_vence_fact25333" size="20" maxlength="15"  readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="123" scope="col"><div align="left" class="Estilo5">FECHA DOCUMENTO : </div></td>
                 <td width="107" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <select name="select2">
                       <option>CALENDARIO</option>
                     </select>
                 </span></span></div></td>
                 <td width="50" scope="col"><span class="Estilo5">
                   <input name="radiobutton" type="radio" value="radiobutton">
      =</span></td>
                 <td width="46" scope="col"><span class="Estilo5">
                   <input name="radiobutton" type="radio" value="radiobutton">
&lt;=</span>
                     <div align="left"></div></td>
                 <td width="488" scope="col"><div align="left"><span class="Estilo5">
                     <input name="radiobutton" type="radio" value="radiobutton">
&gt;=</span></div></td>
                 <td width="41" scope="col"><div align="left"><span class="Estilo5"> </span></div></td>
                 <td width="32" scope="col">&nbsp;</td>
                 <td width="39" scope="col"><span class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="79" scope="col"><div align="left" class="Estilo5">OPERACI&Oacute;N : </div></td>
                 <td width="161" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <select name="select3">
                       <option>TODAS</option>
                       <option>ELIMINO</option>
                       <option>ANULO</option>
                       <option>MODIFICO</option>
                     </select>
                 </span></span></div></td>
                 <td width="40" scope="col">&nbsp;</td>
                 <td width="46" scope="col"><div align="left"></div></td>
                 <td width="488" scope="col"><div align="left"></div></td>
                 <td width="41" scope="col"><div align="left"><span class="Estilo5"> </span></div></td>
                 <td width="32" scope="col">&nbsp;</td>
                 <td width="39" scope="col"><span class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="119" scope="col"><div align="left" class="Estilo5">FECHA OPERACI&Oacute;N : </div></td>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <select name="select4">
                       <option>CALENDARIO</option>
                     </select>
                 </span></span></div></td>
                 <td width="51" scope="col"><span class="Estilo5">
                   <input name="radiobutton" type="radio" value="radiobutton">
      =</span></td>
                 <td width="46" scope="col"><span class="Estilo5">
                   <input name="radiobutton" type="radio" value="radiobutton">
&lt;=</span>
                     <div align="left"></div></td>
                 <td width="488" scope="col"><div align="left"><span class="Estilo5">
                     <input name="radiobutton" type="radio" value="radiobutton">
&gt;=</span></div></td>
                 <td width="41" scope="col"><div align="left"><span class="Estilo5"> </span></div></td>
                 <td width="32" scope="col">&nbsp;</td>
                 <td width="39" scope="col"><span class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><div align="center">AQUI VA UNA TABLA </div></td>
           </tr>
           <tr>
             <td><table width="487" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr align="center" valign="middle">
                 <td width="190">
                   <div align="center">
                     <input name="btgenera" type="button" id="btgenera" value="ACTUALIZAR" onClick="javascript:Llama_Rpt_Diario_Gen('Rpt_Diario_Gen.php');">
                 </div></td>
                 <td width="297">
                   <div align="center">
                     <input name="btcancelar" type="button" id="btcancelar" value="IMPRIMIR" onClick="javascript:Llama_Menu_Rpt('Menu.php');">
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
