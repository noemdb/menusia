<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$cod_empleado='';}else {$cod_empleado=$_GET["Gcodigo"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000075"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}

if (!$_GET){$cod_empleado='';}else {$cod_empleado=$_GET["Gcodigo"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Retornar de Vacaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function carga_vac(){var murl; murl="Retornar_vacaciones.php?Gcodigo="+document.form1.txtcod_empleado.value; document.location = murl;}
function revisar(){
var f=document.form1; var r;
    if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txtfecha_caus_desde.value==""){alert("Fecha Causado Desde no puede estar Vacia"); return false; }
    if(f.txtfecha_caus_hasta.value==""){alert("Fecha Causado Hasta no puede estar Vacia"); return false; }
    if(f.txtfecha_caus_desde.value.length==10){Valido=true;}else{alert("Longitud de Fecha Causado Desde Invalida");return false;}
	if(f.txtfecha_caus_hasta.value.length==10){Valido=true;}else{alert("Longitud de Fecha Causado Hasta Invalida");return false;}
    if(f.txtfecha_d_desde.value==""){alert("Fecha Disfrute Desde no puede estar Vacia"); return false; }
    if(f.txtfecha_d_hasta.value==""){alert("Fecha Disfrute Hasta no puede estar Vacia"); return false; }
    if(f.txtfecha_d_desde.value.length==10){Valido=true;}else{alert("Longitud de Fecha Disfrute Desde Invalida");return false;}
	if(f.txtfecha_d_hasta.value.length==10){Valido=true;}else{alert("Longitud de Fecha Disfrute Hasta Invalida");return false;}
    if(f.txtfecha_reincorp.value==""){alert("Fecha Reincorporase no puede estar Vacia"); return false; }
    if(f.txtfecha_reincorp.value.length==10){Valido=true;}else{alert("Longitud de Fecha Reincorporase Invalida");return false;}
    r=confirm("Desea Registrar el Retorno de Vacaciones ?"); 
    if(r==true){ r=confirm("Esta Realmente Seguro de Registrar el Retorno de Vacaciones ?"); if(r==true){document.form1.submit;}else{return false; } }
	else{return false; }
return true;}
</script>

</head>
<?
$sql="Select * FROM TRABAJADOR_VACACION where (cod_empleado='$cod_empleado')";  $res=pg_query($sql);$filas=pg_num_rows($res);
$nombre=""; $cedula=""; $fecha_ingreso=""; $fecha_caus_hasta=""; $fecha_caus_desde=""; $denominacion=""; $cod_concepto_v=""; $fecha_d_desde=""; $fecha_d_hasta="";
$dias_habiles=0; $dias_no_habiles=0; $fecha_d_desde=""; $fecha_d_hasta=""; $fecha_reincorp=""; $dias_bono_vac=0; $monto_bono_vac=0; $dias_disfrutados=0; $inf_usuario="";
 $calcula_nomina="NO"; $fecha_cal_d=""; $fecha_cal_h=""; $monto_concepto=0;
if($filas>=1){  $registro=pg_fetch_array($res,0);  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_caus_hasta=$registro["fecha_c_hasta"]; $fecha_caus_desde=$registro["fecha_c_desde"]; $fecha_caus_desde=formato_ddmmaaaa($fecha_caus_desde);  $fecha_caus_hasta=formato_ddmmaaaa($fecha_caus_hasta);
  $cod_concepto_v=$registro["cod_concepto"]; $dias_habiles=$registro["dias_habiles"]; $dias_no_habiles=$registro["dias_no_habiles"]; 
  $fecha_d_desde=$registro["fecha_d_desde"]; $fecha_d_hasta=$registro["fecha_d_hasta"]; $fecha_reincorp=$registro["fecha_reincorp"]; $monto_concepto=$registro["monto_concepto"];
  $fecha_d_desde=formato_ddmmaaaa($fecha_d_desde); $fecha_d_hasta=formato_ddmmaaaa($fecha_d_hasta);  $fecha_reincorp=formato_ddmmaaaa($fecha_reincorp); 
  $dias_bono_vac=$registro["dias_bono_vac"]; $monto_bono_vac=$registro["monto_bono_vac"]; $calcula_nomina=$registro["calcula_nomina"]; $inf_usuario=$registro["inf_usuario"];;
  $fecha_cal_d=$registro["fecha_calculo_d"]; $fecha_cal_h=$registro["fecha_calculo_h"]; $fecha_cal_d=formato_ddmmaaaa($fecha_cal_d);  $fecha_cal_h=formato_ddmmaaaa($fecha_cal_h);
} $criterio=$cod_empleado; $dias_disfrutados=$dias_habiles; $monto_bono_vac=formato_monto($monto_bono_vac); $monto_concepto=formato_monto($monto_concepto);
 $dias_bono_vac=formato_monto($dias_bono_vac); $dias_habiles=formato_monto($dias_habiles); $dias_no_habiles=formato_monto($dias_no_habiles); $dias_disfrutados=formato_monto($dias_disfrutados);
$sql="Select * from conceptos where cod_concepto='$cod_concepto_v'"; $res=pg_query($sql);$filas=pg_num_rows($res);if($filas>=1){  $registro=pg_fetch_array($res,0); $denominacion=$registro["denominacion"]; }

pg_close();?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">RETORNO DE VACACIONES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="360" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="Insert_retorno_vaca.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:940px; height:340px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="176"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR  : </span></td>
                   <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_empleado?>" > </span></td>
                   <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores con Calculo Vacaciones"  onClick="VentanaCentrada('Cat_trab_sal_vac.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="600"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="80" maxlength="80" readonly value="<?echo $nombre?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="186"><span class="Estilo5">C&Oacute;DIGO CONCEPTO C&Aacute;LCULO  :</span></td>
                 <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_v" type="text" id="txtcod_concepto_v" size="3" maxlength="3"  value="<?echo $cod_concepto_v?>" readonly> </span></td>
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="80" maxlength="80"  value="<?echo $denominacion?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">PERIODO DE CAUSACION DESDE : </span></td>
                 <td width="300" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_caus_desde" type="text" id="txtfecha_caus_desde" size="10" maxlength="10" readonly value="<?echo $fecha_caus_desde?>"></span></td>
                 <td width="100" ><span class="Estilo5">HASTA : </span></td>
                 <td width="250" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_caus_hasta" type="text" id="txtfecha_caus_hasta" size="10" maxlength="10"  readonly value="<?echo $fecha_caus_hasta?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="246" ><span class="Estilo5">CANTIDAD DIAS DE VACACIONES HABILES : </span></td>
                 <td width="300" ><span class="Estilo5"><input class="Estilo10" name="txtdias_habiles" type="text" id="txtdias_habiles" size="10" maxlength="10" style="text-align:right" readonly value="<?echo $dias_habiles?>"></span></td>
                 <td width="100" ><span class="Estilo5">NO HABILES : </span></td>
                 <td width="220" ><span class="Estilo5"><input class="Estilo10" name="txtdias_no_habiles" type="text" id="txtdias_no_habiles" size="10" maxlength="10" style="text-align:right" readonly value="<?echo $dias_no_habiles?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="200" ><span class="Estilo5">FECHA DE DISFRUTE DESDE : </span></td>
                 <td width="120" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_d_desde" type="text" id="txtfecha_d_desde" size="10" maxlength="10" readonly value="<?echo $fecha_d_desde?>"></span></td>
                 <td width="70" ><span class="Estilo5">HASTA : </span></td>
                 <td width="156" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_d_hasta" type="text" id="txtfecha_d_hasta" size="10" maxlength="10"  readonly value="<?echo $fecha_d_hasta?>"></span></td>
                 <td width="180" ><span class="Estilo5">FECHA A REINCORPORASE : </span></td>
                 <td width="140" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_reincorp" type="text" id="txtfecha_reincorp" size="10" maxlength="10" readonly value="<?echo $fecha_reincorp?>"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="246" ><span class="Estilo5">CANTIDAD DIAS BONO VACACIONAL : </span></td>
                 <td width="250" ><span class="Estilo5"><input class="Estilo10" name="txtdias_bono_vac" type="text" id="txtdias_bono_vac" size="10" maxlength="10" style="text-align:right" readonly value="<?echo $dias_bono_vac?>"></span></td>
                 <td width="170" ><span class="Estilo5">MONTO BONO VACACIONAL: </span></td>
                 <td width="200" ><span class="Estilo5"><input class="Estilo10" name="txtmonto_bono_vac" type="text" id="txtmonto_bono_vac" size="17" maxlength="17" style="text-align:right" readonly value="<?echo $monto_bono_vac?>"></span></td>
                 </tr>
             </table></td>
           </tr> 
           <tr>
             <td><table width="866">
               <tr>
                 <td width="170"><span class="Estilo5">CALCULO DE NOMINA :</span></td>
				 <td width="220" ><span class="Estilo5"><input class="Estilo10" name="txtcalcula_nomina" type="text" id="txtcalcula_nomina" size="3" maxlength="3" readonly value="<?echo $calcula_nomina?>"></span></td>                 
                 <td width="220"><span class="Estilo5">FECHA CALCULO DESDE : </span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_calculo_d" type="text" id="txtfecha_calculo_d" size="10" maxlength="10" readonly value="<?echo $fecha_cal_d?>" ></span></td>
                 <td width="65"><span class="Estilo5">HASTA : </span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_calculo_h" type="text" id="txtfecha_calculo_h" size="10" maxlength="10" readonly value="<?echo $fecha_cal_h?>" ></span></td>
               </tr>
             </table></td>
           </tr>		   
           <tr>
             <td><table width="866">
               <tr>
                 <td width="346" ><span class="Estilo5">CANTIDAD DIAS DE VACACIONES HABILES DISFRUTADOS : </span></td>
                 <td width="520" ><span class="Estilo5"><input class="Estilo10" name="txtdias_disfrutados" type="text" id="txtdias_disfrutados" size="10" maxlength="10" style="text-align:right" value="<?echo $dias_disfrutados?>"></span></td>
               </tr>
             </table></td>
           </tr>
        </table>

        <div id="Layer4" style="position:absolute; width:940px; height:30px; z-index:2; left: 3px; top: 285px;">
        <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="170"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="200" align="center"><input name="btcargar" type="button" id="btcargar" title="Cargar Salida de Vacaciones" onclick="javascript:carga_vac()" value="Cargar"></td>
            <td width="200"><input name="Grabar" type="submit" id="Procesar Retorno"  value="Procesar Retorno"></td>
			<td width="200" align="center"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
            <td width="170"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
          </tr>
        </table>
         </div>

       </div>
      </form>
    </td>

  </tr>
</table>
</body>
</html>