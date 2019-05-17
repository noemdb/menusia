<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$cod_banco_d;$num_cheque_d=$_GET["num_cheque_d"];$num_cheque_h=$_GET["num_cheque_h"];$ult_cheque_d=$_GET["ult_cheque_d"];$ult_cheque_h=$_GET["ult_cheque_h"]; 
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $ordenar=$_GET["ordenado"]; $tipo_rep=$_GET["tipo_rep"];
$firma1=$_GET["firma1"]; $cargo1=$_GET["cargo1"]; $firma2=$_GET["firma2"]; $cargo2=$_GET["cargo2"]; $firma3=$_GET["firma3"]; $cargo3=$_GET["cargo3"];
$criterio1="PERIODO DEL : ".$fecha_d." AL : ".$fecha_h;  $criterio2="";
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}        $fecha_hasta=$ano1.$mes1.$dia1;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{   $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }  $criterio2=$Nom_Emp;
        $sformula= " and (ban006.anulado='N') ";
        $sSQL = "SELECT ban006.cod_banco, ban002.nombre_banco, ban002.nro_cuenta, ban006.num_cheque, ban006.fecha, text(to_char(EXTRACT(day from ban006.fecha),'09'))||text('/')||text (to_char(EXTRACT(month from ban006.fecha),'09'))||text('/')||text (to_char(EXTRACT(year from ban006.fecha),'0009')) as fechae,
                ban006.ced_rif, pre099.nombre, ban006.nro_orden_pago, ban006.concepto, ban006.anulado,  ban006.fecha_anulado, ban006.entregado, ban006.fecha_entregado, ban006.ced_rif_recib,
                ban006.nombre_recib, ban006.monto_cheque FROM ban002, ban006, pre099 WHERE ban006.cod_banco = ban002.cod_banco and ban006.ced_rif = pre099.ced_rif and
                ban006.cod_banco>='".$cod_banco_d."' and ban006.cod_banco<='".$cod_banco_h."' and  ban006.num_cheque>='".$num_cheque_d."' and ban006.num_cheque<='".$num_cheque_h."' and
				substring(ban006.num_cheque,3,6)>='".$ult_cheque_d."' and substring(ban006.num_cheque,3,6)<='".$ult_cheque_h."' and
                ban006.Fecha>='".$fecha_desde."' and ban006.Fecha<='".$fecha_hasta."' ".$sformula." order by ".$ordenar."";
		//echo $sSQL;
	if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Cheques_Emitidos_Para_Banco.xml");
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
		
	if($tipo_rep=="PDF"){   $cod_banco_grupo=""; $res=pg_query($sSQL); $filas=pg_num_rows($res);
      $nombre_banco=""; $nro_cuenta=""; $prev_nombre_banco=""; $prev_nro_cuenta="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $nombre_banco=$registro["nombre_banco"];  $nro_cuenta=$registro["nro_cuenta"]; }	
      $prev_nombre_banco=$nombre_banco;	  $prev_nro_cuenta=$nro_cuenta;
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $tam_logo;  global $criterio1; global $criterio2;  global $cod_banco_grupo; global $nombre_banco; global $nro_cuenta;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				//$this->Cell(20);
				$this->SetFont('Arial','B',10);
				$this->Cell(20);
				$this->Cell(180,5,'CHEQUES EMITIDOS POR '.$criterio2,'RLT',1,'C');
				$this->Cell(20);
				$this->Cell(180,5,'CONTRA EL BANCO:'.'   '.$nombre_banco,'RL',1,'C');
                $this->Cell(20);				
				$this->Cell(180,5,'NUMERO DE CUENTA:'.'   '.$nro_cuenta,'RL',1,'C');
                $this->Cell(20);				
				$this->Cell(180,5,$criterio1,'RLB',1,'C');
                $this->SetFont('Arial','B',8);				
				$this->Ln(3);
				$this->Cell(180,5,"POR MEDIO DE LA PRESENTE SE DA CONFORMIDAD A LOS SIGUIENTES CHEQUES DE NUESTRA CUENTA",0,1,'L');					
                $this->Ln(2);
				$this->Cell(20,5,'CHEQUE NRO',1,0,'L');
				$this->Cell(25,5,'FECHA EMISION',1,0,'L');						
				$this->Cell(20,5,'CEDULA/RIF',1,0,'L');
				$this->Cell(110,5,'NOMBRE',1,0,'L');						
				$this->Cell(25,5,'MONTO CHEQUE',1,1,'R');
				
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
		  $i=0;  $total_cheque=0; $total=0; $cantidada=0; $prev_cod_banco=""; $total_cheque=0; $cantidad=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=utf8_decode($registro["nombre_banco"]); $nro_cuenta=$registro["nro_cuenta"];
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta;               
		       $num_cheque=$registro["num_cheque"]; $fecha=$registro["fecha"]; $ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];
			   $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];  $monto_cheque=$registro["monto_cheque"]; 
			   $total=$total+$monto_cheque; $total_cheque=$total_cheque+$monto_cheque; $cantidad=$cantidad+1; $monto_cheque=formato_monto($monto_cheque); 	
			   if($php_os=="WINNT"){$nombre=$registro["nombre"]; }else{$nombre=utf8_decode($nombre);}	
			   $pdf->SetFont('Arial','',8);   
			   $pdf->Cell(20,4,$num_cheque,0,0,'L'); 
			   $pdf->Cell(25,4,$fecha,0,0,'C'); 
			   $pdf->Cell(20,4,$ced_rif,0,0,'L');				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=110; 
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(25,4,$monto_cheque,0,1,'R'); 				
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,4,$nombre,0); 
				
			} $total=formato_monto($total);
			$pdf->SetFont('Arial','B',8);
			if($total_cheque>0){ $total_cheque=formato_monto($total_cheque); 					    
				$pdf->Cell(175,2,'',0,0);
				$pdf->Cell(25,2,'------------------------',0,1,'R');
				$pdf->Cell(30,5,"CANTIDAD CHEQUES: ".$cantidad,0,0,'L');  
				$pdf->Cell(145,5,"TOTAL BANCO: ".$prev_nombre_banco."    ".$prev_nro_cuenta,0,0,'R');  
				$pdf->Cell(25,5,$total_cheque,0,1,'R'); 
			}
			if($Cod_Emp=="71"){
			   $pdf->Ln(20);
			   $pdf->SetFont('Arial','B',7);
			   $pdf->Cell(65,2,'_______________________________________',0,0,'C');
			   $pdf->Cell(65,2,'_______________________________________',0,0,'C');
			   $pdf->Cell(70,2,'_______________________________________',0,1,'C');
			   $pdf->Cell(65,4,$firma3,0,0,'C');
			   $pdf->Cell(65,4,$firma2,0,0,'C');
			   $pdf->Cell(70,4,$firma1,0,1,'C');			   
			   $pdf->Cell(65,4,$cargo3,0,0,'C');
			   $pdf->Cell(65,4,$cargo2,0,0,'C');
			   $pdf->Cell(70,4,$cargo1,0,1,'C');
			}
		    $pdf->Output();    
  }
    
}
?>

