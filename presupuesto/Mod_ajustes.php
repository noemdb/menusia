<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){ $referencia_ajuste=''; $tipo_ajuste=''; $referencia_comp=''; $tipo_compromiso=''; $referencia_caus=''; $tipo_pago=''; $tipo_causado='';}
 else { $referencia_ajuste=$_GET["txtreferencia_ajuste"];$tipo_ajuste=$_GET["txttipo_ajuste"];$tipo_pago=$_GET["txttipo_pago"];$referencia_pago=$_GET["txtreferencia_pago"];
$referencia_caus=$_GET["txtreferencia_caus"];$tipo_causado=$_GET["txttipo_causado"];$referencia_comp = $_GET["txtreferencia_comp"];$tipo_compromiso = $_GET["txttipo_compromiso"];
  $sql="Select * FROM AJUSTES where tipo_ajuste='$tipo_ajuste' and referencia_ajuste='$referencia_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";
 }  $genera_comprobante="NO";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Ajustes Presupuestario)</title>
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
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtreferencia_ajuste.value==""){alert("Referencia no puede estar Vacia");return false;}
     else{f.txtreferencia_ajuste.value=f.txtreferencia_ajuste.value;}
    if(f.txttipo_ajuste.value==""){alert("Tipo de ajuste no puede estar Vacio"); return false; }
      else{f.txttipo_ajuste.value=f.txttipo_ajuste.value.toUpperCase();}
    if(f.txtdescrip_aju.value==""){alert("Descripción del ajuste no puede estar Vacia"); return false; }
      else{f.txtdescrip_aju.value=f.txtdescrip_aju.value.toUpperCase();}
    if(f.txtreferencia_ajuste.value.length==8){f.txtreferencia_ajuste.value=f.txtreferencia_ajuste.value.toUpperCase();f.txtreferencia_ajuste.value=f.txtreferencia_ajuste.value;}
      else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;}
      else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_ajuste.value=="0000" || f.txttipo_ajuste.value=="A000" ) {alert("Tipo de ajuste No Aceptado");return false; }
document.form1.submit;
return true;}
</script>

