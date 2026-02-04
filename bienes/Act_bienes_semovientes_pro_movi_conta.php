<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$equipo = getenv("COMPUTERNAME");
$mcod_m = "BIEN026".$equipo;
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="02-0000030"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){$p_letra="";$referencia='';
  $sql="SELECT * FROM BIEN026 ORDER BY referencia";
  $codigo_mov=substr($mcod_m,0,49);
} else {
  $codigo_mov="";
  $referencia = $_GET["Greferencia"];
  $p_letra=substr($referencia, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$referencia=substr($referencia,1,12);}
   else{$referencia=substr($referencia,0,12);$codigo_mov=substr($mcod_m,0,49);}
  $clave=$referencia;
print_r($clave);
  $sql="Select * from BIEN026 where referencia='$referencia' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN026 ORDER BY referencia";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN026 Order by referencia desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN026 Where (referencia>'$clave') Order by referencia";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN026 Where (referencia<'$clave') Order by referencia desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Actualiza Movimientos Bienes Semovientes)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Greferencia= "";
function Llamar_Ventana(url){var murl;
    Greferencia=document.form1.txtreferencia.value;
    murl=url+Greferencia;
    if (Greferencia=="")
        {alert("referencia debe ser Seleccionado");}
        else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_bienes_semovientes_pro_movi_conta.php";
   if(MPos=="P"){murl="Act_bienes_semovientes_pro_movi_conta.php?Greferencia=P"}
   if(MPos=="U"){murl="Act_bienes_semovientes_pro_movi_conta.php?Greferencia=U"}
   if(MPos=="S"){murl="Act_bienes_semovientes_pro_movi_conta.php?Greferencia=S"+document.form1.txtreferencia.value;}
   if(MPos=="A"){murl="Act_bienes_semovientes_pro_movi_conta.php?Greferencia=A"+document.form1.txtreferencia.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar Movimientos de Bienes Semovientes?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar Movimientos de Bienes Semovientes?");
    if (r==true) {url="Delete_bienes_semovientes_pro_movi_conta.php?Greferencia="+document.form1.txtreferencia.value+"&Gfecha="+document.form1.txtfecha.value; VentanaCentrada(url,'Eliminar Movimientos de Bienes Semovientes','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
<?php 
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($codigo_mov==""){$codigo_mov="";}
else{
 $res=pg_exec($conn,"SELECT BORRAR_BIEN050('$codigo_mov')");
 $error=pg_errormessage($conn); $error=substr($error, 0, 61);
 if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
}
if ($codigo_mov==""){$codigo_mov="";}
else{
 $res=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')");
 $error=pg_errormessage($conn); $error=substr($error, 0, 61);
 if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
}
$referencia=""; $fecha="";  $cod_dependencia=""; $descripcion=""; $denominacion_dep="";
$res=pg_query($sql);
$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * From BIEN026 ORDER BY referencia";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN026 ORDER BY referencia desc";}
  $res=pg_query($sql);
  $filas=pg_num_rows($res);
}
if($filas>=0){
  $registro=pg_fetch_array($res,0);
$referencia=$registro["referencia"];
$fecha=$registro["fecha"]; 
//if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$cod_dependencia=$registro["cod_dependencia"]; 
$descripcion=$registro["descripcion"];
}
$clave=$referencia.$fecha;
print_r($clave);

//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dep=$registro["denominacion_dep"];}
?>
<body>
<table width="998" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MOVIMIENTOS DE BIENES SEMOVIENTES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="998" height="230" border="0" id="tablacuerpo">
  <tr>
     <td>
    <table width="92" height="230" border="1" cellpadding="0" cellspacing="0" id="tablam">
   <td width="95" height="230"><table width="92" height="230" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?php if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_bienes_semovientes_pro_movi_conta.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_bienes_semovientes_pro_movi_conta.php">Incluir</A></td>
      </tr>
     <?php } if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
     <?php } if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <?php }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
       </tr>
      
        <td height="230">&nbsp;</td>
      </tr>
    </table></td> </table>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:954px; height:523px; z-index:1; top: 73px; left: 133px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><table width="962">
           <tr>
             <td><table width="962">
               <tr>
                 <td width="100" scope="col"><span class="Estilo5">REFERENCIAS MOVIMIENTO :</span></td>
                 <td width="113" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>                   
		<input name="txtreferencia" type="text" id="txtreferencia" size="10" maxlength="8"   value="<?php echo $referencia?>" readonly class="Estilo5">
</strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 <td width="100" scope="col"><span class="Estilo5">FECHA DEL MOVIMIENTO :</span></td>
                 <td width="653" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha" type="text" id="txtfecha" size="15" maxlength="15"   value="<?php echo $fecha?>" readonly class="Estilo5">
                 </span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></div></td>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?php echo $cod_dependencia?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                    
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="747" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="75" maxlength="250" value="<?php echo $denominacion_dep?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></div></td>
                 <td width="859" scope="col"><div align="left">
                     <textarea name="textdescripcion" cols="70" readonly class="Estilo5" id="textdescripcion"><?php echo $descripcion?></textarea>
                 </div></td>
               </tr>
             </table></td>
           </tr>
        </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:346px; z-index:2; left: 2px; top: 140px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Bienes";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Comprobantes";            // Requiere: <div id="T12" class="tab-body">  ... </div>
            </script>
              <?php include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_movimientos_bienes_semo.php?criterio=<?php echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>              
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_cons_comp_movimientos_bienes_semo.php?criterio=<?php echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>


            </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
