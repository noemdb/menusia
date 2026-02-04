<?php include ("../class/conect.php");  include ("../class/funciones.php");
$equipo=getenv("COMPUTERNAME");
if (!$_GET){ $cod_bien=""; 
  $mcod_m="PRE023".$equipo;$codigo_mov=substr($mcod_m,0,49);}
 else{ $cod_bien=$_GET["codigo"];   $codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Modificar Transferencias Bienes Muebles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet> 
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){document.location ='Det_inc_bienes_inmu_depreciacion.php?codigo_mov=<?php echo $codigo_mov?>';}
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtcod_bien_inm.value==""){alert("C�digo del Inmueble no puede estar Vacio"); return false; } else{f.txtcod_bien_inm.value=f.txtcod_bien_inm.value.toUpperCase();}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}
      else{alert("monto debe tener valores num�ricos.");return false;}
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
<?php 
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$denominacion="";
$monto=0;
$sql="SELECT * FROM CODIGOS_BIEN050 where codigo_mov='$codigo_mov' and cod_bien='$cod_bien'";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){
  $cod_bien=$registro["cod_bien"];
  $denominacion=$registro["denominacion"];
  $vida_util=$registro["vida_util"];
  $valor_residual=$registro["valor_residual"];
  $cod_presup_dep=$registro["cod_presup_dep"];
  $monto_depreciado=$registro["monto_depreciado"];
  $cod_contablea=$registro["cod_contablea"];
  $cod_contabled=$registro["cod_contabled"];
  $monto_c=$registro["monto"];
}
$monto=formato_monto($monto);
?>
<body>
<form name="form1" method="post" action="Update_cod_bienes_inmu_depreciaciones.php" onSubmit="return revisar()">
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
                    <input name="txtcod_bien_mue" type="text" class="Estilo5" id="txtcod_bien_mue" size="30" maxlength="30" readonly value="<?php  echo $cod_bien ?>">
                    <strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo de Bienes Inmuebles" onClick="VentanaCentrada('Cat_trans_bienes_mueblesd.php?criterio=','SIPAP','','750','500','true')" value="...">
                </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="103" scope="col"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="847" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtdenominacion" type="text" class="Estilo5" id="txtdenominacion" size="85" maxlength="100"  readonly value="<?php  echo $denominacion ?>">
                </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">VIDA &Uacute;TIL EN A&Ntilde;OS :</span></div></td>
                <td width="107" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtvida_util" type="text" id="txtvida_util" size="10"  readonly value="<?php  echo $vida_util?>">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="71" scope="col"><div align="left"><span class="Estilo5">VALOR RESIDUAL :</span></div></td>
                <td width="701" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtvalor_residual" type="text" id="txtvalor_residual"readonly value="<?php  echo $valor_residual?>">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="164" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DE DEPRECIACI&Oacute;N :</span></div></td>
                <td width="400" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcod_presup_dep" type="text" id="txtcod_presup_dep" size="40" maxlength="32" readonly value="<?php  echo $cod_presup_dep?>">
                    <span class="menu"><strong><strong>
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="133" scope="col"><div align="left"><span class="Estilo5">MONTO DEPRECIADO :</span></div></td>
                <td width="300" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtmonto_depreciado" type="text" id="txtmonto_depreciado" size="15" maxlength="15" readonly value="<?php  echo $monto_depreciado?>">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="114" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO CONTABLE ASOCIADO :</span></div></td>
                <td width="300" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcod_contablea" type="text" id="txtcod_contablea" size="30" maxlength="25"  readonly value="<?php  echo $cod_contablea?>">
                    <span class="menu"><strong><strong>
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="115" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO CONTABLE DEPRECIACI&Oacute;N :</span></div></td>
                <td width="400" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcod_contabled" type="text" id="txtcod_contabled" size="30" maxlength="25" readonly value="<?php  echo $cod_contabled?>">
                    <span class="Estilo10"><span class="menu"><strong><strong>
                </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="614" border="0">
                <tr>
                  <td width="108"><span class="Estilo5">MONTO </span>:</td>
                  <td width="496"><span class="Estilo5">
                    <input name="txtmonto" type="text" class="Estilo5" id="txtmonto" onFocus="encender(this)" onBlur="apagar(this)" value="<?php  echo $monto_c ?>" size="25" maxlength="22" align="right">
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
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
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
