<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT"; error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){ $cod_bien_inm=""; } else{$cod_bien_inm=$_GET["Gcod_bien_inm"];} $sql="Select * from BIEN014 where cod_bien_inm='$cod_bien_inm' ";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$rif_emp=""; $nom_completo=""; $direccion=""; $sqle="Select * from SIA000 order by campo001"; $resultado=pg_query($sqle);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];
$direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$cod_bien_inm=""; $cod_clasificacion=""; $num_bien="";$denominacion=""; $cod_dependencia=""; $cod_empresa=""; $cod_direccion=""; $cod_departamento=""; $ced_responsable=""; $fecha_actualizacion=""; $denomina_tipo="";
$ced_responsable_uso="";$cod_metodo_rot="";$ced_rotulador=""; $fecha_rotulacion="";$direccion=""; $cod_region=""; $cod_entidad=""; $cod_municipio=""; $cod_ciudad=""; $cod_parroquia=""; $cod_postal="";$caracteristicas="";$marca="";  $modelo="";$color="";$matricula="";$serial1="";$serial2="";$tipo_clase="";$uso="";$dimension_tam="";$material="";$codigo_alterno="";$ano=""; $antiguedad="";$cod_contablea="";$cod_contabled="";$tipo_depreciacion="";$tasa_deprec=""; $vida_util=""; $valor_residual=""; $sit_contable="";$sit_legal=""; $edo_conservacion="";$ced_verificador=""; $fecha_verificacion=""; $tipo_incorporacion=""; $cod_imp_presup=""; $nom_imp_presup="";$des_imp_nopresup=""; $fecha_incorporacion=""; $valor_incorporacion="";$garantia="";$nro_oc=""; $fecha_oc=""; $nro_op=""; $fecha_op=""; $tipo_doc_cancela=""; $nro_doc_cancela=""; $fecha_doc_cancela="";$ced_rif_proveedor=""; $codigo_tipo_incorp=""; $nom_proveedor=""; $cod_presup_dep=""; $monto_depreciado=""; $nro_factura=""; $fecha_factura=""; $desincorporado=""; $fecha_desincorporado="";$des_desincorporado="";$bien_en_salida="";$status_bien_inm=""; $usuario_sia=""; $inf_usuario="";$accesorios="";  $descripcion_b="";  $denominacion_empresa=""; $denominacion_dependencia=""; $denominacion_dir="";$denominacion_dep="";  $nombre_res="";  $nombre_res_uso="";  $metodo_rotula="";  $nombre_res_rotu="";$nombre_region="";  $estado="";  $nombre_municipio=""; $nombre_ciudad="";  $nombre_parroquia=""; $tipo_situacion_cont="";  $tipo_situacion_legal=""; $edo_bien="";  $nombre_res_ver="";
$res=pg_query($sql); $filas=pg_num_rows($res); //echo $sql;
if($filas>=1){  $registro=pg_fetch_array($res,0);
	$cod_bien_inm=$registro["cod_bien_inm"];$cod_clasificacion=$registro["cod_clasificacion"];$num_bien=$registro["num_bien"];
	$denominacion=$registro["denominacion"];$cod_dependencia=$registro["cod_dependencia"];$cod_empresa=$registro["cod_empresa"];
	$cod_direccion=$registro["cod_direccion"];$cod_departamento=$registro["cod_departamento"];$descripcion=$registro["descripcion"];
	$area_inmueble=$registro["area_inmueble"];$area_terreno=$registro["area_terreno"];$area_construccion=$registro["area_construccion"];
	$caracteristicas=$registro["caracteristicas"];$ced_responsable=$registro["ced_responsable"];$fecha_actualizacion=$registro["fecha_actualizacion"];
	$direccion=$registro["direccion"];$cod_region=$registro["cod_region"];$cod_entidad=$registro["cod_entidad"];
	$cod_municipio=$registro["cod_municipio"];$cod_ciudad=$registro["cod_ciudad"];$cod_parroquia=$registro["cod_parroquia"];
	$cod_postal=$registro["cod_postal"];$tiene_planos=$registro["tiene_planos"];$lindero_norte=$registro["lindero_norte"];
	$lindero_sur=$registro["lindero_sur"];$lindero_este=$registro["lindero_este"];$lindero_oeste=$registro["lindero_oeste"];
	$observacion=$registro["observacion"];$ofic_registro=$registro["ofic_registro"];$numero=$registro["numero"];
	$tomo=$registro["tomo"];$folio=$registro["folio"];$protocolo=$registro["protocolo"];$fecha_doc=$registro["fecha_doc"];
	$sit_legal=$registro["sit_legal"];$estudio_legal=$registro["estudio_legal"];$cod_contablea=$registro["cod_contablea"];$cod_contabled=$registro["cod_contabled"];
	$tipo_depreciacion=$registro["tipo_depreciacion"];$tasa_deprec=$registro["tasa_deprec"];$vida_util=$registro["vida_util"];
	$valor_residual=$registro["valor_residual"];$cod_presup_dep=$registro["cod_presup_dep"];$monto_depreciado=$registro["monto_depreciado"];
	$desincorporado=$registro["desincorporado"];$sit_contable=$registro["sit_contable"];
	$edo_conservacion=$registro["edo_conservacion"];$ced_verificador=$registro["ced_verificador"];$fecha_verificacion=$registro["fecha_verificacion"];
	$codigo_tipo_incorp=$registro["codigo_tipo_incorp"];$tipo_incorporacion=$registro["tipo_incorporacion"];$cod_imp_presup=$registro["cod_imp_presup"];
	$nom_imp_presup=$registro["nom_imp_presup"];$des_imp_nopresup=$registro["des_imp_nopresup"];$valor_incorporacion=$registro["valor_incorporacion"];
	$fecha_incorporacion=$registro["fecha_incorporacion"]; if($fecha_incorporacion==""){$fecha_incorporacion="";}else{$fecha_incorporacion=formato_ddmmaaaa($fecha_incorporacion);}
	$nro_oc=$registro["nro_oc"];$fecha_oc=$registro["fecha_oc"]; if($fecha_oc==""){$fecha_oc="";}else{$fecha_oc=formato_ddmmaaaa($fecha_oc);}   
	$nro_op=$registro["nro_op"];$fecha_op=$registro["fecha_op"]; if($fecha_op==""){$fecha_op="";}else{$fecha_op=formato_ddmmaaaa($fecha_op);}
	$fecha_desincorporado=$registro["fecha_desincorporado"];if($fecha_desincorporado==""){$fecha_desincorporado="";}else{$fecha_desincorporado=formato_ddmmaaaa($fecha_desincorporado);}
	$tipo_doc_cancela=$registro["tipo_doc_cancela"];$nro_doc_cancela=$registro["nro_doc_cancela"];$fecha_doc_cancela=$registro["fecha_doc_cancela"]; if($fecha_factura==""){$fecha_factura="";}else{$fecha_factura=formato_ddmmaaaa($fecha_factura);}
	$nro_factura=$registro["nro_factura"];$fecha_factura=$registro["fecha_factura"];if($fecha_factura==""){$fecha_factura="";}else{$fecha_factura=formato_ddmmaaaa($fecha_factura);}
	$ced_rif_proveedor=$registro["ced_rif_proveedor"];$nom_proveedor=$registro["nom_proveedor"]; $fecha_op=$registro["fecha_op"];
}
if($fecha_actualizacion==""){$fecha_actualizacion="";}else{$fecha_actualizacion=formato_ddmmaaaa($fecha_actualizacion);}
if($fecha_doc==""){$fecha_doc="";}else{$fecha_doc=formato_ddmmaaaa($fecha_doc);}
if($fecha_verificacion==""){$fecha_verificacion="";}else{$fecha_verificacion=formato_ddmmaaaa($fecha_verificacion);}
if($fecha_op==""){$fecha_op="";}else{$fecha_op=formato_ddmmaaaa($fecha_op);}
if($fecha_doc_cancela==""){$fecha_doc_cancela="";}else{$fecha_doc_cancela=formato_ddmmaaaa($fecha_doc_cancela);} 
//Clasificacion
$Ssql="SELECT grupo_c,codigo_c,denominacion_c  FROM BIEN008 where codigo_c='".$cod_clasificacion."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $descripcion_b=$registro["denominacion_c"];}
//Empresa
$Ssql="SELECT * FROM bien007 where cod_empresa='".$cod_empresa."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_empresa=$registro["denominacion_emp"];}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dependencia=$registro["denominacion_dep"];}
//Direcciones
$Ssql="SELECT * FROM bien005 where cod_dependencia='".$cod_dependencia."' and cod_direccion='".$cod_direccion."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dir=$registro["denominacion_dir"];}
//Departamento
$Ssql="SELECT * FROM bien006 where cod_dependencia='".$cod_dependencia."' and cod_direccion='".$cod_direccion."' and cod_departamento='".$cod_departamento."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dep=$registro["denominacion_dep"];}
//Responsable Primario
$Ssql="SELECT * FROM bien002 where ced_responsable='".$ced_responsable."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_res=$registro["nombre_res"];}
//Regiones
$Ssql="SELECT * FROM pre092 where cod_region='".$cod_region."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_region=$registro["nombre_region"];}
//Entidad Federal
$Ssql="SELECT * FROM pre091 where cod_estado='".$cod_entidad."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $estado=$registro["estado"];}
//Municipios
$Ssql="SELECT * FROM pre093 where cod_municipio='".$cod_municipio."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_municipio=$registro["nombre_municipio"];}
//Ciudad
$Ssql="SELECT * FROM pre094 where cod_ciudad='".$cod_ciudad."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_ciudad=$registro["nombre_ciudad"];}
//Parroquia
$Ssql="SELECT * FROM pre096 where cod_parroquia='".$cod_parroquia."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_parroquia=$registro["nombre_parroquia"];}

