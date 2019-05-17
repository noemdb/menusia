<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000045"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_empleado=''; $p_letra='';  $criterio='';  $cod_empleado='';  $sfecha=''; $clave=''; $sql="SELECT * FROM pago_int_presta ORDER BY cod_empleado,fecha_pago";
} else {$criterio=$_GET["Gcriterio"];$p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$fecha=substr($criterio,1,10); $cod_empleado=substr($criterio,11,15);} else{$fecha=substr($criterio,0,10); $cod_empleado=substr($criterio,10,15);}
  if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
  $sql="Select * FROM pago_int_presta where (cod_empleado='$cod_empleado') and (fecha_pago='$sfecha')"; $clave=$cod_empleado.$sfecha;
  if ($p_letra=="P"){$sql="SELECT * FROM pago_int_presta Order BY cod_empleado,fecha_pago";}
  if ($p_letra=="U"){$sql="SELECT * FROM pago_int_presta Order by cod_empleado Desc,fecha_pago Desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM pago_int_presta Where (text(cod_empleado)||text(fecha_pago)>'$clave') Order by cod_empleado,fecha_pago";}
  if ($p_letra=="A"){$sql="SELECT * FROM pago_int_presta Where (text(cod_empleado)||text(fecha_pago)<'$clave') Order by cod_empleado Desc,fecha_pago Desc";}
} $criterio=$sfecha.$cod_empleado;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Pago Intereses de Prestaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
    Gcod_empleado=document.form1.txtcod_empleado.value;murl=url+Gcod_empleado;
    if (Gcod_empleado==""){alert("Codigo Trabajador debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_saldo_prestaciones.php";
   if(MPos=="P"){murl="Act_pago_prestaciones.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_pago_prestaciones.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_pago_prestaciones.php?Gcriterio=S"+document.form1.txtfecha_pago.value+document.form1.txtcod_empleado.value;}
   if(MPos=="A"){murl="Act_pago_prestaciones.php?Gcriterio=A"+document.form1.txtfecha_pago.value+document.form1.txtcod_empleado.value;}
   document.location=murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar Pago Intereses de Prestaciones ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Pago Intereses de Prestaciones ?");
    if (r==true) { url="Delete_pago_int_presta.php?txtcod_empleado="+document.form1.txtcod_empleado.value+"&txtfecha_pago="+document.form1.txtfecha_pago.value;  VentanaCentrada(url,'Eliminar Saldo de Prestaciones','','400','400','true');} }
   else {url="Cancelado, no elimino";}
}

</script>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
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
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM pago_int_presta Order by cod_empleado,fecha_pago";}if ($p_letra=="A"){$sql="SELECT * FROM pago_int_presta Order by cod_empleado desc,fecha_pago Desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$nombre="";$cod_empleado=""; $cedula=""; $fecha_ingreso=""; $fecha_pago=""; $total_interes=0;  $monto_pago=0;
if($filas>=1){  $registro=pg_fetch_array($res,0);  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_pago=$registro["fecha_pago"]; $fecha_pago=formato_ddmmaaaa($fecha_pago);
  $total_interes=$registro["total_interes"];    $monto_pago=$registro["monto_pago"];
} $total_interes=formato_monto($total_interes);  $monto_pago=formato_monto($monto_pago);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">PAGO INTERESES DE PRESTACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="364" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="363" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_pago_int_presta.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_pago_int_presta.php">Incluir</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript: Mover_Registro('P')";
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U',<?echo $criterio?>)";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_pago_int_presta.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_pago_int_presta.php" class="menu">Catalogo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
      </tr>
      <tr>  <td>&nbsp;</td> </tr>
    </table></td>
    <td width="879">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post">
          <table width="878" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15"  value="<?echo $cod_empleado?>" readonly></span></td>
                 <td width="100"><span class="Estilo5">C&Eacute;DULA :</span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  value="<?echo $cedula?>" readonly></span></td>
                 <td width="120"><span class="Estilo5">FECHA INGRESO  :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ingreso" type="text" id="txtfecha_ingreso" size="12" maxlength="10"  value="<?echo $fecha_ingreso?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">NOMBRE TRABAJADOR  :</span></td>
                 <td width="730"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="100" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>  <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">FECHA PAGO INTERES :</span></td>
                 <td width="730"><span class="Estilo5"><input class="Estilo10" name="txtfecha_pago" type="text" id="txtfecha_pago" size="10" maxlength="10"  value="<?echo $fecha_pago?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>  <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">TOTAL INTERESES:</span></td>
                 <td width="730"><span class="Estilo5"> <input class="Estilo10" name="txttotal_interes" type="text" id="txttotal_interes" size="13" maxlength="12"  style="text-align:right" value="<?echo $total_interes?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>  <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">MONTO DEL PAGO:</span></td>
                 <td width="730"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_pago" type="text" id="txtmonto_pago" size="13" maxlength="12"  style="text-align:right" value="<?echo $monto_pago?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>

         </table>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>