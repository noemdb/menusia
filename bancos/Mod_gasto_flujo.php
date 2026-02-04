<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$cod_banco=""; $referencia="";$tipo_mov="";$cod_presup="";$fuente="";$periodo="";} 
else{ $cod_banco=$_GET["cod_banco"];$referencia=$_GET["referencia"];$tipo_mov=$_GET["tipo_mov"]; $cod_presup=$_GET["cod_presup"]; $fuente=$_GET["fuente"]; $periodo=$_GET["periodo"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Modificar Gasto del Flujo)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_gasto_flujo.php?criterio=<?echo $periodo?>'; }
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function llamar_eliminar(referencia,tipo_mov,cod_banco,periodo){var murl;  var r;
 if (referencia=="") {alert("Codigo debe ser Seleccionado");}
}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
 return true;}
 
 
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtreferencia.value==""){alert("Referencia no puede estar Vacio");return false;}   
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 {font-size: 16px;font-weight: bold;  color: #FFFFFF; }
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
$ced_rif="";$fecha_mov_libro="";$monto_mov_libro=0;$cod_partida="";$cod_contable="";$monto_codigo=0;$campo_str1="";$campo_str2="";$campo_num1="";$campo_num2="";$descrip_mov_libro="";
$sql="SELECT * FROM BAN021 where referencia='$referencia' and cod_banco='$cod_banco' and tipo_mov_libro='$tipo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente' "; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $cod_partida=$registro["cod_partida"]; $cod_contable=$registro["cod_contable"];  $descrip_mov_libro=$registro["descrip_mov_libro"]; 
$monto_mov_libro=$registro["monto_mov_libro"]; $monto_codigo=$registro["monto_codigo"];  $cod_presup=$registro["cod_presup"];  $fuente_financ=$registro["fuente_financ"]; 
$ced_rif=$registro["ced_rif"]; $fecha_mov_libro=$registro["fecha_mov_libro"];
} $monto_mov_libro=formato_monto($monto_mov_libro); $monto_codigo=formato_monto($monto_codigo);
?>
<body>
<form name="form1" method="post" action="Update_gasto_flujo.php" onSubmit="return revisar()">
  <table width="680" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="680" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR GASTO DE FLUJO </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="674" border="0">
              <tr>
			    <td width="105"><span class="Estilo5">C&Oacute;DIGO BANCO:</span></td>
                <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text"  id="txtcod_banco"  value="<?echo $cod_banco?>" size="8" maxlength="4" readonly> </span></td>
                <td width="100"><span class="Estilo5">REFERENCIA  :</span></td>
				<td width="120"><span class="Estilo5"><input class="Estilo10" name="txtreferencia" type="text"  id="txtreferencia"  value="<?echo $referencia?>" size="10" maxlength="8" readonly> </span></td>
				<td width="142"><span class="Estilo5">TIPO MOVIMIENTO :</span></td>
				<td width="57"><span class="Estilo5"><input class="Estilo10" name="txttipo_movimiento" type="text" id="txttipo_movimiento"  value="<?echo $tipo_mov?>" size="4" maxlength="4" readonly></span></td>
               
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="674" border="0">
              <tr>
                <td width="90"><span class="Estilo5">DESCRIPCION : </span></td>
				<td width="580"><textarea name="txtdescripcion" cols="60" readonly="readonly" class="headers" id="txtdescripcion"><?echo $descrip_mov_libro?></textarea></td>
               </tr>
            </table>            </td>
        </tr>
		<tr>
          <td><table width="674" border="0">
              <tr>
			    <td width="200"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO  :</span></td>
				<td width="250"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text"  id="txtcod_presup"  value="<?echo $cod_presup?>" size="30" maxlength="32" readonly> </span></td>
				<td width="100"><span class="Estilo5">FUENTE :</span></td>
				<td width="74"><span class="Estilo5"><input class="Estilo10" name="txttfuente_financ" type="text" id="txttfuente_financ"  value="<?echo $fuente_financ?>" size="2" maxlength="2" readonly></span></td>
               </tr>
          </table></td>
        </tr>
		<tr>
          <td><table width="674" border="0">
              <tr>
			    <td width="150"><span class="Estilo5">C&Oacute;DIGO CONTABLES:</span></td>
                <td width="187"><span class="Estilo5"> <input class="Estilo10" name="txtcod_contable" type="text"  id="txtcod_contable"  value="<?echo $cod_contable?>" size="20" maxlength="24" readonly> </span></td>
                <td width="150"><span class="Estilo5">C&Oacute;DIGO PARTIDA  :</span></td>
				<td width="187"><span class="Estilo5"><input class="Estilo10" name="txtcod_partida" type="text"  id="txtcod_partida"  value="<?echo $cod_partida?>" size="20" maxlength="24" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
			   </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="100">&nbsp;</td>
			<td width="5"><input name="txtperiodo" type="hidden" id="txtperiodo" value="<?echo $periodo?>" ></td>
			<td width="5"><input name="txtmonto_mov_libro" type="hidden" id="txtmonto_mov_libro" value="<?echo $monto_mov_libro?>" ></td>
			<td width="5"><input name="txtmonto_codigo" type="hidden" id="txtmonto_codigo" value="<?echo $monto_codigo?>" ></td>
			<td width="5"><input name="txtced_rif" type="hidden" id="txtced_rif" value="<?echo $ced_rif?>" ></td>
			<td width="5"><input name="txtfecha" type="hidden" id="txtfecha" value="<?echo $fecha_mov_libro?>" ></td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar('<? echo $codigo_mov; ?>','<? echo $cod_cuenta; ?>','<? echo $debito_credito; ?>')"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>