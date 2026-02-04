<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000055"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_empleado=''; $p_letra='';  $criterio='';  $cod_empleado='';  $sfecha=''; $clave=''; $sql="SELECT * FROM SUELDO_PRESTA ORDER BY cod_empleado,fecha_sueldo";
} else {$criterio=$_GET["Gcriterio"];$p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$fecha=substr($criterio,1,10); $cod_empleado=substr($criterio,11,15);} else{$fecha=substr($criterio,0,10); $cod_empleado=substr($criterio,10,15);}
  if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
  $sql="Select * FROM SUELDO_PRESTA where (cod_empleado='$cod_empleado') and (fecha_sueldo='$sfecha')"; $clave=$cod_empleado.$sfecha;
  if ($p_letra=="P"){$sql="SELECT * FROM SUELDO_PRESTA Order BY cod_empleado,fecha_sueldo";}
  if ($p_letra=="U"){$sql="SELECT * FROM SUELDO_PRESTA Order by cod_empleado Desc,fecha_sueldo Desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM SUELDO_PRESTA Where (text(cod_empleado)||text(fecha_sueldo)>'$clave') Order by cod_empleado,fecha_sueldo";}
  if ($p_letra=="A"){$sql="SELECT * FROM SUELDO_PRESTA Where (text(cod_empleado)||text(fecha_sueldo)<'$clave') Order by cod_empleado Desc,fecha_sueldo Desc";}
} $criterio=$sfecha.$cod_empleado;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Sueldo de Prestaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
    Gcod_empleado=document.form1.txtfecha_sueldo.value+document.form1.txtcod_empleado.value;murl=url+Gcod_empleado;
    if (Gcod_empleado==""){alert("Codigo Trabajador debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_sueldo_prestaciones_yac.php";
   if(MPos=="P"){murl="Act_sueldo_prestaciones_yac.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_sueldo_prestaciones_yac.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_sueldo_prestaciones_yac.php?Gcriterio=S"+document.form1.txtfecha_sueldo.value+document.form1.txtcod_empleado.value;}
   if(MPos=="A"){murl="Act_sueldo_prestaciones_yac.php?Gcriterio=A"+document.form1.txtfecha_sueldo.value+document.form1.txtcod_empleado.value;}
   document.location=murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar el Sueldo de Prestaciones ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Sueldo de Prestaciones ?");
    if (r==true) { url="Delete_sueldo_presta.php?txtcod_empleado="+document.form1.txtcod_empleado.value+"&txtfecha_sueldo="+document.form1.txtfecha_sueldo.value;  VentanaCentrada(url,'Eliminar Sueldo de Prestaciones','','400','400','true');} }
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
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM SUELDO_PRESTA  Where Order by cod_empleado";}if ($p_letra=="A"){$sql="SELECT * FROM SUELDO_PRESTA  Where Order by cod_empleado desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$nombre="";$cod_empleado=""; $cedula=""; $fecha_ingreso=""; $fecha_sueldo=""; $monto_sueldo=0; $monto_sueldo_adic=0;  $fecha=$fecha_sueldo;
$monto_base=0; $dias_ajuste=0; $monto_ajuste=0; $campo_num1=0; $campo_num2=0; $campo_num3=0; $campo_num4=0; $campo_num5=0; $campo_num6=0; $inf_usuario=""; 
if($filas>=1){  $registro=pg_fetch_array($res,0);  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_sueldo=$registro["fecha_sueldo"]; $fecha=$fecha_sueldo; $fecha_sueldo=formato_ddmmaaaa($fecha_sueldo);
  $monto_sueldo=$registro["monto_sueldo"];    $monto_sueldo_adic=$registro["monto_sueldo_adic"];
  $monto_base=$registro["monto_base"]; $dias_ajuste=$registro["dias_ajuste"]; $monto_ajuste=$registro["monto_ajuste"]; 
  $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $campo_num3=$registro["campo_num3"]; $campo_num4=$registro["campo_num4"]; 
  $campo_num5=$registro["campo_num5"]; $campo_num6=$registro["campo_num6"]; $inf_usuario=$registro["inf_usuario"]; 
} $monto_sueldo=formato_monto($monto_sueldo);  $monto_sueldo_adic=formato_monto($monto_sueldo_adic); $criterio=$fecha.$cod_empleado;
$monto_base=formato_monto($monto_base); $dias_ajuste=formato_monto($dias_ajuste); $monto_ajuste=formato_monto($monto_ajuste);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">SUELDO DE PRESTACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="464" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="463" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
	   <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_sueldo_presta_yac.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_sueldo_presta_yac.php">Incluir</A></td>
      </tr>
	  <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_sueldo_presta_yac.php?Gcriterio=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_sueldo_presta_yac.php?Gcriterio=');">Modificar</A></td>
      </tr>
	   <?} if ($Mcamino{2}=="S"){?>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_sueldo_presta_yac.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_sueldo_presta_yac.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if ($Mcamino{1}=="S"){?>
       <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Carga_sueldo_presta_yac.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Carga_sueldo_presta_yac.php" class="menu">Cargar</a></td>
      </tr>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Carga_sueldo_obreros_yac.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Carga_sueldo_obreros_yac.php" class="menu">Cargar Sueldo Obreros</a></td>
      </tr>
	  <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
      </tr>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:LlamarURL('Eliminar_sueldo_presta_yac.php');" class="menu">Eliminar Lote</a></td>
      </tr>
	  <?}?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
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
                 <td width="720"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="100" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="116"><span class="Estilo5">FECHA SUELDO :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtfecha_sueldo" type="text" id="txtfecha_sueldo" size="10" maxlength="10"  value="<?echo $fecha_sueldo?>" readonly></span></td>
                 <td width="190"><span class="Estilo5">MONTO SUELDO P/ANTIGUEDAD:</span></td>
                 <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_base" type="text" id="txtmonto_base" size="13" maxlength="12"  style="text-align:right" value="<?echo $monto_base?>" readonly></span></td>
                 <td width="170"><span class="Estilo5">DIAS DE AJUSTE:</span></td>
                 <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtdias_ajuste" type="text" id="txtdias_ajuste" size="13" maxlength="12" style="text-align:right" value="<?echo $dias_ajuste?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="876">
               <tr>
                 <td width="116"><span class="Estilo5">MONTO DE AJUSTE:</span></td>
                 <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_ajuste" type="text" id="txtmonto_ajuste" size="13" maxlength="12"  style="text-align:right" value="<?echo $monto_ajuste?>" readonly></span></td>
                 <td width="170"><span class="Estilo5">MONTO SUELDO AJUSTADO :</span></td>
				 <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_sueldo" type="text" id="txtmonto_sueldo" size="13" maxlength="12"  style="text-align:right" value="<?echo $monto_sueldo?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <div id="Layer2" style="position:absolute; width:755px; height:255px; z-index:2; left: 10px; top: 165px;">
           <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 846;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Conceptos Sueldo Antiguedad";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   </script>
           <?include ("../class/class_tab.php");?>
           <script type="text/javascript" language="javascript"> DrawTabs(); </script>
           <!-- PESTAÑA 1 -->
           <div id="T11" class="tab-body">
             <iframe src="Det_concepto_sueldo_pretaciones.php?criterio=<?echo $criterio?>"  width="846" height="200" scrolling="auto" frameborder="0"> </iframe>
           </div>
           
          </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>