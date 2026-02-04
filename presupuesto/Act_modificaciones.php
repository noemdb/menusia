<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="02-0000025"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); 
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
$equipo = getenv("COMPUTERNAME");$mcod_m="PRE009".$usuario_sia.$equipo; $fecha_hoy=asigna_fecha_hoy(); 
if (!$_GET){$p_letra=''; $criterio='';$referencia_modif=''; $tipo_modif=''; $sql="SELECT * FROM PRE009 ORDER BY referencia_modif,tipo_modif"; $codigo_mov=substr($mcod_m,0,49);
} else {$codigo_mov="";$criterio = $_GET["Gcriterio"]; $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$referencia_modif=substr($criterio,1,8);  $tipo_modif=substr($criterio,9,1);}
   else{$referencia_modif=substr($criterio,0,8); $tipo_modif=substr($criterio,8,1);$codigo_mov=substr($mcod_m,0,49); }
  $clave=$referencia_modif.$tipo_modif;
  $sql="Select * FROM PRE009 where tipo_modif='$tipo_modif' and referencia_modif='$referencia_modif'";
  if ($p_letra=="P"){$sql="SELECT * FROM PRE009 Order by referencia_modif,tipo_modif";}
  if ($p_letra=="U"){$sql="SELECT * FROM PRE009 Order by referencia_modif desc,tipo_modif desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM PRE009 Where (text(referencia_modif)||text(tipo_modif)>'$clave') Order by referencia_modif,tipo_modif";}
  if ($p_letra=="A"){$sql="SELECT * FROM PRE009 Where (text(referencia_modif)||text(tipo_modif)<'$clave') Order by text(referencia_modif)||text(tipo_modif) desc";}
  }
 $fecha_f=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_f)){$fecha_hoy=$fecha_f;}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Modificaciones Presupuestaria)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var mSIA_Definicion='<?php echo $SIA_Definicion ?>';
