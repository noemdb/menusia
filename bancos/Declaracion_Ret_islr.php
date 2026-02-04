<?php  include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "DECISLR".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else{ $Nom_Emp=busca_conf(); }
$nombre_emp=$Nom_Emp; $ced_rif_emp=$Rif_Emp;  $fecha_hoy=asigna_fecha_hoy();  $ano=substr($fecha_hoy,6,4);  $mes=substr($fecha_hoy,3,2); $desde="01".substr($fecha_hoy,2,8); $hasta=colocar_udiames($fecha_hoy);
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000068"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO  (Declaracion Retenci&oacute;n ISLR)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<link href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
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
function checkano(mform){var mano;
   mano=mform.txtano.value; mano=Rellenarizq(mano,"0",4);  mform.txtano.value=mano;
return true;}
function checkmes(mform){
var mmes;  var mano; var mdesde; var mhasta; var mdia;
   mmes=mform.txtmes.value;  mmes=Rellenarizq(mmes,"0",2); mform.txtmes.value=mmes;
   mano=mform.txtano.value; mdesde="01/"+mmes+"/"+mano; mform.txtfecha_desde.value=mdesde; 
   mdia="31"; if(mmes=="02"){mdia="28";} if((mmes=="04")||(mmes=="06")||(mmes=="09")||(mmes=="11")){mdia="30";}
   mhasta=mdia+"/"+mmes+"/"+mano; mform.txtfecha_hasta.value=mhasta;
true;}
function Cargar_Ret(mform){var mmes;  var mano; var mdesde; var mhasta; var valido=0; var temp; var temp2; var magrupar; var magtipo; var mtipo_comp;
   mmes=mform.txtmes.value; mano=mform.txtano.value; mdesde= mform.txtfecha_desde.value; mhasta=mform.txtfecha_hasta.value; temp=mhasta; temp2=mhasta; temp=temp.charAt(3)+temp.charAt(4); temp2=temp2.charAt(6)+temp2.charAt(7)+temp2.charAt(8)+temp2.charAt(9);
   if((temp!=mmes)||(temp2!=mano)){valido=1; alert('Fecha hasta Invalida');} temp=mdesde;
   temp2=mdesde;  temp=temp.charAt(3)+temp.charAt(4); temp2=temp2.charAt(6)+temp2.charAt(7)+temp2.charAt(8)+temp2.charAt(9);
   if((temp!=mmes)||(temp2!=mano)){valido=1; alert('Fecha desde Invalida');}
   magrupar=mform.txtagrupa.value; magtipo=mform.txtagtipo.value;  mtipo_comp=mform.txttipo_comp.value;
   if(valido==0){   ajaxSenddoc('GET', 'cargacompislr.php?ano='+mano+'&mes='+mmes+'&desde='+mdesde+'&hasta='+mhasta+'&agrupar='+magrupar+'&agtipo='+magtipo+'&tipo_comp='+mtipo_comp+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML'); }
return true;}
</script>
</head>
<?php  $resultado=pg_exec($conn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); $tipo_ret="01"; $des_ret="";
$sql="Select * from ban011 where codigo='$tipo_ret'"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $codigo=$registro["codigo"]; $des_ret=$registro["descripcion"];$nro_planilla=$registro["nro_planilla"];$formato_planilla=$registro["formato_planilla"]; $formato_relacion=$registro["formato_relacion"]; }
pg_close($conn); ?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DECLARACI&Oacute;N RETENCI&Oacute;N ISLR</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="510" border="1" id="tablacuerpo">
   <tr>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:976px; height:491px; z-index:1; top: 62px; left: 18px;">
         <form name="form1" method="post" action="Graba_dec_islr.php"  target="popup" onsubmit="window.open('', 'popup')" > 
          <table width="959" border="0" >
                <tr>
                  <td height="14"><table width="939" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="140"><span class="Estilo5">TIPO DE RETENCION: </span></td>
					  <td width="79"><span class="Estilo5"><input class="Estilo10" name="txttipo_ret" type="text" id="txttipo_ret" size="3" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $tipo_ret?>"></span></td>
                      <td width="720"><span class="Estilo5"><input class="Estilo10" name="txtdes_ret" type="text" id="txtdes_ret" size="100" maxlength="100"  readonly value="<?php echo $des_ret?>"> </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="961" border="0">
                <tr>
                  <td width="950"><table width="934" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="104"><span class="Estilo5">PERIODO A&Ntilde;O  :</span></td>
                      <td width="71"><span class="Estilo5"><input class="Estilo10" name="txtano" type="text" id="txtano" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)" onchange="checkano(this.form);" value="<?php echo $ano?>"> </span></td>
                      <td width="62"><span class="Estilo5">MES :</span></td>
                      <td width="78"><span class="Estilo5"><input class="Estilo10" name="txtmes" type="text" id="txtmes" size="3" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" onchange="checkmes(this.form);" value="<?php echo $mes?>"></span></td>
                      <td width="91"><span class="Estilo5">FECHA DESDE :</span></td>
                      <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $desde?>"></span></td>
                      <td width="95"><span class="Estilo5">FECHA HASTA  :</span></td>
                      <td width="103"><span class="Estilo5"><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $hasta?>"></span></td>
                      <td width="100"><span class="Estilo5">COMPROBANTES:</span></td>
					  <td width="100"><span class="Estilo5"><Select name="txttipo_comp" size="1" id="txttipo_comp"><option>TODOS</option>  <option>ORDEN CANCELADA</option> <option>CHEQUE ENTREGADO</option> </Select> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td><table width="946" border="0">
                  <tr>
                    <td width="180"><span class="Estilo5">AGRUPAR POR BENEFICIARIO:</td>
					<td width="100"><span class="Estilo5"><select class="Estilo10" name="txtagrupa" size="1" id="txtagrupa" onFocus="encender(this)" onBlur="apagar(this)">  <option>SI</option> <option>NO</option></select>  </span></td>
					<td width="130"><span class="Estilo5">AGRUPAR POR TIPO:</td>
					<td width="90"><span class="Estilo5"><select class="Estilo10" name="txtagtipo" size="1" id="txtagtipo" onFocus="encender(this)" onBlur="apagar(this)"> <option>NO</option> <option>SI</option></select>  </span></td>
					<td width="120"><span class="Estilo5">TIPO DE FORMATO  :</span></td>
                    <td width="80"><span class="Estilo5"><Select name="txttipo_formato" size="1" id="txttipo_formato"><option>EXCEL</option>  <option>TXT</option> </Select> </span></td>
                    <td width="240" align="center" valign="middle"> <input class="Estilo10" name="btCargar" type="button" id="btCargar" value="Generar" title="Generar Declaracion de Retenciones" onClick="javascript:Cargar_Ret(this.form)" >   </td>
                  </tr>
                </table>
                </tr>
          </table>
          <div id="T11" class="tab-body"><iframe src="Det_dec_ret_islr.php?codigo_mov=<?php echo $codigo_mov?>" width="940" height="350" scrolling="auto" frameborder="1"></iframe> </div>
          <table width="962" border="0">
          <tr> <td height="10">&nbsp;</td> </tr> </table>
          <table width="923">
            <tr>
              <td width="526"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
               <td width="100" align="center" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
              <td width="140" align="center" valign="middle"><input name="Blanqueas" type="reset" value="Blanquear"></td>
              <td width="140" align="center" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
            </tr>
          </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>