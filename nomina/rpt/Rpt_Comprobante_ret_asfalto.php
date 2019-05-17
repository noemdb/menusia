<?include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); $php_os=PHP_OS; error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){$cedula_d=""; $cedula_h="";} else{$cedula_d=$_GET["codigo_d"];  $cedula_h=$_GET["codigo_h"];} $fecha_hoy=asigna_fecha_hoy(); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } }  $error=0;
$direccion_ag=""; $nombre=""; $nom_comp=""; $rif=""; $nit=""; $telefono_ag=""; $fax=""; $str1="NO"; $fecha_ini="2011-01-01"; $fecha_fin="2011-12-31"; $periodo="01"; $correo=""; $tasa_iva=0; $monto_ut=0; $definicion="N";
$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];
$direccion_ag=$registro["campo006"]; $nombre=$registro["campo004"]; $nom_comp=$registro["campo005"]; $rif=$registro["campo007"]; $nit=$registro["campo008"];  $definicion=$registro["campo034"];
$telefono_ag=$registro["campo012"];$fax=$registro["campo013"]; $fecha_ini=$registro["campo031"];$fecha_fin=$registro["campo032"]; $periodo=$registro["campo033"]; $pagina=$registro["campo015"]; $parroquia=$registro["campo040"];
$region=$registro["campo041"];$estado=$registro["campo010"];$municipio=$registro["campo011"];$ciudad=$registro["campo009"]; $correo=$registro["campo014"]; $str1=$registro["campo049"]; $tasa_iva=$registro["campo056"]; $monto_ut=$registro["campo055"]; }
if($fecha_ini==""){$fecha_ini="";}else{$fecha_ini=formato_ddmmaaaa($fecha_ini);} if($fecha_fin==""){$fecha_fin="";}else{$fecha_fin=formato_ddmmaaaa($fecha_fin);}
$nombre_emp=$nombre;$ced_rif_emp=$rif; $nombre_agente=$nombre; $num_pag=0; $error=0;

$ced_rif=""; $fecha_abono=""; $nombre=""; $cedula=""; $pasaporte=""; $direccion=""; $ciudad=""; $estado=""; $telefono=""; $rif_empleado=""; $cod_postal=""; $nacionalidad=""; $tipo_benef="N"; $residente="SI"; 
$sql="SELECT ban019.ced_rif, a.rif_empleado, a.cedula, a.nombre, a.direccion, a.ciudad, a.estado, a.telefono, a.cod_postal, a.nacionalidad, ban019.Fecha_Abono, ban019.Cod_Retencion, ban019.Monto_Abonado, ban019.Monto_Objeto, ban019.Tasa, ban019.Monto_Retencion, ban019.Acum_Retenido, ban019.Acum_Objeto, ban019.Fecha_Enterado, ban019.Nombre_Banco_Ent  
FROM ban019, trabajadores a WHERE ban019.ced_rif = a.cod_empleado And ban019.ced_rif>='$cedula_d' And ban019.ced_rif<='$cedula_h' and nombre_usuario='$usuario_sia' ORDER BY ban019.Fecha_Abono, ban019.ced_rif";
$res=pg_query($sql); $prev_ced="";
$res=pg_query($sql); $prev_ced=""; $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res,0); $num_pag=$num_pag+1;
  $ced_rif=$registro["ced_rif"]; $fecha_abono=$registro["fecha_abono"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $rif_empleado=$registro["rif_empleado"];
  $direccion=$registro["direccion"]; $ciudad=$registro["ciudad"];   $nacionalidad=$registro["nacionalidad"];  $estado=$registro["estado"];
  $telefono=$registro["telefono"]; $cod_postal=$registro["cod_postal"]; $cod_retencion=$registro["cod_retencion"]; $monto_abonado=$registro["monto_abonado"];
  $monto_objeto=$registro["monto_objeto"]; $tasa=$registro["tasa"];
  $monto_retencion=$registro["monto_retencion"]; $acum_objeto=$registro["acum_objeto"];
  $acum_retenido=$registro["acum_retenido"]; $fecha_enterado=$registro["fecha_enterado"];
  $nombre_banco_ent=$registro["nombre_banco_ent"];
  $nac=substr($nacionalidad,0,1); $tipoemp=substr($tipo_benef,0,1);
  if($nac=="V"){$nac1="X"; $nac2="  "; } else { $nac2="X"; $nac1="  ";} 
  if($residente=="SI"){$res1="X"; $res2="  "; } else { $res2="X"; $res1="  ";} 
  if($tipoemp=="N"){$tpe1="X"; $tpe2="  "; } else { $tpe2="X"; $tpe1="  ";}   $cons1="X"; $cons2="  ";
  $prev_ced=$ced_rif;  if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);$direccion=utf8_decode($direccion);}
}  
  
