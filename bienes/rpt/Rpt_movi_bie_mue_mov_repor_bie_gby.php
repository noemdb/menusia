<?include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_bien_mued=$_GET["cod_bien_mued"];$cod_bien_mueh=$_GET["cod_bien_mueh"];$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; $cod_direcciond=$_GET["cod_direcciond"]; $cod_direccionh=$_GET["cod_direccionh"];
$cod_departamentod=$_GET["cod_departamentod"]; $cod_departamentoh=$_GET["cod_departamentoh"]; $referenciad=$_GET["referenciad"]; $referenciah=$_GET["referenciah"]; $mes_proceso=$_GET["mes_proceso"];$tipo_rep=$_GET["tipo_rep"]; $ordenado=$_GET["ordenado"]; $agrup_dep=$_GET["agrup_dep"];
$date = date("d-m-Y");$hora = date("H:i:s a");$Sql=""; $php_os=PHP_OS;  $tipo_rep="PDF";
$fecha_d="01/".substr($mes_proceso,0,2)."/".substr($mes_proceso,3,4);
if (checkData($fecha_d)=='1'){$error=0; $sfecha=formato_aaaammdd($fecha_d);} else {$fecha_d="01/01/2011";}
$fecha_h=colocar_udiames($fecha_d);$sfechad=formato_aaaammdd($fecha_d); $sfechah=formato_aaaammdd($fecha_h);


$criterio ="(bien015.cod_bien_mue>='$cod_bien_mued' AND bien015.cod_bien_mue<='$cod_bien_mueh') AND (bien025.cod_dependencia>='$cod_dependenciad' AND bien025.cod_dependencia<='$cod_dependenciah') and (bien015.cod_direccion>='$cod_direcciond' and bien015.cod_direccion<='$cod_direccionh') AND
  (bien015.cod_departamento>='$cod_departamentod' and bien015.cod_departamento<='$cod_departamentoh') and  (bien025.referencia>='$referenciad' AND bien025.referencia<='$referenciah') AND (bien025.fecha>='$sfechad') AND (bien025.fecha<='$sfechah')";
$mordenado=" bien015.cod_dependencia,bien015.cod_bien_mue"; if($agrup_dep=="SI"){ $mordenado=" bien015.cod_dependencia,bien015.cod_direccion,bien015.cod_departamento,bien015.cod_bien_mue";}
if($ordenado=="N"){$mordenado=" bien015.cod_dependencia,bien015.num_bien"; if($agrup_dep=="SI"){ $mordenado=" bien015.cod_dependencia,bien015.cod_direccion,bien015.cod_departamento,bien015.cod_bien_mue";} }

$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";}   
   
         // LLAMAR A PHP_REPORT
         $sSQL = "SELECT bien025.referencia, bien025.fecha, bien015.cod_bien_mue, bien015.cod_clasificacion, substr(bien015.Cod_Clasificacion,1,1) as grupo, substr(bien015.Cod_Clasificacion,3,2) as subgrupo, substr(bien015.Cod_Clasificacion,6,1) as seccion, bien015.Num_Bien, bien015.Denominacion, bien015.cod_direccion,bien015.cod_departamento,
