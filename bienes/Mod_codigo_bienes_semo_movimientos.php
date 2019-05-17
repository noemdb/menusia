<?include ("../class/conect.php");  include ("../class/funciones.php");
$equipo=getenv("COMPUTERNAME");
if (!$_GET){ $cod_bien=""; 
  $mcod_m="PRE023".$equipo;$codigo_mov=substr($mcod_m,0,49);}
 else{ $cod_bien=$_GET["codigo"];   $codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Modificar Movimientos Bienes Semovientes)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet> 
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){document.location ='Det_inc_bienes_semo_movimientos.php?codigo_mov=<?echo $codigo_mov?>';}
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtcod_bien_sem.value==""){alert("Código del Semoviente no puede estar Vacio"); return false; } else{f.txtcod_bien_sem.value=f.txtcod_bien_sem.value.toUpperCase();}
   if(f.txtcodigo.value==""){alert("Tipo Movimiento no puede estar Vacio"); return false; } else{f.txtcodigo.value=f.txtcodigo.value.toUpperCase();}
   if(f.txtcantidad.value==""){alert("Cantidad no puede estar Vacia"); return false; } else{f.txtcantidad.value=f.txtcantidad.value.toUpperCase();}
   if(f.txtgen_comprobante.value==""){alert("Gen Comprobante no puede estar Vacio"); return false; } else{f.txtgen_comprobante.value=f.txtgen_comprobante.value.toUpperCase();}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}
      else{alert("monto debe tener valores numéricos.");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;  }
.Estilo10 {font-size: 10px}
-->
</style>
</head>
<?
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$denominacion="";
$monto=0;
$sql="SELECT * FROM CODIGOS_SEMOVIENTE_BIEN050 where codigo_mov='$codigo_mov' and cod_bien='$cod_bien'";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){
  $cod_bien=$registro["cod_bien"];
  $denominacion=$registro["denominacion"];
  $tipo_movimiento=$registro["tipo_movimiento"];
  $denomina_tipo=$registro["denomina_tipo"];
  $gen_comprobante=$registro["gen_comprobante"];
  $cantidad=$registro["cantidad"];
  $monto_c=$registro["monto"];
}
$monto=formato_monto($monto);
?>
<body>
<form name="form1" method="post" action="Update_cod_bienes_semovientes_movimientos.php" onSubmit="return revisar()">
  <table width="740" height="280" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="735" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR BIENES</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
          <tr>
            <td><table width="806">
              <tr>
                <td width="111" scope="col"><span class="Estilo5">C&Oacute;DIGO DE L BIEN MUEBLES :</span></td>
                <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtcod_bien_mue" type="text" class="Estilo5" id="txtcod_bien_mue" size="30" maxlength="30" readonly value="<? echo $cod_bien ?>">
                    <strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo de Bienes Inmuebles" onClick="VentanaCentrada('Cat_trans_bienes_mueblesd.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="103" scope="col"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="847" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtdenominacion" type="text" class="Estilo5" id="txtdenominacion" size="85" maxlength="100"  readonly value="<? echo $denominacion ?>">
                </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="806">
              <tr>
                <td width="111" scope="col"><span class="Estilo5">TIPO :</span></td>
                <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtcodigo" type="text" id="txtcodigo" size="05" maxlength="03"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5"  value="<? echo $tipo_movimiento ?>">
                    <strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo de Bienes Inmuebles" onClick="VentanaCentrada('Cat_movim_bienes_mueblesd.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="103" scope="col"><span class="Estilo5">DESCRIPCION DEL MOVIMIENTO:</span></td>
                <td width="847" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtdenomina_tipo" type="text" id="txtdenomina_tipo" size="50" maxlength="100"  readonly  value="<? echo $denomina_tipo?>">
                </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="620" border="0">
                <tr>

                  <td width="109"><span class="Estilo5">CANTIDAD: </span>:</td>
                  <td width="0"><span class="Estilo5">
                    <input name="txtcantidad" type="text" id="txtcantidad" size="25" align="right" maxlength="22" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<? echo $cantidad?>">
                  </span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="620" border="0">
                <tr>

                  <td width="109"><span class="Estilo5">GEN. COMPROBANTE: </span>:</td>
                  <td width="0"><span class="Estilo5">
                    <input name="txtgen_comprobante" type="text" id="txtgen_comprobante" size="3" align="right" maxlength="1" value="<? echo $gen_comprobante?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                  </span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="614" border="0">
                <tr>
                  <td width="108"><span class="Estilo5">MONTO </span>:</td>
                  <td width="496"><span class="Estilo5">
                    <input name="txtmonto" type="text" class="Estilo5" id="txtmonto" onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $monto_c ?>" size="25" maxlength="22" align="right">
                  </span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>
              <p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="120">&nbsp;</td>
            <td width="87" align="center" valign="middle"><input name="Submit" type="submit" id="Submit"  value="Aceptar"></td>
            <td width="99" align="center"><input name="button" type="button" id="button4" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="77" align="center">&nbsp;</td>
            <td width="112">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>
