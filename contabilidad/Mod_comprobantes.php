<?include ("../class/conect.php");  include ("../class/funciones.php");
 if (!$_GET){$fecha="";     $referencia="";    $tipo_comp="";}
 else{ $fecha=$_GET["txtFecha"];    $referencia=$_GET["txtReferencia"];   $tipo_comp=$_GET["txttipo_Comp"];  }
 $equipo = getenv("COMPUTERNAME");  $mcod_m = "CON02".$equipo;  $codigo_mov=substr($mcod_m,0,49);
 if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD FISCAL (Modifica Coprobantes Contables)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
function LlamarURL(url){  document.location = url; }
function Llamar_Ventana(url){
var murl;
var mclave=document.form1.txtFecha.value+document.form1.txtReferencia.value+document.form1.txttipo_comp.value;
    murl=url+mclave;     document.location = murl;
}
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
var Valido=true;
    if(f.txtFecha.value==""){alert("Fecha no puede estar Vacia");return false;}
        if(f.txtReferencia.value==""){alert("Referencia no puede estar Vacio");return false;}
    if(f.txtDescripcion.value==""){alert("Descripci&oacute;n del Comprobante no puede estar Vacia"); return false; }
      else{f.txtDescripcion.value=f.txtDescripcion.value.toUpperCase();}
    if(f.txttipo_asiento.value==""){alert("Tipo de Asiento no puede estar Vacio"); return false; }
      else{f.txttipo_asiento.value=f.txttipo_asiento.value.toUpperCase();}
        if(f.txtReferencia.value.length==8){f.txtReferencia.value=f.txtReferencia.value.toUpperCase();}
      else{alert("Longitud de Referencia Invalida");return false;}
        if(f.txtFecha.value.length==10){Valido=true;}
      else{alert("Longitud de Fecha Invalida");return false;}
        if(f.txttipo_asiento.value=="ANU" || f.txttipo_asiento.value=="ANC" || f.txttipo_asiento.value=="AND" || f.txttipo_asiento.value=="CHQ") {alert("Tipo de Asiento No Aceptado");return false; }
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$res=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$descripcion="";$tipo_asiento=""; $ced_rif="";  $nombre="";
$sql="Select * from COMPROBANTES where text(fecha)='$sfecha' and referencia='$referencia' and tipo_comp='$tipo_comp'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $referencia=$registro["referencia"];  $fecha=$registro["fecha"];
  $tipo_comp=$registro["tipo_comp"];  $descripcion=$registro["descripcion"];  $tipo_asiento=$registro["tipo_asiento"];
  $status=$registro["status"];  $modulo=$registro["modulo"];  $aoperacion=$registro["aoperacion"];
  $doperacion=$registro["doperacion"];  $ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];  $nro_comprobante=$registro["nro_comprobante"];
}
if($fecha==""){$sfecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
$clave=$sfecha.$referencia.$tipo_comp;
$sql="insert into con008 select '$codigo_mov',referencia,debito_credito,cod_cuenta,tipo_comp,'$tipo_asiento',monto_asiento,'$status','$modulo',modificable,'$aoperacion','$doperacion',descripcion_a FROM con003 where text(fecha)='$sfecha' and referencia='$referencia' and tipo_comp='$tipo_comp'";
$res=pg_exec($conn,$sql);$error=pg_errormessage($conn); $error=substr($error, 0, 61);
if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR COMPROBANTES CONTABLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="535" border="1">
  <tr>
    <td width="92"><table width="92" height="525" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Act_comprobantes.php?Gcriterio=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Act_comprobantes.php?Gcriterio=')">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:355px; z-index:1; top: 70px; left: 116px;">
      <form name="form1" method="post" action="Update_comprobantes.php" onSubmit="return revisar()">
        <table width="858" border="0">
          <tr>
            <td width="157">
              <p><span class="Estilo5">FECHA :
                    <input name="txtFecha" type="text" id="txtFecha"  value="<?echo $fecha?>" size="12" maxlength="10" readonly>
                    </span></p>

                        </td>
                        <td width="125">&nbsp;</td>
            <td width="274"><span class="Estilo5">REFERENCIA :</span>
              <input name="txtReferencia" type="text"  id="txtReferencia"  value="<?echo $referencia?>" size="12" maxlength="8" readonly></td>
            <td width="170"><span class="Estilo5">TIPO ASIENTO:</span>
              <input name="txttipo_asiento" id="txttipo_asiento" value="<?echo $tipo_asiento?>" size="5" maxlength="3" readonly></td>
          </tr>
        </table>
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="861" border="0">
          <tr>
            <td width="141"><span class="Estilo5">DESCRIPCION :</span></td>
            <td width="710"><textarea name="txtDescripcion" cols="80"  maxlength="500" onFocus="encender(this)" onBlur="apagar(this)" id="txtDescripcion"><?echo $descripcion?></textarea></td>
          </tr>
        </table>
        <table width="863" border="0">
          <tr>
            <td height="10">&nbsp;</td>
            </tr>
        </table>
        <iframe src="Det_inc_comprobantes.php?codigo_mov=<?echo $codigo_mov?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        <table width="863" border="0">
          <tr>
            <td height="10">&nbsp;</td>
            </tr>
        </table>
        <table width="785">
          <tr>
            <td width="103"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="103"><input name="txtstatus" type="hidden" id="txtstatus" value="<?echo $status?>"></td>
            <td width="70"><input name="txtnro_comprobante" type="hidden" id="txtnro_comprobante" value="<?echo $nro_comprobante?>"></td>
            <td width="159"><input name="txtced_rif" type="hidden" id="txtced_rif" value="<?echo $ced_rif?>"></td>
            <td width="159"><input name="txttipo_comp" type="hidden" id="txttipo_comp" value="<?echo $tipo_comp?>"></td>
            <td width="64" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="80">&nbsp;</td>
          </tr>
        </table>
        </form>
    </div>
  </tr>
</table>
</body>
</html>