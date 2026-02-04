<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
 $equipo = getenv("COMPUTERNAME");   $mcod_m = "PRE007".$usuario_sia.$equipo;  $codigo_mov=substr($mcod_m,0,49);
 $fecha_hoy=asigna_fecha_hoy(); 
 $conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
 if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
 $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="02-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); 
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">muestra('<?php  echo $error; ?>');</script><?php }
$resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script>} <?php }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Incluir Interfaz Contable)</title>
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
function Cargar_bien(mform){var mfecha; var mcodigo_mov='<?php echo $codigo_mov ?>';mfecha=mform.txtFecha.value;    
   ajaxSenddoc('GET', 'cargabiencon.php?fecha='+mfecha+'&codigo_mov='+mcodigo_mov, 'T11', 'innerHTML');   
   ajaxSenddoc('GET', 'cargabiencaus.php?codigo_mov='+mcodigo_mov, 'T12', 'innerHTML');}
function checkrefecha(mform){var mref; var mfec;  mref=mform.txtFecha.value;
  if(mform.txtFecha.value.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mform.txtFecha.value=mfec;}
return true;}
function revisar(){var f=document.form1;  var valido=true;
    if(f.txtFecha.value==""){alert("Fecha no puede estar Vacia");return false;}
	r=confirm("Desea Grabar el Comprobante de Bienes  ?");
    if (r==true) { r=confirm("Esta Realmente Seguro en Grabar el Comprobante de Bienes ?");
      if (r==true) {valido=true;} else{return false;}
	}else{return false;}	
document.form1.submit;
return true;}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR INTERFAZ CONTABILIDAD/BIENES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="535" border="1">
  <tr>
    <td width="92"><table width="92" height="525" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:355px; z-index:1; top: 70px; left: 116px;">
      <form name="form1" method="post" action="Insert_comp_bienes.php" onSubmit="return revisar()">
        <table width="858" border="0">
		  <tr>
              <td colspan="3"><table width="860" border="0">
                <tr>
				  <td width="160"><span class="Estilo5">FECHA : <input name="txtFecha" type="text" id="txtFecha" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_hoy?>" size="12" maxlength="10" onchange="checkrefecha(this.form)"> </span></td>
				  <td width="100"><img src="../imagenes/img_cal.png" width="20" height="14" id="calendario3" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"   onmouseover="this.style.background='blue';" onmouseout="this.style.background=''"  onClick="javascript:showCal('Calendario3')"  /></td>
				  <td width="400"><span class="Estilo5"> </span> </td>
                  
				  
				  <td width="200"><span class="Estilo5"> <input type="button" name="btcarga_fact" value="Generar Asiento" title="Generar Asiento" onClick="javascript:Cargar_bien(this.form)" > </span></td>
 
				        
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
   rows[1][1] = "Comprobante";
   rows[1][2] = "Causado Presup";
            </script>
              <?php include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>              
              <!--PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body" >
                <iframe src="Det_inc_comp_caus.php?codigo_mov=<?php echo $codigo_mov?>"  width="846" height="390" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_inc_causados.php?codigo_mov=<?php echo $codigo_mov?>"  width="846" height="390" scrolling="auto" frameborder="0"> </iframe>
              </div>			  
            </div></td>
         </tr>
        </table>
        
        
        <div id="Layer3" style="position:absolute; width:868px; height:60px; z-index:2; left: 2px; top: 480px;">

        <table width="800">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
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
