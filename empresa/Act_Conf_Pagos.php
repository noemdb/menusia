<?php include ("../class/seguridad.inc");include ("../class/conects.php");include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $cod_modulo="01";
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONFIGURACI&Oacute;N ORDENAMIENTO DE PAGOS</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
    if(f.txtdoc_ord.value==""){alert("Documento de Orden no puede estar Vacio");return false;} else{f.txtdoc_ord.value=f.txtdoc_ord.value.toUpperCase();}
document.form1.submit;
return true;}
function LlamarURL(url) {document.location = url;}
</script>
</head>
<?php
$formato=""; $periodo="01"; $campo502=""; $temp="NO";
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"];
$tipo_op=$registro["campo504"];$tipo_opd=$registro["campo505"];$tipo_opf=$registro["campo506"];$tipo_opfa=$registro["campo507"];$tipo_opa=$registro["campo508"];$tipo_aju=$registro["campo509"];
} IF($periodo=="  "){$periodo="01";}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONFIGURACI&Oacute;N ORDENAMIENTO DE PAGOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="572" border="1">
  <tr>
    <td width="92"><table width="92" height="570" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=javascript:LlamarURL('menu_conf.php');
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="menu_conf.php">Atras</A></td>
      </tr>
	  
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
	  
  <td>&nbsp;</td>
  </tr> </table></td>
  <td width="892"><div id="Layer1" style="position:absolute; width:868px; height:629px; z-index:1; top: 65px; left: 112px;">
   <form name="form1" method="post" action="Update_conf_pagos.php" onSubmit="return revisar()">
   <table width="824" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="816" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td width="370" height="19"><table width="371" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5">GENERAR ORDEN DE PAGO DE RETENCION: </span></td>
					  <!--
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtord_ret" size="1"> <?php if(substr($campo502,0,1)=="S"){ $temp="NO"; ?><option selected>SI</option> <option>NO</option> </select><?php }else{ $temp="NO"; ?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
					  -->
					   <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtord_ret" type="text" id="txtord_ret" size="3"  value="<?php echo $temp?>" readonly>   </span></td>
                         
                    </tr>
                </table></td>
                <td width="434"><table width="430" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="344"><span class="Estilo5">GENERAR COMPROBANTE ORDEN  PAGO  RETENCI&Oacute;N: </span></td>
					  <!--
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtcomp_ret" size="1"> <?php if(substr($campo502,1,1)=="S"){ $temp="SI"; ?><option selected>SI</option> <option>NO</option> </select><?php }else{ $temp="NO"; ?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
					  -->
					  <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtcomp_ret" type="text" id="txtcomp_ret" size="3"  value="<?php echo $temp?>" readonly>   </span></td>
                      
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
		  <tr><td>&nbsp;</td> </tr>
          <tr>
            <td><table width="816" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td width="370" height="19"><table width="371" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5">N&Uacute;MERO ORDEN DE PAGO SOLO N&Uacute;MERO: </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtsolo_num" size="1"> <?php if(substr($campo502,3,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
                <td width="434"><table width="430" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="344"><span class="Estilo5"> ORDEN PAGO DE RETENCI&Oacute;N AFECTA PRESUPUESTO: </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtret_presup" size="1"> <?php if(substr($campo502,2,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td> </tr>
          <tr>
            <td><table width="816" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td width="370" height="19"><table width="371" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5">N&Uacute;MERO ORDEN DE PAGO AUTOMATICO: </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtnum_aut" size="1"> <?php if(substr($campo502,4,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
                <td width="434"><table width="430" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="344"><span class="Estilo5"> FECHA ORDEN DE PAGO AUTOMATICO: </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtfec_aut" size="1"> <?php if(substr($campo502,5,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td>  </tr>
          <tr>
            <td height="23"><table width="816" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td width="370" height="17"><table width="371" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5">IMP. FORMATOS ORDEN DE PAGO ANULADA: </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtforma_anu" size="1"> <?php if(substr($campo502,7,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
                <td width="434"><table width="430" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="344"><span class="Estilo5"> IMPRIMIR FORMATO ORDEN DE PAGO CANCELADAS: </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtforma_can" size="1"> <?php if(substr($campo502,6,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
		  <tr><td>&nbsp;</td></tr>
          <tr>
            <td height="22"><table width="816" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td width="370" height="16"><table width="371" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5">INICIALIZA PANTALLA ORDEN AL INCLUIR: </span></td>
					 
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtini_pant" size="1"> <?php if(substr($campo502,10,1)=="S"){ $temp="SI"; ?><option selected>SI</option> <option>NO</option> </select><?php }else{ $temp="NO";?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
					   <!--
					  
					  <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtini_pant" type="text" id="txtini_pant" size="3"  value="<?php echo $temp?>" readonly>   </span></td>
                      -->
                    </tr>
                </table></td>
                <td width="434"><table width="430" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="344"><span class="Estilo5"> MODIFICAR CUENTA POR PAGAR EN COMPROBANTE: </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtmod_cta" size="1"> <?php if(substr($campo502,12,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>          
          <tr>
            <td><table width="816" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td width="370" height="16"><table width="371" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5">VALIDAR C&Oacute;DIGO BANCO POR TIPO ORDEN: </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtban_tipo" size="1"> <?php if(substr($campo502,8,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
                <td width="434"><table width="430" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="344"><span class="Estilo5"> AMORTIZACI&Oacute;N ANTICIPO AFECTA PRESUPUESTO : </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtamort_pre" size="1"> <?php if(substr($campo502,14,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>          
          <tr>
            <td><table width="816" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td width="370" height="16"><table width="371" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5">COMPROBANTE RETENCION IVA CON ORDEN : </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtcomp_iva" size="1"> <?php if(substr($campo502,11,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
                <td width="434"><table width="430" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="344"><span class="Estilo5">PLANILLA RETENCION IMPUESTO CON ORDEN: </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtret_imp" size="1"> <?php if(substr($campo502,13,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>
		  <tr>
            <td><table width="816" border="1" cellspacing="1" cellpadding="0">
                <tr>
                   <td width="370"><table width="370" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="280"><span class="Estilo5">PERIODO TRABAJO DESDE DEL MODULO : </span></td>
                        <td width="90"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtperiodo" type="text" id="txtperiodo"  size="3" maxlength="2" value="<?php echo $periodo ?>"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
				  <td width="434"><table width="430" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="344"><span class="Estilo5"> ORDEN A RETENCION GENERA COMPROBANTE : </span></td>
                      <td width="90"><div align="center"><span class="Estilo5">
                        <select name="txtorden_ret_comp" size="1"> <?php if(substr($campo502,15,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                </table></td>
                </tr>
            </table></td>
          </tr>
		   <tr><td>&nbsp;</td> </tr>
		  <tr>
            <td><table width="816" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td><table width="450" height="19" border="0" cellpadding="0" dwcopytype="CopyTableRow">
                    <tr>
                      <td width="350"><span class="Estilo5">TIPO DOCUMENTO ORDEN DE PAGO:</span></td>
                      <td width="100"> <div align="center"><span class="Estilo5"><input class="Estilo10" name="txtdoc_ord" type="text" id="txtdoc_ord" size="5" maxlength="4" value="<?php echo $tipo_op ?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></div></td></tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="450" height="19" border="0" cellpadding="0" dwcopytype="CopyTableRow">
                  <tr>
                    <td width="350"><span class="Estilo5">TIPO DOCUMENTO ORDEN DE PAGO DIRECTA:</span></td>
                    <td width="100"> <div align="center"><span class="Estilo5"><input class="Estilo10" name="txtdoc_ordd" type="text" id="txtdoc_ordd" size="5" maxlength="4" value="<?php echo $tipo_opd ?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></div></td></tr>
                 </table></td>
              </tr>
			  <tr>
                <td><table width="450" height="19" border="0" cellpadding="0" dwcopytype="CopyTableRow">
                  <tr>
                    <td width="350"><span class="Estilo5">TIPO DOCUMENTO ORDEN DE PAGO FINANCIERA:</span></td>
                    <td width="100"> <div align="center"><span class="Estilo5"><input class="Estilo10" name="txtdoc_ordf" type="text" id="txtdoc_ordf" size="5" maxlength="4" value="<?php echo $tipo_opf ?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></div></td></tr>
                 </table></td>
              </tr>
              <tr>
                <td><table width="450" height="19" border="0" cellpadding="0" dwcopytype="CopyTableRow">
                  <tr>
                    <td width="350"><span class="Estilo5">TIPO DOCUMENTO ORDEN DE PAGO DEL ANTICIPO:</span></td>
                    <td width="100"> <div align="center"><span class="Estilo5"><input class="Estilo10" name="txtdoc_orda" type="text" id="txtdoc_orda" size="5" maxlength="4" value="<?php echo $tipo_opa ?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></div></td></tr>
                 </table></td>
              </tr>
              <tr>
                <td><table width="450" height="19" border="0" cellpadding="0" dwcopytype="CopyTableRow">
                  <tr>
                    <td width="350"><span class="Estilo5">TIPO DOCUMENTO AJUSTE A ORDEN DE PAGO:</span></td>
                    <td width="100"> <div align="center"><span class="Estilo5"><input class="Estilo10" name="txtdoc_aju" type="text" id="txtdoc_aju" size="5" maxlength="4" value="<?php echo $tipo_aju ?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></div></td></tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>		  
	</table>	
	<table width="768">
          <tr>
            <td width="650">&nbsp;</td>
            <td width="50"><input  name="txtcod_modulo" type="hidden" id="txtcod_modulo" value="<?php echo $cod_modulo?>" ></td>
            <td width="68" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
          </tr>
    </table>        
   </form> 
  </div></td>        
  </tr>
</table>
</body>
</html>
<?php pg_close(); ?>
