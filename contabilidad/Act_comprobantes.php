<?php include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo = getenv("COMPUTERNAME"); $mcod_m="CON02".$usuario_sia.$equipo;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="02-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }

if (!$_GET){$p_letra='';  $criterio='';  $referencia='';  $fecha=''; $tipo_comp='';
  $sql="SELECT * FROM COMPROBANTES ORDER BY fecha,referencia,tipo_comp";   $codigo_mov=substr($mcod_m,0,49);
} else {   $codigo_mov="";   $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="C")||($p_letra=="S")||($p_letra=="A")){ $referencia=substr($criterio,11,8); $fecha=substr($criterio,1,10);   $tipo_comp=substr($criterio,19,5);}
   else{$referencia=substr($criterio,10,8);  $fecha=substr($criterio,0,10); $tipo_comp=substr($criterio,18,5); $codigo_mov=substr($mcod_m,0,49); }
  if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}  $clave=$sfecha.$referencia.$tipo_comp;
  $sql="Select * from COMPROBANTES where text(fecha)='$sfecha' and referencia='$referencia' and tipo_comp='$tipo_comp'";
  if ($p_letra=="P"){$sql="SELECT * FROM COMPROBANTES Order by fecha,referencia,tipo_comp";}
  if ($p_letra=="U"){$sql="SELECT * From COMPROBANTES Order by fecha desc,referencia desc,tipo_comp desc";}
  if ($p_letra=="S"){$sql="SELECT * From COMPROBANTES Where (text(fecha)||text(referencia)||text(tipo_comp)>'$clave') Order by fecha,referencia,tipo_comp";}
  if ($p_letra=="A"){$sql="SELECT * From COMPROBANTES Where (text(fecha)||text(referencia)||text(tipo_comp)<'$clave') Order by text(fecha)||text(referencia)||text(tipo_comp) desc";}
  }
if($pdf_rpt=="SI"){$tipo_rpt='PDF';}else{$tipo_rpt='HTML';}
  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD FISCAL (Comprobantes Contables)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_comprob(mop){ if(mop=='C'){ document.form2.submit(); } if(mop=='M'){ document.form3.submit(); }}
