<?include ("../class/conect.php");  include ("../class/funciones.php");  $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();  
if (!$_GET){$tipo_informe="";$linea="00000001";}else{$tipo_informe=$_GET["tipo_informe"];$linea=$_GET["linea"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Modificar Linea Informes Contables)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_inf_contables.php?criterio=<?echo $tipo_informe?>'; }
function llamar_eliminar(){var murl; var r;
  murl="Esta seguro en Eliminar la Linea del Informe Contable ?"; r=confirm(murl);
  if(r==true){r=confirm("Esta Realmente seguro en Eliminar la Linea del Informe Contable ?");
    if(r==true){murl="Delete_campo_inf_contab.php?tipo_informe=<?echo $tipo_informe?>&linea=<?echo $linea?>"; document.location=murl;}}  else{url="Cancelado, no elimino";}
}
function llamar_calculable(){var murl; var minforme='<?echo $tipo_informe?>'; var mlinea='<?echo $linea?>'; var mcalculable=document.form1.txtcalculable.value;
  if(mcalculable=="SI") { murl='Det_inc_cal_informes.php?linea='+mlinea+"&cod_informe="+minforme;  document.location=murl; }
}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtlinea.value==""){alert("Linea no puede estar Vacio");return false;}
   if(f.txtlinea.value.length==8){valido=true;}else{alert("Longitud Linea Invalida");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $nombre_cuenta="";  $codigo_cuenta="";
$sql="SELECT * from CON006 WHERE tipo_informe='$tipo_informe' and linea='$linea'"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $linea=$registro["linea"]; $codigo_cuenta=$registro["codigo_cuenta"]; $cod_cuenta=$registro["cod_cuenta"];
$nombre_cuenta=$registro["nombre_cuenta"]; $calculable=$registro["calculable"];$status_linea=$registro["status_linea"]; $moperacion=$registro["moperacion"];
$columna=$registro["columna"]; $status=$registro["status"]; 
}pg_close();
?>
<body>
<form name="form1" method="post" action="Update_campo_inf_contab.php" onSubmit="return revisar()">
  <table width="832" height="150" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="831" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICA LINEA INFORME CONTABLE</span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="50"><span class="Estilo5">LINEA :</span> </td>
                <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtlinea" type="text" id="txtlinea" size="10" maxlength="8" readonly  value="<?echo $linea?>" > </span></td>
                <td width="120"><span class="Estilo5">CODIGO CUENTA :</span> </td>
				<td width="200"><span class="Estilo5"><input  class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" class="Estilo5" value="<?echo $codigo_cuenta?>" size="30" maxlength="30" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
                <td width="80"><input  class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Codigo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="..."></td>                   
			    <td width="80"><span class="Estilo5">CODIGO : </span></td>
                <td width="200"><span class="Estilo5"><input  class="Estilo10" name="txtcod_cuenta" type="text" class="Estilo5" id="txtcod_cuenta" value="<?echo $cod_cuenta?>"  size="30" maxlength="30" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
              </tr>
          </table></td>
        </tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
            <td><table width="830">
                <tr>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                   <td width="500"><span class="Estilo5"> <input  class="Estilo10" name="txtNombre_Cuenta" type="text" class="Estilo5" id="txtNombre_Cuenta" value="<?echo $nombre_cuenta?>"  size="120" maxlength="200" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                </tr>
            </table></td>
        </tr>
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="100"><span class="Estilo5">CALCULABLE : </span></td>
                <td width="130"><span class="Estilo5"><select class="Estilo10" name="txtcalculable" size="1" id="txtcalculable" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select> </span></td>
                <td width="100"><span class="Estilo5">ESTATUS : </span></td>
                <td width="130"><span class="Estilo5"><select class="Estilo10" name="txtstatus_linea" size="1" id="txtstatus_linea" onFocus="encender(this)" onBlur="apagar(this)"><option>0</option> <option>1</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> <option>6</option> <option>7</option> <option>8</option> <option>9</option> </select> </span></td>
                <td width="100"><span class="Estilo5">OPERACION : </span></td>
                <td width="180"><span class="Estilo5"><select class="Estilo10" name="txtmoperacion" size="1" id="txtmoperacion" onFocus="encender(this)" onBlur="apagar(this)"><option>+</option> <option>-</option></select> </span></td>
              </tr>
           </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
		<tr>
          <td><table width="830" border="0">
              <tr>
                <td width="100"><span class="Estilo5">COLUMNA : </span></td>
				<td width="230"><span class="Estilo5"><select class="Estilo10" name="txtcolumna" size="1" id="txtcolumna" onFocus="encender(this)" onBlur="apagar(this)"><option>1</option> <option>2</option> <option>3</option> <option>4</option> </select> </span></td>
                <td width="100"><span class="Estilo5">ESTILO : </span></td>
				<td width="400"><span class="Estilo5"><select class="Estilo10" name="txtstatus" size="1" id="txtstatus" onFocus="encender(this)" onBlur="apagar(this)"><option>1-Normal</option> <option>2-Negrita</option> <option>3-Subrayada</option> <option>4-Negrita Subrayada</option> <option>5-Subtotal</option> <option>6-Total</option> <option>7-Cursiva</option> <option>8-Subtotal Negrita</option>  <option>9-Total Negrita</option> </select> </span></td>
              </tr>
           </table></td>
        </tr>		
