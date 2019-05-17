<?php
include("../../class/seguridad.inc");
include("../../class/conects.php");
include("../../class/fun_fechas.php");
include("../../class/fun_numeros.php");
include("../../class/configura.inc");
error_reporting(E_ALL ^ E_NOTICE);
$cod_bien_mued     = $_GET["cod_bien_mued"];
$cod_bien_mueh     = $_GET["cod_bien_mueh"];
$cod_empresad      = $_GET["cod_empresad"];
$cod_empresah      = $_GET["cod_empresah"];
$cod_dependenciad  = $_GET["cod_dependenciad"];
$cod_dependenciah  = $_GET["cod_dependenciah"];
$cod_direcciond    = $_GET["cod_direcciond"];
$cod_direccionh    = $_GET["cod_direccionh"];
$cod_departamentod = $_GET["cod_departamentod"];
$cod_departamentoh = $_GET["cod_departamentoh"];
$tipo_rep          = $_GET["tipo_rep"];
$fecha_d           = $_GET["fecha_d"];
$fecha_h           = $_GET["fecha_h"];
//INI nmdb 02-03-2018 (listado de desincorporados)
$desincorporado    = $_GET["desincorporado"];
$titulo_listado    = $_GET["titulo_listado"];
//INI nmdb 02-03-2018

$date              = date("d-m-Y");
$hora              = date("H:i:s a");
$Sql               = "";
$php_os            = PHP_OS;
if (!(empty($fecha_d))) {
    $ano1 = substr($fecha_d, 6, 9);
    $mes1 = substr($fecha_d, 3, 2);
    $dia1 = substr($fecha_d, 0, 2);
} else {
    $fecha_d = '';
}
$fecha_desde = $ano1 . $mes1 . $dia1;
if (!(empty($fecha_h))) {
    $ano1 = substr($fecha_h, 6, 9);
    $mes1 = substr($fecha_h, 3, 2);
    $dia1 = substr($fecha_h, 0, 2);
} else {
    $fecha_h = '';
}
$fecha_hasta = $ano1 . $mes1 . $dia1;
$criterio1   = "Fecha Incorporacion Desde : " . $fecha_d . "   " . "Hasta : " . $fecha_h;
$criterio    = " (bien015.cod_bien_mue>='$cod_bien_mued' and bien015.cod_bien_mue<='$cod_bien_mueh') and (bien015.cod_empresa>='$cod_empresad' and bien015.cod_empresa<='$cod_empresah') AND 
  (bien015.cod_dependencia>='$cod_dependenciad' and bien015.cod_dependencia<='$cod_dependenciah') and (bien015.cod_direccion>='$cod_direcciond' and bien015.cod_direccion<='$cod_direccionh') AND
  (bien015.cod_departamento>='$cod_departamentod' and bien015.cod_departamento<='$cod_departamentoh') and (bien015.fecha_incorporacion>='$fecha_desde' and bien015.fecha_incorporacion<='$fecha_hasta')";
