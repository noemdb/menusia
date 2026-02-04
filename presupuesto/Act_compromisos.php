<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }   else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="02-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo=getenv("COMPUTERNAME"); $mcod_m="PRE006".$usuario_sia.$equipo;  $fecha_hoy=asigna_fecha_hoy(); 
if (!$_GET){  $p_letra='';   $criterio='';   $referencia_comp='';  $tipo_compromiso='';   $cod_comp='';
  $sql="SELECT * FROM COMPROMISOS ORDER BY tipo_compromiso,referencia_comp,cod_comp,fecha_compromiso"; $codigo_mov=substr($mcod_m,0,49);}
 else { $codigo_mov=""; $criterio=$_GET["Gcriterio"]; $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){
    $referencia_comp=substr($criterio,5,8);  $tipo_compromiso=substr($criterio,1,4); $cod_comp=substr($criterio,13,4);}
   else{$referencia_comp=substr($criterio,4,8); $tipo_compromiso=substr($criterio,0,4); $cod_comp=substr($criterio,12,4);}
  $codigo_mov=substr($mcod_m,0,49);  $clave=$tipo_compromiso.$referencia_comp.$cod_comp;
  $sql="Select * from COMPROMISOS where tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_comp='$cod_comp'" ;
  if ($p_letra=="P"){$sql="SELECT * FROM COMPROMISOS Order by tipo_compromiso,referencia_comp,cod_comp,fecha_compromiso";}
  if ($p_letra=="U"){$sql="SELECT * From COMPROMISOS Order by tipo_compromiso desc,referencia_comp desc,cod_comp desc,fecha_compromiso desc";}
  if ($p_letra=="S"){$sql="SELECT * From COMPROMISOS Where (text(tipo_compromiso)||text(referencia_comp)||text(cod_comp)>'$clave') Order by tipo_compromiso,referencia_comp";}
  if ($p_letra=="A"){$sql="SELECT * From COMPROMISOS Where (text(tipo_compromiso)||text(referencia_comp)||text(cod_comp)<'$clave') Order by text(tipo_compromiso)||text(referencia_comp) desc";}
  } 
$fecha_f=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_f)){$fecha_hoy=$fecha_f;}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Compromisos Presupuestario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var mSIA_Definicion='<?php echo $SIA_Definicion ?>';
function Llamar_Inc_comp(mop){ if(mSIA_Definicion=='N'){ muestra('ETAPA DE DEFINICION ABIERTA'); }
 else{if(mop==1){ document.form2.submit();} if(mop==2){ document.form3.submit();} } }
