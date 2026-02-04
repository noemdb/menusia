<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");  $equipo=getenv("COMPUTERNAME"); $mcod_m="NOM062".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $fecha_hoy=asigna_fecha_hoy();
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000045"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}

if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){ $cedula=''; $p_letra=''; $sql="SELECT * FROM NOM062 ORDER BY cedula";}
else {$cedula = $_GET["Gcedula"];$p_letra=substr($cedula, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cedula=substr($cedula,1,12);} else{$cedula=substr($cedula,0,12);}
  $sql="Select * from NOM062 where cedula='$cedula' ";
  if ($p_letra=="P"){$sql="SELECT * FROM NOM062 ORDER BY cedula";}
  if ($p_letra=="U"){$sql="SELECT * From NOM062 Order by cedula desc";}
  if ($p_letra=="S"){$sql="SELECT * From NOM062 Where (cedula>'$cedula') Order by cedula";}
  if ($p_letra=="A"){$sql="SELECT * From NOM062 Where (cedula<'$cedula') Order by cedula desc";}
 // echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Trabajadores Retirados)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var Gcedula = "";
function Llamar_Ventana(url){var murl;
    Gcedula=document.form1.txtcedula.value;murl=url+Gcedula;
    if (Gcedula==""){alert("Cedula/Rif debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_traba_reti_ar.php";
   if(MPos=="P"){murl="Act_traba_reti_ar.php?Gcedula=P"}
   if(MPos=="U"){murl="Act_traba_reti_ar.php?Gcedula=U"}
   if(MPos=="S"){murl="Act_traba_reti_ar.php?Gcedula=S"+document.form1.txtcedula.value;}
   if(MPos=="A"){murl="Act_traba_reti_ar.php?Gcedula=A"+document.form1.txtcedula.value;}
   document.location = murl;
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
$nombre="";$cedula=""; $nacionalidad=""; $res=pg_query($sql); $filas=pg_num_rows($res); $fecha_nacimiento=$fecha_hoy;
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From NOM062 ORDER BY cedula";} if ($p_letra=="A"){$sql="SELECT * From NOM062 ORDER BY cedula desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $cedula=$registro["cedula"]; $nombre=$registro["nombre"]; $nacionalidad=$registro["nacionalidad"];  }
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INFORMACI&Oacute;N TRABAJADORES RETIRADOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="490" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="488"><table width="92" height="485" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Mover_Registro('P');">Primero</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_retirados.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_retirados.php" class="menu">Catalogo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <td>&nbsp;</td>
  </table></td>
    <td width="888">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
            <div id="Layer1" style="position:absolute; width:836px; height:642px; z-index:1; top: 74px; left: 115px;">
      <form name="form1" method="post">
        <table width="865" border="0" >
           <tr>
             <td><table width="864">
               <tr>
                 <td width="156"><span class="Estilo5">C&Eacute;DULA DE IDENTIDAD :</span></td>
                 <td width="391"><span class="Estilo5"> <input name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  value="<?echo $cedula?>" readonly></span></td>
                 <td width="122"><span class="Estilo5">NACIONALIDAD : </span></td>
                 <td width="155"><span class="Estilo5"> <input name="txtnacionalidad" type="text" id="txtnacionalidad" size="15" maxlength="15"   value="<?echo $nacionalidad?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="124"><span class="Estilo5">NOMBRE COMPLETO  :</span></td>
                 <td width="720"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" size="100" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr><td>&nbsp;</td></tr>
        </table>
                <iframe src="Det_cons_trab_ret.php?cedula=<?echo $cedula?>"  width="850" height="350" scrolling="auto" frameborder="1">
        </iframe>

      </form>

    </td>
  </tr>
</table>
</body>
</html>