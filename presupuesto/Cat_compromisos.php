<?include ("../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE);
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Catalogo de Compromisos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function cerrar_catalogo(mtipo_comp,mref_comp,mcod_comp,mnomb_abrev,mced_rif,mnombre,mfunc_inv,mdescrip){
  window.opener.document.forms[0].txttipo_compromiso.value = mtipo_comp;
  window.opener.document.forms[0].txtreferencia_comp.value = mref_comp;
  window.opener.document.forms[0].txtcodigo_comp.value = mcod_comp;
  window.opener.document.forms[0].txtnombre_abrev_comp.value = mnomb_abrev;
  window.opener.document.forms[0].txtced_rif.value = mced_rif;
  window.opener.document.forms[0].txtnombre.value = mnombre;
  window.opener.document.forms[0].txtfunc_inv.value = mfunc_inv;
  window.opener.document.forms[0].txtdescripcion.value = mdescrip;
  window.opener.document.forms[0].txtreferencia_comp.focus();
  window.close();
}
</script></head>
<body>
<?      $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1;
        $criterio = "where (anulado='N') and (tipo_compromiso<>'0000') and (tipo_compromiso<>'A000')";
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"];$txt_criterio = strtoupper ($txt_criterio);
        $criterio = $criterio . " and (tipo_compromiso like '%" . $txt_criterio . "%' or referencia_comp like '%" . $txt_criterio . "%' or descripcion_comp like '%" . $txt_criterio . "%')";}}
        $sql="SELECT * FROM COMPROMISOS ".$criterio;$res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Compromisos</font>"; $pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{if ($_GET["orden"]==""){$orden="tipo_compromiso,referencia_comp";}else{$orden=$_GET["orden"];}                 $tamPag=10;
                if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;} else{$pagina=$_GET["pagina"];}
                $limitInf=($pagina-1)*$tamPag;  $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}
                 else{ $seccionActual=intval(($pagina-1)/$tamPag);   $inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}
                    if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM COMPROMISOS ".$criterio." ORDER BY ".$orden;   $res=pg_query($sql);
                echo "<table align='center' width='98%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=tipo_compromiso,referencia_comp&criterio=".$txt_criterio."'>Tipo</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=referencia_comp,tipo_compromiso&criterio=".$txt_criterio."'>Referencia</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=fecha_compromiso,referencia_comp&criterio=".$txt_criterio."'>Fecha</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=descripcion_comp&criterio=".$txt_criterio."'>Descripci&oacute;n</a></th>";
                $linea=0;   $Salir=false;
                while($registro=pg_fetch_array($res)) {    $linea=$linea+1;
                $descripcion=$registro["descripcion_comp"];  $descripcion=str_replace("Ñ","N",$descripcion);  $descripcion=str_replace("Ã‘","N",$descripcion);
                $sfecha=$registro["fecha_compromiso"];    $func_inv=$registro["func_inv"];
                if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
                $descripcion2=substr($descripcion,0,200);  $descripcion1=substr($descripcion,0,100);     $descripcion=str_replace('"',' ',$descripcion);  
                $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
                if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["tipo_compromiso"];?>','<? echo $registro["referencia_comp"];?>','<? echo $registro["cod_comp"];?>','<? echo $registro["nombre_abrev_comp"];?>','<? echo $registro["ced_rif"]; ?>','<? echo $registro["nombre"]; ?>','<? echo $func_inv; ?>','<? echo $descripcion; ?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["tipo_compromiso"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["referencia_comp"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $fecha; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $descripcion1; ?></b></font></td>
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
<form action="Cat_compromisos.php" method="get">
Criterio de b&uacute;squeda:
<input type="text" name="criterio" size="22" maxlength="150">
<input type="submit" class="button" value="Buscar">
</form>
</body>
</html>
<?  pg_close(); ?>
