<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="02-0000050"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){$cod_bien_inm='';$p_letra="";
  $sql="SELECT * FROM BIEN017 ORDER BY cod_bien_inm";}
else {
  $cod_bien_inm = $_GET["Gcod_bien_inm"];
  $p_letra=substr($cod_bien_inm, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$cod_bien_inm=substr($cod_bien_inm,1,12);}
   else{$cod_bien_inm=substr($cod_bien_inm,0,12);}
  $sql="Select * from BIEN017 where cod_bien_inm='$cod_bien_inm' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN017 ORDER BY cod_bien_inm";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN017 Order by cod_bien_inm desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN017 Where (cod_bien_inm>'$cod_bien_inm') Order by cod_bien_inm";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN017 Where (cod_bien_inm<'$cod_bien_inm') Order by cod_bien_inm desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Arrendamiento Bienes Inmuebles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Gcod_bien_inm = "";
function Llamar_Ventana(url){var murl;
    Gcod_bien_inm=document.form1.txtcod_bien_inm.value;
    murl=url+Gcod_bien_inm;
    if (Gcod_bien_inm=="")
        {alert("Codigo del Bien debe ser Seleccionado");}
        else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php";
   if(MPos=="P"){murl="Act_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php?Gcod_bien_inm=P"}
   if(MPos=="U"){murl="Act_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php?Gcod_bien_inm=U"}
   if(MPos=="S"){murl="Act_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php?Gcod_bien_inm=S"+document.form1.txtcod_bien_inm.value;}
   if(MPos=="A"){murl="Act_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php?Gcod_bien_inm=A"+document.form1.txtcod_bien_inm.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar Arrendamiento del Bien Inmueble?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar Arrendamiento del Bien Inmueble?");
    if (r==true) {url="Delete_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php?Gcod_bien_inm="+document.form1.txtcod_bien_inm.value; VentanaCentrada(url,'Eliminar Arrendamiento del Bien Inmueble','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
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
$cod_bien_inm=""; $numero_contrato="";$ced_arrendatario="";$fecha_contrato="";$fecha_desde=""; $fecha_hasta="";$canon_arr=""; $garantia_fianza=""; $inf_usuario=""; $observacion="";$denominacion="";$nombre="";
$res=pg_query($sql);
$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * From BIEN017 ORDER BY cod_bien_inm";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN017 ORDER BY cod_bien_inm desc";}
  $res=pg_query($sql);
  $filas=pg_num_rows($res);
}
if($filas>=1){
$registro=pg_fetch_array($res,0);
$cod_bien_inm=$registro["cod_bien_inm"]; 
$numero_contrato=$registro["numero_contrato"];
$ced_arrendatario=$registro["ced_arrendatario"];
$fecha_contrato=$registro["fecha_contrato"];
$fecha_desde=$registro["fecha_desde"]; 
$fecha_hasta=$registro["fecha_hasta"];
$canon_arr=$registro["canon_arr"]; 
$garantia_fianza=$registro["garantia_fianza"];
$inf_usuario=$registro["inf_usuario"]; 
$observacion=$registro["observacion"];
}
//Bienes inmuebles
$Ssql="SELECT * FROM BIEN014 where cod_bien_inm='".$cod_bien_inm."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion=$registro["denominacion"];}
//Arrendatario
$Ssql="SELECT * FROM BIEN011 where ced_rif='".$ced_arrendatario."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre=$registro["nombre_ocupante"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ARRENDAMIENTOS BIENES INMUBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="438" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="432"><table width="92" height="428" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?php if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php">Incluir</A></td>
      </tr>
     <?php } if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php?Gcod_bien_inm=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php?Gcod_bien_inm=');">Modificar</A></td>
      </tr>
     <?php } if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_beneficiario.php?Gcod_bien_inm=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_beneficiario.php?Gcod_bien_inm=');">Consultar</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_Act_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Catalago</A></td>
      </tr>
     <?php } if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <?php }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Procesos </A></td>
      </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:954px; height:523px; z-index:1; top: 72px; left: 119px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td height="32"><table width="962">
               <tr>
                 <td width="100" scope="col"><span class="Estilo5">C&Oacute;DIGO DE L BIEN INMUEBLES :</span></td>
                 <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcod_bien_inm" type="text" id="txtcod_bien_inm" size="30" maxlength="30" class="Estilo5" value="<?php echo $cod_bien_inm?>" readonly>
                     <strong><strong>
                    </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="100" scope="col"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                 <td width="847" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtdenominacion" type="text" id="txtdenominacion" size="80" maxlength="150" class="Estilo5" value="<?php echo $denominacion?>" readonly>
                     <strong><strong>                 </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><div align="center">
               <table width="962">
                 <tr>
                   <td width="170" scope="col"><span class="Estilo5">C&Eacute;DULA DE ARRENDATARIO :</span></td>
                   <td width="784" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                       <input name="txtced_arrendatario" type="text" id="txtced_arrendatario" size="" maxlength="12" class="Estilo5" value="<?php echo $ced_arrendatario?>" readonly>
                       <strong><strong>

                   </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td><div align="left">
               <table width="962">
                 <tr>
                   <td width="170" scope="col"><span class="Estilo5">NOMBRE DE ARRENDATARIO :</span></td>
                   <td width="780" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                       <input name="txtnombre" type="text" id="txtmonbre" size="70" maxlength="150" class="Estilo5" value="<?php echo $nombre?>" readonly>
                       <strong><strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="170" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO CONTRATO :</span></div></td>
                 <td width="90" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtnumero_contrato" type="text" id="txtnumero_contrato" size="10" maxlength="10" class="Estilo5" value="<?php echo $numero_contrato?>" readonly>
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="115" scope="col"><div align="left"><span class="Estilo5">FECHA CONTRATO :</span></div></td>
                 <td width="611" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_contrato" type="text" id="txtfecha_contrato" size="15" maxlength="15" class="Estilo5" value="<?php echo $fecha_contrato?>" readonly>
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="32"><div align="left">
               <table width="963">
                 <tr>
                   <td width="170" scope="col"><div align="left"><span class="Estilo5">PERIODO ARRENDAMIENTO DESDE :</span></div></td>
                   <td width="125" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                       <input name="txtfecha_desde" type="text" id="txtfecha_desde" size="15" maxlength="15" class="Estilo5" value="<?php echo $fecha_desde?>" readonly>
                       <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                   <td width="50" scope="col"><div align="left"><span class="Estilo5">HASTA :</span></div></td>
                   <td width="610" scope="col"><div align="left"><span class="Estilo5">
                       <input name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="15" maxlength="15" class="Estilo5" value="<?php echo $fecha_hasta?>" readonly>
                       <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td height="14">
               <div align="left">
                 <table width="963">
                   <tr>
                     <td width="170" scope="col"><div align="left"><span class="Estilo5">CANON DE ARRENDAMIENTO :</span></div></td>
                     <td width="122" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                         <input name="txtcanon_arr" type="text" id="txtcanon_arr" size="15" maxlength="15" class="Estilo5" value="<?php echo $canon_arr?>" readonly>
                         <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                     <td width="163" scope="col"><div align="left"><span class="Estilo5">VALOR GARANTIA/FINANZA :</span></div></td>
                     <td width="548" scope="col"><div align="left"><span class="Estilo5">
                         <input name="txtgarantia_fianza" type="text" id="txtgarantia_fianza" size="20" class="Estilo5" value="<?php echo $garantia_fianza?>" readonly>
                         <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                   </tr>
                 </table>
              </div></td>
           </tr>
         </table>
         <table width="974" align="center">
           <tr>
             <td>
               <div align="left">
                 <table width="962">
                   <tr>
                     <td width="170" scope="col"><div align="left"><span class="Estilo5">ODSERVACI&Oacute;N :</span></div></td>
                     <td width="855" scope="col"><div align="left">
                         <textarea name="textobservacion" cols="70" readonly class="headers" id="textobservacion" class="Estilo5"><?php echo $observacion?></textarea>
                     </div></td>
                   </tr>
                 </table>
               </div></td>
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
<?php  pg_close($conn);?>
