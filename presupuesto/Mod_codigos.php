<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} else{$Nom_Emp=busca_conf();}
if (!$_GET){  $cod_presup=''; $cod_fuente='00'; $p_letra='';  $sql="SELECT * FROM codigos ORDER BY cod_presup,cod_fuente";}else {$codigo=$_GET["Gcodigo"]; $cod_fuente=substr($codigo,0,2);$cod_presup=substr($codigo,2,32);
$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$titulo=$registro["campo525"];}else{$titulo=""; $formato_presup="XX-XX-XX-XXX-XX-XX-XX";$formato_cat="XX-XX-XX";}$len_cat=strlen($formato_cat);  $len_formato=strlen($formato_presup);
$codigo=$cod_fuente.$cod_presup;  $sql="Select * from codigos where cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";} $len_cod=strlen($cod_presup);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (C&oacute;digos/Asignaci&oacute;n)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="Javascript" src="../class/sia.js" type="text/javascript"></script>
<script language="Javascript" type="text/Javascript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
function validarcod(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\-]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function LlamarURL(url){  document.location = url; }
function CargarUrl(mcodigo) {var murl;   murl="Act_codigos.php?Gcodigo="+mcodigo;  document.location = murl;}
function revisar(){var f=document.form1;  var Valido;
    if(f.txtcod_presup.value==""){alert("Condigo Presupuestario no puede estar Vacio");  f.txtcod_presup.focus(); return false;}
    if(f.txtcod_fuente.value==""){alert("Fuente de Financiamiento no puede estar Vacio"); f.txtcod_fuente.focus(); return false;}
    if(f.txtdenominacion.value==""){alert("Denominacionn del Condigo Presupuestario no puede estar Vacia"); f.txtdenominacion.focus(); return false; }else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtAplicacion.value==""){alert("Condigo de Aplicacionn no puede estar Vacio"); f.txtAplicacion.focus(); return false;}
    if(f.txtAplicacion.value.length==1){f.txtAplicacion.value=f.txtAplicacion.value.toUpperCase();}else{alert("Longitud Condigo de Aplicacionn Invalida");return false;}
    if(f.txtasignado.value==""){alert("Asignacionn Inicial no puede estar Vacio"); f.txtasignado.focus(); return false;}
    if(MontoValido(f.txtasignado.value)) {Valido=true;}else{alert("Asignacionn Inicial debe tener valores numericos."); f.txtasignado.focus(); return false;}
document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 

