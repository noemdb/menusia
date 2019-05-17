<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG001".$usuario_sia.$equipo;
if (!$_GET){ $p_letra='';$criterio=''; $num_cheque='';$cod_banco=''; $sql="SELECT * FROM BAN002, BAN001 WHERE BAN002.Tipo_Cuenta = BAN001.Tipo_Cuenta  ORDER BY Cod_Banco, Num_Cheque";}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $cod_banco=substr($criterio,1,4); $num_cheque=substr($criterio,5,8);}
   else{  $cod_banco=substr($criterio,0,4);  $num_cheque=substr($criterio,4,8);}
  $codigo_mov=substr($mcod_m,0,49);  $clave=$cod_banco.$num_cheque;
  $sql="SELECT * FROM BAN002, BAN001 WHERE BAN002.Tipo_Cuenta = BAN001.Tipo_Cuenta  ORDER BY Cod_Banco, Num_Cheque";
  if ($p_letra=="P"){$sql="SELECT * FROM BAN002, BAN001 WHERE BAN002.Tipo_Cuenta = BAN001.Tipo_Cuenta  ORDER BY Cod_Banco, Num_Cheque";}
  if ($p_letra=="U"){$sql="SELECT * FROM BAN002, BAN001 WHERE BAN002.Tipo_Cuenta = BAN001.Tipo_Cuenta Order by  Cod_Banco DESC, Num_Cheque DESC";}
  if ($p_letra=="S"){$sql="SELECT * FROM BAN002, BAN001 WHERE BAN002.Tipo_Cuenta = BAN001.Tipo_Cuenta AND (text(cod_banco)||text(num_cheque)>'$clave') Order by Cod_Banco, Num_Cheque";}
  if ($p_letra=="A"){$sql="SELECT * FROM BAN002, BAN001 WHERE BAN002.Tipo_Cuenta = BAN001.Tipo_Cuenta AND (text(cod_banco)||text(num_cheque)<'$clave') Order by text(cod_banco)||text(num_cheque) desc";}
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
   murl="Rpt_Rel_Saldo_Bancario_Gru.php";
   if(MPos=="P"){murl="Rpt_Rel_Saldo_Bancario_Gru.php?Gcriterio=P"}
   if(MPos=="U"){murl="Rpt_Rel_Saldo_Bancario_Gru.php?Gcriterio=U"}
   if(MPos=="S"){murl="Rpt_Rel_Saldo_Bancario_Gru.php?Gcriterio=S"+document.form1.textcod_banco.value+document.form1.textnum_cheque.value;}
   if(MPos=="A"){murl="Rpt_Rel_Saldo_Bancario_Gru.php?Gcriterio=A"+document.form1.textcod_banco.value+document.form1.textnum_cheque.value;}
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
.Estilo14 {font-size: 12px}
.Estilo15 {
        font-size: 18px;
        font-weight: bold;
        color: #000099;
}

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
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM BAN002, BAN001 WHERE BAN002.Tipo_Cuenta = BAN001.Tipo_Cuenta Order by  Cod_Banco, Num_Cheque";}  if ($p_letra=="S"){$sql="SELECT * FROM BAN002, BAN001 WHERE BAN002.Tipo_Cuenta = BAN001.Tipo_Cuenta Order by  Cod_Banco Desc, Num_Cheque Desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0)
{
  $registro=pg_fetch_array($res);
  $cod_banco=$registro["cod_banco"];
  $num_cheque=$registro["num_cheque"];
  $nombre_banco=$registro["nombre_banco"];
  $nro_cuenta=$registro["nro_cuenta"];
  $descripcion_banco=$registro["descripcion_banco"];
  $s_inic_libro=$registro["s_inic_libro"];
  $total=$total+$registro["s_inic_libro"]; 
  $tipo_bco=$registro["tipo_bco"];
  if($tipo_bco=="1"){$des_tipo_bco='GASTOS CORRIENTES';}else
  if($tipo_bco=="3"){$des_tipo_bco='FONDOS DE TERCERO';}else
  if($tipo_bco=="5"){$des_tipo_bco='FIDEICOMISOS-LAEE';}else
  if($tipo_bco=="6"){$des_tipo_bco='FIDEICOMISOS-LAEE';}else
  if($tipo_bco=="7"){$des_tipo_bco='FIEM';}else
  if($tipo_bco=="8"){$des_tipo_bco='PEND. POR CANCELAR';}else{$des_tipo_bco='';}     
}
$clave=$cod_banco.$num_cheque;
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
        <td width="48""];" height="31"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Rpt_Orden_Pago.php')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="Rpt_Impresion_Transferencias.php" class="menu">Menu</a></td>
  </tr>
