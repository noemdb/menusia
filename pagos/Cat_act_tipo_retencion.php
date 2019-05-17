<?include ("../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Catalogo Tipos de Retenciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function CargarUrl(mclave) {var murl;   murl="Act_tipo_retencion.php?Gtipo_retencion="+mclave;   document.location = murl;}
</script></head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CATAL0GO TIPOS DE RETENCIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<div id="Layer1" style="position:absolute; width:978px; height:448px; z-index:1; top: 70px; left: 1px;">
<?
        $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1;
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"]; $txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where tipo_retencion like '%" . $txt_criterio . "%' or descripcion_ret like '%" . $txt_criterio . "%'";  }}
        $sql="SELECT * FROM RETENCIONES ".$criterio;$res=pg_query($sql);        $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Tipos de Retenciones</font>";$pagina=1; $inicio=1; $final=1; $numPags=1; 
        }else{if ($_GET["orden"]!=""){$orden=$_GET["orden"];}else{$orden="tipo_retencion";} $tamPag=15;				
			    if ($_GET["pagina"]!=""){$pagina=$_GET["pagina"];}else{$pagina=1;$inicio=1;$final=$tamPag;}  
				$limitInf=($pagina-1)*$tamPag; $numPags=ceil($numeroRegistros/$tamPag); $seccionActual=intval(($pagina-1)/$tamPag);  $inicio=($seccionActual*$tamPag)+1; if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}  if ($final>$numPags){$final=$numPags;} 
			    $sql="SELECT * FROM RETENCIONES ".$criterio." ORDER BY ".$orden; $res=pg_query($sql);
                echo "<table align='center' width='98%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=tipo_retencion&criterio=".$txt_criterio."'>Tipo</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=descripcion_ret&criterio=".$txt_criterio."'>Descripcion</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=tasa&criterio=".$txt_criterio."'>Tasa</a></th>";
				 echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=ret_grupo&criterio=".$txt_criterio."'>Grupo</a></th>";
                $linea=0;  $Salir=false;
                while($registro=pg_fetch_array($res)) {  $linea=$linea+1; $ret_grupo=$registro["ret_grupo"];
				if($ret_grupo=="O"){$ret_grupo="OTROS";}if($ret_grupo=="N"){$ret_grupo="NOMINA";} if($ret_grupo=="I"){$ret_grupo="ISLR";}if($ret_grupo=="A"){$ret_grupo="IVA";}
                if($ret_grupo=="L"){$ret_grupo="LABORAL";}if($ret_grupo=="F"){$ret_grupo="FIEL CUM.";} if($ret_grupo=="T"){$ret_grupo="TIMBRE FISCAL";}if($ret_grupo=="R"){$ret_grupo="RESPONSABILIDAD";} if($ret_grupo=="E"){$ret_grupo="ACT ECONOMICA";}
                $descripcion_ret=$registro["descripcion_ret"]; $descripcion_ret=substr($descripcion_ret,0,150);
                if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:CargarUrl('<? echo $registro["tipo_retencion"]; ?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["tipo_retencion"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $descripcion_ret; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["tasa"]; ?></b></font></td>
	<td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $ret_grupo; ?></b></font></td>
  </tr>
<?}} echo "</table>"; }
?>
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
<form  name="form1" action="Cat_act_tipo_retencion.php" method="get">
<table border="0" width="900">
  <tr>
	<td width="500">
	  <span class="Estilo5">Criterio de b&uacute;squeda:</span>
	  <input class="Estilo10" type="text" name="criterio" size="35" maxlength="150">
	  <input class="Estilo10" type="submit" value="Buscar">
	</td>
	<td width="100" >&nbsp;</td>
	<td width="100" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_tipo_retencion.php')";
        onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="20" align="center" bgcolor=#EAEAEA><a class=menu href="Act_tipo_retencion.php">Menu Anterior</a></div></td>
    <td width="100" >&nbsp;</td>
    <td width="100" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
       onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="20" align="center" bgcolor=#EAEAEA><a class=menu href="menu.php">Menu Principal</a></div></td>
  </tr>
</table>
</form>
</body>
</html>
<?  pg_close();?>
