<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="02-0000055"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_bien_inm='';$p_letra="";
  $sql="SELECT * FROM BIEN018 ORDER BY cod_bien_inm";}
else {
  $cod_bien_inm = $_GET["Gcod_bien_inm"];
  $p_letra=substr($cod_bien_inm, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$cod_bien_inm=substr($cod_bien_inm,1,12);}
   else{$cod_bien_inm=substr($cod_bien_inm,0,12);}
  $sql="Select * from BIEN018 where cod_bien_inm='$cod_bien_inm' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN018 ORDER BY cod_bien_inm";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN018 Order by cod_bien_inm desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN018 Where (cod_bien_inm>'$cod_bien_inm') Order by cod_bien_inm";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN018 Where (cod_bien_inm<'$cod_bien_inm') Order by cod_bien_inm desc";}
  //echo $sql="";"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Contrato de Mantenimiento de Bienes Inmuebles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Gcod_bien_inm = "";
function Llamar_Ventana(url){var murl;
    Gcod_bien_inm=document.form1.txtcod_bien_inm.value;
    murl=url+Gcod_bien_inm;
    if (Gcod_bien_inm=="")
        {alert("Cédula/Rif debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_bienes_inmuebles_pro_contra_mante.php";
   if(MPos=="P"){murl="Act_bienes_inmuebles_pro_contra_mante.php?Gcod_bien_inm=P"}
   if(MPos=="U"){murl="Act_bienes_inmuebles_pro_contra_mante.php?Gcod_bien_inm=U"}
   if(MPos=="S"){murl="Act_bienes_inmuebles_pro_contra_mante.php?Gcod_bien_inm=S"+document.form1.txtcod_bien_inm.value;}
   if(MPos=="A"){murl="Act_bienes_inmuebles_pro_contra_mante.php?Gcod_bien_inm=A"+document.form1.txtcod_bien_inm.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar Contrato de Mantenimiento de Bienes Inmuebles");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar Contrato de Mantenimiento de Bienes Inmuebles?");
    if (r==true) {url="Delete_bienes_inmuebles_pro_contra_mante.php?Gcod_bien_inm="+document.form1.txtcod_bien_inm.value; VentanaCentrada(url,'Eliminar Contrato de Mantenimiento de Bienes Inmuebles','','400','400','true');}}
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
<?
$cod_bien_inm=""; $numero_contrato="";$ced_rif_proveedor="";$fecha_contrato="";$fecha_desde=""; $fecha_hasta="";$monto_contrato=""; $inf_usuario=""; $observacion="";$direccion="";$denominacion="";$nombre="";
$res=pg_query($sql);
$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * From BIEN018 ORDER BY cod_bien_inm";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN018 ORDER BY cod_bien_inm desc";}
  $res=pg_query($sql);
  $filas=pg_num_rows($res);
}
if($filas>=1){
$registro=pg_fetch_array($res,0);
$cod_bien_inm=$registro["cod_bien_inm"]; 
$numero_contrato=$registro["numero_contrato"];
$ced_rif_proveedor=$registro["ced_rif_proveedor"];
$fecha_contrato=$registro["fecha_contrato"];
if($fecha_contrato==""){$fecha_contrato="";}else{$fecha_contrato=formato_ddmmaaaa($fecha_contrato);}
$fecha_desde=$registro["fecha_desde"]; 
if($fecha_desde==""){$fecha_desde="";}else{$fecha_desde=formato_ddmmaaaa($fecha_desde);}
$fecha_hasta=$registro["fecha_hasta"];
if($fecha_hasta==""){$fecha_hasta="";}else{$fecha_hasta=formato_ddmmaaaa($fecha_hasta);}
$monto_contrato=$registro["monto_contrato"]; 
$inf_usuario=$registro["inf_usuario"]; 
$observacion=$registro["observacion"];
$direccion=$registro["direccion"];
}
//Bienes inmuebles
$Ssql="SELECT * FROM BIEN014 where cod_bien_inm='".$cod_bien_inm."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion=$registro["denominacion"];}
//Arrendatario
$Ssql="SELECT * FROM pre099 where ced_rif='".$ced_rif_proveedor."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre=$registro["nombre"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONTRATO DE MANTENIMIENTOS  BIENES INMUBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="450" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="444"><table width="92" height="440" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_bienes_inmuebles_pro_contra_mante.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_bienes_inmuebles_pro_contra_mante.php">Incluir</A></td>
      </tr>
     <?if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_bienes_inmuebles_pro_contra_mante.php?Gcod_bien_inm=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_bienes_inmuebles_pro_contra_mante.php?Gcod_bien_inm=');">Modificar</A></td>
      </tr>
     <?if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_beneficiario.php?Gced_rif=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_beneficiario.php?Gced_rif=');">Consultar</A></td>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_beneficiarios.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Catalago</A></td>
      </tr>
     <?if ($Mcamino{3}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <?if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Imprimir</A></td>
      </tr>
     <? }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_a.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_a.php">Ayuda</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="42"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Contarto De Mantenimiento </A></td>
      </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:954px; height:523px; z-index:1; top: 72px; left: 122px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td height="32"><table width="962">
               <tr>
                 <td width="100" scope="col"><span class="Estilo5">C&Oacute;DIGO DE L BIEN INMUEBLES :</span></td>
                 <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcod_bien_inm" type="text" id="txtcod_bien_inm" size="30" maxlength="30"  value="<?echo $cod_bien_inm?>" readonly class="Estilo5">
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
                     <input name="txtdenominacion" type="text" id="txtdenominacion" size="90" maxlength="150" class="Estilo5" value="<?echo $denominacion?>" readonly>
                     <strong><strong>                 </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">DIRECCI&Oacute;N :</span></div></td>
                 <td width="869" scope="col"><div align="left">
                     <textarea name="txtdireccion" cols="70" readonly id="txtdireccion" class="Estilo5"><?echo $direccion?></textarea>
                 </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="34"><div align="center">
               <table width="962">
                 <tr>
                   <td width="140" scope="col"><span class="Estilo5">C&Eacute;DULA/RIF PROVEEDOR DEl SERVICIO DE MANTENIMIENTO :</span></td>
                   <td width="767" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                       <input name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12" class="Estilo5" value="<?echo $ced_rif_proveedor?>" readonly>
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
                   <td width="150" scope="col"><span class="Estilo5">NOMBRE DE PROVEEDOR :</span></td>
                   <td width="799" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                       <input name="txtnombre" type="text" id="txtmonbre" size="80" maxlength="150" class="Estilo5" value="<?echo $nombre?>" readonly>
                       <strong><strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="150" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO CONTRATO :</span></div></td>
                 <td width="90" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtnumero_contrato" type="text" id="txtnumero_contrato" size="10" maxlength="10" class="Estilo5" value="<?echo $numero_contrato?>" readonly>
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="115" scope="col"><div align="left"><span class="Estilo5">FECHA CONTRATO :</span></div></td>
                 <td width="611" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_contrato" type="text" id="txtfecha_contrato" size="15" maxlength="15" class="Estilo5" value="<?echo $fecha_contrato?>" readonly>
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="34"><div align="left">
               <table width="963">
                 <tr>
                   <td width="170" scope="col"><div align="left"><span class="Estilo5">PERIODO CONTRATO DESDE :</span></div></td>
                   <td width="122" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                       <input name="txtfecha_desde" type="text" id="txtfecha_desde" size="15" maxlength="15" class="Estilo5" value="<?echo $fecha_desde?>" readonly>
                       <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                   <td width="51" scope="col"><div align="left"><span class="Estilo5">HASTA :</span></div></td>
                   <td width="119" scope="col"><div align="left"><span class="Estilo5">
                       <input name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="15" maxlength="15" class="Estilo5" value="<?echo $fecha_hasta?>" readonly>
                       <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                   <td width="145" scope="col"><span class="Estilo5">MONTO DEL CONTRATO :</span></td>
                   <td width="379" scope="col"><span class="Estilo5">
                     <input name="txtmonto_contrato" type="text" id="txtmonto_contrato" size="25" maxlength="15" class="Estilo5" value="<?echo $monto_contrato?>" readonly>
                   </span></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td height="14">
               <div align="left">
                 <table width="962">
                   <tr>
                     <td width="150" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                     <td width="855" scope="col"><div align="left">
                         <textarea name="txtobservacion" cols="70" readonly id="txtobservacion" class="Estilo5"><?echo $observacion?></textarea>
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
<? pg_close();?>
