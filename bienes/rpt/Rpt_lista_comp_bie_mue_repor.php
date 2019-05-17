<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_bien_mued=$_GET["cod_bien_mued"];$cod_bien_mueh=$_GET["cod_bien_mueh"];$cod_empresad=$_GET["cod_empresad"];$cod_empresah=$_GET["cod_empresah"];
$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; $cod_direcciond=$_GET["cod_direcciond"]; $cod_direccionh=$_GET["cod_direccionh"];
$cod_departamentod=$_GET["cod_departamentod"]; $cod_departamentoh=$_GET["cod_departamentoh"]; $tipo_regis=$_GET["tipo_regis"]; $denominacion=$_GET["denominacion"]; $tipo_rep=$_GET["tipo_rep"];
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $date = date("d-m-Y");$hora = date("H:i:s a");$Sql=""; $php_os=PHP_OS; 
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}   $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}   $fecha_hasta=$ano1.$mes1.$dia1;
$cod_mov="bien015001".$usuario_sia;   
$criterio=" (bien015.cod_bien_mue>='$cod_bien_mued' and bien015.cod_bien_mue<='$cod_bien_mueh') and (bien015.cod_empresa>='$cod_empresad' and bien015.cod_empresa<='$cod_empresah') AND 
  (bien015.cod_dependencia>='$cod_dependenciad' and bien015.cod_dependencia<='$cod_dependenciah') and (bien015.cod_direccion>='$cod_direcciond' and bien015.cod_direccion<='$cod_direccionh') AND
  (bien015.cod_departamento>='$cod_departamentod' and bien015.cod_departamento<='$cod_departamentoh') and (bien015.fecha_incorporacion>='$fecha_desde' and bien015.fecha_incorporacion<='$fecha_hasta')";