function Llamar_Modificar(modulo,manu){var murl;
var Gtipo_compromiso=document.form1.txttipo_compromiso.value
  if ((Gtipo_compromiso=="0000")||(Gtipo_compromiso.charAt(0)=="A")||(Gtipo_compromiso=="")||(modulo!="P")||(manu=="S")) { alert("COMPROMISO, NO PUEDE SER MODIFICADO"); }
   else{ murl="Mod_compromisos.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value+"&txtcod_comp="+document.form1.txtcodigo_comp.value; document.location=murl;}
}
function Llamar_Modifica_Imp(modulo,manu){var murl;
var Gtipo_compromiso=document.form1.txttipo_compromiso.value
  if ((Gtipo_compromiso=="A000")||(Gtipo_compromiso.charAt(0)=="A")||(Gtipo_compromiso=="")||(manu=="S")) { alert("COMPROMISO, NO PUEDE SER MODIFICADO"); }
   else{ murl="Mod_imput_compromisos.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value+"&txtcod_comp="+document.form1.txtcodigo_comp.value; document.location=murl;}
}

function Mover_Registro(MPos){var murl;
   murl="Act_compromisos.php";
   if(MPos=="P"){murl="Act_compromisos.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_compromisos.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_compromisos.php?Gcriterio=S"+document.form1.txttipo_compromiso.value+document.form1.txtreferencia_comp.value+document.form1.txtcodigo_comp.value;}
   if(MPos=="A"){murl="Act_compromisos.php?Gcriterio=A"+document.form1.txttipo_compromiso.value+document.form1.txtreferencia_comp.value+document.form1.txtcodigo_comp.value;}
   document.location=murl;
}
function Llama_Eliminar(modulo,manu){var url;var r;
var Gtipo_compromiso=document.form1.txttipo_compromiso.value;
  if ((Gtipo_compromiso=="0000")||(Gtipo_compromiso.charAt(0)=="A")||(Gtipo_compromiso=="")||(modulo!="P")) { alert("COMPROMISO, NO PUEDE SER ELIMINADO"); }
  else{
    if(manu=="S"){url="Compromiso Esta ANULADO, ";}else{url="";}
    r=confirm(url+"Esta seguro en Eliminar el Compromiso Presupuestario ?");
    if (r==true) { r=confirm("Esta Realmente seguro en Eliminar el Compromiso Presupuestario ?");
      if (r==true) { url="Delete_compromisos.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value+"&txtcod_comp="+document.form1.txtcodigo_comp.value;
         VentanaCentrada(url,'Eliminar Compromiso','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
  }
}
function Llama_Anular(modulo,manu,mfechaf){var url; var r;
var Gtipo_compromiso=document.form1.txttipo_compromiso.value;
  if ((Gtipo_compromiso=="0000")||(Gtipo_compromiso.charAt(0)=="A")||(Gtipo_compromiso=="")||(modulo!="P")||(manu=="S")) { alert("COMPROMISO, NO PUEDE SER ANULADO"); }
  else{url="Anula_compromisos.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value+"&txtcod_comp="+document.form1.txtcodigo_comp.value+"&fecha_fin="+mfechaf;
    VentanaCentrada(url,'Anular Compromiso','','800','380','true');}
}
function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Formato Registro Compromiso ?");
   if (r==true) {url="/sia/presupuesto/rpt/Rpt_reg_compromiso.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value+"&txtcod_comp="+document.form1.txtcodigo_comp.value;
    window.open(url);
  }
}
function Llama_Copiar(){var url;
 url="Copia_compromiso.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value+"&txtcod_comp="+document.form1.txtcodigo_comp.value;
 VentanaCentrada(url,'Copiar Compromiso','','400','400','true');
}
function Aprobar(mtipo,mref,mcod_tipo,maprob,mfechaf) { var url;var r; var mdes_comp="el Compromiso ?";  var a=0;
  if(maprob=="S"){alert("COMPROMISO, ESTA APROBADO"); }
  else{ if(mtipo=="0001"){mdes_comp="la Orden de Compra ?";} if(mtipo=="0002"){mdes_comp="la Orden de Servicio ?";}
   r=confirm("Desea Aprobar "+mdes_comp); if (r==true){ r=confirm("Esta Realmente Seguro de Aprobar "+mdes_comp);
   if (r==true) {url="update_aprueba_compromiso.php?txttipo_compromiso="+mtipo+"&txtreferencia_comp="+mref+"&txtcod_comp="+mcod_tipo; document.location=url;} } }
}
function Devolver(mtipo,mref,mcod_tipo,maprob,modulo,manu,mfechaf) { var url;var r; var mdes_comp="el Compromiso ?";  var a=0;
  if ((mtipo=="0000")||(mtipo.charAt(0)=="A")||(mtipo=="")||(manu=="S")) { alert("COMPROMISO, NO PUEDE SER DEVUELTO"); }
  else{url="Devulve_compromisos.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value+"&txtcod_comp="+document.form1.txtcodigo_comp.value;
    VentanaCentrada(url,'Devolver Compromiso','','800','380','true');}
}
function Detalle(mtipo,mref,mcod_tipo,maprob) { var url;var r; var mdes_comp="el Compromiso ?";  var a=0; var criterio;
  url="Det_cons_art_orden.php"; criterio=mref+mtipo+mcod_tipo;
  if(mtipo=="0001"){url="/sia/compras/Det_cons_art_orden.php?criterio="+criterio;}
  if(mtipo=="0002"){url="/sia/compras/Det_cons_serv_orden.php?criterio="+criterio;}
  VentanaCentrada(url,'Anular Compromiso','','800','380','true');
}
</script>
<script language="JavaScript" src="../class/sia.js"  type="text/javascript"></script>
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
<?
if ($codigo_mov==""){$codigo_mov="";}else{
$res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$res=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }}
$mconf="";$Ssql="Select * from SIA005 where campo501='05'";$resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"];}$nro_aut=substr($mconf,1,1); $fecha_aut=substr($mconf,2,1); $aprueba_comp=substr($mconf,15,1);
$descripcion="";$fecha="";$unidad_sol="";$des_unidad_sol="";$nombre_abrev_comp="";$cod_tipo_comp="";$des_tipo_comp="";$l=0;
$ced_rif="";$nombre="";$fecha_vencim="";$nro_documento="";$num_proyecto="";$des_proyecto="";$func_inv="";$fecha_anu="";$usuario_comp="";
$tiene_anticipo="";$tasa_anticipo="";$cod_con_anticipo="";$inf_usuario="";$anulado="";$modulo="";$aprobado="";$nro_expediente="";$fecha_aprobada="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * FROM COMPROMISOS Order by tipo_compromiso,referencia_comp,cod_comp";}
  if ($p_letra=="A"){$sql="SELECT * From COMPROMISOS Order by tipo_compromiso desc,referencia_comp desc,cod_comp desc";}
  $res=pg_query($sql);$filas=pg_num_rows($res);
}
if($filas>0){$registro=pg_fetch_array($res); $referencia_comp=$registro["referencia_comp"]; $cod_comp=$registro["cod_comp"];
  $fecha=$registro["fecha_compromiso"];  $tipo_compromiso=$registro["tipo_compromiso"]; $descripcion=$registro["descripcion_comp"]; $inf_usuario=$registro["inf_usuario"];
  $nombre_abrev_comp=$registro["nombre_abrev_comp"]; $unidad_sol=$registro["unidad_sol"]; $des_unidad_sol=$registro["denominacion_cat"]; $cod_tipo_comp=$registro["cod_tipo_comp"];
  $des_tipo_comp=$registro["des_tipo_comp"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $fecha_vencim=$registro["fecha_vencim"];$fecha_anu=$registro["fecha_anu"];
  $nro_documento=$registro["nro_documento"]; $num_proyecto=$registro["num_proyecto"]; $des_proyecto=$registro["des_proyecto"]; $func_inv=$registro["func_inv"];
  $tiene_anticipo=$registro["tiene_anticipo"]; $tasa_anticipo=$registro["tasa_anticipo"]; $cod_con_anticipo=$registro["cod_con_anticipo"]; $anulado=$registro["anulado"]; 
  $aprobado=$registro["aprobado"]; $nro_expediente=$registro["nro_expediente"]; $modulo=$registro["modulo"]; $usuario_comp=$registro["inf_usuario"]; $inf_usuario=$registro["inf_usuario"];
}
for ($i=0; $i<strlen($inf_usuario); $i++) { if (substr($inf_usuario,$i, 1)==" "){$l=$i; $i=strlen($inf_usuario);} } $usuario_comp=substr($inf_usuario,0,$l);
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
if($fecha_anu==""){$fecha_anu="";}else{$fecha_anu=formato_ddmmaaaa($fecha_anu);}
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="I"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
if($tiene_anticipo=="S"){$tiene_anticipo="SI";}else{$tiene_anticipo="NO";}
$clave=$tipo_compromiso.$referencia_comp.$cod_comp;
$msta=""; $inf_sta=""; if($aprobado=='S'){$msta="APROBADO"; $inf_sta="APROBADO POR:".$nro_expediente.", FECHA:".$fecha_anu;} 
if($aprobado=='D'){$msta="DEVUELTO"; $inf_sta="DEVUELTO POR:".$nro_expediente.", FECHA:".$fecha_anu;}
if($anulado=='S'){$msta="ANULADO"; $inf_sta="ANULADO CON FECHA:".$fecha_anu; }
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">COMPROMISOS PRESUPUESTARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="600" border="0" id="tablacuerpo">
  <tr>
    <td><div id="Layer2" style="position:absolute; width:102px; height:434px; z-index:2; top: 61px; left: 7px;">
      <table width="92" height="594" border="1" cellpadding="0" cellspacing="0" id="tablam">
        <td width="86">
            <td>
              <table width="92" height="592" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
               
		<?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>	
            <tr>		
				<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_comp(1)";
				  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_comp()">Incluir</A></td>
            </tr>
			<?if(($Cod_Emp=="88")or($Cod_Emp<>"88")){?>	
			<tr>		
				<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_comp(2)";
				  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_comp()">Incluir Refiere a Diferido</A></td>
            </tr>
			<? } ?>
			
		<?}if ($Mcamino{2}=="S"){?>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cons_compromisos.php?referencia_comp=<?echo $referencia_comp?>&tipo_compromiso=<?echo $tipo_compromiso?>&nombre_abrev_comp=<?echo $nombre_abrev_comp?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cons_compromisos.php?referencia_comp=<?echo $referencia_comp?>&tipo_compromiso=<?echo $tipo_compromiso?>&nombre_abrev_comp=<?echo $nombre_abrev_comp?>" class="menu">Consultar</a></td>
        </tr>	
       <?//} //if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>	
       <?} if (true){?>	
          <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Modificar('<?echo $modulo ?>','<?echo $anulado ?>')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Modificar('<?echo $modulo?>','<?echo $anulado ?>');">Modificar</A></td>
         </tr>
		<? if(($Mcamino{3}=="S") and (($Cod_Emp=="58")or($Cod_Emp=="86")or($Cod_Emp=="A1")or($Cod_Emp=="32")or($Cod_Emp=="34"))){?>
		  <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Modifica_Imp('<?echo $modulo ?>','<?echo $anulado ?>') ";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Modifica_Imp('<?echo $modulo?>','<?echo $anulado ?>');">Imputacion del Compromiso</A></td>
          </tr>
		<?} } if ($Mcamino{2}=="S"){?>
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
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_compromisos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_compromisos.php" class="menu">Catalogo</a></td>
        </tr>
		<?} if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Anular('<?echo $modulo?>','<?echo $anulado?>','<?echo $Fec_Fin_Ejer?>');" class="menu">Anular</a></td>
        </tr>
		<?//} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
		<?} if (true){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar('<?echo $modulo?>','<?echo $anulado?>');" class="menu">Eliminar</a></td>
        </tr>
		<?} if ($Mcamino{4}=="S"){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
        </tr>
		 <? } // ojo falta camino 11 APROBAR en sia007 ?>   
	<? if(($aprueba_comp=="S")and($anulado=="N")and($Mcamino{11}=="S")){?>
	    <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_comp_por_aprobar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_comp_por_aprobar.php" class="menu">Por Aprobar</a></td>
        </tr>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Aprobar('<? echo $tipo_compromiso ?>','<? echo $referencia_comp?>','<? echo $cod_comp ?>','<? echo $aprobado ?>','<?echo $Fec_Fin_Ejer?>');" class="menu">Aprobar</a></td>
        </tr>        
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Devolver('<? echo $tipo_compromiso ?>','<? echo $referencia_comp?>','<? echo $cod_comp ?>','<? echo $aprobado ?>','<?echo $modulo?>','<?echo $anulado?>','<?echo $Fec_Fin_Ejer?>');" class="menu">Devolver</a></td>
        </tr>
	<?} if(($aprueba_comp=="S")and($anulado=="N")and($Mcamino{2}=="S")and(($tipo_compromiso=="0001")or($tipo_compromiso=="0002"))){?>	
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Detalle('<? echo $tipo_compromiso ?>','<? echo $referencia_comp?>','<? echo $cod_comp ?>','<? echo $aprobado ?>');" class="menu">Detalle</a></td>
        </tr>
	<? } if ($Mcamino{2}=="S"){?>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Copiar();" class="menu">Copiar</a></td>
        </tr>
        <? } ?>	
		<tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/presupuesto/ayuda/ayuda_reg_compro.htm','Ayuda SIA','','1000','1000','true');";
				  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/presupuesto/ayuda/ayuda_reg_compro.htm','Ayuda SIA','','1000','1000','true');" class="menu">Ayuda </a></td>
        </tr>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
            </table></td>
      </table>
    </div>
    <p>&nbsp;</p></td><td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:866px; height:593px; z-index:1; top: 60px; left: 123px;">
            <form name="form1" method="post">
                <table width="847" >
              <tr>
                <td>
                  <table width="842" align="center">
                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="165"> <p><span class="Estilo5">DOCUMENTO COMPROMISO:</span></p>   </td>
                          <td width="38"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" value="<?echo $tipo_compromiso?>" size="6" readonly></td>
                          <td width="54"><span class="Estilo5"><input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" value="<?echo $nombre_abrev_comp?>" size="6" readonly>  </span></td>
                          <td width="50">&nbsp;</td>
                          <td width="81"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="96"><input name="txtreferencia_comp" type="text"  id="txtreferencia_comp" value="<?echo $referencia_comp?>" size="10" readonly></td>
                          <? if($anulado=='S'){?> <td width="90"><a class="Estiloanu"  href="javascript:alert('<?echo $inf_sta?>');">ANULADO</a></td>
                          <? } else{ ?><td width="90"><a class="Estilo11" href="javascript:alert('<?echo $inf_sta?>');"><? echo $msta ?></a></td>  <? }?>
                          <td width="57"><span class="Estilo5">FECHA :</span> </td>
                          <td width="73"><span class="Estilo5"><input name="txtFecha" type="text" id="txtFecha" value="<?echo $fecha?>" size="10" readonly> </span></td>
                          <td width="41"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="815">
                        <tr>
                          <td width="178"><p><span class="Estilo5">CATEGORIA PROGRAMATICA:</span></p> </td>
                          <td width="136"><input name="txtunidad_sol" type="text"  id="txtunidad_sol" value="<?echo $unidad_sol?>" size="20" readonly></td>
                          <td width="485"><input name="txtdes_unidad_sol" type="text"  id="txtdes_unidad_sol" value="<?echo $des_unidad_sol?>" size="80" readonly></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="814">
                        <tr>
                          <td width="167"><span class="Estilo5">TIPO DE COMPROMISO:</span></td>
                          <td width="60"><input name="txtcod_tipo_comp" type="text"  id="txtcod_tipo_comp" value="<?echo $cod_tipo_comp?>" size="8" readonly ></td>
                          <td width="560"><span class="Estilo5"><input name="txtdes_tipo_comp" type="text" id="txtdes_tipo_comp" value="<?echo $des_tipo_comp?>" size="83" readonly>
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="814">
                        <tr>
                          <td width="166"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="150"><span class="Estilo5"><input name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15"  value="<?echo $ced_rif?>" readonly>  </span></td>
                          <td width="482"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="70" readonly>   </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtDescripcion" cols="85" readonly="readonly" class="headers" id="texDescripcion"><?echo $descripcion?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="812">
                        <tr>
                          <td width="164"><span class="Estilo5">N&Uacute;MERO DE DOCUMENTO:</span></td>
                          <td width="400"><input name="txtnro_documento" type="text"  id="txtnro_documento" value="<?echo $nro_documento?>" size="50" readonly ></td>
                          <td width="130"><span class="Estilo5">FECHA VENCIMIENTO:</span></td>
                          <td width="98"><span class="Estilo5"><input name="txtfecha_vencim" type="text" id="txtfecha_vencim" value="<?echo $fecha_vencim?>" size="12" readonly></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="832">
                        <tr>
                          <td width="165"><span class="Estilo5">TIPO DE GASTO :</span></td>
                          <td width="241"><span class="Estilo5"><input name="txtfunc_inv" type="text" id="txtfunc_inv"  value="<?echo $func_inv?>" size="15" readonly>     </span></td>
                          <td width="150" align="center"><span class="Estilo5">TIENE ANTICIPO :</span></td>
                          <td width="122"><span class="Estilo5"><input name="txttiene_anticipo" type="text" id="txttiene_anticipo" size="3"  value="<?echo $tiene_anticipo?>" readonly>  </span></td>
                          <td width="130"><input name="txtcodigo_comp" type="hidden" id="txtcodigo_comp" value="<?echo $cod_comp?>"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="826">
                        <tr>
                          <td width="197"><span class="Estilo5">PORCENTAJE DE ANTICIPO(%):</span></td>
                          <td width="210"><span class="Estilo5"> <input readonly name="txttasa_anticipo" type="text" id="txttasa_anticipo" value="<?ECHO $tasa_anticipo?>" size="8"></span></td>
                          <td width="148"><span class="Estilo5">CUENTA DE ANTICIPO:</span></td>
                          <td width="251"><span class="Estilo5"><input name="txtcod_con_anticipo" type="text" id="txtcod_con_anticipo" value="<?echo $cod_con_anticipo?>" size="30" readonly> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
            </table>
        <iframe src="Det_cons_compromisos.php?criterio=<?echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        </form>
