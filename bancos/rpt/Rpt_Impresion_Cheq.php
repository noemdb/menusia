<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG001".$usuario_sia.$equipo;
if (!$_GET){ $p_letra='';$criterio=''; $cod_banco=''; $num_cheque='';$sql="SELECT BAN006.Cod_Banco, BAN006.Num_Cheque, BAN006.Monto_Cheque, PRE099.Nombre, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Num_Cheque,  BAN006.Fecha, BAN006.Nro_Orden_Pago, BAN006.Concepto FROM BAN002, BAN006, PRE099 WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif AND BAN006.Nro_Orden_Pago='00000001' ORDER BY BAN006.Cod_Banco, BAN006.Num_Cheque";}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $cod_banco=substr($criterio,1,4); $num_cheque=substr($criterio,5,8);  }
   else{$cod_banco=substr($criterio,0,4);  $num_cheque=substr($criterio,4,8);}
  $codigo_mov=substr($mcod_m,0,49);  $clave=$cod_banco.$num_cheque;
  $sql="SELECT BAN006.Cod_Banco, BAN006.Num_Cheque, BAN006.Monto_Cheque, PRE099.Nombre, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Num_Cheque, BAN006.Fecha, BAN006.Nro_Orden_Pago, BAN006.Concepto FROM BAN002, BAN006, PRE099 WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif  AND BAN006.Nro_Orden_Pago='00000001' ORDER BY BAN006.Cod_Banco, BAN006.Num_Cheque";
  if ($p_letra=="P"){$sql="SELECT BAN006.Cod_Banco, BAN006.Num_Cheque, BAN006.Monto_Cheque, PRE099.Nombre, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Fecha, BAN006.Num_Cheque, BAN006.Nro_Orden_Pago, BAN006.Concepto FROM BAN002, BAN006, PRE099 WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif ORDER BY BAN006.Cod_Banco, BAN006.Num_Cheque";}
  if ($p_letra=="U"){$sql="SELECT BAN006.Cod_Banco, BAN006.Num_Cheque, BAN006.Monto_Cheque, PRE099.Nombre, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Fecha, BAN006.Num_Cheque, BAN006.Nro_Orden_Pago, BAN006.Concepto FROM BAN002, BAN006, PRE099 WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif ORDER BY BAN006.Cod_Banco DESC, BAN006.Num_Cheque DESC";}
  if ($p_letra=="S"){$sql="SELECT BAN006.Cod_Banco, BAN006.Num_Cheque, BAN006.Monto_Cheque, PRE099.Nombre, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Fecha, BAN006.Num_Cheque, BAN006.Nro_Orden_Pago, BAN006.Concepto FROM BAN002, BAN006, PRE099 WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif AND (text(BAN006.Cod_Banco)||text(BAN006.Num_Cheque)>'$clave') Order by BAN006.Cod_Banco, BAN006.Num_Cheque";}
  if ($p_letra=="A"){$sql="SELECT BAN006.Cod_Banco, BAN006.Num_Cheque, BAN006.Monto_Cheque, PRE099.Nombre, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Fecha, BAN006.Num_Cheque, BAN006.Nro_Orden_Pago, BAN006.Concepto FROM BAN002, BAN006, PRE099 WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif AND (text(BAN006.Cod_Banco)||text(BAN006.Num_Cheque)<'$clave') Order by text(BAN006.Cod_Banco)||text(BAN006.Num_Cheque) desc";}
  //print_r ($clave);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (NOTAS DE DEBITO)</title>
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
   murl="Rpt_Impresion_Transferen.php";
   if(MPos=="P"){murl="Rpt_Impresion_Cheq.php?Gcriterio=P"}
   if(MPos=="U"){murl="Rpt_Impresion_Cheq.php?Gcriterio=U"}
   if(MPos=="S"){murl="Rpt_Impresion_Cheq.php?Gcriterio=S"+document.form1.textcod_banco.value+document.form1.textnum_cheque.value;}
   if(MPos=="A"){murl="Rpt_Impresion_Cheq.php?Gcriterio=A"+document.form1.textcod_banco.value+document.form1.textnum_cheque.value;}
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
if ($filas==0){if ($p_letra=="A"){$sql="SELECT BAN006.Cod_Banco, BAN006.Num_Cheque, BAN006.Monto_Cheque, PRE099.Nombre, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Num_Cheque, BAN006.Fecha, BAN006.Nro_Orden_Pago, BAN006.Concepto FROM BAN002, BAN006, PRE099 WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif ORDER BY BAN006.Cod_Banco, BAN006.Num_Cheque";}  if ($p_letra=="S"){$sql="SELECT BAN006.Cod_Banco, BAN006.Num_Cheque, BAN006.Monto_Cheque, PRE099.Nombre, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Num_Cheque, BAN006.Fecha, BAN006.Nro_Orden_Pago, BAN006.Concepto FROM BAN002, BAN006, PRE099 WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif ORDER BY BAN006.Cod_Banco DESC, BAN006.Num_Cheque DESC";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0)
{
  $registro=pg_fetch_array($res);
  $cod_banco=$registro["cod_banco"];
  $num_cheque=$registro["num_cheque"];
  $monto_cheque=$registro["monto_cheque"];
  $nombre=$registro["nombre"];
  $nombre_banco=$registro["nombre_banco"];
  $nro_cuenta=$registro["nro_cuenta"];
  $nro_orden_pago=$registro["nro_orden_pago"];
  $concepto=$registro["concepto"];
  $fecha=$registro["fecha"];

}
$clave=$nro_orden_pago;
$criterio=$fecha.$nro_orden_pago;

$nombre_empresa="GOBERNACION DEL ESTADO YARACUY";
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
        <td width="48""];" height="31"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Rpt_Impresion_Cheque.php')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="Rpt_Impresion_Cheque.php" class="menu">Menu</a></td>
  </tr>
</table>
<table width="982" height="900" border="1" id="tablacuerpo">
  <tr>
    <td width="1011" height="743">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:976px; height:750px; z-index:1; top: 53px; left: 12px;">
        <form name="form1" method="post">
          <table width="1015" height="842" border="0">
                        <tr>
                <td colspan="3" height="51"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="10" height="39"></td>
                                   <td width="646" height="39"><div align="left"> </div>
                   <p align="left" class="Estilo14"><input name="textnum_cheque" style="visibility:hidden;"  type="text" id="textnum_cheque" value="<?echo $num_cheque?>" size="1" readonly>
                                     <input name="textcod_banco" style="visibility:hidden;"  type="text" id="textcod_banco" value="<?echo $cod_banco?>" size="1" readonly><strong> </strong></p></td>
                                   <td width="335"><div align="left"> </div>
                   <p align="right" class="Estilo14">***<? echo $monto_cheque; ?>***</p></td>
                                </tr>
                                </table></td>
                        </tr>
                        <tr>
                <td colspan="3" height="51"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="265" height="39"></td>
                                   <td width="695" height="39"><div align="left"> </div>
                   <p align="left" class="Estilo14">***<? echo $nombre; ?>***<strong> </strong></p></td>

                                </tr>
                                </table></td>
                        </tr>
                        <tr>
                <td colspan="3" height="51"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="174" height="39"></td>
                                   <td width="786" height="39"><div align="left"> </div>
                   <p align="left" class="Estilo14">CANTIDAD_EN_ LETRAS </p></td>

                                </tr>
                                </table></td>
                        </tr>
                        <tr>
                <td colspan="3" height="51"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="175" height="39"></td>
                                   <td width="785" height="39"><div align="left"> </div>
                   <p align="left" class="Estilo14">FECHA_EN_LETRAS</p></td>

                                </tr>
                                </table></td>
                        </tr>
                        <tr>
                <td colspan="3" height="51"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="175" height="109"></td>
                                </tr>
                                </table></td>
                        </tr>
                        <tr>
                <td colspan="3" height="51"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="301" height="39"><div align="center"><b><? echo $nombre_banco; ?></b></div></td>
                                    <td width="330" height="39"><div align="center"><b><? echo $nro_cuenta; ?></b></div></td>
                                   <td width="325"><div align="center"><b><? echo $num_cheque; ?></b></div></td>
                                </tr>
                                </table></td>
                        </tr>
                        <tr>
                <td colspan="3" height="35"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="120" height="27"><div align="center"><strong>Orden de Pago : </strong></div></td>
                                    <td width="158" height="27"><div align="left"><? echo $nro_orden_pago; ?></div></td>
                                   <td width="678"><div align="center"></div></td>
                                </tr>
                          </table></td>
                        </tr>
                        <tr>
                <td colspan="3" height="35"><table width="970" border="0" align="left" bordercolor="#000000" >
                                <tr>
                                        <td width="106" height="27"><div align="left"><strong>Concepto : </strong></div></td>
                                    <td width="854" height="27"><div align="left"><? echo $concepto; ?></div></td>
                                </tr>
                          </table></td>
                        </tr>
                   <tr>
              <td colspan="3"><table width="970">
                                <tr>
                                        <td width="9" height="39"></td>
                                        <td colspan="2"><div align="left"> </div>
                   <p align="left" class="Estilo14"><strong>BANCO HASTA :</strong><? echo $cod_banco; ?>           <? echo $num_cheque; ?></p></td>
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
               <td colspan="3" height="29"><table width="971">
                                <tr>
                                        <td width="982" height="21">
                    <div id="T11" class="tab-body">
                      <iframe src="Det_contabilidad_financiera.php?criterio=<?echo $criterio?>"  width="1010" height="170" scrolling="auto" frameborder="0"> </iframe>
                  </div></td>
                                </tr>
                          </table></td>
            </tr>
                        <tr>
               <td colspan="3" height="29"><table width="971">
                                <tr>
                                        <td width="982" height="21">
                    <div id="T11" class="tab-body">
                      <iframe src="Det_contabilidad_presupuestaria.php?clave=<?echo $nro_orden_pago?>"  width="1010" height="170" scrolling="auto" frameborder="0"> </iframe>
                  </div></td>
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
