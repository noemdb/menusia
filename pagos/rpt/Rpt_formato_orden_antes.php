<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){ $nro_orden="";$tipo_causado=""; } else{$nro_orden=$_GET["txtnro_orden"];  $tipo_causado=$_GET["txttipo_causado"];}
$sql="Select * from ORD_PAGO where tipo_causado='$tipo_causado' and nro_orden='$nro_orden'";
$rif_emp="G-20000297-2";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$concepto="";$fecha="";$nombre_abrev_caus=""; $ced_rif="";$nombre="";$inf_usuario="";$anulado="";  $tipo_documento="";  $nro_documento=""; $afecta_presu=""; $status_1=""; $usuario_sia="";
$func=""; $inv=""; $con_comp=""; $directa=""; $financ=""; $caja_chica=""; $permanente=""; $orden_permanen=""; $cod_tipo_orden="";
$oc=""; $os=""; $fact=""; $nom=""; $anticipo=""; $recibo=""; $otros="";
$ing_ord=""; $fuente_otra="";
$res=pg_query($sql); $filas=pg_num_rows($res); $total_neto=0;
if($filas>0){  $registro=pg_fetch_array($res); $nro_orden=$registro["nro_orden"];   $tipo_causado=$registro["tipo_causado"];
  $fecha=$registro["fecha"];  $concepto=$registro["concepto"]; $afecta_presu=$registro["afecta_presu"]; $status_1=$registro["status_1"];
  $inf_usuario=$registro["inf_usuario"];  $nombre_abrev_caus=$registro["nombre_abrev_caus"]; $cod_tipo_orden=$registro["tipo_orden"];
  $ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];  $func_inv=$registro["func_inv"];
  $anulado=$registro["anulado"];  $pago_ces=$registro["pago_ces"];  $ced_rif_ces=$registro["ced_rif_ces"]; $usuario_sia=$registro["usuario_sia"];
  $nombre_ces=$registro["nombre_ces"];  $tipo_documento=$registro["tipo_documento"];  $nro_documento=$registro["nro_documento"];
  $total_causado=$registro["total_causado"];  $total_retencion=$registro["total_retencion"];
  $total_ajuste=$registro["total_ajuste"];  $total_pasivos=$registro["total_pasivos"];  $monto_am_ant=$registro["monto_am_ant"];
  $orden_permanen=$registro["orden_permanen"];
  $total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant + $total_pasivos;
} $tipo_comp='O'.$tipo_causado; $sfecha=$fecha; $referencia=$nro_orden;
if($func_inv=="C"){$func="x";}else{if($func_inv=="I"){$inv="x";}else{$inv="x"; $func="x";}}
if ($tipo_causado<"0002") {$con_comp="x";}else{$con_comp=" ";}
if ($tipo_causado=="0002") {$directa="x";}else{$directa=" ";}
if ($tipo_causado=="0003") {$financ="x";}else{$financ=" ";}
if ($cod_tipo_orden=="0016") {$caja_chica="x";}else{$caja_chica=" ";}
if ($orden_permanen=="S") {$permanente="x";}else{$permanente=" ";}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);} $total_neto=formato_monto($total_neto); $total_causado=formato_monto($total_causado); $total_aju=formato_monto($total_ajuste); 
if($afecta_presu=="S"){$tipo_orden="CON IMPUTACION";}else{$tipo_orden="SIN IMPUTACION";}
$sql="SELECT * FROM codigos_causados where tipo_causado='$tipo_causado' and referencia_caus='$nro_orden' order by cod_presup";$res=pg_query($sql);$filas=pg_num_rows($res); $tipo_compromiso=""; $fuente_financ=""; $referencia_comp="";
if($filas>0){  $registro=pg_fetch_array($res); $tipo_compromiso=$registro["tipo_compromiso"]; $fuente_financ=$registro["fuente_financ"]; $referencia_comp=$registro["referencia_comp"]; }
$sql="SELECT * FROM PAG016  where nro_orden='$nro_orden' order by nro_factura";$res=pg_query($sql); $cant_fact=pg_num_rows($res);
$firma="PRESUPUESTO";if(($afecta_presu=="N")and($status_1=="S")){$firma="CONTABILIDAD";}
if(substr($tipo_causado,0,1)=='A'){$referencia='A'.substr($nro_orden,1,7);}
$monto_letras= monto_letras($total_neto);
$usuario_comp=$usuario_sia;
if ($tipo_compromiso=="0001" and $tipo_causado<>"0003") {$oc="x";}else{$oc=" ";}
if (($tipo_compromiso=="0002") and ($tipo_causado<>"0003")) {$os="x";}else{$os=" ";}
if ($tipo_documento=="FACTURA" or $tipo_compromiso=="0001" or $tipo_compromiso=="0002") {$fact="x";}else{$fact=" ";}
if (($tipo_documento=="NOMINA") and ($tipo_causado<>"0003")) {$nom="x";}else{$nom=" ";}
if ($tipo_documento=="ANTICIPO") {$anticipo="x";}else{$anticipo=" ";}
if ($tipo_documento=="RECIBO") {$recibo="x";}else{$recibo=" ";}
if (($tipo_documento<>"ANTICIPO" or $tipo_documento<>"RECIBO" or $tipo_documento<>"FACTURA" or $tipo_documento<>"NOMINA")or ($tipo_compromiso=="0001") or ($tipo_compromiso=="0002") ) {$otros="x";}else{$otros=" ";}
$ing_ord=" ";$fuente_otra=" ";
if ($fuente_financ=="00") {$ing_ord="x";}else{$fuente_otra="x";}
$sql="select * from sia001 where campo101='$usuario_comp'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}
$total_ret=0; $sqlc="SELECT tipo_retencion,descripcion_ret,cod_contable_ret,tasa_retencion,sum(monto_retencion) as monto_retencion FROM RET_ORD where nro_orden_ret='$nro_orden' group by tipo_retencion,descripcion_ret,cod_contable_ret,tasa_retencion order by tipo_retencion";
$resret=pg_query($sqlc); $filas=pg_num_rows($resret); $k=0; $max_cret=12;
$cod_r=array ('','','','','','','','','','','','','','',''); $tasa_r=array ('','','','','','','','','','','','','','','');
$den_r=array ('','','','','','','','','','','','','','',''); $monto_r=array ('','','','','','','','','','','','','','','');
while($registro=pg_fetch_array($resret)){  
$tasa=$registro["tasa_retencion"]; $tasa=formato_monto($tasa); $monto=$registro["monto_retencion"]; $monto=formato_monto($monto); 
$total_ret=$total_ret+$registro["monto_retencion"]; $concepto_ret=$registro["descripcion_ret"]; $concepto_ret=substr($concepto_ret,0,100);
$cod_r[$k]=$registro["tipo_retencion"]; $cod_r[$k]=$registro["tipo_retencion"];
$tasa_r[$k]=$tasa; $monto_r[$k]=$monto; $den_r[$k]=$concepto_ret; if($k<15){$k=$k+1;} } $cant_r=$k;  $total_ret=formato_monto($total_ret); 
$cod_c=array ('','','','','','','','','','','','','','',''); $debe_c=array ('','','','','','','','','','','','','','','');
$den_c=array ('','','','','','','','','','','','','','',''); $haber_c=array ('','','','','','','','','','','','','','','');
$k=0; $max_ccont=9;
$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$referencia' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;} 
$cod_c[$k]=$registro["cod_cuenta"]; $den_c[$k]=$registro["nombre_cuenta"]; $debe_c[$k]=$debe; $haber_c[$k]=$haber; if($k<15){$k=$k+1;}} $cant_cont=$k;
$sqlc="SELECT * FROM codigos_causados where tipo_causado='$tipo_causado' and referencia_caus='$nro_orden' order by cod_presup";
$resc=pg_query($sqlc); $filas=pg_num_rows($resc); $cant_cod_presup=$filas; $max_cpre=33; 
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $nro_orden; global $func_inv; global $tipo_orden; global $fecha; global $nombre; global $ced_rif; 
	   global $concepto; global $php_os; global $func; global $inv;	global	$con_comp; global $directa; global $financ; global $caja_chica;
	   global $permanente; global $monto_letras; global $total_neto; global $cant_r; global $max_cret; global $total_causado;
	   global $cod_r; global $den_r; global $tasa_r;  global $monto_r;	global $total_ret; global $total_aju; global $total_neto; global $monto_am_ant;
	    //$nombre=utf8_decode($nombre);   $concepto=utf8_decode($concepto);
                $this->rect(10,5,200,268);		
		$this->Image('../../imagenes/Logo_emp.png',12,8,25);
		$this->SetFont('Arial','B',9);
		$this->Ln(4);
        $this->Cell(25);
		//$this->Cell(65,3,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,1,'C');
		$this->Cell(25);
		$this->Cell(65,3,'CONTRALORIA MUNICIPAL DE SAN FELIPE',0,1,'C');
		$this->Cell(25);
       	        //$this->Cell(65,4,'ESTADO YARACUY',0,1,'C');
		$this->Cell(25);
		$this->Cell(100,3,'',0,1,'L');
		$this->Cell(25);
		$this->Cell(60,3,'',0,0,'L');
		$this->SetFont('Arial','B',14);
		$this->Cell(70,3,'ORDEN DE PAGO: ',0,0,'C');
		$this->SetFont('Arial','B',14);	   
		$this->Cell(28,3,'N° '.$nro_orden,0,1,'C');
		$this->Ln(8);		
		$this->SetFont('Arial','',7);
		$this->SetFillColor(192,192,192);
		$this->Cell(138,3,'NOMBRE',1,0,'C',false);
		$this->Cell(42,3,'RIF O CEDULA DE IDENTIDAD',1,0,'C',false);
		$this->Cell(20,3,'FECHA',1,1,'C',false);
                //$this->SetFont('Arial','',10);
		$this->Cell(138,4,$nombre,1,0,'C');
		$this->Cell(42,4,$ced_rif,1,0,'C');
		$this->Cell(20,4,$fecha,1,1,'C');
                $this->Cell(200,0.5,'',0,1,'L');		
                $this->MultiCell(200,3,'POR CONCEPTO DE: '.$concepto,0);
		$this->Cell(200,3,' ',0,1,'C');
                $this->Cell(170,3,'CANTIDAD (LETRAS)',1,0,'C',false);
		$this->Cell(30,3,'MONTO CAUSADO',1,1,'C',false);
		$y=$this->GetY();
		$monto_letras="POR: ".$monto_letras;
		//$part1=$monto_letras; $l=strlen($part1); if($l>175){$part1=substr($monto_letras,0,175); $part2=substr($monto_letras,176,255); }
		$part1=$monto_letras; $l=strlen($part1); if($l>95){$part1=substr($monto_letras,0,95); $part2=substr($monto_letras,96,255); }
                $this->Cell(170,4,$part1,0,0);        		
		$this->Cell(19.8,4,$total_causado,0,1,'R');		
		$this->Cell(170,4,$part2,0,1);
		$this->Line(180,$y,180,$y+8);				
		$this->Cell(200,3,'RETENCIONES',1,1,'C',false);		
		$this->Cell(13,3,'CODIGO',1,0,'C',false);
		$this->Cell(147,3,'DENOMINACION',1,0,'C',false);
		$this->Cell(12,3,'TASA(%)',1,0,'C',false);
		$this->Cell(28,3,'MONTO RETENCION',1,1,'C',false);		
		$z=$this->GetY();
		if($cant_r>$max_cret){ $l=($max_cret-1)*3; $m=($l/2);
		   $this->Ln($m);
		   $this->Cell(180,3,'VER RELACION ANEXA',0,1,'C');
		   $this->Ln($m);
		}else{ for ($k=0; $k<$max_cret; $k++) {  
		$this->Cell(13,3,$cod_r[$k],0,0,'L'); 
	        $this->Cell(147,3,$den_r[$k],0,0,'L'); 
            $this->Cell(12,3,$tasa_r[$k],0,0,'R'); 		  
	        $this->Cell(28,3,$monto_r[$k],0,1,'R'); 
		} }
		$y=$this->GetY();
		$this->Line(185,$y-0.2,210,$y-0.2);
		$this->Cell(175,3,'TOTAL RETENCIONES Bs.',0,0,'R');
		$this->Cell(25,3,$total_ret,0,1,'R'); 
		$y=$y+3.5;
		$this->Line(10,$y,210,$y);		
		$y=$this->GetY();
		$this->Line(185,$y,210,$y);
		$this->Cell(175,4.5,'NETO A PAGAR Bs.',0,0,'R');
		$this->Cell(25,4.5,$total_neto,0,1,'R'); 		
		$this->Cell(200,3,'CONTABILIDAD PRESUPUESTARIA',1,1,'C',false);		
		$this->Cell(40,3,'CODIGO PRESUPUESTARIA',1,0,'C',false);
		$this->Cell(135,3,'DENOMINACION',1,0,'C',false);
		$this->Cell(25,3,'MONTO',1,1,'C',false);
	}
	
	function Footer(){ global $max_ccont; global $cant_cont; global $cod_c; global $debe_c; global $den_c; global $haber_c;
	                   global $oc; global $os; global $fact; global $nom; global $anticipo; global $recibo; global $otros;
                       global $ing_ord; global $fuente_otra;
		$this->SetY(-71);
        //$this->Line(10,$p,210,$p);			
		$this->SetFont('Arial','',8);
		$this->SetFillColor(192,192,192);
		$this->Cell(200,3,'CONTABILIDAD FISCAL',1,1,'C',false);		
		$this->Cell(30,3,'CODIGO CONTABLE',1,0,'C',false);
		$this->Cell(128,3,'NOMBRE DE LA CUENTA',1,0,'C',false);
		$this->Cell(22,3,'DEBE',1,0,'C',false);
		$this->Cell(20,3,'HABER',1,1,'C',false);
		$z=$this->GetY();
		if($cant_cont>$max_ccont){ $l=($max_ccont-1)*3; $m=($l/2);
		   $this->Ln($m);
		   $this->Cell(180,3,'VER RELACION ANEXA',0,1,'C');
		   $this->Ln($m);
		}else{ for ($k=0; $k<$max_ccont; $k++) {  
		$this->Cell(30,3,$cod_c[$k],0,0,'L'); 
	        $this->Cell(128,3,$den_c[$k],0,0,'L'); 					
	        $this->Cell(22,3,$debe_c[$k],0,0,'R');
                $this->Cell(20,3,$haber_c[$k],0,1,'R'); 		  
		} }
		

                $y=$this->GetY();
                $this->Line(40,$z,40,$y-0.1);
		$this->Line(168,$z,168,$y-0.1);
                $this->Line(190,$z,190,$y-0.1);	
		$y=$this->GetY();
	
       		$this->Cell(199.8,3,'FIRMAS AUTORIZADAS',1,1,'C',false);	
		
		$this->Cell(66,3,'ELABORADO POR',1,0,'C',true);
		$this->Cell(66,3,'DIRECCION DE ADMINISTRACION Y SERVICIO',1,0,'C',true);
		$this->Cell(68,3,'CONTRALOR MUNICIPAL',1,0,'C',true);
		
		$z=$this->GetY();		
		$this->SetFont('Arial','',7);
		$this->Cell(200,18,' ',0,1,'C');		
		$this->Cell(50,3,'',0,0,'C');	
        
        $this->Cell(50,3,'',0,0,'C');	
        $this->Cell(50,3,'',0,0,'C');
        //$this->Cell(50,3,'',0,0,'C');
        //$this->Cell(50,3,'ABOG. MARIA INMACULADA MEDINA RODRIGUEZ',0,1,'C');
		
		$x=$this->GetY()+1.5;
		//$this->Line(55,$z,40,$x);	
		//$this->Line(150,$z,150,$x);	
		//$this->Line(160,$z,160,$x);
		
		$this->SetFillColor(255,0,0);
		$this->Ln(5);
		$this->SetFont('Arial','',4);
		//$this->Cell(100,4,'ORIGINAL: CONTABILIDAD',0,0,'L');
		//$this->Cell(100,4,'SIA Ordenamiento de Pago',0,1,'R');
				
	} 
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 65);  
  $i=0;  
  if($cant_cod_presup>$max_cpre){
    $pdf->Ln(20);
	$pdf->Cell(180,3,'VER RELACION ANEXA',0,1,'C');
  }else{
  $sql="SELECT * FROM codigos_causados where tipo_causado='$tipo_causado' and referencia_caus='$nro_orden' order by cod_presup";$res=pg_query($sql);$filas=pg_num_rows($res);
  while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto"]); $total=$total+$registro["monto"]; $denominacion=$registro["denominacion"];
    $denominacion=substr($denominacion,0,140); if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}
    $pdf->Cell(40,3,$registro["cod_presup"],0,0,'L');
	$pdf->Cell(135,3,substr($denominacion,0,89),0,0,'L');
	$pdf->Cell(25,3,$monto,0,1,'R');
  }}
 $pdf->Output();
 pg_close();
?>