<form name="form2" method="post" action="Inc_compromisos.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtdoc_comp" type="hidden" id="txtdoc_comp" value=""></td>
	 <td width="5"><input name="txtabrev_comp" type="hidden" id="txtabrev_comp" value=""></td>
     <td width="5"><input name="txtref_comp" type="hidden" id="txtref_comp" value=""></td>
	 <td width="5"><input name="txtcod_cat" type="hidden" id="txtcod_cat" value=""></td>
     <td width="5"><input name="txtnomb_cat" type="hidden" id="txtnomb_cat" value=""></td>	 
	 <td width="5"><input name="txttipo_comp" type="hidden" id="txttipo_comp" value="000000"></td>
     <td width="5"><input name="txtdes_tipo_comp" type="hidden" id="txtdes_tipo_comp" value="COMPROMISOS"></td>
	 <td width="5"><input name="txtfecha_ini" type="hidden" id="txtfecha_ini" value="<?echo $fecha_hoy?>" ></td>
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
     <td width="5"><input name="txtcod_est" type="hidden" id="txtcod_est" value="00000000" ></td>	 
	 <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value=""></td>
     <td width="5"><input name="txtnomb_r" type="hidden" id="txtnomb_r" value=""></td>
	 <td width="5"><input name="txtconcepto_r" type="hidden" id="txtconcepto_r" value=""></td>
	 <td width="5"><input name="txtfechac" type="hidden" id="txtfechac" value="<?echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txtnro_doc" type="hidden" id="txtnro_doc" value=""></td>
	 <td width="5"><input name="txtfechav" type="hidden" id="txtfechav" value="<?echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txttiene_ant" type="hidden" id="txttiene_ant" value="NO"></td>
	 <td width="5"><input name="txtcon_est" type="hidden" id="txtcon_est" value="NO"></td>
	 <td width="5"><input name="txtfunc_inv" type="hidden" id="txtfunc_inv" value="C"></td>
	 <td width="5"><input name="txttasa_ant" type="hidden" id="txttasa_ant" value=""></td>
	 <td width="5"><input name="txtcod_cuenta" type="hidden" id="txtcod_cuenta" value=""></td>
  </tr>
