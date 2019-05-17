<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");  include ("../../class/configura.inc");
$codigo_informe=$_GET["codigo_informe"]; $nombre_archivo=$_GET["nombre_archivo"]; $periodo=$_GET["periodo"]; $seleccion=$_GET["seleccion"];
echo "ESPERE POR FAVOR CALCULANDO INFORM CONTABLE....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="Select * from SIA005 where campo501='06'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $Formato_Cuenta=$registro["campo504"]; $Cta_Activo=$registro["campo505"];$Cta_Pasivo=$registro["campo506"];
   $Cta_Ingreso=$registro["campo507"];  $Cta_Egreso=$registro["campo508"];  $Cta_Resultado=$registro["campo509"];$Cta_Capital=$registro["campo510"]; $Cta_Orden=$registro["campo511"];
   $Cta_Result_Eje=$registro["campo512"]; $Cta_Result_Ant=$registro["campo513"]; $Cta_Costo_Venta=$registro["campo517"];  }
$Sql="SELECT con006.tipo_informe,con006.linea,con006.codigo_cuenta,con006.cod_cuenta,con006.nombre_cuenta,con006.status_linea,con006.calculable,con006.moperacion,con006.columna,con001.saldo_anterior,con001.cargable,con001.tsaldo,con001.clasificacion,con001.cta_asociada,con001.debito_01,con001.credito_01,con001.debito_02,con001.credito_02,con001.debito_03,con001.credito_03,con001.debito_04,con001.credito_04,con001.debito_05,con001.credito_05,con001.debito_06,con001.credito_06,con001.debito_07,con001.credito_07,con001.debito_08,con001.credito_08,con001.debito_09,con001.credito_09,con001.debito_10,con001.credito_10,con001.debito_11,con001.credito_11,con001.debito_12,con001.credito_12,con004.monto_pp01,con004.monto_pp02,con004.monto_pp03,con004.monto_pp04,con004.monto_pp05,con004.monto_pp06,con004.monto_pp07,con004.monto_pp08,con004.monto_pp09,con004.monto_pp10,con004.monto_pp11,con004.monto_pp12,con004.monto_rp01,con004.monto_rp02,con004.monto_rp03,con004.monto_rp04,con004.monto_rp05,con004.monto_rp06,con004.monto_rp07,con004.monto_rp08,con004.monto_rp09,con004.monto_rp10,con004.monto_rp11,con004.monto_rp12 FROM (con006 LEFT OUTER JOIN con001 ON con001.codigo_cuenta=con006.codigo_cuenta) LEFT OUTER JOIN con004 ON con004.codigo_cuenta=con001.codigo_cuenta Where (con006.tipo_informe='$codigo_informe')";
$res=pg_query($Sql); 
while($registro=pg_fetch_array($res)){
  $linea=$registro["linea"]; $codigo_cuenta=$registro["codigo_cuenta"];   $nombre_cuenta=$registro["nombre_cuenta"]; $cod_cuenta=$registro["cod_cuenta"];
  $status_linea=$registro["status_linea"]; $calculable=$registro["calculable"]; $moperacion=$registro["moperacion"]; $columna=$registro["columna"];
  $cargable=$registro["cargable"];$clasificacion=$registro["clasificacion"];  $tsaldo=$registro["tsaldo"];  $cta_asociada=$registro["cta_asociada"];  $saldo_anterior=$registro["saldo_anterior"];

  $mcta_asociada="";$mcargable="N";$mtsaldo="";$mclasificacion="";$msaldo_anterior=0;
  $msaldo_p01=0;$msaldo_p02=0;$msaldo_p03=0;$msaldo_p04=0;$msaldo_p05=0;$msaldo_p06=0;$msaldo_p07=0;$msaldo_p08=0;$msaldo_p09=0;$msaldo_p10=0;$msaldo_p11=0;$msaldo_p12=0;
  $macumulado_p01=0;$macumulado_p02=0;$macumulado_p03=0;$macumulado_p04=0;$macumulado_p05=0;$macumulado_p06=0;$macumulado_p07=0;$macumulado_p08=0;$macumulado_p09=0;$macumulado_p10=0;$macumulado_p11=0;$macumulado_p12=0;
  $mmonto_pp01=0;$mmonto_pp02=0;$mmonto_pp03=0;$mmonto_pp04=0;$mmonto_pp05=0;$mmonto_pp06=0;$mmonto_pp07=0;$mmonto_pp08=0;$mmonto_pp09=0;$mmonto_pp10=0;$mmonto_pp11=0;$mmonto_pp12=0;
  $mmonto_pa01=0;$mmonto_pa02=0;$mmonto_pa03=0;$mmonto_pa04=0;$mmonto_pa05=0;$mmonto_pa06=0;$mmonto_pa07=0;$mmonto_pa08=0;$mmonto_pa09=0;$mmonto_pa10=0;$mmonto_pa11=0;$mmonto_pa12=0;
  $mdebe01=0;$mdebe02=0;$mdebe03=0;$mdebe04=0;$mdebe05=0;$mdebe06=0;$mdebe07=0;$mdebe08=0;$mdebe09=0;$mdebe10=0;$mdebe11=0;$mdebe12=0;
  $mhaber01=0;$mhaber02=0;$mhaber03=0;$mhaber04=0;$mhaber05=0;$mhaber06=0;$mhaber07=0;$mhaber08=0;$mhaber09=0;$mhaber10=0;$mhaber11=0;$mhaber12=0;
  if($calculable=="N"){ $monto_pp01=$registro["monto_pp01"];
    if($cargable==""){ $cargable="";
    }else{	$mcta_asociada=$cta_asociada;$mcargable=$cargable;$mtsaldo=$tsaldo;$mclasificacion=$clasificacion;$msaldo_anterior=$saldo_anterior;
	  $mdebe01=$registro["debito_01"];$mdebe02=$registro["debito_02"];$mdebe03=$registro["debito_03"];$mdebe04=$registro["debito_04"];$mdebe05=$registro["debito_05"];$mdebe06=$registro["debito_06"];
      $mdebe07=$registro["debito_07"];$mdebe08=$registro["debito_08"];$mdebe09=$registro["debito_09"];$mdebe10=$registro["debito_10"];$mdebe11=$registro["debito_11"];$mdebe12=$registro["debito_12"];
      $mhaber01=$registro["credito_01"];$mhaber02=$registro["credito_02"];$mhaber03=$registro["credito_03"];$mhaber04=$registro["credito_04"];$mhaber05=$registro["credito_05"];$mhaber06=$registro["credito_06"];
      $mhaber07=$registro["credito_07"];$mhaber08=$registro["credito_08"];$mhaber09=$registro["credito_09"];$mhaber10=$registro["credito_10"];$mhaber11=$registro["credito_11"];$mhaber12=$registro["credito_12"];  
	  
	  If ($tsaldo=="Deudor"){
        $msaldo_p01 = Round(($registro["debito_01"]-$registro["credito_01"]), 2);
        $macumulado_p01 = Round(($registro["saldo_anterior"]+($registro["debito_01"]-$registro["credito_01"])), 2);
        $msaldo_p02 = Round(($registro["debito_02"]-$registro["credito_02"]), 2);
        $macumulado_p02 = Round(($macumulado_p01+($registro["debito_02"]-$registro["credito_02"])), 2);
        $msaldo_p03 = Round(($registro["debito_03"]-$registro["credito_03"]), 2);
        $macumulado_p03 = Round(($macumulado_p02+($registro["debito_03"]-$registro["credito_03"])), 2);
        $msaldo_p04 = Round(($registro["debito_04"]-$registro["credito_04"]), 2);
        $macumulado_p04 = Round(($macumulado_p03+($registro["debito_04"]-$registro["credito_04"])), 2);
        $msaldo_p05 = Round(($registro["debito_05"]-$registro["credito_05"]), 2);
        $macumulado_p05 = Round(($macumulado_p04+($registro["debito_05"]-$registro["credito_05"])), 2);
        $msaldo_p06 = Round(($registro["debito_06"]-$registro["credito_06"]), 2);
        $macumulado_p06 = Round(($macumulado_p05+($registro["debito_06"]-$registro["credito_06"])), 2);
        $msaldo_p07 = Round(($registro["debito_07"]-$registro["credito_07"]), 2);
        $macumulado_p07 = Round(($macumulado_p06+($registro["debito_07"]-$registro["credito_07"])), 2);
        $msaldo_p08 = Round(($registro["debito_08"]-$registro["credito_08"]), 2);
        $macumulado_p08 = Round(($macumulado_p07+($registro["debito_08"]-$registro["credito_08"])), 2);
        $msaldo_p09 = Round(($registro["debito_09"]-$registro["credito_09"]), 2);
        $macumulado_p09 = Round(($macumulado_p08+($registro["debito_09"]-$registro["credito_09"])), 2);
        $msaldo_p10 = Round(($registro["debito_10"]-$registro["credito_10"]), 2);
        $macumulado_p10 = Round(($macumulado_p09+($registro["debito_10"]-$registro["credito_10"])), 2);
        $msaldo_p11 = Round(($registro["debito_11"]-$registro["credito_11"]), 2);
        $macumulado_p11 = Round(($macumulado_p10+($registro["debito_11"]-$registro["credito_11"])), 2);
        $msaldo_p12 = Round(($registro["debito_12"]-$registro["credito_12"]), 2);
        $macumulado_p12 = Round(($macumulado_p11+($registro["debito_12"]-$registro["credito_12"])), 2);
      }else{
        $msaldo_p01 = Round(($registro["credito_01"]-$registro["debito_01"]), 2);
        $macumulado_p01 = Round(($registro["saldo_anterior"]+($registro["credito_01"]-$registro["debito_01"])), 2);
        $msaldo_p02 = Round(($registro["credito_02"]-$registro["debito_02"]), 2);
        $macumulado_p02 = Round(($macumulado_p01+($registro["credito_02"]-$registro["debito_02"])), 2);
        $msaldo_p03 = Round(($registro["credito_03"]-$registro["debito_03"]), 2);
        $macumulado_p03 = Round(($macumulado_p02+($registro["credito_03"]-$registro["debito_03"])), 2);
        $msaldo_p04 = Round(($registro["credito_04"]-$registro["debito_04"]), 2);
        $macumulado_p04 = Round(($macumulado_p03+($registro["credito_04"]-$registro["debito_04"])), 2);
        $msaldo_p05 = Round(($registro["credito_05"]-$registro["debito_05"]), 2);
        $macumulado_p05 = Round(($macumulado_p04+($registro["credito_05"]-$registro["debito_05"])), 2);
        $msaldo_p06 = Round(($registro["credito_06"]-$registro["debito_06"]), 2);
        $macumulado_p06 = Round(($macumulado_p05+($registro["credito_06"]-$registro["debito_06"])), 2);
        $msaldo_p07 = Round(($registro["credito_07"]-$registro["debito_07"]), 2);
        $macumulado_p07 = Round(($macumulado_p06+($registro["credito_07"]-$registro["debito_07"])), 2);
        $msaldo_p08 = Round(($registro["credito_08"]-$registro["debito_08"]), 2);
        $macumulado_p08 = Round(($macumulado_p07+($registro["credito_08"]-$registro["debito_08"])), 2);
        $msaldo_p09 = Round(($registro["credito_09"]-$registro["debito_09"]), 2);
        $macumulado_p09 = Round(($macumulado_p08+($registro["credito_09"]-$registro["debito_09"])), 2);
        $msaldo_p10 = Round(($registro["credito_10"]-$registro["debito_10"]), 2);
        $macumulado_p10 = Round(($macumulado_p09+($registro["credito_10"]-$registro["debito_10"])), 2);
        $msaldo_p11 = Round(($registro["credito_11"]-$registro["debito_11"]), 2);
        $macumulado_p11 = Round(($macumulado_p10+($registro["credito_11"]-$registro["debito_11"])), 2);
        $msaldo_p12 = Round(($registro["credito_12"]-$registro["debito_12"]), 2);
        $macumulado_p12 = Round(($macumulado_p11+($registro["credito_12"]-$registro["debito_12"])), 2);
      }	  
    }
	if($monto_pp01==""){
    }else{
	    $mmonto_pp01 = $registro["monto_pp01"]+$registro["monto_rp01"];
	    $mmonto_pa01 = $mmonto_pp01;
	    $mmonto_pp02 = $registro["monto_pp02"]+$registro["monto_rp02"];
	    $mmonto_pa02 = $mmonto_pa01 + $mmonto_pp02;
	    $mmonto_pp03 = $registro["monto_pp03"]+$registro["monto_rp03"];
	    $mmonto_pa03 = $mmonto_pa02 + $mmonto_pp03;
	    $mmonto_pp04 = $registro["monto_pp04"]+$registro["monto_rp04"];
	    $mmonto_pa04 = $mmonto_pa03 + $mmonto_pp04;
	    $mmonto_pp05 = $registro["monto_pp05"]+$registro["monto_rp05"];
	    $mmonto_pa05 = $mmonto_pa04 + $mmonto_pp05;
	    $mmonto_pp06 = $registro["monto_pp06"]+$registro["monto_rp06"];
	    $mmonto_pa06 = $mmonto_pa05 + $mmonto_pp06;
	    $mmonto_pp07 = $registro["monto_pp07"]+$registro["monto_rp07"];
	    $mmonto_pa07 = $mmonto_pa06 + $mmonto_pp07;
	    $mmonto_pp08 = $registro["monto_pp08"]+$registro["monto_rp08"];
	    $mmonto_pa08 = $mmonto_pa07 + $mmonto_pp08;
	    $mmonto_pp09 = $registro["monto_pp09"]+$registro["monto_rp09"];
	    $mmonto_pa09 = $mmonto_pa08 + $mmonto_pp09;
	    $mmonto_pp10 = $registro["monto_pp10"]+$registro["monto_rp10"];
	    $mmonto_pa10 = $mmonto_pa09 + $mmonto_pp10;
	    $mmonto_pp11 = $registro["monto_pp11"]+$registro["monto_rp11"];
	    $mmonto_pa11 = $mmonto_pa10 + $mmonto_pp11;
	    $mmonto_pp12 = $registro["monto_pp12"]+$registro["monto_rp12"];
	    $mmonto_pa12 = $mmonto_pa11 + $mmonto_pp12;
	}
 }else{
   if($cargable==""){ $cargable=""; }else{$mcta_asociada=$cta_asociada;$mcargable=$cargable;$mtsaldo=$tsaldo;$mclasificacion=$clasificacion;}
   $Sql2="SELECT con007.codigo_cuenta,con007.operacion,con007.status_c,con001.saldo_anterior,con001.cargable,con001.tsaldo,con001.clasificacion,con001.cta_asociada,con001.debito_01,con001.credito_01,con001.debito_02,con001.credito_02,con001.debito_03,con001.credito_03,con001.debito_04,con001.credito_04,con001.debito_05,con001.credito_05,con001.debito_06,con001.credito_06,con001.debito_07,con001.credito_07,con001.debito_08,con001.credito_08,con001.debito_09,con001.credito_09,con001.debito_10,con001.credito_10,con001.debito_11,con001.credito_11,con001.debito_12,con001.credito_12,con004.monto_pp01,con004.monto_pp02,con004.monto_pp03,con004.monto_pp04,con004.monto_pp05,con004.monto_pp06,con004.monto_pp07,con004.monto_pp08,con004.monto_pp09,con004.monto_pp10,con004.monto_pp11,con004.monto_pp12,con004.monto_rp01,con004.monto_rp02,con004.monto_rp03,con004.monto_rp04,con004.monto_rp05,con004.monto_rp06,con004.monto_rp07,con004.monto_rp08,con004.monto_rp09,con004.monto_rp10,con004.monto_rp11,con004.monto_rp12 FROM con007,con001 LEFT OUTER JOIN con004 ON con004.codigo_cuenta=con001.codigo_cuenta WHERE (con007.codigo_cuenta=con001.codigo_cuenta) AND (con007.tipo_informe='$codigo_informe') And (con007.linea='$linea') order by con007.codigo_cuenta";
   $res2=pg_query($Sql2); 
   while($reg2=pg_fetch_array($res2)){ $codigo_cuenta=$reg2["codigo_cuenta"]; $status_c=$reg2["status_c"];   $saldo_ant=$reg2["saldo_anterior"]; $reg2["tsaldo"];
      $procesado=0; $monto_pp01=$reg2["monto_pp01"]; $operacion=$reg2["operacion"];
	  if($status_c=="D"){ $procesado=1;
	    $msaldo01 = Round(($reg2["debito_01"]), 2);
        $macumu01 = Round(($reg2["debito_01"]), 2);
	    $msaldo02 = Round(($reg2["debito_02"]), 2);
        $macumu02 = Round(($macumu01 + ($reg2["debito_02"])), 2);
	    $msaldo03 = Round(($reg2["debito_03"]), 2);
        $macumu03 = Round(($macumu02 + ($reg2["debito_03"])), 2);
	    $msaldo04 = Round(($reg2["debito_04"]), 2);
        $macumu04 = Round(($macumu03 + ($reg2["debito_04"])), 2);
	    $msaldo05 = Round(($reg2["debito_05"]), 2);
        $macumu05 = Round(($macumu04 + ($reg2["debito_05"])), 2);
	    $msaldo06 = Round(($reg2["debito_06"]), 2);
        $macumu06 = Round(($macumu05 + ($reg2["debito_06"])), 2);
	    $msaldo07 = Round(($reg2["debito_07"]), 2);
        $macumu07 = Round(($macumu06 + ($reg2["debito_07"])), 2);
	    $msaldo08 = Round(($reg2["debito_08"]), 2);
        $macumu08 = Round(($macumu07 + ($reg2["debito_08"])), 2);
	    $msaldo09 = Round(($reg2["debito_09"]), 2);
        $macumu09 = Round(($macumu08 + ($reg2["debito_09"])), 2);
	    $msaldo10 = Round(($reg2["debito_10"]), 2);
        $macumu00 = Round(($macumu09 + ($reg2["debito_10"])), 2);
	    $msaldo11 = Round(($reg2["debito_11"]), 2);
        $macumu01 = Round(($macumu10 + ($reg2["debito_11"])), 2);
	    $msaldo12 = Round(($reg2["debito_12"]), 2);
        $macumu02 = Round(($macumu11 + ($reg2["debito_12"])), 2);
	  }
	  if($status_c=="C"){ $procesado=1;
	    $msaldo01 = Round(($reg2["credito_01"]), 2);
        $macumu01 = Round(($reg2["credito_01"]), 2);
	    $msaldo02 = Round(($reg2["credito_02"]), 2);
        $macumu02 = Round(($macumu01 + ($reg2["credito_02"])), 2);
	    $msaldo03 = Round(($reg2["credito_03"]), 2);
        $macumu03 = Round(($macumu02 + ($reg2["credito_03"])), 2);
	    $msaldo04 = Round(($reg2["credito_04"]), 2);
        $macumu04 = Round(($macumu03 + ($reg2["credito_04"])), 2);
	    $msaldo05 = Round(($reg2["credito_05"]), 2);
        $macumu05 = Round(($macumu04 + ($reg2["credito_05"])), 2);
	    $msaldo06 = Round(($reg2["credito_06"]), 2);
        $macumu06 = Round(($macumu05 + ($reg2["credito_06"])), 2);
	    $msaldo07 = Round(($reg2["credito_07"]), 2);
        $macumu07 = Round(($macumu06 + ($reg2["credito_07"])), 2);
	    $msaldo08 = Round(($reg2["credito_08"]), 2);
        $macumu08 = Round(($macumu07 + ($reg2["credito_08"])), 2);
	    $msaldo09 = Round(($reg2["credito_09"]), 2);
        $macumu09 = Round(($macumu08 + ($reg2["credito_09"])), 2);
	    $msaldo10 = Round(($reg2["credito_10"]), 2);
        $macumu00 = Round(($macumu09 + ($reg2["credito_10"])), 2);
	    $msaldo11 = Round(($reg2["credito_11"]), 2);
        $macumu01 = Round(($macumu10 + ($reg2["credito_11"])), 2);
	    $msaldo12 = Round(($reg2["credito_12"]), 2);
        $macumu02 = Round(($macumu11 + ($reg2["credito_12"])), 2);
	  }
	  if($procesado==0){
	    //if($linea=="420"){ echo " Cuenta : ".$codigo_cuenta." Saldo: ".$saldo_ant." ".$status_c,"<br>";    }
	    If ($reg2["tsaldo"]=="Deudor") {
            $msaldo01 = Round(($reg2["debito_01"] - $reg2["credito_01"]), 2);
            $macumu01 = Round($reg2["saldo_anterior"] + ($reg2["debito_01"] - $reg2["credito_01"]), 2);
            $msaldo02 = Round(($reg2["debito_02"] - $reg2["credito_02"]), 2);
            $macumu02 = Round(($macumu01 + ($reg2["debito_02"] - $reg2["credito_02"])), 2);
            $msaldo03 = Round(($reg2["debito_03"] - $reg2["credito_03"]), 2);
            $macumu03 = Round(($macumu02 + ($reg2["debito_03"] - $reg2["credito_03"])), 2);
            $msaldo04 = Round(($reg2["debito_04"] - $reg2["credito_04"]), 2);
            $macumu04 = Round(($macumu03 + ($reg2["debito_04"] - $reg2["credito_04"])), 2);
            $msaldo05 = Round(($reg2["debito_05"] - $reg2["credito_05"]), 2);
            $macumu05 = Round(($macumu04 + ($reg2["debito_05"] - $reg2["credito_05"])), 2);
            $msaldo06 = Round(($reg2["debito_06"] - $reg2["credito_06"]), 2);
            $macumu06 = Round(($macumu05 + ($reg2["debito_06"] - $reg2["credito_06"])), 2);
            $msaldo07 = Round(($reg2["debito_07"] - $reg2["credito_07"]), 2);
            $macumu07 = Round(($macumu06 + ($reg2["debito_07"] - $reg2["credito_07"])), 2);
            $msaldo08 = Round(($reg2["debito_08"] - $reg2["credito_08"]), 2);
            $macumu08 = Round(($macumu07 + ($reg2["debito_08"] - $reg2["credito_08"])), 2);
            $msaldo09 = Round(($reg2["debito_09"] - $reg2["credito_09"]), 2);
            $macumu09 = Round(($macumu08 + ($reg2["debito_09"] - $reg2["credito_09"])), 2);
            $msaldo10 = Round(($reg2["debito_10"] - $reg2["credito_10"]), 2);
            $macumu10 = Round(($macumu09 + ($reg2["debito_10"] - $reg2["credito_10"])), 2);
            $msaldo11 = Round(($reg2["debito_11"] - $reg2["credito_11"]), 2);
            $macumu11 = Round(($macumu10 + ($reg2["debito_11"] - $reg2["credito_11"])), 2);
            $msaldo12 = Round(($reg2["debito_12"] - $reg2["credito_12"]), 2);
            $macumu12 = Round(($macumu11 + ($reg2["debito_12"] - $reg2["credito_12"])), 2);
        }else{
            $msaldo01 = Round(($reg2["credito_01"] - $reg2["debito_01"]), 2);
            $macumu01 = Round($reg2["saldo_anterior"] + ($reg2["credito_01"] - $reg2["debito_01"]), 2);
            $msaldo02 = Round(($reg2["credito_02"] - $reg2["debito_02"]), 2);
            $macumu02 = Round(($macumu01 + ($reg2["credito_02"] - $reg2["debito_02"])), 2);
            $msaldo03 = Round(($reg2["credito_03"] - $reg2["debito_03"]), 2);
            $macumu03 = Round(($macumu02 + ($reg2["credito_03"] - $reg2["debito_03"])), 2);
            $msaldo04 = Round(($reg2["credito_04"] - $reg2["debito_04"]), 2);
            $macumu04 = Round(($macumu03 + ($reg2["credito_04"] - $reg2["debito_04"])), 2);
            $msaldo05 = Round(($reg2["credito_05"] - $reg2["debito_05"]), 2);
            $macumu05 = Round(($macumu04 + ($reg2["credito_05"] - $reg2["debito_05"])), 2);
            $msaldo06 = Round(($reg2["credito_06"] - $reg2["debito_06"]), 2);
            $macumu06 = Round(($macumu05 + ($reg2["credito_06"] - $reg2["debito_06"])), 2);
            $msaldo07 = Round(($reg2["credito_07"] - $reg2["debito_07"]), 2);
            $macumu07 = Round(($macumu06 + ($reg2["credito_07"] - $reg2["debito_07"])), 2);
            $msaldo08 = Round(($reg2["credito_08"] - $reg2["debito_08"]), 2);
            $macumu08 = Round(($macumu07 + ($reg2["credito_08"] - $reg2["debito_08"])), 2);
            $msaldo09 = Round(($reg2["credito_09"] - $reg2["debito_09"]), 2);
            $macumu09 = Round(($macumu08 + ($reg2["credito_09"] - $reg2["debito_09"])), 2);
            $msaldo10 = Round(($reg2["credito_10"] - $reg2["debito_10"]), 2);
            $macumu10 = Round(($macumu09 + ($reg2["credito_10"] - $reg2["debito_10"])), 2);
            $msaldo11 = Round(($reg2["credito_11"] - $reg2["debito_11"]), 2);
            $macumu11 = Round(($macumu10 + ($reg2["credito_11"] - $reg2["debito_11"])), 2);
            $msaldo12 = Round(($reg2["credito_12"] - $reg2["debito_12"]), 2);
            $macumu12 = Round(($macumu11 + ($reg2["credito_12"] - $reg2["debito_12"])), 2);
        }
		If (($codigo_cuenta==$Cta_Result_Eje) And ($Cod_Emp=="71")){
		  $macumu01 = $reg2["saldo_anterior"];	$macumu02 = $reg2["saldo_anterior"];
		  $macumu03 = $reg2["saldo_anterior"];  $macumu04 = $reg2["saldo_anterior"];
		  $macumu05 = $reg2["saldo_anterior"];  $macumu06 = $reg2["saldo_anterior"];
		  $macumu07 = $reg2["saldo_anterior"];  $macumu08 = $reg2["saldo_anterior"];
		  $macumu09 = $reg2["saldo_anterior"];  $macumu10 = $reg2["saldo_anterior"];
		  $macumu11 = $reg2["saldo_anterior"];  $macumu12 = $reg2["saldo_anterior"];
		  //echo $Cta_Result_Eje." acumualdo ".$macumu03." ".$linea,"<br>";
		}
	  }
	  if($monto_pp01==""){
	    $mmontop01=0;$mmontop02=0;$mmontop03=0;$mmontop04=0;$mmontop05=0;$mmontop06=0;$mmontop07=0;$mmontop08=0;$mmontop09=0;$mmontop10=0;$mmontop11=0;$mmontop12=0;
        $mmontoa01=0;$mmontoa02=0;$mmontoa03=0;$mmontoa04=0;$mmontoa05=0;$mmontoa06=0;$mmontoa07=0;$mmontoa08=0;$mmontoa09=0;$mmontoa10=0;$mmontoa11=0;$mmontoa12=0;
  	  }else{
	    $mmontop01 = $reg2["monto_pp01"] + $reg2["monto_rp01"];
 	    $mmontoa01 = $mmontop01;
	    $mmontop02 = $reg2["monto_pp02"] + $reg2["monto_rp02"];
 	    $mmontoa02 = $mmontoa01+$mmontop02;
	    $mmontop03 = $reg2["monto_pp03"] + $reg2["monto_rp03"];
 	    $mmontoa03 = $mmontoa02+$mmontop03;
	    $mmontop04 = $reg2["monto_pp04"] + $reg2["monto_rp04"];
 	    $mmontoa04 = $mmontoa03+$mmontop04;
	    $mmontop05 = $reg2["monto_pp05"] + $reg2["monto_rp05"];
 	    $mmontoa05 = $mmontoa04+$mmontop05;
	    $mmontop06 = $reg2["monto_pp06"] + $reg2["monto_rp06"];
 	    $mmontoa06 = $mmontoa05+$mmontop06;
	    $mmontop07 = $reg2["monto_pp07"] + $reg2["monto_rp07"];
 	    $mmontoa07 = $mmontoa06+$mmontop07;
	    $mmontop08 = $reg2["monto_pp08"] + $reg2["monto_rp08"];
 	    $mmontoa08 = $mmontoa07+$mmontop08;
	    $mmontop09 = $reg2["monto_pp09"] + $reg2["monto_rp09"];
 	    $mmontoa09 = $mmontoa08+$mmontop09;
	    $mmontop10 = $reg2["monto_pp10"] + $reg2["monto_rp10"];
 	    $mmontoa10 = $mmontoa09+$mmontop10;
	    $mmontop11 = $reg2["monto_pp11"] + $reg2["monto_rp11"];
 	    $mmontoa11 = $mmontoa10+$mmontop11;
	    $mmontop12 = $reg2["monto_pp12"] + $reg2["monto_rp12"];
 	    $mmontoa12 = $mmontoa11+$mmontop12;
	  }
	  If ($operacion=="+"){
        $msaldo_anterior=$msaldo_anterior+$saldo_ant;
        $msaldo_p01 = $msaldo_p01+$msaldo01;
        $macumulado_p01 = $macumulado_p01+$macumu01;
        $msaldo_p02 = $msaldo_p02+$msaldo02;
        $macumulado_p02 = $macumulado_p02+$macumu02;
        $msaldo_p03 = $msaldo_p03+$msaldo03;
        $macumulado_p03 = $macumulado_p03+$macumu03;
        $msaldo_p04 = $msaldo_p04+$msaldo04;
        $macumulado_p04 = $macumulado_p04+$macumu04;
        $msaldo_p05 = $msaldo_p05+$msaldo05;
        $macumulado_p05 = $macumulado_p05+$macumu05;
        $msaldo_p06 = $msaldo_p06+$msaldo06;
        $macumulado_p06 = $macumulado_p06+$macumu06;
        $msaldo_p07 = $msaldo_p07+$msaldo07;
        $macumulado_p07 = $macumulado_p07+$macumu07;
        $msaldo_p08 = $msaldo_p08+$msaldo08;
        $macumulado_p08 = $macumulado_p08+$macumu08;
        $msaldo_p09 = $msaldo_p09+$msaldo09;        
		$macumulado_p09 = $macumulado_p09+$macumu09;
        $msaldo_p10 = $msaldo_p10+$msaldo10;
        $macumulado_p10 = $macumulado_p10+$macumu10;
        $msaldo_p11 = $msaldo_p11+$msaldo11;
        $macumulado_p11 = $macumulado_p11+$macumu11;
        $msaldo_p12 = $msaldo_p12+$msaldo12;
        $macumulado_p12 = $macumulado_p12+$macumu12;
        $mmonto_pp01 = $mmonto_pp01 + $mmontop01;
        $mmonto_pa01 = $mmonto_pa01 + $mmontoa01;
        $mmonto_pp02 = $mmonto_pp02 + $mmontop02;
        $mmonto_pa02 = $mmonto_pa02 + $mmontoa02;
        $mmonto_pp03 = $mmonto_pp03 + $mmontop03;
        $mmonto_pa03 = $mmonto_pa03 + $mmontoa03;
        $mmonto_pp04 = $mmonto_pp04 + $mmontop04;
        $mmonto_pa04 = $mmonto_pa04 + $mmontoa04;
        $mmonto_pp05 = $mmonto_pp05 + $mmontop05;
        $mmonto_pa05 = $mmonto_pa05 + $mmontoa05;
        $mmonto_pp06 = $mmonto_pp06 + $mmontop06;
        $mmonto_pa06 = $mmonto_pa06 + $mmontoa06;
        $mmonto_pp07 = $mmonto_pp07 + $mmontop07;
        $mmonto_pa07 = $mmonto_pa07 + $mmontoa07;
        $mmonto_pp08 = $mmonto_pp08 + $mmontop08;
        $mmonto_pa08 = $mmonto_pa08 + $mmontoa08;
        $mmonto_pp09 = $mmonto_pp09 + $mmontop09;
        $mmonto_pa09 = $mmonto_pa09 + $mmontoa09;
        $mmonto_pp10 = $mmonto_pp10 + $mmontop10;
        $mmonto_pa10 = $mmonto_pa10 + $mmontoa10;
        $mmonto_pp11 = $mmonto_pp11 + $mmontop11;
        $mmonto_pa11 = $mmonto_pa11 + $mmontoa11;
        $mmonto_pp12 = $mmonto_pp12 + $mmontop12;
        $mmonto_pa12 = $mmonto_pa12 + $mmontoa12;
                         
        $mdebe01 = $mdebe01 + $reg2["debito_01"];
        $mdebe02 = $mdebe02 + $reg2["debito_02"];
        $mdebe03 = $mdebe03 + $reg2["debito_03"];
        $mdebe04 = $mdebe04 + $reg2["debito_04"];
        $mdebe05 = $mdebe05 + $reg2["debito_05"];
        $mdebe06 = $mdebe06 + $reg2["debito_06"];
        $mdebe07 = $mdebe07 + $reg2["debito_07"];
        $mdebe08 = $mdebe08 + $reg2["debito_08"];
        $mdebe09 = $mdebe09 + $reg2["debito_09"];
        $mdebe10 = $mdebe10 + $reg2["debito_10"];
        $mdebe11 = $mdebe11 + $reg2["debito_11"];
        $mdebe12 = $mdebe12 + $reg2["debito_12"];
        $mhaber01 = $mhaber01 + $reg2["credito_01"];
        $mhaber02 = $mhaber02 + $reg2["credito_02"];
        $mhaber03 = $mhaber03 + $reg2["credito_03"];
        $mhaber04 = $mhaber04 + $reg2["credito_04"];
        $mhaber05 = $mhaber05 + $reg2["credito_05"];
        $mhaber06 = $mhaber06 + $reg2["credito_06"];
        $mhaber07 = $mhaber07 + $reg2["credito_07"];
        $mhaber08 = $mhaber08 + $reg2["credito_08"];
        $mhaber09 = $mhaber09 + $reg2["credito_09"];
        $mhaber10 = $mhaber10 + $reg2["credito_10"];
        $mhaber11 = $mhaber11 + $reg2["credito_11"];
        $mhaber12 = $mhaber12 + $reg2["credito_12"];
      }else{
        If (($codigo_cuenta==$Cta_Result_Eje) And ($Cod_Emp=="71")){
            $msaldo_p01 = Round(($msaldo_p01 - $msaldo01), 2);
            $msaldo_p02 = Round(($msaldo_p02 - $msaldo02), 2);
            $msaldo_p03 = Round(($msaldo_p03 - $msaldo03), 2);
            $msaldo_p04 = Round(($msaldo_p04 - $msaldo04), 2);
            $msaldo_p05 = Round(($msaldo_p05 - $msaldo05), 2);
            $msaldo_p06 = Round(($msaldo_p06 - $msaldo06), 2);
            $msaldo_p07 = Round(($msaldo_p07 - $msaldo07), 2);
            $msaldo_p08 = Round(($msaldo_p08 - $msaldo08), 2);
            $msaldo_p09 = Round(($msaldo_p09 - $msaldo09), 2);
            $msaldo_p10 = Round(($msaldo_p10 - $msaldo10), 2);
            $msaldo_p11 = Round(($msaldo_p11 - $msaldo11), 2);
            $msaldo_p12 = Round(($msaldo_p12 - $msaldo12), 2);			
			//echo $Cta_Result_Eje."  Saldo periodo : ".$msaldo_p03,"<br>";
			$msaldo_anterior=$msaldo_anterior+$saldo_ant;
			$macumulado_p01 = Round(($macumulado_p01 - $macumu01), 2);
			$macumulado_p02 = Round(($macumulado_p02 - $macumu02), 2);
			$macumulado_p03 = Round(($macumulado_p03 - $macumu03), 2);
			$macumulado_p04 = Round(($macumulado_p04 - $macumu04), 2);
			$macumulado_p05 = Round(($macumulado_p05 - $macumu05), 2);
			$macumulado_p06 = Round(($macumulado_p06 - $macumu06), 2);
			$macumulado_p07 = Round(($macumulado_p07 - $macumu07), 2);
			$macumulado_p08 = Round(($macumulado_p08 - $macumu08), 2);
			$macumulado_p09 = Round(($macumulado_p09 - $macumu09), 2);
			$macumulado_p10 = Round(($macumulado_p10 - $macumu10), 2);
			$macumulado_p11 = Round(($macumulado_p11 - $macumu11), 2);
			$macumulado_p12 = Round(($macumulado_p12 - $macumu12), 2);
        }else{		   
            $msaldo_anterior=$msaldo_anterior-$saldo_ant;	
            $msaldo_p01 = Round(($msaldo_p01 - $msaldo01), 2);
            $macumulado_p01 = Round(($macumulado_p01 - $macumu01), 2);
            $msaldo_p02 = Round(($msaldo_p02 - $msaldo02), 2);
            $macumulado_p02 = Round(($macumulado_p02 - $macumu02), 2);
            $msaldo_p03 = Round(($msaldo_p03 - $msaldo03), 2);
            $macumulado_p03 = Round(($macumulado_p03 - $macumu03), 2);
            $msaldo_p04 = Round(($msaldo_p04 - $msaldo04), 2);
            $macumulado_p04 = Round(($macumulado_p04 - $macumu04), 2);
            $msaldo_p05 = Round(($msaldo_p05 - $msaldo05), 2);
            $macumulado_p05 = Round(($macumulado_p05 - $macumu05), 2);
            $msaldo_p06 = Round(($msaldo_p06 - $msaldo06), 2);
            $macumulado_p06 = Round(($macumulado_p06 - $macumu06), 2);
            $msaldo_p07 = Round(($msaldo_p07 - $msaldo07), 2);
            $macumulado_p07 = Round(($macumulado_p07 - $macumu07), 2);
            $msaldo_p08 = Round(($msaldo_p08 - $msaldo08), 2);
            $macumulado_p08 = Round(($macumulado_p08 - $macumu08), 2);
            $msaldo_p09 = Round(($msaldo_p09 - $msaldo09), 2);
            $macumulado_p09 = Round(($macumulado_p09 - $macumu09), 2);
            $msaldo_p10 = Round(($msaldo_p10 - $msaldo10), 2);
            $macumulado_p10 = Round(($macumulado_p10 - $macumu10), 2);
            $msaldo_p11 = Round(($msaldo_p11 - $msaldo11), 2);
            $macumulado_p11 = Round(($macumulado_p11 - $macumu11), 2);
            $msaldo_p12 = Round(($msaldo_p12 - $msaldo12), 2);
            $macumulado_p12 = Round(($macumulado_p12 - $macumu12), 2);
        }
        $mmonto_pp01 = $mmonto_pp01 - $mmontop01;
        $mmonto_pa01 = $mmonto_pa01 - $mmontoa01;
        $mmonto_pp02 = $mmonto_pp02 - $mmontop02;
        $mmonto_pa02 = $mmonto_pa02 - $mmontoa02;
        $mmonto_pp03 = $mmonto_pp03 - $mmontop03;
        $mmonto_pa03 = $mmonto_pa03 - $mmontoa03;
        $mmonto_pp04 = $mmonto_pp04 - $mmontop04;
        $mmonto_pa04 = $mmonto_pa04 - $mmontoa04;
        $mmonto_pp05 = $mmonto_pp05 - $mmontop05;
        $mmonto_pa05 = $mmonto_pa05 - $mmontoa05;
        $mmonto_pp06 = $mmonto_pp06 - $mmontop06;
        $mmonto_pa06 = $mmonto_pa06 - $mmontoa06;
        $mmonto_pp07 = $mmonto_pp07 - $mmontop07;
        $mmonto_pa07 = $mmonto_pa07 - $mmontoa07;
        $mmonto_pp08 = $mmonto_pp08 - $mmontop08;
        $mmonto_pa08 = $mmonto_pa08 - $mmontoa08;
        $mmonto_pp09 = $mmonto_pp09 - $mmontop09;
        $mmonto_pa09 = $mmonto_pa09 - $mmontoa09;
        $mmonto_pp10 = $mmonto_pp10 - $mmontop10;
        $mmonto_pa10 = $mmonto_pa10 - $mmontoa10;
        $mmonto_pp11 = $mmonto_pp11 - $mmontop11;
        $mmonto_pa11 = $mmonto_pa11 - $mmontoa11;
        $mmonto_pp12 = $mmonto_pp12 - $mmontop12;
        $mmonto_pa12 = $mmonto_pa12 - $mmontoa12;
                         
        $mdebe01 = $mdebe01 - $reg2["debito_01"];
        $mdebe02 = $mdebe02 - $reg2["debito_02"];
        $mdebe03 = $mdebe03 - $reg2["debito_03"];
        $mdebe04 = $mdebe04 - $reg2["debito_04"];
        $mdebe05 = $mdebe05 - $reg2["debito_05"];
        $mdebe06 = $mdebe06 - $reg2["debito_06"];
        $mdebe07 = $mdebe07 - $reg2["debito_07"];
        $mdebe08 = $mdebe08 - $reg2["debito_08"];
        $mdebe09 = $mdebe09 - $reg2["debito_09"];
        $mdebe10 = $mdebe10 - $reg2["debito_10"];
        $mdebe11 = $mdebe11 - $reg2["debito_11"];
        $mdebe12 = $mdebe12 - $reg2["debito_12"];
        $mhaber01 = $mhaber01 - $reg2["credito_01"];
        $mhaber02 = $mhaber02 - $reg2["credito_02"];
        $mhaber03 = $mhaber03 - $reg2["credito_03"];
        $mhaber04 = $mhaber04 - $reg2["credito_04"];
        $mhaber05 = $mhaber05 - $reg2["credito_05"];
        $mhaber06 = $mhaber06 - $reg2["credito_06"];
        $mhaber07 = $mhaber07 - $reg2["credito_07"];
        $mhaber08 = $mhaber08 - $reg2["credito_08"];
        $mhaber09 = $mhaber09 - $reg2["credito_09"];
        $mhaber10 = $mhaber10 - $reg2["credito_10"];
        $mhaber11 = $mhaber11 - $reg2["credito_11"];
        $mhaber12 = $mhaber12 - $reg2["credito_12"];
      }
   }   
 }
 If ($moperacion=="-"){ $moperador=-1;} else { $moperador=1;} $msaldo_anterior=$msaldo_anterior*$moperador;
 $msaldo_p01=$msaldo_p01*$moperador;  $msaldo_p02=$msaldo_p02*$moperador;  $msaldo_p03=$msaldo_p03*$moperador;  $msaldo_p04=$msaldo_p04*$moperador; 
 $msaldo_p05=$msaldo_p05*$moperador;  $msaldo_p06=$msaldo_p06*$moperador;  $msaldo_p07=$msaldo_p07*$moperador;  $msaldo_p08=$msaldo_p08*$moperador; 
 $msaldo_p09=$msaldo_p09*$moperador;  $msaldo_p10=$msaldo_p10*$moperador;  $msaldo_p11=$msaldo_p11*$moperador;  $msaldo_p12=$msaldo_p12*$moperador;  
 $macumulado_p01=$macumulado_p01*$moperador;  $macumulado_p02=$macumulado_p02*$moperador;  $macumulado_p03=$macumulado_p03*$moperador;  $macumulado_p04=$macumulado_p04*$moperador; 
 $macumulado_p05=$macumulado_p05*$moperador;  $macumulado_p06=$macumulado_p06*$moperador;  $macumulado_p07=$macumulado_p07*$moperador;  $macumulado_p08=$macumulado_p08*$moperador; 
 $macumulado_p09=$macumulado_p09*$moperador;  $macumulado_p10=$macumulado_p10*$moperador;  $macumulado_p11=$macumulado_p11*$moperador;  $macumulado_p12=$macumulado_p12*$moperador;  
 $mmonto_pp01=$mmonto_pp01*$moperador;  $mmonto_pp02=$mmonto_pp02*$moperador;  $mmonto_pp03=$mmonto_pp03*$moperador;  $mmonto_pp04=$mmonto_pp04*$moperador; 
 $mmonto_pp05=$mmonto_pp05*$moperador;  $mmonto_pp06=$mmonto_pp06*$moperador;  $mmonto_pp07=$mmonto_pp07*$moperador;  $mmonto_pp08=$mmonto_pp08*$moperador; 
 $mmonto_pp09=$mmonto_pp09*$moperador;  $mmonto_pp10=$mmonto_pp10*$moperador;  $mmonto_pp11=$mmonto_pp11*$moperador;  $mmonto_pp12=$mmonto_pp12*$moperador; 
 $mmonto_pa01=$mmonto_pa01*$moperador;  $mmonto_pa02=$mmonto_pa02*$moperador;  $mmonto_pa03=$mmonto_pa03*$moperador;  $mmonto_pa04=$mmonto_pa04*$moperador; 
 $mmonto_pa05=$mmonto_pa05*$moperador;  $mmonto_pa06=$mmonto_pa06*$moperador;  $mmonto_pa07=$mmonto_pa07*$moperador;  $mmonto_pa08=$mmonto_pa08*$moperador; 
 $mmonto_pa09=$mmonto_pa09*$moperador;  $mmonto_pa10=$mmonto_pa10*$moperador;  $mmonto_pa11=$mmonto_pa11*$moperador;  $mmonto_pa12=$mmonto_pa12*$moperador; 
 $mdebe01=$mdebe01*$moperador;  $mdebe02=$mdebe02*$moperador;  $mdebe03=$mdebe03*$moperador;  $mdebe04=$mdebe04*$moperador; 
 $mdebe05=$mdebe05*$moperador;  $mdebe06=$mdebe06*$moperador;  $mdebe07=$mdebe07*$moperador;  $mdebe08=$mdebe08*$moperador; 
 $mdebe09=$mdebe09*$moperador;  $mdebe10=$mdebe10*$moperador;  $mdebe11=$mdebe11*$moperador;  $mdebe12=$mdebe12*$moperador; 
 $mhaber01=$mhaber01*$moperador;  $mhaber02=$mhaber02*$moperador;  $mhaber03=$mhaber03*$moperador;  $mhaber04=$mhaber04*$moperador; 
 $mhaber05=$mhaber05*$moperador;  $mhaber06=$mhaber06*$moperador;  $mhaber07=$mhaber07*$moperador;  $mhaber08=$mhaber08*$moperador; 
 $mhaber09=$mhaber09*$moperador;  $mhaber10=$mhaber10*$moperador;  $mhaber11=$mhaber11*$moperador;  $mhaber12=$mhaber12*$moperador; 
 
 $sqlg="SELECT GUARDA_CALCULO_CON006('$codigo_informe','$linea','$mcta_asociada','$mcargable','$mtsaldo','$mclasificacion',$msaldo_anterior,$mmonto_pp01,$mmonto_pp02,$mmonto_pp03,$mmonto_pp04,$mmonto_pp05,$mmonto_pp06,$mmonto_pp07,$mmonto_pp08,$mmonto_pp09,$mmonto_pp10,$mmonto_pp11,$mmonto_pp12,$mmonto_pa01,$mmonto_pa02,$mmonto_pa03,$mmonto_pa04,$mmonto_pa05,$mmonto_pa06,$mmonto_pa07,$mmonto_pa08,$mmonto_pa09,$mmonto_pa10,$mmonto_pa11,$mmonto_pa12, $msaldo_p01,$msaldo_p02,$msaldo_p03,$msaldo_p04,$msaldo_p05,$msaldo_p06,$msaldo_p07,$msaldo_p08,$msaldo_p09,$msaldo_p10,$msaldo_p11,$msaldo_p12,$macumulado_p01,$macumulado_p02,$macumulado_p03,$macumulado_p04,$macumulado_p05,$macumulado_p06,$macumulado_p07,$macumulado_p08,$macumulado_p09,$macumulado_p10,$macumulado_p11,$macumulado_p12,$mdebe01,$mdebe02,$mdebe03,$mdebe04,$mdebe05,$mdebe06,$mdebe07,$mdebe08,$mdebe09,$mdebe10,$mdebe11,$mdebe12,$mhaber01,$mhaber02,$mhaber03,$mhaber04,$mhaber05,$mhaber06,$mhaber07,$mhaber08,$mhaber09,$mhaber10,$mhaber11,$mhaber12)";
 $resg=pg_exec($conn,$sqlg); $errorg=pg_errormessage($conn);  if (!$resg){ $error=1; echo $sqlg,"<br>";  echo $errorg,"<br>"; $errorg=substr($errorg, 0, 61); ?> <script language="JavaScript"> muestra('<? echo $errorg; ?>'); </script> <? }
 
}
$num_per=$periodo*1;
if(($seleccion=="T")and($num_per>4)){ $error=1; ?> <script language="JavaScript"> muestra('PERIODO INVALIDO'); </script> <? }
else{$url=$nombre_archivo."?&codigo_informe=".$codigo_informe."&periodo=".$periodo."&seleccion=".$seleccion;  echo $url;}
pg_close(); //$error=1; 
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}
?>


