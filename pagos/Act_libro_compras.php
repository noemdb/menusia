<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="02-0000030"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG032".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
if (!$_GET){ $mes_libro='';  $p_letra='';  $sql="SELECT * FROM PAG032 Order by mes_libro Desc";}
else {  $mes_libro = $_GET["Gmes_libro"];  $p_letra=substr($mes_libro, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$mes_libro=substr($mes_libro,1,2);}
  $sql="Select * from PAG032 where mes_libro='$mes_libro'";
  if ($p_letra=="P"){$sql="SELECT * FROM PAG032 Order by mes_libro";}
  if ($p_letra=="U"){$sql="SELECT * From PAG032 Order by mes_libro Desc";}
  if ($p_letra=="S"){$sql="SELECT * From PAG032 Where (mes_libro>'$mes_libro') Order by mes_libro";}
  if ($p_letra=="A"){$sql="SELECT * From PAG032 Where (mes_libro<'$mes_libro') Order by mes_libro Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Generar Libro de Compras)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Mover_Registro(MPos){ var murl;
   murl="Act_libro_compras.php";
   if(MPos=="P"){murl="Act_libro_compras.php?Gmes_libro=P"}
   if(MPos=="U"){murl="Act_libro_compras.php?Gmes_libro=U"}
   if(MPos=="S"){murl="Act_libro_compras.php?Gmes_libro=S"+document.form1.txtmes_libro.value;}
   if(MPos=="A"){murl="Act_libro_compras.php?Gmes_libro=A"+document.form1.txtmes_libro.value;}
   document.location = murl;
}
function Llamar_Inc_Comp_iva(){ document.form2.submit(); }
function Llamar_Mod_Libro_Comp(mano_eje){var murl; murl="Mod_libro_comp.php?mes_libro="+document.form1.txtmes_libro.value+"&ano_eje="+mano_eje;  document.location=murl; }
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar el Libro de Compras ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Libro de Compras ?");
    if (r==true) {url="Delete_libro_compras.php?txtmes_libro="+document.form1.txtmes_libro.value; VentanaCentrada(url,'Eliminar Libro de Compras','','400','400','true');}
  }else { url="Cancelado, no elimino"; }
}
</script>
<script language="JavaScript" src="../class/sia.js" type=text/javascript></script>
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
<? $ano_eje=substr($Fec_Fin_Ejer,0,4);
$resultado=pg_exec($conn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$nombre_mes="";$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){ if ($p_letra=="A"){$sql="SELECT * FROM PAG032 Order by mes_libro";}  if ($p_letra=="S"){$sql="SELECT * FROM PAG032 Order by mes_libro desc";}
  $res=pg_query($sql); $filas=pg_num_rows($res);
} $fecha="";
if($filas>0){  $registro=pg_fetch_array($res);
  $mes_libro=$registro["mes_libro"]; $ano_fiscal=$registro["ano_fiscal"]; $mes_fiscal=$registro["mes_fiscal"]; $fecha=$registro["fecha_emision"];  $ced_rif=$registro["ced_rif"];
}
if($mes_libro=="01"){$nombre_mes="ENERO";} if($mes_libro=="02"){$nombre_mes="FEBRERO";} if($mes_libro=="03"){$nombre_mes="MARZO";} if($mes_libro=="04"){$nombre_mes="ABRIL";}  if($mes_libro=="05"){$nombre_mes="MAYO";} if($mes_libro=="06"){$nombre_mes="JUNIO";}
if($mes_libro=="07"){$nombre_mes="JULIO";} if($mes_libro=="08"){$nombre_mes="AGOSTO";} if($mes_libro=="09"){$nombre_mes="SEPTIEMBRE";} if($mes_libro=="10"){$nombre_mes="OCTUBRE";}  if($mes_libro=="11"){$nombre_mes="NOVIEMBRE";} if($mes_libro=="12"){$nombre_mes="DICIEMBRE";}
$clave=$mes_libro; if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
?>
<body>
<table width="989" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR LIBRO DE COMPRAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="510" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="502" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
       <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>    
      
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Comp_iva()";
         onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Inc_Comp_iva()">Incluir</a></div></td>
  </tr>
  <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Mod_Libro_Comp('<? echo $ano_eje; ?>')";
         onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Mod_Libro_Comp('<? echo $ano_eje; ?>');">Modificar</a></div></td>
  </tr>
  <?} if ($Mcamino{2}=="S"){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
         onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Mover_Registro('P');">Primero</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
  </tr>
  <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
  </tr>
  <?} ?>
  <tr>
	<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:VentanaCentrada('/sia/pagos/ayuda/ayuda_generar_libro_com.htm','Ayuda SIPAP','','1000','1000','true');";
		  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:VentanaCentrada('/sia/pagos/ayuda/ayuda_generar_libro_com.htm','Ayuda SIPAP','','1000','1000','true');" class="menu">Ayuda </a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="menu.php" class="menu">Menu </a></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
                      <td width="210"><span class="Estilo5"><input class="Estilo10" name="txtnomb_mes" type="text" id="txtnomb_mes" size="15" maxlength="15" readonly value="<?echo $nombre_mes ?>"> </span></td>
                      <td width="540"><span class="Estilo5"><input class="Estilo10" name="txtmes_libro" type="text" id="txtmes_libro" size="3" maxlength="3" readonly value="<?echo $mes_libro ?>"> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td>  </tr>
              </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_cons_libro_comp.php?criterio=<?echo $clave?>" width="870" height="400" scrolling="auto" frameborder="1"></iframe>
              </div>
        </form>
<form name="form2" method="post" action="Inc_libro_compas.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtano_eje" type="hidden" id="txtano_eje" value="<?echo $ano_eje?>" ></td>
  </tr>
</table>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>