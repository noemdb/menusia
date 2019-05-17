<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME"); $nombre="";$cod_empleado=""; $fecha_hoy=asigna_fecha_hoy();
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$fecha_liquidacion=$fecha_hoy; $error=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Calculo de Liquidacion)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function llamar_anterior(){  history.back(); }
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtcod_empleado.value==""){alert("Codigo de Empleado no puede estar Vacia");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;font-weight: bold;color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="carga_cal_liq.php" onSubmit="return revisar()">
  <table width="751" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="744" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CALCULO DE LIQUIDACION</span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
		<tr>
             <td><table width="740">
                 <tr>
                   <td width="150"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR  : </span></td>
                   <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                   <td width="480"><input class="Estilo10" name="btconcepto" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trabajadores.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 </tr>
             </table></td>
        </tr>        
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="740" border="0">
              <tr>
                <td width="92"><span class="Estilo5">NOMBRE :</span></td>
                <td width="589"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="95" maxlength="250" readonly value="<?echo $nombre?>">
                </span></td>
              </tr>
            </table> </td>
        </tr>
		<tr>  <td>&nbsp;</td> </tr>
		   <tr>
             <td><table width="740">
               <tr>
                 <td width="150"><span class="Estilo5">FECHA DE LIQUIDACION :</span></td>
                 <td width="190"><span class="Estilo5"><input class="Estilo10" name="txtfecha_liquidacion" type="text" id="txtfecha_liquidacion" size="10" maxlength="10"  value="<?echo $fecha_liquidacion?>" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="150"><span class="Estilo5">TIPO DE LIQUIDACION :</span></td>
				 <td width="250"><span class="Estilo5"><select class="Estilo10" name="txttipo_liquidacion" size="1" id="txttipo_liquidacion" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>JUSTIFICADO</option> <option>RENUNCIA</option> <option>INJUSTIFICADO</option> <option>FALLECIDO</option> <option>INCAPACITADO</option> <option>FIN CONTRATO</option>  <option>JUBILACION</option> </select>  </span></td>
				</tr>
             </table></td>
           </tr>
        <tr>
          <td><span class="Estilo5"> </span>  </td>
        </tr>
        <tr><td>&nbsp;</td> </tr>       
      </table>
        <table width="540" align="center">
          <tr>
            <td width="32"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value=""></td>
            <td width="80"><input name="txtref_comp" type="hidden" id="txtref_comp" value=""></td>
			<?if($error==0){?>
            <td width="97" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
			<?}?>
            <td width="94" align="center">&nbsp;</td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="113">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>