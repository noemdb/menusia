<?php include ("../class/conect.php");include ("../class/fun_numeros.php"); error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];}$long_c=strlen($formato_presup); $lc=strlen($formato_categoria);
?>
<script language="JavaScript">
function cerrar_catalogo(mcodigo,mfuente,mdenominacion,mdes_fuente,mcod_conta,mnom_cuenta,mdisponible){
  window.opener.document.forms[0].txtcod_presup.value = mcodigo;
  window.opener.document.forms[0].txtcod_fuente.value = mfuente;
  window.opener.document.forms[0].txtdenominacion.value = mdenominacion;
  window.opener.document.forms[0].txtdes_fuente.value = mdes_fuente;
  window.opener.document.forms[0].txtcod_contable.value = mcod_conta;
  window.opener.document.forms[0].txtdes_contable.value = mnom_cuenta; 
  window.opener.document.forms[0].txtcod_presup.focus();
  window.close();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONFIGURACI&Oacute;N Y MANTENIMIENTO (Catalogo de Codigos Presupuestarios)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head><body>
<?php      $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1;  $criterio = "where ( (length(cod_presup)=".$long_c.") or (length(cod_presup)=".$lc.") )";$txt_criterio = "";
        if ($_GET){if ($_GET["criterio"]!=""){ $txt_criterio = $_GET["criterio"];$txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where ( (length(cod_presup)=".$long_c.") or (length(cod_presup)=".$lc.") ) and (cod_presup like '%" . $txt_criterio . "%' or denominacion like '%" . $txt_criterio . "%')";}}
        $sql="select cod_presup,cod_fuente,denominacion,cod_contable,des_fuente_financ,nombre_cuenta,asignado,disponible,diferido,disp_diferida from codigos ".$criterio;
        $res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Cuentas</font>"; $pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{
              if ($_GET["orden"]==""){$orden="cod_presup,cod_fuente";}else{$orden=$_GET["orden"];} $tamPag=10; if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];} $limitInf=($pagina-1)*$tamPag; $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}else{   $seccionActual=intval(($pagina-1)/$tamPag);   $inicio=($seccionActual*$tamPag)+1;if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}   if ($final>$numPags){$final=$numPags;} }
                $sql="select cod_presup,cod_fuente,denominacion,cod_contable,des_fuente_financ,nombre_cuenta,asignado,disponible,diferido,disp_diferida from codigos ".$criterio." ORDER BY ".$orden;
                $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=cod_presup&criterio=".$txt_criterio."'>Codigo Presupuestario</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=cod_fuente&criterio=".$txt_criterio."'>Fuente</a></th>";
                echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=denominacion&criterio=".$txt_criterio."'>Denominacion</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)){ $denominacion=substr($registro["denominacion"],0,60);
                $linea=$linea+1;  if($registro["disponible"]>0){$monto=formato_monto($registro["disponible"]);} else {$monto=0;}
                if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<?php echo $registro["cod_presup"]; ?>','<?php echo $registro["cod_fuente"]; ?>','<?php echo $denominacion; ?>','<?php echo $registro["des_fuente_financ"]; ?>','<?php echo $registro["cod_contable"]; ?>','<?php echo $registro["nombre_cuenta"]; ?>','<?php echo $monto; ?>')" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php echo $registro["cod_presup"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php echo $registro["cod_fuente"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php echo $registro["denominacion"]; ?></b></font></td>
  </tr>
<?php }  } echo "</table>"; }
?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?php      if($pagina>1){
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

<form action="Cat_codigos_presup.php" method="get">
Criterio de b&uacute;squeda:
<input type="text" name="criterio" size="22" maxlength="150">
<input type="submit" value="Buscar">
</div>
</form>

</body>
</html>
<?php  pg_close();?>