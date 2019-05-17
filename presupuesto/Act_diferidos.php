<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="02-0000003"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo = getenv("COMPUTERNAME"); $mcod_m="PRE023".$usuario_sia.$equipo;  $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){ $p_letra=''; $criterio='';   $referencia_dife=''; $tipo_diferido='';  $sql="SELECT * FROM DIFERIDOS ORDER BY tipo_diferido,referencia_dife";  $codigo_mov=substr($mcod_m,0,49);
} else { $codigo_mov=""; $criterio = $_GET["Gcriterio"];$p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$referencia_dife=substr($criterio,5,8);  $tipo_diferido=substr($criterio,1,4);}  else{$referencia_dife=substr($criterio,4,8); $tipo_diferido=substr($criterio,0,4);$codigo_mov=substr($mcod_m,0,49); }
  $clave=$tipo_diferido.$referencia_dife;  $sql="Select * from DIFERIDOS where tipo_diferido='$tipo_diferido' and referencia_dife='$referencia_dife'";
  if ($p_letra=="P"){$sql="SELECT * FROM DIFERIDOS Order by tipo_diferido,referencia_dife";}
  if ($p_letra=="U"){$sql="SELECT * From DIFERIDOS Order by tipo_diferido desc,referencia_dife desc";}
  if ($p_letra=="S"){$sql="SELECT * From DIFERIDOS Where (text(tipo_diferido)||text(referencia_dife)>'$clave') Order by tipo_diferido,referencia_dife";}
  if ($p_letra=="A"){$sql="SELECT * From DIFERIDOS Where (text(tipo_diferido)||text(referencia_dife)<'$clave') Order by text(tipo_diferido)||text(referencia_dife) desc";}
  }
