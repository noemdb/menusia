<? include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo = getenv("COMPUTERNAME"); $mcod_m="BAN012M".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000060"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$criterio='';$p_letra='';$sql="SELECT * FROM PLANILLAS_RET Order by tipo_planilla,nro_planilla";
} else{ $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $nro_planilla=substr($criterio,3,8);  $tipo_planilla=substr($criterio,1,2);}
   else{  $nro_planilla=substr($criterio,2,8);  $tipo_planilla=substr($criterio,0,2);  }
  $codigo_mov=substr($mcod_m,0,49);   $clave=$tipo_planilla.$nro_planilla;
  $sql="Select * from PLANILLAS_RET where tipo_planilla='$tipo_planilla' and  nro_planilla='$nro_planilla'";
  if ($p_letra=="P"){$sql="SELECT * FROM PLANILLAS_RET Order by tipo_planilla,nro_planilla";}
  if ($p_letra=="U"){$sql="SELECT * FROM PLANILLAS_RET Order by text(tipo_planilla)||text(nro_planilla) desc";}
  if ($p_letra=="S"){$sql="SELECT * From PLANILLAS_RET Where (text(tipo_planilla)||text(nro_planilla)>'$clave') Order by tipo_planilla,nro_planilla";}
  if ($p_letra=="A"){$sql="SELECT * From PLANILLAS_RET Where (text(tipo_planilla)||text(nro_planilla)<'$clave') Order by text(tipo_planilla)||text(nro_planilla) desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO  (Planillas de Retencion)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">

function Mover_Registro(MPos){var murl;
   murl="Act_planillas_ret.php"; 
   if(MPos=="P"){murl="Act_planillas_ret.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_planillas_ret.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_planillas_ret.php?Gcriterio=S"+document.form1.txttipo_planilla.value+document.form1.txtnro_planilla.value;}
   if(MPos=="A"){murl="Act_planillas_ret.php?Gcriterio=A"+document.form1.txttipo_planilla.value+document.form1.txtnro_planilla.value;}
   document.location = murl;
}

function Llamar_Inc_planillas_ret(){ document.form2.submit(); }


function Llama_Eliminar(){var url;var r; var Gtipo_mov=document.form1.txttipo_mov.value;
var Gcod_banco=document.form1.txtcod_banco.value;var Greferencia=document.form1.txtreferencia.value;
  if ((Gcod_banco=="0000")&&(Gtipo_mov=="000")&&(Greferencia=="00000000"))  {
    r=confirm("Esta seguro en Eliminar la Planilla de Retencion ?");
    if (r==true) { r=confirm("Esta Realmente seguro en Eliminar la Planilla de Retencion ?");
      if (r==true) {  url="Delete_planilla_ret_man.php?orden="+document.form1.txtnro_orden.value+"&tipo_planilla="+document.form1.txttipo_planilla.value+"&nro_planilla="+document.form1.txtnro_planilla.value;
         VentanaCentrada(url,'Eliminar Planilla de Retencion','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
  }else{ alert("PLANILLA, NO PUEDE SER ELIMINADA"); }
}

function Llama_Anular(){var url;var r; var Gtipo_mov=document.form1.txttipo_mov.value;
var Gcod_banco=document.form1.txtcod_banco.value;var Greferencia=document.form1.txtreferencia.value;
  if ((Gcod_banco=="0000")&&(Gtipo_mov=="000")&&(Greferencia=="00000000"))  {
    r=confirm("Esta seguro en Anular la Planilla de Retencion ?");
    if (r==true) { r=confirm("Esta Realmente seguro en Anular la Planilla de Retencion ?");
      if (r==true) {  url="Anula_planilla_ret_man.php?orden="+document.form1.txtnro_orden.value+"&tipo_planilla="+document.form1.txttipo_planilla.value+"&nro_planilla="+document.form1.txtnro_planilla.value;
         VentanaCentrada(url,'Anular Planilla de Retencion','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
  }else{ alert("PLANILLA, NO PUEDE SER ANULADA"); }
}

function Llamar_Formato(mformato){var url;var r; 
   r=confirm("Desea Generar la Planilla ?");
   if (r==true) { url="/sia/pagos/rpt/"+mformato+"?orden="+document.form1.txtnro_orden.value+'&tipo='+document.form1.txttipo_planilla.value; window.open(url);
  }
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
<?
if($codigo_mov==""){$codigo_mov="";}else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG029(4,'$codigo_mov','','','','','2007-01-01',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','')");$error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } }
$fecha=""; $ced_rif=""; $nombre_benef=""; $tipo_planilla="";  $nro_planilla=""; $descripcion=""; $tipo_mov=""; $cod_banco=""; $referencia=""; 
$formato_planilla=""; $orden=""; $anulada=""; $res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){ if ($p_letra=="A"){$sql="SELECT * FROM PLANILLAS_RET Order by tipo_planilla,nro_planilla";}  if ($p_letra=="S"){$sql="SELECT * FROM PLANILLAS_RET Order by text(tipo_planilla)||text(nro_planilla) desc";}  $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){  $registro=pg_fetch_array($res);
  $nro_planilla=$registro["nro_planilla"]; $tipo_planilla=$registro["tipo_planilla"];   $fecha=$registro["fecha_emision"];  $ced_rif=$registro["ced_rif"];
  $nombre_benef=$registro["nombre"];  $tipo_mov=$registro["tipo_mov"];  $cod_banco=$registro["cod_banco"]; $referencia=$registro["referencia"]; $anulada=$registro["anulada"];
  $descripcion=$registro["descripcion"]; $formato_planilla=$registro["formato_planilla"];  $orden=$registro["nro_orden"]; $inf_usuario=$registro["inf_usuario"];
} 
$clave=$tipo_planilla.$nro_planilla.$tipo_mov.$cod_banco.$referencia; if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($anulada=='S'){ $etiq_anu="ANULADA";} else { $etiq_anu="";}
?>
<body>
<table width="989" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">PLANILLAS DE RETENCI&Oacute;N</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="510" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="502" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
	  <tr>      
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_planillas_ret()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Inc_planillas_ret()">Incluir</a></div></td>
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
	  <tr>
		<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
	  </tr>
	  <tr>
		<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
	  </tr>
	  <tr>
		<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_planillas_ret.php')";
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_planillas_ret.php" class="menu">Catalogo</a></div></td>
	  </tr>
	  <?} if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?> 
	  <tr>
		<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Anular();" class="menu">Anular</a></td>
	  </tr>
	  <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?> 
	  <tr>
		<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
	  </tr>
	 <?} if ($Mcamino{4}=="S"){?>
	    <tr>
			  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato('<? echo $formato_planilla; ?>');" class="menu">Formato</a></td>
	    </tr>
	  <?} ?>
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
				       <td width="450"><a class="Estiloanu" ><?echo $etiq_anu?></a></td>   </tr>
                  </table></td>
                </tr>
				
                <tr>
                  <td height="14"><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
					  <td width="100"><span class="Estilo5">TIPO PLANILLA: </span></td>
					  <td width="60"><span class="Estilo5"><input class="Estilo10" name="txttipo_planilla" type="text" id="txttipo_planilla" size="3" maxlength="2"  readonly  value="<?echo $tipo_planilla?>"></span></td>
                      <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtdes_planilla" type="text" id="txtdes_planilla" size="40" maxlength="100"  readonly value="<?echo $descripcion?>"> </span></td>
                      <td width="120"><span class="Estilo5">N&Uacute;MERO PLANILLA  :</span></td>
                      <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtnro_planilla" type="text" id="txtnro_planilla" size="9" maxlength="8"  readonly value="<?echo $nro_planilla?>"></span></td>
                      <td width="120"><span class="Estilo5">FECHA EMISI&Oacute;N  : </span></td>
                      <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="10" maxlength="10"  readonly value="<?echo $fecha?>"> </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="889" border="0">
                <tr>
                  <td width="883"><table width="861" >
                    <tr>
                      <td width="95" height="24"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                      <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="12" maxlength="12"  value="<?echo $ced_rif?>" readonly> </span></td>
                      <td width="70"><span class="Estilo5"> NOMBRE :</span></td>
                      <td width="580"><span class="Estilo5">  <input class="Estilo10" name="txtnombre_benef" type="text" id="txtnombre_benef" size="85"  value="<?echo $nombre_benef?>" readonly>  </span></td>
                      <td width="5"><input class="Estilo10" name="txtnro_orden" type="hidden" id="txtnro_orden" value="<?echo $orden?>" ></td>
	                  <td width="5"><input class="Estilo10" name="txttipo_mov" type="hidden" id="txttipo_mov" value="<?echo $tipo_mov?>" ></td>
                      <td width="5"><input class="Estilo10" name="txtcod_banco" type="hidden" id="txtcod_banco" value="<?echo $cod_banco?>" ></td>
                      <td width="5"><input class="Estilo10" name="txtreferencia" type="hidden" id="txtreferencia" value="<?echo $referencia?>" ></td>	
					</tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td> </tr>
              </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_cons_planillas_ret.php?criterio=<?echo $clave?>" width="870" height="370" scrolling="auto" frameborder="1"></iframe>
              </div>
         <table width="863" border="0"> <tr> <td height="10">&nbsp;</td> </tr> </table>
        </form>
<form name="form2" method="post" action="Inc_planilla_ret.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
  </tr>
</table>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>