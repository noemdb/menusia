<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$date = date("d/m/Y");
$num="01";
?>
  
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALESA (Incluir Ficha de Semovientes)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
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
function revisar(){
var f=document.form1;
    if(f.txtcod_clasificacion.value==""){alert("El Codigo Clasificacion no puede estar Vacio");return false;}else{f.txtcod_clasificacion.value=f.txtcod_clasificacion.value.toUpperCase();}
    if(f.txtnum_bien.value==""){alert("Numero del Bien no puede estar Vacio"); return false; } else{f.txtnum_bien.value=f.txtnum_bien.value.toUpperCase();}
    if(f.txtcod_bien_sem.value==""){alert("El Codigo del Bien Inmueble no puede estar Vacio");return false;}else{f.txtcod_bien_sem.value=f.txtcod_bien_sem.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Denominacion no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtcod_empresa.value==""){alert("El Codigo de la Empresa no puede estar Vacio");return false;}else{f.txtcod_empresa.value=f.txtcod_empresa.value.toUpperCase();}
    if(f.txtcod_direccion.value==""){alert("El Codigo de la Direccion no puede estar Vacia");return false;}else{f.txtcod_direccion.value=f.txtcod_direccion.value.toUpperCase();}
    if(f.txtcod_departamento.value==""){alert("El Codigo no puede estar Vacio");return false;}else{f.txtcod_departamento.value=f.txtcod_departamento.value.toUpperCase();}
    if(f.txtcod_dependencia.value==""){alert("El Codigo no puede estar Vacio");return false;}else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtced_responsable.value==""){alert("La Cedula del responsable no estar Vacia"); return false; } else{f.txtced_responsable.value=f.txtced_responsable.value.toUpperCase();}
    if(f.txtfecha_actualizacion.value==""){alert("La Fecha no estar Vacia"); return false; } else{f.txtfecha_actualizacion.value=f.txtfecha_actualizacion.value.toUpperCase();}
    if(f.txtced_res_uso.value==""){alert("La Cedula del responsable de uso no estar Vacia");return false;}else{f.txtced_res_uso.value=f.txtced_res_uso.value.toUpperCase();}
    if(f.txtcodigo_rotula.value==""){alert("El Codigo no puede estar Vacio");return false;}else{f.txtcodigo_rotula.value=f.txtcodigo_rotula.value.toUpperCase();} 
    if(f.txtced_res_rotu.value==""){alert("La Cedula del responsable no estar Vacia"); return false; } else{f.txtced_res_rotu.value=f.txtced_res_rotu.value.toUpperCase();}
    if(f.txtfecha_rotulacion.value==""){alert("La Cedula del responsable no estar Vacia"); return false; } else{f.txtfecha_rotulacion.value=f.txtfecha_rotulacion.value.toUpperCase();}
    if(f.txtdireccion.value==""){alert("La Direccion no estar Vacia"); return false; } else{f.txtdireccion.value=f.txtdireccion.value.toUpperCase();}
    if(f.txtcod_region.value==""){alert("Codigo Region no puede estar Vacio"); return false; } else{f.txtcod_region.value=f.txtcod_region.value.toUpperCase();}
    if(f.txtcod_entidad.value==""){alert("Codigo de la Entidad no puede estar Vacio"); return false; } else{f.txtcod_entidad.value=f.txtcod_entidad.value.toUpperCase();}
    if(f.txtcod_municipio.value==""){alert("Codigo del Municipio no puede estar Vacio"); return false; } else{f.txtcod_municipio.value=f.txtcod_municipio.value.toUpperCase();}
    if(f.txtcod_ciudad.value==""){alert("Codigo de la Ciudad no puede estar Vacio"); return false; } else{f.txtcod_ciudad.value=f.txtcod_ciudad.value.toUpperCase();}
    if(f.txtcod_parroquia.value==""){alert("Codigo de Parroquia no puede estar Vacio"); return false; } else{f.txtcod_parroquia.value=f.txtcod_parroquia.value.toUpperCase();}
    if(f.txtcod_postal.value==""){alert("El Codigo Postal no puede estar Vacio"); return false; } else{f.txtcod_postal.value=f.txtcod_postal.value.toUpperCase();}    
    if(f.txtraza.value==""){alert("El Codigo no puede estar Vacio");return false;}else{f.txtraza.value=f.txtraza.value.toUpperCase();}
    if(f.txtcolor.value==""){alert("Descripcion no puede estar Vacio");return false;}else{f.txtcolor.value=f.txtcolor.value.toUpperCase();} 
    if(f.txtsexo.value==""){alert("La marca no puede estar Vacio"); return false; } else{f.txtsexo.value=f.txtsexo.value.toUpperCase();}
    if(f.txtfecha_nacimiento.value==""){alert("El Modelo no puede estar Vacio"); return false; } else{f.txtfecha_nacimiento.value=f.txtfecha_nacimiento.value.toUpperCase();}
    if(f.txtedad.value==""){alert("El Color no puede estar Vacio"); return false; } else{f.txtedad.value=f.txtedad.value.toUpperCase();}
    if(f.txttam_peso.value==""){alert("La Matricula no puede estar Vacio"); return false; } else{f.txttam_peso.value=f.txttam_peso.value.toUpperCase();}
    if(f.txtuso.value==""){alert("El Material no puede estar Vacio"); return false; } else{f.txtuso.value=f.txtuso.value.toUpperCase();}
    if(f.txtcod_contablea.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtcod_contablea.value=f.txtcod_contablea.value.toUpperCase();}
    if(f.txtcod_contabled.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtcod_contabled.value=f.txtcod_contabled.value.toUpperCase();}
    if(f.txttipo_depreciacion.value==""){alert("El Tipo Depreciacion no puede estar Vacio"); return false; } else{f.txttipo_depreciacion.value=f.txttipo_depreciacion.value.toUpperCase();}
    if(f.txttasa_deprec.value==""){alert("La Tasa no puede estar Vacio"); return false; } else{f.txttasa_deprec.value=f.txttasa_deprec.value.toUpperCase();}
    if(f.txtvida_util.value==""){alert("El VIda util no puede estar Vacio"); return false; } else{f.txtvida_util.value=f.txtvida_util.value.toUpperCase();}
    if(f.txtvalor_residual.value==""){alert("El Valor Residual no puede estar Vacio"); return false; } else{f.txtvalor_residual.value=f.txtvalor_residual.value.toUpperCase();}
    if(f.txtcod_presup_dep.value==""){alert("El Valor Residual no puede estar Vacio"); return false; } else{f.txtcod_presup_dep.value=f.txtcod_presup_dep.value.toUpperCase();}
    if(f.txtmonto_depreciado.value==""){alert("El Valor Residual no puede estar Vacio"); return false; } else{f.txtmonto_depreciado.value=f.txtmonto_depreciado.value.toUpperCase();}
    if(f.txtdesincorporado.value==""){alert("El Tipo Depreciacion no puede estar Vacio"); return false; } else{f.txtdesincorporado.value=f.txtdesincorporado.value.toUpperCase();}
    if(f.txtfecha_desincorporado.value==""){alert("El Material no puede estar Vacio"); return false; } else{f.txtfecha_desincorporado.value=f.txtfecha_desincorporado.value.toUpperCase();}
    if(f.txtcodigo_situacont.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtcodigo_situacont.value=f.txtcodigo_situacont.value.toUpperCase();}
    if(f.txtcodigo_situalegal.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtcodigo_situalegal.value=f.txtcodigo_situalegal.value.toUpperCase();}
    if(f.txtced_res_verificador.value==""){alert("La Tasa no puede estar Vacio"); return false; } else{f.txtced_res_verificador.value=f.txtced_res_verificador.value.toUpperCase();}
    if(f.txtfecha_verificacion.value==""){alert("El VIda util no puede estar Vacio"); return false; } else{f.txtfecha_verificacion.value=f.txtfecha_verificacion.value.toUpperCase();}   
    if(f.txttipo_incorporacion.value==""){alert("El Material no puede estar Vacio"); return false; } else{f.txttipo_incorporacion.value=f.txttipo_incorporacion.value.toUpperCase();}
    if(f.txtcod_imp_presup.value==""){alert("El Material no puede estar Vacio"); return false; } else{f.txtcod_imp_presup.value=f.txtcod_imp_presup.value.toUpperCase();}
    if(f.txtnom_imp_presup.value==""){alert("El Material no puede estar Vacio"); return false; } else{f.txtnom_imp_presup.value=f.txtnom_imp_presup.value.toUpperCase();}
    if(f.txtdes_imp_nopresup.value==""){alert("El Tipo Depreciacion no puede estar Vacio"); return false; } else{f.txtdes_imp_nopresup.value=f.txtdes_imp_nopresup.value.toUpperCase();}    
    if(f.txtvalor_incorporacion.value==""){alert("El VIda util no puede estar Vacio"); return false; } else{f.txtvalor_incorporacion.value=f.txtvalor_incorporacion.value.toUpperCase();}
    if(f.txtfecha_incorporacion.value==""){alert("La Tasa no puede estar Vacio"); return false; } else{f.txtfecha_incorporacion.value=f.txtfecha_incorporacion.value.toUpperCase();}
    if(f.txtnro_oc.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtnro_oc.value=f.txtnro_oc.value.toUpperCase();}
    if(f.txtfecha_oc.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtfecha_oc.value=f.txtfecha_oc.value.toUpperCase();}
    if(f.txtnro_op.value==""){alert("El Tipo Depreciacion no puede estar Vacio"); return false; } else{f.txtnro_op.value=f.txtnro_op.value.toUpperCase();}
    if(f.txtfecha_op.value==""){alert("La Tasa no puede estar Vacio"); return false; } else{f.txtfecha_op.value=f.txtfecha_op.value.toUpperCase();}
    if(f.txttipo_doc_cancela.value==""){alert("El VIda util no puede estar Vacio"); return false; } else{f.txttipo_doc_cancela.value=f.txttipo_doc_cancela.value.toUpperCase();}
    if(f.txtnro_doc_cancela.value==""){alert("El Valor Residual no puede estar Vacio"); return false; } else{f.txtnro_doc_cancela.value=f.txtnro_doc_cancela.value.toUpperCase();}
    if(f.txtfecha_doc_cancela.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtfecha_doc_cancela.value=f.txtfecha_doc_cancela.value.toUpperCase();}
    if(f.txtnro_factura.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtnro_factura.value=f.txtnro_factura.value.toUpperCase();}
    if(f.txtfecha_factura.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtfecha_factura.value=f.txtfecha_factura.value.toUpperCase();}
    if(f.txtced_rif_proveedor.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtced_rif_proveedor.value=f.txtced_rif_proveedor.value.toUpperCase();}
    if(f.txtnombre_proveedor.value==""){alert("La Tasa no puede estar Vacio"); return false; } else{f.txtnombre_proveedor.value=f.txtnombre_proveedor.value.toUpperCase();}
