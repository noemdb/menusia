<?php include ("../class/fun_fechas.php"); include ("../class/ventana.php");
 if (!$_GET){$equipo = getenv("COMPUTERNAME");   $mcod_m = "CON012".$usuario_sia.$equipo;  $codigo_mov=substr($mcod_m,0,49);}
 else{$codigo_mov=$_GET["codigo_mov"]; $nusuario_sia=$_GET["nusuario_sia"];}  $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Incluir Interfaz Contable)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript"  src="../class/sia.js"  type="text/javascript"></SCRIPT>
<script language="javascript" src="ajax_comp.js" type="text/javascript"></script>
<script language="javascript" src="../class/cal2.js"></script>
<script language="javascript" src="../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">

function Cargar_mov(mform){var mfecha; var mcodigo_mov='<?php echo $codigo_mov ?>';mfecha=mform.txtFecha.value; mafecta_p=mform.txtafect_pre.value; 
   ajaxSenddoc('GET', 'cargamovcob.php?fecha='+mfecha+'&codigo_mov='+mcodigo_mov+'&afecta_p='+mafecta_p, 'T11', 'innerHTML');
   ajaxSenddoc('GET', 'cargamovlib.php?codigo_mov='+mcodigo_mov, 'T12', 'innerHTML');
   ajaxSenddoc('GET', 'cargamovcon.php?codigo_mov='+mcodigo_mov, 'T13', 'innerHTML');
   ajaxSenddoc('GET', 'cargamovpag.php?codigo_mov='+mcodigo_mov, 'T14', 'innerHTML');
   ajaxSenddoc('GET', 'cargamoving.php?codigo_mov='+mcodigo_mov, 'T15', 'innerHTML');}
function checkrefecha(mform){var mref; var mfec;  mref=mform.txtFecha.value;
  if(mform.txtFecha.value.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mform.txtFecha.value=mfec;}
return true;}
function revisar(){var f=document.form1;  var valido=true;
    if(f.txtFecha.value==""){alert("Fecha no puede estar Vacia");return false;}
	r=confirm("Desea Grabar la Interfaz Contable/Cobranza ?");
    if (r==true) { r=confirm("Esta Realmente Seguro en Grabar la Interfaz Contable ?");
      if (r==true) {valido=true;} else{return false;} } else{return false;}	
document.form1.submit;
return true;}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR INTERFAZ CONTABLE/COBRANZA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="535" border="1">
  <tr>
    <td width="92"><table width="92" height="525" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_int_contab.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="Act_int_contab.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:355px; z-index:1; top: 70px; left: 116px;">
      <form name="form1" method="post" action="Insert_int_contab" onSubmit="return revisar()">
        <table width="858" border="0">
		  <tr>
              <td colspan="3"><table width="860" border="0">
                <tr>
				  <td width="160"><span class="Estilo5">FECHA : <input name="txtFecha" type="text" id="txtFecha" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" size="12" maxlength="10" onchange="checkrefecha(this.form)"> </span></td>
				  <td width="100"><img src="../imagenes/img_cal.png" width="20" height="14" id="calendario3" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"   onmouseover="this.style.background='blue';" onmouseout="this.style.background=''"  onClick="javascript:showCal('Calendario3')"  /></td>
				  <td width="250"><span class="Estilo5">FECHA REGISTRO : <input name="txtFecha_reg" type="text"  id="txtFecha_reg" size="12" maxlength="19" onFocus="encender(this)" onBlur="apagar(this)"   value="<?echo $fecha_hoy?>"> </span></td>
                  <td width="230"><span class="Estilo5">USUARIO: <input name="txtusuario_sia" id="txtusuario_sia" size="15" value="<?echo $nusuario_sia?>"  readonly > </span> </td>
                  
				  
				  <td width="120"><span class="Estilo5"> <input type="button" name="btcarga_fact" value="Cargar" title="Cargar Movimientos de Cobranza" onClick="javascript:Cargar_mov(this.form)" > </span></td>
 
				        
				</tr>
              </table></td>
          </tr>
        </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="tt1" style="position:absolute; width:868px; height:392px; z-index:2; left: 2px; top: 40px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Movimientos";
   rows[1][2] = "Mov.Libros";
   rows[1][3] = "Comprobantes";
   rows[1][4] = "Pagos Presup";
   rows[1][5] = "Presup Ingresos";
   if ((mbloq=="N")&&(gordr=="N")) {rows[1][5] = "O/P Retenciones Canc.";}
            </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_inc_int_cont.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="390" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_inc_mov_cont.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="390" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 3 -->
              <div id="T13" class="tab-body" >
                <iframe src="Det_inc_comp_cont.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="390" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 4 -->
              <div id="T14" class="tab-body" >
                <iframe src="Det_inc_pag_cont.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="390" scrolling="auto" frameborder="0"> </iframe>
              </div>
			  <div id="T15" class="tab-body" >
                <iframe src="Det_inc_ing_cont.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="390" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
        
        
        <div id="Layer3" style="position:absolute; width:868px; height:60px; z-index:2; left: 2px; top: 480px;">

        <table width="800">
          <tr>
            <td width="14"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="650"><span class="Estilo5">AFECTA PRESUPUESTO CON FECHA DE REGISTRO : <select name="txtafect_pre" size="1" id="txtafect_pre" onFocus="encender(this)" onBlur="apagar(this)">
                <option>SI</option> <option selected>NO</option> </select></span></td>
				  
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
		</div>
        </form>
    </div>
  </tr>
</table>
</body>
</html>