$fecha_f=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_f)){$fecha_hoy=$fecha_f;}else{$fecha_f=$fecha_hoy;} $clave=$tipo_diferido.$referencia_dife;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Diferidos Presupuestario)</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Modificar(){var murl;
var Gtipo_diferido=document.form1.txttipo_diferido.value
  if ((Gtipo_diferido=="0001")||(Gtipo_diferido.charAt(0)=="A")||(Gtipo_diferido=="")) { alert("MOVIMIENTO, NO PUEDE SER MODIFICADO"); }
   else{ murl="Mod_diferidos.php?txttipo_diferido="+document.form1.txttipo_diferido.value+"&txtreferencia_dife="+document.form1.txtreferencia_dife.value;
     document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_diferidos.php";
   if(MPos=="P"){murl="Act_diferidos.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_diferidos.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_diferidos.php?Gcriterio=S"+document.form1.txttipo_diferido.value+document.form1.txtreferencia_dife.value;}
   if(MPos=="A"){murl="Act_diferidos.php?Gcriterio=A"+document.form1.txttipo_diferido.value+document.form1.txtreferencia_dife.value;}
   document.location = murl;
}
function Llamar_Inc_comp(mop){ document.form2.submit();} 
function Llama_Eliminar(manu){var url; var r;
var Gtipo_diferido=document.form1.txttipo_diferido.value;
  if ((Gtipo_diferido=="0001")||(Gtipo_diferido.charAt(0)=="A")||(Gtipo_diferido=="")) { alert("MOVIMIENTO, NO PUEDE SER ELIMINADO"); }
  else{  if(manu=="S"){url="Diferido Esta ANULADO, ";alert(url);}else{url="";} 
    r=confirm("Esta seguro en Eliminar el Diferido Presupuestario ?");
    if (r==true) {  r=confirm("Esta Realmente seguro en Eliminar el Diferido Presupuestario ?");
      if (r==true) {  url="Delete_diferidos.php?txttipo_diferido="+document.form1.txttipo_diferido.value+"&txtreferencia_dife="+document.form1.txtreferencia_dife.value;
         VentanaCentrada(url,'Eliminar Diferido','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
  }
}
function Llama_Liberar(manu){var url; var r;
var Gtipo_diferido=document.form1.txttipo_diferido.value;
  if ((Gtipo_diferido=="0001")||(Gtipo_diferido.charAt(0)=="A")||(Gtipo_diferido=="")) { alert("MOVIMIENTO, NO PUEDE SER ELIMINADO"); }
  else{  if(manu=="S"){url="Diferido Esta ANULADO, ";alert(url);}else{url="";} 
    r=confirm("Esta seguro en Liberar el Diferido Presupuestario ?");
    if (r==true) {  r=confirm("Esta Realmente seguro en Liberar el Diferido Presupuestario ?");
      if (r==true) {  url="Libera_diferidos.php?txttipo_diferido="+document.form1.txttipo_diferido.value+"&txtreferencia_dife="+document.form1.txtreferencia_dife.value;
         VentanaCentrada(url,'Liberar Diferido','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
  }
}
function Llama_Anular(manu){var url; var r;
var Gtipo_diferido=document.form1.txttipo_diferido.value;
  if ((Gtipo_diferido=="0001")||(Gtipo_diferido.charAt(0)=="A")||(Gtipo_diferido=="")||(manu=="S")) { alert("MOVIMIENTO, NO PUEDE SER ANULADO"); }
  else{url="Anula_diferidos.php?txttipo_diferido="+document.form1.txttipo_diferido.value+"&txtreferencia_dife="+document.form1.txtreferencia_dife.value;
    VentanaCentrada(url,'Anular Diferido','','800','380','true');}
}
function Llama_Copiar(){var url;
 url="Copia_diferido.php?txttipo_diferido="+document.form1.txttipo_diferido.value+"&txtreferencia_dife="+document.form1.txtreferencia_dife.value;
 VentanaCentrada(url,'Copiar Diferido','','400','400','true');
}
</script>
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
function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Formato Registro Diferido ?");
   if (r==true) {url="/sia/presupuesto/rpt/Rpt_reg_diferido.php?txttipo_diferido="+document.form1.txttipo_diferido.value+"&txtreferencia_dife="+document.form1.txtreferencia_dife.value;
    window.open(url);
  }
}
</script>
</head>
<?
if ($codigo_mov==""){$codigo_mov="";}else{$res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } }
$descripcion="";$fecha="";$nombre_abrev_dife="";$inf_usuario=""; $anulado=""; $fecha_anu="";  $status_2=""; $res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM DIFERIDOS Order by tipo_diferido,referencia_dife";}  if ($p_letra=="A"){$sql="SELECT * From DIFERIDOS Order by tipo_diferido desc,referencia_dife desc";}  $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){$registro=pg_fetch_array($res);
  $referencia_dife=$registro["referencia_dife"];$fecha=$registro["fecha_diferido"];  $tipo_diferido=$registro["tipo_diferido"]; $descripcion=$registro["descripcion_dife"];
  $inf_usuario=$registro["inf_usuario"]; $nombre_abrev_dife=$registro["nombre_abrev_dife"];  $anulado=$registro["anulado"]; $fecha_anu=$registro["fecha_anu"]; $modulo=$registro["modulo"]; $status_2=$registro["status_2"];
}
if($fecha==""){$sfecha="";}else{$fecha=formato_ddmmaaaa($fecha);}$clave=$tipo_diferido.$referencia_dife;if($fecha_anu==""){$fecha_anu="";}else{$fecha_anu=formato_ddmmaaaa($fecha_anu);}
$mconf="";$Ssql="Select * from SIA005 where campo501='05'";$resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"];}$nro_aut=substr($mconf,1,1); $fecha_aut=substr($mconf,2,1); $aprueba_comp=substr($mconf,15,1);
$nomb_a_dif="";  $ref_dife=''; $tipo_dif='';
$sSQL="Select * from pre024 WHERE tipo_diferido>'0001' order by tipo_diferido";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
if ($filas>0){$registro=pg_fetch_array($resultado);  $tipo_dif=$registro["tipo_diferido"]; $nomb_a_dif=$registro["nombre_abrev_dife"]; }
$msta=""; $inf_sta=""; if($status_2=='L'){$msta="LIBERADO"; }  if($anulado=='S'){$msta="ANULADO"; $inf_sta="ANULADO CON FECHA:".$fecha_anu; }
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DIFERIDOS PRESUPUESTARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="507" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="502" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
	  <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
        <tr>		
				<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_comp(1)";
				  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_comp()">Incluir</A></td>
        </tr>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Liberar('<?echo $anulado?>');" class="menu">Liberar</a></td>
        </tr>
	 <!-- 
	 <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>	
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Modificar()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Modificar();">Modificar</A></td>
      </tr>
	  -->
	  <?} if ($Mcamino{2}=="S"){?>
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
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_diferidos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_diferidos.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?>	
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Anular('<?echo $anulado?>');" class="menu">Anular</a></td>
        </tr>
	 <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>	
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar('<?echo $anulado?>');" class="menu">Eliminar</a></td>
      </tr>
	  <?} if ($Mcamino{4}=="S"){?>
      <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
      </tr>
	  <? } if ($Mcamino{2}=="S"){?>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Copiar();" class="menu">Copiar</a></td>
        </tr>
        <? } ?>	
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
      </tr>
      <tr><td>&nbsp;</td></tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:495px; z-index:1; top: 60px; left: 114px;">
            <form name="form1" method="post">
                <table width="867" >
              <tr>
                <td>
                  <table width="830" align="center">
                    <tr> <td>&nbsp;</td> </tr>
                    <tr>
                      <td><table width="813" border="0">
                        <tr>
                          <td width="103"><p><span class="Estilo5">TIPO DIFERIDO:</span></p>                          </td>
                          <td width="58"><input name="txttipo_diferido" type="text"  id="txttipo_diferido" value="<?echo $tipo_diferido?>" size="6" readonly  ></td>
                          <td width="60"><span class="Estilo5"> <input name="txtnombre_abrev_dife" type="text" id="txtnombre_abrev_dife" value="<?echo $nombre_abrev_dife?>" size="6" readonly>  </span></td>
                          <td width="36">&nbsp;</td>
                          <td width="98"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="126"><input name="txtreferencia_dife" type="text"  id="txtreferencia_dife" value="<?echo $referencia_dife?>" size="12" readonly  ></td>
                          <? if($anulado=='S'){?> <td width="90"><span class="Estilo15">ANULADO</span></td>
                          <? } else{ ?><td width="90"><a class="Estilo11" href="javascript:alert('<?echo $inf_sta?>');"><? echo $msta ?></a></td>  <? }?>                                                   
						  <td width="68"><span class="Estilo5">FECHA :</span> </td>
                          <td width="94"><span class="Estilo5"> <input name="txtFecha" type="text" id="txtFecha" value="<?echo $fecha?>" size="12" readonly  ></span></td>
                          <td width="42"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtDescripcion" cols="85" readonly="readonly" class="headers" id="textarea"><?echo $descripcion?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>  </td>
              </tr>
            </table>
        <iframe src="Det_cons_diferidos.php?criterio=<?echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        </form>		
<form name="form2" method="post" action="Inc_diferidos.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>	 
	 <td width="5"><input name="txttipo_dif" type="hidden" id="txttipo_dif" value="<?echo $tipo_dif?>"></td>
	 <td width="5"><input name="txtabrev_dif" type="hidden" id="txtabrev_dif" value="<?echo $nomb_a_dif?>"></td>
     <td width="5"><input name="txtref_dif" type="hidden" id="txtref_dif" value="<?echo $ref_dife?>"></td>
	 <td width="5"><input name="txtfechad" type="hidden" id="txtfechad" value="<?echo $fecha_f?>"></td>	 
	 <td width="5"><input name="txtfecha_ini" type="hidden" id="txtfecha_ini" value="<?echo $fecha_hoy?>" ></td>
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtconcepto_r" type="hidden" id="txtconcepto_r" value=""></td> 
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