<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php");
$equipo=getenv("COMPUTERNAME"); $mcod_m="VAC".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000065"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_empleado=''; $p_letra='';  $criterio='';  $cod_empleado='';  $clave=''; $sql="SELECT * FROM CALCULO_VACACIONES ORDER BY cod_empleado";
} else {$criterio=$_GET["Gcriterio"];$p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_empleado=substr($criterio,1,15);} else{ $cod_empleado=substr($criterio,0,15);}
  $sql="Select * FROM CALCULO_VACACIONES where (cod_empleado='$cod_empleado')"; $clave=$cod_empleado;
  if ($p_letra=="P"){$sql="SELECT * FROM CALCULO_VACACIONES Order BY cod_empleado";}
  if ($p_letra=="U"){$sql="SELECT * FROM CALCULO_VACACIONES Order by cod_empleado Desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM CALCULO_VACACIONES Where (cod_empleado>'$clave') Order by cod_empleado";}
  if ($p_letra=="A"){$sql="SELECT * FROM CALCULO_VACACIONES Where (cod_empleado<'$clave') Order by cod_empleado Desc";}
} $criterio=$cod_empleado;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL N&Oacute;MINA Y PERSONAL (Calculo de Vacaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;var Gcodigo=document.form1.txtcod_empleado.value;    murl=url+Gcodigo;
    if (Gcodigo=="") {alert("Codigo debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_calculo_vacaciones.php";
   if(MPos=="P"){murl="Act_calculo_vacaciones.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_calculo_vacaciones.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_calculo_vacaciones.php?Gcriterio=S"+document.form1.txtcod_empleado.value;}
   if(MPos=="A"){murl="Act_calculo_vacaciones.php?Gcriterio=A"+document.form1.txtcod_empleado.value;}
 document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar el Calculo de Vacaciones ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Calculo de Vacaciones ?");
    if (r==true) { url="Delete_cal_vacaciones.php?txtcod_empleado="+document.form1.txtcod_empleado.value;  VentanaCentrada(url,'Eliminar Calculo de Vacaciones','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
}

function Llamar_Formato(){var url;var r;
 r=confirm("Desea Generar el Formato de Vacaciones ?");
   if (r==true) {url="/sia/nomina/rpt/Formato_vacaciones.php?txtcod_empleado="+document.form1.txtcod_empleado.value;  window.open(url); }
 }

</script>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
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

</head>
<?
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM CALCULO_VACACIONES  Where Order by cod_empleado";}if ($p_letra=="A"){$sql="SELECT * FROM CALCULO_VACACIONES  Where Order by cod_empleado desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$nombre=""; $cedula=""; $fecha_ingreso=""; $fecha_caus_hasta=""; $fecha_caus_desde=""; $denominacion=""; $cod_concepto_v=""; $fecha_d_desde=""; $fecha_d_hasta="";
$dias_habiles=0; $dias_no_habiles=0; $fecha_d_desde=""; $fecha_d_hasta=""; $fecha_reincorp=""; $dias_bono_vac=0; $monto_bono_vac=0; $dias_disfrutados=0; $monto_concepto=0; $inf_usuario="";
 $calcula_nomina="NO"; $fecha_cal_d=""; $fecha_cal_h="";
if($filas>=1){  $registro=pg_fetch_array($res,0);  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_caus_hasta=$registro["fecha_caus_hasta"]; $fecha_caus_desde=$registro["fecha_caus_desde"]; $fecha_caus_desde=formato_ddmmaaaa($fecha_caus_desde);  $fecha_caus_hasta=formato_ddmmaaaa($fecha_caus_hasta);
  $cod_concepto_v=$registro["cod_concepto_v"]; $dias_habiles=$registro["dias_habiles"]; $dias_no_habiles=$registro["dias_no_habiles"]; 
  $fecha_d_desde=$registro["fecha_desde"]; $fecha_d_hasta=$registro["fecha_hasta"]; $fecha_reincorp=$registro["fecha_reincorp"];  $monto_concepto=$registro["monto_concepto_v"]; 
  $fecha_d_desde=formato_ddmmaaaa($fecha_d_desde); $fecha_d_hasta=formato_ddmmaaaa($fecha_d_hasta);  $fecha_reincorp=formato_ddmmaaaa($fecha_reincorp); 
  $dias_bono_vac=$registro["dias_bono_vaca"]; $monto_bono_vac=$registro["monto_bono_vaca"]; $calcula_nomina=$registro["calcula_nomina"]; $inf_usuario=$registro["inf_usuario"]; $usuario_vac=$registro["usuario_sia"];
  $fecha_cal_d=$registro["fecha_calculo_d"]; $fecha_cal_h=$registro["fecha_calculo_h"]; $fecha_cal_d=formato_ddmmaaaa($fecha_cal_d);  $fecha_cal_h=formato_ddmmaaaa($fecha_cal_h);
} $criterio=$cod_empleado; $monto_bono_vac=formato_monto($monto_bono_vac); $monto_concepto=formato_monto($monto_concepto);
$sql="Select * from conceptos where cod_concepto='$cod_concepto_v'"; $res=pg_query($sql);$filas=pg_num_rows($res);if($filas>=1){  $registro=pg_fetch_array($res,0); $denominacion=$registro["denominacion"]; }
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CALCULO DE VACACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="374" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="373" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?if ($Mcamino{0}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cargar_trab_vac.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Cargar_trab_vac.php">Incluir</A></td>
      </tr>
	  <?} if ($Mcamino{1}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('carga_mod_vac.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('carga_mod_vac.php?Gcodigo=');">Modificar</A></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript: Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U',<?echo $criterio?>)";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_calculo_vacaciones.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_calculo_vacaciones.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
      </tr>
	  <?} if ($Mcamino{3}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
      </tr>
	   <?} ?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
      </tr>
      <tr><td>&nbsp;</td> </tr>
    </table></td>
    <td width="879">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post">
          <table width="878" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15"  value="<?echo $cod_empleado?>" readonly></span></td>
                 <td width="100"><span class="Estilo5">C&Eacute;DULA :</span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  value="<?echo $cedula?>" readonly></span></td>
                 <td width="120"><span class="Estilo5">FECHA INGRESO  :</span></td>
                 <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ingreso" type="text" id="txtfecha_ingreso" size="12" maxlength="10"  value="<?echo $fecha_ingreso?>" readonly></span></td>
                 <td width="40"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="146"><span class="Estilo5">NOMBRE TRABAJADOR  :</span></td>
                 <td width="720"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="100" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="186"><span class="Estilo5">C&Oacute;DIGO CONCEPTO CALCULO  :</span></td>
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
                 <td width="256" ><span class="Estilo5">CANTIDAD DIAS DE VACACIONES HABILES : </span></td>
                 <td width="290" ><span class="Estilo5"><input class="Estilo10" name="txtdias_habiles" type="text" id="txtdias_habiles" size="10" maxlength="10" readonly style="text-align:right" value="<?echo $dias_habiles?>"></span></td>
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
                 <td width="250" ><span class="Estilo5"><input class="Estilo10" name="txtdias_bono_vac" type="text" id="txtdias_bono_vac" size="10" maxlength="10" readonly  style="text-align:right" value="<?echo $dias_bono_vac?>"></span></td>
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
          </table>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>