<? include ("../../class/conect.php");include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php");include ("../../class/configura.inc");error_reporting(E_ALL ^ E_NOTICE); 
$date=date("d-m-Y"); $hora=date("H:i:s a"); $php_os=PHP_OS; $Cta_Result_Eje=""; $mostrar_ap=1;
$codigocuentad=$_GET["codigocuentad"]; $codigocuentah=$_GET["codigocuentah"]; $periodo=$_GET["periodo"]; $tipo_rep=$_GET["tipo_rep"]; $bal_cierre=$_GET["bal_cierre"];
$nivel_hasta=$_GET["nivel"]; $imp_encero=$_GET["vimprimir"]; $Sql="";$MControl = array (0,0,0,0,0,0,0,0,0,0);
function BUSCAR_ACTUAL($Clave,$Formato){
  global $MControl; global $Ultimo; $j=0;
  for ($a=0;$a<10;$a++){ $MControl[$a]=0;}
  for ($a=0;$a<strlen($Formato); $a++){if(substr($Formato,+$a,1)=="-"){$j++;}else{$MControl[$j]++;}}
  $Ultimo=$j;  $k=$MControl[0];
  for ($a=1; $a<10; $a++) {if ($MControl[$a] == 0) {$MControl[$a]=0;} else { $j=$MControl[$a]+$k; $MControl[$a]=$j+1; $k=$MControl[$a];} }
  for ($a=1; $a<10; $a++) {if ($MControl[$a] < 0) {$MControl[$a]=0;}}  $act=-1;
  for ($a=0; $a<10; $a++) {if (strlen($Clave) == $MControl[$a]){$act=$a; $a=10;}}
  if ($act==-1){?><script language="JavaScript">muestra('ERROR Longitud de la Cuenta Invalida');</script><? }
return $act;}
function cambia_coma_numero($monto){$valor=""; for ($i=0; $i<strlen($monto); $i++) {  if (substr($monto,$i,1)==",") {$valor=$valor.".";} else {$valor=$valor.substr($monto,$i,1);}  }  return $valor;}

