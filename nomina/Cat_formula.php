<?include ("../class/conect.php");  error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<script language="JavaScript">
function cerrar_catalogo(tipo_nomina,descripcion,cod_concepto,denominacion,concecutivo,){
  window.opener.document.forms[0].txttipo_nomina.value = tipo_nomina;
  window.opener.document.forms[0].txtdescripcion.value = descripcion;
  window.opener.document.forms[0].txtcod_concepto.value = cod_concepto;
  window.opener.document.forms[0].txtdenominacion.value = den_concepto;
  window.opener.document.forms[0].txttipo_nomina.focus();
  window.close();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Catalogo Tipos de N&oacute;minas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
</head><body>
<?
        $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1; 
        if ($_GET["criterio"]!=""){ $txt_criterio = $_GET["criterio"]; $txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where tipo_nomina like '%" . $txt_criterio . "%' or descripcion like '%" . $txt_criterio . "%'";
        }
        $sql="SELECT * NOM003.Tipo_Nomina,NOM001.Descripcion,NOM003.Cod_Concepto,NOM002.Denominacion,NOM003.Consecutivo " .$criterio;
        $res=pg_query($sql); $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
        }else{
              if ($_GET["orden"]==""){$orden="tipo_nomina";}else{$orden=$_GET["orden"];} $tamPag=10;if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}$limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;}else{$seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * NOM003.Tipo_Nomina,NOM001.Descripcion,NOM003.Cod_Concepto,NOM002.Denominacion,NOM003.Consecutivo " & " ORDER BY NOM003.Tipo_Nomina,NOM003.Cod_Concepto,NOM003.Consecutivo".$orden;
                $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th bgcolor='#00CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=tipo_nomina&criterio=".$txt_criterio."'>Tipo N&oacute;mina</a></th>";
                echo "<th bgcolor='#00CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=descripcion&criterio=".$txt_criterio."'>Descripci&oacute;n</a></th>";
				echo "<th bgcolor='#00CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=cod_concepto&criterio=".$txt_criterio."'>C&oacute;digo Concepto</a></th>";
				echo "<th bgcolor='#00CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=denominacion&criterio=".$txt_criterio."'>Denominaci&oacute;n</a></th>";
				echo "<th bgcolor='#00CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=concecutivo&criterio=".$txt_criterio."'>Concecutivo</a></th>";
                $linea=0;   $Salir=false;
                while($registro=pg_fetch_array($res))
                {
                $linea=$linea+1;                if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
<!-- tabla de resultados -->
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["tipo_nomina"]; ?>','<? echo $registro["descripcion"]; ?>')" >
   <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["tipo_nomina"]; ?></b></font></td>
   <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["descripcion"]; ?></b></font></td>
   <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["cod_concepto"]; ?></b></font></td>
   <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["desnominacion"]; ?></b></font></td>
   <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["concecutivo"]; ?></b></font></td>
   </tr>
<!-- fin tabla resultados -->
<?}
                }//fin while
                echo "</table>";
        }//fin if
        //////////a partir de aqui viene la paginacion
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

<form action="../Nomina/Cat_formula.php" method="get">
Criterio de b&uacute;squeda:
<input type="text" name="criterio" size="22" maxlength="150">
<input type="submit" value="Buscar">
</div>
</form>

</body>
</html>
<?
  pg_close();
?>