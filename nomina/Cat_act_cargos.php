<?include ("../class/conect.php");  include ("../class/fun_numeros.php");  error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Catalogo de Cargos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function CargarUrl(mcodigo){var murl;  murl="Act_cargo_ar.php?Gcodigo=C"+mcodigo;   document.location = murl;}
</script></head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CATALOGO DE CARGOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<div id="Layer1" style="position:absolute; width:968px; height:448px; z-index:1; top: 70px; left: 5px;">
<?      $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1;  
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"];  $txt_criterio=strtoupper($txt_criterio);
        $criterio = " where codigo_cargo like '%" . $txt_criterio . "%' or denominacion like '%" . $txt_criterio . "%' or text(sueldo_cargo) like '%" . $txt_criterio . "%'";}}
        $sql="SELECT * FROM NOM004 ".$criterio; $res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
        //echo $sql;
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron resultados</font>"; $pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{
              if ($_GET["orden"]==""){$orden="codigo_cargo";}else{$orden=$_GET["orden"];} $tamPag=15;if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}$limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;}else{$seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM NOM004 ".$criterio." ORDER BY ".$orden;  $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=codigo_cargo&criterio=".$txt_criterio."'>Codigo de Cargo</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=denominacion&criterio=".$txt_criterio."'>Descripci&oacute;n</a></th>";
                 echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=sueldo_cargo&criterio=".$txt_criterio."'>Sueldo</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)) {$linea=$linea+1;
                if  ($linea>$limitInf+$tamPag){$Salir=true;}  if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){   $sueldo_cargo=$registro["sueldo_cargo"]; $sueldo_cargo=formato_monto($sueldo_cargo); ?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:CargarUrl('<? echo $registro["codigo_cargo"]; ?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["codigo_cargo"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["denominacion"]; ?></b></font></td>
<td align='right'><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $sueldo_cargo; ?></b></font></td>
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
<form action="Cat_act_cargos.php " method="get">
<table border="0" width="900">
  <tr>
	<td width="500">
	  <span class="Estilo5">Criterio de b&uacute;squeda:</span>
	  <input class="Estilo10" type="text" name="criterio" size="35" maxlength="150">
	  <input class="Estilo10" type="submit" value="Buscar">
	</td>
	<td width="100" >&nbsp;</td>
	<td width="100" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_cargo_ar.php')";
        onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="20" align="center" bgcolor=#EAEAEA><a class=menu href="Act_cargo_ar.php">Menu Anterior</a></div></td>
    <td width="100" >&nbsp;</td>
    <td width="100" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
       onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="20" align="center" bgcolor=#EAEAEA><a class=menu href="menu.php">Menu Principal</a></div></td>
  </tr>
</table>
</form>
</body>
</html>
<?  pg_close();?>