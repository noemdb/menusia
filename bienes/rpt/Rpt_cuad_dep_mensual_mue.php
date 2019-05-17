<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$fecha_d=$_GET["fecha_d"]; $acum=$_GET["acum"]; $subt_mes=$_GET["subt_mes"]; $dep_mes=$_GET["dep_mes"]; $date=date("d-m-Y");$hora = date("H:i:s a"); $Sql="";
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}   $fecha_desde=$ano1.$mes1.$dia1;
$criterio ="(bien047.fecha_dep='$fecha_desde') ";	$mborde=0;	$tfecha_d=$fecha_d; $mperiodo=substr($tfecha_d,0,5);

if($mperiodo=="01/01"){  $tfecha_d=nextmes($tfecha_d,-1) ;  $tfecha_d=colocar_udiames($tfecha_d); }
	
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }   $fecha_i=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_i=nextmes($fecha_i,-1);  $fecha_i=colocar_udiames($fecha_i);
   $num_rpt=1;   if($acum=="SI"){ $num_rpt=2; if($subt_mes=="SI"){ $num_rpt=3; } }  if($dep_mes=="NO"){ $num_rpt=4; }
	if($num_rpt==1){  	
	   $sSQL = "SELECT bien015.cod_bien_mue, bien015.denominacion, bien015.cod_clasificacion, bien028.referencia_dep, bien028.fecha_dep, bien028.descripcion, bien028.met_calculo, bien028.status, bien028.anulado, 
	     bien015.valor_incorporacion, bien047.monto_dep, bien015.valor_residual, bien015.vida_util, bien015.fecha_incorporacion, bien047.saldo_dep, bien015.cod_dependencia, bien008.denominacion_c, to_char(bien028.fecha_dep,'DD/MM/YYYY') as fechad, to_char(bien015.fecha_incorporacion,'DD/MM/YYYY') as fechai  
	     FROM bien008, bien015, bien028, bien047 WHERE bien015.cod_bien_mue = bien047.cod_bien_mue AND bien015.cod_clasificacion = bien008.codigo_c AND bien028.referencia_dep=bien047.referencia_dep AND ".$criterio."
	     and  (bien015.fecha_incorporacion<='$fecha_desde') ORDER BY bien028.referencia_dep, bien028.fecha_dep,  bien047.cod_bien_mue";       
	    $res=pg_query($sSQL); 
	    require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $fecha_d; global $mborde;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(200,10,'DEPRECIACION ACUMULADA AL '.$fecha_d,1,0,'C');
				$this->Ln(20);
			    $this->SetFont('Arial','B',7);
				$this->Cell(30,3,'CODIGO','TRL',0);						
				$this->Cell(125,3,'','TRL',0,'L');				
				$this->Cell(15,3,'FECHA','TRL',0,'C');
				$this->Cell(10,3,'VIDA','TRL',0,'C');
				$this->Cell(20,3,'VALOR','TRL',0,'C');
				$this->Cell(20,3,'DEPRECIACION','TRL',0,'C');
				$this->Cell(20,3,'DEPRECIACION','TRL',0,'C');
				$this->Cell(20,3,'VALOR','TRL',1,'C');				
				$this->Cell(30,4,'DEL BIEN','BRL',0);						
				$this->Cell(125,4,'DESCRIPCION DEL BIEN','BRL',0,'L');				
				$this->Cell(15,4,'ADQUISIC.','BRL',0,'L');
				$this->Cell(10,4,'UTIL','BRL',0,'C');
				$this->Cell(20,4,'INCORPORAC.','BRL',0,'C');
				$this->Cell(20,4,'MENSUAL','BRL',0,'C');
				$this->Cell(20,4,'ACUMULADA','BRL',0,'C');
				$this->Cell(20,4,'S/LIBRO','BRL',1,'C');
                $mborde=0;				
		    } 
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totalg=0; $totalv=0; $totali=0; $totala=0; $prev_referencia=""; $c=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;		  
            $referencia=$registro["referencia_dep"]; $fechat=$registro["fechad"];  $met_calculo=$registro["met_calculo"]; $descripcion=$registro["denominacion_c"];	
			if($met_calculo=="M"){$met_calculo="MENSUAL";}else{$met_calculo="ANUAL";}				
			$cod_bien_mue=$registro["cod_bien_mue"]; $codigo=$registro["cod_bien_mue"]; $monto=$registro["monto_dep"]; $denominacion=$registro["denominacion"];
	        $valor_incorporacion=$registro["valor_incorporacion"]; $fecha_incorporacion=$registro["fechai"]; $vida_util=$registro["vida_util"];   $saldo_dep=$registro["saldo_dep"]; 
			$acumulada=$registro["valor_incorporacion"]-$registro["saldo_dep"]+$registro["monto_dep"];  $valor=$registro["valor_incorporacion"]-$acumulada;
			$totalg=$totalg+$registro["monto_dep"]; $totalv=$totalv+$valor; $totala=$totala+$acumulada;	$totali=$totali+$valor_incorporacion; $c=$c+1;
			$monto_dep=formato_monto($monto); $acumulada=formato_monto($acumulada); $saldo_dep=formato_monto($saldo_dep); $valor_incorporacion=formato_monto($valor_incorporacion); $valor=formato_monto($valor); 
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);  $descripcion==utf8_decode($descripcion); }
			$denominacion=substr($denominacion,0,80);  $x=$pdf->GetX();   $y=$pdf->GetY();
            $bord=0;	$bordl='L'; $bordr='R';  if(($y>=190)and($mborde==1)){$bord='B'; $bordl='LB'; $bordr='RB';  $mborde=0;}	else { $mborde=1; }	
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(30,3,$cod_bien_mue,$bordl,0,'L'); 
			$pdf->Cell(125,3,$denominacion,$bord,0,'L'); 
			$pdf->Cell(15,3,$fecha_incorporacion,$bord,0,'L'); 
			$pdf->Cell(10,3,$vida_util,$bord,0,'R');
			$pdf->Cell(20,3,$valor_incorporacion,$bord,0,'R');
			$pdf->Cell(20,3,$monto_dep,$bord,0,'R');
			$pdf->Cell(20,3,$acumulada,$bord,0,'R');
			$pdf->Cell(20,3,$valor,$bordr,1,'R');
			$x=$pdf->GetX();   $y=$pdf->GetY();
			
          }		  
		  $pdf->SetFont('Arial','B',7); $totalg=formato_monto($totalg);  $totali=formato_monto($totali);  $totalv=formato_monto($totalv);  $totala=formato_monto($totala);
		  $pdf->Cell(180,5,'TOTAL GENERAL : ',1,0,'R');
		  $pdf->Cell(20,5,$totali,1,0,'R');
		  $pdf->Cell(20,5,$totalg,1,0,'R');
		  $pdf->Cell(20,5,$totala,1,0,'R');
	      $pdf->Cell(20,5,$totalv,1,0,'R');
		  $pdf->Output();
	}
	if($num_rpt==2){ 
	  $criterio ="(bien047.fecha_dep<='$fecha_desde') ";	  
	  $sSQL = "SELECT bien015.cod_bien_mue, bien015.denominacion, bien015.cod_clasificacion,  bien015.vida_util, bien015.fecha_incorporacion,bien015.valor_incorporacion,bien015.valor_residual,bien015.monto_depreciado,
	     bien008.denominacion_c , to_char(bien015.fecha_incorporacion,'DD/MM/YYYY') as fechai, bien047.monto_dep, bien047.saldo_dep, bien047.fecha_dep, to_char(bien047.fecha_dep,'DD/MM/YYYY') as fechad 
	     FROM bien008, bien015  left join  bien047 on (bien015.cod_bien_mue=bien047.cod_bien_mue and (bien047.fecha_dep<='$fecha_desde')) WHERE  (bien015.cod_clasificacion=bien008.codigo_c) and  (bien015.fecha_incorporacion<='$fecha_desde')
	      ORDER BY  bien015.cod_clasificacion,bien015.cod_bien_mue,bien047.fecha_dep";
		
	  $sSQL = "SELECT bien015.cod_bien_mue, bien015.denominacion, bien015.cod_clasificacion,  bien015.vida_util, bien015.fecha_incorporacion, bien015.valor_incorporacion,bien015.valor_residual,bien015.monto_depreciado,
	    bien008.denominacion_c , to_char(bien015.fecha_incorporacion,'DD/MM/YYYY') as fechai, bien047.monto_dep, bien047.saldo_dep 
	    FROM bien008, bien015  left join  bien047 on (bien015.cod_bien_mue = bien047.cod_bien_mue and ".$criterio.") WHERE  bien015.cod_clasificacion = bien008.codigo_c and  (bien015.fecha_incorporacion<='$fecha_desde')
	    ORDER BY  bien015.cod_clasificacion, bien015.cod_bien_mue,bien047.fecha_dep";
		
      $res=pg_query($sSQL);
	  
	  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $fecha_d; global $mborde; global $tfecha_d;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(200,10,'DEPRECIACION ACUMULADA POR CLASIFICACION AL '.$tfecha_d,1,0,'C');
				$this->Ln(20);				
			    $this->SetFont('Arial','B',7);
				$this->Cell(30,3,'CODIGO','TRL',0);						
				$this->Cell(138,3,'','TRL',0,'L');	
				$this->Cell(23,3,'VALOR','TRL',0,'C');
				$this->Cell(23,3,'DEPRECIACION','TRL',0,'C');
				$this->Cell(23,3,'DEPRECIACION','TRL',0,'C');
				$this->Cell(23,3,'VALOR','TRL',1,'C');				
				$this->Cell(30,5,'CLASIFICACION','BRL',0);						
				$this->Cell(138,5,'DESCRIPCION CLASIFICACION','BRL',0,'L');	
				$this->Cell(23,5,'INCORPORACION','BRL',0,'C');
				$this->Cell(23,5,'MENSUAL','BRL',0,'C');
				$this->Cell(23,5,'ACUMULADA','BRL',0,'C');
				$this->Cell(23,5,'S/LIBRO','BRL',1,'C');
                $mborde=0;				
		    } 
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',8);
		  $i=0;  $totalg=0; $totalv=0; $totali=0; $totala=0; $prev_clas="";  $den_clas=""; $c=0;
		  $subtotalg=0; $subtotalv=0; $subtotali=0; $subtotala=0; $acumulada=0;  $gsubtotalg=0; $gsubtotalv=0; $gsubtotali=0; $gsubtotala=0; $prev_grupo="";
		  //$pdf->MultiCell($n,3,$sSQL,0);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;	  
            $descripcion=$registro["denominacion_c"];	$cod_bien_mue=$registro["cod_bien_mue"]; $codigo=$registro["cod_clasificacion"]; $monto=$registro["monto_dep"]; $denominacion=$registro["denominacion"];
	        $valor_incorporacion=$registro["valor_incorporacion"]; $fecha_incorporacion=$registro["fechai"]; $vida_util=$registro["vida_util"];   $saldo_dep=$registro["saldo_dep"];  $monto_depreciado=$registro["monto_depreciado"];
			//if($registro["monto_dep"]==0){ $acumulada=0; }	else{$acumulada=$registro["valor_incorporacion"]-$registro["saldo_dep"]+$registro["monto_dep"]; } 	
			$acumulada=$registro["valor_incorporacion"]-$registro["saldo_dep"]+$registro["monto_dep"]; $grupo=substr($codigo,0,4);
			
			$monto=$monto*1;
			if($monto==0){ $acumulada=$monto_depreciado; 			
			  $sqlb="select bien047.monto_dep, bien047.saldo_dep, bien047.fecha_dep  from bien047 WHERE cod_bien_mue='$cod_bien_mue' and fecha_dep>'$fecha_desde' ORDER BY fecha_dep"; $resb=pg_query($sqlb); $filasb=pg_num_rows($resb);
			  if($filasb>0){$regb=pg_fetch_array($resb);  $acumulada=$registro["valor_incorporacion"]-$regb["saldo_dep"]; }
			}	else{$acumulada=$registro["valor_incorporacion"]-$registro["saldo_dep"]+$registro["monto_dep"];  }	
			
			
			$valor=$registro["valor_incorporacion"]-$acumulada; 
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);  $descripcion==utf8_decode($descripcion); }
			$denominacion=substr($denominacion,0,100); $descripcion=substr($descripcion,0,100);
			if($i==1){ $prev_clas=$codigo;  $den_clas=$descripcion; $subtotalg=0; $subtotalv=0; $subtotali=0; $subtotala=0;
			   $prev_grupo=$grupo; $gsubtotalg=0; $gsubtotalv=0; $gsubtotali=0; $gsubtotala=0;
			}
			
			
			$pdf->SetFont('Arial','',8);
            if($prev_clas<>$codigo){ 
			   $subtotalg=formato_monto($subtotalg);  $subtotali=formato_monto($subtotali);  $subtotalv=formato_monto($subtotalv);  $subtotala=formato_monto($subtotala);
               $pdf->Cell(30,4,$prev_clas,'L',0,'L'); 
			   $pdf->Cell(138,4,$den_clas,0,0,'L'); 
			   $pdf->Cell(23,4,$subtotali,0,0,'R');
			   $pdf->Cell(23,4,$subtotalg,0,0,'R');
			   $pdf->Cell(23,4,$subtotala,0,0,'R');
			   $pdf->Cell(23,4,$subtotalv,'R',1,'R');
               $prev_clas=$codigo;  $den_clas=$descripcion; $subtotalg=0; $subtotalv=0; $subtotali=0; $subtotala=0; 
		    }	
			
			if($prev_grupo<>$grupo){ 
			   $gsubtotalg=formato_monto($gsubtotalg);  $gsubtotali=formato_monto($gsubtotali);  $gsubtotalv=formato_monto($gsubtotalv);  $gsubtotala=formato_monto($gsubtotala);
               $pdf->SetFont('Arial','B',8);
			   $pdf->Cell(168,4,"Sub-Total: ".$prev_grupo." ...  ",'L',0,'R'); 
			   $pdf->Cell(23,4,$gsubtotali,'T',0,'R');
			   $pdf->Cell(23,4,$gsubtotalg,'T',0,'R');
			   $pdf->Cell(23,4,$gsubtotala,'T',0,'R');
			   $pdf->Cell(23,4,$gsubtotalv,'TR',1,'R');
			   $pdf->Cell(260,3,'','LR',1,'L');
               $prev_grupo=$grupo; $gsubtotalg=0; $gsubtotalv=0; $gsubtotali=0; $gsubtotala=0; 
		    }
			
			$totalg=$totalg+$registro["monto_dep"]; $totalv=$totalv+$valor; $totala=$totala+$acumulada;	$totali=$totali+$valor_incorporacion; $c=$c+1;
			$subtotalg=$subtotalg+$registro["monto_dep"]; $subtotalv=$subtotalv+$valor; $subtotala=$subtotala+$acumulada;	$subtotali=$subtotali+$valor_incorporacion;
			
			$gsubtotalg=$gsubtotalg+$registro["monto_dep"]; $gsubtotalv=$gsubtotalv+$valor; $gsubtotala=$gsubtotala+$acumulada;	$gsubtotali=$gsubtotali+$valor_incorporacion;
			
			$monto_dep=formato_monto($monto);  $saldo_dep=formato_monto($saldo_dep); $valor_incorporacion=formato_monto($valor_incorporacion); $valor=formato_monto($valor); 
			
          }$subtotalg=formato_monto($subtotalg);  $subtotali=formato_monto($subtotali);  $subtotalv=formato_monto($subtotalv);  $subtotala=formato_monto($subtotala);
		   $pdf->Cell(30,4,$prev_clas,'L',0,'L'); 
		   $pdf->Cell(138,4,$den_clas,0,0,'L'); 
		   $pdf->Cell(23,4,$subtotali,0,0,'R');
		   $pdf->Cell(23,4,$subtotalg,0,0,'R');
		   $pdf->Cell(23,4,$subtotala,0,0,'R');
		   $pdf->Cell(23,4,$subtotalv,'R',1,'R');
		   
		   $gsubtotalg=formato_monto($gsubtotalg);  $gsubtotali=formato_monto($gsubtotali);  $gsubtotalv=formato_monto($gsubtotalv);  $gsubtotala=formato_monto($gsubtotala);
		   $pdf->SetFont('Arial','B',8);
		   $pdf->Cell(168,4,"Sub-Total: ".$prev_grupo." ...  ",'L',0,'R'); 
		   $pdf->Cell(23,4,$gsubtotali,'T',0,'R');
		   $pdf->Cell(23,4,$gsubtotalg,'T',0,'R');
		   $pdf->Cell(23,4,$gsubtotala,'T',0,'R');
		   $pdf->Cell(23,4,$gsubtotalv,'TR',1,'R');
		   $pdf->Cell(260,3,'','LR',1,'L');
		   $pdf->SetFont('Arial','B',8); $totalg=formato_monto($totalg);  $totali=formato_monto($totali);  $totalv=formato_monto($totalv);  $totala=formato_monto($totala);
		    
		  $pdf->Cell(168,5,'TOTAL GENERAL : ',1,0,'R');
		  $pdf->Cell(23,5,$totali,1,0,'R');
		  $pdf->Cell(23,5,$totalg,1,0,'R');
		  $pdf->Cell(23,5,$totala,1,0,'R');
	      $pdf->Cell(23,5,$totalv,1,0,'R');
		  $pdf->Output();
	}if($num_rpt==3){ 	  
	   $sSQL = "SELECT bien015.cod_bien_mue, bien015.denominacion, bien015.cod_clasificacion,  bien015.vida_util, bien015.fecha_incorporacion, bien015.valor_incorporacion,bien015.valor_residual,bien015.monto_depreciado,
	    bien008.denominacion_c , to_char(bien015.fecha_incorporacion,'DD/MM/YYYY') as fechai, bien047.monto_dep, bien047.saldo_dep, bien047.fecha_dep, to_char(bien047.fecha_dep,'DD/MM/YYYY') as fechad 
	    FROM bien008, bien015  left join  bien047 on (bien015.cod_bien_mue=bien047.cod_bien_mue and (bien047.fecha_dep<='$fecha_desde')) WHERE  (bien015.cod_clasificacion=bien008.codigo_c) and  (bien015.fecha_incorporacion<='$fecha_desde')
	    ORDER BY  bien015.cod_clasificacion,bien015.cod_bien_mue,bien047.fecha_dep";
      $res=pg_query($sSQL);
	  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $fecha_d; global $fecha_i;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(200,10,'Gastos de depreciación del período por Clase y Mes',1,0,'C');
				$this->Ln(20);				
			    $this->SetFont('Arial','B',7);
				$this->Cell(130,3,'','TRL',0);						
				$this->Cell(28,3,'','TRL',0,'L');	
				$this->Cell(22,3,'','TRL',0,'C');
				$this->Cell(20,3,'DEPRECIACION','TRL',0,'C');
				$this->Cell(20,3,'','TRL',0,'C');
				$this->Cell(20,3,'DEPRECIACION','TRL',0,'C');
				$this->Cell(20,3,'VALOR','TRL',1,'C');	
				
				$this->Cell(130,3,'','RL',0);						
				$this->Cell(28,3,'','RL',0,'L');	
				$this->Cell(22,3,'VALOR','RL',0,'C');
				$this->Cell(20,3,'ACUMULADA','RL',0,'C');
				$this->Cell(20,3,'GASTO DEL','RL',0,'C');
				$this->Cell(20,3,'ACUMULADA','RL',0,'C');
				$this->Cell(20,3,'S/LIBRO','RL',1,'C');	
				
				$this->Cell(130,5,'CLASIFICACION','BRL',0);						
				$this->Cell(28,5,'MES','BRL',0,'L');	
				$this->Cell(22,5,'INCORPORACION','BRL',0,'C');
				$this->Cell(20,5,'AL '.$fecha_i,'BRL',0,'C');
				$this->Cell(20,5,'PERIODO','BRL',0,'C');
				$this->Cell(20,5,'AL '.$fecha_d,'BRL',0,'C');
				$this->Cell(20,5,'AL '.$fecha_d,'BRL',1,'C');				
		    } 
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',8);
		  $i=0;  $totalg=0; $totalv=0; $totali=0; $totala=0; $totald=0; $prev_clas="";  $den_clas=""; $c=0;
		  $subtotalg=0; $subtotalv=0; $subtotali=0; $subtotala=0; $prev_mes=""; $prev_cod=""; $acumulada=0;
		  $mes=substr($fecha_d,3,2); $ano=substr($fecha_d,6,4); $nmes=$mes*1;
		  $monto1_00=0; $monto2_00=0; $monto3_00=0; $monto4_00=0; $monto5_00=0;		  
		  $monto1_01=0; $monto2_01=0; $monto3_01=0; $monto4_01=0; $monto5_01=0;
		  $monto1_02=0; $monto2_02=0; $monto3_02=0; $monto4_02=0; $monto5_02=0;
		  $monto1_03=0; $monto2_03=0; $monto3_03=0; $monto4_03=0; $monto5_03=0;
		  $monto1_04=0; $monto2_04=0; $monto3_04=0; $monto4_04=0; $monto5_04=0;
		  $monto1_05=0; $monto2_05=0; $monto3_05=0; $monto4_05=0; $monto5_05=0;
		  $monto1_06=0; $monto2_06=0; $monto3_06=0; $monto4_06=0; $monto5_06=0;
		  $monto1_07=0; $monto2_07=0; $monto3_07=0; $monto4_07=0; $monto5_07=0;
		  $monto1_08=0; $monto2_08=0; $monto3_08=0; $monto4_08=0; $monto5_08=0;
		  $monto1_09=0; $monto2_09=0; $monto3_09=0; $monto4_09=0; $monto5_09=0;
		  $monto1_10=0; $monto2_10=0; $monto3_10=0; $monto4_10=0; $monto5_10=0;
		  $monto1_11=0; $monto2_11=0; $monto3_11=0; $monto4_11=0; $monto5_11=0;
		  $monto1_12=0; $monto2_12=0; $monto3_12=0; $monto4_12=0; $monto5_12=0;  
		  //$pdf->MultiCell($n,3,$sSQL,0);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;	  
            $descripcion=$registro["denominacion_c"];	$cod_bien_mue=$registro["cod_bien_mue"]; $codigo=$registro["cod_clasificacion"]; $monto=$registro["monto_dep"]; $denominacion=$registro["denominacion"];
	        $valor_incorporacion=$registro["valor_incorporacion"]; $fecha_incorporacion=$registro["fechai"]; $vida_util=$registro["vida_util"];   $saldo_dep=$registro["saldo_dep"]; $monto_depreciado=$registro["monto_depreciado"];
			$monto=$monto*1;		
            if($monto==0){ $acumulada=$monto_depreciado; 			
			  $sqlb="select bien047.monto_dep, bien047.saldo_dep, bien047.fecha_dep  from bien047 WHERE cod_bien_mue='$cod_bien_mue' and fecha_dep>'$fecha_desde' ORDER BY fecha_dep"; $resb=pg_query($sqlb); $filasb=pg_num_rows($resb);
			  if($filasb>0){$regb=pg_fetch_array($resb);  $acumulada=$registro["valor_incorporacion"]-$regb["saldo_dep"]; }
			}		else{$acumulada=$registro["valor_incorporacion"]-$registro["saldo_dep"]+$registro["monto_dep"]; } 	
			//$valor=$registro["valor_incorporacion"]-$acumulada; 			
			$valor=$registro["valor_incorporacion"];			
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);  $descripcion==utf8_decode($descripcion); }
			$denominacion=substr($denominacion,0,100); $descripcion=substr($descripcion,0,100);
			if($i==1){ $prev_clas=$codigo;  $den_clas=$descripcion;  $subtotalg=0; $subtotalv=0; $subtotali=0; $subtotala=0; $pdf->Cell(260,4,$prev_clas." ".$den_clas,'LR',1,'L'); }
			$pdf->SetFont('Arial','',8);
            if($prev_clas<>$codigo){ $monto2_01=$monto4_01-$monto3_01; $mmonto1_00=formato_monto($monto1_00); 
			   $pdf->Cell(110,4,"",'L',0,'L');
			   $pdf->Cell(50,4,"Acumulado al ".$fecha_i,0,0,'L');
			   $pdf->Cell(20,4,$mmonto1_00,0,0,'R');
			   $pdf->Cell(80,4,"",'R',0,'L');
			   $mmonto1_01=formato_monto($monto1_01); $mmonto2_01=formato_monto($monto2_01); $mmonto3_01=formato_monto($monto3_01); $mmonto4_01=formato_monto($monto4_01); $mmonto5_01=formato_monto($monto5_01);
			   
			   $pdf->Cell(130,4,"",'L',0,'L');
			   $pdf->Cell(30,4,"Enero",0,0,'L');
			   $pdf->Cell(20,4,$mmonto1_01,0,0,'R');			   
			   $pdf->Cell(20,4,$mmonto2_01,0,0,'R');			   
			   $pdf->Cell(20,4,$mmonto3_01,0,0,'R');
			   $pdf->Cell(20,4,$mmonto4_01,0,0,'R');
			   $pdf->Cell(20,4,$mmonto5_01,'R',1,'R');
               if($nmes>=2){ $monto4_02=$monto4_01+$monto3_02; $subtotala=$monto4_02; $monto2_02=$monto4_02-$monto3_02;
			      $mmonto1_02=formato_monto($monto1_02); $mmonto2_02=formato_monto($monto2_02); $mmonto3_02=formato_monto($monto3_02); $mmonto4_02=formato_monto($monto4_02); $mmonto5_02=formato_monto($monto5_02);
                  $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Febrero",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_02,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_02,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_02,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_02,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_02,'R',1,'R');				  
               }	
               if($nmes>=3){  $monto4_03=$monto4_02+$monto3_03;  $subtotala=$monto4_03; $monto2_03=$monto4_03-$monto3_03;
			      $mmonto1_03=formato_monto($monto1_03); $mmonto2_03=formato_monto($monto2_03); $mmonto3_03=formato_monto($monto3_03); $mmonto4_03=formato_monto($monto4_03); $mmonto5_03=formato_monto($monto5_03);
                  $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Marzo",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_03,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_03,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_03,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_03,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_03,'R',1,'R');				 
               }
               if($nmes>=4){  $monto4_04=$monto4_03+$monto3_04;  $subtotala=$monto4_04; $monto2_04=$monto4_04-$monto3_04;
                  $mmonto1_04=formato_monto($monto1_04); $mmonto2_04=formato_monto($monto2_04); $mmonto3_04=formato_monto($monto3_04); $mmonto4_04=formato_monto($monto4_04); $mmonto5_04=formato_monto($monto5_04);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Abril",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_04,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_04,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_04,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_04,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_04,'R',1,'R');				 
               }
               if($nmes>=5){  $monto4_05=$monto4_04+$monto3_05;  $subtotala=$monto4_05; $monto2_05=$monto4_05-$monto3_05;
                  $mmonto1_05=formato_monto($monto1_05); $mmonto2_05=formato_monto($monto2_05); $mmonto3_05=formato_monto($monto3_05); $mmonto4_05=formato_monto($monto4_05); $mmonto5_05=formato_monto($monto5_05);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Mayo",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_05,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_05,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_05,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_05,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_05,'R',1,'R');				 
               }	
               if($nmes>=6){  $monto4_06=$monto4_05+$monto3_06;  $subtotala=$monto4_06; $monto2_06=$monto4_06-$monto3_06;
                  $mmonto1_06=formato_monto($monto1_06); $mmonto2_06=formato_monto($monto2_06); $mmonto3_06=formato_monto($monto3_06); $mmonto4_06=formato_monto($monto4_06); $mmonto5_06=formato_monto($monto5_06);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Junio",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_06,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_06,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_06,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_06,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_06,'R',1,'R');				 
               }	
               if($nmes>=7){  $monto4_07=$monto4_06+$monto3_07;  $subtotala=$monto4_07; $monto2_07=$monto4_07-$monto3_07;
                  $mmonto1_07=formato_monto($monto1_07); $mmonto2_07=formato_monto($monto2_07); $mmonto3_07=formato_monto($monto3_07); $mmonto4_07=formato_monto($monto4_07); $mmonto5_07=formato_monto($monto5_07);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Julio",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_07,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_07,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_07,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_07,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_07,'R',1,'R');				 
               }	
               if($nmes>=8){  $monto4_08=$monto4_07+$monto3_08;  $subtotala=$monto4_08; $monto2_08=$monto4_08-$monto3_08;
                  $mmonto1_08=formato_monto($monto1_08); $mmonto2_08=formato_monto($monto2_08); $mmonto3_08=formato_monto($monto3_08); $mmonto4_08=formato_monto($monto4_08); $mmonto5_08=formato_monto($monto5_08);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Agosto",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_08,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_08,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_08,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_08,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_08,'R',1,'R');				 
               }	
               if($nmes>=9){  $monto4_09=$monto4_08+$monto3_09;  $subtotala=$monto4_09; $monto2_09=$monto4_09-$monto3_09;
                  $mmonto1_09=formato_monto($monto1_09); $mmonto2_09=formato_monto($monto2_09); $mmonto3_09=formato_monto($monto3_09); $mmonto4_09=formato_monto($monto4_09); $mmonto5_09=formato_monto($monto5_09);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Septiembre",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_09,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_09,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_09,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_09,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_09,'R',1,'R');				 
               }	
               if($nmes>=10){  $monto4_10=$monto4_09+$monto3_10;  $subtotala=$monto4_10; $monto2_10=$monto4_10-$monto3_10;
                  $mmonto1_10=formato_monto($monto1_10); $mmonto2_10=formato_monto($monto2_10); $mmonto3_10=formato_monto($monto3_10); $mmonto4_10=formato_monto($monto4_10); $mmonto5_10=formato_monto($monto5_10);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Octubre",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_10,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_10,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_10,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_10,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_10,'R',1,'R');				 
               }
               if($nmes>=11){  $monto4_11=$monto4_10+$monto3_11;  $subtotala=$monto4_11; $monto2_11=$monto4_11-$monto3_11;
                  $mmonto1_11=formato_monto($monto1_11); $mmonto2_11=formato_monto($monto2_11); $mmonto3_11=formato_monto($monto3_11); $mmonto4_11=formato_monto($monto4_11); $mmonto5_11=formato_monto($monto5_11);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Noviembre",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_11,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_11,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_11,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_11,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_11,'R',1,'R');				 
               }
			    if($nmes>=12){  $monto4_12=$monto4_10+$monto3_12;  $subtotala=$monto4_12; $monto2_12=$monto4_12-$monto3_12;
                  $mmonto1_12=formato_monto($monto1_12); $mmonto2_12=formato_monto($monto2_12); $mmonto3_12=formato_monto($monto3_12); $mmonto4_12=formato_monto($monto4_12); $mmonto5_12=formato_monto($monto5_12);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Diciembre",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_12,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_12,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_12,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_12,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_12,'R',1,'R');				 
               }
			   
			   $totala=$totala+$subtotala; $subtotalv=$subtotalv-$subtotala; $totalv=$totalv+$subtotalv;   $subtotald=$subtotala-$subtotalg;   $totald=$totald+$subtotald;
			   $subtotalg=formato_monto($subtotalg); $subtotald=formato_monto($subtotald); $subtotali=formato_monto($subtotali);  $subtotalv=formato_monto($subtotalv);  $subtotala=formato_monto($subtotala);
               $pdf->Cell(130,4,"",'L',0,'L');
			   $pdf->Cell(28,4,"Total : ",1,0,'R');
			   $pdf->Cell(22,4,$subtotali,1,0,'R');			   
			   $pdf->Cell(20,4,$subtotald,1,0,'R');			   
			   $pdf->Cell(20,4,$subtotalg,1,0,'R');
			   $pdf->Cell(20,4,$subtotala,1,0,'R');
			   $pdf->Cell(20,4,$subtotalv,1,1,'R');			   
			   		   
               $prev_clas=$codigo;  $den_clas=$descripcion; $subtotalg=0; $subtotalv=0; $subtotali=0; $subtotala=0; 
			   $monto1_00=0; $monto2_00=0; $monto3_00=0; $monto4_00=0; $monto5_00=0;		  
			   $monto1_01=0; $monto2_01=0; $monto3_01=0; $monto4_01=0; $monto5_01=0;
			   $monto1_02=0; $monto2_02=0; $monto3_02=0; $monto4_02=0; $monto5_02=0;
			   $monto1_03=0; $monto2_03=0; $monto3_03=0; $monto4_03=0; $monto5_03=0;
			   $monto1_04=0; $monto2_04=0; $monto3_04=0; $monto4_04=0; $monto5_04=0;
			   $monto1_05=0; $monto2_05=0; $monto3_05=0; $monto4_05=0; $monto5_05=0;
			   $monto1_06=0; $monto2_06=0; $monto3_06=0; $monto4_06=0; $monto5_06=0;
			   $monto1_07=0; $monto2_07=0; $monto3_07=0; $monto4_07=0; $monto5_07=0;
			   $monto1_08=0; $monto2_08=0; $monto3_08=0; $monto4_08=0; $monto5_08=0;
			   $monto1_09=0; $monto2_09=0; $monto3_09=0; $monto4_09=0; $monto5_09=0;
			   $monto1_10=0; $monto2_10=0; $monto3_10=0; $monto4_10=0; $monto5_10=0;
			   $monto1_11=0; $monto2_11=0; $monto3_11=0; $monto4_11=0; $monto5_11=0;
			   $monto1_12=0; $monto2_12=0; $monto3_12=0; $monto4_12=0; $monto5_12=0; 
			   $pdf->Cell(260,5,"",'LR',1,'L');
			   $pdf->Cell(260,4,$prev_clas." ".$den_clas,'LR',1,'L'); 	
		    }			
			$monto=$registro["monto_dep"]; $fecha_dep=$registro["fecha_dep"]; $fechad=$registro["fechad"];	
			$monto=$monto*1;
			if($monto==0){ $subtotalg=$subtotalg; $monto=0; }
			else{ $totalg=$totalg+$monto;  $subtotalg=$subtotalg+$monto; 	 $c=$c+1; 	}		
			if($prev_cod<>$cod_bien_mue){ $subtotali=$subtotali+$valor_incorporacion; $totali=$totali+$valor_incorporacion; 
			  $subtotalv=$subtotalv+$valor;  $prev_cod=$cod_bien_mue; $subtotala=$subtotala+$acumulada;
			
				$mesi=substr($fecha_incorporacion,3,2); $anoi=substr($fecha_incorporacion,6,4); $ano=substr($fecha_d,6,4);
				if($ano==$anoi){
				  if($mesi=="01"){ $monto1_01=$monto1_01+$valor_incorporacion; }
				  if($mesi=="02"){ $monto1_02=$monto1_02+$valor_incorporacion; }
				  if($mesi=="03"){ $monto1_03=$monto1_03+$valor_incorporacion; }
				  if($mesi=="04"){ $monto1_04=$monto1_04+$valor_incorporacion; }
				  if($mesi=="05"){ $monto1_05=$monto1_05+$valor_incorporacion; }
				  if($mesi=="06"){ $monto1_06=$monto1_06+$valor_incorporacion; }
				  if($mesi=="07"){ $monto1_07=$monto1_07+$valor_incorporacion; }
				  if($mesi=="08"){ $monto1_08=$monto1_08+$valor_incorporacion; }
				  if($mesi=="09"){ $monto1_09=$monto1_09+$valor_incorporacion; }
				  if($mesi=="10"){ $monto1_10=$monto1_10+$valor_incorporacion; }
				  if($mesi=="11"){ $monto1_11=$monto1_11+$valor_incorporacion; }
				  if($mesi=="12"){ $monto1_12=$monto1_12+$valor_incorporacion; }
				}else { $monto1_00=$monto1_00+$valor_incorporacion; }
			}
			$mesd=substr($fecha_dep,5,2); $anod=substr($fecha_dep,0,4);
			if($ano==$anod){
			  if($mesd=="01"){ $monto3_01=$monto3_01+$monto; $monto4_01=$monto4_01+$acumulada; }			  
			  if($mesd=="02"){ $monto3_02=$monto3_02+$monto; $monto4_02=$monto4_01+$acumulada; }			  
			  if($mesd=="03"){ $monto3_03=$monto3_03+$monto; $monto4_03=$monto4_03+$acumulada; }
			  if($mesd=="04"){ $monto3_04=$monto3_04+$monto; $monto4_04=$monto4_04+$acumulada; }
			  if($mesd=="05"){ $monto3_05=$monto3_05+$monto; $monto4_05=$monto4_05+$acumulada; }
			  if($mesd=="06"){ $monto3_06=$monto3_06+$monto; $monto4_06=$monto4_06+$acumulada; }
			  if($mesd=="07"){ $monto3_07=$monto3_07+$monto; $monto4_07=$monto4_07+$acumulada; }
			  if($mesd=="08"){ $monto3_08=$monto3_08+$monto; $monto4_08=$monto4_08+$acumulada; }
			  if($mesd=="09"){ $monto3_09=$monto3_09+$monto; $monto4_09=$monto4_09+$acumulada; }
			  if($mesd=="10"){ $monto3_10=$monto3_10+$monto; $monto4_10=$monto4_10+$acumulada; }
			  if($mesd=="11"){ $monto3_11=$monto3_11+$monto; $monto4_11=$monto4_11+$acumulada; }
			  if($mesd=="12"){ $monto3_12=$monto3_12+$monto; $monto4_12=$monto4_12+$acumulada; }
			}	
			$monto_dep=formato_monto($monto);  $saldo_dep=formato_monto($saldo_dep); $valor_incorporacion=formato_monto($valor_incorporacion); $valor=formato_monto($valor); 
			
			/*
			if(($prev_clas=="2003")){
			    $pdf->Cell(30,3,$cod_bien_mue,'L',0,'L'); 
				$pdf->Cell(120,3,$denominacion." ".$ano." ".$anoi." ".$mesi,0,0,'L'); 
				$pdf->Cell(15,3,$fecha_incorporacion,0,0,'L'); 
				$pdf->Cell(15,3,$fechad,0,0,'R');
				$pdf->Cell(20,3,$valor_incorporacion,0,0,'R');
				$pdf->Cell(20,3,$monto_dep,0,0,'R');
				$pdf->Cell(20,3,$acumulada,0,0,'R');
				$pdf->Cell(20,3,$valor,'R',1,'R');
			}
			*/
			
          }	$monto2_01=$monto4_01-$monto3_01;
			   $mmonto1_01=formato_monto($monto1_01); $mmonto2_01=formato_monto($monto2_01); $mmonto3_01=formato_monto($monto3_01); $mmonto4_01=formato_monto($monto4_01); $mmonto5_01=formato_monto($monto5_01);
			   $pdf->Cell(130,4,"",'L',0,'L');
			   $pdf->Cell(30,4,"Enero",0,0,'L');
			   $pdf->Cell(20,4,$mmonto1_01,0,0,'R');			   
			   $pdf->Cell(20,4,$mmonto2_01,0,0,'R');			   
			   $pdf->Cell(20,4,$mmonto3_01,0,0,'R');
			   $pdf->Cell(20,4,$mmonto4_01,0,0,'R');
			   $pdf->Cell(20,4,$mmonto5_01,'R',1,'R');
               if($nmes>=2){ $monto4_02=$monto4_01+$monto3_02; $subtotala=$monto4_02; $monto2_02=$monto4_02-$monto3_02;
			      $mmonto1_02=formato_monto($monto1_02); $mmonto2_02=formato_monto($monto2_02); $mmonto3_02=formato_monto($monto3_02); $mmonto4_02=formato_monto($monto4_02); $mmonto5_02=formato_monto($monto5_02);
                  $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Febrero",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_02,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_02,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_02,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_02,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_02,'R',1,'R');				  
               }	
               if($nmes>=3){  $monto4_03=$monto4_02+$monto3_03;  $subtotala=$monto4_03; $monto2_03=$monto4_03-$monto3_03;
			      $mmonto1_03=formato_monto($monto1_03); $mmonto2_03=formato_monto($monto2_03); $mmonto3_03=formato_monto($monto3_03); $mmonto4_03=formato_monto($monto4_03); $mmonto5_03=formato_monto($monto5_03);
                  $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Marzo",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_03,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_03,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_03,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_03,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_03,'R',1,'R');				 
               }
               if($nmes>=4){  $monto4_04=$monto4_03+$monto3_04;  $subtotala=$monto4_04; $monto2_04=$monto4_04-$monto3_04;
                  $mmonto1_04=formato_monto($monto1_04); $mmonto2_04=formato_monto($monto2_04); $mmonto3_04=formato_monto($monto3_04); $mmonto4_04=formato_monto($monto4_04); $mmonto5_04=formato_monto($monto5_04);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Abril",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_04,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_04,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_04,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_04,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_04,'R',1,'R');				 
               }
               if($nmes>=5){  $monto4_05=$monto4_04+$monto3_05;  $subtotala=$monto4_05; $monto2_05=$monto4_05-$monto3_05;
                  $mmonto1_05=formato_monto($monto1_05); $mmonto2_05=formato_monto($monto2_05); $mmonto3_05=formato_monto($monto3_05); $mmonto4_05=formato_monto($monto4_05); $mmonto5_05=formato_monto($monto5_05);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Mayo",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_05,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_05,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_05,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_05,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_05,'R',1,'R');				 
               }	
               if($nmes>=6){  $monto4_06=$monto4_05+$monto3_06;  $subtotala=$monto4_06; $monto2_06=$monto4_06-$monto3_06;
                  $mmonto1_06=formato_monto($monto1_06); $mmonto2_06=formato_monto($monto2_06); $mmonto3_06=formato_monto($monto3_06); $mmonto4_06=formato_monto($monto4_06); $mmonto5_06=formato_monto($monto5_06);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Junio",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_06,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_06,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_06,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_06,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_06,'R',1,'R');				 
               }	
               if($nmes>=7){  $monto4_07=$monto4_06+$monto3_07;  $subtotala=$monto4_07; $monto2_07=$monto4_07-$monto3_07;
                  $mmonto1_07=formato_monto($monto1_07); $mmonto2_07=formato_monto($monto2_07); $mmonto3_07=formato_monto($monto3_07); $mmonto4_07=formato_monto($monto4_07); $mmonto5_07=formato_monto($monto5_07);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Julio",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_07,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_07,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_07,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_07,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_07,'R',1,'R');				 
               }	
               if($nmes>=8){  $monto4_08=$monto4_07+$monto3_08;  $subtotala=$monto4_08; $monto2_08=$monto4_08-$monto3_08;
                  $mmonto1_08=formato_monto($monto1_08); $mmonto2_08=formato_monto($monto2_08); $mmonto3_08=formato_monto($monto3_08); $mmonto4_08=formato_monto($monto4_08); $mmonto5_08=formato_monto($monto5_08);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Agosto",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_08,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_08,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_08,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_08,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_08,'R',1,'R');				 
               }	
               if($nmes>=9){  $monto4_09=$monto4_08+$monto3_09;  $subtotala=$monto4_09; $monto2_09=$monto4_09-$monto3_09;
                  $mmonto1_09=formato_monto($monto1_09); $mmonto2_09=formato_monto($monto2_09); $mmonto3_09=formato_monto($monto3_09); $mmonto4_09=formato_monto($monto4_09); $mmonto5_09=formato_monto($monto5_09);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Septiembre",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_09,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_09,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_09,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_09,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_09,'R',1,'R');				 
               }	
               if($nmes>=10){  $monto4_10=$monto4_09+$monto3_10;  $subtotala=$monto4_10; $monto2_10=$monto4_10-$monto3_10;
                  $mmonto1_10=formato_monto($monto1_10); $mmonto2_10=formato_monto($monto2_10); $mmonto3_10=formato_monto($monto3_10); $mmonto4_10=formato_monto($monto4_10); $mmonto5_10=formato_monto($monto5_10);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Octubre",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_10,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_10,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_10,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_10,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_10,'R',1,'R');				 
               }
               if($nmes>=11){  $monto4_11=$monto4_10+$monto3_11;  $subtotala=$monto4_11; $monto2_11=$monto4_11-$monto3_11;
                  $mmonto1_11=formato_monto($monto1_11); $mmonto2_11=formato_monto($monto2_11); $mmonto3_11=formato_monto($monto3_11); $mmonto4_11=formato_monto($monto4_11); $mmonto5_11=formato_monto($monto5_11);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Noviembre",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_11,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_11,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_11,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_11,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_11,'R',1,'R');				 
               }
			    if($nmes>=12){  $monto4_12=$monto4_10+$monto3_12;  $subtotala=$monto4_12; $monto2_12=$monto4_12-$monto3_12;
                  $mmonto1_12=formato_monto($monto1_12); $mmonto2_12=formato_monto($monto2_12); $mmonto3_12=formato_monto($monto3_12); $mmonto4_12=formato_monto($monto4_12); $mmonto5_12=formato_monto($monto5_12);
			      $pdf->Cell(130,4,"",'L',0,'L');
			      $pdf->Cell(30,4,"Diciembre",0,0,'L');
			      $pdf->Cell(20,4,$mmonto1_12,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto2_12,0,0,'R');			   
			      $pdf->Cell(20,4,$mmonto3_12,0,0,'R');
			      $pdf->Cell(20,4,$mmonto4_12,0,0,'R');
			      $pdf->Cell(20,4,$mmonto5_12,'R',1,'R');				 
               }	  
		       $totala=$totala+$subtotala; $subtotalv=$subtotalv-$subtotala; $totalv=$totalv+$subtotalv;   $subtotald=$subtotala-$subtotalg;   $totald=$totald+$subtotald;
		       $subtotalg=formato_monto($subtotalg); $subtotald=formato_monto($subtotald); $subtotali=formato_monto($subtotali);  $subtotalv=formato_monto($subtotalv);  $subtotala=formato_monto($subtotala);
		       $pdf->Cell(130,4,"",'L',0,'L');
			   $pdf->Cell(28,4,"Total : ",1,0,'R');
			   $pdf->Cell(22,4,$subtotali,1,0,'R');			   
			   $pdf->Cell(20,4,$subtotald,1,0,'R');			   
			   $pdf->Cell(20,4,$subtotalg,1,0,'R');
			   $pdf->Cell(20,4,$subtotala,1,0,'R');
			   $pdf->Cell(20,4,$subtotalv,1,1,'R');	
		  $pdf->SetFont('Arial','B',8); 
		  $totalg=formato_monto($totalg);  $totald=formato_monto($totald);  $totali=formato_monto($totali); $totalv=formato_monto($totalv);  $totala=formato_monto($totala);
		  $pdf->Cell(260,5,"",'LR',1,'L');
		  $pdf->Cell(158,5,'TOTAL GENERAL : ',1,0,'R');
		  $pdf->Cell(22,5,$totali,1,0,'R');
		  $pdf->Cell(20,5,$totald,1,0,'R');
		  $pdf->Cell(20,5,$totalg,1,0,'R');
		  $pdf->Cell(20,5,$totala,1,0,'R');
	      $pdf->Cell(20,5,$totalv,1,0,'R');
		  $pdf->Output();
	}
	if($num_rpt==4){  	
	    $sSQL = "SELECT bien015.cod_bien_mue, bien015.denominacion, bien015.cod_clasificacion, bien015.valor_incorporacion, bien015.valor_residual, bien015.vida_util, bien015.fecha_incorporacion, bien015.cod_dependencia, bien008.denominacion_c, to_char(bien015.fecha_incorporacion,'DD/MM/YYYY') as fechai  
	     FROM bien008, bien015, WHERE bien015.cod_bien_mue = bien047.cod_bien_mue AND bien015.cod_clasificacion = bien008.codigo_c and  (bien015.fecha_incorporacion<='$fecha_desde') ORDER BY bien015.cod_bien_mue";       
	    
		$sSQL = "SELECT bien015.cod_bien_mue, bien015.denominacion, bien015.cod_clasificacion,  bien015.vida_util, bien015.fecha_incorporacion,bien015.valor_incorporacion,bien015.valor_residual,bien015.monto_depreciado,
	     bien008.denominacion_c , to_char(bien015.fecha_incorporacion,'DD/MM/YYYY') as fechai, bien047.monto_dep, bien047.saldo_dep, bien047.fecha_dep, to_char(bien047.fecha_dep,'DD/MM/YYYY') as fechad 
	     FROM bien008, bien015  left join  bien047 on (bien015.cod_bien_mue=bien047.cod_bien_mue and (bien047.fecha_dep<='$fecha_desde')) WHERE  (bien015.cod_clasificacion=bien008.codigo_c) and  (bien015.fecha_incorporacion<='$fecha_desde')
	      ORDER BY  bien015.cod_clasificacion,bien015.cod_bien_mue,bien047.fecha_dep";
		  
		  
		$res=pg_query($sSQL); 
	    require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $fecha_d; global $mborde; global $tfecha_d;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(200,10,'DEPRECIACION ACUMULADA AL '.$tfecha_d,1,0,'C');
				$this->Ln(20);
			    $this->SetFont('Arial','B',7);
				$this->Cell(30,3,'CODIGO','TRL',0);						
				$this->Cell(125,3,'','TRL',0,'L');				
				$this->Cell(15,3,'FECHA','TRL',0,'C');
				$this->Cell(10,3,'VIDA','TRL',0,'C');
				$this->Cell(20,3,'VALOR','TRL',0,'C');
				$this->Cell(20,3,'DEPRECIACION','TRL',0,'C');
				$this->Cell(20,3,'DEPRECIACION','TRL',0,'C');
				$this->Cell(20,3,'VALOR','TRL',1,'C');				
				$this->Cell(30,4,'DEL BIEN','BRL',0);						
				$this->Cell(125,4,'DESCRIPCION DEL BIEN','BRL',0,'L');				
				$this->Cell(15,4,'ADQUISIC.','BRL',0,'L');
				$this->Cell(10,4,'UTIL','BRL',0,'C');
				$this->Cell(20,4,'INCORPORAC.','BRL',0,'C');
				$this->Cell(20,4,'MENSUAL','BRL',0,'C');
				$this->Cell(20,4,'ACUMULADA','BRL',0,'C');
				$this->Cell(20,4,'S/LIBRO','BRL',1,'C');
                $mborde=0;				
		    } 
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totalg=0; $totalv=0; $totali=0; $totala=0; $prev_referencia=""; $c=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;		  
            $referencia=$registro["referencia_dep"]; $fechat=$registro["fechad"]; $descripcion=$registro["denominacion_c"];	$monto_depreciado=$registro["monto_depreciado"];
			$cod_bien_mue=$registro["cod_bien_mue"]; $codigo=$registro["cod_bien_mue"]; $monto=$registro["monto_dep"]; $denominacion=$registro["denominacion"];
	        $valor_incorporacion=$registro["valor_incorporacion"]; $fecha_incorporacion=$registro["fechai"]; $vida_util=$registro["vida_util"];   $saldo_dep=$registro["saldo_dep"]; 
			$monto=$monto*1;
			if($monto==0){ $acumulada=$monto_depreciado; 			
			  $sqlb="select bien047.monto_dep, bien047.saldo_dep, bien047.fecha_dep  from bien047 WHERE cod_bien_mue='$cod_bien_mue' and fecha_dep>'$fecha_desde' ORDER BY fecha_dep"; $resb=pg_query($sqlb); $filasb=pg_num_rows($resb);
			   if($filasb>0){$regb=pg_fetch_array($resb);  $acumulada=$registro["valor_incorporacion"]-$regb["saldo_dep"]; }
			}	else{$acumulada=$registro["valor_incorporacion"]-$registro["saldo_dep"]+$registro["monto_dep"];  }			
			$valor=$registro["valor_incorporacion"]-$acumulada;			
			$totalg=$totalg+$registro["monto_dep"]; $totalv=$totalv+$valor; $totala=$totala+$acumulada;	$totali=$totali+$valor_incorporacion; $c=$c+1;
			$monto_dep=formato_monto($monto); $acumulada=formato_monto($acumulada); $saldo_dep=formato_monto($saldo_dep); $valor_incorporacion=formato_monto($valor_incorporacion); $valor=formato_monto($valor); 
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);  $descripcion==utf8_decode($descripcion); }
			$denominacion=substr($denominacion,0,80);  $x=$pdf->GetX();   $y=$pdf->GetY();
            $bord=0;	$bordl='L'; $bordr='R';  if(($y>=190)and($mborde==1)){$bord='B'; $bordl='LB'; $bordr='RB';  $mborde=0;}	else { $mborde=1; }		
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(30,3,$cod_bien_mue,$bordl,$bord,'L'); 
			$pdf->Cell(125,3,$denominacion,$bord,0,'L'); 
			$pdf->Cell(15,3,$fecha_incorporacion,$bord,0,'L'); 
			$pdf->Cell(10,3,$vida_util,$bord,0,'R');
			$pdf->Cell(20,3,$valor_incorporacion,$bord,0,'R');
			$pdf->Cell(20,3,$monto_dep,$bord,0,'R');
			$pdf->Cell(20,3,$acumulada,$bord,0,'R');
			$pdf->Cell(20,3,$valor,$bordr,1,'R');
			$x=$pdf->GetX();   $y=$pdf->GetY();
          }		  
		  $pdf->SetFont('Arial','B',7); $totalg=formato_monto($totalg);  $totali=formato_monto($totali);  $totalv=formato_monto($totalv);  $totala=formato_monto($totala);
		  $pdf->Cell(180,5,'TOTAL GENERAL : ',1,0,'R');
		  $pdf->Cell(20,5,$totali,1,0,'R');
		  $pdf->Cell(20,5,$totalg,1,0,'R');
		  $pdf->Cell(20,5,$totala,1,0,'R');
	      $pdf->Cell(20,5,$totalv,1,0,'R');
		  $pdf->Output();
	}
}
?>