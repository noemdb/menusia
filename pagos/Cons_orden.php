<?include ("../class/ventana.php"); include ("../class/fun_fechas.php");
  $equipo = getenv("COMPUTERNAME");  $mcod_m = "PRE006".$equipo; $cod_tipo_comp="000000"; $des_tipo_comp="COMPROMISOS";
  $codigo_mov=substr($mcod_m,0,49);  $fecha_hoy=asigna_fecha_hoy();  $nro_orden=$_GET["nro_orden"]; $tipo_causado=$_GET["tipo_causado"]; $nombre_abrev_caus=$_GET["nombre_abrev_caus"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (CONSULTAR ORDENES DE PAGO)</title>
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
function Llamar_Inc_comp(){ document.form2.submit();}

function checkreferencia(mform){var mref;
   mref=mform.txtnro_orden.value;   mref = Rellenarizq(mref,"0",8);   mform.txtnro_orden.value=mref;
return true;}
function revisar(){var f=document.form1;var Valido=true;
    if(f.txtnro_orden.value==""){alert("Numero de Orden no puede estar Vacia");return false;}  else{f.txtnro_orden.value=f.txtnro_orden.value;}
    document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONSULTAR ORDEN DE PAGO </div></td>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_orden_pago.php?Gcriterio=C<? echo $nro_orden.$tipo_causado;?>'')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_orden_pago.php?Gcriterio=C<? echo $nro_orden.$tipo_causado;?>'">Atras</A></td>
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
      <form name="form1" method="post" action="consult_orden.php" onSubmit="return revisar()">
      <table width="869" >
	          <tr> <td>&nbsp;</td>  </tr>
              <tr>
                <td>
                  <table width="866" align="center">
                    <tr>
                      <td><table width="832" border="0">
                        <tr>
						  <td width="132"><span class="Estilo5">N&Uacute;MERO ORDEN:</span></td>
                          <td width="300"><input name="txtnro_orden" type="text"  id="txtnro_orden" size="12" maxlength="8" value="<?echo $nro_orden?>" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkreferencia(this.form);" onkeypress="return stabular(event,this)"></td>
                        
						  <td width="400"><p><span class="Estilo5"></span></p></td>
                        
						</tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
			  <tr> <td>&nbsp;</td>  </tr>
			  <tr> <td>&nbsp;</td>  </tr>
          </table>
        <table width="768">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Buscar"></td>
            <td width="88"><input name="Submit" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>

</table>
</body>
</html>