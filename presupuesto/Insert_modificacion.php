<?include ("../class/conect.php");  include ("../class/funciones.php");include ("Ver_dispon.php"); include ("../class/configura.inc");error_reporting(E_ALL);
$formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $referencia_modif=$_POST["txtreferencia_modif"];$tipo_modif=$_POST["txttipo_modif"];
$fecha_registro=$_POST["txtfecha"];$descripcion_dife=$_POST["txtdescripcion"];$codigo_mov=$_POST["txtcodigo_mov"];$tmodif=$_POST["txtmodif_i_e"];
$aprobada_por=$_POST["txtaprobada_por"];$modif_aprob=$_POST["txtmodif_aprob"];$fecha_documento=$_POST["txtfecha"];$fecha_modif=$_POST["txtfecha"];
$nro_documento=$_POST["txtnro_documento"];$nro_aut=$_POST["txtnro_aut"];$fecha_aut=$_POST["txtfecha_aut"];$modif_aprob=substr($modif_aprob,0,1);$modif_I_E="I";
if($tmodif=="EXTERNA MAYOR AL 20%"){$modif_i_e="1";}if($tmodif=="EXTERNA MENOR AL 20%"){$modif_i_e="2";}if($tmodif=="EXTERNA IGUAL 10%"){$modif_i_e="3";}
if($tmodif=="INTERNA"){$modif_i_e="I";}if($tmodif=="EXTERNA"){$modif_i_e="E";} $equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$descripcion_dife=cambiar_car_especiales($descripcion_dife); 
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha_registro)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA REGISTRO NO ES VALIDA');</script><? }
if (checkData($fecha_modif)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA MODIFICACION NO ES VALIDA');</script><? }
if (checkData($fecha_documento)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA DOCUMENTO NO ES VALIDA');</script><? }
if ($error==0){
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICIÒN ABIERTA');</script><?}
  if($error==0){ $fecha_hoy=asigna_fecha_hoy();  $tipo_m="1"; $mconf="";
    if($tipo_modif=="Creditos Adicionales"){$tipo_m="1";}  if($tipo_modif=="Rectificaciones"){$tipo_m="2";}
    if($tipo_modif=="Insubsistencia"){$tipo_m="3";} if($tipo_modif=="Reduccion de Ingresos"){$tipo_m="4";}
    if($tipo_modif=="Traspasos de Creditos"){$tipo_m="5";}  if($tipo_modif=="Saldo Final de Caja"){$tipo_m="6";} if($tipo_modif=="Incremento de Ingresos"){$tipo_m="7";} 
	$Ssql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($Ssql); $tipo_dife="0001"; $campo572="";
    if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $campo572=trim($registro["campo572"]); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}}
    $nro_aut=substr($mconf,10,1);$fecha_aut=substr($mconf,11,1);$preg_t=substr($mconf,12,1);  $corr_m=substr($mconf,13,1); $modif_apr=substr($mconf,15,1);
	if($campo572==""){$campo572="0001";}  $tipo_dife=$campo572;
	
    if($fecha_aut=="S"){$fecha_registro=$fecha_hoy;}
    if(($tipo_m=="3")or($tipo_m=="4")){$nro_documento=$nro_documento;$modif_aprob="S";}
     else{$aprobada_por="";$fecha_documento=$fecha_registro;$fecha_modif=$fecha_registro;$nro_documento="";$modif_aprob="N";}
  }
  if($error==0){  $sSQL="Select * from pre009 WHERE referencia_modif='$referencia_modif' and tipo_modif='$tipo_m'";
    $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas>0){echo $tipo_modif." ".$sSQL,"<br>"; $error=1;?><script language="JavaScript">muestra('REFERENCIA DE LA MODIFICACION YA EXISTE');</script><?}
  }
  $sfecha=formato_aaaammdd($fecha_registro); $mfecha=formato_aaaammdd($fecha_modif);  $dfecha=formato_aaaammdd($fecha_documento);
  if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE REGISTRO INVALIDA');</script><?}
    if (($mfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){ echo $_POST["txtfecha"]." ".$fecha_aut." ".$mfecha." ".$Fec_Fin_Ejer." ".$Fec_Ini_Ejer,"<br>"; $error=1;?><script language="JavaScript">muestra('FECHA DE MODIFICACION INVALIDA');</script><?}
  }  
  if($error==0){$nmes=substr($fecha_registro,3, 2);
    if ($SIA_Periodo>$nmes){echo "Ultimo Periodo: ".$SIA_Periodo." Periodo de la Modificacion: ".$nmes; $error=1;?><script language="JavaScript">muestra('FECHA DE MODIFICACION MENOR A ULTIMO PERIODO CERRADO');</script><?}
  }  
  if($error==0){  $sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup";  $res=pg_query($sql);
    $total=0;$totals=0;$totalr=0; 
    while($registro=pg_fetch_array($res)){ $total=$total+$registro["monto"]; $monto_c=$registro["monto"];  $operacion=$registro["operacion"];
      if($operacion=="-"){$totalr=$totalr+$registro["monto"];
        if (verifica_disponibilidad($conn,$registro["cod_presup"],$registro["fuente_financ"],$fecha_registro,$monto_c)==0){$error=0;}
           else{$error=1;?><script language="JavaScript">muestra('ERRROR EN EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?>');</script><?}
      }else{$totals=$totals+$registro["monto"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"];
	     $sSQL="Select cod_presup from pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$fuente_financ'";$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
         if ($filas==0){$error=1;  echo "Codigo:".$mcodigo." Fuente:".$mfuente,"<br>"; ?> <script language="JavaScript">muestra('CODIGO PRESUPUESTARIO NO EXISTE');</script> <? } }
    }
    if($total==0){$error=1;?><script language="JavaScript">muestra('MONTO DE LA MODIFICACION INVALIDO');</script><?}
    if(($tipo_m=="5")or($tipo_m=="2")){ if($totalr>$totals){$balance=$totalr-$totals;}else{$balance=$totals-$totalr;}
	  //echo $totalr." ".$totals." ".$balance;
      if($balance>0.001){echo $totalr." ".$totals." ".$balance; $error=1;?><script language="JavaScript">muestra('MONTO DEL TRASPASO INVALIDO');</script><?}
    }
  }
  if($error==0){$sfecha=formato_aaaammdd($fecha_registro);$mfecha=formato_aaaammdd($fecha_modif);
     $resultado=pg_exec($conn,"SELECT INCLUYE_PRE009('$codigo_mov','$referencia_modif','$tipo_m','$sfecha','$mfecha','$nro_documento','$dfecha','$modif_i_e','$modif_aprob','','$aprobada_por','N','$minf_usuario','$nro_aut','$corr_m','$tipo_dife','P','N','$usuario_sia','$descripcion_dife')");    $error=pg_errormessage($conn);$error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}else{$error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Act_modificaciones.php?Gcriterio=<? echo $referencia_modif.$tipo_m; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? } ?>
