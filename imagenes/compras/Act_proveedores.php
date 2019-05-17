<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103, campo104 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; $modulo="09";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $Nom_usuario=$registro["campo104"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="09"; $opcion="01-0000045"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){ $ced_rif=''; $sql="SELECT * FROM COMP005 ORDER BY ced_rif"; $p_letra="";}
else {$ced_rif = $_GET["Gced_rif"];$p_letra=substr($ced_rif, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$ced_rif=substr($ced_rif,1,12);} else{$ced_rif=substr($ced_rif,0,12);}
  $sql="Select * from COMP005 where ced_rif='$ced_rif'";
  if ($p_letra=="P"){$sql="SELECT * FROM COMP005 ORDER BY ced_rif";}
  if ($p_letra=="U"){$sql="SELECT * From COMP005 Order by ced_rif desc";}
  if ($p_letra=="S"){$sql="SELECT * From COMP005 Where (ced_rif>'$ced_rif') Order by ced_rif";}
  if ($p_letra=="A"){$sql="SELECT * From COMP005 Where (ced_rif<'$ced_rif') Order by ced_rif desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA COMPRAS,SERVICIOS Y ALMAC&Eacute;N (Actualiza Proveedores)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Gced_rif = "";
function Llamar_Incluir(mop){ document.form2.submit(); }
function Llamar_Ventana(url){var murl;
    Gced_rif=document.form1.txtced_rif.value;murl=url+Gced_rif;
    if (Gced_rif==""){alert("Cédula/Rif debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_proveedores.php";
   if(MPos=="P"){murl="Act_proveedores.php?Gced_rif=P"}
   if(MPos=="U"){murl="Act_proveedores.php?Gced_rif=U"}
   if(MPos=="S"){murl="Act_proveedores.php?Gced_rif=S"+document.form1.txtced_rif.value;}
   if(MPos=="A"){murl="Act_proveedores.php?Gced_rif=A"+document.form1.txtced_rif.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar el Proveedor ?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar el Proveedor ?");
    if (r==true) {url="Delete_proveedor.php?Gced_rif="+document.form1.txtced_rif.value; VentanaCentrada(url,'Eliminar Proveedor','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js"  type=text/javascript></SCRIPT>
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
</head>
<?
$nombre_proveedor="";$rif_proveedor="";$nit_proveedo="";$nit=""; $direccion="";$tipo_benef=""; $ci_rep_legal=""; $nom_rep_legal="";
$persona_contacto="";  $telefono=""; $fax=""; $tlf_movil=""; $email_proveed=""; $observacion="";  $web_site_proveed=""; $ramo_venta="";
$cod_pos_proveedor=""; $aptd_pos_proveedor=""; $nro_sso="";$nro_ince="";$inf_usuario=""; $tiene_alcaldia=""; $nro_alcaldia="";
$tiene_gobernacion=""; $nro_gobernacion=""; $nro_gobernacion2=""; $fecha_reg_gob="";  $tiene_ocei=""; $nro_ocei=""; $monto_ocei=0;
$nro_otro1=""; $nro_otro2="";$exon_inscripcion="";  $exon_licitacion=""; $capital_suscripto=0; $capital_pagado=0;  $cta_banco_empresa="";
$fecha_registro=""; $circunscripcion_j=""; $nro_registro=""; $tomo_registro=""; $folio_registro=""; $status_proveed="";
$porc_ret_iva=0; $porc_ret_islr=0; $porc_ret_alcaldia=0; $porc_ret_otro=0;$tipo_empresa="";$exon_iva="";$campo_str1=""; $campo_str2=""; $campo_num1=0; $campo_num2=0;
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From COMP005 ORDER BY ced_rif";} if ($p_letra=="A"){$sql="SELECT * From COMP005 ORDER BY ced_rif desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0);
  $ced_rif=$registro["ced_rif"]; $nombre_proveedor=$registro["nombre_proveedor"];$rif_proveedor=$registro["rif_proveedor"];
  $nit_proveedor=$registro["nit_proveedor"]; $direccion=$registro["direccion_proveedor"];$tipo_benef=$registro["tipo"];
  $ci_rep_legal=$registro["ci_rep_legal"]; $nom_rep_legal=$registro["nom_rep_legal"]; $persona_contacto=$registro["persona_contacto"];
  $telefono=$registro["telefono_proveedor"];$fax=$registro["fax_proveedor"];$tlf_movil=$registro["tlf_movil_proveedor"];
  $email_proveed=$registro["email_proveed"]; $observacion=$registro["observacion"]; $web_site_proveed=$registro["web_site_proveed"];
  $ramo_venta=$registro["ramo_venta"]; $cod_pos_proveedor=$registro["cod_pos_proveedor"]; $aptd_pos_proveedor=$registro["aptd_pos_proveedor"];
  $nro_sso=$registro["nro_sso"]; $nro_ince=$registro["nro_ince"]; $inf_usuario=$registro["inf_usuario"]; $tiene_alcaldia=$registro["tiene_alcaldia"]; $nro_alcaldia=$registro["nro_alcaldia"];
  $tiene_gobernacion=$registro["tiene_gobernacion"];$nro_gobernacion=$registro["nro_gobernacion"]; $nro_gobernacion2=$registro["nro_gobernacion2"]; $fecha_reg_gob=$registro["fecha_reg_gob"];
  $tiene_ocei=$registro["tiene_ocei"]; $nro_ocei=$registro["nro_ocei"]; $monto_ocei=$registro["monto_ocei"]; $monto_ocei=formato_monto($monto_ocei); $nro_otro1=$registro["nro_otro1"];
  $nro_otro2=$registro["nro_otro2"]; $exon_inscripcion=$registro["exon_inscripcion"]; $exon_licitacion=$registro["exon_licitacion"]; $capital_suscripto=$registro["capital_suscripto"]; $capital_suscripto=formato_monto($capital_suscripto);
  $capital_pagado=$registro["capital_pagado"]; $capital_pagado=formato_monto($capital_pagado); $fecha_registro=$registro["fecha_registro"]; $circunscripcion_j=$registro["circunscripcion_j"];
  $nro_registro=$registro["nro_registro"]; $tomo_registro=$registro["tomo_registro"]; $folio_registro=$registro["folio_registro"]; $status_proveed=$registro["status_proveed"];
  $porc_ret_iva=$registro["porc_ret_iva"]; $porc_ret_islr=$registro["porc_ret_islr"]; $porc_ret_alcaldia=$registro["porc_ret_alcaldia"]; $porc_ret_otro=$registro["porc_ret_otro"];
  $cta_banco_empresa=$registro["cta_banco_empresa"];$tipo_empresa=$registro["tipo_empresa"]; $exon_iva=$registro["exon_iva"];
  $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"]; $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"];
  $fecha_registro=formato_ddmmaaaa($fecha_registro); $fecha_reg_gob=formato_ddmmaaaa($fecha_reg_gob);
  }
$Ssql="Select * from SIA000"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$reg_e=$registro["campo041"];$edo_e=$registro["campo010"];$mun_e=$registro["campo011"];$ciu_e=$registro["campo009"];}else{$reg_e="REGION CENTRO-OCCIDENTAL";$edo_e="LARA";$mun_e="IRIBARREN";$ciu_e="BARQUISIMETO";}
$cod_e="00"; $Ssql="SELECT * FROM pre091 where nro_gobernacion='".$edo_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_e=$registro["cod_estado"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">PROVEEDORES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="785" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="780" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Incluir()";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Incluir()">Incluir</A></td>
      </tr>
	  <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_proveedor.php?Gced_rif=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_proveedor.php?Gced_rif=');">Modificar</A></td>
      </tr>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Req_proveedor.php?Gced_rif=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Req_proveedor.php?Gced_rif=');">Requi/Solven</A></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_proveedores.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_proveedores.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
	  <? }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
 <tr><td>&nbsp;</td> </tr>
 </table></td>
     <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:860px; height:750px; z-index:1; top: 70px; left: 110px;">
        <form name="form1" method="post" action="">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="865">
               <tr>
                 <td width="85"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                 <td width="220"><span class="Estilo5"><input name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15"  value="<?echo $ced_rif?>" readonly> </span></td>
                 <td width="55"><span class="Estilo5">RIF :</span></td>
                 <td width="220"><span class="Estilo5"><input name="txtrif_proveedor" type="text" id="txtrif_proveedor" size="20" maxlength="15"  value="<?echo $rif_proveedor?>" readonly> </span></td>
                 <td width="55"><span class="Estilo5">NIT :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtnit_proveedor" type="text" id="txtnit_proveedor" size="20" maxlength="15"  value="<?echo $nit_proveedor?>" readonly>  </span></td>
                 <td width="50"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="865">
               <tr>
                 <td width="85"><span class="Estilo5">NOMBRE  :</span></td>
                 <td width="780"><span class="Estilo5"><input name="txtnombre_proveedor" type="text" id="txtnombre_proveedor" value="<?echo $nombre_proveedor?>" size="100" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="865">
               <tr>
                 <td width="85"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="780"><textarea name="txtdireccion" cols="85" readonly="readonly" class="headers" id="txtdireccion"><?echo $direccion?></textarea></td>
               </tr>
             </table></td>
           </tr>
                   <table width="828" align="center">
           <tr>
             <td><table width="865">
                 <tr>
                   <td width="85"><span class="Estilo5">TELEFONOS:</span></td>
                   <td width="240"><span class="Estilo5"><input name="txttelefono" type="text" id="txttelefono" size="25" maxlength="25"  value="<?echo $telefono?>" readonly> </span></td>
                   <td width="55"><span class="Estilo5">FAX :</span></td>
                   <td width="230"><span class="Estilo5"><input name="txtfax" type="text" id="txtfax" size="20" maxlength="20"  value="<?echo $fax?>" readonly></span></td>
                   <td width="110"><span class="Estilo5">COD. POSTAL :</span></td>
                   <td width="160"><span class="Estilo5"><input name="txtcod_pos_proveedor" type="text" id="txtcod_pos_proveedor" size="20" maxlength="10"  value="<?echo $cod_pos_proveedor?>" readonly></span></td>
                 </tr>
             </table></td>
           </tr>
                   <tr>
             <td><table width="865">
                 <tr>
                   <td width="130"><span class="Estilo5">APARTADO POSTAL:</span></td>
                   <td width="300"><span class="Estilo5"><input name="txtaptd_pos_proveedor" type="text" id="txtaptd_pos_proveedor" size="25" maxlength="10"  value="<?echo $aptd_pos_proveedor?>" readonly></span></td>
                    <td width="145"><span class="Estilo5">TIPO DE PROVEEDOR :</span></td>
                   <td width="290"><span class="Estilo5"><input name="txttipo_benef" type="text" id="txttipo_benef" size="30"  value="<?echo $tipo_benef?>" readonly></span></td>
                 </tr>
             </table></td>
           </tr>
                   <tr>
             <td><table width="865">
                 <tr>
                   <td width="160"><span class="Estilo5">CORREO ELECTRONICO :</span></td>
                   <td width="305"><span class="Estilo5"><input name="txtemail_proveed" type="text" id="txtemail_proveed" size="40" maxlength="50"  value="<?echo $email_proveed?>" readonly></span></td>
                   <td width="120"><span class="Estilo5">PAGINA WEB:</span></td>
                   <td width="280"><span class="Estilo5"><input name="txtweb_site_proveed" type="text" id="txtweb_site_proveed" size="35" maxlength="50"  value="<?echo $web_site_proveed?>" readonly> </span></td>
                 </tr>
             </table></td>
           </tr>
                   <tr>
             <td><table width="865">
               <tr>
                 <td width="165"><span class="Estilo5">PRESONA CONTACTO:</span></td>
                 <td width="700"><span class="Estilo5"><input name="txtpersona_contacto" type="text" id="txtpersona_contacto" value="<?echo $persona_contacto?>" size="95" readonly></span></td>
               </tr>
             </table></td>
           </tr>
                   <tr>
             <td><table width="865">
               <tr>
                 <td width="105"><span class="Estilo5">TIPO EMPRESA :</span></td>
                 <td width="335"><span class="Estilo5"><input name="txttipo_empresa" type="text" id="txttipo_empresa" size="50"  value="<?echo $tipo_empresa?>" readonly> </span></td>
                 <td width="165"><span class="Estilo5">NRO. CTA. BANCARIA :</span></td>
                 <td width="260"><span class="Estilo5"><input name="txtcta_banco_empresa" type="text" id="txtcta_banco_empresa" size="25"  value="<?echo $cta_banco_empresa?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="865">
               <tr>
                 <td width="165"><span class="Estilo5">C&Eacute;DULA/RIF REP. LEGAL :</span></td>
                 <td width="290"><span class="Estilo5"><input name="txtci_rep_legal" type="text" id="txtci_rep_legal" size="20" maxlength="12"  value="<?echo $ci_rep_legal?>" readonly> </span></td>
                 <td width="120"><span class="Estilo5">TELEFONO MOVIL :</span></td>
                 <td width="290"><span class="Estilo5"><input name="txttlf_movil" type="text" id="txttlf_movil" size="20" maxlength="20"  value="<?echo $tlf_movil?>" readonly> </span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="865">
               <tr>
                 <td width="155"><span class="Estilo5">NOMBRE REP. LEGAL :</span></td>
                 <td width="710"><span class="Estilo5"><input name="txtnom_rep_legal" type="text" id="txtnom_rep_legal" value="<?echo $nom_rep_legal?>" size="80" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="865">
                 <tr>
                   <td width="130"><span class="Estilo5">CAPITAL INICIAL:</span></td>
                   <td width="180"><span class="Estilo5"><input name="txtcapital_suscripto" type="text" id="txtcapital_suscripto" size="16" align="right" maxlength="16"  value="<?echo $capital_suscripto?>" readonly> </span></td>
                   <td width="130"><span class="Estilo5">CAPITAL ACTUAL :</span></td>
                   <td width="180"><span class="Estilo5"><input name="txtcapital_pagado" type="text" id="txtcapital_pagado" size="16" maxlength="16" align="right" value="<?echo $capital_pagado?>" readonly>  </span></td>
                   <td width="120"><span class="Estilo5">FECHA REGISTRO :</span></td>
                   <td width="125"><span class="Estilo5"><input name="txtfecha_registro" type="text" id="txtfecha_registro" size="10" maxlength="10"  value="<?echo $fecha_registro?>" readonly> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="865">
               <tr>
                 <td width="120"><span class="Estilo5">CIRCUSCRIPCION :</span></td>
                 <td width="520"><span class="Estilo5"><input name="txtcircunscripcion_j" type="text" id="txtcircunscripcion_j" value="<?echo $circunscripcion_j?>" size="60" readonly></span></td>
                  <td width="110"><span class="Estilo5">NRO. REGISTRO :</span></td>
                 <td width="115"><span class="Estilo5"><input name="txtnro_registro" type="text" id="txtnro_registro" size="10" maxlength="10"  value="<?echo $nro_registro?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
                   <td><table width="865">
               <tr>
                 <td width="115"><span class="Estilo5">TOMO NUMERO :</span></td>
                 <td width="450"><span class="Estilo5"><input name="txttomo_registro" type="text" id="txttomo_registro" size="20" maxlength="20"  value="<?echo $tomo_registro?>" readonly> </span></td>
                 <td width="100"><span class="Estilo5">FOLIO :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtfolio_registro" type="text" id="txtfolio_registro" size="20" maxlength="20"  value="<?echo $folio_registro?>" readonly> </span></td>
                </tr>
             </table></td>
           </tr>
            <tr>
             <td><table width="865">
               <tr>
                 <td width="115"><span class="Estilo5">OBSERVACION :</span></td>
                 <td width="750"><span class="Estilo5"><input name="txtobservacion" type="text" id="txtobservacion" value="<?echo $observacion?>" size="100" readonly></span></td>
               </tr>
             </table></td>
           </tr>
                   <td><table width="865">
               <tr>
                 <td width="165"><span class="Estilo5">NRO. INSCRIPCION IVSS :</span></td>
                 <td width="280"><span class="Estilo5"><input name="txtnro_sso" type="text" id="txtnro_sso" size="20" maxlength="20"  value="<?echo $nro_sso?>" readonly> </span></td>
                 <td width="170"><span class="Estilo5">NRO. INSCRIPCION INCE :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtnro_ince" type="text" id="txtnro_ince" size="20" maxlength="20"  value="<?echo $nro_ince?>" readonly> </span></td>
                </tr>
             </table></td>
           </tr>
                   <td><table width="865">
               <tr>
                 <td width="195"><span class="Estilo5">NRO. INSCRIPCION LABORAL :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtnro_otro1" type="text" id="txtnro_otro1" size="20" maxlength="20"  value="<?echo $nro_otro1?>" readonly> </span></td>
                 <td width="200"><span class="Estilo5">NRO. INSCRIPCION SUNACOP :</span></td>
                 <td width="220"><span class="Estilo5"><input name="txtnro_otro2" type="text" id="txtnro_otro2" size="20" maxlength="20"  value="<?echo $nro_otro2?>" readonly> </span></td>
                </tr>
             </table></td>
           </tr>
                   <tr>
             <td><table width="865">
                 <tr>
                   <td width="85"><span class="Estilo5">TIENE SNC:</span></td>
                   <td width="150"><span class="Estilo5"><input name="txttiene_ocei" type="text" id="txttiene_ocei" size="3" maxlength="2"  value="<?echo $tiene_ocei?>" readonly>  </span></td>
                   <td width="80"><span class="Estilo5">NUMERO:</span></td>
                   <td width="200"><span class="Estilo5"><input name="txtnro_ocei" type="text" id="txtnro_ocei" size="20" maxlength="20"  value="<?echo $nro_ocei?>" readonly> </span></td>
                   <td width="160"><span class="Estilo5">MONTO FINANCIERO INE:</span></td>
                   <td width="210"><span class="Estilo5"><input name="txtmonto_ocei" type="text" id="txtmonto_ocei" size="20" maxlength="20" align="right"  value="<?echo $monto_ocei?>" readonly></span></td>
                 </tr>
             </table></td>
           </tr>

                   <tr>
             <td><table width="865">
               <tr>
                 <td width="240"><span class="Estilo5">TIENE INSCRIPCION GOBERNACION :</span></td>
                 <td width="100"><span class="Estilo5"> <input name="txttiene_gobernacion" type="text" id="txttiene_gobernacion" size="3"  value="<?echo $tiene_gobernacion?>" readonly></span></td>
                 <td width="75"><span class="Estilo5">NUMERO:</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtnro_gobernacion" type="text" id="txtnro_gobernacion" size="25"  value="<?echo $nro_gobernacion?>" readonly></span></td>
                 <td width="75"><span class="Estilo5">FECHA  :</span></td>
                 <td width="160"><span class="Estilo5"><input name="txtfecha_reg_gob" type="text" id="txtfecha_reg_gob" size="10" maxlength="10"  value="<?echo $fecha_reg_gob?>" readonly> </span></td>

                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="865">
               <tr>
                 <td width="225"><span class="Estilo5">TIENE INSCRIPCION ALCALDIA :</span></td>
                 <td width="130"><span class="Estilo5"><input name="txttiene_alcaldia" type="text" id="txttiene_alcaldia" size="3"  value="<?echo $tiene_alcaldia?>" readonly></span></td>
                 <td width="75"><span class="Estilo5">NUMERO:</span></td>
                 <td width="435"><span class="Estilo5"><input name="txtnro_alcaldia" type="text" id="txtnro_alcaldia" size="25"  value="<?echo $nro_alcaldia?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="865">
                 <tr>
                   <td width="185"><span class="Estilo5">INSCRIPCION EXONERADA :</span></td>
                   <td width="115"><span class="Estilo5"><input name="txtexon_inscripcion" type="text" id="txtexon_inscripcion" size="3" maxlength="1"  value="<?echo $exon_inscripcion?>" readonly></span></td>
                   <td width="170"><span class="Estilo5">LICITACION EXONERADA :</span></td>
                   <td width="125"><span class="Estilo5"> <input name="txtexon_licitacion" type="text" id="txtexon_licitacion" size="3" maxlength="3"  value="<?echo $exon_licitacion?>" readonly></span></td>
                   <td width="140"><span class="Estilo5">EXONERADO IVA:</span></td>
                   <td width="130"><span class="Estilo5"><input name="txtexon_iva" type="text" id="txtexon_iva" size="3"  value="<?echo $exon_iva?>" readonly> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="865">
               <tr>
                 <td width="200"><span class="Estilo5">RAMO DE VENTA:</span></td>
                 <td width="665"><span class="Estilo5"><input readonly name="txtramo_venta" type="text" id="txtramo_venta" value="<?echo $ramo_venta?>" size="70"> </span></td>
               </tr>
             </table></td>
                        </tr>
        </table>
        <p>&nbsp;</p>
        </form>
    </div>    </td>
</tr>
</table>
<form name="form2" method="post" action="Inc_proveedor.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
  </tr>
</table>
</form>

</body>
</html>
<? pg_close();?>