<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT"; error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){ $cod_bien_mue=""; } else{$cod_bien_mue=$_GET["Gcod_bien_mue"];} $sql="Select * from BIEN015 where cod_bien_mue='$cod_bien_mue' ";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$rif_emp=""; $nom_completo=""; $direccion="";
$sqle="Select * from SIA000 order by campo001"; $resultado=pg_query($sqle);$filas=pg_num_rows($resultado); if($filas>=1){  $registro=pg_fetch_array($resultado,0); $cod_emp=$registro["campo001"];
$direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$cod_bien_mue=""; $cod_clasificacion=""; $num_bien="";$denominacion=""; $cod_dependencia=""; $cod_empresa=""; $cod_direccion=""; $cod_departamento=""; $ced_responsable=""; $fecha_actualizacion=""; $denomina_tipo="";
$ced_responsable_uso="";$cod_metodo_rot="";$ced_rotulador=""; $fecha_rotulacion="";$direccion=""; $cod_region=""; $cod_entidad=""; $cod_municipio=""; $cod_ciudad=""; $cod_parroquia=""; $cod_postal="";$caracteristicas="";$marca="";  $modelo="";$color="";$matricula="";$serial1="";$serial2="";$tipo_clase="";$uso="";$dimension_tam="";$material="";$codigo_alterno="";$ano=""; $antiguedad="";$cod_contablea="";$cod_contabled="";$tipo_depreciacion="";$tasa_deprec=""; $vida_util=""; $valor_residual=""; $sit_contable="";$sit_legal=""; $edo_conservacion="";$ced_verificador=""; $fecha_verificacion=""; $tipo_incorporacion=""; $cod_imp_presup=""; $nom_imp_presup="";$des_imp_nopresup=""; $fecha_incorporacion=""; $valor_incorporacion="";$garantia="";$nro_oc=""; $fecha_oc=""; $nro_op=""; $fecha_op=""; $tipo_doc_cancela=""; $nro_doc_cancela=""; $fecha_doc_cancela="";$ced_rif_proveedor=""; $codigo_tipo_incorp=""; $nom_proveedor=""; $cod_presup_dep=""; $monto_depreciado=""; $nro_factura=""; $fecha_factura=""; $desincorporado=""; $fecha_desincorporado="";$des_desincorporado="";$bien_en_salida="";$status_bien_inm=""; $usuario_sia=""; $inf_usuario="";$accesorios="";  $descripcion_b="";  $denominacion_empresa=""; $denominacion_dependencia=""; $denominacion_dir="";$denominacion_dep="";  $nombre_res="";  $nombre_res_uso="";  $metodo_rotula="";  $nombre_res_rotu="";$nombre_region="";  $estado="";  $nombre_municipio=""; $nombre_ciudad="";  $nombre_parroquia=""; $tipo_situacion_cont="";  $tipo_situacion_legal=""; $edo_bien="";  $nombre_res_ver="";
$res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $cod_bien_mue=$registro["cod_bien_mue"];  $cod_clasificacion=$registro["cod_clasificacion"];  $num_bien=$registro["num_bien"];
  $denominacion=$registro["denominacion"];   $cod_dependencia=$registro["cod_dependencia"];   $cod_empresa=$registro["cod_empresa"]; 
  $cod_direccion=$registro["cod_direccion"];  $cod_departamento=$registro["cod_departamento"];   $ced_responsable=$registro["ced_responsable"];
  $fecha_actualizacion=$registro["fecha_actualizacion"];  if($fecha_actualizacion==""){$fecha_actualizacion="";}else{$fecha_actualizacion=formato_ddmmaaaa($fecha_actualizacion);}
  $ced_responsable_uso=$registro["ced_responsable_uso"];  $cod_metodo_rot=$registro["cod_metodo_rot"];  $ced_rotulador=$registro["ced_rotulador"];
  $fecha_rotulacion=$registro["fecha_rotulacion"];if($fecha_rotulacion==""){$fecha_rotulacion="";}else{$fecha_rotulacion=formato_ddmmaaaa($fecha_rotulacion);}
  $direccion=$registro["direccion"];   $cod_region=$registro["cod_region"];   $cod_entidad=$registro["cod_entidad"];
  $cod_municipio=$registro["cod_municipio"];   $cod_ciudad=$registro["cod_ciudad"];   $cod_parroquia=$registro["cod_parroquia"]; 
  $cod_postal=$registro["cod_postal"];  $caracteristicas=$registro["caracteristicas"];  $marca=$registro["marca"];
  $modelo=$registro["modelo"];  $color=$registro["color"];  $matricula=$registro["matricula"];
  $serial1=$registro["serial1"];  $serial2=$registro["serial2"];  $tipo_clase=$registro["tipo_clase"];
  $uso=$registro["uso"];  $dimension_tam=$registro["dimension_tam"];   $material=$registro["material"]; 
  $codigo_alterno=$registro["codigo_alterno"];   $ano=$registro["ano"];   $antiguedad=$registro["antiguedad"]; 
  $cod_contablea=$registro["cod_contablea"];   $cod_contabled=$registro["cod_contabled"];   $tipo_depreciacion=$registro["tipo_depreciacion"]; 
  $tasa_deprec=$registro["tasa_deprec"];   $vida_util=$registro["vida_util"];  $valor_residual=$registro["valor_residual"]; 
  $sit_contable=$registro["sit_contable"];   $sit_legal=$registro["sit_legal"];  $edo_conservacion=$registro["edo_conservacion"];
  $ced_verificador=$registro["ced_verificador"];   $fecha_verificacion=$registro["fecha_verificacion"];
  if($fecha_verificacion==""){$fecha_verificacion="";}else{$fecha_verificacion=formato_ddmmaaaa($fecha_verificacion);}
  $tipo_incorporacion=$registro["tipo_incorporacion"];   $cod_imp_presup=$registro["cod_imp_presup"]; 
  $nom_imp_presup=$registro["nom_imp_presup"];  $des_imp_nopresup=$registro["des_imp_nopresup"];   
  $fecha_incorporacion=$registro["fecha_incorporacion"]; if($fecha_incorporacion==""){$fecha_incorporacion="";}else{$fecha_incorporacion=formato_ddmmaaaa($fecha_incorporacion);}
  $valor_incorporacion=$registro["valor_incorporacion"];  $garantia=$registro["garantia"];  $nro_oc=$registro["nro_oc"]; $nro_op=$registro["nro_op"]; 
  $fecha_oc=$registro["fecha_oc"]; if($fecha_oc==""){$fecha_oc="";}else{$fecha_oc=formato_ddmmaaaa($fecha_oc);}    
  $fecha_op=$registro["fecha_op"]; if($fecha_op==""){$fecha_op="";}else{$fecha_op=formato_ddmmaaaa($fecha_op);}
  $tipo_doc_cancela=$registro["tipo_doc_cancela"];  $nro_doc_cancela=$registro["nro_doc_cancela"]; 
  $fecha_doc_cancela=$registro["fecha_doc_cancela"];if($fecha_doc_cancela==""){$fecha_doc_cancela="";}else{$fecha_doc_cancela=formato_ddmmaaaa($fecha_doc_cancela);} 
  $ced_rif_proveedor=$registro["ced_rif_proveedor"];  $codigo_tipo_incorp=$registro["codigo_tipo_incorp"];  $nom_proveedor=$registro["nom_proveedor"]; 
  $cod_presup_dep=$registro["cod_presup_dep"];  $monto_depreciado=$registro["monto_depreciado"];   $nro_factura=$registro["nro_factura"]; 
  $fecha_factura=$registro["fecha_factura"]; if($fecha_factura==""){$fecha_factura="";}else{$fecha_factura=formato_ddmmaaaa($fecha_factura);}
  $des_desincorporado=$registro["des_desincorporado"]; $desincorporado=$registro["desincorporado"];   
  $fecha_desincorporado=$registro["fecha_desincorporado"];if($fecha_desincorporado==""){$fecha_desincorporado="";}else{$fecha_desincorporado=formato_ddmmaaaa($fecha_desincorporado);}
  $bien_en_salida=$registro["bien_en_salida"]; $accesorios=$registro["accesorios"];
}
//Clasificacion
$Ssql="SELECT grupo_c,codigo_c,denominacion_c  FROM BIEN008 where codigo_c='".$cod_clasificacion."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $descripcion_b=$registro["denominacion_c"];}
//Empresa
$Ssql="SELECT * FROM bien007 where cod_empresa='".$cod_empresa."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){  $registro=pg_fetch_array($resultado,0); $denominacion_empresa=$registro["denominacion_emp"];}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dependencia=$registro["denominacion_dep"];}
//Direcciones
$Ssql="SELECT * FROM bien005 where cod_dependencia='".$cod_dependencia."' and cod_direccion='".$cod_direccion."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dir=$registro["denominacion_dir"];}
//Departamento
$Ssql="SELECT * FROM bien006 where cod_dependencia='".$cod_dependencia."' and cod_direccion='".$cod_direccion."' and cod_departamento='".$cod_departamento."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dep=$registro["denominacion_dep"];}
//Responsable Primario
$Ssql="SELECT * FROM bien002 where ced_responsable='".$ced_responsable."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_res=$registro["nombre_res"];}
//Responsable Uso
$Ssql="SELECT * FROM bien031 where ced_res_uso='".$ced_responsable_uso."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_res_uso=$registro["nombre_res_uso"];}
//Metodo Rotulacion
$Ssql="SELECT * FROM bien012 where codigo='".$cod_metodo_rot."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $metodo_rotula=$registro["metodo_rotula"];}
//Rotuladores
$Ssql="SELECT * FROM bien032 where ced_res_rotu='".$ced_rotulador."'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_res_rotu=$registro["nombre_res_rotu"];}
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
	function Header(){global $cod_bien_mue; global $denominacion;	 global $nom_completo;    
        //$this->rect(10,5,200,185);		
		$this->Image('../../imagenes/logo escudo.png',12,8,18);
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(100,3,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,0,'L');
		$this->Cell(75,3,'',0,1,'R');
		$this->Cell(25);
		$this->Cell(100,3,$nom_completo,0,1,'L');
		$this->Ln(5);
		$this->SetFont('Arial','B',12);
		$this->Cell(200,4,'REGISTRO DE BIENES MUEBLES',0,1,'C');
		$this->Ln(4);	
        $x=$this->GetX();   $y=$this->GetY();
		$this->SetFont('Arial','',7);
		$this->Cell(200,5,'CODIGO DEL BIEN: '.$cod_bien_mue." - ".$denominacion,1,1,'L');
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
  
  $pdf->Cell(135,5,"DEPENDENCIA: ".$cod_dependencia." ".$denominacion_dependencia,1,0,'L');	
  $pdf->Cell(65,5," FECHA ULTIMA ACTUALIZACION: ".$fecha_actualizacion,1,1,'R');  
  
  $pdf->Cell(200,5,"RESPONSABLE: ".$ced_responsable." ".$nombre_res,1,1,'L');
  
  $pdf->Cell(200,5,"RESPONSABLE DE USO: ".$ced_responsable_uso." ".$nombre_res_uso,1,1,'L');
  
  $pdf->Cell(65,5," Metodo de Rotulación ",'LTRB',0,'L');	
  $pdf->Cell(35,5," Fecha ",'LTRB',0,'C');  
  $pdf->Cell(35,5," Cédula ",'LTRB',0,'C');
  $pdf->Cell(65,5," Nombre del Rotulador ",'LTRB',1,'L');	
  $pdf->Cell(65,5,$metodo_rotula,'LTRB',0,'L');	
  $pdf->Cell(35,5,$fecha_rotulacion,'LTRB',0,'C');  
  $pdf->Cell(35,5,$ced_rotulador,'LTRB',0,'C');
  $pdf->Cell(65,5,$nombre_res_rotu,'LTRB',1,'L');
  
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
  
  $pdf->MultiCell(200,5,"Caracteristicas: ".$caracteristicas,1,'L');
  
  $pdf->Cell(65,5," Marca ",'LTRB',0,'C');	
  $pdf->Cell(65,5," Modelo ",'LTRB',0,'C');  
  $pdf->Cell(35,5," Color ",'LTRB',0,'C');
  $pdf->Cell(35,5," Matricula ",'LTRB',1,'L');	
  $pdf->Cell(65,5,$marca,'LTRB',0,'L');	
  $pdf->Cell(35,5,$modelo,'LTRB',0,'C');  
  $pdf->Cell(35,5,$color,'LTRB',0,'C');
  $pdf->Cell(65,5,$matricula,'LTRB',1,'L');
  
  $pdf->Cell(32,5," Serial ",'LTRB',0,'C');	
  $pdf->Cell(32,5," Serial 2 ",'LTRB',0,'C');  
  $pdf->Cell(32,5," Tipo ",'LTRB',0,'C');
  $pdf->Cell(32,5," Uso ",'LTRB',0,'C');
  $pdf->Cell(32,5," Tamaño ",'LTRB',0,'C');
  $pdf->Cell(40,5," Antiguedad ",'LTRB',1,'C');
  $pdf->Cell(32,5,$serial1,'LTRB',0,'C');	
  $pdf->Cell(32,5,$serial2,'LTRB',0,'C');  
  $pdf->Cell(32,5,$tipo_clase,'LTRB',0,'C');
  $pdf->Cell(32,5,$uso,'LTRB',0,'C');
  $pdf->Cell(32,5,$dimension_tam,'LTRB',0,'C');
  $pdf->Cell(40,5,$antiguedad,'LTRB',1,'C');
  
  $pdf->MultiCell(200,5,"Accesorios: ".$accesorios,1,'L');
  
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
  $pdf->Cell(20,5,$nro_oc,'LTRB',0,'L');	
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

  $pdf->SetFillColor(192,192,192);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(200,4,'REPARACIONES Y MEJORAS',1,1,'C',true);	
  $pdf->SetFont('Arial','B',7);
  $pdf->Cell(30,4,'Codigo de','LRT',0,'C',true);	
  $pdf->Cell(130,4,'','LRT',0,'C',true);	
  $pdf->Cell(20,4,'Valor de la','LRT',0,'C',true);	
  $pdf->Cell(20,4,'Fecha de la','LRT',1,'C',true);	
  
  $pdf->Cell(30,4,'Activo Asociado','LRB',0,'C',true);	
  $pdf->Cell(130,4,'Desccripcion','LRB',0,'C',true);	
  $pdf->Cell(20,4,'Reparacion','LRB',0,'C',true);	
  $pdf->Cell(20,4,'Reparacion','LRB',1,'C',true);	
  $pdf->SetFont('Arial','',7);
  $sql="SELECT bien058.cod_bien_mue,bien058.cod_bien_aso,bien058.fecha_rep,bien058.valor_rep,bien058.campo_str1,bien058.campo_str2,bien058.monto1,bien058.monto2,bien015.denominacion  FROM bien058 left join bien015 on (bien015.cod_bien_mue=bien058.cod_bien_aso) where bien058.cod_bien_mue='$cod_bien_mue' order by bien058.cod_bien_aso";  $resultado=pg_query($sql);
  $total_rep=0; $filas=pg_num_rows($resultado); 
  while($registro=pg_fetch_array($resultado)){ $total_rep=$total_rep+$registro["valor_rep"];  $fecha_rep=$registro["fecha_rep"]; $fecha_rep=formato_ddmmaaaa($fecha_rep); $valor_rep=$registro["valor_rep"]; $valor_rep=formato_monto($valor_rep);
	$denom=$registro["denominacion"]; $denom=substr($denom,0,100);
	$pdf->Cell(30,4,$registro["cod_bien_aso"],1,0,'L');	
    $pdf->Cell(130,4,$denom,1,0,'L');	
    $pdf->Cell(20,4,$valor_rep,1,0,'R');	
    $pdf->Cell(20,4, $fecha_rep,1,1,'C');		 
  }
 
 $pdf->Output();

 
pg_close();
?>