bien025.Cod_Dependencia, bien001.Denominacion_Dep, bien001.Direccion_Dep, bien040.Tipo_Movimiento, bien003.Denomina_Tipo, bien040.Tipo_ID, bien025.Descripcion, bien025.Anulado, bien040.Cantidad, bien040.Monto, bien015.Direccion, bien015.Valor_Incorporacion, bien025.Saldo_Anterior, bien006.denominacion_dep as denom_departamento  
FROM bien001, bien003, (bien015 LEFT JOIN bien006 ON (bien006.cod_departamento=bien015.cod_departamento and bien006.cod_dependencia=bien015.cod_dependencia and bien006.cod_direccion=bien015.cod_direccion)), bien025, bien040  WHERE bien001.Cod_Dependencia = bien025.Cod_Dependencia AND (bien025.Fecha=bien040.Fecha) AND
bien015.cod_bien_mue=bien040.cod_bien_mue AND  bien025.referencia=bien040.referencia AND bien040.Tipo_Movimiento = bien003.Codigo AND ((bien025.Anulado='N')) AND ".$criterio." order by ".$mordenado;


    function buca_saldo_ant_dep($mcod_dep){global $sfechad; global $host; global $password; global $user; global $dbname;	
	   $conn=pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");    $msaldo_ant=0;
	   $fsql = "SELECT saldo_inicial from bien001 where (cod_dependencia='".$mcod_dep."')";
	   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $msaldo_ant=$freg["saldo_inicial"];}	   
	   $fsql="select cod_bien_mue from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha<'$sfechad') and (bien040.tipo_id='I') and (bien025.cod_dependencia='$mcod_dep') ";
	   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){
	   $fsql="select sum(monto) as monto_mov from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha<'$sfechad') and (bien040.tipo_id='I') and (bien025.cod_dependencia='$mcod_dep') ";
	   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $msaldo_ant=$msaldo_ant+$freg["monto_mov"];} 
	   }
	   $fsql="select cod_bien_mue from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha<'$sfechad') and (bien040.tipo_id='D') and (bien025.cod_dependencia='$mcod_dep') ";
	   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){
	   $fsql="select sum(monto) as monto_mov from bien040,bien025 where (bien025.referencia=bien040.referencia) and (bien025.fecha=bien040.fecha) and (bien040.fecha<'$sfechad') and (bien040.tipo_id='D') and (bien025.cod_dependencia='$mcod_dep') ";
	   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $msaldo_ant=$msaldo_ant-$freg["monto_mov"];} 
	   }	  
	   return $msaldo_ant;
	}

    if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");	
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_movi_bie_mue_mov_repor_bie_mue_gby.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("localhost");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
            $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
            $oRpt->run();
            $aBench = $oRpt->getBenchmark();
            $iSec   = $aBench["report_end"]-$aBench["report_start"];
	}
		
	if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $cod_dependencia=""; $denominacion_dep="";  $subtotal=0; $fin=0; $prev_cod_dep=""; $direccion_dep=""; $saldo_anterior=0; $denom_departamento=""; $cod_departamento=""; $cod_direccion="";
	     $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_dependencia=$registro["cod_dependencia"];  $prev_cod_dep=$registro["cod_dependencia"];
		      $denominacion_dep=$registro["denominacion_dep"];  $denominacion=$registro["denominacion"]; $direccion_dep=$registro["direccion_dep"];
			  $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"];  $cod_direccion=$registro["cod_direccion"]; IF($agrup_dep=="SI"){$prev_cod_dep=$cod_dependencia.$cod_direccion.$cod_departamento; } 
		      $saldo_anterior=buca_saldo_ant_dep($cod_dependencia);			  
		      if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep);  $direccion_dep=utf8_decode($direccion_dep); $denom_departamento=utf8_decode($denom_departamento);  } }
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $Nom_Emp; global $cod_dependencia; global $denominacion_dep;  global $denom_departamento; global $direccion_dep; global $agrup_dep;  global $mes_proceso;
                $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $estado="YARACUY"; $distrito="";  $municipio="SAN FELIPE"; 	
				$den_enc=$denominacion_dep;	if($agrup_dep=="SI"){ $den_enc=$denominacion_dep." (".$denom_departamento.")"; }			
			    $y=$this->GetY();$x=$this->GetX();
				$this->SetFont('Arial','BU',8);
				$this->Cell(260,5,'FORMULARIO BM-2',0,1,'R');
				$this->SetFont('Arial','B',12);
				$this->Cell(200,10,'RELACION MOVIMIENTOS DE BIENES MUEBLES',0,0,'C');
				$this->SetFont('Arial','',8);
				$this->Cell(60,10,'Hoja Nro.: '.$this->PageNo(),0,1,'R');
				$this->Ln(3);
				$this->Cell(90,5,'1. ESTADO: '.$estado,0,0,'L');
				$this->Cell(90,5,'2. DISTRITO: '.$distrito,0,0,'L');
				$this->Cell(80,5,'3. MUNICIPIO: '.$municipio,0,1,'L');				
				$this->Cell(260,5,'   DIRECCION O LUGAR: '.$direccion_dep,0,1,'L');				
				$this->Cell(200,5,'4. ENTIDAD PROPIETARIA: '.$Nom_Emp,0,0,'L');
				$this->Cell(60,5,'5. SERVICIO: ',0,1,'L');				
				$this->Cell(260,5,'6. UNIDAD DE TRABAJO O DEPENDENCIA: '.$den_enc,0,1,'L');
				$this->Cell(260,5,'7. PERIODO DE LA CUENTA: '.$mes_proceso,0,1,'L');				
				$this->Cell(260,5,'EN EL MES DE LA CUENTA HA OCURRIDO EL SIGUIENTE MOVIMIENTO EN LOS BIENES A CARGO DE ESTA DEPENDENCIA',0,1,'C');
				
				$this->Ln(2);
				$y=$this->GetY();$x=$this->GetX();				
				$this->rect(9.8,60,260.2,125);
				
			    $this->SetFont('Arial','B',6);
				$this->Cell(30,4,'CLASIFICACION','TB',0,'C');					
                $this->SetFont('Arial','B',5);
                $this->Cell(11,4,'CONCEPTO','TL',0,'C');				
                $this->Cell(7,4,'CANTI-','TL',0,'C');				
                $this->Cell(15,4,'NUMERO DE','TL',0,'C'); 
                $this->SetFont('Arial','B',6); 				
				$this->Cell(160,4,'NOMBRE Y DESCRIPCION DE LOS BIENES','TL',0,'C');				
				$this->Cell(18,4,'INCORPO-','TL',0,'C');
				$this->Cell(19,4,'DESINCOR-','TL',1,'C');				
				$this->SetFont('Arial','B',5);
				$this->Cell(8,3,'GRUPO','TB',0);
				$this->Cell(12,3,'SUB-GRUPO','LTB',0);
				$this->Cell(10,3,'SECCION','LTB',0);				
				$this->Cell(11,3,'DEL MOV','LB',0,'C');
				$this->Cell(7,3,'DAD','LB',0,'C');
				$this->Cell(15,3,'IDENTIFICACION','LB',0,'C');
				$this->SetFont('Arial','B',6);
				$this->Cell(160,3,'','BL',0,'L');				
				$this->Cell(18,3,'RACIONES Bs.','BL',0,'C');
				$this->Cell(19,3,'PORACIONES Bs.','BL',1,'C');
				
				$y=$this->GetY();$x=$this->GetX();	
				$this->Line(18,$y-0.1,18,184.9); 
                $this->Line(30,$y-0.1,30,184.9);				
				$this->Line(40,$y-0.1,40,184.9);
				$this->Line(51,$y-0.1,51,184.9);
				$this->Line(58,$y-0.1,58,184.9);
				$this->Line(73,$y-0.1,73,184.9);
				$this->Line(233,$y-0.1,233,184.9);
				$this->Line(251,$y-0.1,251,184.9);
				
				
		    } 
			function Footer(){  global $subtotali; global $subtotald; global $fin; global $saldo_anterior;
			    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $tmonto=formato_monto($subtotal); 
				$this->SetY(-30);	
				$this->SetFont('Arial','B',7);
				$saldo_actual=$saldo_anterior+$subtotali-$subtotald;
				$smontoi=formato_monto($subtotali); $smontod=formato_monto($subtotald); 
				$smontoa=formato_monto($saldo_anterior); $smontoc=formato_monto($saldo_actual);
				if($fin==1){
					$this->Cell(223,3,'RESUMEN',1,0,'C');
					$this->Cell(18,3,'',1,0,'C');
					$this->Cell(19,3,'',1,1,'C');
					$this->Cell(223,4,'INCORPORACIONES EN EL PERIODO DE LA CUENTA',1,0,'R');
					$this->Cell(18,4,$smontoi,1,0,'R');
					$this->Cell(19,4,'',1,1,'R');
					$this->Cell(223,4,'DESINCORPORACIONES EN EL PERIODO DE LA CUENTA',1,0,'R');
					$this->Cell(18,4,'',1,0,'R');
					$this->Cell(19,4,$smontod,1,1,'R');
				}
				else{
				    $this->Cell(223,4,'SUBTOTALES ...  ',1,0,'R');
					$this->Cell(18,4,$smontoi,1,0,'R');
					$this->Cell(19,4,$smontod,1,1,'R');
				}
				
				$this->Ln(10);
				$this->Cell(80,3,'Elaborado por : __________________________',0,0,'C');
				$this->Cell(80,3,'Coordinacion de Bienes : __________________________',0,0,'C');
				$this->Cell(80,3,'Unidad de Trabajo : __________________________',0,1,'C');
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetAutoPageBreak(true, 35);
		  $pdf->SetFont('Arial','',7);
		  
		  
		  $i=0;  $totali=0; $totald=0;   $subtotali=0;  $subtotald=0; $c=0; $totalg=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_mue=$registro["cod_bien_mue"];  $num_bien=$registro["num_bien"];
		    $grupo=$registro["grupo"]; $subgrupo=$registro["subgrupo"]; $seccion=$registro["seccion"];  $direccion_dep=$registro["direccion_dep"];$cod_bien_mue=$registro["cod_bien_mue"]; $denominacion=$registro["denominacion"]; $tipo_id=$registro["tipo_id"];
			$cantidad=1; $monto=$registro["monto"]; $tipo_movimiento=$registro["tipo_movimiento"]; $denomina_tipo=$registro["denomina_tipo"];			
			$cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"]; $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"];  $cod_direccion=$registro["cod_direccion"]; 
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $direccion_dep=utf8_decode($direccion_dep); $denom_departamento=utf8_decode($denom_departamento); }
			$cod_grupo=$cod_dependencia;  if($agrup_dep=="SI"){$cod_grupo=$cod_dependencia.$cod_direccion.$cod_departamento; }
			
			if($prev_cod_dep<>$cod_grupo){			  
			  $prev_cod_dep=$cod_grupo;  $fin=1;
			  $pdf->AddPage();
			  $subtotal=0; $subtotali=0;  $subtotald=0; $fin=0;
			}
			$pdf->SetFont('Arial','',7); 
			 
			$totalg=$totalg+$monto; $subtotal=$subtotal+$monto; $c=$c+1;
			
			if($tipo_id=="I"){ $montoi=formato_monto($monto); $totali=$totali+$monto; $subtotali=$subtotali+$monto; $montod=""; } 
			  else { $montod=formato_monto($monto); $totald=$totald+$monto; $subtotald=$subtotald+$monto; $montoi=""; }
			$monto=formato_monto($monto);
			
			
			$pdf->Cell(8,4,$grupo,0,0,'C');
            $pdf->Cell(12,4,$subgrupo,0,0,'C');	
            $pdf->Cell(10,4,$seccion,0,0,'C');			
			$pdf->Cell(10,4,$tipo_movimiento,0,0,'C');
            $pdf->Cell(8,4,$cantidad,0,0,'C');			
            $pdf->Cell(15,4,$num_bien,0,0,'C');			
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=160;
		    $pdf->SetXY($x+$n,$y);
		    $pdf->Cell(18,4,$montoi,0,0,'R');
		    $pdf->Cell(19,4,$montod,0,0,'R');
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,4,$denominacion,0);
			
          }
		  $fin=1;
		  $pdf->Output();
	}
   }
?>
