<?include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $Formato_Cuenta="X-X-XXX-XX-XX-XXXX";
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else { $Nom_Emp=busca_conf(); }
$sql="Select * from SIA005 where campo501='06'";  $resultado=pg_query($sql);  if ($registro=pg_fetch_array($resultado,0)){$Formato_Cuenta=$registro["campo504"];}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="01-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$codigo_cuenta='';$p_letra=''; $sql="SELECT * FROM CON001 ORDER BY codigo_cuenta";
} else { $codigo_cuenta = $_GET["Gcodigo_cuenta"];$p_letra=substr($codigo_cuenta, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="C")||($p_letra=="S")||($p_letra=="A")){$codigo_cuenta=substr($codigo_cuenta,1,20);}
  $sql="Select * from con001 where codigo_cuenta='$codigo_cuenta'";
  if ($p_letra=="P"){$sql="SELECT * FROM CON001 ORDER BY codigo_cuenta";}
  if ($p_letra=="U"){$sql="SELECT * From CON001 Order by Codigo_Cuenta Desc";}
  if ($p_letra=="S"){$sql="SELECT * From CON001 Where (Codigo_Cuenta>'$codigo_cuenta') Order by Codigo_Cuenta";}
  if ($p_letra=="A"){$sql="SELECT * From CON001 Where (Codigo_Cuenta<'$codigo_cuenta') Order by Codigo_Cuenta Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD FISCAL (Cuentas Contables)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_comprob(){  document.form2.submit(); }

function Llamar_Ventana(url){var murl;
var Gcodigo_cuenta=document.form1.txtCodigo_Cuenta.value;
    murl=url+Gcodigo_cuenta;
    if (Gcodigo_cuenta==""){alert("Codigo de Cuenta debe ser Seleccionada");}        else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_cuentas.php?Gcodigo_cuenta=P"}
   if(MPos=="U"){murl="Act_cuentas.php?Gcodigo_cuenta=U"}
   if(MPos=="S"){murl="Act_cuentas.php?Gcodigo_cuenta=S"+document.form1.txtCodigo_Cuenta.value;}
   if(MPos=="A"){murl="Act_cuentas.php?Gcodigo_cuenta=A"+document.form1.txtCodigo_Cuenta.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  if (document.form1.txtCargable.value=="CARGABLE"){
  r=confirm("Esta seguro en Eliminar la Cuenta ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Cuenta ?");
    if (r==true) {  url="Delete_cuentas.php?txtCodigo_Cuenta="+document.form1.txtCodigo_Cuenta.value; VentanaCentrada(url,'Eliminar Plan Cuentas','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
  }
  else { alert("CUENTA NO ES CARGABLE, NO PUEDE SER ELIMINADA"); }
}
</script>
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
<script language="JavaScript" type="text/JavaScript"><!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<?
$nombre_cuenta="";$cargable=""; $clasificacion="";$tSaldo="";  $saldo_anterior=0;  $fecha_creado="";
$debito01=0;$credito01=0;$saldop01=0;$saldo01=0;$debito02=0;$credito02=0;$saldop02=0;$saldo02=0;
$debito03=0;$credito03=0;$saldop03=0;$saldo03=0;$debito04=0;$credito04=0;$saldop04=0;$saldo04=0;
$debito05=0;$credito05=0;$saldop05=0;$saldo05=0;$debito06=0;$credito06=0;$saldop06=0;$saldo06=0;
$debito07=0;$credito07=0;$saldop07=0;$saldo07=0;$debito08=0;$credito08=0;$saldop08=0;$saldo08=0;
$debito09=0;$credito09=0;$saldop09=0;$saldo09=0;$debito10=0;$credito10=0;$saldop10=0;$saldo10=0;
$debito11=0;$credito11=0;$saldop11=0;$saldo11=0;$debito12=0;$credito12=0;$saldop12=0;$saldo12=0;
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{$encontro=false; if ($p_letra=="A"){$sql="SELECT * From CON001 Order by Codigo_Cuenta";$res=pg_query($sql);  if ($registro=pg_fetch_array($res,0)){$encontro=true;}  } }
if($encontro=true){
  $codigo_cuenta=$registro["codigo_cuenta"];   $nombre_cuenta=$registro["nombre_cuenta"]; 
  if($registro["cargable"]=="C"){$cargable="CARGABLE";}else{$cargable="NO CARGABLE";}
  $clasificacion=$registro["clasificacion"];  $tSaldo=$registro["tsaldo"];  $fecha_creado=$registro["fecha_creado"];
  $saldo_anterior=$registro["saldo_anterior"];
  $debito01=formato_monto($registro["debito_01"]);  $credito01=formato_monto($registro["credito_01"]);
  If($tSaldo== "Deudor"){$saldop01=$registro["debito_01"]-$registro["credito_01"];}else{$saldop01=$registro["credito_01"]-$registro["debito_01"];}
  $saldo01= $saldo_anterior+$saldop01;
  $debito02=formato_monto($registro["debito_02"]);  $credito02=formato_monto($registro["credito_02"]);
  If($tSaldo== "Deudor"){$saldop02=$registro["debito_02"]-$registro["credito_02"];}else{$saldop02=$registro["credito_02"]-$registro["debito_02"];}
  $saldo02= $saldo01+$saldop02;
  $debito03=formato_monto($registro["debito_03"]);  $credito03=formato_monto($registro["credito_03"]);
  If($tSaldo== "Deudor"){$saldop03=$registro["debito_03"]-$registro["credito_03"];}else{$saldop03=$registro["credito_03"]-$registro["debito_03"];}
  $saldo03= $saldo02+$saldop03;
  $debito04=formato_monto($registro["debito_04"]);  $credito04=formato_monto($registro["credito_04"]);
  If($tSaldo== "Deudor"){$saldop04=$registro["debito_04"]-$registro["credito_04"];}else{$saldop04=$registro["credito_04"]-$registro["debito_04"];}
  $saldo04= $saldo03+$saldop04;
  $debito05=formato_monto($registro["debito_05"]);  $credito05=formato_monto($registro["credito_05"]);
  If($tSaldo== "Deudor"){$saldop05=$registro["debito_05"]-$registro["credito_05"];}else{$saldop05=$registro["credito_05"]-$registro["debito_05"];}
  $saldo05= $saldo04+$saldop05;
  $debito06=formato_monto($registro["debito_06"]);  $credito06=formato_monto($registro["credito_06"]);
  If($tSaldo== "Deudor"){$saldop06=$registro["debito_06"]-$registro["credito_06"];}else{$saldop06=$registro["credito_06"]-$registro["debito_06"];}
  $saldo06= $saldo05+$saldop06;
  $debito07=formato_monto($registro["debito_07"]);
  $credito07=formato_monto($registro["credito_07"]);
  If($tSaldo== "Deudor"){$saldop07=$registro["debito_07"]-$registro["credito_07"];}else{$saldop07=$registro["credito_07"]-$registro["debito_07"];}
  $saldo07= $saldo06+$saldop07;
  $debito08=formato_monto($registro["debito_08"]);  $credito08=formato_monto($registro["credito_08"]);
  If($tSaldo=="Deudor"){$saldop08=$registro["debito_08"]-$registro["credito_08"];}else{$saldop08=$registro["credito_08"]-$registro["debito_08"];}
  $saldo08= $saldo07+$saldop08;
  $debito09=formato_monto($registro["debito_09"]);
  $credito09=formato_monto($registro["credito_09"]);
  If($tSaldo=="Deudor"){$saldop09=$registro["debito_09"]-$registro["credito_09"];}else{$saldop09=$registro["credito_09"]-$registro["debito_09"];}
  $saldo09= $saldo08+$saldop09;
  $debito10=formato_monto($registro["debito_10"]);  $credito10=formato_monto($registro["credito_10"]);
  If($tSaldo=="Deudor"){$saldop10=$registro["debito_10"]-$registro["credito_10"];}else{$saldop10=$registro["credito_10"]-$registro["debito_10"];}
  $saldo10= $saldo09+$saldop10;
  $debito11=formato_monto($registro["debito_11"]);  $credito11=formato_monto($registro["credito_11"]);
  If($tSaldo=="Deudor"){$saldop11=$registro["debito_11"]-$registro["credito_11"];}else{$saldop11=$registro["credito_11"]-$registro["debito_11"];}
  $saldo11= $saldo10+$saldop11;
  $debito12=formato_monto($registro["debito_12"]);  $credito12=formato_monto($registro["credito_12"]);
  If($tSaldo=="Deudor"){$saldop12=$registro["debito_12"]-$registro["credito_12"];}else{$saldop12=$registro["credito_12"]-$registro["debito_12"];}
  $saldo12=$saldo11+$saldop12;
}
$saldo_anterior=formato_monto($saldo_anterior);  if($fecha_creado==""){$fecha_creado="";}else{$fecha_creado=formato_ddmmaaaa($fecha_creado);}
$saldop01=formato_monto($saldop01);$saldo01=formato_monto($saldo01);$saldop02=formato_monto($saldop02);$saldo02=formato_monto($saldo02);
$saldop03=formato_monto($saldop03);$saldo03=formato_monto($saldo03);$saldop04=formato_monto($saldop04);$saldo04=formato_monto($saldo04);
$saldop05=formato_monto($saldop05);$saldo05=formato_monto($saldo05);$saldop06=formato_monto($saldop06);$saldo06=formato_monto($saldo06);
$saldop07=formato_monto($saldop07);$saldo07=formato_monto($saldo07);$saldop08=formato_monto($saldop08);$saldo08=formato_monto($saldo08);
$saldop09=formato_monto($saldop09);$saldo09=formato_monto($saldo09);$saldop10=formato_monto($saldop10);$saldo10=formato_monto($saldo10);
$saldop11=formato_monto($saldop11);$saldo11=formato_monto($saldo11);$saldop12=formato_monto($saldop12);$saldo12=formato_monto($saldo12);

$MClasif_Fiscal=$clasificacion;   $clasificacion="Activo del Tesoro";
If ($MClasif_Fiscal=="11") {$clasificacion="Activo del Tesoro";}
if ($MClasif_Fiscal=="12") {$clasificacion="Pasivo del Tesoro";}
if ($MClasif_Fiscal=="21") {$clasificacion="Activo de la Hacienda";}
if ($MClasif_Fiscal=="22") {$clasificacion="Pasivo de la Hacienda";}
if ($MClasif_Fiscal=="31") {$clasificacion="Gastos del Presupuesto";}
if ($MClasif_Fiscal=="32") {$clasificacion="Ingresos del Presupuesto";}
if ($MClasif_Fiscal=="4") {$clasificacion="Resultado del Presupuesto";}
if ($MClasif_Fiscal=="5") {$clasificacion="Cuenta de Patrimonio";}
if ($MClasif_Fiscal=="99") {$clasificacion="No Clasificada";}

?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CUENTAS CONTABLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="507" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="502" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
    <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_comprob()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_comprob()">Incluir</A></td>
      </tr>
	  <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_cuentas.php?Gcodigo_cuenta=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_cuentas.php?Gcodigo_cuenta=');">Modificar</A></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
	  <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cons_cuentas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cons_cuentas.php" class="menu">Consultar</a></td>
        </tr>	
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_cuentas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_cuentas.php" class="menu">Catalogo</a></td>
  </tr>
  <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
  </tr>
  <?} ?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/contabilidad/ayuda/ayuda_cuentas_con.htm','Ayuda SIA','','1000','1000','true');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/contabilidad/ayuda/ayuda_cuentas_con.htm','Ayuda SIA','','1000','1000','true');" class="menu">Ayuda </a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu Principal </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:895px; height:475px; z-index:1; top: 62px; left: 114px;">
            <form name="form1" method="post">
        <table width="868" border="0">
            <tr>
              <td><table width="848" border="0">
                <tr>
                  <td width="669"><blockquote>
                    <p><span class="Estilo5">C&Oacute;DIGO DE CUENTA :
                            <input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" value="<?echo $codigo_cuenta?>" size="30" readonly>
                        </span></p>
                  </blockquote></td>
                  <td width="157"><input name=txtCargable class="Estilo5" id="txtCargable" value="<?echo $cargable?>" readonly></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="849" border="0">
                <tr>
                  <td width="162"><blockquote><span class="Estilo5">NOMBRE DE LA CUENTA :</span></blockquote></td>
                  <td width="677"><textarea name="txtNombre_Cuenta" cols="80" readonly="readonly" class="headers" id="txtNombre_Cuenta"><?echo $nombre_cuenta?></textarea></td>
                </tr>
              </table>                </td>
            </tr>
            <tr>
              <td height="34"><table width="863" border="0">
                <tr>
                  <td width="260"><blockquote><span class="Estilo5">TIPO DE SALDO :
                      <input readonly name="txtTSaldo" type="text" id="txtTSaldo" value="<?echo $tSaldo?>" size="10">
                  </span> </blockquote></td>
                  <td width="260" class="Estilo5"><span class="Estilo5">CLASIFICACI&Oacute;N :</span>
                  <input readonly name="txtclasificacion" type="text" id="txtclasificacion" value="<?echo $clasificacion?>" size="15"></td>
                  <td width="295" class="Estilo5"><span class="Estilo5">SALDO ANTERIOR  :</span>
                  <input readonly name="txtsaldo_anterior" type="text" id="txtsaldo_anterior" value="<?echo $saldo_anterior?>" size="25" style="text-align:right"></td>
                </tr>
              </table>                </td>
            </tr>
        </table>
        <table width="750" height="246" border="1" cellspacing='0' cellpadding='0' align="center" id="periodos">
          <tr height="20" class="Estilo5">
            <td width="90" height="25" align="center" bgcolor="#99CCFF"><strong>PERIODO</strong></td>
            <td width="150" align="right" bgcolor="#99CCFF"><strong>DEBITO</strong></td>
            <td width="150" align="right" bgcolor="#99CCFF"><strong>CREDITO</strong></td>
            <td width="180" align="right" bgcolor="#99CCFF" ><strong>SALDO PERIODO </strong></td>
            <td width="180" align="center" bgcolor="#99CCFF"><strong>SALDO</strong></td>
          </tr>
          <tr class="Estilo5">
            <td height="20" class="Estilo5">ENERO</td>
            <td align="right"><? echo $debito01; ?></td>
            <td align="right"><? echo $credito01; ?></td>
            <td align="right"><? echo $saldop01; ?></td>
            <td align="right"><? echo $saldo01; ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20" class="Estilo5">FEBRERO</td>
            <td align="right"><? echo $debito02; ?></td>
            <td align="right"><? echo $credito02; ?></td>
            <td align="right"><? echo $saldop02; ?></td>
            <td align="right"><? echo $saldo02; ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">MARZO</td>
            <td align="right"><? echo $debito03; ?></td>
            <td align="right"><? echo $credito03; ?></td>
            <td align="right"><? echo $saldop03; ?></td>
            <td align="right"><? echo $saldo03; ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">ABRIL</td>
            <td align="right"><? echo $debito04; ?></td>
            <td align="right"><? echo $credito04; ?></td>
            <td align="right"><? echo $saldop04; ?></td>
            <td align="right"><? echo $saldo04; ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">MAYO</td>
            <td align="right"><? echo $debito05; ?></td>
            <td align="right"><? echo $credito05; ?></td>
            <td align="right"><? echo $saldop05; ?></td>
            <td align="right"><? echo $saldo05; ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">JUNIO</td>
            <td align="right"><? echo $debito06; ?></td>
            <td align="right"><? echo $credito06; ?></td>
            <td align="right"><? echo $saldop06; ?></td>
            <td align="right"><? echo $saldo06; ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">JULIO</td>
            <td align="right"><? echo $debito07; ?></td>
            <td align="right"><? echo $credito07; ?></td>
            <td align="right"><? echo $saldop07; ?></td>
            <td align="right"><? echo $saldo07; ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">AGOSTO</td>
            <td align="right"><? echo $debito08; ?></td>
            <td align="right"><? echo $credito08; ?></td>
            <td align="right"><? echo $saldop08; ?></td>
            <td align="right"><? echo $saldo08; ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">SEPTIEMBRE</td>
            <td align="right"><? echo $debito09; ?></td>
            <td align="right"><? echo $credito09; ?></td>
            <td align="right"><? echo $saldop09; ?></td>
            <td align="right"><? echo $saldo09; ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">OCTUBRE</td>
            <td align="right"><? echo $debito10; ?></td>
            <td align="right"><? echo $credito10; ?></td>
            <td align="right"><? echo $saldop10; ?></td>
            <td align="right"><? echo $saldo10; ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">NOVIEMBRE</td>
            <td align="right"><? echo $debito11; ?></td>
            <td align="right"><? echo $credito11; ?></td>
            <td align="right"><? echo $saldop11; ?></td>
            <td align="right"><? echo $saldo11; ?></td>
          </tr>
          <tr class="Estilo5">
            <td height="20">DICIEMBRE</td>
            <td align="right"><? echo $debito12; ?></td>
            <td align="right"><? echo $credito12; ?></td>
            <td align="right"><? echo $saldop12; ?></td>
            <td align="right"><? echo $saldo12; ?></td>
          </tr>
        </table>
        <table width="868" border="0">
          <tr>
              <td><table width="848" border="0">
                <tr>
                  <td width="769"><blockquote>
                    <p><span class="Estilo5">FECHA REGISTRO :<input name="txtFecha_Creado" type="text" id="txtFecha_Creado" value="<?echo $fecha_creado?>" size="10" readonly>
                        </span></p>
                  </blockquote></td>
                 </tr>
              </table></td>
            </tr>
        </table>
        <p>&nbsp;</p>
        </form>
      </div>
    </td>
</tr>
</table>
<form name="form2" method="post" action="Inc_cuentas.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtSIA_Definicion" type="hidden" id="txtSIA_Definicion" value="<?echo $SIA_Definicion?>" ></td>
	 <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value="<?echo $Rif_Emp?>"></td>
     <td width="5"><input name="txtnomb" type="hidden" id="txtnomb" value="<?echo $Nom_Emp?>"></td>
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtformato" type="hidden" id="txtformato" value="<?echo $Formato_Cuenta?>"></td>
  </tr>
</table>
</form>
</body>
</html>
<? pg_close();?>