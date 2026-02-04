<? include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$equipo = getenv("COMPUTERNAME"); $mcod_m="BAN04L".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$tipo_mov_d=$_GET["tipo_mov_d"];$tipo_mov_h=$_GET["tipo_mov_h"]; $tipo_rep=$_GET["tipo_rep"];
$periodod=$_GET["periodod"];$periodoh=$_GET["periodoh"];$imprimir=$_GET["imprimir"];$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; 
    if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
     $mano=substr($Fec_Fin_Ejer,0,4);     $fecha_d=$Fec_Ini_Ejer; $fecha_h=$Fec_Fin_Ejer;

        if ($periodod=='01'){$fecha_d=$mano.'-01-01';}  if ($periodoh=='01'){$fecha_h=$mano.'-01-31';}


	if ($periodod=='02'){$fecha_d=$mano.'-02-01';}  if ($periodoh=='02'){$fecha_h=$mano.'-02-28';}
	if ($periodod=='03'){$fecha_d=$mano.'-03-01';}  if ($periodoh=='03'){$fecha_h=$mano.'-03-31';}
	if ($periodod=='04'){$fecha_d=$mano.'-04-01';}  if ($periodoh=='04'){$fecha_h=$mano.'-04-30';}
	if ($periodod=='05'){$fecha_d=$mano.'-05-01';}  if ($periodoh=='05'){$fecha_h=$mano.'-05-31';}
	if ($periodod=='06'){$fecha_d=$mano.'-06-01';}  if ($periodoh=='06'){$fecha_h=$mano.'-06-30';}
	if ($periodod=='07'){$fecha_d=$mano.'-07-01';}  if ($periodoh=='07'){$fecha_h=$mano.'-07-31';}



	if ($periodod=='08'){$fecha_d=$mano.'-08-01';}  if ($periodoh=='08'){$fecha_h=$mano.'-08-31';}
	if ($periodod=='09'){$fecha_d=$mano.'-09-01';}  if ($periodoh=='09'){$fecha_h=$mano.'-09-30';}

	if ($periodod=='10'){$fecha_d=$mano.'-10-01';}  if ($periodoh=='10'){$fecha_h=$mano.'-10-31';}
	if ($periodod=='11'){$fecha_d=$mano.'-11-01';}  if ($periodoh=='11'){$fecha_h=$mano.'-11-30';}
	if ($periodod=='12'){$fecha_d=$mano.'-12-01';}  if ($periodoh=='12'){$fecha_h=$mano.'-12-31';}
	

  
	$sfechad=formato_ddmmaaaa($fecha_d);  $sfechah=formato_ddmmaaaa($fecha_h);
	$criterio1="Desde ".$sfechad." Al ".$sfechah; 	  
    
	
	$sSQL = "SELECT BAN004.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN004.Tipo_Mov_Libro, BAN003.Descrip_Tipo_Mov, BAN004.Fecha_Mov_Libro, BAN004.Monto_Mov_Libro, BAN004.Anulado,BAN004.Fecha_Anulado, BAN003.Tipo, BAN003.Operacion  FROM BAN002, BAN003, BAN004 
                WHERE BAN002.Cod_Banco = BAN004.Cod_Banco AND BAN004.Tipo_Mov_Libro = BAN003.Tipo_Movimiento AND
                BAN004.Cod_Banco>='".$cod_banco_d."' AND BAN004.Cod_Banco<='".$cod_banco_h."' AND
                BAN004.Tipo_Mov_Libro>='".$tipo_mov_d."' AND BAN004.Tipo_Mov_Libro<='".$tipo_mov_h."' AND
                BAN004.Fecha_Mov_Libro>='".$fecha_d."' AND BAN004.Fecha_Mov_Libro<='".$fecha_h."'
                ORDER BY BAN004.Cod_Banco, BAN004.Tipo_Mov_Libro, BAN004.Fecha_Mov_Libro";  
	   
  
