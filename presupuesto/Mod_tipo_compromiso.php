<?php include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$tipo_comp='';} else {$tipo_comp = $_GET["Gtipo_comp"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Modificar Tipos de Compromiso)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language=JavaScript src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
    if(f.txttipo_comp.value==""){alert("C�digo de Documento Compromiso no puede estar Vacio");return false;}
        if(f.txttipo_comp.value.charAt(0)=='A'){alert("Documento de Compromiso no valido");return false;}
    if(f.txtdes_tipo_comp.value==""){alert("denominaci�n del Tipo Compromiso no puede estar Vacia");return false; }
       else{f.txtdes_tipo_comp.value=f.txtdes_tipo_comp.value.toUpperCase();}
    if(f.txttipo_comp.value.length==6){f.txttipo_comp.value=f.txttipo_comp.value.toUpperCase();}
       else{alert("Longitud C�digo Tipo de Compromiso Invalida");return false;}
document.form1.submit;
return true;}
</script>
</style>
</head>
<?php 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="Select * from pre016 where tipo_comp='$tipo_comp'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $des_tipo_comp=$registro["des_tipo_comp"]; $cod_contable=$registro["cod_contable"]; 
  $cod_part_iva=$registro["cod_part_iva"];  $func_inv=$registro["func_inv_tpcomp"];  $c_imp_unico=$registro["c_imp_unico"];}
 else{ $des_tipo_comp=""; $cod_part_iva=""; $cod_contable=""; $c_imp_unico=""; }
?>
<script language="JavaScript" type="text/JavaScript">
function asig_tgasto(mvalor){var f=document.form1;
    if(mvalor=="C"){f.txtTipo_Gasto.options[0].selected = true;}  else{f.txtTipo_Gasto.options[1].selected = true;}
}
function asig_iunico(mvalor){var f=document.form1;
    if(mvalor=="S"){f.txtc_imp_unico.options[0].selected = true;}  else{f.txtc_imp_unico.options[1].selected = true;}
}
</script>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">TIPOS DE COMPROMISOS (Modificar)</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_tipo_compromiso.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_tipo_compromiso.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:355px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Update_tipo_compromiso.php" onSubmit="return revisar()">
        <table width="864" height="140">
          <tr>
            <td><table width="819" align="center">
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="800">
                  <tr>
                    <td width="197"><span class="Estilo5">C&Oacute;DIGO TIPO DE COMPROMISO :</span></td>
                    <td width="591"><span class="Estilo5"><input name="txttipo_comp" type="text" id="txttipo_comp" readonly  value="<?php echo $tipo_comp?>" size="12" maxlength="6">
                    </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="800">
                  <tr>
                    <td width="226"><span class="Estilo5">DENOMINACI&Oacute;N TIPO  COMPROMISO :</span></td>
                    <td width="562"><span class="Estilo5"><input name="txtdes_tipo_comp" type="text" id="txtdes_tipo_comp" title="Registre el c&oacute;digo del Tipo de compromiso" onFocus="encender(this); " onBlur="apagar(this);" onChange="chequea_tipo(this.form);" value="<?php echo $des_tipo_comp?>" size="80" maxlength="100">
                    </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="800">
                  <tr>
                    <td width="160"><span class="Estilo5">C&Oacute;DIGO PARTIDA IVA:</span></td>
                    <td width="280"><span class="Estilo5"><input name="txtcod_part_iva" type="text" id="txttipo_comp3" title="Registre el c&oacute;digo del Tipo de compromiso" onFocus="encender(this); " onBlur="apagar(this);" onChange="chequea_tipo(this.form);" value="<?php echo $cod_part_iva?>" size="30" maxlength="24"></span></td>
					<td width="150"><span class="Estilo5">C&Oacute;DIGO CONTABLES :</span></td>
					<td width="160"><span class="Estilo5"><input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" size="25" maxlength="30" value="<?php echo $cod_contable?>" onFocus="encender(this); " onBlur="apagar(this);">   </span></td>
                    <td width="40"><input name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onclick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                     <td width="5"><input name="txtNombre_Cuenta" type="hidden" id="txtNombre_Cuenta"  ></td>
				  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="816" border="0">
                  <tr>
                    <td width="141"><span class="Estilo5">TIPO DE GASTO :</span> </td>
                    <td width="276"><span class="Estilo5"><select name="txtTipo_Gasto" size="1" id="txtTipo_Gasto" onFocus="encender(this)" onBlur="apagar(this)">
                        <option selected>CORRIENTE</option> <option>INVERSION</option>  </select> </span></td>
                        <script language="JavaScript" type="text/JavaScript"> asig_tgasto('<?php echo $func_inv;?>');</script>                    
                    <td width="147" class="Estilo5">PARTIDA DE IVA FIJA : </td>
                    <td width="266" class="Estilo5">
                      <select name="txtc_imp_unico" size="1" id="txtc_imp_unico" onFocus="encender(this)" onBlur="apagar(this)">
                        <option>SI</option> <option>NO</option> </select> </span></td>
                    <script language="JavaScript" type="text/JavaScript"> asig_iunico('<?php echo $c_imp_unico;?>');</script>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88">&nbsp;</td>
          </tr>
        </table>
        <div align="right"></div>
        <div align="right"></div>
        <p>&nbsp;</p>
        </form>
    </div>

  </tr>
</table>
</body>
</html>