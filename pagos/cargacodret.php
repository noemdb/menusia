<?php include ("../class/conect.php");  include ("../class/funciones.php"); 
$password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"]; $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $mcod_part_iva="403-18-01"; 
$StrSQL="select * from pre026 where (codigo_mov='$codigo_mov') and (monto>0) and (cod_presup not in (select cod_presup from pre026 where (cod_presup LIKE '%$mcod_part_iva%'))) order by tipo_compromiso,referencia_comp,cod_presup,fuente_financ"; $res=pg_query($StrSQL);
//echo $StrSQL;
?><select name="txtcod_ret" size="1" id="txtcod_ret" onFocus="encender(this)" onBlur="apaga_cod_ret(this)" onchange="chequea_cod_ret(this.form);"><?
while($registro=pg_fetch_array($res))
{$codigo=$registro["tipo_compromiso"]." ".$registro["referencia_comp"]." ".$registro["fuente_financ"]." ".$registro["cod_presup"];
?><option value="<? echo $codigo;?>"><? echo $codigo;?></option><?}?>  </select><?pg_close();?>
