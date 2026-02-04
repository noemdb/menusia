<?php include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit;} else{$Nom_Emp=busca_conf();}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="01-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); 
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){ $cod_banco=""; $sql="SELECT * FROM bancos ORDER BY cod_banco"; $p_letra=""; }
else {$cod_banco = $_GET["Gcod_banco"];$p_letra=substr($cod_banco, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_banco=substr($cod_banco,1,12);} else{$cod_banco=substr($cod_banco,0,12);}
  $sql="Select * from bancos where cod_banco='$cod_banco' ";
  if ($p_letra=="P"){$sql="SELECT * FROM bancos ORDER BY cod_banco";}
  if ($p_letra=="U"){$sql="SELECT * From bancos Order by cod_banco desc";}
  if ($p_letra=="S"){$sql="SELECT * From bancos Where (cod_banco>'$cod_banco') Order by cod_banco";}
  if ($p_letra=="A"){$sql="SELECT * From bancos Where (cod_banco<'$cod_banco') Order by cod_banco desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Definci&oacute;n de Bancos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;  var Gcod_banco; var mactiva;
  mactiva=document.form1.txtactiva.value;
  if(mactiva=="S"){Gcod_banco=document.form1.txtcod_banco.value;murl=url+Gcod_banco;
   if (Gcod_banco==""){alert("Codigo de Banco debe ser Seleccionada");}else {document.location = murl;} }
  else{alert("Codigo de Banco esta Desactivado");}
}
function Mover_Registro(MPos){var murl;
   murl="Act_bancos.php";
   if(MPos=="P"){murl="Act_bancos.php?Gcod_banco=P"}
   if(MPos=="U"){murl="Act_bancos.php?Gcod_banco=U"}
   if(MPos=="S"){murl="Act_bancos.php?Gcod_banco=S"+document.form1.txtcod_banco.value;}
   if(MPos=="A"){murl="Act_bancos.php?Gcod_banco=A"+document.form1.txtcod_banco.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar el Banco ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Banco ?");
    if (r==true) { url="Delete_banco.php?txtcod_banco="+document.form1.txtcod_banco.value;  VentanaCentrada(url,'Eliminar Codigo de Banco','','400','400','true');}} else {url="Cancelado, no elimino";}
}
function Llama_Desactivar(){var url; var mactiva;
  mactiva=document.form1.txtactiva.value;
  if(mactiva=="S"){url="Desactiva_banco.php?txtcod_banco="+document.form1.txtcod_banco.value;  VentanaCentrada(url,'Desactivar Codigo de Banco','','750','300','true');} else{alert("Codigo de Banco esta Desactivado");}
}
</script>
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
<?php 
$nombre_banco="";$nro_cuenta="";$tipo_cuenta="";$des_tipo_cuenta="";$nro_cuenta="";$cod_contable="";$nombre_cuenta="";$activa="S";$tipo_bco="1";$formato_cheque="";$descripcion_banco="";$saldo_ant_libro=0;$saldo_ant_banco=0;$campo_num1=0;$campo_str1="";$campo_str2="";$nombre_grupob=""; $fecha_desactiva="";
$debito01=0;$credito01=0;$debitob01=0;$creditob01=0;$debito02=0;$credito02=0;$debitob02=0;$creditob02=0;$debito03=0;$credito03=0;$debitob03=0;$creditob03=0;$debito04=0;$credito04=0;$debitob04=0;$creditob04=0;
$debito05=0;$credito05=0;$debitob05=0;$creditob05=0;$debito06=0;$credito06=0;$debitob06=0;$creditob06=0;$debito07=0;$credito07=0;$debitob07=0;$creditob07=0;$debito08=0;$credito08=0;$debitob08=0;$creditob08=0;
$debito09=0;$credito09=0;$debitob09=0;$creditob09=0;$debito10=0;$credito10=0;$debitob10=0;$creditob10=0;$debito11=0;$credito11=0;$debitob11=0;$creditob11=0;$debito12=0;$credito12=0;$debitob12=0;$creditob12=0;
$res=pg_query($sql);$filas=pg_num_rows($res); if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From bancos ORDER BY cod_banco";} if ($p_letra=="A"){$sql="SELECT * From bancos ORDER BY cod_banco desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $descripcion_banco=$registro["descripcion_banco"];  $cod_contable=$registro["cod_contable"]; $inf_usuario=$registro["inf_usuario"]; $des_tipo_cuenta=$registro["descripcion_tipo"]; $activa=$registro["activa"]; $campo_str1=$registro["campo_str1"];$campo_str2=$registro["campo_str2"]; $fecha_desactiva=formato_ddmmaaaa($fecha_desactiva);  
 $tipo_cuenta=$registro["tipo_cuenta"]; $tipo_bco=$registro["tipo_bco"]; $activa=$registro["activa"]; $formato_cheque=$registro["formato_cheque"]; $fecha_activa=$registro["fecha_activa"]; $fecha_desactiva=$registro["fecha_desactiva"]; $nombre_cuenta=$registro["nombre_cuenta"]; $saldo_ant_libro=$registro["s_inic_libro"]; $saldo_ant_banco=$registro["s_inic_banco"]; $campo_num1=$registro["campo_num1"];$nombre_grupob=$registro["nombre_grupob"];
 $debito01=$registro["deb_libro01"];$credito01=$registro["cre_libro01"];$debitob01=$registro["deb_banco01"];$creditob01=$registro["cre_banco01"];$debito02=$registro["deb_libro02"];$credito02=$registro["cre_libro02"];$debitob02=$registro["deb_banco02"];$creditob02=$registro["cre_banco02"];$debito03=$registro["deb_libro03"];$credito03=$registro["cre_libro03"];$debitob03=$registro["deb_banco03"];$creditob03=$registro["cre_banco03"];
 $debito04=$registro["deb_libro04"];$credito04=$registro["cre_libro04"];$debitob04=$registro["deb_banco04"];$creditob04=$registro["cre_banco04"];$debito05=$registro["deb_libro05"];$credito05=$registro["cre_libro05"];$debitob05=$registro["deb_banco05"];$creditob05=$registro["cre_banco05"];$debito06=$registro["deb_libro06"];$credito06=$registro["cre_libro06"];$debitob06=$registro["deb_banco06"];$creditob06=$registro["cre_banco06"];
 $debito07=$registro["deb_libro07"];$credito07=$registro["cre_libro07"];$debitob07=$registro["deb_banco07"];$creditob07=$registro["cre_banco07"];$debito08=$registro["deb_libro08"];$credito08=$registro["cre_libro08"];$debitob08=$registro["deb_banco08"];$creditob08=$registro["cre_banco08"];$debito09=$registro["deb_libro09"];$credito09=$registro["cre_libro09"];$debitob09=$registro["deb_banco09"];$creditob09=$registro["cre_banco09"];
 $debito10=$registro["deb_libro10"];$credito10=$registro["cre_libro10"];$debitob10=$registro["deb_banco10"];$creditob10=$registro["cre_banco10"];$debito11=$registro["deb_libro11"];$credito11=$registro["cre_libro11"];$debitob11=$registro["deb_banco11"];$creditob11=$registro["cre_banco11"];$debito12=$registro["deb_libro12"];$credito12=$registro["cre_libro12"];$debitob12=$registro["deb_banco12"];$creditob12=$registro["cre_banco12"];
}
$saldo_libro=$saldo_ant_libro+$debito01-$credito01+$debito02-$credito02+$debito03-$credito03+$debito04-$credito04+$debito05-$credito05+$debito06-$credito06+$debito07-$credito07+$debito08-$credito08+$debito09-$credito09+$debito10-$credito10+$debito11-$credito11+$debito12-$credito12;
$saldo_banco=$saldo_ant_banco+$debitob01-$creditob01+$debitob02-$creditob02+$debitob03-$creditob03+$debitob04-$creditob04+$debitob05-$creditob05+$debitob06-$creditob06+$debitob07-$creditob07+$debitob08-$creditob08+$debitob09-$creditob09+$debitob10-$creditob10+$debitob11-$creditob11+$debitob12-$creditob12;
$saldo_ant_libro=formato_monto($saldo_ant_libro); $saldo_ant_banco=formato_monto($saldo_ant_banco);  $saldo_libro=formato_monto($saldo_libro); $saldo_banco=formato_monto($saldo_banco);
if($tipo_bco=="1"){$tipo_bco="GASTOS CORRIENTES";} if($tipo_bco=="2"){$tipo_bco="RECAUDACION";} if($tipo_bco=="3"){$tipo_bco="FONDOS DE TERCEROS";} if($tipo_bco=="4"){$tipo_bco="FIDEICOMISOS-FIDES";} if($tipo_bco=="5"){$tipo_bco="FIDEICOMISOS-LAEE";} if($tipo_bco=="6"){$tipo_bco="FIEM";} if($tipo_bco=="7"){$tipo_bco="OTROS FIDEICOMISOS";} if($tipo_bco=="8"){$tipo_bco="PENDIENTE POR CANCELAR";} if($tipo_bco=="9"){$tipo_bco="OTROS";} if($tipo_bco=="0"){$tipo_bco="";}
?>
<body>
<table width="992" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEFINICI&Oacute;N DE BANCOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="992" height="724" border="1" id="tablacuerpo">
  <tr>
    <td width="93" height="724"><table width="92" height="720" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
       <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Bancos.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a class=menu href="Inc_Bancos.php">Incluir</a></div></td>
      </tr>
	  <?php } if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_Bancos.php?Gcod_banco=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a class=menu href="javascript:Llamar_Ventana('Mod_Bancos.php?Gcod_banco=')">Modificar</a></div></td>
      </tr>
	  <?php } if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Mover_Registro('P');">Primero</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_bancos.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_bancos.php" class="menu">Catalogo</a></div></td>
      </tr>
	  <?php } if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Llama_Eliminar();">Eliminar</a></div></td>
      </tr>
	  <?php } if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Llama_Desactivar();">Desactivar</a></div></td>
      </tr>
	  <?php }?> 
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="932">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:881px; height:739px; z-index:1; top: 69px; left: 115px;">
        <form name="form1" method="post">
          <table width="880" border="0" >
                <tr>
                  <td width="868"><table width="868" >
                      <tr>
                        <td width="110" height="24"><span class="Estilo5">C&Oacute;DIGO BANCO :</span></td>
                        <td width="70"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco"  value="<?php echo $cod_banco?>" size="5" maxlength="4" readonly>
                        </span></td>
                        <td width="70"><span class="Estilo5">NOMBRE:</span></td>
                        <td width="580"><span class="Estilo5"> <input class="Estilo10" name="txtnombre_banco" type="text"  id="txtnombre_banco"  value="<?php echo $nombre_banco?>" size="90" maxlength="150" readonly>
                      </span></td>
                        <td width="20"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                      </tr>
                  </table></td>
                </tr>

                <tr>
                  <td width="868"><table width="868" >
                      <tr>
                        <td width="110"><span class="Estilo5">TIPO DE CUENTA : </span></td>
                        <td width="70"><span class="Estilo5"><input class="Estilo10" name="txttipo_cuenta" type="text" id="txttipo_cuenta"  value="<?php echo $tipo_cuenta?>" size="4" maxlength="3" readonly>   </span></td>
                        <td width="670"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_cuenta" type="text" id="txtdes_tipo_cuenta"  value="<?php echo $des_tipo_cuenta?>" size="100" maxlength="100" readonly>   </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td width="868"><table width="868" >
                    <tr>
                      <td width="130"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                      <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txtnro_cuenta" type="text" id="txtnro_cuenta"  value="<?php echo $nro_cuenta?>" size="27" maxlength="25" readonly> </span></td>
                      <td width="130"><span class="Estilo5">C&Oacute;DIGO CONTABLE :</span></td>
                      <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtcod_contable" type="text" id="txtcod_contable"  value="<?php echo $cod_contable?>" size="30" maxlength="32" readonly>   </span></td>
                    </tr>
                  </table></td>
                </tr>

                <tr>
                  <td width="868"><table width="868" >
                    <tr>
                      <td width="190"><span class="Estilo5">NOMBRE C&Oacute;DIGO CONTABLE :</span></td>
                      <td width="670"><span class="Estilo5"><input class="Estilo10" name="txtnombre_cuenta" type="text" id="txtnombre_cuenta"  value="<?php echo $nombre_cuenta?>" size="100" maxlength="99" readonly> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                 <td width="868"><table width="868" >
                      <tr>
                        <td width="190" height="24"><span class="Estilo5">DESCRIPCI&Oacute;N DE BANCO :</span></td>
                        <td width="670"><span class="Estilo5"><textarea name="txtdescripcion_banco" cols="80" readonly="readonly"  id="txtdescripcion_banco"><?php echo $descripcion_banco?></textarea>  </span></td>
                      </tr>
                  </table></td>
                </tr>
          <tr>
            <td width="870"><table width="870" border="0" cellspacing="0" >
              <tr>
                <td width="868"><table width="868" >
                    <tr>
                      <td width="110"><span class="Estilo5">TIPO DE BANCO :</span></td>
                      <td width="320"><span class="Estilo5"><input class="Estilo10" name="txttipo_bco" type="text"  id="txttipo_bco"  value="<?php echo $tipo_bco?>" size="30" maxlength="30" readonly>    </span></td>
                      <?php  if($activa=="N"){ ?>
                      <td width="200"><span class="Estilo5">CUENTA DESACTIVADA FECHA :</span></td>
                      <td width="230"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desactiva" type="text" id="txtfecha_desactiva"  value="<?php echo $fecha_desactiva?>" size="11" maxlength="10" readonly> </span></td>
                      <?php }else{ ?> <td width="430">&nbsp;</td> <?php }?>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td width="868"><table width="868" >
                    <tr>
                      <td width="148"><span class="Estilo5">FORMATO DE CHEQUE :</span></td>
                      <td width="520"><span class="Estilo5"> <input class="Estilo10" name="txtformato_cheque" type="text"  id="txtformato_cheque"  value="<?php echo $formato_cheque?>" size="100" maxlength="100" readonly>   </span></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="868">
              <tr>
                <td width="140"><span class="Estilo5">GRUPO DE BANCO : </span></td>
                <td width="59"><span class="Estilo5"> <input class="Estilo10" name="txtgrupo_banco" type="text" id="txtgrupo_banco"  value="<?php echo $campo_str2?>" size="4" maxlength="3" readonly>   </span></td>
                <td width="668"><span class="Estilo5"><input class="Estilo10" name="txtnombre_grupob" type="text" id="txtnombre_grupob"  value="<?php echo $nombre_grupob?>" size="100" maxlength="100" readonly>  </span></td>
              </tr>
            </table></td>
          </tr>
          <?php  if($campo_num1>0){?>
          <tr>
            <td><table width="868">
              <tr>
                <td width="110"><span class="Estilo5">TASA I.D.B (%) :</span></td>
                <td width="255"><span class="Estilo5"><input class="Estilo10" name="txttasa_idb" type="text" id="txttasa_idb"  value="<?php echo $campo_num1?>" size="6" maxlength="5" style="text-align:right"  readonly>   </span> </span></td>
                <td width="200"><span class="Estilo5">C&Oacute;DIGO CONTABLE I.D.B (%) : </span></td>
                <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtcod_contable_idb" type="text" id="txtcod_contable_idb"  value="<?php echo $campo_str1?>" size="30" maxlength="32" readonly>  </span> </td>
              </tr>
            </table></td>
          </tr> <?php }?>
          <tr> <td>&nbsp;</td> </tr>
        </table>
                <table width="770"  border="0" cellspacing='0' cellpadding='0' align="center" id="enc_periodos">
                <tr>
                  <td width="90"></td>
                  <td width="680">
                  <table width="679" border="1" cellspacing="0" cellpadding="0">
                   <tr>
                     <td width="339" align="center" bgcolor="#99CCFF"><strong>LIBROS</strong></td>
                     <td width="339" align="center" bgcolor="#99CCFF"><strong>BANCOS</strong></td>
                   </tr>
                   <tr>
                     <td width="339"> <table width="338" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                       <td width="137" align="center"><span class="Estilo5">SALDO ANTERIOR : </span></td>
               <td width="200" align="left"><span class="Estilo5"><input class="Estilo10" name="txtsaldo_ant_libros" type="text" id="txtsaldo_ant_libros" size="16"  style="text-align:right"  value="<?php echo $saldo_ant_libro?>" readonly></span></td>
                      </tr>
                         </table> </td>
                         <td width="339"> <table width="338" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                       <td width="137" align="center"><span class="Estilo5">SALDO ANTERIOR : </span></td>
               <td width="200" align="left"><span class="Estilo5"><input class="Estilo10" name="txtsaldo_ant_bancos" type="text" id="txtsaldo_ant_bancos" size="16"  style="text-align:right"  value="<?php echo $saldo_ant_banco?>" readonly></span></td>
                      </tr>
                         </table> </td>
                   </tr>
                  </table>

                  </td>
                </tr>
                </table>
        <table width="770" height="246" border="1" cellspacing='0' cellpadding='0' align="center" id="periodos">
          <tr height="20" class="Estilo5">
            <td width="90" height="25" align="center" bgcolor="#99CCFF"><strong>PERIODO</strong></td>
            <td width="170" align="center" bgcolor="#99CCFF"><strong>DEBITO</strong></td>
            <td width="170" align="center" bgcolor="#99CCFF"><strong>CREDITO</strong></td>
            <td width="170" align="center" bgcolor="#99CCFF" ><strong>D&Eacute;BITO</strong></td>
            <td width="170" align="center" bgcolor="#99CCFF"><strong>CR&Eacute;DITO</strong></td>
          </tr>
          <tr class="Estilo5">
            <td height="20" class="Estilo5">ENERO</td>
            <td align="right"><?php  echo formato_monto($debito01); ?></td>
            <td align="right"><?php  echo formato_monto($credito01); ?></td>
            <td align="right"><?php  echo formato_monto($debitob01); ?></td>
            <td align="right"><?php  echo formato_monto($creditob01); ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20" class="Estilo5">FEBRERO</td>
            <td align="right"><?php  echo formato_monto($debito02); ?></td>
            <td align="right"><?php  echo formato_monto($credito02); ?></td>
            <td align="right"><?php  echo formato_monto($debitob02); ?></td>
            <td align="right"><?php  echo formato_monto($creditob02); ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">MARZO</td>
            <td align="right"><?php  echo formato_monto($debito03); ?></td>
            <td align="right"><?php  echo formato_monto($credito03); ?></td>
            <td align="right"><?php  echo formato_monto($debitob03); ?></td>
            <td align="right"><?php  echo formato_monto($creditob03); ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">ABRIL</td>
            <td align="right"><?php  echo formato_monto($debito04); ?></td>
            <td align="right"><?php  echo formato_monto($credito04); ?></td>
            <td align="right"><?php  echo formato_monto($debitob04); ?></td>
            <td align="right"><?php  echo formato_monto($creditob04); ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">MAYO</td>
            <td align="right"><?php  echo formato_monto($debito05); ?></td>
            <td align="right"><?php  echo formato_monto($credito05); ?></td>
            <td align="right"><?php  echo formato_monto($debitob05); ?></td>
            <td align="right"><?php  echo formato_monto($creditob05); ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">JUNIO</td>
            <td align="right"><?php  echo formato_monto($debito06); ?></td>
            <td align="right"><?php  echo formato_monto($credito06); ?></td>
            <td align="right"><?php  echo formato_monto($debitob06); ?></td>
            <td align="right"><?php  echo formato_monto($creditob06); ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">JULIO</td>
            <td align="right"><?php  echo formato_monto($debito07); ?></td>
            <td align="right"><?php  echo formato_monto($credito07); ?></td>
            <td align="right"><?php  echo formato_monto($debitob07); ?></td>
            <td align="right"><?php  echo formato_monto($creditob07); ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">AGOSTO</td>
            <td align="right"><?php  echo formato_monto($debito08); ?></td>
            <td align="right"><?php  echo formato_monto($credito08); ?></td>
            <td align="right"><?php  echo formato_monto($debitob08); ?></td>
            <td align="right"><?php  echo formato_monto($creditob08); ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">SEPTIEMBRE</td>
            <td align="right"><?php  echo formato_monto($debito09); ?></td>
            <td align="right"><?php  echo formato_monto($credito09); ?></td>
            <td align="right"><?php  echo formato_monto($debitob09); ?></td>
            <td align="right"><?php  echo formato_monto($creditob09); ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">OCTUBRE</td>
            <td align="right"><?php  echo formato_monto($debito10); ?></td>
            <td align="right"><?php  echo formato_monto($credito10); ?></td>
            <td align="right"><?php  echo formato_monto($debitob10); ?></td>
            <td align="right"><?php  echo formato_monto($creditob10); ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">NOVIEMBRE</td>
            <td align="right"><?php  echo formato_monto($debito11); ?></td>
            <td align="right"><?php  echo formato_monto($credito11); ?></td>
            <td align="right"><?php  echo formato_monto($debitob11); ?></td>
            <td align="right"><?php  echo formato_monto($creditob11); ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">DICIEMBRE</td>
            <td align="right"><?php  echo formato_monto($debito12); ?></td>
            <td align="right"><?php  echo formato_monto($credito12); ?></td>
            <td align="right"><?php  echo formato_monto($debitob12); ?></td>
            <td align="right"><?php  echo formato_monto($creditob12); ?></td>
          </tr>
        </table>
        <table width="879" height="37" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="870" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="40"><input class="Estilo10" name="txtactiva" type="hidden" id="txtactiva" value="<?php echo $activa?>"></td>
                <td width="160">&nbsp;</td>
                <td width="99"><span class="Estilo5">SALDO ACTUAL : </span></td>
                <td width="234"><span class="Estilo5"><input class="Estilo10" name="txtsaldo_act_libros" type="text"  id="txtsaldo_act_libros" value="<?php echo $saldo_libro?>"  style="text-align:right"  size="20" readonly>   </span></td>
                <td width="100"><span class="Estilo5">SALDO ACTUAL : </span></td>
                <td width="237"><span class="Estilo5"><input class="Estilo10" name="txtsaldo_act_bancos" type="text"  id="txtsaldo_act_bancos" value="<?php echo $saldo_banco?>"  style="text-align:right"  size="20" readonly>     </span></td>
              </tr>
            </table>
              <span class="Estilo5"></span></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
