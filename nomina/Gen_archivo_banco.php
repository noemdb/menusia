<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME"); $fecha_hoy=asigna_fecha_hoy();  $tipo_arch_banco='96';
if (!$_GET){$cod_arch_banco=""; $tipo_arch_banco="96";}else{$cod_arch_banco=$_GET["cod_arch_banco"];} $criterio=$tipo_arch_banco.$cod_arch_banco;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="04-0000015"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Generar Archivo de Banco)</title>
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
var patronfecha = new Array(2,2,4);
function Carga_Arch(){var mcod_arch; var f=document.form1;  var mtipo_arch='<?echo $tipo_arch_banco?>';
  mcod_arch=f.txtcod_arch_banco.value;   document.location ='Gen_archivo_banco.php?cod_arch_banco='+mcod_arch;
return true;}
function Procesar_Archivo(){var murl; var mcod_arch; var f=document.form1;  var mtipo_arch='<?echo $tipo_arch_banco?>';
  mcod_arch=f.txtcod_arch_banco.value;  murl="Desea Generar el Archivo ?"; r=confirm(murl);
  if(r==true){murl="Genera_arch_banco.php?cod_arch_banco="+mcod_arch+"&tipo_arch_banco=<?echo $tipo_arch_banco?>"; document.location=murl;}
return true;}
function revisa(){var f=document.form1; var Valido=true;
   if(f.txtcod_arch_banco.value==""){alert("Codigo de Archivo no puede estar Vacio");return false;}
   if(f.txttipo_arch_banco.value==""){alert("Tipo de Archivo no puede estar Vacio");return false;}
   if(f.txtcod_cta_emp.value==""){alert("Cuenta no puede estar Vacio");return false;}
   if(f.txtfecha_hasta.value.length==10){valido=true;}else{alert("Longitud Fecha proceso Invalida");return false;}
   if(f.txtcod_arch_banco.value.length==6){valido=true;}else{alert("Longitud Codigo de Archivo Invalida");return false;}
 //document.form1.submit;
return true;}
</script>
</head>
<?
$den_arch_banco=""; $cod_cta_emp="";  $fecha_hasta=$fecha_hoy; $fecha_dep=$fecha_hoy;  $num_quinc=1; $num_periodos="1";
$hora = getdate(time()); $hora_dep=$hora["hours"] . ":" . $hora["minutes"] . ":" . $hora["seconds"];  $hora_dep = date ( "h:i:s");
$sql="SELECT den_arch_banco,cod_cta_emp FROM nom045 where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco='$cod_arch_banco')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $den_arch_banco=$registro["den_arch_banco"]; $cod_cta_emp=$registro["cod_cta_emp"];}
$sql="SELECT tipo_nomina FROM NOM046 where (Cod_Arch_Banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $tipo_nomina=$registro["tipo_nomina"]; $StrSQL="SELECT fecha_p_hasta,monto FROM NOM017 Where (tipo_nomina='$tipo_nomina') And (tp_calculo='N')"; $result=pg_query($StrSQL);
 if($reg=pg_fetch_array($result,0)){ $fecha_hasta=$reg["fecha_p_hasta"];   $fecha_hasta=formato_ddmmaaaa($fecha_hasta); } }
