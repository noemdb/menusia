<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000065"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_empleado=''; $p_letra='';  $criterio='';  $cod_empleado='';  $sfecha=''; $clave=''; $sql="SELECT * FROM MOV_VACACIONES ORDER BY cod_empleado,fecha_causa_hasta";
} else {$criterio=$_GET["Gcriterio"];$p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$fecha=substr($criterio,1,10); $cod_empleado=substr($criterio,11,15);} else{$fecha=substr($criterio,0,10); $cod_empleado=substr($criterio,10,15);}
  if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
  $sql="Select * FROM MOV_VACACIONES where (cod_empleado='$cod_empleado') and (fecha_causa_hasta='$sfecha')"; $clave=$cod_empleado.$sfecha;
  if ($p_letra=="P"){$sql="SELECT * FROM MOV_VACACIONES Order BY cod_empleado,fecha_causa_hasta";}
  if ($p_letra=="U"){$sql="SELECT * FROM MOV_VACACIONES Order by cod_empleado Desc,fecha_causa_hasta Desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM MOV_VACACIONES Where (text(cod_empleado)||text(fecha_causa_hasta)>'$clave') Order by cod_empleado,fecha_causa_hasta";}
  if ($p_letra=="A"){$sql="SELECT * FROM MOV_VACACIONES Where (text(cod_empleado)||text(fecha_causa_hasta)<'$clave') Order by cod_empleado Desc,fecha_causa_hasta Desc";}
   } $criterio=$sfecha.$cod_empleado;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Saldo de Vacaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css  rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Mover_Registro(MPos){var murl;  murl="Act_saldo_prestaciones.php";
   if(MPos=="P"){murl="Act_sal_vacaciones.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_sal_vacaciones.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_sal_vacaciones.php?Gcriterio=S"+document.form1.txtfecha_causa_hasta.value+document.form1.txtcod_empleado.value;}
   if(MPos=="A"){murl="Act_sal_vacaciones.php?Gcriterio=A"+document.form1.txtfecha_causa_hasta.value+document.form1.txtcod_empleado.value;}
 document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar el Saldo de Vacaciones ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Saldo de Vacaciones ?");
    if (r==true) { url="Delete_saldo_vacaciones.php?txtcod_empleado="+document.form1.txtcod_empleado.value;  VentanaCentrada(url,'Eliminar Saldo de Vacaciones','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
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
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM MOV_VACACIONES  Order by cod_empleado,fecha_causa_hasta";}if ($p_letra=="A"){$sql="SELECT * FROM MOV_VACACIONES  Order by cod_empleado desc,fecha_causa_hasta desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$nombre="";$cod_empleado=""; $cedula=""; $fecha_ingreso=""; $fecha_causa_hasta=""; $fecha_causa_desde=""; $dias_habiles=0; $dias_no_habiles=0; $fecha_d_desde=""; $fecha_d_hasta=""; $fecha_reincorp=""; $dias_bono_vac=0; $monto_bono_vac=0; $dias_disfrutados=0; $inf_usuario="";
if($filas>=1){  $registro=pg_fetch_array($res,0);  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_causa_hasta=$registro["fecha_causa_hasta"]; $fecha_causa_desde=$registro["fecha_causa_desde"]; 
  $dias_habiles=$registro["dias_habiles"]; $dias_no_habiles=$registro["dias_no_habiles"]; $fecha_d_desde=$registro["fecha_d_desde"];  $fecha_d_hasta=$registro["fecha_d_hasta"]; $fecha_reincorp=$registro["fecha_reincorp"]; 
  $dias_bono_vac=$registro["dias_bono_vac"]; $monto_bono_vac=$registro["monto_bono_vac"];
  $fecha_causa_desde=formato_ddmmaaaa($fecha_causa_desde); $fecha_causa_hasta=formato_ddmmaaaa($fecha_causa_hasta);
  $fecha_d_desde=formato_ddmmaaaa($fecha_d_desde); $fecha_d_hasta=formato_ddmmaaaa($fecha_d_hasta); $fecha_reincorp=formato_ddmmaaaa($fecha_reincorp);
} $criterio=$fecha_causa_hasta.$cod_empleado;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">SALDO DE VACACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="374" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="373" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?if ($Mcamino{0}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_saldo_vacaciones.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_saldo_vacaciones.php">Incluir</A></td>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U',<?echo $criterio?>)";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_saldo_vacaciones.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_saldo_vacaciones.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
      </tr>
	  <?} ?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
      </tr>
      <tr><td>&nbsp;</td> </tr>
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
                 <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ingreso" type="text" id="txtfecha_ingreso" size="12" maxlength="10"  value="<?echo $fecha_ingreso?>" readonly></span></td>
                 <td width="40"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
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
           <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">PERIODO DE CAUSACION DESDE : </span></td>
                 <td width="300" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_causa_desde" type="text" id="txtfecha_causa_desde" size="10" maxlength="10" readonly value="<?echo $fecha_causa_desde?>"></span></td>
                 <td width="100" ><span class="Estilo5">HASTA : </span></td>
                 <td width="250" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_causa_hasta" type="text" id="txtfecha_causa_hasta" size="10" maxlength="10"  readonly value="<?echo $fecha_causa_hasta?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="246" ><span class="Estilo5">CANTIDAD DIAS DE VACACIONES HABILES : </span></td>
                 <td width="300" ><span class="Estilo5"><input class="Estilo10" name="txtdias_habiles" type="text" id="txtdias_habiles" size="10" style="text-align:right" maxlength="10" readonly value="<?echo $dias_habiles?>"></span></td>
                 <td width="100" ><span class="Estilo5">NO HABILES : </span></td>
                 <td width="220" ><span class="Estilo5"><input class="Estilo10" name="txtdias_no_habiles" type="text" id="txtdias_no_habiles" size="10" maxlength="10"  style="text-align:right" readonly value="<?echo $dias_no_habiles?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="200" ><span class="Estilo5">FECHA DE DISFRUTE DESDE : </span></td>
                 <td width="120" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_d_desde" type="text" id="txtfecha_d_desde" size="10" maxlength="10" readonly value="<?echo $fecha_d_desde?>"></span></td>
                 <td width="70" ><span class="Estilo5">HASTA : </span></td>
                 <td width="156" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_d_hasta" type="text" id="txtfecha_d_hasta" size="10" maxlength="10"  readonly value="<?echo $fecha_d_hasta?>"></span></td>
                 <td width="180" ><span class="Estilo5">FECHA A REINCORPORASE : </span></td>
                 <td width="140" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_reincorp" type="text" id="txtfecha_reincorp" size="10" maxlength="10" readonly value="<?echo $fecha_reincorp?>"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="246" ><span class="Estilo5">CANTIDAD DIAS BONO VACACIONAL : </span></td>
                 <td width="250" ><span class="Estilo5"><input class="Estilo10" name="txtdias_bono_vac" type="text" id="txtdias_bono_vac" size="10" maxlength="10" style="text-align:right" readonly value="<?echo $dias_bono_vac?>"></span></td>
                 <td width="170" ><span class="Estilo5">MONTO BONO VACACIONAL: </span></td>
                 <td width="200" ><span class="Estilo5"><input class="Estilo10" name="txtmonto_bono_vac" type="text" id="txtmonto_bono_vac" size="17" maxlength="17" style="text-align:right" readonly value="<?echo $monto_bono_vac?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="346" ><span class="Estilo5">CANTIDAD DIAS DE VACACIONES HABILES DISFRUTADOS : </span></td>
                 <td width="520" ><span class="Estilo5"><input class="Estilo10" name="txtdias_disfrutados" type="text" id="txtdias_disfrutados" size="10" maxlength="10" readonly value="<?echo $dias_disfrutados?>"></span></td>
               </tr>
             </table></td>
           </tr>
          </table>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>