<?php include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);
include ("../../class/conect.php");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG001".$usuario_sia.$equipo;
$cod_banco_d=$_GET["cod_banco_d"];
if (!$_GET){ $p_letra='';$criterio=''; $cod_banco='';$referencia=''; $sql="SELECT * FROM BAN002, BAN004, PRE099 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco AND BAN004.Ced_Rif= PRE099.Ced_Rif AND Tipo_Mov_Libro='NDB' Order by BAN004.Cod_Banco, BAN004.Referencia";}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $cod_banco=substr($criterio,1,4);  $referencia=substr($criterio,5,12);}
   else{$cod_banco=substr($criterio,0,4);  $referencia=substr($criterio,4,12);}
  $codigo_mov=substr($mcod_m,0,49);  $clave=$cod_banco.$referencia;
  //$cod_banco_d=$_GET["cod_banco_d"];
  $sql="SELECT * FROM BAN002, BAN004, PRE099 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco AND BAN004.Ced_Rif= PRE099.Ced_Rif AND Tipo_Mov_Libro='NDB' Order by BAN004.Cod_Banco, BAN004.Referencia";
  if ($p_letra=="P"){$sql="SELECT * FROM BAN002, BAN004, PRE099 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco AND BAN004.Ced_Rif= PRE099.Ced_Rif AND Tipo_Mov_Libro='NDB' Order by BAN004.Cod_Banco, BAN004.Referencia";}
  if ($p_letra=="U"){$sql="SELECT * FROM BAN002, BAN004, PRE099 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco AND BAN004.Ced_Rif= PRE099.Ced_Rif AND Tipo_Mov_Libro='NDB' Order by BAN004.Cod_Banco DESC, BAN004.Referencia DESC";}
  if ($p_letra=="S"){$sql="SELECT * FROM BAN002, BAN004, PRE099 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco AND BAN004.Ced_Rif= PRE099.Ced_Rif AND Tipo_Mov_Libro='NDB' AND (text(BAN004.Cod_Banco)||text(BAN004.Referencia)>'$clave') Order by BAN004.Cod_Banco, BAN004.Referencia";}
  if ($p_letra=="A"){$sql="SELECT * FROM BAN002, BAN004, PRE099 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco AND BAN004.Ced_Rif= PRE099.Ced_Rif AND Tipo_Mov_Libro='NDB' AND (text(BAN004.Cod_Banco)||text(BAN004.Referencia)<'$clave') Order by text(BAN004.Cod_Banco)||text(BAN004.Referencia) desc";}
  //print_r ($cod_banco_d);
 // print_r ($clave);
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
   murl="Rpt_Comprobante_Ret.php";
   if(MPos=="P"){murl="Rpt_Impresion_Nota_Debi.php?Gcriterio=P"}
   if(MPos=="U"){murl="Rpt_Impresion_Nota_Debi.php?Gcriterio=U"}
   if(MPos=="S"){murl="Rpt_Impresion_Nota_Debi.php?Gcriterio=S"+document.form1.textcod_banco.value+document.form1.textreferencia.value;}
   if(MPos=="A"){murl="Rpt_Impresion_Nota_Debi.php?Gcriterio=A"+document.form1.textcod_banco.value+document.form1.textreferencia.value;}
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
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM BAN002, BAN004, PRE099 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco AND BAN004.Ced_Rif= PRE099.Ced_Rif AND Tipo_Mov_Libro='NDB' Order by BAN004.Cod_Banco, BAN004.Referencia";}  if ($p_letra=="S"){$sql="SELECT * FROM BAN002, BAN004, PRE099 WHERE BAN004.Cod_Banco = BAN002.Cod_Banco AND BAN004.Ced_Rif= PRE099.Ced_Rif AND Tipo_Mov_Libro='NDB' Order by BAN004.Cod_Banco Desc, BAN004.Referencia Desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0)
{
  $registro=pg_fetch_array($res);
  $num_cheque=$registro["num_cheque"];
  $referencia=$registro["referencia"];
  $fecha_mov_libro=$registro["fecha_mov_libro"];
  $monto_mov_libro=$registro["monto_mov_libro"];
  $cod_banco=$registro["cod_banco"];
  $nombre_banco=$registro["nombre_banco"];
  $nro_cuenta=$registro["nro_cuenta"];
  $nombre=$registro["nombre"];
  $ced_rif=$registro["ced_rif"];
  $descrip_mov_libro=$registro["descrip_mov_libro"];
}
$clave=$cod_banco.$referencia;
$nombre_empresa="GOBERNACION DEL ESTADO YARACUY";  
?>
<body>
<table width="1015" height="35" border="0" bgcolor="#FFFFFF" id="tablam">
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
	<td width="48""];" height="31"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Rpt_Impresion_Nota_Debito.php')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="Rpt_Impresion_Nota_Debito.php" class="menu">Menu</a></td>
  </tr>
