<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); $equipo=getenv("COMPUTERNAME"); $mcod_m="BAN04L".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000030"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){  $gcod_banco='';  $cod_banco='';  $p_letra=''; $tipo_mov='';  $referencia=''; $sql="SELECT * FROM MOV_LIBROS ORDER BY cod_banco,referencia,tipo_mov_libro";}
else {  $gcod_banco=$_GET["Gcod_banco"];  $p_letra=substr($gcod_banco,0,1);  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_banco=substr($gcod_banco,1,4);$referencia=substr($gcod_banco,5,8);$tipo_mov=substr($gcod_banco,13,3);}
  $sql="Select * from MOV_LIBROS where cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; $clave=$cod_banco.$referencia.$tipo_mov;
  if ($p_letra=="P"){$sql="SELECT * FROM MOV_LIBROS ORDER BY cod_banco,referencia,tipo_mov_libro";}
  if ($p_letra=="U"){$sql="SELECT * From MOV_LIBROS Order by cod_banco Desc,referencia Desc,tipo_mov_libro Desc";}
  if ($p_letra=="S"){$sql="SELECT * From MOV_LIBROS Where (text(cod_banco)||text(referencia)||text(tipo_mov_libro)>'$clave') Order by cod_banco,referencia,tipo_mov_libro";}
  if ($p_letra=="A"){$sql="SELECT * From MOV_LIBROS Where (text(cod_banco)||text(referencia)||text(tipo_mov_libro)<'$clave') Order by cod_banco Desc,referencia Desc,tipo_mov_libro Desc";}
}  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Movimientos en Libros)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Mov(mop){ if(mop=='M'){ document.form2.submit(); } if(mop=='T'){ document.form3.submit(); } }
function Llamar_Ventana(url){ var murl;
var Gcod_banco=document.form1.txtcod_banco.value; murl=url+Gcod_banco;
    if (Gcod_banco=="")  {alert("Codigo de Banco debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_Mov_Libros.php";
   if(MPos=="P"){murl="Act_Mov_Libros.php?Gcod_banco=P"}
   if(MPos=="U"){murl="Act_Mov_Libros.php?Gcod_banco=U"}
   if(MPos=="S"){murl="Act_Mov_Libros.php?Gcod_banco=S"+document.form1.txtcod_banco.value+document.form1.txtreferencia.value+document.form1.txttipo_movimiento.value;}
   if(MPos=="A"){murl="Act_Mov_Libros.php?Gcod_banco=A"+document.form1.txtcod_banco.value+document.form1.txtreferencia.value+document.form1.txttipo_movimiento.value;}
   document.location = murl;
}
function Llama_Eliminar(manu,mconc){var url;var r; var Gtipo_mov=document.form1.txttipo_movimiento.value; 
  if(mconc=="00"){if ((Gtipo_mov=="ANU")||(Gtipo_mov=="ANC")||(Gtipo_mov=="AND")||(Gtipo_mov=="TRD")){alert("MOVIMIENTO  NO PUEDE SER ELIMINADO"); }
  else{if(manu=="S"){url="Movimiento Esta ANULADO, ";}else{url="";} r=confirm(url+"Esta seguro en Eliminar el Movimiento en Libro ?");
    if (r==true){r=confirm("Esta Realmente seguro en Eliminar el Movimiento en Libro ?");
      if (r==true){url="Delete_mov_libros.php?cod_banco="+document.form1.txtcod_banco.value+"&referencia="+document.form1.txtreferencia.value+"&tipo_mov="+Gtipo_mov; VentanaCentrada(url,'Eliminar Movimiento','','400','400','true');}}
    else {url="Cancelado, no elimino";}
  }}else {alert("MOVIMIENTO ESTA CONCILIADO");}
}
function Llama_Anular(manu,mconc,mfechaf){var url; var Gtipo_mov=document.form1.txttipo_movimiento.value;
  if(mconc=="00"){if ((Gtipo_mov=="ANU")||(Gtipo_mov=="ANC")||(Gtipo_mov=="AND")||(Gtipo_mov=="TRD")||(manu=="S")){alert("MOVIMIENTO  NO PUEDE SER ANULADO"); }
  else{url="Anula_mov_libro.php?cod_banco="+document.form1.txtcod_banco.value+"&referencia="+document.form1.txtreferencia.value+"&tipo_mov="+Gtipo_mov+"&fecha_fin=<?php echo $Fec_Fin_Ejer?>"; VentanaCentrada(url,'Anular Movimiento','','800','400','true'); }}else {alert("MOVIMIENTO ESTA CONCILIADO");}
}
function Llama_Anular_cta(manu,mconc,mfechaf){var url; var Gtipo_mov=document.form1.txttipo_movimiento.value;
  if(mconc=="00"){if ((Gtipo_mov=="ANU")||(Gtipo_mov=="ANC")||(Gtipo_mov=="AND")||(Gtipo_mov=="TRD")||(manu=="S")){alert("MOVIMIENTO  NO PUEDE SER ANULADO"); }
  else{   if ((Gtipo_mov=="DEP")||(Gtipo_mov=="DSD")||(Gtipo_mov=="DFT")||(Gtipo_mov=="NCR")||(Gtipo_mov=="TCR")||(Gtipo_mov=="TDB")) { url="Anula_mov_libro_cta.php?cod_banco="+document.form1.txtcod_banco.value+"&referencia="+document.form1.txtreferencia.value+"&tipo_mov="+Gtipo_mov+"&fecha_fin="+mfechaf; document.location=url; } 
    else{ alert("MOVIMIENTO NO VALIDO"); }
 }}else {alert("MOVIMIENTO ESTA CONCILIADO");}
}
function Llamar_Formato(){var url;var r; var Gtipo_mov=document.form1.txttipo_movimiento.value; 
 if (Gtipo_mov=="CHQ"){alert("MOVIMIENTO  NO PUEDE SER IMPRESO"); }
  else{ r=confirm("Desea Generar el Formato ?");
   if (r==true) {url="../bancos/rpt/Rpt_formato_mov_libro.php?cod_banco="+document.form1.txtcod_banco.value+"&referencia="+document.form1.txtreferencia.value+"&tipo_mov="+Gtipo_mov;
    window.open(url);}  }
}
function Llama_Mov_Multiples(manu,pemision){var url=""; var Gtipo_mov=document.form1.txttipo_movimiento.value; var mmonto_mov=document.form1.txtmonto_mov_libro.value;  var mov_val=0; 
  if ((Gtipo_mov=="ANU")||(Gtipo_mov=="ANC")||(Gtipo_mov=="AND")||(Gtipo_mov=="TRD")||(manu=="S")){mov_val=0; }
  else{ if (Gtipo_mov=="DEP"){url="Reversa_Deposito.php?"; mov_val=1;}  if ((Gtipo_mov=="NDB")&&(pemision=="N")){url="Reversa_Nota_Debito.php?"; mov_val=1;}   }
  if(mov_val==1){ url=url+"cod_banco="+document.form1.txtcod_banco.value+"&referencia="+document.form1.txtreferencia.value+"&tipo_mov="+Gtipo_mov+"&monto_mov="+mmonto_mov; 
    document.location = url; }  else{alert("MOVIMIENTO NO VALIDO"); }	
}
function Llama_Copiar(){var url; var Gtipo_mov=document.form1.txttipo_movimiento.value;
 if ((Gtipo_mov=="ANU")||(Gtipo_mov=="ANC")||(Gtipo_mov=="AND")||(Gtipo_mov=="TRD")||(Gtipo_mov=="CHQ")){alert("MOVIMIENTO  NO PUEDE SER COPIAR"); }
  else{url="Copia_mov_libro.php?cod_banco="+document.form1.txtcod_banco.value+"&referencia="+document.form1.txtreferencia.value+"&tipo_mov="+document.form1.txttipo_movimiento.value;
  VentanaCentrada(url,'Copiar Movimiento en Libro','','400','400','true'); }
}

function Llama_modificar(){var url; var Gtipo_mov=document.form1.txttipo_movimiento.value;
 if ((Gtipo_mov=="ANU")||(Gtipo_mov=="ANC")||(Gtipo_mov=="AND")||(Gtipo_mov=="TRD")||(Gtipo_mov=="CHQ")){alert("MOVIMIENTO  NO PUEDE SER MODIFICADO"); }
  else{url="Mod_Mov_Libros.php?cod_banco="+document.form1.txtcod_banco.value+"&referencia="+document.form1.txtreferencia.value+"&tipo_mov="+document.form1.txttipo_movimiento.value;
  document.location = url; }
}
</script>
<script language="JavaScript"  src="../class/sia.js"  type="text/javascript"></script>
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
<?php  $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')"); $merror=pg_errormessage($conn); $merror=substr($merror, 0, 91);
$resultado=pg_exec($conn,"SELECT BORRAR_BAN035('$codigo_mov')");  $merror=pg_errormessage($conn); $merror=substr($merror, 0, 91);
$nombre_banco="";$nro_cuenta="";$des_tipo_mov="";$referencia=""; $tipo_mov="";$nombre_benef=""; $ced_rif=""; $descripcion=""; $monto_mov_libro=0; $fecha=""; $inf_usuario=""; $anulado="N"; $mes_conciliacion="00"; $fecha_anulado="";  $inf_anul=""; $por_emision=""; $cod_bancoa=""; $referenciaa="";
$res=pg_query($sql);$filas=pg_num_rows($res); if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From MOV_LIBROS ORDER BY cod_banco,referencia,tipo_mov_libro";} if ($p_letra=="A"){$sql="SELECT * From MOV_LIBROS ORDER BY cod_banco Desc,referencia Desc,tipo_mov_libro Desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0);  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"];$nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"]; $mes_conciliacion=$registro["mes_conciliacion"]; $fecha_anulado=$registro["fecha_anulado"];
  $des_tipo_mov=$registro["descrip_tipo_mov"]; $referencia=$registro["referencia"];  $tipo_mov=$registro["tipo_mov_libro"];   $fecha=$registro["fecha_mov_libro"]; $por_emision=$registro["por_emision"]; $cod_bancoa=$registro["cod_bancoa"]; $referenciaa=$registro["referenciaa"];
  $monto_mov_libro=$registro["monto_mov_libro"]; $descripcion=$registro["descrip_mov_libro"];  $nombre_benef=$registro["nombre"]; $ced_rif=$registro["ced_rif"]; $inf_usuario=$registro["inf_usuario"];
  $inf_anul="Movimiento Anulado con Fecha: ".formato_ddmmaaaa($fecha_anulado);
}$clave=$cod_banco.$referencia.$tipo_mov;  $monto_mov_libro=formato_monto($monto_mov_libro); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}  if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}  $criterio=$sfecha.$referencia.'B'.$cod_banco;if(($anulado=='S')and(($tipo_mov=="ANU")or($tipo_mov=="ANC")or($tipo_mov=="AND"))){$criterio=$sfecha.'A'.substr($referencia,1,7).'B'.$cod_banco;}
if($cod_bancoa=="AJC"){$tipo_comp='00000'; $criterio=$sfecha.$referenciaa.$tipo_comp;} 
pg_close($conn);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MOVIMIENTOS EN LIBROS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="528" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="523" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Mov('M')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Mov('M')">Incluir Mov.</A></td>
      </tr>	  
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"  onClick="javascript:Llamar_Inc_Mov('T')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Inc_Mov('T')">Incluir Tranferencias</a></div></td>
      </tr>
	  <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llama_modificar();";
	  
            onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llama_modificar();">Modificar</a></div></td>
       </tr>
	  <?php } if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu   href="javascript:Mover_Registro('P');">Primero</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
  </tr>  
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_mov_libro.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_mov_libro.php" class="menu">Catalogo</a></div></td>
  </tr>
  <?php } if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Anular('<?php echo $anulado?>','<?php  echo $mes_conciliacion?>','<?php echo $Fec_Fin_Ejer?>');" class="menu">Anular</a></div></td>
  </tr>
  <?php } if (($Mcamino{7}=="S")and($Cod_Emp=="70")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Anular_cta('<?php echo $anulado?>','<?php  echo $mes_conciliacion?>','<?php echo $Fec_Fin_Ejer?>');" class="menu">Anular Cta. Especifica</a></div></td>
  </tr>
  
  <?php } if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar('<?php echo $anulado?>','<?php  echo $mes_conciliacion?>');" class="menu">Eliminar</a></div></td>
  </tr>
  <?php } if (($Mcamino{7}=="S")and($Cod_Emp=="70")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Mov_Multiples('<?php echo $anulado?>','<?php echo $por_emision?>');" class="menu">Movimientos Multiples</a></div></td>
  </tr>
  <?php } if ($Mcamino{4}=="S"){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></div></td>
  </tr>
  <?php }?>
  
  <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
	<tr>
	  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
	  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Copiar();" class="menu">Copiar</a></td>
	</tr>
  <?php }?>	
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></div></td>
  </tr>
  <tr><td>&nbsp;</td> </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:858px; height:510px; z-index:1; top: 70px; left: 115px;">
        <form name="form1" method="post">
          <table width="868" border="0" >
                <tr>
                  <td width="862"><table width="860">
                    <tr>
                      <td width="105"><span class="Estilo5">C&Oacute;DIGO BANCO:</span></td>
                      <td width="170"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text"  id="txtcod_banco"  value="<?php echo $cod_banco?>" size="8" maxlength="4" readonly> </span></td>
                       <?php  if($anulado=='S'){?> <td width="200" center><a class="Estiloanu" href="javascript:alert('<?php echo $inf_anul?>');" >ANULADO</a></td>
                       <?php }else{if($mes_conciliacion<>'00'){?> <td width="109"><a class="Estilo19" href="javascript:alert('MOVIMIENTO CONCILIADO EL MES: <?php echo $mes_conciliacion?>');">CONCILIADO</a>
                       <?php }else{?><td width="200"></td><?php } }?>
                      <td width="130"><span class="Estilo5">N&Uacute;MERO DE CUENTA:</span></td>
                      <td width="220"><div align="left"><span class="Estilo5">
                      <input class="Estilo10" name="txtnro_cuenta" type="text"  id="txtnro_cuenta"  value="<?php echo $nro_cuenta?>" size="30" maxlength="30" readonly></span></div></td>
                       <td width="35"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                      <tr>
                        <td width="126"><span class="Estilo5">NOMBRE DEL BANCO  : </span></td>
                        <td width="717"><span class="Estilo5"><input class="Estilo10" name="txtnombre_banco" type="text"  id="txtnombre_banco"  value="<?php echo $nombre_banco?>" size="110" maxlength="100" readonly></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                      <tr>
                        <td width="100"><span class="Estilo5">REFERENCIA  :</span></td>
                        <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtreferencia" type="text"  id="txtreferencia"  value="<?php echo $referencia?>" size="10" maxlength="8" readonly> </span></td>
                        <td width="122"><span class="Estilo5">TIPO MOVIMIENTO :</span></td>
                        <td width="57"><span class="Estilo5"><input class="Estilo10" name="txttipo_movimiento" type="text" id="txttipo_movimiento"  value="<?php echo $tipo_mov?>" size="4" maxlength="4" readonly></span></td>
                        <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_mov" type="text" id="txtdes_tipo_mov"  value="<?php echo $des_tipo_mov?>" size="63" maxlength="63" readonly> </span></td>
                      </tr>
                  </table></td>
                </tr>
          <tr>
            <td><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                <td width="115"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text"  id="txtced_rif"  value="<?php echo $ced_rif?>" size="14" maxlength="12" readonly> </span> </td>
                <td width="100"><span class="Estilo5">BENEFICIARIO : </span></td>
                <td width="540"><span class="Estilo5"><input class="Estilo10" name="txtnombre_benef" type="text" id="txtnombre_benef"  value="<?php echo $nombre_benef?>" size="77" maxlength="80" readonly> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td ><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                <td width="750"><span class="Estilo5"><textarea name="txtdescripcion" cols="90" readonly="readonly"  class="Estilo10" id="txtdescripcion"><?php echo $descripcion?></textarea>
                </span> </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">FECHA :</span></td>
                <td width="390"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text"  id="txtfecha" value="<?php echo $fecha?>" size="12" maxlength="10" readonly></span></td>
                <td width="69"><span class="Estilo5">MONTO :</span></td>
                <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtmonto_mov_libro"  style="text-align:right"  type="text"  id="txtmonto_mov_libro"  value="<?php echo $monto_mov_libro?>" size="17" maxlength="16" readonly> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>  <td>&nbsp;</td> </tr>
        </table>
        <iframe src="Det_cons_comp_libro.php?criterio=<?php echo $criterio?>" width="850" height="250" scrolling="auto" frameborder="1">
        </iframe>
        </form>
