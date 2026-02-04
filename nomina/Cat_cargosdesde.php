<?include ("../class/conect.php");  error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<script language="JavaScript">
function cerrar_catalogo(codigo_cargo,den_cargo){
  window.opener.document.forms[0].txtcodigo_cargo_d.value = codigo_cargo;
  window.opener.document.forms[0].txtdenominacion_cd.value = den_cargo;
  window.opener.document.forms[0].txtcodigo_cargo_d.focus();
  window.close();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Catalogo de Cargos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
</head><body>
<?        $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1; 
        if ($_GET){if ($_GET["criterio"]!=""){ $txt_criterio = $_GET["criterio"]; $txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where codigo_cargo like '%" . $txt_criterio . "%' or denominacion like '%" . $txt_criterio . "%'";
        }} $sql="SELECT * FROM nom004 ".$criterio;        $res=pg_query($sql); $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron resultados</font>"; $pagina=1;$inicio=1;$final=1; $numPags=1;
        }else{if ($_GET["orden"]==""){$orden="codigo_cargo";}else{$orden=$_GET["orden"];} $tamPag=10;if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}$limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;}else{$seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM nom004 ".$criterio." ORDER BY ".$orden;$res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th bgcolor='#00CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=codigo_cargo&criterio=".$txt_criterio."'>C&oacute;digo de Cargo</a></th>";
                echo "<th bgcolor='#00CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=denominacion&criterio=".$txt_criterio."'>Denominaci&oacute;n del Cargo</a></th>";
                $linea=0;   $Salir=false;
                while($registro=pg_fetch_array($res)){ $linea=$linea+1;                
				if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["codigo_cargo"]; ?>','<? echo $registro["denominacion"]; ?>')" >
   <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["codigo_cargo"]; ?></b></font></td>
   <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["denominacion"]; ?></b></font></td>
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
                echo "<font face='verdana' size='-2'>siguiente</font></a>";  } ?>
        </td></tr>
        </table>
<hr noshade style="color:CC6666;height:1px">

<form action="Cat_cargosdesde.php" method="get">
Criterio de b&uacute;squeda:
<input type="text" name="criterio" size="22" maxlength="150">
<input type="submit" value="Buscar">
</div>
</form>
</body>
</html>
<?  pg_close();?>