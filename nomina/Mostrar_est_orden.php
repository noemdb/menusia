<?include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php"); 
$equipo=getenv("COMPUTERNAME"); $codigo_mov="PAG066".$usuario_sia.$equipo;   $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$criterio="N00000000D";}else{$criterio=$_GET["criterio"];} $tp_calculo=substr($criterio,0,1); $cod_estructura=substr($criterio,1,8); $tp_pago=substr($criterio,9,1);
$fecha_d=substr($criterio,10,10); $fecha_h=substr($criterio,20,10); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA NOMINA Y PERSONAL (Informacion Orden de Pago - Nominas Calculadas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
<script language="JavaScript" type="text/JavaScript">
function Carga_Nom(){var mcod_est; var f=document.form1;  var mtp_calculo;  var mtipoc;
  mcod_est=f.txtcod_estructura.value; mtp_calculo=f.txttipo_calculo.value;  document.location ='Gen_orden_nomina.php?criterio='+mtp_calculo+mcod_est;
return true;}
function revisa(){var f=document.form1; var Valido=true;
   if(f.txtcod_estructura.value==""){alert("Codigo de Estructura no puede estar Vacio");return false;}
   if(f.txtfecha_hasta.value.length==10){valido=true;}else{alert("Longitud Fecha proceso Invalida");return false;}
   if(f.txtcod_estructura.value.length==8){valido=true;}else{alert("Longitud Codigo de Estructura Invalida");return false;}
 document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$des_estructura=""; $fecha_hasta=$fecha_hoy; $tipo_pago="DEPOSITO"; if($tp_pago=="C"){$tipo_pago="CHEQUE";}  if($tp_pago=="T"){$tipo_pago="TODOS";} 
$sql="SELECT descripcion_est,nro_documento FROM PAG006 Where (cod_estructura='$cod_estructura')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $des_estructura=$registro["descripcion_est"];}
pg_close(); $criterio=$tp_calculo.$cod_estructura; $tipo_calculo="NORMAL"; if($tp_calculo=="E"){$tipo_calculo="EXTRAORDINARIA";}
$fecha_desde=formato_ddmmaaaa($fecha_d); $fecha_hasta=formato_ddmmaaaa($fecha_h);
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INFORMACI&Oacute;N ORDEN DE PAGO - N&Oacute;MINAS CALCULADAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="560" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="insert_est_orden_nom.php"  onsubmit="return revisa();" >
       <div id="Layer1" style="position:absolute; width:940px; height:540px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="226"><span class="Estilo5">C&Oacute;DIGO ESTRUCTURA DE ORDEN:</span></td>
                   <td width="100" ><span class="Estilo5"> <input class="Estilo10" name="txtcod_estructura" type="text" id="txtcod_estructura" size="10" maxlength="8"  readonly value="<?echo $cod_estructura?>" > </span></td>
                   <td width="620"></td>
                   </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="96"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                   <td width="650"><span class="Estilo5"> <input class="Estilo10" name="txtdes_estructura" type="text" id="txtdes_estructura" size="120" maxlength="120" readonly value="<?echo $des_estructura?>" > </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="136"><span class="Estilo5">TIPO DE CALCULO  :</span></td>
                   <td width="150" ><span class="Estilo5"> <input class="Estilo10" name="txttipo_calculo" type="text" id="txttipo_calculo" size="10" maxlength="10"  readonly value="<?echo $tipo_calculo?>" > </span></td>
                   <td width="100"><span class="Estilo5">FECHA DESDE :</span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="10" maxlength="10"  readonly value="<?echo $fecha_desde?>"> </span></td>
                   <td width="70"><span class="Estilo5">HASTA :</span></td>
                   <td width="130"><span class="Estilo5"><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10"  readonly value="<?echo $fecha_hasta?>"> </span></td>
                   <td width="100"><span class="Estilo5">TIPO DE PAGO  :</span></td>
                   <td width="150"><input class="Estilo10" name="txttipo_pago" type="text" id="txttipo_pago" size="10" maxlength="10"  readonly value="<?echo $tipo_pago?>"></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
         </table>
    <div id="Layer3" style="position:absolute; width:731px; height:310px; z-index:2; left: 30px; top: 100px;">
          <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 849;              //ojo puro ojo >>>>> anchura de los tag ojo puro ojo <<<<<<
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Cod. Presupuestarios";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Retenciones";        // Requiere: <div id="T12" class="tab-body">  ... </div>
   rows[1][3] = "Trabajadores";        // Requiere: <div id="T14" class="tab-body">  ... </div>
   rows[1][4] = "Cod. Trabajadores";        // Requiere: <div id="T15" class="tab-body">  ... </div>
   rows[1][5] = "Ret. Trabajadores";        // Requiere: <div id="T16" class="tab-body">  ... </div>
   rows[1][6] = "Otros Pasivos";
   </script>
          <?include ("../class/class_tab.php");?>
          <script type="text/javascript" language="javascript"> DrawTabs(); </script>
          <!-- PESTAÑA 1 -->
          <div id="T11" class="tab-body">
            <iframe src="Det_cod_presupuestarios_nom_cal.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="340" scrolling="auto" frameborder="0"> </iframe>
          </div>
          <!--PESTAÑA 2 -->
          <div id="T12" class="tab-body" >
            <iframe src="Det_retenciones_nom_cal.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="340" scrolling="auto" frameborder="0"> </iframe>
          </div>
          <!-- PESTAÑA 3 -->
          <div id="T13" class="tab-body">
            <iframe src="Det_trabajadores_nom_cal.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="340" scrolling="auto" frameborder="0"> </iframe>
          </div>
                  <!-- PESTAÑA 4 -->
          <div id="T14" class="tab-body">
             <iframe src="Det_cod_trabajadores_nom_cal.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="340" scrolling="auto" frameborder="0"> </iframe>
          </div>
                  <!-- PESTAÑA 5 -->
          <div id="T15" class="tab-body">
            <iframe src="Det_ret_trabajadores_nom_cal.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="340" scrolling="auto" frameborder="0"> </iframe>
          </div>
		   <div id="T16" class="tab-body" >
            <iframe src="Det_pasivos_nom_cal.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="340" scrolling="auto" frameborder="0"> </iframe>
          </div>
    </div>
    <div id="Layer4" style="position:absolute; width:731px; height:40px; z-index:2; left: 30px; top: 500px;">
         <table width="940">
          <tr>
            <td width="20"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="20"><input name="txttp_calculo" type="hidden" id="txttp_calculo" value="<?echo $tp_calculo?>"></td>
            <td width="20"><input name="txtfecha_d" type="hidden" id="txtfecha_d" value="<?echo $fecha_d?>"></td>
            <td width="20"><input name="txtfecha_h" type="hidden" id="txtfecha_h" value="<?echo $fecha_h?>"></td>
            <td width="140">&nbsp;</td>
            <td width="250" align="center" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar" title="Grabar Estructura de Orden" ></td>
            <td width="250" align="center"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
            <td width="220">&nbsp;</td>
          </tr>
        </table>
    </div>
       </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>