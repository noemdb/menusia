<? include("../class/conect.php");
include("../class/funciones.php");
$tipo_arch_banco = '00';
if (!$_GET) {
  $cod_arch_banco = '';
} else {
  $criterio = $_GET["criterio"];
  $tipo_arch_banco = substr($criterio, 0, 2);
  $cod_arch_banco = substr($criterio, 2, 6);
}
$conn = pg_connect("host=" . $host . " port=" . $port . " password=" . $password . " user=" . $user . " dbname=" . $dbname . "");
if (pg_ErrorMessage($conn)) {
  echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>";
  exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
  <title>SIPAP N&oacute;MINA Y PERSONAL (Detalles del Archivo Prestaciones)</title>
  <LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>

<body>
  <table width="1910" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="left">
        <table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar"
                value="Agregar" title="Agregar Campo al archivo" onclick="javascript:llamar_agregar()"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar"
                onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar Campos"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="1910">
        <?php
        $sql = "SELECT * FROM nom052 where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco='$cod_arch_banco') order by cod_arch_banco,pos_campo";
        $res = pg_query($sql);
        ?>
        <table width="1900" border="1" cellspacing='0' cellpadding='0' align="left" id="det_arch_banco">
          <tr height="20" class="Estilo5">
            <td width="50" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
            <td width="280" align="center" bgcolor="#99CCFF"><strong>Descripci&oacute;n</strong></td>
            <td width="30" align="center" bgcolor="#99CCFF"><strong>Tipo</strong></td>
            <td width="55" align="center" bgcolor="#99CCFF"><strong>Longitud</strong></td>
            <td width="70" align="center" bgcolor="#99CCFF"><strong>Decimales</strong></td>
            <td width="40" align="center" bgcolor="#99CCFF"><strong>Inicio</strong></td>
            <td width="40" align="center" bgcolor="#99CCFF"><strong>Fin</strong></td>
            <td width="110" align="center" bgcolor="#99CCFF"><strong>Rellena Cero Izq.</strong></td>
            <td width="110" align="center" bgcolor="#99CCFF"><strong>Rellena Cero Der.</strong></td>
            <td width="130" align="center" bgcolor="#99CCFF"><strong>Rellena Espacio Izq.</strong></td>
            <td width="130" align="center" bgcolor="#99CCFF"><strong>Rellena Espacio Der.</strong></td>
            <td width="110" align="center" bgcolor="#99CCFF"><strong>Elimina Cero Izq.</strong></td>
            <td width="110" align="center" bgcolor="#99CCFF"><strong>Elimina Cero Der.</strong></td>
            <td width="130" align="center" bgcolor="#99CCFF"><strong>Elimina Espacio Izq.</strong></td>
            <td width="130" align="center" bgcolor="#99CCFF"><strong>Elimina Espacio Der.</strong></td>
            <td width="80" align="center" bgcolor="#99CCFF"><strong>Elimina Coma</strong></td>
            <td width="80" align="center" bgcolor="#99CCFF"><strong>Elimina Punto</strong></td>
            <td width="55" align="center" bgcolor="#99CCFF"><strong>Posici&oacute;n</strong></td>
            <td width="60" align="center" bgcolor="#99CCFF"><strong>Condici&oacute;n</strong></td>
            <td width="80" align="center" bgcolor="#99CCFF"><strong>Cuerpo Arch.</strong></td>
          </tr>
          <? $ult_campo = 5;
          while ($registro = pg_fetch_array($res)) {
            $pos_campo = $registro["pos_campo"];
            $ult_campo = $pos_campo + 5;
            ?>
            <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5"
              onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onMouseOut="this.style.backgroundColor='#FFFFFF'" o"];"
              onDblClick="javascript:Llama_Modificar('<? echo $pos_campo; ?>');">
              <td width="50" align="left"><? echo $registro["cod_campo"]; ?></td>
              <? if ($registro["car_especial"] == "") { ?>
                <td width="280" align="left">&nbsp;</td>
              <? } else { ?>
                <td width="280" align="left"><? echo $registro["car_especial"]; ?></td><? } ?>
              <td width="30" align="left"><? echo $registro["tipo_campo"]; ?></td>
              <td width="55" align="left"><? echo $registro["longitud_campo"]; ?></td>
              <td width="70" align="left"><? echo $registro["decimales_campo"]; ?></td>
              <td width="40" align="left"><? echo $registro["pos_comienza"]; ?></td>
              <td width="30" align="left"><? echo $registro["pos_finaliza"]; ?></td>
              <td width="110" align="left"><? echo $registro["rellena_ceros_izq"]; ?></td>
              <td width="110" align="left"><? echo $registro["rellena_ceros_der"]; ?></td>
              <td width="130" align="left"><? echo $registro["rellena_espacios_i"]; ?></td>
              <td width="130" align="left"><? echo $registro["rellena_espacios_d"]; ?></td>
              <td width="110" align="left"><? echo $registro["elimina_ceros_izq"]; ?></td>
              <td width="110" align="left"><? echo $registro["elimina_ceros_der"]; ?></td>
              <td width="130" align="left"><? echo $registro["elimina_espacios_i"]; ?></td>
              <td width="130" align="left"><? echo $registro["elimina_espacios_d"]; ?></td>
              <td width="80" align="left"><? echo $registro["elimina_comas"]; ?></td>
              <td width="80" align="left"><? echo $registro["elimina_puntos"]; ?></td>
              <td width="55" align="left"><? echo $registro["pos_campo"]; ?></td>
              <td width="60" align="left"><? echo $registro["status1_campo"]; ?></td>
              <td width="80" align="left"><? echo $registro["status2_campo"]; ?></td>
            </tr>
          <? } ?>
        </table>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</body>

</html>
<? pg_close(); ?>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_agregar(){   var mpos_campo='<? echo $ult_campo; ?>';    mpos_campo=Rellenarizq(mpos_campo,"0",3);
document.location='Inc_campo_arch_presta.php?cod_arch_banco=<? echo $cod_arch_banco ?>'+'&tipo_arch_banco=<? echo $tipo_arch_banco ?>'+'&pos_campo='+mpos_campo; }
function Llama_Modificar(mpos_campo){  if(mpos_campo==""){alert("Informacion debe ser Seleccionada");}
 else{document.location='Mod_campo_arch_presta.php?cod_arch_banco=<? echo $cod_arch_banco ?>'+'&tipo_arch_banco=<? echo $tipo_arch_banco ?>'+'&pos_campo='+mpos_campo;} }
</script>