require('../../class/fpdf/fpdf.php');
 
      class PDF extends FPDF{ 
	    
		function Header(){  global $nombre_agente; global $ced_rif_emp; global $rif; global $direccion_ag; global $telefono_ag; global $fecha_ini; global $fecha_fin; global $nombre; global $cedula; global $ced_rif; global $nacionalidad; global $direccion; global $ciudad; global $cod_postal; global $estado; global $telefono; 
		                    global $tpe1; global $tpe2; global $nac1; global $nac2; global $res1; global $res2; global $cons1; global $cons2;
			                global $nombre_funcionario; global $ced_funcionario; global $paso_enc; global $rif_empleado;
			$this->SetFont('Arial','',7);
			
			$this->Image('../../imagenes/Logo_emp.png',10,10,15);
			$this->SetFont('Arial','B',13);
			$this->Cell(50);
			$this->Cell(150,10,'COMPROBANTE DE RETENCIONES DEL IMPUESTO SOBRE LA RENTA',0,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(220,5,'Periodo Desde : '.$fecha_ini.' Hasta : '.$fecha_fin,0,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);	
			$this->Cell(130,5,'DATOS DEL AGENTE DE RETENCION :',0,0,'L');
			$this->Cell(130,5,'DATOS DEL TRABAJADOR :',0,1,'L');
			$this->rect(10,34,120,53);
			$this->SetFont('Arial','B',6);	
		    $this->Cell(10,4,'',0,0,'L');	
		    $this->Cell(30,4,'Tipo Agente ',0,0,'L');
		    $this->Cell(25,4,'1.Persona [   ]',0,0,'L');
		    $this->Cell(25,4,'2.Persona [   ]',0,0,'L');
		    $this->Cell(30,4,'3.Persona [ X ]',0,0,'L');
			$this->Cell(5,4,'',0,0,'L');
			$this->rect(140,34,130,53);
			$this->Cell(5,4,'',0,0,'L');
		    $this->Cell(130,4,'Apellido(s) Y Nombre(s): ','RL',1,'L');			
		    $this->Cell(10,4,'',0,0,'L');
			$this->Cell(30,2,'de Retencion:',0,0,'L');
		    $this->Cell(25,2,'   Natural ',0,0,'L');
		    $this->Cell(25,2,'   Juridica ',0,0,'L');
		    $this->Cell(30,2,'   Publica ',0,0,'L');
			$this->Cell(5,4,'',0,0,'L');			
			$nombre1=$nombre;	$nombre2="";	$nombre1=substr($nombre1,0,65); $nombre2=substr($nombre,66,130);			
			$long_line=65; $part1=$nombre; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($nombre,0,$long_line); }
            $lp=strlen($part1);  $c2=$lp; $care="N"; 
            if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($nombre,0,$c2); }       
            $part2=substr($nombre,$c2,$long_line);
		    $nombre1=$part1;	$nombre2=$part2;		   
			$this->Cell(5,4,'',0,0,'L');
		    $this->Cell(130,4,$nombre1,0,1,'L');
            $this->SetFont('Arial','B',6);	
			$this->Cell(10,32,'',1,0,'L');	
			$this->Cell(80,4,'Apellidos(s) Y Nombre(s): ','RLT',0,'L');
			$this->Cell(30,4,'Numero de Rif: ','RLT',0,'L');
			$this->Cell(10,4,'',0,0,'L');			
			$this->Cell(130,4,$nombre2,0,1,'L');
            $this->SetFont('Arial','B',6);	
			$this->Cell(10,4,'',0,0,'L');	
			$this->Cell(80,4,'','RB',0,'L');
			$this->Cell(30,4,'',0,0,'L');
			$this->Cell(10,4,'',0,0,'L');			
			$this->Cell(45,4,'Nacionalidad:','RLT',0,'L');
			$this->Cell(45,4,'Numero de RIF:','RLT',0,'L');			
			$this->Cell(40,4,'Cedula Identidad:','RLT',1,'L');
            $this->SetFont('Arial','B',6);	
			$this->Cell(10,4,'',0,0,'L');	
			$this->Cell(80,4,'Apellidos(s) Y Nombre(s): ',0,0,'L');
			$this->Cell(30,4,'Numero de Rif: ','RLT',0,'L');
			$this->Cell(10,4,'',0,0,'L');
			$this->Cell(45,4,'Venezolana '.'['.$nac1.']'.'     '.'Extranjera '.'['.$nac2.']',0,0,'L');
			$this->Cell(45,4,$rif_empleado,'RL',0,'L');
			$this->Cell(40,4,$cedula,'RL',1,'L');
            $this->SetFont('Arial','B',6);	
			$this->Cell(10,4,'',0,0,'L');	
			$this->Cell(80,4,'','RB',0,'L');
			$this->Cell(30,4,'',0,0,'L');
			$this->Cell(10,4,'',0,0,'L');
			$this->Cell(45,4,'','RLT',0,'L');
			$this->Cell(45,4,'','RLT',0,'L');			
			$this->Cell(40,4,'','RLT',1,'L');
            $this->SetFont('Arial','B',6);	
			$this->Cell(10,4,'',0,0,'L');	
			$this->Cell(80,4,'Apellidos(s) Y Nombre(s): ',0,0,'L');
			$this->Cell(30,4,'Numero de Rif: ','RLT',0,'L');
			$this->Cell(10,4,'',0,0,'L');
			$this->Cell(90,4,'Direccion y Telefonos:','RLT',0,'L');
			$this->Cell(40,4,'Periodo a que corresponde',0,1,'L');	
			$direccion1=$direccion; $direccion2=""; $direccion3="";
			$direccion1=substr($direccion1,0,65); $direccion2=substr($direccion,66,65); $direccion3=substr($direccion,131,65);			
			$long_line=65; $part1=$direccion; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($direccion,0,$long_line); }
            $lp=strlen($part1);  $c2=$lp; $care="N"; 
            if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($direccion,0,$c2); }       
            $part2=substr($direccion,$c2,$long_line);  $part3=substr($direccion,$c2+$long_line,$long_line);
		    $direccion1=$part1;	$direccion2=$part2; $direccion3=$part3;
			$this->SetFont('Arial','B',6);	
		    $this->Cell(10,4,'',0,0,'L');
			$this->Cell(80,4,$nombre_agente,'RB',0,'L');		    
			$this->Cell(30,4,$rif,0,0,'L');		    
		    $this->Cell(10,4,'',0,0,'L');
			$this->Cell(90,4,'','LR',0,'L');
			$this->Cell(40,4,'las Remuneraciones Pagadas',0,1,'L');				
			$this->SetFont('Arial','B',6);	
		    $this->Cell(10,4,'',0,0,'L');
		    $this->Cell(80,4,'Funcionario Autorizado para hacer la Retención : ',0,0,'L');
			$this->Cell(30,4,'Numero de Rif: ','RLT',0,'L');
		    $this->Cell(10,4,'',0,0,'L');
			$this->Cell(90,4,$direccion1,'LR',0,'L');
			$this->Cell(40,4,'',0,1,'L');			
			$this->Cell(10,4,'',0,0,'L');	
			$this->Cell(80,4,$nombre_funcionario,'RB',0,'L');		    
			$this->Cell(30,4,$ced_funcionario,'LRB',0,'L');
			$this->Cell(10,4,'',0,0,'L');
			$this->Cell(90,4,$direccion2,'LR',0,'L');
            $this->Cell(40,4,'Desde : '.$fecha_ini,0,1,'L');				
			$temp=$direccion_ag." ".$telefono_ag;	$temp1=substr($temp,0,71);$temp2=substr($temp,72,140);			
			$long_line=70; $part1=$temp; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($temp,0,$long_line); }
			$lp=strlen($part1);  $c2=$lp; $care="N"; 
			if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($temp,0,$c2); }       
			$part2=substr($temp,$c2,$long_line); $temp1=$part1 ;$temp2=$part2;            
			$this->SetFont('Arial','B',6);	
			$this->Cell(90,4,'Direccion y Telefono(s) ',0,0,'L');
			$this->Cell(30,4,'Fecha Cierre del Ejercicio:','L',0,'L');
			$this->Cell(10,4,'',0,0,'L');
			$this->Cell(90,4,$direccion3,'LR',0,'L');
			$this->Cell(40,4,'Hasta  : '.$fecha_fin,0,1,'L');			
			$this->Cell(90,3,$temp1,'R',0,'L');
			$this->Cell(30,3,$fecha_fin,0,0,'L');
			$this->Cell(10,3,'',0,0,'L');
			$this->Cell(45,3,$ciudad,0,0,'L');
			$this->Cell(45,3,$cod_postal,'R',0,'L');
			$this->Cell(40,3,'',0,1,'L');			
            $this->SetFont('Arial','B',6);	
			$this->Cell(90,5,$temp2,'R',0,'L');
			$this->Cell(30,5,'',0,0,'L');
			$this->Cell(10,5,'',0,0,'L');
			$this->Cell(45,5,$estado,0,0,'L');
			$this->Cell(45,5,$telefono,'R',0,'L');
			$this->Cell(40,5,'',0,1,'L'); 			
			$this->Ln(3);
			$this->SetFont('Arial','B',8);	
			$this->Cell(100,5,'INFORMACION DEL IMPUESTO RETENIDO  :',0,0,'L');
			$this->Ln(5);
			//ENCABEZADO DE CELDAS
			$this->SetFont('Arial','B',6);
        	$this->SetFillColor(192,192,192);
			$this->Cell(50,3,'',0,0,'C');			
            $this->Cell(20,3,'MES DE PAGO','LRT',0,'C',true);	
			$this->Cell(15,3,'CODIGO DE','LRT',0,'C',true);
			$this->Cell(30,3,'REMUNERACIONES','LRT',0,'C',true);			
			$this->Cell(10,3,'% o','LRT',0,'C',true);
			$this->Cell(20,3,'IMPUESTO','LRT',0,'C',true);
			$this->Cell(30,3,'TOTAL REMUNERACIONES','LRT',0,'C',true);
			$this->Cell(30,3,'IMPUESTO RETENIDO','LRT',0,'C',true);			
			$this->Cell(55,3,'',0,1,'C');		
		    $this->Cell(50,3,'',0,0,'C');			
            $this->Cell(20,3,' ','LRB',0,'C',true);     
			$this->Cell(15,3,'RETENCION','LRB',0,'C',true);
			$this->Cell(30,3,'PAGADA O ABONADA','LRB',0,'C',true);			
			$this->Cell(10,3,'TARIFA','LRB',0,'C',true);			
			$this->Cell(20,3,'RETENIDO','LRB',0,'C',true);
			$this->Cell(30,3,'PAGADA ACUMULADA','LRB',0,'C',true);
			$this->Cell(30,3,'ACUMULADO','LRB',0,'C',true);
			$this->Cell(60,3,'',0,1,'L');
            $y=$this->GetY();	$x=$this->GetX();
			$paso_enc=1;
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			//$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			//$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total_monto_abonado=0; $total_monto_objeto=0; $total_monto_retencion=0; $total_acum_objeto=0; $total_acum_retenido=0; 
	  $prev_pag=0;
 	  while($registro=pg_fetch_array($res)){ $ced_rif=$registro["ced_rif"]; $paso_enc=0; $pag=$pdf->PageNo();
		  $fecha_abono=$registro["fecha_abono"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; 
		  $direccion=$registro["direccion"]; $ciudad=$registro["ciudad"]; $tipo_benef="N"; $residente="SI"; 
		  $nacionalidad=$registro["nacionalidad"]; $estado=$registro["estado"];
		  $telefono=$registro["telefono"]; $cod_postal=$registro["cod_postal"]; $cod_retencion=$registro["cod_retencion"]; $monto_abonado=$registro["monto_abonado"];
		  $monto_objeto=$registro["monto_objeto"]; $tasa=$registro["tasa"];  $monto_retencion=$registro["monto_retencion"]; $acum_objeto=$registro["acum_objeto"];
		  $acum_retenido=$registro["acum_retenido"]; $fecha_enterado=$registro["fecha_enterado"];  $nombre_banco_ent=$registro["nombre_banco_ent"];
	      $fecha_abono=$registro["fecha_abono"]; $cod_retencion=$registro["cod_retencion"]; $fecha_enterado=$registro["fecha_enterado"];  $nombre_banco_ent=$registro["nombre_banco_ent"];
		  $total_acum_retenido=$registro["acum_retenido"]; $total_acum_objeto=$registro["acum_objeto"]; 		  
		  $monto_abonado=formato_monto($registro["monto_abonado"]); $monto_objeto=formato_monto($registro["monto_objeto"]); $monto_retencion=formato_monto($registro["monto_retencion"]);
		  $acum_objeto=formato_monto($registro["acum_objeto"]); $acum_retenido=formato_monto($registro["acum_retenido"]);  
		  $total_monto_abonado=$total_monto_abonado+$registro["monto_abonado"]; $total_monto_objeto=$total_monto_objeto+$registro["monto_objeto"]; 
		  $total_monto_retencion=$total_monto_retencion+$registro["monto_retencion"]; 		  
		  $fecha_a=formato_ddmmaaaa($fecha_abono); $fecha_e=formato_ddmmaaaa($fecha_enterado); $mes_desde=substr($fecha_abono,5,2);
		  if ($mes_desde==01){$mesd="Enero";}elseif ($mes_desde==02){$mesd="Febrero";}elseif ($mes_desde==03){$mesd="Marzo";}elseif ($mes_desde==04){$mesd="Abril";}elseif ($mes_desde==05)	{$mesd="Mayo";}elseif ($mes_desde==06){$mesd="Junio";}elseif ($mes_desde==07){$mesd="Julio";}elseif ($mes_desde==08){$mesd="Agosto";}elseif ($mes_desde==09){$mesd="Septiembre";}elseif ($mes_desde==10){$mesd="Octubre";}elseif ($mes_desde==11){$mesd="Noviembre";}elseif ($mes_desde==12){$mesd="Diciembre";}
		  if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);$direccion=utf8_decode($direccion);$nombre_banco_ent=utf8_decode($nombre_banco_ent); }	
		  
		  $mes_desde=substr($fecha_abono,5,2); $mesd="";
		  if ($mes_desde=="01"){$mesd="Enero";} if ($mes_desde=="02"){$mesd="Febrero";} if ($mes_desde=="03"){$mesd="Marzo";} 
		  if ($mes_desde=="04"){$mesd="Abril";} if ($mes_desde=="05"){$mesd="Mayo";}    if ($mes_desde=="06"){$mesd="Junio";}
		  if ($mes_desde=="07"){$mesd="Julio";} if ($mes_desde=="08"){ $mesd="Agosto"; }  if ($mes_desde=="09"){$mesd="Septiembre";}
		  if ($mes_desde=="10"){$mesd="Octubre";} if ($mes_desde=="11"){$mesd="Noviembre";} if ($mes_desde=="12"){$mesd="Diciembre";}
		  if($prev_ced<>$ced_rif){ $total_monto_abonado=formato_monto($total_monto_abonado);  $total_monto_objeto=formato_monto($total_monto_objeto);  $total_monto_retencion=formato_monto($total_monto_retencion);
            $total_acum_objeto=formato_monto($total_acum_objeto); $total_acum_retenido=formato_monto($total_acum_retenido);
		    $pdf->SetFont('Arial','B',8);
			$pdf->Cell(50,5,'',0,0,'R');
			$pdf->Cell(35,5,'TOTALES',1,0,'R');
			$pdf->Cell(30,5,$total_monto_abonado,1,0,'R');
			$pdf->Cell(10,5,'',1,0,'R');
			$pdf->Cell(20,5,$total_monto_retencion,1,0,'R');
			$pdf->Cell(30,5,$total_monto_objeto,1,0,'R');			
			$pdf->Cell(30,5,$total_acum_retenido,1,0,'R');
			$pdf->Cell(55,5,'',0,1,'R');
			$pdf->Ln(10);
			$y=$pdf->GetY();	$x=$pdf->GetX();
			$pdf->rect(100,$y,$x+60,15);
			$pdf->SetFont('Arial','B',5);		
			$pdf->Cell(140,6,'AGENTE DE RETENCION (SELLO, FECHA Y FRIMA): ',0,0,'R');			
			$pdf->AddPage();
		   $prev_ced=$ced_rif; $total_monto_abonado=0; $total_monto_objeto=0; $total_monto_retencion=0; $total_acum_objeto=0; $total_acum_retenido=0; 
         }		$pdf->SetFont('Arial','',8);		 
		$x=$pdf->GetX(); $y=$pdf->GetY(); $bord="LR"; 
		if(($y>=192)and($prev_pag<>$pag)){ $bord="LRB"; $prev_pag=$pag; }        
		$pdf->Cell(50,4,'',0,0,'L');
		$pdf->Cell(20,4,$mesd,$bord,0,'C');
		$pdf->Cell(15,4,$cod_retencion,$bord,0,'C');
		$pdf->Cell(30,4,$monto_abonado,$bord,0,'R'); 		
		$pdf->Cell(10,4,$tasa,$bord,0,'C');
		$pdf->Cell(20,4,$monto_retencion,$bord,0,'R');
		$pdf->Cell(30,4,$acum_objeto,$bord,0,'R');		
		$pdf->Cell(30,4,$acum_retenido,$bord,0,'R');
		$pdf->Cell(55,4,'',0,1,'L');		
    } $total_monto_abonado=formato_monto($total_monto_abonado);  $total_monto_objeto=formato_monto($total_monto_objeto);  $total_monto_retencion=formato_monto($total_monto_retencion);
      $total_acum_objeto=formato_monto($total_acum_objeto); $total_acum_retenido=formato_monto($total_acum_retenido);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(50,5,'',0,0,'R');
		$pdf->Cell(35,5,'TOTALES',1,0,'R');
		$pdf->Cell(30,5,$total_monto_abonado,1,0,'R');
		$pdf->Cell(10,5,'',1,0,'R');
		$pdf->Cell(20,5,$total_monto_retencion,1,0,'R');
		$pdf->Cell(30,5,$total_acum_objeto,1,0,'R');		
		$pdf->Cell(30,5,$total_acum_retenido,1,0,'R');
		$pdf->Cell(55,5,'',0,1,'R');
		$pdf->Ln(10);
        $y=$pdf->GetY();	$x=$pdf->GetX();
		if($y>=200){ $pdf->AddPage(); $pdf->Ln(10); $y=$pdf->GetY();	$x=$pdf->GetX(); }
        $pdf->rect(100,$y,$x+60,15);
		$pdf->SetFont('Arial','B',5);		
		$pdf->Cell(140,5,'AGENTE DE RETENCION (SELLO, FECHA Y FRIMA): ',0,0,'R');
		$pdf->Output();  
pg_close();?>