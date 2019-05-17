<? include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php"); include ("../../class/conect.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$MControl = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0); $date = date("d-m-Y");  $hora = date("H:i:s a"); $php_os=PHP_OS;
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
  
  if((substr($cuenta,0,$lc)==substr($Cta_Ingreso,0,$lc))or(substr($cuenta,0,$lr)==substr($Cta_Egreso,0,$lr))){$valido=1;}else{$valido=0;}
  
  $cfecha=$fecha_c;  $hfecha=formato_aaaammdd($fecha_h);  if(($cfecha<=$hfecha)and($valido==0)){$valido=0;}else{$valido=1;}
return $valido;}
$MCuenta = array ('', '', '', '', '', '', '', '', '', '');
$MNombre = array ('', '', '', '', '', '', '', '', '', '');
$MTSaldo = array ('', '', '', '', '', '', '', '', '', '');
$MDebitos = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$MCreditos = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$MSaldo_Total = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$Total_Activo=0; $Total_Pasivo=0; $Total_Resultado=0;$Total_Capital=0; $Total_Resultado_Balance=0; $Monto_Gan_Perd=0;
$periodo=$_GET["periodo"]; $nivel_hasta=$_GET["nivel"]; $imp_encero=$_GET["vimprimir"]; $tipo_rep=$_GET["tipo_rep"]; $imp_cta_orden="N";  $nivel_hasta=$nivel_hasta*1;


$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}else{ $Nom_Emp=busca_conf(); $php_os=PHP_OS; if($utf_rpt=="SI"){ $php_os="WINNT";}   }
$sql="Select * from SIA005 where campo501='03'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $Formato_Cuenta=$registro["campo504"]; 
$Cta_Activo=$registro["campo505"];$Cta_Pasivo=$registro["campo506"]; 
$Cta_Orden=$registro["campo507"]; $Cta_Ingreso=$registro["campo510"];  
$Cta_Egreso=$registro["campo509"];  $Cta_Resultado=$registro["campo509"];
$Cta_Sit_Finan=$registro["campo513"]; $Cta_Sit_Fiscal=$registro["campo514"]; 
$Cta_Ejec_Presup=$registro["campo515"]; $Cta_Hacienda_Mun=$registro["campo516"]; $Cta_Result_Fis=$registro["campo517"];  
}
$fecha_d=Armar_Fecha($periodo, 1, $Fec_Ini_Ejer); $fecha_h=Armar_Fecha($periodo,2,$Fec_Ini_Ejer); $criterio1=" Al ".$fecha_h; $Sql="";
$sfecha=formato_aaaammdd($fecha_d);   $ano_fiscal=substr($Fec_Ini_Ejer,6,4);  $periodo=$periodo*1;

$Activos=0; $Pasivos=0; $Ingresos=0; $Egresos=0; $Resultado=0; $Superavit=0; $TAct_Hacienda=0;
$sql="Select * from con001 where codigo_cuenta='$Cta_Activo'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
for ($i=0; $i<$periodo; $i++){ if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$i]-$MHaber[$i])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$i]-$MDebe[$i])),2);} } $Activos=$MSaldo; }
$sql="Select * from con001 where codigo_cuenta='$Cta_Pasivo'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
for ($i=0; $i<$periodo; $i++){ if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$i]-$MHaber[$i])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$i]-$MDebe[$i])),2);} } $Pasivos=$MSaldo; }
$sql="Select * from con001 where codigo_cuenta='$Cta_Ingreso'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
for ($i=0; $i<$periodo; $i++){ if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$i]-$MHaber[$i])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$i]-$MDebe[$i])),2);} } $Ingresos=$MSaldo; }
$sql="Select * from con001 where codigo_cuenta='$Cta_Egreso'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
for ($i=0; $i<$periodo; $i++){ if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$i]-$MHaber[$i])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$i]-$MDebe[$i])),2);} } $Egresos=$MSaldo; }
$Superavit = $Ingresos - $Egresos; $Resultado = Abs($Activos) - Abs($Pasivos);
$nro_linea=0; $cod_cuenta=""; $nom_cuenta=""; $c=0;  $prev_cuenta="";  $TAct_Hacienda=0;

