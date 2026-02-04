<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $p_letra="";
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{$Nom_Emp=busca_conf();}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="01-0000035"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){ $cod_movimiento=''; $sql="SELECT * FROM DEF_FLUJO_CAJA ORDER BY cod_movimiento";}
else {$cod_movimiento = $_GET["Gcod_movimiento"];$p_letra=substr($cod_movimiento, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_movimiento=substr($cod_movimiento,1,3);} else{$cod_movimiento=substr($cod_movimiento,0,3);}
  $sql="Select * from DEF_FLUJO_CAJA where cod_movimiento='$cod_movimiento' ";
  if ($p_letra=="P"){$sql="SELECT * FROM DEF_FLUJO_CAJA ORDER BY cod_movimiento";}
  if ($p_letra=="U"){$sql="SELECT * From DEF_FLUJO_CAJA Order by cod_movimiento desc";}
  if ($p_letra=="S"){$sql="SELECT * From DEF_FLUJO_CAJA Where (cod_movimiento>'$cod_movimiento') Order by cod_movimiento";}
  if ($p_letra=="A"){$sql="SELECT * From DEF_FLUJO_CAJA Where (cod_movimiento<'$cod_movimiento') Order by cod_movimiento desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Definir Flujo de Caja)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
    Gcod_movimiento=document.form1.txtcod_movimiento.value;murl=url+Gcod_movimiento;
    if (Gcod_movimiento==""){alert("Tipo de Cuenta debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_Flujo_Caja.php";
   if(MPos=="P"){murl="Act_Flujo_Caja.php?Gcod_movimiento=P"}
   if(MPos=="U"){murl="Act_Flujo_Caja.php?Gcod_movimiento=U"}
   if(MPos=="S"){murl="Act_Flujo_Caja.php?Gcod_movimiento=S"+document.form1.txtcod_movimiento.value;}
   if(MPos=="A"){murl="Act_Flujo_Caja.php?Gcod_movimiento=A"+document.form1.txtcod_movimiento.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar la Defincion del Flujo de Cajaa ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Defincion del Flujo de Caja ?");
    if (r==true) { url="Delete_mov_flujo_caja.php?txtcod_movimiento="+document.form1.txtcod_movimiento.value;  VentanaCentrada(url,'Eliminar Defincion del Flujo de Caja','','400','400','true');}}else { url="Cancelado, no elimino"; }
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js"  type="text/javascript"></SCRIPT>
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
$denominacion=""; $denominacion_titulo=""; $linea=""; $descripcion=""; $cod_grupo=""; $operacion=""; $tipo_operacion=""; $activo=""; $modulo=""; $signo=""; $cod_contab=""; $cod_contable=""; $tipo_mov=""; $monto=""; $acumulado=""; $cod_titulo=""; $cargable=""; $inf_usuario="";
$res=pg_query($sql);$filas=pg_num_rows($res); if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From DEF_FLUJO_CAJA ORDER BY cod_movimiento";} if ($p_letra=="A"){$sql="SELECT * From DEF_FLUJO_CAJA ORDER BY cod_movimiento desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $cod_movimiento=$registro["cod_movimiento"]; $linea=$registro["linea"]; $descripcion=$registro["descripcion"];
$cod_grupo=$registro["cod_grupo"]; $operacion=$registro["operacion"]; $tipo_operacion=$registro["tipo_operacion"]; $activo=$registro["activo"]; $modulo=$registro["modulo"]; 
$signo=$registro["signo"]; $cod_contab=$registro["cod_contab"]; $cod_contable=$registro["cod_contable"]; $tipo_mov=$registro["tipo_mov"]; $monto=$registro["monto"]; 
$acumulado=$registro["acumulado"]; $cod_titulo=$registro["cod_titulo"]; $cargable=$registro["cargable"]; $inf_usuario=$registro["inf_usuario"]; $denominacion=$registro["denominacion"]; $denominacion_titulo=$registro["denominacion_titulo"]; }
$monto=formato_monto($monto); $acumulado=formato_monto($acumulado);
?>

<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MOVIMIENTOS FLUJOS DE CAJA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="363" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="357"><table width="92" height="353" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?> 
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Flujo_Caja.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="left"><A class=menu href="Inc_Flujo_Caja.php">Incluir</A></div></td>
      </tr>
	  <?php }if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Mod_Flujo_Caja.php?Gcod_movimiento=<?php  echo $cod_movimiento; ?>')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="left"><A class=menu href="Mod_Flujo_Caja.php?Gcod_movimiento=<?php  echo $cod_movimiento; ?>">Modificar</A></div></td>
      </tr>
	  <?php } if ($Mcamino{2}=="S"){?> 
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="left"><A class=menu href="javascript:Mover_Registro('P');">Primero</A></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          	onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="left"><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
    	      onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="left"><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
        		  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="left"><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_flujo_caja.php')";
        		  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="left"><a href="Cat_act_flujo_caja.php" class="menu">Catalogo</a></div></td>
      </tr>
	  <?php }if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="left"><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></div></td>
      </tr>
	  <?php }?> 
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="left"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>     
	 <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:861px; height:320px; z-index:1; top: 72px; left: 117px;">
         <table width="857" border="0" >
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="140" height="24"><span class="Estilo5">C&Oacute;DIGO MOVIMIENTO :</span></td>
                   <td width="670"><span class="Estilo5"><input class="Estilo10" name="txtcod_movimiento" type="text" class="Estilo5" id="txtcod_movimiento"  value="<?php echo $cod_movimiento?>" size="4" maxlength="3" readonly>  </span></td>
                   <td width="40"><img src="../imagenes/b_info.png" width="11" height="11" onClick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="1001"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                   <td width="750"><span class="Estilo5"><textarea name="txtdescripcion" cols="85" readonly="readonly" class="headers" id="txtdescripcion"><?php echo $descripcion?></textarea>
                   </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="60"><span class="Estilo5">TITULO : </span></td>
                   <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_titulo" type="text" class="Estilo5" id="txtcod_titulo"  value="<?php echo $cod_titulo?>" size="5" maxlength="4" readonly>    </span></td>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                   <td width="630"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion_titulo" type="text" class="Estilo5" id="txtdenominacion_titulo"  value="<?php echo $denominacion_titulo?>" size="120" maxlength="200" readonly>   </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="60"><span class="Estilo5">GRUPO : </span></td>
                   <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_grupo" type="text" class="Estilo5" id="txtcod_grupo"  value="<?php echo $cod_grupo?>" size="5" maxlength="4" readonly> </span></td>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                   <td width="630"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" class="Estilo5" id="txtdenominacion"  value="<?php echo $denominacion?>" size="120" maxlength="200" readonly>  </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="100"><span class="Estilo5">OPERACI&Oacute;N :</span></td>
                   <td width="240"><span class="Estilo5"><input class="Estilo10" name="txtoperacion" type="text" class="Estilo5" id="txtoperacion"  value="<?php echo $operacion?>" size="20" maxlength="20" readonly>   </span></td>
                   <td width="120"><span class="Estilo5">TIPO OPERACI&Oacute;N : </span></td>
                   <td width="230"><span class="Estilo5"> <input class="Estilo10" name="txttipo_operacion" type="text" class="Estilo5" id="txttipo_operacion"  value="<?php echo $tipo_operacion?>" size="20" maxlength="20" readonly>    </span></td>
                   <td width="70"><span class="Estilo5">ACTIVO :</span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtactivo" type="text" class="Estilo5" id="txtactivo"  value="<?php echo $activo?>" size="4" maxlength="2" readonly>   </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
            <td><table width="850">
                 <tr>
                   <td width="170"><span class="Estilo5">M&Oacute;DULO QUE LO GENERA :</span></td>
                   <td width="340"><span class="Estilo5"><input class="Estilo10" name="txtmodulo" type="text" class="Estilo5" id="txtmodulo"  value="<?php echo $modulo?>" size="30" maxlength="29" readonly> </span></td>
                   <td width="180"><span class="Estilo5">SIGNO DE LA OPERACI&Oacute;N :</span></td>
                   <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtsigno" type="text" class="Estilo5" id="txtsigno"  value="<?php echo $signo?>" size="18" maxlength="19" readonly>   </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="150" height="24"><span class="Estilo5">C&Oacute;DIGO OPERACI&Oacute;N :</span></td>
                   <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtcod_contable" type="text" class="Estilo5" id="txtcod_contable"  value="<?php echo $cod_contable?>" size="30" maxlength="30" readonly>    </span></td>
                   <td width="150"><span class="Estilo5">TIPO MOVIMIENTO :</span></td>
                   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txttipo_mov" type="text" class="Estilo5" id="txttipo_mov"  value="<?php echo $tipo_mov?>" size="5" maxlength="5" readonly>   </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="150"><span class="Estilo5">C&Oacute;DIGO CONTABLE :</span></td>
                   <td width="245"><span class="Estilo5"> <input class="Estilo10" name="txtcod_contab" type="text" class="Estilo5" id="txtcod_contab"  value="<?php echo $cod_contab?>" size="30" maxlength="30" readonly>   </span></td>
                   <td width="60"><span class="Estilo5">MONTO : </span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" class="Estilo5" id="txtmonto"  style="text-align:right" value="<?php echo $monto?>" size="20" maxlength="20" readonly>   </span></td>
                   <td width="105"><span class="Estilo5">ACUMUMULADO :</span></td>
                   <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtacumulado" type="text" class="Estilo5" id="txtacumulado" style="text-align:right" value="<?php echo $acumulado?>" size="20" maxlength="20" readonly>   </span></td>
                 </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
       </div>	   
	 </form>     
    </td>
  </tr>
</table>
</body>
</html>
