<?include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php");
$equipo=getenv("COMPUTERNAME"); $mcod_m="CNOM018".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$tipo_nomina="01"; $cod_concepto="001"; $criterio=""; $fecha_hoy=asigna_fecha_hoy();  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000035"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
pg_close(); if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="00";}else{$temp_nomina=$gnomina; $tipo_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Cierre de Nomina)</title>
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
function apaga_tipo(mthis){var mtipo; var mtp_cal; var mtp; var f=document.form1; nper=f.txtnum_periodos.value; apagar(mthis); mtipo=mthis.value;
   mtp_cal=document.form1.txttipo_calculo.value;  mtp=mtp_cal.substring (0,1);  if(mtp=="O"){mtp_cal="N";}else {mtp_cal="E";}
   ajaxSenddoc('GET', 'cnomcalculada.php?tipo_nomina='+mtipo+'&tp_calculo='+mtp_cal+'&num_periodos='+nper+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'dnomina', 'innerHTML');
return true;}
function apaga_tp_cal(mthis){var mtipo; var mtp_cal; var mtp; var f=document.form1; nper=f.txtnum_periodos.value; apagar(mthis); mtp_cal=mthis.value;
   mtp_cal=document.form1.txttipo_calculo.value;  mtp=mtp_cal.substring (0,1);  if(mtp=="O"){mtp_cal="N";}else {mtp_cal="E";}    mtipo=document.form1.txttipo_nomina.value;
   ajaxSenddoc('GET', 'cnomcalculada.php?tipo_nomina='+mtipo+'&tp_calculo='+mtp_cal+'&num_periodos='+nper+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'dnomina', 'innerHTML');
return true;}

function apaga_num_per(mthis){var mtipo; var mtp_cal; var mtp;  apagar(mthis); nper=mthis.value;
   mtp_cal=document.form1.txttipo_calculo.value;   mtp=mtp_cal.substring (0,1);  if(mtp=="O"){mtp_cal="N";}else {mtp_cal="E";}    mtipo=document.form1.txttipo_nomina.value;
   ajaxSenddoc('GET', 'cnomcalculada.php?tipo_nomina='+mtipo+'&tp_calculo='+mtp_cal+'&num_periodos='+nper+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'dnomina', 'innerHTML');
return true;}
function Cierra_nom(){
var mtipo; var fdesde; var fhasta;  var f=document.form1; var valido; var r;   var mtp_cal;  var mmens; var nper=f.txtnum_periodos.value;
   mtipo=f.txttipo_nomina.value; fdesde=f.txtfecha_desde.value; fhasta=f.txtfecha_hasta.value;  mtp_cal=document.form1.txttipo_calculo.value;  mtp=mtp_cal.substring (0,1);
   if(mtp=="O"){mmens="Esta Realmente Seguro en Cerrar la Nomina ?";mtp_cal="N";}else{mmens="Esta Realmente Seguro en Cerrar la Nomina EXTRAORDINARIA ?";mtp_cal="E";}
   if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacia");return false;}
   if(f.txtfecha_desde.value==""){alert("Fecha desde no puede estar Vacia");return false;}
   if(f.txtfecha_hasta.value==""){alert("Fecha hasta no puede estar Vacia");return false;}
   if(f.txttipo_nomina.value.length==2){valido=true;}else{alert("Longitud Tipo de Nomina Invalida");return false;}
   if(f.txtfecha_desde.value.length==10){valido=true;}else{alert("Longitud de Fecha desde Invalida");return false;}
   if(f.txtfecha_hasta.value.length==10){valido=true;}else{alert("Longitud de Fecha hasta Invalida");return false;}
   if(mtemp_nomina!="00"){ if(mtemp_nomina!=f.txttipo_nomina.value){alert("TIPO DE NOMINA NO ACTIVA PARA EL USUARIO");return false;}  }
   r=confirm("Desea Cerrar la Nomina ?"); if(r==true){r=confirm(mmens); if(r==true){url="llamacierre.php?tipo_nomina="+mtipo+'&tp_calculo='+mtp_cal+'&num_periodos='+nper; VentanaCentrada(url,'Cierre de Nomina','','600','400','true');} }
return true;}
function tabular(e,obj) {
  tecla=(document.all) ? e.keyCode : e.which;
  if(tecla!=13) return;  frm=obj.form;  
  for(i=0;i<frm.elements.length;i++) if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }
  frm.elements[i+1].focus();
return false;} 
</script>

</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CIERRE DE N&Oacute;MINA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="360" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:940px; height:340px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="150"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="60"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="3" maxlength="2" onFocus="encender(this)" onBlur="apaga_tipo(this)" onchange="chequea_tipo(this.form);" value="<?echo $tipo_nomina?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="50"><input class="Estilo10" name="bttiponom" type="button" id="bttiponom" title="Abrir Catalogo Tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="705"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="100" maxlength="100" readonly > </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="946">
                 <tr>
				    <td width="100"><span class="Estilo5">NUM. CALCULO : </span></td>
				    <td width="200"><span class="Estilo5"><input name="txtnum_periodos" type="text" id="txtnum_periodos" size="1" maxlength="1" value="1" onFocus="encender(this)" onBlur="apaga_num_per(this)" onKeypress="return validarNum(event)"> </span></td>
                    <td width="150"><span class="Estilo5">TIPO DE CALCULO :</span></td>
                    <td width="396"><span class="Estilo5"><select class="Estilo10" name="txttipo_calculo" size="1" id="txttipo_concepto" onFocus="encender(this)" onBlur="apaga_tp_cal(this)">
                      <option>ORDINARIO</option> <option>EXTRAORINARIO</option> </select>  </span></td>
                    <td width="100"><span class="Estilo5"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><div id="dnomina"><table width="946">
                 <tr>
                   <td width="190"><span class="Estilo5">FECHA PROCESO DESDE : </span></td>
                   <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde"  size="10" maxlength="10" readonly> </span></td>
                   <td width="190"><span class="Estilo5">FECHA PROCESO HASTA : </span></td>
                   <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta"  size="10" maxlength="10" readonly> </span></td>
                   </tr>
             </table></div></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
         </table>
        <div id="Layer4" style="position:absolute; width:940px; height:30px; z-index:2; left: 3px; top: 285px;">
        <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="170"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="300" align="center"><input name="btcalcular" type="button" id="btcalcular" title="Cerrar Nomina" onclick="javascript:Cierra_nom()" value="Cerrar Nomina"></td>
            <td width="300" align="center"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
            <td width="170"><input name="txtcodigo_m" type="hidden" id="txtcodigo_m" value="<?echo $codigo_mov?>"></td>
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