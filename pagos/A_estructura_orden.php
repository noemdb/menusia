<?include ("../class/seguridad.inc");?>
<? include ("../class/funciones.php");
if (!$_GET){
  $cod_estructura='';
  $p_letra='';
  $sql="SELECT * FROM ESTRUCTURA_ORD ORDER BY cod_estructura";
} else {
  $cod_estructura = $_GET["Gcod_estructura"];
  $p_letra=substr($cod_estructura, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$cod_estructura=substr($cod_estructura,1,8);}
  $sql="Select * from ESTRUCTURA_ORD where cod_estructura='$cod_estructura'";
  if ($p_letra=="P"){$sql="SELECT * FROM ESTRUCTURA_ORD ORDER BY cod_estructura";}
  if ($p_letra=="U"){$sql="SELECT * From ESTRUCTURA_ORD Order by cod_estructura Desc";}
  if ($p_letra=="S"){$sql="SELECT * From ESTRUCTURA_ORD Where (cod_estructura>'$cod_estructura') Order by cod_estructura";}
  if ($p_letra=="A"){$sql="SELECT * From ESTRUCTURA_ORD Where (cod_estructura<'$cod_estructura') Order by cod_estructura Desc";}
}
$equipo = getenv("COMPUTERNAME");
$mcod_m = "PAG006".$equipo;
$codigo_mov=substr($mcod_m,0,49);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<LINK REL="SHORTCUT ICON" HREF="../class/imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Definci&oacute;n Estructura de Ordenes)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<link rel="stylesheet" type="text/css" href="../class/ajaxtabs.css" />
<script type="text/javascript" src="../class/ajaxtabs.js"> </script>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url)
{
var murl;
var Gcod_estructura=document.form1.txtcod_estructura.value;
    murl=url+Gcod_estructura;
    if (Gcod_estructura=="")
        {alert("Código de Estructura debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos)
{
var murl;
   murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_estructura_orden.php?Gcod_estructura=P"}
   if(MPos=="U"){murl="Act_estructura_orden.php?Gcod_estructura=U"}
   if(MPos=="S"){murl="Act_estructura_orden.php?Gcod_estructura=S"+document.form1.txtcod_estructura.value;}
   if(MPos=="A"){murl="Act_estructura_orden.php?Gcod_estructura=A"+document.form1.txtcod_estructura.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url;
var r;
  r=confirm("Esta seguro en Eliminar la Estructura ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar la Estructura ?");
    if (r==true) {
       url="Delete_estructura.php?txtcod_estructura="+document.form1.txtcod_estructura.value;
       VentanaCentrada(url,'Eliminar Estructuras','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js"  type=text/javascript></SCRIPT>
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
.Estilo10 {
        font-size: 12px;
        font-weight: bold;
        color: #0000FF;
}
.Estilo11 {font-size: 12px}
-->
</style>
</head>
<?
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");
$error=pg_errormessage($conn); $error=substr($error, 0, 61);
if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
$resultado=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");
$error=pg_errormessage($conn); $error=substr($error, 0, 61);
if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
$descripcion_est="";$ced_rif_est="";$fecha_desde_est="";$fecha_hasta_est="";
$bloqueada="";$modulo="";$tipo_documento="";$nro_documento="";$inf_usuario="";
$cod_tipo_ord="";$concepto_est=""; $nombre="";  $des_tipo_orden="";
$res=pg_query($sql);
$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * From ESTRUCTURA_ORD ORDER BY cod_estructura";}
  if ($p_letra=="A"){$sql="SELECT * From ESTRUCTURA_ORD ORDER BY cod_estructura desc";}
  $res=pg_query($sql);
  $filas=pg_num_rows($res);
}
if($filas>=1){
  $registro=pg_fetch_array($res,0);
  $cod_estructura=$registro["cod_estructura"];
  $descripcion_est=$registro["descripcion_est"];
  $ced_rif_est=$registro["ced_rif_est"];
  $fecha_desde_est=$registro["fecha_desde_est"];
  $fecha_hasta_est=$registro["fecha_hasta_est"];
  $tipo_documento=$registro["tipo_documento"];
  $nro_documento=$registro["nro_documento"];
  $cod_tipo_ord=$registro["cod_tipo_ord"];
  $concepto_est=$registro["concepto_est"];
  $nombre=$registro["nombre"];
  $des_tipo_orden=$registro["des_tipo_orden"];
  $inf_usuario=$registro["inf_usuario"];
}
if($fecha_desde_est==""){$fecha_desde_est="";}else{$fecha_desde_est=formato_ddmmaaaa($fecha_desde_est);}
if($fecha_hasta_est==""){$fecha_hasta_est="";}else{$fecha_hasta_est=formato_ddmmaaaa($fecha_hasta_est);}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEFINICI&Oacute;N ESTRUCTURA DE ORDEN</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="617" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="607" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_estructura.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_estructura.php">Incluir</A></td>
        </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Modifica_est.php?Gcod_estructura=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="javascript:Llamar_Ventana('Modifica_est.php?Gcod_estructura=');">Modificar</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_estructura.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_estructura.php" class="menu">Catalogo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu Principal </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:870px; height:596px; z-index:1; top: 68px; left: 119px;">
        <form name="form1" method="post">
          <table width="865" border="0" >
                <tr>
                  <td width="850" height="32"><table width="855" >
                      <tr>
                        <td width="69" height="24"><span class="Estilo5">C&Oacute;DIGO : </span></td>
                        <td width="94"><span class="Estilo5">
                        <span class="Estilo5">
                        <input name="txtcod_estructura" type="text" id="txtcod_estructura"  readonly value="<?echo $cod_estructura?>" size="10" maxlength="8">
                        </span> </span></td>
                        <td width="93"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                        <td width="542"><span class="Estilo5">
                          <input name="txtdescripcion_est" type="text" id="txtdescripcion_est"  readonly value="<?echo $descripcion_est?>" size="85">
                        </span></td>
                        <td width="24"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="851" >
                    <tr>
                      <td width="170" height="24"><span class="Estilo5">C&Eacute;DULA/RIF BENEFICIARIO : </span></td>
                      <td width="133"><span class="Estilo5">
                        <input name="txtced_rif_est" type="text" id="txtced_rif_est"  readonly value="<?echo $ced_rif_est?>" size="15" maxlength="15">
                      </span></td>
                      <td width="532"><span class="Estilo5">
                        <input name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="81" readonly>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="841">
                      <tr>
                        <td width="91" height="24"><span class="Estilo5">CONCEPTO :</span></td>
                        <td width="738"><span class="Estilo5">
                          <textarea name="txtconcepto_est" cols="88" readonly="readonly" class="headers" id="txtconcepto_est"><?echo $concepto_est?></textarea>
                        </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="852" >
                    <tr>
                      <td width="123" height="24"><span class="Estilo5">TIPO DOCUMENTO  : </span></td>
                      <td width="154"><span class="Estilo5">
                        <input name="txttipo_documento" type="text" id="txttipo_documento"  readonly value="<?echo $tipo_documento?>" size="20">
                      </span> </td>
                      <td width="145"><span class="Estilo5">NUMERO DOCUMENTO :</span></td>
                      <td width="410"><span class="Estilo5">
                        <input name="txtnro_documento" type="text" id="txtnro_documento"  readonly value="<?echo $nro_documento?>" size="60">
                      </span> </td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="850">
                    <tr>
                      <td width="124"><span class="Estilo5">TIPO DE ORDEN :</span></td>
                      <td width="92"><span class="Estilo5">
                        <input name="txtcod_tipo_ord" type="text" id="txtcod_tipo_ord" size="8" maxlength="15"  readonly  value="<?echo $cod_tipo_ord?>">
                      </span> </td>
                      <td width="618"><span class="Estilo5">
                        <input name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" size="96" readonly  value="<?echo $des_tipo_orden?>">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="846">
                    <tr>
                      <td width="123"><span class="Estilo5">FECHA DESDE :</span></td>
                      <td width="370"><span class="Estilo5">
                        <input name="txtfecha_desde_est" type="text" id="txtfecha_desde_est" size="15" value="<?echo $fecha_desde_est?>" readonly>
                      </span></td>
                      <td width="107"><span class="Estilo5">FECHA HASTA :</span></td>
                      <td width="226"><span class="Estilo5">
                        <input name="txtfecha_hasta_est" type="text" id="txtfecha_hasta_est" value="<?echo $fecha_hasta_est?>" size="15" readonly>
                       </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
 </form> </div>
<div id="divtab" style="position:absolute; width:846px; height:280px; z-index:2; left: 117px; top: 332px;">
<ul id="maintab" class="shadetabs">
<li class="selected"><a href="#default" rel="ajaxcontentarea">Cód. Presupuestario</a></li>
<li><a href="Det_ret_estruct.php?criterio=<?echo $cod_estructura?>" rel="ajaxcontentarea">Retenciones</a></li>
</ul>
<div id="ajaxcontentarea" class="contentstyle">
  <iframe src="Det_cons_estructura.php?criterio=<?echo $cod_estructura?>"  width="845" height="290" scrolling="auto" frameborder="1"> </iframe>
</div>

<script type="text/javascript"> startajaxtabs("maintab")</script>
</div>

    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>