<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000070"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');
$equipo = getenv("COMPUTERNAME"); $mcod_m = "ban016".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
if (!$_GET){ $periodo='';  $p_letra='';  $sql="SELECT * FROM ban016 Order by periodo Desc";}
else {  $periodo = $_GET["Gperiodo"];  $p_letra=substr($periodo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$periodo=substr($periodo,1,2);}
  $sql="Select * from ban016 where periodo='$periodo'";
  if ($p_letra=="P"){$sql="SELECT * FROM ban016 Order by periodo";}
  if ($p_letra=="U"){$sql="SELECT * From ban016 Order by periodo Desc";}
  if ($p_letra=="S"){$sql="SELECT * From ban016 Where (periodo>'$periodo') Order by periodo";}
  if ($p_letra=="A"){$sql="SELECT * From ban016 Where (periodo<'$periodo') Order by periodo Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Generar Flujo de Caja)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Mover_Registro(MPos){ var murl;
   murl="Act_Gen_Flujo_Caja.php";
   if(MPos=="P"){murl="Act_Gen_Flujo_Caja.php?Gperiodo=P"}
   if(MPos=="U"){murl="Act_Gen_Flujo_Caja.php?Gperiodo=U"}
   if(MPos=="S"){murl="Act_Gen_Flujo_Caja.php?Gperiodo=S"+document.form1.txtperiodo.value;}
   if(MPos=="A"){murl="Act_Gen_Flujo_Caja.php?Gperiodo=A"+document.form1.txtperiodo.value;}
   document.location = murl;
}
function Llamar_Inc_Comp_iva(){ document.form2.submit(); }
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar el  Flujo de Caja ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar  Flujo de Caja ?");
    if (r==true) {url="Delete_flujo_caja.php?periodo="+document.form1.txtperiodo.value; VentanaCentrada(url,'Eliminar Gastos del Flujo de Caja','','400','400','true');}
  }else { url="Cancelado, no elimino"; }
}
</script>
<script language=JavaScript src="../class/sia.js" type=text/javascript></script>
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
</head>
<?php  $ano_eje=substr($Fec_Fin_Ejer,0,4);$nombre_mes="";$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){ if ($p_letra=="A"){$sql="SELECT * FROM ban016 Order by periodo";}  if ($p_letra=="S"){$sql="SELECT * FROM ban016 Order by periodo desc";} $res=pg_query($sql); $filas=pg_num_rows($res);} 
if($filas>0){  $registro=pg_fetch_array($res);  $periodo=$registro["periodo"];   }
if($periodo=="01"){$nombre_mes="ENERO";} if($periodo=="02"){$nombre_mes="FEBRERO";} if($periodo=="03"){$nombre_mes="MARZO";} if($periodo=="04"){$nombre_mes="ABRIL";}  if($periodo=="05"){$nombre_mes="MAYO";} if($periodo=="06"){$nombre_mes="JUNIO";}
if($periodo=="07"){$nombre_mes="JULIO";} if($periodo=="08"){$nombre_mes="AGOSTO";} if($periodo=="09"){$nombre_mes="SEPTIEMBRE";} if($periodo=="10"){$nombre_mes="OCTUBRE";}  if($periodo=="11"){$nombre_mes="NOVIEMBRE";} if($periodo=="12"){$nombre_mes="DICIEMBRE";}
$clave=$periodo; 
$Uperiodo=0; $sql="SELECT * FROM ban016 Order by periodo desc"; $res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);  $Uperiodo=$registro["periodo"]; }
$Uperiodo=$Uperiodo*1; IF($Uperiodo<12){$Uperiodo=$Uperiodo+1;}
$len=strlen($Uperiodo); $Uperiodo=substr("00",0,2-$len).$Uperiodo;
?>
<body>
<table width="989" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR FLUJO DE CAJA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="510" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="502" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
       <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>    
      <tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Comp_iva()";
         onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Inc_Comp_iva()">Incluir</a></div></td>
  </tr>  
  <?php } if ($Mcamino{2}=="S"){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
         onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Mover_Registro('P');">Primero</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
  </tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
  </tr>
  <?php } if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
  </tr>
  <?php } ?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="menu.php" class="menu">Menu </a></div></td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:491px; z-index:1; top: 62px; left: 118px;">
        <form name="form1" method="post">
          <table width="856" border="0" >
            <tr> <td width="850" height="5">&nbsp;</td> </tr>
          </table>
              <table width="889" border="0">
                <tr>
                  <td><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="110"><span class="Estilo5">MES PROCESO: </span></td>
                      <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtnomb_mes" type="text" id="txtnomb_mes" size="20" maxlength="20" readonly value="<?php echo $nombre_mes ?>"> </span></td>
                      <td width="550"><span class="Estilo5"><input class="Estilo10" name="txtperiodo" type="text" id="txtperiodo" size="3" maxlength="3" readonly value="<?php echo $periodo ?>"> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td>  </tr>
              </table>
          <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:312px; z-index:2; left: 2px; top: 60px;">
              <script language="javascript" type="text/javascript">
  
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Movimientos";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Resultados";        // Requiere: <div id="T12" class="tab-body">  ... </div>
            </script>
              <?php include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_gen_flujo_caja.php?criterio=<?php echo $clave?>"  width="846" height="390" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_cons_res_flujo_caja.php?criterio=<?php echo $clave?>"  width="846" height="390" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
 </form>
<form name="form2" method="post" action="Inc_gen_flujo_caja.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtano_eje" type="hidden" id="txtano_eje" value="<?php echo $ano_eje?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtUperiodo" type="hidden" id="txtUperiodo" value="<?php echo $Uperiodo?>" ></td>	
  </tr>
</table>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>