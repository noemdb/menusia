<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$fecha_d=$_GET["fecha_d"];$imprimir=$_GET["imprimir"];
$criterio1="Al : ".$fecha_d;$Sql="";$date = date("d-m-Y"); $tipo_rep=$_GET["tipo_rep"];$hora = date("H:i:s a"); 
if($fecha_d==""){$sfecha_d="2010-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}
$mcod_m="DBAN023".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ echo "OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS","<br>"; }
else{   $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){ $php_os="WINNT";} 
    $cuenta_dep_trans="";  $sql="Select campo504,campo510 from SIA005 where campo501='02'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$cuenta_dep_trans=$registro["campo510"]; }
    $Sql="SELECT RPT_DISP_BAN023('".$codigo_mov."','".$sfecha_d."','".$cod_banco_d."','".$cod_banco_h."','".$imprimir."')";
    $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){ echo $error,"<br>"; }    
    $mdebe=0; $mhaber=0; $prev_banco="D001"; $saldo_anterior=0;
    $sSQL = "SELECT Sum(monto_asiento) as monto FROM CON003 Where (debito_credito='D') And (cod_cuenta='$cuenta_dep_trans') And (Fecha<='$sfecha_d')"; $resultado=pg_exec($conn,$sSQL);
    if ($registro=pg_fetch_array($resultado,0)){$mdebe=$registro["monto"]; }
    $sSQL = "SELECT Sum(monto_asiento) as monto FROM CON003 Where (debito_credito='C') And (cod_cuenta='$cuenta_dep_trans') And (Fecha<='$sfecha_d')"; $resultado=pg_exec($conn,$sSQL);
    if ($registro=pg_fetch_array($resultado,0)){$mhaber=$registro["monto"]; }
	$sSQL = "SELECT nombre_cuenta,saldo_anterior FROM CON001 Where (codigo_cuenta='$cuenta_dep_trans')"; $res=pg_query($sSQL); $filas=pg_num_rows($res);
	if($filas>0){$registro=pg_fetch_array($res);  $nombre_cuenta=$registro["nombre_cuenta"]; $saldo_anterior=$registro["saldo_anterior"];
	   $Sql="INSERT INTO ban023(codigo_mov,cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable,tipo_bco,tipo_inv,fecha_inicio,fecha_vencimiento,monto1,monto2,monto3,monto4,monto5,monto6,monto7,monto8,monto9,monto10)
            VALUES ('".$codigo_mov."','".$prev_banco."','".$nombre_cuenta."','','','D','".$cuenta_dep_tran."','D','N','".$sfecha_d."','".$sfecha_d."',".$saldo_anterior.",".$mdebe.",".$mhaber.",0,0,0,0,0,0,0)";
	   $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){ echo $error,"<br>"; } 
	}
	
	$sSQL = "SELECT referencia,tipo_inv,cod_cuenta,fecha_inicio,fecha_vencimiento,dias_inv,tasa_inv,monto_inv,observacion,nombre_Cuenta FROM BAN025,CON001 where (codigo_cuenta=cod_cuenta) And (fecha_vencimiento>='$sfecha_d') and (fecha_inicio<='$sfecha_d') ORDER BY fecha_inicio";
    $res=pg_query($sSQL); $c=0; $mdebe=0; $mhaber=0; $prev_banco=""; $saldo_anterior=0;
	while($registro=pg_fetch_array($res)){ $c=c+1; $ult_ref=$c; $len=strlen($ult_ref); $ult_ref=substr("000",0,3-$len).$ult_ref;
	  $tipo_inv=$registro["tipo_inv"];  $monto=$registro["monto_inv"];  $nombre_cuenta=$registro["nombre_cuenta"]; $referencia=$registro["referencia"];
	  $cod_cuenta=$registro["tipo_inv"];
	  $prev_banco=$tipo_inv.$ult_ref;
	  $Sql="INSERT INTO ban023(codigo_mov,cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable,tipo_bco,tipo_inv,fecha_inicio,fecha_vencimiento,monto1,monto2,monto3,monto4,monto5,monto6,monto7,monto8,monto9,monto10)
            VALUES ('".$codigo_mov."','".$prev_banco."','".$nombre_cuenta."','".$referencia."','','".$tipo_inv."','".$cod_cuenta."','D','N','".$sfecha_d."','".$sfecha_d."',$monto,$mdebe,$mhaber,0,0,0,0,0,0,0)";
	   $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){ echo $error,"<br>"; } 
	}
	if($imprimir=="N"){
	  $Sql="DELETE FROM BAN023 Where (monto1+monto2-monto3+monto4-monto5)=0 and codigo_mov='".$codigo_mov."'";
	  $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR ELIMINANDO: ".substr($error, 0, 61); if (!$resultado){ echo $error,"<br>"; } 
	}
	
	$Sql="Delete from ban023 where tipo_inv='N' and fecha_vencimiento<'".$sfecha_d."'";
	$resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR ELIMINANDO: ".substr($error, 0, 61); if (!$resultado){ echo $error,"<br>"; } 
	
	$Sql="Update ban023 set tipo_bco='1' where tipo_bco='9'";
	$resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR ACTUALIZANDO: ".substr($error, 0, 61); if (!$resultado){ echo $error,"<br>"; } 
	
	$Sql="Update ban023 set descripcion_banco='I. EN CUENTAS CORRIENTES' where tipo_bco='1'";
	$resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR ACTUALIZANDO: ".substr($error, 0, 61); if (!$resultado){ echo $error,"<br>"; } 
	
	$Sql="Update ban023 set descripcion_banco='' where tipo_bco='5'";
	$resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR ACTUALIZANDO: ".substr($error, 0, 61); if (!$resultado){ echo $error,"<br>"; } 
	
	$Sql="Update ban023 set descripcion_banco='II. EN INVERSIONES TEMPORALES' where tipo_bco='T'";
	$resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR ACTUALIZANDO: ".substr($error, 0, 61); if (!$resultado){ echo $error,"<br>"; } 
	
	$Sql="Update ban023 set descripcion_banco='III. EN FIDEICOMISOS DE INVERSION' where tipo_bco='F'";
	$resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR ACTUALIZANDO: ".substr($error, 0, 61); if (!$resultado){ echo $error,"<br>"; } 
	
	$Sql="Update ban023 set descripcion_banco='IV. OTROS FIDEICOMISOS' where tipo_bco='7'";
	$resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR ACTUALIZANDO: ".substr($error, 0, 61); if (!$resultado){ echo $error,"<br>"; } 
	
	$sSQL = "SELECT cod_banco,nombre_banco,nro_cuenta,tipo_bco,descripcion_banco,monto1,monto2,monto3,monto4,monto5,(monto1+monto2-monto3) as saldo_ini, (monto1+monto2-monto3+monto4-monto5) as saldo_act from ban023 where codigo_mov='$codigo_mov' order by ban023.tipo_bco,ban023.cod_banco";

    if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");  
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Dep_Bancarios.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rep=="PDF"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){ global $tam_logo;  global $criterio1;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(150,10,'DEPOSITOS BANCARIOS',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(200,10,$criterio1,0,1,'C');	
			$this->SetFont('Arial','B',7);
			$this->Cell(11,5,'CODIGO',1,0);
			$this->Cell(77,5,'NOMBRE BANCO',1,0);
			$this->Cell(29,5,'NRO CUENTA',1,0,'L');
			$this->Cell(23,5,'SALDO ANTERIOR',1,0,'C');
			$this->Cell(20,5,'DEBE.',1,0,'C');
			$this->Cell(19,5,'HABER.',1,0,'C');
			$this->Cell(21,5,'DISPONIBILIDAD',1,1,'C');
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
	  $i=0;  $total=0; $prev_tipo_bco=""; $prev_desc=""; $subtotal=0; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $cod_contable=$registro["cod_contable"]; $tipo_bco=$registro["tipo_bco"];
           $saldo_ini=$registro["saldo_ini"]; $monto4=$registro["monto4"]; $monto5=$registro["monto5"]; $saldo_act=$registro["saldo_act"];  $descripcion_banco=$registro["descripcion_banco"];
		   if($php_os=="WINNT"){$nombre_banco=$registro["nombre_banco"]; } else{$nombre_banco=utf8_decode($nombre_banco);}  
		   if($prev_tipo_bco<>$tipo_bco){
		     $pdf->SetFont('Arial','B',7);	
		     if($i>1){ $subtotal=formato_monto($subtotal);
				$pdf->Cell(180,2,'',0,0);
				$pdf->Cell(20,2,'--------------------',0,1,'R');
				$pdf->Cell(180,4,'Total '.$prev_desc.' : ',0,0,'R');
				$pdf->Cell(20,4,$subtotal,0,1,'R'); 
				$pdf->Ln(3);
			  }
			  $prev_tipo_bco=$tipo_bco; $prev_desc=$descripcion_banco; $subtotal=0;
			  $pdf->Ln(2); 
		      $pdf->Cell(180,4,$prev_desc,0,1,'L');
			  $pdf->SetFont('Arial','',7);
		   }
           $total=$total+$saldo_act;  $subtotal=$subtotal+$saldo_act; $saldo_act=formato_monto($saldo_act); 		   
		   $pdf->Cell(2,5,"",0,0);
		   $pdf->Cell(9,5,$cod_banco,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=77; 
		   $pdf->SetXY($x+$n,$y);		   
		   $pdf->Cell(32,5,$nro_cuenta,0,0,'L'); 
		   $pdf->Cell(20,5,$saldo_ini,0,0,'R');
		   $pdf->Cell(20,5,$monto4,0,0,'R');
		   $pdf->Cell(20,5,$monto5,0,0,'R');
		   $pdf->Cell(20,5,$saldo_act,0,1,'R');
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,5,$nombre_banco,0); 
		} $subtotal=formato_monto($subtotal);
		$pdf->SetFont('Arial','B',7);	
		$pdf->Cell(180,2,'',0,0);
		$pdf->Cell(20,2,'--------------------',0,1,'R');
		$pdf->Cell(180,4,'Total '.$prev_desc.' : ',0,0,'R');
		$pdf->Cell(20,4,$subtotal,0,1,'R'); 
		$pdf->Ln(5);		
		
		$total=formato_monto($total); 			
		$pdf->Cell(180,2,'',0,0);
		$pdf->Cell(20,2,'============',0,1,'R');
		$pdf->Cell(180,4,'Total Depositos Bancarios : ',0,0,'R');
		$pdf->Cell(20,4,$total,0,1,'R'); 		 
		$pdf->Output();   
    }
}
?>