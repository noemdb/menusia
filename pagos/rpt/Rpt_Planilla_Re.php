<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG001".$usuario_sia.$equipo;
if (!$_GET){ $p_letra='';$criterio=''; $nro_planilla=''; $nro_orden=''; $sql="SELECT * FROM planilla_ret Order by nro_planilla, nro_orden";}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $nro_planilla=substr($criterio,1,8);  $nro_orden=substr($criterio,9,8);}
   else{$nro_planilla=substr($criterio,0,8);  $nro_orden=substr($criterio,8,8);}
  $codigo_mov=substr($mcod_m,0,49);   $clave=$nro_planilla.$nro_orden;
  $sql="SELECT * FROM planilla_ret Order by nro_planilla, nro_orden";
  print_r ($nro_orden_h);
  if ($p_letra=="P"){$sql="SELECT * FROM planilla_ret Order by nro_planilla, nro_orden";}
  if ($p_letra=="U"){$sql="SELECT * FROM planilla_ret Order by nro_planilla, nro_orden desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM planilla_ret where (text(nro_planilla)||text(nro_orden)>'$clave') Order by nro_planilla, nro_orden";}
  if ($p_letra=="A"){$sql="SELECT * FROM planilla_ret where (text(nro_planilla)||text(nro_orden)<'$clave') Order by text(nro_planilla)||text(nro_orden) desc";}
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
   murl="Rpt_Planilla_Re.php";
   if(MPos=="P"){murl="Rpt_Planilla_Re.php?Gcriterio=P"}
   if(MPos=="U"){murl="Rpt_Planilla_Re.php?Gcriterio=U"}
   if(MPos=="S"){murl="Rpt_Planilla_Re.php?Gcriterio=S"+document.form1.txtnro_planilla.value+document.form1.txtnro_orden.value;}
   if(MPos=="A"){murl="Rpt_Planilla_Re.php?Gcriterio=A"+document.form1.txtnro_planilla.value+document.form1.txtnro_orden.value;}
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

-->
</style>
</head>
<?
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($codigo_mov==""){$codigo_mov="";}
else
{
}

$res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM planilla_ret Order by nro_planilla, nro_orden";}  if ($p_letra=="S"){$sql="SELECT * FROM planilla_ret Order by nro_planilla desc, nro_orden desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){
  $registro=pg_fetch_array($res);
  $nro_planilla=$registro["nro_planilla"];
  $nro_orden=$registro["nro_orden"];
  $descripcion=$registro["descripcion"];
  $ced_rif=$registro["ced_rif"];
  $fecha_emision=$registro["fecha_emision"];
  $tipo_documento=$registro["tipo_documento"];
  $nro_documento=$registro["nro_documento"];
  $referencia=$registro["referencia"];
  $tipo_en=$registro["tipo_en"];
  $monto_pago=$registro["monto_pago"];
  $monto_objeto=$registro["monto_objeto"];
  $tasa=$registro["tasa"];
  $monto_retencion=$registro["monto_retencion"];
  $descripcion_ret=$registro["descripcion_ret"];
}
$nombre_empresa="GOBERNACION DEL ESTADO YARACUY";
$rif_empresa="G-20000164-0";
$direccion_empresa="EDIF. ADMINISTRATIVO 5TA AVENIDA CRUCE AV. CARACAS CON LIBERTADOR";
$tlf_empresa="0254-2315766";
$ciudad_empresa="SAN FELIPE";
$estado_empresa="YARACUY";
$date = date("d-m-Y");
$hora = date("h:i:s a");
?>
<body>
<table width="1018" height="35" border="0" bgcolor="#FFFFFF" id="tablam">
  <tr>
  <td width="689""];" height="31"  bgColor=#EAEAEA  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o></td>
    <td width="49""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('P')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
    <td width="63""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('A')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
    <td width="63""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('S')"  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
        <td width="52""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('U')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
       <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Rpt_Planilla_Ret.php')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="Rpt_Planilla_Ret.php" class="menu">Menu</a></td>
  </tr>
