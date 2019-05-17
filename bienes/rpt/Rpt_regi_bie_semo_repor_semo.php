<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="03-0000138"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$cod_bien_semd=""; $cod_bien_semh="";   $cod_empresad=""; $cod_empresah=""; $cod_dependenciad=""; $cod_dependenciah=""; $cod_direcciond=""; $cod_direccionh=""; $cod_departamentod=""; $cod_departamentoh=""; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Reportes Listado De Bienes Muebles)</title>
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
function Llama_Rpt_regi_bie_semo_repor(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Registro de Bienes Semovientes?");
  if (r==true){url=murl+"?&cod_bien_semd="+document.form1.txtcod_bien_sem_d.value+"&cod_bien_semh="+document.form1.txtcod_bien_sem_h.value+
"&cod_empresad="+document.form1.txtcod_empresad.value+"&cod_empresah="+document.form1.txtcod_empresah.value+
"&cod_dependenciad="+document.form1.txtcod_dependenciad.value+"&cod_dependenciah="+document.form1.txtcod_dependenciah.value+
"&cod_direcciond="+document.form1.txtcod_direcciond.value+"&cod_direccionh="+document.form1.txtcod_direccionh.value+
"&cod_departamentod="+document.form1.txtcod_departamentod.value+"&cod_departamentoh="+document.form1.txtcod_departamentoh.value;
  window.open(url,"Reporte Registro de Bienes Semovientes")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?
//BIENES MUEBLES
$sql="SELECT MAX(cod_bien_sem) As Max_cod_bien_sem, MIN(cod_bien_sem) As Min_cod_bien_sem FROM bien016";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_bien_semd=$registro["min_cod_bien_sem"];$cod_bien_semh=$registro["max_cod_bien_sem"];}
//EMPRESAS
$sql="SELECT MAX(cod_empresa) As Max_cod_empresa, MIN(cod_empresa) As Min_cod_empresa FROM bien007";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_empresad=$registro["min_cod_empresa"];$cod_empresah=$registro["max_cod_empresa"];}
//DEPENDENCIAS
$sql="SELECT MAX(cod_dependencia) As Max_cod_dependencia, MIN(cod_dependencia) As Min_cod_dependencia FROM bien001";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_dependenciad=$registro["min_cod_dependencia"];$cod_dependenciah=$registro["max_cod_dependencia"];}
//DIRECCIONES
$sql="SELECT MAX(cod_direccion) As Max_cod_direccion, MIN(cod_direccion) As Min_cod_direccion FROM bien005";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_direcciond=$registro["min_cod_direccion"];$cod_direccionh=$registro["max_cod_direccion"];}
//DEPARTAMENTOS
$sql="SELECT MAX(cod_departamento) As Max_cod_departamento, MIN(cod_departamento) As Min_cod_departamento FROM bien006";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_departamentod=$registro["min_cod_departamento"];$cod_departamentoh=$registro["max_cod_departamento"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE REGISTRO DE SEMOVIENES </div></td>
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
             <td><table width="963">
               <tr>
                 <td width="323" scope="col"><div align="left"></div></td>
                 <td width="220" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">DESDE</span></span></span></div></td>
                 <td width="122" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="Estilo12">HASTA</span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="278" scope="col"><div align="left"><span class="Estilo5">                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="231" scope="col"><div align="right"><span class="Estilo5">COD. SEMOVIENTE :</span></div></td>
                 <td width="350" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcod_bien_sem_d" type="text" class="Estilo5" id="txtcod_bien_sem_d" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?echo $cod_bien_semd?>">
                    <strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo de Bienes Muebles" onClick="VentanaCentrada('Cat_bienes_semovientesd.php?criterio=','SIA','','750','500','true')" value="...">
                   </strong></strong></span> </span></span></div></td>
                 <td width="460" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="txtcod_bien_sem_h" type="text" class="Estilo5" id="txtcod_bien_sem_h" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?echo $cod_bien_semh?>">
                    <strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo de Bienes Muebles" onClick="VentanaCentrada('Cat_bienes_semovientesh.php?criterio=','SIA','','750','500','true')" value="...">
                   </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="326" scope="col"><div align="right"><span class="Estilo5">C&Oacute;DIGO DE EMPRESA :</span></div></td>
                 <td width="350" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcod_empresad" type="text" class="Estilo5" id="txtcod_empresad" size="5" maxlength="3"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?echo $cod_empresad?>">
                    <strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo de Bienes Inmuebles" onClick="VentanaCentrada('Cat_empresasd.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> </span></span></div></td>
                 <td width="400" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="txtcod_empresah" type="text" class="Estilo5" id="txtcod_empresah" size="5" maxlength="3"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?echo $cod_empresah?>">
                    <strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo de Bienes Inmuebles" onClick="VentanaCentrada('Cat_empresash.php?criterio=','SIA','','750','500','true')" value="...">
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
                 <td width="320" scope="col"><div align="right"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></div></td>
                 <td width="350" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcod_direcciond" type="text" class="Estilo5" id="txtcod_direcciond" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="4" class="Estilo5" value="<?echo $cod_direcciond?>" >
                   <span class="menu"><strong><strong>
                   <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_direcciond.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> </span></span></div></td>
                 <td width="400" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                  <input name="txtcod_direccionh" type="text" class="Estilo5" id="txtcod_direccionh" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="4" class="Estilo5" value="<?echo $cod_direccionh?>" >
                   <strong><strong><strong><strong>
                   <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_direccionh.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="320" scope="col"><div align="right"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></div></td>
                 <td width="350" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_departamentod" type="text" class="Estilo5" id="txtcod_departamentod" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?echo $cod_departamentod?>">
                     <span class="menu"><strong><strong>
                   <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_departamentod.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> </span></span></div></td>
                 <td width="400" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                     <input name="txtcod_departamentoh" type="text" class="Estilo5" id="txtcod_departamentoh" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?echo $cod_departamentoh?>">
                     <strong><strong><strong><strong>
                   <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_departamentoh.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr align="center" valign="middle">
                 <td>
                   <div align="center">
                     <input name="btgenera2" type="button" id="btgenera22" value="GENERAR" onClick="javascript:Llama_Rpt_regi_bie_semo_repor('Rpt_regi_bie_semo_repor.php');">
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
