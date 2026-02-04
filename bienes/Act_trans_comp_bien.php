<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); $cod_modulo="13";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="02-0000016"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
$equipo = getenv("COMPUTERNAME"); $mcod_m="BIEN054".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); 
if (!$_GET){$p_letra="";$referencia_transf_c='';  $sql="SELECT * FROM BIEN054 ORDER BY referencia_transf_c";  } 
else{ $referencia_transf_c = $_GET["Greferencia_transf_c"];  $p_letra=substr($referencia_transf_c, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$referencia_transf_c=substr($referencia_transf_c,1,8);}
   else{$referencia_transf_c=substr($referencia_transf_c,0,8);} $clave=$referencia_transf_c;
  $sql="Select * from BIEN054 where referencia_transf_c='$referencia_transf_c' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN054 ORDER BY referencia_transf_c";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN054 Order by referencia_transf_c desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN054 Where (referencia_transf_c>'$clave') Order by referencia_transf_c";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN054 Where (referencia_transf_c<'$clave') Order by referencia_transf_c desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Transferencia de Componentes)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" type="text/Javascript">
var Greferencia_transf_c = "";
function Llamar_Inc_Mov_Bien(){ document.form2.submit(); }
function Llamar_Ventana(url){var murl;
    Greferencia_transf_c=document.form1.txtreferencia_transf_c.value;    murl=url+Greferencia_transf_c;
    if (Greferencia_transf_c==""){alert("Referencia debe ser Seleccionada");}    else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_trans_comp_bien.php";
   if(MPos=="P"){murl="Act_trans_comp_bien.php?Greferencia_transf_c=P"}
   if(MPos=="U"){murl="Act_trans_comp_bien.php?Greferencia_transf_c=U"}
   if(MPos=="S"){murl="Act_trans_comp_bien.php?Greferencia_transf_c=S"+document.form1.txtreferencia_transf_c.value;}
   if(MPos=="A"){murl="Act_trans_comp_bien.php?Greferencia_transf_c=A"+document.form1.txtreferencia_transf_c.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar Transferencias de Componentes?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar Transferencias de Componentes ?");
    if (r==true) { url="Delete_trasnf_componentes.php?Greferencia_transf_c="+document.form1.txtreferencia_transf_c.value; 
	VentanaCentrada(url,'Eliminar Transferencias de Componentes','','400','400','true');}  }
   else { url="Cancelado, no elimino"; }
}
function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Formato de Transferencias ?");
   if (r==true) {url="/sia/bienes/rpt/Rpt_formato_transf_componentes.php?Greferencia_transf_c="+document.form1.txtreferencia_transf_c.value;
    window.open(url);
  }
}
</script>
<script language="JavaScriptsrc"="../class/sia.js" type="text/javascript"></script>
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
$resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); 
$referencia_transf_c=""; $fecha_transf=""; $tipo_transferencia=""; $cod_dependencia_r=""; $cod_empresa_r=""; $cod_direccion_r=""; $cod_departamento_r=""; $tipo_movimiento_r="";  $cod_dependencia_e="";$cod_empresa_e=""; $cod_direccion_e=""; $cod_departamento_e="";     $tipo_movimiento_e=""; $ced_responsable=""; $ced_responsable_uso=""; $ced_rotulador=""; $ced_verificador=""; $departamento_r=""; $nombre_r=""; $departamento_e=""; $nombre_e=""; $cargo1=""; $departamento1=""; $nombre1=""; $referencia_mov_e=""; $referencia_mov_r="";    $campo_str1="";$campo_str2=""; $observacion=""; $usuario_sia=""; $inf_usuario=""; $descripcion="";  $denominacion_empresa_e="";$denominacion_dependen_e=""; $denominacion_dir_e=""; $denominacion_dep_e="";$denominacion_empresa_r=""; $denominacion_dependen_r=""; $denominacion_dir_r=""; $denominacion_dep_r=""; $nombre_res=""; $nombre_res_uso=""; 
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){ if ($p_letra=="S"){$sql="SELECT * From BIEN054 ORDER BY referencia_transf_c";} if ($p_letra=="A"){$sql="SELECT * From BIEN054 ORDER BY referencia_transf_c desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>=0){ $registro=pg_fetch_array($res,0); $referencia_transf_c=$registro["referencia_transf_c"]; $fecha_transf=$registro["fecha_transf_c"]; 
  $tipo_transferencia=$registro["tipo_transferencia_c"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];$inf_usuario=$registro["inf_usuario"];$descripcion=$registro["descripcion"];
  $departamento_r=$registro["departamento_r"]; $nombre_r=$registro["nombre_r"]; $departamento_e=$registro["departamento_e"]; $nombre_e=$registro["nombre_e"];
}
$clave=$referencia_transf_c; 
if($fecha_transf==""){$fecha_transf="";}else{$fecha_transf=formato_ddmmaaaa($fecha_transf);}
if($tipo_transferencia=="E"){$tipo_transferencia="EXTERNA";}if($tipo_transferencia=="I"){$tipo_transferencia="INTERNA";}
if($tipo_transferencia=="P"){$tipo_transferencia="PRESTAMO";}
if($tipo_transferencia=="C"){$tipo_transferencia="CESION";}
if($tipo_transferencia=="M"){$tipo_transferencia="MANTENIMIENTO";}
if($tipo_transferencia=="D"){$tipo_transferencia="DESINCORPORACION";}
if($tipo_transferencia=="T"){$tipo_transferencia="CAMBIO DE ESTADO";}
?>
<body>
<table width="998" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">TRANSFERENCIAS COMPONENTES DE BIENES MUEBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="998" height="560" border="0" id="tablacuerpo">
  <tr>
      <td>
    <table width="92" height="560" border="1" cellpadding="0" cellspacing="0" id="tablam">
   <td width="95" height="560"><table width="92" height="560" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
      <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Mov_Bien()";
					onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Mov_Bien()">Incluir</A></td>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_Act_trans_comp_bien.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_Act_trans_comp_bien.php" class="menu">Catalogo</a></td>
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
        <td>&nbsp;</td>
      </tr>
    </table></td> </table>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:954px; height:523px; z-index:1; top: 73px; left: 133px;">	     
         <table width="848" border="0" >
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="160"><span class="Estilo5">REFERENCIA MOVIMIENTO:</span></td>
                 <td width="130"><input name="txtreferencia_transf_c" type="text" id="txtreferencia_transf_c" size="10" maxlength="8"  value="<?php echo $referencia_transf_c?>" readonly class="Estilo5"> </td>
                 <td width="150"><span class="Estilo5">FECHA DEL MOVIMIENTO:</span></td>
                 <td width="125"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" size="15" maxlength="15"   value="<?php echo $fecha_transf?>" readonly class="Estilo5"> </span></td>
                 <td width="160"><span class="Estilo5">TIPO DE TRANSFERENCIA:</span></td>
                 <td width="120"><span class="Estilo5"><input name="txttipo_transferencia" type="text" id="txttipo_transferencia" size="25" maxlength="20"   value="<?php echo $tipo_transferencia?>" readonly class="Estilo5"> </span></td>
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
             <td><span class="Estilo10"><strong>DEPENDENCIA EMISORA</strong></span></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">NOMBRE RESPONSABLE :</span></td>
                 <td width="690"><span class="Estilo5"><input name="txtnombre_e" type="text" id="txtnombre_e" size="100" maxlength="100"  value="<?php echo $nombre_e?>" readonly class="Estilo5">   </span></td>
               </tr>
             </table></td>
           </tr> 
		   <tr>
             <td><span class="Estilo10"><strong>DEPENDENCIA RECEPTORA</strong></span></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">NOMBRE RESPONSABLE :</span></td>
                 <td width="690"><span class="Estilo5"><input name="txtnombre_r" type="text" id="txtnombre_r" size="100" maxlength="100"  value="<?php echo $nombre_r?>" readonly class="Estilo5">   </span></td>
               </tr>
             </table></td>
           </tr> 
		   <tr>
			<td >&nbsp;</td>
		  </tr>
         </table> 
          <iframe src="Det_transf_comp_bienes.php?criterio=<?php echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
          </iframe>
         <p>&nbsp;</p>
       </div>
         </form>
    </td>
  </tr>
</table>
<form name="form2" method="post" action="Inc_trans_comp_bien.php">
<table width="100">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>	 
	 <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>	 	 
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?php echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?php echo $Cod_Emp?>" ></td> 
	 <td width="5"><input name="txtced_rif_emp" type="hidden" id="txtced_rif_emp" value="<?php echo $ced_rif_emp?>" ></td> 
  </tr>
</table>
</form>
</body>
</html>
<?php  pg_close($conn);?>