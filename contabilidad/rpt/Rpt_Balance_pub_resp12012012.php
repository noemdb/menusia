<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php"); include ("../../class/conect.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;
$date = date("d-m-Y");  $hora = date("H:i:s a");
$MControl = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
function BUSCAR_ACTUAL($Clave,$Formato){
  global $MControl; global $Ultimo; $j=0;
  for ($a=0;$a<10;$a++){ $MControl[$a]=0;}
  for ($a=0;$a<strlen($Formato); $a++){if(substr($Formato,+$a,1)=="-"){$j++;}else{$MControl[$j]++;}}
  $Ultimo=$j;  $k=$MControl[0];
  for ($a=1; $a<10; $a++) {if ($MControl[$a] == 0) {$MControl[$a]=0;} else { $j=$MControl[$a]+$k; $MControl[$a]=$j+1; $k=$MControl[$a];} }
  for ($a=1; $a<10; $a++) {if ($MControl[$a] < 0) {$MControl[$a]=0;}}  $act=-1;
  for ($a=0; $a<10; $a++) {if (strlen($Clave) == $MControl[$a]){$act=$a; $a=10;}}
  if ($act==-1){?><script language="JavaScript">muestra('ERROR Longitud de la Cuenta Invalida');</script><? }
return $act;}
function Nivel_Cod($ncuenta){global $MControl; $n_cod=0; for($n=0;$n<10;$n++){if(strlen($ncuenta)==$MControl[$n]){$n_cod=$n; $n=10;}} return $n_cod;}
function Seletion_Ok($cuenta,$fecha_c){global $Cta_Activo; global $Cta_Pasivo; global $Cta_Ingreso; global $Cta_Egreso; global $fecha_h;
  $valido=1; $la=strlen($Cta_Activo); $lp=strlen($Cta_Pasivo); $lc=strlen($Cta_Ingreso); $lr=strlen($Cta_Egreso);
  if((substr($cuenta,0,$la)==substr($Cta_Activo,0,$la))or(substr($cuenta,0,$lp)==substr($Cta_Pasivo,0,$lp))or(substr($cuenta,0,$lc)==substr($Cta_Ingreso,0,$lc))or(substr($cuenta,0,$lr)==substr($Cta_Egreso,0,$lr))) {$valido=0;}
  $cfecha=$fecha_c;  $hfecha=formato_aaaammdd($fecha_h);  if(($cfecha<=$hfecha)and($valido==0)){$valido=0;}else{$valido=1;}
return $valido;}
$MCuenta = array ('', '', '', '', '', '', '', '', '', '');
$MNombre = array ('', '', '', '', '', '', '', '', '', '');
$MTSaldo = array ('', '', '', '', '', '', '', '', '', '');
$MDebitos = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$MCreditos = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$MSaldo_Total = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$Total_Activo=0; $Total_Pasivo=0; $Total_Resultado=0;$Total_Capital=0; $Total_Resultado_Balance=0; $Monto_Gan_Perd=0;
$periodo=$_GET["periodo"]; $nivel_hasta=$_GET["nivel"]; $nivel_hasta=3; $imp_encero=$_GET["vimprimir"]; $tipo_rep=$_GET["tipo_rep"]; $imp_cta_orden="N";  $nivel_hasta=$nivel_hasta*1;
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}else{ $Nom_Emp=busca_conf(); $php_os=PHP_OS; if($utf_rpt=="SI"){ $php_os="WINNT";}   }
$sql="Select * from SIA005 where campo501='03'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $Formato_Cuenta=$registro["campo504"]; $Cta_Activo=$registro["campo505"];$Cta_Pasivo=$registro["campo506"]; $Cta_Orden=$registro["campo507"]; $Cta_Ingreso=$registro["campo510"];  $Cta_Egreso=$registro["campo509"];  $Cta_Resultado=$registro["campo509"];
$Cta_Sit_Finan=$registro["campo513"]; $Cta_Sit_Fiscal=$registro["campo514"]; $Cta_Ejec_Presup=$registro["campo515"]; $Cta_Hacienda_Mun=$registro["campo516"]; $Cta_Result_Fis=$registro["campo517"];  }
$Activos=0; $Pasivos=0; $Ingresos=0; $Egresos=0; $Resultado=0; $Superavit=0; $TAct_Hacienda=0;  $actual=BUSCAR_ACTUAL($Cta_Activo,$Formato_Cuenta);  $ln=$MControl[$nivel_hasta-1];
$fecha_d=Armar_Fecha($periodo, 1, $Fec_Ini_Ejer); $fecha_h=Armar_Fecha($periodo,2,$Fec_Ini_Ejer); $criterio1=" Al ".$fecha_h; $Sql="";
$sfecha=formato_aaaammdd($fecha_d);   $ano_fiscal=substr($Fec_Ini_Ejer,6,4);  $periodo=$periodo*1;

