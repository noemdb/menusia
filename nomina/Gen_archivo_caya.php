<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME"); $fecha_hoy=asigna_fecha_hoy();  $tipo_arch_banco='09';
if (!$_GET){$cod_arch_banco="000001"; $tipo_arch_banco="09";}else{$cod_arch_banco=$_GET["cod_arch_banco"];} $criterio=$tipo_arch_banco.$cod_arch_banco;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="04-0000025"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Generar Archivo Fondo de Jubilaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
function checkrefecha(mform){var mref; var mfec; var mmes; var mdia; var mano; var mhasta;
  mref=mform.txtfecha_desde.value;  mfec=mform.txtfecha_desde.value;
  if(mform.txtfecha_desde.value.length==8){ mfec=mref.substring (0, 6)+"20"+mref.charAt(6)+mref.charAt(7);  mform.txtfecha_desde.value=mfec; }
  mmes=mref.charAt(3)+mref.charAt(4); mano=mref.charAt(6)+mref.charAt(7)+mref.charAt(8)+mref.charAt(9);
  mdia="31"; if(mmes=="02"){mdia="28";} if((mmes=="04")||(mmes=="06")||(mmes=="09")||(mmes=="11")){mdia="30";}
  mhasta=mdia+"/"+mmes+"/"+mano;  mform.txtfecha_hasta.value=mhasta;    
return true;}
function Carga_Arch(){var mcod_arch; var f=document.form1;  var mtipo_arch='<?echo $tipo_arch_banco?>';
  mcod_arch=f.txtcod_arch_banco.value;   document.location ='Gen_archivo_fpj.php?cod_arch_banco='+mcod_arch;
return true;}
function revisa(){var f=document.form1; var Valido=true;  
  if(f.txtfecha_desde.value.length==10){valido=true;}else{alert("Longitud Fecha desde Invalida");return false;}
  if(f.txtfecha_desde.value.length==10){valido=true;}else{alert("Longitud Fecha hasta Invalida");return false;}
 //document.form1.submit;
return true;}
</script>
</head>
<?
$cod_emp="00000000";  $fecha_dep=$fecha_hoy; $fecha_desde=colocar_pdiames($fecha_hoy); $fecha_hasta=colocar_udiames($fecha_hoy);   
$cod_concepto=""; $denominacion_concep=""; $accion="T";$cod_conceptod=""; $cod_conceptoh=""; $denominacion_concep_d=""; $denominacion_concep_h=""; $acciond="T"; $accionh="T";
$hora = getdate(time()); $hora_dep=$hora["hours"] . ":" . $hora["minutes"] . ":" . $hora["seconds"];  $hora_dep = date ( "h:i:s");
$sql="select * from nom045 where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco='$cod_arch_banco')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $den_arch_banco=$registro["den_arch_banco"]; $cod_emp=$registro["cod_empresa"];
$cod_conceptod=$registro["cod_concepto1"]; $cod_conceptoh=$registro["cod_concepto2"]; $cod_concepto=$registro["cod_concepto3"];
$accion=$registro["cod_nomina_arch"]; $acciond=$registro["medio_envio"]; $acciond=$registro["cod_moneda"];}
$sql="SELECT cod_concepto,denominacion FROM nom002 where cod_concepto='$cod_conceptod'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_concep_d=$registro["denominacion"];}
$sql="SELECT cod_concepto,denominacion FROM nom002 where cod_concepto='$cod_conceptoh'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_concep_h=$registro["denominacion"];}
pg_close();?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR ARCHIVO CAJA DE AHORRO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="560" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="Genera_arch_caya.php"  target="popup" onsubmit="return revisa(); window.open('', 'popup')" >
       <div id="Layer1" style="position:absolute; width:940px; height:540px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           
          
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="226"><span class="Estilo5">FECHA PROCESO NOMINA DESDE  :</span></td>
				   <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"   onchange="checkrefecha(this.form)" value="<?echo $fecha_desde?>"> </span></td>
                   <td width="100"><span class="Estilo5">HASTA :</span></td>
                   <td width="500"><span class="Estilo5"><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $fecha_hasta?>"> </span></td>
                   
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="946" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="200" align="left" class="Estilo5">CONCEPTO APORTE EMPLEADO :</td>
                 <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_d" type="text" id="txtcod_concepto_d" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_conceptod?>"> </span></td>
                 <td width="43" align="left"><span class="Estilo5"><input class="Estilo10" name="Catalogod" type="button" id="Catalogod" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('Cat_conceptosd.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
                 <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="txtacciond" type="text" id="txtacciond" onFocus="encender(this)" onBlur="apagar(this)" size="1" maxlength="1" value="<?echo $acciond?>"> </span></td>
                 <td width="600" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_d" type="text" id="txtdenominacion_d" size="60" maxlength="100" readonly value="<?echo $denominacion_concep_d?>"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="946" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="200" align="left" class="Estilo5">CONCEPTO APORTE PATRONAL :</td>
                 <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_h" type="text" id="txtcod_concepto_h" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_conceptoh?>"></span></td>
                 <td width="43" align="left"><span class="Estilo5"><input class="Estilo10" name="Catalogoh" type="button" id="Catalogoh" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('Cat_conceptosh.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="txtaccionh" type="text" id="txtaccionh" onFocus="encender(this)" onBlur="apagar(this)" size="1" maxlength="1" value="<?echo $accionh?>"> </span></td>
                 <td width="600" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_h" type="text" id="txtdenominacion_h" size="60" maxlength="100" readonly value="<?echo $denominacion_concep_h?>"> </span></td>
               </tr>
             </table></td>
           </tr>
		   
           <tr> <td>&nbsp;</td> </tr>
         </table>
         <div id="T11" align="center" class="tab-body">
         <iframe src="Det_nomina_arch_banco.php?criterio=<?echo $criterio?>" width="770" height="300" scrolling="auto" frameborder="1"></iframe>
         </div>
         <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="20"><input class="Estilo10" name="txttipo_arch_banco" type="hidden" id="txttipo_arch_banco" value="<?echo $tipo_arch_banco?>"></td>
            <td width="20"><input name="txtcod_arch_banco" type="hidden" id="txtcod_arch_banco" value="<?echo $cod_arch_banco?>"></td>
            <td width="200">&nbsp;</td>
            <td width="250" align="center" valign="middle"><input name="Procesar" type="submit" id="Procesar"  value="Procesar Archivo" title="Procesar Archivo" ></td>
            <td width="250" align="center"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
            <td width="220">&nbsp;</td>
          </tr>
        </table>

       </div>
      </form>
    </td>

  </tr>
</table>
</body>
</html>