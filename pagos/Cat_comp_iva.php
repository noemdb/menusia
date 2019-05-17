<?include ("../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Catalogo Comprobantes de IVA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function CargarUrl(mclave) {var murl;   murl="Act_comp_ret_iva.php?Gcriterio=C"+mclave;   document.location = murl; }
</script></head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CATALOGO COMPROBANTE DE IVA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<div id="Layer1" style="position:absolute; width:978px; height:448px; z-index:1; top: 70px; left: 1px;">
<?      $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1;
        if ($_GET){if ($_GET["criterio"]!=""){ $txt_criterio = $_GET["criterio"];  $txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where mes_fiscal like '%" . $txt_criterio . "%' or nro_comprobante like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%'";}}
        $sql="SELECT DISTINCT ano_fiscal,mes_fiscal,nro_comprobante,fecha_emision,ced_rif,nombre FROM COMP_IVA ".$criterio; $res=pg_query($sql); $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Ordenes</font>";$pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{if ($_GET["orden"]==""){$orden="ano_fiscal,mes_fiscal,nro_comprobante ";}else{$orden=$_GET["orden"];}  $tamPag=10;
                if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;} else{$pagina=$_GET["pagina"];} $limitInf=($pagina-1)*$tamPag;  $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}  else{ $seccionActual=intval(($pagina-1)/$tamPag);$inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;} if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT DISTINCT ano_fiscal,mes_fiscal,nro_comprobante,fecha_emision,ced_rif,nombre FROM COMP_IVA  ".$criterio." ORDER BY ".$orden;  $res=pg_query($sql);
                echo "<table align='center' width='98%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=ano_fiscal,mes_fiscal,nro_comprobante&criterio=".$txt_criterio."'>A&ntilde;o</a></th>";
                echo "<th bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=mes_fiscal,nro_comprobante&criterio=".$txt_criterio."'>Mes</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=nro_comprobante&criterio=".$txt_criterio."'>Comprobante</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=fecha_emision&criterio=".$txt_criterio."'>Fecha</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=ced_rif,nro_comprobante&criterio=".$txt_criterio."'>Cedula/Rif</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=nombre,nro_comprobante&criterio=".$txt_criterio."'>Nombre</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)) { $linea=$linea+1;
                $sfecha=$registro["fecha_emision"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
                if ($linea>$limitInf+$tamPag){$Salir=true;}  if (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:CargarUrl('<? echo $registro["ano_fiscal"].$registro["mes_fiscal"].$registro["nro_comprobante"]; ?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["ano_fiscal"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["mes_fiscal"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["nro_comprobante"];; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $fecha; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["ced_rif"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["nombre"]; ?></b></font></td>

  </tr>
<?}} echo "</table>"; }  ?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
  <?    if($pagina>1){
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Principio</font>";
          echo "</a>&nbsp;";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Anterior</font>";
          echo "</a>&nbsp;"; }
        for($i=$inicio;$i<=$final;$i++) {
          if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";}
            else{echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."'>";
                 echo "<font face='verdana' size='-2'>".$i."</font></a>&nbsp;"; } }
        if($pagina<$numPags){
          echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Siguiente</font></a>";
          echo " ";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$numPags."&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Final</font>";
          echo "</a>&nbsp;"; }?>
        </td></tr>
        </table>
<hr noshade style="color:CC6666;height:1px">
<form  name="form1" action="Cat_comp_iva.php" method="get">
<table border="0" width="900">
  <tr>
	<td width="500">
	  <span class="Estilo5">Criterio de b&uacute;squeda:</span>
	  <input class="Estilo10" type="text" name="criterio" size="35" maxlength="150">
	  <input class="Estilo10" type="submit" value="Buscar">
	</td>
	<td width="100" >&nbsp;</td>
	<td width="100" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_comp_ret_iva.php')";
        onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="20" align="center" bgcolor=#EAEAEA><a class=menu href="Act_comp_ret_iva.php">Menu Anterior</a></div></td>
    <td width="100" >&nbsp;</td>
    <td width="100" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
       onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="20" align="center" bgcolor=#EAEAEA><a class=menu href="menu.php">Menu Principal</a></div></td>
  </tr>
</table>
</form>
</body>
</html>
<?  pg_close();?>