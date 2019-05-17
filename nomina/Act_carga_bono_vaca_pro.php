<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); $cod_modulo="04";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN"; $cod_modulo="04";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000065"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo=getenv("COMPUTERNAME"); $mcod_m = "NOM011".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $tipo_nomina="01"; $cod_concepto=""; $criterio="";  $descripcion=""; $denominacion="";
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="00";}else{$temp_nomina=$gnomina; $tipo_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
$sql="SELECT * FROM NOM001 ".$criterion." Order by tipo_nomina"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){  $registro=pg_fetch_array($res,0);   $tipo_nomina=$registro["tipo_nomina"];  $descripcion=$registro["descripcion"]; $cod_concepto=$registro["con_bon_vac"]; }  
$sql="Select * from conceptos where tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){  $registro=pg_fetch_array($res,0);  $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  }
$campo502="NNNNNNNNNNNNNNNNNNN"; $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; }
/* */
if (substr($campo502,15,1)=="N"){$error=0;} else{?><script language="JavaScript"> document.location='menu.php';</script><?}
//echo substr($campo502,15,1)." ".$campo502;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL N&Oacute;MINA Y PERSONAL (Actualiza Carga Bono Vacacional)</title>
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
var mcodigo_mov='<?php echo $codigo_mov ?>';
var mtemp_nomina='<?php echo $temp_nomina ?>';
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_nomina.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina.value=mref;
return true;}
function apaga_tipo(mthis){
var mtipo;  apagar(mthis); mtipo=mthis.value;
   ajaxSenddoc('GET', 'cfechacargb.php?tipo_nomina='+mtipo+'&ope=E'+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'dnomina', 'innerHTML');
return true;}
function chequea_concepto(mform){ var mref;
 mref=mform.txtcod_concepto.value; mref = Rellenarizq(mref,"0",3); mform.txtcod_concepto.value=mref;
return true;}
function Carga_procesar(){var mtipo; var fdesde; var fhasta; var mcod;  var valido; var r;  var f=document.form1; 
   mtipo=f.txttipo_nomina.value; fdesde=f.txtfecha_desde.value; fhasta=f.txtfecha_hasta.value; mcod=f.txtcod_concepto.value;
   if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacia");return false;}
   if(f.txtfecha_desde.value==""){alert("Fecha desde no puede estar Vacia");return false;}
   if(f.txtfecha_hasta.value==""){alert("Fecha hasta no puede estar Vacia");return false;}
   if(f.txttipo_nomina.value.length==2){valido=true;}else{alert("Longitud Tipo de Nomina Invalida");return false;}
   if(f.txtfecha_desde.value.length==10){valido=true;}else{alert("Longitud de Fecha desde Invalida");return false;}
   if(f.txtfecha_hasta.value.length==10){valido=true;}else{alert("Longitud de Fecha hasta Invalida");return false;}
   if(mtemp_nomina!="00"){ if(mtemp_nomina!=f.txttipo_nomina.value){alert("TIPO DE NOMINA NO ACTIVA PARA EL USUARIO");return false;}  }
   r=confirm("Desea Cargar Bono Vacacional ?"); if(r==true){ajaxSenddoc('GET', 'cargabonovac.php?tipo_nomina='+mtipo+'&fdesde='+fdesde+'&fhasta='+fhasta+'&codigo_mov='+mcodigo_mov+'&conc_bono='+mcod, 'T11', 'innerHTML');}

return true;}
</script>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CARGA BONO VACACIONAL</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="560" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:940px; height:540px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="150"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="60"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="3" maxlength="2" onFocus="encender(this)" onBlur="apaga_tipo(this)" onchange="chequea_tipo(this.form);" value="<?echo $tipo_nomina?>"> </span></td>
                   <td width="50"><input class="Estilo10" name="bttiponom" type="button" id="bttiponom" title="Abrir Catalogo Tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="705"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="100" maxlength="100" readonly value="<?echo $descripcion?>" > </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="166"><span class="Estilo5">C&Oacute;DIGO DE CONCEPTO : </span></td>
                   <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_concepto(this.form);" value="<?echo $cod_concepto?>"> </span></td>
                   <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="btconcepto" title="Abrir Catalogo Conceptos"  onClick="VentanaCentrada('Cat_conceptos.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                   <td width="550"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="55" maxlength="80" readonly value="<?echo $denominacion?>"> </span></td>
                   <td width="20"><span class="Estilo5"></td>
                 </tr>
             </table></td>
            </tr>
			<tr>
             <td><div id="dnomina"><table width="946">
                 <tr>
                   <td width="106"><span class="Estilo5">FECHA DESDE : </span></td>
                   <td width="120"><span class="Estilo5"><input name="txtfecha_desde" type="text" id="txtfecha_desde"  size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                   <td width="100"><span class="Estilo5">FECHA HASTA : </span></td>
                   <td width="130"><span class="Estilo5"> <input name="txtfecha_hasta" type="text" id="txtfecha_hasta"  size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                   <td width="250"><span class="Estilo5"></span></td>
                   <td width="240"><span class="Estilo5"> </span></td>
				 
				 </tr>
             </table></div></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
         </table>
         <div id="T11" class="tab-body">
         <iframe src="Det_carga_bono_vac.php?criterio=<?echo $criterio?>" width="950" height="350" scrolling="auto" frameborder="1"></iframe>
         </div>
         <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="40"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="150">&nbsp;</td>
			<td width="150"><input name="btProcesar" type="button" id="btProcesar" title="Procesar Carga  Bono Vacacional" onclick="javascript:Carga_procesar()" value="Procesar"></td>
            <td width="150">&nbsp;</td>
			<td width="150"><input name="Submit" type="reset" value="Blanquear"></td>
            <td width="150">&nbsp;</td>
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