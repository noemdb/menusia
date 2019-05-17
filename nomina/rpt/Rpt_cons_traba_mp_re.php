<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="03-0000130"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
    $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);   $cod_empleado_d="";  $fecha_hoy=asigna_fecha_hoy(); 
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reportes Constancia de Trabajo)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec; } return true;}
function Llama_Menu_Rpt(murl){var url;   url="../"+murl;   LlamarURL(url);}

function Llama_cons_trab(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Constancia de Trabajo ?");
  if (r==true){url=murl+"?cod_empleado="+document.form1.txtcod_empleado.value+"&tipo_sueldo="+document.form1.txtipo_sueldo.value+"&fecha_emi="+document.form1.txtfecha_emi.value+"&fecha_ing="+document.form1.txtfecha_ingreso.value+    
     "&fecha_desde="+document.form1.txtFechad.value+"&fecha_hasta="+document.form1.txtFechah.value+"&observacion="+document.form1.txtobservacion.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
  window.open(url,"Reporte Constancia de Trabajo")}
}
</script>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE CONSTANCIA DE TRABAJO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="383" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="377"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:504px; height:332px; z-index:1; top: 81px; left: 42px;">
         <table width="828" border="0" align="center" >           
           <tr>
             <td><table width="905">
               <tr>
                 <td width="200"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEL TRABAJADOR  :</span></div></td>
				 <td width="145"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="160"><input class="Estilo10" name="bttrabajador" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('../Cat_trabajadores_cons.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="150"><div align="left"><span class="Estilo5">FECHA DE EMISION  :</span></div></td>
				 <td width="250" align="left"><span class="Estilo5"><input class="Estilo10" name="txtfecha_emi" type="text" id="txtfecha_emi" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
				</tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="200"><div align="left"><span class="Estilo5">NOMBRE DEL TRABAJADOR  :</span></div></td>
				 <td width="705"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="100" maxlength="100" readonly value=""> </span></td>
			  </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="200" scope="col"><div align="left"><span class="Estilo5">TIPO DE SUELDO  :</span></div></td>
                 <td width="405" scope="col"><div align="left"><span class="Estilo5">
                     <select class="Estilo10" name="txtipo_sueldo"><option>SUELDO BASICO</option><option>SUELDO INTEGRAL</option>
                       <option>SUELDO BASICO PROMEDIO</option> <option>SUELDO INTEGRAL PROMEDIO</option>
                        </select>
                 </span></div></td>
				 <td width="150"><div align="left"><span class="Estilo5">FECHA DE INGRESO  :</span></div></td>
				 <td width="150" align="left"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ingreso" type="text" id="txtfecha_ingreso" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
			
               </tr>
             </table></td>
           </tr>
           
           <tr>
             <td><table width="905">
               <tr>
                 <td width="325" scope="col"><div align="left"><span class="Estilo5">RANGO DE FECHA PARA SUELDOS PROMEDIOS DESDE : </span></div></td>
                 <td width="200" scope="col"><div align="left"><span class="Estilo5"> <input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">
                     <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                    onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  />  </span></div></td>
                 <td width="60" scope="col"><span class="Estilo5">HASTA :</span></td>
                 <td width="320" scope="col"><span class="Estilo5"> <input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">
                   <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                  onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td>&nbsp;</td></tr>
           <tr>
             <td><table width="906">
               <tr>
                 <td width="105" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N  :</span></div></td>
                 <td width="800" scope="col"><div align="left"><span class="Estilo5"><textarea name="txtobservacion" cols="90" class="Estilo10" id="txtobservacion" onFocus="encender(this)" onBlur="apagar(this)"></textarea></span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td>&nbsp;</td></tr>
           <tr>
            <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
                 <td width="180"  align="left" class="Estilo5">TIPO SALIDA DEL REPORTE :</td>
				 <td width="160" align="left"><span class="Estilo5"><select class="Estilo10" name="tipo_rpt" id="tipo_rpt"> <option value='PDF'>FORMATO PDF</option> <option value='WORD'>FORMATO WORD</option> </select></span></td>
                 <td width="563"><span class="Estilo5"> </span></td>				 
			 </tr>
             </table></td>
           </tr>
           <tr><td>&nbsp;</td></tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center"><input name="btgenerar" type="button" id="btgenerar" value="GENERAR" onClick="javascript:Llama_cons_trab('Rpt_cons_trab.php');">  </div></th>
                 <th width="447" scope="col"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></th>
               </tr>
             </table></td>
           </tr>
         </table>
         <p align="left">&nbsp;</p>
       </div>
    </form>    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<? pg_close();?>
