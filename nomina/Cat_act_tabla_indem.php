<?include ("../class/conect.php");  error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Catalogo Tabla de Indemnizaci&oacute;n)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function CargarUrl(mcodigo){var murl;  murl="Act_tabla_indemnizacion.php?Gcodigo="+mcodigo;   document.location = murl;}
</script></head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CATALOGO TABLA DE INDEMNIZACION</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<div id="Layer1" style="position:absolute; width:968px; height:448px; z-index:1; top: 70px; left: 5px;">
<?      $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1;  if ($gnomina=="00"){ $criterion="";$criterioc=""; }else{ $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
        $criterio=$criterion;
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"];  $txt_criterio=strtoupper($txt_criterio);
        $criterio = " where (tipo_nomina like '%" . $txt_criterio . "%' or  consecutivo like '%" . $txt_criterio . "%')".$criterioc;}}
        $sql="SELECT * FROM tabla_indem ".$criterio; $res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron resultados</font>"; $pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{
              if ($_GET["orden"]==""){$orden="tipo_nomina,consecutivo";} else{$orden=$_GET["orden"];} $tamPag=15;if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}$limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;}else{$seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM tabla_indem ".$criterio." ORDER BY ".$orden;  $res=pg_query($sql);
                echo "<table align='center' width='98%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=tipo_nomina,consecutivo&criterio=".$txt_criterio."'>Nomina</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=consecutivo,tipo_nomina&criterio=".$txt_criterio."'>Consecutivo</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=dede,tipo_nomina&criterio=".$txt_criterio."'>Desde</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=hasta,tipo_nomina&criterio=".$txt_criterio."'>Hasta</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=antiguedad,tipo_nomina&criterio=".$txt_criterio."'>Antiguedad</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=preaviso,tipo_nomina&criterio=".$txt_criterio."'>Preaviso</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=vacaciones,tipo_nomina&criterio=".$txt_criterio."'>Vacaciones</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=vac_adicional,tipo_nomina&criterio=".$txt_criterio."'>Vac.Adic.</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=bono_vacacional,tipo_nomina&criterio=".$txt_criterio."'>Bono Vac.</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)) {$linea=$linea+1;
                if  ($linea>$limitInf+$tamPag){$Salir=true;}  if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:CargarUrl('<? echo $registro["tipo_nomina"].$registro["consecutivo"].$registro["cod_empleado"]; ?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["tipo_nomina"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["consecutivo"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["desde"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["hasta"]; ?></b></font></td>
    <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["antiguedad"]; ?></b></font></td>
    <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["preaviso"]; ?></b></font></td>
    <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["vacaciones"]; ?></b></font></td>
    <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["vac_adicional"]; ?></b></font></td>
    <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["bono_vacacional"]; ?></b></font></td>

  </tr>
<?} }echo "</table>";}?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?      if($pagina>1){
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Principio</font>";
          echo "</a>&nbsp;";
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
          echo "<font face='verdana' size='-2'>Siguiente</font></a>";
          echo " ";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$numPags."&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Final</font>";
          echo "</a>&nbsp;";} ?>
        </td></tr>
        </table>
<form action="Cat_act_tabla_indem.php" method="get">
<table border="0" width="900">
  <tr>
	<td width="500">
	  <span class="Estilo5">Criterio de b&uacute;squeda:</span>
	  <input class="Estilo10" type="text" name="criterio" size="35" maxlength="150">
	  <input class="Estilo10" type="submit" value="Buscar">
	</td>
	<td width="100" >&nbsp;</td>
	<td width="100" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_tabla_indemnizacion.php')";
        onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="20" align="center" bgcolor=#EAEAEA><a class=menu href="Act_tabla_indemnizacion.php">Menu Anterior</a></div></td>
    <td width="100" >&nbsp;</td>
    <td width="100" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
       onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="20" align="center" bgcolor=#EAEAEA><a class=menu href="menu.php">Menu Principal</a></div></td>
  </tr>
</table>
</form>
</body>
</html>
<?  pg_close();?>