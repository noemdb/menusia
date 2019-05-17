<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../presupuesto/Ver_dispon.php");
$codigo_mov=$_POST["txtcodigo_mov"];$cod_presup=$_POST["txtcod_presup"]; $fecha=asigna_fecha_hoy();
$fuente_financ=$_POST["txtcod_fuente"];$monto_c=formato_numero($_POST["txtmonto"]); if(is_numeric($monto_c)){$monto=$monto_c;} else{$monto=0;}
$tipo_imput_presu=$_POST["txttipo_imput_presu"];$ref_imput_presu=$_POST["txtref_imput_presu"];  $monto_credito=0;
$cod_contable=$_POST["txtcod_contable"];$referencia_comp=$_POST["txtref_comp"];
$tipo_compromiso=$_POST["txttipo_comp"];$tipo_imput_presu=substr($tipo_imput_presu,0,1);
$codigo1=$_POST["txtcodigo1"]; $monto1=formato_numero($_POST["txtmonto1"]); if(is_numeric($monto1)){$monto1=$monto1;} else{$monto1=0;}
$codigo2=$_POST["txtcodigo2"]; $monto2=formato_numero($_POST["txtmonto2"]); if(is_numeric($monto2)){$monto2=$monto2;} else{$monto2=0;}
$codigo3=$_POST["txtcodigo3"]; $monto3=formato_numero($_POST["txtmonto3"]); if(is_numeric($monto3)){$monto3=$monto3;} else{$monto3=0;}
$codigo4=""; $monto4=0; $codigo5=""; $monto5=0;
$equipo = getenv("COMPUTERNAME");$MInf_Usuario=$equipo." ".date("d/m/y H:i a");echo $fecha;
echo "ESPERE POR FAVOR ASOCIANDO CODIGO....","<br>";$url="Det_inc_cod_ord.php?codigo_mov=".$codigo_mov."&bloqueada=N";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $error=0; $tmonto=$monto1+$monto2+$monto3;
    if ($tmonto>$monto_c){$balance=$tmonto-$monto_c;}else{$balance=$monto_c-$tmonto;}
    if ($balance>0.001){$error=1; echo $tmonto.' '.$monto_c.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('TOTAL CUENTAS NO CUADRA');</script><? }
    if(($error==0)and($codigo1=="")){ $error=1; ?><script language="JavaScript">muestra('CODIGO DE CUENTA 1 NO VALIDO');</script><? }
    if($error==0){$sSQL="Select * from con001 WHERE codigo_cuenta='$codigo1'";$resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA  1 NO EXISTE');</script><? }
      else{$registro=pg_fetch_array($resultado);
        if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA 1 NO ES CARGABLE');</script><?}
      }
    }
	if(($error==0)and($codigo2=="")){ $error=1; ?><script language="JavaScript">muestra('CODIGO DE CUENTA 2 NO VALIDO');</script><?}
    if($error==0){$sSQL="Select * from con001 WHERE codigo_cuenta='$codigo2'";$resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA  2 NO EXISTE');</script><? }
      else{$registro=pg_fetch_array($resultado);
        if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA 2 NO ES CARGABLE');</script><?}
      }
    }
	if(($error==0)and($codigo3<>"")){$sSQL="Select * from con001 WHERE codigo_cuenta='$codigo3'";$resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA 3 NO EXISTE');</script><? }
      else{$registro=pg_fetch_array($resultado);
        if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA 3 NO ES CARGABLE');</script><?}
      }
    }
	if($error==0){ $sql="SELECT INCLUYE_CON022('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','','0000','$tipo_imput_presu','$ref_imput_presu','$cod_contable',$monto,'$codigo1',$monto1,'$codigo2',$monto2,'$codigo3',$monto3,'$codigo4',$monto4,'$codigo5',$monto5)";
      $resultado=pg_exec($conn,$sql);      $error=pg_errormessage($conn);  $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
      echo $sql;
    }
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }
?>
