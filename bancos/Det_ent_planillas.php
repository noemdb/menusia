<?include ("../class/conect.php");  include ("../class/funciones.php");    $fecha_hoy=asigna_fecha_hoy(); $equipo=getenv("COMPUTERNAME");  $mcod_m="BAN013".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if(pg_ErrorMessage($conn)){ echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if(!$_GET){$tipo_planilla='00';$plan_desde='00000000';$plan_hasta='00000000';$fecha_desde='2008-01-01';$fecha_hasta='2008-01-01';}
else{$tipo_planilla=$_GET["tipo_planilla"];$plan_desde=$_GET["plan_desde"];$plan_hasta=$_GET["plan_hasta"];$fecha_desde=$_GET["fecha_desde"];$fecha_hasta=$_GET["fecha_hasta"];}  $fecha_hoy=asigna_fecha_hoy();
$cod_ret="00"; $nro_deposito=""; $nom_banco=""; $fecha_ent=$fecha_hoy;
$sql="select * from ban013 where tipo_planilla='$tipo_planilla' and (nro_planilla in (SELECT nro_planilla FROM ban012 where tipo_planilla='$tipo_planilla' and nro_planilla>='$plan_desde' and nro_planilla<='$plan_hasta' and fecha_emision>='$fecha_desde' and fecha_emision<='$fecha_hasta'))";
$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>=1){$reg=pg_fetch_array($res,0); $cod_ret=$reg["cod_retencion"]; $nro_deposito=$reg["nro_deposito"]; $nom_banco=$reg["nombre_banco_ent"]; $fecha_ent=$reg["fecha_enterado"]; $fecha_ent=formato_ddmmaaaa($fecha_ent);}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTROL BANCARIO (Detalles Planillas de Retencion)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
</head>
<script language="JavaScript" type="text/JavaScript">
function chequea_cod_ret(mform){var mref;
   mref=mform.txtcod_ret.value; mref = Rellenarizq(mref,"0",2);  mform.txtcod_ret.value=mref;
return true;}
function Llama_Modificar(planilla,nro_planilla){var murl; var cod_ret; var fechae; var deposito; var banco;
 cod_ret=document.form1.txtcod_ret.value; fechae=document.form1.txtfecha_ent.value;  deposito=document.form1.txtnro_deposito.value; banco=document.form1.txtnomb_banco.value;
 murl="Mod_planilla_ent.php?planilla="+planilla+"&nro_planilla="+nro_planilla+"&pdesde=<?echo $plan_desde?>&phasta=<?echo $plan_hasta?>&fdesde=<?echo $fecha_desde?>&fhasta=<?echo $fecha_hasta?>"+"&cod_ret="+cod_ret+"&fechae="+fechae+"&deposito="+deposito+"&banco="+banco; document.location=murl; }
function Entera_todos(){ var url; var cod_ret; var fechae; var deposito; var banco; var r;
 cod_ret=document.form1.txtcod_ret.value; fechae=document.form1.txtfecha_ent.value;  deposito=document.form1.txtnro_deposito.value; banco=document.form1.txtnomb_banco.value;
 r=confirm("Registrar todas las planillas como Enterada ?");  if (r==true){url="entera_todas.php?planilla=<?echo $tipo_planilla?>&pdesde=<?echo $plan_desde?>&phasta=<?echo $plan_hasta?>&fdesde=<?echo $fecha_desde?>&fhasta=<?echo $fecha_hasta?>"+"&cod_ret="+cod_ret+"&fechae="+fechae+"&deposito="+deposito+"&banco="+banco; document.location=url; }
}
</script>
<body>
<form name="form1" method="post">
<table width="945" border="0">
   <tr>
      <td><table width="940">
          <tr>
            <td width="150"><span class="Estilo5">C&Oacute;DIGO DE RETENCION :</span></td>
            <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtcod_ret" type="text" id="txtcod_ret" size="3" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_cod_ret(this.form);" value="<?echo $cod_ret;?>"  >  </span> </td>
            <td width="115"><span class="Estilo5">FECHA ENTERADO : </span></td>
            <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_ent" type="text" id="txtfecha_ent" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $fecha_ent;?>">  </span> </td>
            <td width="115"><span class="Estilo5">NRO. DEPOSITO : </span></td>
            <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtnro_deposito" type="text" id="txtnro_deposito" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nro_deposito;?>"> </span></td>
            <td width="200" align="center"><input class="Estilo10" name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar las planillas de retencion"></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="940">
          <tr>
            <td width="150"><span class="Estilo5">NOMBRE DEL BANCO :</span></td>
            <td width="580"><span class="Estilo5"><input class="Estilo10" name="txtnomb_banco" type="text" id="txtnomb_banco" size="100" maxlength="80"  onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_cod_ret(this.form);" value="<?echo $nom_banco;?>" >  </span> </td>
            <td width="200" align="center"><input class="Estilo10" name="btTodos" type="button" id="btTodos" onClick="JavaScript:Entera_todos();" value="Todos" title="Entera todas las planillas de retencion"></td>
          </tr>
      </table></td>
    </tr>

   <tr>
     <td>
