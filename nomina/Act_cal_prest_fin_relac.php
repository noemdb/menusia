<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000050"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_empleado=''; $p_letra='';  $criterio='';  $cod_empleado='';  $clave=''; $sql="SELECT * FROM CAL_PRESTA_FIN  ORDER BY cod_empleado";
} else {$criterio=$_GET["Gcriterio"];$p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_empleado=substr($criterio,1,15);} else{ $cod_empleado=substr($criterio,0,15);}
  
  $sql="Select * FROM CAL_PRESTA_FIN  where (cod_empleado='$cod_empleado') "; $clave=$cod_empleado;
  if ($p_letra=="P"){$sql="SELECT * FROM CAL_PRESTA_FIN  Order BY cod_empleado";}
  if ($p_letra=="U"){$sql="SELECT * FROM CAL_PRESTA_FIN  Order by cod_empleado Desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM CAL_PRESTA_FIN  Where (cod_empleado>'$clave') Order by cod_empleado,fecha_cal_fin";}
  if ($p_letra=="A"){$sql="SELECT * FROM CAL_PRESTA_FIN  Where (cod_empleado<'$clave') Order by cod_empleado Desc,fecha_cal_fin Desc";}
} $criterio=$cod_empleado;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL  (Calculo Prestaciones Fin Relacion Laboral - Art. 142 Literal C)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Calculo(mop){  document.form2.submit(); }
function Llamar_Ventana(url){var murl;
    Gcod_empleado=document.form1.txtcod_empleado.value;murl=url+Gcod_empleado;
    if (Gcod_empleado==""){alert("Codigo Trabajador debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_cal_prest_fin_relac.php";
   if(MPos=="P"){murl="Act_cal_prest_fin_relac.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_cal_prest_fin_relac.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_cal_prest_fin_relac.php?Gcriterio=S"+document.form1.txtcod_empleado.value;}
   if(MPos=="A"){murl="Act_cal_prest_fin_relac.php?Gcriterio=A"+document.form1.txtcod_empleado.value;}
   document.location=murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar Calculo de Prestaciones ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Calculo de Prestaciones ?");
    if (r==true) { url="Delete_cal_prest_fin_relac.php?txtcod_empleado="+document.form1.txtcod_empleado.value+"&txtfecha_cal_fin="+document.form1.txtfecha_cal_fin.value;  VentanaCentrada(url,'Eliminar Saldo de Prestaciones','','400','400','true');} }
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
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM CAL_PRESTA_FIN Order by cod_empleado";}if ($p_letra=="A"){$sql="SELECT * FROM CAL_PRESTA_FIN  Order by cod_empleado desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$nombre="";$cod_empleado=""; $cedula=""; $fecha_ingreso=""; $fecha_cal_fin=""; 
$ant_ano="";$ant_mes="";$ant_dia="";$cod_sue_int="";$monto_sue_int=0;$sueldo_basico=0;$tiempo_servicio=0;$monto_garantia=0;$monto_art142=0;$fecha_cal_garantia="";$status="";$campo_str1="";$campo_str2="";$campo_num1="";$campo_num2="";$inf_usuario="";
if($filas>=1){  $registro=pg_fetch_array($res,0);  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_cal_fin=$registro["fecha_cal_fin"]; $fecha_cal_fin=formato_ddmmaaaa($fecha_cal_fin);  
  $ant_ano=$registro["ant_ano"]; $ant_mes=$registro["ant_mes"]; $ant_dia=$registro["ant_dia"]; $cod_sue_int=$registro["cod_sue_int"];
  $monto_sue_int=$registro["monto_sue_int"]; $sueldo_basico=$registro["sueldo_basico"]; $tiempo_servicio=$registro["tiempo_servicio"];
  $monto_garantia=$registro["monto_garantia"]; $monto_art142=$registro["monto_art142"]; $fecha_cal_garantia=$registro["fecha_cal_garantia"]; $fecha_cal_garantia=formato_ddmmaaaa($fecha_cal_garantia);  
  $status=$registro["status"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"]; $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $inf_usuario=$registro["inf_usuario"];  
} $monto_sue_int=formato_monto($monto_sue_int);  $sueldo_basico=formato_monto($sueldo_basico);  $monto_garantia=formato_monto($monto_garantia);   $monto_art142=formato_monto($monto_art142);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CALCULO PRESTACIONES FIN RELACION LABORAL ART. 142 LITERAL C </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="364" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="363" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Calculo('I')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Calculo('I')">Incluir</A></td>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_cal_prest_fin_relac.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_cal_prest_fin_relac.php" class="menu">Catalogo</a></td>
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
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  value="<?echo $cedula?>" readonly></span></td>
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
                 <td width="146"><span class="Estilo5">FECHA LIQUIDACION :</span></td>
                 <td width="230"><span class="Estilo5"><input class="Estilo10" name="txtfecha_cal_fin" type="text" id="txtfecha_cal_fin" size="10" maxlength="10"  value="<?echo $fecha_cal_fin?>" readonly></span></td>
                 <td width="90"><span class="Estilo5">ANTIGUEDAD :</span></td>
				 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtant_ano" type="text" id="txtant_ano" size="5" maxlength="4"  style="text-align:right" value="<?echo $ant_ano?>" readonly></span></td>
                 <td width="50"><span class="Estilo5">A&Ntilde;OS</span></td>
				 <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtant_mes" type="text" id="txtant_mes" size="3" maxlength="4"  style="text-align:right" value="<?echo $ant_mes?>" readonly></span></td>
                 <td width="50"><span class="Estilo5">MESES</span></td>
				 <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtant_dia" type="text" id="txtant_dia" size="3" maxlength="4"  style="text-align:right" value="<?echo $ant_dia?>" readonly></span></td>
                 <td width="100"><span class="Estilo5">DIAS</span></td>
			   </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">SUELDO BASICO:</span></td>
                 <td width="230"><span class="Estilo5"><input class="Estilo10" name="txtsueldo_basico" type="text" id="txtsueldo_basico" size="15" maxlength="15"  style="text-align:right" value="<?echo $sueldo_basico?>" readonly></span></td>
                 <td width="150"><span class="Estilo5">SUELDO INTEGRAL:</span></td>
                 <td width="350"><span class="Estilo5"><input class="Estilo10" name="txtmonto_sue_int" type="text" id="txtmonto_sue_int" size="15" maxlength="15"  style="text-align:right" value="<?echo $monto_sue_int?>" readonly></span></td>

                </tr>
             </table></td>
           </tr>
           <tr>  <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="376"><span class="Estilo5">MONTO GARANTIA DE PRESTACIONES ART 142 LITERAL A y B :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtmonto_garantia" type="text" id="txtmonto_garantia" size="15" maxlength="15"  style="text-align:right" value="<?echo $monto_garantia?>" readonly></span></td>
                 <td width="150"><span class="Estilo5">FECHA DE GARANTIA :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_cal_garantia" type="text" id="txtfecha_cal_garantia" size="12" maxlength="10"  value="<?echo $fecha_cal_garantia?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>

		   <tr>
             <td><table width="876">
               <tr>
                 <td width="376"><span class="Estilo5">MONTO CALCULO DE PRESTACIONES ART 142 LITERAL C :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtmonto_art142" type="text" id="txtmonto_art142" size="15" maxlength="15"  style="text-align:right" value="<?echo $monto_art142?>" readonly></span></td>
                 <td width="200"><span class="Estilo5">TIEMPO DE SERVICIOS EN A&Ntilde;O :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txttiempo_servicio" type="text" id="txttiempo_servicio" size="5" maxlength="5"  style="text-align:right" value="<?echo $tiempo_servicio?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
		   
         </table>
         </form>
		 
<form name="form2" method="post" action="Inc_cal_prest_fin_relac.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
     <td width="5"><input class="Estilo10" name="txtcod_empleado" type="hidden" id="txtcod_empleado" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtcedula" type="hidden" id="txtcedula" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_ingreso" type="hidden" id="txtfecha_ingreso" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtnombre" type="hidden" id="txtnombre" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_cal_fin" type="hidden" id="txtfecha_cal_fin" value="<?echo $fecha_hoy?>" ></td>
     <td width="5"><input class="Estilo10" name="txtant_ano" type="hidden" id="txtant_ano" value=""></td>
     <td width="5"><input class="Estilo10" name="txtant_mes" type="hidden" id="txtant_mes" value=""></td>
     <td width="5"><input class="Estilo10" name="txtant_dia" type="hidden" id="txtant_dia" value=""></td>	 
     <td width="5"><input class="Estilo10" name="txtcod_sue_int" type="hidden" id="txtcod_sue_int" value=""></td>
     <td width="5"><input class="Estilo10" name="txtmonto_sue_int" type="hidden" id="txtmonto_sue_int" value=""></td>
     <td width="5"><input class="Estilo10" name="txtsueldo_basico" type="hidden" id="txtsueldo_basico" value=""></td>
     <td width="5"><input class="Estilo10" name="txttiempo_servicio" type="hidden" id="txttiempo_servicio" value=""></td>
     <td width="5"><input class="Estilo10" name="txtmonto_garantia" type="hidden" id="txtmonto_garantia" value=""></td>
	 <td width="5"><input class="Estilo10" name="txtmonto_art142" type="hidden" id="txtmonto_art142" value=""></td>	
	 <td width="5"><input class="Estilo10" name="txtfecha_cal_garantia" type="hidden" id="txtfecha_cal_garantia" value=""></td>	 
	 <td width="5"><input class="Estilo10" name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input class="Estilo10" name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $Cod_Emp?>" ></td> 
  </tr>
</table>
</form>

    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>