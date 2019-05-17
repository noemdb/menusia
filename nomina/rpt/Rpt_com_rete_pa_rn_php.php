<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG001".$usuario_sia.$equipo;
if (!$_GET){ $p_letra='';$criterio=''; $tipo_nomina=''; $cod_empleado=''; $cod_concepto; $sql="SELECT * FROM NOM017  Union All SELECT * FROM NOM019  order by Tipo_Nomina, Cod_Empleado, Cod_Concepto";}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $tipo_nomina=substr($criterio,1,2);  $cod_empleado=substr($criterio,3,15); $cod_concepto=substr($criterio,16,4);}
   else{$tipo_nomina=substr($criterio,0,2);  $cod_empleado=substr($criterio,2,15); $cod_concepto=substr($criterio,15,4);}
  $codigo_mov=substr($mcod_m,0,49);  $clave=$tipo_nomina.$cod_empleado.$cod_concepto;
  $sql="SELECT * FROM NOM017  Union All SELECT * FROM NOM019  order by Tipo_Nomina, Cod_Empleado, Cod_Concepto";
  if ($p_letra=="P"){$sql="SELECT * FROM NOM017  Union All SELECT * FROM NOM019  order by Tipo_Nomina, Cod_Empleado, Cod_Concepto";}
  if ($p_letra=="U"){$sql="SELECT * FROM NOM017  Union All SELECT * FROM NOM019  order by Tipo_Nomina DESC, Cod_Empleado DESC, Cod_Concepto DESC";}
  if ($p_letra=="S"){$sql="SELECT * FROM NOM017  Union All SELECT * FROM NOM019 WHERE (text(tipo_nomina)||text(cod_empleado)||text(cod_concepto)>'$clave') Order by Tipo_Nomina, Cod_Empleado, Cod_Concepto";}
  if ($p_letra=="A"){$sql="SELECT * FROM NOM017  Union All SELECT * FROM NOM019 WHERE (text(tipo_nomina)||text(cod_empleado)||text(cod_concepto)<'$clave') Order by text(tipo_nomina)||text(cod_empleado)||text(cod_concepto) desc";}
  //print_r ($clave);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (ORDENES DE PAGO)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK  href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(mop){
 if(mop=='D'){ document.form2.submit(); }
 if(mop=='C'){ document.form3.submit(); }
 if(mop=='F'){ document.form4.submit(); }
 if(mop=='A'){ document.form5.submit(); }
 if(mop=='R'){ document.form6.submit(); }
}
function Mover_Registro(MPos){
var murl;
   murl="Rpt_com_rete_pa_rn.php";
   if(MPos=="P"){murl="Rpt_com_rete_pa_rn.php?Gcriterio=P"}
   if(MPos=="U"){murl="Rpt_com_rete_pa_rn.php?Gcriterio=U"}
   if(MPos=="S"){murl="Rpt_com_rete_pa_rn.php?Gcriterio=S"+document.form1.txttipo_nomina.value+document.form1.txtcod_empleado.value+document.form1.txtcod_concepto.value;}
   if(MPos=="A"){murl="Rpt_com_rete_pa_rn.php?Gcriterio=A"+document.form1.txttipo_nomina.value+document.form1.txtcod_empleado.value+document.form1.txtcod_concepto.value;}
   document.location = murl;
}
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<style type="text/css">
<!--
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
        color: #000000;
}
.Estilo12 {font-size: 9px}
.Estilo13 {
        font-size: 12px;
        font-style: italic;
}
.Estilo14 {font-size: 12px}

-->
</style>
</head>
<?
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
else
{
}
$res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM NOM017  Union All SELECT * FROM NOM019  order by Tipo_Nomina, Cod_Empleado, Cod_Concepto";}  if ($p_letra=="S"){$sql="SELECT * FROM NOM017  Union All SELECT * FROM NOM019  order by Tipo_Nomina Desc, Cod_Empleado Desc, Cod_Concepto Desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0)
{
  $registro=pg_fetch_array($res);
  $tipo_nomina=$registro["tipo_nomina"];
  $cod_empleado=$registro["cod_empleado"];
  $nombre=$registro["nombre"];
  $cod_concepto=$registro["cod_concepto"];
  $ced_rif=$registro["ced_rif"];
  $fecha_p_hasta=$registro["fecha_p_hasta"];
  $meses= explode("-", $fecha_p_hasta);
  $mes=$meses[1];
  if($mes=="01"){$mes="ENERO";}elseif($mes=="02"){$mes="FEBRERO";}elseif($mes=="03"){$mes="MARZO";}elseif($mes=="04"){$mes="ABRIL";}elseif($mes=="05"){$mes="MAYO";}elseif($mes=="06"){$mes="JUNIO";}elseif($mes=="07"){$mes="JULIO";}elseif($mes=="08"){$mes="AGOSTO";}elseif($mes=="09"){$mes="SEPTIEMBRE";}elseif($mes=="10"){$mes="OCTUBRE";}elseif($mes=="11"){$mes="NOVIEMBRE";}elseif($mes=="12"){$mes="DICIEMBRE";}
  $asig_ded_apo=$registro["asig_ded_apo"];
  $oculto=$registro["oculto"];
  $monto=$registro["monto"];
  $cod_concepto=$registro["cod_concepto"];
  if(($asig_ded_apo=="A")&&($oculto=="NO")){$monto=$registro["monto"];}
  elseif($cod_concepto=="508"){$monto=$registro["monto"]*-1;}
}