function Llamar_Inc_modif(mop){ if(mSIA_Definicion=='N'){ muestra('ETAPA DE DEFINICION ABIERTA'); }
 else{	if(mop=='T'){ document.form2.submit(); } 	 if(mop=='A'){ document.form3.submit(); } 	 if(mop=='D'){ document.form4.submit(); }  }
}
function Llamar_Modificar(){var murl;
 murl="Mod_modif.php?txtreferencia_modif="+document.form1.txtreferencia_modif.value+"&txttipo_modif="+document.form1.txttipo_m.value;
 document.location = murl;
}
function Llamar_Aprobar(){var murl;
 murl="Aprobar_modif.php?txtreferencia_modif="+document.form1.txtreferencia_modif.value+"&txttipo_modif="+document.form1.txttipo_m.value;
 document.location = murl;
}
function Mover_Registro(MPos){var murl;
   murl="Act_modificaciones.php";
   if(MPos=="P"){murl="Act_modificaciones.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_modificaciones.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_modificaciones.php?Gcriterio=S"+document.form1.txtreferencia_modif.value+document.form1.txttipo_m.value;}
   if(MPos=="A"){murl="Act_modificaciones.php?Gcriterio=A"+document.form1.txtreferencia_modif.value+document.form1.txttipo_m.value;}
   document.location = murl;
}
function Llama_Eliminar(maprob,mmodif_ap){var url; var r;
var Gtipo_modif=document.form1.txttipo_m.value;
  if ((Gtipo_modif=="") ||  ((maprob=="SI")&&(mmodif_ap=="N"))) { alert("MODIFICACION, NO PUEDE SER ELIMINADO"); }
  else{  r=confirm("Esta seguro en Eliminar la Modificacion Presupuestaria ?");
    if (r==true) { r=confirm("Esta Realmente seguro en Eliminar la Modificacion Presupuestaria ?");
      if (r==true) {  url="Delete_modif.php?txtreferencia_modif="+document.form1.txtreferencia_modif.value+"&txttipo_modif="+document.form1.txttipo_m.value;
         VentanaCentrada(url,'Eliminar Modificacion','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
  }
}

function Llama_Anular(maprob,mmodif_ap,mfechaf){var url; var r;
var Gtipo_modif=document.form1.txttipo_m.value; 
  if ((maprob=="SI")&&(mmodif_ap=="N")) { alert("MODIFICACION, NO PUEDE SER ANULADO"); }
  else{url="Anula_modificacion.php?txtreferencia_modif="+document.form1.txtreferencia_modif.value+"&txttipo_modif="+document.form1.txttipo_m.value+"&fecha_fin="+mfechaf;
    VentanaCentrada(url,'Anular Modificacion','','800','380','true');}
}
function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Formato Modificaciones ?");
   if (r==true) {url="/sia/presupuesto/rpt/Rpt_reg_modificaciones.php?txttipo_modif="+document.form1.txttipo_m.value+"&txtreferencia_modif="+document.form1.txtreferencia_modif.value;
    window.open(url);
  }
}

function Llama_Copiar(){var url;
 url="Copia_modificaciones.php?txtreferencia_modif="+document.form1.txtreferencia_modif.value+"&txttipo_modif="+document.form1.txttipo_m.value;
 VentanaCentrada(url,'Copiar Modificacion','','400','400','true');
}
</script>
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
</script>
</head>
<?php 
if ($codigo_mov==""){$codigo_mov="";}
else{ $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php } }
$mconf="";$Ssql="Select * from SIA005 where campo501='05'";$resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"];}$nro_aut=substr($mconf,10,1);$fecha_aut=substr($mconf,11,1);
$preg_t=substr($mconf,12,1); $corr_m=substr($mconf,13,1); $modif_apr=substr($mconf,14,1);
$descripcion="";$fecha_registro="";$modif_i_e="";$fecha_modif="";$modif_aprob="";$inf_usuario="";$aprobada_por="";$nro_documento="";$fecha_documento="";$anulado=""; $fecha_anu="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM PRE009 Order by referencia_modif,tipo_modif";} if ($p_letra=="A"){$sql="SELECT * FROM PRE009 Order by referencia_modif desc,tipo_modif desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>0){$registro=pg_fetch_array($res);
  $referencia_modif=$registro["referencia_modif"];  $fecha_registro=$registro["fecha_registro"];
  $fecha_modif=$registro["fecha_modif"];  $tipo_modif=$registro["tipo_modif"];
  $descripcion=$registro["descripcion_modif"];  $modif_i_e=$registro["modif_i_e"];
  $modif_aprob=$registro["modif_aprob"];  $aprobada_por=$registro["aprobada_por"];  $anulado=$registro["anulado"]; $fecha_anu=$registro["fecha_anu"]; 
  $nro_documento=$registro["nro_documento"];  $fecha_documento=$registro["fecha_documento"];  $inf_usuario=$registro["inf_usuario"];
}
if($fecha_registro==""){$fecha_registro="";}else{$fecha_registro=formato_ddmmaaaa($fecha_registro);}
if($fecha_modif==""){$fecha_modif="";}else{$fecha_modif=formato_ddmmaaaa($fecha_modif);}
if($fecha_documento==""){$fecha_documento="";}else{$fecha_documento=formato_ddmmaaaa($fecha_documento);}
if($fecha_anu==""){$fecha_anu="";}else{$fecha_anu=formato_ddmmaaaa($fecha_anu);}
$des_tipo_modif="";$msta=""; $inf_sta="";
if($tipo_modif==1){$des_tipo_modif="CREDITOS ADICIONALES";}
if($tipo_modif==2){$des_tipo_modif="RECTIFICACIONES";}
if($tipo_modif==3){$des_tipo_modif="INSUBSISTENCIAS"; $des_tipo_modif="REDUCCION DE GASTOS";}
if($tipo_modif==4){$des_tipo_modif="REDUCCION DE INGRESOS";}
if($tipo_modif==5){$des_tipo_modif="TRASPASOS DE CREDITOS";}
if($tipo_modif==6){$des_tipo_modif="SALDO FINAL DE CAJA";}
if($tipo_modif==7){$des_tipo_modif="INCREMENTO DE INGRESOS";}
if($modif_i_e=='I'){$modif_i_e="INTERNA";}else{$modif_i_e="EXTERNA";}
if($modif_i_e=='1'){$modif_i_e="EXTERNA MAYOR AL 20%";} else {if($modif_i_e=='2'){$modif_i_e="EXTERNA MENOR AL 20%";} else {if($modif_i_e=='3'){$modif_i_e="EXTERNA IGUAL 10%";}}}
if($modif_aprob=='S'){$modif_aprob="SI";} else {$modif_aprob="NO";}
if($anulado=='S'){$msta="ANULADO"; $inf_sta="ANULADO CON FECHA:".$fecha_anu; }
$clave=$referencia_modif.$tipo_modif;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICACIONES PRESUPUESTARIAS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="607" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="602" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
	  <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_modif('T')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_modif('T')">Incluir Traspaso</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_modif('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_modif('A')">Incluir Adicion</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_modif('D')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_modif('D')">Incluir Disminucion</A></td>
      </tr>
	  <?php } if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>	
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Modificar()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Modificar();">Modificar</A></td>
      </tr>
	  <?php } if (($Mcamino{10}=="S")and($SIA_Cierre=="N")){?>	
          <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Aprobar()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Aprobar();">Aprobar</A></td>
      </tr>
	  <?php } if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U'')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_modificaciones.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_modificaciones.php" class="menu">Catalogo</a></td>
  </tr>
  <?php } if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Anular('<?php echo $modif_aprob?>','<?php echo $modif_apr?>','<?php echo $Fec_Fin_Ejer?>');" class="menu">Anular</a></td>
        </tr>
  <?php } if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>	
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar('<?php echo $modif_aprob?>','<?php echo $modif_apr?>');" class="menu">Eliminar</a></td>
  </tr>
  <?php } if ($Mcamino{2}=="S"){?>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Copiar();" class="menu">Copiar</a></td>
        </tr>
  <?php } if ($Mcamino{4}=="S"){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
  </tr>
  <?php }?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:495px; z-index:1; top: 60px; left: 114px;">
            <form name="form1" method="post">
                <table width="867" height="211" >
              <tr>
                <td>
                  <table width="867" align="center">
                    <tr>
                      <td><table width="865" border="0">
                        <tr>
                          <td width="135"><span class="Estilo5">TIPO MODIFICACI&Oacute;N:</span></td>
                          <td width="197"><input class="Estilo10" name="txttipo_modif" type="text"  id="txttipo_modif" value="<?php echo $des_tipo_modif?>" size="30" readonly  ></td>
                          <td width="28"><input class="Estilo10" name="txttipo_m" type="hidden" id="txttipo_m" value="<?php echo $tipo_modif?>"></td>
                          <td width="82"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="115"><input class="Estilo10" name="txtreferencia_modif" type="text"  id="txtreferencia_modif" value="<?php echo $referencia_modif?>" size="9" readonly  ></td>
                          <?php  if($anulado=='S'){?> <td width="109"><a class="Estiloanu"  href="javascript:alert('<?php echo $inf_sta?>');">ANULADO</a></td>
						   <?php }else{?> <td width="30"><span class="Estilo5"></span></td><?php }?>
						  <td width="110"><span class="Estilo5">FECHA REGISTRO:</span> </td>
                          <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtFecha" type="text" id="txtFecha" value="<?php echo $fecha_registro?>" size="10" readonly > </span></td>
                          <td width="20"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtDescripcion" cols="90" readonly="readonly" class="Estilo10" id="textarea"><?php echo $descripcion?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                        <td><table width="819">
                        <tr>
                          <td width="105"><span class="Estilo5">MODIFICACI&Oacute;N:</span></td>
                          <td width="163"><span class="Estilo5"><input class="Estilo10" name="txtmodif_i_e" type="text" id="txtmodif_i_e" size="20"  value="<?php echo $modif_i_e?>" readonly>   </span></td>
                          <td width="166"><span class="Estilo5">FECHA DE MODIFICACI&Oacute;N:</span></td>
                          <td width="141"><span class="Estilo5"><input class="Estilo10" name="txtfecha_modif" type="text" id="txtfecha_modif" value="<?php echo $fecha_modif?>" size="12" readonly>    </span></td>
                          <td width="99"><span class="Estilo5">APROBADA :</span></td>
                          <td width="54"><span class="Estilo5"><input class="Estilo10" name="txtmodif_aprob" type="text" id="txtmodif_aprob" size="3"  value="<?php echo $modif_aprob?>" readonly>   </span></td>
                          <td width="55"><input class="Estilo10" name="corr_m" type="hidden" id="corr_m" value="<?php echo $corr_m?>"></td>
                        </tr>
                      </table></td>
					</tr>
						<tr>
						  <td><table width="800">
                        <tr>
                          <td width="108"><span class="Estilo5">APROBADO POR:</span></td>
                          <td width="680"><span class="Estilo5"> <input class="Estilo10" name="txtaprobada_por" type="text" id="txtaprobada_por" value="<?php echo $aprobada_por?>" size="100" readonly>     </span></td>
                        </tr>
                      </table></td>
					</tr>
						<tr>
						  <td><table width="827">
                        <tr>
                          <td width="230"><span class="Estilo5">NRO.DOCUMENTO/ACTA APROBACI&Oacute;N:</span></td>
                          <td width="337"><input class="Estilo10" name="txtnro_documento" type="text"  id="txtnro_documento" value="<?php echo $nro_documento?>" size="60" readonly ></td>
                          <td width="170"><span class="Estilo5">FECHA DOCUMENTO/ACTA:</span></td>
                          <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtfecha_documento" type="text" id="txtfecha_documento" value="<?php echo $fecha_documento?>" size="10" readonly>     </span></td>
                        </tr>
                      </table></td>
                                    </tr>
                  </table>  </td>
              </tr>
            </table>
        <iframe src="Det_cons_modificaciones.php?criterio=<?php echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        </form>
