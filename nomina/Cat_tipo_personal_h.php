<?include ("../class/conect.php");  error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<script language="JavaScript">
function cerrar_catalogo(cod_tipo_personal){
  window.opener.document.forms[0].txttipo_personal_h.value = cod_tipo_personal;  
  window.opener.document.forms[0].txttipo_personal_h.focus();
  window.close();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Catalogo Tipo de Personal)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
</head><body>
<?
        $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1; 
        if ($_GET["criterio"]!=""){ $txt_criterio = $_GET["criterio"]; $txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where cod_tipo_personal like '%" . $txt_criterio . "%' or des_tipo_personal like '%" . $txt_criterio . "%'"; }
        $sql="SELECT * FROM nom015 ".$criterio;   $res=pg_query($sql); $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
        }else{if ($_GET["orden"]==""){$orden="cod_tipo_personal";} else{$orden=$_GET["orden"];} $tamPag=10;if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}$limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;}else{$seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM nom015 ".$criterio." ORDER BY ".$orden; $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th bgcolor='#00CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=cod_tipo_personal&criterio=".$txt_criterio."'>C&oacute;digo</a></th>";
                echo "<th bgcolor='#00CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=des_tipo_personal&criterio=".$txt_criterio."'>Denominaci&oacute;n Tipo Personal</a></th>";
                $linea=0;   $Salir=false;
                while($registro=pg_fetch_array($res)) {  $linea=$linea+1;  if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["cod_tipo_personal"]; ?>','<? echo $registro["des_tipo_personal"]; ?>')" >
   <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["cod_tipo_personal"]; ?></b></font></td>
   <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["des_tipo_personal"]; ?></b></font></td>
   </tr>
<?}
                }
                echo "</table>";
        }
?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?      if($pagina>1){
                echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&criterio=".$txt_criterio."'>";
                echo "<font face='verdana' size='-2'>Principio</font>";
                echo "</a>&nbsp;";
                echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
                echo "<font face='verdana' size='-2'>anterior</font>";
                echo "</a>&nbsp;"; }
        for($i=$inicio;$i<=$final;$i++) {
                if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";
                }else{
                   echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."'>";
                   echo "<font face='verdana' size='-2'>".$i."</font></a>&nbsp;"; } }
        if($pagina<$numPags){
                echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
                echo "<font face='verdana' size='-2'>siguiente</font></a>"; 
                echo " ";
				echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$numPags."&orden=".$orden."&criterio=".$txt_criterio."'>";
				echo "<font face='verdana' size='-2'>Final</font>";
				echo "</a>&nbsp;";				} ?>
        </td></tr>
        </table>
<hr noshade style="color:CC6666;height:1px">

<form action="Cat_tipo_personal_h.php" method="get">
Criterio de b&uacute;squeda:
<input type="text" name="criterio" size="22" maxlength="150">
<input type="submit" value="Buscar">
</div>
</form>
</body>
</html>
<?  pg_close();?>