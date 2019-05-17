<?include ("../class/ventana.php"); include ("../class/fun_fechas.php");  include ("../class/configura.inc");
$fecha_hoy=asigna_fecha_hoy();  $num="01"; $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"];
$formato_bien=$_POST["txtformato_bien"]; $long_num_bien=$_POST["txtlong_num_bien"]; $direccion_t=$_POST["txtdireccion_t"];$cod_dep=$_POST["txtcod_dep"]; $nom_dep=$_POST["txtnom_dep"]; $ced_r=$_POST["txtced_resp_p"]; $nomb_r=$_POST["txtnomb_resp_p"]; 
$cod_pos=$_POST["txtcod_pos_t"]; $cod_reg=$_POST["txtcod_reg_t"]; $cod_ent=$_POST["txtcod_ent_t"]; $cod_mun=$_POST["txtcod_mun_t"]; $cod_ciu=$_POST["txtcod_ciu_t"]; $cod_parro=$_POST["txtcod_parro_t"]; 
$fec_fin_e=$_POST["txtfecha_fin"]; $cod_empresa=$_POST["txtc_empresa"]; $nomb_empresa=$_POST["txtn_empresa"]; $num_bien_unico=$_POST["txtnum_bien_unico"];
$nombre_region=$_POST["txtnombre_region_t"];$estado=$_POST["txtestado_t"];$nombre_municipio=$_POST["txtnombre_municipio_t"];
$nombre_ciudad=$_POST["txtnombre_ciudad_t"];$nombre_parroquia=$_POST["txtnombre_parroquia_t"]; $nombre_res_ver=""; $cod_contablea="";  $cod_contabled="";
$fecha_fin=formato_ddmmaaaa($fec_fin_e);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}
$ano=substr($fecha_hoy,6,4); $antiguedad=0; $tasa_deprec=0; $vida_util=0; $valor_residual=0; $monto_depreciado=0; $codigo_tipo_incorp=""; $denomina_tipo="";  
?>  
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Ficha de Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript"  src="../class/sia.js"  type="text/javascript"></script>
<script language="javascript" src="../class/cal2.js"></script>
<script language="javascript" src="../class/cal_conf2.js"></script>
<script language="javascript" src="ajax_bien.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mnum_bien_unico='<?php echo $num_bien_unico ?>';
var mlong_num_bien='<?php echo $long_num_bien ?>';
var patronfecha = new Array(2,2,4);
function Llama_num_bien(){var mref; var mcod_c; var mcod_b;
 mcod_c=document.form1.txtcod_clasificacion.value;   
 ajaxSenddoc('GET', 'numbienaut.php?cod_clasi='+mcod_c+'&num_bien_unico='+mnum_bien_unico+'&long_num_bien='+mlong_num_bien+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'numbien', 'innerHTML');
 mref=document.form1.txtnum_bien.value;
 mcod_b=mcod_c+"-"+mref;   document.form1.txtcod_bien_mue.value=mcod_b;
 document.form1.txtnum_bien.focus()
 }
function apaga_numbien(mthis){var mref; var mcod_c; var mcod_b;
 apagar(mthis); mref=mthis.value;  mcod_c=document.form1.txtcod_clasificacion.value; 
 mcod_b=mcod_c+"-"+mref;   document.form1.txtcod_bien_mue.value=mcod_b; 
}
function llama_cat_decripciones(){ var mcod_c;  mcod_c=document.form1.txtcod_clasificacion.value; 
  VentanaCentrada('Cat_descrip_bienes.php?codigo_c='+mcod_c+'&criterio=','SIA','','750','500','true')
}
function llama_cat_dir(mform){  var mcod_dep; var murl; mcod_dep=mform.txtcod_dependencia.value;
  murl='Cat_direcc_dep.php?cod_dependen='+mcod_dep+'&criterio=';   VentanaCentrada(murl,'SIA','','750','500','true');
return true;}
function llama_cat_dep(mform){  var mcod_dep; var murl;  var mcod_dir;
   mcod_dep=mform.txtcod_dependencia.value; mcod_dir=mform.txtcod_direccion.value;
  murl='Cat_departamentos.php?cod_dependen='+mcod_dep+'&cod_direccion='+mcod_dir+'&criterio=';   VentanaCentrada(murl,'SIA','','750','500','true');
return true;}
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; 
  if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec;}
