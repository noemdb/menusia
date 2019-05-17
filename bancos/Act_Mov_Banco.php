<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); 
include ("../class/configura.inc"); $equipo = getenv("COMPUTERNAME"); $mcod_m = "BAN05L".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000035"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}

if (!$_GET){  $gcod_banco='';  $cod_banco='';  $p_letra=''; $tipo_mov='';  $referencia=''; $sql="SELECT * FROM MOV_BANCOS ORDER BY cod_banco,referencia,tipo_mov_banco";}
else {  $gcod_banco=$_GET["Gcod_banco"];  $p_letra=substr($gcod_banco, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_banco=substr($gcod_banco,1,4);$referencia=substr($gcod_banco,5,8);$tipo_mov=substr($gcod_banco,13,3);}
  $sql="Select * from MOV_BANCOS where cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_banco='$tipo_mov'"; $clave=$cod_banco.$referencia.$tipo_mov;
  if ($p_letra=="P"){$sql="SELECT * FROM MOV_BANCOS ORDER BY cod_banco,referencia,tipo_mov_banco";}
  if ($p_letra=="U"){$sql="SELECT * From MOV_BANCOS Order by cod_banco Desc,referencia Desc,tipo_mov_banco Desc";}
  if ($p_letra=="S"){$sql="SELECT * From MOV_BANCOS Where (text(cod_banco)||text(referencia)||text(tipo_mov_banco)>'$clave') Order by cod_banco,referencia,tipo_mov_banco";}
  if ($p_letra=="A"){$sql="SELECT * From MOV_BANCOS Where (text(cod_banco)||text(referencia)||text(tipo_mov_banco)<'$clave') Order by cod_banco Desc,referencia Desc,tipo_mov_banco Desc";}
} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Movimientos en Bancos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Mov(mop){document.form2.submit();}
function Llamar_Ventana(url){var murl;
var Gcod_banco=document.form1.txtcod_banco.value; murl=url+Gcod_banco;
    if (Gcod_banco=="")  {alert("Codigo de Banco debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_Mov_Banco.php";
   if(MPos=="P"){murl="Act_Mov_Banco.php?Gcod_banco=P"}
   if(MPos=="U"){murl="Act_Mov_Banco.php?Gcod_banco=U"}
   if(MPos=="S"){murl="Act_Mov_Banco.php?Gcod_banco=S"+document.form1.txtcod_banco.value+document.form1.txtreferencia.value+document.form1.txttipo_movimiento.value;}
   if(MPos=="A"){murl="Act_Mov_Banco.php?Gcod_banco=A"+document.form1.txtcod_banco.value+document.form1.txtreferencia.value+document.form1.txttipo_movimiento.value;}
   document.location = murl;
}
function Llama_Eliminar(manu,mconc){var url; var r;
var Gtipo_mov=document.form1.txttipo_movimiento.value
  if(mconc=="00"){if ((Gtipo_mov=="ANU")||(Gtipo_mov=="ANC")||(Gtipo_mov=="AND")||(Gtipo_mov=="REV")){alert("MOVIMIENTO  NO PUEDE SER ELIMINADO"); }
  else{if(manu=="S"){url="Movimiento Esta ANULADO, ";}else{url="";} r=confirm(url+"Esta seguro en Eliminar el Movimiento en Banco ?");
    if (r==true){r=confirm("Esta Realmente seguro en Eliminar el Movimiento en Banco ?");
      if (r==true){url="Delete_mov_banco.php?cod_banco="+document.form1.txtcod_banco.value+"&referencia="+document.form1.txtreferencia.value+"&tipo_mov="+Gtipo_mov; VentanaCentrada(url,'Eliminar Orden','','400','400','true');}}
    else {url="Cancelado, no elimino";}
  } }else {alert("MOVIMIENTO ESTA CONCILIADO");}
}
function Llama_Anular(manu,mconc){var url;
var Gtipo_mov=document.form1.txttipo_movimiento.value
  if(mconc=="00"){if ((Gtipo_mov=="ANU")||(Gtipo_mov=="ANC")||(Gtipo_mov=="AND")||(Gtipo_mov=="REV")||(manu=="S")){alert("MOVIMIENTO  NO PUEDE SER ANULADO"); }
  else{url="Anula_mov_banco.php?cod_banco="+document.form1.txtcod_banco.value+"&referencia="+document.form1.txtreferencia.value+"&tipo_mov="+Gtipo_mov+"&fecha_fin=<?echo $Fec_Fin_Ejer?>"; VentanaCentrada(url,'Anular Movimiento','','800','400','true'); } }else {alert("MOVIMIENTO ESTA CONCILIADO");}
}
function Llama_cargar(codigo_mov){var url;  murl="Car_Mov_Banco.php?codigo_mov="+codigo_mov; document.location=murl;}
</script>
<SCRIPT language="JavaScript"  src="../class/sia.js"  type="text/javascript"></SCRIPT>
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
$resultado=pg_exec($conn,"SELECT BORRAR_BAN035('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$nombre_banco="";$nro_cuenta="";$des_tipo_mov="";$referencia=""; $tipo_mov=""; $descripcion=""; $monto_mov_banco=0; $fecha=""; $inf_usuario=""; $anulado="N"; $mes_conciliacion="00"; $fecha_anulado="";
$res=pg_query($sql);$filas=pg_num_rows($res); if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From MOV_BANCOS ORDER BY cod_banco,referencia,tipo_mov_banco";} if ($p_letra=="A"){$sql="SELECT * From MOV_BANCOS ORDER BY cod_banco Desc,referencia Desc,tipo_mov_banco Desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"];$nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"]; $mes_conciliacion=$registro["mes_conciliacion"]; $fecha_anulado=$registro["fecha_anulado"];
  $des_tipo_mov=$registro["descrip_tipo_mov"]; $referencia=$registro["referencia"];  $tipo_mov=$registro["tipo_mov_banco"];   $fecha=$registro["fecha_mov_banco"];
  $monto_mov_banco=$registro["monto_mov_banco"]; $descripcion=$registro["des_mov_banco"];   $inf_usuario=$registro["inf_usuario"];
}$clave=$cod_banco.$referencia.$tipo_mov;  $monto_mov_banco=formato_monto($monto_mov_banco); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}  if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}  $criterio=$sfecha.$referencia.'B'.$cod_banco;if(($anulado=='S')and(($tipo_mov=="ANU")or($tipo_mov=="ANC")or($tipo_mov=="AND"))){$criterio=$sfecha.'A'.substr($referencia,1,7).'B'.$cod_banco;}
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MOVIMIENTOS EN BANCOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="351" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="345"><table width="92" height="342" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Mov('I')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu ref="javascript:Llamar_Inc_Mov('I')">Incluir</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llama_cargar('<?echo $codigo_mov?>') ";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu ref="javascript:Llama_cargar('<?echo $codigo_mov?>')">Cargar</a></div></td>
      </tr>
      <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Mover_Registro('P');">Primero</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
	    <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
	  </tr>
	  <tr>
		<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
	  </tr>
	  <tr>
		<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_mov_banco.php')";
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_mov_banco.php" class="menu">Catalogo</a></div></td>
	  </tr>
	  <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
	  <tr>
		<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar('<?echo $anulado?>','<? echo $mes_conciliacion?>');" class="menu">Eliminar</a></div></td>
	  </tr>
	  <?} if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?>
	  <tr>
		<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Anular('<?echo $anulado?>','<? echo $mes_conciliacion?>');" class="menu">Anular</a></div></td>
	  </tr>
	  <?}?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:868px; height:290px; z-index:1; top: 83px; left: 114px;">
        <form name="form1" method="post">
          <table width="863" border="0" cellspacing="1" cellpadding="1">
                <tr>
                  <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                      <td width="115"><span class="Estilo5">C&Oacute;DIGO BANCO:</span></td>
                      <td width="107"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text"  id="txtcod_banco"  value="<?echo $cod_banco?>" size="8" maxlength="4" readonly> </span></td>
                       <? if($anulado=='S'){?> <td width="151" center><span class="Estilo15">ANULADO</span></td>
                       <? }else{if($mes_conciliacion<>'00'){?> <td width="109"><a class="Estilo19" href="javascript:alert('MOVIMIENTO CONCILIADO EL MES: <?echo $mes_conciliacion?>');">CONCILIADO</a>
                       <? }else{?><td width="102"></td><? }}?>
                      <td width="127"><span class="Estilo5">N&Uacute;MERO DE CUENTA:</span></td>
                      <td width="216"><div align="left"><span class="Estilo5">
                      <input class="Estilo10" name="txtnro_cuenta" type="text"  id="txtnro_cuenta"  value="<?echo $nro_cuenta?>" size="30" maxlength="30" readonly></span></div></td>
                       <td width="28"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>  <td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="854" border="0" cellspacing="1" cellpadding="1">
                      <tr>
                        <td width="130"><span class="Estilo5">NOMBRE DEL BANCO : </span></td>
                        <td width="713"><span class="Estilo5">  <input class="Estilo10" name="txtNombre_Banco" type="text" id="txtcod_titulo32"  value="<?echo $nombre_banco?>" size="100" maxlength="100" readonly> </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>  <td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="854" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="100"><span class="Estilo5">REFERENCIA  :</span></td>
                        <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtreferencia" type="text"  id="txtreferencia"  value="<?echo $referencia?>" size="10" maxlength="8" readonly> </span></td>
                        <td width="122"><span class="Estilo5">TIPO MOVIMIENTO :</span></td>
                        <td width="57"><span class="Estilo5"><input class="Estilo10" name="txttipo_movimiento" type="text" id="txttipo_movimiento"  value="<?echo $tipo_mov?>" size="4" maxlength="4" readonly></span></td>
                        <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_mov" type="text" id="txtdes_tipo_mov"  value="<?echo $des_tipo_mov?>" size="63" maxlength="63" readonly> </span></td>
                      </tr>
                  </table></td>
                </tr>
                 <tr>  <td>&nbsp;</td> </tr>
                <tr>
                  <td width="855"><table width="853" border="0" cellspacing="1" cellpadding="1">
                  <tr>
                   <td width="100"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                   <td width="750"><span class="Estilo5"> <textarea name="txtdescripcion" cols="90" readonly="readonly" id="txtdescripcion"><?echo $descripcion?></textarea> </span></td>
                  </tr>
                  </table></td>
                </tr>
                <tr>  <td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="854" border="0" cellpadding="2" cellspacing="1">
                  <tr>
                    <td width="74"><span class="Estilo5">FECHA :</span></td>
                    <td width="506"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text" id="txtfecha"  value="<?echo $fecha?>" size="10" maxlength="10" readonly></span></td>
                    <td width="66"><span class="Estilo5">MONTO :</span></td>
                    <td width="187"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_mov_banco" type="text" id="txtmonto_mov_banco" style="text-align:right" value="<?echo $monto_mov_banco?>" size="17" maxlength="16" readonly> </span></td>
                  </tr>
                 </table></td>
               </tr>
          </table>
            <p>&nbsp;</p>
        </form>
