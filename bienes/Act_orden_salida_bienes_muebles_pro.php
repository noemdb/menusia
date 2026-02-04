<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); $cod_modulo="13"; $ced_rif_emp="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="02-0000017"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
$equipo=getenv("COMPUTERNAME"); $mcod_m="BIEN043".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $tipo_comp="EM001"; $sfecha=$Fec_Fin_Ejer;
if (!$_GET){$p_letra="";$referencia=''; $sql="SELECT * FROM BIEN043 ORDER BY referencia";} 
else {$referencia = $_GET["Greferencia"]; $p_letra=substr($referencia,0,1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$referencia=substr($referencia,1,8);} else{$referencia=substr($referencia,0,8);}
  $clave=$referencia;
  $sql="Select * from BIEN043 where referencia='$referencia' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN043 ORDER BY referencia";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN043 Order by referencia desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN043 Where (referencia>'$clave') Order by referencia";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN043 Where (referencia<'$clave') Order by referencia desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">

<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Actualiza Orden de Salida Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Greferencia= "";

function Llamar_Inc_Mov_Bien(){ document.form2.submit(); }
function Llamar_Ventana(url){var murl;
    Greferencia=document.form1.txtreferencia.value;  murl=url+Greferencia;
    if (Greferencia=="") {alert("Referencia debe ser Seleccionado");}     else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_orden_salida_bienes_muebles_pro.php";
   if(MPos=="P"){murl="Act_orden_salida_bienes_muebles_pro.php?Greferencia=P"}
   if(MPos=="U"){murl="Act_orden_salida_bienes_muebles_pro.php?Greferencia=U"}
   if(MPos=="S"){murl="Act_orden_salida_bienes_muebles_pro.php?Greferencia=S"+document.form1.txtreferencia.value;}
   if(MPos=="A"){murl="Act_orden_salida_bienes_muebles_pro.php?Greferencia=A"+document.form1.txtreferencia.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar la Orden de Salida de Bienes Muebles?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar Orden de Salida de Bienes Muebles?");
    if (r==true) {url="Delete_orden_salida_bienes_muebles_pro.php?Greferencia="+document.form1.txtreferencia.value; VentanaCentrada(url,'Eliminar Orden de Salida de Bienes Muebles','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}

function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Formato Orden de Salida ?");
   if (r==true) {url="/sia/bienes/rpt/Rpt_formato_orden_salida.php?Greferencia="+document.form1.txtreferencia.value;
    window.open(url);
  }
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

$resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }

$referencia=""; $fecha=""; $tipo_salida=""; $cod_dependencia=""; $descripcion="";$nombre1="";$departamento1=""; $nombre2="";$departamento2=""; $denominacion_dep="";  
$res=pg_query($sql);$filas=pg_num_rows($res);if ($filas==0){ if ($p_letra=="S"){$sql="SELECT * From BIEN043 ORDER BY referencia";}  if ($p_letra=="A"){$sql="SELECT * From BIEN043 ORDER BY referencia desc";}  $res=pg_query($sql);  $filas=pg_num_rows($res);}
if($filas>=0){  $registro=pg_fetch_array($res,0);
$referencia=$registro["referencia"];$fecha=$registro["fecha"]; $tipo_salida=$registro["tipo_salida"];
$descripcion=$registro["descripcion"];  $cod_dependencia=$registro["cod_dependencia"]; 
$nombre1=$registro["nombre1"]; $departamento1=$registro["departamento1"]; 
$nombre2=$registro["nombre2"]; $departamento2=$registro["departamento2"]; 
}
$clave=$referencia; $des_tipo_salida="";
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dep=$registro["denominacion_dep"];}
if($tipo_salida=="1"){$des_tipo_salida="ORDEN POR REPARACION";}
if($tipo_salida=="2"){$des_tipo_salida="DONACION";}
if($tipo_salida=="3"){$des_tipo_salida="RETORNO A PROVEEDOR";}
if($tipo_salida=="4"){$des_tipo_salida="TRASLADO POR REPARACION";}
if($tipo_salida=="5"){$des_tipo_salida="PUNTO CUENTA DONACION";}
if($tipo_salida=="6"){$des_tipo_salida="COMODATO";}
if($tipo_salida=="7"){$des_tipo_salida="PARA USO DE LA DEPENDENCIA";}
$cod_dep_t=""; $nom_dep_t=""; $ced_resp_p="";  $nom_resp_p=""; $cod_pos_t=""; $cod_reg_t=""; $cod_ent_t=""; $cod_mun_t=""; $cod_ciu_t=""; $cod_parro_t=""; $direccion_t=""; $ced_rif_emp="";
$Ssql="SELECT * FROM bien001 order by cod_dependencia"; $resultado=pg_query($Ssql); 
if ($registro=pg_fetch_array($resultado,0)){$cod_dep_t=$registro["cod_dependencia"]; $nom_dep_t=$registro["denominacion_dep"]; $ced_resp_p=$registro["ci_contacto"]; $nom_resp_p=$registro["nombre_contacto"]; 
$cod_reg_t=$registro["cod_region"]; $cod_ent_t=$registro["cod_entidad"]; $cod_mun_t=$registro["cod_municipio"]; $cod_ciu_t=$registro["cod_ciudad"]; $cod_parro_t=$registro["cod_parroquia"]; $direccion_t=$registro["direccion_dep"];  $cod_pos_t=$registro["cod_postal_dep"];}
$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){ $ced_rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
?>
<body>
<table width="998" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ORDEN DE SALIDA  BIENES MUEBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="998" height="230" border="0" id="tablacuerpo">
  <tr>
      <td>
    <table width="92" height="230" border="1" cellpadding="0" cellspacing="0" id="tablam">
   <td width="95" height="230"><table width="92" height="230" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
      <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Mov_Bien()";
					onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Mov_Bien()">Incluir</A></td>
	  </tr> 
    <?php } if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Retornar_orden_salida_bienes_muebles.php?Greferencia=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Retornar_orden_salida_bienes_muebles.php?Greferencia=');">Retornar</A></td>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_Act_bienes_muebles_ord_salida_bie.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_Act_bienes_muebles_ord_salida_bie.php" class="menu">Catalogo</a></td>
      </tr>
     <?php } if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <?php } if (($Mcamino{4}=="S")and($SIA_Cierre=="N")){?>
			<tr>
			  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
			</tr> 
	 <?php } ?>	
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
       </tr>
      
        <td height="230">&nbsp;</td>
      </tr>
    </table></td> </table>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:954px; height:523px; z-index:1; top: 73px; left: 133px;">	     
         <table width="848" border="0" >
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="120"><span class="Estilo5">REFERENCIA :</span></td>
                 <td width="130"><input class="Estilo10" name="txtreferencia" type="text" id="txtreferencia" size="10" maxlength="8"  value="<?php echo $referencia?>" readonly> </td>
                 <td width="100"><span class="Estilo5">FECHA :</span></td>
                 <td width="145"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="15" maxlength="15"   value="<?php echo $fecha?>" readonly> </span></td>
                 <td width="120"><span class="Estilo5">TIPO DE SALIDA :</span></td>
                 <td width="230"><span class="Estilo5"><input class="Estilo10" name="txttipo_salida" type="text" id="txttipo_salida" size="30" maxlength="30"   value="<?php echo $des_tipo_salida?>" readonly> </span></td>
                	
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></td>
                 <td width="135"><span class="Estilo5"><input class="Estilo10" name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?php echo $cod_dependencia?>" readonly>    </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" value="<?php echo $denominacion_dep?>" readonly>    </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                 <td width="720"><div align="left"><textarea name="txtdescripcion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" readonly  class="headers" id="txtdescripcion"><?php echo $descripcion?></textarea>  </div></td>
               </tr>
             </table></td>
           </tr>
        <tr>
			<td >&nbsp;</td>
		  </tr>
         </table> 
          <iframe src="Det_cons_ord_sal_bienes_muebles.php?criterio=<?php echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
          </iframe>
         <p>&nbsp;</p>
       </div>
         </form>
    </td>
  </tr>
</table>
<form name="form2" method="post" action="Inc_orden_salida_bienes_muebles_pro.php">
<table width="100">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
     <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?php echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?php echo $host?>" ></td>	 
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>	 	 
     <td width="5"><input class="Estilo10" name="txtcod_dep" type="hidden" id="txtcod_dep" value="<?php echo $cod_dep_t?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnom_dep" type="hidden" id="txtnom_dep" value="<?php echo $nom_dep_t?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?php echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input class="Estilo10" name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?php echo $Cod_Emp?>" ></td>
     <td width="5"><input class="Estilo10" name="txtced_rif_emp" type="hidden" id="txtced_rif_emp" value="<?php echo $Rif_Emp?>" ></td>	 
  </tr>
</table>
</form>

</body>
</html>
<?php  pg_close($conn);?>