</head>
<?
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$descripcion="";$fecha="";$nombre_abrev_caus="";$nombre_abrev_pago="";$nombre_abrev_comp="";$inf_usuario="";$modulo="";$nombre_abrev_ajuste="";$anulado="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){$registro=pg_fetch_array($res);
  $tipo_ajuste=$registro["tipo_ajuste"];  $referencia_ajuste=$registro["referencia_ajuste"];
  $tipo_pago=$registro["tipo_pago"];  $referencia_pago=$registro["referencia_pago"];
  $referencia_caus=$registro["referencia_caus"];  $tipo_causado=$registro["tipo_causado"];
  $referencia_comp=$registro["referencia_comp"];  $tipo_compromiso=$registro["tipo_compromiso"];
  $fecha=$registro["fecha_ajuste"];  $descripcion=$registro["descripcion"];  $inf_usuario=$registro["inf_usuario"];
  $nombre_abrev_ajuste=$registro["nombre_abrev_ajuste"];  $nombre_abrev_pago=$registro["nombre_abrev_pago"];
  $nombre_abrev_caus=$registro["nombre_abrev_caus"];  $nombre_abrev_comp=$registro["nombre_abrev_comp"];
  $modulo=$registro["modulo"];  $anulado=$registro["anulado"];
}if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$clave=$tipo_ajuste.$referencia_ajuste.$tipo_pago.$referencia_pago.$tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR AJUSTES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="358" border="0" id="tablacuerpo">
  <tr>
     <td><table width="92" height="342" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablamenu">
        <td width="86">
      <td><table width="92" height="342" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_ajustes.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_ajustes.php">Atras</A></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
        </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:295px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Update_ajustes.php" onSubmit="return revisar()">
      <table width="867" >
              <tr>
                <td>
                  <table width="846" align="center">
                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="166">
                            <p><span class="Estilo5">DOCUMENTO AJUSTE:</span></p></td>
                          <td width="54"><input name="txttipo_ajuste" type="text"  id="txttipo_ajuste" value="<?echo $tipo_ajuste?>" size="6" readonly></td>
                          <td width="85"><span class="Estilo5">
                            <input name="txtnombre_abrev_ajuste" type="text" id="txtnombre_abrev_ajuste" value="<?echo $nombre_abrev_ajuste?>" size="6" readonly>   </span></td>
                          <td width="92"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="89"><input name="txtreferencia_ajuste" type="text"  id="txtreferencia_ajuste" value="<?echo $referencia_ajuste?>" size="12" readonly></td> 
						  <td width="103">&nbsp;</td>
                          <td width="58"><span class="Estilo5">FECHA :</span> </td>
                          <td width="141"><span class="Estilo5">
                            <input name="txtfecha" type="text" id="txtfecha" value="<?echo $fecha?>" size="12" readonly> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="166">
                            <p><span class="Estilo5">DOCUMENTO PAGO:</span></p></td>
                          <td width="56"><input name="txttipo_pago" type="text"  id="txttipo_pago" value="<?echo $tipo_pago?>" size="6" readonly></td>
                          <td width="88"><span class="Estilo5"> <input name="txtnombre_abrev_pago" type="text" id="txtnombre_abrev_pago" value="<?echo $nombre_abrev_pago?>" size="6" readonly>                          </span></td>
                          <td width="90"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="159"><input name="txtreferencia_pago" type="text"  id="txtreferencia_pago" value="<?echo $referencia_pago?>" size="12" readonly></td>
                          <td width="67">&nbsp; </td>
                          <td width="99"><span class="Estilo5">                          </span></td>
                          <td width="67">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="167">
                            <p><span class="Estilo5">DOCUMENTO CAUSADO:</span></p></td>
                          <td width="55"><input name="txttipo_causado" type="text"  id="txttipo_causado" value="<?echo $tipo_causado?>" size="6" readonly></td>
                          <td width="86"><span class="Estilo5">
                            <input name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" value="<?ECHO $nombre_abrev_caus?>" size="6" readonly>
                          </span></td>
                          <td width="90"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="173"><input name="txtreferencia_caus" type="text"  id="txtreferencia_caus" value="<?echo $referencia_caus?>" size="12" readonly></td>
                          <td width="73">&nbsp;</td>
                          <td width="82"><span class="Estilo5">                          </span></td>
                          <td width="65">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="167">
                            <p><span class="Estilo5">DOCUMENTO COMPROMISO:</span></p></td>
                          <td width="55"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" value="<?echo $tipo_compromiso?>" size="6" readonly></td>
                          <td width="86"><span class="Estilo5">
                            <input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" value="<?ECHO $nombre_abrev_comp?>" size="6" readonly>
                          </span></td>
                          <td width="90"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="143"><input name="txtreferencia_comp" type="text"  id="txtreferencia_comp" value="<?echo $referencia_comp?>" size="12" readonly></td>
                          <td width="116">&nbsp;</td>
                          <td width="132"><span class="Estilo5"></span></td>
                        </tr>
					</table></td>
                    </tr>	
                    <tr>
                      <td><table width="827" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtdescrip_aju" cols="85" onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="txtdescrip_aju"><?echo $descripcion?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>  <td >&nbsp;</td>  </tr>
                  </table>  </td>
              </tr>
          </table>
        
        <table width="870" border="0">
          <tr>
            <td width="864" height="5">&nbsp;</td>
         </tr>
        </table>
        <table width="768">
          <tr>
            <td width="100"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100"><input name="txtcodigo_comp" type="hidden" id="txtcodigo_comp"></td>
            <td width="100"><input name="txtdescripcion" type="hidden" id="txtdescripcion"></td>
            <td width="290"><input name="txtfunc_inv" type="hidden" id="txtfunc_inv"></td>
            <td width="100"><input name="txtced_rif" type="hidden" id="txtced_rif"></td>
            <td width="100"><input name="txtnombre" type="hidden" id="txtnombre" ></td>
            <td width="331"><input name="txtrefiereA" type="hidden" id="txtrefiereA" value="PAGO"></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>