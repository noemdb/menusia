<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL ^ E_NOTICE);
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Catalogo Ordenes de Pago)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function cerrar_catalogo(mtipo_caus,mnro_orden,mnomb_abrev,mcedr,mnomb,mconc,mmonto){
  window.opener.document.forms[0].txttipo_causado.value = mtipo_caus;
  window.opener.document.forms[0].txtnro_orden.value = mnro_orden;
  window.opener.document.forms[0].txtnombre_abrev_caus.value = mnomb_abrev;
  window.opener.document.forms[0].txtced_rif.value = mcedr;
  window.opener.document.forms[0].txtnombre_benef.value = mnomb;
  window.opener.document.forms[0].txtconcepto.value = mconc;
  window.opener.document.forms[0].txtmonto_nota.value = mmonto;
  window.opener.document.forms[0].txtnro_orden.focus();
  window.close();
}
</script></head>
<body>
<?
        $criterio = "where (status='N') "; $txt_criterio = "";
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"]; $txt_criterio = strtoupper ($txt_criterio);
        $criterio = $criterio . " and (tipo_causado like '%" . $txt_criterio . "%' or nro_orden like '%" . $txt_criterio . "%' or concepto like '%" . $txt_criterio . "%')";}}
        $sql="SELECT DISTINCT * FROM ORD_PAGO_ANT ".$criterio;     $res=pg_query($sql); $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Ordenes de Pago</font>";$pagina=1; $inicio=1; $final=1; $numPags=1; 
        }else{  if ($_GET["orden"]==""){$orden="nro_orden,tipo_causado";} else{$orden=$_GET["orden"];}    $tamPag=10;
                if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}  else{$pagina=$_GET["pagina"];}   $limitInf=($pagina-1)*$tamPag;  $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}    else{  $seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}    if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT DISTINCT * FROM ORD_PAGO_ANT ".$criterio." ORDER BY ".$orden;   $res=pg_query($sql);
                echo "<table align='center' width='98%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=nro_orden,tipo_causado&criterio=".$txt_criterio."'>Numero</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=tipo_causado,nro_orden&criterio=".$txt_criterio."'>Tipo</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=fecha,nro_orden&criterio=".$txt_criterio."'>Fecha</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=concepto&criterio=".$txt_criterio."'>Concepto</a></th>";
                $linea=0;   $Salir=false;
                while($registro=pg_fetch_array($res))  {    $linea=$linea+1;
                $descripcion=$registro["concepto"]; $sfecha=$registro["fecha"]; $func_inv=$registro["func_inv"];   if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
                $descripcion2=substr($descripcion,0,200); $descripcion=substr($descripcion,0,100);     $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
                $total_causado=$registro["total_causado"];  $total_retencion=$registro["total_retencion"]; $usuario_siao=$registro["usuario_sia"];
				$total_ajuste=$registro["total_ajuste"];  $total_pasivos=$registro["total_pasivos"];  $monto_am_ant=$registro["monto_am_ant"];
				$concepto=$registro["concepto"]; $concepto=cambiar_car_especiales($concepto);
				$total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant;
				if($registro["retencion"]=="S"){$total_neto = $total_causado - $total_ajuste;}
				  else{if($total_pasivos>0) {$total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant + $total_pasivos;}}
				$total_neto=formato_monto($total_neto);  
				if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["tipo_causado"];?>','<? echo $registro["nro_orden"];?>','<? echo $registro["nombre_abrev_caus"];?>','<? echo $registro["ced_rif"];?>','<? echo $registro["nombre"];?>','<? echo $concepto;?>','<? echo $total_neto;?>');" >
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["nro_orden"]; ?></b></font></td>
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["tipo_causado"]; ?></b></font></td>
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $fecha; ?></b></font></td>
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $descripcion; ?></b></font></td>
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
<form action="Cat_orden_pago_ant_ndb.php" method="get">
Criterio de b&uacute;squeda:<input type="text" name="criterio" size="22" maxlength="150"><input type="submit" class="button" value="Buscar">
</form>
</body>
</html>
<?   pg_close(); ?>