<? include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){ $referencia_aju=""; $mcod_m="PAG019".$equipo;$codigo_mov=substr($mcod_m,0,49);}  else{$referencia_aju=$_GET["txtreferencia_aju"]; $codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Modificar Ajuste Ordenes de Pagos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
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
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtnro_orden.value==""){alert("Número de Orden no puede estar Vacia");return false;}
      else{f.txtnro_orden.value=f.txtnro_orden.value;}
    if(f.txttipo_causado.value==""){alert("Tipo de Causado no puede estar Vacio"); return false; }
      else{f.txttipo_causado.value=f.txttipo_causado.value.toUpperCase();}
    if(f.txtconcepto.value==""){alert("Concepto de la Orden no puede estar Vacia"); return false; }
      else{f.txtconcepto.value=f.txtconcepto.value.toUpperCase();}
    if(f.txtnro_orden.value.length==8){f.txtnro_orden.value=f.txtnro_orden.value.toUpperCase();f.txtnro_orden.value=f.txtnro_orden.value;}
      else{alert("Longitud de Número de Orden  Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;} else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_causado.value=="0000" || f.txttipo_causado.value=="A000" ) {alert("Tipo de Causado No Aceptado");return false; }
document.form1.submit;
return true;}
</script>
</head>
<?
$nombre_abrev_aju="";$tipo_ajuste=""; $nro_orden="";  $tipo_causado=""; $fecha=""; $concepto=""; $nombre_abrev_caus=""; $nombre_abrev_aju=""; $total_ajuste=0; $anulado="N"; $fecha_anu="";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sSQL="Select * from AJUSTE_ORD where Referencia_Aju_Ord='$referencia_aju'";  $res=pg_exec($conn,$sSQL); $filas=pg_numrows($res);
if($filas>0){ $registro=pg_fetch_array($res);
  $referencia_aju=$registro["referencia_aju_ord"];   $tipo_ajuste=$registro["tipo_aju_ord"];
  $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $total_ajuste=$registro["monto_aju_ord"];
  $fecha=$registro["fecha_aju_ord"];  $concepto=$registro["descripcion"];   $inf_usuario=$registro["inf_usuario"];  $fecha_anu=$registro["fecha_anulado_aju"];
  $nombre_abrev_caus=$registro["nombre_abrev_caus"]; $nombre_abrev_aju=$registro["nombre_abrev_ajuste"]; $anulado=$registro["anulado_aju"];
}
$total_ajuste=formato_monto($total_ajuste);
$clave=$tipo_ajuste.$referencia_aju.$tipo_causado.$nro_orden;
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}
$criterio=$sfecha.$referencia_aju.'J'.$tipo_ajuste;
if(substr($tipo_ajuste,0,1)=='A'){$criterio=$sfecha.'A'.substr($referencia_aju,1,7).'O'.$tipo_ajuste;}
?>
<body>
<table width="987" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR AJUSTE ORDEN DE PAGO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
 <tr> <table width="989" height="449" id="tablacuerpo">
 <tr>
     <td><table width="92" height="542" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablam">
        <td width="86">
      <td><table width="92" height="542" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_ajuste_orden.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_ajuste_orden.php">Atras</A></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
        </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:589px; z-index:1; top: 63px; left: 117px;">
        <form name="form1" method="post" action="Update_ajuste_orden.php" onSubmit="return revisar()">
        <table width="856" border="0" >
                        <td>&nbsp;</td>
                <tr>
                                    <td width="850" height="14"><table width="848">
                    <tr>
                      <td width="144"><span class="Estilo5">REFERENCIA AJUSTE : </span></td>
                      <td width="147"><span class="Estilo5">  <input name="txtreferencia_aju" type="text"  id="txtreferencia_aju" size="8" maxlength="8" value="<?echo $referencia_aju?>" readonly>  </td>
                      <td width="154"><span class="Estilo5">DOCUMENTO AJUSTE : </span></td>
                      <td width="38"><span class="Estilo5"> <input name="txttipo_ajuste" type="text" id="txttipo_ajuste" size="4" maxlength="4"  value="<?echo $tipo_ajuste?>" readonly > </span></td>
                      <td width="140"><span class="Estilo5">
                      <input name="txtnombre_abrev_ajuste" type="text" id="txtnombre_abrev_ajuste" size="5" maxlength="5" value="<?echo $nombre_abrev_aju?>" readonly></span></td>
                      <td width="54"><span class="Estilo5">FECHA :</span></td>
                      <td width="134"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10"  value="<?echo $fecha?>" readonly></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="861" >
                    <tr>
                      <td width="144"><span class="Estilo5">N&Uacute;MERO ORDEN : </span></td>
                      <td width="142"><span class="Estilo5"><input name="txtnro_orden" type="text" id="txtnro_orden" size="8" maxlength="8" value="<?echo $nro_orden?>" readonly>
                      </span></td>
                      <td width="153"><span class="Estilo5">DOCUMENTO CAUSADO :</span></td>
                      <td width="35"><span class="Estilo5">  <input name="txttipo_causado" type="text" id="txttipo_causado" size="4" maxlength="4" value="<?echo $tipo_causado?>" readonly>
                      </span></td>
                      <td width="77"><span class="Estilo5">  <input name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" size="5" maxlength="5" value="<?echo $nombre_abrev_caus?>" readonly>
                      </span></td>
                      <td width="61"><span class="Estilo5"></span></td>
                      <td width="213"><span class="Estilo5"></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="855">
                    <tr>
                      <td width="120" height="24"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                      <td width="709"><span class="Estilo5">
                        <textarea name="txtconcepto" cols="89"  onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="txtconcepto"><?echo $concepto?></textarea>
                      </span> </td>
                    </tr>
                  </table></td>
                </tr>
          </table>


         <div id="Layer3" style="position:absolute; width:868px; height:60px; z-index:2; left: 1px; top: 513px;">

        <table width="768">
          <tr>
            <td width="331"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100"><input name="txtp_ces" type="hidden" id="txtp_ces" value="N"></td>
            <td width="231"><input name="txtcaus_directo" type="hidden" id="txtcaus_directo" value="SI"></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table> </div>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>