</table>
<table width="1013" height="92" border="0" bgcolor="#FFFFFF">
  <tr>
    <td width="74" rowspan="2"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="91"></div></td>
    <td height="35"><div align="center" class="Estilo2 Estilo6">
      <div align="left"><p align="left" class="Estilo14">
                  <?php  echo $nombre_empresa; ?>
        </p></div>
    </div>    </td>
  </tr>
   <tr>
     <td height="51"><div align="center"><span class="Estilo15">NOTA DE DEBITO </span></div></td>
  </tr>
</table>
<table width="1017" height="543" border="0" id="tablacuerpo">
  <tr>
    <td width="1011">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:1018px; height:579px; z-index:1; top: 152px; left: 13px;">
        <form name="form1" method="post">
          <table width="1015" height="550" border="0">
			<tr>
                <td colspan="3" height="51"><table>
				<tr>
					<td width="321" height="43"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong>NRO:</strong><?php  echo $referencia; ?>
                     <input name="textcod_banco" style="visibility:hidden;"  type="text" id="textcod_banco" value="<?php echo $cod_banco?>" size="1" readonly>
				    <input name="textreferencia" style="visibility:hidden;"  type="text" id="textreferencia" value="<?php echo $referencia?>" size="1" readonly>
				</p></td>
					<td width="394"><div align="left"> </div>              
                   <p align="center" class="Estilo14"><strong>FECHA DE EMISION :</strong><?php  echo $fecha_mov_libro; ?></p></td>
				   <td width="394"><div align="left"> </div>              
                   <p align="center" class="Estilo14"><strong>MONTO :</strong><?php  echo $monto_mov_libro; ?></p></td>
				</tr>
				</table></td>
			</tr>
			
			<tr>
              <td colspan="3" height="47"><table width="1006">
				<tr>
					<td width="644" height="39"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong>BANCO :</strong><?php  echo $cod_banco; ?>           <?php  echo $nombre_banco; ?></p></td>
				   <td width="350"><div align="left"> </div>              
                   <p align="center" class="Estilo14"><strong>CUENTA NRO :</strong><?php  echo $nro_cuenta; ?></p></td>
				</tr>
			  </table></td>
            </tr>
		   <tr>
               <td colspan="3" height="47"><table width="1006">
				<tr>
					<td width="644" height="39"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong>BENEFICIARIO :</strong><?php  echo $nombre; ?></p></td>
				   <td width="350"><div align="left"> </div>              
                   <p align="center" class="Estilo14"><strong>CEDULA/RIF :</strong><?php  echo $ced_rif; ?></p></td>
				</tr>
			  </table></td>
            </tr>
			 <tr>
               <td colspan="3" height="47"><table width="1006">
				<tr>
					<td width="644" height="39"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong>POR LA CANTIDAD DE :</strong></p></td> 
				</tr>
			  </table></td>
            </tr>
			<tr>
               <td colspan="3" height="47"><table width="1006">
				<tr>
					<td width="644" height="39"><div align="left"> </div>              
                   <p align="left" class="Estilo14"><strong>CONCEPTO :</strong><?php  echo $descrip_mov_libro; ?></p></td> 
				</tr>
			  </table></td>
            </tr>
			<tr>
               <td colspan="3" height="29"><table width="971">
				<tr>
					<td width="982" height="21">
                    <div id="T11" class="tab-body">
                      <iframe src="Det_contabilidad_presupu_nota_debito.php?clave=<?php echo $clave?>"  width="1010" height="190" scrolling="auto" frameborder="0"> </iframe>
                  </div></td> 
				</tr>
			  </table></td>
            </tr>
			<tr>
               <td colspan="3" height="29"><table width="971">
				<tr>
					<td width="982" height="21">
                    <div id="T11" class="tab-body">
                      <iframe src="Det_contabilidad_finan_nota_debito.php?clave=<?php echo $clave?>"  width="1010" height="400" scrolling="auto" frameborder="0"> </iframe>
                  </div></td> 
				</tr>
			  </table></td>
            </tr>
			<tr>
               <td colspan="3" height="45"><table>
			   <tr>
			   <td width="91" height="21"><p><span class="Estilo12"><br>
			     </span></p>			     </td>
			 <td width="224" height="21">&nbsp;</td>
			   <td width="391"><div align="center"><strong>__________________________</strong></div></td>
			   <td width="283"><div align="center"></div></td>
			   </tr>
			   <tr>
			   <td width="91" height="21"><p><span class="Estilo12"><br>
			     </span></p>			     </td>
			 <td width="224" height="21">&nbsp;</td>
			   <td width="391"><div align="center"><strong>ELABORADO POR </strong></div></td>
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
<?php  pg_close($conn);?>
