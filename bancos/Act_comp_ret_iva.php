<?php  include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "BAN027".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000067"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){$criterio='';$p_letra=''; $nro_comprobante='';  $ano_fiscal='';  $mes_fiscal=''; $sql="SELECT * FROM COMP_IVA ORDER BY ano_fiscal desc,mes_fiscal desc,nro_comprobante desc";
} else{ $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $nro_comprobante=substr($criterio,7,8);  $ano_fiscal=substr($criterio,1,4);  $mes_fiscal=substr($criterio,5,2);}
   else{$nro_comprobante=substr($criterio,6,8);  $ano_fiscal=substr($criterio,0,4);  $mes_fiscal=substr($criterio,4,2);}
  $codigo_mov=substr($mcod_m,0,49);   $clave=$ano_fiscal.$mes_fiscal.$nro_comprobante;
  $sql="Select * from COMP_IVA where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante'";
  if ($p_letra=="P"){$sql="SELECT * FROM COMP_IVA ORDER BY ano_fiscal,mes_fiscal,nro_comprobante";}
  if ($p_letra=="U"){$sql="SELECT * FROM COMP_IVA ORDER BY ano_fiscal desc,mes_fiscal desc,nro_comprobante desc";}
  if ($p_letra=="S"){$sql="SELECT * From COMP_IVA Where (text(ano_fiscal)||text(mes_fiscal)||text(nro_comprobante)>'$clave') Order by ano_fiscal,mes_fiscal,nro_comprobante";}
  if ($p_letra=="A"){$sql="SELECT * From COMP_IVA Where (text(ano_fiscal)||text(mes_fiscal)||text(nro_comprobante)<'$clave') Order by text(ano_fiscal)||text(mes_fiscal)||text(nro_comprobante) desc";}
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO  (Comprobante Retenciones IVA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Mover_Registro(MPos){var murl;
   murl="Act_comp_ret_iva.php";
   if(MPos=="P"){murl="Act_comp_ret_iva.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_comp_ret_iva.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_comp_ret_iva.php?Gcriterio=S"+document.form1.txtano_fiscal.value+document.form1.txtmes_fiscal.value+document.form1.txtnro_comprobante.value;}
   if(MPos=="A"){murl="Act_comp_ret_iva.php?Gcriterio=A"+document.form1.txtano_fiscal.value+document.form1.txtmes_fiscal.value+document.form1.txtnro_comprobante.value;}
   document.location = murl;
}
function Llamar_Inc_Comp_iva(){ document.form2.submit(); }
function Llamar_Mod_Comp_iva(){var murl; murl="Mod_comp_ret_iva.php?criterio="+document.form1.txtano_fiscal.value+document.form1.txtmes_fiscal.value+document.form1.txtnro_comprobante.value;document.location=murl; }
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar el Comprobante del IVA ?");
  if(r==true){ r=confirm("Esta Realmente seguro en Eliminar el Comprobante ?");
    if(r==true){url="Delete_comp_iva.php?criterio="+document.form1.txtano_fiscal.value+document.form1.txtmes_fiscal.value+document.form1.txtnro_comprobante.value; VentanaCentrada(url,'Eliminar Comprobante IVA','','400','400','true');}}
      else { url="Cancelado, no elimino"; }
}
function Llama_Anular(){var url; var r;
  r=confirm("Esta seguro en Anular el Comprobante del IVA ?");
  if(r==true){ r=confirm("Esta Realmente seguro en Anular el Comprobante ?");
    if(r==true){url="Anula_comp_iva.php?criterio="+document.form1.txtano_fiscal.value+document.form1.txtmes_fiscal.value+document.form1.txtnro_comprobante.value; VentanaCentrada(url,'Eliminar Comprobante IVA','','400','400','true');}}
      else { url="Cancelado, no elimino"; }
}
function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Comprobante ?");
   if (r==true) {url="../pagos/rpt/Rpt_comp_ret_iva.php?criterio="+document.form1.txtano_fiscal.value+document.form1.txtmes_fiscal.value+document.form1.txtnro_comprobante.value;
    window.open(url);
  }
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
$corr_iva_mes="N";$mconf="";$tipo_causd="0002";$tipo_causc="0001";$tipo_causf="0003";
$Ssql="Select * from SIA005 where campo501='01'"; $resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $tipo_causc=$registro["campo504"];$tipo_causd=$registro["campo505"];$tipo_causf=$registro["campo506"];}
$gen_ord_ret=substr($mconf,0,1); $gen_comp_ret=substr($mconf,1,1); $gen_pre_ret=substr($mconf,2,1);$nro_aut=substr($mconf,4,1); $fecha_aut=substr($mconf,5,1);
$Ssql="Select * from SIA005 where campo501='02'"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$mconfb=$registro["campo502"]; $corr_iva_mes==substr($mconfb,8,1);}else{$mconfb="";}
$resultado=pg_exec($conn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$fecha=""; $ced_rif=""; $nombre_benef=""; $anulada=""; $res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){  if ($p_letra=="A"){$sql="SELECT * FROM COMP_IVA ORDER BY ano_fiscal,mes_fiscal,nro_comprobante";}  if ($p_letra=="S"){$sql="SELECT * FROM COMP_IVA ORDER BY ano_fiscal desc,mes_fiscal desc,nro_comprobante desc";}  $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){  $registro=pg_fetch_array($res);
  $nro_comprobante=$registro["nro_comprobante"]; $ano_fiscal=$registro["ano_fiscal"]; $mes_fiscal=$registro["mes_fiscal"];
  $fecha=$registro["fecha_emision"];  $ced_rif=$registro["ced_rif"];   $nombre_benef=$registro["nombre"];  $inf_usuario=$registro["inf_usuario"];
  $tipo_operacion=$registro["tipo_operacion"]; $monto_iva_retenido=$registro["monto_iva_retenido"];
  if(($tipo_operacion=='A') and ($monto_iva_retenido==0)){ $anulada='S';}
} 
$clave=$ano_fiscal.$mes_fiscal.$nro_comprobante;if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($anulada=='S'){ $etiq_anu="ANULADA";} else { $etiq_anu="";}
?>
<body>
<table width="989" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">COMPROBANTE RETENCI&Oacute;N IVA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="510" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="502" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
	  <tr>      
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Comp_iva()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Inc_Comp_iva()">Incluir</a></div></td>
      </tr>
	  <?php } if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?> 
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Mod_Comp_iva()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Llamar_Mod_Comp_iva();">Modificar</a></div></td>
      </tr>
	  <?php } if ($Mcamino{2}=="S"){?> 
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Mover_Registro('P');">Primero</a></div></td>
      </tr>
  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_comp_iva.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_comp_iva.php" class="menu">Catalogo</a></div></td>
  </tr>
  <?php } if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?> 
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Anular();" class="menu">Anular</a></td>
  </tr>
  <?php } if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?> 
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
  </tr>
 <?php } if ($Mcamino{4}=="S"){?>
  <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
      </tr>
  <?php } ?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="menu.php" class="menu">Menu </a></div></td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:491px; z-index:1; top: 62px; left: 118px;">
        <form name="form1" method="post">
          <table width="856" border="0" >
                <tr>
                  <td height="14"><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
					   <td width="400" height="14">&nbsp;</td>
				       <td width="450"><a class="Estiloanu" ><?php echo $etiq_anu?></a></td>   </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="155"><span class="Estilo5">PERIODO FISCAL A&Ntilde;O  : </span></td>
                      <td width="80"><span class="Estilo5"> <input class="Estilo10" name="txtano_fiscal" type="text" id="txtano_fiscal" size="5" maxlength="5" readonly value="<?php echo $ano_fiscal?>" ></span></td>
                      <td width="45"><span class="Estilo5">MES :</span></td>
                      <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtmes_fiscal" type="text" id="txtmes_fiscal" size="2" maxlength="2"  readonly value="<?php echo $mes_fiscal?>"></span></td>
                      <td width="170"><span class="Estilo5">N&Uacute;MERO COMPROBANTE  :</span></td>
                      <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtnro_comprobante" type="text" id="txtnro_comprobante" size="10" maxlength="10"  readonly value="<?php echo $nro_comprobante?>"></span></td>
                      <td width="120"><span class="Estilo5">FECHA EMISI&Oacute;N  : </span></td>
                      <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="10" maxlength="10"  readonly value="<?php echo $fecha?>"> </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="889" border="0">
                <tr>
                  <td width="883"><table width="861" >
                    <tr>
                      <td width="95" height="24"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                      <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="12" maxlength="12"  value="<?php echo $ced_rif?>" readonly> </span></td>
                      <td width="75"><span class="Estilo5"> NOMBRE :</span></td>
                      <td width="580"><span class="Estilo5">  <input class="Estilo10" name="txtnombre_benef" type="text" id="txtnombre_benef" size="85"  value="<?php echo $nombre_benef?>" readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td> </tr>
              </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_cons_comp_iva.php?criterio=<?php echo $clave?>" width="870" height="370" scrolling="auto" frameborder="1"></iframe>
              </div>
         <table width="863" border="0"> <tr> <td height="10">&nbsp;</td> </tr> </table>
        </form>
<form name="form2" method="post" action="Inc_comp_ret_iva.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcorr_iva_mes" type="hidden" id="txtcorr_iva_mes" value="<?php echo $corr_iva_mes?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?php echo $Fec_Fin_Ejer?>"></td>
  </tr>
</table>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>