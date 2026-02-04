<?php include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG001".$usuario_sia.$equipo;
if (!$_GET){ $p_letra='';$criterio=''; $num_cheque='';$referencia=''; $sql="SELECT * FROM BAN004, BAN002 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco Order by  Num_Cheque, Referencia";}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $num_cheque=substr($criterio,1,8);  $referencia=substr($criterio,9,8);}
   else{$num_cheque=substr($criterio,0,8);  $referencia=substr($criterio,8,8);}
  $codigo_mov=substr($mcod_m,0,49);  $clave=$num_cheque.$referencia;
  $sql="SELECT * FROM BAN004, BAN002 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco Order by  Num_Cheque, Referencia";
  if ($p_letra=="P"){$sql="SELECT * FROM BAN004, BAN002 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco Order by  Num_Cheque, Referencia";}
  if ($p_letra=="U"){$sql="SELECT * FROM BAN004, BAN002 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco Order by  Num_Cheque DESC, Referencia DESC";}
  if ($p_letra=="S"){$sql="SELECT * FROM BAN004, BAN002 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco AND (text(num_cheque)||text(referencia)>'$clave') Order by Num_Cheque, Referencia";}
  if ($p_letra=="A"){$sql="SELECT * FROM BAN004, BAN002 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco AND (text(num_cheque)||text(referencia)<'$clave') Order by text(num_cheque)||text(referencia) desc";}
  //print_r ($clave);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (NOTAS DE DEBITO)</title>
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
   if(MPos=="P"){murl="Rpt_Impresion_Transferen.php?Gcriterio=P"}
   if(MPos=="U"){murl="Rpt_Impresion_Transferen.php?Gcriterio=U"}
   if(MPos=="S"){murl="Rpt_Impresion_Transferen.php?Gcriterio=S"+document.form1.textnum_cheque.value+document.form1.textreferencia.value;}
   if(MPos=="A"){murl="Rpt_Impresion_Transferen.php?Gcriterio=A"+document.form1.textnum_cheque.value+document.form1.textreferencia.value;}
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
.Estilo14 {font-size: 12px}
.Estilo15 {
	font-size: 18px;
	font-weight: bold;
	color: #000099;
}

-->
</style>
</head>
<?php 
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
else
{
}
$res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM BAN004, BAN002 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco Order by Num_Cheque, Referencia";}  if ($p_letra=="S"){$sql="SELECT * FROM BAN004, BAN002 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco Order by Num_Cheque Desc, Referencia Desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0)
{
  $registro=pg_fetch_array($res);
  $num_cheque=$registro["num_cheque"];
  $referencia=$registro["referencia"];
  $fecha_mov_libro=$registro["fecha_mov_libro"];
  $monto_mov_libro=$registro["monto_mov_libro"];
  $cod_banco=$registro["cod_banco"];
  $cod_bancoa=$registro["cod_bancoa"];
  $nombre_banco=$registro["nombre_banco"];
  $nro_cuenta=$registro["nro_cuenta"];
  $descrip_mov_libro=$registro["descrip_mov_libro"];
}
$clave=$cod_bancoa.$referencia;
print_r ($clave);
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
                  <?php  echo $nombre_empresa; ?>
        </p></div>
    </div>    </td>
  </tr>
   <tr>
     <td height="51"><div align="center"><span class="Estilo15">FORMATO TRANSFERENCIA BANCARIA </span></div></td>
  </tr>
</table>
<table width="982" height="749" border="1" id="tablacuerpo">
  <tr>
    <td width="1011" height="743">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:976px; height:750px; z-index:1; top: 151px; left: 14px;">
        <form name="form1" method="post">
          <table width="1015" height="506" border="0">
			<tr>
                <td colspan="3" height="51"><table width="970" border="0" align="left" bordercolor="#000000" >
				<tr>
					<td width="10" height="39"></td>
				   <td width="646" height="39"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong> FECHA DE EMISION :</strong><?php  echo $fecha_mov_libro; ?></p></td>
				   <td width="335"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong>MONTO :</strong><?php  echo $monto_mov_libro; ?></p></td>
				</tr>
				</table></td>
			</tr>
			<tr>
              <td height="29" colspan="2"><table width="973" height="27">
                <tr>
                  <td width="965" height="21">
                    <div id="T11" class="tab-body">
                      <iframe src="Det_transferencia_bancaria.php?clave=<?php echo $clave?>"  width="1010" height="170" scrolling="auto" frameborder="0"> </iframe>
                  </div></td>
                </tr>
              </table></td>
            </tr>
		   <tr>
              <td colspan="3"><table width="970">
			  <tr>
					<td width="9" height="39"></td>
					<td colspan="2"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong>BANCO DESDE :</strong><?php  echo $cod_banco; ?>           <?php  echo $nombre_banco; ?></p></td>
			    </tr
				<tr>
					<td width="9" height="39"></td>
					<td colspan="2"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong>BANCO HASTA :</strong><?php  echo $cod_banco; ?>           <?php  echo $nombre_banco; ?></p></td>
			    </tr>
				<tr>
					<td width="9" height="39"></td>
					<td width="656" height="43"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong>CUENTA NRO :</strong><?php  echo $nro_cuenta; ?></p></td>
				   <td width="328"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong>REFERENCIA :</strong><?php  echo $referencia; ?>
                     <input name="textnum_cheque" style="visibility:hidden;"  type="text" id="textnum_cheque" value="<?php echo $num_cheque?>" size="1" readonly>
				     <input name="textreferencia" style="visibility:hidden;"  type="text" id="textreferencia" value="<?php echo $referencia?>" size="1" readonly>
				</p></td>
				</tr>
			  </table></td>
            </tr>
			 <tr>
               <td colspan="3" height="47"><table width="970">
				<tr>
					<td width="9" height="39"></td>
					<td colspan="2"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong>CONCEPTO :</strong><?php  echo $descrip_mov_libro; ?></p></td>
				</tr>
			  </table></td>
            </tr>
			<tr>
               <td colspan="3" height="29"><table width="971">
				<tr>
					<td width="982" height="21">
                    <div id="T11" class="tab-body">
                      <iframe src="Det_contabilidad_finan_nota_debito.php?clave=<?php echo $clave?>"  width="1010" height="170" scrolling="auto" frameborder="0"> </iframe>
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
<?php  pg_close($conn);?>
