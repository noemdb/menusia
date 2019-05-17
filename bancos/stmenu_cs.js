/*
   Deluxe Menu Data File
   Created by Deluxe Tuner v3.2
   http://deluxe-menu.com
*/


// -- Deluxe Tuner Style Names
var tstylesNames=["Top Item",];
var tXPStylesNames=[];
// -- End of Deluxe Tuner Style Names

//--- Common
var tlevelDX=20;
var texpanded=0;
var texpandItemClick=0;
var tcloseExpanded=0;
var tcloseExpandedXP=0;
var ttoggleMode=1;
var tnoWrap=1;
var titemTarget="_self";
var titemCursor="pointer";
var statusString="link";
var tblankImage="../imagenes/blank.gif";
var tpathPrefix_img="";
var tpathPrefix_link="";

//--- Dimensions
var tmenuWidth="250px";
var tmenuHeight="auto";

//--- Positioning
var tabsolute=1;
var tleft="15px";
var ttop="60px";

//--- Font
var tfontStyle="normal 10pt Arial";
var tfontColor=["#3F3D3D","#7E7C7C"]; tfontColor=["#000066","#0033FF"];
var tfontDecoration=["none","underline"];
var tfontColorDisabled="#ACACAC";
var tpressedFontColor="#AA0000";

//--- Appearance
var tmenuBackColor="#E0E0E0";  tmenuBackColor="#FFFFFF";
var tmenuBackImage="back1.gif";
var tmenuBorderColor="#FFFFFF";
var tmenuBorderWidth=2;
var tmenuBorderStyle="solid";

//--- Item Appearance
var titemAlign="left";
var titemHeight=26;
var titemBackColor=["",""];
var titemBackImage=["../imagenes/blank.gif","../imagenes/blank.gif"];

//--- Icons & Buttons
var ticonWidth=21;
var ticonHeight=15;
var ticonAlign="left";
var texpandBtn=["../imagenes/expandbtn2.gif","../imagenes/expandbtn2.gif","../imagenes/collapsebtn2.gif"];
var texpandBtnW=15;
var texpandBtnH=15;
var texpandBtnAlign="left";

//--- Lines
var tpoints=1;
var tpointsImage="../imagenes/hpoint.gif";
var tpointsVImage="../imagenes/vpoint.gif";
var tpointsCImage="../imagenes/cpoint.gif";
var tpointsBImage="../imagenes/bpoint.gif";

//--- Floatable Menu
var tfloatable=1;
var tfloatIterations=10;
var tfloatableX=1;
var tfloatableY=1;

//--- Movable Menu
var tmoveable=0;
var tmoveHeight=12;
var tmoveColor="#AA0000";
var tmoveImage="";

//--- XP-Style
var tXPStyle=0;
var tXPIterations=10;
var tXPBorderWidth=1;
var tXPBorderColor="#FFFFFF";
var tXPAlign="left";
var tXPTitleBackColor="#AFB1C3";
var tXPTitleBackImg="../imagenes/xptitle_s.gif";
var tXPTitleLeft="../imagenes/xptitleleft_s.gif";
var tXPTitleLeftWidth=4;
var tXPIconWidth=31;
var tXPIconHeight=32;
var tXPMenuSpace=10;
var tXPExpandBtn=["../imagenes/xpexpand1_s.gif","../imagenes/xpexpand1_s.gif","../imagenes/xpcollapse1_s.gif","../imagenes/xpcollapse1_s.gif"];
var tXPBtnWidth=25;
var tXPBtnHeight=23;
var tXPFilter=1;

//--- Advanced
var tdynamic=0;
var tajax=0;

//--- State Saving
var tsaveState=0;
var tsavePrefix="menu1";

var tstyles=[
    ["tfontDecoration=none,none"],
];
var tXPStyles=[];

var mnombmenu1="Emision_Ndb_ord_nomina.php?continua=N";
if(mcod_emp=="58"){mnombmenu1="Emision_Ndb_ord_nomina_gby.php?continua=N";}

var mnombmenu2="Emision_Cheque_orden_nom.php?continua=N";
if(mcod_emp=="58"){mnombmenu2="Emision_Cheque_orden_nom_gby.php?continua=N";}