</table>
</form>

<form name="form3" method="post" action="Inc_compromisos_dife.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtdoc_comp" type="hidden" id="txtdoc_comp" value=""></td>
	 <td width="5"><input name="txtabrev_comp" type="hidden" id="txtabrev_comp" value=""></td>
     <td width="5"><input name="txtref_comp" type="hidden" id="txtref_comp" value=""></td>
	 <td width="5"><input name="txtcod_cat" type="hidden" id="txtcod_cat" value=""></td>
     <td width="5"><input name="txtnomb_cat" type="hidden" id="txtnomb_cat" value=""></td>	 
	 <td width="5"><input name="txttipo_comp" type="hidden" id="txttipo_comp" value="000000"></td>
     <td width="5"><input name="txtdes_tipo_comp" type="hidden" id="txtdes_tipo_comp" value="COMPROMISOS"></td>
	 <td width="5"><input name="txtfecha_ini" type="hidden" id="txtfecha_ini" value="<?echo $fecha_hoy?>" ></td>
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
     <td width="5"><input name="txtcod_est" type="hidden" id="txtcod_est" value="00000000" ></td>	 
	 <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value=""></td>
     <td width="5"><input name="txtnomb_r" type="hidden" id="txtnomb_r" value=""></td>
	 <td width="5"><input name="txtconcepto_r" type="hidden" id="txtconcepto_r" value=""></td>
	 <td width="5"><input name="txtfechac" type="hidden" id="txtfechac" value="<?echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txtnro_doc" type="hidden" id="txtnro_doc" value=""></td>
	 <td width="5"><input name="txtfechav" type="hidden" id="txtfechav" value="<?echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txttiene_ant" type="hidden" id="txttiene_ant" value="NO"></td>
	 <td width="5"><input name="txtfunc_inv" type="hidden" id="txtfunc_inv" value="C"></td>
	 <td width="5"><input name="txttasa_ant" type="hidden" id="txttasa_ant" value=""></td>
	 <td width="5"><input name="txtcod_cuenta" type="hidden" id="txtcod_cuenta" value=""></td>
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
