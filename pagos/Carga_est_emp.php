<? include ("../class/conect.php"); include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$mcod_m="PAG001".$usuario_sia.$equipo;$codigo_mov=substr($mcod_m,0,49); $ced_emp="";}
else{$codigo_mov=$_GET["codigo_mov"]; $ced_emp=$_GET["ced_emp"]; $user=$_GET["user"];$password=$_GET["password"];$dbname=$_GET["dbname"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Cargar Estructura Empleado)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mhost='<?php echo $host ?>';
var mport='<?php echo $port ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function llamar_anterior(){ document.location ='Det_inc_comp_ord.php?codigo_mov=<?echo $codigo_mov?>&bloqueada=N'; }
function revisar(){var f=document.form1; 
   if(f.txtcod_est.value==""){alert("Codigo Estructura no puede estar Vacio");return false;}
   if(f.txtcedula.value==""){alert("Cedula Trabajador no puede estar Vacia"); return false; } else{f.txtcedula.value=f.txtcedula.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 {font-size: 16px;        font-weight: bold;        color: #FFFFFF;}
.Estilo10 {font-size: 10px}
-->
</style>
</head>
<?
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$cod_est="00000004"; $des_est="";
$sql="select descripcion_est from pag006 where cod_estructura='$cod_est'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $des_est=$registro["descripcion_est"];   }
$ced_emp=elimina_guion($ced_emp); $ced_emp=elimina_puntos($ced_emp); $p=substr($ced_emp,0,1);
if($p=="V"){$ced_emp=substr($ced_emp,1,10);}
?>
<body>
<form name="form1" method="post" action="carga_est_trab.php" onSubmit="return revisar()">
  <table width="736" height="190" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="732" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CARGAR ESTRUCTURA DE TRABAJADOR </span></td>
        </tr>
        <tr><td>&nbsp;</td> </tr>
        <tr>
          <td><table width="737">
		    <tr>
                <td width="99"><span class="Estilo5">C&Oacute;DIGO  : </span></td>
                <td width="69"><span class="Estilo5">
                  <input name="txtcod_est" type="text" id="txtcod_est" title="Registre el C&oacute;digo de la Estructura"  size="10" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);" value="<?echo $cod_est?>">
                </span></td>
                <td width="432"><input name="btCatest" type="button" id="btCatest" title="Abrir Catalogo C&oacute;digo de Estructuras"  onclick="VentanaCentrada('Cat_estructura.php?codigo_mov=<?echo $codigo_mov?>&ref_comp=','SIA','','750','500','true')" value="..."></td>
            </tr>
          </table></td>
        </tr>
		<tr>
          <td><table width="740" border="0">
              <tr>
                <td width="92"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                <td width="589"><span class="Estilo5">
                  <input name="txtdescripcion_est" type="text" id="txtdescripcion_est" size="95" maxlength="250" readonly value="<?echo $des_est?>">
                </span></td>
              </tr>
            </table> </td>
        </tr>
        <tr>
          <td><table width="739" border="0">
            <tr>
              <td width="117"><span class="Estilo5">CEDULA :</span></td>
              <td width="153"><span class="Estilo5">
                <input name="txtcedula" type="text" id="txtcedula" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $ced_emp?>" >
              </span> </td>
              <td width="143">&nbsp;</td>
              <td width="308"></td>
            </tr>
          </table></td>
        </tr>
        
        <tr>
          <td><span class="Estilo5"> </span>            </td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>              </td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100">&nbsp;</td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>
