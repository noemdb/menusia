<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_presup=$_GET["cod_presup"];$codigo=$_GET["codigo"];$SIA_Definicion=substr($codigo,0,1);$cod_fuente=substr($codigo,1,2);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Cargar Partidas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
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
function llamar_eliminar(){
var r=confirm("Esta seguro en Eliminar el Codigo Presupuestario de la Carga ?");
  if (r==true) { document.location ='Delete_cod_carga.php?codigo=<?echo $codigo?>&cod_presup=<?echo $cod_presup?>'; }
}
function llamar_modificar(){ document.location ='Update_cod_carga.php?codigo=<?echo $codigo?>&cod_presup=<?echo $cod_presup?>&monto='+document.form1.txtmonto.value; }
function llamar_anterior(){ document.location ='Part_det_carga.php?Gcodigo=<?echo $codigo?>'; }
</script>

<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$denominacion=""; $monto=0;
$sSQL="SELECT * FROM PRE032 where cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";$res=pg_query($sSQL);
if ($registro=pg_fetch_array($res,0)){ $denominacion=$registro["denominacion"]; $monto=$registro["asignado"];}
$monto=formato_monto($monto);
?>
</head>
<body>
<form name="form1" >
  <table width="613" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="610" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#003399"><span class="Estilo2 Estilo6">MODIFICAR ASIGNACION</span></td>
        </tr>
        <tr>
          <td><table width="599" border="0">
              <tr>
                <td width="181"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                <td width="408"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup"   value="<?echo $cod_presup?>" readonly size="32" maxlength="32" >
                </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="599" border="0">
              <tr>
                <td width="122"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="482"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="74" maxlength="250" value="<?echo $denominacion?>" readonly>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="599" border="0">
                <tr>
                  <td width="115"><span class="Estilo5">ASIGNACI&Oacute;N : </span></td>
                  <td width="474"><span class="Estilo5">
                    <? IF($SIA_Definicion=="N"){?>
                       <input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="25" style="text-align:right" maxlength="22" title="Registre el Monto de Asignacion" value="<?echo $monto?>" onFocus="encender_monto(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)">
                    <?} else { ?>
                       <input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="25" style="text-align:right" maxlength="22" readonly value="<?echo $monto?>">
                     <?}?>
                  </span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
        <table width="600" align="center">
          <tr>
            <td width="120">&nbsp;</td>
            <td width="120" align="center" ><input name="button" type="button" id="button"  value="Grabar" onClick="JavaScript:llamar_modificar()"></td>
            <td width="120" align="center"><input name="button1" type="button" id="button1" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="120" align="center"><input name="button2" type="button" id="button2" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
            <td width="120">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>