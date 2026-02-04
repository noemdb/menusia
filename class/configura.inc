<?php $Cod_Emp = "00";
$Rif_Emp = "";
$Fec_Ini_Ejer = "2010-01-01";
$Fec_Fin_Ejer = "2010-01-01";
$SIA_Definicion = "N";
$SIA_Integrado = "N";
$SIA_Cierre = "N";
$utf_rpt = "N";
$pdf_rpt = "N";
$tam_logo = 20;
function busca_conf()
{
    global $conn;
    global $Cod_Emp;
    global $Rif_Emp;
    global $Fec_Ini_Ejer;
    global $Fec_Fin_Ejer;
    global $SIA_Periodo;
    global $SIA_Definicion;
    global $SIA_Integrado;
    global $utf_rpt;
    global $pdf_rpt;
    global $tam_logo;
    global $SIA_Cierre;
    $sql = "Select * from SIA000 order by campo001";
    $resultado = pg_query($conn, $sql);
    if ($registro = pg_fetch_array($resultado, 0)) {
        $SIA_Periodo = $registro["campo033"];
        $SIA_Definicion = $registro["campo034"];
        $SIA_Integrado = $registro["campo036"];
        $Nom_Emp = $registro["campo004"];
        $Rif_Emp = $registro["campo007"];
        $Cod_Emp = $registro["campo037"];
        $Fec_Ini_Ejer = $registro["campo031"];
        $Fec_Fin_Ejer = $registro["campo032"];
        $utf_rpt = $registro["campo049"];
        $pdf_rpt = $registro["campo050"];
        $tam_logo = $registro["campo057"];
        $SIA_Cierre = substr($SIA_Integrado, 17, 1);
    } else {
        $Nom_Emp = "CEINCO C.A.";
        $SIA_Periodo = "01"; ?>
        <script language="JavaScript">muestra('INFORMACION DE EMPRESA NO LOCALIZADA');</script><?php }
    return $Nom_Emp;
} ?>