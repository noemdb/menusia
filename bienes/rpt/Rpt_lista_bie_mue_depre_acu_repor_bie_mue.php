<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="03-0000132"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$cod_bien_mued=""; $cod_bien_mueh=""; $cod_dependenciad=""; $cod_dependenciah=""; $referencia_depd=""; $referencia_deph="";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Reportes Listado De Activos fijos y Depreciacion Acumulada)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){
var mref;
var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){
var mref;
var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_lista_bie_mue_depre_acu_repor_bie(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Listados de Activos Fijos y Depreciacion Acumulada?");
  if (r==true){url=murl+"?&cod_bien_mued="+document.form1.txtcod_bien_mue_d.value+"&cod_bien_mueh="+document.form1.txtcod_bien_mue_h.value+
"&cod_dependenciad="+document.form1.txtcod_dependenciad.value+"&cod_dependenciah="+document.form1.txtcod_dependenciah.value+
"&referencia_depd="+document.form1.txtreferencia_depd.value+"&referencia_deph="+document.form1.txtreferencia_deph.value+
"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value;
  window.open(url,"Reporte Listados Activos Fijos y Depreciacion Acumulada")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?
//BIENES MUEBLES
$sql="SELECT MAX(cod_bien_mue) As Max_cod_bien_mue, MIN(cod_bien_mue) As Min_cod_bien_mue FROM bien015";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_bien_mued=$registro["min_cod_bien_mue"];$cod_bien_mueh=$registro["max_cod_bien_mue"];}
//DEPENDENCIAS
$sql="SELECT MAX(cod_dependencia) As Max_cod_dependencia, MIN(cod_dependencia) As Min_cod_dependencia FROM bien001";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_dependenciad=$registro["min_cod_dependencia"];$cod_dependenciah=$registro["max_cod_dependencia"];}
//REFERENCIA
$sql="SELECT MAX(referencia_dep) As Max_referencia_dep, MIN(referencia_dep) As Min_referencia_dep FROM bien028";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$referencia_depd=$registro["min_referencia_dep"];$referencia_deph=$registro["max_referencia_dep"];}
//DEPARTAMENTOS
$sql="SELECT MAX(cod_departamento) As Max_cod_departamento, MIN(cod_departamento) As Min_cod_departamento FROM bien006";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_departamentod=$registro["min_cod_departamento"];$cod_departamentoh=$registro["max_cod_departamento"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO DE ACTIVOS FIJOS Y DEPRECIACI&Oacute;N ACUMULADA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="422" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="416">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:393px; z-index:1; top: 73px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="388" border="0">
    <tr>
      <td width="958" height="384" align="center" valign="top"><table width="783" height="274" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16"><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="150">&nbsp;</td>
              <td width="253"><span class="Estilo13">DESDE</span></td>
              <td width="354"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="231" scope="col"><div align="right"><span class="Estilo5">COD. BIEN MUEBLE :</span></div></td>
                 <td width="350" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcod_bien_inm_d" type="text" class="Estilo5" id="txtcod_bien_mue_d" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?echo $cod_bien_mued?>">
                    <strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo de Bienes Muebles" onClick="VentanaCentrada('Cat_bienes_mueblesd.php?criterio=','SIA','','750','500','true')" value="...">
                   </strong></strong></span> </span></span></div></td>
                 <td width="460" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="txtcod_bien_inm_h" type="text" class="Estilo5" id="txtcod_bien_mue_h" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?echo $cod_bien_mueh?>">
                    <strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo de Bienes Muebles" onClick="VentanaCentrada('Cat_bienes_mueblesh.php?criterio=','SIA','','750','500','true')" value="...">
                   </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="320" scope="col"><div align="right"><span class="Estilo5">COD. DEPENDENCIA :</span></div></td>
                 <td width="350" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcod_dependenciad" type="text" class="Estilo5" id="txtcod_dependenciad" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="4" class="Estilo5" value="<?echo $cod_dependenciad?>" >
                   <span class="menu"><strong><strong>
                   <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_dependenciasd.php?criterio=','SIA','','750','500','true')" value="...">
                   </strong></strong></span> </span></span></div></td>
                 <td width="400" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                  <input name="txtcod_dependenciah" type="text" class="Estilo5" id="txtcod_dependenciah" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="4" class="Estilo5" value="<?echo $cod_dependenciah?>">
                   <strong><strong><strong><strong>
                   <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_dependenciash.php?criterio=','SIA','','750','500','true')" value="...">
                   </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="261" scope="col"><div align="right"><span class="Estilo5">REFERENCIA DEPRECIACI&Oacute;N :</span></div></td>
                 <td width="236" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtreferencia_depd" type="text" class="Estilo5" id="txtreferencia_depd" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $referencia_depd?>">
                     <span class="menu"><strong><strong> </strong></strong></span> </span></span></div></td>
                 <td width="452" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                     <input name="txtreferencia_deph" type="text" class="Estilo5" id="txtreferencia_deph" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $referencia_deph?>">
                     <strong><strong><strong><strong> </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="262" scope="col"><div align="right"><span class="Estilo5">COD. CONT. ASOCIADO :</span></div></td>
                 <td width="237" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_contablea" type="text" class="Estilo5" id="txtcod_contablea" size="25" maxlength="25"  onFocus="encender(this)" onBlur="apagar(this)">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre2242222233" type="button" id="bttipo_codeingre2242222238" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> </span></span></div></td>
                 <td width="450" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                     <input name="txtcod_contabled" type="text" class="Estilo5" id="txtcod_contabled" size="25" maxlength="25"  onFocus="encender(this)" onBlur="apagar(this)">
                     <strong><strong><strong><strong>
                     <input name="bttipo_codeingre22422222223" type="button" id="bttipo_codeingre22422222228" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="262" scope="col"><div align="right"><span class="Estilo5">COD. CONT. DEPRECIACI&Oacute;N :</span></div></td>
                 <td width="237" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcode_ingre_mora22222332" type="text" class="Estilo5" id="txtcode_ingre_mora22222332" size="25" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222332" type="button" id="bttipo_codeingre22422222332" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> </span></span></div></td>
                 <td width="450" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                     <input name="txtcode_ingre_mora222222232" type="text" class="Estilo5" id="txtcode_ingre_mora222222232" size="25" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                     <strong><strong><strong><strong>
                     <input name="bttipo_codeingre224222222232" type="button" id="bttipo_codeingre224222222232" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="320" scope="col"><div align="right"><span class="Estilo5">FECHA INCORPORACION DESDE:</span></div></td>
                 <td width="350" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                     <input name="txtFechad" type="text" class="Estilo5" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" class="Estilo5" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
                 <td width="56" scope="col"><span class="Estilo5">HASTA :</span></td>
                 <td width="378" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtFechah" type="text" class="Estilo5" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" class="Estilo5" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr align="center" valign="middle">
                 <td>
                   <div align="center">
                     <input name="btgenera2" type="button" id="btgenera22" value="GENERAR" onClick="javascript:Llama_Rpt_lista_bie_mue_depre_acu_repor_bie('Rpt_lista_bie_mue_depre_acu_repor_bie.php');">
                 </div></td>
                 <td>
                   <div align="center">
                     <input name="btcancelar2" type="button" id="btcancelar22" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                 </div></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
       </div>
         </form>    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<? pg_close();?>
