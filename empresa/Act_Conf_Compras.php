<?php include ("../class/seguridad.inc");include ("../class/conects.php");include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $cod_modulo="09";
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONFIGURACI&Oacute;N COMPRAS,SERVICIOS ALMACEN</title>
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
function revisar(){var f=document.form1;
    if(f.txtcod_modulo.value==""){alert("Modulo no puede estar Vacio");return false;}
document.form1.submit;
return true;}
function LlamarURL(url) {document.location = url;}
</script>
</head>
<?php
$campo502=""; $periodo="01"; $campo573=""; $campo504=""; $campo505=""; $campo507=""; $campo508="";  $campo509=""; $campo510=""; $campo511="";  $campo512=""; $campo513="";
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"];$periodo=$registro["campo503"]; $campo504=$registro["campo504"]; $campo505=$registro["campo505"]; 
$campo507=$registro["campo507"]; $campo508=$registro["campo508"]; $campo509=$registro["campo509"]; $campo510=$registro["campo510"]; $campo573=$registro["campo573"]; $campo511=$registro["campo511"];  $campo512=$registro["campo512"]; $campo513=$registro["campo513"];
}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONFIGURACI&Oacute;N COMPRAS,SERVICIOS ALMACEN</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="682" border="1">
  <tr>
    <td width="92"><table width="92" height="677" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=javascript:LlamarURL('menu_conf.php');
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_conf.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="892"><div id="Layer1" style="position:absolute; width:868px; height:991px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Update_compras.php" onSubmit="return revisar()">
        <table width="865" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
            <td><table width="860" border="1" cellspacing="2" cellpadding="0">
               <tr>
		         <td width="330"><table width="330"  border="0" cellpadding="0">
                    <tr>
					   <td width="250"><span class="Estilo5">APLICAR IMPUESTO A C&Oacute;DIGO UNICO :</span></td>
					    <td width="70" align="center"><span class="Estilo5">
                          <select name="txtimp_unico" size="1" id="txtimp_unico"><?if (substr($campo573,1,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>
				 <td width="530"><table width="520"  border="0" cellpadding="0">
                    <tr>
					   <td width="150"><span class="Estilo5">C&Oacute;DIGO IMPUESTO:</span></td>
					    <td width="70" align="center"><span class="Estilo5">
                          <select name="txtcod_imp" size="1" id="txtcod_imp"><?if (substr($campo573,2,1)=="S"){ ?><option selected>PARTIDA</option> <option>PRESUPUESTARIO</option> </select><?}else{?><option>PARTIDA</option> <option selected>PRESUPUESTARIO</option> </select> <?}?>
                        </span></td>
					   <td width="300"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtcod_impuesto" type="text" id="txtcod_impuesto"  size="35" maxlength="35"  value="<?echo $campo509?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                        	
                    </tr>
                 </table></td>
                  
			   </tr>
            </table></td>  
          </tr>
		  <tr>
            <td><table width="660" height="17" border="1" cellpadding="0" cellspacing="1" >
              <tr>
                <td width="330"><table width="330" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5">PERIODO TRABAJO DESDE DEL M&Oacute;DULO:</span></td>
                      <td width="50"><div align="right"><span class="Estilo5"><input class="Estilo10" name="txtperiodo" type="text" id="txtperiodo" size="3" maxlength="2" value="<?echo $periodo ?>"  onFocus="encender(this)" onBlur="apagar(this)"> </span></div></td>
                    </tr>
                </table></td>
				 <td width="430"><table width="420"  border="0" cellpadding="0">
                  <tr>
                    <td width="350"><span class="Estilo5"> TIPO DOCUMENTO AJUSTE:</span></td>
                    <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtdoc_ajus" type="text" id="txtdoc_ajus"  size="4" maxlength="4" value="<?echo $campo510 ?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
		  <tr> <td >&nbsp;</td></tr> 
		  		  
          <tr>
            <td height="16"><table width="171" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="163" align="center"><span class="Estilo14">ORDENES DE COMPRA </span></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td >&nbsp;</td></tr>
		  <tr>
            <td><table width="860" border="1" cellspacing="2" cellpadding="0">
               <tr>
		         <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">N&Uacute;MERO DE MOVIMIENTOS AUTOMATICO:</span></td>
					    <td width="80" align="center"><span class="Estilo5">
                          <select name="txtref_aut" size="1" id="txtref_aut"><?if (substr($campo502,3,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>
				 <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">FECHA DE MOVIMIENTOS AUTOMATICO:</span></td>
					    <td width="80" align="center"><span class="Estilo5">
                          <select name="txtfecha_aut" size="1" id="txtfecha_aut"><?if (substr($campo502,4,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>                  
			   </tr>
            </table></td>  
           </tr>
		   <tr>
            <td><table width="860" border="1" cellspacing="2" cellpadding="0">
               <tr>
		         <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">VALIDAR NUMERO DE REQUISICI&Oacute;N EN ORDEN:</span></td>
					    <td width="80" align="center"><span class="Estilo5">
                          <select name="txtnro_req" size="1" id="txtnro_req"><?if (substr($campo502,1,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>
				 <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">VALIDAR REQUISICI&Oacute;N APROBADA EN LA ORDEN:</span></td>
					    <td width="80" align="center"><span class="Estilo5">
                          <select name="txtreq_ap" size="1" id="txtreq_ap"><?if (substr($campo502,2,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>                  
			   </tr>
            </table></td>  
           </tr>
		   <tr>
            <td><table width="860" border="1" cellspacing="2" cellpadding="0">
               <tr>
		         <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">VALIDAR MARCA Y MODELO EN ORDENES:</span></td>
					    <td width="80" align="center"><span class="Estilo5">
                          <select name="txtval_marca" size="1" id="txtval_marca"><?if (substr($campo502,5,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>
				 <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">MODIFICAR C&Oacute;DIGO PRESUPUESTARIO EN ORDENES:</span></td>
					    <td width="80" align="center"><span class="Estilo5">
                          <select name="txtmod_cod_presup" size="1" id="txtmod_cod_presup"><?if (substr($campo502,6,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>                  
			   </tr>
            </table></td>  
           </tr>
           <tr>
            <td><table width="860" border="1" cellpadding="0" cellspacing="2">
              <tr>
                <td width="430"><table width="420"  border="0" cellpadding="0">
                  <tr>
                    <td width="350"><span class="Estilo5"> TIPO DOCUMENTO ORDEN DE COMPRA:</span></td>
                    <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtdoc_comp" type="text" id="txtdoc_comp"  size="4" maxlength="4" value="<?echo $campo504 ?>" onFocus="encender(this)" onBlur="apagar(this)">
                    </span></td>
                  </tr>
                </table></td>
                
                <td width="430"><table width="420" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="350"><span class="Estilo5"> TIPO COMPROMISO ORDEN DE COMPRA:</span></td>
                    <td width="80"><span class="Estilo5"><input class="Estilo10" name="txttip_comp" type="text" id="txttip_comp"  size="6" maxlength="6"  value="<?echo $campo507 ?>" onFocus="encender(this)" onBlur="apagar(this)">
                    </span></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
           </tr>
		   <tr>
            <td><table width="860" border="1" cellspacing="2" cellpadding="0">
               <tr>
		         <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">APARTADO PRESUP. CON REQUISICIONES :</span></td>
					    <td width="70" align="center"><span class="Estilo5">
                          <select name="txtgen_apart_r" size="1" id="txtgen_apart_r"><?if (substr($campo502,17,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>
				 <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					    <td width="350"><span class="Estilo5"> TIPO DOCUMENTO DIFERIDO REQUISICION :</span></td>
                       <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtdoc_req" type="text" id="txtdoc_req"  size="4" maxlength="4" value="<?echo $campo512 ?>" onFocus="encender(this)" onBlur="apagar(this)">
                       </span></td>
                    </tr>
                 </table></td>
                  
			   </tr>
            </table></td>  
          </tr>
          <tr><td>&nbsp;</td> </tr>
          
          
          <tr>
            <td><table width="183" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="183" align="center"><span class="Estilo14">RECEPCI&Oacute;N/DESPACHO</span></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td>  </tr>
		  <tr>
            <td><table width="860" border="1" cellspacing="2" cellpadding="0">
               <tr>
		         <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">N&Uacute;MERO DE MOVIMIENTOS AUTOMATICO:</span></td>
					   <td width="80" align="center"><span class="Estilo5"> <select name="txtref_autr" size="1" id="txtref_autr"><?if (substr($campo502,15,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>
				 <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">FECHA DE MOVIMIENTOS AUTOMATICO:</span></td>
					   <td width="80" align="center"><span class="Estilo5"><select name="txtfecha_autr" size="1" id="txtfecha_autr"><?if (substr($campo502,16,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>                  
			   </tr>
            </table></td>  
           </tr>
		   
          
          <tr><td>&nbsp;</td></tr>
          <tr>
            <td><table width="192" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="192" align="center"><span class="Estilo14">ORDENES DE SERVICIO</span></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td >&nbsp;</td></tr>
		  <tr>
            <td><table width="860" border="1" cellspacing="2" cellpadding="0">
               <tr>
		         <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">N&Uacute;MERO DE MOVIMIENTOS AUTOMATICO:</span></td>
					    <td width="80" align="center"><span class="Estilo5"><select name="txtref_auts" size="1" id="txtref_auts"><?if (substr($campo502,11,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>
				 <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">FECHA DE MOVIMIENTOS AUTOMATICO:</span></td>
					   <td width="80" align="center"><span class="Estilo5"><select name="txtfecha_auts" size="1" id="txtfecha_auts"><?if (substr($campo502,12,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?> </span></td>
                    </tr>
                 </table></td>                  
			   </tr>
            </table></td>  
           </tr>
		   <tr>
            <td><table width="860" border="1" cellspacing="2" cellpadding="0">
               <tr>
		         <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">VALIDAR NUMERO DE SOLICITUD EN ORDEN:</span></td>
					   <td width="80" align="center"><span class="Estilo5"><select name="txtnro_reqs" size="1" id="txtnro_reqs"><?if (substr($campo502,9,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?> </span></td>
                    </tr>
                 </table></td>
				 <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">VALIDAR SOLICITUD APROBADA EN LA ORDEN:</span></td>
					   <td width="80" align="center"><span class="Estilo5"><select name="txtreq_aps" size="1" id="txtreq_aps"><?if (substr($campo502,10,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>    </span></td>
                    </tr>
                 </table></td>                  
			   </tr>
            </table></td>  
           </tr>
		   <tr>
            <td><table width="860" border="1" cellspacing="2" cellpadding="0">
               <tr>		         
				 <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">MODIFICAR C&Oacute;DIGO PRESUPUESTARIO EN ORDENES:</span></td>
					    <td width="80" align="center"><span class="Estilo5"> <select name="txtmod_cod_presups" size="1" id="txtmod_cod_presups"><?if (substr($campo502,13,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>  </span></td>
                    </tr>
                 </table></td>                  
			   </tr>
            </table></td>  
           </tr>
           <tr>
            <td><table width="860" border="1" cellpadding="0" cellspacing="2">
              <tr>
                <td width="430"><table width="420"  border="0" cellpadding="0">
                  <tr>
                    <td width="350"><span class="Estilo5"> TIPO DOCUMENTO ORDEN DE SERVICIO:</span></td>
                    <td width="80"><span class="Estilo5">
                            <input class="Estilo10" name="txtdoc_comps" type="text" id="txtdoc_comps"  size="4" maxlength="4" value="<?echo $campo505 ?>" onFocus="encender(this)" onBlur="apagar(this)">
                    </span></td>
                  </tr>
                </table></td>
                
                <td width="430"><table width="420" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="350"><span class="Estilo5"> TIPO COMPROMISO ORDEN DE SERVICIO:</span></td>
                    <td width="80"><span class="Estilo5">
                          <input class="Estilo10" name="txttip_comps" type="text" id="txttip_comps"  size="6" maxlength="6" value="<?echo $campo508 ?>" onFocus="encender(this)" onBlur="apagar(this)">
                    </span></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
           </tr>
		    <tr>
            <td><table width="860" border="1" cellspacing="2" cellpadding="0">
               <tr>
		         <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					   <td width="350"><span class="Estilo5">APARTADO PRESUP. CON SOLICITUD SERVICIO :</span></td>
					    <td width="70" align="center"><span class="Estilo5">
                          <select name="txtgen_apart_s" size="1" id="txtgen_apart_s"><?if (substr($campo502,18,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?>
                        </span></td>
                    </tr>
                 </table></td>
				 <td width="430"><table width="420"  border="0" cellpadding="0">
                    <tr>
					    <td width="350"><span class="Estilo5"> TIPO DOCUMENTO DIFERIDO SERVICIO :</span></td>
                       <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtdoc_sol" type="text" id="txtdoc_sol"  size="4" maxlength="4" value="<?echo $campo513 ?>" onFocus="encender(this)" onBlur="apagar(this)">
                       </span></td>
                    </tr>
                 </table></td>
                  
			   </tr>
            </table></td>  
          </tr>		  
        </table>
        <p>&nbsp;</p>
        <table width="768">
          <tr>
            <td width="514">&nbsp;</td>
			<td width="50"><input name="txtcod_modulo" type="hidden" id="txtcod_modulo" value="<?echo $cod_modulo?>" ></td>     
            <td width="50"><input name="txtdet_inv_art" type="hidden" id="txtdet_inv_art" value="<?echo $campo511?>" ></td>  

            <td width="50"><input name="txtref_auta" type="hidden" id="txtref_auta" value="NO" ></td>
            <td width="50"><input name="txtfecha_auta" type="hidden" id="txtfecha_auta" value="NO" ></td> 
  			
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88">&nbsp;</td>
          </tr>
        </table>
        <div align="right"></div>
        <div align="right"></div>
        <p>&nbsp;</p>
        </form>
    </div>

  </tr>
</table>
</body>
</html>
