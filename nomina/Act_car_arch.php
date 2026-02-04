<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000015"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo=getenv("COMPUTERNAME"); $mcod_m = "NOM011".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$tipo_nomina="01"; $cod_concepto="001"; $criterio=""; $nombre_arch="";
if (isset($_GET['nombre_arch'])) { $nombre_arch=$_GET["nombre_arch"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Actualiza Carga Montos de Conceptos Manual)</title>
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
function chequea_tipo(mform){
var mref;
   mref=mform.txttipo_nomina.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina.value=mref;
return true;}
function chequea_concepto(mform){ var mref;
 mref=mform.txtcod_concepto.value; mref = Rellenarizq(mref,"0",3); mform.txtcod_concepto.value=mref;
return true;}
function Cargar_Arch(mform){var mcod; var mtipo; var mnomb; var mcol1; var mcol2; var mcamb; var mbuscarp;
   mtipo=mform.txttipo_nomina.value; mcod=mform.txtcod_concepto.value; mnomb=mform.txtnomb_arch.value;   mbuscarp=mform.txtbucar_por.value;
   mcol1=mform.txtcol_ced.value; mcol2=mform.txtcol_val.value; mcamb=mform.txtcan_monto.value;
   ajaxSenddoc('GET', 'cargaarch.php?tipo_nomina='+mtipo+'&cod_concepto='+mcod+'&nombre_arch='+mnomb+'&col1='+mcol1+'&col2='+mcol2+'&cambia='+mcamb+'&buscarp='+mbuscarp, 'T11', 'innerHTML');
return true;}
</script>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CARGA MONTOS DE CONCEPTOS POR ARCHIVO TEXTO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="620" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" >
       <div id="Layer1" style="position:absolute; width:940px; height:590px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="150"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="60"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="3" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_tipo(this.form);"> </span></td>
                   <td width="50"><input class="Estilo10" name="bttiponom" type="button" id="bttiponom" title="Abrir Catalogo Tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="705"><span class="Estilo5"><input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="100" maxlength="100" readonly > </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="166"><span class="Estilo5">C&Oacute;DIGO DE CONCEPTO : </span></td>
                   <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_concepto(this.form);"> </span></td>
                   <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="btconcepto" title="Abrir Catalogo Conceptos"  onClick="VentanaCentrada('Cat_conceptos.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                   <td width="570"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="55" maxlength="80" readonly> </span></td>
                      </tr>
             </table></td>
            </tr>
			
			<tr>
             <td><table width="946">
                 <tr>
                   <td width="286"><span class="Estilo5">NOMBRE DEL ARCHIVO (DELIMITADO POR ";") : </span></td>
				   <? if($nombre_arch==""){ ?>
                   <td width="600"><span class="Estilo5"> <input class="Estilo10" name="txtnomb_arch" type="text" id="txtnomb_arch" size="65" maxlength="80" value="<?echo $nombre_arch?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
				   <? }else{ ?>
					<td width="600"><span class="Estilo5"> <input class="Estilo10" name="txtnomb_arch" type="text" id="txtnomb_arch" size="65" maxlength="80" value="<?echo $nombre_arch?>" readonly> </span></td>
				   <? } ?>
				   <td width="60"></span></td>
              
                 </tr>
             </table></td>
           </tr>
		   
		   <tr>
             <td><table width="946">
                 <tr>
                   <td width="100"><span class="Estilo5">BUSCAR POR :</span></td>
				   <td width="246"><span class="Estilo5"><select name="txtbucar_por" size="1" id="txtbucar_por" onFocus="encender(this)" onBlur="apagar(this)"> <option>CODIGO</option> <option>CEDULA</option></select>  </span></td>
                   <td width="200"><span class="Estilo5"></span></td>
				   <td width="200"><span class="Estilo5">CAMBIAR CANTIDAD O MONTO : </span></td>
                   <td width="200"><span class="Estilo5"><select name="txtcan_monto" size="1" id="txtcan_monto" onFocus="encender(this)" onBlur="apagar(this)"><option>MONTO</option> <option>CANTIDAD</option></select>  </span></td>
                 </tr>
             </table></td>
           </tr>
		   
		   
		   <tr>
             <td><table width="946">
                 <tr>
                   <td width="270"><span class="Estilo5">COLUMNA CEDULA/CODIGO TRABAJADOR :</span></td>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtcol_ced" type="text" id="txtcol_ced" size="2" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" value="1" > </span></td>
                   <td width="200"><span class="Estilo5">COLUMNA VALOR A CAMBIAR :</span></td>
                   <td width="146"><span class="Estilo5"> <input class="Estilo10" name="txtcol_val" type="text" id="txtcol_val" size="2" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" value="2" > </span></td>
                   <td width="200"><span class="Estilo5"><input type="button" name="btcarga_arch" value="Cargar Archivo" title="Cargar Valores del Concepto" onClick="javascript:Cargar_Arch(this.form)" ></span></td>
                </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
         </table>
         <div id="T11" class="tab-body">
         <iframe src="Det_carga_manual.php?criterio=<?echo $criterio?>" width="950" height="350" scrolling="auto" frameborder="1"></iframe>
         </div>
         <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="100"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="450"></td>
            <td width="150"><input name="Submit" type="reset" value="Blanquear"></td>
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