<form name="form2" method="post" action="Inc_traspaso.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?php echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?php echo $host?>" ></td>
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?php echo $nro_aut?>" ></td>
	 <td width="5"><input name="txtcorr_m" type="hidden" id="txtcorr_m" value="<?php echo $corr_m?>" ></td> 	 
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?php echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtfechar" type="hidden" id="txtfechar" value="<?php echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txtfecham" type="hidden" id="txtfecham" value="<?php echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txtfechad" type="hidden" id="txtfechad" value="<?php echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txtnro_docr" type="hidden" id="txtnro_doc" value=""></td>	 
	 <td width="5"><input name="txtconcepto_r" type="hidden" id="txtconcepto_r" value=""></td>
	 <td width="5"><input name="txtmodie" type="hidden" id="txtmodie" value="I"></td>
	 <td width="5"><input name="txtref_modif" type="hidden" id="txtref_modif" value=""></td>
	 <td width="5"><input name="txttipo_modif" type="hidden" id="txttipo_modif" value=""></td>
  </tr>
</table>
</form>
<form name="form3" method="post" action="Inc_adicion.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser2" type="hidden" id="txtuser2" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword2" type="hidden" id="txtpassword2" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname2" type="hidden" id="txtdbname2" value="<?php echo $dbname?>" ></td>
	 <td width="5"><input name="txtport2" type="hidden" id="txtport2" value="<?php echo $port?>" ></td>	 
	 <td width="5"><input name="txthost2" type="hidden" id="txthost2" value="<?php echo $host?>" ></td>
     <td width="5"><input name="txtnro_aut2" type="hidden" id="txtnro_aut2" value="<?php echo $nro_aut?>" ></td>
	 <td width="5"><input name="txtcorr_m2" type="hidden" id="txtcorr_m2" value="<?php echo $corr_m?>" ></td>
     <td width="5"><input name="txtfecha_aut2" type="hidden" id="txtfecha_aut2" value="<?php echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtcodigo_mov2" type="hidden" id="txtcodigo_mov2" value="<?php echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtfechac2" type="hidden" id="txtfechac2" value="<?php echo $fecha_hoy?>"></td>	 
	 <td width="5"><input name="txtfechar2" type="hidden" id="txtfechar2" value="<?php echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txtfecham2" type="hidden" id="txtfecham2" value="<?php echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txtfechad2" type="hidden" id="txtfechad2" value="<?php echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txtnro_docr2" type="hidden" id="txtnro_doc2" value=""></td>	 
	 <td width="5"><input name="txtconcepto_r2" type="hidden" id="txtconcepto_r2" value=""></td>
	 <td width="5"><input name="txtmodie2" type="hidden" id="txtmodie2" value="I"></td>
	 <td width="5"><input name="txtref_modif2" type="hidden" id="txtref_modif2" value=""></td>
	 <td width="5"><input name="txttipo_modif2" type="hidden" id="txttipo_modif2" value=""></td>
  </tr>
</table>
</form>
<form name="form4" method="post" action="Inc_disminucion.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser3" type="hidden" id="txtuser3" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword3" type="hidden" id="txtpassword3" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname3" type="hidden" id="txtdbname3" value="<?php echo $dbname?>" ></td>
	 <td width="5"><input name="txtport3" type="hidden" id="txtport3" value="<?php echo $port?>" ></td>	 
	 <td width="5"><input name="txthost3" type="hidden" id="txthost3" value="<?php echo $host?>" ></td>
     <td width="5"><input name="txtnro_aut3" type="hidden" id="txtnro_aut3" value="<?php echo $nro_aut?>" ></td>
	 <td width="5"><input name="txtcorr_m3" type="hidden" id="txtcorr_m3" value="<?php echo $corr_m?>" ></td>
     <td width="5"><input name="txtfecha_aut3" type="hidden" id="txtfecha_aut3" value="<?php echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtcodigo_mov3" type="hidden" id="txtcodigo_mov3" value="<?php echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtfechac3" type="hidden" id="txtfechac3" value="<?php echo $fecha_hoy?>"></td>
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
