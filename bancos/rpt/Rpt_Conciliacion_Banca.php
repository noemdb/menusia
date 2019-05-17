<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$metodo_conci=$_GET["metodo_conci"];$periodod=$_GET["periodod"]; $tipo_rep=$_GET["tipo_rep"];  $Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }  $mcod_m="BAN023".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $cfecha=formato_ddmmaaaa($Fec_Ini_Ejer);
$criterio1=""; $dperiodod='Enero'; $cfecha="01/01/".substr($cfecha,6,4); 
$des_encab="SALDO SEGUN BANCO :"; $des_pie1="SALDO EN LIBROS SEGUN CONCILIACION :"; $des_pie2="SALDO ACTUAL EN LIBROS :";
$sql_saldo="(BAN002.s_inic_libro+(BAN002.deb_libro01-BAN002.cre_libro01)"; $sql_saldo_b="(BAN002.s_inic_banco+(BAN002.deb_banco01-BAN002.cre_banco01)";
if($periodod>="02"){ $dperiodod='Febrero'; $cfecha="01/02/".substr($cfecha,6,4);
$sql_saldo=$sql_saldo."+(BAN002.deb_libro02-BAN002.cre_libro02)"; $sql_saldo_b=$sql_saldo_b."+(BAN002.deb_banco02-BAN002.cre_banco02)"; }
if($periodod>="03"){ $dperiodod='Marzo'; $cfecha="01/03/".substr($cfecha,6,4);
$sql_saldo=$sql_saldo."+(BAN002.Deb_Libro03-BAN002.Cre_Libro03)"; $sql_saldo_b=$sql_saldo_b."+(BAN002.deb_banco03-BAN002.cre_banco03)";}
if($periodod>="04"){ $dperiodod='Abril'; $cfecha="01/04/".substr($cfecha,6,4);
$sql_saldo=$sql_saldo."+(BAN002.Deb_Libro04-BAN002.Cre_Libro04)"; $sql_saldo_b=$sql_saldo_b."+(BAN002.deb_banco04-BAN002.cre_banco04)";}
if($periodod>="05"){ $dperiodod='Mayo'; $cfecha="01/05/".substr($cfecha,6,4);
$sql_saldo=$sql_saldo."+(BAN002.Deb_Libro05-BAN002.Cre_Libro05)"; $sql_saldo_b=$sql_saldo_b."+(BAN002.deb_banco05-BAN002.cre_banco05)";}
if($periodod>="06"){ $dperiodod='Junio'; $cfecha="01/06/".substr($cfecha,6,4);
$sql_saldo=$sql_saldo."+(BAN002.Deb_Libro06-BAN002.Cre_Libro06)"; $sql_saldo_b=$sql_saldo_b."+(BAN002.deb_banco06-BAN002.cre_banco06)";}
if($periodod>="07"){ $dperiodod='Julio'; $cfecha="01/07/".substr($cfecha,6,4);
$sql_saldo=$sql_saldo."+(BAN002.Deb_Libro07-BAN002.Cre_Libro07)"; $sql_saldo_b=$sql_saldo_b."+(BAN002.deb_banco07-BAN002.cre_banco07)";}
if($periodod>="08"){ $dperiodod='Agosto'; $cfecha="01/08/".substr($cfecha,6,4);
$sql_saldo=$sql_saldo."+(BAN002.Deb_Libro08-BAN002.Cre_Libro08)"; $sql_saldo_b=$sql_saldo_b."+(BAN002.deb_banco08-BAN002.cre_banco08)";}
if($periodod>="09"){ $dperiodod='Septiembre'; $cfecha="01/09/".substr($cfecha,6,4);
$sql_saldo=$sql_saldo."+(BAN002.Deb_Libro09-BAN002.Cre_Libro09)"; $sql_saldo_b=$sql_saldo_b."+(BAN002.deb_banco09-BAN002.cre_banco09)";}
if($periodod>="10"){ $dperiodod='Octubre'; $cfecha="01/10/".substr($cfecha,6,4);
$sql_saldo=$sql_saldo."+(BAN002.Deb_Libro10-BAN002.Cre_Libro10)"; $sql_saldo_b=$sql_saldo_b."+(BAN002.deb_banco10-BAN002.cre_banco10)";}
if($periodod>="11"){ $dperiodod='Noviembre'; $cfecha="01/11/".substr($cfecha,6,4);  
$sql_saldo=$sql_saldo."+(BAN002.Deb_Libro11-BAN002.Cre_Libro11)"; $sql_saldo_b=$sql_saldo_b."+(BAN002.deb_banco11-BAN002.cre_banco11)";}
if($periodod>="12"){ $dperiodod='Diciembre'; $cfecha="01/12/".substr($cfecha,6,4);  
$sql_saldo=$sql_saldo."+(BAN002.Deb_Libro12-BAN002.Cre_Libro12)"; $sql_saldo_b=$sql_saldo_b."+(BAN002.deb_banco12-BAN002.cre_banco12)";}
$sql_saldo_act=$sql_saldo." ) as monto1, "; $sql_saldo_ban=$sql_saldo_b." ) as monto2, ";
$fecha_d=$cfecha; $fecha_h=colocar_udiames($cfecha); $criterio1="Fecha desde: ".$fecha_d." al ".$fecha_h; $criterio2=$fecha_h;
$Sql="DELETE FROM BAN023 where (codigo_mov='".$codigo_mov."')";  $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91);
$Sql="DELETE FROM BAN031 where (codigo_mov='".$codigo_mov."')";  $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91);

