<?include ("../../class/conect.php"); include ("../../class/ventana.php"); error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<script language="JavaScript">
function Llamar_cat(){var murl;
  murl= "Beneficiariosh.php?criterio="+document.form1.criterio.value;  LlamarURL(murl);}
function cerrar_catalogo(mcodigo,mnombre){
  window.opener.document.forms[0].txtcedula_h.value = mcodigo;
  window.opener.document.forms[0].txtcedula_h.focus();
  window.close();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Catalogo de Beneficiarios)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head><body>
<?      $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1;
        if ($_GET["criterio"]!=""){   $txt_criterio=$_GET["criterio"];     $txt_criterio=strtoupper ($txt_criterio);
        $criterio = " where ced_rif like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%'";  }
        $sql="SELECT * FROM PRE099 ".$criterio;     $res=pg_query($sql);     $numeroRegistros=pg_num_rows($res);
		 if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron resultados</font>"; $pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{
              if ($_GET["orden"]==""){$orden="ced_rif";}else{$orden=$_GET["orden"];} $tamPag=10;
                if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];} $limitInf=($pagina-1)*$tamPag; $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}else{ $seccionActual=intval(($pagina-1)/$tamPag);  $inicio=($seccionActual*$tamPag)+1; if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}  if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM PRE099 ".$criterio." ORDER BY ".$orden;   $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='20' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=ced_rif&criterio=".$txt_criterio."'>Cedula/Rif</a></th>";
                echo "<th height='20' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=nombre&criterio=".$txt_criterio."'>Nombre Beneficiario</a></th>";
                $linea=0;   $Salir=false;
                while($registro=pg_fetch_array($res)) { $linea=$linea+1;
                if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["ced_rif"]?>','<? echo $registro["nombre"]; ?>')" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["ced_rif"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["nombre"]; ?></b></font></td>
  </tr>
<?}} echo "</table>"; }
?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?      echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&criterio=".$txt_criterio."'>";
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
        </td></tr>
        </table>
<hr noshade style="color:CC6666;height:1px">
<form name="form1" method="post">
Criterio de busqueda:
<input type="text" name="criterio" size="22" maxlength="150">
<td width="268"><input name="button" type="button" id="button" value="Buscar" onClick="javascript:Llamar_cat()"></td>
</div>
</form>
</body>
</html>
<?
  pg_close();
?>