$nro_linea=0; $cod_cuenta=""; $nom_cuenta=""; $c=0;  $prev_cuenta="";  $TAct_Hacienda=0;
$Sql="SELECT ELIMINA_CON013('".$usuario_sia."','E')"; $resultado=pg_exec($conn,$Sql);$error=pg_errormessage($conn); $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
 else{ $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','','00000','','01','0','A','','CUENTAS DEL TESORO','','','','',0,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
     $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','','00000','','01','0','B','','ACTIVO','','','PASIVO','',0,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
     $linea_11=$nro_linea; $Total=0; $MResultado=0;
     $sql="Select * from con001 Where (clasificacion='11') And (Length(Codigo_Cuenta)=$ln) order by codigo_cuenta"; $resultado=pg_query($sql);
     while($registro=pg_fetch_array($resultado)){ $cod_cuenta=$registro["codigo_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"];   $tsaldo=$registro["tsaldo"];
       if(strlen($cod_cuenta)==$MControl[$nivel_hasta-1]){ $Cod1=substr($cod_cuenta, ($MControl[$nivel_hasta-2] + 1), $MControl[$nivel_hasta-1]);
         $MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
         for($s=0;$s<$periodo;$s++){if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$s]-$MHaber[$s])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$s]-$MDebe[$s])),2);}}
         $Total=$Total+$MSaldo;  $Imprimir=true; If(($MSaldo==0)and($imp_encero=="N")){$Imprimir=false;}
         if($Imprimir==true){$nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','$Cod1','00000','','01','0','C','$Cod1','$nombre_cuenta','$tsaldo','','','',$MSaldo,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}}
       }
     }
     $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','','00000','','01','0','D','','TOTAL','','','','',$Total,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
     $linea_12=$nro_linea;  $Activos=$Total;

     $Total=0; $nro_linea=$linea_11;  
     $sql="Select * from con001 Where (clasificacion='12') And (Length(Codigo_Cuenta)=$ln) order by codigo_cuenta"; $resultado=pg_query($sql);  $Total=0;
     while($registro=pg_fetch_array($resultado)){ $cod_cuenta=$registro["codigo_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"];   $tsaldo=$registro["tsaldo"];
       if(strlen($cod_cuenta)==$MControl[$nivel_hasta-1]){ $Cod1=substr($cod_cuenta, ($MControl[$nivel_hasta-2] + 1), $MControl[$nivel_hasta-1]);
	   
         If(substr($cod_cuenta,0,$MControl[$nivel_hasta-1])==substr($Cta_Sit_Finan,0,$MControl[$nivel_hasta-1])) {
           $MSaldo=$Activos-$Total; $MResultado=$MSaldo;   $nro_linea=$nro_linea+1;
           If($nro_linea<$linea_12){$sql2="SELECT UPDATE_COL2_CON013('$usuario_sia','E',$nro_linea,'C','','SUB-TOTAL',$Total)";}else{$sql2="SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','','00000','','01','0','C','','','','','SUB-TOTAL','',0,$Total,0,0,0,0,0,0,0,0,'','')";}
           $res=pg_exec($conn,$sql2); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
           $nro_linea=$nro_linea+1;
           If($nro_linea<$linea_12){$sql2="SELECT UPDATE_COL2_CON013('$usuario_sia','E',$nro_linea,'C','$Cod1','$nombre_cuenta',$MSaldo)";}else{$sql2="SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','','00000','','01','0','C','','','','$Cod1','$nombre_cuenta','',0,$MSaldo,0,0,0,0,0,0,0,0,'','')";}
           $res=pg_exec($conn,$sql2); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
         }else{
           $MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
           for($s=0;$s<$periodo;$s++){if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$s]-$MHaber[$s])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$s]-$MDebe[$s])),2);}}
           $Imprimir=true; If(($MSaldo==0)and($imp_encero=="N")){$Imprimir=false;}
           if($Imprimir==true){ $nro_linea=$nro_linea+1;
             If($nro_linea<$linea_12){$sql2="SELECT UPDATE_COL2_CON013('$usuario_sia','E',$nro_linea,'C','$Cod1','$nombre_cuenta',$MSaldo)";}else{$sql2="SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','$Cod1','00000','','01','0','C','','','','$Cod1','$nombre_cuenta','$tsaldo',0,$MSaldo,0,0,0,0,0,0,0,0,'','')";}
             //echo $sql2,"<br>";
			 $res=pg_exec($conn,$sql2); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
           }
         } $Total=$Total+$MSaldo;
       }
     }
     If($nro_linea>=$linea_12){$MMonto1=$Activos; $MMonto2=$Total;  $nro_linea=$nro_linea+1;
      $sql2="SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','','00000','','01','0','D','','TOTAL','','','TOTAL','$tsaldo',$Activos,$Total,0,0,0,0,0,0,0,0,'','')"; $res=pg_exec($conn,$sql2); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
      $sql2="SELECT UPDATE_COL1_CON013('$usuario_sia','E',$nro_linea,'D','','',0)";  }
     else{$nro_linea=$linea_12; $sql2="SELECT UPDATE_COL2_CON013('$usuario_sia','E',$nro_linea,'D','','TOTAL',$Total)";}
     $res=pg_exec($conn,$sql2); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}

     If($nro_linea<$linea_12){$nro_linea=$linea_12;} $nro_linea=$nro_linea+2;
     $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','','00000','','01','0','A','','CUENTAS DE LA HACIENDA','','','','',0,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}

     $Total=0; $linea_21=$nro_linea;
     $sql="Select * from con001 Where (clasificacion='21') And (Length(Codigo_Cuenta)=$ln) order by codigo_cuenta"; $resultado=pg_query($sql);  $Total=0;
     while($registro=pg_fetch_array($resultado)){ $cod_cuenta=$registro["codigo_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"];   $tsaldo=$registro["tsaldo"];
       if(strlen($cod_cuenta)==$MControl[$nivel_hasta-1]){ $Cod1=substr($cod_cuenta, ($MControl[$nivel_hasta-2] + 1), $MControl[$nivel_hasta-1]);
         $MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
         for($s=0;$s<$periodo;$s++){if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$s]-$MHaber[$s])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$s]-$MDebe[$s])),2);}}
         
		 If(substr($cod_cuenta,0,$MControl[$nivel_hasta-1])==substr($Cta_Sit_Fiscal,0,$MControl[$nivel_hasta-1])) {
           $MSaldo=$MResultado;}
		 
		 $Total=$Total+$MSaldo;  $Imprimir=true; If(($MSaldo==0)and($imp_encero=="N")){$Imprimir=false;}
         if($Imprimir==true){$nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','$Cod1','00000','','01','0','C','$Cod1','$nombre_cuenta','$tsaldo','','','',$MSaldo,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}}
       }
     }$linea_22=$nro_linea-1;  $Activos=$Total;  $linea_299=0; $nombre_299=""; $monto_299=0;

	 $nro_linea=$linea_21; 
     $sql="Select * from con001 Where ((clasificacion='22') or (clasificacion='5')) And (Length(Codigo_Cuenta)=$ln) order by codigo_cuenta"; $resultado=pg_query($sql);  $Total=0;
     while($registro=pg_fetch_array($resultado)){ $cod_cuenta=$registro["codigo_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"];   $tsaldo=$registro["tsaldo"];
       if(strlen($cod_cuenta)==$MControl[$nivel_hasta-1]){ $Cod1=substr($cod_cuenta, ($MControl[$nivel_hasta-2] + 1), $MControl[$nivel_hasta-1]);
         $MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
         for($s=0;$s<$periodo;$s++){if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$s]-$MHaber[$s])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$s]-$MDebe[$s])),2);}}
         If($Cod1=="299") { $nro_linea=$nro_linea+1;   $linea_299=$nro_linea; $nombre_299=$nombre_cuenta; $monto_299=$MSaldo;
           If($nro_linea<=$linea_22){$sql2="SELECT UPDATE_COL2_CON013('$usuario_sia','E',$nro_linea,'C','$Cod1','$nombre_cuenta',$MSaldo)";}else{$sql2="SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','','00000','','01','0','C','','','','$Cod1','$nombre_cuenta','',0,$MSaldo,0,0,0,0,0,0,0,0,'','')";}
           $res=pg_exec($conn,$sql2); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
         }else{
           $Imprimir=true; If(($MSaldo==0)and($imp_encero=="N")){$Imprimir=false;}
           if($Imprimir==true){ $nro_linea=$nro_linea+1;
             If($nro_linea<=$linea_22){$sql2="SELECT UPDATE_COL2_CON013('$usuario_sia','E',$nro_linea,'C','$Cod1','$nombre_cuenta',$MSaldo)";}else{$sql2="SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','$Cod1','00000','','01','0','C','','','','$Cod1','$nombre_cuenta','$tsaldo',0,$MSaldo,0,0,0,0,0,0,0,0,'','')";}
             $res=pg_exec($conn,$sql2); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
           }
         } $Total=$Total+$MSaldo;
       }
     } $Pasivos=$Total;   If($nro_linea<$linea_22){$nro_linea=$linea_22;}  $nro_linea=$nro_linea+2;
     $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','','00000','','01','0','A','','CUENTAS DE PRESUPUESTO','','','','',0,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}

     $Total=0; $linea_31=$nro_linea;
     $sql="Select * from con001 Where (clasificacion='31') And (Length(Codigo_Cuenta)=$ln) order by codigo_cuenta"; $resultado=pg_query($sql);  $Total=0;
     while($registro=pg_fetch_array($resultado)){ $cod_cuenta=$registro["codigo_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"];   $tsaldo=$registro["tsaldo"];
       if(strlen($cod_cuenta)==$MControl[$nivel_hasta-1]){ $Cod1=substr($cod_cuenta, ($MControl[$nivel_hasta-2] + 1), $MControl[$nivel_hasta-1]);
         $MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
         for($s=0;$s<$periodo;$s++){if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$s]-$MHaber[$s])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$s]-$MDebe[$s])),2);}}
         $Total=$Total+$MSaldo;  $Imprimir=true; If(($MSaldo==0)and($imp_encero=="N")){$Imprimir=false;}
         if($Imprimir==true){$nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','$Cod1','00000','','01','0','C','$Cod1','$nombre_cuenta','$tsaldo','','','',$MSaldo,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}}
       }
     }$linea_32=$nro_linea;  $TActivos=$Total+$Activos;

     $Total=0; $nro_linea=$linea_31;
     $sql="Select * from con001 Where (clasificacion='32') And (Length(Codigo_Cuenta)=$ln) order by codigo_cuenta"; $resultado=pg_query($sql);  $Total=0;
     while($registro=pg_fetch_array($resultado)){ $cod_cuenta=$registro["codigo_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"];   $tsaldo=$registro["tsaldo"];
       if(strlen($cod_cuenta)==$MControl[$nivel_hasta-1]){ $Cod1=substr($cod_cuenta, ($MControl[$nivel_hasta-2] + 1), $MControl[$nivel_hasta-1]);
         $MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
         for($s=0;$s<$periodo;$s++){if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$s]-$MHaber[$s])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$s]-$MDebe[$s])),2);}}
         $Imprimir=true; If(($MSaldo==0)and($imp_encero=="N")){$Imprimir=false;}
         if($Imprimir==true){ $nro_linea=$nro_linea+1;
           If($nro_linea<=$linea_32){$sql2="SELECT UPDATE_COL2_CON013('$usuario_sia','E',$nro_linea,'C','$Cod1','$nombre_cuenta',$MSaldo)";}else{$sql2="SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','$Cod1','00000','','01','0','C','','','','$Cod1','$nombre_cuenta','$tsaldo',0,$MSaldo,0,0,0,0,0,0,0,0,'','')";}
           $res=pg_exec($conn,$sql2); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
         }
         $Total=$Total+$MSaldo;
       }
     }  $Hacienda=($Activos-$Pasivos)+(($TActivos-$Activos)-$Total);   $MSaldo=$Total+$Pasivos+$Hacienda;
     If($nro_linea<$linea_32){$nro_linea=$linea_32;} $nro_linea=$nro_linea+2;
     $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','','00000','','01','0','D','','TOTAL','','','TOTAL','',$TActivos,$MSaldo,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}

     $MMonto1=$TActivos+$MMonto1; $MMonto2=$Total+$Pasivos+$Hacienda+$MMonto2; $nro_linea=$nro_linea+2;
     $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','E',$nro_linea,'00000000','$sfecha','','','00000','','01','0','D','','TOTAL','','','TOTAL','',$MMonto1,$MMonto2,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}

	 $monto_299=$monto_299+$Hacienda;
	 $sql2="SELECT UPDATE_COL2_CON013('$usuario_sia','E',$linea_299,'C','299','$nombre_299',$monto_299)";$res=pg_exec($conn,$sql2); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
     
}
if($nro_linea>0){
  $Sql= "select * from CON013 WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='E' ORDER BY nro_linea";  $sSQL = $Sql;
    if($tipo_rep=="HTML"){
			 $oRpt = new PHPReportMaker();
			 $oRpt->setXML("Balance_General_Publicacion.xml");
			 $oRpt->setUser("$user");
			 $oRpt->setPassword("$password");
			 $oRpt->setConnection("localhost");
			 $oRpt->setDatabaseInterface("postgresql");
			 $oRpt->setSQL($sSQL);
			 $oRpt->setDatabase("$dbname");
			 $oRpt->setParameters(array("criterio1"=>$criterio1));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
	}	
    if($tipo_rep=="PDF"){  $res=pg_query($sSQL); 
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'BALANCE GENERAL',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',10);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);				
			}
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];    $nombre_cuenta=$registro["nombre_cuenta"]; 
		       $codigo_cuenta2=$registro["codigo_cuenta2"];    $nombre_cuenta2=$registro["nombre_cuenta2"]; 
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta); $nombre_cuenta2=utf8_decode($nombre_cuenta2); }	
			   $status=$registro["status"];  $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; 
		       $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;  $h=4;
			   $pdf->SetFont('Arial','B',8);
			   if(($status=="A")){ 
		         $pdf->Cell(200,6,$nombre_cuenta,0,1,'C');
			   }			   
			   if(($status=="B")){ 
		         $pdf->Cell(100,5,$nombre_cuenta,0,0,'C');
				 $pdf->Cell(100,5,$nombre_cuenta2,0,1,'C');
			   }
			   $pdf->SetFont('Arial','B',7);
               if(($status=="D")){ $columna11="=============="; $columna12="=============="; 
			    
			    $pdf->Cell(80,1," ",0,0); 
			    $pdf->Cell(20,1,$columna11,0,0,'R');
				$pdf->Cell(80,1," ",0,0); 
                $pdf->Cell(20,1,$columna12,0,1,'R');
				$columna1=formato_monto($columna1); $columna2=formato_monto($columna2);
				$pdf->Cell(80,$h," ",0,0); 
			    $pdf->Cell(20,$h,$columna1,0,0,'R');
				$pdf->Cell(80,$h," ",0,0); 
                $pdf->Cell(20,$h,$columna2,0,1,'R');
				$pdf->Ln($h);
				
			   }		
              $pdf->SetFont('Arial','',7);			   
			   $x=$pdf->GetX();   $y=$pdf->GetY();  
			   if(($status=="C")){ $columna1=formato_monto($columna1); $columna2=formato_monto($columna2);
			   $pdf->Cell(5,$h,$codigo_cuenta,0,0);
			   $pdf->Cell(75,$h,$nombre_cuenta,0,0); 			   
			   $pdf->Cell(20,$h,$columna1,0,0,'R');
			   $pdf->Cell(5,$h,$codigo_cuenta2,0,0);
			   if($nombre_cuenta2=="SUB-TOTAL"){$pdf->SetFont('Arial','B',7);}
			   $pdf->Cell(75,$h,$nombre_cuenta2,0,0); 
               $pdf->Cell(20,$h,$columna2,0,1,'R');}
			   
			} $totald=formato_monto($totald); $totalh=formato_monto($totalh); 
			
			$pdf->Output();   
	}