document.form1.submit;
return true;}

</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo9 {font-size: 8pt}
.Estilo10 {font-size: 12px}
-->
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR FICHA DE SEMOVIENTES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="540" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92"><table width="92" height="1708" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_fichas_semovientes_pro.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_fichas_semovientes_pro.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Procesos </A></td>
      </tr>
  <td height="1622">&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:274px; z-index:1; top: 78px; left: 120px;">
            <form name="form1" method="post" action="Insert_fichas_semovientes_pro.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DE CLACIFICACI&Oacute;N:</span></div></td>
                <td width="150" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcod_clasificacion" type="text" id="txtcod_clasificacion" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_clasificaciond.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="719" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnom_clasificacion" type="text" id="txtnom_clasificacion" size="70" maxlength="250" readonly class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="160" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DEL BIEN :</span></div></td>
                <td width="350" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtnum_bien" type="text" id="txtnum_bien" size="25" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre22422222242" type="button" id="bttipo_codeingre22422222242" title="Abrir Catalogo Tipos de Orden" value="123...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEL BIEN MUEBLE :</span></div></td>
                <td width="605" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcod_bien_sem" type="text" id="txtcod_bien_sem" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">DENOMINACI&Oacute;N :</span></div></td>
                <td width="849" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtdenominacion" type="text" id="txtdenominacion" size="85" maxlength="250"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><span class="Estilo12">INFORMACI&Oacute;N</span></td>
          </tr>
          <tr>
            <td><table width="963">
             <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">CODIGO EMPRESA :</span></div></td>
                 <td width="90" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_empresa" type="text" id="txtcod_empresa" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Empresas" onClick="VentanaCentrada('Cat_empresasd.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_empresa" type="text" id="txtnombre_empresa" size="73" maxlength="250" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="821">
               <tr>
                 <td width="130" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_dependencia" type="text" id="txtcod_dependencia" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" size="5" maxlength="4">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_dependenciasd.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="575" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dependencia" type="text" id="txtdenominacion_dependencia" size="68" maxlength="250" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="821">
               <tr>
                 <td width="130" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DIRECCION :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_direccion" type="text" id="txtcod_direccion" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" size="5" maxlength="4">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Direcciones" onClick="VentanaCentrada('Cat_direccionesd.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="575" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="68" maxlength="250" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
            <tr>
             <td><table width="821">
               <tr>
                 <td width="140" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></div></td>
                 <td width="180" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_departamento" type="text" id="txtcod_departamento" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" size="10" maxlength="8">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Direcciones" onClick="VentanaCentrada('Cat_departamentosd.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="575" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_dep" type="text" id="txtnombre_dep" size="65" maxlength="250" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE PRIMARIOS:</span></div></td>
                <td width="200" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtced_responsable" type="text" id="txtced_responsable" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                               <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_responsablesd.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="98" scope="col"><div align="left"><span class="Estilo5">FECHA DE ACTUALIZACION:</span></div></td>
                <td width="555" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_actualizacion" type="text" id="txtfecha_actualizacion" size="15" maxlength="10" value="<?echo $date?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL RESPONSABLE:</span></div></td>
                <td width="858" scope="col"><div align="left"><span class="Estilo5">
                   <input name="txtnombre_responsabep" type="text" id="txtnombre_responsabep" size="50" maxlength="250" readonly class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <table width="828" align="center">
          <tr>
            <td><table width="900">
              <tr>
                <td width="100" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE DE USO:</span></div></td>
                <td width="160" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtced_res_uso" type="text" id="txtced_res_uso" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_responsablesusod.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="60" scope="col"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                <td width="432" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnombre_res_uso" type="text" id="txtnombre_res_uso" size="50" maxlength="250" readonly class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
            <tr>
             <td><table width="821">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">METODO DE ROTULACION:</span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcodigo_rotula" type="text" id="txtcodigo_rotula" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" size="4" maxlength="2">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Metodo de Rotulacion" onClick="VentanaCentrada('Cat_metodosrotulad.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="575" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtmetodo_rotula" type="text" id="txtmetodo_rotula" size="70" maxlength="250" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA DE ROTULADOR :</span></div></td>
                <td width="200" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtced_res_rotu" type="text" id="txtced_res_rotu" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_rotuladoresd.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="126" scope="col"><div align="left"><span class="Estilo5">FECHA ROTULACI&Oacute;N : </span></div></td>
                <td width="616" scope="col"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtfecha_rotulacion" type="text" id="txtfecha_rotulacion" size="15" maxlength="10"  value="<?echo $date?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" >
                </span></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="157" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL ROTULADOR :</span></div></td>
                <td width="794" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtnombre_res_rotu" type="text" id="txtnombre_res_rotu" size="50" maxlength="250" readonly class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><span class="Estilo12">UBIC. GEOGRAFICA </span></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">DIRECCI&Oacute;N :</span></div></td>
                <td width="869" scope="col"><div align="left">
                    <textarea name="txtdireccion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="txtdireccion"></textarea>
                </div></td>
              </tr>
            </table></td>
          </tr>
           <tr>
                  <td><table width="920">
                        <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">REG&Iacute;ON :</span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_region" type="text" id="txtcod_region" size="4" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_regionesd.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_region" type="text" id="txtnombre_region" size="70" maxlength="250" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
                  <td><table width="920">
                        <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">ENTIDAD FEDERAL :</span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_entidad" type="text" id="txtcod_entidad" size="4" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_entidadfederald.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtestado" type="text" id="txtestado" size="70" maxlength="250" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
                  <td><table width="920">
                        <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">MUNICIPIO :</span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_municipio" type="text" id="txtcod_municipio" size="4" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_municipiosd.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_municipio" type="text" id="txtnombre_municipio" size="70" maxlength="250" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
                  <td><table width="920">
                        <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">CIUDAD :</span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_ciudad" type="text" id="txtcod_ciudad" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_cuidadesd.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_ciudad" type="text" id="txtnombre_ciudad" size="70" maxlength="250" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
                  <td><table width="920">
                        <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">PARROQUIA :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_parroquia" type="text" id="txtcod_parroquia" size="7" maxlength="6"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_parroquiasd.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_parroquia" type="text" id="txtnombre_parroquia" size="68" maxlength="250" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO POSTAL :</span></div></td>
                <td width="891" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcod_postal" type="text" id="txtcod_postal" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><span class="Estilo12">CARACTERISTICAS</span></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="118" scope="col"><div align="left"><span class="Estilo5">CARACTERISTICAS DEL BIEN INMUEBLE:</span></div></td>
                <td width="832" scope="col"><div align="left">
                    <textarea name="txtcaracteristicas" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="txtcaracteristicas"></textarea>
                </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">RAZA :</span></div></td>
                <td width="214" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtraza" type="text" id="txtraza" size="40" maxlength="60"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="60" scope="col"><div align="left"><span class="Estilo5">COLOR :</span></div></td>
                <td width="626" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcolor" type="text" id="txtcolor" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">SEXO:</span></div></td>
                <td width="141" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                    <select name="txtsexo" id="txtsexo">
                      <option value="MASCULINO" >MASCULINO</option>
                      <option value="FEMENINO">FEMENINO</option>
                    </select>
                </strong></strong></span></span> </span></div></td>
                <td width="141" scope="col"><div align="left"><span class="Estilo5">FECHA DE NACIMIENTO :</span></div></td>
                <td width="542" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_nacimiento" type="text" id="txtfecha_nacimiento" size="15" maxlength="10" value="<?echo $date?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">EDAD (MESES) :</span></div></td>
                <td width="116" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtedad" type="text" id="txtedad" size="4" maxlength="2"  value="<?echo $num?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="94" scope="col"><div align="left"><span class="Estilo5">TAMA&Ntilde;O/PESO :</span></div></td>
                <td width="639" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txttam_peso" type="text" id="txttam_peso" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">USO :</span></div></td>
                <td width="912" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtuso" type="text" id="txtuso" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><span class="Estilo12">DATOS CONTABLES </span></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="114" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO CONTABLE ASOCIADO :</span></div></td>
                <td width="300" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcod_contablea" type="text" id="txtcod_contablea" size="30" maxlength="25"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_codigoscontablesd.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="115" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO CONTABLE DEPRECIACI&Oacute;N :</span></div></td>
                <td width="400" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcod_contabled" type="text" id="txtcod_contabled" size="30" maxlength="25"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong>
                    <input name="bttipo_codeingre22422222243623" type="button" id="bttipo_codeingre22422222243623" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="98" scope="col"><div align="left"><span class="Estilo5">TIPO DE DEPRECIACI&Oacute;N :</span></div></td>
                <td width="141" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                    <select name="txttipo_depreciacion" id="txttipo_depreciacion">
                      <option value="LINEA RECTA">LINEA RECTA</option>
                      <option value="NINGUNA">NINGUNA</option>
                    </select>
                </strong></strong></span></span> </span></div></td>
                <td width="100" scope="col"><div align="left"><span class="Estilo5">TASA DEPRECIACI&Oacute;N :</span></div></td>
                <td width="604" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txttasa_deprec" type="text" id="txttasa_deprec" size="25" maxlength="15" value="<?echo $num?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong>
                </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">VIDA &Uacute;TIL EN A&Ntilde;OS :</span></div></td>
                <td width="107" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtvida_util" type="text" id="txtvida_util" size="10" maxlength="15" value="<?echo $num?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="71" scope="col"><div align="left"><span class="Estilo5">VALOR RESIDUAL :</span></div></td>
                <td width="701" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtvalor_residual" type="text" id="txtvalor_residual" size="20" maxlength="15" value="<?echo $num?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="164" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DE DEPRECIACI&Oacute;N :</span></div></td>
                <td width="400" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcod_presup_dep" type="text" id="txtcod_presup_dep" size="40" maxlength="32"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre224222222436222" type="button" id="bttipo_codeingre2242222224362222" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="133" scope="col"><div align="left"><span class="Estilo5">MONTO DEPRECIADO :</span></div></td>
                <td width="300" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtmonto_depreciado" type="text" id="txtmonto_depreciado" size="15" maxlength="15" value="<?echo $num?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="121" scope="col"><div align="left"><span class="Estilo5">DESINCORPORADO :</span></div></td>
                <td width="80" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                    <select name="txtdesincorporado" size="1" id="txtdesincorporado">
                      <option value='1'>SI</option>
                      <option value='2'>NO</option>
                    </select>
                </strong></strong></span></span> </span></div></td>
                <td width="164" scope="col"><span class="Estilo5">FECHA DESINCORPORCI&Oacute;N :</span></td>
                <td width="578" scope="col"><span class="Estilo5">
                 <input name="txtfecha_desincorporado" type="text" id="txtfecha_desincorporado" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?echo $date?>">
                </span></td>
              </tr>
            </table></td>
          </tr>
           <tr>
                  <td><table width="920">
                        <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">SITUACION CONTABLE :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcodigo_situacont" type="text" id="txtcodigo_situacont" size="4" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Situacion Contable" onClick="VentanaCentrada('Cat_situacioncontabled.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txttipo_situacion" type="text" id="txttipo_situacion" size="68" maxlength="50" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
                  <td><table width="920">
                        <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">SITUACION LEGAL :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcodigo_situalegal" type="text" id="txtcodigo_situalegal" size="4" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Situacion Contable" onClick="VentanaCentrada('Cat_situacionlegald.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txttipo_situacion_legal" type="text" id="txttipo_situacion_legal" size="68" maxlength="50" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE VERIFICADOR:</span></div></td>
                <td width="200" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtced_res_verificador" type="text" id="txtced_res_verificador" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_responsableverd.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="98" scope="col"><div align="left"><span class="Estilo5">FECHA DE VERIFICACI&Oacute;N :</span></div></td>
                <td width="555" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_verificacion" type="text" id="txtfecha_verificacion" size="15" maxlength="10" value="<?echo $date?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL VERIFICADOR :</span></div></td>
                <td width="858" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnombre_res_ver" type="text" id="txtnombre_res_ver" size="80" maxlength="100" readonly class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><span class="Estilo12">INCORPORACI&Oacute;N</span></td>
          </tr>
           <tr>
            <td><table width="963">
              <tr>
                <td width="133" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO MOVIMIENTO INCORPORACI&Oacute;N:</span></div></td>
                <td width="81" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcodigo" type="text" id="txtcodigo" size="5" maxlength="3"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                  <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Tipo Incorporacion" onClick="VentanaCentrada('Cat_tipoincorpd.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="733" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtdenomina_tipo" type="text" id="txtdenomina_tipo" size="75" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table>
              <table width="961">
                <tr>
                  <td width="113" scope="col"><div align="left"><span class="Estilo5">TIPO DE INCORPORACI&Oacute;N :</span></div></td>
                  <td width="836" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                      <select name="txttipo_incorporacion" size="1" id="txttipo_incorporacion">
                        <option value='1'>PRESUPUESTARIA</option>
                        <option value='2'>NO PRESUPUESTARIA</option>
                      </select>
                  </strong></strong></span></span> </span></div></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">C&Oacute;D. IMPUTACI&Oacute;N PRESUPUESTARIA :</span></div></td>
                <td width="829" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcod_imp_presup" type="text" id="txtcod_imp_presup" size="35" maxlength="32"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong>
                    <input name="bttipo_codeingre2242222224362522" type="button" id="bttipo_codeingre22422222243625222" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="129" scope="col"><div align="left"><span class="Estilo5">NOMBRE IMPUTACI&Oacute;N PRESUPUESTARIA :</span></div></td>
                <td width="820" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnom_imp_presup" type="text" id="txtnom_imp_presup" size="80" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="205" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N DE INCORPORACI&Oacute;N NO PRESUPUESTARIA :</span></div></td>
                <td width="744" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtdes_imp_nopresup" type="text" id="txtdes_imp_nopresup" size="75" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="112" scope="col"><div align="left"><span class="Estilo5">VALOR INCORPORACI&Oacute;N :</span></div></td>
                <td width="164" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtvalor_incorporacion" type="text" id="txtvalor_incorporacion" size="20" maxlength="15" value="<?echo $num?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="112" scope="col"><div align="left"><span class="Estilo5">FECHA INCORPORACI&Oacute;N :</span></div></td>
                <td width="167" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_incorporacion" type="text" id="txtfecha_incorporacion" size="20" maxlength="15" value="<?echo $date?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              
                
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="98" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO ORDEN DE COMPRA :</span></div></td>
                <td width="136" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtnro_oc" type="text" id="txtnro_oc" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="89" scope="col"><div align="left"><span class="Estilo5">FECHA ORDEN DE COMPRA :</span></div></td>
                <td width="620" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_oc" type="text" id="txtfecha_oc" size="20" maxlength="15" value="<?echo $date?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="99" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO ORDEN DE PAGO :</span></div></td>
                <td width="144" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtnro_op" type="text" id="txtnro_op" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="85" scope="col"><div align="left"><span class="Estilo5">FECHA ORDEN DE PAGO :</span></div></td>
                <td width="615" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_op" type="text" id="txtfecha_op" size="15" maxlength="10" value="<?echo $date?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="106" scope="col"><span class="Estilo5">DOCUMENTO QUE CANCELA :</span></td>
                <td width="130" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong>
                    <select name="txttipo_doc_cancela" id="txttipo_doc_cancela">
                      <option value="CHEQUE">CHEQUE</option>
                      <option value="NOTA DEBITO">NOTA DEBITO</option>
                    </select>
                </strong></strong> </strong></strong></span> </span></span></div></td>
                <td width="85" scope="col"><span class="Estilo5">N&Uacute;MERO DOCUMENTO :</span></td>
                <td width="135" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnro_doc_cancela" type="text" id="txtnro_doc_cancela" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
                <td width="89" scope="col"><div align="left"><span class="Estilo5">FECHA DOCUMENTO :</span></div></td>
                <td width="389" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_doc_cancela" type="text" id="txtfecha_doc_cancela" size="15" maxlength="10" value="<?echo $date?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DE FACTURA :</span></div></td>
                <td width="130" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtnro_factura" type="text" id="txtnro_factura" size="25" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="66" scope="col"><div align="left"><span class="Estilo5">FECHA DE FACTURA :</span></div></td>
                <td width="676" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_factura" type="text" id="txtfecha_factura" size="15" maxlength="10" value="<?echo $date?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">CI/RIF PROVEEDOR :</span></div></td>
                <td width="200" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_proveedoresd.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="702" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnombre_proveedor" type="text" id="txtnombre_proveedor" size="65" maxlength="150"  readonly class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
            </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