//echo "paso";

   if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");
	         //echo $sSQL;
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Resumen_Movimientos_Libros.xml");
			 //$oRpt->setXML("Rpt_Resumen_Movimientos_Libros_Detallado.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec   = $aBench["report_end"]-$aBench["report_start"];
    }
	
	if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $filas=pg_num_rows($res);
	    if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		    //if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} 		    
		  
            }
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $tam_logo;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'RESUMEN MOVIMIENTOS EN LIBROS',1,0,'C');
				$this->Ln(20);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,5,$criterio1,0,1,'L');	                
				$this->Ln(3);
					
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
		  $i=0;  $totald=0; $totalh=0; $sub_totali=0; $sub_totale=0; $sub_totala=0;  $sub_totalm=0;  $prev_cod_banco="";  $prev_mes_mov=""; $prev_tipo="";  $prev_des_tipo="";
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  
		       $cod_banco=$registro["cod_banco"];  $nro_cuenta=$registro["nro_cuenta"];
		       $mes_mov=$registro["mes_mov"]; $tipo_mov_libro=$registro["tipo_mov_libro"]; $descrip_tipo_mov=$registro["descrip_tipo_mov"];
			  // if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} 
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; $mes_mov_grupo=$mes_mov; 
			   
			   if((($prev_tipo<>$tipo_mov_libro)or($prev_cod_banco<>$cod_banco_grupo))and ($sub_totalm<>0)){
			     $total_tipo=formato_monto($sub_totalm);
				 $pdf->Cell(10,3,$prev_tipo,0,0); 
				 $pdf->Cell(145,3,$prev_des_tipo,0,0); 
				 $pdf->Cell(25,3,$total_tipo,0,1,'R'); 
			     $sub_totalm=0;	 $prev_tipo=$tipo_mov_libro; $prev_des_tipo=$descrip_tipo_mov;
			   }
		       if($prev_cod_banco<>$cod_banco_grupo){ 
			     if($prev_cod_banco<>""){ 			     
				    if($imprimir=="S"){ $sub_totali=formato_monto($sub_totali); $sub_totale=formato_monto($sub_totale); $sub_totala=formato_monto($sub_totala);
					  $pdf->Ln(3);					  
					  $pdf->Cell(10,4,'',0,0); 
				      $pdf->Cell(70,4,"TOTAL INGRESOS",'LT',0); 
				      $pdf->Cell(25,4,$sub_totali,'RT',0,'R');
					  $pdf->Cell(5,4,'',0,1); 					  
					  $pdf->Cell(10,4,'',0,0); 
				      $pdf->Cell(70,4,"TOTAL EGRESOS",'L',0); 
				      $pdf->Cell(25,4,$sub_totale,'R',0,'R');
					  $pdf->Cell(5,4,'',0,1); 					  
					  $pdf->Cell(10,4,'',0,0); 
				      $pdf->Cell(70,4,"TOTAL MOVIMIENTOS",'LB',0); 
				      $pdf->Cell(25,4,$sub_totala,'RB',0,'R');
					  $pdf->Cell(5,4,'',0,1); 
					}
				    $pdf->Ln(5); 
				 }
				 $pdf->SetFont('Arial','B',8);
			     $pdf->Cell(200,5,$cod_banco_grupo." ".$nombre_banco_grupo."  Nro. Cuenta: ".$nro_cuenta_grupo,'B',1);
				 $pdf->Ln(1);
				 $prev_cod_banco=$cod_banco_grupo;   $sub_totali=0; $sub_totale=0; $sub_totala=0;  $sub_totalm=0;
				 $prev_tipo=$tipo_mov_libro; $prev_des_tipo=$descrip_tipo_mov;
			   }
			   $pdf->SetFont('Arial','',8);
			   $monto_mov_libro=$registro["monto_mov_libro"]; $operacion=$registro["operacion"];
			   $sub_totalm=$sub_totalm+$monto_mov_libro;
			   if($operacion=="I"){ $sub_totali=$sub_totali+$monto_mov_libro;}
			   if($operacion=="E"){ $sub_totale=$sub_totale+$monto_mov_libro;}
			   if($operacion=="M"){ $sub_totala=$sub_totala+$monto_mov_libro;}
			   
	     }		 
		 if($sub_totalm<>0){
			 $total_tipo=formato_monto($sub_totalm);
			 $pdf->Cell(10,3,$prev_tipo,0,0); 
			 $pdf->Cell(145,3,$prev_des_tipo,0,0); 
			 $pdf->Cell(25,3,$total_tipo,0,1,'R'); 
			 $sub_totalm=0;	 $prev_tipo=$tipo_mov_libro; $prev_des_tipo=$descrip_tipo_mov;
		 }
		 if($imprimir=="S"){ $sub_totali=formato_monto($sub_totali); $sub_totale=formato_monto($sub_totale); $sub_totala=formato_monto($sub_totala);
			  $pdf->Ln(3);					  
			  $pdf->Cell(10,4,'',0,0); 
			  $pdf->Cell(70,4,"TOTAL INGRESOS",'LT',0); 
			  $pdf->Cell(25,4,$sub_totali,'RT',0,'R');
			  $pdf->Cell(5,4,'',0,1); 					  
			  $pdf->Cell(10,4,'',0,0); 
			  $pdf->Cell(70,4,"TOTAL EGRESOS",'L',0); 
			  $pdf->Cell(25,4,$sub_totale,'R',0,'R');
			  $pdf->Cell(5,4,'',0,1); 					  
			  $pdf->Cell(10,4,'',0,0); 
			  $pdf->Cell(70,4,"TOTAL MOVIMIENTOS",'LB',0); 
			  $pdf->Cell(25,4,$sub_totala,'RB',0,'R');
			  $pdf->Cell(5,4,'',0,1); 
		 }  
		 
		 $pdf->Output();   
		 $pdf->SetFont('Arial','B',6);
	}
}
?>

