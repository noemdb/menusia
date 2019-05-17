<?include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php");
$equipo=getenv("COMPUTERNAME"); $codigo_mov="PAG066".$usuario_sia.$equipo;   $fecha_hoy=asigna_fecha_hoy(); $tipo_arch='07';
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
<title>SIA N&Oacute;MINA Y PERSONAL (Generar Informacion Orden de Pago - Aportes)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type=text/css rel=stylesheet>
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
  mcod_est=f.txtcod_estructura.value; mtp_calculo=f.txttipo_calculo.value;  document.location ='Gen_orden_aporte.php?criterio='+mtp_calculo+mcod_est;
return true;}
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec; } return true;}

function revisa(){var f=document.form1; var Valido=true;
   if(f.txtcod_estructura.value==""){alert("Codigo de Estructura no puede estar Vacio");return false;}
   if(f.txtfecha_desde.value.length==10){valido=true;}else{alert("Longitud Fecha Desde Invalida");return false;}
   if(f.txtfecha_hasta.value.length==10){valido=true;}else{alert("Longitud Fecha hasta Invalida");return false;}
   if(f.txtcod_estructura.value.length==8){valido=true;}else{alert("Longitud Codigo de Estructura Invalida");return false;}
 document.form1.submit;
return true;}
</script>
</head>
<?
$des_estructura=""; $tipo_nomina=""; $fecha_hasta=colocar_udiames($fecha_hoy); $fecha_desde=colocar_pdiames($fecha_hoy); $tipo_pago="DEPOSITO"; $cod_arch = "070000"; $cod_concepto=""; $den_concepto="";
$sql="SELECT descripcion_est,nro_documento FROM PAG006 Where (cod_estructura='$cod_estructura')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){$des_estructura=$registro["descripcion_est"]; $cod_concepto=$registro["nro_documento"]; $cod_arch=substr($cod_estructura,2,6);}


$sql="Select tipo_nomina from nom046 where (Cod_Arch_Banco='$cod_arch') and (tipo_arch_banco='$tipo_arch')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $tipo_nomina=$registro["tipo_nomina"]; $StrSQL="Select fecha_p_desde,fecha_p_hasta,monto from nom017 Where (Tipo_Nomina='$tipo_nomina') And (Tp_Calculo='$tp_calculo')"; $result=pg_query($StrSQL);
if($reg=pg_fetch_array($result,0)){ $fecha_hasta=$reg["fecha_p_hasta"];   $fecha_hasta=formato_ddmmaaaa($fecha_hasta);  $fecha_desde=$reg["fecha_p_desde"];   $fecha_desde=formato_ddmmaaaa($fecha_desde); } } 

$sql="SELECT tipo_nomina,cod_concepto,denominacion from nom002 where tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $res=pg_query($sql); 
   if($registro=pg_fetch_array($res,0)){$den_concepto=$registro["denominacion"];}
   
pg_close(); $criterio=$tipo_arch.$cod_arch; ?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR INFORMACI&Oacute;N ORDEN DE PAGO - APORTES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="560" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="Genera_orden_aporte.php"  onsubmit="return revisa();" >
       <div id="Layer1" style="position:absolute; width:940px; height:540px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="226"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA DE ORDEN:</span></td>
                   <td width="100" ><span class="Estilo5"> <input class="Estilo10" name="txtcod_estructura" type="text" id="txtcod_estructura" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_estructura?>" > </span></td>
                   <td width="320"><input class="Estilo10" name="bttiponom" type="button" id="btcodarch" title="Abrir Catalogo Estructura de Orden"  onClick="VentanaCentrada('Cat_estructura_aporte.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
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
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="206"><span class="Estilo5">C&Oacute;DIGO DE CONCEPTO APORTE : </span></td>
                   <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_a" type="text" id="txtcod_concepto_a" size="4" maxlength="4" onFocus="encender(this)" onBlur="apaga_concepto(this)" value="<?echo $cod_concepto?>" > </span></td>
                   <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="btconcepto" title="Abrir Catalogo Conceptos"  onClick="VentanaCentrada('Cat_conceptos_apo.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="550"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion_a" type="text" id="txtdenominacion_a" size="75" maxlength="75" value="<?echo $den_concepto?>" readonly> </span></td>
                 </tr>
             </table></td>
            </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_tipo_calculo(mvalor){var f=document.form1;  if(mvalor=="N"){document.form1.txttipo_calculo.options[0].selected = true;}else{document.form1.txttipo_calculo.options[1].selected = true;}}
</script>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="136"><span class="Estilo5">TIPO DE CALCULO  :</span></td>
                   <td width="180"><span class="Estilo5"><select class="Estilo10" name="txttipo_calculo" size="1" id="txttipo_calculo"><option value='N' selected>NORMAL</option>  <option value='E'>EXTRAORDINARIA</option> <option value='T'>TODOS</option> </select> </span></td>
                   <td width="200"><span class="Estilo5">FECHA PROCESO NOMINA DESDE  :</span></td>
                   <td width="180"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $fecha_desde?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                   <td width="70"><span class="Estilo5">HASTA  :</span></td>
                   <td width="180"><span class="Estilo5"><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $fecha_hasta?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>

                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="946">
                 <tr>
				  
                   <td width="156"><span class="Estilo5">REFIERE A COMPROMISO :</span></td>
                   <td width="790"><span class="Estilo5"><select class="Estilo10" name="txtref_comp" size="1" id="txtref_comp"><option selected>NO</option>  <option >SI</option> </select> </span></td>
                  
				</tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript"> asig_tipo_calculo('<?echo $tp_calculo;?>'); </script>
           <tr> <td>&nbsp;</td> </tr>
         </table>
         <div id="T11" align="center" class="tab-body">
         <iframe src="Det_nomina_arch_banco.php?criterio=<?echo $criterio?>" width="770" height="300" scrolling="auto" frameborder="1"></iframe>
         </div>
         <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="20"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="20"><input name="txtcriterio" type="hidden" id="txtcriterio" value="<?echo $criterio?>"></td>
            <td width="200">&nbsp;</td>
            <td width="250" align="center" valign="middle"><input name="Procesar" type="submit" id="Procesar"  value="Procesar Inf. Orden" title="Procesar Orden" ></td>
            <td width="250" align="center"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
            <td width="200">&nbsp;</td>
          </tr>
        </table>
       </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>