return true;}
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
function revisar(){var f=document.form1;
    f.txtcod_bien_mue.value=f.txtcod_clasificacion.value+"-"+f.txtnum_bien.value;
    if(f.txtcod_clasificacion.value==""){alert("Codigo de Clasificacion no puede estar Vacio");return false;}else{f.txtcod_clasificacion.value=f.txtcod_clasificacion.value.toUpperCase();}
    if(f.txtnum_bien.value==""){alert("Numero del Bien no puede estar Vacio"); return false; } else{f.txtnum_bien.value=f.txtnum_bien.value.toUpperCase();}
    if(f.txtcod_bien_mue.value==""){alert("Codigo del Bien no puede estar Vacio");return false;}else{f.txtcod_bien_mue.value=f.txtcod_bien_mue.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Denominacion no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtcod_dependencia.value==""){alert("Codigo Dependencia no puede estar Vacio");return false;}else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtcod_direccion.value==""){alert("Codigo Direccion no puede estar Vacia");return false;}else{f.txtcod_direccion.value=f.txtcod_direccion.value.toUpperCase();}
    if(f.txtcod_departamento.value==""){alert("Codigo Departamento no puede estar Vacio");return false;}else{f.txtcod_departamento.value=f.txtcod_departamento.value.toUpperCase();}
    if(f.txtced_responsable.value==""){alert("Cedula del responsable Primario no estar Vacia"); return false; } else{f.txtced_responsable.value=f.txtced_responsable.value.toUpperCase();}
    if(f.txtced_responsable_uso.value==""){alert("Cedula del responsable de Uso no estar Vacia");return false;}else{f.txtced_responsable_uso.value=f.txtced_responsable_uso.value.toUpperCase();}
    if(f.txtcod_metodo_rot.value==""){alert("Codigo Metodo de Rotulacion no puede estar Vacio");return false;}else{f.txtcod_metodo_rot.value=f.txtcod_metodo_rot.value.toUpperCase();}   
    if(f.txtced_rotulador.value==""){alert("Cedula del Rotulador no estar Vacia"); return false; } else{f.txtced_rotulador.value=f.txtced_rotulador.value.toUpperCase();}
    if(f.txtfecha_rotulacion.value==""){alert("Fecha de Rotulacion no estar Vacia"); return false; } else{f.txtfecha_rotulacion.value=f.txtfecha_rotulacion.value.toUpperCase();}
    if(f.txtfecha_actualizacion.value==""){alert("Fecha de Actualizacion no estar Vacia"); return false; } else{f.txtfecha_actualizacion.value=f.txtfecha_actualizacion.value.toUpperCase();}
    if(f.txtdireccion.value==""){alert("Direccion no estar Vacia"); return false; } else{f.txtdireccion.value=f.txtdireccion.value.toUpperCase();}
    if(f.txtcod_region.value==""){alert("Codigo Region no puede estar Vacio"); return false; } else{f.txtcod_region.value=f.txtcod_region.value.toUpperCase();}
    if(f.txtcod_entidad.value==""){alert("Codigo de la Entidad no puede estar Vacio"); return false; } else{f.txtcod_entidad.value=f.txtcod_entidad.value.toUpperCase();}
    if(f.txtcod_municipio.value==""){alert("Codigo del Municipio no puede estar Vacio"); return false; } else{f.txtcod_municipio.value=f.txtcod_municipio.value.toUpperCase();}
    if(f.txtcod_ciudad.value==""){alert("Codigo de la Ciudad no puede estar Vacio"); return false; } else{f.txtcod_ciudad.value=f.txtcod_ciudad.value.toUpperCase();}
    if(f.txtcod_parroquia.value==""){alert("Codigo de Parroquia no puede estar Vacio"); return false; } else{f.txtcod_parroquia.value=f.txtcod_parroquia.value.toUpperCase();}
    if(f.txtsit_contable.value==""){alert("Codigo Situacion Contable no debe estar Vacia"); return false; } else{f.txtsit_contable.value=f.txtsit_contable.value.toUpperCase();}
    if(f.txtsit_legal.value==""){alert("Codigo Situacion Legal no debe estar Vacia"); return false; } else{f.txtsit_legal.value=f.txtsit_legal.value.toUpperCase();}
    if(f.txtedo_conservacion.value==""){alert("Codigo Estado de Conservacion no puede estar Vacio"); return false; } else{f.txtedo_conservacion.value=f.txtedo_conservacion.value.toUpperCase();}
    if(f.txtced_res_verificador.value==""){alert("Cedula Responsable Verificador no puede estar Vacio"); return false; } else{f.txtced_res_verificador.value=f.txtced_res_verificador.value.toUpperCase();}
    if(f.txtfecha_verificacion.value==""){alert("Fecha de Verificacion no puede estar Vacio"); return false; } else{f.txtfecha_verificacion.value=f.txtfecha_verificacion.value.toUpperCase();}
    if(f.txttipo_incorporacion.value==""){alert("Tipo de Incorporacion no puede estar Vacio"); return false; } else{f.txttipo_incorporacion.value=f.txttipo_incorporacion.value.toUpperCase();}
    if(f.txtfecha_incorporacion.value==""){alert("Fecha de Incorporacion no puede estar Vacio"); return false; } else{f.txtfecha_incorporacion.value=f.txtfecha_incorporacion.value.toUpperCase();}
    if(f.txtvalor_incorporacion.value==""){alert("Valor de Incorporacion no puede estar Vacio"); return false; } else{f.txtvalor_incorporacion.value=f.txtvalor_incorporacion.value.toUpperCase();}
    if(f.txcodigo_tipo_incorp.value==""){alert("Codigo Tipo de Incorporacion no puede estar Vacio"); return false; } else{f.txcodigo_tipo_incorp.value=f.txcodigo_tipo_incorp.value.toUpperCase();}
    r=confirm("Desea Grabar la Ficha del Bien ?");  if (r==true) { valido=true;} else{return false;} 
	document.form1.submit;