//Situacion Contable
$Ssql="SELECT * FROM bien010 where codigo='".$sit_contable."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);   $tipo_situacion_cont=$registro["tipo_situacion"]; }

//Situacion Legal
$Ssql="SELECT * FROM bien009 where codigo='".$sit_legal."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $tipo_situacion_legal=$registro["tipo_situacion"];}
//Estado Conservacion
$Ssql="SELECT * FROM bien004 where codigo='".$edo_conservacion."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $edo_bien=$registro["edo_bien"];}
//Verificador Responsable
$Ssql="SELECT * FROM bien030 where ced_res_verificador='".$ced_verificador."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_res_ver=$registro["nombre_res_ver"];}
//tIPO DE INCORPORACION
$Ssql="SELECT * FROM bien003 where codigo='".$codigo_tipo_incorp."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denomina_tipo=$registro["denomina_tipo"];}

$valor_incorporacion=formato_monto($valor_incorporacion); 
if($desincorporado=="S"){$desincorporado="SI";}else{$desincorporado="NO";}


require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $cod_bien_inm; global $denominacion; global $nom_completo;
	    
        $this->rect(10,5,200,185);		
		$this->Image('../../imagenes/logo escudo.png',12,8,18);
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(100,3,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,0,'L');
		$this->Cell(75,3,'',0,1,'R');
		$this->Cell(25);
		$this->Cell(100,3,$nom_completo,0,1,'L');
		$this->Ln(5);
		$this->SetFont('Arial','B',12);
		$this->Cell(200,3,'REGISTRO DE BIENES INMUEBLES',0,1,'C');
		$this->Ln(5);	
        $x=$this->GetX();   $y=$this->GetY();
		$this->SetFont('Arial','',7);
		$this->Cell(200,5,'CODIGO DEL BIEN: '.$cod_bien_inm." - ".$denominacion,'T',1,'L');
	}
	
	function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		$this->SetY(-45);
		$this->SetFont('Arial','I',5);
		//$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
		$this->Cell(200,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'L');
	}
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 45);  
  
  $pdf->Cell(135,5,"DEPENDENCIA: ".$cod_dependencia." ".$denominacion_dependencia,'T',0,'L');	
  $pdf->Cell(65,5," FECHA ULTIMA ACTUALIZACION: ".$fecha_actualizacion,'T',1,'R');  
  
  $pdf->Cell(200,5,"RESPONSABLE: ".$ced_responsable." ".$nombre_res,'',1,'L');
  
   $pdf->MultiCell(200,5,"DESCRIPCION: ".$descripcion,1,'L');
   
   $pdf->MultiCell(200,5,"Caracteristicas: ".$caracteristicas,1,'L');
  
  $pdf->MultiCell(200,5,"Dirección: ".$direccion,1,'L');
  
  $pdf->Cell(40,5," Región ",'LTRB',0,'C');	
  $pdf->Cell(40,5," Estado ",'LTRB',0,'C');  
  $pdf->Cell(40,5," Municipio ",'LTRB',0,'C');
  $pdf->Cell(40,5," Ciudad ",'LTRB',0,'C');
  $pdf->Cell(40,5," Cod.Postal ",'LTRB',1,'C');
  $pdf->Cell(40,5,$nombre_region,'LTRB',0,'C');	
  $pdf->Cell(40,5,$estado,'LTRB',0,'C');  
  $pdf->Cell(40,5,$nombre_municipio,'LTRB',0,'C');
  $pdf->Cell(40,5,$nombre_ciudad,'LTRB',0,'C');
  $pdf->Cell(40,5,$cod_postal,'LTRB',1,'C');
  
  $pdf->MultiCell(200,5,"Lindero Norte: ".$lindero_norte,1,'L');
  $pdf->MultiCell(200,5,"Lindero Sur: ".$lindero_sur,1,'L');
  $pdf->MultiCell(200,5,"Lindero Este: ".$lindero_este,1,'L');
  $pdf->MultiCell(200,5,"Lindero Oeste: ".$lindero_oeste,1,'L');
  
  
  $pdf->Cell(35,5," Cuenta de Activo ",'LTRB',0,'L');	
  $pdf->Cell(35,5," Cuenta de Depreciación ",'LTRB',0,'L');  
  $pdf->Cell(32,5," Tipo de Depreciación ",'LTRB',0,'L');
  $pdf->Cell(20,5," Tasa ",'LTRB',0,'L');
  $pdf->Cell(25,5," Vida Util ",'LTRB',0,'C');
  $pdf->Cell(25,5," Valor Residual ",'LTRB',0,'C');
  $pdf->Cell(28,5," Monto Depreciado ",'LTRB',1,'C');
  $pdf->Cell(35,5,$cod_contablea,'LTRB',0,'C');	
  $pdf->Cell(35,5,$cod_contabled,'LTRB',0,'C');  
  $pdf->Cell(32,5,$tipo_depreciacion,'LTRB',0,'C');
  $pdf->Cell(20,5,$tasa_deprec,'LTRB',0,'C');
  $pdf->Cell(25,5,$vida_util,'LTRB',0,'C');
  $pdf->Cell(25,5,$valor_residual,'LTRB',0,'C');
  $pdf->Cell(28,5,$monto_depreciado,'LTRB',1,'C');
  
  $pdf->Cell(200,8,"Código Presupuestario para Depreciación: ".$cod_presup_dep,1,1,'L');
  
  $pdf->Cell(200,8,"Situación Contable: ".$sit_contable." - ".$tipo_situacion_cont,1,1,'L');
  
  $pdf->Cell(200,8,"Situación Legal: ".$sit_legal." - ".$tipo_situacion_legal,1,1,'L');
  
  $pdf->Cell(200,8,"Estado de Conservación: ".$edo_conservacion." - ".$edo_bien,1,1,'L');
  
  $pdf->Cell(35,5," Verificador ",'LTRB',0,'L');	
  $pdf->Cell(135,5," Nombre ",'LTRB',0,'C');  
  $pdf->Cell(30,5,"  Fecha Verificación ",'LTRB',1,'L');	
  $pdf->Cell(35,5,$ced_verificador,'LTRB',0,'L');	
  $pdf->Cell(135,5,$nombre_res_ver,'LTRB',0,'C');  
  $pdf->Cell(30,5,$fecha_verificacion,'LTRB',1,'L');
  
  $pdf->Cell(40,5," Tipo Incorporación ",'LTRB',0,'L');	
  $pdf->Cell(90,5," Descripción ",'LTRB',0,'L');  
  $pdf->Cell(30,5," Fecha ",'LTRB',0,'L');
  $pdf->Cell(40,5," Valor de Incorporación ",'LTRB',1,'L');	
  $pdf->Cell(40,5,$codigo_tipo_incorp,'LTRB',0,'L');	
  $pdf->Cell(90,5,$denomina_tipo,'LTRB',0,'L');  
  $pdf->Cell(30,5,$fecha_incorporacion,'LTRB',0,'L');
  $pdf->Cell(40,5,$valor_incorporacion,'LTRB',1,'L');
  
  $pdf->Cell(20,5," Orden Compra ",'LTRB',0,'L');	
  $pdf->Cell(20,5," Fecha ",'LTRB',0,'L');  
  $pdf->Cell(20,5," Orden Pago ",'LTRB',0,'L');
  $pdf->Cell(20,5," Fecha ",'LTRB',0,'L');	
  $pdf->Cell(30,5," Tipo de Documento Pago ",'LTRB',0,'L');  
  $pdf->Cell(30,5," Documento Pago ",'LTRB',0,'L');
  $pdf->Cell(20,5," Fecha ",'LTRB',0,'L');  
  $pdf->Cell(20,5," Factura ",'LTRB',0,'L');
  $pdf->Cell(20,5," Fecha ",'LTRB',1,'L');	  
  $pdf->Cell(20,5,$nro_oc=$registro,'LTRB',0,'L');	
  $pdf->Cell(20,5,$fecha_oc,'LTRB',0,'L');  
  $pdf->Cell(20,5,$nro_op,'LTRB',0,'L');
  $pdf->Cell(20,5,$fecha_op,'LTRB',0,'L');	
  $pdf->Cell(30,5,$tipo_doc_cancela,'LTRB',0,'L');  
  $pdf->Cell(30,5,$nro_doc_cancela,'LTRB',0,'L');
  $pdf->Cell(20,5,$fecha_doc_cancela,'LTRB',0,'L');  
  $pdf->Cell(20,5,$nro_factura,'LTRB',0,'L');
  $pdf->Cell(20,5,$fecha_factura,'LTRB',1,'L');
  
  $pdf->Cell(35,5," C.I./Rif Proveed. ",'LTRB',0,'L');	
  $pdf->Cell(165,5," Nombre ",'LTRB',1,'L');  
  $pdf->Cell(35,5,$ced_rif_proveedor,'LTRB',0,'L');	
  $pdf->Cell(165,5,$nom_proveedor,'LTRB',1,'L');  

 
 $pdf->Output();

 
pg_close();
?>