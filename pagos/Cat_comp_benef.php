<?include ("../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE);
if (!$_GET){$codigo_mov="";$ivag=0;$ref_comp="N";$ced_rif="";$tipo_comp="";$ref_compromiso="";$monto=0;}
else{$codigo_mov=$_GET["codigo_mov"];$ivag=$_GET["ivag"];$ref_comp=$_GET["ref_comp"];$ced_rif=$_GET["ced_rif"];$tipo_comp=$_GET["tipo_comp"];$ref_compromiso=$_GET["ref_compromiso"];$monto=$_GET["monto"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$campo502=""; $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];} $g_comprobante=substr($campo502,3,1); $aprueba_comp=substr($campo502,15,1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Catalogo de Compromisos por beneficiario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function carga_monto(mced_rif,mtipo_comp,mref_comp){
  ajaxSenddoc('GET', 'amontfac.php?tipo='+mtipo_comp+'&refcomp='+mref_comp+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'montOb', 'innerHTML');
}
function llama_ant(mced_rif,mtipo_comp,mref_comp){var mmonto;var murl;
  mmonto=document.form1.txtmonto_sin_iva.value;
  murl="Inc_fact_ord.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>&ivag=<?echo$ivag;?>&ref_comp=<?echo$ref_comp;?>&ced_rif="+mced_rif+"&tipo_comp="+mtipo_comp+"&ref_compromiso="+mref_comp+"&monto="+mmonto;
  document.location=murl;
 }
function cerrar_catalogo(mced_rif,mtipo_comp,mref_comp){ carga_monto(mced_rif,mtipo_comp,mref_comp);   llama_ant(mced_rif,mtipo_comp,mref_comp); }
</script></head>
<body>
<?      $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1;
        if (!$_GET){$codigo_mov="";$ivag=0;$ref_comp="N";$ced_rif="";$tipo_comp="";$ref_compromiso="";}else{$codigo_mov=$_GET["codigo_mov"];$ivag=$_GET["ivag"];$ref_comp=$_GET["ref_comp"];$ced_rif=$_GET["ced_rif"];$tipo_comp=$_GET["tipo_comp"];$ref_compromiso=$_GET["ref_compromiso"];}
        $criterio = "and (ced_rif='$ced_rif') and (anulado='N') "; if($aprueba_comp=="S"){ $criterio = $criterio."and  pre006.aprobado='S'";}
        $sql="select pre006.referencia_comp,pre006.tipo_compromiso,pre006.cod_comp,pre006.fecha_compromiso,pre006.cod_tipo_comp,pre006.descripcion_comp from pre006 where (text(pre006.referencia_comp)||text(pre006.tipo_compromiso)||text(pre006.cod_comp) in (select text(pre036.referencia_comp)||text(pre036.tipo_compromiso)||text(pre036.cod_comp) from pre036 where (monto-causado-ajustado>0) and (tipo_compromiso<>'0000') and (tipo_compromiso<>'A000'))) ".$criterio;
        $res=pg_query($sql); $numeroRegistros=pg_num_rows($res); 
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Compromisos</font>";$pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{
              if ($_GET["orden"]==""){$orden="tipo_compromiso,referencia_comp";}else{$orden=$_GET["orden"];}  $tamPag=10;
                if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;} else{$pagina=$_GET["pagina"];} $limitInf=($pagina-1)*$tamPag;  $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}  else{ $seccionActual=intval(($pagina-1)/$tamPag);$inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;} if ($final>$numPags){$final=$numPags;} }
                $sql="select pre006.referencia_comp,pre006.tipo_compromiso,pre006.cod_comp,pre006.fecha_compromiso,pre006.cod_tipo_comp,pre006.descripcion_comp from pre006 where (text(pre006.referencia_comp)||text(pre006.tipo_compromiso)||text(pre006.cod_comp) in (select text(pre036.referencia_comp)||text(pre036.tipo_compromiso)||text(pre036.cod_comp) from pre036 where (monto-causado-ajustado>0) and (tipo_compromiso<>'0000') and (tipo_compromiso<>'A000'))) ".$criterio." ORDER BY ".$orden;
                $res=pg_query($sql);
                echo "<table align='center' width='98%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th bgcolor='#99CCFF'><a class='ord' >Tipo</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' >Referencia</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' >Fecha</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' >Descripcion</a></th>";
                $linea=0;   $Salir=false;
                while($registro=pg_fetch_array($res)){ $linea=$linea+1;
                $descripcion=$registro["descripcion_comp"];  $sfecha=$registro["fecha_compromiso"];
                $descripcion2=substr($descripcion,0,200); $descripcion=substr($descripcion,0,150);
                $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
                if  ($linea>$limitInf+$tamPag){$Salir=true;}   if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $ced_rif;?>','<? echo $registro["tipo_compromiso"];?>','<? echo $registro["referencia_comp"];?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["tipo_compromiso"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["referencia_comp"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $fecha; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $descripcion; ?></b></font></td>
  </tr>
<?}} echo "</table>"; }
?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
  <?    if($pagina>1){
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&criterio=".$txt_criterio."&codigo_mov=".$codigo_mov."&ivag=".$ivag."&ref_comp=".$ref_comp."&ced_rif=".$ced_rif."'>";
          echo "<font face='verdana' size='-2'>Principio</font>";
          echo "</a>&nbsp;";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$txt_criterio."&codigo_mov=".$codigo_mov."&ivag=".$ivag."&ref_comp=".$ref_comp."&ced_rif=".$ced_rif."'>";
          echo "<font face='verdana' size='-2'>Anterior</font>";
          echo "</a>&nbsp;"; }
        for($i=$inicio;$i<=$final;$i++) {
          if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";}
            else{echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."&codigo_mov=".$codigo_mov."&ivag=".$ivag."&ref_comp=".$ref_comp."&ced_rif=".$ced_rif."'>";
                 echo "<font face='verdana' size='-2'>".$i."</font></a>&nbsp;"; } }
        if($pagina<$numPags){
          echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."&codigo_mov=".$codigo_mov."&ivag=".$ivag."&ref_comp=".$ref_comp."&ced_rif=".$ced_rif."'>";
          echo "<font face='verdana' size='-2'>Siguiente</font></a>";
          echo " ";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$numPags."&orden=".$orden."&criterio=".$txt_criterio."&codigo_mov=".$codigo_mov."&ivag=".$ivag."&ref_comp=".$ref_comp."&ced_rif=".$ced_rif."'>";
          echo "<font face='verdana' size='-2'>Final</font>";
          echo "</a>&nbsp;"; }?>
        </td></tr>
        </table>
<hr noshade style="color:CC6666;height:1px">
<form name="form1" >
<div id="montOb">
<input name="txtmonto_sin_iva" type="hidden" id="txtmonto_sin_iva" value="0">
</div>
</form>
</body>
</html>
<? pg_close(); ?>