print_r ($mes);
print_r ($monto);

?>
<body>
<table width="1035" height="35" border="0" bgcolor="#FFFFFF" id="tablam">
  <tr>
  <td width="694""];" height="31"  bgColor=#EAEAEA  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o></td>
    <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('P')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
    <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('A')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
    <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('S')"  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
        <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('U')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
        <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Rpt_com_rete_pa_rn_re.php')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="Rpt_com_rete_pa_rn_re.php" class="menu">Menu</a></td>
  </tr>
</table>
<table width="1013" height="117" border="0" bgcolor="#FFFFFF">
  <tr>
    <td width="74" rowspan="2"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="91"></div></td>
    <td width="624" height="61"><div align="center" class="Estilo2 Estilo6">
      <div align="left"></div>
    </div></td>
    <td width="211">&nbsp;    </td>
         <td width="86">&nbsp;    </td>
 </tr>
   <tr>
     <td height="50" colspan="3"><div align="center" class="Estilo2 Estilo6"><div align="left" class="Estilo13">
          <div align="center">
            <label></label>
          </div>
     </div>
    </div>    </td>
  </tr>
</table>
<table width="1016" height="543" border="0" id="tablacuerpo">
  <tr>
    <td width="1010">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:1018px; height:579px; z-index:1; top: 171px; left: 11px;">
        <form name="form1" method="post">
          <table width="1015" height="396" border="0">
                        <tr>
              <td width="460" height="65">
                                         <? echo $tipo_nomina; ?><input name="txttipo_nomina" type="text" id="txttipo_nomina" value="<?echo $tipo_nomina?>" style="visibility:hidden;" size="1" readonly>
                                                                               <input name="txtcod_empleado" type="text" id="txtcod_empleado" value="<?echo $cod_empleado?>" style="visibility:hidden;" size="1" readonly>
                                                       <input name="txtcod_concepto" type="text" id="txtcod_concepto" value="<?echo $cod_concepto?>" style="visibility:hidden;" size="1" readonly></td>
                <td width="379"><? echo $cod_empleado; ?></td>
                <td width="161"><? echo $cod_concepto; ?></td>
                        </tr>
                        <tr>
              <td height="21" colspan="3">&nbsp; </td>
            </tr>
                   <tr>
              <td width="460" height="46">&nbsp; </td>
                <td colspan="2">&nbsp;</td>
                   </tr>
                        <tr>
               <td colspan="3" height="52"><table>
                           <tr>
                           <td width="120" height="21"></td>
                           <td width="496"></td>
                           <td width="324"></td>
                           <td width="49"></td>
                           </tr>
                           <tr>
                           <td width="120" height="21"><? echo $mes; ?></td>
                           <td width="496"><? echo $monto; ?></td>
                           <td width="324"></td>
                           <td width="49"></td>
                           </tr>
                      </table>
              <p>&nbsp;</p></td>
           </tr>

                        <tr>
               <td colspan="3" height="200"><table>
                           <tr>
                           <td width="91" height="66"><p><span class="Estilo12"><br>
                             </span></p>                             </td>
                         <td width="224" height="66">&nbsp;</td>
                           <td width="391"><div align="center"><strong>__________________________</strong></div></td>
                           <td width="283"><div align="center"></div></td>
                           </tr>
                           <tr>
                           <td width="91" height="77"><p><span class="Estilo12">ORIGINAL:<br>
                                                                                                                                 DUPLICADO:<br>
                                                                                                                                 TRIPLICADO:<br>
                             </span></p>                             </td>
                         <td width="224" height="77"><span class="Estilo12">AGENTE DE RETENCI&Oacute;N<br>
                                                                                                                               PROVEEDOR<br>
                                    ADMINISTRACI&Oacute;N</span></td>
                           <td width="391"><div align="center"><strong>FIRMA AUTORIZADA</strong></div></td>
                           <td width="283"><div align="center"></div></td>
                           </tr>
                      </table> </td>
           </tr>
          </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
