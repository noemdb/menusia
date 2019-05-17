<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../presupuesto/Ver_dispon.php"); include ("../class/configura.inc");
$fecha=$_POST["txtFecha"]; $referencia=$_POST["txtReferencia"]; $ced_rif=$_POST["txtced_rif"];
$tipo_asiento=$_POST["txttipo_asiento"]; $codigo_mov=$_POST["txtcodigo_mov"]; $tipo_comp="00000";
$descripcion=$_POST["txtDescripcion"]; $equipo=getenv("COMPUTERNAME"); error_reporting(E_ALL);
$minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO COMPROBANTE MULTIPLE....","<br>";
if (checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('FECHA NO ES VALIDA');</script><? }
if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);} $url="Act_comprobantes.php?Gcriterio=".$fecha.$referencia.$tipo_comp;
if($tipo_asiento=='ANU'||$tipo_asiento=='ANC'||$tipo_asiento=='CHQ'||$tipo_asiento=='NDB'||$tipo_asiento=='AND'){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE ASIENTO NO VALIDO');</script><? }
if ($error==0){ $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
 if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 if($error==0){$campo502="NNNNNNNNNNNNNNNNNNNN";  
   $periodom=$SIA_Periodo; $nmes=substr($fecha,3, 2);  
   $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
   if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}} 
   if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}
   if ($error==0){
   if($tipo_asiento=='AJC'){ $ult_ref="00000001";
     $StrSQL="select max(referencia) as referencia from con002 where tipo_asiento='$tipo_asiento' and referencia<='99999999'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
     if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;}
     $referencia=$ult_ref;
   }
   $sSQL="Select * from con009 WHERE tipo_asiento='$tipo_asiento'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
   if ($filas==0){$error=1;?>  <script language="JavaScript">  muestra('TIPO DE ASIENTO NO EXISTE');  </script>  <? }
   else{ $error=0; $sSql="Select * from con002 where text(fecha)='$sfecha' and referencia='$referencia' and tipo_comp='00000'"; $resultado=pg_query($sSql);  $filas=pg_num_rows($resultado);
      if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE YA EXISTE');</script><? }	  
      if ($error==0){ $sql="SELECT * FROM CON017 where codigo_mov='$codigo_mov' order by nro_linea";
         $res=pg_query($sql);  $t_debe=0; $t_haber=0;$balance=0;
         while($registro=pg_fetch_array($res)){ if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
           if ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;} }
         if($balance>0.001){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('MOVIMIENTOS CONTABLE NO CUADRA');</script><? }
         If(($t_debe==0)or($t_haber==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE MOVIMIENTOS NO VALIDO');</script><? }
      }	  
	  
	  if ($error==0){ $sql="SELECT * FROM CON017 where codigo_mov='$codigo_mov' and modulo='E' order by nro_linea";  $res=pg_query($sql); 
         while($registro=pg_fetch_array($res)){ 
		    $cod_presup=$registro["cod_cuenta"];$fuente_financ=$registro["aoperacion"];   $monto_c=$registro["monto_asiento"]; if ($registro["debito_credito"]=="C"){$monto_c=$monto_c*-1; }
			echo $cod_presup." ".$fuente_financ." ".$fecha." ".$monto_c;
			if (verifica_disponibilidad($conn,$cod_presup,$fuente_financ,$fecha,$monto_c)==0){$error=0;}
               else{$error=1;?><script language="JavaScript">muestra('ERRRO EN EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> ');</script><?}
        
		 }
      }
	  if ($error==0){ $sql="SELECT * FROM CON010 where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";
         $res=pg_query($sql);  $t_mov=$t_debe; $t_debe=0; $t_haber=0;$balance=0;
         while($registro=pg_fetch_array($res)) { if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
           if ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}  }
         if($balance>0.001){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
         if(($t_debe==0)or($t_haber==0)){$error=1; echo $t_debe.' '.$t_haber; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
         $balance=$t_mov-$t_debe;		 
		 if($balance>0.001){$error=1; echo $t_debe.' '.$t_mov.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA CON TOTAL MOVIMIENTOS');</script><? }
	  }
	  if($error==0){ $sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
         if ($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}
      }
	  if($error==0){$nmes=substr($fecha,3, 2);  if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}
      if($error==0){ 
        if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE MOVIMIENTO INVALIDA');</script><?}
      } 
	  if ($error==0){ $sSQL="SELECT MULTIPLE_CON002('$codigo_mov','$referencia','$sfecha','$tipo_comp','$tipo_asiento','A','M','S','01','0','00000000','$ced_rif','','$usuario_sia','$minf_usuario','$descripcion')"; echo $sSQL;
	    $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error, 0, 80);
         if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
          else{ $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error,0,91);
           if (!$resultado){?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? } }
      }
    } }
 } 
} pg_close();  error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location='<? echo $url; ?>'; </script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }
?>