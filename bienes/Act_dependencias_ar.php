<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="01-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){ $cod_dependencia='';$p_letra="";  $sql="SELECT * FROM BIEN001 ORDER BY cod_dependencia";}
else {  $cod_dependencia = $_GET["Gcod_dependencia"];  $p_letra=substr($cod_dependencia, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$cod_dependencia=substr($cod_dependencia,1,4);} else{$cod_dependencia=substr($cod_dependencia,0,4);}
  $sql="Select * from BIEN001 where cod_dependencia='$cod_dependencia' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN001 ORDER BY cod_dependencia";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN001 Order by cod_dependencia desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN001 Where (cod_dependencia>'$cod_dependencia') Order by cod_dependencia";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN001 Where (cod_dependencia<'$cod_dependencia') Order by cod_dependencia desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Dependencia)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var Gcod_dependencia = "";
function Llamar_Ventana(url){var murl;
    Gcod_dependencia=document.form1.txtcod_dependencia.value;
    murl=url+Gcod_dependencia;
    if (Gcod_dependencia=="")    {alert("Codigo Dependencia debe ser Seleccionada");}  else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_dependecias_ar.php";
   if(MPos=="P"){murl="Act_dependencias_ar.php?Gcod_dependencia=P"}
   if(MPos=="U"){murl="Act_dependencias_ar.php?Gcod_dependencia=U"}
   if(MPos=="S"){murl="Act_dependencias_ar.php?Gcod_dependencia=S"+document.form1.txtcod_dependencia.value;}
   if(MPos=="A"){murl="Act_dependencias_ar.php?Gcod_dependencia=A"+document.form1.txtcod_dependencia.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar la Dependencia ?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar la Dependencia ?");
    if (r==true) {url="Delete_dependencias_ar.php?Gcod_dependencia="+document.form1.txtcod_dependencia.value; VentanaCentrada(url,'Eliminar Dependencia','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}
</script>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
$cod_dependencia=""; $denominacion_dep=""; $cod_region=""; $cod_entidad=""; $cod_municipio=""; $cod_ciudad=""; $cod_parroquia=""; $direccion_dep=""; $cod_postal_dep=""; $telefonos_dep=""; 
$ci_contacto=""; $nombre_contacto=""; $distrito=""; $cod_alterno=""; $saldo_inicial=""; $status1=""; $status2=""; $campo_str1=""; $campo_str2=""; $campo_num1=""; $campo_num2=""; $inf_usuario="";$nombre_region="";$estado="";$nombre_municipio="";$nombre_ciudad="";$nombre_parroquia="";
$res=pg_query($sql);$filas=pg_num_rows($res);if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From BIEN001 ORDER BY cod_dependencia";} if ($p_letra=="A"){$sql="SELECT * From BIEN001 ORDER BY cod_dependencia desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); 
$cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"]; $cod_region=$registro["cod_region"]; $cod_entidad=$registro["cod_entidad"]; $cod_municipio=$registro["cod_municipio"]; $cod_ciudad=$registro["cod_ciudad"]; $cod_parroquia=$registro["cod_parroquia"]; $direccion_dep=$registro["direccion_dep"]; 
$cod_postal_dep=$registro["cod_postal_dep"]; $telefonos_dep=$registro["telefonos_dep"];$ci_contacto=$registro["ci_contacto"]; $nombre_contacto=$registro["nombre_contacto"]; 
$distrito=$registro["distrito"]; $cod_alterno=$registro["cod_alterno"]; $saldo_inicial=$registro["saldo_inicial"]; $status1=$registro["status1"]; $status2=$registro["status2"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"]; $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $inf_usuario=$registro["inf_usuario"];
}
$Ssql="Select * from SIA000"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$reg_e=$registro["campo041"];$edo_e=$registro["campo010"];$mun_e=$registro["campo011"];$ciu_e=$registro["campo009"];}else{$reg_e="REGION CENTRO-OCCIDENTAL";$edo_e="LARA";$mun_e="IRIBARREN";$ciu_e="BARQUISIMETO";}
$cod_e="00"; $Ssql="SELECT * FROM pre091 where estado='".$edo_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_e=$registro["cod_estado"];}
//Regiones
$Ssql="SELECT * FROM pre092 where cod_region='".$cod_region."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_region=$registro["nombre_region"];}
//Entidad Federal
$Ssql="SELECT * FROM pre091 where cod_estado='".$cod_entidad."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$estado=$registro["estado"];}
//Municipios
$Ssql="SELECT * FROM pre093 where cod_municipio='".$cod_municipio."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_municipio=$registro["nombre_municipio"];}
//Ciudad
$Ssql="SELECT * FROM pre094 where cod_ciudad='".$cod_ciudad."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_ciudad=$registro["nombre_ciudad"];}
//Parroquia
$Ssql="SELECT * FROM pre096 where cod_parroquia='".$cod_parroquia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_parroquia=$registro["nombre_parroquia"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REGISTRAR DEPENDENCIAS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="391" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="385"><table width="92" height="417" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_dependencias_ar.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_dependencias_ar.php">Incluir</A></td>
      </tr>
     <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_dependencias_ar.php?Gcod_dependencia=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_dependencias_ar.php?Gcod_dependencia=');">Modificar</A></td>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_dependencias.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_dependencias.php" class="menu">Catalogo</a></td>
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
  <td height="91">&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><table width="821">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">C&Oacute;D. DEPENDENCIA :</span></div></td>
                 <td width="685"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" class="Estilo5"  value="<?echo $cod_dependencia?>" readonly>      </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="815">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">DENOMINACI&Oacute;N :</span></div></td>
                 <td width="685"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="80" maxlength="250" class="Estilo5" value="<?echo $denominacion_dep?>" readonly>     </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="817">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">REG&Iacute;ON :</span></div></td>
                 <td width="40"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_region" type="text" id="txtcod_region" size="4" maxlength="2" class="Estilo5" value="<?echo $cod_region?>" readonly > </span></div></td>
                 <td width="600"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenom_region" type="text" id="txtdenom_region" size="70" maxlength="250" class="Estilo5" readonly value="<?echo $nombre_region?>">    </span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="827">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">ENTIDAD FEDERAL :</span></div></td>
                 <td width="40"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_entidad" type="text" id="txtcod_entidad" size="4" maxlength="2" class="Estilo5" value="<?echo $cod_entidad?>" readonly> </span></div></td>
                 <td width="600"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenom_entidad" type="text" id="txtdenom_entidad" size="70" maxlength="250" class="Estilo5"readonly value="<?echo $estado?>">  </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="812">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">MUNICIPIO :</span></div></td>
                 <td width="40"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_municipio" type="text" id="txtcod_municipio" size="5" maxlength="4" class="Estilo5" value="<?echo $cod_municipio?>" readonly> </span></div></td>
                 <td width="600"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenom_municipio" type="text" id="txtdenom_municipio" size="70" maxlength="250" class="Estilo5" readonly value="<?echo $nombre_municipio?>">   </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="808">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">CIUDAD:</span></div></td>
                 <td width="40"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_ciudad" type="text" id="txtcod_ciudad" size="5" maxlength="4" class="Estilo5" value="<?echo $cod_ciudad?>" readonly> </span></div></td>
                 <td width="600"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenom_ciudad" type="text" id="txtdenom_ciudad" size="70" maxlength="250" class="Estilo5" readonly value="<?echo $nombre_ciudad?>">   </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="820">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">PARROQUIA :</span></div></td>
                 <td width="40"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_parroquia" type="text" id="txtcod_parroquia" size="7" maxlength="6" class="Estilo5" value="<?echo $cod_parroquia?>" readonly> </span></div></td>
                 <td width="600"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenom_parroquia" type="text" id="txtdenom_parroquia" size="70" maxlength="250" class="Estilo5" readonly value="<?echo $nombre_parroquia?>"> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="818">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">DIRECCI&Oacute;N :</span></div></td>
                 <td width="640"><div align="left"><textarea name="txt_direccion_dep" cols="70" readonly class="headers" id="txt_direccion_dep"><?echo $direccion_dep?></textarea>    </div></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <table width="828" align="center">
           <tr>
             <td><table width="814">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">C&Oacute;DIGO POSTAL :</span></div></td>
                 <td width="50"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_postal_dep" type="text" id="txtcod_postal_dep" size="15" maxlength="10"  class="Estilo5" value="<?echo $cod_postal_dep?>" readonly>  </div></td>
                 <td width="83"><div align="left"><span class="Estilo5">TEL&Eacute;FONOS :</span></div></td>
                 <td width="400"><div align="left"><span class="Estilo5"> <input class="Estilo10" name="txttelefonos_dep" type="text" id="txttelefonos_dep" size="35" maxlength="30" class="Estilo5" value="<?echo $telefonos_dep?>" readonly>   </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="811">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">C.I. RESPONSABLE :</span></div></td>
                 <td width="50"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtci_contacto" type="text" id="txtci_contacto" size="15" maxlength="12" class="Estilo5" value="<?echo $ci_contacto?>" readonly>
                 <td width="60"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                 <td width="400"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtnombre_contacto" type="text" id="txtnombre_contacto" size="50" maxlength="100" class="Estilo5" value="<?echo $nombre_contacto?>" readonly>
                     </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="802">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">DISTRITO :</span></div></td>
                 <td width="80"><div align="left"><span class="Estilo5"> <input class="Estilo10" name="txtdistrito" type="text" id="txtdistrito" size="4" maxlength="2" class="Estilo5" value="<?echo $distrito?>" readonly>   </div></td>
                 <td width="120"><div align="left"><span class="Estilo5">C&Oacute;DIGO ALTERNO :</span></div></td>
                 <td width="400"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_alterno" type="text" id="txtcod_alterno" size="35" maxlength="20" class="Estilo5"  value="<?echo $cod_alterno?>" readonly>  </div></td>
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
<? pg_close();?>
