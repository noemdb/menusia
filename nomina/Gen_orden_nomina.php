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
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Generar Informacion Orden de Pago - Nominas Calculadas)</title>
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
function Carga_Nom(){var mcod_est; var f=document.form1;  var mtp_calculo;  var mtipoc;
  mcod_est=f.txtcod_estructura.value; mtp_calculo=f.txttipo_calculo.value;  document.location ='Gen_orden_nomina.php?criterio='+mtp_calculo+mcod_est;
return true;}
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec; } return true;}

function revisa(){var f=document.form1; var Valido=true;
   if(f.txtcod_estructura.value==""){alert("Codigo de Estructura no puede estar Vacio");return false;}
   if(f.txtfecha_hasta.value.length==10){valido=true;}else{alert("Longitud Fecha proceso Invalida");return false;}
   if(f.txtcod_estructura.value.length==8){valido=true;}else{alert("Longitud Codigo de Estructura Invalida");return false;}
 document.form1.submit;
return true;}

function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 

</script>

</head>
<?
$des_estructura=""; $fecha_hasta=$fecha_hoy; $tipo_pago="DEPOSITO"; $status=""; $tipo_comp_est=""; $ref_comp_est=""; $num_periodos="1";
$sql="SELECT descripcion_est,nro_documento,status FROM PAG006 Where (cod_estructura='$cod_estructura')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $des_estructura=$registro["descripcion_est"]; $tipo_pago=$registro["nro_documento"]; $status=$registro["status"]; }
if($tp_calculo=="N"){$sql="SELECT tipo_nomina,descripcion,bloqueada,bloqueada_ext FROM NOM001 WHERE ((cod_relac_nom='$cod_estructura') or (cod_relac_apo='$cod_estructura') or (cod_relac_ext='$cod_estructura') or (cod_relac_vac='$cod_estructura')) order by tipo_nomina";}
 else{$sql="SELECT tipo_nomina,descripcion,bloqueada,bloqueada_ext FROM NOM001 WHERE (cod_relac_ext='$cod_estructura') or (cod_relac_apo='$cod_estructura') order by tipo_nomina";} $res=pg_query($sql);
 if($registro=pg_fetch_array($res,0)){ $tipo_nomina=$registro["tipo_nomina"]; $StrSQL="SELECT fecha_p_hasta,monto,num_periodos FROM NOM017 Where (tipo_nomina='$tipo_nomina') And (tp_calculo='$tp_calculo')"; $result=pg_query($StrSQL);
 if($reg=pg_fetch_array($result,0)){ $fecha_hasta=$reg["fecha_p_hasta"];  $num_periodos=$reg["num_periodos"]; $fecha_hasta=formato_ddmmaaaa($fecha_hasta); } }
if(($status=="")or($status=="S")){ $sql="SELECT ref_comp_est, tipo_comp_est,tipo_imput_presu, ref_imput_presu FROM PAG009 Where (cod_estructura='$cod_estructura' and monto_est>0 and ref_comp_est<>'00000000' and ref_comp_est<>'')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $ref_comp_est=$registro["ref_comp_est"]; $tipo_comp_est=$registro["tipo_comp_est"]; $status="S"; }
} 

$status="N";
 pg_close(); $criterio=$tp_calculo.$cod_estructura;
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR INFORMACI&Oacute;N ORDEN DE PAGO - N&Oacute;MINAS CALCULADAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="560" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="Genera_orden_nomina.php"  onsubmit="return revisa();" >
       <div id="Layer1" style="position:absolute; width:940px; height:540px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="226"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA DE ORDEN:</span></td>
                   <td width="100" ><span class="Estilo5"> <input class="Estilo10" name="txtcod_estructura" type="text" id="txtcod_estructura" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_estructura?>" > </span></td>
                   <td width="320"><input class="Estilo10" name="bttiponom" type="button" id="btcodarch" title="Abrir Catalogo Estructura de Orden"  onClick="VentanaCentrada('Cat_estructura_nom.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="300" align="center"><input class="Estilo10" name="btcargar" type="button" id="btcargar" title="Cargar" onclick="javascript:Carga_Nom()" value="Cargar Nominas"></td>
                  </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="96"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                   <td width="650"><span class="Estilo5"> <input class="Estilo10" name="txtdes_estructura" type="text" id="txtdes_estructura" size="120" maxlength="120" readonly value="<?echo $des_estructura?>" > </span></td>
                 </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_tipo_calculo(mvalor){var f=document.form1;  if(mvalor=="N"){document.form1.txttipo_calculo.options[0].selected = true;}else{document.form1.txttipo_calculo.options[1].selected = true;}}
