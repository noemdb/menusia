<?include ("../class/conect.php");  include ("../class/funciones.php"); 
 $cod_estructura=$_GET["Gcod_estructura"]; $bloqueada="N"; $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Estructura de Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="ajax_comp.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->

function revisar(){
var f=document.form1;
var Valido=true;
    if(f.txtcod_estructura.value==""){alert("Código de Estructura no puede estar Vacia");return false;}
      else{f.txtcod_estructura.value=f.txtcod_estructura.value;}
    if(f.txtdescripcion_est.value==""){alert("Descripción de Estructura no puede estar Vacia"); return false; }
      else{f.txtdescripcion_est.value=f.txtdescripcion_est.value.toUpperCase();}
    if(f.txtcod_estructura.value.length==8){f.txtcod_estructura.value=f.txtcod_estructura.value.toUpperCase();}
      else{alert("Longitud Código de Estructura Invalida");return false;}
    document.form1.submit;
return true;}
</script>
</head>
<?
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from ESTRUCTURA_ORD where cod_estructura='$cod_estructura'";
$descripcion_est="";$ced_rif_est="";$fecha_desde_est="";$fecha_hasta_est="";$modulo="";$tipo_documento="";$nro_documento="";$inf_usuario="";
$cod_tipo_ord="";$concepto_est=""; $nombre="";  $des_tipo_orden="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $cod_estructura=$registro["cod_estructura"];  $descripcion_est=$registro["descripcion_est"];
  $ced_rif_est=$registro["ced_rif_est"];  $fecha_desde_est=$registro["fecha_desde_est"];  $fecha_hasta_est=$registro["fecha_hasta_est"];  $tipo_documento=$registro["tipo_documento"];
  $nro_documento=$registro["nro_documento"];  $cod_tipo_ord=$registro["cod_tipo_ord"];  $concepto_est=$registro["concepto_est"];  $nombre=$registro["nombre"];
  $des_tipo_orden=$registro["des_tipo_orden"];  $inf_usuario=$registro["inf_usuario"];  $bloqueada=$registro["bloqueada"];
}
if($fecha_desde_est==""){$fecha_desde_est="";}else{$fecha_desde_est=formato_ddmmaaaa($fecha_desde_est);}
if($fecha_hasta_est==""){$fecha_hasta_est="";}else{$fecha_hasta_est=formato_ddmmaaaa($fecha_hasta_est);}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ASIGNA COMPROMISOS ESTRUCTURA DE ORDEN </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="618" border="0" id="tablacuerpo">
  <tr>
     <td><table width="92" height="502" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablamenu">
        <td width="86">
      <td><table width="92" height="602" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_estructura_orden.php?Gcod_estructura=<?echo $cod_estructura?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_estructura_orden.php?Gcod_estructura=<?echo $cod_estructura?>">Atras</A></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu Archivos</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
        </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:495px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Update_estructura.php" onSubmit="return revisar()">
      <table width="867" >
              <tr>
                <td>
                  <table width="846" align="center">
                    <tr>
                      <td><table width="855" >
                        <tr>
                          <td width="69" height="24"><span class="Estilo5">C&Oacute;DIGO : </span></td>
                          <td width="94"><span class="Estilo5"><input name="txtcod_estructura" type="text" id="txtcod_estructura"  value="<?echo $cod_estructura?>" size="10" maxlength="8" readonly>
                          </span></td>
                          <td width="93"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                          <td width="542"><span class="Estilo5"><input name="txtdescripcion_est" type="text" id="txtdescripcion_est"  readonly value="<?echo $descripcion_est?>"  size="85">
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
        </table>
        <div id="T11" class="tab-body">
              <iframe src="Det_asig_comp_est.php?cod_estructura=<?echo $cod_estructura?>" width="870" height="460" scrolling="auto" frameborder="1"></iframe>
        </div>
    
  <p>&nbsp;</p>
  
</div>
 </form>
  </div></tr>
</table>
</body>
</html>