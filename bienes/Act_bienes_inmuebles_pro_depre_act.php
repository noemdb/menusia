<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); $cod_modulo="13";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="02-0000035"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo = getenv("COMPUTERNAME"); $mcod_m="BIEN027".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $tipo_comp="ED001"; $sfecha=$Fec_Fin_Ejer; $tipo_causado='0004';
if (!$_GET){$p_letra="";$referencia_dep='';$sql="SELECT * FROM BIEN027 ORDER BY referencia_dep";  $codigo_mov=substr($mcod_m,0,49);} 
else {   $referencia_dep=$_GET["Greferencia_dep"];  $p_letra=substr($referencia_dep, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$referencia_dep=substr($referencia_dep,1,12);}  else{$referencia_dep=substr($referencia_dep,0,12);$codigo_mov=substr($mcod_m,0,49);}
  $clave=$referencia_dep;
  $sql="Select * from BIEN027 where referencia_dep='$referencia_dep' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN027 ORDER BY referencia_dep";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN027 Order by referencia_dep desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN027 Where (referencia_dep>'$clave') Order by referencia_dep";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN027 Where (referencia_dep<'$clave') Order by referencia_dep desc";}
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Depreciacion Bienes Inmuebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var Greferencia_dep= "";
function Llamar_Ventana(url){var murl;
    Greferencia_dep=document.form1.txtreferencia_dep.value;  murl=url+Greferencia_dep;
    if (Greferencia_dep=="")   {alert("referencia_dep debe ser Seleccionado");}   else {document.location = murl;}
}
function Llamar_Inc_Mov_Bien(){ document.form2.submit(); }
function Mover_Registro(MPos){var murl;
   murl="Act_bienes_inmuebles_pro_depre_act.php";
   if(MPos=="P"){murl="Act_bienes_inmuebles_pro_depre_act.php?Greferencia_dep=P"}
   if(MPos=="U"){murl="Act_bienes_inmuebles_pro_depre_act.php?Greferencia_dep=U"}
   if(MPos=="S"){murl="Act_bienes_inmuebles_pro_depre_act.php?Greferencia_dep=S"+document.form1.txtreferencia_dep.value;}
   if(MPos=="A"){murl="Act_bienes_inmuebles_pro_depre_act.php?Greferencia_dep=A"+document.form1.txtreferencia_dep.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar Depreciacion de Bienes Inmuebles?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar Depreciacion de Bienes Inmuebles?");
    if (r==true) {url="Delete_bienes_inmuebles_pro_movi_conta.php?Greferencia_dep="+document.form1.txtreferencia_dep.value+"&Gfecha_dep="+document.form1.txtfecha_dep.value; VentanaCentrada(url,'Eliminar Movimientos de Bienes Inmuebles','','400','400','true');}}
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
$resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");
$referencia_dep=""; $fecha_dep="";  $cod_dependencia=""; $descripcion=""; $denominacion_dep=""; $met_calculo="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){  if ($p_letra=="S"){$sql="SELECT * From BIEN027 ORDER BY referencia_dep";}  if ($p_letra=="A"){$sql="SELECT * From BIEN027 ORDER BY referencia_dep desc";}  $res=pg_query($sql);  $filas=pg_num_rows($res);}
if($filas>=0){  $registro=pg_fetch_array($res,0);$referencia_dep=$registro["referencia_dep"]; $met_calculo=$registro["met_calculo"];
  $fecha_dep=$registro["fecha_dep"]; $descripcion=$registro["descripcion"]; }
if($fecha_dep==""){$fecha_dep="";}else{$fecha_dep=formato_ddmmaaaa($fecha_dep);}
if($met_calculo=="A"){$met_calculo="ANUAL";}else{$met_calculo="MENSUAL";}
$clave=$referencia_dep; $criterio=$referencia_dep.$sfecha.$tipo_comp; $clavec=$referencia_dep.$tipo_causado;
$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){ $ced_rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
?>
<body>
<table width="998" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEPRECIACION DE BIENES INMUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="998" height="200" border="0" id="tablacuerpo">
  <tr>
      <td>
    <table width="92" height="200" border="1" cellpadding="0" cellspacing="0" id="tablam">
   <td width="95" height="280"><table width="92" height="200" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?if ($Mcamino{0}=="S"){?>
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
     <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <? }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
       </tr>
      
        <td height="200">&nbsp;</td>
      </tr>
    </table></td> </table>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
        <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:954px; height:523px; z-index:1; top: 73px; left: 133px;">
	      <table width="848" border="0" >
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="170"><span class="Estilo5">REFERENCIA DEPRECIACION:</span></td>
                 <td width="115"><input name="txtreferencia" type="text" id="txtreferencia" size="10" maxlength="8"  value="<?echo $referencia_dep?>" readonly class="Estilo5"> </td>
                 <td width="145"><span class="Estilo5">FECHA DEPRECIACION:</span></td>
                 <td width="120"><span class="Estilo5"><input name="txtfecha_dep" type="text" id="txtfecha_dep" size="14" maxlength="15"   value="<?echo $fecha_dep?>" readonly class="Estilo5"> </span></td>
                 <td width="165"><span class="Estilo5">CALCULAR DEPRECIACION:</span></td>
				 <td width="130"><span class="Estilo5"><input name="txtmet_calculo" type="text" id="txtmet_calculo" size="15" maxlength="15"   value="<?echo $met_calculo?>" readonly class="Estilo5"> </span></span></td>		
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
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:346px; z-index:2; left: 2px; top: 100px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Bienes";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Comprobantes";            // Requiere: <div id="T12" class="tab-body">  ... </div>
            </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_depreciaciones_bienes_inmu.php?criterio=<?echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>              
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_cons_comp_depreciaciones_bienes_inmu.php?criterio=<?echo $criterio?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
       </form>
      </div>
    </td>
</tr>
</table>

<form name="form2" method="post" action="Inc_bienes_inmuebles_pro_depre_act.php">
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
