<?include ("../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE); include ("../class/fun_numeros.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<script language="JavaScript">
function cerrar_catalogo(mcodigo,mdes_componente,mmarca,mmodelo,mserial){
  window.opener.document.forms[0].txtcod_componente.value = mcodigo;
  window.opener.document.forms[0].txtdes_componente.value = mdes_componente;
  window.opener.document.forms[0].txtmarca.value = mmarca;
  window.opener.document.forms[0].txtmodelo.value = mmodelo;
  window.opener.document.forms[0].txtserial.value = mserial;
  window.opener.document.forms[0].txtcod_componente.focus();
  window.close();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Catalogo de Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head><body>
<?
        $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $cod_bien_mue="";
        if ($_GET){ $cod_bien_mue = $_GET["cod_bien_mue"];}		
		$sql="SELECT cod_componente,des_componente,marca,modelo,serial1 FROM BIEN053 where (cod_bien_mue='$cod_bien_mue') ".$criterio;$res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Componetes del Biene</font>";$pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{
              if ($_GET["orden"]==""){$orden="cod_componente";} else{$orden=$_GET["orden"];} $tamPag=10;
                if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}
                $limitInf=($pagina-1)*$tamPag; $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}  else{ $seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}   if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT cod_componente,des_componente,marca,modelo,serial1 FROM BIEN053 where (cod_bien_mue='$cod_bien_mue') ".$criterio." ORDER BY ".$orden; $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=cod_componente&criterio=".$txt_criterio."'>Codigo </a></th>";
                echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=des_componente&criterio=".$txt_criterio."'>Denominacion Componente</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=marca&criterio=".$txt_criterio."'>Marca</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=modelo&criterio=".$txt_criterio."'>Modelo</a></th>";
                echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=serial1&criterio=".$txt_criterio."'>Serial</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)){ $linea=$linea+1; $cod_depe=$registro["cod_componente"]; 
                $des_componente=$registro["des_componente"];  $des_componente=str_replace("'","",$des_componente);  $des_componente=str_replace('"','',$des_componente);
				if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["cod_componente"]; ?>','<? echo $des_componente; ?>','<? echo $registro["marca"]; ?>','<? echo $registro["modelo"]; ?>','<? echo $registro["serial1"]; ?>')" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["cod_componente"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["des_componente"]; ?></b></font></td>
	<td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["marca"]; ?></b></font></td>
	<td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["modelo"]; ?></b></font></td>
	<td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["serial1"]; ?></b></font></td>
  </tr>
<?}}echo "</table>"; }
?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?      if($pagina>1){
           echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&criterio=".$txt_criterio."&cod_bien_mue=".$cod_bien_mue."'>";
           echo "<font face='verdana' size='-2'>Principio</font>";
           echo "</a>&nbsp;";
           echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$txt_criterio."&cod_bien_mue=".$cod_bien_mue."'>";
           echo "<font face='verdana' size='-2'>Anterior</font>";
           echo "</a>&nbsp;"; }
        for($i=$inicio;$i<=$final;$i++) {
           if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";}
             else{
               echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."&cod_bien_mue=".$cod_bien_mue."'>";
               echo "<font face='verdana' size='-2'>".$i."</font></a>&nbsp;"; } }
        if($pagina<$numPags){
          echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."&cod_bien_mue=".$cod_bien_mue."'>";
          echo "<font face='verdana' size='-2'>Siguiente</font></a>";
          echo " ";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$numPags."&orden=".$orden."&criterio=".$txt_criterio."&cod_bien_mue=".$cod_bien_mue."'>";
          echo "<font face='verdana' size='-2'>Final</font>";
          echo "</a>&nbsp;"; }?>
        </td></tr>
        </table>
<hr noshade style="color:CC6666;height:1px">

</body>
</html>
<?
  pg_close();
?>
