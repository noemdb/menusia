<? include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo=getenv("COMPUTERNAME"); $mcod_m="BAN013".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if(pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000065"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if($SIA_Cierre=="N"){$error=0;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Actualiza Impuesto Enterado)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_ban.js" type="text/javascript"></script>
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
function chequea_planilla(mform){var mref;
   mref=mform.txttipo_planilla.value; mref = Rellenarizq(mref,"0",2);  mform.txttipo_planilla.value=mref;
   ajaxSenddoc('GET', 'desplanilla2.php?codigo='+mref+'&codigo_mov=<?echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'desplan', 'innerHTML');
  return true;}
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia.value; mref = Rellenarizq(mref,"0",8);  mform.txtreferencia.value=mref;
return true;}
function chequea_planillad(mform){var mref;
   mref=mform.txtplanilla_desde.value; mref = Rellenarizq(mref,"0",8);  mform.txtplanilla_desde.value=mref;
return true;}
function chequea_planillah(mform){var mref;
   mref=mform.txtplanilla_hasta.value; mref = Rellenarizq(mref,"0",8);  mform.txtplanilla_hasta.value=mref;
return true;}
function Cargar_Ret(mform){var mtipo; var mdesde; var mhasta; var fdesde; var fhasta;
   mdesde=mform.txtplanilla_desde.value; mhasta=mform.txtplanilla_hasta.value; mtipo=mform.txttipo_planilla.value; fdesde=mform.txtfecha_desde.value; fhasta=mform.txtfecha_hasta.value;
   ajaxSenddoc('GET', 'cargaplanret.php?tipo='+mtipo+'&pdesde='+mdesde+'&phasta='+mhasta+'&fdesde='+fdesde+'&fhasta='+fhasta+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML');
return true;}
</script>

</head>
<? $sfechad=formato_ddmmaaaa($Fec_Ini_Ejer); $sfechah=formato_ddmmaaaa($Fec_Fin_Ejer);
$resultado=pg_exec($conn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
pg_close();?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ACTUALIZA IMPUESTO ENTERADO POR PLANILLA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="491" border="1" id="tablacuerpo">
    <td width="970">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:953px; height:350px; z-index:1; top: 70px; left: 20px;">
        <form name="form1" method="post">
          <table width="953"  border="0">
               <tr>
                  <td width="947"><table width="947">
                    <tr>
                      <td width="120"><span class="Estilo5">TIPO DE PLANILLA :</span></td>
                      <td width="50"><span class="Estilo5"> <input class="Estilo10" name="txttipo_planilla" type="text" id="txttipo_planilla" size="4" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_planilla(this.form);" value="00" >  </span> </td>
                      <td width="600"><span class="Estilo5"><div id="desplan"><input class="Estilo10" name="txtdescripcion" type="text" id="txtdescripcion" size="80" readonly> </div></span></td>
                      <td width="153"><span class="Estilo5"><input type="button" name="btcarga_plan" value="Cargar Planillas" title="Cargar Planillas de Retenciones del Tipo" onClick="javascript:Cargar_Ret(this.form)" >  </span></td>
                                    </tr>
                  </table></td>
              </tr>
              <tr>
                 <td width="947"><table width="947">
                    <tr>
                      <td width="183"><span class="Estilo5">N&Uacute;MERO DE PLANILLA  DESDE :</span></td>
                      <td width="88"><span class="Estilo5"> <input class="Estilo10" name="txtplanilla_desde" type="text" id="txtplanilla_desde" size="8" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_planillad(this.form);" value="00000000">  </span> </td>
                      <td width="59"><span class="Estilo5">HASTA :</span></td>
                      <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtplanilla_hasta" type="text" id="txtplanilla_hasta" size="8" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_planillah(this.form);"  value="99999999">  </span> </td>
                      <td width="172"><span class="Estilo5">FECHA DE PLANILLA DESDE : </span></td>
                      <td width="91"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $sfechad?>">  </span> </td>
                      <td width="62"><span class="Estilo5">HASTA :</span></td>
                      <td width="102"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $sfechah?>">  </span> </td>
                   </tr>
                  </table></td>
              </tr>
         </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_ent_planillas.php?" width="940" height="350" scrolling="auto" frameborder="1"></iframe>
              </div>
          <table width="923">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="100"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="526"><input class="Estilo10" name="txtnro_cuenta" type="hidden" id="txtnro_cuenta"></td>
            <td width="139"><input class="Estilo10" name="Submit" type="reset" value="Blanquear"></td>
            <td width="142" valign="middle"><input class="Estilo10" name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>