<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
 $equipo = getenv("COMPUTERNAME"); $mcod_m = "PRE009".$equipo; $codigo_mov=substr($mcod_m,0,49);
 if (!$_GET){$referencia_modif=''; $tipo_modif='';} 
  else{$referencia_modif=$_GET["txtreferencia_modif"];  $tipo_modif=$_GET["txttipo_modif"]; }
 $sql="Select * FROM PRE009 where tipo_modif='$tipo_modif' and referencia_modif='$referencia_modif'";   
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Traspasos Presupuestario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
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
    if(f.txtreferencia_modif.value==""){alert("Referencia no puede estar Vacio");return false;}
    if(f.txttipo_modif.value==""){alert("Tipo de Modificación no puede estar Vacio"); return false; }   else{f.txttipo_modif.value=f.txttipo_modif.value.toUpperCase();}
    if(f.txtdescripcion.value==""){alert("Descripción de Modificación no puede estar Vacia"); return false; }  else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
    if(f.txtreferencia_modif.value.length==8){f.txtreferencia_modif.value=f.txtreferencia_modif.value.toUpperCase();}  else{alert("Longitud de Referencia Invalida");return false;}    
    if(f.txtfecha.value.length==10){Valido=true;}   else{alert("Longitud de Fecha Invalida");return false;}
	if(f.txtfecha_modif.value.length==10){Valido=true;}   else{alert("Longitud de Fecha de modificación Invalida");return false;}  
	if(f.txtfecha_documento.value.length==10){Valido=true;}   else{alert("Longitud de Fecha de documento Invalida");return false;}
	  
document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$descripcion="";$fecha_registro="";$modif_i_e="";$fecha_modif="";$modif_aprob="";$inf_usuario="";$aprobada_por="";$nro_documento="";$fecha_documento="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
  $referencia_modif=$registro["referencia_modif"];  $fecha_registro=$registro["fecha_registro"];
  $fecha_modif=$registro["fecha_modif"];  $tipo_modif=$registro["tipo_modif"];
  $descripcion=$registro["descripcion_modif"];  $modif_i_e=$registro["modif_i_e"];
  $modif_aprob=$registro["modif_aprob"];  $aprobada_por=$registro["aprobada_por"];
  $nro_documento=$registro["nro_documento"];  $fecha_documento=$registro["fecha_documento"];  $inf_usuario=$registro["inf_usuario"];
}
if($fecha_registro==""){$fecha_registro="";}else{$fecha_registro=formato_ddmmaaaa($fecha_registro);}
if($fecha_modif==""){$fecha_modif="";}else{$fecha_modif=formato_ddmmaaaa($fecha_modif);}
if($fecha_documento==""){$fecha_documento="";}else{$fecha_documento=formato_ddmmaaaa($fecha_documento);}
$des_tipo_modif="";
if($tipo_modif==1){$des_tipo_modif="CREDITOS ADICIONALES";}
if($tipo_modif==2){$des_tipo_modif="RECTIFICACIONES";}
if($tipo_modif==3){$des_tipo_modif="INSUBSISTENCIAS";}
if($tipo_modif==4){$des_tipo_modif="REDUCCION DE INGRESOS";}
if($tipo_modif==5){$des_tipo_modif="TRASPASOS DE CREDITOS";}
if($tipo_modif==6){$des_tipo_modif="SALDO FINAL DE CAJA";}
if($tipo_modif==7){$des_tipo_modif="INCREMENTO DE INGRESOS";}
if($modif_i_e=='I'){$modif_i_e="INTERNA";} else {$modif_i_e="EXTERNA";}
if($modif_aprob=='S'){$modif_aprob="SI";} else {$modif_aprob="NO";}
$clave=$referencia_modif.$tipo_modif;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">APROBAR MODIFICACIONES PRESUPUESTARIAS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="507" border="0" id="tablacuerpo">
  <tr>
    <td><table width="92" height="530" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablamenu">
        <td width="86">
      <td>
      <table width="92" height="530" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_modificaciones.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_modificaciones.php">Atras</A></td>
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
      <div id="Layer1" style="position:absolute; width:875px; height:495px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Update_aprobar.php" onSubmit="return revisar()">
      <table width="867" >
              <tr>
                <td>
                  <table width="830" height="170" align="center">
                    <tr>
                      <td><table width="813" border="0">
                        <tr>
                          <td width="139"><p><span class="Estilo5">TIPO MODIFICACI&Oacute;N : </span></p>                          </td>
                          <td width="204"><span class="Estilo5"><input class="Estilo10" name="txttipo_modif" type="text"  id="txttipo_modif2" value="<?echo $des_tipo_modif?>" size="30" readonly>     </span></td>
                          <td width="21"><input class="Estilo10" name="txttipo_m" type="hidden" id="txttipo_m" value="<?echo $tipo_modif?>"></td>
                          <td width="101"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="130"><div id="refer"><input class="Estilo10" name="txtreferencia_modif" type="text"  id="txtreferencia_modif"  value="<?echo $referencia_modif?>" size="12" readonly>    </div></td>
                          <td width="59"><span class="Estilo5">FECHA :</span> </td>
                          <td width="129"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10"  value="<?echo $fecha_registro?>" readonly>     </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="90"><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtdescripcion" cols="90" readonly class="Estilo10" id="Estilo10"><?echo $descripcion?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="813">
                        <tr>
                          <td width="104"><span class="Estilo5">MODIFICACI&Oacute;N:</span></td>
                          <td width="184"><span class="Estilo5"><input class="Estilo10" name="txtmodif_i_e" type="text" id="txtmodif_i_e" size="20"  value="<?echo $modif_i_e?>" readonly>       </span></td>
                          <td width="162"><span class="Estilo5">FECHA DE MODIFICACI&Oacute;N:</span></td>
                          <td width="126"><span class="Estilo5"><input class="Estilo10" name="txtfecha_modif" type="text" id="txtfecha_modif" value="<?echo $fecha_modif?>" size="12" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
                          <td width="97"><span class="Estilo5">APROBADA :</span></td>
                          <td width="85"><span class="Estilo5"><select  class="Estilo10" name="txtmodif_aprob" size="1" id="txtmodif_aprob" onFocus="encender(this)" onBlur="apagar(this)">                              
						  <option>SI</option> <option>NO</option> </select>    </span></td>
                          <td width="23">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="814">
                        <tr>
                          <td width="108"><span class="Estilo5">APROBADO POR:</span></td>
                          <td width="680"><span class="Estilo5"> <input class="Estilo10" name="txtaprobada_por" type="text" id="txtaprobada_por" value="<?ECHO $aprobada_por?>" size="100" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="827">
                        <tr>
                          <td width="240"><span class="Estilo5">NRO.DOCUMENTO/ACTA APROBACI&Oacute;N:</span></td>
                          <td width="325"><input class="Estilo10" name="txtnro_documento" type="text"  id="txtnro_documento" value="<?echo $nro_documento?>" size="45" onFocus="encender(this)" onBlur="apagar(this)" ></td>
                          <td width="171"><span class="Estilo5">FECHA DOCUMENTO/ACTA:</span></td>
                          <td width="71"><span class="Estilo5"><input class="Estilo10" name="txtfecha_documento" type="text" id="txtfecha_documento" value="<?echo $fecha_documento?>" size="10" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
          </table>
         <table width="863" border="0">
          <tr>
            <td height="10">&nbsp;</td>
            </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="88" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88">&nbsp;</td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>