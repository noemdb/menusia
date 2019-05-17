<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$mes_proceso=$_GET["mes_proceso"];$tipo_rep=$_GET["tipo_rep"];  $date = date("d-m-Y");$hora = date("H:i:s a");$Sql=""; $php_os=PHP_OS;  
$fecha_d="01/".substr($mes_proceso,0,2)."/".substr($mes_proceso,3,4);if (checkData($fecha_d)=='1'){$error=0; $sfecha=formato_aaaammdd($fecha_d);} else {$fecha_d="01/01/2011";}
$fecha_h=colocar_udiames($fecha_d);$sfechad=formato_aaaammdd($fecha_d); $sfechah=formato_aaaammdd($fecha_h); $mes=substr($mes_proceso,0,2); $des_mes=""; $ano=substr($mes_proceso,3,4);
if ($mes=='01'){$des_mes="Enero";}elseif ($mes=='02'){$des_mes="Febrero";}elseif ($mes=='03'){$des_mes="Marzo";}elseif ($mes=='04'){$des_mes="Abril";}elseif ($mes=='05'){$des_mes="Mayo";}elseif ($mes=='06'){$des_mes="Junio";}elseif ($mes=='07'){$des_mes="Julio";}elseif ($mes=='08'){$des_mes="Agosto";}elseif ($mes=='09'){$des_mes="Septiembre";}elseif ($mes=='10'){$des_mes="Octubre";}elseif ($mes=='11'){$des_mes="Noviembre";}elseif ($mes=='12'){$des_mes="Diciembre";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }  
   $saldo_anterior=0; $incorp=0; $desincorp=0; $desincorp60=0;
   $fsql = "SELECT sum(saldo_inicial) as saldo_ini from bien001";
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $saldo_anterior=$freg["saldo_ini"];}	
   
   $fsql="select cod_bien_mue from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha<'$sfechad') and (bien040.tipo_id='I') ";
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){
   $fsql="select sum(monto) as monto_mov from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha<'$sfechad') and (bien040.tipo_id='I')";
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $saldo_anterior=$saldo_anterior+$freg["monto_mov"];} 
   }   
   
   $fsql="select cod_bien_mue from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha<'$sfechad') and (bien040.tipo_id='D')";
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){
   $fsql="select sum(monto) as monto_mov from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha<'$sfechad') and (bien040.tipo_id='D')";
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres);  $saldo_anterior=$saldo_anterior-$freg["monto_mov"];} 
   }	

   $fsql="select cod_bien_mue from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha>='$sfechad') and (bien040.fecha<='$sfechah') and (bien040.tipo_id='I')";
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){
   $fsql="select sum(monto) as monto_mov from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha>='$sfechad') and (bien040.fecha<='$sfechah') and (bien040.tipo_id='I')";
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $incorp=$freg["monto_mov"]; } 
   } 

   $fsql="select cod_bien_mue from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha>='$sfechad') and (bien040.fecha<='$sfechah') and (bien040.tipo_id='D')";
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){
   $fsql="select sum(monto) as monto_mov from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha>='$sfechad') and (bien040.fecha<='$sfechah')  and (bien040.tipo_id='D')";
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $desincorp=$freg["monto_mov"];} 
   } 
   
   $fsql="select cod_bien_mue from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha>='$sfechad') and (bien040.fecha<='$sfechah') and (bien040.tipo_id='D') and (bien040.tipo_movimiento='060')";
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){
   $fsql="select sum(monto) as monto_mov from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha>='$sfechad') and (bien040.fecha<='$sfechah') and (bien040.tipo_id='D') and (bien040.tipo_movimiento='060')";
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $desincorp60-$freg["monto_mov"];} 
   }    
   
   $desincorp=$desincorp-$desincorp60; 
   $saldo_final=$saldo_anterior+$incorp-$desincorp-$desincorp60;
   
   $totali=$saldo_anterior+$incorp; $totald=$saldo_final+$desincorp+$desincorp60;
   $totali=formato_monto($totali); $totald=formato_monto($totald);
   $incorp=formato_monto($incorp); $desincorp=formato_monto($desincorp); $desincorp60=formato_monto($desincorp60);
   
   
   $saldo_anterior=formato_monto($saldo_anterior); $saldo_final=formato_monto($saldo_final);
   if($tipo_rep=="PDF"){
          require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $Nom_Emp; global $mes_proceso; global $des_mes; global $ano;
                $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  
                $estado="YARACUY"; $distrito="";  $municipio="SAN FELIPE"; 	
			    $y=$this->GetY();$x=$this->GetX();
				$this->SetFont('Arial','BU',8);
				$this->Cell(260,5,'FORMULARIO BM-4',0,1,'R');
				$this->SetFont('Arial','B',12);
				$this->Cell(260,10,'RESUMEN DE LA CUENTA DE BIENES MUEBLES EN CADA UNIDAD DE TRABAJO',0,1,'C');
				$this->Ln(3);
				$this->SetFont('Arial','',9);
				$this->Cell(90,5,'ESTADO: '.$estado,0,0,'L');
				$this->Cell(90,5,'DISTRITO: '.$distrito,0,0,'L');
				$this->Cell(80,5,'MUNICIPIO: '.$municipio,0,1,'L');	
				$this->Cell(260,5,'CORRESPONDIENTES AL MES DE '.$des_mes." DE ".$ano,0,1,'L');				
				$this->Ln(7);				
		    } 
			function Footer(){  
			    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  
				$this->SetY(-30);	
				$this->SetFont('Arial','',8);
				$this->Cell(260,5,'Firma del Jefe Responsable de la Unidad de Trabajo o Departamento : __________________________',0,1,'R');
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',9);
		  $pdf->Cell(200,6,"Existencia Anterior",0,0,'L');
          $pdf->Cell(30,6,$saldo_anterior,0,0,'R');	
		  $pdf->Cell(30,6,"",0,1,'R');
		  $pdf->Ln(1);
		  
		  $pdf->Cell(200,6,"Incorporaciones en el mes de la cuenta",0,0,'L');
          $pdf->Cell(30,6,$incorp,0,0,'R');	
		  $pdf->Cell(30,6,"",0,1,'R');
		  $pdf->Ln(3);
		  
		  $pdf->Cell(200,4,"Desincorporaciones en el mes de la cuenta por todos los conceptos, con",0,0,'L');
          $pdf->Cell(30,4,"",0,0,'R');	
		  $pdf->Cell(30,4,"",0,1,'R');
		  $pdf->Cell(200,3,'excepcion del 60,"Faltantes de Bienes por Investigar"',0,0,'L');
          $pdf->Cell(30,3,"",0,0,'R');	
		  $pdf->Cell(30,3,$desincorp,0,1,'R');
		  $pdf->Ln(3);
		  
		  $pdf->Cell(200,4,'Desincorporaciones en el mes de la cuenta por concepto 60 "Faltantes',0,0,'L');
          $pdf->Cell(30,4,"",0,0,'R');	
		  $pdf->Cell(30,4,"",0,1,'R');
		  $pdf->Cell(200,3,' de Bienes por Investigar"',0,0,'L');
          $pdf->Cell(30,3,"",0,0,'R');	
		  $pdf->Cell(30,3,$desincorp60,0,1,'R');
		  $pdf->Ln(3);
		  
		  $pdf->Cell(200,6,"Existencia Final",0,0,'L');
          $pdf->Cell(30,6,"",0,0,'R');	
		  $pdf->Cell(30,6,$saldo_final,0,1,'R');
		  
		  
		  $pdf->Cell(200,2,"",0,0,'L');
          $pdf->Cell(30,2,"----------------------",0,0,'R');	
		  $pdf->Cell(30,2,"----------------------",0,1,'R');
		  
		  $pdf->Cell(200,4,"",0,0,'L');
          $pdf->Cell(30,4,$totali,0,0,'R');	
		  $pdf->Cell(30,4,$totald,0,1,'R');
		  
		  $pdf->Output();   
   }

}