<form name="form2" method="post" action="Inc_Mov_Libros.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?php echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?php echo $host?>" ></td>	      
     <td width="5"><input class="Estilo10" name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?php echo $nro_aut?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtced_r" type="hidden" id="txtced_r" value="<?php echo $Rif_Emp?>"></td>
     <td width="5"><input class="Estilo10" name="txtnomb" type="hidden" id="txtnomb" value="<?php echo $Nom_Emp?>"></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?php echo $Fec_Fin_Ejer?>"></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_b" type="hidden"  id="txtcod_b"  value="<?php echo $cod_banco?>"></td>
	 <td width="5"><input class="Estilo10" name="txtnro_c" type="hidden"  id="txtnro_c"  value="<?php echo $nro_cuenta?>"></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_b" type="hidden"  id="txtnombre_b"  value="<?php echo $nombre_banco?>"></td>
	 <td width="5"><input class="Estilo10" name="txtref" type="hidden"  id="txtref"  value="<?php echo $referencia?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_m" type="hidden" id="txttipo_m"  value="<?php echo $tipo_mov?>"></td>
	 <td width="5"><input class="Estilo10" name="txtdes_tipo_m" type="hidden" id="txtdes_tipo_m"  value="<?php echo $des_tipo_mov?>"></td>
	 <td width="5"><input class="Estilo10" name="txtdesc" type="hidden" id="txtdesc" value="<?php echo $descripcion?>"></td>
	 <td width="5"><input class="Estilo10" name="txtmonto_mov" type="hidden" id="txtmonto_mov" value="0"></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_m" type="hidden" id="txtfecha_m" value=""></td>	
  </tr>
