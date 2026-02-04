<?include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php");include ("../class/configura.inc"); $equipo=getenv("COMPUTERNAME");   $fecha_hoy=asigna_fecha_hoy();  $fecha_tope="30/04/2012"; 
if (!$_GET){$criterio="";} else{$criterio=$_GET["Gcriterio"];}  $cod_empleado=$criterio;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Reporte Control Individual de Prestaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="javascript" src="../class/cal2.js"></script>
<script language="javascript" src="../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
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
var patronfecha = new Array(2,2,4);
function Llamar_Ventana(url){var murl;   document.location = url;}

function Llama_Rpt_con_indi_pres_mpr(murl){var url; var r;
  r=confirm("Desea Generar el Reporte Control Individual de Prestaciones e Intereses?");
  if (r==true) {url=murl+"?tipo_nominad="+document.form1.txttipo_nomina.value+"&tipo_nominah="+document.form1.txttipo_nomina.value+"&cod_empleado_d="+document.form1.txtcod_empleado.value+"&cod_empleado_h="+document.form1.txtcod_empleado.value+"&fecha_h="+document.form1.txtFechad.value+"&estatus=TODOS"+"&detalle="+document.form1.txtdetalle.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
     window.open(url,"Reporte Control Individual de Prestaciones e Intereses")
  }
}

</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else { $Nom_Emp=busca_conf(); }
$sql="Select cod_empleado,nombre,cedula,fecha_ingreso,tipo_nomina FROM NOM006 where (cod_empleado='$cod_empleado')"; $res=pg_query($sql);$filas=pg_num_rows($res);
$nombre=""; $cedula=""; $fecha_ingreso=""; $tipo_nomina="00"; if($filas>=1){ $registro=pg_fetch_array($res,0);
$nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $tipo_nomina=$registro["tipo_nomina"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso); $cod_empleado=$registro["cod_empleado"];  }
pg_close(); //$fecha_hoy=colocar_udiames($fecha_hoy); 
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE CONTROL INDIVIDUAL DE PRESTACIONES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Act_cal_prest_lott.php?Gcodigo=C<?echo $cod_empleado?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Ventana('Act_cal_prest_lott.php?Gcodigo=C<?echo $cod_empleado?>');">Atras</a></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr>
   </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post" >
          <table width="868" border="0" cellspacing="3" cellpadding="3">
          <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR  : </span></td>
                   <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_empleado?>" > </span></td>
                   <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trabajadores.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="550"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="80" maxlength="80" readonly value="<?echo $nombre?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">FECHA PROCESO HASTA :</span></td>
                 <td width="730"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" onkeyup="mascara(this,'/',patronfecha,true)">
				  <img src="../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha" onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  />
				 </span></td>
               </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
		   <tr>
             <td><table width="905">
               <tr>
                 <td width="180"><div align="left"><span class="Estilo5">DETALLADO</span></div></td>
				 <td width="220"><span class="Estilo5"><select class="Estilo10" name="txtdetalle" size="1" id="txtdetalle"><option value ='NO'>NO</option> <option value ='SI'>SI</option> </select> </span></td>
                 <td width="200"  align="left" class="Estilo5">TIPO SALIDA DEL REPORTE :</td>
				 <td width="305" align="left"><span class="Estilo5"><select class="Estilo10" name="tipo_rpt" id="tipo_rpt"> <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option> <option value='PDF2'>FORMATO PDF 2</option>  </select></span></td>
               </tr>
             </table></td>
           </tr>
           <tr><td>&nbsp;</td></tr>	
		   <script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
         
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
                  <td width="200"><input class="Estilo10" name="txttipo_nomina" type="hidden" id="txttipo_nomina" value="<?echo $tipo_nomina?>"></td>
                  <th width="446" scope="col"><div align="center"><input name="btgenerar" type="button" id="btgenerar" value="GENERAR" onClick="javascript:Llama_Rpt_con_indi_pres_mpr('/sia/nomina/rpt/Rpt_con_indi_pres_mpr.php');">  </div></th>
                  <td width="59">&nbsp;</td>
                  <td width="200"><input name="Blanquear" type="reset" value="Blanquear"></td>
                  <td width="200">&nbsp;</td>
                </tr>
          </table>
        </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>