//echo $Activos." ".$Pasivos." ".$Ingresos." ".$Egresos." ".$Cta_Result_Fis,"<br>";
$Sql="SELECT ELIMINA_CON013('".$usuario_sia."','D')"; $resultado=pg_exec($conn,$Sql);$error=pg_errormessage($conn); $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
 else{ $actual=BUSCAR_ACTUAL($Cta_Result_Fis,$Formato_Cuenta);
    //$sql="Select * from con001 order by codigo_cuenta"; $resultado=pg_query($sql);  
	//echo $actual." ".$Cta_Result_Fis." ".$Formato_Cuenta." ".$MControl[0]." ".$MControl[1]." ".$MControl[2]." ".$nivel_hasta,"<br>";
	$long_cuenta=$MControl[$nivel_hasta-1]; $sql="Select * from con001 where length(codigo_cuenta)<=".$long_cuenta." order by codigo_cuenta"; $resultado=pg_query($sql);  $actual=$MControl[0];
	 //echo $sql,"<br>";
     while($registro=pg_fetch_array($resultado)){ 
	   if($c==0){$c=1; $prev_cuenta=$registro["codigo_cuenta"];  $MCuenta[1]=$registro["codigo_cuenta"]; $MNombre[1]=$registro["nombre_cuenta"]; $MTSaldo[1]=$registro["TSaldo"]; }
       $cod_cuenta=$registro["codigo_cuenta"]; $cargable=$registro["cargable"]; $fecha_creado=$registro["fecha_creado"];  $tsaldo=$registro["tsaldo"];  $nombre_cuenta=$registro["nombre_cuenta"];
       
	   //if($cod_cuenta=="1-1-102-01-01-0001"){
	   //echo $cod_cuenta." ".$nombre_cuenta." ".Seletion_Ok($cod_cuenta,$fecha_creado)." ".$actual." ".Nivel_Cod($cod_cuenta)." ".strlen($cod_cuenta)." ".$MControl[$nivel_hasta-1],"<br>";
       //}
	   If (Nivel_Cod($cod_cuenta) < $actual){
          for ($i=$Ultimo-1; $i>=0; $i--){
           If ((trim($MCuenta[$i]) <> substr($cod_cuenta,0,($MControl[$i]))) And (strlen(Trim($MCuenta[$i]))>0)) {$Imprimir=true;
              If(($MSaldo_Total[$i]==0)and($imp_encero=="N")){$Imprimir=false;}
              if($i==0){ if($MCuenta[$i]==substr($Cta_Orden,1,1)){$TAct_Hacienda=$MSaldo_Total[$i];}  }
              if(($Imprimir==true)and($i<$nivel_hasta)){ $temp_nomb=" TOTAL ".$MNombre[$i];
                $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','D',$nro_linea,'00000000','$sfecha','','$MCuenta[$i]','00000','','01','0','C','$MCuenta[$i]','$temp_nomb','$MTSaldo[$i]','','','',0,$MSaldo_Total[$i],0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
                if(($i==0)and(trim($MCuenta[$i])==substr($Cta_Activo,1,1))and($imp_cta_orden=="S")){  }
              }
              $MCuenta[$i]="";$MNombre[$i]=""; $MTSaldo[$i]=""; $MSaldo_Total[$i]=0;
          }}
       }
       if((((strlen($cod_cuenta)==$MControl[$nivel_hasta-1]))or(($cargable=="C")and(strlen($cod_cuenta)<$MControl[$nivel_hasta-1])))and(Seletion_Ok($cod_cuenta,$fecha_creado)==0)){
        $ln=strlen($cod_cuenta);
		$MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
         for($s=0;$s<$periodo;$s++){if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$s]-$MHaber[$s])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$s]-$MDebe[$s])),2);}}
         if($registro["tsaldo"]=="Acreedor"){$MSaldo=$MSaldo*-1;}  if(substr($cod_cuenta,0,$ln)==substr($Cta_Sit_Finan,0,$ln)){$MSaldo=$Resultado;}
        
		
		if(substr($cod_cuenta,0,$ln)==substr($Cta_Sit_Fiscal,0,$ln)){$MSaldo=$Resultado*-1;}if(substr($cod_cuenta,0,$ln)==substr($Cta_Result_Fis,0,$ln)){$MSaldo=$Superavit*-1;}
         if(substr($cod_cuenta,0,$ln)==substr($Cta_Hacienda_Mun,0,$ln)){$TAct_Hacienda =$TAct_Hacienda-Abs($MSaldo); $MSaldo=$TAct_Hacienda*-1;}

		 
		     
         for($i=0;$i<$nivel_hasta-1;$i++){
            If(Nivel_Cod($cod_cuenta)>$i){ if($MTSaldo[$i]==$tsaldo){$MSaldo_Total[$i]=$MSaldo_Total[$i]+$MSaldo;}else{$MSaldo_Total[$i]=$MSaldo_Total[$i]-$MSaldo;} }
         } $Imprimir=true;  If(($MSaldo==0)and($imp_encero=="N")){$Imprimir=false;}
         if($Imprimir==true){$nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','D',$nro_linea,'00000000','$sfecha','','$cod_cuenta','00000','','01','0','B','$cod_cuenta','$nombre_cuenta','$tsaldo','','','',$MSaldo,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}}
         $actual=BUSCAR_ACTUAL($cod_cuenta,$Formato_Cuenta);
       }
       else{ if((strlen($cod_cuenta)<$MControl[$nivel_hasta-1])and(Seletion_Ok($cod_cuenta,$fecha_creado)==0)){ $actual=BUSCAR_ACTUAL($cod_cuenta,$Formato_Cuenta);
         $i=$actual; $MCuenta[$i]=substr($cod_cuenta,0,$MControl[$i]); $MNombre[$i]=$nombre_cuenta; $MTSaldo[$i]=$tsaldo;
         $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','D',$nro_linea,'00000000','$sfecha','','$cod_cuenta','00000','','01','0','A','$cod_cuenta','$nombre_cuenta','$tsaldo','','','',0,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
       }}
       $prev_cuenta=$registro["codigo_cuenta"];
     }
	 /*
     for ($i=$Ultimo-1; $i>=0; $i--){ $Imprimir=true;
       If(trim($MCuenta[$i]) <> substr($prev_cuenta,0,($MControl[$i]-1))) { $Imprimir=false; $res=pg_exec($conn,"DELETE FROM CON013 Where (Tipo_Registro='D') And (Nombre_Usuario='$usuario_sia') And (Status='A') And (Codigo_Cuenta='$MCuenta[$i]')"); $error=pg_errormessage($conn);$error=substr($error,0,61);}
       If((($MSaldo_Total[$i]==0)and($imp_encero=="N"))or(trim($MCuenta[$i])=="")){$Imprimir=false;}
       if($i==0){ if($MCuenta[$i]==substr($Cta_Orden,1,1)){$TAct_Hacienda=$MSaldo_Total[$i];} }
       if(($Imprimir==true)and($i<$nivel_hasta)){ $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','D',$nro_linea,'00000000','$sfecha','','$MCuenta[$i]','00000','','01','0','C','$MCuenta[$i]','$MNombre[$i]','$MTSaldo[$i]','','','',0,$MSaldo_Total[$i],0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?} }
       $MCuenta[$i]="";$MNombre[$i]=""; $MTSaldo[$i]=""; $MSaldo_Total[$i]=0;
     }  
	 */
	 for ($i=$Ultimo-1; $i>=0; $i--){ $Imprimir=true;
	   //If(trim($MCuenta[$i]) <> substr($prev_cuenta,0,($MControl[$i]-1))) { $Imprimir=false; $res=pg_exec($conn,"DELETE FROM CON013 Where (Tipo_Registro='D') And (Nombre_Usuario='$usuario_sia') And (Status='A') And (Codigo_Cuenta='$MCuenta[$i]')"); $error=pg_errormessage($conn);$error=substr($error,0,61);}
       
       If((($MSaldo_Total[$i]==0)and($imp_encero=="N"))or(trim($MCuenta[$i])=="")){$Imprimir=false;}
      
       if(($Imprimir==true)and($i<$nivel_hasta)){$temp_nomb=" TOTAL ".$MNombre[$i];
                if(($MCuenta[$i]==substr($Cta_Capital,0,1))){$nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','D',$nro_linea,'00000000','$sfecha','','','00000','','01','0','S','','','','','','',0,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?} }
               

           $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','D',$nro_linea,'00000000','$sfecha','','$MCuenta[$i]','00000','','01','0','C','$MCuenta[$i]','$temp_nomb','$MTSaldo[$i]','','','',0,$MSaldo_Total[$i],0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?} }
       $MCuenta[$i]="";$MNombre[$i]=""; $MTSaldo[$i]=""; $MSaldo_Total[$i]=0;
     }
}
if($nro_linea>0){
  $Sql= "select * from CON013 WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='D' ORDER BY nro_linea";  $sSQL = $Sql;
  
	if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
		  $oRpt = new PHPReportMaker();
		  $oRpt->setXML("Balance_Gen_Fiscal.xml");
		  $oRpt->setUser("$user");
		  $oRpt->setPassword("$password");
		  $oRpt->setConnection("$host");
		  $oRpt->setDatabaseInterface("postgresql");
		  $oRpt->setSQL($sSQL);
		  $oRpt->setDatabase("$dbname");
		  $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora));
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
		  $pdf->SetFont('Arial','',8);
		  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];    $nombre_cuenta=$registro["nombre_cuenta"]; 
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta); }	
		       $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;  $h=4;
		       $status=$registro["status"];  $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; 
			   if($columna1==0){$columna1=""; }else{$columna1=formato_monto($columna1);}
			   if($status=="R"){$columna2="=============="; $h=2;}
			   else{ if($status=="S"){$columna2="------------------------"; $h=2;} 
			    else{ if($columna2==0){$columna2="";}else{$columna2=formato_monto($columna2);} }}
				
			   if(($columna1=="")and($columna2<>"")){ $n=130; $long_line=80;}   else{$n=140; $long_line=85;}
			   
			   $nombre1=$nombre_cuenta;
			   if(strlen($nombre_cuenta)>$long_line){ $l=$long_line;
			      $nombre1=substr($nombre_cuenta,0,$l); $lp=strlen($nombre1);  $c2=$lp; $care="N"; 
                  if($lp>=$long_line){ for($k=$lp-1; $k>0; $k--){  $care=substr($nombre1,$k,1); if($care==" ") {$c2=$k; $k=0; } }  $nombre1=substr($nombre_cuenta,0,$c2); }       
                  $nombre2=substr($nombre_cuenta,$c2,$long_line);
				}		
               if(($columna1==0)and($status=="C")){ $columna11="------------------------"; $columna12=""; 
			    $pdf->Cell(140,1," ",0,0); 
			    $pdf->Cell(30,1,$columna11,0,0,'R');
                $pdf->Cell(30,1,$columna12,0,1,'R');
			   }				
			   $x=$pdf->GetX();   $y=$pdf->GetY();  
			   if($n==130){$pdf->Cell(10,3,"",0,0);} else{  $p=count(explode("-", $codigo_cuenta));	 $pdf->Cell($p,3,"",0,0); }
			   $pdf->Cell($n,$h,$nombre1,0,0); 
			   
			   $pdf->SetXY($x+140,$y);
			   $pdf->Cell(30,$h,$columna1,0,0,'R');
               $pdf->Cell(30,$h,$columna2,0,1,'R');
			   if(strlen($nombre_cuenta)>$long_line){ 
			      if($n==130){$pdf->Cell(10,3,"",0,0);}
			      $pdf->Cell($n,$h,$nombre2,0,1);
			   }
			   
			} $totald=formato_monto($totald); $totalh=formato_monto($totalh); 
			
			$pdf->Output();   
	}	
    if($tipo_rep=="EXCEL"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Balance_General.xls");	
		?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>BALANCE GENERAL</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?echo $criterio1?></strong></font></td>
			 </tr>
			 <tr height="20">
			      <td width="400" align="center"></td>
			 </tr>
		 <? $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];   $nombre_cuenta=$registro["nombre_cuenta"]; 
		       $nombre_cuenta=conv_cadenas($nombre_cuenta,0);    $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;  
		       $status=$registro["status"];  $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; 
			   if($columna1==0){$columna1="";}else{$columna1=formato_monto($columna1);}
			   if($status=="R"){$columna2="==============";}
			   else{ if($status=="S"){$columna2="______________";}
			    else{ if($columna2==0){$columna2="";}else{$columna2=formato_monto($columna2);} }}
				
			   ?>	   
				<tr>
				   <td width="400" align="justify"><? echo $nombre_cuenta; ?></td>
				   <td width="120" align="right"><? echo $columna1; ?></td>
				   <td width="120" align="right"><? echo $columna2; ?></td>
				 </tr>
			   <? 
			} 
	}	
} ?>