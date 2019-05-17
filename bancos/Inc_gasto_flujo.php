<?include ("../class/ventana.php"); include ("../class/fun_fechas.php");  $codigo_mov=$_POST["txtcodigo_mov"];  $fecha_hoy=asigna_fecha_hoy(); 
 $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"]; $ano_eje=$_POST["txtano_eje"]; $uperiodo=$_POST["txtUperiodo"];   
 $fecha_h=colocar_udiames($fecha_hoy); $mes_libro=substr($fecha_h,3,2); $mes_libro=$uperiodo; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO  (Incluir Gasto de Flujo)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
var mano='<?php echo $ano_eje ?>';
function chequea_mes(mform){var mmes;
   mmes=mform.txtnomb_mes.value; mform.txtmes_fiscal.value=mmes;
return true;}
function Cargar_Ret(mform){var mmes;  mmes=mform.txtmes_fiscal.value; 
   r=confirm("Esta seguro en Generar el Gastos del Flujo de Caja ?");
  if (r==true) { ajaxSenddoc('GET', 'cargagastoflujo.php?mes='+mmes+'&ano='+mano+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML'); }
return true;}
</script>
<? 

?>
</head>
<body>
<table width="989" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR GASTOS PARA FLUJO DE CAJA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="510" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="502" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_Gasto_flujo.php?Gperiodo=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_Gasto_flujo.php?Gperiodo=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:491px; z-index:1; top: 62px; left: 118px;">
        <form name="form1" >
          <table width="856" border="0" >
                <tr> <td >&nbsp;</td>  </tr>
                <tr>
                  <td height="14"><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="100"><span class="Estilo5">MES PROCESO: </span></td>
                      <td width="120"><span class="Estilo5">
                         <select name="txtnomb_mes"  id="txtnomb_mes" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_mes(this.form)">
                          <option value='01'>ENERO</option><option value='02'>FEBRERO</option> <option value='03'>MARZO</option>
                          <option value='04'>ABRIL</option><option value='05'>MAYO</option> <option value='06'>JUNIO</option>
                          <option value='07'>JULIO</option> <option value='08'>AGOSTO</option> <option value='09'>SEPTIEMBRE</option>
                          <option value='10'>OCTUBRE</option> <option value='11'>NOVIEMBRE</option> <option value='12'>DICIEMBRE</option>
                        </select>
                      </span></td>
<script language="JavaScript" type="text/JavaScript">
var mvalor='<?echo $mes_libro ?>';
    if(mvalor=="01"){document.form1.txtnomb_mes.options[0].selected = true;}
    if(mvalor=="02"){document.form1.txtnomb_mes.options[1].selected = true;}
    if(mvalor=="03"){document.form1.txtnomb_mes.options[2].selected = true;}
    if(mvalor=="04"){document.form1.txtnomb_mes.options[3].selected = true;}
    if(mvalor=="05"){document.form1.txtnomb_mes.options[4].selected = true;}
    if(mvalor=="06"){document.form1.txtnomb_mes.options[5].selected = true;}	
	if(mvalor=="07"){document.form1.txtnomb_mes.options[6].selected = true;}
	if(mvalor=="08"){document.form1.txtnomb_mes.options[7].selected = true;}
	if(mvalor=="09"){document.form1.txtnomb_mes.options[8].selected = true;}
	if(mvalor=="10"){document.form1.txtnomb_mes.options[9].selected = true;}
	if(mvalor=="11"){document.form1.txtnomb_mes.options[10].selected = true;}
	if(mvalor=="12"){document.form1.txtnomb_mes.options[11].selected = true;}
</script>
                      <td width="80"><span class="Estilo5"><input name="txtmes_fiscal" type="text" id="txtmes_fiscal" size="2" maxlength="2" value='<?echo $mes_libro ?>' readonly ></span></td>
                      <td width="350"></td>
                      <td width="200"><span class="Estilo5"> <input type="button" name="btcarga_fact" value="Generar" title="Generar Gastos para Flujo de Caja" onClick="javascript:Cargar_Ret(this.form)" > </span></td>
                     </tr>
                     <tr> <td>&nbsp;</td>  </tr>
                  </table></td>
                </tr>
          </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_inc_gasto_flujo.php?criterio=<?echo $mes_libro?>" width="870" height="360" scrolling="auto" frameborder="1"></iframe>
              </div>
         <table width="863" border="0"> <tr> <td height="5">&nbsp;</td> </tr> </table>
         <table width="812">
          <tr>
            <td width="654">&nbsp;</td>
            <td width="10"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>