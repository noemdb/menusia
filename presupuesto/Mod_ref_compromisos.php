<?php include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){ $referencia_comp=''; $tipo_compromiso=''; $cod_comp='';}else { $referencia_comp = $_GET["txtreferencia_comp"]; $tipo_compromiso = $_GET["txttipo_compromiso"]; $cod_comp = $_GET["txtcod_comp"];}
$sql="Select * from COMPROMISOS where tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_comp='$cod_comp'" ;  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Compromisos Presupuestario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
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
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtreferencia_comp.value==""){alert("Referencia no puede estar Vacio");return false;}
    if(f.txttipo_compromiso.value==""){alert("Tipo de Compromiso no puede estar Vacio"); return false; }  else{f.txttipo_compromiso.value=f.txttipo_compromiso.value.toUpperCase();}
    if(f.txtDescripcion.value==""){alert("Descripcion del Compromiso no puede estar Vacia"); return false; } else{f.txtDescripcion.value=f.txtDescripcion.value.toUpperCase();}
    if(f.txtreferencia_comp.value.length==8){f.txtreferencia_comp.value=f.txtreferencia_comp.value.toUpperCase();}      else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;}  else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_compromiso.value=="0000" || f.txttipo_compromiso.value=="A000" || f.txttipo_compromiso.value.substring(0,1)=="A") {alert("Tipo de Compromiso No Aceptado");return false; }
    if(f.txtreferencia_comp_new.value.length==8){f.txtreferencia_comp_new.value=f.txtreferencia_comp_new.value.toUpperCase();}      else{alert("Longitud de Referencia Nueva Invalida");return false;}
    if(f.txtreferencia_comp_new.value==f.txtreferencia_comp.value){alert("Referencia Nueva Invalida");return false;}    
	r=confirm("Desea Modificar la Referencia del Compromiso ?");  if (r==true) { valido=true;} else{return false;} 
	document.form1.submit;
