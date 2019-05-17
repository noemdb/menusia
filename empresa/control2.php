 <?php
include("../class/ccontrol.inc");
$tempresa = $_POST["txtempresa"];
$tclave   = $_POST["txtclave"];
$tusuario = $_POST["txtusuario"];
$tusuario = str_replace("-", "", $tusuario);
$tusuario = str_replace("'", "", $tusuario);
$tusuario = str_replace(";", "", $tusuario);
$tusuario = str_replace("*", "", $tusuario);
$tusuario = str_replace("%", "", $tusuario);
$tusuario = str_replace("[", "", $tusuario);
$tusuario = str_replace("#", "", $tusuario);
$tusuario = str_replace("/", "", $tusuario);
$tusuario = str_replace("=", "", $tusuario);
$tclave   = str_replace("/", "", $tclave);
$tclave   = str_replace("-", "", $tclave);
$tclave   = str_replace("'", "", $tclave);
$tclave   = str_replace(";", "", $tclave);
$tclave   = str_replace("=", "", $tclave);
foreach ($_GET as $key => $val) {
    ${$key} = $val;
}
$port    = $tport;
$host    = $thost;
$existdb = "N";
$user    = "invsia";
$key     = "0agi6s";
$str_conn = "host=" . $host . " port=" . $port . " password=" . $key . " user=" . $user . " dbname=" . $tempresa . "";
$conn    = pg_connect($str_conn);
echo 'string de conexion: '.$str_conn .'<br>';
echo 'objeto de conexion: '.$conn .'<br>';
if (!$conn) {
    echo "OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS 1", "<br>";
} else {
    $sql = "Select * from SIA000";
    $res = pg_query($sql);
    if ($registro = pg_fetch_array($res, 0)) {
        $user    = $registro["campo038"];
        $key     = $registro["campo039"];
        $existdb = "S";
    }
    pg_close();
}
if ($existdb == "S") {
    $conn = pg_connect("host=" . $host . " port=" . $port . " password=" . $key . " user=" . $user . " dbname=" . $tempresa . "");
    if (pg_ErrorMessage($conn)) {
        echo "OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS 2", "<br>";
    } else {
        $tgnomina = "";
        $sql      = "Select * from SIA001 WHERE campo101='$tusuario' and campo102='$tclave'";
        $res      = pg_query($sql);
        $filas    = pg_num_rows($res);
        $sql      = "select busca_sia001('$tusuario','$tclave');";
        $res      = pg_query($sql);
        $filas    = pg_num_rows($res);
        if ($filas >= 1) {
            $registro = pg_fetch_array($res);
            $filas    = $registro[0];
        }
        if ($filas == 0) {
            $existdb = "N";
        } else {
            $registro = pg_fetch_array($res);
            session_start();
            $_SESSION["autentificado"] = "SI";
            $_SESSION["usuario"]       = $user;
            $_SESSION["usr_password"]  = $key;
            $_SESSION["user_sia"]      = $tusuario;
            $_SESSION["bdatos"]        = $tempresa;
            $_SESSION["gnom"]          = $tgnomina;
            $existdb                   = "S";
        }
        if ($existdb == "S") {
            header("Location: menu.php");
        } else {
            header("Location: index.php?errorusuario=si");
        }
    }
    pg_close();
} 