return true;}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR FICHA BIENES MUEBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="1610" border="0" id="tablacuerpo">
  <tr>
    <td>
    <table width="92" height="1800" border="1" cellpadding="0" cellspacing="0" id="tablam">
      <td width="86">
		 <td width="92" height="1800"><table width="94" height="1800" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
		   <tr>
			<td width="89" height="27"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Act_fichas_bienes_muebles_pro.php?Gcod_bien_mue=U')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="Act_fichas_bienes_muebles_pro.php?Gcod_bien_mue=U">Atras</A></td>
		   </tr>
		   <tr>
			 <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
				  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
		   </tr>
		    <tr>
			<td >&nbsp;</td>
		  </tr>
		 </table></td>
	  </td>	 
	</table>
    <p>&nbsp;</p>
    
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:1992px; z-index:1; top: 78px; left: 119px;">
            <form name="form1" method="post" action="Insert_fichas_bienes_muebles_pro.php" onSubmit="return revisar()">
        <table width="848" border="0" align="center">
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="180"><span class="Estilo5">C&Oacute;DIGO DE CLASIFICACI&Oacute;N :</span></td>
                 <td width="100"><span class="Estilo5"><input name="txtcod_clasificacion" type="text" id="txtcod_clasificacion" onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="10" class="Estilo10"> </span></td>
                 <td width="45"><span class="Estilo5"><input name="btclasif_bien" type="button" id="btclasif_bien" title="Abrir Catalogo Clasificacion de Bienes" onClick="VentanaCentrada('Cat_clasificacion_bien.php?criterio=','SIA','','750','500','true')" value="..." class="Estilo10">  </span></td>
                 <td width="520"><span class="Estilo5"><input name="txtnom_clasificacion" type="text" id="txtnom_clasificacion" size="80" maxlength="250" value="" readonly class="Estilo10"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">N&Uacute;MERO DEL BIEN:</span></td>
                 <td width="150"><span class="Estilo5"><div id="numbien"> <input name="txtnum_bien" type="text" id="txtnum_bien" size="20" maxlength="<?php echo $long_num_bien?>"  onFocus="encender(this)" onBlur="apaga_numbien(this)" class="Estilo10"></div></td>
                 <td width="100"><span class="Estilo5"><input name="btnumbien" type="button" id="btnumbien" title="Asigna Numero correlativo automatico del bien" onClick="Llama_num_bien()" value="123" class="Estilo10"> </span></td>
                 <td width="220"><span class="Estilo5">C&Oacute;DIGO DEL BIEN MUEBLE :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtcod_bien_mue" type="text" id="txtcod_bien_mue"  size="40" maxlength="40" value="" readonly class="Estilo10"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">DENOMINACI&Oacute;N DEL BIEN :</span></td>
                 <td width="640"><span class="Estilo5"><input name="txtdenominacion" type="text" id="txtdenominacion" size="110" maxlength="250" value=""  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"></div></td>
                 <td width="40"><span class="Estilo5"><input name="btclasif_bien" type="button" id="btclasif_bien" title="Abrir Catalogo Descripcion de Bienes" onClick="llama_cat_decripciones()" value="..." class="Estilo10">  </span></td>
                 
			   </tr>
             </table></td>
           </tr>
          
           <tr>
             <td><table width="845">
               <tr>
                 <td width="150"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></td>
                 <td width="65"><span class="Estilo5"><input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?echo $cod_dep?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">    </span></td>
                 <td width="60"><span class="Estilo5"> <input name="btdependencia" type="button" id="btdependencia" title="Abrir Catalogo de Dependencias" onClick="VentanaCentrada('Cat_dependenciasd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" value="<?echo $nom_dep?>" readonly class="Estilo10">    </span></td>
               </tr>
             </table></td>
           </tr>		   
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="150"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></td>
                 <td width="65"><span class="Estilo5"> <input name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="60"><span class="Estilo5"> <input name="btdirecciones" type="button" id="btdirecciones" title="Abrir Catalogo de Direcciones" onClick="javascript:llama_cat_dir(this.form)" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="100" maxlength="100" value="" readonly class="Estilo10">   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></td>
				 <td width="100"><span class="Estilo5"><input name="txtcod_departamento" type="text" id="txtcod_departamento" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="60"><span class="Estilo5"> <input name="btdepartamento" type="button" id="btdepartamento" title="Abrir Catalogo de Departamentos" onClick="javascript:llama_cat_dep(this.form)" value="..."> </span></td>
                 <td width="530"><span class="Estilo5"><input name="txtdenominacion_depart" type="text" id="txtdenominacion_depart" size="100" maxlength="100"  value="" readonly class="Estilo10">   </span></td>
              </tr>
             </table></td>
           </tr>        
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Oacute;DIGO EMPRESA :</span></td>
				 <td width="60"><span class="Estilo5"><input name="txtcod_empresa" type="text" id="txtcod_empresa" size="5" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $cod_empresa?>" class="Estilo10">   </span></td>
                 <td width="60"><span class="Estilo5"> <input name="btempresa" type="button" id="btempresa" title="Abrir Catalogo de Empresas" onClick="VentanaCentrada('Cat_empresas_ed.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_emp" type="text" id="txtdenominacion_emp" size="100" maxlength="100"  value="<?echo $nomb_empresa ?>" readonly class="Estilo10">   </span></td>
               </tr>
             </table></td>
           </tr>  
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">C.I. RESPONSABLE PRIMARIO :</span></td>
                 <td width="95"><span class="Estilo5"><input name="txtced_responsable" type="text" id="txtced_responsable" size="14" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $ced_r?>" class="Estilo10">   </span></td>
                 <td width="45"><span class="Estilo5"><input name="btresp_p" type="button" id="btresp_p" title="Abrir Catalogo Responsable Primario" onClick="VentanaCentrada('Cat_responsablesd.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
                 <td width="520"><span class="Estilo5"><input name="txtnombre_respp" type="text" id="txtnombre_respp" size="100" maxlength="250"  value="<?echo $nomb_r?>" readonly class="Estilo10">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">C.I. RESPONSABLE DE USO :</span></td>
                 <td width="95"><span class="Estilo5"> <input name="txtced_responsable_uso" type="text" id="txtced_responsable_uso" size="15" maxlength="12"  value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="45"><span class="Estilo5"><input name="btresp_uso" type="button" id="btresp_uso" title="Abrir Catalogo Responsable Uso" onClick="VentanaCentrada('Cat_responsablesusod.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
                 <td width="520"><span class="Estilo5"><input name="txtnombre_res_uso" type="text" id="txtnombre_res_uso" size="100" maxlength="250"  value="" readonly class="Estilo10">    </span></td>
               </tr>
             </table></td>
           </tr>          
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">METODO DE ROTULACI&Oacute;N :</span></td>
                 <td width="55"><span class="Estilo5"><input name="txtcod_metodo_rot" type="text" id="txtcod_metodo_rot" size="4" maxlength="2" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="45"><span class="Estilo5"><input name="btmet_rot" type="button" id="btmet_rot" title="Abrir Catalogo Metodo de Rotulacion" onClick="VentanaCentrada('Cat_metodosrotulad.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtmetodo_rotula" type="text" id="txtmetodo_rotula" size="100" maxlength="250" value="" readonly class="Estilo10">     </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Eacute;DULA DE ROTULADOR :</span></td>
                 <td width="95"><span class="Estilo5"><input name="txtced_rotulador" type="text" id="txtced_rotulador" size="15" maxlength="12"  value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="45"><span class="Estilo5"><input name="btced_rot" type="button" id="btced_rot" title="Abrir Catalogo Cedula de Rotulador" onClick="VentanaCentrada('Cat_rotuladoresd.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
                 <td width="550"><span class="Estilo5"><input name="txtnombre_res_rotu" type="text" id="txtnombre_res_rotu" size="100" maxlength="250"  value="" readonly class="Estilo10">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">FECHA DE ROTULACI&Oacute;N :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtfecha_rotulacion" type="text" id="txtfecha_rotulacion" size="20" maxlength="10" value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
                 <td width="200"><span class="Estilo5">FECHA ULTIMA ACTUALIZACI&Oacute;N :</span></td>
                 <td width="290"><span class="Estilo5"><input name="txtfecha_actualizacion" type="text" id="txtfecha_actualizacion" size="20" maxlength="10" value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>		  
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="720"><div align="left"><textarea name="txtdireccion" onFocus="encender(this)" onBlur="apagar(this)" cols="70" onFocus="encender(this)" onBlur="apagar(this)"  class="headers" id="txtdireccion"><?echo $direccion_t?></textarea>  </div></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">REGI&Oacute;N :</span></td>
                 <td width="50"><span class="Estilo5"> <input name="txtcod_region" type="text" id="txtcod_region" size="4" maxlength="2" value="<?echo $cod_reg?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="50"><input name="btcat_reg" type="button" id="btcat_reg" title="Abrir Catalogo de Regiones" onClick="VentanaCentrada('Cat_regionesd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="620"><span class="Estilo5"><input name="txtnombre_region" type="text" id="txtnombre_region" size="100" maxlength="250"  value="<?echo $nombre_region?>" readonly class="Estilo10">   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">ENTIDAD FEDERAL :</span></td>
                 <td width="50"><span class="Estilo5"><input name="txtcod_entidad" type="text" id="txtcod_entidad" size="4" maxlength="2" value="<?echo $cod_ent?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="50"><input name="btcat_ent" type="button" id="btcat_ent" title="Abrir Catalogo de Entidades Federal" onClick="VentanaCentrada('Cat_entidadfederald.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
				 <td width="620"><span class="Estilo5"><input name="txtestado" type="text" id="txtestado" size="100" maxlength="250"  value="<?echo $estado?>" readonly class="Estilo10">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">MUNICIPIO :</span></td>
                 <td width="50"><span class="Estilo5"><input name="txtcod_municipio" type="text" id="txtcod_municipio" size="5" maxlength="4" value="<?echo $cod_mun?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></td>
                 <td width="50"><input name="btcat_mun" type="button" id="btcat_mun" title="Abrir Catalogo de Municipios" onClick="VentanaCentrada('Cat_municipiosd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
				 <td width="620"><span class="Estilo5"><input name="txtnombre_municipio" type="text" id="txtnombre_municipio" size="100" maxlength="250" value="<?echo $nombre_municipio?>" readonly class="Estilo10">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">CIUDAD :</span></td>
                 <td width="50"><span class="Estilo5"><input name="txtcod_ciudad" type="text" id="txtcod_ciudad" size="5" maxlength="4"  value="<?echo $cod_ciu?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">    </span></td>
                 <td width="50"><input name="btcat_ciu" type="button" id="btcat_ciu" title="Abrir Catalogo de Ciudades" onClick="VentanaCentrada('Cat_ciudadesd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
				 <td width="620"><span class="Estilo5"><input name="txtnombre_ciudad" type="text" id="txtnombre_ciudad" size="100" maxlength="250" value="<?echo $nombre_ciudad?>" readonly class="Estilo10"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">PARROQUIA :</span></td>
                 <td width="50"><span class="Estilo5"><input name="txtcod_parroquia" type="text" id="txtcod_parroquia" size="7" maxlength="6" value="<?echo $cod_parro?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></td>
                 <td width="50"><input name="btcat_parr" type="button" id="btcat_parr" title="Abrir Catalogo de Parroquias" onClick="VentanaCentrada('Cat_parroquiasd.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
				 <td width="620"><span class="Estilo5"><input name="txtnombre_parroquia" type="text" id="txtnombre_parroquia" size="100" maxlength="250" value="<?echo $nombre_parroquia?>" readonly class="Estilo10"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">C&Oacute;DIGO POSTAL :</span></td>
                 <td width="720"><span class="Estilo5"><input name="txtcod_postal" type="text" id="txtcod_postal" size="12" maxlength="10" value="<?echo $cod_pos?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo10"><strong>CARACTERISTICAS</strong></span></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">CARACTERISTICAS DEL BIEN MUEBLE :</span></td>
                 <td width="720"><div align="left"><textarea name="textcaracteristicas" cols="70" onFocus="encender(this)" onBlur="apagar(this)"  class="headers" id="textcaracteristicas"></textarea> </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">MARCA :</span></td>
                 <td width="250"><span class="Estilo5"> <input name="txtmarca" type="text" id="txtmarca" size="30" maxlength="30" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"></span></td>
                 <td width="150"><span class="Estilo5">MODELO :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtmodelo" type="text" id="txtmodelo" size="30" maxlength="30" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">COLOR :</span></td>
                 <td width="200"><span class="Estilo5"> <input name="txtcolor" type="text" id="txtcolor" size="30" maxlength="30" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"> </span></td>
                 <td width="50"><span class="Estilo5"> <input name="btcolor" type="button" id="btcolor" title="Abrir Catalogo de Colores" onClick="VentanaCentrada('Cat_colord.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
				 <td width="150"><span class="Estilo5">MATRICULA :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtmatricula" type="text" id="txtmatricula" size="30" maxlength="30" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">SERIAL :</span></td>
                 <td width="250"><span class="Estilo5"> <input name="txtserial1" type="text" id="txtserial1" size="30" maxlength="30" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"> </span></td>
                 <td width="150"><span class="Estilo5">SERIAL 2 :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtserial2" type="text" id="txtserial2" size="30" maxlength="30"  value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">TIPO O CLASE :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txttipo_clase" type="text" id="txttipo_clase" size="30" maxlength="30" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></td>
                 <td width="150"><span class="Estilo5">USO :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtuso" type="text" id="txtuso" size="30" maxlength="15" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DIMENSION O TAMA&Ntilde;O :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtdimension_tam" type="text" id="txtdimension_tam" size="30" maxlength="30" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="150"><span class="Estilo5">MATERIAL :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtmaterial" type="text" id="txtmaterial" size="30" maxlength="30" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></td>
                 <td width="120"><span class="Estilo5"><input name="btmaterial" type="button" id="btmaterial" title="Abrir Catalogo de Materiales" onClick="VentanaCentrada('Cat_materialesd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
			   </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">C&Oacute;DIGO ALTERNO :</span></td>
                 <td width="240"><span class="Estilo5"><input name="txtcodigo_alterno" type="text" id="txtcodigo_alterno" size="30" maxlength="30"  value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="60"><span class="Estilo5">A&Ntilde;O :</span></td>
                 <td width="150"><span class="Estilo5"><input name="txtano" type="text" id="txtano" size="5" maxlength="4" value="<?echo $ano?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"> </span></td>
                 <td width="100"><span class="Estilo5">ANTIGUEDAD :</span></td>
                 <td width="170"><span class="Estilo5"><input name="txtantiguedad" type="text" id="txtantiguedad" size="10" maxlength="5" align="rigth" value="<?echo $antiguedad?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">ACCESORIOS :</span></td>
                 <td width="720"><div align="left"><textarea name="txtaccesorios" cols="70" onFocus="encender(this)" onFocus="encender(this)" onBlur="apagar(this)" class="headers" id="txtaccesorios"></textarea>   </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo10"><strong>DATOS CONTABLES</strong></span></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="200"><span class="Estilo5">C&Oacute;DIGO CONTABLE ASOCIADO :</span></td>
                 <td width="225"><span class="Estilo5"><input name="txtcod_contablea" type="text" id="txtcod_contablea" size="25" maxlength="25" value="<?echo $cod_contablea?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   
				  <input name="btcod_contaba" type="button" id="btcod_contaba" title="Abrir Catalogo Codigo Contable" onClick="VentanaCentrada('Cat_codigoscontablesa.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="220"><span class="Estilo5">C&Oacute;DIGO CONTABLE DEPRECIACI&Oacute;N :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtcod_contabled" type="text" id="txtcod_contabled" size="25" maxlength="25" value="<?echo $cod_contabled?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  
				   <input name="btcod_contabd" type="button" id="btcod_contabd" title="Abrir Catalogo Codigo Contable Depreciacion" onClick="VentanaCentrada('Cat_codigoscontablesd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="195"><span class="Estilo5">TIPO DE DEPRECIACI&Oacute;N :</span></td>
                 <td width="250"><span class="Estilo5">  <select name="txttipo_depreciacion" onFocus="encender(this)" onBlur="apagar(this)"> <option>NINGUNA</option>    <option>LINEA RECTA</option> </select> </span></td>
                 <td width="150"><span class="Estilo5">TASA DEPRECIACI&Oacute;N :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txttasa_deprec" type="text" id="txttasa_deprec" size="10" maxlength="5" style="text-align:right" value="<?echo $tasa_deprec?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">    </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="195"><span class="Estilo5">VIDA &Uacute;TIL EN A&Ntilde;OS :</span></td> 
                 <td width="250"><span class="Estilo5"><input name="txtvida_util" type="text" id="txtvida_util" size="10"  maxlength="5" style="text-align:right"  value="<?echo $vida_util?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">    </span></td>
                 <td width="150"><span class="Estilo5">VALOR RESIDUAL :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtvalor_residual" type="text" id="txtvalor_residual" size="20"  maxlength="5" style="text-align:right"  value="<?echo $valor_residual?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"> </span></td>
               </tr>
             </table></td>
           </tr>
          
		  <tr>
             <td><table width="845">
               <tr>
                 <td width="290"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DE DEPRECIACI&Oacute;N :</span></td>
                 <td width="280"><span class="Estilo5"><input name="txtcod_presup_dep" type="text" id="txtcod_presup_dep" size="35" maxlength="32" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  
				  <input name="btcod_presupd" type="button" id="btcod_presupd" title="Abrir Catalogo Codigo Presupuestario Depreciacion" onClick="VentanaCentrada('Cat_codigos_presup_dep.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="145"><span class="Estilo5">MONTO DEPRECIADO :</span></td>
                 <td width="130"><span class="Estilo5"><input name="txtmonto_depreciado" type="text" id="txtmonto_depreciado" size="15" maxlength="15" value="<?echo $monto_depreciado?>" style="text-align:right" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="845">
              <tr>
                <td width="145" ><span class="Estilo5">DESINCORPORADO :</span></div></td>
                <td width="700" ><span class="Estilo5"><select name="txtdesincorporado" size="1" id="txtdesincorporado"> <option >NO</option> <option >SI</option>  </select>  </span></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">SITUACI&Oacute;N CONTABLE :</span></td>
                 <td width="100"><span class="Estilo5"><input name="txtsit_contable" type="text" id="txtsit_contable" size="4" maxlength="2" value=""  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   
          			<input name="btsit_contab" type="button" id="btsit_contab" title="Abrir Catalogo Situacion Contable" onClick="VentanaCentrada('Cat_situacioncontabled.php?criterio=','SIA','','750','500','true')" value="...">     </span></td>
                 <td width="570"><span class="Estilo5"><input name="txttipo_situacion_cont" type="text" id="txttipo_situacion_cont" size="100" maxlength="100" value="" readonly class="Estilo10">  </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">SITUACI&Oacute;N LEGAL :</span></td>
                 <td width="100"><span class="Estilo5"><input name="txtsit_legal" type="text" id="txtsit_legal" size="4" maxlength="2" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   
				    <input name="btsit_legal" type="button" id="btsit_legal" title="Abrir Catalogo Situacion Legal del Bien" onClick="VentanaCentrada('Cat_situacionlegald.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="570"><span class="Estilo5"><input name="txttipo_situacion_legal" type="text" id="txttipo_situacion_legal" size="100" maxlength="100" value="" readonly class="Estilo10">   </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">ESTADO DE CONSERVACI&Oacute;N :</span></td>
                 <td width="100"><span class="Estilo5"> <input name="txtedo_conservacion" type="text" id="txtedo_conservacion" size="5" maxlength="15" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   
				     <input name="btedo_cons" type="button" id="btedo_cons" title="Abrir Catalogo Estado de Conservacion" onClick="VentanaCentrada('Cat_estadoconservaciond.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="570"><span class="Estilo5"><input name="txtestado_bien" type="text" id="txtestado_bien" size="100" maxlength="100" value="" readonly class="Estilo10"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="200"><span class="Estilo5">C.I. RESPONSABLE VERIFICADOR :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtced_res_verificador" type="text" id="txtced_res_verificador" size="15" maxlength="12" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  
				   <input name="btres_ver" type="button" id="btres_ver" title="Abrir Catalogo Responsable Verificador" onClick="VentanaCentrada('Cat_responsableverd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="155"><span class="Estilo5">FECHA DE VERIFICACI&Oacute;N :</span></td>
                 <td width="290"><span class="Estilo5"><input name="txtfecha_verificacion" type="text" id="txtfecha_verificacion" size="20" maxlength="10" value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">NOMBRE DEL VERIFICADOR :</span></td>
                 <td width="670"><span class="Estilo5"><input name="txtnombre_res_ver" type="text" id="txtnombre_res_ver" size="100" maxlength="250" value="<?echo $nombre_res_ver?>" readonly class="Estilo10">
                 </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo10"><strong>INCORPORACI&Oacute;N</strong></span></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">C&Oacute;DIGO MOVIMIENTO INCORPORACI&Oacute;N:</span></td>
                 <td width="150"><span class="Estilo5"><input name="txcodigo_tipo_incorp" type="text" id="txcodigo_tipo_incorp" size="5" maxlength="5" value="<?echo $codigo_tipo_incorp?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  
				     <input name="btcod_mov" type="button" id="btcod_mov" title="Abrir Catalogo Tipo Incorporacion" onClick="VentanaCentrada('Cat_tipoincorpd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="450"><span class="Estilo5"><input name="txtdenomina_tipo" type="text" id="txtdenomina_tipo" size="90" maxlength="150" value="<?echo $denomina_tipo?>" readonly class="Estilo10"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="195"><span class="Estilo5">TIPO DE INCORPORACI&Oacute;N :</span></td>
                 <td width="650"><span class="Estilo5"><select name="txttipo_incorporacion" onFocus="encender(this)" onBlur="apagar(this)"><option>PRESUPUESTARIA</option><option>NO PRESUPUESTARIA</option></select></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">C&Oacute;D. IMPUTACI&Oacute;N PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input name="txtcod_presup" type="text" id="txtcod_presup" size="40" maxlength="32"  value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"> 
				   <input name="btcod_presupi" type="button" id="btcod_presupi" title="Abrir Catalogo Codigo Presupuestario" onClick="VentanaCentrada('Cat_codigos_presup.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">NOMBRE IMPUTACI&Oacute;N PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input name="txtdenomina_presup" type="text" id="txtdenomina_presup" size="105" maxlength="150" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">DESCRIPCI&Oacute;N DE INCORPORACI&Oacute;N NO PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input name="txtdes_imp_nopresup" type="text" id="txtdes_imp_nopresup" size="105" maxlength="150" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">VALOR INCORPORACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input name="txtvalor_incorporacion" type="text" id="txtvalor_incorporacion" size="20" maxlength="15" style="text-align:right" value="0" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="150"><span class="Estilo5">FECHA INCORPORACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input name="txtfecha_incorporacion" type="text" id="txtfecha_incorporacion" size="15" maxlength="10" value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">   </span></td>
                 <td width="90"><span class="Estilo5">GARANTIA :</span></td>
                 <td width="140"><span class="Estilo5"><input name="txtgarantia" type="text" id="txtgarantia" size="10" maxlength="10"  align="rigth" value="0" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
               </tr>
             </table></td>
           </tr>
		  
		   <tr>
             <td><table width="845">
               <tr>
                <td width="85"><span class="Estilo5"><input name="txttasa_impuesto" type="hidden" id="txttasa_impuesto" >   </span></td>
                 <td width="110"><span class="Estilo5"><input name="txtvalor_impuesto" type="hidden" id="txtvalor_impuesto" >   </span></td>
                  <td width="85"><span class="Estilo5"><input name="txttasa_prorrata" type="hidden" id="txttasa_prorrata">   </span></td>
                 <td width="115"><span class="Estilo5"><input name="txtvalor_prorrata" type="hidden" id="txtvalor_prorrata">   </span></td>
               </tr>
             </table></td>
           </tr>
		   
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">N&Uacute;MERO ORDEN DE COMPRA :</span></td>
                 <td width="170"><span class="Estilo5"><input name="txtnro_oc" type="text" id="txtnro_oc" size="10" maxlength="8"  value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="170"><span class="Estilo5">FECHA ORDEN DE COMPRA :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtfecha_oc" type="text" id="txtfecha_oc" size="15" maxlength="10" value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">N&Uacute;MERO ORDEN DE PAGO :</span></td>
                 <td width="170"><span class="Estilo5"><input name="txtnro_op" type="text" id="txtnro_op" size="10" maxlength="8"  value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="170"><span class="Estilo5">FECHA ORDEN DE PAGO :</span></td>
                 <td width="320"><span class="Estilo5"> <input name="txtfecha_op" type="text" id="txtfecha_op" size="15" maxlength="10" value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">DOCUMENTO QUE CANCELA :</span></td>
                 <td width="120"><span class="Estilo5"> <select name="txttipo_doc_cancela"> <option>CHEQUE</option><option>NOTA DEBITO</option>  </select></span></td>
                 <td width="140"><span class="Estilo5">N&Uacute;MERO DOCUMENTO :</span></td>
                 <td width="120"><span class="Estilo5"><input name="txtnro_doc_cancela" type="text" id="txtnro_doc_cancela" size="10" maxlength="8"  value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></td>
                 <td width="140"><span class="Estilo5">FECHA DOCUMENTO :</span></td>
                 <td width="140"><span class="Estilo5"><input name="txtfecha_doc_cancela" type="text" id="txtfecha_doc_cancela" size="20"  maxlength="10" value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="145"><span class="Estilo5">N&Uacute;MERO DE FACTURA :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtnro_factura" type="text" id="txtnro_factura" size="25" maxlength="20"   value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                     <span class="menu"><strong><strong> </strong></strong></span> </span></td>
                 <td width="180"><span class="Estilo5">FECHA DE FACTURA :</span></td>
                 <td width="320"><span class="Estilo5"> <input name="txtfecha_factura" type="text" id="txtfecha_factura" size="15" maxlength="10" value="<?echo $fecha_hoy?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">
                     </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="145"><span class="Estilo5">CI/RIF PROVEEDOR :</span></td>
                 <td width="160"><span class="Estilo5"><input name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12"  value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   
				   <input name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo Proveedores" onClick="VentanaCentrada('Cat_proveedoresd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="540"><span class="Estilo5"><input name="txtnombre_proveedor" type="text" id="txtnombre_proveedor" size="90" maxlength="100" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">    </span></td>
               </tr>
             </table></td>
           </tr>
        </table>
        <table width="812">
		  <tr>
             <td width="840" height="39">&nbsp;</td>
		   </tr>
          <tr>
            <td width="627">&nbsp;</td>
			<td width="5"><input name="txtcod_fuente" type="hidden" id="txtcod_fuente" value="" ></td>
			<td width="5"><input name="txtlong_num_bien" type="hidden" id="txtlong_num_bien" value="<?php echo $long_num_bien ?>" ></td>
            <td width="81"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
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
