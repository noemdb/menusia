<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG001".$usuario_sia.$equipo;
if (!$_GET){ $p_letra='';$criterio=''; $tipo_nomina=''; $cod_empleado='';$sql="SELECT *  FROM NOM017 WHERE ((NOM017.Oculto='NO') AND (NOM017.Status_Emp='ACTIVO')) ORDER BY Tipo_Nomina, Cod_Empleado";}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $tipo_nomina=substr($criterio,1,2); $cod_empleado=substr($criterio,3,15);  }
   else{$tipo_nomina=substr($criterio,0,2);  $cod_empleado=substr($criterio,2,15);}
  $clave=$tipo_nomina.$cod_empleado;
  $sql="SELECT *  FROM NOM017 WHERE ((NOM017.Oculto='NO') AND (NOM017.Status_Emp='ACTIVO')) ORDER BY Tipo_Nomina, Cod_Empleado";
  if ($p_letra=="P"){$sql="SELECT *  FROM NOM017 WHERE ((NOM017.Oculto='NO') AND (NOM017.Status_Emp='ACTIVO')) ORDER BY Tipo_Nomina, Cod_Empleado";}
  if ($p_letra=="U"){$sql="SELECT *  FROM NOM017 WHERE ((NOM017.Oculto='NO') AND (NOM017.Status_Emp='ACTIVO')) ORDER BY Tipo_Nomina DESC, Cod_Empleado DESC";}
  if ($p_letra=="S"){$sql="SELECT *  FROM NOM017 WHERE ((NOM017.Oculto='NO') AND (NOM017.Status_Emp='ACTIVO')) AND (text(tipo_nomina)||text(cod_empleado)>'$clave') Order by Tipo_Nomina, Cod_Empleado";}
  if ($p_letra=="A"){$sql="SELECT *  FROM NOM017 WHERE ((NOM017.Oculto='NO') AND (NOM017.Status_Emp='ACTIVO')) AND (text(tipo_nomina)||text(cod_empleado)<'$clave') Order by text(tipo_nomina)||text(cod_empleado) desc";}
  //print_r ($clave);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reporte Deglose de N&oacute;mina)</title>
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
   murl="Rpt_desglo_nomi_rn.php";
   if(MPos=="P"){murl="Rpt_desglo_nomi_rn.php?Gcriterio=P"}
   if(MPos=="U"){murl="Rpt_desglo_nomi_rn.php?Gcriterio=U"}
   if(MPos=="S"){murl="Rpt_desglo_nomi_rn.php?Gcriterio=S"+document.form1.texttipo_nomina.value+document.form1.textcod_empleado.value;}
   if(MPos=="A"){murl="Rpt_desglo_nomi_rn.php?Gcriterio=A"+document.form1.texttipo_nomina.value+document.form1.textcod_empleado.value;}
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
if ($filas==0){if ($p_letra=="A"){$sql="SELECT *  FROM NOM017 WHERE ((NOM017.Oculto='NO') AND (NOM017.Status_Emp='ACTIVO')) ORDER BY Tipo_Nomina, Cod_Empleado";}  if ($p_letra=="S"){$sql="SELECT *  FROM NOM017 WHERE ((NOM017.Oculto='NO') AND (NOM017.Status_Emp='ACTIVO')) ORDER BY Tipo_Nomina DESC, Cod_Empleado DESC";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0)
{
  $registro=pg_fetch_array($res);
  $tipo_nomina=$registro["tipo_nomina"];
  $cod_empleado=$registro["cod_empleado"];
  $des_nomina=$registro["des_nomina"];
  $fecha_desde=$registro["fecha_desde"];
  $fecha_hasta=$registro["fecha_hasta"];
  $asignacion=$registro["asignacion"];
  if($registro["asignacion"]=="SI"){$monto=$registro["monto"];}else{$monto='0';}
  $asignacion=$asignacion+$monto;
  if($registro["asignacion"]=="NO"){$monto=$registro["monto"];}else{$monto='0';}
  $deduccion=$deduccion+$monto;
  $neto=$asignacion-$deduccion;
  $nombre=$registro["nombre"];
}
print_r($monto);

?>
<body>
<table width="982" height="35" border="0" bgcolor="#FFFFFF" id="tablam">
  <tr>
  <td width="685""];" height="31"  bgColor=#EAEAEA  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o></td>
    <td width="64""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('P')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
    <td width="64""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('A')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
    <td width="64""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('S')"  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
        <td width="64""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('U')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
        <td width="48""];" height="31"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Rpt_desglo_nomi_rn_re.php')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="Rpt_desglo_nomi_rn_re.php" class="menu">Menu</a></td>
  </tr>
</table>
<table width="981" height="38" border="0" bgcolor="#FFFFFF">
  <tr>
    <td width="79" height="44"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td><div align="center" class="Estilo2 Estilo6"><div align="left"></div></div><div align="right"><b></b></div></td>
  </tr>
</table>
<table width="982" height="900" border="1" id="tablacuerpo">
  <tr>
    <td width="1011" height="743">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:976px; height:750px; z-index:1; top: 103px; left: 15px;">
        <form name="form1" method="post">
          <table width="1015" height="855" border="0">
		  				<tr>
                          <td colspan="3" height="32"><table width="970" border="0" align="left" bordercolor="#000033" >
                                <tr>
                                        <td height="24"><div align="center"><strong>DESGLOSE DE NOMINA </strong></div></td>
							    </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td colspan="3" height="35"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="786" height="24"><strong>Tipo Nomina:</strong> <? echo $tipo_nomina; ?> <? echo $des_nomina; ?></td>
										<td width="174" height="24"><input name="texttipo_nomina" style="visibility:hidden;"  type="text" id="texttipo_nomina" value="<?echo $tipo_nomina?>" size="1" readonly>
                                  <input name="textcod_empleado" style="visibility:hidden;"  type="text" id="textcod_empleado" value="<?echo $cod_empleado?>" size="1" readonly></td>
                                </tr>
                          </table></td>
                        </tr>
						<tr>
                          <td colspan="3" height="35"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="786" height="24"><strong>Fecha:</strong> <? echo $fecha_desde; ?> <strong> al </strong><? echo $fecha_hasta; ?></td>
                                </tr>
                          </table></td>
                        </tr>
                        <tr>
                			<td colspan="3"><table width="971" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                  <td width="87"><div align="left"><strong>Codigo </strong></div></td>
                                  <td width="93"><strong>Asignaciones</strong></td>
								  <td width="88"><strong>Deducciones</strong></td>
                                  <td width="45"><div align="left"><strong>Neto</strong></div></td>
								  <td width="43"><div align="center"><strong>50000</strong></div></td>
                                  <td width="44"><div align="center"><strong>20000</strong></div></td>
								  <td width="40"><div align="center"><strong>10000</strong></div></td>
								  <td width="38"><div align="center"><strong>5000</strong></div></td>
								  <td width="38"><div align="center"><strong>2000</strong></div></td>
								  <td width="37"><div align="center"><strong>1000</strong></div></td>
								  <td width="34"><div align="center"><strong>500</strong></div></td>
								  <td width="36"><div align="center"><strong>100</strong></div></td>
								  <td width="22"><div align="center"><strong>50</strong></div></td>
								  <td width="22"><div align="center"><strong>20</strong></div></td>
								  <td width="21"><div align="center"><strong>10</strong></div></td>
								  <td width="17"><div align="center"><strong>5</strong></div></td>
								  <td width="18"><div align="center"><strong>2</strong></div></td>
								  <td width="21"><div align="center"><strong>1</strong></div></td>
								  <td width="34"><div align="center"><strong>0.50</strong></div></td>
								  <td width="42"><div align="center"><strong>0.25</strong></div></td>
								  <td width="28"><div align="center"><strong>0.10</strong></div></td>
								  <td width="33"><div align="center"><strong>0.05</strong></div></td>
                                </tr>
                          </table></td>
                        </tr>
                        <tr>
               			   <td colspan="3"><table width="971" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                  <td width="87"><div align="left"><strong>Nombre </strong></div></td>
                                </tr>
                          </table></td>
                        </tr>
						<tr>
                			<td height="32" colspan="3"><table width="971" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                  <td width="87"><div align="left"><? echo $cod_empleado; ?></div></td>
                                  <td width="93"><div align="left"><? echo $asignacion; ?></div></td>
								  <td width="88"><div align="left"><? echo $deduccion; ?></div></td>
                                  <td width="45"><div align="left"><? echo $neto; ?></div></td>
								  <td width="43"><div align="center"><strong>50000</strong></div></td>
                                  <td width="44"><div align="center"><strong>20000</strong></div></td>
								  <td width="40"><div align="center"><strong>10000</strong></div></td>
								  <td width="38"><div align="center"><strong>5000</strong></div></td>
								  <td width="38"><div align="center"><strong>2000</strong></div></td>
								  <td width="37"><div align="center"><strong>1000</strong></div></td>
								  <td width="34"><div align="center"><strong>500</strong></div></td>
								  <td width="36"><div align="center"><strong>100</strong></div></td>
								  <td width="22"><div align="center"><strong>50</strong></div></td>
								  <td width="22"><div align="center"><strong>20</strong></div></td>
								  <td width="21"><div align="center"><strong>10</strong></div></td>
								  <td width="17"><div align="center"><strong>5</strong></div></td>
								  <td width="18"><div align="center"><strong>2</strong></div></td>
								  <td width="21"><div align="center"><strong>1</strong></div></td>
								  <td width="34"><div align="center"><strong>0.50</strong></div></td>
								  <td width="42"><div align="center"><strong>0.25</strong></div></td>
								  <td width="28"><div align="center"><strong>0.10</strong></div></td>
								  <td width="33"><div align="center"><strong>0.05</strong></div></td>
                                </tr>
                          </table></td>
                        </tr>
                        <tr>
                <td colspan="3"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                   <td ></td>
                                </tr>
                          </table></td>
                        </tr>
                        <tr>
                <td height="29" ><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="175" height="23"><div align="left"><? echo $nombre; ?></div></td>
                                </tr>
                          </table></td>
                        </tr>
                        <tr>
                <td colspan="3" height="51"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="301" height="39"><div align="center"></div></td>
                                    <td width="330" height="39"><div align="center"></div></td>
                                   <td width="325"><div align="center"></div></td>
                                </tr>
                                </table></td>
                        </tr>
                        <tr>
                <td colspan="3" height="35"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="120" height="27"><div align="center"></div></td>
                                    <td width="158" height="27"><div align="left"></div></td>
                                   <td width="678"><div align="center"></div></td>
                                </tr>
                          </table></td>
                        </tr>
                        <tr>
                <td colspan="3" height="35"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="106" height="27"><div align="left"></div></td>
                                    <td width="854" height="27"><div align="left"></div></td>
                                </tr>
                          </table></td>
                        </tr>
                   <tr>
              <td colspan="3"><table width="970">
                                <tr>
                                        <td width="9" height="39"></td>
                                        <td colspan="2"><div align="left"> </div>
                   <p align="left" class="Estilo14">&nbsp;</p></td>
                            </tr>
                                <tr>
                                        <td width="9" height="39"></td>
                                        <td width="656" height="43"><div align="left"> </div>
                   <p align="left" class="Estilo14">&nbsp;</p></td>
                                   <td width="328"><div align="left"> </div>
                   <p align="left" class="Estilo14">

                                </p></td>
                                </tr>
                          </table></td>
            </tr>
                         <tr>
               <td colspan="3" height="47"><table width="970">
                                <tr>
                                        <td width="9" height="39"></td>
                                        <td colspan="2"><div align="left"> </div>
                   <p align="left" class="Estilo14">&nbsp;</p></td>
                                </tr>
                          </table></td>
            </tr>
                      
                       
                        <tr>
               <td colspan="3" height="42"><table width="969">
                           <tr>
                           <td height="34"></td>
                           </tr>
                      </table> </td>
           </tr>

                        <tr>
               <td colspan="3" height="200"> </td>
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
