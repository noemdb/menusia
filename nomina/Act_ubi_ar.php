<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } 
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000030"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Defici&oacute;n de Ubicaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var Gcodigo = "";
function enviar(seleccion){Gcodigo=seleccion;}
function LlamarURL(url){document.location=url;}
function Llamar_Ventana(url){
var murl;  murl=url+Gcodigo; if(Gcodigo==""){alert("Codigo de Ubicacion debe ser Seleccionado");}else{document.location=murl;} }
function Llama_Eliminar(){var url; var r;
  if(Gcodigo==""){alert("Codigo de Ubicacion debe ser Seleccionado");}else{
  r=confirm("Esta seguro en Eliminar la Ubicacion ?");
  if (r==true){r=confirm("Esta Realmente seguro en Eliminar la Ubicacion ?");
    if (r==true){url="Delete_ubicacion.php?txtcodigo_ubicacion="+Gcodigo; VentanaCentrada(url,'Eliminar Ubicacion','','400','400','true');}}
   else {url="Cancelado, no elimino";} }
}
</script>
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
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEFINICI&Oacute;N DE UBICACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="134" border="0" id="tablacuerpo">
  <tr>
    <td><table width="96" border="1" cellspacing="0">
      <tr>
        <td height="274"><table width="92" height="270" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
          <?if ($Mcamino{0}=="S"){?>
		  <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_ubi_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_ubi_ar.php">Incluir</A></td>
          </tr>
          <?} if ($Mcamino{1}=="S"){?>
		  <tr>
		    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_ubi_ar.php?codigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_ubi_ar.php?codigo=')">Modificar</A></td>
          </tr>
		  <?} if ($Mcamino{6}=="S"){?>
          <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llama_Eliminar();">Eliminar</A></td>
          </tr>
		  <?}?>
		  <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_ubica_perso.htm','Ayuda Formulas','','900','600','true');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_ubica_perso.htm','Ayuda Formulas','','900','600','true');" class="menu">Ayuda </a></td>
          </tr>
          <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
          </tr>
       <td>&nbsp;</td>
      </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b>
          </b></font>
      <div id="Layer1" style="position:absolute; width:891px; height:348px; z-index:1; top: 67px; left: 110px;">
          <?$criterio=""; $txt_criterio=""; $pagina=1; $inicio=1; $final=1; if ($_GET){$orden=$_GET["orden"]; $pagina=$_GET["pagina"];}else{ $orden=""; $pagina="";}
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"];$txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where codigo_ubicacion like '%" . $txt_criterio . "%' or descripcion_ubi like '%" . $txt_criterio . "%'";}}
 	    $sql="SELECT * FROM NOM058 ".$criterio; $res=pg_query($sql); $numeroRegistros=pg_num_rows($res);  
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>  No se encontraron datos</font>";   $pagina=0;  $inicio=1; $final=0; $numPags=0;
        }else{if ($orden==""){$orden="codigo_ubicacion";}   $tamPag=10;
                if ($pagina==""){$pagina=1; $inicio=1; $final=$tamPag;} else{$pagina=$pagina;} $limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;}else{ $seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM NOM058  ".$criterio."ORDER BY ".$orden;  $res=pg_query($sql);            
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='20' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=codigo_ubicacion'>C&oacute;digo</a></th>";
                echo "<th height='20' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=descripcion_ubi'>Descripci&oacute;n de la Ubicacion</a></th>";
                $linea=0;  $Salir=false;
                while($registro=pg_fetch_array($res)){ $linea=$linea+1;
                if($linea>$limitInf+$tamPag){$Salir=true;}
                if(($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<? echo $registro["codigo_ubicacion"]; ?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["codigo_ubicacion"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["descripcion_ubi"]; ?></b></font></td>
     </tr>
<?}}echo "</table>"; }?>
<br>
<table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?    echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&criterio=".$txt_criterio."'>";
        echo "<font face='verdana' size='-2'>Principio</font>";
        echo "</a>&nbsp;";
        if($pagina>1){
                echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
                echo "<font face='verdana' size='-2'>Anterior</font>";
                echo "</a>&nbsp;"; }
        for($i=$inicio;$i<=$final;$i++) {
                if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";
                }else{
                   echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."'>";
                   echo "<font face='verdana' size='-2'>".$i."</font></a>&nbsp;"; } }
        if($pagina<$numPags){
                echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
                echo "<font face='verdana' size='-2'>Siguiente</font></a>";  }
        echo " ";
        echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$numPags."&orden=".$orden."&criterio=".$txt_criterio."'>";
        echo "<font face='verdana' size='-2'>Final</font>";
        echo "</a>&nbsp;"; ?>
<p>&nbsp;</p>
      </div> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b>      </b></font></td>  </div>
  </tr>
</table>
<form  name="form1" action="Act_ubi_ar.php" method="get" onSubmit="return revisar()">
<table border="0">
  <tr>
	<td>
	  <span class="Estilo5">Criterio de b&uacute;squeda:</span>
	  <input class="Estilo5" type="text" name="criterio" size="35" maxlength="150">
	  <input class="Estilo5" type="submit" value="Buscar">
	</td>
	<td>&nbsp;</td>
  </tr>  
</table>
</form>
</body>
</html>
<? pg_close();?>