<form name="form2" method="post" action="Inc_Mov_Banco.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtced_r" type="hidden" id="txtced_r" value="<?echo $Rif_Emp?>"></td>
     <td width="5"><input class="Estilo10" name="txtnomb" type="hidden" id="txtnomb" value="<?echo $Nom_Emp?>"></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input class="Estilo10" name="txtcod_b" type="hidden"  id="txtcod_b"  value="<?echo $cod_banco?>"></td>
	 <td width="5"><input class="Estilo10" name="txtnro_c" type="hidden"  id="txtnro_c"  value="<?echo $nro_cuenta?>"></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_b" type="hidden"  id="txtnombre_b"  value="<?echo $nombre_banco?>"></td>
	 <td width="5"><input class="Estilo10" name="txtref" type="hidden"  id="txtref"  value="<?echo $referencia?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_m" type="hidden" id="txttipo_m"  value="<?echo $tipo_mov?>"></td>
	 <td width="5"><input class="Estilo10" name="txtdes_tipo_m" type="hidden" id="txtdes_tipo_m"  value="<?echo $des_tipo_mov?>"></td>
	 <td width="5"><input class="Estilo10" name="txtdesc" type="hidden" id="txtdesc" value="<?echo $descripcion?>"></td>
  </tr>
</table>
</form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>