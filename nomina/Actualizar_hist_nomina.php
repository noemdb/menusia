<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="04-0000050"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo=getenv("COMPUTERNAME"); $mcod_m="NOM019".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$tipo_nomina="01"; $cod_concepto="001"; $criterio="";  $fecha_hoy=asigna_fecha_hoy(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL N&Oacute;MINA Y PERSONAL (Actualiza Montos de Conceptos del Historico)</title>
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
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function Cargar_Asig_trab(mform){
var mcod_empleado=mform.txtcod_empleado.value;
var mtipo_nomina=mform.txttipo_nomina.value;
var mfecha_nomina=mform.txtfecha_nomina.value;
   ajaxSenddoc('GET', 'cargaconchist.php?cod_empleado='+mcod_empleado+'&tipo_nomina='+mtipo_nomina+'&fecha_nomina='+mfecha_nomina, 'T11', 'innerHTML');
return true;}
</script>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ACTUALIZAR MONTOS DE CONCEPTOS DEL HISTORICO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="590" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:940px; height:540px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
		   <tr>
             <td><table width="946">
                 <tr>
                   <td width="150"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="60"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="3" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_tipo(this.form);"> </span></td>
                   <td width="50"><input class="Estilo10" name="bttiponom" type="button" id="bttiponom" title="Abrir Catalogo Tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="705"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="100" maxlength="100" readonly > </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="146"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" readonly></span></td>
                 <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trab_cal_presta.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="100"><span class="Estilo5">C&Eacute;DULA :</span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"   readonly></span></td>
                 <td width="120"><span class="Estilo5">FECHA NOMINA  :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_nomina" type="text" id="txtfecha_nomina" size="12" maxlength="10"  value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="146"><span class="Estilo5">NOMBRE TRABAJADOR  :</span></td>
                 <td width="720"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="100" maxlength="100"   readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="946">
                 <tr>
				   <td width="50"><input class="Estilo10" name="txtfecha_ingreso" type="hidden" id="txtfecha_ingreso" value="<?echo $fecha_hoy?>"></td>
                   <td width="750"><span class="Estilo5"> </span></td>
                   <td width="146"><span class="Estilo5"><input type="button" name="btcarga_asig" value="Cargar Conceptos" title="Cargar Concepto del Historico" onClick="javascript:Cargar_Asig_trab(this.form)" ></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
         </table>
         <div id="T11" class="tab-body">
         <iframe src="Det_conc_hist_nom.php?cod_empleado=<?echo $cod_empleado?>&tipo_nomina=&fecha_nomina=" width="950" height="350" scrolling="auto" frameborder="1"></iframe>
         </div>
         <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="550"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="150"></td>
            <td width="150" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
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