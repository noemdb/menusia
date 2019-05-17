var TREE_NODES1={
	format:{
		left:12,
		top:65, 
		width:255,
		height:432,
		e_image:"../imagenes/e2.gif",		 
		c_image:"../imagenes/c2.gif",		 
		i_image:"../imagenes/d2.gif",
		b_image:'../imagenes/b.gif',
		img_size:[16,16],
		
		animation: false,  // nuevo true
        anim_step: 16,    // 16 nuevo 
        anim_timer: 100,  // 100 nuevo
		
		back_class:'clsLinkContainer',  // nuevo
  		div_class:'clsNodeDIV',         // nuevo
  		item_class:'clsNodeText',       // nuevo
  		link_class:'clsNodeLink',       // nuevo
  		table_class:'clsFullNode',      // nuevo
		
//		back_bgcolor:'yellow',			// nuevo
//        item_bgcolor:'pink',			// nuevo
//  		bgcolor:'silver',				// nuevo

		level_ident: 4,				// nuevo
  		y_offset: 1,					// nuevo
		
		one_branch: true,				// nuevo
		
		
//		animation:0,
		padding:1,
		dont_resize_back:2
	},
	sub:[
		{html:'Archivo', 
		sub:[
			{html:'Tipos de Cuentas', url:'Act_Tipos_Cuentas.php'},
			{html:'Definición de Bancos', url:'Act_Bancos.php'},
			{html:'Tipos de Movimientos', url:'Act_Tipo_Movimientos.php'},
			{html:'Grupo de Bancos', url:'Act_Grupo_Bancos.php'},
			{html:'Tipo Planillas de Retención', url:'Act_Tipo_Planillas.php'},
			{html:'Tipo de Enriquecimiento', url:'Act_tipo_enriquecimiento.php'},
			{html:'Beneficiarios', url:'Act_beneficiarios.php'},
			]
		},
		{html:'Procesos', 
		sub:[
			{html:'Emision Cheques', 
			sub:[
			    {html:'Cheques a Orden', url:'Emision_Cheque_orden.php?continua=N'},
			    {html:'Cheques a Beneficiario Especifico', url:'Emision_Cheque_benef.php?continua=N'},
			    {html:'Cheques Financiero', url:'Emision_Cheque_finan.php'},
//			    {html:'Cheques a Años Anteriores', url:'Emision_Cheque_ant.php'},
			    ]
		     },
		     {html:'Emisión Notas de Débito', 
			 sub:[
			     {html:'Notas Débito a Orden', url:'Emision_Ndb_orden.php?continua=N'},
			     {html:'Nota Débito Directa', url:'Emision_Ndb_directa.php'},
//			     {html:'Nota Débito Anos Anteriores', url:'Emision_Ndb_ant.php'},
			     ]
		     }, 
			 {html:'Movimientos', 
			 sub:[
			     {html:'Movimientos en Libros', url:'Act_mov_libros.php'},
			     {html:'Movimientos en Bancos', url:'Act_Mov_Banco.php'},
			     {html:'Movimientos Transito en Libros', url:'Act_Mov_Trans_Libro.php'},
			     {html:'Movimientos Transito en Bancos', url:'Act_Mov_Trans_Banco.php'},
			     ]
		     },
			{html:'Conciliación Bancaria', url:'Conciliacion_Bancaria.php'}, 
			{html:'Colocaciones Bancaria', url:'Act_Colocaciones.php'},
			{html:'Estado de Cheques', url:'Act_Edo_Cheques.php'},
			{html:'Generar Planillas de Retención', url:'Gen_planillas_ret.php'},
			{html:'Actualizar Impuesto Enterado', url:'Act_Imp_Por_Planilla.php'},
//			sub:[
//			    {html:'Por Benficiario', url:'Act_Imp_Por_Beneficiario.php'},
//			    {html:'Por Planillas', url:'Act_Imp_Por_Planilla.php'},
//			    ]
//		     },
			 {html:'Comprobante de Retención IVA', url:'Act_comp_ret_iva.php'},
			 {html:'Declaración de Retención IVA', url:'Declaracion_Ret_IVA.php'},
		    ] 
		},
		{html:'Reportes', 
		sub:[
			{html:'Impresión de Documentos', 
		    sub:[
			    {html:'Impresión de Cheques', url:'/sia/bancos/rpt/Rpt_Impresion_Cheque.php'},
			    {html:'Impresión Notas de Débitos', url:'/sia/bancos/rpt/Rpt_Impresion_Nota_Debito.php'},
			    {html:'Impresión Transferencias', url:'/sia/bancos/rpt/Rpt_Impresion_Transferencias.php'},
			    {html:'Impresión Movimientos en Libros', url:'/sia/bancos/rpt/Rpt_Impresion_Movimientos_Libros.php'},
				]
		    },
			{html:'Movimientos Libros/Bancos', 
		    sub:[
			    {html:'Movimientos en Libros', url:'/sia/bancos/rpt/Rpt_Movimientos_Libros.php'},
			    {html:'Movimientos Bancos', url:'/sia/bancos/rpt/Rpt_Movimientos_Bancos.php'},
			    ]
			},
			{html:'Resumen Movimientos Libros/Bancos', 
		    sub:[
			    {html:'Resumen Movimientos en Libros', url:'/sia/bancos/rpt/Rpt_Resumen_Movimientos_Libros.php'},
			    {html:'Resumen Movimientos en Bancos', url:'/sia/bancos/rpt/Rpt_Resumen_Movimientos_Bancos.php'},
			    ]
			},
			{html:'Movimientos en Transito Libros/Bancos', 
		    sub:[
			    {html:'Movimientos Transito en Libros', url:'/sia/bancos/rpt/Rpt_Movimientos_Transito_Libros.php'},
			    {html:'Movimientos Transito en Bancos', url:'/sia/bancos/rpt/Rpt_Movimientos_Transito_Bancos.php'},
			    ]
			},
			{html:'Resumen de Movimientos', url:'/sia/bancos/rpt/Rpt_Resumen_Movimientos.php'},
			{html:'Relación Cuentas Bancarias', url:'/sia/bancos/rpt/Rpt_Relacion_Cuentas_Bancarias.php'},
			{html:'Disponibilidad Bancaria', 
		    sub:[
			    {html:'Diaria', url:'/sia/bancos/rpt/Rpt_Disponibilidad_Bancaria_Diaria.php'},
			    {html:'Mensual', url:'/sia/bancos/rpt/Rpt_Disponibilidad_Bancaria_Mensual.php'},
			    ]
		    },
			{html:'Conciliación Bancaria', url:'/sia/bancos/rpt/Rpt_Conciliacion_Bancaria.php'},
			{html:'Movimientos no Conciliados', url:'/sia/bancos/rpt/Rpt_Movimientos_No_Conciliados.php'},
			{html:'Reportes de Cheques', 
		    sub:[
			    {html:'Cheques no Conciliados', url:'/sia/bancos/rpt/Rpt_Cheques_No_Conciliados.php'},
			    {html:'Cheques Anulados por Bancos', url:'/sia/bancos/rpt/Rpt_Cheques_Anulados.php'},
			    {html:'Cheques Caducados por Bancos', url:'/sia/bancos/rpt/Rpt_Cheques_Caducados_Por_Bancos.php'},
				{html:'Cheques por Entregar', url:'/sia/bancos/rpt/Rpt_Cheques_Por_Entregar.php'},
				{html:'Cheques Entregados', url:'/sia/bancos/rpt/Rpt_Cheques_Entregados.php'},
				{html:'Cheques Emitidos por Bancos', url:'/sia/bancos/rpt/Rpt_Cheques_Emitidos_Por_Banco.php'},
				{html:'Cheques Emitidos por Usuarios', url:'/sia/bancos/rpt/Rpt_Cheques_Emitidos_Usuario.php'},
				]
		    },
			{html:'Desglose de Cheques', 
		    sub:[
			    {html:'Ordenes de Presupuesto', url:'/sia/bancos/rpt/Rpt_Relacion_Cheque_Ord_Pago.php'},
			    {html:'Notas de Débito', url:'/sia/bancos/rpt/Rpt_Relacion_Nota_Deb_Ord_Pago.php'}
				]
		    },
			{html:'Relación por Cod. Presupuestarios', 
		    sub:[
			    {html:'Cheques/Cod. Presupuestarios', url:'/sia/bancos/rpt/Rpt_Relacion_Cheque_Ord_Pago.php'},
			    {html:'Notas de Débito/Cod. Presupuestarios', url:'/sia/bancos/rpt/Rpt_Relacion_Nota_Deb_Ord_Pago.php'}
				]
		    },
//			{html:'Flujo de Caja', 
//		    sub:[
//			    {html:'Grupo Flujos de Caja', url:'/sia/bancos/rpt/Rpt_Relacion_Cheque_Ord_Pago.php'},
//			    {html:'Movimientos Flujo De Caja', url:'/sia/bancos/rpt/Rpt_Relacion_Nota_Deb_Ord_Pago.php'},
//				{html:'Presupuesto Flujo De Caja', url:'/sia/bancos/rpt/Rpt_Presupuesto_Caja.php'},
//				]
//		    },
			{html:'Reportes de Retención', 
		    sub:[
			    {html:'Planillas de Retención', url:'/sia/bancos/rpt/Rpt_Planillas_Retencion.php'},
			    {html:'Listado Planillas de Retención', url:'/sia/bancos/rpt/Rpt_Listado_Planillas_Retencion.php'},
			    {html:'Liustado Planillas de Retención/Beneficiario', url:'/sia/bancos/rpt/Rpt_Cheques_Caducados_Por_Bancos.php'},
				{html:'Listado Impuesto Enterado', url:'/sia/bancos/rpt/Rpt_List_Impuesto_Enterado.php'},
				{html:'Comprobante Retenciones ISRL', url:'/sia/bancos/rpt/Rpt_Comprobante_Ret_ISRL.php'},
				{html:'Listado Relación Impuesto Retenido', url:'/sia/bancos/rpt/Rpt_List__Rel_Impuesto_Retenido.php'},
				{html:'Comprobante Retención IVA', url:'/sia/bancos/rpt/Rpt_Comprobante_Ret_IVA.php'},
				]
		    },
			{html:'Listado de Beneficiarios', url:'/sia/bancos/rpt/Rpt_Listado_Beneficiario.php'},
			{html:'Reportes Especiales', 
		    sub:[
			    {html:'Modalidades Financieras', url:'/sia/bancos/rpt/Rpt_Modalidades_Financieras.php'},
			    {html:'Relación Saldos Bancario', url:'/sia/bancos/rpt/Rpt_Rel_Saldo_Bancario.php'},
			    {html:'Relación de Saldo Bancario por Grupo ', url:'/sia/bancos/rpt/Rpt_Rel_Saldo_Bancario_Grupo.php'},
				{html:'Relación Movimientos', url:'/sia/bancos/rpt/Rpt_Relacion_Movimientos.php'},
				{html:'Flujo de Caja', url:'/sia/bancos/rpt/Rpt_Flujo_Caja.php'},
				{html:'Informe Diario de Egreso', url:'/sia/bancos/rpt/Rpt_Informe_Diario_Egreso.php'},
				{html:'Relación de Cheques para el Banco', url:'/sia/bancos/rpt/Rpt_Cheques_Emitidos_Para_Banco.php'},
				{html:'Ruta de Cheques', url:'/sia/bancos/rpt/Rpt_Ruta_Cheques.php'},
				{html:'Depositos Bancarios', url:'/sia/bancos/rpt/Rpt_Dep_Bancarios.php'},
				{html:'Notificación Cancelación Tributos', url:'/sia/bancos/Rpt_Notif_Cancelacion_Tributos.php'},
				]
		    },
			{html:'Reporte Definidos por el Usuario', url:'/sia/bancos/rpt/Rpt_Definido_Usuario.php'},
			]
		},
		{html:'Utilidades', 
		sub:[
			{html:'Utilidades', url:'.php'},
			{html:'Actualizar Maestro', url:"javascript:VentanaCentrada('Act_maestro.php','Actualizar Maestro','','600','260','true');"},
			{html:'Cambio de Clave', url:'#'}
			]
		},
		{html:'Ayuda', 
		sub:[
			{html:'Acerca de...', url:'#'}
			]
		},
		{html:'Salir', url:'salir.php'}
	]
}