function asig_tipo_pago(mvalor){var f=document.form1;  if(mvalor=="DEPOSITO"){document.form1.txttipo_pago.options[1].selected = true;} if(mvalor=="CHEQUE"){document.form1.txttipo_pago.options[2].selected = true;}}
function asig_ref_comp(mvalor){var f=document.form1;  if(mvalor=="S"){document.form1.txtref_comp.options[1].selected = true;}else{document.form1.txtref_comp.options[0].selected = true;}}
</script>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="130"><span class="Estilo5">TIPO DE CALCULO  :</span></td>
                   <td width="160"><span class="Estilo5"><select class="Estilo10" name="txttipo_calculo" size="1" id="txttipo_calculo"><option value='N' selected>NORMAL</option>  <option value='E'>EXTRAORDINARIA</option> </select> </span></td>
                   <td width="50"><span class="Estilo5"><input name="txtnum_periodos" type="text" id="txtnum_periodos" size="1" maxlength="1" value="<?echo $num_periodos?>" onFocus="encender(this)" onBlur="apagar(this)" title="Num. Calculo para Nominas Extrordinaria" onKeypress="return validarNum(event)"> </span></td>
		
				   <td width="100"><span class="Estilo5">NOMINA :</span></td>
                   <td width="150"><span class="Estilo5"><select class="Estilo10" name="txttipo_nom" size="1" id="txttipo_nom"><option selected>ACTUAL</option>  <option>HISTORICO</option> </select> </span></td>
                   
				   <td width="200"><span class="Estilo5">FECHA PROCESO NOMINA HASTA  :</span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $fecha_hasta?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="946">
                 <tr>
				   <td width="146"><span class="Estilo5">TIPO DE PAGO  :</span></td>
                   <td width="140"><span class="Estilo5"><select class="Estilo10" name="txttipo_pago" size="1" id="txttipo_pago"> <option>TODOS</option>  <option>DEPOSITO</option>  <option>CHEQUE</option> </select> </span></td>
                 
                   <td width="180"><span class="Estilo5">DETALLE DE TRABAJADORES  :</span></td>
                   <td width="130"><span class="Estilo5"><select class="Estilo10" name="txtdet_trab" size="1" id="txtdet_trab"><option selected>NO</option>  <option >SI</option> </select> </span></td>
                  
				   <td width="180"  align="left" class="Estilo5">CONCEPTOS DE CALCULO :</td>
				   <td width="150" align="left"><span class="Estilo5"><select class="Estilo10" name="txtconcepto_t" size="1" id="txtconcepto_t"><option value='NOMINA' selected>NOMINA</option><option value='VACACIONES'>VACACIONES</option><option value='TODOS'>TODOS</option></select></span></td>
                    
				</tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="946">
                 <tr>				  
                   <td width="156"><span class="Estilo5">REFIERE A COMPROMISO :</span></td>
                   <td width="100"><span class="Estilo5"><select class="Estilo10" name="txtref_comp" size="1" id="txtref_comp"><option selected>NO</option>  <option >SI</option> </select> </span></td>
                   <td width="160"><span class="Estilo5">DOCUMENTO COMPROMISO:</span></td>
				   <td width="45"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" size="6" maxlength="4" onFocus="encender(this);" onBlur="apagar(this)"  value="<?echo $tipo_comp_est?>" onkeypress="return stabular(event,this)"></td>
				   <td width="45"><span class="Estilo5"><input name="btdoc_comp" type="button" id="btdoc_comp" title="Abrir Catalogo Documentos Compromiso" onClick="VentanaCentrada('../presupuesto/Cat_doc_comp.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
				   <td width="100"><span class="Estilo5"><input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" size="6" readonly onkeypress="return stabular(event,this)">   </span></td>
				   <td width="90"><span class="Estilo5">REFERENCIA :</span> </td>
				   <td width="100"><div id="refer"><input name="txtreferencia_comp" type="text" id="txtreferencia_comp" size="12" maxlength="8" onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $ref_comp_est?>" onkeypress="return stabular(event,this)"></div></td>
 				</tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript"> asig_tipo_calculo('<?echo $tp_calculo;?>'); asig_tipo_pago('<?echo $tipo_pago;?>');  asig_ref_comp('<?echo $status;?>');  </script>
           <tr> <td>&nbsp;</td> </tr>
         </table>
         <div id="T11" align="center" class="tab-body">
         <iframe src="Det_nomina_est_orden.php?criterio=<?echo $criterio?>" width="770" height="300" scrolling="auto" frameborder="1"></iframe>
         </div>
         <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="20"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="200">&nbsp;</td>
            <td width="250" align="center" valign="middle"><input name="Procesar" type="submit" id="Procesar"  value="Procesar Inf. Orden" title="Procesar Orden" ></td>
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