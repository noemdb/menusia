<?include ("../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE); include ("../class/fun_numeros.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<script language="JavaScript">
function cerrar_catalogo(mcodigo,mdenominacion,mcod_contable,mcod_contable_c,mcod_presup,mtipo_depreciacion,mtasa_deprec,mvida_util){
  window.opener.document.forms[0].txtcod_clasificacion.value = mcodigo;
  window.opener.document.forms[0].txtnom_clasificacion.value = mdenominacion;
  window.opener.document.forms[0].txtcod_contablea.value = mcod_contable;
  window.opener.document.forms[0].txtcod_contabled.value = mcod_contable_c;
  window.opener.document.forms[0].txtcod_presup_dep.value = mcod_presup;
  window.opener.document.forms[0].txttasa_deprec.value = mtasa_deprec;
  window.opener.document.forms[0].txtvida_util.value = mvida_util;
  //window.opener.document.forms[0].txttipo_depreciacion.value = mtipo_depreciacion;  
  if(mtipo_depreciacion=="NINGUNA"){window.opener.document.forms[0].txttipo_depreciacion.options[0].selected = true;}else{window.opener.document.forms[0].txttipo_depreciacion.options[1].selected = true;}
   window.opener.document.forms[0].txtcod_clasificacion.focus();
  window.close();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Catalogo de Clasificacion)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head><body>
<?      $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1;
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"];$txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where codigo_c like '%" . $txt_criterio . "%' or denominacion_c like '%" . $txt_criterio . "%'"; }}
        $sql="SELECT *  FROM BIEN008 ".$criterio;$res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Dependencias</font>";$pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{
              if ($_GET["orden"]==""){$orden="grupo_c,codigo_c";} else{$orden=$_GET["orden"];}  $tamPag=10;
                if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}   $limitInf=($pagina-1)*$tamPag;  $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}else{$seccionActual=intval(($pagina-1)/$tamPag);  $inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}   if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT *  FROM BIEN008".$criterio." ORDER BY ".$orden; $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=grupo_c&criterio=".$txt_criterio."'>Grupo</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=codigo_c&criterio=".$txt_criterio."'>Codigo </a></th>";
                echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=denominacion_c&criterio=".$txt_criterio."'>Descripcion</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)){ $linea=$linea+1; $cod_depe=$registro["codigo_c"]; $tasa_deprec=$registro["tasa_deprec"];   $vida_util=$registro["vida_util"]; $tasa_deprec=formato_monto($tasa_deprec);    $vida_util=formato_monto($vida_util); 
                if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["codigo_c"]; ?>','<? echo $registro["denominacion_c"]; ?>','<? echo $registro["cod_contable"]; ?>','<? echo $registro["cod_contable_c"]; ?>','<? echo $registro["cod_presup"]; ?>','<? echo $registro["tipo_depreciacion"]; ?>','<? echo $tasa_deprec; ?>','<? echo $vida_util; ?>')" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["grupo_c"]; ?></b></font></td>
	<td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["codigo_c"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["denominacion_c"]; ?></b></font></td>
  </tr>
<?}}echo "</table>"; }
?>
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
           if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";}
             else{
               echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."'>";
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
<form action="Cat_clasificacion_bien.php" method="get">
Criterio de b&uacute;squeda:
<input type="text" name="criterio" size="22" maxlength="150">
<input type="submit" value="Buscar">
</div>
</form>
</body>
</html>
<?  pg_close();?>