$Sql="INSERT INTO BAN023 Select '".$codigo_mov."',BAN002.cod_banco,BAN002.nombre_banco,BAN002.nro_cuenta,BAN002.descripcion_banco,BAN002.tipo_cuenta,BAN002.cod_contable,BAN002.tipo_bco,'N',BAN002.fecha_activa,BAN002.fecha_desactiva,". $sql_saldo_act . $sql_saldo_ban ." 0, 0, 0, 0, 0, 0, 0, 0  from ban002 where (BAN002.cod_banco>='".$cod_banco_d."' AND BAN002.cod_banco<='".$cod_banco_h."')";  $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91);
if($metodo_conci=="SEB"){$nom_rep="Rpt_Conciliacion_Saldos_Encontrados.xml"; $Sql="SELECT RPT_CONC_SALDOS_EN('".$codigo_mov."','".$periodod."','".$cod_banco_d."','".$cod_banco_h."')";}
if($metodo_conci=="SA"){$nom_rep="Rpt_Conciliacion_Saldos_Ajustados.xml"; $Sql="SELECT RPT_CONC_SALDOS_AJUS('".$codigo_mov."','".$periodod."','".$cod_banco_d."','".$cod_banco_h."')";}
if($metodo_conci=="SEL"){$nom_rep="Rpt_Conciliacion_Saldos_Encontrados_Libros.xml"; $Sql="SELECT RPT_CONC_SALDOS_LIB('".$codigo_mov."','".$periodod."','".$cod_banco_d."','".$cod_banco_h."')";
$des_encab="SALDO SEGUN LIBROS :"; $des_pie1="SALDO EN BANCOS SEGUN CONCILIACION :"; $des_pie2="SALDO ACTUAL EN BANCOS :";}
if($metodo_conci=="SEBM"){$nom_rep="Rpt_Conciliacion_Saldos_Encontrados_benef.xml"; $Sql="SELECT RPT_CONC_SALDOS_EN('".$codigo_mov."','".$periodod."','".$cod_banco_d."','".$cod_banco_h."')";}
$resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR : ".substr($error,0,91);
$sql_saldo_act=$sql_saldo." ) as saldo_act_lib, "; $sql_saldo_ban=$sql_saldo_b." ) as saldo_act_ban, ";

   $sSQL = "SELECT BAN010.cod_banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN010.Tipo_Registro, BAN003.Tipo, BAN010.Tipo_Mov_Trans, BAN010.Referencia, BAN010.Descrip_Mov_Trans,
                BAN010.Beneficiario, BAN010.Fecha_Mov_Trans, BAN010.Monto_Mov_Trans, BAN010.Mes_Conciliado, BAN002.S_Inic_Libro, BAN002.S_Inic_Banco,". $sql_saldo_act.$sql_saldo_ban."BAN003.Descrip_Tipo_Mov  FROM BAN002 BAN002, BAN003 BAN003, BAN010 BAN010
                WHERE BAN002.cod_banco = BAN010.cod_banco AND BAN010.Tipo_Mov_Trans = BAN003.Tipo_Movimiento AND (BAN002.cod_banco>='".$cod_banco_d."' AND BAN002.cod_banco<='".$cod_banco_h."') AND BAN010.Mes_Conciliado='".$periodod."'";

   $sSQL = "SELECT BAN031.cod_banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN031.Tipo_Registro, BAN031.Tipo_Mov_Trans, BAN031.Referencia, BAN031.Descrip_Mov_Trans,BAN031.Beneficiario, BAN031.Fecha_Mov_Trans, BAN031.Monto_Mov_Trans, ban031.titulo_tipo_mov,
                BAN031.Mes_Conciliado,BAN031.columna1,BAN031.columna2,BAN031.columna3,BAN031.columna4,BAN031.columna5,BAN031.columna6,BAN031.columna7,BAN002.S_Inic_Libro, BAN002.S_Inic_Banco, BAN003.Descrip_Tipo_Mov,to_char(fecha_mov_trans,'DD/MM/YYYY') as fecham, text(BAN031.tipo_registro)||text(BAN031.columna7) as tipo_reg  FROM BAN002 BAN002, BAN003 BAN003, BAN031 BAN031
                WHERE BAN002.cod_banco = BAN031.cod_banco AND BAN031.Tipo_Mov_Trans = BAN003.Tipo_Movimiento AND (BAN002.cod_banco>='".$cod_banco_d."' AND BAN002.cod_banco<='".$cod_banco_h."') AND (BAN031.Mes_Conciliado='".$periodod."') And (codigo_mov='".$codigo_mov."') order by ban031.cod_banco,ban031.tipo_registro,ban031.nro_linea";
    
	if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML($nom_rep);
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"dperiodod"=>$dperiodod,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec   = $aBench["report_end"]-$aBench["report_start"];
	}
	
	if($tipo_rep=="PDF"){  $i=0; 
	    if(($metodo_conci=="SEB") or ($metodo_conci=="SEL")){ 
	      $res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_banco_grupo="0000"; $nombre_banco_grupo=""; $nro_cuenta_grupo="00000000"; $titulo_tipo_mov_grupo="";
	      if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		     $columna2=$registro["columna2"]; $columna3=$registro["columna3"];  $columna4=$registro["columna4"]; $columna5=$registro["columna5"];   
			 $saldo_segun_banco=formato_monto($columna4); $titulo_tipo_mov=$registro["titulo_tipo_mov"]; $titulo_tipo_mov_grupo=$titulo_tipo_mov; 
		  if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; }
		  $prev_cod_banco=$cod_banco_grupo;
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $tam_logo;   global $i; global $criterio1; global $cod_banco_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo; global $des_encab; 
			    global $dperiodod; global $saldo_segun_banco; global $titulo_tipo_mov_grupo;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'CONCILIACION BANCARIA',1,0,'C');
				$this->Ln(20);
				$this->SetFont('Arial','B',8);				
				$this->Cell(120,5,"Banco: ".$nombre_banco_grupo,0,0);
			   	$this->Cell(80,5,"Cuenta: ".$nro_cuenta_grupo,0,1,'R');				
				$this->Cell(200,5,"Mes: ".$dperiodod,0,1,'L');
				$this->SetFont('Arial','B',7);
				$this->Cell(30,5,'DOCUMENTO',1,0);
				$this->Cell(30,5,'REFERENCIA',1,0,'C');						
				$this->Cell(30,5,'FECHA',1,0,'C');	
				$this->Cell(30,5,'MONTO',1,0,'R');
				$this->Cell(30,5,'SUB-TOTALES',1,0,'R');
				$this->Cell(50,5,'',1,1,'C');
				$this->Cell(170,5,$des_encab,0,0,'R');
				$this->Cell(30,5,$saldo_segun_banco,0,1,'R');  
				$this->SetFont('Arial','',7);
                if($i>0){$this->Cell(170,4,$titulo_tipo_mov_grupo,0,0,'L');
				$this->Cell(30,4,'',0,1,'L');}
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
		   $columna2=0; $columna5=0; $monto=0;   $prev_tipo="";  $prev_tipo_mov_trans=""; $prev_des_mov_trans="";		  
		  while($registro=pg_fetch_array($res)){  $i=$i+1;	  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);}			   
			   $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta;			   
		       $titulo_tipo_mov=$registro["titulo_tipo_mov"]; $tipo_mov_trans=$registro["tipo_mov_trans"];  $tipo_registro=$registro["tipo_registro"];
               $descrip_tipo_mov=$registro["descrip_tipo_mov"]; $monto_mov_trans=$registro["monto_mov_trans"];  $columna7=$registro["columna7"];
			   
			   $caso1="-------------------"; $caso2="TOTAL: ".$prev_des_mov_trans; $caso3=formato_monto($monto);
		       //if($tipo_registro=="0"){$caso1="";$caso2="";$caso3="";}else{ $caso1="-------------------"; $caso2="TOTAL: ".$prev_des_mov_trans; $caso3=formato_monto($monto);}  
			   
			   $tipo_grupo=$tipo_registro.$columna7; $titulo_tipo_mov_grupo=$titulo_tipo_mov; $tipo_mov_trans_grupo=$tipo_mov_trans; 
			   
			   if(($prev_tipo<>$tipo_grupo)or($prev_cod_banco<>$cod_banco_grupo)or($prev_tipo_mov_trans<>$tipo_mov_trans_grupo)){ 
			     $pdf->SetFont('Arial','',7); 
			     if(($prev_tipo_mov_trans<>"")){ 
				    if($monto<>0){
						$pdf->Cell(90,2,'',0,0,'R'); 	    
						$pdf->Cell(30,2,$caso1,0,1,'R');    
						$pdf->Cell(90,3,$caso2,0,0,'R'); 
						$pdf->Cell(30,3,$caso3,0,1,'R');  
						$pdf->Ln(2); 
					}					
				 }	
				 $prev_tipo_mov_trans=$tipo_mov_trans_grupo; $prev_des_mov_trans=$descrip_tipo_mov; $monto=0; 
			   }	   
			   if(($prev_tipo<>$tipo_grupo)or($prev_cod_banco<>$cod_banco_grupo)){ 
			     $pdf->SetFont('Arial','',7); 
			     if(($prev_tipo<>"")){ $sub_total=formato_monto($columna2); 	    
					$pdf->Cell(120,5,"SUB TOTAL: ",0,0,'R'); 
					$pdf->Cell(30,5,$sub_total,0,1,'R');
                    $pdf->Ln(2);					
				 }
				 if(($prev_cod_banco==$cod_banco_grupo)){
				   $pdf->Cell(170,4,$titulo_tipo_mov_grupo,0,0,'L');
				   $pdf->Cell(30,4,'',0,1,'L'); }
				 $prev_tipo=$tipo_grupo; $prev_tipo_mov_trans=$tipo_mov_trans_grupo;
			   }
			   if($prev_cod_banco<>$cod_banco_grupo){ $saldo_segun_banco=$registro["columna4"]; $saldo_segun_banco=formato_monto($saldo_segun_banco);
			     $pdf->SetFont('Arial','B',7); 
				 //if(($columna2<>0)or($columna5<>0)){  
				    $saldo_segun_conc=formato_monto($columna2); $saldo_act_lib=formato_monto($columna5);   
					$pdf->Cell(170,5,$des_pie1,0,0,'R'); 
					$pdf->Cell(30,5,$saldo_segun_conc,0,1,'R');
					$pdf->Cell(170,5,$des_pie2,0,0,'R');
					$pdf->Cell(30,5,$saldo_act_lib,0,1,'R'); 
					$pdf->AddPage();					
				 //}
				 $prev_cod_banco=$cod_banco_grupo; $columna2=0; $columna5=0; $monto=0;   $prev_tipo=$tipo_grupo;   $prev_tipo_mov_trans=$tipo_mov_trans_grupo; $prev_des_mov_trans=$descrip_tipo_mov;
			   }			   
               $pdf->SetFont('Arial','',7);	
		       $tipo_registro=$registro["tipo_registro"]; $tipo_mov_trans=$registro["tipo_mov_trans"]; $referencia=$registro["referencia"]; $fecham=$registro["fecham"];
			   $titulo_tipo_mov=$registro["titulo_tipo_mov"]; $descrip_tipo_mov=$registro["descrip_tipo_mov"]; $monto_mov_trans=$registro["monto_mov_trans"]; 
			   $columna2=$registro["columna2"]; $columna5=$registro["columna5"]; $beneficiario=$registro["beneficiario"];			   
			   if($tipo_registro=="0"){$caso4="";$caso5="";$caso6="";$caso7="";$caso8="";}
			   else{$caso4=$tipo_mov_trans;$caso5=$referencia;$caso6=$fecham;$caso7=formato_monto($monto_mov_trans);$caso8=$beneficiario;} 	
			   $monto=$monto+$monto_mov_trans;   $monto_mov_trans=formato_monto($monto_mov_trans); 
               if($monto>0){			   
			   $pdf->Cell(30,3,$caso4,0,0,'L'); 
			   $pdf->Cell(30,3,$caso5,0,0,'C');				   
			   $pdf->Cell(30,3,$caso6,0,0,'C'); 
			   $pdf->Cell(30,3,$caso7,0,0,'R'); 
               $pdf->Cell(80,3,' ',0,1,'R'); }			  	
			} 			
			if($monto<>0){ $caso3=formato_monto($monto);
			$pdf->Cell(90,2,' ',0,0,'R'); 	    
			$pdf->Cell(30,2,$caso1,0,1,'R');    
			$pdf->Cell(90,3,$caso2,0,0,'R'); 
			$pdf->Cell(30,3,$caso3,0,1,'R'); 
            $pdf->Ln(2); }					
			$pdf->SetFont('Arial','',7); 
			$sub_total=formato_monto($columna5); 	    
			$pdf->Cell(120,5,"SUB TOTAL: ",0,0,'R'); 
			$pdf->Cell(30,5,$sub_total,0,1,'R');
			$pdf->Ln(2);
			$pdf->SetFont('Arial','B',7); 
			if(($columna2>=0)or($columna5>=0)){   $saldo_segun_conc=formato_monto($columna2); $saldo_act_lib=formato_monto($columna5); 
				$pdf->Cell(170,5,$des_pie1,0,0,'R'); 
				$pdf->Cell(30,5,$saldo_segun_conc,0,1,'R');
				$pdf->Cell(170,5,$des_pie2,0,0,'R');
				$pdf->Cell(30,5,$saldo_act_lib,0,1,'R'); 
			}		
            if($Cod_Emp=="71"){
                $pdf->Ln(5);
			    $y=$pdf->GetY(); $x=$pdf->GetX();				
				if($y<220){$t=220-$y; $pdf->ln($t);} 
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(200,4,'FIRMAS Y SELLOS',1,1,'C');
				$pdf->SetFont('Arial','',8);		
				$pdf->Cell(100,4,'PREPARADA POR',1,0,'C');
				$pdf->Cell(100,4,'CONFORMADA POR',1,1,'C');
				$pdf->Cell(100,10,' ','LR',0,'C');
				$pdf->Cell(100,10,' ','LR',1,'C');
				$pdf->Cell(100,4,'Firma:','LR',0,'L');
				$pdf->Cell(100,4,'Firma:','LR',1,'L');
				$pdf->Cell(100,4,'Nombre:','LR',0,'L');
				$pdf->Cell(100,4,'Nombre:','LR',1,'L');
				$pdf->Cell(100,4,'Cargo:','BLR',0,'L');
				$pdf->Cell(100,4,'Cargo:','BLR',1,'L');
            }			
			$pdf->Output(); 
		}
        if($metodo_conci=="SA"){
	      $res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_banco_grupo="0000"; $nombre_banco_grupo=""; $nro_cuenta_grupo="00000000"; $tipo_registro_grupo="";
	      if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		     $columna2=$registro["columna2"]; $columna3=$registro["columna3"];  $columna4=$registro["columna4"]; $columna5=$registro["columna5"];   
			 $saldo_segun_banco=formato_monto($columna4); 
		  if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; }
          require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $tam_logo;  global $criterio1; global $criterio2; global $cod_banco_grupo; global $tipo_registro_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo; global $dperiodod; global $saldo_segun_banco;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'CONCILIACION BANCARIA',1,0,'C');
				$this->Ln(20);
				$this->SetFont('Arial','B',8);				
				$this->Cell(120,5,"Banco: ".$nombre_banco_grupo,0,0);
			   	$this->Cell(80,5,"Cuenta: ".$nro_cuenta_grupo,0,1,'R');				
				$this->Cell(200,5,$criterio1,0,1,'L');
				$this->SetFont('Arial','B',7);
				$this->Cell(13,5,'FECHA',1,0,'C');
				$this->Cell(17,5,'REFERENCIA',1,0,'C');
				$this->Cell(8,5,'MOV',1,0,'C');
				$this->Cell(98,5,'BENEFICIARIO',1,0,'L');	
				$this->Cell(20,5,'MONTO',1,0,'R');
				$this->Cell(22,5,'SALDO S/LIBROS',1,0,'R');
				$this->Cell(22,5,'SALDO S/BANCOS',1,1,'C');
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
		  $pdf->SetFont('Arial','',7);
		  $i=0;   $columna4=0; $columna5=0;  $prev_cod_banco=""; $prev_tipo_registro="";  
		  $resultado1=0; $resultado2=0; $resultado3=0; $resultado4=0;   
		  while($registro=pg_fetch_array($res)){  $cod_banco=$registro["cod_banco"]; $tipo_registro=$registro["tipo_registro"]; 
		     $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $columna4=$registro["columna4"]; $columna5=$registro["columna5"];  
		     $titulo_tipo_mov=$registro["titulo_tipo_mov"];
		     $columna4=formato_monto($columna4); $columna5=formato_monto($columna5);		   
		     $cod_banco_grupo=$cod_banco; $tipo_registro_grupo=$tipo_registro; $titulo_tipo_mov=$registro["titulo_tipo_mov"]; $nombre_banco_grupo=$nombre_banco; 
             $nro_cuenta_grupo=$nro_cuenta; $columna4_grupo=$columna4; $columna5_grupo=$columna5; $titulo_tipo_mov_grupo=$titulo_tipo_mov;                   
		     if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);}		
			 if($prev_cod_banco<>$cod_banco_grupo){ 
			     //if(($resultado1<>0)or($resultado2<>0)){  
				 if($i>0){
				    $resultado3=formato_monto($resultado3); $resultado4=formato_monto($resultado4); 
				     $resultado1=formato_monto($resultado1); $resultado2=formato_monto($resultado2);  
			     	$pdf->Cell(156,5,'',0,0,'R'); 	    
				    $pdf->Cell(22,5,$resultado3,0,0,'R'); 
				    $pdf->Cell(22,5,$resultado4,0,1,'R');
					$pdf->SetFont('Arial','B',7);  
					$pdf->Cell(156,5,'',0,0,'R'); 
					$pdf->Cell(22,2,'______________',0,0,'R'); 
					$pdf->Cell(22,2,'______________',0,1,'R'); 
					$pdf->Cell(156,5,"TOTAL SALDOS AJUSTADOS: ",0,0,'C');
					$pdf->Cell(22,5,$resultado1,0,0,'R'); 
					$pdf->Cell(22,5,$resultado2,0,1,'R');
                    $pdf->AddPage();					
				 }
			     $pdf->SetFont('Arial','B',7); 
				 $pdf->Cell(156,5,'Saldo al:'."   ".$criterio2,0,0,'L'); 
				 $pdf->Cell(22,5,$columna4_grupo,0,0,'R'); 
				 $pdf->Cell(22,5,$columna5_grupo,0,1,'R'); 
				 $pdf->Cell(200,5,$titulo_tipo_mov_grupo,0,1,'L');
			       
				 $prev_cod_banco=$cod_banco_grupo; $prev_tipo_registro=$tipo_registro_grupo; $resultado1=0; $resultado2=0;  $resultado3=0; $resultado4=0;
			 }
			 if($prev_tipo_registro<>$tipo_registro_grupo){ 
			     if(($resultado3>0)or($resultado4>0)){  $resultado3=formato_monto($resultado3); $resultado4=formato_monto($resultado4);  
					$pdf->Cell(156,5,'',0,0,'R'); 	    
					$pdf->Cell(22,5,$resultado3,0,0,'R'); 
					$pdf->Cell(22,5,$resultado4,0,1,'R');			
			 }
			 $pdf->SetFont('Arial','B',7); 
			 $pdf->Cell(200,5,$titulo_tipo_mov_grupo,0,1,'L');
			 $prev_tipo_registro=$tipo_registro_grupo; $resultado3=0; $resultado4=0; }
		     $tipo_registro=$registro["tipo_registro"]; $tipo_mov_trans=$registro["tipo_mov_trans"]; $referencia=$registro["referencia"]; $fecham=$registro["fecham"];
		     $beneficiario=$registro["beneficiario"]; $titulo_tipo_mov=$registro["titulo_tipo_mov"]; $descrip_mov_trans=$registro["descrip_mov_trans"]; 
		     $monto_mov_trans=$registro["monto_mov_trans"]; $resultado3=$registro["columna2"]; $resultado4=$registro["columna3"]; $columna4=$registro["columna4"]; 
		     $columna5=$registro["columna5"]; $resultado1=$registro["columna6"]; $resultado2=$registro["columna7"];		   
		     if($tipo_registro=="0"){$caso1="";$caso2="";$caso4="";$caso3="";$caso5="";}
			 else{$caso1=$fecham; $caso2=$referencia;$caso3=$tipo_mov_trans; if($tipo_mov_trans=="CHQ"){$caso4=$beneficiario;}else{$caso4=$descrip_mov_trans;} $caso5=formato_monto($monto_mov_trans);} 
		     $pdf->SetFont('Arial','',7);
	         $pdf->Cell(15,3,$caso1,0,0,'C'); 
	         $pdf->Cell(15,3,$caso2,0,0,'C'); 
	         $pdf->Cell(8,3,$caso3,0,0,'C'); 				   
		     $x=$pdf->GetX();   $y=$pdf->GetY(); $n=98;
		   	 $pdf->SetXY($x+$n,$y);
             $pdf->Cell(22,3,$caso5,0,1,'R'); 				
		     $pdf->SetXY($x,$y);
		     $pdf->MultiCell($n,3,$caso4,0); 
			 $i=$i+1; 
		  } 
		    if(($resultado3<>0)or($resultado4<>0)){  $resultado3=formato_monto($resultado3); $resultado4=formato_monto($resultado4);  
				$pdf->Cell(156,5,'',0,0,'R'); 	    
				$pdf->Cell(22,5,$resultado3,0,0,'R'); 
				$pdf->Cell(22,5,$resultado4,0,1,'R');			
			}		
			if(($resultado1<>0)or($resultado2<>0)){  $resultado1=formato_monto($resultado1); $resultado2=formato_monto($resultado2);
				$pdf->SetFont('Arial','B',7);    
				$pdf->Cell(156,5,'',0,0,'R'); 
				$pdf->Cell(22,5,'______________',0,0,'R'); 
				$pdf->Cell(22,5,'______________',0,1,'R'); 
				$pdf->Cell(156,5,"TOTAL SALDOS AJUSTADOS: ",0,0,'C');
				$pdf->Cell(22,5,$resultado1,0,0,'R'); 
				$pdf->Cell(22,5,$resultado2,0,1,'R');				
			}
		  $pdf->Output();  
		}
        if($metodo_conci=="SEBM"){
		   $res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_banco_grupo="0000"; $nombre_banco_grupo=""; $nro_cuenta_grupo="00000000"; $titulo_tipo_mov_grupo="";
	      if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		     $columna2=$registro["columna2"]; $columna3=$registro["columna3"];  $columna4=$registro["columna4"]; $columna5=$registro["columna5"];   
			 $saldo_segun_banco=formato_monto($columna4); $titulo_tipo_mov=$registro["titulo_tipo_mov"]; $titulo_tipo_mov_grupo=$titulo_tipo_mov; 
		  if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; }
		  $prev_cod_banco=$cod_banco_grupo;
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $tam_logo;  global $i; global $criterio1; global $cod_banco_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo; global $des_encab; 
			    global $dperiodod; global $saldo_segun_banco; global $titulo_tipo_mov_grupo;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'CONCILIACION BANCARIA',1,0,'C');
				$this->Ln(20);
				$this->SetFont('Arial','B',8);				
				$this->Cell(120,5,"Banco: ".$nombre_banco_grupo,0,0);
			   	$this->Cell(80,5,"Cuenta: ".$nro_cuenta_grupo,0,1,'R');				
				$this->Cell(200,5,"Mes: ".$dperiodod,0,1,'L');
				$this->SetFont('Arial','B',7);
				$this->Cell(13,5,'TIPO',1,0);
				$this->Cell(17,5,'REFERENCIA',1,0,'C');						
				$this->Cell(15,5,'FECHA',1,0,'C');
                $this->Cell(95,5,'BENEFICIARIO',1,0,'L');				
				$this->Cell(20,5,'MONTO',1,0,'R');
				$this->Cell(20,5,'SUB-TOTALES',1,0,'R');
				$this->Cell(20,5,'',1,1,'C');				
				$this->Cell(170,5,$des_encab,0,0,'R');
				$this->Cell(30,5,$saldo_segun_banco,0,1,'R');  
				$this->SetFont('Arial','',7);
                if($i>0){$this->Cell(170,4,$titulo_tipo_mov_grupo,0,0,'L');
				$this->Cell(30,4,'',0,1,'L');	}
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
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $columna2=0; $columna5=0; $monto=0;   $prev_tipo="";  $prev_tipo_mov_trans=""; $prev_des_mov_trans="";		  
		  while($registro=pg_fetch_array($res)){  $i=$i+1;	  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);}			   
			   $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta;			   
		       $titulo_tipo_mov=$registro["titulo_tipo_mov"]; $tipo_mov_trans=$registro["tipo_mov_trans"]; 
			   $tipo_registro=$registro["tipo_registro"];
               $descrip_tipo_mov=$registro["descrip_tipo_mov"]; $monto_mov_trans=$registro["monto_mov_trans"];  $columna7=$registro["columna7"];			   
		       if($tipo_registro=="0"){$caso1="";}else{$caso1="-------------------";}  
			   if($tipo_registro=="0"){$caso2="";}else{$caso2="TOTAL: ".$prev_des_mov_trans;}
		       if($tipo_registro=="0"){$caso3="";}else{$caso3=formato_monto($monto);}
			   $tipo_grupo=$tipo_registro.$columna7; $titulo_tipo_mov_grupo=$titulo_tipo_mov; $tipo_mov_trans_grupo=$tipo_mov_trans; 
			   if($prev_tipo_mov_trans<>$tipo_mov_trans_grupo){ 
			     $pdf->SetFont('Arial','',7); 
			     if($prev_tipo_mov_trans<>""){ 
				    if($monto>0){
					$pdf->Cell(140,2,'',0,0,'R'); 	    
					$pdf->Cell(20,2,$caso1,0,1,'R');    
					$pdf->Cell(140,3,$caso2,0,0,'R'); 
					$pdf->Cell(20,3,$caso3,0,1,'R');  
                    $pdf->Ln(2); }					
				 }	$prev_tipo_mov_trans=$tipo_mov_trans_grupo; $prev_des_mov_trans=$descrip_tipo_mov; $monto=0; 
			   }			   
			   if(($prev_tipo<>$tipo_grupo)or($prev_cod_banco<>$cod_banco_grupo)){ 
			     $pdf->SetFont('Arial','',7); 
			     if($prev_tipo<>""){ $sub_total=formato_monto($columna2); 	    
					$pdf->Cell(160,5,"SUB TOTAL: ",0,0,'R'); 
					$pdf->Cell(20,5,$sub_total,0,1,'R');
                    $pdf->Ln(2);					
				 }
				 if($prev_cod_banco==$cod_banco_grupo){
				   $pdf->Cell(180,4,$titulo_tipo_mov_grupo,0,0,'L');
				   $pdf->Cell(20,4,'',0,1,'L'); }
				 $prev_tipo=$tipo_grupo; 
			   }
			   if($prev_cod_banco<>$cod_banco_grupo){ $saldo_segun_banco=$registro["columna4"]; $saldo_segun_banco=formato_monto($saldo_segun_banco);
			     $pdf->SetFont('Arial','B',7); 
				 //if(($columna2<>0)or($columna5<>0)){  
				    $saldo_segun_conc=formato_monto($columna2); $saldo_act_lib=formato_monto($columna5);   
					$pdf->Cell(180,5,$des_pie1,0,0,'R'); 
					$pdf->Cell(20,5,$saldo_segun_conc,0,1,'R');
					$pdf->Cell(180,5,$des_pie2,0,0,'R');
					$pdf->Cell(20,5,$saldo_act_lib,0,1,'R'); 
					$pdf->AddPage();					
				 //}
				 $prev_cod_banco=$cod_banco_grupo; $columna2=0; $columna5=0; $monto=0;   $prev_tipo=$tipo_grupo;   $prev_tipo_mov_trans=$tipo_mov_trans_grupo; $prev_des_mov_trans=$descrip_tipo_mov;
			   }			   
               $pdf->SetFont('Arial','',7);	
		       $tipo_registro=$registro["tipo_registro"]; $tipo_mov_trans=$registro["tipo_mov_trans"]; $referencia=$registro["referencia"]; $fecham=$registro["fecham"];
			   $titulo_tipo_mov=$registro["titulo_tipo_mov"]; $descrip_tipo_mov=$registro["descrip_tipo_mov"]; $monto_mov_trans=$registro["monto_mov_trans"]; 
			   $columna2=$registro["columna2"]; $columna5=$registro["columna5"];	$beneficiario=$registro["beneficiario"];	 $descrip_mov_trans=$registro["descrip_mov_trans"]; 		   
			   if($tipo_registro=="0"){$caso4="";$caso5="";$caso6="";$caso7="";$caso8="";}
			   else{$caso4=$tipo_mov_trans;$caso5=$referencia;$caso6=$fecham;$caso7=formato_monto($monto_mov_trans);if($tipo_mov_trans=="CHQ"){$caso8=$beneficiario;}else{$caso8=$descrip_mov_trans;} $caso8=substr($caso8,0,60); } 
			   $monto=$monto+$monto_mov_trans;    
               if($monto>0){			   
			   $pdf->Cell(15,3,$caso4,0,0,'L'); 
			   $pdf->Cell(15,3,$caso5,0,0,'C');				   
			   $pdf->Cell(15,3,$caso6,0,0,'C');
               $pdf->Cell(95,3,$caso8,0,0,'L');
			   $pdf->Cell(20,3,$caso7,0,0,'R'); 
               $pdf->Cell(40,3,' ',0,1,'R'); }			  	
			} 			
			if($monto>0){    $caso3=formato_monto($monto);
			$pdf->Cell(140,2,' ',0,0,'R'); 	    
			$pdf->Cell(20,2,$caso1,0,1,'R');    
			$pdf->Cell(140,3,$caso2,0,0,'R'); 
			$pdf->Cell(20,3,$caso3,0,1,'R'); 
            $pdf->Ln(2); }					
			$pdf->SetFont('Arial','',7); 
			$sub_total=formato_monto($columna5); 	    
			$pdf->Cell(160,5,"SUB TOTAL: ",0,0,'R'); 
			$pdf->Cell(20,5,$sub_total,0,1,'R');
			$pdf->Ln(2);
			$pdf->SetFont('Arial','B',7); 
			if(($columna2<>0)or($columna5<>0)){   $saldo_segun_conc=formato_monto($columna2); $saldo_act_lib=formato_monto($columna5);  
				$pdf->Cell(180,5,$des_pie1,0,0,'R'); 
				$pdf->Cell(20,5,$saldo_segun_conc,0,1,'R');
				$pdf->Cell(180,5,$des_pie2,0,0,'R');
				$pdf->Cell(20,5,$saldo_act_lib,0,1,'R'); 
			}			
			$pdf->Output(); 
        }		
	}
	$Sql="DELETE FROM BAN023 where (codigo_mov='".$codigo_mov."')";  $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91);
	$Sql="DELETE FROM BAN031 where (codigo_mov='".$codigo_mov."')";  $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91);

}
?>
