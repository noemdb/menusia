<?include ("../class/conect.php");  error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<script language="JavaScript">
function cerrar_catalogo(mcod_banco,mnombre,mtipo_mov,mref,mfecha,mcedrif,mnomb){
  window.opener.document.forms[0].txtcod_banco.value=mcod_banco;
  window.opener.document.forms[0].txtnombre_banco.value=mnombre;
  window.opener.document.forms[0].txttipo_movimiento.value=mtipo_mov;
  window.opener.document.forms[0].txtreferencia.value=mref;
  window.opener.document.forms[0].txtfecha.value=mfecha;
  window.opener.document.forms[0].txtced_rif.value=mcedrif;
  window.opener.document.forms[0].txtnombre.value=mnomb;
  window.opener.document.forms[0].txtreferencia.focus();
  window.close();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Catalogo de Bancos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head><body>
<?      $criterio = ""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1;
        $criterio="where ((tipo_mov_libro='CHQ') or (tipo_mov_libro='NDB')) ";$txt_criterio="";
        if ($_GET["criterio"]!=""){$txt_criterio=$_GET["criterio"];$txt_criterio=strtoupper ($txt_criterio);
        $criterio= $criterio. " and (referencia like '%" . $txt_criterio . "%' or cod_banco like '%" . $txt_criterio . "%' or descrip_mov_libro like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%')";}
        $sql="SELECT * FROM MOV_LIBROS  ".$criterio; $res=pg_query($sql);  $numeroRegistros=pg_num_rows($res);
         if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Movimientos</font>"; $pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{
              if ($_GET["orden"]==""){$orden="cod_banco,referencia";}else{$orden=$_GET["orden"];} $tamPag=10;  
			  if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}$limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;} else{$seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1; if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;} if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM MOV_LIBROS ".$criterio." ORDER BY ".$orden; $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=cod_banco,referencia,tipo_mov_libroa&criterio=".$txt_criterio."'>Banco</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=referencia,cod_banco&criterio=".$txt_criterio."'>Referencia</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=tipo_mov_libro,cod_banco,referencia&criterio=".$txt_criterio."'>Tipo</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=fecha_mov_libro,cod_banco,referencia&criterio=".$txt_criterio."'>Fecha</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=descrip_mov_libro&criterio=".$txt_criterio."'>Descripci&oacute;n</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)) { $linea=$linea+1;
                $descripcion=$registro["descrip_mov_libro"]; $sfecha=$registro["fecha_mov_libro"]; $descripcion=substr($descripcion,0,150); $fecha=substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
                if ($linea>$limitInf+$tamPag){$Salir=true;}  if (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["cod_banco"];?>','<? echo $registro["nombre_banco"];?>','<? echo $registro["tipo_mov_libro"]; ?>','<? echo $registro["referencia"]; ?>','<? echo $fecha; ?>','<? echo $registro["ced_rif"]; ?>','<? echo $registro["nombre"]; ?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["cod_banco"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["referencia"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["tipo_mov_libro"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $fecha; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $descripcion; ?></b></font></td>
  </tr>
<?}}echo "</table>"; }?>
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
<form action="Cat_mov_chq_ndb.php" method="get">
Criterio de b&uacute;squeda: <input type="text" name="criterio" size="22" maxlength="150"> <input type="submit" value="Buscar">
</div></form></body> </html> <? pg_close();?>