<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php"); $planilla="";
$equipo = getenv("COMPUTERNAME"); $mcod_m = "BAN012".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); 
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname.""); 
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="02-0000018"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Planillas de Retenci&oacute;n)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK  href="../class/sia.css" type=text/css rel=stylesheet>
<script language=JavaScript src="../class/sia.js" type=text/javascript></script>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
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
function checkorden(mform){var mref;
   mref=mform.txtnro_orden.value; mref = Rellenarizq(mref,"0",8);  mform.txtnro_orden.value=mref;
return true;}
function Cargar_Ret(mform){var mref;
   mref=mform.txtnro_orden.value;
   ajaxSenddoc('GET', 'cargaretorden.php?criterio='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML');
return true;}
function chequea_planilla(mform){var mref;
   mref=mform.txtplanilla.value;   mref = Rellenarizq(mref,"0",2);   mform.txtplanilla.value=mref;
return true;}
function llamar_impimir(){var murl;var f=document.form1; var tipo_p; var orden;
  tipo_p=f.txtplanilla.value;  orden=f.txtnro_orden.value;
  murl='/sia/pagos/rpt/Rpt_planilla_ret.php?&orden='+orden+'&tipo='+tipo_p;  window.open(murl);
}
</script>
</head>
<?
$resultado=pg_exec($conn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
pg_close();?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">PLANILLAS DE RETENCI&Oacute;N RESP</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="540" border="1" id="tablacuerpo">
  <tr>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:945px; height:491px; z-index:1; top: 71px; left: 20px;">
        <form name="form1" method="post">
          <table width="922" border="0" >
                <tr>
                  <td width="916" height="14"><table width="910">
                    <tr>
                      <td width="156"><span class="Estilo5">N&Uacute;MERO DE ORDEN : </span></td>
                      <td width="77"><span class="Estilo5"><input name="txtnro_orden" type="text" id="txtnro_orden" size="8" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" onchange="checkorden(this.form);"> </span></td>
                      <td width="91"><input name="btordenes" type="button" id="btordenes" title="Catalogo Ordenes de Pago" onClick="VentanaCentrada('Cat_ord_pago.php?criterio=','SIA','','750','500','true')" value="..."> </td>
                      <td width="92"><span class="Estilo5">FECHA ORDEN:</span></td>
                      <td width="279"><span class="Estilo5"> <input name="txtfecha" type="text" id="txtfecha" size="10" maxlength="10" readonly></span></td>
                      <td width="187"><span class="Estilo5"> <input type="button" name="btcarga_ret" value="Cargar Retenciones" title="Cargar Retenciones de la Orden de pago" onClick="javascript:Cargar_Ret(this.form)" > </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="924" border="0">
                <tr>
                  <td width="918"><table width="910" >
                    <tr>
                      <td width="156"><span class="Estilo5"> CED./RIF BENEFICIARIO  :</span></span></td>
                      <td width="105"><span class="Estilo5"><input name="txtced_rif" type="text" id="txtced_rif" size="12" maxlength="12" readonly></span></td>
                      <td width="629"><span class="Estilo5"> <input name="txtnombre" type="text" id="txtnombre" size="80" readonly>
                        </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td> </tr>
              </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_ret_planillas.php?codigo_mov=<?echo $codigo_mov?>" width="940" height="350" scrolling="auto" frameborder="1"></iframe>
              </div>
         <table width="863" border="0"> <tr> <td height="10">&nbsp;</td> </tr> </table>
        <table width="923">
          <tr>
            <td width="366"> <table width="360" border="1">
               <tr>
                <td><table width="350" border="0" cellpadding="4" cellspacing="2">
                  <tr>
                     <td width="200"><span class="Estilo5">TIPO DE PLANILLA IMPRIMIR:</span></td>
                     <td width="50"><span class="Estilo5"><input name="txtplanilla" type="text" id="txtplanilla" title="Registre el tipo de Planilla a imprimir" value="<? echo $planilla ?>"  size="2" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_planilla(this.form);">  </span></td>
                     <?if ($Mcamino{4}=="S"){?>
					 <td width="100"><input name="Imprimir" type="button" id="Imprimir" value="Imprimir" onClick="JavaScript:llamar_impimir()"></td>
                     <?} ?>
                   </tr>
                </table></td>
               </tr>
            </table></td>
			
            <td width="110"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="139"><input name="Submit" type="reset" value="Blanquear"></td>
            <td width="142" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
			
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>