pg_close();?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR ARCHIVO DE BANCO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="560" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="Genera_arch_banco.php"  target="popup" onsubmit="return revisa(); window.open('', 'popup')" >
       <div id="Layer1" style="position:absolute; width:940px; height:540px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="80"><span class="Estilo5">C&Oacute;DIGO:</span></td>
                   <td width="66" ><span class="Estilo5"> <input class="Estilo10" name="txtcod_arch_banco" type="text" id="txtcod_arch_banco" size="10" maxlength="6"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_arch_banco?>" > </span></td>
                   <td width="50"><input class="Estilo10" name="bttiponom" type="button" id="btcodarch" title="Abrir Catalogo Codigo de Archivo"  onClick="VentanaCentrada('Cat_arch_banco.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="650"><span class="Estilo5"> <input class="Estilo10" name="txtden_arch_banco" type="text" id="txtden_arch_banco" size="100" maxlength="100" readonly value="<?echo $den_arch_banco?>" > </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="180"><span class="Estilo5">NUMERO CUENTA EMPRESA  :</span></td>
                   <td width="226"><span class="Estilo5"><input class="Estilo10" name="txtcod_cta_emp" type="text" id="txtcod_cta_emp" size="30" maxlength="30"  readonly value="<?echo $cod_cta_emp?>"> </span></td>
                   <td width="140"><span class="Estilo5">TIPO DE CALCULO  :</span></td>
                   <td width="100"><span class="Estilo5"><select class="Estilo10" name="txttipo_calculo" size="1" id="txttipo_calculo"><option value='N' selected>NORMAL</option>  <option value='E'>EXTRAORDINARIA</option> </select> </span></td>
                   <td width="50"><span class="Estilo5"><input name="txtnum_periodos" type="text" id="txtnum_periodos" size="1" maxlength="1" value="<?echo $num_periodos?>" onFocus="encender(this)" onBlur="apagar(this)" title="Num. Calculo para Nominas Extrordinaria" onKeypress="return validarNum(event)"> </span></td>
		
				   <td width="250" align="center"><input class="Estilo10" name="btcargar" type="button" id="btcargar" title="Cargar" onclick="javascript:Carga_Arch()" value="Cargar Archivo"></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="216"><span class="Estilo5">FECHA PROCESO NOMINA HASTA  :</span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  onkeyup="mascara(this,'/',patronfecha,true)" value="<?echo $fecha_hasta?>"> </span></td>
                   <td width="60"><span class="Estilo5">NOMINA :</span></td>
                   <td width="150"><span class="Estilo5"><select class="Estilo10" name="txttipo_nom" size="1" id="txttipo_nom"><option selected>ACTUAL</option>  <option>HISTORICO</option> </select> </span></td>
                   <td width="120"><span class="Estilo5">FECHA DEPOSITO  :</span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtfecha_dep" type="text" id="txtfecha_dep" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)"  value="<?echo $fecha_dep?>"> </span></td>
                   <td width="50"><span class="Estilo5">HORA :</span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txthora_dep" type="text" id="txthora_dep" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $hora_dep?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="220"><span class="Estilo5">EN NOMINA MENSUAL FRACCIONAR  :</span></td>
                   <td width="100"><span class="Estilo5"><select class="Estilo10" name="txtfrac_nom" size="1" id="txtfrac_nom" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                   <td width="296"><span class="Estilo5">NUMERO DE QUINCENA PARA NOMINA MENSUAL :</span></td>
                   <td width="100" ><span class="Estilo5"> <input class="Estilo10" name="txtnum_quinc" type="text" id="txtnum_quinc" size="2" maxlength="1"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $num_quinc?>" > </span></td>
                   <td width="130"><span class="Estilo5">TIPO DE FORMATO  :</span></td>
                   <td width="100"><span class="Estilo5"><select class="Estilo10" name="txttipo_formato" size="1" id="txttipo_formato"><option>LINEAL</option>  <option>TABULADO</option> <option>TXT</option> <option>EXCEL</option>  </select> </span></td>
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="946">
                 <tr>
                   <td width="220"  align="left" class="Estilo5">CONCEPTOS DE CALCULO :</td>
				   <td width="150" align="left"><span class="Estilo5"><select class="Estilo10" name="txtconcepto_t" size="1" id="txtconcepto_t"><option value='NOMINA' selected>NOMINA</option><option value='VACACIONES'>VACACIONES</option><option value='TODOS'>TODOS</option></select></span></td>
<!--				   
				   <td width="146"><span class="Estilo5">TIPO DE SALIDA  :</span></td>
                   <td width="430"><span class="Estilo5"><Select class="Estilo10" name="txttipo_salida" size="1" id="txttipo_salida"><option>HTML</option> <option>TXT</option>  </Select> </span></td>
				   <td width="576"><span class="Estilo5"></span></td>
-->                 
				  
				  
				 <td width="131" align="left" class="Estilo5">FORMA DE PAGO :</td>
				 <td width="265" align="left"><span class="Estilo5"><select class="Estilo10" name="txtforma_pago" size="1" id="txtforma_pago">
                     <option selected value ='DEPOSITO'>DEPOSITO</option>
                     <option value ='EFECTIVO'>EFECTIVO</option> <option value ='CHEQUE'>CHEQUE</option> <option value ='RECIBO'>RECIBO</option> </select> </span></td> 
					 
				 <td width="100"><span class="Estilo5">ORDENAR POR  :</span></td>
                 <td width="100"><span class="Estilo5"><select class="Estilo10" name="txtordenar" size="1" id="txtordenar">   <option>CEDULA</option> <option>DEPARTAMENTO</option> </select> </span></td>
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
            <td width="20"><input name="txttipo_arch_banco" type="hidden" id="txttipo_arch_banco" value="<?echo $tipo_arch_banco?>"></td>
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