$conn        = pg_connect("host=" . $host . " port=" . $port . " password=" . $password . " user=" . $user . " dbname=" . $dbname . "");
if (pg_ErrorMessage($conn)) {
?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?php
} else {
    $php_os  = PHP_OS;
    $Nom_Emp = busca_conf();
    if ($utf_rpt == "SI") {
        if ($php_os == "WINNT") {
            $php_os = "LINUX";
        } else {
            $php_os = "WINNT";
        }
    }
    $mordenado  = " order by bien015.cod_clasificacion,bien015.cod_bien_mue";
    $nombre_rpt = "Rpt_lista_bie_mue_repor_bie_mue.xml";
    $nombre_rpt = "Rpt_lista_inc_bie_mue.xml";
    $sSQL       = "SELECT bien015.cod_bien_mue, bien015.cod_clasificacion, bien015.num_bien, bien015.denominacion, bien015.cod_dependencia, bien015.cod_direccion, bien015.cod_departamento, 
              bien015.caracteristicas, bien015.marca, bien015.modelo, bien015.color, bien015.Matricula, bien015.Serial1, bien015.Serial2, bien015.Tipo_Clase, bien015.Uso, bien015.Dimension_Tam, bien015.Antiguedad, 
              bien015.valor_incorporacion, to_char(bien015.fecha_incorporacion,'DD/MM/YYYY') as fechai, bien015.tipo_incorporacion, bien015.cod_contablea, bien015.cod_ContableD, bien015.cod_Imp_Presup, 
              bien015.cod_presup_dep, bien001.denominacion_dep, bien008.denominacion_C, bien005.denominacion_dir, bien006.denominacion_dep as denom_departamento, bien015.codigo_tipo_incorp, BIEN003.denomina_tipo
              FROM bien001, bien008, ( ((bien015  LEFT JOIN bien005 ON (bien005.cod_dependencia=bien015.cod_dependencia and bien005.cod_direccion=bien015.cod_direccion)) LEFT JOIN bien006 ON (bien006.cod_departamento=bien015.cod_departamento and bien006.cod_dependencia=bien015.cod_dependencia and bien006.cod_direccion=bien015.cod_direccion)) LEFT JOIN bien003 ON (bien003.codigo=bien015.codigo_tipo_incorp))
              where (bien001.cod_dependencia = bien015.cod_dependencia) and (bien008.Codigo_C=bien015.cod_clasificacion) and " . $criterio . $mordenado;
    if ($tipo_rep == "HTML") {
        include("../../class/phpreports/PHPReportMaker.php");
        $oRpt = new PHPReportMaker();
        $oRpt->setXML($nombre_rpt);
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("$host");
        $oRpt->setDatabaseInterface("postgresql");
        $oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
        $oRpt->setParameters(array(
            "criterio1" => $criterio1,
            "criterio2" => $criterio2,
            "date" => $date,
            "hora" => $hora
        ));
        $oRpt->putEnvObj("nombre_empresa", $Nom_Emp);
        $oRpt->run();
        $aBench = $oRpt->getBenchmark();
        $iSec   = $aBench["report_end"] - $aBench["report_start"];
    }
    if (($tipo_rep == "PDF")) {
        $res       = pg_query($sSQL);
        $cod_grupo = "";
        require('../../class/fpdf/fpdf.php');
        class PDF extends FPDF
        {
            function Header()
            {
                global $criterio1;
                global $criterio2;
                global $titulo_listado;//nmdb
                $this->Image('../../imagenes/Logo_emp.png', 7, 7, 20);
                $this->SetFont('Arial', 'B', 15);
                $this->Cell(50);
                //$this->Cell(150, 10, 'LISTADO INCORPORACIONES DE BIENES MUEBLES', 1, 0, 'C');
                $this->Cell(150, 10, 'LISTADO '.$titulo_listado.' DE BIENES MUEBLES', 1, 0, 'C');
                $this->Ln(20);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(100, 10, $criterio1, 0, 1, 'L');
                $this->SetFont('Arial', 'B', 6);
                $this->Cell(17, 5, 'CODIGO BIEN', 1, 0);
                $this->Cell(90, 5, 'DENOMINACION', 1, 0, 'L');
                $this->Cell(78, 5, 'DEPENDENCIA', 1, 0, 'L');
                $this->Cell(35, 5, 'MOVIMIENTO', 1, 0, 'L');
                $this->Cell(20, 5, 'VALOR INCORP.', 1, 0, 'L');
                $this->Cell(20, 5, 'COD. CONTABLE', 1, 1, 'L');
                
            }
            function Footer()
            {
                $ffechar = date("d-m-Y");
                $fhorar  = date("H:i:s a");
                $this->SetY(-10);
                $this->SetFont('Arial', 'I', 5);
                $this->Cell(130, 5, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
                $this->Cell(130, 5, 'Fecha: ' . $ffechar . ' Hora: ' . $fhorar, 0, 0, 'R');
            }
        }
        $pdf = new PDF('L', 'mm', Letter);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 7);
        $i                      = 0;
        $totalg                 = 0;
        $subtotal               = 0;
        $prev_cod_clasificacion = "";
        $c                      = 0;
        while ($registro = pg_fetch_array($res)) {
            $i                 = $i + 1;
            $cod_clasificacion = $registro["cod_clasificacion"];
            $denominacion_c    = $registro["denominacion_c"];
            $cod_bien_mue      = $registro["cod_bien_mue"];
            if ($php_os == "WINNT") {
                $denominacion_c = $denominacion_c;
            } else {
                $denominacion_c = utf8_decode($denominacion_c);
            }
            if ($prev_cod_clasificacion <> $cod_clasificacion) {
                if (($subtotal <> 0) or ($c > 1)) {
                    $subtotal = formato_monto($subtotal);
                    $pdf->Cell(220, 2, '', 0, 0);
                    $pdf->Cell(20, 2, '---------------------', 0, 0, 'R');
                    $pdf->Cell(20, 2, '', 0, 1);
                    $pdf->Cell(120, 3, 'CANTIDAD DE BIENES : ' . $c, 0, 0, 'C');
                    $pdf->Cell(100, 3, 'TOTAL : ' . $prev_cod_clasificacion . '  ', 0, 0, 'R');
                    $pdf->Cell(20, 3, $subtotal, 0, 1, 'R');
                    $pdf->Ln(5);
                }
                $subtotal               = 0;
                $prev_cod_clasificacion = $cod_clasificacion;
                $c                      = 0;
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(200, 4, $cod_clasificacion . '  ' . $denominacion_c, 0, 1);
            }
            $pdf->SetFont('Arial', '', 7);
            $cod_bien_mue        = $registro["cod_bien_mue"];
            $denominacion        = $registro["denominacion"];
            $fechai              = $registro["fechai"];
            $denom_departamento  = $registro["denom_departamento"];
            $cod_departamento    = $registro["cod_departamento"];
            $valor_incorporacion = $registro["valor_incorporacion"];
            $cod_dependencia     = $registro["cod_dependencia"];
            $denominacion_dep    = $registro["denominacion_dep"];
            $cod_contablea       = $registro["cod_contablea"];
            $denomina_tipo       = $registro["denomina_tipo"];
            if ($php_os == "WINNT") {
                $denominacion = $denominacion;
            } else {
                $denominacion       = utf8_decode($denominacion);
                $denominacion_dep   = utf8_decode($denominacion_dep);
                $denom_departamento = utf8_decode($denom_departamento);
            }
            $monto            = formato_monto($valor_incorporacion);
            $totalg           = $totalg + $valor_incorporacion;
            $subtotal         = $subtotal + $valor_incorporacion;
            $c                = $c + 1;
            $denomina_tipo    = substr($denomina_tipo, 0, 40);
            $denominacion_dep = substr($denominacion_dep, 0, 40);
            $pdf->Cell(17, 3, $cod_bien_mue, 0, 0, 'L');
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $n = 90;
            $pdf->SetXY($x + $n, $y);
            $pdf->Cell(78, 3, $denominacion_dep, 0, 0, 'L');
            $pdf->Cell(35, 3, $denomina_tipo, 0, 0, 'L');
            $pdf->Cell(20, 3, $monto, 0, 0, 'R');
            $pdf->Cell(20, 3, $cod_contablea, 0, 1, 'L');
            $pdf->SetXY($x, $y);
            $pdf->MultiCell($n, 3, $denominacion, 0);
        }
        if (($subtotal <> 0) or ($c > 1)) {
            $subtotal = formato_monto($subtotal);
            $pdf->Cell(220, 2, '', 0, 0);
            $pdf->Cell(20, 2, '---------------------', 0, 0, 'R');
            $pdf->Cell(20, 2, '', 0, 1);
            $pdf->Cell(120, 3, 'CANTIDAD DE BIENES : ' . $c, 0, 0, 'C');
            $pdf->Cell(100, 3, 'TOTAL : ' . $prev_cod_clasificacion . '  ', 0, 0, 'R');
            $pdf->Cell(20, 3, $subtotal, 0, 1, 'R');
            $pdf->Ln(5);
        }
        $pdf->SetFont('Arial', 'B', 7);
        $totalg = formato_monto($totalg);
        $pdf->Cell(220, 2, '', 0, 0);
        $pdf->Cell(20, 2, '=============', 0, 0, 'R');
        $pdf->Cell(20, 2, '', 0, 1);
        $pdf->Cell(120, 3, 'CANTIDAD DE BIENES : ' . $i, 0, 0, 'C');
        $pdf->Cell(100, 2, 'TOTAL GENERAL : ', 0, 0, 'R');
        $pdf->Cell(20, 2, $totalg, 0, 1, 'R');
        $pdf->Output();
    }
    
    if ($tipo_rep == "EXCEL") {
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Rpt_Listado_bienes_muebles.xls");
?>
          <table border="0" cellspacing='0' cellpadding='0' align="left">
             <tr height="20">
                <td width="100" align="left" ><strong></strong></td>
                <td width="100" align="left" ><strong></strong></td>
                <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO DE INCROPORACIONES BIENES MUEBLES</strong></font></td>
             </tr>    
             <tr height="20">
                <td width="100" align="left" ><strong></strong></td>
                <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?php
        echo $criterio1;
?></strong></font></td>
                <td width="300" align="left" ><strong></strong></td>
                <td width="200" align="left" ><strong></strong></td>
                <td width="100" align="left" ><strong></strong></td>
             </tr>            
             <tr height="20">
               <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CODIGO</strong></td>
               <td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION DEL BIEN</strong></td>
               <td width="300" align="left" bgcolor="#99CCFF"><strong>DEPENDENCIA</strong></td>
               <td width="200" align="left" bgcolor="#99CCFF" ><strong>MOVIMIENTO</strong></td>
               <td width="100" align="right" bgcolor="#99CCFF" ><strong>VALOR INCORP.</strong></td>
               <td width="200" align="left" bgcolor="#99CCFF" ><strong>COD. CONTABLE</strong></td>
             </tr>
          <?php
        $i                      = 0;
        $totalg                 = 0;
        $subtotal               = 0;
        $prev_cod_clasificacion = "";
        $c                      = 0;
        $res                    = pg_query($sSQL);
        while ($registro = pg_fetch_array($res)) {
            $i                 = $i + 1;
            $cod_clasificacion = $registro["cod_clasificacion"];
            $denominacion_c    = $registro["denominacion_c"];
            $cod_bien_mue      = $registro["cod_bien_mue"];
            $denominacion_c    = conv_cadenas($denominacion_c, 0);
            if ($prev_cod_clasificacion <> $cod_clasificacion) {
                if (($subtotal <> 0) or ($c > 1)) {
                    $subtotal = formato_monto($subtotal);
?>                      
                       <tr>
                      <td width="100" align="left"></td>
                      <td width="400" align="left"></td>
                      <td width="300" align="left"></td>
                      <td width="200" align="left"></td>
                      <td width="100" align="right">-------------------</td>
                      <td width="200" align="right"></td>
                   </tr>    
                   <tr>
                      <td width="100" align="left"></td>
                      <td width="400" align="left"></td>
                      <td width="300" align="left"></td>
                      <td width="200" align="left">Sub-Total <?php
                    echo $prev_cod_clasificacion;
?></td>
                      <td width="100" align="right"><?php
                    echo $subtotal;
?></td>
                      <td width="200" align="right"></td>
                    </tr>    
                 <?php
                }
                $subtotal               = 0;
                $prev_cod_clasificacion = $cod_clasificacion;
                $c                      = 0;
?>
              <tr>
                      <td width="100" align="left"><?php
                echo $cod_clasificacion;
?></td>
                      <td width="400" align="left"><?php
                echo $denominacion_c;
?></td>
                      <td width="300" align="left"></td>
                      <td width="200" align="left"></td>
                      <td width="100" align="right"></td>
                      <td width="200" align="right"></td>
                </tr>    
              <?php
            }
            $cod_bien_mue        = $registro["cod_bien_mue"];
            $denominacion        = $registro["denominacion"];
            $fechai              = $registro["fechai"];
            $denom_departamento  = $registro["denom_departamento"];
            $cod_departamento    = $registro["cod_departamento"];
            $valor_incorporacion = $registro["valor_incorporacion"];
            $cod_dependencia     = $registro["cod_dependencia"];
            $denominacion_dep    = $registro["denominacion_dep"];
            $marca               = $registro["marca"];
            $modelo              = $registro["modelo"];
            $serial1             = $registro["serial1"];
            $marca               = substr($marca, 0, 15);
            $modelo              = substr($modelo, 0, 15);
            $serial1             = substr($serial1, 0, 20);
            $cod_contablea       = $registro["cod_contablea"];
            $denomina_tipo       = $registro["denomina_tipo"];
            $denominacion        = conv_cadenas($denominacion, 0);
            $denominacion_dep    = conv_cadenas($denominacion_dep, 0);
            $denom_departamento  = conv_cadenas($denom_departamento, 0);
            $marca               = conv_cadenas($marca, 0);
            $modelo              = conv_cadenas($modelo, 0);
            $serial1             = conv_cadenas($serial1, 0);
            $monto               = formato_monto($valor_incorporacion);
            $totalg              = $totalg + $valor_incorporacion;
            $subtotal            = $subtotal + $valor_incorporacion;
            $c                   = $c + 1;
?>      
                <tr>
                   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><?php
            echo $cod_bien_mue;
?></td>                  
                   <td width="400" align="justify"><?php
            echo $denominacion;
?></td>
                   <td width="300" align="left"><?php
            echo $denominacion_dep;
?></td>
                   <td width="200" align="left"><?php
            echo $denomina_tipo;
?></td>
                   <td width="100" align="right"><?php
            echo $monto;
?></td>
                   <td width="200" align="justify"><?php
            echo $cod_contablea;
?></td>
                </tr>
             <?php
        }
        if (($subtotal > 0)) {
            $subtotal = formato_monto($subtotal);
?>                      
            <tr>
                <td width="100" align="left"></td>
                  <td width="400" align="left"></td>
                  <td width="300" align="left"></td>
                  <td width="200" align="left"></td>
                  <td width="100" align="right">-------------------</td>
                  <td width="200" align="right"></td>
            </tr>    
            <tr>
                <td width="100" align="left"></td>
                  <td width="400" align="left"></td>
                  <td width="300" align="left"></td>
                  <td width="2100" align="left">Sub-Total <?php
            echo $prev_cod_clasificacion;
?></td>
                  <td width="100" align="right"><?php
            echo $subtotal;
?></td>
                  <td width="200" align="right"></td>
            </tr>    
          <?php
        }
        $totalg = formato_monto($totalg);
?>                      
            <tr>
                <td width="100" align="left"></td>                
                <td width="400" align="left"></td>
                <td width="300" align="left"></td>
                <td width="200" align="left"></td>
                <td width="100" align="right">=============</td>
                <td width="200" align="right"></td>
            </tr>    
            <tr>
                <td width="100" align="left"></td>
                <td width="400" align="left"></td>
                <td width="300" align="left"></td>
                <td width="200" align="left"><strong>Totales</strong></td>
                <td width="100" align="right"><strong><?php
        echo $totalg;
?></strong></td>
                <td width="200" align="right"></td>
            </tr>    
            
         </table><?php
    }
    
    
}
?>