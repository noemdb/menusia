<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); $cod_modulo="13";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="02-0000025"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo = getenv("COMPUTERNAME"); $mcod_m="BIEN025".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $tipo_comp="EM001"; $sfecha=$Fec_Fin_Ejer;
if (!$_GET){$p_letra="";$referencia=''; $sql="SELECT * FROM BIEN025 ORDER BY referencia";} 
else {$referencia = $_GET["Greferencia"]; $p_letra=substr($referencia,0,1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$referencia=substr($referencia,1,12);} else{$referencia=substr($referencia,0,12);}
  $clave=$referencia;
  $sql="Select * from BIEN025 where referencia='$referencia' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN025 ORDER BY referencia";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN025 Order by referencia desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN025 Where (referencia>'$clave') Order by referencia";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN025 Where (referencia<'$clave') Order by referencia desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Movimientos Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Greferencia= "";
function Llamar_Inc_Mov_Bien(){ document.form2.submit(); }
function Mover_Registro(MPos){var murl;
   murl="Act_bienes_muebles_pro_movi_conta.php";
   if(MPos=="P"){murl="Act_bienes_muebles_pro_movi_conta.php?Greferencia=P"}
   if(MPos=="U"){murl="Act_bienes_muebles_pro_movi_conta.php?Greferencia=U"}
   if(MPos=="S"){murl="Act_bienes_muebles_pro_movi_conta.php?Greferencia=S"+document.form1.txtreferencia.value;}
   if(MPos=="A"){murl="Act_bienes_muebles_pro_movi_conta.php?Greferencia=A"+document.form1.txtreferencia.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar Movimientos de Bienes Muebles?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar Movimientos de Bienes Muebles?");
    if (r==true) {url="Delete_bienes_muebles_pro_movi_conta.php?Greferencia="+document.form1.txtreferencia.value+"&Gfecha="+document.form1.txtfecha.value; VentanaCentrada(url,'Eliminar Movimientos de Bienes Semovientes','','400','400','true');}}
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
$resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$referencia=""; $fecha=""; $sfecha="";  $cod_dependencia=""; $descripcion=""; $denominacion_dependencia=""; $status="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){  if ($p_letra=="S"){$sql="SELECT * From BIEN025 ORDER BY referencia";}  if ($p_letra=="A"){$sql="SELECT * From BIEN025 ORDER BY referencia desc";}  $res=pg_query($sql);  $filas=pg_num_rows($res);}
if($filas>=0){  $registro=pg_fetch_array($res,0);
$referencia=$registro["referencia"];$fecha=$registro["fecha"]; if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$cod_dependencia=$registro["cod_dependencia"]; $descripcion=$registro["descripcion"]; $sfecha=$registro["fecha"]; $status=$registro["status"];
} IF($status=="D"){$tipo_comp="EM001";}
$clave=$referencia.$sfecha; $criterio=$referencia.$sfecha.$tipo_comp;
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dependencia=$registro["denominacion_dep"];}

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
<table width="998" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MOVIMIENTOS DE BIENES MUEBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="998" height="230" border="0" id="tablacuerpo">
  <tr>
      <td>
    <table width="92" height="230" border="1" cellpadding="0" cellspacing="0" id="tablam">
   <td width="95" height="230"><table width="92" height="230" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
      <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Mov_Bien()";
					onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Mov_Bien()">Incluir</A></td>
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
     <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <? }?>
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
                 <td width="170"><span class="Estilo5">REFERENCIA MOVIMIENTO:</span></td>
                 <td width="150"><input name="txtreferencia" type="text" id="txtreferencia" size="10" maxlength="8"  value="<?echo $referencia?>" readonly class="Estilo5"> </td>
                 <td width="145"><span class="Estilo5">FECHA DEL MOVIMIENTO:</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" size="15" maxlength="15"   value="<?echo $fecha?>" readonly class="Estilo5"> </span></td>
                 <td width="180"><span class="Estilo5"></span></td>		
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></td>
                 <td width="135"><span class="Estilo5"><input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?echo $cod_dependencia?>" readonly class="Estilo5">    </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" value="<?echo $denominacion_dependencia?>" readonly class="Estilo5">    </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                 <td width="720"><div align="left"><textarea name="txtdescripcion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" readonly  class="headers" id="txtdescripcion"><?echo $descripcion?></textarea>  </div></td>
               </tr>
             </table></td>
           </tr>
        </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:346px; z-index:2; left: 2px; top: 140px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Bienes";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Comprobantes";            // Requiere: <div id="T12" class="tab-body">  ... </div>
            </script>
              <?include ("../class/class_tab.php");  ?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_movimientos_bienes_mue.php?criterio=<?echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>              
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_cons_comp_movimientos_bienes_mue.php?criterio=<?echo $criterio ?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>

<form name="form2" method="post" action="Inc_bienes_muebles_pro_movi_conta.php">
<table width="100">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>	 
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
	 <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtformato_bien" type="hidden" id="txtformato_bien" value="<?echo $formato_bien?>" ></td>
	 <td width="5"><input name="txtlong_num_bien" type="hidden" id="txtlong_num_bien" value="<?echo $long_num_bien?>" ></td>	 
     <td width="5"><input name="txtcod_dep" type="hidden" id="txtcod_dep" value="<?echo $cod_dep_t?>" ></td>
     <td width="5"><input name="txtnom_dep" type="hidden" id="txtnom_dep" value="<?echo $nom_dep_t?>" ></td>	 
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $Cod_Emp?>" ></td> 
	 <td width="5"><input name="txtced_rif_emp" type="hidden" id="txtced_rif_emp" value="<?echo $ced_rif_emp?>" ></td> 
  </tr>
</table>
</form>

</body>
</html>
<? pg_close();?>