<script language="JavaScript" type="text/JavaScript"> 
var mcalculable='<?echo $calculable;?>';
if(mcalculable=="N"){document.form1.txtcalculable.options[0].selected=true;}else{document.form1.txtcalculable.options[1].selected=true;}
var mstatus_linea='<?echo $status_linea;?>';  
if(mstatus_linea=="0"){document.form1.txtstatus_linea.options[0].selected=true;} if(mstatus_linea=="1"){document.form1.txtstatus_linea.options[1].selected=true;}
if(mstatus_linea=="2"){document.form1.txtstatus_linea.options[2].selected=true;} if(mstatus_linea=="3"){document.form1.txtstatus_linea.options[3].selected=true;}
if(mstatus_linea=="4"){document.form1.txtstatus_linea.options[4].selected=true;} if(mstatus_linea=="5"){document.form1.txtstatus_linea.options[5].selected=true;}
if(mstatus_linea=="6"){document.form1.txtstatus_linea.options[6].selected=true;} if(mstatus_linea=="6"){document.form1.txtstatus_linea.options[6].selected=true;}
if(mstatus_linea=="7"){document.form1.txtstatus_linea.options[7].selected=true;} if(mstatus_linea=="8"){document.form1.txtstatus_linea.options[8].selected=true;}
var moperacion='<?echo $moperacion;?>';
if(moperacion=="+"){document.form1.txtmoperacion.options[0].selected=true;}else{document.form1.txtmoperacion.options[1].selected=true;}
var mcolumna='<?echo $columna;?>';  
if(mcolumna=="1"){document.form1.txtcolumna.options[0].selected=true;} if(mcolumna=="2"){document.form1.txtcolumna.options[1].selected=true;}
if(mcolumna=="3"){document.form1.txtcolumna.options[2].selected=true;} if(mcolumna=="4"){document.form1.txtcolumna.options[3].selected=true;}
var mcolumna='<?echo $status;?>';  
if(mcolumna=="1"){document.form1.txtstatus.options[0].selected=true;} if(mcolumna=="2"){document.form1.txtstatus.options[1].selected=true;}
if(mcolumna=="3"){document.form1.txtstatus.options[2].selected=true;} if(mcolumna=="4"){document.form1.txtstatus.options[3].selected=true;}
if(mcolumna=="5"){document.form1.txtstatus.options[4].selected=true;} if(mcolumna=="6"){document.form1.txtstatus.options[5].selected=true;}
if(mcolumna=="7"){document.form1.txtstatus.options[6].selected=true;} if(mcolumna=="8"){document.form1.txtstatus.options[7].selected=true;}
if(mcolumna=="9"){document.form1.txtstatus.options[8].selected=true;}
</script>		
        <tr><td><p>&nbsp;</p></td></tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input name="txttipo_informe" type="hidden" id="txttipo_informe" value="<?echo $tipo_informe?>"></td>
            <td width="40">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="120" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
			<td width="100" align="center"><input name="Calculos" type="button" id="Calculos" value="Calculos" onClick="JavaScript:llamar_calculable()"></td>
			<td width="60">&nbsp;</td>
          </tr>
          <tr><td><p>&nbsp;</p></td></tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>