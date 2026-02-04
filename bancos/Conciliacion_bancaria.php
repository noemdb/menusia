<?php include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); 
if (!$_GET){$codbanco="0000";}else{$codbanco=$_GET["codbanco"];}  $fecha_hoy=asigna_fecha_hoy();$equipo = getenv("COMPUTERNAME"); $mcod_m = "BAN0010".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit;} else{$Nom_Emp=busca_conf();}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000050"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
/*
if($SIA_Cierre=="N"){$error=0;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Conciliacion Bancaria)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_ban.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function Llama_Registrar(){var url; var r;
  r=confirm("Desea Generar la Conciliacion Bancaria ?");
  if (r==true) { url="Insert_conciliacion.php?txtcod_banco="+document.form1.txtcod_banco.value+"&txtmes="+document.form1.txtmes.value;  LlamarURL(url);}
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar la Conciliacion ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Conciliacion ?");
    if (r==true) { url="Delete_conciliacion.php?txtcod_banco="+document.form1.txtcod_banco.value+"&txtmes="+document.form1.txtmes.value;  LlamarURL(url);} }
}
function apaga_banco(mthis){var mref;    apagar(mthis);
   mref=document.form1.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  document.form1.txtcod_banco.value=mref;
   ajaxSenddoc('GET', 'asigmes.php?cod_banco='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nmes', 'innerHTML');
   ajaxSenddoc('GET', 'perconc.php?cod_banco='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'smes', 'innerHTML');
return true;}
function chequea_banco(mform){var mref;
   mref=mform.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  mform.txtcod_banco.value=mref;
return true;}
</script>
</head>
<?php  $temp_mes="01"; $cod_banco=""; $nombre_banco=""; $nro_cuenta="";
$mes1="";$mes2="";$mes3="";$mes4="";$mes5="";$mes6="";$mes7="";$mes8="";$mes9="";$mes10="";$mes11="";$mes12="";
if($codbanco=="0000"){$sql="SELECT * FROM bancos ORDER BY cod_banco";}else{$sql="SELECT * FROM bancos where cod_banco='".$codbanco."'";}$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];}
$sql="SELECT * FROM ban009 where cod_banco='".$cod_banco."'";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$reg=pg_fetch_array($res,0); $temp_mes=$reg["u_conciliacion"];  if($reg["mes01"]=="S"){$mes1='checked';}else{$mes1='';} if($reg["mes02"]=="S"){$mes2='checked';}else{$mes2='';} if($reg["mes03"]=="S"){$mes3='checked';}else{$mes3='';}
if($reg["mes04"]=="S"){$mes4='checked';}else{$mes4='';} if($reg["mes05"]=="S"){$mes5='checked';}else{$mes5='';} if($reg["mes06"]=="S"){$mes6='checked';}else{$mes6='';} if($reg["mes07"]=="S"){$mes7='checked';}else{$mes7='';}
if($reg["mes08"]=="S"){$mes8='checked';}else{$mes8='';} if($reg["mes09"]=="S"){$mes9='checked';}else{$mes9='';} if($reg["mes10"]=="S"){$mes10='checked';}else{$mes10='';} if($reg["mes11"]=="S"){$mes11='checked';}else{$mes11='';} if($reg["mes12"]=="S"){$mes12='checked';}else{$mes12='';} }
pg_close($conn);
?>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONCILIACI&Oacute;N BANCARIA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="346" border="1" id="tablacuerpo">
  <tr>
    <td>       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>      <div id="Layer1" style="position:absolute; width:901px; height:324px; z-index:1; top: 72px; left: 24px;">
        <form name="form1" method="post">
          <table width="950" height="132" border="0" >
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td><table width="945">
                    <tr>
                      <td width="134"><span class="Estilo5">C&Oacute;DIGO DEL BANCO:</span></td>
                      <td width="68"><span class="Estilo5"> <input name="txtcod_banco" type="text" id="txtcod_banco" size="5" maxlength="4"  value="<?php echo $cod_banco?>" onFocus="encender(this)" onBlur="apaga_banco(this)" onchange="chequea_banco(this.form);">
                      </span> </td>
                      <td width="221"><input name="btcod_banco" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancos.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                      <td width="157"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                      <td width="341"><span class="Estilo5"> <input name="txtnro_cuenta" type="text" id="txtnro_cuenta" value="<?php echo $nro_cuenta?>"  size="30" maxlength="25" readonly>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="945"><table width="945" >
                    <tr>
                      <td width="134"><span class="Estilo5"> NOMBRE DEL BANCO :</span></td>
                      <td width="795"><span class="Estilo5"> <input name="txtnombre_banco" type="text" id="txtnombre_banco" value="<?php echo $nombre_banco?>" size="100" maxlength="100" readonly>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td><table width="640" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="170">&nbsp;</td>
                      <td width="33"><div align="center"><span class="Estilo5">01</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">02</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">03</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">04</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">05</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">06</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">07</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">08</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">09</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">10</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">11</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">12</span></div></td>
                      <td width="60">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                                   <td><div id="smes"><table width="640" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="170"><span class="Estilo5">PERIODOS CONCILIADOS :</span></td>
                      <td width="33"><div align="center"><input name="Mes1" type="checkbox" id="Mes1" value="checkbox" <?php echo $mes1;?>> </div></td>
                      <td width="33"><div align="center"><input name="Mes2" type="checkbox" id="Mes2" value="checkbox" <?php echo $mes2;?>> </div></td>
                      <td width="33"><div align="center"><input name="Mes3" type="checkbox" id="Mes3" value="checkbox" <?php echo $mes3;?>> </div></td>
                      <td width="33"><div align="center"><input name="Mes4" type="checkbox" id="Mes4" value="checkbox" <?php echo $mes4;?>> </div></td>
                      <td width="33"><div align="center"> <input name="Mes5" type="checkbox" id="Mes_Conc" value="checkbox" <?php echo $mes5;?>> </div></td>
                      <td width="33"><div align="center"> <input name="Mes6" type="checkbox" id="Mes_Conc" value="checkbox" <?php echo $mes6;?>> </div></td>
                      <td width="33"><div align="center"> <input name="Mes7" type="checkbox" id="Mes_Conc" value="checkbox" <?php echo $mes7;?>> </div></td>
                      <td width="33"><div align="center"> <input name="Mes8" type="checkbox" id="Mes8" value="checkbox" <?php echo $mes8;?>></div></td>
                      <td width="33"><div align="center"> <input name="Mes9" type="checkbox" id="Mes9" value="checkbox" <?php echo $mes9;?>> </div></td>
                      <td width="33"><div align="center"> <input name="Mes10" type="checkbox" id="Mes10" value="checkbox" <?php echo $mes10;?>></div></td>
                      <td width="33"><div align="center"> <input name="Mes11" type="checkbox" id="Mes11" value="checkbox" <?php echo $mes11;?>> </div></td>
                      <td width="33"><div align="center"> <input name="Mes12" type="checkbox" id="Mes12" value="checkbox" <?php echo $mes12;?>> </div></td>
                                          <td width="60">&nbsp;</td>
                    </tr>
                  </table> </div></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
<script language="JavaScript" type="text/JavaScript">
function asig_num_mes(mvalor){var f=document.form1;
    if(mvalor=="01"){document.form1.txtmes.options[1].selected = true;}
    if(mvalor=="02"){document.form1.txtmes.options[2].selected = true;}
    if(mvalor=="03"){document.form1.txtmes.options[3].selected = true;}
    if(mvalor=="04"){document.form1.txtmes.options[4].selected = true;}
    if(mvalor=="05"){document.form1.txtmes.options[5].selected = true;}
    if(mvalor=="06"){document.form1.txtmes.options[6].selected = true;}
    if(mvalor=="07"){document.form1.txtmes.options[7].selected = true;}
    if(mvalor=="08"){document.form1.txtmes.options[8].selected = true;}
    if(mvalor=="09"){document.form1.txtmes.options[9].selected = true;}
	if(mvalor=="10"){document.form1.txtmes.options[10].selected = true;}
    if(mvalor=="11"){document.form1.txtmes.options[11].selected = true;}
  //  if(mvalor=="12"){document.form1.txtmes.options[11].selected = true;}
}</script>
                <tr>
                  <td><table width="908" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="168"><span class="Estilo5">MES DE CONCILIACI&Oacute;N :</span></td>
                      <td width="740"><span class="Estilo5">  <div id="nmes">
                        <select name="txtmes" id="txtmes">
                          <option>01</option> <option>02</option> <option>03</option>  <option>04</option>
                          <option>05</option> <option>06</option> <option>07</option>  <option>08</option>
                          <option>09</option> <option>10</option> <option>11</option>  <option>12</option>
                      </select> </div>
                      <script language="JavaScript" type="text/JavaScript"> asig_num_mes('<?php echo $temp_mes;?>');</script>
                      </span> </td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>  
          </table>
        <table width="957">
          <tr><td><table width="923">
            <td width="538"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <?php if ($Mcamino{0}=="S"){?> <td width="115"><input name="Generar" type="button" id="Generar" title="Generar Conciliacion Bancaria" onclick="javascript:Llama_Registrar()" value="Generar"></td>
            <?php } if ($Mcamino{6}=="S"){?> <td width="107"><input name="Eliminar" type="button" id="Eliminar" title="Eliminar Conciliacion Bancaria" onclick="javascript:Llama_Eliminar()" value="Eliminar"></td><?php }?> 
            <td width="143" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
          </table></td></tr>
        </table>
        </form>
        </div></td>
</tr>
</table>
</body>
</html>