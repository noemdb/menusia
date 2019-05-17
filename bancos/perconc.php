<?php include ("../class/conect.php"); include ("../class/funciones.php"); $cod_banco=$_GET["cod_banco"]; $mes1="";$mes2="";$mes3="";$mes4="";$mes5="";$mes6="";$mes7="";$mes8="";$mes9="";$mes10="";$mes11="";$mes12="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $temp_mes="01";
$sql="SELECT * FROM ban009 where cod_banco='".$cod_banco."'";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$reg=pg_fetch_array($res,0); $temp_mes=$reg["u_conciliacion"];if($reg["mes01"]=="S"){$mes1='checked';}else{$mes1='';} if($reg["mes02"]=="S"){$mes2='checked';}else{$mes2='';} if($reg["mes03"]=="S"){$mes3='checked';}else{$mes3='';}
if($reg["mes04"]=="S"){$mes4='checked';}else{$mes4='';} if($reg["mes05"]=="S"){$mes5='checked';}else{$mes5='';} if($reg["mes06"]=="S"){$mes6='checked';}else{$mes6='';} if($reg["mes07"]=="S"){$mes7='checked';}else{$mes7='';}
if($reg["mes08"]=="S"){$mes8='checked';}else{$mes8='';} if($reg["mes09"]=="S"){$mes9='checked';}else{$mes9='';} if($reg["mes10"]=="S"){$mes10='checked';}else{$mes10='';} if($reg["mes11"]=="S"){$mes11='checked';}else{$mes11='';} if($reg["mes12"]=="S"){$mes12='checked';}else{$mes12='';}
} pg_close();  ?>
<table width="640" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td width="170"><span class="Estilo5">PERIODOS CONCILIADOS :</span></td>
  <td width="33"><div align="center"><input name="Mes1" type="checkbox" id="Mes1" value="checkbox" <?echo $mes1;?>> </div></td>
  <td width="33"><div align="center"><input name="Mes2" type="checkbox" id="Mes2" value="checkbox" <?echo $mes2;?>> </div></td>
  <td width="33"><div align="center"><input name="Mes3" type="checkbox" id="Mes3" value="checkbox" <?echo $mes3;?>> </div></td>
  <td width="33"><div align="center"><input name="Mes4" type="checkbox" id="Mes4" value="checkbox" <?echo $mes4;?>> </div></td>
  <td width="33"><div align="center"> <input name="Mes5" type="checkbox" id="Mes_Conc" value="checkbox" <?echo $mes5;?>> </div></td>
  <td width="33"><div align="center"> <input name="Mes6" type="checkbox" id="Mes_Conc" value="checkbox" <?echo $mes6;?>> </div></td>
  <td width="33"><div align="center"> <input name="Mes7" type="checkbox" id="Mes_Conc" value="checkbox" <?echo $mes7;?>> </div></td>
  <td width="33"><div align="center"> <input name="Mes8" type="checkbox" id="Mes8" value="checkbox" <?echo $mes8;?>></div></td>
  <td width="33"><div align="center"> <input name="Mes9" type="checkbox" id="Mes9" value="checkbox" <?echo $mes9;?>> </div></td>
  <td width="33"><div align="center"> <input name="Mes10" type="checkbox" id="Mes10" value="checkbox" <?echo $mes10;?>></div></td>
  <td width="33"><div align="center"> <input name="Mes11" type="checkbox" id="Mes11" value="checkbox" <?echo $mes11;?>> </div></td>
  <td width="33"><div align="center"> <input name="Mes12" type="checkbox" id="Mes12" value="checkbox" <?echo $mes12;?>> </div></td>
  <td width="60">&nbsp;</td>
</tr>