function Llamar_Modificar(mmodu){var murl; 
  if(mmodu=="M"){alert("COMPROBANTE, NO PUEDE SER MODIFICADO");}
  else{
  if ((document.form1.txttipo_Comp.value=="00000")||(document.form1.txttipo_asiento.value=="O/P")||(document.form1.txttipo_asiento.value=="ING")){
     murl="Mod_comprobantes.php?txtFecha="+document.form1.txtFecha.value+"&txtReferencia="+document.form1.txtReferencia.value+"&txttipo_Comp="+document.form1.txttipo_Comp.value;
     document.location = murl;}
  else { alert("COMPROBANTE, NO PUEDE SER MODIFICADO"); }}
}
function Mover_Registro(MPos){var murl;
   murl="Act_comprobantes.php";
   if(MPos=="P"){murl="Act_comprobantes.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_comprobantes.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_comprobantes.php?Gcriterio=S"+document.form1.txtFecha.value+document.form1.txtReferencia.value+document.form1.txttipo_Comp.value;}
   if(MPos=="A"){murl="Act_comprobantes.php?Gcriterio=A"+document.form1.txtFecha.value+document.form1.txtReferencia.value+document.form1.txttipo_Comp.value;}
   document.location = murl;
}
function Llama_Eliminar(mmodu){var url;  var r;
  if (document.form1.txttipo_Comp.value=="00000"){r=confirm("Esta seguro en Eliminar el Comprobante ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Comprobante ?");
    if (r==true){ if(mmodu=="M"){url="Delete_comprob_multi.php?txtFecha=";} else{url="Delete_comprobantes.php?txtFecha=";}
	   url=url+document.form1.txtFecha.value+"&txtReferencia="+document.form1.txtReferencia.value+"&txttipo_Comp="+document.form1.txttipo_Comp.value;
       VentanaCentrada(url,'Eliminar Comprobante','','400','400','true');}
    }else { url="Cancelado, no elimino"; }
  }else { alert("COMPROBANTE, NO PUEDE SER ELIMINADO"); }
}
function Llama_Act_Diferido(){var url; var r;
  r=confirm("Desea Actualizar el Comprobante ?");
  if (r==true) { url="Act_Diferido.php?fecha_d="+document.form1.txtFecha.value+"&referencia_d="+document.form1.txtReferencia.value+"&tipo_comp_d="+document.form1.txttipo_Comp.value+"&fecha_h="+document.form1.txtFecha.value+"&referencia_h="+document.form1.txtReferencia.value+"&tipo_comp_h="+document.form1.txttipo_Comp.value;
    VentanaCentrada(url,'Actualizar Diferido','','400','400','true');
  }
}
function Llama_Rpt_Formato(murl){var url; var r; var st;
  r=confirm("Desea Generar el Reporte Formato de Comprobante ?");
  if (r==true) { url=murl+"?fecha_d="+document.form1.txtFecha.value+"&referencia_d="+document.form1.txtReferencia.value+"&tipo_asiento_d="+document.form1.txttipo_asiento.value+"&fecha_h="+document.form1.txtFecha.value+"&referencia_h="+document.form1.txtReferencia.value+"&tipo_asiento_h="+document.form1.txttipo_asiento.value+"&tipo_rep=<?php echo $tipo_rpt ?>";
    window.open(url,"Formato Comrpobante")
  }
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
$res=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
$res=pg_exec($conn,"SELECT ELIMINA_CON017('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
$res=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
$descripcion="";$tipo_asiento=""; $status=""; $ced_rif="";  $nombre=""; $modulo=""; $inf_usuario=""; $nro_expediente=""; $res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * From COMPROBANTES Order by fecha,referencia,tipo_comp";}  if ($p_letra=="S"){$sql="SELECT * From COMPROBANTES Order by fecha desc,referencia desc,tipo_comp desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){ $registro=pg_fetch_array($res); $referencia=$registro["referencia"]; $fecha=$registro["fecha"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $modulo=$registro["modulo"];  $nro_expediente=$registro["nro_expediente"];
  $tipo_comp=$registro["tipo_comp"]; $descripcion=$registro["descripcion"]; $tipo_asiento=$registro["tipo_asiento"]; $status=$registro["status"]; $inf_usuario=$registro["inf_usuario"];}
if($fecha==""){$sfecha="";}else{$fecha=formato_ddmmaaaa($fecha);} if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
$clave=$sfecha.$referencia.$tipo_comp;
$mactualizado=""; if(($status=="A")and($nro_expediente<>"")){ $mactualizado="Actulizado por:".$nro_expediente;}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">COMPROBANTES CONTABLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="528" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="520" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
    <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_comprob('C');"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_comprob('C')">Incluir</A></td>
      </tr>
	
    <?php } if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Modificar('<?php echo $modulo?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Modificar('<?php echo $modulo?>');">Modificar</A></td>
      </tr>
    <?php } if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_comprobantes.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_comprobantes.php" class="menu">Catalogo</a></td>
  </tr>
  <?php } if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar('<?php echo $modulo?>');" class="menu">Eliminar</a></td>
  </tr>
  <?php } if ($Mcamino{3}=="S"){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Rpt_Formato('rpt/Rpt_Formato_Comp.php');" class="menu">Formato</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/contabilidad/ayuda/ayuda_compro_con.htm','Ayuda SIPAP','','900','600','true');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/contabilidad/ayuda/ayuda_compro_con.htm','Ayuda SIPAP','','900','600','true');" class="menu">Ayuda </a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu Principal </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:1098px; height:526px; z-index:1; top: 60px; left: 114px;">
            <form name="form1" method="post">
        <table width="868" border="0">
            <tr>
              <td width="680">&nbsp;</td>
              <?php  if ($status=="D"){ if ($Mcamino{10}=="S"){?>
              <td width="78" align="center" bgcolor="#0033FF"><A href="javascript:Llama_Act_Diferido();" class="Estilo2"><strong>DIFERIDO</strong></A></td>
              <?php } else{?><td width="78" align="center" bgcolor="#0033FF"> <strong>DIFERIDO</strong></A></td> <?php } }?>
            </tr>
            <tr>
              <td colspan="3"><table width="853" border="0">
                <tr>
                  <td width="276"><span class="Estilo5">FECHA : <input name="txtFecha" type="text" id="txtFecha" value="<?php echo $fecha?>" size="12" readonly></span></td>
                  <td width="314"><span class="Estilo5">REFERENCIA :</span> <input name="txtReferencia" type="text"  id="txtReferencia" value="<?php echo $referencia?>" size="12" readonly> </td>
                  <td width="204"><span class="Estilo5">TIPO ASIENTO:</span> <input name="txttipo_asiento" id="txttipo_asiento" value="<?php echo $tipo_asiento?>" size="4" readonly></td>
				  <td width="20"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?php echo $inf_usuario?>, \n <?php echo $mactualizado?>');"></td>
                 <?php  if ($tipo_asiento=="O/P"){ ?> <td width="20"><img src="../imagenes/s_tbl.png" width="16" height="16" title="Mostrar Cheques de la Orden" onclick="javascript:Ventana_002('../pagos/Cons_pago_ord.php?clave=<?php echo $referencia?>','SIPAP','','650','300','true');"></td>  <?php }?>
                </tr>
              </table></td>
            </tr>
            <tr>
                  <td colspan="3"><table width="851" border="0">
                    <tr>
                      <td width="160"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                      <td width="110"><span class="Estilo5">
                        <input name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="12"  value="<?php echo $ced_rif?>" readonly>
                      </span></td>
                      <td width="580"><span class="Estilo5">
                        <input name="txtnombre" type="text" id="txtnombre" value="<?php echo $nombre?>" size="80" readonly>
                      </span></td>
                    </tr>
                  </table></td>
            </tr>
            <tr>
              <td colspan="3"><table width="857" border="0">
                <tr>
                  <td width="150"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                  <td width="647"><textarea name="txtDescripcion" cols="80" readonly="readonly" class="headers" id="txtDescripcion"><?php echo $descripcion?></textarea></td>
                  <td width="29"><input name="txttipo_Comp" type="hidden" id="txttipo_Comp" value="<?php echo $tipo_comp?>"></td>
                </tr>
              </table>                </td>
            </tr>
            <tr>
              <td height="14" colspan="3">&nbsp;</td>
            </tr>
        </table>
        <iframe src="Det_cons_comprobantes.php?criterio=<?php echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        </form>
      </div>
    </td>
</tr>
<form name="form2" method="post" action="Inc_comprobantes.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value="<?php echo $Rif_Emp?>"></td>
     <td width="5"><input name="txtnomb" type="hidden" id="txtnomb" value="<?php echo $Nom_Emp?>"></td>
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?php echo $Fec_Fin_Ejer?>"></td>
  </tr>
</table>
</form>
<form name="form3" method="post" action="Inc_comprob_multiple.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser2" type="hidden" id="txtuser2" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword2" type="hidden" id="txtpassword2" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname2" type="hidden" id="txtdbname2" value="<?php echo $dbname?>" ></td>
     <td width="5"><input name="txtcodigo_mov2" type="hidden" id="txtcodigo_mov2" value="<?php echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtced_r2" type="hidden" id="txtced_r2" value="<?php echo $Rif_Emp?>"></td>
     <td width="5"><input name="txtnomb2" type="hidden" id="txtnomb2" value="<?php echo $Nom_Emp?>"></td>
	  <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?php echo $Fec_Fin_Ejer?>"></td>
  </tr>
</table>
</form>
</table>
</body>
</html>
<?php  pg_close($conn);?>