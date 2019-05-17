<?include ("../class/conect.php");  include ("../class/funciones.php");  $fecha_hoy=asigna_fecha_hoy();
if($_GET["fecha"]){$fecha=$_GET["fecha"];$codigo_mov=$_GET["codigo_mov"];}else{$codigo_mov="";$fecha=formato_aaaammdd($fecha_hoy);}
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; }
$res=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$cdia=substr($fecha,0,2); $cmes=substr($fecha,3,2); $cano=substr($fecha,6,4);
$ndia=$cdia*1; $nmes=$cmes*1; $nano=$cano*1;
$conex = odbc_pconnect("becoaldhdl", "USERODBC", "INFODBC54");

$ssql="Select * from ffapuin where xanoap=$nano and xmesap=$nmes and xdiaap=$ndia"; 
$ssql="Select * from ffapuin where xmesap=$nmes and xdiaap=$ndia"; 
//$rce = odbc_exec($conex, $ssql); 
//while (odbc_fetch_row($rce)){
//  $ano=trim(odbc_result($rce,4)); $mes=trim(odbc_result($rce,5)); $mes=Rellenarcerosizq($mes,2); $dia=trim(odbc_result($rce,6)); $dia=Rellenarcerosizq($dia,2);

$path="intbien.txt"; $fp = fopen($path,"r");
while ($linea= fgets($fp,1024)) {  $datos = explode(";", $linea);
  $ano=trim($datos[3]); $mes=trim($datos[4]); $mes=Rellenarcerosizq($mes,2); $dia=trim($datos[5]); $dia=Rellenarcerosizq($dia,2);
  
  if(($cdia==$dia)and($cmes==$mes)and($cano==$ano)){  $fecha_mov=$fecha;
  
  //      $num_asiento=odbc_result($rce,7); $tipo_contab=odbc_result($rce,8); $num_linea=odbc_result($rce,9); $num_cuenta=odbc_result($rce,10); $tipo_mov=odbc_result($rce,11);
  //      $clave_con=odbc_result($rce,12); $des_referencia=odbc_result($rce,13); $referencia_doc=odbc_result($rce,14); $tipo_doc="BIE"; $status_conc=odbc_result($rce,15);
  //      $monto_mov=odbc_result($rce,16); $monto_mov=cambia_coma_numero($monto_mov); $monto_mov=$monto_mov*1;
  //      $monto_mov_div=odbc_result($rce,17); $monto_mov_div=cambia_coma_numero($monto_mov_div); $monto_mov_div=$monto_mov_div*1;
  //      $cod_div=odbc_result($rce,18); $monto_div=odbc_result($rce,19); $monto_div=cambia_coma_numero($monto_div); $monto_div=$monto_div*1;
  //      $fecha_v=odbc_result($rce,20); $l=strlen($fecha_v); if($l==8){$fecha_vence=$fecha_v;}else{$fecha_vence=$fecha;}
  //      $cod_act=odbc_result($rce,21); $cod_destino=odbc_result($rce,22); $iva_mov =odbc_result($rce,23); $status_b=odbc_result($rce,24); $situacion=odbc_result($rce,25);
  //      $usuario_graba=odbc_result($rce,26); $fecha_graba=odbc_result($rce,27); $hora_graba=odbc_result($rce,28); $fecha_gen_mov=$fecha;

        $num_asiento=$datos[6]; $tipo_contab=$datos[7]; $num_linea=$datos[8]; $num_cuenta=$datos[9]; $tipo_mov=$datos[10];
        $clave_con=$datos[11]; $des_referencia=$datos[12]; $referencia_doc=$datos[13]; $tipo_doc="DEP"; $status_conc=$datos[14];
        $monto_mov=$datos[15]; $monto_mov=cambia_coma_numero($monto_mov); $monto_mov=$monto_mov*1;
        $monto_mov_div=$datos[16]; $monto_mov_div=cambia_coma_numero($monto_mov_div); $monto_mov_div=$monto_mov_div*1;
        $cod_div=$datos[17]; $monto_div=$datos[18]; $monto_div=cambia_coma_numero($monto_div); $monto_div=$monto_div*1;
        $fecha_v=$datos[19]; $l=strlen($fecha_v); if($l==8){$fecha_vence=$fecha_v;}else{$fecha_vence=$fecha;}
        $cod_act=$datos[20]; $cod_destino=$datos[21]; $iva_mov =$datos[22]; $status_b=$datos[23]; $situacion=$datos[24];
        $usuario_graba=$datos[25]; $fecha_graba=$datos[26]; $hora_graba=$datos[27]; $fecha_gen_mov=$fecha;
          
        $num_asiento=Rellenarcerosizq($num_asiento,5);

        $unidad=$cod_act.$cod_destino; $unidad=$unidad*1;
      if($unidad=="1051"){ $unidad="01-00-51";}
      if($unidad=="1052"){ $unidad="01-00-52";}
      if($unidad=="1053"){ $unidad="01-00-53";}
      if($unidad=="1054"){ $unidad="01-00-54";}
      if($unidad=="1055"){ $unidad="01-00-55";}
      if($unidad=="1056"){ $unidad="01-00-56";}
      if($unidad=="1057"){ $unidad="01-00-57";}
      if($unidad=="1058"){ $unidad="01-00-58";}

      if($unidad=="1062"){ $unidad="01-00-62";}
      if($unidad=="1063"){ $unidad="01-00-63";}
      if($unidad=="1064"){ $unidad="01-00-64";}
      if($unidad=="1065"){ $unidad="01-00-65";}
      if($unidad=="1066"){ $unidad="01-00-66";}
      if($unidad=="1067"){ $unidad="01-00-67";}

      if($unidad=="3051"){ $unidad="03-00-51";}
      if($unidad=="3052"){ $unidad="03-00-52";}
      if($unidad=="3053"){ $unidad="03-00-53";}
      if($unidad=="3054"){ $unidad="03-00-54";}
      if($unidad=="3055"){ $unidad="03-00-55";}
      if($unidad=="3056"){ $unidad="03-00-56";}
      if($unidad=="3057"){ $unidad="03-00-57";}
      if($unidad=="3058"){ $unidad="03-00-58";}
      if($unidad=="3059"){ $unidad="03-00-59";}

      if($unidad=="102151"){ $unidad="02-01-51";}
      if($unidad=="102152"){ $unidad="02-01-52";}
      if($unidad=="102153"){ $unidad="02-01-53";}
      //if($unidad=="102154"){ $unidad="02-01-54";}
	  
	  if($unidad=="102154"){ $unidad="02-05-53";}
	  
      //if($unidad=="102155"){ $unidad="02-01-55";}
	  if($unidad=="102154"){ $unidad="02-05-52";}
	  
      if($unidad=="102156"){ $unidad="02-01-56";}
      if($unidad=="102157"){ $unidad="02-01-57";}
      if($unidad=="102158"){ $unidad="02-01-58";}

      if($unidad=="102251"){ $unidad="02-02-51";}
      if($unidad=="102252"){ $unidad="02-02-52";}
      if($unidad=="102253"){ $unidad="02-02-53";}
      if($unidad=="102254"){ $unidad="02-02-54";}
      if($unidad=="102255"){ $unidad="02-02-55";}
      if($unidad=="102256"){ $unidad="02-02-56";}
      if($unidad=="102257"){ $unidad="02-02-57";}
      if($unidad=="102258"){ $unidad="02-02-58";}

      if($unidad=="102351"){ $unidad="02-03-51";}
      if($unidad=="102352"){ $unidad="02-03-52";}
      if($unidad=="102353"){ $unidad="02-03-53";}
      if($unidad=="102354"){ $unidad="02-03-54";}
      if($unidad=="102355"){ $unidad="02-03-55";}
      if($unidad=="102356"){ $unidad="02-03-56";}
      if($unidad=="102357"){ $unidad="02-03-57";}
      if($unidad=="102358"){ $unidad="02-03-58";}

      if($unidad=="102451"){ $unidad="02-04-51";}
      if($unidad=="202255"){ $unidad="02-02-55";}
      if($unidad=="301053"){ $unidad="01-00-53";}
      if($unidad=="4051"){ $unidad="04-00-51";}
      if($unidad=="3061"){ $unidad="03-00-61";}

        $cod_cuenta=""; $debito_credito=""; $ced_rif=""; $status="N"; $usuario_sia=""; $descripcion=$des_referencia; $referencia_r="";
        $status_1=""; $status_2=""; $campo_str1=""; $campo_str2=""; $campo_num1=0; $campo_num2=0; $inf_usuario="";
        $sql="Select * from con015 WHERE num_cuenta='$num_cuenta'";$res=pg_query($sql);$filas=pg_num_rows($res);
        if($filas>0){$reg=pg_fetch_array($res);$cod_cuenta=$reg["cod_cuenta"]; $status_2=$reg["gen_gas_presup"]; $campo_str2=$reg["cod_presup"];}
        
		$sql="Select con001.nombre_cuenta from con001 WHERE con001.codigo_cuenta='$cod_cuenta'";$res=pg_query($sql);$filas=pg_num_rows($res);
        if($filas>0){$registro=pg_fetch_array($res);$campo_str1=$registro["nombre_cuenta"]; }
        if($tipo_mov=="1"){$debito_credito="D";}else{$debito_credito="C";} $referencia_r=$referencia_doc;
		$monto=$monto_mov; $num_asiento=""; $referencia=$referencia_r; $sfecha=$fecha_mov; $tipo_comp="00000"; $nro_comp=Rellenarcerosizq($num_asiento,8);
		
		if($monto<0){$monto=$monto*-1; if($debito_credito=="D"){$debito_credito="C";}else{$debito_credito="D";}}
        $sql="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='$debito_credito'"; $res=pg_exec($conn,$sql); $filas=pg_numrows($res);
        if ($filas>0){ $reg=pg_fetch_array($res); $monto_c=$monto+$reg["monto_asiento"];   $monto_c=cambia_coma_numero($monto_c); $res=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','$debito_credito','$cod_cuenta',$monto_c,'$descripcion')"); }
          else{

$sqlf="SELECT INCLUYE_CON008('$codigo_mov','$referencia','$debito_credito','$cod_cuenta','$tipo_comp','$tipo_doc',$monto,'$debito_credito','C','N','01','0','$sfecha','$nro_comp','$ced_rif','','','$descripcion')";

$sqlf="SELECT INCLUYE_CON008('$codigo_mov','$referencia','$debito_credito','$cod_cuenta','$tipo_comp','',$monto,'$debito_credito','C','S','01','0','$descripcion')";

$res=pg_exec($conn,$sqlf); $error=pg_errormessage($conn); $error=substr($error, 0, 100);if (!$res){ echo "Comp:".$error,"<br>";
echo $sqlf,"<br>";
} }

		if($status_2=="S"){ $cod_presup=$unidad."-".$campo_str2; $fuente_financ="00";

$sql="SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','','0000','','0000','$referencia','0000','','0000','','','','$cod_cuenta','$nro_comp','','$sfecha','C','P','00000000','$sfecha',$monto,0,0,0)";  $res=pg_exec($conn,$sql);}
  

        
  }
} 

pg_close();?>
<iframe src="Det_inc_comp_caus.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="390" scrolling="auto" frameborder="0"> </iframe>



