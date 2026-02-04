<?php include ("../class/conect.php"); include ("../class/funciones.php"); error_reporting(E_ALL ^ E_NOTICE);
if (!$_GET){$cod_presup=''; $cod_fuente='00'; }else {$cod_presup=$_GET["cod_presup"]; $cod_fuente=$_GET["cod_fuente"]; } $codigo=$cod_fuente.$cod_presup;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$formato_par=$registro["campo527"];}else{$formato_presup="XX-XX-XX-XXX-XX-XX-XX";$formato_cat="XX-XX-XX";$formato_par="XXX-XX-XX-XX";}
$mpatron="Array(1,1,3,2,2,4,0,0,0,0)";  $mpatron=arma_patron($formato_presup);$mpatronp="Array(1,1,3,2,2,4,0,0,0,0)";  $mpatronp=arma_patron($formato_par);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (C&oacute;ndigos/Asignaci&oacute;nn)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
var patroncodigo = new <?php echo $mpatron ?>;
function CargarUrl(mcodigo) {var murl;   murl="Act_codigos.php?Gcodigo="+mcodigo;  document.location = murl;}
function revisar(){var f=document.form1;var Valido=true;
    if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio"); f.txtcod_presup.focus(); return false;}
    if(f.txtcod_fuente.value==""){alert("Fuente de Financiamiento no puede estar Vacio"); f.txtcod_fuente.focus(); return false;}
    document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONSULTAR C&Oacute;DIGOS/ASIGNACI&Oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="307" border="0" id="tablacuerpo">
  <tr>
    <td><table width="92" height="305" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablamenu">
        <td width="86">
      <td>
      <table width="92" height="305" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:CargarUrl('<?php  echo $codigo; ?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:CargarUrl('<?php  echo $codigo; ?>')">Atras</A></td>
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
      <div id="Layer1" style="position:absolute; width:874px; height:300px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="consult_codigos.php" onSubmit="return revisar()">
      <table width="869" >
	          <tr> <td>&nbsp;</td>  </tr>
              <tr>
              <td><table width="840" border="0">
                <tr>
                  <td width="175"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                  <td width="227"><span class="Estilo5"> <input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" size="40" maxlength="40" onFocus="encender(this);" onBlur="apagar(this);"  value="<?php echo $cod_presup?>" onKeypress="return stabular(event,this)" onkeyup="mascara(this,'-',patroncodigo,true)" >    </span></td>
                  <td width="109">&nbsp;</td>
                  <td width="33"></td>
                  <td width="288"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="843" border="0">
                <tr>
                  <td width="198"><span class="Estilo5">FUENTE DE FINANCIAMIENTO :</span></td>
                  <td width="21"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2" onFocus="encender(this); " onBlur="apagar(this);"  value="<?php echo $cod_fuente?>" onkeypress="return stabular(event,this)">  </span></td>
                  <td width="45"><input class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onclick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td>
                  <td width="569"><span class="Estilo5"> <input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" size="75" readonly onkeypress="return stabular(event,this)"> </span></td>
                </tr>
              </table></td>
            </tr>
			  <tr> <td>&nbsp;</td>  </tr>
			  <tr> <td>&nbsp;</td>  </tr>
          </table>
        <table width="768">
          <tr>
            <td width="568"></td>
            <td width="100" valign="middle"><input name="button" type="submit" id="button"  value="Buscar"></td>
            <td width="100"><input name="Submit" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>

</table>
</body>
</html>