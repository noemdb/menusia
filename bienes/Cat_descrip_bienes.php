<?include ("../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<script language="JavaScript">
function cerrar_catalogo(mcodigo,mdenominacion){
  //window.opener.document.forms[0].txtnum_descrip.value = mcodigo;
  window.opener.document.forms[0].txtdenominacion.value = mdenominacion;
  window.opener.document.forms[0].txtdenominacion.focus();
  window.close();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Catalogo de Descripcion de Bienes)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head><body>
<?
        $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $codigo_c="";
        if ($_GET){   if ($_GET["codigo_c"]!=""){$codigo_c = $_GET["codigo_c"]; }		
		if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"];$txt_criterio = strtoupper ($txt_criterio); 		  
        $criterio = " and num_descrip like '%" . $txt_criterio . "%' or descripcion_b like '%" . $txt_criterio . "%'"; } }
        $sql="SELECT num_descrip,descripcion_b  FROM BIEN033 where codigo_c='$codigo_c' ".$criterio;$res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Descripcion de Bienes</font>";$pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{
              if ($_GET["orden"]==""){$orden="codigo_c,num_descrip";} else{$orden=$_GET["orden"];} $tamPag=10;
                if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}
                $limitInf=($pagina-1)*$tamPag; $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}  else{ $seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}   if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT num_descrip,descripcion_b  FROM BIEN033 where codigo_c='$codigo_c' ".$criterio." ORDER BY ".$orden; $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=num_descrip&criterio=".$txt_criterio."'>Numero</a></th>";
                 echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=descripcion_b&criterio=".$txt_criterio."'>Denominacion</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)){ $linea=$linea+1; $cod_depe=$registro["num_descrip"];
                if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["num_descrip"]; ?>','<? echo $registro["descripcion_b"]; ?>')" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["num_descrip"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["descripcion_b"]; ?></b></font></td>
  </tr>
<?}}echo "</table>"; }
?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?      if($pagina>1){
           echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&codigo_c=".$codigo_c."&criterio=".$txt_criterio."'>";
           echo "<font face='verdana' size='-2'>Principio</font>";
           echo "</a>&nbsp;";
           echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&codigo_c=".$codigo_c."&criterio=".$txt_criterio."'>";
           echo "<font face='verdana' size='-2'>Anterior</font>";
           echo "</a>&nbsp;"; }
        for($i=$inicio;$i<=$final;$i++) {
           if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";}
             else{
               echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&codigo_c=".$codigo_c."&criterio=".$txt_criterio."'>";
               echo "<font face='verdana' size='-2'>".$i."</font></a>&nbsp;"; } }
        if($pagina<$numPags){
          echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&codigo_c=".$codigo_c."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Siguiente</font></a>";
          echo " ";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$numPags."&orden=".$orden."&codigo_c=".$codigo_c."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Final</font>";
          echo "</a>&nbsp;"; }?>
        </td></tr>
        </table>
<hr noshade style="color:CC6666;height:1px">
<form action="Cat_descrip_bienes.php" method="get">

</div>
</form>

</body>
</html>
<?
  pg_close();
?>
