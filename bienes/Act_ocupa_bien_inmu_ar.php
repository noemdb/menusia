<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="01-0000075"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){
  $ced_rif='';$p_letra="";
  $sql="SELECT * FROM BIEN011 ORDER BY ced_rif";}
else {
  $ced_rif = $_GET["Gced_rif"];
  $p_letra=substr($ced_rif, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$ced_rif=substr($ced_rif,1,12);}
   else{$ced_rif=substr($ced_rif,0,12);}
  $sql="Select * from BIEN011 where ced_rif='$ced_rif' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN011 ORDER BY ced_rif";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN011 Order by ced_rif desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN011 Where (ced_rif>'$ced_rif') Order by ced_rif";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN011 Where (ced_rif<'$ced_rif') Order by ced_rif desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Registrar Ocupantes del Bien Inmueble)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Gced_rif = "";
function Llamar_Ventana(url){var murl;
    Gced_rif=document.form1.txtced_rif.value;
    murl=url+Gced_rif;
    if (Gced_rif=="")
        {alert("C�dula/Rif debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_ocupa_bien_inmu_ar.php";
   if(MPos=="P"){murl="Act_ocupa_bien_inmu_ar.php?Gced_rif=P"}
   if(MPos=="U"){murl="Act_ocupa_bien_inmu_ar.php?Gced_rif=U"}
   if(MPos=="S"){murl="Act_ocupa_bien_inmu_ar.php?Gced_rif=S"+document.form1.txtced_rif.value;}
   if(MPos=="A"){murl="Act_ocupa_bien_inmu_ar.php?Gced_rif=A"+document.form1.txtced_rif.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar el Ocupante del Bien Inmueble?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar el Ocupante del Bien Inmueble?");
    if (r==true) {url="Delete_ocupa_bien_inmu_ar.php?Gced_rif="+document.form1.txtced_rif.value; VentanaCentrada(url,'Eliminar el Ocupante del Bien Inmueble','','400','400','true');}}
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
$ced_rif=""; $nombre_ocupante=""; $cedula=""; $rif=""; $nit=""; $tipo=""; $observacion="";
$res=pg_query($sql);
$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * From BIEN011 ORDER BY ced_rif";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN011 ORDER BY ced_rif desc";}
  $res=pg_query($sql);
  $filas=pg_num_rows($res);
}
if($filas>=1){
  $registro=pg_fetch_array($res,0);
  $ced_rif=$registro["ced_rif"];
  $nombre_ocupante=$registro["nombre_ocupante"];
  $cedula=$registro["cedula"];
  $rif=$registro["rif"];
  $nit=$registro["nit"];
  $tipo=$registro["tipo"];
  $observacion=$registro["observacion"];
}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REGISTRAR OCUPANTES DEL BIEN INMUEBLE </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="335" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="329"><table width="92" height="325" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_ocupa_bien_inmu_ar.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_ocupa_bien_inmu_ar.php">Incluir</A></td>
      </tr>
     <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_ocupa_bien_inmu_ar.php?Gced_rif=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_ocupa_bien_inmu_ar.php?Gced_rif=');">Modificar</A></td>
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
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_ocupa_bien_inmu_ar.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_ocupa_bien_inmu_ar.php" class="menu">Catalogo</a></td>
      </tr>
     <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <? }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><table width="795">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA/RIF :</span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="12"   value="<?echo $ced_rif?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="803">
               <tr>
                 <td width="130" scope="col"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                 <td width="730" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_ocupante" type="text" id="txtnombre_ocupante" size="80" maxlength="80"   value="<?echo $nombre_ocupante?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="805">
               <tr>
                 <td width="110" scope="col"><span class="Estilo5">C&Eacute;DULA : </span></td>
                 <td width="122" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcedula" type="text" id="txtcedula" size="15" maxlength="12"   value="<?echo $cedula?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong> </strong></strong></span> </span></span></div></td>
                 <td width="45" scope="col"><span class="Estilo5">R.I.F :</span></td>
                 <td width="129" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtrif" type="text" id="txtrif" size="15" maxlength="12"  value="<?echo $rif?>" readonly class="Estilo5">
                 </span></div></td>
                 <td width="43" scope="col"><div align="left"><span class="Estilo5">N.I.T :</span></div></td>
                 <td width="379" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnit" type="text" id="txtnit" size="15" maxlength="15"  value="<?echo $nit?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
               <tr>
                 <td width="94" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                 <td width="694" scope="col"><div align="left">
                     <textarea name="txtobservacion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" readonly class="Estilo5" class="headers" id="txtobservacion"><?echo $observacion?></textarea>
                 </div></td>
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