if($tipo_rep=="EXCEL"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Balance_publicacion.xls");	
		?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
			    <td width="50" align="center"></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>BALANCE GENERAL</strong></font></td>
			 </tr>
			 <tr height="20">
			 <td width="50" align="center"></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?echo $criterio1?></strong></font></td>
			 </tr>
			 <tr height="20">
			      <td width="50" align="center"></td>
			 </tr>
		 <? $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];   $nombre_cuenta=$registro["nombre_cuenta"]; 
		       $codigo_cuenta2=$registro["codigo_cuenta2"];    $nombre_cuenta2=$registro["nombre_cuenta2"]; 
		       $nombre_cuenta=conv_cadenas($nombre_cuenta,0); $nombre_cuenta2=conv_cadenas($nombre_cuenta2,0);    $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;  
		       $status=$registro["status"];  $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; 
			   if($columna1==0){$columna1="";}else{$columna1=formato_monto($columna1);}
			   if($columna2==0){$columna2="";}else{$columna2=formato_monto($columna2);} 
			   
			   if(($status=="A")){	
			   ?>	   
				<tr>
				   <td width="50" align="center"></td>
				   <td width="400" align="center"><strong><? echo $nombre_cuenta; ?></strong></td>
				   <td width="120" align="right"></td>
				   <td width="50" align="center"></td>
				   <td width="400" align="center"></td>
				   <td width="120" align="right"></td>
				 </tr>
			   <? }
			   
			   if(($status=="B")){	
			   ?>	   
				<tr>
				   <td width="50" align="center"></td>
				   <td width="400" align="center"><strong><? echo $nombre_cuenta; ?></strong></td>
				   <td width="120" align="right"></td>
				   <td width="50" align="center"></td>
				   <td width="400" align="center"><strong><? echo $nombre_cuenta2; ?></strong></td>
				   <td width="120" align="right"></td>
				 </tr>
			   <? }
			   
			   if(($status=="C")){	
			   ?>	   
				<tr>
				   <td width="50" align="center"><? echo $codigo_cuenta; ?></td>
				   <td width="400" align="justify"><? echo $nombre_cuenta; ?></td>
				   <td width="120" align="right"><? echo $columna1; ?></td>
				   <td width="50" align="center"><? echo $codigo_cuenta2; ?></td>
				   <td width="400" align="justify"><? echo $nombre_cuenta2; ?></td>
				   <td width="120" align="right"><? echo $columna2; ?></td>
				 </tr>
			   <? }
			   
			   if(($status=="D")){	
			   ?>	   
				<tr>
				   <td width="50" align="center"></td>
				   <td width="400" align="justify"></td>
				   <td width="120" align="right"><strong>==============</strong></td>
				   <td width="50" align="center"></td>
				   <td width="400" align="justify"></td>
				   <td width="120" align="right"><strong>==============</strong></td>
				 </tr>
				 <tr>
				   <td width="50" align="center"></td>
				   <td width="400" align="justify"></td>
				   <td width="120" align="right"><strong><? echo $columna1; ?></strong></td>
				   <td width="50" align="center"></td>
				   <td width="400" align="justify"></td>
				   <td width="120" align="right"><strong><? echo $columna2; ?></strong></td>
				 </tr>
			   <? }
			} 
	}		
} ?>