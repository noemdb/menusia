<?include ("../class/conect.php");  include ("../class/funciones.php");include ("Ver_dispon.php"); include ("../class/configura.inc");error_reporting(E_ALL);$formato_presup="XX-XX-XX-XXX-XX-XX-XX";
$codigo_mov=$_POST["txtcodigo_mov"];$referencia_caus=$_POST["txtreferencia_caus"];$tipo_causado=$_POST["txttipo_causado"];$referencia_comp=$_POST["txtreferencia_comp"];
$tipo_compromiso=$_POST["txttipo_compromiso"];$fecha_causado=$_POST["txtfecha"];$ced_rif=$_POST["txtced_rif"];$descripcion_caus=$_POST["txtdescripcion"];$num_proyecto="0000000000";
$caus_directo=$_POST["txtcaus_directo"];$func_inv=$_POST["txtfunc_inv"];if($func_inv==""){$func_inv="CORRIENTE";}
$func_inv=substr($func_inv,0,1);$genera_comprobante=$_POST["txtgenera_comprobante"];$genera_comprobante=substr($genera_comprobante,0,1);
$unidad_sol="";$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";if (checkData($fecha_causado)=='1'){$error=0;}
else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if ($error==0){  $sfecha=formato_aaaammdd($fecha_causado); $rfecha=$sfecha;  
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICIÒN ABIERTA');</script><?}
  if($error==0){ $l_cat=0;$sql="Select * from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat);}
  }
  if($error==0){$sSQL="Select * from pre003 WHERE tipo_causado='$tipo_causado'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE CAUSADO NO EXISTE');</script><?}
     else{if(($tipo_causado=="0000")or(substr($tipo_causado,0,1)=='A')){$error=1;?><script language="JavaScript">  muestra('DOCUMENTO DE CAUSADO NO VALIDO');</script><?}
      else{ $registro=pg_fetch_array($resultado);
        if(($caus_directo=="SI")And($registro["ref_compromiso"]=="SI")){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE CAUSADO NO VALIDO');</script><?}
        if(($caus_directo=="NO")And($registro["ref_compromiso"]=="NO")){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE CAUSADO NO VALIDO');</script><?}
      }}
  }
  if($error==0){
    if($caus_directo=="SI"){$referencia_comp=$referencia_caus;$tipo_compromiso="0000";}
     else{$sSQL="Select * from pre006 WHERE tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
       if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO NO EXISTE');</script><?}
        else{$registro=pg_fetch_array($resultado);$rfecha=$registro["fecha_compromiso"]; $ced_rif=$registro["ced_rif"];
            $func_inv=$registro["func_inv"]; if($func_inv==""){$func_inv="CORRIENTE";} $func_inv=substr($func_inv,0,1);
        }
     }
  }
  if($error==0){$sSQL="Select * from pre007 WHERE referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";
    $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE CAUSADO YA EXISTE');</script><?}
  }
  if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)or($sfecha<$rfecha)){$error=1;?><script language="JavaScript">muestra('FECHA DE CAUSADO INVALIDA');</script><?}
  }
  if($error==0){ $sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}
  }
  if($error==0){$sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup"; $res=pg_query($sql);
    $total=0; $sfecha=formato_aaaammdd($fecha_causado);
    while(($registro=pg_fetch_array($res))and($error==0)){
      $total=$total+$registro["monto"];$cod_presup=$registro["cod_presup"];$fuente_financ=$registro["fuente_financ"];
      $monto_c=$registro["monto"];$ref_imput_presu=$registro["ref_imput_presu"];$monto_credito=$registro["monto_credito"];
      $tipo_imput_presu=$registro["tipo_imput_presu"];
      $unidad_sol=substr($cod_presup,0, $l_cat);
      if($caus_directo=="SI"){ echo $fecha_causado;
        if (verifica_disponibilidad($conn,$registro["cod_presup"],$registro["fuente_financ"],$fecha_causado,$monto_c)==0){$error=0;}
         else{$error=1;?><script language="JavaScript">muestra('ERRRO EN EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
        if(($error==0)and($tipo_imput_presu=="C")){
          $sSQL="Select * from PRE010 WHERE (referencia_adicion='$ref_imput_presu') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
          $res=pg_query($sSQL);$filas=pg_num_rows($res);
          if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?> \ncon NO EXISTE EN LA EJECUCIÓN DEL CREDITO ADICIONAL');</script><? }
           else{$reg=pg_fetch_array($res);
             if($registro["disponible"]<$monto_credito) {$error=1; $dispon=$registro["disponible"]; $dispon=formato_monto($dispon); ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?> \ncon Monto Mayor que Disponibilidad del Crédito Adicional, Disponibilidad: <? echo $dispon; ?> ');</script><? }
          }
        }
      }else{$sSQL="Select * from PRE036 WHERE (ref_imput_presu='$ref_imput_presu') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
        $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
        if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL COMPROMISO EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
         else{$registro=pg_fetch_array($resultado);$compromiso=$registro["monto"]-$registro["causado"]-$registro["ajustado"]; $balance=$monto_c-$compromiso;
           if(($monto_c>$compromiso)and($balance>0.001)){$error=1; echo $monto_c.' '.$compromiso.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('MONTO A CAUSAR MAYOR AL MONTO DEL CODIGO POR COMPROMETER');</script><? }
         }
      }
    }
    if($total==0){$error=1;?><script language="JavaScript">muestra('MONTO TOTAL DEL CAUSADO INVALIDO');</script><?}
  }
  if(($error==0)and($genera_comprobante=='S')){
         $sql="SELECT * FROM CON008  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";     $res=pg_query($sql);$t_debe=0; $t_haber=0;$balance=0;
         while($registro=pg_fetch_array($res))
         { if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
           if ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
         }
		 if ($balance>0.001){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>";  ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
         if ($total>$t_debe){$balance=$total-$t_debe;}else{$balance=$t_debe-$total;}		 
         if (($t_debe==0)or($balance>0.001)){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>";  ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
      }
  if($error==0){$sfecha=formato_aaaammdd($fecha_causado);
     $sSQL="SELECT INCLUYE_PRE007('$codigo_mov','$referencia_caus','$tipo_causado','$referencia_comp','$tipo_compromiso','$sfecha','$referencia_caus','$ced_rif','P','$func_inv','$num_proyecto','$genera_comprobante','','$minf_usuario','N','$unidad_sol','D','$descripcion_caus')";
     $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn);$error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else{$error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);   if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}}
       $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Act_causados.php?Gcriterio=<? echo $tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? } ?>