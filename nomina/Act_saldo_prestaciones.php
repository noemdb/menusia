<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000040"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_empleado=''; $p_letra='';$sql="SELECT * FROM CAL_PRESTA Where (Tipo_Calculo='S') ORDER BY cod_empleado";
} else {$codigo=$_GET["Gcodigo"];$p_letra=substr($codigo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_empleado=substr($codigo,1,15);} else{$cod_empleado=substr($codigo,0,15);}
  $sql="Select * FROM CAL_PRESTA  where (Tipo_Calculo='S') and (cod_empleado='$cod_empleado')"; $clave=$cod_empleado;
  if ($p_letra=="P"){$sql="SELECT * FROM CAL_PRESTA Where (Tipo_Calculo='S') Order BY cod_empleado";}
  if ($p_letra=="U"){$sql="SELECT * FROM CAL_PRESTA Where (Tipo_Calculo='S') Order by cod_empleado Desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM CAL_PRESTA Where (Tipo_Calculo='S') and (cod_empleado>'$clave') Order by cod_empleado";}
  if ($p_letra=="A"){$sql="SELECT * FROM CAL_PRESTA Where (Tipo_Calculo='S') and (cod_empleado<'$clave') Order by cod_empleado Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Saldo de Prestaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Mover_Registro(MPos){
var murl;
   murl="Act_saldo_prestaciones.php";
   if(MPos=="P"){murl="Act_saldo_prestaciones.php?Gcodigo=P"}
   if(MPos=="U"){murl="Act_saldo_prestaciones.php?Gcodigo=U"}
   if(MPos=="S"){murl="Act_saldo_prestaciones.php?Gcodigo=S"+document.form1.txtcod_empleado.value;}
   if(MPos=="A"){murl="Act_saldo_prestaciones.php?Gcodigo=A"+document.form1.txtcod_empleado.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url;var r;
  r=confirm("Esta seguro en Eliminar el Saldo de Prestaciones ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Saldo de Prestaciones ?");
    if (r==true) { url="Delete_saldo_presta.php?txtcod_empleado="+document.form1.txtcod_empleado.value;  VentanaCentrada(url,'Eliminar Saldo de Prestaciones','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
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
</script>

</head>
<?
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM CAL_PRESTA Where (Tipo_Calculo='S') Order by cod_empleado";}if ($p_letra=="A"){$sql="SELECT * FROM CAL_PRESTA Where (Tipo_Calculo='S') Order by cod_empleado desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$nombre="";$cod_empleado=""; $cedula=""; $fecha_ingreso=""; $fecha_calculo=""; $sueldo_calculo=0;  $dias_prestaciones=0;  $sueldo_calculo_adic=0;  $dias_adicionales=0; $total_prestaciones=0;  $total_adelanto=0; $interes_pagado=0; $acumulado_total=0; $total_interes=0; $saldo_prestaciones668=0; $total_interes668=0; $interes_noacum=0; $interes_acum=0;
if($filas>=1){  $registro=pg_fetch_array($res,0);  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_calculo=$registro["fecha_calculo"]; $fecha_calculo=formato_ddmmaaaa($fecha_calculo); $sueldo_calculo=$registro["sueldo_calculo"];  $dias_prestaciones=$registro["dias_prestaciones"];
  $sueldo_calculo_adic=$registro["sueldo_calculo_adic"];  $dias_adicionales=$registro["dias_adicionales"]; $total_prestaciones=$registro["total_prestaciones"];  $total_adelanto=$registro["total_adelanto"]; $interes_pagado=$registro["interes_pagado"];
  $acumulado_total=$registro["acumulado_total"]; $total_interes=$registro["total_interes"]; $interes_noacum=$registro["interes_noacum"]; $interes_acum=$registro["interes_acum"]; $interes_noacum=formato_monto($interes_noacum); $interes_acum=formato_monto($interes_acum); $interes_pagado=formato_monto($interes_pagado);
} $sueldo_calculo=formato_monto($sueldo_calculo);  $sueldo_calculo_adic=formato_monto($sueldo_calculo_adic);  $total_prestaciones=formato_monto($total_prestaciones); $acumulado_total=formato_monto($acumulado_total); $total_interes=formato_monto($total_interes); $total_adelanto=formato_monto($total_adelanto);
$strSQL = "SELECT * FROM NOM075 Where (Cod_Empleado='$cod_empleado')"; $resultado=pg_query($strSQL);$filas=pg_num_rows($resultado); if($filas>=1){  $reg=pg_fetch_array($resultado,0); $saldo_prestaciones668=$reg["saldo_prestaciones"]; $total_interes668=$reg["total_interes"]; $saldo_prestaciones668=formato_monto($saldo_prestaciones668); $total_interes668=formato_monto($total_interes668);}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">SALDO DE PRESTACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="376" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="373" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_saldo_presta.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_saldo_presta.php">Incluir</A></td>
      </tr>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_saldo_presta.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_saldo_presta.php" class="menu">Catalogo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
      </tr>
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
           <tr>
             <td><table width="866">
               <tr>
                 <td width="146" ><span class="Estilo5">FECHA CALCULO : </span></td>
                 <td width="150" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_calculo" type="text" id="txtfecha_calculo" size="10" maxlength="10" readonly value="<?echo $fecha_calculo?>"></span></td>
                 <td width="130" ><span class="Estilo5">MONTO SUELDO : </span></td>
                 <td width="180" ><span class="Estilo5"><input class="Estilo10" name="txtsueldo_calculo" type="text" id="txtsueldo_calculo" size="17" maxlength="17"  style="text-align:right" readonly value="<?echo $sueldo_calculo?>"></span></td>
                 <td width="120"><span class="Estilo5">CANTIDAD DIAS  :</span></td>
                 <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtdias_prestaciones" type="text" id="txtdias_prestaciones" size="10" maxlength="10"  style="text-align:right" value="<?echo $dias_prestaciones?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">MONTO SUELDO DIAS ADICIONALES: </span></td>
                 <td width="310" ><span class="Estilo5"><input class="Estilo10" name="txtsueldo_calculo_adic" type="text" id="txtsueldo_calculo_adic" size="17" maxlength="17" style="text-align:right" readonly value="<?echo $sueldo_calculo_adic?>"></span></td>
                 <td width="200" ><span class="Estilo5">CANTIDAD DIAS ADICIONALES : </span></td>
                 <td width="140" ><span class="Estilo5"><input class="Estilo10" name="txtdias_adicionales" type="text" id="txtdias_adicionales" size="10" maxlength="10"  style="text-align:right" readonly value="<?echo $dias_adicionales?>"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">TOTAL PRESTACIONES : </span></td>
                 <td width="330" ><span class="Estilo5"> <input class="Estilo10" name="txttotal_prestaciones" type="text" id="txttotal_prestaciones" size="17" maxlength="17"  style="text-align:right" readonly value="<?echo $total_prestaciones?>"></span></td>
                 <td width="140" ><span class="Estilo5">TOTAL ADELANTO : </span></td>
                 <td width="180" ><span class="Estilo5"><input class="Estilo10" name="txttotal_adelanto" type="text" id="txttotal_adelanto" size="17" maxlength="17"  style="text-align:right" readonly value="<?echo $total_adelanto?>"></span></td>
                </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">INTERES CAPITALIZADO : </span></td>
                 <td width="330" ><span class="Estilo5"> <input class="Estilo10" name="txtinteres_devengado" type="text" id="txtinteres_devengado" size="17" maxlength="17"  style="text-align:right" readonly value="<?echo $interes_acum?>"></span></td>
                 <td width="140" ><span class="Estilo5">INTERES NO CAPITALIZADO : </span></td>
                 <td width="180" ><span class="Estilo5"><input class="Estilo10" name="txtinteres_noacum" type="text" id="txtinteres_noacum" size="17" maxlength="17"  style="text-align:right" readonly value="<?echo $interes_noacum?>"></span></td>
                </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
			     <td width="216" ><span class="Estilo5">INTERES PAGADO : </span></td>
                 <td width="330" ><span class="Estilo5"><input class="Estilo10" name="txtinteres_pagado" type="text" id="txtinteres_pagado" size="17" maxlength="17"  style="text-align:right" readonly value="<?echo $interes_pagado?>"  ></span></td>
                 <td width="140" ><span class="Estilo5">TOTAL INTERESES : </span></td>
                 <td width="180" ><span class="Estilo5"><input class="Estilo10" name="txttotal_interes" type="text" id="txttotal_interes" size="17" maxlength="17"  style="text-align:right" readonly readonly value="<?echo $total_interes?>"  ></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>                 
				 <td width="216" ><span class="Estilo5">SALDO PRESTACIONES : </span></td>
                 <td width="330" ><span class="Estilo5"> <input class="Estilo10" name="txtacumulado_total" type="text" id="txtacumulado_total" size="17" maxlength="17"  style="text-align:right" readonly value="<?echo $acumulado_total?>"></span></td>
                 <td width="140" ><span class="Estilo5"> </span></td>
                 <td width="180" ><span class="Estilo5"></span></td>
				</tr>
             </table></td>
           </tr>
		   <!-- 
           <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">SALDO PRESTACIONES ART.668: </span></td>
                 <td width="250" ><span class="Estilo5"> <input class="Estilo10" name="txtsaldo_prestaciones668" type="text" id="txtsaldo_prestaciones668" size="17" maxlength="17"  style="text-align:right" readonly value="<?echo $saldo_prestaciones668?>"></span></td>
                 <td width="220" ><span class="Estilo5">INTERESES PRESTACIONES ART.668: </span></td>
                 <td width="180" ><span class="Estilo5"><input class="Estilo10" name="txttotal_interes668" type="text" id="txttotal_interes668" size="17" maxlength="17"  style="text-align:right" readonly value="<?echo $total_interes668?>"></span></td>
                </tr>
             </table></td>
           </tr>
		   -->
         </table>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>