if($denominacion<>""){ $criterio=$criterio." and (bien015.denominacion Like '%".$denominacion."%')"; } 
$mordenado=" order by bien015.cod_clasificacion,bien015.cod_bien_mue,bien015.fecha_incorporacion,bien015.valor_incorporacion";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else { $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }     
     $sSQL = "SELECT bien015.cod_bien_mue, bien015.cod_clasificacion, bien015.num_bien, bien015.denominacion, bien015.cod_dependencia, bien015.cod_direccion, bien015.cod_departamento, 
	          bien015.Caracteristicas, bien015.Marca, bien015.Modelo, bien015.Color, bien015.Matricula, bien015.Serial1, bien015.Serial2, bien015.Tipo_Clase, bien015.Uso, bien015.Dimension_Tam, bien015.Antiguedad, 
			  bien015.Valor_Incorporacion, to_char(bien015.fecha_incorporacion,'DD/MM/YYYY') as fechai, bien015.tipo_incorporacion, bien015.cod_ContableA, bien015.cod_ContableD, bien015.cod_Imp_Presup, 
			  bien015.cod_Presup_Dep, bien001.denominacion_dep, bien008.denominacion_C, bien005.denominacion_dir, bien006.denominacion_dep as denom_departamento,
			  bien053.cod_componente, bien053.des_componente, bien053.Marca as marca_comp, bien053.Modelo as modelo_comp, bien053.Serial1 as serial_comp
              FROM bien001,bien008,bien053,((bien015  LEFT JOIN bien005 ON (bien005.cod_dependencia=bien015.cod_dependencia and bien005.cod_direccion=bien015.cod_direccion)) LEFT JOIN bien006 ON (bien006.cod_departamento=bien015.cod_departamento and bien006.cod_dependencia=bien015.cod_dependencia and bien006.cod_direccion=bien015.cod_direccion)) 
			  where  (bien001.cod_dependencia= bien015.cod_dependencia) and (bien053.cod_bien_mue= bien015.cod_bien_mue) and (bien008.Codigo_C=bien015.cod_clasificacion) and ".$criterio.$mordenado;

	if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $cod_grupo="";
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $criterio2; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,'LISTADO COMPONENTES DE BIENES MUEBLES',1,0,'C');
				$this->Ln(20);				
			    $this->SetFont('Arial','B',6);
				$this->Cell(25,5,'CODIGO DEL BIEN',1,0);						
				$this->Cell(120,5,'DENOMINACION',1,0,'L');
				$this->Cell(25,5,'MARCA',1,0);	
				$this->Cell(25,5,'MODELO',1,0);	
				$this->Cell(30,5,'SERIAL',1,0);	
				$this->Cell(15,5,'FECHA INC.',1,0,'L');
				$this->Cell(20,5,'VALOR INCORP.',1,1,'L');				
		    } 
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totalg=0; $subtotal=0;  $prev_cod_clasificacion=""; $c=0; $prev_cod="";
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_mue=$registro["cod_bien_mue"];  
		    if($php_os=="WINNT"){$denominacion_c=$denominacion_c; }else{$denominacion_c=utf8_decode($denominacion_c); }			
			$pdf->SetFont('Arial','',7);
			$cod_bien_mue=$registro["cod_bien_mue"]; $denominacion=$registro["denominacion"]; $fechai=$registro["fechai"]; $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"]; 
			$marca=$registro["marca"]; $modelo=$registro["modelo"]; $serial1=$registro["serial1"];  $marca=substr($marca,0,15); $modelo=substr($modelo,0,15); $serial1=substr($serial1,0,20);
			$valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			$cod_componente=$registro["cod_componente"]; $des_componente=$registro["des_componente"]; $marca_comp=$registro["marca_comp"]; $modelo_comp=$registro["modelo_comp"]; $serial_comp=$registro["serial_comp"]; 
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento); $marca=utf8_decode($marca); $modelo=utf8_decode($modelo); $serial1=utf8_decode($serial1); }
			$monto=formato_monto($valor_incorporacion); $totalg=$totalg+$valor_incorporacion; $subtotal=$subtotal+$valor_incorporacion; $c=$c+1;
			if($prev_cod<>$cod_bien_mue){
			  $pdf->Ln(3);
			  $pdf->Cell(25,3,$cod_bien_mue,0,0,'L'); 			   
			  $pdf->Cell(120,3,$denominacion,0,0,'L');
			  $pdf->Cell(25,3,$marca,0,0,'L');
			  $pdf->Cell(25,3,$modelo,0,0,'L');
			  $pdf->Cell(30,3,$serial1,0,0,'L');
			  $pdf->Cell(15,3,$fechai,0,0,'C');
			  $pdf->Cell(20,3,$monto,0,1,'R');
			  $prev_cod=$cod_bien_mue;
			}
		    $pdf->Cell(25,3,$cod_componente,0,0,'R'); 			   
			$pdf->Cell(120,3,$des_componente,0,0,'L');
			$pdf->Cell(25,3,$marca_comp,0,0,'L');
			$pdf->Cell(25,3,$modelo_comp,0,0,'L');
			$pdf->Cell(30,3,$serial_comp,0,0,'L');
			$pdf->Cell(15,3,'',0,0,'C');
			$pdf->Cell(20,3,'',0,1,'R');	
          }		  
		  $pdf->SetFont('Arial','B',7); $totalg=formato_monto($totalg);
		  $pdf->Cell(240,2,'',0,0);
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(200,3,'CANTIDAD DE BIENES : '.$i,0,0,'C');
		  $pdf->Cell(40,2,'TOTAL GENERAL : ',0,0,'R');
	      $pdf->Cell(20,2,$totalg,0,1,'R');
		  $pdf->Output();
	}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Listado_componentes_bienes_muebles.xls");
		  ?>
		<table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO COMPONENTES DE BIENES MUEBLES</strong></font></td>
			 </tr>	
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CODIGO</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION DEL BIEN</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>MARCA</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>MODELO</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>SERIAL</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>FECHA INC.</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>VALOR INCORP.</strong></td>
			 </tr> 
			<?  $i=0;  $totalg=0; $subtotal=0;  $prev_cod_clasificacion=""; $c=0;   $res=pg_query($sSQL);
		    while($registro=pg_fetch_array($res)){ $i=$i+1;  
		       $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_mue=$registro["cod_bien_mue"]; 
               
			   $cod_bien_mue=$registro["cod_bien_mue"]; $denominacion=$registro["denominacion"]; $fechai=$registro["fechai"]; $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"]; 
			   $marca=$registro["marca"]; $modelo=$registro["modelo"]; $serial1=$registro["serial1"];  $marca=substr($marca,0,15); $modelo=substr($modelo,0,15); $serial1=substr($serial1,0,20);
			   $valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			   $cod_componente=$registro["cod_componente"]; $des_componente=$registro["des_componente"]; $marca_comp=$registro["marca_comp"]; $modelo_comp=$registro["modelo_comp"]; $serial_comp=$registro["serial_comp"]; 
			   $denominacion=conv_cadenas($denominacion,0); $denominacion_dep=conv_cadenas($denominacion_dep,0); $denom_departamento=conv_cadenas($denom_departamento,0); 
			   $marca=conv_cadenas($marca,0);  $modelo=conv_cadenas($modelo,0);  $serial1=conv_cadenas($serial1,0);  $denominacion_c=conv_cadenas($denominacion_c,0);  
			   $monto=formato_monto($valor_incorporacion); $totalg=$totalg+$valor_incorporacion; $subtotal=$subtotal+$valor_incorporacion; $c=$c+1;			
			   if($prev_cod<>$cod_bien_mue){
			     ?>	
                <tr height="20">
				   <td width="100" align="left" ><strong></strong></td>
				</tr>	 				 
				<tr>
				   <td width="100" align="left" style="mso-number-format:'@';"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_bien_mue; ?></td>				   
				   <td width="400" align="justify"><? echo $denominacion; ?></td>
				   <td width="100" align="left"><? echo $marca; ?></td>
				   <td width="100" align="left"><? echo $modelo; ?></td>
				   <td width="100" align="left"><? echo $serial1; ?></td>
				   <td width="100" align="center"><? echo $fechai; ?></td>
				   <td width="100" align="right"><? echo $monto; ?></td>
				</tr>
			    <? $prev_cod=$cod_bien_mue;	
			   }
			   ?>	   
				<tr>
				   <td width="100" align="left" style="mso-number-format:'@';"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_componente; ?></td>				   
				   <td width="400" align="justify"><? echo $denominacion_c; ?></td>
				   <td width="100" align="left"><? echo $marca_comp; ?></td>
				   <td width="100" align="left"><? echo $modelo_comp; ?></td>
				   <td width="100" align="left"><? echo $serial_comp; ?></td>
				   <td width="100" align="center"></td>
				   <td width="100" align="right"></td>
				</tr>
			    <? 	
			}  $totalg=formato_monto($totalg); ?>	 				 
			<tr>
			    <td width="100" align="left"></td>			    
			    <td width="400" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right">=============</td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
				<td width="100" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"><strong>Totales</strong></td>
			    <td width="100" align="right"><strong><? echo $totalg; ?></strong></td>
			</tr>	
		</table><?	 
	}
 }
?>