</table>
<table width="982" height="92" border="1" bgcolor="#FFFFFF">
  <tr>
    <td width="74" rowspan="2"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="91"></div></td>
    <td height="35"><div align="center" class="Estilo2 Estilo6">
      <div align="left"><p align="left" class="Estilo14">
                  <? echo $nombre_empresa; ?>
        </p></div>
    </div>    </td>
  </tr>
   <tr>
     <td height="51"><div align="center"><span class="Estilo15"> </span></div></td>
  </tr>
</table>
<table width="982" height="749" border="1" id="tablacuerpo">
  <tr>
    <td width="1011" height="743">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:976px; height:750px; z-index:1; top: 151px; left: 14px;">
        <form name="form1" method="post">
          <table width="1015" height="531" border="0">
            <tr>
                <td colspan="3" height="51"><table width="970" border="1" align="left" bordercolor="#000000" >
                    <tr>
                        <td width="335" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
                        <p align="center" class="Estilo14"><strong>BANCO</strong></p></td>
                        <td width="335" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>                          <p align="center" class="Estilo14"><strong>CUENTA Nro. </strong></p></td>
						<td width="335" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>						  <p align="center" class="Estilo14"><strong>DESCRIPCION</strong></p></td>
						<td width="335" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
					    <p align="center" class="Estilo14"><strong>SALDO ACTUAL </strong></p></td>
                  </tr>
                  </table></td>
            </tr>
              <tr>
                <td height="44" colspan="3"><table width="970">
                    <tr>
                        <td width="226"  bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
                      <p align="center" class="Estilo14"><? echo $nombre_banco; ?></p></td>
                        <td width="240" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"></div><p align="center" class="Estilo14"><? echo $nro_cuenta; ?></p></td>
						<td width="247" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div><p align="center" class="Estilo14"><? echo $descripcion_banco; ?></p></td>
						<td width="237" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
					    <p align="center" class="Estilo14"><? echo $s_inic_libro; ?></p></td>
                  </tr>
                </table></td>
             </tr>
            <tr>
                <td height="44" colspan="3"><table width="970">
                    <tr>
                        <td width="226" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
                      <p align="center" class="Estilo14">&nbsp;</p></td>
                      <td width="240" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"><input name="textnum_cheque" style="visibility:hidden;"  type="text" id="textnum_cheque" value="<?echo $num_cheque?>" size="1" readonly>
                                <input name="textcod_banco" style="visibility:hidden;"  type="text" id="textcod_banco" value="<?echo $cod_banco?>" size="1" readonly>
                      </div></td>
						<td width="250" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
					  <p align="right" class="Estilo14"><strong>TOTAL BANCO : </strong></p></td>
						<td width="234" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
					    <p align="center" class="Estilo14"><? echo $total; ?></p></td>
                  </tr>
                </table></td>
            </tr>
			<tr>
                <td height="48" colspan="3"><table width="970">
                    <tr>
                        <td width="226" height="40" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
                      <p align="center" class="Estilo14">&nbsp;</p></td>
                      <td width="250" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
					  <p align="right" class="Estilo14"><strong>TOTAL : </strong></p></td>
					<td width="250" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
					  <p align="center" class="Estilo14"><? echo $des_tipo_bco; ?></p></td>
						<td width="234" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
					    <p align="center" class="Estilo14"><? echo $total; ?></p></td>
                  </tr>
              </table></td>
            </tr>
			<tr>
                <td height="48" colspan="3"><table width="970">
                    <tr>
                        <td width="226" height="40" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
                      <p align="center" class="Estilo14">&nbsp;</p></td>
                      <td width="250" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
					  <p align="right" class="Estilo14"><strong>TOTAL GENERAL: </strong></p></td>
					<td width="250" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
					  <p align="center" class="Estilo14">&nbsp;</p></td>
						<td width="234" bordercolor="#000000" bgcolor="#FFFFFF"><div align="left"> </div>
					    <p align="center" class="Estilo14"><? echo $total; ?></p></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
               <td colspan="3" height="29"><table width="971">
                 <tr>
                    <td width="982" height="21"></td>
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