<?php $sql="SELECT * FROM PLANILLA_ENT where tipo_planilla='$tipo_planilla' and nro_planilla>='$plan_desde' and nro_planilla<='$plan_hasta' and fecha_emision>='$fecha_desde' and fecha_emision<='$fecha_hasta' order by nro_planilla"; $res=pg_query($sql);
?>
 <table width="2010" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="2000">
       <table width="2000"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_orden">
         <tr height="20" class="Estilo5">
           <td width="80" align="left" bgcolor="#99CCFF" ><strong>Nro. Planilla</strong></td>
           <td width="90" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
           <td width="50" align="right" bgcolor="#99CCFF" ><strong>Tasa </strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto Objeto </strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto Ret.</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Cod.Ret</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha Ent.</strong></td>
           <td width="250" align="left" bgcolor="#99CCFF" ><strong>Nombre Banco</strong></td>
           <td width="80"  align="left" bgcolor="#99CCFF"><strong>Deposito</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF" ><strong>Tipo Enriquecimiento </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Documento </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Nro. Documento </strong></td>
           <td width="140" align="right" bgcolor="#99CCFF" ><strong>Monto pago</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced/rif</strong></td>
           <td width="330" align="left" bgcolor="#99CCFF" ><strong>Nombre</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)){ $monto_r=formato_monto($registro["monto_retencion"]);
  $monto_o=formato_monto($registro["monto_objeto"]); $tasa=formato_monto($registro["tasa"]); $monto_p=formato_monto($registro["monto_pago"]);  $monto2=formato_monto($registro["monto2"]);
  if($registro["cod_retencion"]==""){$cod_retencion="00";$fecha_enterado="";$nombre_b="";$deposito="";} else{$cod_retencion=$registro["cod_retencion"];$fecha_enterado=$registro["fecha_enterado"];$nombre_b=$registro["nombre_banco_ent"];$deposito=$registro["nro_deposito"];}
  if(($cod_retencion!="00")or($nombre_b!="")){$fecha_ent=formato_ddmmaaaa($fecha_enterado); $total=$total+$registro["monto_retencion"];} else{$total=$total; $fecha_ent="";}
  $sfecha=$registro["fecha_emision"];  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $registro["tipo_planilla"]; ?>','<? echo $registro["nro_planilla"]; ?>');">
           <td width="80" align="left"><? echo $registro["nro_planilla"]; ?></td>
           <td width="90" align="left"><? echo $fecha; ?></td>
           <td width="50" align="right"><? echo $tasa; ?></td>
           <td width="120" align="right"><? echo $monto_o; ?></td>
           <td width="120" align="right"><? echo $monto_r; ?></td>
           <td width="40" align="left"><? echo $cod_retencion; ?></td>
           <td width="100" align="left"><? echo $fecha_ent; ?></td>
           <td width="250" align="left"><? echo $nombre_b; ?></td>
           <td width="80" align="left"><? echo $deposito; ?></td>
           <td width="200" align="left"><? echo $registro["tipo_en"]; ?></td>
           <td width="120" align="left"><? echo $registro["tipo_documento"]; ?></td>
           <td width="120" align="left"><? echo $registro["nro_documento"]; ?></td>
           <td width="140" align="right"><? echo $monto_p; ?></td>
           <td width="100" align="left"><? echo $registro["ced_rif"]; ?></td>
           <td width="330" align="left"><? echo $registro["nombre"]; ?></td>
         </tr>
         <?} $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr> <td>&nbsp;</td> </tr>  <tr> <td>&nbsp;</td> </tr>
   <tr>
     <td><table width="830" border="0">
       <tr>
         <td width="530">&nbsp;</td>
         <td width="150" align="center"><span class="Estilo5">TOTAL :</span></td>
         <td><table width="125" border="1" cellspacing="0" cellpadding="0">
           <tr> <td width="123" align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 </form>
</body>
</html>
<? pg_close(); ?>