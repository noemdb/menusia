<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$periodo_d=$_GET["periodo_d"];$rescod=$_GET["rescod"]; $codigod=$_GET["codigod"]; $codigoh=$_GET["codigoh"]; $Sql="";$date = date("d-m-Y"); $hora = date("H:i:s a");  $cod_mov="pre020".$usuario_sia;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ echo "OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS","<br>"; }
else{   $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){ $php_os="WINNT";} 
    $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
    $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo513"];}
    $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; $p=3; $h=$c+1+$p; 
    $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria);$ls=$long_c-1; $p_ini=$long_c+2; $ml_cod=$long_u-$p_ini+1;    
    $ano=substr($Fec_Fin_Ejer,0,4);
	$fecha_d="01-".$periodo_d."-".$ano; $fecha_H="01-".$periodo_d."-".$ano; $fecha_h=colocar_udiames($fecha_d); $fecha_1=formato_aaaammdd($fecha_d);  $fecha_2=formato_aaaammdd($fecha_h);
	$criterio1="DESDE : ".$fecha_d." HASTA : ".$fecha_d;	
	if($rescod=="N"){ 
	  $sSQL="SELECT ban021.referencia,ban021.cod_banco,ban021.tipo_mov_libro,ban021.fecha_mov_libro, ban021.monto_mov_libro, ban021.cod_partida, ban021.monto_codigo FROM ban021 where periodo='$periodo_d' and (ban021.cod_partida>='$codigod' and ban021.cod_partida<='$codigoh') order by ban021.cod_banco,ban021.referencia,ban021.tipo_mov_libro";
    }else{
	  $StrSQL="DELETE FROM pre020 Where (tipo_registro='F') And (nombre_usuario='".$cod_mov."')";
      $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }   
	
	  $StrSQL="INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'F' as tipo_registro,cod_partida,fuente_financ,'' as denominacion,substr(cod_presup,1,".$ls.") as cod_categoria,'' as denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as denomina_par,'','','','','', ";
      $StrSQL=$StrSQL." monto_codigo as asignacion,0 as disponible,0 as disp_diferida, 0 as compromiso, 0 as causado, 0 as pagado, 0 as traslados, 0 as trasladon, 0 as adicion, 0 as sisminucion, 0 as siferido, 0 as compromisoM,0 as causadoM, 0 as pagadoM, 0 as trasladosM, 0 as trasladonM, 0 as adicionM, 0 as disminucionM, 0 as diferidoM ";
      $StrSQL=$StrSQL." FROM ban021 where periodo='$periodo_d'";  
      $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
      $StrSQL="SELECT ban017.cod_movimiento,ban017.cod_contable,ban017.monto,ban017.signo,ban015.cod_contab FROM BAN017,ban015 where ban017.cod_movimiento=ban015.cod_movimiento and  ban017.monto<>0 and  ban017.modulo<>'G' and ban017.operacion='E' and  ban017.periodo='$periodo_d'";  $res=pg_query($StrSQL); 
      while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_contab"];	$cod_movimiento=$registro["cod_movimiento"];  $signo=$registro["signo"];
	    $sqlg= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'F' as tipo_registro,'".$cod_presup."','00','' as denominacion,'".$cod_movimiento."' as cod_categoria,'' as denomina_cat,'' as cod_partida,'' as denomina_par,'','','','','', ";
        
		if($signo=="NEGATIVO"){$sqlg=$sqlg." (monto*-1) as asignacion,0 as disponible,0 as disp_diferida, 0 as compromiso, 0 as causado, 0 as pagado, 0 as traslados, 0 as trasladon, 0 as adicion, 0 as sisminucion, 0 as siferido, 0 as compromisoM,0 as causadoM, 0 as pagadoM, 0 as trasladosM, 0 as trasladonM, 0 as adicionM, 0 as disminucionM, 0 as diferidoM ";}
		else{$sqlg=$sqlg." monto as asignacion,0 as disponible,0 as disp_diferida, 0 as compromiso, 0 as causado, 0 as pagado, 0 as traslados, 0 as trasladon, 0 as adicion, 0 as sisminucion, 0 as siferido, 0 as compromisoM,0 as causadoM, 0 as pagadoM, 0 as trasladosM, 0 as trasladonM, 0 as adicionM, 0 as disminucionM, 0 as diferidoM ";}
        
		$sqlg=$sqlg." FROM ban017 where ban017.cod_movimiento='$cod_movimiento' and ban017.periodo='$periodo_d'";  
        $resg=pg_exec($conn,$sqlg); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resg){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }  
	  }
	  
	  $StrSQL="SELECT pre020.cod_presup,pre001.denominacion from pre020,pre001 where substring(pre001.cod_presup,$p_ini,$ml_cod)=pre020.cod_presup  GROUP BY pre020.cod_presup,pre001.denominacion";  $res=pg_query($StrSQL); 
	  //echo $StrSQL,"<br>";
	  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"];	
	    $sqlg="Update pre020 set denominacion='$denominacion' where cod_presup='$cod_presup'";	
       // echo $sqlg,"<br>";	
		$resg=pg_exec($conn,$sqlg); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resg){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }  
	  }	  
	  $sSQL="SELECT pre020.cod_presup,pre020.cod_fuente,pre020.denominacion,pre020.asignado  from pre020 pre020  where (tipo_registro='F') and (asignado<>0) and (nombre_usuario='".$cod_mov."') and (denominacion='') ORDER BY pre020.cod_presup"; $res=pg_query($sSQL); 
	  //echo $sSQL,"<br>";	
	  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"];		    
		$sqlb="Select * from con001 where codigo_cuenta='$cod_presup'"; $resb=pg_exec($conn,$sqlb);  $filasb=pg_numrows($resb);
		//echo $sqlb,"<br>";		
        if ($filasb>0){  $regb=pg_fetch_array($resb);   $nombre_cuenta=$regb["nombre_cuenta"];
		   $sqlg="Update pre020 set denominacion='$nombre_cuenta' where cod_presup='$cod_presup'";
		   $resg=pg_exec($conn,$sqlg); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resg){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }  
	    }
	  }	 
	  $sSQL="SELECT pre020.cod_presup,pre020.cod_fuente,pre020.denominacion,pre020.asignado  from pre020 pre020  where (tipo_registro='F') and (asignado<>0) and (nombre_usuario='".$cod_mov."') and (pre020.cod_presup>='$codigod' and pre020.cod_presup<='$codigoh') ORDER BY pre020.cod_presup";
	}  
	
	require('../../class/fpdf/fpdf.php');      
	if($rescod=="N"){ 	
      class PDF extends FPDF{ 
		function Header(){ global $criterio1;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(150,10,'VERIFICACION GASTO DE CAJA',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',11);
			$this->Cell(200,10,$criterio1,0,1,'C');
            $this->Ln(3);				
			$this->SetFont('Arial','B',8);
			$this->Cell(20,5,'REFERENCIA',1,0);
			$this->Cell(16,5,'TIPO MOV.',1,0);
			$this->Cell(19,5,'FECHA',1,0);
			$this->Cell(25,5,'MONTO MOV.',1,0,'C');
			$this->Cell(35,5,'COD PARTIDA',1,0);
			$this->Cell(25,5,'MONTO COD.',1,0,'C');
			$this->Cell(25,5,'DIFERENCIA',1,1,'C');
			$this->Ln(5);
			$this->SetFont('Arial','',9);
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
	  $i=0;  $total=0; $prev_monto=""; $subtotal=0; $prev_grupo="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;	 $pdf->SetFont('Arial','',9); 
	       $tipo_mov_libro=$registro["tipo_mov_libro"]; $referencia=$registro["referencia"]; $descrip_mov_libro=$registro["descrip_mov_libro"]; $cod_banco=$registro["cod_banco"];
		   $fecha=$registro["fecha_mov_libro"];  $monto_mov_libro=$registro["monto_mov_libro"]; $cod_partida=$registro["cod_partida"]; $monto_codigo=$registro["monto_codigo"];
           $grupo_mov=$cod_banco.$referencia.$tipo_mov_libro;
		   $pdf->SetFont('Arial','',9);
		   if($prev_grupo<>$grupo_mov){ $fecha=formato_ddmmaaaa($fecha);
		      if($subtotal<>0){ if($subtotal>=0){$diferencia=$prev_monto-$subtotal;}else{ $diferencia=$prev_monto+$subtotal;}
         		    $subtotal=formato_monto($subtotal); $prev_monto=formato_monto($prev_monto); $diferencia=formato_monto($diferencia); 						    
				    $pdf->Cell(115,2,'',0,0);
					$pdf->Cell(25,2,'----------------------',0,0,'R');
					$pdf->Cell(25,2,'----------------------',0,1,'R');
					$pdf->Cell(55,5," ",0,0,'R'); 
					$pdf->Cell(25,5,$subtotal,0,0,'R'); 
					$pdf->Cell(35,5," ",0,0,'R'); 
					$pdf->Cell(25,5,$prev_monto,0,0,'R'); 
					$pdf->Cell(25,5,$diferencia,0,1,'R'); 
                    $pdf->Ln(3);					
				 }	 
			 $pdf->Cell(20,4,$referencia,0,0,'L'); 
			 $pdf->Cell(15,4,$tipo_mov_libro,0,0);
             $pdf->Cell(20,4,$fecha,0,1);			 
			 $prev_monto=$monto_mov_libro; $subtotal=0; $prev_grupo=$grupo_mov;  
		   } $monto_c=formato_monto($monto_codigo);  $subtotal=$subtotal+$monto_codigo;	$total=$total+$monto_codigo;
		   $pdf->Cell(80,4,"",0,0,'L'); 
		   $pdf->Cell(35,4,$cod_partida,0,0);
           $pdf->Cell(25,4,$monto_c,0,1,'R');	
		} 
		$total=formato_monto($total); $diferencia=$prev_monto-$subtotal;
		$subtotal=formato_monto($subtotal); $prev_monto=formato_monto($prev_monto); 	$diferencia=formato_monto($diferencia); 						    
		$pdf->Cell(115,2,'',0,0);
		$pdf->Cell(25,2,'----------------------',0,0,'R');
		$pdf->Cell(25,2,'----------------------',0,1,'R');
		$pdf->Cell(55,5," ",0,0,'R'); 
		$pdf->Cell(25,5,$subtotal,0,0,'R'); 
		$pdf->Cell(35,5," ",0,0,'R'); 
		$pdf->Cell(25,5,$prev_monto,0,0,'R'); 
		$pdf->Cell(25,5,$diferencia,0,1,'R');
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(140,2,'',0,0);
		$pdf->Cell(25,2,'===============',0,1,'R');
		$pdf->Cell(140,5,"Totales : ",0,0,'R'); 
		$pdf->Cell(25,5,$total,0,0,'R'); 
		$pdf->Output();   
    }else{
	  class PDF extends FPDF{ 
		function Header(){ global $criterio1;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(150,10,'CODIGOS GASTO PRESUPUESTO DE CAJA',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',11);
			$this->Cell(200,10,$criterio1,0,1,'C');
            $this->Ln(3);				
			$this->SetFont('Arial','B',8);
			$this->Cell(35,5,'CODIGO',1,0);
			$this->Cell(140,5,'DENOMINACION',1,0);
			$this->Cell(25,5,'MONTO ',1,1,'C');
			$this->Ln(5);
			$this->SetFont('Arial','',9);
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
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $total=0; $total_grupo=0; $subtotal=0; $prev_grupo=""; $prev_denominacion="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;	 $pdf->SetFont('Arial','',9); 
	    $cod_fuente=$registro["cod_fuente"]; $cod_partida=$registro["cod_presup"]; $monto=$registro["asignado"]; $denominacion=$registro["denominacion"]; $grupo=substr($cod_partida,0,3);
	    if($prev_partida<>$cod_partida){  if($prev_grupo==""){ $prev_grupo=$grupo; }
		  $total_grupo=$total_grupo+$subtotal;
		  if($subtotal<>0){    $subtotal=formato_monto($subtotal); $prev_denominacion=substr($prev_denominacion,0,75);
		    $pdf->Cell(35,4,$prev_partida,0,0);
			$pdf->Cell(140,4,$prev_denominacion,0,0);
            $pdf->Cell(25,4,$subtotal,0,1,'R');	
		  }		  
		  if(($prev_grupo<>$grupo)and($total_grupo>0)){ $total_grupo=formato_monto($total_grupo);
		    $pdf->Cell(175,4,'',0,0);
			$pdf->Cell(25,4,$total_grupo,'T',1,'R');	
		    $total_grupo=0; $prev_grupo=$grupo;
			$pdf->Ln(4);
		  }		 
		  $prev_partida=$cod_partida; $subtotal=0; $prev_denominacion=$denominacion;
		}
		$subtotal=$subtotal+$monto;	$total=$total+$monto;
	  } $total_grupo=$total_grupo+$subtotal; $subtotal=formato_monto($subtotal);  $total=formato_monto($total);
	  $pdf->Cell(35,4,$cod_partida,0,0);
	  $pdf->Cell(140,4,$prev_denominacion,0,0);
	  $pdf->Cell(25,4,$subtotal,0,1,'R');	
	  $total_grupo=formato_monto($total_grupo);
	  $pdf->Cell(175,4,'',0,0);
	  $pdf->Cell(25,4,$total_grupo,'T',1,'R');
	  $pdf->Ln(4);
	  $pdf->SetFont('Arial','B',9);
	  $pdf->Ln(5);
	  $pdf->Cell(175,2,'',0,0);
	  $pdf->Cell(25,2,'===============',0,1,'R');
	  $pdf->Cell(175,5,"Totales : ",0,0,'R'); 
	  $pdf->Cell(25,5,$total,0,0,'R'); 
	  $pdf->Output();  
	}
}
 pg_close();
?>