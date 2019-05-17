<?include ("../class/seguridad.inc"); include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php");  include ("../class/configura.inc");
$equipo=getenv("COMPUTERNAME"); $mcod_m="COMP017".$usuario_sia.$equipo; $fecha_hoy=asigna_fecha_hoy();
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103, campo104 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; $modulo="09";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $Nom_usuario=$registro["campo104"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="09"; $opcion="02-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){ $p_letra='';$criterio=''; $nro_analisis=''; $sql="SELECT * FROM ANALISIS_ART ORDER BY nro_analisis desc";  $codigo_mov=substr($mcod_m,0,49); }
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $nro_analisis=substr($criterio,1,8);}
   else{$nro_analisis=substr($criterio,0,8); } $codigo_mov=substr($mcod_m,0,49);   $clave=$nro_analisis;
  $sql="Select * from ANALISIS_ART where nro_analisis='$nro_analisis'";
  if ($p_letra=="P"){$sql="SELECT * FROM ANALISIS_ART Order by nro_analisis";}
  if ($p_letra=="U"){$sql="SELECT * From ANALISIS_ART Order by nro_analisis desc";}
  if ($p_letra=="S"){$sql="SELECT * From ANALISIS_ART Where nro_analisis>'$clave') Order by nro_analisis";}
  if ($p_letra=="A"){$sql="SELECT * From ANALISIS_ART Where nro_analisis<'$clave') Order by nro_analisis";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA COMPRAS Y ALMAC&Eacute;N (Analisis Cotizaciones de Art&iacute;culos)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url,maprob){var murl;
var Gnro_analisis=document.form1.txtnro_analisis.value;  murl=url+Gnro_analisis;
    document.location = murl;
}
function Llamar_Inc_Orden(mop){if(mop=='D'){ document.form2.submit(); }}
function Mover_Registro(MPos){var murl;
   murl="Act_Analisis_art.php";
   if(MPos=="P"){murl="Act_Analisis_art.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_Analisis_art.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_Analisis_art.php?Gcriterio=S"+document.form1.txtnro_analisis.value;}
   if(MPos=="A"){murl="Act_Analisis_art.php?Gcriterio=A"+document.form1.txtnro_analisis.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar el Analisis ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Analisis ?");
    if (r==true) {url="Delete_analisis.php?txtnro_analisis="+document.form1.txtnro_analisis.value;
       VentanaCentrada(url,'Eliminar Analisis','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
  
}
function Llamar_Formato(maprobado){var url;var r; var a=0;
 if(a==0){r=confirm("Desea Generar el Formato Analisis ?");
   if (r==true) {url="/sia/compras/rpt/Formato_anlisis_art.php?txtnro_analisis="+document.form1.txtnro_analisis.value;  window.open(url); }
 }
}
function Llamar_Solicitud(maprobado){var url; url="Llama_sol_cot.php?txtnro_analisis="+document.form1.txtnro_analisis.value;  window.open(url); }
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
if ($codigo_mov==""){$codigo_mov="";}else{
 $res=pg_exec($conn,"SELECT BORRAR_COMP042('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
}$mconf="";$Ssql="Select * from SIA005 where campo501='05'";$resultado=pg_query($Ssql);
if($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"];}$nro_aut=substr($mconf,1,1); $fecha_aut=substr($mconf,2,1); $aprueba_comp=substr($mconf,15,1);
$mconf="";$tipo_ordc="0001"; $cod_tipoc="000001"; $nomb_a_ordc="O/C"; $cod_imp_unico="S"; $cod_imp_part="S"; $cod_part_iva="403-18-01-00"; $mconf73="";
$Ssql="Select * from SIA005 where campo501='09'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $mconf73=$registro["campo573"]; $tipo_ordc=$registro["campo504"]; $cod_tipoc=$registro["campo507"]; $cod_part_iva=$registro["campo509"]; }
$valida_requis=substr($mconf,1,1); $valida_req_aprobada=substr($mconf,2,1); $nro_aut=substr($mconf,3,1); $fecha_aut=substr($mconf,4,1); $modifc_presup=substr($mconf,7,1); $cod_imp_unico=substr($mconf73,1,1); $cod_imp_part=substr($mconf73,2,1);
$nro_requisicion=""; $fecha_analisis=""; $fecha_solicitud_coti=""; $inf_usuario=""; $status=""; $descripcion="";
$res=pg_query($sql); $filas=pg_num_rows($res);if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM ANALISIS_ART Order by nro_analisis";}  if ($p_letra=="S"){$sql="SELECT * From ANALISIS_ART Order by nro_analisis desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){$registro=pg_fetch_array($res);
  $nro_analisis=$registro["nro_analisis"];   $nro_requisicion=$registro["nro_requisicion"];
  $fecha_analisis=$registro["fecha_analisis"]; $fecha_solicitud_coti=$registro["fecha_solicitud_coti"];  $status=$registro["status"]; 
  $descripcion=$registro["descripcion"]; $inf_usuario=$registro["inf_usuario"];
} $clave=$nro_analisis;
if($fecha_analisis==""){$fecha_analisis="";}else{$fecha_analisis=formato_ddmmaaaa($fecha_analisis);}
if($fecha_solicitud_coti==""){$fecha_solicitud_coti="";}else{$fecha_solicitud_coti=formato_ddmmaaaa($fecha_solicitud_coti);}
?>
<body>

<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ANALISIS COTIZACIONES  ART&Iacute;CULOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="543" border="0" id="tablacuerpo">
  <tr>
    <td><div id="Layer2" style="position:absolute; width:102px; height:434px; z-index:2; top: 61px; left: 7px;">
      <table width="92" height="524" border="1" cellpadding="0" cellspacing="0" id="tablam">
        <td width="86">
            <td>
              <table width="92" height="522" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
			    <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Orden('D')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Orden('D')">Incluir</A></td>
                </tr>
				<?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
                <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Modifica_Anal_Art.php?Gnro_analisis=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Modifica_Anal_Art.php?Gnro_analisis=');">Modificar</A></td>
				</tr>
				<?} if ($Mcamino{2}=="S"){?> 
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
                </tr>
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
                </tr><tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
        </tr>
        <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
        </tr>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_analisis_art.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_analisis_art.php" class="menu">Catalogo</a></td>
        </tr>
        <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar('<?echo $aprobado?>');" class="menu">Eliminar</a></td>
        </tr>
		<?} if ($Mcamino{4}=="S"){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato('<?echo $aprobado?>');" class="menu">Formato Analisis</a></td>
        </tr>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Solicitud('<?echo $aprobado?>');" class="menu">Solicitud de Cotizacion</a></td>
        </tr>    
        <?}?>		
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
            </table></td>
      </table>
    </div>
    <p>&nbsp;</p></td><td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:866px; height:532px; z-index:1; top: 67px; left: 118px;">
            <form name="form1" method="post">
              <table width="868" align="center">                
				<tr>
                  <td width="865"><table width="861" border="0" cellspacing="1" cellpadding="0">
                    <tr>
                      <td width="151"><span class="Estilo5">N&Uacute;MERO DE ANALISIS  :</span></span></td>
                      <td width="117"><span class="Estilo5"> <input name="txtnro_analisis" type="text" class="Estilo5" id="txtnro_analisis"  value="<?echo $nro_analisis ?>" size="10" maxlength="8" readonly>  </span></td>
                      <td width="231"><span class="Estilo5">FECHA SOLICITUD COTIZACIONES :</span></span></td>
                      <td width="115"><span class="Estilo5"><input name="txtfecha_solicitud_coti" type="text" class="Estilo5" id="txtfecha_solicitud_coti"  value="<?echo $fecha_solicitud_coti ?>" size="11" maxlength="11" readonly>  </span></td>
                      <td width="121"><span class="Estilo5">FECHA ANALISIS   :</span></span></td>
                      <td width="88"><span class="Estilo5"><input name="txtfecha_analisis" type="text" class="Estilo5" id="txtfecha_analisis"  value="<?echo $fecha_analisis ?>" size="11" maxlength="11" readonly> </span></td>
                      <td width="30"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                     
                    </tr>
                  </table></td>
                </tr>
				 <tr>
                  <td height="24"><table width="861" border="0" cellspacing="1" cellpadding="0">
                    <tr>
                      <td width="85"><span class="Estilo5">CONCEPTO : </span></span></td>
                      <td width="767"><span class="Estilo5"><textarea name="txtdescripcion" cols="117" readonly="readonly" class="Estilo5" id="txtdescripcion"><?echo $descripcion ?></textarea>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="861" border="0" cellspacing="1" cellpadding="0">
                    <tr>
                      <td width="157"><span class="Estilo5">REQUISICI&Oacute;N NUMERO : </span></span></td>
                      <td width="643"><span class="Estilo5"><input name="txtnro_requisicion" type="text" class="Estilo5" id="txtnro_requisicion"  value="<?echo $nro_requisicion ?>" size="10" maxlength="8" readonly>  </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                
          </table>
         <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:320px; z-index:2; left: 2px; top: 120px;">
   <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 3;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Articulos";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Cotizaciones"; 
   rows[1][3] = "Resultados"; 
   </script>
   <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTAÑA 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_art_anal.php?criterio=<?echo $clave?>"  width="846" height="320" scrolling="auto" frameborder="0"> </iframe>
              </div> 
			  <!-- PESTAÑA 2 --> 
              <div id="T12" class="tab-body" >
                <iframe src="Det_cons_cot_anal.php?criterio=<?echo $clave?>"  width="846" height="320" scrolling="auto" frameborder="0"> </iframe>
              </div> 	
               <!-- PESTAÑA 3 --> 
              <div id="T13" class="tab-body" >
                <iframe src="Det_cons_res_anal.php?criterio=<?echo $clave?>"  width="846" height="320" scrolling="auto" frameborder="0"> </iframe>
              </div> 				  
            </div></td>
         </tr>
        </table>
                
        </form>
<form name="form2" method="post" action="Inc_Analisis_art.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtcod_imp_unico" type="hidden" id="txtcod_imp_unico" value="<?echo $cod_imp_unico?>" ></td>
     <td width="5"><input name="txtcod_imp_part" type="hidden" id="txtcod_imp_part" value="<?echo $cod_imp_part?>" ></td>
     <td width="5"><input name="txtcod_part_iva" type="hidden" id="txtcod_part_iva" value="<?echo $cod_part_iva?>" ></td>
	 <td width="5"><input name="txtnro_anal" type="hidden" id="txtnro_anal" value="" ></td>
     <td width="5"><input name="txtasig_anal" type="hidden" id="txtasig_anal" value="S" ></td>
     <td width="5"><input name="txtfecha_anal" type="hidden" id="txtfecha_anal" value="<?echo $fecha_hoy?>" ></td>
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>	 
     <td width="5"><input name="txtnro_req_anal" type="hidden" id="txtnro_req_anal" value="" ></td>
	 <td width="5"><input name="txtconcep" type="hidden" id="txtconcep" value="" ></td>	 
     <td width="5"><input name="txtfecha_sol" type="hidden" id="txtfecha_sol" value="<?echo $fecha_hoy?>" ></td>   	 
  </tr>
</table>
</form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