function Nivel_Cod($ncuenta){global $MControl; global $bal_cierre; global  $Cta_Ingreso; global $Cta_Egreso; $n_cod=0; for($n=0;$n<10;$n++){if(strlen($ncuenta)==$MControl[$n]){$n_cod=$n; $n=10;}} return $n_cod;}
function Seletion_Ok($cuenta,$fecha_c){global $codigocuentad; global $codigocuentah;global $fecha_h; $valido=1;  
  if(($cuenta>=$codigocuentad)and($cuenta<=$codigocuentah)) {$valido=0;}
  $cfecha=$fecha_c;  $hfecha=formato_aaaammdd($fecha_h);  if(($cfecha<=$hfecha)and($valido==0)){$valido=0;}else{$valido=1;}
return $valido;}
$MCuenta = array ('', '', '', '', '', '', '', '', '', '');$MNombre = array ('', '', '', '', '', '', '', '', '', '');$MTSaldo = array ('', '', '', '', '', '', '', '', '', '');
$MDebitos = array (0,0,0,0,0,0,0,0,0,0);$MCreditos = array (0,0,0,0,0,0,0,0,0,0);$MSaldo_Ant = array (0,0,0,0,0,0,0,0,0,0);
$MSaldo_Total = array (0,0,0,0,0,0,0,0,0,0);
$Total_Activo=0; $Total_Pasivo=0; $Total_Resultado=0;$Total_Capital=0; $Total_Resultado_Balance=0; $Monto_Gan_Perd=0;$nivel_hasta=$nivel_hasta*1;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } }
if($periodo=="00"){$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=$fecha_d; $fecha_h=nextmes($fecha_h,-1); $fecha_h=colocar_udiames($fecha_h); $criterio1=" Al ".$fecha_h;}
else{$fecha_d=Armar_Fecha($periodo, 1, $Fec_Ini_Ejer); $fecha_h=Armar_Fecha($periodo,2,$Fec_Ini_Ejer); $criterio1="Desde ".$fecha_d." Al ".$fecha_h; } $Sql="";
$sfecha=formato_aaaammdd($fecha_d);   $ano_fiscal=substr($Fec_Ini_Ejer,6,4);  $periodo=$periodo*1;
$sql="Select * from SIA005 where campo501='03'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $Formato_Cuenta=$registro["campo504"]; $Cta_Activo=$registro["campo505"];$Cta_Pasivo=$registro["campo506"]; $Cta_Orden=$registro["campo507"]; $Cta_Ingreso=$registro["campo510"];  $Cta_Egreso=$registro["campo509"];  $Cta_Resultado=$registro["campo509"];
$Cta_Sit_Finan=$registro["campo513"]; $Cta_Sit_Fiscal=$registro["campo514"]; $Cta_Ejec_Presup=$registro["campo515"]; $Cta_Hacienda_Mun=$registro["campo516"]; $Cta_Result_Fis=$registro["campo517"];  }
$actual=BUSCAR_ACTUAL($Cta_Result_Eje,$Formato_Cuenta); $ln=$MControl[$nivel_hasta-1];  $lc=strlen($Cta_Ingreso); $lr=strlen($Cta_Egreso);
$nro_linea=0; $cod_cuenta=""; $nom_cuenta=""; $c=0;  $prev_cuenta=""; $Total_Activo=0;  $Total_Resultado=0;  $Total_Pasivo=0; $Total_Capital=0;
$Sql="SELECT ELIMINA_CON013('".$usuario_sia."','C')"; $resultado=pg_exec($conn,$Sql);$error=pg_errormessage($conn); $error="ERROR INICIALIZANDO: ".substr($error, 0,61);
if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
 else{ $long_cuenta=$MControl[$nivel_hasta-1]; $sql="Select * from con001 where codigo_cuenta<>'".$Cta_Result_Eje."' and length(codigo_cuenta)<=".$long_cuenta." order by codigo_cuenta"; 
    $sql="Select * from con001 where codigo_cuenta<>'".$Cta_Result_Eje."' and length(codigo_cuenta)<=".$long_cuenta." order by codigo_cuenta"; $resultado=pg_query($sql);  $actual=$MControl[0];
	$temp_debe=0; $temp_haber=0;
    //echo $sql." ".$nivel_hasta." ".$Cta_Result_Eje." ".$Formato_Cuenta;
	while($registro=pg_fetch_array($resultado)){
       if($c==0){$c=1; $prev_cuenta=$registro["codigo_cuenta"];  $MCuenta[1]=$registro["codigo_cuenta"]; $MNombre[1]=$registro["nombre_cuenta"]; $MTSaldo[1]=$registro["tsaldo"]; }
       $cod_cuenta=$registro["codigo_cuenta"]; $cargable=$registro["cargable"]; $fecha_creado=$registro["fecha_creado"];  $tsaldo=$registro["tsaldo"];  $nombre_cuenta=$registro["nombre_cuenta"];
	   If (Nivel_Cod($cod_cuenta) < $actual){
          for ($i=$Ultimo-1; $i>=0; $i--){
           If ((trim($MCuenta[$i]) <> substr($cod_cuenta,0,($MControl[$i]))) And (strlen(Trim($MCuenta[$i]))>0)) {$Imprimir=true;
              If(($MSaldo_Total[$i]==0)and($imp_encero=="N")){$Imprimir=true;}  
			  if(($Imprimir==true)and($i<$nivel_hasta)){ $Monto1=$MSaldo_Ant[$i]; $Monto2=$MDebitos[$i]; $Monto3=$MCreditos[$i];  $Monto4=$MSaldo_Total[$i];  $temp_nomb="TOTAL ".$MNombre[$i];                 
				$nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','C',$nro_linea,'00000000','$sfecha','','','00000','','01','0','S','','','','','','',0,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
				$nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','C',$nro_linea,'00000000','$sfecha','','$MCuenta[$i]','00000','','01','0','A','','$temp_nomb','$MTSaldo[$i]','','','',$Monto1,$Monto2,$Monto3,$Monto4,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
              }
              $MCuenta[$i]="";$MNombre[$i]=""; $MTSaldo[$i]=""; $MSaldo_Total[$i]=0; $MSaldo_Ant[$i]=0; $MDebitos[$i]=0; $MCreditos[$i]=0;
          }}
       }
	   if((((strlen($cod_cuenta)==$MControl[$nivel_hasta-1]))or(($cargable=="C")and(strlen($cod_cuenta)<$MControl[$nivel_hasta-1])))and(Seletion_Ok($cod_cuenta,$fecha_creado)==0)){
	     $MSaldo=$registro["saldo_anterior"]; $MDebe=array($registro["debito_01"],$registro["debito_02"],$registro["debito_03"],$registro["debito_04"],$registro["debito_05"],$registro["debito_06"],$registro["debito_07"],$registro["debito_08"],$registro["debito_09"],$registro["debito_10"],$registro["debito_11"],$registro["debito_12"]);  $MHaber=array($registro["credito_01"],$registro["credito_02"],$registro["credito_03"],$registro["credito_04"],$registro["credito_05"],$registro["credito_06"],$registro["credito_07"],$registro["credito_08"],$registro["credito_09"],$registro["credito_10"],$registro["credito_11"],$registro["credito_12"]);
         $MSaldo_Anterior=$MSaldo; $per_act=$periodo-1; if($periodo==0){$MDebe_per=0;$MHaber_per=0;}else{$MDebe_per=$MDebe[$per_act]; $MHaber_per=$MHaber[$per_act];}		
		 
		for($s=0;$s<$periodo;$s++){if($registro["tsaldo"]=="Deudor"){$MSaldo=round(($MSaldo+($MDebe[$s]-$MHaber[$s])),2);}else{$MSaldo=round(($MSaldo+($MHaber[$s]-$MDebe[$s])),2);} }  
        for($s=0;$s<$periodo-1;$s++){if($registro["tsaldo"]=="Deudor"){$MSaldo_Anterior=round(($MSaldo_Anterior+($MDebe[$s]-$MHaber[$s])),2);}else{$MSaldo_Anterior=round(($MSaldo_Anterior+($MHaber[$s]-$MDebe[$s])),2);}	}		 
        //for($s=0;$s<$periodo;$s++){$MSaldo=round(($MSaldo+($MDebe[$s]-$MHaber[$s])),2);}  
        //for($s=0;$s<$periodo-1;$s++){$MSaldo_Anterior=round(($MSaldo_Anterior+($MDebe[$s]-$MHaber[$s])),2);}		
		for($i=0;$i<$nivel_hasta-1;$i++){
            If(Nivel_Cod($cod_cuenta)>$i){ 
			if($MTSaldo[$i]==$tsaldo){$MSaldo_Ant[$i]=$MSaldo_Ant[$i]+$MSaldo_Anterior; $MSaldo_Total[$i]=$MSaldo_Total[$i]+$MSaldo;}
			 else{$MSaldo_Ant[$i]=$MSaldo_Ant[$i]-$MSaldo_Anterior; $MSaldo_Total[$i]=$MSaldo_Total[$i]-$MSaldo;} 			 
			$MDebitos[$i]=$MDebitos[$i]+$MDebe_per; $MCreditos[$i]=$MCreditos[$i]+$MHaber_per; 
			//echo $cod_cuenta." ".$MSaldo_Ant[$i]." ".$MSaldo_Anterior,"<br>";	
			}			 
         } $Imprimir=true;  If(($MSaldo==0)and($imp_encero=="N")){$Imprimir=true;}
		 
		 if(($bal_cierre=="SI")and($periodo=="12")and( (substr($cod_cuenta,0,$lc)==substr($Cta_Ingreso,0,$lc))or(substr($cod_cuenta,0,$lr)==substr($Cta_Egreso,0,$lr)) )){
		 $Imprimir=false; $temp_debe=$temp_debe+$MDebe_per; $temp_haber=$temp_haber+$MHaber_per; }else{$entrar=1;}
		 
		 
         if($Imprimir==true){$nro_linea=$nro_linea+1;  $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','C',$nro_linea,'00000000','$sfecha','','$cod_cuenta','00000','','01','0','B','$cod_cuenta','$nombre_cuenta','$tsaldo','','','',$MSaldo_Anterior,$MDebe_per,$MHaber_per,$MSaldo,0,0,0,0,$MDebe_per,$MHaber_per,'','')"); 	 $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}}
         $actual=BUSCAR_ACTUAL($cod_cuenta,$Formato_Cuenta);
       }
       else{ 
		 $Imprimir=true;
		 if(($bal_cierre=="SI")and($periodo=="12")and( (substr($cod_cuenta,0,$lc)==substr($Cta_Ingreso,0,$lc))or(substr($cod_cuenta,0,$lr)==substr($Cta_Egreso,0,$lr)) )){	 $Imprimir=false; }else{$entrar=1;}
		 if((strlen($cod_cuenta)<$MControl[$nivel_hasta-1])and(Seletion_Ok($cod_cuenta,$fecha_creado)==0)and($Imprimir==true)){ $actual=BUSCAR_ACTUAL($cod_cuenta,$Formato_Cuenta);
         $i=$actual; $MCuenta[$i]=substr($cod_cuenta,0,$MControl[$i]); $MNombre[$i]=$nombre_cuenta; $MTSaldo[$i]=$tsaldo;
         $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','C',$nro_linea,'00000000','$sfecha','','$cod_cuenta','00000','','01','0','C','$cod_cuenta','$nombre_cuenta','$tsaldo','','','',0,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
       }}
       $prev_cuenta=$registro["codigo_cuenta"];
    }
	for ($i=$Ultimo-1; $i>=0; $i--){
        If ((strlen(Trim($MCuenta[$i]))>0)) {$Imprimir=true;
            If(($MSaldo_Total[$i]==0)and($imp_encero=="N")){$Imprimir=true;}  
			If(($Imprimir==true)and($i<$nivel_hasta)){ $Monto1=$MSaldo_Ant[$i]; $Monto2=$MDebitos[$i]; $Monto3=$MCreditos[$i];  $Monto4=$MSaldo_Total[$i];  $temp_nomb="TOTAL ".$MNombre[$i]; 
                $Monto1=cambia_coma_numero($Monto1); $Monto2=cambia_coma_numero($Monto2); $Monto3=cambia_coma_numero($Monto3); $Monto4=cambia_coma_numero($Monto4);
				$nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','C',$nro_linea,'00000000','$sfecha','','','00000','','01','0','S','','','','','','',0,0,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
				if(($MCuenta[$i]>=$codigocuentad)and($cuenta<=$codigocuentah)){
				  $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','C',$nro_linea,'00000000','$sfecha','','$MCuenta[$i]','00000','','01','0','A','','$temp_nomb','$MTSaldo[$i]','','','',$Monto1,$Monto2,$Monto3,$Monto4,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);$error=substr($error,0,61); if(!$res){?><script language="JavaScript">muestra('<? echo $error; ?>'); </script><?}
                }
			}
            $MCuenta[$i]="";$MNombre[$i]=""; $MTSaldo[$i]=""; $MSaldo_Total[$i]=0; $MSaldo_Ant[$i]=0; $MDebitos[$i]=0; $MCreditos[$i]=0;
        }
    }	
}
 
if($nro_linea>0){ 
 //if($imp_encero=="N"){$sSQL="DELETE FROM CON013 WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='C' AND Columna2=0 AND Columna3=0"; }
 if($imp_encero=="N"){$sSQL="DELETE FROM CON013 where nombre_usuario='".$usuario_sia."' and tipo_registro='C' and status<>'S' and columna1=0 and columna2=0 and columna3=0 and columna4=0"; 
                     $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn);}
 $sSQL="SELECT CON013.Nombre_Usuario, CON013.Tipo_Registro, CON013.Nro_Linea, CON013.Status, CON013.Codigo_Cuenta, CON013.Nombre_Cuenta, CON013.TSaldo,
               CON013.Columna1, CON013.Columna2, CON013.Columna3, CON013.Columna4, CON013.Columna5, CON013.Columna6, CON013.Columna7, CON013.Columna8,
               CON013.Columna9, CON013.Columna10,CON013.Columna1*-1 as saldoa_ac, CON013.Columna4*-1 as saldo_ac
               FROM CON013 WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='C' and (status='A' or status='B' or status='S') ORDER BY nro_linea";
    if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
		  $oRpt = new PHPReportMaker();
		  $oRpt->setXML("Balance_Comprobacion.xml");
		  $oRpt->setUser("$user");
		  $oRpt->setPassword("$password");
		  $oRpt->setConnection("$host");
		  $oRpt->setDatabaseInterface("postgresql");
		  $oRpt->setSQL($sSQL);
		  $oRpt->setDatabase("$dbname");
		  $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora));
		  $oRpt->run();
	}	
    if($tipo_rep=="PDF"){  $res=pg_query($sSQL); 
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'BALANCE DE COMPROBACION ',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',9);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',7);
				$this->Cell(25,5,'CODIGO CUENTA',1,0);
				$this->Cell(91,5,'NOMBRE CUENTA',1,0);				
				$this->Cell(24,5,'SALDO ANTERIOR',1,0);
				$this->Cell(20,5,'DEBITO',1,0,'C');
				$this->Cell(19,5,'CREDITO',1,0,'C');
                $this->Cell(21,5,'SALDO ACTUAL',1,1,'C');				
			}
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');

				// INI NMDB 30-04-2018
		        // $this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		        $this->Cell(100,5,' ',0,0,'R');
		        // FIN NMDB 30-04-2018
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  $imp=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];    $nombre_cuenta=$registro["nombre_cuenta"]; 
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta); }	
		       $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;  $saldoa_ac=$registro["saldoa_ac"]; $saldo_ac=$registro["saldo_ac"];
		       $status=$registro["status"]; $tsaldo=$registro["tsaldo"]; $debe=$registro["columna9"]; $haber=$registro["columna10"];
			   $columna1=$registro["columna1"]; $columna2=$registro["columna2"];   $columna3=$registro["columna3"]; $columna4=$registro["columna4"]; 
			   if(($bal_cierre=="SI")and($periodo=="12")and($Cta_Hacienda_Mun==$codigo_cuenta)){  $debe=$debe+$temp_debe; $haber=$haber+$temp_haber; $columna2=$debe; $columna3=$haber; }
			   $totald=$totald+$debe; $totalh=$totalh+$haber; 
			   $h=4;
			   //if($status=="S"){$columna1=""; $columna4="";  $columna2="____________"; $columna3="____________"; $h=1;}
			   if(($status=="S")and($imp==1)){$columna1=""; $columna4=""; $imp=0; $columna2="--------------------"; $columna3="--------------------"; $h=2;}
			   else{ if($status<>"A"){$imp=1;} $columna2=formato_monto($columna2); $columna3=formato_monto($columna3);  
			      //if($tsaldo=="Acreedor"){$columna1=formato_monto($saldoa_ac);}else{$columna1=formato_monto($columna1);} 
			      //if($tsaldo=="Acreedor"){$columna4=formato_monto($saldo_ac);}else{$columna4=formato_monto($columna4);} 
				  if($mostrar_ap==1){  
					  $columna1=formato_monto($columna1); $columna4=formato_monto($columna4);
					}else{
					  if($tsaldo=="Acreedor"){$columna1=formato_monto($saldoa_ac);}else{$columna1=formato_monto($columna1);} 
					  if($tsaldo=="Acreedor"){$columna4=formato_monto($saldo_ac);}else{$columna4=formato_monto($columna4);} 
					}
				 if(($status=="S")and($codigo_cuenta=="")and($columna1=="0,00")and($columna2=="0,00")and($columna3=="0,00")and($columna4=="0,00")){$columna1=""; $columna2="";$columna3=""; $columna4="";  $h=2; }		
			   }
			   $pdf->SetFont('Arial','',7);
			   if($status=="A"){$h=5; $pdf->SetFont('Arial','B',7);}
			   $pdf->Cell(25,$h,$codigo_cuenta,0,0);
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=93; 			   
			   $pdf->SetXY($x+$n,$y);
			   //if($tsaldo=="Acreedor"){$valor_col1=$saldoa_ac;}else{$valor_col1=$columna1;}
			   //if($tsaldo=="Acreedor"){$valor_col4=$saldo_ac;}else{$valor_col4=$columna4;}
			   $pdf->Cell(22,$h,$columna1,0,0,'R'); 	
			   $pdf->Cell(20,$h,$columna2,0,0,'R');
               $pdf->Cell(20,$h,$columna3,0,0,'R');
               $pdf->Cell(20,$h,$columna4,0,0,'R');			   
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,$h,$nombre_cuenta,0); 				
			} 
			$totald=formato_monto($totald); $totalh=formato_monto($totalh); $pdf->SetFont('Arial','B',7);
			$pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');
			$pdf->Cell(140,5,' ',0,0,'R');
			$pdf->Cell(20,5,$totald,0,0,'R'); 
			$pdf->Cell(20,5,$totalh,0,1,'R'); 
			$pdf->Output();   
	}
	if($tipo_rep=="EXCEL"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Balance_Comprobacion.xls");
		?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="150" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>BALANCE DE COMPROBACION</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="150" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
			 </tr>
			 <tr height="20">
			   <td width="150" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Cuenta</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre Cuenta</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF"><strong>Saldo Anterior</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Debito</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF"><strong>Credito</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Saldo Actual</strong></td>
			 </tr>
		  <?  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];    $nombre_cuenta=$registro["nombre_cuenta"]; 
		       $nombre_cuenta=conv_cadenas($nombre_cuenta,0); $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;  $saldoa_ac=$registro["saldoa_ac"]; $saldo_ac=$registro["saldo_ac"];
		       $status=$registro["status"]; $tsaldo=$registro["tsaldo"]; $debe=$registro["columna9"]; $haber=$registro["columna10"];
			   $columna1=$registro["columna1"]; $columna2=$registro["columna2"];   $columna3=$registro["columna3"]; $columna4=$registro["columna4"]; 
			   $totald=$totald+$debe; $totalh=$totalh+$haber; 
			   if($status=="S"){$columna1=""; $columna4="";  $columna2="--------------------"; $columna3="--------------------"; $h=2;}
			   else{ $columna2=formato_monto($columna2); $columna3=formato_monto($columna3);  
			      if($tsaldo=="Acreedor"){$columna1=formato_monto($saldoa_ac);}else{$columna1=formato_monto($columna1);} 
			      if($tsaldo=="Acreedor"){$columna4=formato_monto($saldo_ac);}else{$columna4=formato_monto($columna4);} 
			   }
			   ?>	   
				<tr>
				   <td width="150" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $codigo_cuenta; ?></td>
				   <td width="400" align="justify"><? echo $nombre_cuenta; ?></td>
				   <td width="120" align="right"><? echo $columna1; ?></td>
				   <td width="120" align="right"><? echo $columna2; ?></td>
				   <td width="120" align="right"><? echo $columna3; ?></td>
				   <td width="120" align="right"><? echo $columna4; ?></td>
				 </tr>
			   <? 
				
		  }
          if(($totald>0)or($totalh>0)){ $totald=formato_monto($totald); $totalh=formato_monto($totalh); 
			?>	 				 
			<tr>
			  <td width="150" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="120" align="left"></td>
			  <td width="120" align="right">--------------------</td>
			  <td width="120" align="right">--------------------</td>
			</tr>	
			<tr>
			  <td width="150" align="left"></td>
			  <td width="400" align="right"></td>
			  <td width="120" align="left"></td>
			  <td width="120" align="right"><? echo $totald; ?></td>
			  <td width="120" align="right"><? echo $totalh; ?></td>
			</tr>	
			
		  <? 					
		  }		  
		  ?></table><?			
	}	
}     

?>

