<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");
$equipo = getenv("COMPUTERNAME"); $mcod_m="CON012".$usuario_sia.$equipo;
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="02-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$p_letra='';  $criterio='';  $referencia='';  $fecha=''; $tipo_comp='';
  $sql="SELECT * from CON012 ORDER BY fecha_mov";   $codigo_mov=substr($mcod_m,0,49);
} else {   $codigo_mov="";   $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){ $referencia=substr($criterio,11,8); $fecha=substr($criterio,1,10);   $tipo_comp=substr($criterio,19,5);}
   else{$fecha=substr($criterio,0,10); $tipo_comp=''; $referencia='';  $codigo_mov=substr($mcod_m,0,49); }
  if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}  $clave=$sfecha.$referencia.$tipo_comp;
  $sql="Select * from CON012 where text(fecha_mov)='$sfecha' ";
  if ($p_letra=="P"){$sql="SELECT * from CON012 Order by fecha_mov";}
  if ($p_letra=="U"){$sql="SELECT * from CON012 Order by fecha_mov desc";}
  if ($p_letra=="S"){$sql="SELECT * from CON012 Where (text(fecha_mov)>'$clave') Order by fecha_mov";}
  if ($p_letra=="A"){$sql="SELECT * from CON012 Where (text(fecha_mov)<'$clave') Order by fecha_mov desc";}
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../class/imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Interfaz Contable/Cobranza)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css  rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">

function Mover_Registro(MPos){var murl;
   murl="Act_int_contab.php";
   if(MPos=="P"){murl="Act_int_contab.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_int_contab.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_int_contab.php?Gcriterio=S"+document.form1.txtFecha.value;}
   if(MPos=="A"){murl="Act_int_contab.php?Gcriterio=A"+document.form1.txtFecha.value;}
   document.location = murl;
}

function Llama_Eliminar(){var url;  var r;
  r=confirm("Esta seguro en Eliminar la Interfaz Contable de la Fecha ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Interfaz Contable ?");
    if (r==true){ url="Delete_int_contab.php?txtFecha="+document.form1.txtFecha.value;
       VentanaCentrada(url,'Eliminar Interfaz Contable','','400','400','true');}
    }else { url="Cancelado, no elimino"; }  
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
$res=pg_exec($conn,"SELECT ELIMINA_CON016('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$resultado=pg_exec($conn,"SELECT ELIMINA_CON014('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$resultado=pg_exec($conn,"SELECT ELIMINA_BAN034('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$resultado=pg_exec($conn,"SELECT ACTUALIZA_INGRE004(4,'$codigo_mov','','',0,0,0)"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$descripcion="";$fecha_reg=""; $status=""; $nusuario_sia=""; $res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * from CON012 Order by fecha_mov";}  if ($p_letra=="S"){$sql="SELECT * from CON012 Order by fecha_mov desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){ $registro=pg_fetch_array($res); $fecha_reg=$registro["fecha_gen_mov"]; $fecha=$registro["fecha_mov"]; $nusuario_sia=$registro["usuario_sia"]; $status=$registro["status"]; $descripcion=$registro["descripcion"]; }
if($fecha==""){$sfecha="";}else{$fecha=formato_ddmmaaaa($fecha);} if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
if($fecha_reg==""){$rfecha="";}else{$fecha_reg=formato_ddmmaaaa($fecha_reg);} 
$clave=$sfecha.$referencia.$tipo_comp;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INTERFAZ CONTABLE/COBRANZA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="528" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="508" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
    <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>    
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_int_contab.php?codigo_mov=<?echo $codigo_mov?>&nusuario_sia=<?echo $usuario_sia?> ')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_int_contab.php?codigo_mov=<?echo $codigo_mov?>&nusuario_sia=<?echo $usuario_sia?>">Incluir</A></td>
      </tr>	
	<?} if ($Mcamino{2}=="S"){?>  
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_int_cont.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_int_cont.php" class="menu">Catalogo</a></td>
  </tr> 
  <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
  </tr>
  <?}?>  
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu Principal </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:1098px; height:526px; z-index:1; top: 60px; left: 114px;">
            <form name="form1" method="post">
        <table width="868" border="0">
            
            <tr>
              <td colspan="3"><table width="860" border="0">
                <tr>
                  <td width="200"><span class="Estilo5">FECHA : <input name="txtFecha" type="text" id="txtFecha" value="<?echo $fecha?>" size="12" readonly></span></td>
                  <td width="260"><span class="Estilo5">FECHA REGISTRO :</span> <input name="txtFecha_reg" type="text"  id="txtFecha_reg" value="<?echo $fecha_reg?>" size="12" readonly> </td>
                  <td width="200"><span class="Estilo5">STATUS:</span> <input name="txtstatus" id="txtstatus" value="<?echo $status?>" size="1" readonly></td>
				  <td width="200"><span class="Estilo5">USUARIO:</span> <input name="txtusuario_sia" id="txtusuario_sia" value="<?echo $nusuario_sia?>" size="15" readonly></td>
                </tr>
              </table></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
        </table>
        <iframe src="Det_cons_int_cont.php?criterio=<?echo $clave?>"  width="850" height="400" scrolling="auto" frameborder="1">
        </iframe>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>