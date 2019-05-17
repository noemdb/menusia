<?include ("../class/conect.php"); include ("../class/funciones.php");?>
<?$equipo=getenv("COMPUTERNAME");
if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}  $tipo_nomina=substr($criterio,0,2); $fecha_desde=substr($criterio,2,10); $fecha_hasta=substr($criterio,12,10); $num_semanas=substr($criterio,22,1); $parametro=substr($criterio,23,1); $u_semana=substr($criterio,24,1); $pcod_trab=substr($criterio,25,15);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Calcular Nomina Trabajador Especifico)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_cal_nomina.php?criterio=<?echo $tipo_nomina?>'; }
function Calcula_nom() { var mcriterio='<?echo $criterio?>'; var f=document.form1;
mcriterio=mcriterio+f.txtcod_empleado.value; document.location ='Calcula_nomina.php?criterio='+mcriterio;
}
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtcod_empleado.value==""){alert("C&oacute;digo de Trabajador no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Update_carga_trab.php" onSubmit="return revisar()">
  <table width="761" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="660" border="0" cellpadding="3" cellspacing="3">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CALCULA N&Oacute;MINA A UN TRBAJADOR ESPECIFICO </span></td>
        </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="190"><span class="Estilo5">CODIGO DEL TRABAJADOR :</span></td>
                                   <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                   <td width="410"><input class="Estilo10" name="btconcepto" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trabajadores.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="190"><span class="Estilo5">NOMBRE : </span></td>
                                   <td width="570"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="80" maxlength="80" readonly > </span></td>
                 </tr>
             </table></td>
           </tr>

           <tr>
             <td>&nbsp;</td>
           </tr>
        <tr> <td>&nbsp;</td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input name="txtcriterio" type="hidden" id="txtcriterio" value="<?echo $criterio?>"></td>
            <td width="100">&nbsp;</td>
                        <td width="100" align="center"><input name="btcalcular" type="button" id="btcalcular" title="Calcular N&oacute;mina" onclick="javascript:Calcula_nom()" value="Calcular"></td>
            <td width="100" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:llamar_anterior()"></td>
            <td width="120">&nbsp;</td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>