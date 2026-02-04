<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); $cod_modulo="13";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="02-0000018"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
$equipo = getenv("COMPUTERNAME"); $mcod_m="BIEN045".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $tipo_comp="ED004"; $sfecha=$Fec_Fin_Ejer;
if (!$_GET){$p_letra="";$referencia_desin='';  $sql="SELECT * FROM BIEN045 ORDER BY referencia_desin";  } 
else{ $referencia_desin = $_GET["Greferencia_desin"];  $p_letra=substr($referencia_desin, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$referencia_desin=substr($referencia_desin,1,12);}  else{$referencia_desin=substr($referencia_desin,0,12);}
  $clave=$referencia_desin;
  $sql="Select * from BIEN045 where referencia_desin='$referencia_desin' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN045 ORDER BY referencia_desin";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN045 Order by referencia_desin desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN045 Where (referencia_desin>'$clave') Order by referencia_desin";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN045 Where (referencia_desin<'$clave') Order by referencia_desin desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Actualiza Desincorporacion de Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var Greferencia_desin= "";
function Llamar_Inc_Des_Bien(){ document.form2.submit(); }
function Llamar_Ventana(url){var murl;
    Greferencia_desin=document.form1.txtreferencia_desin.value; murl=url+Greferencia_desin;
    if (Greferencia_desin==""){alert("referencia_desin debe ser Seleccionado");}  else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_bienes_muebles_pro_desin_bie.php";
   if(MPos=="P"){murl="Act_bienes_muebles_pro_desin_bie.php?Greferencia_desin=P"}
   if(MPos=="U"){murl="Act_bienes_muebles_pro_desin_bie.php?Greferencia_desin=U"}
   if(MPos=="S"){murl="Act_bienes_muebles_pro_desin_bie.php?Greferencia_desin=S"+document.form1.txtreferencia_desin.value;}
   if(MPos=="A"){murl="Act_bienes_muebles_pro_desin_bie.php?Greferencia_desin=A"+document.form1.txtreferencia_desin.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar Acta de Desincorporacion de Bienes Muebles?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar Acta de Desincorporacion de Bienes Muebles?");
    if (r==true) {url="Delete_bienes_muebles_pro_desin_bie.php?Greferencia_desin="+document.form1.txtreferencia_desin.value+"&Gfecha_desin="+document.form1.txtfecha_desin.value+"&Gdes_desin="+document.form1.txttipo_desin.value; VentanaCentrada(url,'Eliminar Desincorporacion de Bienes Muebles','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}
function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Formato de Desincorporacion ?");
   if (r==true) {url="/sia/bienes/rpt/Rpt_formato_desincorporacion.php?Greferencia_desin="+document.form1.txtreferencia_desin.value;
    window.open(url);
  }
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
<?php 
$resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
$referencia_desin="";  $fecha_desin=""; $tipo_desin=""; $cod_dependencia=""; $descripcion="";$nombre1="";$departamento1=""; $nombre2="";$departamento2="";$denominacion_dep="";$denominacion_dir=""; $cod_departamento_r="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From BIEN045 ORDER BY referencia_desin";} if ($p_letra=="A"){$sql="SELECT * From BIEN045 ORDER BY referencia_desin desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>=0){  $registro=pg_fetch_array($res,0);
	$referencia_desin=$registro["referencia_desin"];	$fecha_desin=$registro["fecha_desin"]; $sfecha=$registro["fecha_desin"];	if($fecha_desin==""){$fecha_desin="";}else{$fecha_desin=formato_ddmmaaaa($fecha_desin);}
	$cod_dependencia=$registro["cod_dependencia"]; 	$tipo_desin=$registro["tipo_desin"]; 	$status=$registro["status"]; 	$cod_conta_desin=""; 	
	$cargo1=$registro["cargo1"]; $departamento1=$registro["departamento1"];	$nombre1=$registro["nombre1"]; 		$cargo2=$registro["cargo2"]; $departamento2=$registro["departamento2"]; $nombre2=$registro["nombre2"]; 
	$cargo3=$registro["cargo3"]; $departamento3=$registro["departamento3"]; $nombre3=$registro["nombre3"]; 	$campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];
	$observacion=$registro["observacion"]; $inf_usuario=$registro["inf_usuario"];$descripcion=$registro["descripcion"];
}
$clave=$referencia_desin; $criterio=$sfecha.$referencia_desin.$tipo_comp; $des_desin=""; $denominacion_dependencia="";
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dependencia=$registro["denominacion_dep"];}
/*
1- INSERVIBILIDAD - 056
2- FALTANTES POR INVESTIGAR - 060
3- VENTAS - 052
4 -DESARME - 055
5- DETERIORO - 057
6- DEMOLICION - 058
7- POR TRABAJO - 051
8- SUMINISTRO A OTRAS ENTIDADES - 054
9- POR DONACION - 062
0- OTROS CONCEPTOS - 067
*/
if($tipo_desin=='056'){ $des_desin="INSERVIBILIDAD"; }
if($tipo_desin=='060'){ $des_desin="FALTANTES POR INVESTIGAR"; }
if($tipo_desin=='052'){ $des_desin="VENTAS"; }
if($tipo_desin=='055'){ $des_desin="DESARME"; }
if($tipo_desin=='057'){ $des_desin="DETERIORO"; }
if($tipo_desin=='058'){ $des_desin="DEMOLICION"; }
if($tipo_desin=='051'){ $des_desin="POR TRABAJO"; }
if($tipo_desin=='054'){ $des_desin="SUMINISTRO A OTRAS ENTIDADES"; }
if($tipo_desin=='062'){ $des_desin="POR DONACION"; }
if($tipo_desin=='067'){ $des_desin="OTROS CONCEPTOS"; }
$cod_dep_t=""; $nom_dep_t=""; $ced_resp_p="";  $nom_resp_p=""; $cod_pos_t=""; $cod_reg_t=""; $cod_ent_t=""; $cod_mun_t=""; $cod_ciu_t=""; $cod_parro_t=""; $direccion_t=""; $ced_rif_emp="";
$Ssql="SELECT * FROM bien001 order by cod_dependencia"; $resultado=pg_query($Ssql); 
if ($registro=pg_fetch_array($resultado,0)){$cod_dep_t=$registro["cod_dependencia"]; $nom_dep_t=$registro["denominacion_dep"]; $ced_resp_p=$registro["ci_contacto"]; $nom_resp_p=$registro["nombre_contacto"]; 
$cod_reg_t=$registro["cod_region"]; $cod_ent_t=$registro["cod_entidad"]; $cod_mun_t=$registro["cod_municipio"]; $cod_ciu_t=$registro["cod_ciudad"]; $cod_parro_t=$registro["cod_parroquia"]; $direccion_t=$registro["direccion_dep"];  $cod_pos_t=$registro["cod_postal_dep"];}
$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){ $ced_rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$formato_bien=""; $long_num_bien=0; $periodo="01"; $campo502=""; $doc_caus_inm=""; $doc_caus_mue=""; $doc_caus_sem=""; $num_bien_unico="S";
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; 
$formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"];}
$num_bien_unico=substr($campo502,3,1);  $mod_solo_transf=substr($campo502,6,1);
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DESINCORPORACI&Oacute;N  BIENES MUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="976" height="600" border="0" id="tablacuerpo">
  <tr>  
   <td>
    <table width="92" height="600" border="1" cellpadding="0" cellspacing="0" id="tablam">
      <td width="86">
	    <td width="92" height="600"><table width="92" height="600" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">		

		 <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Des_Bien()";
					onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Des_Bien()">Incluir</A></td>
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
		 <?php } if (($Mcamino{4}=="S")and($SIA_Cierre=="N")){?>
			<tr>
			  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
			</tr>  
		 <?php } if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
				   onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
		  </tr>
		 <?php }?>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
		   </tr>      
		   <tr>
			<td >&nbsp;</td>
		   </tr>
		</table></td>
	</table>
    <p>&nbsp;</p></td>
    <td width="868"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
    <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:861px; height:523px; z-index:1; top: 74px; left: 121px;">
         <table width="848" border="0" align="center">
           <tr>
             <td><table width="845">
               <tr>
                 <td width="100"><span class="Estilo5">REFERENCIA :</span></td>
                 <td width="150"><input class="Estilo10" name="txtreferencia_desin" type="text" id="txtreferencia_desin" size="10" maxlength="8"  value="<?php echo $referencia_desin?>" readonly> </td>
                 <td width="100"><span class="Estilo5">FECHA :</span></td>
                 <td width="145"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desin" type="text" id="txtfecha_desin" size="15" maxlength="15"   value="<?php echo $fecha_desin?>" readonly> </span></td>
                 <td width="180"><span class="Estilo5">TIPO DESINCORPORACION :</span></td>				 
                 <td width="170"><span class="Estilo5"><input class="Estilo10" name="txttipo_desin" type="text" id="txttipo_desin" size="25" maxlength="25"   value="<?php echo $des_desin?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="145"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></td>
                 <td width="130"><span class="Estilo5"><input class="Estilo10" name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?php echo $cod_dependencia?>" readonly>    </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" value="<?php echo $denominacion_dependencia?>" readonly>    </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></td>
                 <td width="135"><span class="Estilo5"> <input class="Estilo10" name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4" value="<?php echo $cargo1?>" readonly>   </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="100" maxlength="100" value="<?php echo $departamento1?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtcod_departamento" type="text" id="txtcod_departamento" size="10" maxlength="8" value="<?php echo $cargo2?>" readonly>   </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="100"  value="<?php echo $departamento2?>" readonly>   </span></td>
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
        </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:346px; z-index:2; left: 2px; top: 190px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Bienes";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Comprobantes";            // Requiere: <div id="T12" class="tab-body">  ... </div>
            </script>
              <?php include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_desin_bienes.php?criterio=<?php echo $referencia_desin?>"  width="940" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>              
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body">
                <iframe src="Det_cons_comp_desin_bienes.php?criterio=<?php echo $criterio?>"  width="940" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
       </form>
   </td>
  </tr>
</table>


<form name="form2" method="post" action="Inc_bienes_muebles_pro_desin_bie.php">
<table width="100">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtformato_bien" type="hidden" id="txtformato_bien" value="<?php echo $formato_bien?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtlong_num_bien" type="hidden" id="txtlong_num_bien" value="<?php echo $long_num_bien?>" ></td>	 
     <td width="5"><input class="Estilo10" name="txtcod_dep" type="hidden" id="txtcod_dep" value="<?php echo $cod_dep_t?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnom_dep" type="hidden" id="txtnom_dep" value="<?php echo $nom_dep_t?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?php echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input class="Estilo10" name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?php echo $Cod_Emp?>" ></td> 
	 <td width="5"><input class="Estilo10" name="txtced_rif_emp" type="hidden" id="txtced_rif_emp" value="<?php echo $ced_rif_emp?>" ></td> 
  </tr>
</table>
</form>

</body>
</html>
