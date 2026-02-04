<?php include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php } else{$Nom_Emp=busca_conf();}
if (!$_GET){$cod_banco=''; $sql="SELECT * FROM bancos_dolares ORDER BY cod_banco";} else{$cod_banco=$_GET["Gcod_banco"]; $sql="Select * from bancos_dolares where cod_banco='$cod_banco'";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Definci&oacute;n Cuentas Bancos Dolares)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
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
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
 return true;}
function revisar(){var f=document.form1;
    if(f.txtcod_banco.value==""){alert("Codigo de Banco no puede estar Vacio");return false;}
    if(f.txtnombre_banco.value==""){alert("Nombre de Banco no puede estar Vacia");return false;} else{f.txtnombre_banco.value=f.txtnombre_banco.value.toUpperCase();}
    if(f.txtcod_banco.value.length==4){f.txtcod_banco.value=f.txtcod_banco.value.toUpperCase();} else{alert("Longitud Codigo de Banco Invalida");return false;}
    if(f.txtcod_contable.value==""){alert("Codigo Contable no puede estar Vacio");return false;}
document.form1.submit;
return true;}
function LlamarURL(url){  document.location = url; }
</script>
</head>
<?php 
$debito01=0;$credito01=0;$debitob01=0;$creditob01=0;$debito02=0;$credito02=0;$debitob02=0;$creditob02=0;$debito03=0;$credito03=0;$debitob03=0;$creditob03=0;$debito04=0;$credito04=0;$debitob04=0;$creditob04=0;
$debito05=0;$credito05=0;$debitob05=0;$creditob05=0;$debito06=0;$credito06=0;$debitob06=0;$creditob06=0;$debito07=0;$credito07=0;$debitob07=0;$creditob07=0;$debito08=0;$credito08=0;$debitob08=0;$creditob08=0;
$debito09=0;$credito09=0;$debitob09=0;$creditob09=0;$debito10=0;$credito10=0;$debitob10=0;$creditob10=0;$debito11=0;$credito11=0;$debitob11=0;$creditob11=0;$debito12=0;$credito12=0;$debitob12=0;$creditob12=0;
$nombre_banco="";$nro_cuenta="";$tipo_cuenta="";$des_tipo_cuenta="";$nro_cuenta="";$cod_contable="";$nombre_cuenta="";$activa="S";$tipo_bco="1";$formato_cheque="";$descripcion_banco="";$saldo_ant_libro=0;$saldo_ant_banco=0;$campo_num1=0;$campo_str1="";$campo_str2="";$nombre_grupob="";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $ $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $descripcion_banco=$registro["descripcion_banco"];  $cod_contable=$registro["cod_contable"]; $inf_usuario=$registro["inf_usuario"]; $des_tipo_cuenta=$registro["descripcion_tipo"]; $activa=$registro["activa"]; $campo_str1=$registro["campo_str1"];$campo_str2=$registro["campo_str2"];
 $tipo_cuenta=$registro["tipo_cuenta"]; $tipo_bco=$registro["tipo_bco"]; $activa=$registro["activa"]; $formato_cheque=$registro["formato_cheque"]; $fecha_activa=$registro["fecha_activa"]; $fecha_desactiva=$registro["fecha_desactiva"]; $nombre_cuenta=$registro["nombre_cuenta"]; $saldo_ant_libro=$registro["s_inic_libro"]; $saldo_ant_banco=$registro["s_inic_banco"]; $campo_num1=$registro["campo_num1"];$nombre_grupob=$registro["nombre_grupob"];
 $debito01=$registro["deb_libro01"];$credito01=$registro["cre_libro01"];$debitob01=$registro["deb_banco01"];$creditob01=$registro["cre_banco01"];$debito02=$registro["deb_libro02"];$credito02=$registro["cre_libro02"];$debitob02=$registro["deb_banco02"];$creditob02=$registro["cre_banco02"];$debito03=$registro["deb_libro03"];$credito03=$registro["cre_libro03"];$debitob03=$registro["deb_banco03"];$creditob03=$registro["cre_banco03"];
 $debito04=$registro["deb_libro04"];$credito04=$registro["cre_libro04"];$debitob04=$registro["deb_banco04"];$creditob04=$registro["cre_banco04"];$debito05=$registro["deb_libro05"];$credito05=$registro["cre_libro05"];$debitob05=$registro["deb_banco05"];$creditob05=$registro["cre_banco05"];$debito06=$registro["deb_libro06"];$credito06=$registro["cre_libro06"];$debitob06=$registro["deb_banco06"];$creditob06=$registro["cre_banco06"];
 $debito07=$registro["deb_libro07"];$credito07=$registro["cre_libro07"];$debitob07=$registro["deb_banco07"];$creditob07=$registro["cre_banco07"];$debito08=$registro["deb_libro08"];$credito08=$registro["cre_libro08"];$debitob08=$registro["deb_banco08"];$creditob08=$registro["cre_banco08"];$debito09=$registro["deb_libro09"];$credito09=$registro["cre_libro09"];$debitob09=$registro["deb_banco09"];$creditob09=$registro["cre_banco09"];
 $debito10=$registro["deb_libro10"];$credito10=$registro["cre_libro10"];$debitob10=$registro["deb_banco10"];$creditob10=$registro["cre_banco10"];$debito11=$registro["deb_libro11"];$credito11=$registro["cre_libro11"];$debitob11=$registro["deb_banco11"];$creditob11=$registro["cre_banco11"];$debito12=$registro["deb_libro12"];$credito12=$registro["cre_libro12"];$debitob12=$registro["deb_banco12"];$creditob12=$registro["cre_banco12"];
}
$saldo_libro=$saldo_ant_libro+$debito01-$credito01+$debito02-$credito02+$debito03-$credito03+$debito04-$credito04+$debito05-$credito05+$debito06-$credito06+$debito07-$credito07+$debito08-$credito08+$debito09-$credito09+$debito10-$credito10+$debito11-$credito11+$debito12-$credito12;
$saldo_banco=$saldo_ant_banco+$debitob01-$creditob01+$debitob02-$creditob02+$debitob03-$creditob03+$debitob04-$creditob04+$debitob05-$creditob05+$debitob06-$creditob06+$debitob07-$creditob07+$debitob08-$creditob08+$debitob09-$creditob09+$debitob10-$creditob10+$debitob11-$creditob11+$debitob12-$creditob12;
$saldo_ant_libro=formato_monto($saldo_ant_libro); $saldo_ant_banco=formato_monto($saldo_ant_banco);  $saldo_libro=formato_monto($saldo_libro); $saldo_banco=formato_monto($saldo_banco);   $fecha_desactiva=formato_ddmmaaaa($fecha_desactiva);
?>
<body>
<table width="992" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR CUENTAS BANCOS EN DOLARES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="992" height="440" border="1" id="tablacuerpo">
  <tr>
    <td width="93" height="438"><table width="92" height="435" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_bancos_dolares.php?Gcod_banco=C<?php echo $cod_banco?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_bancos_dolares.php?Gcod_banco=C<?php echo $cod_banco?>">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="932">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:882px; height:436px; z-index:1; top: 73px; left: 117px;">
        <form name="form1" method="post" action="Update_banco_dolares.php" onSubmit="return revisar()">
          <table width="880" border="0" >
                  <tr>
                  <td width="868"><table width="868" >
                      <tr>
                        <td width="110" height="24"><span class="Estilo5">C&Oacute;DIGO BANCO :</span></td>
                        <td width="70"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco"  size="5" maxlength="4" onFocus="encender(this)" value="<?php echo $cod_banco?>" readonly> </span></td>
                        <td width="70"><span class="Estilo5">NOMBRE:</span></td>
                        <td width="500"><span class="Estilo5"> <input class="Estilo10" name="txtnombre_banco" type="text"  id="txtnombre_banco" value="<?php echo $nombre_banco?>" size="94" maxlength="150" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td width="868"><table width="868" >
                      <tr>
                        <td width="110"><span class="Estilo5">TIPO DE CUENTA : </span></td>
                        <td width="50"><span class="Estilo5"><input class="Estilo10" name="txttipo_cuenta" type="text" id="txttipo_cuenta" value="<?php echo $tipo_cuenta?>" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                        <td width="50"><input class="Estilo10" name="btTipo_Cuenta" type="button" id="bttipo_cuenta" title="Abrir Catalogo Tipos de Cuenta" onclick="VentanaCentrada('Cat_tipo_cuenta.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                        <td width="630"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_cuenta" type="text" id="txtdes_tipo_cuenta" value="<?php echo $des_tipo_cuenta?>"  size="100" maxlength="100" readonly>   </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td width="868"><table width="868" >
                    <tr>
                      <td width="135"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                      <td width="275"><span class="Estilo5"> <input class="Estilo10" name="txtnro_cuenta" type="text" id="txtnro_cuenta" value="<?php echo $nro_cuenta?>" size="30" maxlength="25" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                      <td width="135"><span class="Estilo5">C&Oacute;DIGO CONTABLE :</span></td>
                      <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta"  value="<?php echo $cod_contable?>" size="30" maxlength="32" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                      <td width="50"><input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Codigo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td width="868"><table width="868" >
                    <tr>
                      <td width="190"><span class="Estilo5">NOMBRE C&Oacute;DIGO CONTABLE :</span></td>
                      <td width="670"><span class="Estilo5"><input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" value="<?php echo $nombre_cuenta?>" size="100" maxlength="99" readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td><table width="869">
                      <tr>
                        <td width="168"><span class="Estilo5">DESCRIPCI&Oacute;N DE BANCO :</span></td>
                        <td width="700"><span class="Estilo5"> <textarea name="txtdescripcion_banco" cols="80"  id="txtdescripcion_banco" onFocus="encender(this)" onBlur="apagar(this)"><?php echo $descripcion_banco?></textarea>  </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
				<tr> <td><table width="868">
					<tr>
					  <td width="170"><span class="Estilo5">SALDO ANTERIOR LIBRO : </span></td>
					  <td width="230"><span class="Estilo5">
					  <?php  if($SIA_Definicion=="N"){?>
						<input class="Estilo10" name="txts_inic_libro" type="text"  id="txts_inic_libro" value="<?php echo $saldo_ant_libro?>" size="20" style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event)">
					  <?php } else { ?>
						<input class="Estilo10" name="txts_inic_libro" type="text"  id="txts_inic_libro" value="<?php echo $saldo_ant_libro?>" size="20" style="text-align:right" readonly>
					  <?php }?>
					  </span></td>
					  <td width="170"><span class="Estilo5"> </span></td>
					  <td width="230"><span class="Estilo5"></span></td>
					</tr>
				  </table></td></tr>
				<tr><td>&nbsp;</td> </tr>
          </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
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
