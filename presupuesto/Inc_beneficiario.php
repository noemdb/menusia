<?include ("../class/ventana.php");  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $host=$_POST["txthost"]; $port=$_POST["txtport"]; $dbname=$_POST["txtdbname"];$ced_rif_c=$_POST["txtced_rif_c"];
$region_e=$_POST["txtregion_e"]; $estado_e=$_POST["txtestado_e"];  $municipio_e=$_POST["txtmunicipio_e"];  $ciudad_e=$_POST["txtciudad_e"];  $cod_estado=$_POST["txtcod_estado"];
$mpatron="Array(1,8,1)"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Incluir beneficiarios)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
</script>
<script language="JavaScript" type="text/JavaScript">
var patroncodigo = new <?php echo $mpatron ?>;
function validarrif(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=45&&tecla!=69&&tecla!=71&&tecla!=74&&tecla!=86)){alert('Valor no Valido') };
    patron=/[0-9\J\E\G\C\-\V]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function chequea_estado(mform){ var cod_edo;  cod_edo=mform.txtestado.value;
ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio_e;?>&cod_estado='+cod_edo, 'municipio', 'innerHTML');
ajaxSenddoc('GET', 'cargaciudad.php?ciudad=<? echo $ciudad_e;?>&cod_estado='+cod_edo, 'ciudad', 'innerHTML');
return true;}
function revisar(){var f=document.form1; var r; var valido; var mcedula;
    if(f.txtced_rif.value==""){alert("Cedula/Rif del beneficiario no puede estar Vacio"); f.txtced_rif.focus();  return false;}else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    mcedula=f.txtced_rif.value;
	if ((mcedula.charAt(0) == 'V')||(mcedula.charAt(0) == 'E')||(mcedula.charAt(0) == 'J')||(mcedula.charAt(0) == 'G')||(mcedula.charAt(0) == 'C')){ mcedula=f.txtced_rif.value;}else{alert("Ced/Rif Invalido formato valido Ej: V-00000000"); f.txtced_rif.focus(); return false;}
	if (mcedula.charAt(1) == '-'){mcedula=f.txtced_rif.value;}else{alert("Ced/Rif Invalido, debe llevar guion(-) en el segundo digito V-12345678"); f.txtced_rif.focus(); return false;}
	if(f.txtnombre.value==""){alert("Nombre del Beneficiario no puede estar Vacia"); ; f.txtnombre.focus();  return false; } else{f.txtnombre.value=f.txtnombre.value.toUpperCase();}
    r=confirm("Desea Grabar el Beneficiario ?");  if (r==true) { valido=true;} else{return false;} 
	document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
</script>
</head>
<?php $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="Select * from COMP005 where ced_rif='$ced_rif_c'"; $res=pg_query($sql);$filas=pg_num_rows($res);
$ced_rif=""; $nombre_proveedor="";$rif_proveedor="";$nit_proveedo="";$nit_proveedor=""; $direccion="";$tipo_benef=""; $ci_rep_legal=""; $nom_rep_legal="";  $cedula="";$persona_contacto="";  $telefono=""; $fax=""; $tlf_movil=""; $email_proveed=""; $observacion="";  $web_site_proveed=""; $ramo_venta="";
$cod_pos_proveedor=""; $aptd_pos_proveedor=""; $nro_sso="";$nro_ince="";$inf_usuario=""; $tiene_alcaldia=""; $nro_alcaldia="";$tiene_gobernacion=""; $nro_gobernacion=""; $nro_gobernacion2=""; $fecha_reg_gob="";  $tiene_ocei=""; $nro_ocei=""; $monto_ocei=0;
$nro_otro1=""; $nro_otro2="";$exon_inscripcion="";  $exon_licitacion=""; $capital_suscripto=0; $capital_pagado=0;  $cta_banco_empresa="";$fecha_registro=""; $circunscripcion_j=""; $nro_registro=""; $tomo_registro=""; $folio_registro=""; $status_proveed="";
$porc_ret_iva=0; $porc_ret_islr=0; $porc_ret_alcaldia=0; $porc_ret_otro=0;$tipo_empresa="";$exon_iva="";$campo_str1=""; $campo_str2="";  $nombre_grupob=""; $campo_num1=0; $campo_num2=0;
if($filas>=1){$registro=pg_fetch_array($res,0);
  $ced_rif=$registro["ced_rif"]; $nombre_proveedor=$registro["nombre_proveedor"];$rif_proveedor=$registro["rif_proveedor"];
  $nit_proveedor=$registro["nit_proveedor"]; $direccion=$registro["direccion_proveedor"];$tipo_benef="J"; if(substr($ced_rif,0,1)=='V'){$tipo_benef="V";}
  $ci_rep_legal=$registro["ci_rep_legal"]; $nom_rep_legal=$registro["nom_rep_legal"]; $persona_contacto=$registro["persona_contacto"];
  $telefono=$registro["telefono_proveedor"];$fax=$registro["fax_proveedor"];$tlf_movil=$registro["tlf_movil_proveedor"];
  $email_proveed=$registro["email_proveed"]; $observacion=$registro["observacion"]; $web_site_proveed=$registro["web_site_proveed"];
  $ramo_venta=$registro["ramo_venta"]; $cod_pos_proveedor=$registro["cod_pos_proveedor"]; $aptd_pos_proveedor=$registro["aptd_pos_proveedor"];
  $nro_sso=$registro["nro_sso"]; $nro_ince=$registro["nro_ince"]; $inf_usuario=$registro["inf_usuario"]; $tiene_alcaldia=$registro["tiene_alcaldia"]; $nro_alcaldia=$registro["nro_alcaldia"];
  $tiene_gobernacion=$registro["tiene_gobernacion"];$nro_gobernacion=$registro["nro_gobernacion"]; $nro_gobernacion2=$registro["nro_gobernacion2"]; $fecha_reg_gob=$registro["fecha_reg_gob"];
  $tiene_ocei=$registro["tiene_ocei"]; $nro_ocei=$registro["nro_ocei"]; $monto_ocei=$registro["monto_ocei"]; $nro_otro1=$registro["nro_otro1"];
  $nro_otro2=$registro["nro_otro2"]; $exon_inscripcion=$registro["exon_inscripcion"]; $exon_licitacion=$registro["exon_licitacion"]; $capital_suscripto=$registro["capital_suscripto"];
  $capital_pagado=$registro["capital_pagado"];  $fecha_registro=$registro["fecha_registro"]; $circunscripcion_j=$registro["circunscripcion_j"];
  $nro_registro=$registro["nro_registro"]; $tomo_registro=$registro["tomo_registro"]; $folio_registro=$registro["folio_registro"]; $status_proveed=$registro["status_proveed"];
  $porc_ret_iva=$registro["porc_ret_iva"]; $porc_ret_islr=$registro["porc_ret_islr"]; $porc_ret_alcaldia=$registro["porc_ret_alcaldia"]; $porc_ret_otro=$registro["porc_ret_otro"];
  $cta_banco_empresa=$registro["cta_banco_empresa"];$tipo_empresa=$registro["tipo_empresa"]; $exon_iva=$registro["exon_iva"];
  $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"]; $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"];  
  $Ssql="Select * from ban022 where cod_grupob='$campo_str1'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $reg=pg_fetch_array($resultado,0); $nombre_grupob=$reg["nombre_grupob"];}
//  $fecha_registro=formato_ddmmaaaa($fecha_registro); $fecha_reg_gob=formato_ddmmaaaa($fecha_reg_gob);
}else{ if($ced_rif_c<>''){ $sql="Select * from TRABAJADORES where cedula='$ced_rif_c' "; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];
  $fecha_ingreso=$registro["fecha_ingreso"]; $fecha_ing_adm=$registro["fecha_ing_adm"];  $cod_cargo=$registro["cod_cargo"]; $cod_departam=$registro["cod_departam"];
  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_categoria=$registro["cod_categoria"]; $tipo_pago=$registro["tipo_pago"]; $cta_empleado=$registro["cta_empleado"]; $tipo_cuenta=$registro["tipo_cuenta"];
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $cta_empresa=$registro["cta_empresa"]; $calculo_grupos=$registro["calculo_grupos"]; $cod_jerarquia=$registro["cod_jerarquia"];
  $tiene_dec_jurada=$registro["tiene_dec_jurada"]; $fecha_declaracion=$registro["fecha_declaracion"]; $monto_declaracion=$registro["monto_declaracion"];  
  $tiene_lph=$registro["tiene_lph"]; $banco_lph=$registro["banco_lph"]; $cta_lph=$registro["cta_lph"]; $fecha_lph=$registro["fecha_lph"]; $fecha_des_lph=$registro["fecha_des_lph"]; $modif_lph=$registro["modif_lph"]; 
  $fecha_fin_con=$registro["fecha_fin_con"]; $fecha_egreso=$registro["fecha_egreso"]; $motivo_egreso=$registro["motivo_egreso"]; $cont_fijo=$registro["cont_fijo"];  
  $tipo_vacaciones=$registro["tipo_vacaciones"]; $pago_vaciones=$registro["pago_vaciones"]; $fecha_pago=$registro["fecha_pago"]; $cod_jerarquia=$registro["cod_jerarquia"]; 
  $codigo_ubicacion=$registro["codigo_ubicacion"]; $descripcion_ubi=$registro["descripcion_ubi"]; $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $rif_empleado=$registro["rif_empleado"];
  $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $direccion=$registro["direccion"];$grado_inst=$registro["grado_inst"]; $profesion=$registro["profesion"]; 
  $sexo=$registro["sexo"]; $edo_civil=$registro["edo_civil"]; $fecha_nacimiento=$registro["fecha_nacimiento"]; $edad=$registro["edad"];  
  $lugar_nacimiento=$registro["lugar_nacimiento"]; $cod_postal=$registro["cod_postal"]; $telefono=$registro["telefono"];  $tlf_movil=$registro["tlf_movil"];  $correo=$registro["correo"];
  $estado=$registro["estado"]; $ciudad=$registro["ciudad"]; $municipio=$registro["municipio"]; $parroquia=$registro["parroquia"]; $aptdo_postal=$registro["aptdo_postal"];
  $observacion=$registro["observacion"]; $talla_camisa=$registro["talla_camisa"]; $talla_pantalon=$registro["talla_pantalon"]; $talla_calzado=$registro["talla_calzado"];
  $poliza=$registro["poliza"]; $fecha_seguro=$registro["fecha_seguro"];  $tiene_aus_pro=$registro["tiene_aus_pro"]; $motivo_ausencia=$registro["motivo_ausencia"];  $fecha_aus_desde=$registro["fecha_aus_desde"]; $fecha_aus_hasta=$registro["fecha_aus_hasta"];  
  $ced_rif="V-".$cedula; $nombre_proveedor=$nombre;   $tipo_benef="V"; $cod_pos_proveedor=$cod_postal; $aptd_pos_proveedor=$aptdo_postal;  $clasificacion="EMPLEADO";
  $Ssql="SELECT * FROM pre091 where estado='".$estado."'"; echo $Ssql; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_estado=$registro["cod_estado"];}if($cod_estado==""){ $cod_estado=$cod_e; $estado=$edo_e;}
  $cod_muni=$cod_estado."01"; $Ssql="select * FROM PRE093 where nombre_municipio='".$municipio."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_muni=$registro["cod_municipio"];} else { $cod_muni=$cod_m; } 
  if($municipio==""){ $Ssql="select * FROM PRE093 where cod_municipio='".$cod_muni."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$municipio=$registro["nombre_municipio"];}  };
} } }
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR BENEFICIARIOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="560" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="555" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Carga_proveedor.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Carga_proveedor.php">Cargar Proveedor</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_beneficiarios.php?Gced_rif=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_beneficiarios.php?Gced_rif=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:274px; z-index:1; top: 62px; left: 113px;">
            <form name="form1" method="post" action="Insert_beneficiario.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
