<?php include ("../class/conect.php");  include ("../class/funciones.php");
$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];$tipo=$_GET["tipo"];$referncia=$_GET["referencia"];$codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$des_tipo_orden="";$cod_cont=""; $tot_comp=0;
$StrSQL="select sum(monto) as total_comp from pre036 where referencia_comp='$referncia' and tipo_compromiso='$tipo'";$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $tot_comp=$registro["total_comp"]; }
$StrSQL="select * from pag036 where codigo_mov='$codigo_mov'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$StrSQL="SELECT UPDATE_PAG036_MONTO(2,'$codigo_mov',0,$tot_comp)"; $resultado=pg_exec($conn,$StrSQL); } $tot_comp=formato_monto($tot_comp);
?> <input class="Estilo10" name="txttotal_comp" type="text" id="txttotal_comp" size="20" align="right" maxlength="20" readonly  value="<? echo $tot_comp?>" onkeypress="return stabular(event,this)" ><?
pg_close();?>