var tmenuItems=[
    ["Archivo","", "", "", "", "Menu Archivos", "", "0", "", "", ],
        ["|Tipos de Cuentas","Act_Tipos_Cuentas.php", "", "", "", "", "", "", "", "", ],
		["|Definicion de Bancos","Act_bancos.php", "", "", "", "", "", "", "", "", ],
		["|Tipos de Movimientos","Act_Tipo_Movimientos.php", "", "", "", "", "", "", "", "", ],
		["|Grupo de Bancos","Act_Grupo_Bancos.php", "", "", "", "", "", "", "", "", ],
		["|Tipo Planillas de Retencion","Act_Tipo_Planillas.php", "", "", "", "", "", "", "", "", ],
		["|Tipo de Enriquecimiento","Act_Tipo_Enriquecimiento.php", "", "", "", "", "", "", "", "", ],
		["|Beneficiarios","Act_beneficiarios.php", "", "", "", "", "", "", "", "", ],
    ["Procesos","", "", "", "", "Menu Procesos", "", "0", "", "", ],        
  		["|Emision Cheques","", "", "", "", "", "", "0", "", "", ],
            ["||Cheques a Orden","Emision_Cheque_orden.php?continua=N", "", "", "", "", "", "", "", "", ],
			["||Cheques a Beneficiario Especifico","Emision_Cheque_benef.php?continua=N", "", "", "", "", "", "", "", "", ],
			["||Cheques Financiero","Emision_Cheque_finan.php", "", "", "", "", "", "", "", "", ],
			["||Cheques a Orden Nomina",mnombmenu2, "", "", "", "", "", "", "", "", ],
			//["||Cheques Abono a Orden","Emision_Cheque_abono_orden.php?continua=N", "", "", "", "", "", "", "", "", ],
			["||Cheques a Orden Periodos Anteriores","Emision_Cheque_orden_ant.php?continua=N", "", "", "", "", "", "", "", "", ],
		["|Notas de Debito","", "", "", "", "", "", "0", "", "", ],
            ["||Notas Debito a Orden","Emision_Ndb_orden.php?continua=N", "", "", "", "", "", "", "", "", ],
			["||Notas Debito Directa","Emision_Ndb_directa.php", "", "", "", "", "", "", "", "", ],
			["||Notas Debito Orden Nomina",mnombmenu1, "", "", "", "", "", "", "", "", ],
			["||Cancelacion Ordenes de Pago","Cancelacion_Orden_Pago.php", "", "", "", "", "", "", "", "", ],
			["||Notas Debito a Orden Periodos Anteriores","Emision_Ndb_orden_ant.php?continua=N", "", "", "", "", "", "", "", "", ],
		["|Movimientos","", "", "", "", "", "", "0", "", "", ],
            ["||Movimientos en Libros","Act_Mov_Libros.php", "", "", "", "", "", "", "", "", ],
			["||Movimientos en Bancos","Act_Mov_Banco.php", "", "", "", "", "", "", "", "", ],
			["||Movimientos Transito en Libros","Act_Mov_Trans_Libro.php", "", "", "", "", "", "", "", "", ],
			["||Movimientos Transito en Bancos","Act_Mov_Trans_Banco.php", "", "", "", "", "", "", "", "", ],
		["|Conciliacion Bancaria","Conciliacion_bancaria.php", "", "", "", "", "", "", "", "", ],
		//	["|Colocaciones Bancaria","Act_Colocaciones.php", "", "", "", "", "", "", "", "", ],
		["|Estado de Cheques","Act_Edo_Cheques.php", "", "", "", "", "", "", "", "", ],
		["|Generar Planillas de Retencion","Gen_planillas_ret.php", "", "", "", "", "", "", "", "", ],
		["|Planillas de Retencion Manual","Act_planillas_ret.php", "", "", "", "", "", "", "", "", ],
		["|Actualizar Impuesto Enterado","Act_Imp_Por_Planilla.php", "", "", "", "", "", "", "", "", ],
		["|Comprobante de Retencion IVA","Act_comp_ret_iva.php", "", "", "", "", "", "", "", "", ],
		["|Declaracion de Retencion IVA","Declaracion_Ret_IVA.php", "", "", "", "", "", "", "", "", ],
		["|Declaracion de Retencion ISLR","Declaracion_Ret_islr.php", "", "", "", "", "", "", "", "", ],
		["|Declaracion de Retencion 1*1000","Declaracion_Ret_otros.php", "", "", "", "", "", "", "", "", ],
	["Reportes","", "", "", "", "Menu Reportes", "", "0", "", "", ],
        ["|Movimientos","", "", "", "", "", "", "0", "", "", ],
            ["||Movimientos en Libros","../bancos/rpt/Rpt_Movimientos_Libros.php", "", "", "", "", "", "", "", "", ],
			["||Movimientos Bancos","../bancos/rpt/Rpt_Movimientos_Bancos.php", "", "", "", "", "", "", "", "", ],
		    ["||Resumen Movimientos en Libros","../bancos/rpt/Rpt_Resumen_Movimientos_Libros.php", "", "", "", "", "", "", "", "", ],
		   //["||Resumen Movimientos en Bancos","../bancos/rpt/Rpt_Resumen_Movimientos_Bancos.php", "", "", "", "", "", "", "", "", ],
		    ["||Movimientos Transito en Libros","../bancos/rpt/Rpt_Movimientos_Transito_Libros.php", "", "", "", "", "", "", "", "", ],
			["||Movimientos Transito en Bancos","../bancos/rpt/Rpt_Movimientos_Transito_Bancos.php", "", "", "", "", "", "", "", "", ],			
		   // ["||Resumen de Movimientos","../bancos/rpt/Rpt_Resumen_Movimientos.php", "", "", "", "", "", "", "", "", ],
		["|Relacion Cuentas Bancarias","../bancos/rpt/Rpt_Relacion_Cuentas_Bancarias.php", "", "", "", "", "", "", "", "", ],
		["|Disponibilidad Bancaria","", "", "", "", "", "", "0", "", "", ],
            ["||Diaria","../bancos/rpt/Rpt_Disponibilidad_Bancaria_Diaria.php", "", "", "", "", "", "", "", "", ],
			["||Mensual","../bancos/rpt/Rpt_Disponibilidad_Bancaria_Mensual.php", "", "", "", "", "", "", "", "", ],	
		["|Conciliacion Bancaria","../bancos/rpt/Rpt_Conciliacion_Bancaria.php", "", "", "", "", "", "", "", "", ],
		["|Movimientos no Conciliados","../bancos/rpt/Rpt_Movimientos_No_Conciliados.php", "", "", "", "", "", "", "", "", ],
		["|Reportes de Cheques","", "", "", "", "", "", "0", "", "", ],
		    ["||Cheques Emitidos por Bancos","../bancos/rpt/Rpt_Cheques_Emitidos_Por_Banco.php", "", "", "", "", "", "", "", "", ],
        	["||Cheques Anulados por Bancos","../bancos/rpt/Rpt_Cheques_Anulados.php", "", "", "", "", "", "", "", "", ],
			["||Cheques por Entregar","../bancos/rpt/Rpt_Cheques_Por_Entregar.php", "", "", "", "", "", "", "", "", ],			
			["||Cheques Entregados","../bancos/rpt/Rpt_Cheques_Entregados.php", "", "", "", "", "", "", "", "", ],
			["||Cheques Retenciones","../bancos/rpt/Rpt_Cheques_Retenciones.php", "", "", "", "", "", "", "", "", ],
		    ["||Cheques Caducados por Bancos","../bancos/rpt/Rpt_Cheques_Caducados_Por_Bancos.php", "", "", "", "", "", "", "", "", ],
	       ["||Cheques no Conciliados","../bancos/rpt/Rpt_Cheques_No_Conciliados.php", "", "", "", "", "", "", "", "", ],
		["|Ordenes de Pago por Pagar","../bancos/rpt/Rpt_Ordenes_Pago_Por_Pagar.php", "", "", "", "", "", "", "", "", ],
        ["|Ordenes de Pago por Beneficiario","../bancos/rpt/Rpt_Ordenes_Pago_Beneficiario.php", "", "", "", "", "", "", "", "", ], 		
        ["|Relacion Cheques/Notas","", "", "", "", "", "", "0", "", "", ],
            ["||Cheques/Ordenes de Pago","../bancos/rpt/Rpt_Relacion_Cheque_Ord_Pago.php", "", "", "", "", "", "", "", "", ],
			["||Notas Debito/Ordenes de Pago","../bancos/rpt/Rpt_Relacion_Nota_Deb_Ord_Pago.php", "", "", "", "", "", "", "", "", ],
		    ["||Cheques/Cod. Presupuestario","../bancos/rpt/Rpt_Relacion_Cheque_Cod_Presup.php", "", "", "", "", "", "", "", "", ],
			["||Notas Debito/Cod. Presupuestario","../bancos/rpt/Rpt_Relacion_Nota_Deb_Cod_Presup.php", "", "", "", "", "", "", "", "", ],
		["|Reportes de Retencion","", "", "", "", "", "", "0", "", "", ],
           ["||Listado Planillas de Retencion","../bancos/rpt/Rpt_Listado_Planillas_Retencion.php", "", "", "", "", "", "", "", "", ],	
            ["||Listado Planillas de Retencion/Beneficiario","../bancos/rpt/Rpt_Listado_Retencion_Beneficiario.php", "", "", "", "", "", "", "", "", ],
			["||Listado Impuesto Enterado","../bancos/rpt/Rpt_List_Impuesto_Enterado.php", "", "", "", "", "", "", "", "", ],
            ["||Comprobante Retenciones ISRL","../bancos/rpt/Rpt_Comprobante_Ret_ISRL.php", "", "", "", "", "", "", "", "", ],
			["||Listado de Retencion 1_1000","../bancos/rpt/Rpt_List_Rel_Impuesto_Retenido.php", "", "", "", "", "", "", "", "", ],
			["||Listado de Retencion de IVA","../bancos/rpt/Rpt_Listado_Ret_IVA.php", "", "", "", "", "", "", "", "", ],
            ["||Listado de Retencion de IVA por Beneficiario","../bancos/rpt/Rpt_Listado_Ret_IVA_Beneficiario.php", "", "", "", "", "", "", "", "", ],
		["|Reportes Especiales","", "", "", "", "", "", "0", "", "", ],
		      ["||Relacion Cancelaciones por Beneficiario","../bancos/rpt/Rpt_Relacion_Canc_Beneficiario.php", "", "", "", "", "", "", "", "", ],
			  ["||Listado de Beneficiarios","../bancos/rpt/Rpt_Listado_Beneficiario.php", "", "", "", "", "", "", "", "", ],
            ["||Relacion Saldos Bancario","../bancos/rpt/Rpt_Rel_Saldo_Bancario.php", "", "", "", "", "", "", "", "", ],
//			["||Relacion de Saldo Bancario por Grupo","../bancos/rpt/Rpt_Rel_Saldo_Bancario_Grupo.php", "", "", "", "", "", "", "", "", ],	
             ["||Relacion Movimientos","../bancos/rpt/Rpt_Relacion_Movimientos.php", "", "", "", "", "", "", "", "", ],
//			["||Flujo de Caja","../bancos/rpt/Rpt_Flujo_Caja.php", "", "", "", "", "", "", "", "", ],
//            ["||Informe Diario de Egreso","../bancos/rpt/Rpt_Informe_Diario_Egreso.php", "", "", "", "", "", "", "", "", ],
			["||Relacion de Cheques para el Banco","../bancos/rpt/Rpt_Cheques_Emitidos_Para_Banco.php", "", "", "", "", "", "", "", "", ],
//            ["||Ruta de Cheques","../bancos/rpt/Rpt_Ruta_Cheques.php", "", "", "", "", "", "", "", "", ],
			["||Depositos Bancarios","../bancos/rpt/Rpt_Dep_Bancarios.php", "", "", "", "", "", "", "", "", ],
//            ["||Notificacion Cancelacion Tributos","../bancos/rpt/Rpt_Notif_Cancelacion_Tributos.php", "", "", "", "", "", "", "", "", ],
//			["||Relacion Gastos Presupuestarios","../bancos/rpt/Rpt_Relacion_Gastos_Presupuestarios.php", "", "", "", "", "", "", "", "", ],
    ["Utilidades","", "", "", "", "Menu Utilidades", "", "0", "", "", ],
         ["|Auditoria","Auditoria_bancos.php", "", "", "", "", "", "", "", "", ],
         ["|Actualizar Maestro","javascript:VentanaCentrada('Act_maestro.php','Actualizar Maestro','','600','260','true');", "", "", "", "", "", "", "", "", ],	
         ["|Cambio de Clave","Cambio_clave.php", "", "", "", "", "", "", "", "", ], 
		 ["|Periodo Trabajo Bancos","Cierre_bancos.php", "", "", "", "", "", "", "", "", ],	
    ["Salir","salir.php", "", "", "", "", "", "", "", "", ],
];dtree_init();
