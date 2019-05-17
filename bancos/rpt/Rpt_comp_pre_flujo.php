<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$periodo_d=$_GET["periodo_d"];$cod_partida_d=$_GET["cod_partida_d"]; $cod_partida_h=$_GET["cod_partida_h"]; $tipo_rpt="EXCEL";$Sql="";$date = date("d-m-Y"); $hora = date("H:i:s a");  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ echo "OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS","<br>"; }
else{   $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} 
    $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
    $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo513"];}
    $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; $h=$c+1+$p; 
    $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria);$ls=$long_c-1; $p_ini=$long_c+2; $ml_cod=$long_u-$p_ini+1;    
    $ano=substr($Fec_Fin_Ejer,0,4);
	$fecha_d="01-".$periodo_d."-".$ano; $fecha_H="01-".$periodo_d."-".$ano; $fecha_h=colocar_udiames($fecha_d); $fecha_1=formato_aaaammdd($fecha_d);  $fecha_2=formato_aaaammdd($fecha_h);
	$criterio1="DESDE : ".$fecha_d." HASTA : ".$fecha_d;	
	$sSQL="SELECT ban021.referencia,ban021.cod_banco,ban021.tipo_mov_libro,ban021.fecha_mov_libro, ban021.monto_mov_libro, ban021.cod_partida, ban021.monto_codigo FROM ban021 where (periodo='$periodo_d') and (cod_partida>='$cod_partida_d' and cod_partida<='$cod_partida_h') order by ban021.cod_partida,ban021.cod_banco,ban021.referencia,ban021.tipo_mov_libro";
   
    if($tipo_rpt=="PDF"){
      require('../../class/fpdf/fpdf.php'); 
      class PDF extends FPDF{ 
		function Header(){ global $criterio1;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(150,10,'COMPARACION  PRESUPUESTARIA Y FLUJO DE CAJA ',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',11);
			$this->Cell(200,10,$criterio1,0,1,'C');
            $this->Ln(3);				
			$this->SetFont('Arial','B',7);
			$this->Cell(25,5,'PARTIDA',1,0);
			$this->Cell(15,5,'REFERENCIA',1,0); 
			$this->Cell(20,5,'PRESUPUESTO',1,0);
			$this->Cell(21,5,'FLUJO DE CAJA',1,0);
			$this->Cell(19,5,'DIFERENCIA',1,0,'C');
			$this->Cell(20,5,'RET. ISLR',1,0);
			$this->Cell(20,5,'RET. 1x1000',1,0,'C');
			$this->Cell(20,5,'RET. OTROS',1,0,'C');
			$this->Cell(25,5,'TOTAL DIFERENCIA',1,1,'C');
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
	  $i=0;  $totalp=0; $total_presup=0; $totalr1=0;  $totalr2=0;  $totalr3=0; 
	  $prev_monto=""; $subtotal=0; $prev_grupo=""; $prev_cod_banco=""; $prev_referencia=""; $prev_partida="";
	  $res=pg_query($sSQL);
	  //$pdf->MultiCell(200,3,$sSQL,0); 
	  while($registro=pg_fetch_array($res)){ $i=$i+1;	 $pdf->SetFont('Arial','',9); 
	       $tipo_mov_libro=$registro["tipo_mov_libro"]; $referencia=$registro["referencia"]; $descrip_mov_libro=$registro["descrip_mov_libro"]; $cod_banco=$registro["cod_banco"];
		   $fecha=$registro["fecha_mov_libro"];  $monto_mov_libro=$registro["monto_mov_libro"]; $cod_partida=$registro["cod_partida"]; $monto_codigo=$registro["monto_codigo"];
           $grupo_mov=$cod_partida.$cod_banco.$referencia.$tipo_mov_libro;
		   $pdf->SetFont('Arial','',9);
		   if($prev_grupo<>$grupo_mov){ $fecha=formato_ddmmaaaa($fecha);
		    if($i>1){ $monto_presup=0; $monto_dif=0; $monto_ret1=0; $monto_ret2=0; $monto_ret3=0;
			    $sqlo="select * from pag001 where (pag001.status='I') and (pag001.cod_banco='$prev_cod_banco') and  (pag001.nro_cheque='$prev_referencia')";
			    $resultadoo=pg_exec($conn,$sqlo); $filaso=pg_numrows($resultadoo);
				if ($filaso>0){ 
				    while($registroo=pg_fetch_array($resultadoo)){ $nro_orden=$registroo["nro_orden"]; $tipo_causado=$registroo["tipo_causado"]; $fechao=$registroo["fecha"];
					    $sqlp="select sum(monto) as monto_pago from pre038 where referencia_pago='$prev_referencia' and referencia_caus='$nro_orden' and substring(cod_presup,".$p_ini.",".$p.")='$prev_partida'";
						$resp=pg_query($sqlp); $filasp=pg_num_rows($resp);
						if ($filasp>0){ $regp=pg_fetch_array($resp);    $monto_pago=$regp["monto_pago"];   $monto_presup=$monto_presup+$monto_pago;  }
					    $sqlr="SELECT pag004.nro_orden_ret,pag004.aux_orden,pag004.cod_presup_ret,pag004.monto_retencion,pag003.ret_grupo FROM pag004,pag003 where pag004.tipo_retencion=pag003.tipo_retencion and (pag004.nro_orden_ret='$nro_orden') and (tipo_caus_ret='$tipo_causado') and (substring(cod_presup_ret,".$p_ini.",".$p.")='$prev_partida')";   $resr=pg_query($sqlr); $filasr=pg_num_rows($resr);
                        while($registror=pg_fetch_array($resr)){ $monto_retencion=$registror["monto_retencion"]; $ret_grupo=$registror["ret_grupo"];
					      //$pdf->Cell(20,5,$monto_retencion,0,1,'R');
					      if($ret_grupo=="I"){ $monto_ret1=$monto_ret1+$monto_retencion; } else{ if($ret_grupo=="T"){ $monto_ret2=$monto_ret2+$monto_retencion; } else{ $monto_ret3=$monto_ret3+$monto_retencion; } }
			            }
					}				
				}
				$monto_dif=$monto_presup-$subtotal; $total_presup=$total_presup+$monto_presup; $totalr1=$totalr1+$monto_ret1; $totalr2=$totalr2+$monto_ret2; $totalr3=$totalr3+$monto_ret3;
			    $subtotal=formato_monto($subtotal); $monto_presup=formato_monto($monto_presup); $monto_dif=formato_monto($monto_dif);
			    $monto_ret1=formato_monto($monto_ret1); $monto_ret2=formato_monto($monto_ret2); $monto_ret3=formato_monto($monto_ret3);				
				$pdf->Cell(20,5,$monto_presup,0,0,'R'); 
				$pdf->Cell(20,5,$subtotal,0,0,'R'); 
				$pdf->Cell(20,5,$monto_dif,0,0,'R'); 
				$pdf->Cell(20,5,$monto_ret1,0,0,'R'); 
				$pdf->Cell(20,5,$monto_ret2,0,0,'R'); 
				$pdf->Cell(20,5,$monto_ret3,0,1,'R'); 
		    }	 
			if(($prev_partida<>$cod_partida)and($totalp<>0)){ $monto_dif=$total_presup-$totalp; $monto_r=$totalr1+$totalr2+$totalr3;
			   $totalp=formato_monto($totalp); $total_presup=formato_monto($total_presup); $monto_dif=formato_monto($monto_dif);
			   $totalr1=formato_monto($totalr1); $totalr2=formato_monto($totalr2); $totalr3=formato_monto($totalr3); $monto_r=formato_monto($monto_r);
			   $pdf->Cell(40,2,'',0,0);
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(25,2,'----------------------',0,1,'R');
			   $pdf->Cell(40,5,'SUBTOTAL :',0,0);
			   $pdf->Cell(20,5,$total_presup,0,0,'R'); 
			   $pdf->Cell(20,5,$totalp,0,0,'R');
			   $pdf->Cell(20,5,$monto_dif,0,0,'R'); 
               $pdf->Cell(20,5,$totalr1,0,0,'R');
               $pdf->Cell(20,5,$totalr2,0,0,'R');	
               $pdf->Cell(20,5,$totalr3,0,0,'R');
               $pdf->Cell(25,5,$monto_r,0,1,'R'); 	
               $pdf->Ln(3);			   
			   $totalp=0; $total_presup=0; $totalr1=0;  $totalr2=0;  $totalr3=0; 
			}
			$pdf->Cell(25,5,$cod_partida,0,0);
            $pdf->Cell(15,5,$referencia,0,0);			
			$prev_monto=$monto_mov_libro; $subtotal=0; $prev_grupo=$grupo_mov;  $prev_cod_banco=$cod_banco; $prev_referencia=$referencia; $prev_partida=$cod_partida;
		   } $monto_c=formato_monto($monto_codigo);  $subtotal=$subtotal+$monto_codigo;	$totalp=$totalp+$monto_codigo;
		   
		} 
		if($i>1){$monto_presup=0; $monto_dif=0; $monto_ret1=0; $monto_ret2=0; $monto_ret3=0;
			    $sqlo="select * from pag001 where (pag001.status='I') and (pag001.cod_banco='$prev_cod_banco') and  (pag001.nro_cheque='$prev_referencia')";
			    $resultadoo=pg_exec($conn,$sqlo); $filaso=pg_numrows($resultadoo);
				if ($filaso>0){ 
				    while($registroo=pg_fetch_array($resultadoo)){ $nro_orden=$registroo["nro_orden"]; $tipo_causado=$registroo["tipo_causado"]; $fechao=$registroo["fecha"];
					   $sqlp="select sum(monto) as monto_pago from pre038 where referencia_pago='$prev_referencia' and referencia_caus='$nro_orden' and substring(cod_presup,".$p_ini.",".$p.")='$prev_partida'";
						$resp=pg_query($sqlp); $filasp=pg_num_rows($resp);
						if ($filasp>0){ $regp=pg_fetch_array($resp);    $monto_pago=$regp["monto_pago"];   $monto_presup=$monto_presup+$monto_pago;  }
					}					
					$sqlr="SELECT pag004.nro_orden_ret,pag004.aux_orden,pag004.cod_presup_ret,pag004.monto_retencion,pag003.ret_grupo FROM pag004,pag003 where pag004.tipo_retencion=pag003.tipo_retencion and (pag004.nro_orden_ret='$nro_orden') and (tipo_caus_ret='$tipo_causado') and (substring(cod_presup_ret,".$p_ini.",".$p.")='$prev_partida')";   $resr=pg_query($sqlr);
                    while($registror=pg_fetch_array($resr)){ $monto_retencion=$registror["monto_retencion"];    $ret_grupo=$registror["ret_grupo"];
					   if($ret_grupo=="I"){ $monto_ret1=$monto_ret1+$monto_retencion; } else{ if($ret_grupo=="T"){ $monto_ret2=$monto_ret2+$monto_retencion; } else{ $monto_ret3=$monto_ret3+$monto_retencion; } }
			        } 					
				}else{$sqlp="select sum(monto) as monto_pago from pre038 where referencia_pago='$prev_referencia' and cod_banco='$prev_cod_banco' and substring(cod_presup,".$p_ini.",".$p.")='$prev_partida'";
					$resp=pg_query($sqlp); $filasp=pg_num_rows($resp);if ($filasp>0){ $regp=pg_fetch_array($resp);    $monto_pago=$regp["monto_pago"];   $monto_presup=$monto_presup+$monto_pago;  }				
				}
				$monto_dif=$monto_presup-$subtotal; $total_presup=$total_presup+$monto_presup; $totalr1=$totalr1+$monto_ret1; $totalr2=$totalr2+$monto_ret2; $totalr3=$totalr3+$monto_ret3;
			    $subtotal=formato_monto($subtotal); $monto_presup=formato_monto($monto_presup); $monto_dif=formato_monto($monto_dif);
			    $monto_ret1=formato_monto($monto_ret1); $monto_ret2=formato_monto($monto_ret2); $monto_ret3=formato_monto($monto_ret3);
		        $pdf->Cell(20,5,$monto_presup,0,0,'R'); 
				$pdf->Cell(20,5,$subtotal,0,0,'R'); 
				$pdf->Cell(20,5,$monto_dif,0,0,'R'); 
				$pdf->Cell(20,5,$monto_ret1,0,0,'R'); 
				$pdf->Cell(20,5,$monto_ret2,0,0,'R'); 
				$pdf->Cell(20,5,$monto_ret3,0,1,'R');
				
			   $monto_dif=$total_presup-$totalp; $monto_r=$totalr1+$totalr2+$totalr3;
			   $totalp=formato_monto($totalp); $total_presup=formato_monto($total_presup); $monto_dif=formato_monto($monto_dif);
			   $totalr1=formato_monto($totalr1); $totalr2=formato_monto($totalr2); $totalr3=formato_monto($totalr3); $monto_r=formato_monto($monto_r);
			   $pdf->Cell(40,2,'',0,0);
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(20,2,'----------------------',0,0,'R');
			   $pdf->Cell(25,2,'----------------------',0,1,'R');
			   $pdf->Cell(40,5,'SUBTOTAL :',0,0);
			   $pdf->Cell(20,5,$total_presup,0,0,'R'); 
			   $pdf->Cell(20,5,$totalp,0,0,'R');
			   $pdf->Cell(20,5,$monto_dif,0,0,'R'); 
               $pdf->Cell(20,5,$totalr1,0,0,'R');
               $pdf->Cell(20,5,$totalr2,0,0,'R');	
               $pdf->Cell(20,5,$totalr3,0,0,'R');
               $pdf->Cell(25,5,$monto_r,0,1,'R'); 			   
		}
		$pdf->Output();  
	}
	
    IF($tipo_rpt=="EXCEL"){
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Comparacion_presup_flujo.xls"); 	
	  ?>
	   <table border="1" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		   <td width="200" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>COMPARACION  PRESUPUESTARIA Y FLUJO DE CAJA</strong></font></td>
		 </tr>
		  <tr height="20">
		     <td width="200" align="left" ><strong><? echo $criterio1; ?></strong></td>
		 </tr>
		 <tr height="20" >
		   <td width="200" height="40"  align="left" bgcolor="#A4A4A4"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>PARTIDA</strong></td>
		   <td width="100" align="left" bgcolor="#A4A4A4"><strong>REFERENCIA</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>PRESUPUESTO</strong></td> 
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>FLUJO DE CAJA</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>DIFERENCIA</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>RET. ISLR</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>RET. 1x1000</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>RET. OTROS</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>TOTAL DIFERENCIA</strong></td>
		 </tr>      
	  <? 
	  $i=0;  $totalp=0; $total_presup=0; $totalr1=0;  $totalr2=0;  $totalr3=0; 
	  $prev_monto=""; $subtotal=0; $prev_grupo=""; $prev_cod_banco=""; $prev_referencia=""; $prev_partida="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;	 
	       $tipo_mov_libro=$registro["tipo_mov_libro"]; $referencia=$registro["referencia"]; $descrip_mov_libro=$registro["descrip_mov_libro"]; $cod_banco=$registro["cod_banco"];
		   $fecha=$registro["fecha_mov_libro"];  $monto_mov_libro=$registro["monto_mov_libro"]; $cod_partida=$registro["cod_partida"]; $monto_codigo=$registro["monto_codigo"];
           $grupo_mov=$cod_partida.$cod_banco.$referencia.$tipo_mov_libro;
		   if($prev_grupo<>$grupo_mov){ $fecha=formato_ddmmaaaa($fecha);
		    if($i>1){ $monto_presup=0; $monto_dif=0; $monto_ret1=0; $monto_ret2=0; $monto_ret3=0;
			    $sqlo="select * from pag001 where (pag001.status='I') and (pag001.cod_banco='$prev_cod_banco') and  (pag001.nro_cheque='$prev_referencia')";
			    $resultadoo=pg_exec($conn,$sqlo); $filaso=pg_numrows($resultadoo);
				if ($filaso>0){ 
				    while($registroo=pg_fetch_array($resultadoo)){ $nro_orden=$registroo["nro_orden"]; $tipo_causado=$registroo["tipo_causado"]; $fechao=$registroo["fecha"];
					    $sqlp="select sum(monto) as monto_pago from pre038 where referencia_pago='$prev_referencia' and referencia_caus='$nro_orden' and substring(cod_presup,".$p_ini.",".$p.")='$prev_partida'";
						$resp=pg_query($sqlp); $filasp=pg_num_rows($resp);
						if ($filasp>0){ $regp=pg_fetch_array($resp);    $monto_pago=$regp["monto_pago"];   $monto_presup=$monto_presup+$monto_pago;  }
					    $sqlr="SELECT pag004.nro_orden_ret,pag004.aux_orden,pag004.cod_presup_ret,pag004.monto_retencion,pag003.ret_grupo FROM pag004,pag003 where pag004.tipo_retencion=pag003.tipo_retencion and (pag004.nro_orden_ret='$nro_orden') and (tipo_caus_ret='$tipo_causado') and (substring(cod_presup_ret,".$p_ini.",".$p.")='$prev_partida')";   $resr=pg_query($sqlr); $filasr=pg_num_rows($resr);
                        while($registror=pg_fetch_array($resr)){ $monto_retencion=$registror["monto_retencion"]; $ret_grupo=$registror["ret_grupo"];
					      if($ret_grupo=="I"){ $monto_ret1=$monto_ret1+$monto_retencion; } else{ if($ret_grupo=="T"){ $monto_ret2=$monto_ret2+$monto_retencion; } else{ $monto_ret3=$monto_ret3+$monto_retencion; } }
			            }
					}				
				}else{$sqlp="select sum(monto) as monto_pago from pre038 where referencia_pago='$prev_referencia' and cod_banco='$prev_cod_banco' and substring(cod_presup,".$p_ini.",".$p.")='$prev_partida'";
					$resp=pg_query($sqlp); $filasp=pg_num_rows($resp);if ($filasp>0){ $regp=pg_fetch_array($resp);    $monto_pago=$regp["monto_pago"];   $monto_presup=$monto_presup+$monto_pago;  }				
				}
				$monto_dif=$monto_presup-$subtotal; $total_presup=$total_presup+$monto_presup; $totalr1=$totalr1+$monto_ret1; $totalr2=$totalr2+$monto_ret2; $totalr3=$totalr3+$monto_ret3;
			    $subtotal=formato_monto($subtotal); $monto_presup=formato_monto($monto_presup); $monto_dif=formato_monto($monto_dif);
			    $monto_ret1=formato_monto($monto_ret1); $monto_ret2=formato_monto($monto_ret2); $monto_ret3=formato_monto($monto_ret3);
                ?>
				  <tr>
					  <td width="200" align="left" style="mso-number-format:'@';" ><? echo $prev_partida; ?></td>
					  <td width="100" align="left" style="mso-number-format:'@';" ><? echo $prev_referencia; ?></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto_presup; ?></td>	
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $subtotal; ?></td>	
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto_dif; ?></td>	 				  
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto_ret1; ?></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto_ret2; ?></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto_ret3; ?></td>
				  </tr>
				<? 
		    }	 
			if(($prev_partida<>$cod_partida)and($totalp<>0)){ $monto_dif=$total_presup-$totalp; $monto_r=$totalr1+$totalr2+$totalr3;
			   $totalp=formato_monto($totalp); $total_presup=formato_monto($total_presup); $monto_dif=formato_monto($monto_dif);
			   $totalr1=formato_monto($totalr1); $totalr2=formato_monto($totalr2); $totalr3=formato_monto($totalr3); $monto_r=formato_monto($monto_r);
			  ?>
				  <tr>
					  <td width="200" align="left"><strong>SUB-TOTAL:</strong></td>
					  <td width="100" align="left"></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $total_presup; ?></strong></td>	
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $totalp; ?></strong></td>	
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $monto_dif; ?></strong></td>	 				  
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $totalr1; ?></strong></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $totalr2; ?></strong></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $totalr3; ?></strong></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $monto_r; ?></strong></td>
				  </tr>
				  <tr height="20">
		          </tr>
				<? 
			   $totalp=0; $total_presup=0; $totalr1=0;  $totalr2=0;  $totalr3=0; 
			}				
			$prev_monto=$monto_mov_libro; $subtotal=0; $prev_grupo=$grupo_mov;  $prev_cod_banco=$cod_banco; $prev_referencia=$referencia; $prev_partida=$cod_partida;
		   } $monto_c=formato_monto($monto_codigo);  $subtotal=$subtotal+$monto_codigo;	$totalp=$totalp+$monto_codigo;
		   
		}
		if($i>1){ $monto_presup=0; $monto_dif=0; $monto_ret1=0; $monto_ret2=0; $monto_ret3=0;
			    $sqlo="select * from pag001 where (pag001.status='I') and (pag001.cod_banco='$prev_cod_banco') and  (pag001.nro_cheque='$prev_referencia')";
			    $resultadoo=pg_exec($conn,$sqlo); $filaso=pg_numrows($resultadoo);
				if ($filaso>0){ 
				    while($registroo=pg_fetch_array($resultadoo)){ $nro_orden=$registroo["nro_orden"]; $tipo_causado=$registroo["tipo_causado"]; $fechao=$registroo["fecha"];
					    $sqlp="select sum(monto) as monto_pago from pre038 where referencia_pago='$prev_referencia' and referencia_caus='$nro_orden' and substring(cod_presup,".$p_ini.",".$p.")='$prev_partida'";
						$resp=pg_query($sqlp); $filasp=pg_num_rows($resp);
						if ($filasp>0){ $regp=pg_fetch_array($resp);    $monto_pago=$regp["monto_pago"];   $monto_presup=$monto_presup+$monto_pago;  }
					    $sqlr="SELECT pag004.nro_orden_ret,pag004.aux_orden,pag004.cod_presup_ret,pag004.monto_retencion,pag003.ret_grupo FROM pag004,pag003 where pag004.tipo_retencion=pag003.tipo_retencion and (pag004.nro_orden_ret='$nro_orden') and (tipo_caus_ret='$tipo_causado') and (substring(cod_presup_ret,".$p_ini.",".$p.")='$prev_partida')";   $resr=pg_query($sqlr); $filasr=pg_num_rows($resr);
                        while($registror=pg_fetch_array($resr)){ $monto_retencion=$registror["monto_retencion"]; $ret_grupo=$registror["ret_grupo"];
					      if($ret_grupo=="I"){ $monto_ret1=$monto_ret1+$monto_retencion; } else{ if($ret_grupo=="T"){ $monto_ret2=$monto_ret2+$monto_retencion; } else{ $monto_ret3=$monto_ret3+$monto_retencion; } }
			            }
					}				
				}
				$monto_dif=$monto_presup-$subtotal; $total_presup=$total_presup+$monto_presup; $totalr1=$totalr1+$monto_ret1; $totalr2=$totalr2+$monto_ret2; $totalr3=$totalr3+$monto_ret3;
			    $subtotal=formato_monto($subtotal); $monto_presup=formato_monto($monto_presup); $monto_dif=formato_monto($monto_dif);
			    $monto_ret1=formato_monto($monto_ret1); $monto_ret2=formato_monto($monto_ret2); $monto_ret3=formato_monto($monto_ret3);
				
                ?>
				  <tr>
					  <td width="200" align="left" style="mso-number-format:'@';" ><? echo $prev_partida; ?></td>
					  <td width="100" align="left" style="mso-number-format:'@';" ><? echo $prev_referencia; ?></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto_presup; ?></td>	
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $subtotal; ?></td>	
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto_dif; ?></td>	 				  
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto_ret1; ?></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto_ret2; ?></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto_ret3; ?></td>
				  </tr>
				<?   
				  $monto_dif=$total_presup-$totalp; $monto_r=$totalr1+$totalr2+$totalr3;
			      $totalp=formato_monto($totalp); $total_presup=formato_monto($total_presup); $monto_dif=formato_monto($monto_dif);
			      $totalr1=formato_monto($totalr1); $totalr2=formato_monto($totalr2); $totalr3=formato_monto($totalr3); $monto_r=formato_monto($monto_r);
			    ?>
				  <tr>
					 
			          <td width="200" align="left"><strong>SUB-TOTAL:</strong></td>
					  <td width="100" align="left"></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $total_presup; ?></strong></td>	
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $totalp; ?></strong></td>	
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $monto_dif; ?></strong></td>	 				  
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $totalr1; ?></strong></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $totalr2; ?></strong></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $totalr3; ?></strong></td>
					  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><strong><? echo $monto_r; ?></strong></td>
				  </tr>
				<? 
		}	 
	  
	 
	
    }	
}
 pg_close();