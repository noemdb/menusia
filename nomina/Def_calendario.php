<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); $ini='N'; $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$ano='2012';$mes='01';  $ano=substr($fecha_hoy,6,4);  $mes=substr($fecha_hoy,3,2); }else{$mes=$_GET["mes"]; $mes=$_GET["mes"]; $ini=$_GET["ini"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="04-0000040"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo = getenv("COMPUTERNAME"); $criterio=$usuario_sia; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Definir Calendario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function siguinte_mes(){var murl; var mmes=document.form1.txtmes.value; var mano=document.form1.txtano.value;   murl="Def_calendario.php";
 mmes=mmes*1; mano=mano*1; mmes=mmes+1; if(mmes<10){ mmes="0"+mmes; }  if(mmes>=13){ mmes="01"; mano=mano+1; } 
 murl="Def_calendario.php?mes="+mmes+"&ano="+mano+"&ini=N";
 document.location = murl;
}
function anterior_mes(){var murl; var mmes=document.form1.txtmes.value; var mano=document.form1.txtano.value;   murl="Def_calendario.php";
 mmes=mmes*1; mano=mano*1; mmes=mmes-1; if(mmes<10){ mmes="0"+mmes; } if(mmes<1){ mmes="12"; mano=mano-1; }  
 murl="Def_calendario.php?mes="+mmes+"&ano="+mano+"&ini=N";
 document.location = murl;
}
</script>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEFINIR CALENDARIO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="520" border="1" id="tablacuerpo">
  <tr>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:945px; height:491px; z-index:1; top: 71px; left: 20px;">
	  
	    <form name="form1" method="post">
          <table width="878" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <tr>
			  <td height="19" align="center" class="Estilo16"><table width="920" border="0">
				<tr>
				  <td width="60" height="26" align="left" class="Estilo5"> MES : </td>
				  <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtmes" type="text" id="txtmes" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $mes?>" size="4" maxlength="2" class="Estilo5"> </span></td>
				  <td width="60" class="Estilo5"><div align="left">A&Ntilde;O  : </div></td>
				  <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtano" type="text" id="txtano" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $ano?>" size="8" maxlength="4" class="Estilo5">  </span></td>
				  <td width="100"></td>
				  
				  <td width="150"><span class="Estilo5"><input type="button" name="btanterior" value="Mes Anterior" title="Cambia al Anterior Mes" onClick="javascript:anterior_mes()" ></span></td>
				  <td width="100"></td>
				  <td width="150"><span class="Estilo5"><input type="button" name="btsiguiente" value="Mes Siguiente" title="Cambia al Siguiente Mes" onClick="javascript:siguinte_mes()" ></span></td>
				  <td width="100"></td>
				</tr>
			  </table></td>
		   </tr> 
		   <tr>
            <td> <iframe src="Det_def_calendario.php?mes=<?echo $mes?>&ano=<?echo $ano?>&ini=<?echo $ini?>"  width="850" height="380" scrolling="auto" frameborder="1">  </iframe></td>
          </tr>
          </table>
        <table width="923">
		  <tr><td>&nbsp;</td> </tr>
          <tr>
            <td width="626"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="139"></td>
            <td width="142" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
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