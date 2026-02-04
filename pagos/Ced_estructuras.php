<?include ("../class/conect.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Catalogo Cedulas de Estrucutra de Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function cerrar_catalogo(ced,nomb){ 
  window.opener.document.forms[0].txtced_trab.value = ced;
  window.opener.document.forms[0].txtnombre_trab.value = nomb;
  window.opener.document.forms[0].txtced_trab.focus();
  window.close();
}
</script></head>
<body>
<?      $criterio = "";        $txt_criterio = "";
        if ($_GET["cod_est"]!=""){$cod_est=$_GET["cod_est"];  $criterio = " where cod_estructura='$cod_est'";} else {$cod_est=""; }		 
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"]; $txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where cod_estructura='$cod_est' and (ced_rif_est like '%" . $txt_criterio . "%' or nombre_benef_e like '%" . $txt_criterio . "%')";}}
         $sql="select * from pag033 ".$criterio;        $res=pg_query($sql); $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Cedulas</font>";$pagina=1; $inicio=1; $final=1; $numPags=1; 
        }else{
              if(!isset($orden)){$orden="ced_rif_est";} else{$orden=$_GET["orden"];}
                $tamPag=10;
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}  else{$pagina=$_GET["pagina"];}
                $limitInf=($pagina-1)*$tamPag; $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}
                 else{
                    $seccionActual=intval(($pagina-1)/$tamPag);
                    $inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}
                    if ($final>$numPags){$final=$numPags;} }
                $sql="select * from pag033 ".$criterio." ORDER BY ".$orden; $res=pg_query($sql);
                echo "<table align='center' width='98%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=ced_rif_est&criterio=".$txt_criterio."'>CEDULA</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=nombre_benef_e&criterio=".$txt_criterio."'>NOMBRE TRABAJADOR</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)){$linea=$linea+1;
                $descripcion=$registro["nombre_benef_e"]; $descripcion=substr($descripcion,0,150);
                if ($linea>$limitInf+$tamPag){$Salir=true;}   if (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["ced_rif_est"];?>','<? echo $registro["nombre_benef_e"];?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["ced_rif_est"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $descripcion; ?></b></font></td>
  </tr>
<?}} echo "</table>"; }
?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
  <?    if($pagina>1){
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&cod_est=".$cod_est."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Principio</font>";
          echo "</a>&nbsp;";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&cod_est=".$cod_est."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Anterior</font>";
          echo "</a>&nbsp;"; }
        for($i=$inicio;$i<=$final;$i++) {
          if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";}
            else{echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&cod_est=".$cod_est."&criterio=".$txt_criterio."'>";
                 echo "<font face='verdana' size='-2'>".$i."</font></a>&nbsp;"; } }
        if($pagina<$numPags){
          echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Siguiente</font></a>";
          echo " ";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$numPags."&orden=".$orden."&cod_est=".$cod_est."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Final</font>";
          echo "</a>&nbsp;"; }?>
        </td></tr>
        </table>
<hr noshade style="color:CC6666;height:1px">
<form action="Ced_estructuras.php" method="get">
<td width="20"><input name="cod_est" type="hidden" id="cod_est" value="<?echo $cod_est?>"></td>
Criterio de b&uacute;squeda:
<input type="text" name="criterio" size="22" maxlength="150">
<input type="submit" value="Buscar">
</div>
</form>
</body>
</html>
<? pg_close(); ?>