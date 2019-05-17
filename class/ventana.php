<?php
function arma_patron($formato){ $valor=""; $mcontrol=array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0); $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i, 1) == "-") {$j++;} else{$mcontrol[$j]++;} }
  $valor="Array(".$mcontrol[0].",".$mcontrol[1].",".$mcontrol[2].",".$mcontrol[3].",".$mcontrol[4].",".$mcontrol[5].",".$mcontrol[6].",".$mcontrol[7].",".$mcontrol[8].",".$mcontrol[9].",".$mcontrol[10].",".$mcontrol[11].")";
return $valor;}
?>
</head>
<script language="JavaScript">
function muestra(mensaje) { alert(mensaje); }
function Ventana_001 (URL){
  window.open(URL,"CEINCO","width=500,height=300,top=20,left=40,scrollbars=NO,titlebar=NO,menubar=NO,toolbar=YES,directories=YES,location=NO,status=NO,resizable=YES")
}
function Ventana_002(theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;
    features+=(features!='')?',':'';
    features+=',left='+myLeft+',top='+myTop;
  }
  window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight+',scrollbars=YES,titlebar=NO');
}
function VentanaCentrada(theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;
    features+=(features!='')?',':'';
    features+=',left='+myLeft+',top='+myTop;
  }
  window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight+',titlebar=NO,toolbar=NO,scrollbars=YES,location=NO,directories=NO');
}
function Ventana_rpt (URL){
  window.open(URL,"CEINCO","width=500,height=300,top=20,left=40,scrollbars=YES,titlebar=YES,menubar=YES,toolbar=YES,directories=YES,location=NO,status=NO,resizable=YES")
}
function Ventana_chq (URL){
  window.open(URL,"FORMATO CHEQUE","width=800,height=600,top=20,left=40,scrollbars=YES,titlebar=NO,menubar=NO,toolbar=NO,directories=NO,location=NO,status=NO,resizable=YES")
}
function cerrar_ventana(){ window.close()}
function LlamarURL(url) { document.location = url; }
function Validar_fecha(Cadena){
        var Fecha= new String(Cadena)        // Crea un string
        var RealFecha= new Date()        // Para sacar la fecha de hoy
        // Cadena Año
        var Ano= new String(Fecha.substring(Fecha.lastIndexOf("/")+1,Fecha.length))
        // Cadena Mes
        var Mes= new String(Fecha.substring(Fecha.indexOf("/")+1,Fecha.lastIndexOf("/")))
        // Cadena Día
        var Dia= new String(Fecha.substring(0,Fecha.indexOf("/")))

        // Valido el año
        if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){
                alert('Año inválido')
                return false
        }
        // Valido el Mes
        if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){
                alert('Mes inválido')
                return false
        }
        // Valido el Dia
        if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){
                alert('Día inválido')
                return false
        }
        if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {
                if (Mes==2 && Dia > 28 || Dia>30) {
                        alert('Día inválido')
                        return false
                }
        }
   return true
}

</script>