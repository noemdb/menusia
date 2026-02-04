<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");
$equipo=getenv("COMPUTERNAME"); $codigo_mov="PAG066".$usuario_sia.$equipo;   $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$criterio="N";}else{$criterio=$_GET["criterio"];}   $tp_calculo=substr($criterio,0,1); $cod_estructura=substr($criterio,1,8); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="04-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Generar Informacion Orden de Pago - Nominas con Contratos)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK  href="../class/sia.css" type=text/css rel=stylesheet>
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

</script>
<script language="JavaScript" type="text/JavaScript">
function Calcula_nom(){var mtipo; var f=document.form1; var valido; var r;
   mtipo=f.txttipo_nomina.value;
   if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacia");return false;}   
   r=confirm("Desea Cargar la Estructura de Nomina ?"); 
    if(r==true){ajaxSenddoc('GET', 'llamaestcont.php?tipo_nomina='+mtipo,'T11', 'innerHTML');}
return true;}
</script>

</head>
<?
$tipo_nomina="03"; $descripcion=""; $cod_estructura="";
$sql="Select * from NOM001 where tipo_nomina='$tipo_nomina'"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $tipo_nomina=$registro["tipo_nomina"];  $descripcion=$registro["descripcion"]; $cod_estructura=$registro["cod_relac_nom"]; }
pg_close(); $criterio=$cod_estructura; ?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR INFORMACI&Oacute;N ORDEN DE PAGO - N&Oacute;MINAS CON CONTRATOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="560" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post"   >
       <div id="Layer1" style="position:absolute; width:940px; height:540px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="150"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="60"><span class="Estilo5"> <input name="txttipo_nomina" type="text" id="txttipo_nomina" size="3" maxlength="2" onFocus="encender(this)" onBlur="apaga_tipo(this)" value="<?echo $tipo_nomina?>" > </span></td>
                   <td width="50"><input name="bttiponom" type="button" id="bttiponom" title="Abrir Catalogo Tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="705"><span class="Estilo5"> <input name="txtdes_nomina" type="text" id="txtdes_nomina" size="100" maxlength="100" readonly value="<?echo $descripcion?>" > </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
         </table>
         <div id="T11" align="center" class="tab-body">
		   <iframe src="Det_cod_presupuestarios_nom_cal.php?codigo_mov=<?echo $criterio?>"  width="900" height="400" scrolling="auto" frameborder="1"> </iframe>
          
         </div>
         <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="20"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="200">&nbsp;</td>
			<td width="250" align="center"><input name="Procesar" type="button" id="Procesar" title="Procesar Inf. Orden" onclick="javascript:Calcula_nom()" value="Procesar Inf. Orden"></td>
            
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