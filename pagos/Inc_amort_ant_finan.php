<?include ("../class/conect.php"); include ("../class/funciones.php");?>
<?$equipo=getenv("COMPUTERNAME"); if (!$_GET){$mcod_m="PAG001".$usuario_sia.$equipo;$codigo_mov=substr($mcod_m,0,49);} else{$codigo_mov=$_GET["codigo_mov"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Registrar Amortización de Anticipo)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
return true;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function llamar_anterior(){ document.location ='Det_inc_comp_ord_fin.php?codigo_mov=<?echo $codigo_mov?>'; }
function revisar(){
var f=document.form1;
   if(f.txttiene_anticipo.value==""){alert("Tiene Anticipo no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 {font-size: 16px;font-weight: bold;color: #FFFFFF;}
.Estilo10 {font-size: 10px}
-->
</style>
</head>
<?
$monto_anticipo=0;$tiene_anticipo="NO";$codigo_cuenta="";$nombre_cuenta="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'";
$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
if ($filas>0){$registro=pg_fetch_array($resultado); $tiene_anticipo=$registro["status_1"];$codigo_cuenta=$registro["campo_str1"];$monto_anticipo=$registro["monto_am_ant"];}
if ($tiene_anticipo=="S") {$tiene_anticipo="SI";}
else{$monto_anticipo=0;$tiene_anticipo="NO";$codigo_cuenta="";$nombre_cuenta="";
 $sql="Select PRE026.tipo_compromiso,PRE026.referencia_comp,PRE026.monto,PRE026.amort_anticipo,PRE006.cod_con_anticipo from PRE026,PRE006 where (PRE026.tipo_compromiso=PRE006.tipo_compromiso) and (PRE026.referencia_comp=PRE006.referencia_comp) and (PRE026.codigo_mov='$codigo_mov') and (PRE026.tipo_compromiso<>'0000') and (PRE026.amort_anticipo<>0) order by PRE026.tipo_compromiso,PRE026.referencia_comp,PRE026.cod_presup";
 $res=pg_query($sql);
 while($reg=pg_fetch_array($res)){ $tiene_anticipo="SI"; $tasa=$reg["amort_anticipo"]; $monto_c=$reg["monto"]; $monto_a=$monto_c*($tasa/100); $monto_a=formato_monto($monto_a);  $monto_anticipo=$monto_anticipo+$monto_a; $codigo_cuenta=$reg["cod_con_anticipo"];}
}
if($tiene_anticipo=="SI") {$sSQL="Select * from con001 WHERE codigo_cuenta='$codigo_cuenta' and cargable='C'";
$res=pg_exec($conn,$sSQL);$filas=pg_numrows($res); if ($filas>0){ $registro=pg_fetch_array($res); $nombre_cuenta=$registro["nombre_cuenta"]; } }
$monto_anticipo=formato_monto($monto_anticipo);
?>
<body>
<form name="form1" method="post" action="update_amort_ant_fin.php" onSubmit="return revisar()">
  <table width="768" height="180" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="763" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">REGISTRAR AMORTIZACION DE ANTICIPO EN LA ORDEN</span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="737">
            <tr>
<script language="JavaScript" type="text/JavaScript">
function asig_tiene_anticipo(mvalor){
var f=document.form1;
    if(mvalor=="SI"){document.form1.txttiene_anticipo.options[0].selected = true;}else{document.form1.txttiene_anticipo.options[1].selected = true;}
}</script>
              <td width="158"><span class="Estilo5">AMORTIZA ANTICIPO:</span></td>
              <td width="68"><span class="Estilo5"> <select name="txttiene_anticipo" size="1" id="txttiene_anticipo" onFocus="encender(this)" onBlur="apagar(this)">
                  <option>SI</option> <option>NO</option> </select> </span></td>
              <script language="JavaScript" type="text/JavaScript"> asig_tiene_anticipo('<?echo $tiene_anticipo;?>');</script>
              <td width="105"></td>
              <td width="214"><span class="Estilo5">MONTO DE LA AMORTIZACI&Oacute;N:</span></td>
              <td width="168"><span class="Estilo5"><input name="txtmonto_anticipo" type="text" id="txtmonto_anticipo" size="12" style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto_anticipo?>" onKeypress="return validarNum(event)">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="759" border="0">
            <tr>
              <td width="145"><span class="Estilo5">CUENTA DE ANTICIPO:</span></td>
              <td width="153"><span class="Estilo5"><input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" size="25" onFocus="encender(this); " onBlur="apagar(this);" value="<?echo $codigo_cuenta?>"></span> </td>
              <td width="40"><span class="Estilo5"><input name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onclick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
              <td width="375"><span class="Estilo5"><input name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" size="60" value="<?echo $nombre_cuenta?>" readonly>  </span> </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>  </td>
        </tr>
        <tr>
          <td><p>&nbsp;</p> </td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="19"><input name="txtdes_orden_ret" type="hidden" id="txtdes_orden_ret" ></td>
            <td width="75">&nbsp;</td>
            <td width="88" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="87" align="center">&nbsp;</td>
            <td width="109" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="113">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>