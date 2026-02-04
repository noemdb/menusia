<?php include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php");include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit;} else{$Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="01-0000045"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){ $ced_rif=''; $sql="SELECT * FROM PRE099 ORDER BY ced_rif"; $p_letra="";}else {$ced_rif = $_GET["Gced_rif"];$p_letra=substr($ced_rif, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$ced_rif=substr($ced_rif,1,12);} else{$ced_rif=substr($ced_rif,0,12);}
  $sql="Select * from PRE099 where ced_rif='$ced_rif' ";
  if ($p_letra=="P"){$sql="SELECT * FROM PRE099 ORDER BY ced_rif";}
  if ($p_letra=="U"){$sql="SELECT * From PRE099 Order by ced_rif desc";}
  if ($p_letra=="S"){$sql="SELECT * From PRE099 Where (ced_rif>'$ced_rif') Order by ced_rif";}
  if ($p_letra=="A"){$sql="SELECT * From PRE099 Where (ced_rif<'$ced_rif') Order by ced_rif desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Actualiza Beneficiario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var Gced_rif = "";
function Llamar_Incluir(mop){ document.form2.submit(); }
function Llamar_Ventana(url){var murl;
    Gced_rif=document.form1.txtced_rif.value;murl=url+Gced_rif;
    if (Gced_rif==""){alert("C�dula/Rif debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){ var murl;
   murl="Act_beneficiarios.php";
   if(MPos=="P"){murl="Act_beneficiarios.php?Gced_rif=P"}
   if(MPos=="U"){murl="Act_beneficiarios.php?Gced_rif=U"}
   if(MPos=="S"){murl="Act_beneficiarios.php?Gced_rif=S"+document.form1.txtced_rif.value;}
   if(MPos=="A"){murl="Act_beneficiarios.php?Gced_rif=A"+document.form1.txtced_rif.value;}
   document.location = murl;
}
function Llama_Eliminar(){ var url; var r;
  r=confirm("Esta seguro en Eliminar el Beneficiario ?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar el Beneficiario ?");
    if (r==true) {url="Delete_beneficiario.php?Gced_rif="+document.form1.txtced_rif.value; VentanaCentrada(url,'Eliminar Beneficiario','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}
function Llama_Cambiar(){var url; var r; 
  url="../pagos/Cambiar_ced_rif.php?Gced_rif="+document.form1.txtced_rif.value+"&Gnombre="+document.form1.txtnombre.value; 
  VentanaCentrada(url,'Cambiar Cedula/Rif Beneficiario','','800','400','true');  
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
<?php  $nombre="";$cedula="";$rif="";$nit=""; $direccion="";$tipo_benef=""; $ced_rif_aut="";$nombre_auto="";  $ciudad="";$municipio="";$region="";$estado="";$pais="";$telefono="";$fax="";$tlf_movil="";  $pasaporte="";$nacionalidad="";   $residente=""; $campo_str1=""; $campo_str2=""; $nombre_grupob=""; $observaciones="";  $clasificacion="";$rep_legal=""; $cod_postal="";$aptd_postal="";$tipo_orden="";  $des_tipo_orden="";   $inf_usuario="";
$res=pg_query($sql);$filas=pg_num_rows($res);if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From PRE099 ORDER BY ced_rif";} if ($p_letra=="A"){$sql="SELECT * From PRE099 ORDER BY ced_rif desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"];$cedula=$registro["cedula"];  $rif=$registro["rif"];$nit=$registro["nit"];$direccion=$registro["direccion"];$tipo_benef=$registro["tipo_benef"];
  $ced_rif_aut=$registro["ced_rif_autorizado"];$nombre_auto=$registro["nombre_autorizado"];  $ciudad=$registro["ciudad"];$municipio=$registro["municipio"];  $region=$registro["region"];$estado=$registro["estado"];$pais=$registro["pais"];$telefono=$registro["telefono"];$fax=$registro["fax"];$tlf_movil=$registro["tlf_movil"];
  $pasaporte=$registro["pasaporte"];$nacionalidad=$registro["nacionalidad"];$residente=$registro["residente"];$observaciones=$registro["observaciones"];  $clasificacion=$registro["clasificacion"];$rep_legal=$registro["representante_legal"];
  $cod_postal=$registro["cod_postal"];$aptd_postal=$registro["aptd_postal"];$tipo_orden=$registro["tipo_orden"];  $des_tipo_orden=""; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];  $inf_usuario=$registro["inf_usuario"];
}
$Ssql="Select * from SIA000"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$reg_e=$registro["campo041"];$edo_e=$registro["campo010"];$mun_e=$registro["campo011"];$ciu_e=$registro["campo009"];}else{$reg_e="REGION CENTRO-OCCIDENTAL";$edo_e="LARA";$mun_e="IRIBARREN";$ciu_e="BARQUISIMETO";}
$cod_e="00"; $Ssql="SELECT * FROM pre091 where estado='".$edo_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_e=$registro["cod_estado"];}
$Ssql="Select * from ban022 where cod_grupob='$campo_str1'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_grupob=$registro["nombre_grupob"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">BENEFICIARIOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="525" border="1" id="tablacuerpo">
  <tr>
   <td width="92"><table width="92" height="516" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
       <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Incluir()";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Incluir()">Incluir</A></td>
      </tr>
	  <?php }if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_beneficiario.php?Gced_rif=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_beneficiario.php?Gced_rif=');">Modificar</A></td>
      </tr>
	  <?php } if ($Mcamino{2}=="S"){?>
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
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_beneficiarios.php" class="menu">Catalogo</a></td>
      </tr>
	  <?php }if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
      <?php }if (($Mcamino{11}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Cambiar();">Cambiar Cedula/Rif</A></td>
      </tr>
          <?php } ?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
   <td>&nbsp;</td>
  </tr>
  </table></td>
    <td width="932">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:861px; height:523px; z-index:1; top: 65px; left: 115px;">
        <form name="form1" method="post">

         <table width="828" border="0" align="center" >
           <tr>
             <td><table width="810" >
               <tr>
                 <td width="84"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                 <td width="331"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15"  value="<?php echo $ced_rif?>" readonly></span></td>
                 <td width="159"><span class="Estilo5">TIPO DE BENEFICIARIO :</span></td>
                 <td width="159"><span class="Estilo5"> <input class="Estilo10" name="txttipo_benef" type="text" id="txttipo_benef" size="20"  value="<?php echo $tipo_benef?>" readonly></span></td>
                 <td width="53"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?php echo $inf_usuario?>');"></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="820">
               <tr>
                 <td width="85"><span class="Estilo5">NOMBRE :</span></td>
                 <td width="705"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" value="<?php echo $nombre?>" size="107" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
               <tr>
                 <td width="85"><span class="Estilo5">C&Eacute;DULA :</span></td>
                 <td width="190"><span class="Estilo5"><input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="20" maxlength="15"  value="<?php echo $cedula?>" readonly></span></td>
                 <td width="52"><span class="Estilo5">RIF :</span></td>
                 <td width="207"><span class="Estilo5"><input class="Estilo10" name="txtrif" type="text" id="txtrif" size="20" maxlength="15"  value="<?php echo $rif?>" readonly></span></td>
                 <td width="57"><span class="Estilo5">NIT :</span></td>
                 <td width="181"><span class="Estilo5"><input class="Estilo10" name="txtnit" type="text" id="txtnit" size="20" maxlength="15"  value="<?php echo $nit?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
               <tr>
                 <td width="85"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="705"><textarea name="txtdireccion" cols="84" readonly="readonly" class="Estilo10" id="txtdireccion"><?php echo $direccion?></textarea></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
               <tr>
                 <td width="82"><span class="Estilo5">REGION :</span></td>
                 <td width="308"><span class="Estilo5"><input class="Estilo10" name="txtregion" type="text" id="txtregion" size="40"  value="<?php echo $region?>" readonly></span></td>
                 <td width="87"><span class="Estilo5">ESTADO :</span></td>
                 <td width="303"><span class="Estilo5"><input class="Estilo10" name="txtestado" type="text" id="txtestado" size="40"  value="<?php echo $estado?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
               <tr>
                 <td width="82"><span class="Estilo5">MUNICIPIO :</span></td>
                 <td width="308"><span class="Estilo5"><input class="Estilo10" name="txtmunicipio" type="text" id="txtmunicipio" size="40"  value="<?php echo $municipio?>" readonly></span></td>
                 <td width="87"><span class="Estilo5">CIUDAD :</span></td>
                 <td width="303"><span class="Estilo5"><input class="Estilo10" name="txtciudad" type="text" id="txtciudad" size="40"  value="<?php echo $ciudad?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
               <tr>
                 <td width="164"><span class="Estilo5">C&Eacute;DULA/RIF AUTORIZADO :</span></td>
                 <td width="624"><span class="Estilo5"><input class="Estilo10" name="txtced_rif_aut" type="text" id="txtced_rif_aut" value="<?php echo $ced_rif_aut?>" size="20" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
               <tr>
                 <td width="164"><span class="Estilo5">NOMBRE AUTORIZADO:</span></td>
                 <td width="624"><span class="Estilo5"><input class="Estilo10" name="txtnomb_auto" type="text" id="txtnomb_auto" value="<?php echo $nombre_auto?>" size="93" readonly></span></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <table width="828" align="center">
           <tr>
             <td><table width="800">
                 <tr>
                   <td width="84"><span class="Estilo5">TELEFONOS:</span></td>
                   <td width="204"><span class="Estilo5"><input class="Estilo10" name="txttelefono" type="text" id="txttelefono" size="25" maxlength="25"  value="<?php echo $telefono?>" readonly></span></td>
                   <td width="38"><span class="Estilo5">FAX :</span></td>
                   <td width="162"><span class="Estilo5"><input class="Estilo10" name="txtfax" type="text" id="txtfax" size="20" maxlength="20"  value="<?php echo $fax?>" readonly></span></td>
                   <td width="75"><span class="Estilo5">TLF. MOVIL:</span></td>
                   <td width="209"><span class="Estilo5"><input class="Estilo10" name="txttlf_movil" type="text" id="txttlf_movil" size="25" maxlength="25"  value="<?php echo $tlf_movil?>" readonly></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
                 <tr>
                   <td width="95"><span class="Estilo5">COD. POSTAL :</span></td>
                   <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtcod_postal" type="text" id="txtcod_postal3" size="20" maxlength="10"  value="<?php echo $cod_postal?>" readonly></span></td>
                   <td width="81"><span class="Estilo5">APARTADO :</span></td>
                   <td width="162"><span class="Estilo5"><input class="Estilo10" name="txtaptd_postal" type="text" id="txtaptd_postal3" size="20" maxlength="10"  value="<?php echo $aptd_postal?>" readonly></span></td>
                   <td width="106"><span class="Estilo5">NRO. PASAPORTE:</span></td>
                   <td width="178"><span class="Estilo5"> <input class="Estilo10" name="txtpasaporte" type="text" id="txtpasaporte2" size="20" maxlength="15"  value="<?php echo $pasaporte?>" readonly></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="817">
                 <tr>
                   <td width="74"><span class="Estilo5">RESIDENTE :</span></td>
                   <td width="53"><span class="Estilo5"><input class="Estilo10" name="txtresidente" type="text" id="txtcod_postal22" size="3" maxlength="1"  value="<?php echo $residente?>" readonly></span></td>
                   <td width="100"><span class="Estilo5">NACIONALIDAD :</span></td>
                   <td width="153"><span class="Estilo5"><input class="Estilo10" name="txtnacionalidad" type="text" id="txtnacionalidad" size="20" maxlength="10"  value="<?php echo $nacionalidad?>" readonly></span></td>
                   <td width="39"><span class="Estilo5">PAIS:</span></td>
                   <td width="353"><span class="Estilo5"><input class="Estilo10" name="txtpais" type="text" id="txtpais" size="53"  value="<?php echo $pais?>" readonly></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
               <tr>
                 <td width="164"><span class="Estilo5">REPRESENTANTE LEGAL:</span></td>
                 <td width="624"><span class="Estilo5"><input class="Estilo10" name="txtrep_legal" type="text" id="txtrep_legal" value="<?php echo $rep_legal?>" size="93" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
               <tr>
                 <td width="216"><span class="Estilo5">CLASIFICACI&Oacute;N DEL BENEFICIARIO :</span></td>
                 <td width="572"><span class="Estilo5"><input class="Estilo10" name="txtclasificacion" type="text" id="txtclasificacion" value="<?php echo $clasificacion?>" size="40" readonly>    </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="800">
               <tr>
                 <td width="103"><span class="Estilo5">TIPO DE ORDEN:</span></td>
                 <td width="76"><span class="Estilo5"> <input class="Estilo10" readonly name="txttipo_orden" type="text" id="txttipo_orden" value="<?php echo $tipo_orden?>" size="10">  </span></td>
                 <td width="30">&nbsp;</td>
                 <td width="569"><span class="Estilo5"> <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" value="<?php echo $des_tipo_orden?>" size="70" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="800">
               <tr>
                 <td width="70"><span class="Estilo5">BANCO :</span></td>
                 <td width="80"><span class="Estilo5"> <input class="Estilo10" name="txtgrupo_banco" type="text" id="txtgrupo_banco"  value="<?php echo $campo_str1?>" size="4" maxlength="3" readonly>   </span></td>
                 <td width="650"><span class="Estilo5"><input class="Estilo10" name="txtnombre_grupob" type="text" id="txtnombre_grupob"  value="<?php echo $nombre_grupob?>" size="100" maxlength="100" readonly>  </span></td>
                </tr>
             </table></td>
           </tr>		   
		   <tr>
             <td><table width="800">
               <tr>
			     <td width="150"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                 <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txtnro_cuenta" type="text" id="txtnro_cuenta"  value="<?php echo $campo_str2?>" size="30" maxlength="30" readonly> </span></td>
                 <td width="350"><span class="Estilo5"></span></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
                 </form>
       </div>

<form name="form2" method="post" action="Inc_beneficiario.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?php echo $host?>" ></td>
     <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?php echo $port?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
     <td width="5"><input class="Estilo10" name="txtregion_e" type="hidden" id="txtregion_e" value="<?php echo $reg_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtestado_e" type="hidden" id="txtestado_e" value="<?php echo $edo_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtmunicipio_e" type="hidden" id="txtmunicipio_e" value="<?php echo $mun_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtciudad_e" type="hidden" id="txtciudad_e" value="<?php echo $ciu_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcod_estado" type="hidden" id="txtcod_estado" value="<?php echo $cod_e?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtced_rif_c" type="hidden" id="txtced_rif_c" value="" ></td>
  </tr>
</table>
</form>
    </td>
  </tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>