</table>
<table width="1015" height="76" border="0" bgcolor="#FFFFFF">
  <tr>
    <td width="289" height="26"><div align="center" class="Estilo2 Estilo4"></div></td>
    <td width="435"><div align="center" class="Estilo2 Estilo6">
      <div align="center">CONSTANCIA DE RETENCION </div>
    </div></td>
    <td width="277"><div align="right"><b></b></div></td>
  </tr>
  <tr>
    <td width="289" height="44"><div align="center" class="Estilo2 Estilo4"></div></td>
    <td width="435"><div align="center" class="Estilo2 Estilo6">
      <? echo $descripcion; ?>
    </div></td>
    <td width="277"><div align="right">NRO.<? echo $nro_planilla; ?></div></td>
  </tr>
</table>
<table width="1019" height="543" border="0" id="tablacuerpo">
  <tr>
    <td width="1029">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:1009px; height:538px; z-index:1; top: 130px; left: 13px;">
        <form name="form1" method="post">
          <table width="869" border="0">
            <tr>
              <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
					  <td width="130" scope="col"><div align="left">
                        <input name="txtnro_orden" type="text"  style="visibility:hidden;"  id="txtnro_orden3" value="<?echo $nro_orden?>" size="1" readonly>
                        <input name="txtnro_planilla" type="text"  style="visibility:hidden;"  id="txtnro_planilla2" value="<?echo $nro_planilla?>" size="1" readonly>
					    </div>
					   </td>
                      <td width="723" scope="col"><div align="center"><strong><b></b>NOMBRE DEL AGENTE DE RETENCION </strong></div></td>
                      <td width="142" scope="col"><div align="center"><strong>RIF</strong></div></td>
                    </tr>
              </table></td>
            </tr>
            <tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="837" scope="col"><div align="center"><? echo $nombre_empresa?></div></td>
                      <td width="162" scope="col"><div align="center"><? echo $rif_empresa?></div></td>
                    </tr>
                </table></td>
            </tr>
            <tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="68" height="39" scope="col"><div align="left"><strong>DIRECCION: </strong></div></td>
                      <td width="931" scope="col"><div align="left"><? echo $direccion_empresa?></div></td>
                    </tr>
                  </table></td>
            </tr>
			<tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="370" scope="col"><div align="left"><strong>TELEFONO</strong></div></td>
					  <td width="369" scope="col"><div align="left"><strong>CIUDAD</strong></div></td>
                      <td width="256" scope="col"><div align="left"><strong>ESTADO</strong></div></td>
                    </tr>
                  </table></td>
            </tr>
			<tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="370" scope="col"><div align="left"><? echo $tlf_empresa?></div></td>
					  <td width="369" scope="col"><div align="left"><? echo $ciudad_empresa?></div></td>
                      <td width="256" scope="col"><div align="left"><? echo $estado_empresa?></div></td>
                    </tr>
                  </table></td>
            </tr>
            <tr>
              <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
					  <td width="130" scope="col"><div align="left">
                        </div>
					   </td>
                      <td width="723" scope="col"><div align="center"><strong><b></b>NOMBRE DEL CONTRIBUYENTE </strong></div></td>
                      <td width="142" scope="col"><div align="center"><strong>RIF</strong></div></td>
                    </tr>
              </table></td>
            </tr>
           <tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="861" scope="col"><div align="center"><? echo $nombre_empresa?></div></td>
                      <td width="138" scope="col"><div align="center"><? echo $ced_rif?></div></td>
                    </tr>
               </table></td>
            </tr>
          <tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="68" height="39" scope="col"><div align="left"><strong>DIRECCION: </strong></div></td>
                      <td width="931" scope="col"><div align="left"><? echo $direccion_empresa?></div></td>
                    </tr>
                  </table></td>
            </tr>
           <tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="370" scope="col"><div align="left"><strong>TELEFONO</strong></div></td>
					  <td width="369" scope="col"><div align="left"><strong>CIUDAD</strong></div></td>
                      <td width="256" scope="col"><div align="left"><strong>ESTADO</strong></div></td>
                    </tr>
                  </table></td>
            </tr>
			<tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="370" scope="col"><div align="left"><? echo $tlf_empresa?></div></td>
					  <td width="369" scope="col"><div align="left"><? echo $ciudad_empresa?></div></td>
                      <td width="256" scope="col"><div align="left"><? echo $estado_empresa?></div></td>
                    </tr>
                  </table></td>
            </tr>
			<tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="370" scope="col"><div align="left"><strong>FECHA DE PAGO</strong></div></td>
					  <td width="369" scope="col"><div align="left"><strong>DOCUMENTO</strong></div></td>
                      <td width="256" scope="col"><div align="left"><strong>REFERENCIA</strong></div></td>
                    </tr>
                  </table></td>
            </tr>
			<tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="373" scope="col"><div align="left"><? echo $fecha_emision?></div></td>
					  <td width="223" scope="col"><div align="left"><? echo $tipo_documento?></div></td>
					  <td width="141" scope="col"><div align="left"><? echo $nro_documento?></div></td>
                      <td width="254" scope="col"><div align="left"><? echo $referencia?></div></td>
                    </tr>
                  </table></td>
            </tr>
			<tr>
              <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="489" scope="col"><div align="center"><strong><b></b>TIPO ENRIQUECIMIENTO </strong></div></td>
                      <td width="510" scope="col"><div align="center"><strong>MONTO PAGADO O ABONADO EN CUENTA </strong></div></td>
                    </tr>
              </table></td>
            </tr>
			<tr>
              <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="489" scope="col"><div align="center"><? echo $tipo_en?></div></td>
                      <td width="510" scope="col"><div align="center"><? echo $monto_pago?></div></td>
                    </tr>
              </table></td>
            </tr>
			<tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="370" scope="col"><div align="center"><strong>MONTO OBJETO DE RETENCION</strong></div></td>
					  <td width="369" scope="col"><div align="center"><strong>PORCENTAJE DE RETENCION</strong></div></td>
                      <td width="256" scope="col"><div align="center"><strong>MONTO RETENIDO Bs.</strong></div></td>
                    </tr>
                  </table></td>
            </tr>
			<tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="370" scope="col"><div align="center"><? echo $monto_objeto?></div></td>
					  <td width="369" scope="col"><div align="center"><? echo $tasa?></div></td>
                      <td width="256" scope="col"><div align="center"><? echo $monto_retencion?></div></td>
                    </tr>
                  </table></td>
            </tr>
           <tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="308" scope="col"></td>
					  <td width="412" scope="col"><div align="center"><strong>DESCRIPCION RETENCION </strong></div></td>
                      <td width="308" scope="col"></td>
                    </tr>
                  </table></td>
            </tr>
            <tr>
              <td height="28" colspan="2"><table width="1010">
                <tr>
                  <td height="18"><div align="center"><? echo $descripcion_ret?></div></td>
                </tr>
              </table></td>
            </tr>
			<tr>
              <td height="65" colspan="2"><table width="1010" height="63">
                <tr>
                  <td height="57">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
			<tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="306" scope="col"><div align="center"></div></td>
					  <td width="402" scope="col"><div align="center"><strong>____________________________</strong></div></td>
                      <td width="287" scope="col"><div align="center"></div></td>
                    </tr>
                  </table></td>
            </tr>
			<tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="306" scope="col"><div align="center"></div></td>
					  <td width="402" scope="col"><div align="center"><strong>FIRMA AUTORIZADA</strong></div></td>
                      <td width="287" scope="col"><div align="center"></div></td>
                    </tr>
                  </table></td>
            </tr>
			<tr>
              <td height="65" colspan="2"><table width="1010" height="63">
                <tr>
                  <td height="57">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
			<tr>
             <td colspan="2"><div align="left"><table width="1009" border="0">
                    <tr>
                      <td width="370" scope="col"><div align="center"></div></td>
					  <td width="369" scope="col"><div align="center"></div></td>
                      <td width="256" scope="col"><div align="right">Fecha: <? echo $date?> - Hora: <? echo $hora?></div></td>
                    </tr>
                  </table></td>
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
