<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_empleado=$_POST["txtcod_empleado"];$cedula=$_POST["txtcedula"];$nacionalidad=$_POST["txtnacionalidad"];$fecha_ingreso=$_POST["txtfecha_ingreso"];
$nombre=$_POST["txtnombre"];$tp_planilla=$_POST["txttp_planilla"]; $var_patrones=$_POST["txtvar_patrones"]; $tnom_emp=$_POST["txtnom_emp"]; $nro_empresa=$_POST["txtnro_empresa"];
$num_aseg=$_POST["txtnum_aseg"]; $cod_suc=$_POST["txtcod_suc"]; $cond_trab=$_POST["txtcond_trab"];$fecha_nac=$_POST["txtfecha_nacimiento"]; $direccion=$_POST["txtdireccion"];
$cod_cent=$_POST["txtcod_cent"]; $sexo=$_POST["txtsexo"]; $zurdo=$_POST["txtzurdo"]; $ing_empresa=$_POST["txting_empresa"]; $cod_z="";
$salario_sem=$_POST["txtsalario_sem"]; $cod_ocupacion=$_POST["txtcod_ocupacion"]; $ocupacion=$_POST["txtocupacion"];
$parentescof1=$_POST["txtparentescof1"]; $cedulaf1=$_POST["txtcedulaf1"]; $sexof1=$_POST["txtsexof1"]; $nombref1=$_POST["txtnombref1"]; $fecha_nacf1=$_POST["txtfecha_nacf1"];
$parentescof2=$_POST["txtparentescof2"]; $cedulaf2=$_POST["txtcedulaf2"]; $sexof2=$_POST["txtsexof2"]; $nombref2=$_POST["txtnombref2"]; $fecha_nacf2=$_POST["txtfecha_nacf2"];
$parentescof3=$_POST["txtparentescof3"]; $cedulaf3=$_POST["txtcedulaf3"]; $sexof3=$_POST["txtsexof3"]; $nombref3=$_POST["txtnombref3"]; $fecha_nacf3=$_POST["txtfecha_nacf3"];
$parentescof4=$_POST["txtparentescof4"]; $cedulaf4=$_POST["txtcedulaf4"]; $sexof4=$_POST["txtsexof4"]; $nombref4=$_POST["txtnombref4"]; $fecha_nacf4=$_POST["txtfecha_nacf4"];
$parentescof5=$_POST["txtparentescof5"]; $cedulaf5=$_POST["txtcedulaf5"]; $sexof5=$_POST["txtsexof5"]; $nombref5=$_POST["txtnombref5"]; $fecha_nacf5=$_POST["txtfecha_nacf5"];
$parentescof6=$_POST["txtparentescof6"]; $cedulaf6=$_POST["txtcedulaf6"]; $sexof6=$_POST["txtsexof6"]; $nombref6=$_POST["txtnombref6"]; $fecha_nacf6=$_POST["txtfecha_nacf6"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} 
  if($php_os=="WINNT"){$Nom_Emp=$Nom_Emp; }else{$Nom_Emp=utf8_decode($Nom_Emp);  }
  
  if($tp_planilla=="I"){$inst="X";} else {$inst="";}
  if($tp_planilla=="M"){$modd="X";} else {$modd="";}
  if($tp_planilla=="C"){$cambc="X";} else {$cambc="";}
  if($tp_planilla=="D"){$decf="X";} else {$decf="";}
  
  $si_pat=""; $no_pat=""; if($var_patrones=="SI"){$si_pat="X";}else {$no_pat="X";}
  $nac_v=""; $nac_e=""; if(substr($nacionalidad,0,1)=="E"){$nac_e="X";}else {$nac_v="X";}
  if($cond_trab=="PENSIONADO"){$cond_p="X";} else{$cond_p=""; }
  if($cond_trab=="JUBILADO"){$cond_j="X";} else{$cond_j=""; }
  
  $sexo_m=""; $sexo_f=""; if($sexo=="MASCULINO"){$sexo_m="X";}else {$sexo_f="X";} 
  $zurdo_s=""; $zurdo_n=""; if($zurdo=="SI"){$zurdo_s="X";}else {$zurdo_n="X";}
  
  $dian=substr($fecha_nac,0,2); $mesn=substr($fecha_nac,3,2); $anon=substr($fecha_nac,8,2);
  
  $diai=substr($ing_empresa,0,2); $mesi=substr($ing_empresa,3,2); $anoi=substr($ing_empresa,8,2);
  
  
  $sexo_m1=""; $sexo_f1=""; if($sexof1=="MASCULINO"){$sexo_m1="X";} if($sexof1=="FEMENINO"){$sexo_f1="X";} $dia1=substr($fecha_nacf1,0,2); $mes1=substr($fecha_nacf1,3,2); $ano1=substr($fecha_nacf1,8,2);
  $sexo_m2=""; $sexo_f2=""; if($sexof2=="MASCULINO"){$sexo_m2="X";} if($sexof2=="FEMENINO"){$sexo_f2="X";} $dia2=substr($fecha_nacf2,0,2); $mes2=substr($fecha_nacf2,3,2); $ano2=substr($fecha_nacf2,8,2);
  $sexo_m3=""; $sexo_f3=""; if($sexof3=="MASCULINO"){$sexo_m3="X";} if($sexof3=="FEMENINO"){$sexo_f3="X";} $dia3=substr($fecha_nacf3,0,2); $mes3=substr($fecha_nacf3,3,2); $ano3=substr($fecha_nacf3,8,2);
  $sexo_m4=""; $sexo_f4=""; if($sexof4=="MASCULINO"){$sexo_m4="X";} if($sexof4=="FEMENINO"){$sexo_f4="X";} $dia4=substr($fecha_nacf4,0,2); $mes4=substr($fecha_nacf4,3,2); $ano4=substr($fecha_nacf4,8,2);
  $sexo_m5=""; $sexo_f5=""; if($sexof5=="MASCULINO"){$sexo_m5="X";} if($sexof5=="FEMENINO"){$sexo_f5="X";} $dia5=substr($fecha_nacf5,0,2); $mes5=substr($fecha_nacf5,3,2); $ano5=substr($fecha_nacf5,8,2);
  $sexo_m6=""; $sexo_f6=""; if($sexof6=="MASCULINO"){$sexo_m6="X";} if($sexof6=="FEMENINO"){$sexo_f6="X";} $dia6=substr($fecha_nacf6,0,2); $mes6=substr($fecha_nacf6,3,2); $ano6=substr($fecha_nacf6,8,2);
  
  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $cod_empleado_grupo; global $cod_concepto_grupo; global $registro;
			$this->Image('../../imagenes/Logo ivss.jpg',7,7,18);
			$this->SetFont('Arial','B',8);
			$this->Cell(30);
			$this->Cell(70,3,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,0,'C');
			$this->Cell(90,3,'FORMA: 14-02',0,1,'R');
			$this->SetFont('Arial','',7);
			$this->Cell(30);
			$this->Cell(70,3,'MINISTERIO DEL PODER POPULAR PARA EL TRABAJO Y SEGURIDAD SOCIAL',0,1,'C');
			$this->Cell(30);
			$this->Cell(70,3,'INSTITUTO VENEZOLANO DE LOS SEGUROS SOCIALES ',0,1,'C');
			$this->Cell(30);
			$this->Cell(70,3,'DIRECCION GENERAL DE AFILIACION  Y PRESTACIONES EN DINERO ',0,1,'C');
			$this->Ln(7);
			$this->SetFont('Arial','B',12);
			$this->Cell(200,6,'REGISTRO DE ASEGURADO',0,1,'C');
			$this->SetFont('Arial','',8);
			$this->Cell(200,6,'(INSERTE UNA EQUIS (X) EN EL RECUADRO QUE CORRESPONDA)',0,1,'C');
			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-15);
			$this->SetFont('Arial','',7);
			$this->Cell(200,4,'EL FORMULARIO Y SU TRAMITACION SON COMPLETAMENTE GRATUITOS',0,1,'C');
			$this->Cell(200,4,'www.ivss.gov.ve',0,1,'C');
			//$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			//$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','B',7);
  
      $pdf->Cell(50,3,'INSCRIPCION DE TRABAJADOR','TRL',0,'C');
      $pdf->Cell(50,3,' ','TRL',0,'C');
      $pdf->Cell(50,3,'CAMBIO DE NUMERO','TRL',0,'C');
      $pdf->Cell(50,3,'DECLARACION DE','TRL',1,'C');	
      $pdf->Cell(50,3,'EN EL IVSS','BRL',0,'C');
      $pdf->Cell(50,3,'MODIFICACION DE DATOS ','BRL',0,'C');
      $pdf->Cell(50,3,'DE CEDULA DE IDENTIDAD','BRL',0,'C');
      $pdf->Cell(50,3,'FAMILIARES ','BRL',1,'C');	

      $pdf->SetFont('Arial','',7);
      $pdf->Cell(50,3,'LLENE LAS CASILLAS','TRL',0,'C');
      $pdf->Cell(50,3,'LLENE ENTRE LAS CASILLAS','TRL',0,'C');
      $pdf->Cell(50,3,'EXTRANJERO A VENEZOLANO','TRL',0,'C');
      $pdf->Cell(50,3,'LLENE LAS CASILLAS ','TRL',1,'C');
      $pdf->Cell(50,3,'1 AL 14','RL',0,'C');
      $pdf->Cell(50,3,'1 AL 14, LOS DATOS QUE','RL',0,'C');
      $pdf->Cell(50,3,'LLENE LAS CASILLAS 1, 2, 3 Y','RL',0,'C');
      $pdf->Cell(50,3,'3, 4, 6, 15, 16, 17, 18 Y 19','RL',1,'C');
	  
	  $pdf->Cell(30,5,'','RL',0,'C');
	  $pdf->SetFont('Arial','B',9);
	  $pdf->Cell(10,5,'A','TRL',0,'C');
	  $pdf->Cell(10,5,$inst,'TRL',0,'C');
	  $pdf->SetFont('Arial','',7);
      $pdf->Cell(50,5,'DESEA MODIFICAR ','RL',0,'C');
      $pdf->Cell(50,5,'EL Nº DE ASEGURADO ANTERIOR','RL',0,'C');
      $pdf->Cell(50,5,'SOLO FIRMA EL ASEGURADO ','RL',1,'C');
	  
	  $pdf->SetFont('Arial','',6);
	  $pdf->Cell(10,3,'SI','TLR',0,'C');
	  $pdf->Cell(30,3,'TRABAJA PARA','T',0,'C');
	  $pdf->Cell(10,3,'NO','TRL',0,'C');
      $pdf->Cell(50,3,'','RL',0,'C');
      $pdf->Cell(50,3,'','RL',0,'C');
      $pdf->Cell(50,3,' ','RL',1,'C');
	  $pdf->SetFont('Arial','',7);
	  
	  $pdf->Cell(10,5,$si_pat,1,0,'C');
	  $pdf->Cell(30,5,'VARIOS PATRONES','B',0,'C');
	  $pdf->Cell(10,5,$no_pat,1,0,'C');
	  $pdf->SetFont('Arial','B',9);
      $pdf->Cell(30,5,'','BRL',0,'C');
	  $pdf->Cell(10,5,'B',1,0,'C');
	  $pdf->Cell(10,5,$modd,1,0,'C');
      $pdf->Cell(30,5,'','BRL',0,'C');
	  $pdf->Cell(10,5,'C',1,0,'C');
	  $pdf->Cell(10,5,$cambc,1,0,'C');
      $pdf->Cell(30,5,' ','BRL',0,'C');
	  $pdf->Cell(10,5,'D',1,0,'C');
	  $pdf->Cell(10,5,$decf,1,1,'C');
      $pdf->SetFont('Arial','',7); 	
      $pdf->Ln(2);	
	  $pdf->Cell(155,4,'1. RAZON SOCIAL DE LA EMPRESA O NOMBRE DEL PATRONO	',1,0,'C'); 
	  $pdf->Cell(45,4,'2. NUMERO DE EMPRESA',1,1,'C');
	  
	  $pdf->Cell(155,6,$tnom_emp,1,0,'C'); 
	  $pdf->Cell(5,6,substr($nro_empresa,0,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,2,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,2,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,3,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,4,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,5,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,6,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,7,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,8,1),1,1,'C');

	  $texto='EL NUMERO DE ASEGURADO SE CONFORMA CON “1” SI ES VENEZOLANO, “2” SI ES EXTRANJERO Y EL NUMERO DE CEDULA DE IDENTIDAD ';
	  $pdf->Ln(2);	
	  $pdf->Cell(7,4,'V',1,0,'C'); 
	  $pdf->Cell(7,4,'E',1,0,'C'); 
	  $pdf->Cell(40,4,'3. CEDULA DE IDENTIDAD Nº',1,0,'C');
	  $x=$pdf->GetX();   $y=$pdf->GetY();
      $pdf->Cell(46,4,'','TRL',0,'C');	  
	  $pdf->Cell(50,4,'4. NUMERO DE ASEGURADO',1,0,'C');	  
	  $pdf->Cell(50,4,'5. SUC. DPTO. DPCIA.',1,1,'C');	  
	  
	  $pdf->Cell(7,2,'','RL',0,'C'); 
	  $pdf->Cell(7,2,'','RL',0,'C'); 
	  $pdf->Cell(40,2,'','RL',0,'C');
	  $pdf->Cell(46,2,'','RL',0,'C');
	  $pdf->Cell(50,2,'','RL',0,'C');
	  $pdf->Cell(50,2,'','RL',1,'C');
	  
	  $pdf->Cell(7,5,$nac_v,'RL',0,'C'); 
	  $pdf->Cell(7,5,$nac_e,'RL',0,'C'); 
	  $pdf->Cell(40,5,$cedula,'RL',0,'C');
	  $pdf->Cell(46,5,'','RL',0,'C');
	  $pdf->Cell(50,5,$num_aseg,'RL',0,'C');
	  $pdf->Cell(50,5,$cod_suc,'RL',1,'C');
	  
	  $pdf->Cell(7,2,'','BRL',0,'C'); 
	  $pdf->Cell(7,2,'','BRL',0,'C'); 
	  $pdf->Cell(40,2,'','BRL',0,'C');
	  $pdf->Cell(46,2,'','BRL',0,'C');
	  $pdf->Cell(50,2,'','BRL',0,'C');
	  $pdf->Cell(50,2,'','BRL',1,'C');
	  $x1=$pdf->GetX();   $y1=$pdf->GetY();
	  
	  $pdf->SetFont('Arial','',5);
	  $pdf->SetXY($x+2,$y);	
	  $pdf->MultiCell(40,3,$texto,0);
	  
	  $pdf->SetFont('Arial','',7); 
	  $pdf->SetXY($x1,$y1);
	  $pdf->Ln(2);
	  $pdf->Cell(125,4,'6. APELLIDOS Y NOMBRES DEL TRABAJADOR',1,0,'C'); 
	  $pdf->Cell(36,4,'7. FECHA DE NACIMIENTO',1,0,'C');
	  $pdf->Cell(39,4,'8. CONDICION TRABAJADOR',1,1,'C');
	  
	  $pdf->SetFont('Arial','',5);
	  $pdf->Cell(125,3,'','RL',0,'C'); 
	  $pdf->Cell(12,3,'DIA','RL',0,'C'); 
	  $pdf->Cell(12,3,'MES','RL',0,'C'); 
	  $pdf->Cell(12,3,'AÑO','RL',0,'C');
	   
      $pdf->Cell(30,3,'PENSIONADO',0,0,'C');	  
	  $pdf->Cell(9,3,$cond_p,'R',1,'C'); 
	  
	  $pdf->SetFont('Arial','',7); 
	  $pdf->Cell(125,5,$nombre,'BRL',0,'C');
      $pdf->Cell(12,5,$dian,'BRL',0,'C');
      $pdf->Cell(12,5,$mesn,'BRL',0,'C');
      $pdf->Cell(12,5,$anon,'BRL',0,'C');
       $pdf->SetFont('Arial','',5);
      $pdf->Cell(30,5,'JUBILADO','B',0,'C');	  
	  $pdf->Cell(9,5,$cond_j,'BR',1,'C');
      $pdf->SetFont('Arial','',7);

      $pdf->Ln(2);
	  
	  $pdf->Cell(12,3,'9. SEXO',1,0,'C');
      $pdf->Cell(22,3,'10. ZURDO',1,0,'C');
      $pdf->SetFont('Arial','',6.3);	  
	  $pdf->Cell(30,3,'11. INGRESO A EMPRESA',1,0,'C'); 
	  $pdf->Cell(26,3,'12. SALARIO SEMANAL',1,0,'C'); 
	  $pdf->Cell(90,3,'13. OCUPACION U OFICIO',1,0,'C');
	  $pdf->SetFont('Arial','',6);
	  $pdf->Cell(20,3,'COD OCUPACION',1,1,'C'); 
	  $pdf->SetFont('Arial','',5);
	  $pdf->Cell(6,3,'M','RL',0,'C');
      $pdf->Cell(6,3,'F','RL',0,'C');
      $pdf->Cell(6,3,'SI','RL',0,'C');
      $pdf->Cell(6,3,'NO','RL',0,'C');
      $pdf->Cell(10,3,'CODIGO','RL',0,'C');
	  
	  $pdf->Cell(10,3,'DIA','RL',0,'C'); 
	  $pdf->Cell(10,3,'MES','RL',0,'C'); 
	  $pdf->Cell(10,3,'AÑO','RL',0,'C');
	  $pdf->Cell(26,3,'','RL',0,'C');
	  $pdf->Cell(90,3,'','RL',0,'C');
	  $pdf->Cell(20,3,'','RL',1,'C');
	  
	  $pdf->SetFont('Arial','',7);
	  
	  $pdf->Cell(6,5,$sexo_m,'BRL',0,'C'); 
	  $pdf->Cell(6,5,$sexo_f,'BRL',0,'C'); 
	  $pdf->Cell(6,5,$zurdo_s,'BRL',0,'C'); 
	  $pdf->Cell(6,5,$zurdo_n,'BRL',0,'C'); 
	  $pdf->Cell(10,5,$cod_z,'BRL',0,'C');
	  $pdf->Cell(10,5,$diai,'BRL',0,'C');
      $pdf->Cell(10,5,$mesi,'BRL',0,'C');
      $pdf->Cell(10,5,$anoi,'BRL',0,'C');
	  $pdf->Cell(26,5,$salario_sem,'BRL',0,'C');
	  $pdf->Cell(90,5,$ocupacion,'BRL',0,'C');
	  $pdf->Cell(20,5,$cod_ocupacion,'BRL',1,'C');
	  
	  $pdf->Ln(2);
	  $pdf->Cell(170,3,'14. DOMICILIO Y DIRECCION EXACTA DEL TRABAJADOR','TRL',0,'C'); 
	  $pdf->Cell(20,3,'COD. CENTRO','TRL',0,'C');
	  $pdf->Cell(10,3,'CN.CT.','TRL',1,'C');
      $pdf->Cell(170,3,'','BRL',0,'C'); 
	  $pdf->Cell(20,3,'ASISTENCIAL','BRL',0,'C');
	  $pdf->Cell(10,3,'','BRL',1,'C');	  
	  $pdf->Cell(170,5,$direccion,'BRL',0,'C');
      $pdf->Cell(20,5,$cod_cent,'BRL',0,'C');
	  $pdf->SetFont('Arial','B',10);
      $pdf->Cell(10,5,"3",'BRL',1,'C');
	  $pdf->SetFont('Arial','B',7);	  
	  $pdf->Cell(200,3,'D E C L A R A C I O N   D E   F A M I L I A R E S',1,1,'C');
	  $pdf->SetFont('Arial','',7);
	  
	  $pdf->Cell(18,3,'15. ','TRL',0,'C');
      $pdf->Cell(22,3,'16. CEDULA DE','TRL',0,'C');
	  $pdf->Cell(12,3,'17. ','TRL',0,'C');
	  $pdf->Cell(130,3,' ','TRL',0,'C');
	  $pdf->Cell(18,3,'19. FECHA DE','TRL',1,'C');
	  
	  $pdf->Cell(18,3,'PARENTESCO','RL',0,'C');
      $pdf->Cell(22,3,'IDENITDAD Nº','RL',0,'C');
	  $pdf->Cell(12,3,'SEXO','RL',0,'C');
	  $pdf->Cell(130,3,'18. APELLIDOS Y NOMBRES DEL FAMILIAR ','RL',0,'C');
	  $pdf->Cell(18,3,'NACIMIENTO','BRL',1,'C');
	  $pdf->SetFont('Arial','',5);
	  $pdf->Cell(18,2,'','BRL',0,'C');
	  $pdf->Cell(22,2,'','BRL',0,'C');	  
	  $pdf->Cell(6,2,'M',1,0,'C');
      $pdf->Cell(6,2,'F',1,0,'C');
      $pdf->Cell(130,2,'','BRL',0,'C');
      $pdf->Cell(6,2,'DIA','BRL',0,'C'); 
	  $pdf->Cell(6,2,'MES','BRL',0,'C'); 
	  $pdf->Cell(6,2,'AÑO','BRL',1,'C');
	  $pdf->SetFont('Arial','',7);
	  
	  $pdf->Cell(18,5,$parentescof1,1,0,'C');
	  $pdf->Cell(22,5,$cedulaf1,1,0,'C');	  
	  $pdf->Cell(6,5,$sexo_m1,1,0,'C');
      $pdf->Cell(6,5,$sexo_f1,1,0,'C');
      $pdf->Cell(130,5,$nombref1,1,0,'C');
      $pdf->Cell(6,5,$dia1,1,0,'C'); 
	  $pdf->Cell(6,5,$mes1,1,0,'C'); 
	  $pdf->Cell(6,5,$ano1,1,1,'C');
	  
	  $pdf->Cell(18,5,$parentescof2,1,0,'C');
	  $pdf->Cell(22,5,$cedulaf2,1,0,'C');	  
	  $pdf->Cell(6,5,$sexo_m2,1,0,'C');
      $pdf->Cell(6,5,$sexo_f2,1,0,'C');
      $pdf->Cell(130,5,$nombref2,1,0,'C');
      $pdf->Cell(6,5,$dia2,1,0,'C'); 
	  $pdf->Cell(6,5,$mes2,1,0,'C'); 
	  $pdf->Cell(6,5,$ano2,1,1,'C');
	  
	  $pdf->Cell(18,5,$parentescof3,1,0,'C');
	  $pdf->Cell(22,5,$cedulaf3,1,0,'C');	  
	  $pdf->Cell(6,5,$sexo_m3,1,0,'C');
      $pdf->Cell(6,5,$sexo_f3,1,0,'C');
      $pdf->Cell(130,5,$nombref3,1,0,'C');
      $pdf->Cell(6,5,$dia3,1,0,'C'); 
	  $pdf->Cell(6,5,$mes3,1,0,'C'); 
	  $pdf->Cell(6,5,$ano3,1,1,'C');
	  
	  $pdf->Cell(18,5,$parentescof4,1,0,'C');
	  $pdf->Cell(22,5,$cedulaf4,1,0,'C');	  
	  $pdf->Cell(6,5,$sexo_m4,1,0,'C');
      $pdf->Cell(6,5,$sexo_f4,1,0,'C');
      $pdf->Cell(130,5,$nombref4,1,0,'C');
      $pdf->Cell(6,5,$dia4,1,0,'C'); 
	  $pdf->Cell(6,5,$mes4,1,0,'C'); 
	  $pdf->Cell(6,5,$ano4,1,1,'C');
	  
	  
	  $pdf->Cell(18,5,$parentescof5,1,0,'C');
	  $pdf->Cell(22,5,$cedulaf5,1,0,'C');	  
	  $pdf->Cell(6,5,$sexo_m5,1,0,'C');
      $pdf->Cell(6,5,$sexo_f5,1,0,'C');
      $pdf->Cell(130,5,$nombref5,1,0,'C');
      $pdf->Cell(6,5,$dia5,1,0,'C'); 
	  $pdf->Cell(6,5,$mes5,1,0,'C'); 
	  $pdf->Cell(6,5,$ano5,1,1,'C');
	  
	  $pdf->Cell(18,5,$parentescof6,1,0,'C');
	  $pdf->Cell(22,5,$cedulaf6,1,0,'C');	  
      $pdf->Cell(6,5,$sexo_m6,1,0,'C');
      $pdf->Cell(6,5,$sexo_f6,1,0,'C');
      $pdf->Cell(130,5,$nombref6,1,0,'C');
      $pdf->Cell(6,5,$dia6,1,0,'C'); 
	  $pdf->Cell(6,5,$mes6,1,0,'C'); 
	  $pdf->Cell(6,5,$ano6,1,1,'C');
	   
	  $pdf->Ln(40); 
	  
	  $pdf->Cell(10,3,'',0,0,'C');
	  $pdf->Cell(70,3,'SELLO DE LA EMPRESA Y FIRMA DEL PATRONO','T',0,'C');
	  $pdf->Cell(20,3,'',0,0,'C');
      $pdf->Cell(70,3,'FIRMA DEL TRABAJADOR','T',1,'C');	  
	  $pdf->Ln(4);
	  
	  $pdf->SetFont('Arial','B',7);
	  $pdf->Cell(110,5,'20. RECIBIDO EN EL IVSS',1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'C');
	  $pdf->Cell(80,5,'21. ACTA DE FISCALIZACION',1,1,'C');
	  $pdf->SetFont('Arial','',7);
	  
	  $pdf->Cell(80,5,'','LR',0,'C');
	  $pdf->Cell(30,5,'FECHA',1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'C');
	  $pdf->Cell(15,5,'SIGLA',1,0,'C');
	  $pdf->Cell(15,5,'AÑO',1,0,'C');
	  $pdf->Cell(20,5,'NUMERO',1,0,'C');
	  $pdf->Cell(30,5,'FECHA',1,1,'C');
	  
	  $pdf->Cell(80,3,'','LR',0,'C');
	  $pdf->Cell(10,3,'D','LR',0,'C');
	  $pdf->Cell(10,3,'M','LR',0,'C');
	  $pdf->Cell(10,3,'A','LR',0,'C');
	  $pdf->Cell(10,3,'',0,0,'C');	  
	  $pdf->Cell(15,3,'','LR',0,'C');
	  $pdf->Cell(15,3,'','LR',0,'C');
	  $pdf->Cell(20,3,'','LR',0,'C');
	  $pdf->Cell(10,3,'D','LR',0,'C');
	  $pdf->Cell(10,3,'M','LR',0,'C');
	  $pdf->Cell(10,3,'A','LR',1,'C');
	  
	  $pdf->Cell(80,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'',0,0,'C');
	  $pdf->Cell(15,15,'','LR',0,'C');
	  $pdf->Cell(15,15,'','LR',0,'C');
	  $pdf->Cell(20,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',1,'C');
	  
	  
	  $pdf->Cell(80,3,'FIRMA Y SELLO','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'',0,0,'C');	  
	  $pdf->Cell(15,3,'','BLR',0,'C');
	  $pdf->Cell(15,3,'','BLR',0,'C');
	  $pdf->Cell(20,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',1,'C');
	  $pdf->SetFont('Arial','',5);
	  $pdf->Cell(180,3,'DOS/06.200',0,1,'R');
	  $pdf->SetFont('Arial','',7);
	  
	  $pdf->Cell(200,4,'Este Formulario está autorizado por el IVSS y válido únicamente para ser consignado en las oficinas administrativas',0,1,'C');
	  
	  
     $pdf->Output();  
}
?>