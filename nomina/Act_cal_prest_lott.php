<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); $fecha_tope="30/04/2012"; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000040"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_empleado=''; $p_letra='';$sql="SELECT * FROM CAL_PRESTA ORDER BY cod_empleado";
} else {$codigo=$_GET["Gcodigo"];$p_letra=substr($codigo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_empleado=substr($codigo,1,15);} else{$cod_empleado=substr($codigo,0,15);}
  $sql="Select * FROM CAL_PRESTA where (cod_empleado='$cod_empleado')"; $clave=$cod_empleado;
  if ($p_letra=="P"){$sql="SELECT * FROM CAL_PRESTA Order BY cod_empleado";}
  if ($p_letra=="U"){$sql="SELECT * FROM CAL_PRESTA Order by cod_empleado Desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM CAL_PRESTA Where (cod_empleado>'$clave') Order by cod_empleado";}
  if ($p_letra=="A"){$sql="SELECT * FROM CAL_PRESTA Where (cod_empleado<'$clave') Order by cod_empleado Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL N&Oacute;MINA Y PERSONAL (Actualiza Calculo de Prestaciones LOTT)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" type="text/Javascript">
function Mover_Registro(MPos){var murl;
   murl="Act_cal_prest_lott.php";
   if(MPos=="P"){murl="Act_cal_prest_lott.php?Gcodigo=P"}
   if(MPos=="U"){murl="Act_cal_prest_lott.php?Gcodigo=U"}
   if(MPos=="S"){murl="Act_cal_prest_lott.php?Gcodigo=S"+document.form1.txtcod_empleado.value;}
   if(MPos=="A"){murl="Act_cal_prest_lott.php?Gcodigo=A"+document.form1.txtcod_empleado.value;}
   document.location = murl;
}
</script>
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
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
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM CAL_PRESTA Where Order by cod_empleado";}if ($p_letra=="A"){$sql="SELECT * FROM CAL_PRESTA Where  Order by cod_empleado desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$nombre="";$cod_empleado=""; $cedula=""; $fecha_ingreso=""; $fecha_calculo=""; $sueldo_calculo=0;  $dias_prestaciones=0;  $sueldo_calculo_adic=0;  $dias_adicionales=0; $total_prestaciones=0;  $total_adelanto=0; $acumulado_total=0; $total_interes=0; $saldo_prestaciones668=0; $total_interes668=0;
if($filas>=1){  $registro=pg_fetch_array($res,0);  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_calculo=$registro["fecha_calculo"]; $fecha=$fecha_calculo; $fecha_calculo=formato_ddmmaaaa($fecha_calculo); $sueldo_calculo=$registro["sueldo_calculo"];  $dias_prestaciones=$registro["dias_prestaciones"];
  $sueldo_calculo_adic=$registro["sueldo_calculo_adic"];  $dias_adicionales=$registro["dias_adicionales"]; $total_prestaciones=$registro["total_prestaciones"];  $total_adelanto=$registro["total_adelanto"];
  $acumulado_total=$registro["acumulado_total"]; $total_interes=$registro["total_interes"];
} $criterio=$cod_empleado;
?>
<body>
 <body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CALCULO DE PRESTACIONES LOTT ART. 142</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="376" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="373" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
	  <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_cal_presta_lott.php?Gcriterio=<?echo $cod_empleado?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_cal_presta_lott.php?Gcriterio=<?echo $cod_empleado?>">Incluir</A></td>
      </tr>
      <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Inc_cal_pres_lote_lott.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="31"  bgcolor=#EAEAEA><a class=menu href="Inc_cal_pres_lote_lott.php">Incluir Lote </a></td>
     </tr>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_cal_presta_lott.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_cal_presta_lott.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Elim_cal_pres_lott.php?Gcriterio=<?echo $cod_empleado?>" class="menu">Eliminar</a></td>
      </tr>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Elim_cal_pres_lote_lott.php?Gcriterio=<?echo $cod_empleado?>" class="menu">Eliminar Lote</a></td>
      </tr>
	  <?} if ($Mcamino{4}=="S"){?>
	   <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Criterio_cont_ind_prest.php?Gcriterio=<?echo $cod_empleado?>" class="menu">Reportes</a></td>
      </tr>
	  <?} ?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>

             <td><table width="866">
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
             <td><table width="866">
               <tr>
                 <td width="146"><span class="Estilo5">NOMBRE TRABAJADOR  :</span></td>
                 <td width="720"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="100" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <iframe src="Det_calculo_prest_lott.php?criterio=<?echo $criterio?>"  width="850" height="270" scrolling="auto" frameborder="1">
        </iframe>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>