</script>
</head>
<?
$denominacion="";$des_fuente="";$cod_contable="";$nombre_cuenta="";$status_dist="";$func_inv="";$aplicacion="";$distribucion="ANUAL";$asignado=0;$disponible=0;$diferido=0;$disp_diferida=0;$montod=0; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];  $denominacion=$registro["denominacion"];
  $cod_contable=$registro["cod_contable"];  $func_inv=$registro["func_inv"];  $aplicacion=$registro["aplicacion"];  $status_dist=$registro["status_dist"];
  $asignado=$registro["asignado"];  $disponible=formato_monto($registro["disponible"]);  $diferido=$registro["diferido"]; $disp_diferida=formato_monto($registro["disp_diferida"]);  $des_fuente=$registro["des_fuente_financ"];  $nombre_cuenta=$registro["nombre_cuenta"];
}
$asignado=formato_monto($asignado);
if($status_dist=='1'){$distribucion="ANUAL";}
if($status_dist=='2'){$distribucion="MENSUAL";}
if($status_dist=='3'){$distribucion="TRIMESTRAL";}
if($status_dist=='4'){$distribucion="TRIMESTRAL (%)";}
?>
<script language="JavaScript" type="text/JavaScript">
function asig_tgasto(mvalor){var f=document.form1;
    if(mvalor=="C"){f.txtTipo_Gasto.options[0].selected = true;}
    if(mvalor=="I"){f.txtTipo_Gasto.options[1].selected = true;}
}
</script>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR C&Oacute;DIGOS/ASIGNACI&Oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="367" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="360" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:CargarUrl('<? echo $codigo; ?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:CargarUrl('<? echo $codigo; ?>')">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:360px; z-index:1; top: 62px; left: 113px;">
            <form name="form1" method="post" action="Update_codigos.php" onSubmit="return revisar()">
        <table width="861" border="0" align="center">
            <tr>
              <td>&nbsp;</td>
            </tr>
			<tr>
              <td><table width="840" border="0">
                <tr>
                  <td width="175"><span class="Estilo5">&nbsp;</span></td>
                  <td width="227"><span class="Estilo10"> <? echo $titulo; ?>    </span></td>
                  <td width="109">&nbsp;</td>
                  <td width="33"></td>
                  <td width="288"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="840" border="0">
                <tr>
                  <td width="175"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                  <td width="227"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" size="34" maxlength="34"  value="<?echo $cod_presup?>" readonly>  </span></td>
                  <td width="109">&nbsp;</td>
                  <td width="33"></td>
                  <td width="288"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="843" border="0">
                <tr>
                  <td width="176"><span class="Estilo5">FUENTE DE FINANCIAMIENTO :</span></td>
                  <td width="31"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2"  value="<?echo $cod_fuente?>" readonly>  </span></td>
                  <td width="622"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" size="75" value="<?echo $des_fuente?>" readonly>  </span></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="849" border="0">
                <tr>
                  <td width="108"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                  <td width="731"><textarea name="txtdenominacion" cols="84" class="Estilo10" id="txtdenominacion" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)"><?echo $denominacion?></textarea></td>
                </tr>
              </table>   </td>
            </tr>
            <tr>
              <td ><table width="849" border="0">
                <tr>
                  <td width="182"><span class="Estilo5">CODIGO CONTABLE GASTO:</span></td>
                  <td width="152"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" size="25" maxlength="30" value="<?echo $cod_contable?>" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)">   </span></td>
                  <td width="37"><input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onclick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td>
                  <td width="460"><span class="Estilo5"><input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" size="65" maxlength="250" value="<?echo $nombre_cuenta?>" readonly onkeypress="return stabular(event,this)">   </span></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td ><table width="848" border="0">
                <tr>
                  <td width="112"><span class="Estilo5">TIPO DE GASTO :</span> </td>
                  <td width="176"><span class="Estilo5"><select name="txtTipo_Gasto" size="1" id="select" onFocus="encender(this)" onBlur="apagar(this)">
                      <option selected>CORRIENTE</option> <option>INVERSION</option> </select></span></td>
				  <script language="JavaScript" type="text/JavaScript"> asig_tgasto('<?echo $func_inv;?>');</script> 
                  <td width="90" class="Estilo5"><span class="Estilo5">APLICACI&Oacute;N :</span> </td>
                  <td width="103" class="Estilo5"><input class="Estilo10" name="txtAplicacion" type="text" id="txtAplicacion" title="Registre el Tipo de AplicaciOn" size="4" maxlength="1" value="<?echo $aplicacion?>" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)"></td>
                  <td width="93" class="Estilo5">ASIGNACI&Oacute;N :</td>
                  <td width="248" class="Estilo5">
                   <? IF(($SIA_Definicion=="N")and($len_cod==$len_formato)){?>
                       <input class="Estilo10" name="txtasignado" type="text" id="txtasignado" size="30" maxlength="30" style="text-align:right" title="Registre el Monto de Asignacion" value="<?echo $asignado?>" onFocus="encender_monto(this)" onBlur="apagar(this)" onKeypress="return validarNum(event,this)"> 
                    <?} else { ?>
                       <input class="Estilo10" name="txtasignado" type="text" id="txtasignado" size="30" maxlength="30" style="text-align:right" readonly value="<?echo $asignado?>">
                     <?}?>
                   </td>
                </tr>
              </table>
               </td>
            </tr>
            <tr><td >&nbsp;</td></tr>
        </table>
        <p>&nbsp;</p>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
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
<? pg_close();?>