</table>
</form>
<form name="form3" method="post" action="Inc_trans_Libros.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser2" type="hidden" id="txtuser2" value="<?php echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword2" type="hidden" id="txtpassword2" value="<?php echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname2" type="hidden" id="txtdbname2" value="<?php echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport2" type="hidden" id="txtport2" value="<?php echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost2" type="hidden" id="txthost2" value="<?php echo $host?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnro_aut2" type="hidden" id="txtnro_aut2" value="<?php echo $nro_aut?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov2" type="hidden" id="txtcodigo_mov2" value="<?php echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtced_r2" type="hidden" id="txtced_r2" value="<?php echo $Rif_Emp?>"></td>
     <td width="5"><input class="Estilo10" name="txtnomb2" type="hidden" id="txtnomb2" value="<?php echo $Nom_Emp?>"></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_fin2" type="hidden" id="txtfecha_fin2" value="<?php echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input class="Estilo10" name="txtcod_b2" type="hidden"  id="txtcod_b2"  value="<?php echo $cod_banco?>"></td>
	 <td width="5"><input class="Estilo10" name="txtnro_c2" type="hidden"  id="txtnro_c2"  value="<?php echo $nro_cuenta?>"></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_b2" type="hidden"  id="txtnombre_b2"  value="<?php echo $nombre_banco?>"></td>
	 <td width="5"><input class="Estilo10" name="txtref2" type="hidden"  id="txtref2"  value="<?php echo $referencia?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_m2" type="hidden" id="txttipo_m2"  value="<?php echo $tipo_mov?>"></td>
	 <td width="5"><input class="Estilo10" name="txtdes_tipo_m2" type="hidden" id="txtdes_tipo_m2"  value="<?php echo $des_tipo_mov?>"></td>
	 <td width="5"><input class="Estilo10" name="txtdesc2" type="hidden" id="txtdesc" value="<?php echo $descripcion?>"></td>
	 <td width="5"><input class="Estilo10" name="txtmonto_mov2" type="hidden" id="txtmonto_mov2" value="0"></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_m2" type="hidden" id="txtfecha_m2" value=""></td>	
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