<script language="JavaScript" type="text/JavaScript"> function asig_tipo_benef(mvalor){var f=document.form1;  if(mvalor=="J"){document.form1.txttipo_benef.options[0].selected=true;}else{document.form1.txttipo_benef.options[1].selected=true;}} </script>
          <tr>
            <td><table width="800" >
                <tr>
                  <td width="85"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                  <td width="346"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $ced_rif?>" onKeypress="return validarrif(event,this)" onkeyup="mascara(this,'-',patroncodigo,false)" ></span></td>
                  <td width="165"><span class="Estilo5">TIPO DE BENEFICIARIO :</span></td>
                  <td width="184"><span class="Estilo5"><select  class="Estilo10" name="txttipo_benef" size="1" id="txttipo_benef" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return stabular(event,this)">
                      <option>Juridico</option> <option>Natural</option> </select>  </span></td>
                </tr>
                <script language="JavaScript" type="text/JavaScript"> asig_tipo_benef('<?echo substr($tipo_benef,0,1);?>');</script>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="85"><span class="Estilo5">NOMBRE :</span></td>
                  <td width="705"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre"  size="107" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $nombre_proveedor?>" ></span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="85"><span class="Estilo5">C&Eacute;DULA :</span></td>
                  <td width="190"><span class="Estilo5">  <input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="20" maxlength="9"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $cedula?>" >  </span></td>
                  <td width="52"><span class="Estilo5">RIF :</span></td>
                  <td width="207"><span class="Estilo5"> <input class="Estilo10" name="txtrif" type="text" id="txtrif" size="20" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $ced_rif?>" >  </span></td>
                  <td width="57"><span class="Estilo5">NIT :</span></td>
                  <td width="181"><span class="Estilo5"> <input class="Estilo10" name="txtnit" type="text" id="txtnit" size="20" maxlength="12"   onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $nit_proveedor?>" >  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="85"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                  <td width="705"><textarea name="txtdireccion" cols="84" onFocus="encender(this)" onBlur="apagar(this)" class="headers" id="txtdireccion" onKeypress="return stabular(event,this)"><?echo $direccion?></textarea></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="82"><span class="Estilo5">REGION :</span></td>
                  <td width="308"><span class="Estilo5"><div id="region"><select  class="Estilo10" name="txtregion" id="txtregion" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)">
                  <option><? echo $region_e;?></option> </div> </span></td>
                  <script language="JavaScript" type="text/JavaScript">ajaxSenddoc('GET', 'cargaregiones.php?mregion=<? echo $region_e;?>', 'region', 'innerHTML'); </script>
                  <td width="87"><span class="Estilo5">ESTADO :</span></td>
                  <td width="303"><span class="Estilo5"> <div id="estado"><select  class="Estilo10" name="txtestado" id="txtestado" onFocus="encender(this)" onBlur="apagar(this);"  onKeypress="return stabular(event,this)" onchange="chequea_estado(this.form)">
                  <option value="<? echo $cod_estado;?>"><? echo $estado_e;?></option>
                  </div></span></td>
                  <script language="JavaScript" type="text/JavaScript">ajaxSenddoc('GET', 'cargaentidades.php?mestado=<? echo $estado_e;?>', 'estado', 'innerHTML'); </script>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="82"><span class="Estilo5">MUNICIPIO :</span></td>
                  <td width="308"><span class="Estilo5"><div id="municipio"><select  class="Estilo10" name="txtmunicipio" id="txtmunicipio" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)">
                  <option><? echo $municipio_e;?></option> </div></span></td>
                  <script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value;  ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio_e;?>&cod_estado='+cod_e, 'municipio', 'innerHTML'); </script>
                  <td width="87"><span class="Estilo5">CIUDAD :</span></td>
                  <td width="303"><span class="Estilo5"> <div id="ciudad"><select  class="Estilo10" name="txtciudad" id="txtciudad" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)">
                  <option><? echo $ciudad_e;?></option> </div></span></td>
                  <script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value; ajaxSenddoc('GET', 'cargaciudad.php?ciudad=<? echo $ciudad_e;?>&cod_estado='+cod_e, 'ciudad', 'innerHTML'); </script>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="164"><span class="Estilo5">C&Eacute;DULA/RIF AUTORIZADO :</span></td>
                  <td width="624"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif_aut" type="text" id="txtced_rif_aut" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" onBlur="apagar(this)"  size="20" maxlength="12" value="<?echo $ci_rep_legal?>">   </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="164"><span class="Estilo5">NOMBRE DE AUTORIZADO:</span></td>
                  <td width="624"><span class="Estilo5"> <input class="Estilo10" name="txtnomb_auto" type="text" id="txtnomb_auto" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" onBlur="apagar(this)"  size="95" maxlength="100" value="<?echo $nom_rep_legal?>">   </span></td>
                </tr>
            </table></td>
          </tr>
        </table>
        <table width="828" align="center">
          <tr>
            <td><table width="800">
                <tr>
                  <td width="84"><span class="Estilo5">TELEFONOS:</span></td>
                  <td width="204"><span class="Estilo5"> <input class="Estilo10" name="txttelefono" type="text" id="txttelefono" size="25" maxlength="25" value="<?echo $telefono?>"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)">   </span></td>
                  <td width="38"><span class="Estilo5">FAX :</span></td>
                  <td width="162"><span class="Estilo5"><input class="Estilo10" name="txtfax" type="text" id="txtfax" size="20" maxlength="20"   value="<?echo $fax?>" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)">  </span></td>
                  <td width="75"><span class="Estilo5">TLF. MOVIL:</span></td>
                  <td width="209"><span class="Estilo5"> <input class="Estilo10" name="txttlf_movil" type="text" id="txttlf_movil" size="25" maxlength="25"  value="<?echo $tlf_movil?>" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)">  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="95"><span class="Estilo5">COD. POSTAL :</span></td>
                  <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_postal" type="text" id="txtcod_postal" size="20" maxlength="10" value="<?echo $cod_pos_proveedor?>" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)">  </span></td>
                  <td width="81"><span class="Estilo5">APARTADO :</span></td>
                  <td width="162"><span class="Estilo5"> <input class="Estilo10" name="txtaptd_postal" type="text" id="txtaptd_postal" size="20" maxlength="10"  value="<?echo $aptd_pos_proveedor?>" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)">  </span></td>
                  <td width="106"><span class="Estilo5">NRO. PASAPORTE:</span></td>
                  <td width="178"><span class="Estilo5"><input class="Estilo10" name="txtpasaporte" type="text" id="txtpasaporte" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)">   </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="817">
                <tr>
                  <td width="74"><span class="Estilo5">RESIDENTE :</span></td>
                  <td width="53"><span class="Estilo5"><select  class="Estilo10" name="txtresidente" size="1" id="txtresidente" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
                  <td width="100"><span class="Estilo5">NACIONALIDAD :</span></td>
                  <td width="153"><span class="Estilo5"><select  class="Estilo10" name="txtnacionalidad" size="1" id="txtnacionalidad" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)"> <option>VENEZOLANO</option><option>EXTRANJERO</option> </select> </span></td>
                  <td width="39"><span class="Estilo5">PAIS:</span></td>
                  <td width="353"><span class="Estilo5"><input class="Estilo10" name="txtpais" type="text" id="txtpais" size="53"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)">
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="164"><span class="Estilo5">REPRESENTANTE LEGAL:</span></td>
                  <td width="624"><span class="Estilo5"><input class="Estilo10" name="txtrep_legal" type="text" id="txtrep_legal" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" onBlur="apagar(this)"  size="93" value="<?echo $nom_rep_legal?>" >
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="216"><span class="Estilo5">CLASIFICACI&Oacute;N DEL BENEFICIARIO :</span></td>
                  <td width="572"><span class="Estilo5"> <select  class="Estilo10" name="txtclasificacion" size="1" id="txtclasificacion" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)">
                      <option>PROVEEDOR</option>  <option>CONTRATISTA</option> <option>MICROEMPRESAS</option><option>COLABORACIONES</option> <option>EMPLEADO</option> <option>PASANTES</option> <option>OTROS</option>  </select>  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
              <tr>
                <td width="103"><span class="Estilo5">TIPO DE ORDEN:</span></td>
                <td width="76"><span class="Estilo5">  <input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" size="10" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)"> </span></td>
                <td width="35"><input class="Estilo10" name="bttipo_orden" type="button" id="bttipo_orden" title="Abrir Catalogo Tipos de Orden" onclick="VentanaCentrada('../pagos/Cat_tipo_orden.php?criterio=','SIA','','750','500','true')" value="..." onKeypress="return stabular(event,this)"></td>
                <td width="566"><span class="Estilo5"> <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" size="85" readonly onKeypress="return stabular(event,this)"></span></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
             <td><table width="800">
               <tr>
                 <td width="70"><span class="Estilo5">BANCO :</span></td>
                 <td width="80"><span class="Estilo5"> <input class="Estilo10" name="txtgrupo_banco" type="text" id="txtgrupo_banco"  value="<?echo $campo_str1?>" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return stabular(event,this)" readonly>   </span></td>
				 <td width="50"><input class="Estilo10" name="btgrupo_banco" type="button" id="btgrupo_banco" title="Abrir Catalogo Grupo de Banco" onclick="VentanaCentrada('../bancos/Cat_grupo_banco.php?criterio=','SIA','','750','500','true')" value="..." onKeypress="return stabular(event,this)"></td>
                 <td width="650"><span class="Estilo5"><input class="Estilo10" name="txtnombre_grupob" type="text" id="txtnombre_grupob"  value="<?echo $nombre_grupob?>" size="100" maxlength="100" readonly onKeypress="return stabular(event,this)">  </span></td>
                </tr>
             </table></td>
           </tr>		   
		   <tr>
             <td><table width="800">
               <tr>
			     <td width="150"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                 <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txtnro_cuenta" type="text" id="txtnro_cuenta"  value="<?echo $campo_str2?>" size="30" maxlength="30" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)"> </span></td>
                 <td width="350"><span class="Estilo5"></span></td>
               </tr>
             </table></td>
           </tr>
          <tr> <td>&nbsp;</td></tr>
        </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input class="Estilo10" name="Grabar" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88"><input class="Estilo10" name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
            </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>