return true;}
function modificar_ref_comp(){var f=document.form1; var mref;  mref=f.txtreferencia_comp.value;
  murl="Mod_ref_compromisos.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value+"&txtcod_comp="+document.form1.txtcodigo_comp.value; document.location=murl;
}
</script>
</head>
<?php 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$descripcion="";$fecha="";$unidad_sol="";$des_unidad_sol="";$nombre_abrev_comp="";$cod_tipo_comp="";$des_tipo_comp=""; $ced_rif="";$nombre="";$fecha_vencim="";
$nro_documento="";$num_proyecto="";$des_proyecto="";$func_inv="";$tiene_anticipo="";$tasa_anticipo="";$cod_con_anticipo="";$inf_usuario="";$anulado="";$modulo="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
  $referencia_comp=$registro["referencia_comp"];  $cod_comp=$registro["cod_comp"];  $fecha=$registro["fecha_compromiso"];  $tipo_compromiso=$registro["tipo_compromiso"];
  $descripcion=$registro["descripcion_comp"];  $inf_usuario=$registro["inf_usuario"];  $nombre_abrev_comp=$registro["nombre_abrev_comp"];   $unidad_sol=$registro["unidad_sol"];
  $des_unidad_sol=$registro["denominacion_cat"];  $cod_tipo_comp=$registro["cod_tipo_comp"];  $des_tipo_comp=$registro["des_tipo_comp"];  $ced_rif=$registro["ced_rif"];
  $nombre=$registro["nombre"];  $fecha_vencim=$registro["fecha_vencim"];  $nro_documento=$registro["nro_documento"];  $num_proyecto=$registro["num_proyecto"];
  $des_proyecto=$registro["des_proyecto"];  $func_inv=$registro["func_inv"];  $tiene_anticipo=$registro["tiene_anticipo"];  $tasa_anticipo=$registro["tasa_anticipo"];
  $cod_con_anticipo=$registro["cod_con_anticipo"];  $anulado=$registro["anulado"];  $modulo=$registro["modulo"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
if($tiene_anticipo=="S"){$tiene_anticipo="SI";}else{$tiene_anticipo="NO";}
$clave=$tipo_compromiso.$referencia_comp.$cod_comp;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR REFERENCIA COMPROMISOS PRESUPUESTARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="436" border="0" id="tablacuerpo">
  <tr>
    <td height="432"><table width="92" height="431" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablamenu">
        <td width="86">
      <td>
      <table width="92" height="423" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_compromisos.php?Gcriterio=<?php  echo $tipo_compromiso.$referencia_comp.$cod_comp; ?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:LlamarURL('Act_compromisos.php?Gcriterio=<?php  echo $tipo_compromiso.$referencia_comp.$cod_comp; ?>')">Atras</A></td>
      </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
     </tr>
    <tr>
       <td>&nbsp;</td>
     </tr>
    </table></td>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:874px; height:458px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Update_ref_compromisos.php" onSubmit="return revisar()">
      <table width="869" >
              <tr>
                <td>
                  <table width="866" align="center">
                    <tr>
                      <td><table width="832" border="0">
                        <tr>
                          <td width="168">
                          <p><span class="Estilo5">DOCUMENTO COMPROMISO:</span></p>                          </td>
                          <td width="43"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" value="<?php echo $tipo_compromiso?>" size="6" readonly></td>
                          <td width="93"><span class="Estilo5"><input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" size="6" value="<?php echo $nombre_abrev_comp?>" readonly>   </span></td>
                          <td width="87"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="170"><input name="txtreferencia_comp" type="text" id="txtreferencia_comp"  value="<?php echo $referencia_comp?>" readonly ></td>
                          <td width="63"><span class="Estilo5">FECHA :</span> </td>
                          <td width="114"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10" value="<?php echo $fecha?>" readonly ></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="830">
                        <tr>
                          <td width="177"><p><span class="Estilo5">CATEGORIA PROGRAMATICA:</span></p></td>
                          <td width="125"><input name="txtunidad_sol" type="text"  id="txtunidad_sol" value="<?php echo $unidad_sol?>" size="20" readonly></td>
                          <td width="453"><input name="txtdes_unidad_sol" type="text"  id="txtdes_unidad_sol" size="70" value="<?php echo $des_unidad_sol?>" readonly></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="829">
                        <tr>
                          <td width="162"><span class="Estilo5">TIPO DE COMPROMISO:</span></td>
                          <td width="50"><input name="txtcod_tipo_comp" type="text"  id="txtcod_tipo_comp" size="8" readonly value="<?php echo $cod_tipo_comp?>"></td>
                          <td width="40"></td>
                          <td width="542"><span class="Estilo5"><input name="txtdes_tipo_comp" type="text" id="txtdes_tipo_comp" size="83" value="<?php echo $des_tipo_comp?>" readonly> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                     <tr>
                      <td><table width="814">
                        <tr>
                          <td width="166"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="150"><span class="Estilo5"><input name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15"  value="<?php echo $ced_rif?>" readonly>  </span></td>
                          <td width="482"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" value="<?php echo $nombre?>" size="70" readonly>   </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtDescripcion" cols="85" readonly="readonly" class="headers" id="texDescripcion"><?php echo $descripcion?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>                   
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
					<tr>
						<td><table width="810" border="0">
						  <tr>
							<td width="260"><span class="Estilo5">REFERENCIA DE COMPROMISO NUEVO :</span></span></td>
							<td width="250"><input class="Estilo10" name="txtreferencia_comp_new" type="text" class="Estilo5"  id="txtreferencia_comp_new" size="10" maxlength="8" onFocus="encender(this);" onBlur="apagar(this);" value="<?php echo $referencia_comp?>" >   </td>		
							<td width="300"><span class="Estilo5">                </span></td>
						  </tr>
						</table></td>
					 </tr>
					  <tr>
						<td>&nbsp;</td>
					  </tr>
                  </table>  </td>
              </tr>
          </table>
		  <table width="768">
          <tr>
		    <td width="300">&nbsp;</td>
			<td width="268"><input name="txtcod_comp" type="hidden" id="txtcod_comp" value="<?php echo $cod_comp?>"></td>
            <td width="100" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="100"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>
