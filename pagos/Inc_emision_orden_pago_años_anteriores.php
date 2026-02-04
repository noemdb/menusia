<?include ("../class/seguridad.inc");?>
<? include ("../class/funciones.php");
if (!$_GET){
  $codigo_cuenta='';
  $p_letra='';
  $sql="SELECT * FROM CON001 ORDER BY codigo_cuenta";
} else {
  $codigo_cuenta = $_GET["Gcodigo_cuenta"];
  $p_letra=substr($codigo_cuenta, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$codigo_cuenta=substr($codigo_cuenta,1,20);}
  $sql="Select * from con001 where codigo_cuenta='$codigo_cuenta'";
  if ($p_letra=="P"){$sql="SELECT * FROM CON001 ORDER BY codigo_cuenta";}
  if ($p_letra=="U"){$sql="SELECT * From CON001 Order by Codigo_Cuenta Desc";}
  if ($p_letra=="S"){$sql="SELECT * From CON001 Where (Codigo_Cuenta>'$codigo_cuenta') Order by Codigo_Cuenta";}
  if ($p_letra=="A"){$sql="SELECT * From CON001 Where (Codigo_Cuenta<'$codigo_cuenta') Order by Codigo_Cuenta Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Emisi&oacute;n Ordenes de Pagos)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url)
{
var murl;
var Gcodigo_cuenta=document.form1.txtCodigo_Cuenta.value;
    murl=url+Gcodigo_cuenta;
    if (Gcodigo_cuenta=="")
        {alert("Código de Cuenta debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos)
{
var murl;
   murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_cuentas.php?Gcodigo_cuenta=P"}
   if(MPos=="U"){murl="Act_cuentas.php?Gcodigo_cuenta=U"}
   if(MPos=="S"){murl="Act_cuentas.php?Gcodigo_cuenta=S"+document.form1.txtCodigo_Cuenta.value;}
   if(MPos=="A"){murl="Act_cuentas.php?Gcodigo_cuenta=A"+document.form1.txtCodigo_Cuenta.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url;
var r;
  if (document.form1.txtCargable.value=="CARGABLE"){
  r=confirm("Esta seguro en Eliminar la Cuenta ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar la Cuenta ?");
    if (r==true) {
       url="Delete_cuentas.php?txtCodigo_Cuenta="+document.form1.txtCodigo_Cuenta.value;
       VentanaCentrada(url,'Eliminar Plan Cuentas','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
  }
  else { alert("CUENTA NO ES CARGABLE, NO PUEDE SER ELIMINADA"); }
}
</script>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
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
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo9 {font-size: 8pt}
.Estilo10 {
	font-size: 12px;
	font-weight: bold;
	color: #0000FF;
}
.Estilo11 {font-size: 12px}
-->
</style>
</head>
<?
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$nombre_cuenta="";
$cargable="";
$clasificacion="";
$tSaldo="";
$saldo_anterior=0;
$debito01=0;$credito01=0;$saldop01=0;$saldo01=0;
$debito02=0;$credito02=0;$saldop02=0;$saldo02=0;
$debito03=0;$credito03=0;$saldop03=0;$saldo03=0;
$debito04=0;$credito04=0;$saldop04=0;$saldo04=0;
$debito05=0;$credito05=0;$saldop05=0;$saldo05=0;
$debito06=0;$credito06=0;$saldop06=0;$saldo06=0;
$debito07=0;$credito07=0;$saldop07=0;$saldo07=0;
$debito08=0;$credito08=0;$saldop08=0;$saldo08=0;
$debito09=0;$credito09=0;$saldop09=0;$saldo09=0;
$debito10=0;$credito10=0;$saldop10=0;$saldo10=0;
$debito11=0;$credito11=0;$saldop11=0;$saldo11=0;
$debito12=0;$credito12=0;$saldop12=0;$saldo12=0;
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
  if ($p_letra=="A"){
     $sql="SELECT * From CON001 Order by Codigo_Cuenta";
         $res=pg_query($sql);
     if ($registro=pg_fetch_array($res,0)){$encontro=true;}
  }
}
if($encontro=true){
  $codigo_cuenta=$registro["codigo_cuenta"];
  $nombre_cuenta=$registro["nombre_cuenta"];
  if($registro["cargable"]=="C"){$cargable="CARGABLE";}else{$cargable="NO CARGABLE";}
  $clasificacion=$registro["clasificacion"];
  $tSaldo=$registro["tsaldo"];
  $saldo_anterior=$registro["saldo_anterior"];
  $debito01=formato_monto($registro["debito_01"]);
  $credito01=formato_monto($registro["credito_01"]);
  If($tSaldo== "Deudor"){$saldop01=$registro["debito_01"]-$registro["credito_01"];}else{$saldop01=$registro["credito_01"]-$registro["debito_01"];}
  $saldo01= $saldo_anterior+$saldop01;
  $debito02=formato_monto($registro["debito_02"]);
  $credito02=formato_monto($registro["credito_02"]);
  If($tSaldo== "Deudor"){$saldop02=$registro["debito_02"]-$registro["credito_02"];}else{$saldop02=$registro["credito_02"]-$registro["debito_02"];}
  $saldo02= $saldo01+$saldop02;
  $debito03=formato_monto($registro["debito_03"]);
  $credito03=formato_monto($registro["credito_03"]);
  If($tSaldo== "Deudor"){$saldop03=$registro["debito_03"]-$registro["credito_03"];}else{$saldop03=$registro["credito_03"]-$registro["debito_03"];}
  $saldo03= $saldo02+$saldop03;
  $debito04=formato_monto($registro["debito_04"]);
  $credito04=formato_monto($registro["credito_04"]);
  If($tSaldo== "Deudor"){$saldop04=$registro["debito_04"]-$registro["credito_04"];}else{$saldop04=$registro["credito_04"]-$registro["debito_04"];}
  $saldo04= $saldo03+$saldop04;
  $debito05=formato_monto($registro["debito_05"]);
  $credito05=formato_monto($registro["credito_05"]);
  If($tSaldo== "Deudor"){$saldop05=$registro["debito_05"]-$registro["credito_05"];}else{$saldop05=$registro["credito_05"]-$registro["debito_05"];}
  $saldo05= $saldo04+$saldop05;
  $debito06=formato_monto($registro["debito_06"]);
  $credito06=formato_monto($registro["credito_06"]);
  If($tSaldo== "Deudor"){$saldop06=$registro["debito_06"]-$registro["credito_06"];}else{$saldop06=$registro["credito_06"]-$registro["debito_06"];}
  $saldo06= $saldo05+$saldop06;
  $debito07=formato_monto($registro["debito_07"]);
  $credito07=formato_monto($registro["credito_07"]);
  If($tSaldo== "Deudor"){$saldop07=$registro["debito_07"]-$registro["credito_07"];}else{$saldop07=$registro["credito_07"]-$registro["debito_07"];}
  $saldo07= $saldo06+$saldop07;
  $debito08=formato_monto($registro["debito_08"]);
  $credito08=formato_monto($registro["credito_08"]);
  If($tSaldo=="Deudor"){$saldop08=$registro["debito_08"]-$registro["credito_08"];}else{$saldop08=$registro["credito_08"]-$registro["debito_08"];}
  $saldo08= $saldo07+$saldop08;
  $debito09=formato_monto($registro["debito_09"]);
  $credito09=formato_monto($registro["credito_09"]);
  If($tSaldo=="Deudor"){$saldop09=$registro["debito_09"]-$registro["credito_09"];}else{$saldop09=$registro["credito_09"]-$registro["debito_09"];}
  $saldo09= $saldo08+$saldop09;
  $debito10=formato_monto($registro["debito_10"]);
  $credito10=formato_monto($registro["credito_10"]);
  If($tSaldo=="Deudor"){$saldop10=$registro["debito_10"]-$registro["credito_10"];}else{$saldop10=$registro["credito_10"]-$registro["debito_10"];}
  $saldo10= $saldo09+$saldop10;
  $debito11=formato_monto($registro["debito_11"]);
  $credito11=formato_monto($registro["credito_11"]);
  If($tSaldo=="Deudor"){$saldop11=$registro["debito_11"]-$registro["credito_11"];}else{$saldop11=$registro["credito_11"]-$registro["debito_11"];}
  $saldo11= $saldo10+$saldop11;
  $debito12=formato_monto($registro["debito_12"]);
  $credito12=formato_monto($registro["credito_12"]);
  If($tSaldo=="Deudor"){$saldop12=$registro["debito_12"]-$registro["credito_12"];}else{$saldop12=$registro["credito_12"]-$registro["debito_12"];}
  $saldo12=$saldo11+$saldop12;
}
$saldo_anterior=formato_monto($saldo_anterior);
$saldop01=formato_monto($saldop01);
$saldo01=formato_monto($saldo01);
$saldop02=formato_monto($saldop02);
$saldo02=formato_monto($saldo02);
$saldop03=formato_monto($saldop03);
$saldo03=formato_monto($saldo03);
$saldop04=formato_monto($saldop04);
$saldo04=formato_monto($saldo04);
$saldop05=formato_monto($saldop05);
$saldo05=formato_monto($saldo05);
$saldop06=formato_monto($saldop06);
$saldo06=formato_monto($saldo06);
$saldop07=formato_monto($saldop07);
$saldo07=formato_monto($saldo07);
$saldop08=formato_monto($saldop08);
$saldo08=formato_monto($saldo08);
$saldop09=formato_monto($saldop09);
$saldo09=formato_monto($saldo09);
$saldop10=formato_monto($saldop10);
$saldo10=formato_monto($saldo10);
$saldop11=formato_monto($saldop11);
$saldo11=formato_monto($saldo11);
$saldop12=formato_monto($saldop12);
$saldo12=formato_monto($saldo12);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">EMISI&Oacute;N ORDENES DE PAGOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="1342" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="1226" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_def_bancos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="center"><A class=menu href="Inc_def_bancos.php">Incluir</A></div></td>
        </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_cuentas.php?Gcodigo_cuenta=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="center"><A class=menu
            href="javascript:Llamar_Ventana('Mod_cuentas.php?Gcodigo_cuenta=');">Modificar</A></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="center"><A class=menu
            href="javascript:Mover_Registro('P');">Primero</A></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_cuentas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="center"><a href="Cat_act_cuentas.php" class="menu">Catalogo</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="center"><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="center"><a href="menu.php" class="menu">Menu Principal </a></div></td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:1317px; z-index:1; top: 62px; left: 118px;">
        <form name="form1" method="post">
          <table width="856" border="0" >
                <tr>
                  <td height="14"><table width="848" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="118"><span class="Estilo5"><span class="Estilo11">N</span></span><span class="Estilo5"><span class="Estilo11">&Uacute;MERO ORDEN : </span></span></td>
                      <td width="135"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif32343" type="text" id="txtced_rif323432" size="8" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="163"><span class="Estilo5"><span class="Estilo11">DOCUMENTO CAUSADO : </span></span></td>
                      <td width="81"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif32344" type="text" id="txtced_rif323444" size="8" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="161"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtcedula3325" type="text" id="txtcedula33254" size="9" maxlength="15" readonly>
</span></span></td>
                      <td width="57"><span class="Estilo5"><span class="Estilo11">FECHA :</span></span></td>
                      <td width="86"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif3234222" type="text" id="txtced_rif3234222" size="9" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="47"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td width="850" height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">INFORMACI&Oacute;N</span></span></td>
                </tr>
                <tr>
                  <td><table width="841" >
                    <tr>
                      <td width="183" height="24"><span class="Estilo5"><span class="Estilo11">C&Eacute;DULA/RIF BENEFICIARIO : </span></span></td>
                      <td width="123"><span class="Estilo5"> <span class="Estilo11">
                        <input name="txtced_rif32333" type="text" id="txtced_rif323332" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
</span> </span></td>
                      <td width="70"><span class="Estilo5"><span class="Estilo11">NOMBRE : </span></span></td>
                      <td width="445"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula33222" type="text" id="txtcedula33222" size="64" maxlength="15" readonly>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="32"><table width="838" >
                    <tr>
                      <td width="190" height="30"><span class="Estilo5"><span class="Estilo11">CESIONARIO A COBRAR : 
                        <input type="checkbox" name="checkbox" value="checkbox">
                      </span></span></td>
                      <td width="92"><span class="Estilo5"><span class="Estilo11">C&Eacute;DULA/RIF :
                      </span></span></td>
                      <td width="122"><span class="Estilo5"> <span class="Estilo11">
                      <input name="txtced_rif3233" type="text" id="txtced_rif32334" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
</span> </span></td>
                      <td width="68"><span class="Estilo5"><span class="Estilo11">NOMBRE :</span></span></td>
                      <td width="342"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332222" type="text" id="txtcedula332222" size="48" maxlength="15" readonly>
</span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="32"><table width="841">
                      <tr>
                        <td width="87" height="24"><span class="Estilo5"><span class="Estilo11">CONCEPTO :</span></span></td>
                        <td width="742"><span class="Estilo5"><span class="Estilo11">
                          <input name="txtced_rif32323" type="text" id="txtced_rif32323" size="114" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span>
                        </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="841" >
                    <tr>
                      <td width="131" height="24"><span class="Estilo5"><span class="Estilo11">TIPO DOCUMENTO  : </span></span></td>
                      <td width="127"><span class="Estilo5"> <span class="Estilo11">
                        <select name="select2">
                        </select>
                      </span> </span></td>
                      <td width="124"><span class="Estilo5"><span class="Estilo11">Nro. DOCUMENTO : </span></span></td>
                      <td width="439"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif323222" type="text" id="txtced_rif323222" size="64" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="103"><span class="Estilo5"><span class="Estilo11">FECHA DESDE :</span></span></td>
                      <td width="186"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif323425" type="text" id="txtced_rif323425" size="9" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="101"><span class="Estilo5"><span class="Estilo11">FECHA HASTA :</span></span></td>
                      <td width="175"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif3234223" type="text" id="txtced_rif3234224" size="9" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="147"><span class="Estilo5"><span class="Estilo11">FECHA VENCIMIENTO : </span></span></td>
                      <td width="133"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif3234224" type="text" id="txtced_rif3234227" size="9" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="848" >
                    <tr>
                      <td width="102" height="24"><span class="Estilo5"><span class="Estilo11">TIPO ORDEN  : </span></span></td>
                      <td width="49"><span class="Estilo5"> <span class="Estilo11">
                      <input name="txtced_rif323332" type="text" id="txtced_rif3233324" size="6" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
</span> </span></td>
                      <td width="681"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332223" type="text" id="txtcedula3322233" size="103" maxlength="15" readonly>
</span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="841" >
                    <tr>
                      <td width="167" height="24"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE PROYECTO : </span></span></td>
                      <td width="104"><span class="Estilo5"> <span class="Estilo11">
                        <input name="txtced_rif3233322" type="text" id="txtced_rif3233322" size="13" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span> </span></td>
                      <td width="554"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula3322232" type="text" id="txtcedula332223" size="83" maxlength="15" readonly>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="889" border="0">
                <tr>
                  <td height="22"><table width="866" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="116" height="20"><span class="Estilo5"><span class="Estilo11">TIPO DE GASTO :</span></span></td>
                      <td width="343"><span class="Estilo5"><span class="Estilo11">
                        <select name="select3">
                          <option>FUNCIONAMIENTO</option>
                          <option>INVERSI&Oacute;N</option>
                          <option>FUN/INV</option>
                      </select>
                      </span></span></td>
                      <td width="208"><span class="Estilo5"><span class="Estilo11">IMPUTACI&Oacute;N PRESUPUESTARIA  :</span></span></td>
                      <td width="199"><span class="Estilo5"><span class="Estilo11">
                        <select name="select4">
                          <option>FUNCIONAMIENTO</option>
                          <option>INVERSI&Oacute;N</option>
                          <option>FUN/INV</option>
                        </select>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="883"><table width="860" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="256" height="20"><span class="Estilo5"><span class="Estilo11">REFERENCIA DEL CR&Eacute;DITO ADICIONAL :</span></span></td>
                        <td width="604"><span class="Estilo5"><span class="Estilo11">
                          <input name="txtced_rif323332222" type="text" id="txtced_rif323332222" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span> </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="841" >
                    <tr>
                      <td width="175" height="24"><span class="Estilo5"><span class="Estilo11">FUENTE FINANCIAMENTO : </span></span></td>
                      <td width="96"><span class="Estilo5"> <span class="Estilo11">
                        <input name="txtced_rif32333222" type="text" id="txtced_rif32333222" size="13" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span> </span></td>
                      <td width="554"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula33222322" type="text" id="txtcedula3322232" size="83" maxlength="15" readonly>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="841" >
                    <tr>
                      <td width="150" height="24"><span class="Estilo5"><span class="Estilo11">BANCO QUE CANCELA: </span></span></td>
                      <td width="96"><span class="Estilo5"> <span class="Estilo11">
                        <input name="txtced_rif323332223" type="text" id="txtced_rif323332223" size="13" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span> </span></td>
                      <td width="579"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332223222" type="text" id="txtcedula33222322" size="87" maxlength="15" readonly>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">C&Oacute;DIGOS PRESUPUESTARIOS</span></span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>
                    <table width="861" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="94"><span class="Estilo5"><span class="Estilo11">REFERENCIA  : </span></span></td>
                        <td width="259"><span class="Estilo5"><span class="Estilo11">
                          <input name="txtcedula33252" type="text" id="txtcedula33255" size="15" maxlength="15" readonly>

                        </span></span></td>
                        <td width="49"><span class="Estilo5"><span class="Estilo11">TIPO : </span></span></td>
                        <td width="268"><span class="Estilo5"><span class="Estilo11">
                          <input name="txtcedula33253" type="text" id="txtcedula33256" size="15" maxlength="15" readonly>

                        </span></span></td>
                        <td width="59"><span class="Estilo5"><span class="Estilo11">FECHA : </span></span></td>
                        <td width="132"><span class="Estilo5"><span class="Estilo11">
                          <input name="txtcedula33254" type="text" id="txtcedula33257" size="9" maxlength="15" readonly>

                        </span></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="194"><span class="Estilo5"><span class="Estilo11">SR-PR-PY-AC-PAR-GE-ES-SE :</span></span></td>
                        <td width="472"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula33256" type="text" id="txtcedula332562" size="40" maxlength="15" readonly>
</span> </span></td>
                        <td width="63"><span class="Estilo5"><span class="Estilo11">FUENTE :</span></span></td>
                        <td width="131"><span class="Estilo5"><span class="Estilo11">
                          <input name="txtcedula33255" type="text" id="txtcedula33258" size="9" maxlength="15" readonly>

                        </span> </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="120"><span class="Estilo5"><span class="Estilo11">COMPROMETIDO :</span></span></td>
                      <td width="494"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula33257" type="text" id="txtcedula332510" size="22" maxlength="15" readonly>

</span> </span></td>
                      <td width="80"><span class="Estilo5"><span class="Estilo11">CAUSADO :</span></span></td>
                      <td width="166"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula33259" type="text" id="txtcedula332512" size="15" maxlength="15" readonly>
</span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="121"><span class="Estilo5"><span class="Estilo11">DENOMINACI&Oacute;N :</span></span></td>
                      <td width="739"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula33258" type="text" id="txtcedula332511" size="111" maxlength="15" readonly>

</span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="120"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO CUENTA :</span></span></td>
                      <td width="212"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332572" type="text" id="txtcedula332572" size="22" maxlength="15" readonly>
                      </span> </span></td>
                      <td width="127"><span class="Estilo5"><span class="Estilo11">NOMBRE CUENTA  :</span></span></td>
                      <td width="401"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332592" type="text" id="txtcedula332592" size="55" maxlength="15" readonly>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="57"><span class="Estilo5"><span class="Estilo11">Tp Imp: </span></span></td>
                      <td width="115"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332542" type="text" id="txtcedula332542" size="10" maxlength="15" readonly>
</span></span></td>
                      <td width="75"><span class="Estilo5"><span class="Estilo11">REF. IMP.  :</span></span></td>
                      <td width="139"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332543" type="text" id="txtcedula332543" size="10" maxlength="15" readonly>
</span></span></td>
                      <td width="83"><span class="Estilo5"><span class="Estilo11">PROYECTO :</span></span></td>
                      <td width="136"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332544" type="text" id="txtcedula332544" size="10" maxlength="15" readonly>
</span></span></td>
                      <td width="122"><span class="Estilo5"><span class="Estilo11">MONTO CR&Eacute;DITO : </span></span></td>
                      <td width="134"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332545" type="text" id="txtcedula332545" size="10" maxlength="15" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="177"><span class="Estilo5"><span class="Estilo11">NRO. DOC. COMPROMISO : </span></span></td>
                      <td width="130"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula3325422" type="text" id="txtcedula3325422" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="85"><span class="Estilo5"><span class="Estilo11">TIENE ANT.  :</span></span></td>
                      <td width="104"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula3325432" type="text" id="txtcedula3325432" size="10" maxlength="15" readonly>
                      </span></span></td>
                      <td width="71"><span class="Estilo5"><span class="Estilo11">CTA. ANT.:</span></span></td>
                      <td width="113"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula3325442" type="text" id="txtcedula3325442" size="10" maxlength="15" readonly>
                      </span></span></td>
                      <td width="47"><span class="Estilo5"><span class="Estilo11">TASA : </span></span></td>
                      <td width="134"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula3325452" type="text" id="txtcedula3325452" size="10" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">RETENCIONES</span> </span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="32"><table width="841" >
                      <tr>
                        <td width="46" height="24"><span class="Estilo5"><span class="Estilo11">TIPO : </span></span></td>
                        <td width="152"><span class="Estilo5"> <span class="Estilo11">
                          <input name="txtced_rif323322" type="text" id="txtced_rif32332" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span> </span></td>
                        <td width="189"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N RETENCI&Oacute;N : </span></span></td>
                        <td width="434"><span class="Estilo5"><span class="Estilo11">
                          <input name="txtced_rif3232222" type="text" id="txtced_rif3232222" size="65" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span> </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50"><span class="Estilo5"><span class="Estilo11">TASA : </span></span></td>
                      <td width="92"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif323423232" type="text" id="txtced_rif323423233" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="120"><span class="Estilo5"><span class="Estilo11">MONTO OBJETO :</span></span></td>
                      <td width="105"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif3234232225" type="text" id="txtced_rif3234232226" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="89"><span class="Estilo5"><span class="Estilo11">RETENCI&Oacute;N :</span></span></td>
                      <td width="88"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif32342322222" type="text" id="txtced_rif32342322223" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="188"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO PRESUPUESTARIO : </span></span></td>
                      <td width="129"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif32342322232" type="text" id="txtced_rif32342322233" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="861" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="184"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO PRESUPUESTARIO  : </span></span></td>
                        <td width="166"><span class="Estilo5"><span class="Estilo11">
                          <input name="txtced_rif32342323" type="text" id="txtced_rif32342323" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span></span></td>
                        <td width="119"><span class="Estilo5"><span class="Estilo11">DENOMINACI&Oacute;N :</span></span></td>
                        <td width="392"><span class="Estilo5"><span class="Estilo11">
                          <input name="txtced_rif323423222" type="text" id="txtced_rif3234232225" size="54" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="861" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="125" height="22"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO CUENTA  : </span></span></td>
                        <td width="109"><span class="Estilo5"><span class="Estilo11">
                          <input name="txtced_rif3234232322" type="text" id="txtced_rif3234232323" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span></span></td>
                        <td width="124"><span class="Estilo5"><span class="Estilo11">NOMBRE CUENTA : </span></span></td>
                        <td width="503"><span class="Estilo5"><span class="Estilo11">
                          <input name="txtced_rif3234232224" type="text" id="txtced_rif32342322242" size="72" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="171"><span class="Estilo5"><span class="Estilo11">PAGO MAYOR ANALITICA : </span></span></td>
                      <td width="179"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif3234232323" type="text" id="txtced_rif3234232322" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="106"><span class="Estilo5"><span class="Estilo11">SUSTRAENDO :</span></span></td>
                      <td width="161"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif32342322252" type="text" id="txtced_rif32342322252" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="112"><span class="Estilo5"><span class="Estilo11">CUENTA ASOC.  :</span></span></td>
                      <td width="132"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif323423222222" type="text" id="txtced_rif323423222222" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="841" >
                    <tr>
                      <td width="183" height="24"><span class="Estilo5"><span class="Estilo11">C&Eacute;DULA/RIF BENEFICIARIO : </span></span></td>
                      <td width="123"><span class="Estilo5"> <span class="Estilo11">
                        <input name="txtced_rif323333" type="text" id="txtced_rif32333" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span> </span></td>
                      <td width="70"><span class="Estilo5"><span class="Estilo11">NOMBRE : </span></span></td>
                      <td width="445"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332224" type="text" id="txtcedula332224" size="66" maxlength="15" readonly>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="234"><span class="Estilo5"><span class="Estilo11">CONCEPTO DE ORDEN RETENCI&Oacute;N  :</span></span></td>
                      <td width="626"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332582" type="text" id="txtcedula332582" size="92" maxlength="15" readonly>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="92"><span class="Estilo5"><span class="Estilo11">REDONDEA : </span></span></td>
                      <td width="196"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif32342323232" type="text" id="txtced_rif32342323232" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="163"><span class="Estilo5"><span class="Estilo11">GENERA COMPROMISO  :</span></span></td>
                      <td width="147"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif323423222522" type="text" id="txtced_rif323423222522" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="127"><span class="Estilo5"><span class="Estilo11">PAGO RETENCI&Oacute;N  :</span></span></td>
                      <td width="136"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtced_rif3234232222222" type="text" id="txtced_rif3234232222222" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">COMPROBANTE CONTABLE</span> </span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><table width="841" >
                    <tr>
                      <td width="138" height="24"><span class="Estilo5"><span class="Estilo11">CUENTA POR PAGAR : </span></span></td>
                      <td width="168"><span class="Estilo5"> <span class="Estilo11">
                        <input name="txtced_rif323334" type="text" id="txtced_rif323333" size="22" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span> </span></td>
                      <td width="70"><span class="Estilo5"><span class="Estilo11">NOMBRE : </span></span></td>
                      <td width="445"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332225" type="text" id="txtcedula332225" size="64" maxlength="15" readonly>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">OTROS PASIVOS</span> </span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">O/P RETENCIONES</span> </span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><table width="862" border="1" cellspacing="2" cellpadding="0">
                    <tr>
                      <td><table width="848" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="132"><span class="Estilo5"><span class="Estilo11">TOTAL CAUSADOS : </span></span></td>
                            <td width="164"><span class="Estilo5">
                              <input name="txtcedula33243" type="text" id="txtcedula3324" size="18" maxlength="15" readonly>
                            </span></td>
                            <td width="150"><span class="Estilo5"><span class="Estilo11">AMORTIZA ANTICIPO :</span></span></td>
                            <td width="153"><span class="Estilo5">
                              <input name="txtcedula3324322" type="text" id="txtcedula3324322" size="18" maxlength="15" readonly>
                            </span></td>
                            <td width="113"><span class="Estilo5"><span class="Estilo11">TOTAL PASIVOS :</span></span></td>
                            <td width="136"><span class="Estilo5">
                              <input name="txtcedula3324323" type="text" id="txtcedula3324323" size="18" maxlength="15" readonly>
                            </span></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="851" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="131"><span class="Estilo5"><span class="Estilo11">RETENCI&Oacute;N : </span></span></td>
                            <td width="164"><span class="Estilo5">
                              <input name="txtcedula332432" type="text" id="txtcedula332432" size="18" maxlength="15" readonly>
                            </span></td>
                            <td width="151"><span class="Estilo5"><span class="Estilo11">AJUSTE :</span></span></td>
                            <td width="153"><span class="Estilo5">
                              <input name="txtcedula3324325" type="text" id="txtcedula3324325" size="18" maxlength="15" readonly>
                            </span></td>
                            <td width="114"><span class="Estilo5"><span class="Estilo11">NETO :</span></span></td>
                            <td width="138"><span class="Estilo5">
                              <input name="txtcedula3324324" type="text" id="txtcedula3324324" size="18" maxlength="15" readonly>
                            </span></td>
                          </tr>
                        </table>
                          <span class="Estilo5"></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><span class="Estilo5"> </span></td>
                </tr>
              </table>
              <p>&nbsp;</p>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>