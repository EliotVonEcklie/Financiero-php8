var app = new Vue({ 
	el: '#myapp',
	data:
	{
		idproyecto:'',
		valida_proyecto:'NO',
		valida_presupuesto:'NO',
		valida_fuentes:'NO',
		preguntasn:'',
		//INICIO MODALES
		showMensaje: false,
		showMensajeSN: false,
		showModal: false,
		showModal2: false,
		showModal3: false,
		showModal4: false,
		showModal5: false,
		showModal6: false,
		showModal7: false,
		showModal8: false,
		showModal9: false,
		showModal10: false,
		showModal11: false,
		showModal12: false,
		showModalUnidadEj: false,
		showopcion1:false,
		showopcion2:false,
		showopcion2_3:false,
		titulomensaje:'',
		contenidomensaje:'',
		colortitulosmensaje:'',
		//BUSCADORES
		search: {keyword: ''},
		searchProgram: {keywordProgram: ''},
		searchProduct: {keywordProduct: ''},
		searchCuentaPresupuestal: {keywordCuentaPresupuestal: ''},
		searchfuentes:{keyword: ''},
		searchsubproductos:{keywordsubproductos: ''},
		searchsubclase:{keywordsubclase:''},
		//MODULO PROYECTO
		unidadejecutoradobleclick: 'colordobleclik',
		sectordobleclick:'colordobleclik',
		programadobleclick:'colordobleclik',
		indicadordobleclick:'colordobleclik',
		fuentedobleclick:'colordobleclik',
		secciondobleclick:'colordobleclik',
		divisiondobleclick:'colordobleclik',
		grupodobleclick:'colordobleclik',
		clasedobleclick:'colordobleclik',
		subclasedobleclick:'colordobleclik',
		subproductodobleclick:'colordobleclik',
		parpadeomediopago:'',
		parpadeovalorrubro:'',
		codigo:'',
		vigencia: new Date().getFullYear(),
		nombre:'',
		valorproyecto:'0',
		descripcion:'',
		unidadejecutora: '',
		cunidadejecutora: '',
		sector:'',
		csector:'',
		programa:'',
		cprograma:'',
		subprograma:'',
		csubprograma:'',
		producto:'',
		cproducto:'',
		indicadorpro:'',
		cindicadorpro:'',
		sectores: [],
		unidadesejecutoras: [],
		sector_p: '',
		programas:[],
		programa_P:'',
		productos:[],
		programas_subprogramas: [],
		sombra: '',
		selecproductosa:[],
		selecproductosb:[],
		vcproducto:'',
		years:[],
		//MODULO PRESUPUESTO
		mediopago:'',
		codrubro:'',
		nrubro:'',
		nombre_r: '',
		valorrubro:'',
		cuentapre:'',
		cuentaspres:[],
		cpadre_p:'',
		selectcuetasa:[],
		selectcuetasb:[],
		selectcuetasc:[],
		selectcuetasd:[],
		selectcuetase:[],
		selectcuetasf:[],
		selectbuscar:[],
		selectbuscar1:[],
		selectbuscar2:[],
		vccuenta:'',
		secciones:[],
		seccion:'',
		seccion_p:'',
		cseccion:'',
		clasificador:'',
		cclasifica:'',
		cclasificados:[],
		clasificadorescuentas: [],
		cdivision:'',
		division:'',
		division_p:'',
		divisiones:[],
		grupo:'',
		cgrupo:'',
		grupo_p:'',
		grupos:[],
		clase:'',
		cclase:'',
		clase_p:'',
		clases:[],
		subclase:'',
		csubclase:'',
		subclase_p:'',
		subClases:[],
		subproducto:'',
		csubproducto:'',
		subproductos:[],
		identidad:'',
		nitentidad:'',
		nomentidad:'',
		validacuin: false,
		validaclaservi: false,
		validaclabienes: false,
		codigocuin:'',
		codigoscuin:[],
		clacuin:'',
		vcodigocuin:'',
		valorcuin:'',
		valorsinclasifi: '',
		deshabilitar_seccion: false,
		//MODULO FUENTES PROYECTO
		cfuentef:'',
		fuentef:'',
		results:[],
		vfuente:'',
		opcionmensaje:'',
		tb1:1,
		tb2:2,
		tb3:3,
		tabgroup2:1,
		tapheight1:'79%',
		tapheight2:'79%',
		tapheight3:'79%',
	},
	mounted: 
	function()
	{
		this.fetchMembers();
		this.fetchMembersUnidadEj();
		this.cargayears();
	},
	computed:
	{
		/*years22()
		{
			const year = new Date().getFullYear() + 50
			return Array.from({length: year - 1980}, (value, index) => 1951 + index)
		}*/
	},
	methods:
	{
		cargayears: async function()
		{
			await axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=years')
			.then(
				(response)=>
				{
					app.years=response.data.anio;
				}
			);
		},
		validaValor: function(valor)
		{
			var regural = '^[0-9]+([,][0-9]+)?$';
			var OK = regural.exec(valor);
			if (!OK) {
			  console.error(phoneInput.value + ' isn\'t a phone number with area code!'); 
			} else {
			  console.log('Gracias, tu número de teléfono es ' + OK[0]);}
		},
		toggleMensajeSN:function(preg,resp)
		{
			this.showMensajeSN = !this.showMensajeSN;
			if(this.showMensajeSN==false)
			{
				switch (preg)
				{
					case '1': 
						if(resp=='S'){this.guardarglobal();}
						break;
				}
			}
		},
		toggleMensaje: function()
		{
			this.showMensaje = !this.showMensaje;
			if(this.opcionmensaje!='' && this.showMensaje== false)
			{
				switch (this.opcionmensaje)
				{
					case '1': 
						this.opcionmensaje='';
						this.$refs.codigo.focus();
						break;
					case'2':
						this.opcionmensaje='';
						this.$refs.nombre.focus();
						break;
					case'3':
						this.opcionmensaje='';
						this.$refs.descripcion.focus();
						break;
					case '4':
						this.opcionmensaje='';
						this.$refs.valorrubro.focus();
						break;
					case '5':
						this.opcionmensaje='';
						this.$refs.fuentef.focus();
						break;
				}
			}
		},
		toggleModalUnidadEje: function()
		{
			if(this.selecproductosa.length==0)
			{
				this.sectordobleclick='colordobleclik',
				this.showModalUnidadEj = !this.showModalUnidadEj;
			}
		},
		toggleModal: function()
		{
			if(this.selecproductosa.length==0)
			{
				this.sectordobleclick='colordobleclik',
				this.showModal = !this.showModal;
			}
			else 
			{
				this.toggleMensaje();
				this.colortitulosmensaje='crimson';
				this.titulomensaje='Mensaje de Error';
				this.contenidomensaje='Ya se ingresaron productos no se puede cambiar el sector';
			}
		},
		toggleModal2: function()
		{
			if(this.selecproductosa.length==0)
			{
				this.programadobleclick='colordobleclik';
				if(this.csector!='')
				{
					
					this.showModal2 = !this.showModal2;
					if(this.showModal2== true)
					{this.programasp(this.csector);}
				}
				else
				{
					this.toggleMensaje();
					this.colortitulosmensaje='crimson';
					this.titulomensaje='Mensaje de Error';
					this.contenidomensaje='Se debe ingresar primero un sector';
					this.sectordobleclick='parpadea colordobleclik';
				}
			}
			else
			{
				this.toggleMensaje();
				this.colortitulosmensaje='crimson';
				this.titulomensaje='Mensaje de Error';
				this.contenidomensaje='Ya se ingresaron productos no se puede cambiar el Programa';
			}
		},
		toggleModal3: function()
		{
			if(this.cprograma!='')
			{
				this.showModal3 = !this.showModal3;
				if(this.showModal3== true)
				{this.buscarProductos(this.cprograma);}
			}
			else
				{
					this.toggleMensaje();
					this.colortitulosmensaje='crimson';
					this.titulomensaje='Mensaje de Error';
					this.contenidomensaje='Se debe ingresar primero un programa';
					this.programadobleclick='parpadea colordobleclik';
				}
		},
		toggleModal4: function()
		{
			this.showModal4 = !this.showModal4;
			if(this.showModal4== true)
			{
				this.buscarcuentas('2.3');
				this.showopcion1=false;
				this.showopcion2=false;
				this.showopcion2_3=false;
				this.clasificador='';
			}
		},
		toggleModal5: function()
		{
			this.secciondobleclick='colordobleclik';
			if(this.deshabilitar_seccion == false)
			{
				this.showModal5 = !this.showModal5;
				if(this.showModal5== true)
				{this.buscarsectores();}
			}
		},
		toggleModal6: function()
		{
			this.divisiondobleclick='colordobleclik';
			if(this.cseccion!='')
			{
				this.showModal6 = !this.showModal6;
				if(this.showModal6== true)
				{this.buscardivisiones();}
			}
			else
			{
				this.secciondobleclick='parpadea colordobleclik';
				this.toggleMensaje();
				this.colortitulosmensaje='crimson';
				this.titulomensaje='Mensaje de Error';
				this.contenidomensaje='Se debe seleccionar primero una Secci\xf3n';
			}
		},
		toggleModal7: function()
		{
			this.grupodobleclick='colordobleclik';
			if(this.cdivision!='')
			{
				this.showModal7 = !this.showModal7;
				if(this.showModal7== true)
				{this.buscargrupos();}
			}
			else
			{
				this.divisiondobleclick='parpadea colordobleclik';
				this.toggleMensaje();
				this.colortitulosmensaje='crimson';
				this.titulomensaje='Mensaje de Error';
				this.contenidomensaje='Se debe seleccionar primero una Divisi\xf3n';
			}
		},
		toggleModal8: function()
		{
			this.clasedobleclick='colordobleclik';
			if(this.cgrupo!='')
			{
				this.showModal8 = !this.showModal8;
				if(this.showModal8== true)
				{this.buscarclases();}
			}
			else
			{
				this.grupodobleclick='parpadea colordobleclik';
				this.toggleMensaje();
				this.colortitulosmensaje='crimson';
				this.titulomensaje='Mensaje de Error';
				this.contenidomensaje='Se debe seleccionar primero un Grupo';
			}
		},
		toggleModal9: function()
		{
			this.subclasedobleclick='colordobleclik';
			this.showModal9 = !this.showModal9;
			if(this.showModal9== true)
			{this.buscarsubclases();}
		},
		toggleModal10: function()
		{
			this.fuentedobleclick='colordobleclik';
			this.showModal10 = !this.showModal10;
			if(this.showModal10== true)
			{this.buscarfuentes()}
		},
		toggleModal11: function()
		{
			this.showModal11 = !this.showModal11;
			if(this.showModal11== true)
			{this.buscarcodigocuin()}
		},
		toggleModal12: function()
		{
			this.showModal12 = !this.showModal12;
			if(this.showModal12== true)
			{this.buscarsubproductos()}
		},
		fetchMembers: async function()
		{
			await axios.post('vue/ccp-producto.php')
			.then(
				(response)=>
				{
					this.sectores = response.data.codigos;
				}
			);
		},
		fetchMembersUnidadEj: async function()
		{
			await axios.post('vue/ccp-producto.php?action=unidadejecutora')
			.then(
				(response)=>
				{
					this.unidadesejecutoras = response.data.unidadesejecutoras;
					this.unidadejecutora = app.unidadesejecutoras[0][0] + " - " + app.unidadesejecutoras[0][1];
					this.cunidadejecutora = app.unidadesejecutoras[0][0];
				}
			);
		},
		programasp: function(sector)
		{
			app.searchProgram = {keywordProgram: ''};
			app.programas_subprogramas = [];
			app.productos = [];
			this.programa_p = '';
			app.mostrarProductos = false;
			this.sector_p = sector;
			axios.post('vue/ccp-producto.php?sector='+this.sector_p)
			.then(function(response)
			{
				app.programas_subprogramas = response.data.programas;
			});
			
		},
		buscarProductos: function(programa)
		{
			app.searchProduct = {keywordProduct: ''};
			app.productos = [];
			this.programa_p = programa;
			axios.post('vue/ccp-producto.php?programa='+this.programa_p)
			.then(function(response)
			{
				app.productos = response.data.productos;
			});
		},
		buscarcuentas: function(cpadre)
		{
			app.cuentaspres = [];
			this.cpadre_p = cpadre;
			axios.post('vue/presupuesto_ccp/cuentasccpet.php?padre='+this.cpadre_p)
			.then(function(response)
			{
				app.cuentaspres = response.data.cuentaspresu;
			});
		},
		buscarclasificador: async function()
		{
			await axios.post('vue/presupuesto_ccp/cuentasccpet.php?action=buscaclasificador&cuenta='+this.codrubro)
			.then((response)=>
			{
				this.cclasificados = response.data.cuentaclasifi;
				if(this.cclasificados == '')
				{
					this.tabgroup2=1;
					this.tapheight1='69.5%';
					this.tapheight2='69.5%';
					this.tapheight3='69.5%';
					this.showopcion1=false;
					this.showopcion2=true;
					this.showopcion2_3=false;
				}
				else
				{
					this.deshacer('12');
				}
			});
		},
		buscarclasificadores: async function()
		{
			app.validaclabienes = false;
			app.validaclaservi = false;
			await axios.post('vue/presupuesto_ccp/cuentasccpet.php?action=buscaclasificadores')
			.then(function(response){
				app.cuentaspres = response.data.clasificadores;
				for( i = 0; i < app.cuentaspres.length; i++ ){

					if(app.cuentaspres[i] == '1')
					{
						app.validacuin = true;
					}

					if((app.selectcuetasa.length > 0 && app.cuentaspres[i] == '2') || (app.selectcuetasa.length > 0 && app.cuentaspres[i] == '3'))
					{	
						for( x = 0; x < app.selectcuetasa.length; x++ )
						{	
							console.log("Entro en seundo for" + app.selectcuetasa[x][0])
							if(app.selectcuetasa[x][0] == '2')
							{
								console.log("Si hay datos de clasificador 2 - Clasificador bienes transportables Sec. 0 - 4");
								app.validaclabienes = true;
								continue;
							}
							if(app.selectcuetasa[x][0] == '3')
							{
								console.log("Si hay datos de clasificador 3 - Clasificador servicios Sec. 5 - 9");
								app.validaclaservi = true;
								continue;
							}
						}
					}
					else
					{
						console.log("selectcuetasa no tiene datos o no hay clasificador 2 ni 3 en las cuentas de inversión");
					}

				}
			});
		},
		buscarcodigocuin:function()
		{
			axios.post('vue/ccp-cuin.php')
			.then(function(response)
			{
				app.codigoscuin = response.data.codigos;
			});
		},
		buscarsectores: function()
		{
			switch (this.clasificador)
			{
				case '': 
					this.codrubro='Rubro Sin Clasificar';
					break;
				case '2':
					axios.post('vue/ccp-bienestransportables.php')
					.then(function(response)
					{
						app.secciones = response.data.secciones;
					});
					break;
				case '3':
					axios.post('vue/ccp-servicios.php')
					.then(function(response){
						app.secciones = response.data.secciones;
					});
					break;
				default:
					this.codrubro='Rubro con clasificacion fuera de rango';
					break;
			}
		},
		buscardivisiones: function()
		{
			
			switch (this.clasificador)
			{
				case '': 
					this.codrubro='Rubro Sin Clasificar';
					break;
				case '2':
					this.seccion_p = this.cseccion;
					axios.post('vue/ccp-bienestransportables.php?seccion='+this.seccion_p)
					.then(function(response)
					{
						app.divisiones = response.data.divisiones;
					});
					break;
				case '3':
					this.seccion_p = this.cseccion;
					axios.post('vue/ccp-servicios.php?seccion='+this.seccion_p)
					.then(function(response)
					{
						app.divisiones = response.data.divisiones;
					});
					break;
				default:
					this.codrubro='Rubro con clasificacion fuera de rango';
					break;
			}
		},
		buscargrupos: function()
		{
			switch (this.clasificador)
			{
				case '': 
					this.codrubro='Rubro Sin Clasificar';
					break;
				case '2':
					this.division_p = this.cdivision;
					axios.post('vue/ccp-bienestransportables.php?division='+this.division_p)
					.then(function(response)
					{
						app.grupos = response.data.grupos;
					});
					break;
				case '3':
					this.division_p = this.cdivision;
					axios.post('vue/ccp-servicios.php?division='+this.division_p)
					.then(function(response)
					{
						app.grupos = response.data.grupos;
					});
					break;
				default:
					this.codrubro='Rubro con clasificacion fuera de rango';
					break;
			}
		},
		buscarclases: function()
		{
			switch (this.clasificador)
			{
				case '': 
					this.codrubro='Rubro Sin Clasificar';
					break;
				case '2':
					this.grupo_p = this.cgrupo;
					axios.post('vue/ccp-bienestransportables.php?grupo='+this.grupo_p)
					.then(function(response)
					{
						app.clases = response.data.clases;
					});
					break;
				case '3':
					this.grupo_p = this.cgrupo;
					axios.post('vue/ccp-servicios.php?grupo='+this.grupo_p)
					.then(function(response)
					{
						app.clases = response.data.clases;
					});
					break;
				default:
					this.codrubro='Rubro con clasificacion fuera de rango';
					break;
			}
		},
		buscarsubclases: function()
		{
			switch (this.clasificador)
			{
				case '': 
					this.codrubro='Rubro Sin Clasificar';
					break;
				case '2':
				{
					var codbuscador='';
					var nivbuscador='';
					if (this.cclase!='')
					{
						codbuscador=this.cclase;
						nivbuscador='4';
					}
					else if (this.cgrupo!='')
					{
						codbuscador=this.cgrupo;
						nivbuscador='3';
					}
					else if (this.cdivision!='')
					{
						codbuscador=this.cdivision;
						nivbuscador='2';
					}
					else if (this.cseccion!='')
					{
						codbuscador=this.cseccion;
						nivbuscador='1';
					}
					var keywordsubclase = this.toFormData(this.searchsubclase);
					axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=subclaseb&seccion='+codbuscador + '&nivel='+nivbuscador,keywordsubclase)
					.then(function(response)
					{
						app.subClases = response.data.subClases;
					});
				}break;
				case '3':
				{
					var codbuscador='';
					var nivbuscador='';
					if (this.cclase!='')
					{
						codbuscador=this.cclase;
						nivbuscador='4';
					}
					else if (this.cgrupo!='')
					{
						codbuscador=this.cgrupo;
						nivbuscador='3';
					}
					else if (this.cdivision!='')
					{
						codbuscador=this.cdivision;
						nivbuscador='2';
					}
					else if (this.cseccion!='')
					{
						codbuscador=this.cseccion;
						nivbuscador='1';
					}
					var keywordsubclase = this.toFormData(this.searchsubclase);
					axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=subclases&seccion='+codbuscador + '&nivel='+nivbuscador,keywordsubclase)
					.then(function(response)
					{
						app.subClases = response.data.subClases;
					});
				}break;
				default:
					this.codrubro='Rubro con clasificacion fuera de rango';
					break;
			}
		},
		buscarfuentes: function()
		{
			axios.post('vue/ccp-fuentes.php')
			.then(function(response)
			{
				app.results = response.data.codigos;
			});
		},
		buscarsubproductos: function()
		{
			var codbuscador='';
			var nivbuscador='';
			if (this.csubclase!='')
			{
				codbuscador=this.csubclase;
				nivbuscador='5';
			}
			else if (this.cclase!='')
			{
				codbuscador=this.cclase;
				nivbuscador='4';
			}
			else if (this.cgrupo!='')
			{
				codbuscador=this.cgrupo;
				nivbuscador='3';
			}
			else if (this.cdivision!='')
			{
				codbuscador=this.cdivision;
				nivbuscador='2';
			}
			else if (this.cseccion!='')
			{
				codbuscador=this.cseccion;
				nivbuscador='1';
			}
			var keywordsubproductos = this.toFormData(this.searchsubproductos);
			axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=subproducto&seccion='+codbuscador + '&nivel='+nivbuscador,keywordsubproductos)
			.then(
				(response)=>
				{
					app.subproductos = response.data.codigos;
				}
			);
		},
		searchMonitorPrograms: function()
		{
			var keywordProgram = app.toFormData(app.searchProgram);
			axios.post('vue/ccp-producto.php?action=searchProgram&sectorSearch='+this.sector_p, keywordProgram)
			.then(function(response)
			{
				app.programas_subprogramas = response.data.programas;
				if(response.data.codigos == ''){app.noMember = true;}
				else{app.noMember = false;}
			});
		},
		searchMonitor: async function()
		{
			var keyword = this.toFormData(this.search);
			await axios.post('vue/ccp-producto.php?action=searchSector', keyword)
			.then(
				(response)=>
				{
					this.sectores = response.data.codigos;
					if(response.data.codigos == ''){this.noMember = true;}
					else {this.noMember = false;}
				}
			);
		},
		searchMonitorProducts: function()
		{
			var keywordProduct = app.toFormData(app.searchProduct);
			axios.post('vue/ccp-producto.php?action=searchProduct&programSearch='+this.programa_p, keywordProduct)
			.then(function(response)
			{
				app.productos = response.data.productos;
				if(response.data.productos == ''){app.noMember = true;}
				else {app.noMember = false;}
			});
		},
		searchMonitorCuentasPresupuestales: function()// Buscar cuentas presupuestales
		{
			var keywordCuentaPresupuestal = app.toFormData(app.searchCuentaPresupuestal);
			axios.post('vue/ccp-producto.php?action=searchCuentaPresupuestal', keywordCuentaPresupuestal)
			.then(function(response)
			{
				app.cuentaspres = response.data.cuentaspresu;
				if(response.data.cuentaspresu == ''){app.noMember = true;}
				else {app.noMember = false;}
			});
		},
		searchMonitorfuentes: async function()
		{
			var keyword = this.toFormData(this.searchfuentes);
			await axios.post('vue/ccp-fuentes.php?action=search', keyword)
			.then(function(response)
			{
				app.results = response.data.codigos;
				if(response.data.codigos == ''){app.noMember = true;}
				else {app.noMember = false;}
			});
		},
		toFormData: function(obj)
		{
			var form_data = new FormData();
			for(var key in obj)
			{
				form_data.append(key, obj[key]);
			}
			return form_data;
		},
		cargaunidadejecutora: function(cod,nom)
		{
			this.cunidadejecutora=cod;
			this.unidadejecutora=cod+' - '+nom;
			this.showModalUnidadEj = false;
			this.deshacer('8');
		},
		cargasector: function(cod,nom)
		{
			this.csector=cod;
			this.sector=cod+' - '+nom;
			this.showModal = false;
			this.deshacer('8');
		},
		cargaprograma: function(cod,nom,scod,snom)
		{
			this.cprograma=cod;
			this.programa=cod+" - "+nom;
			this.csubprograma=scod;
			this.subprograma=scod+" - "+snom;
			this.showModal2 = false;
			this.deshacer('9');
		},
		cargaproducto: function(cod,nom,pcod,pnom)
		{
			this.cproducto=cod;
			this.producto=cod+" - "+nom;
			this.cindicadorpro=pcod;
			this.indicadorpro=pcod+" - "+pnom;
			this.showModal3 = false;
		},
		deplegar: function()
		{
			switch (this.clasificador)
			{	case '1':
					this.tapheight1='61%';
					this.tapheight2='61%';
					this.tapheight3='61%';
					this.tabgroup2=2;
					this.showopcion1=true;
					this.showopcion2=false;
					this.showopcion2_3=false;
					break;
				case '2':
				case '3':
					this.tapheight1='52.5%';
					this.tapheight2='52.5%';
					this.tapheight3='52.5%';
					this.tabgroup2=3;
					this.showopcion1=false;
					this.showopcion2=false;
					this.showopcion2_3=true;
					break;
			}
		},
		cargacuenta: async function(cod,nom,tip)
		{
			if(tip == 'C')
			{
				if(this.codrubro!=cod)
				{
					this.codrubro=cod;
					this.nrubro=cod+" - "+nom;
					this.nombre_r=nom;
					this.showModal4 = false;
					this.deshabilitar_seccion = false;
					var codrubrorec =  this.codrubro.slice(0,-3);
					
					this.seccion=this.cseccion = '';
					if(codrubrorec == '2.3.2.02.01.' || codrubrorec == '2.3.5.01'){
											
						await axios.post('vue/ccp-bienestransportables.php')
							.then(function(response)
							{
								app.secciones = response.data.secciones;
							});
						for( i = 0; i <= (app.secciones.length-1); i++ ){
							if(app.codrubro.slice(14) ==  app.secciones[i][0]){
								app.cargaseccion(app.secciones[i][0], app.secciones[i][1]);
							}
							else if(app.codrubro.slice(10) ==  app.secciones[i][0])
							{
								app.cargaseccion(app.secciones[i][0], app.secciones[i][1]);
							}
						}
						this.deshabilitar_seccion = true;

					}else if(codrubrorec == '2.3.2.02.02.' || codrubrorec == '2.3.5.02'){

						await axios.post('vue/ccp-servicios.php')
							.then(function(response){
								app.secciones = response.data.secciones;
							});
						for( i = 0; i <= (app.secciones.length-1); i++ ){
							if(app.codrubro.slice(14) ==  app.secciones[i][0]){
								app.cargaseccion(app.secciones[i][0], app.secciones[i][1]);
							}else if(app.codrubro.slice(10) ==  app.secciones[i][0]){
								app.cargaseccion(app.secciones[i][0], app.secciones[i][1]);
							}
						}
						this.deshabilitar_seccion = true;

					}else{
					}
					this.buscarclasificador();
				}
				else{this.showModal4 = false;}
			}
		},
		cargacodigocuin:function(ident,nitent,noment,codcuin)
		{
			if(this.identidad!=ident)
			{
				this.identidad=ident;
				this.nitentidad=nitent;
				this.codigocuin=codcuin;
				this.nomentidad=noment
				this.showModal11 = false;
			}
		},
		cargaseccion: function(cod,nom)
		{
			if(this.cseccion!=cod)
			{
				this.cseccion=cod;
				this.seccion=cod+" - "+nom;
				this.showModal5 = false;
				this.deshacer('3');
			}
			else{this.showModal5 = false;}
		},
		cargadivision: function(cod,nom)
		{
			if(this.cdivision!=cod)
			{
				this.cdivision=cod;
				this.division=cod+" - "+nom;
				this.showModal6 = false;
				this.deshacer('4');
			}
			else{this.showModal6 = false;}
		},
		cargagrupo: function(cod,nom)
		{
			if(this.cgrupo!=cod)
			{
				this.cgrupo=cod;
				this.grupo=cod+" - "+nom;
				this.showModal7 = false;
				this.deshacer('5');
			}
			else{this.showModal7 = false;}
		},
		cargaclase: function(cod,nom)
		{
			if(this.cclase!=cod)
			{
				this.cclase=cod;
				this.clase=cod+" - "+nom;
				this.showModal8 = false;
				this.deshacer('6');
			}
			else{this.showModal8 = false;}
		},
		cargasubclase: function(cod,nom)
		{
			if(this.csubclase!=cod)
			{
				this.csubclase=cod;
				this.subclase=cod+" - "+nom;
				if(this.clasificador=='2')
				{
					if(this.cseccion=='')
					{
						this.cseccion=cod.substr(0,1);
						axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cseccion)
						.then((response)=>{this.seccion=this.cseccion+" - "+response.data.codigos[0][0];});
					}
					if(this.cdivision=='')
					{
						this.cdivision=cod.substr(0,2);
						axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cdivision)
						.then((response)=>{this.division=this.cdivision+" - "+response.data.codigos[0][0];});
					}
					if(this.cgrupo=='')
					{
						this.cgrupo=cod.substr(0,3);
						axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cgrupo)
						.then((response)=>{this.grupo=this.cgrupo+" - "+response.data.codigos[0][0];});
					}
					if(this.cclase=='')
					{
						this.cclase=cod.substr(0,4);
						axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cclase)
						.then((response)=>{this.clase=this.cclase+" - "+response.data.codigos[0][0];});
					}
				}
				else
				{
					if(this.cseccion=='')
					{
						this.cseccion=cod.substr(0,1);
						axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupos&grupo='+this.cseccion)
						.then((response)=>{this.seccion=this.cseccion+" - "+response.data.codigos[0][0];});
					}
					if(this.cdivision=='')
					{
						this.cdivision=cod.substr(0,2);
						axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupos&grupo='+this.cdivision)
						.then((response)=>{this.division=this.cdivision+" - "+response.data.codigos[0][0];});
					}
					if(this.cgrupo=='')
					{
						this.cgrupo=cod.substr(0,3);
						axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupos&grupo='+this.cgrupo)
						.then((response)=>{this.grupo=this.cgrupo+" - "+response.data.codigos[0][0];});
					}
					if(this.cclase=='')
					{
						this.cclase=cod.substr(0,4);
						axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupos&grupo='+this.cclase)
						.then((response)=>{this.clase=this.cclase+" - "+response.data.codigos[0][0];});
					}
				}
				this.showModal9 = false;
				this.deshacer('7');
			}
			else{this.showModal9 = false;}
		},
		cargafuente: function(cod,nom)
		{
			this.cfuentef=cod;
			this.fuentef=cod+" - "+nom;
			this.showModal10 = false;
		},
		cargasubproducto: function(cod,nom)
		{
			this.csubproducto=cod;
			this.subproducto=cod+" - "+nom;
			if(this.cseccion=='')
			{
				this.cseccion=cod.substr(0,1);
				axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cseccion)
				.then((response)=>{this.seccion=this.cseccion+" - "+response.data.codigos[0][0];});
			}
			if(this.cdivision=='')
			{
				this.cdivision=cod.substr(0,2);
				axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cdivision)
				.then((response)=>{this.division=this.cdivision+" - "+response.data.codigos[0][0];});
			}
			if(this.cgrupo=='')
			{
				this.cgrupo=cod.substr(0,3);
				axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cgrupo)
				.then((response)=>{this.grupo=this.cgrupo+" - "+response.data.codigos[0][0];});
			}
			if(this.cclase=='')
			{
				this.cclase=cod.substr(0,4);
				axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cclase)
				.then((response)=>{this.clase=this.cclase+" - "+response.data.codigos[0][0];});
			}
			if(this.csubclase=='')
			{
				this.csubclase=cod.substr(0,5);
				axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.csubclase)
				.then((response)=>{this.subclase=this.csubclase+" - "+response.data.codigos[0][0];});
			}
			this.showModal12 = false;
		},
		agregarproducto: function()
		{
			var bandera01=0;
			if(this.selecproductosb.length>0)
			{
				for (const auxarray in this.selecproductosb)
				{
					var auxlong=`${this.selecproductosb[auxarray]}`;
					if(auxlong.includes(this.cindicadorpro)==true)
					{
						bandera01=1;
					}
				}
			}
			if(this.indicadorpro != '')
			{
				if(bandera01==0)
				{
					var varauxia=[this.cproducto,this.producto,this.cindicadorpro,this.indicadorpro,this.csector,this.cprograma,this.csubprograma];
					var varauxib=[this.cproducto,this.cindicadorpro,this.csector,this.cprograma,this.csubprograma];
					this.selecproductosa.push(varauxia);
					this.selecproductosb.push(varauxib);
					this.cindicadorpro=this.indicadorpro=this.cproducto=this.producto='';
					this.sectordobleclick='';
					this.programadobleclick= '';
				}
				else
				{
					this.toggleMensaje();
					this.colortitulosmensaje='crimson';
					this.titulomensaje='Mensaje de Error';
					this.contenidomensaje='Producto duplicado';
				}
			}
			else
			{
				this.toggleMensaje();
				this.colortitulosmensaje='crimson';
				this.titulomensaje='Mensaje de Error';
				this.contenidomensaje='Falta seleccionar un producto para agregar';
			}
		},
		eliminaproducto: function(index)
		{
			this.selecproductosa.splice(index, 1);
			this.selecproductosb.splice(index, 1);
			if(this.selecproductosa.length==0){this.programadobleclick=this.sectordobleclick='colordobleclik';}
		},
		agregarcuenta: function()
		{
			var bandera01=0;
			if(this.selectbuscar.length>0)
			{
				for (const auxarray in this.selectbuscar)
				{
					var auxlong=`${this.selectbuscar[auxarray]}`;
					var auxbusq=this.cfuentef + '<->' + this.clasificador + '<->' + this.codrubro + '<->' + this.csubclase;
					if(auxlong.includes(auxbusq)==true)
					{
						bandera01=1;
					}
				}
			}
			if(this.fuentef!='')
			{
				if(this.mediopago!='')
				{
					if(this.seccion!='')
					{
						if(this.division!='')
						{
							if(this.grupo!='')
							{
								if(this.clase!='')
								{
									if(this.csubclase!='')
									{
										if(this.valorrubro > 0 )
										{
											if(!this.valorrubro.includes('.'))
											{
												if(bandera01==0)
												{
													var unionaux = this.cfuentef + '<->' + this.clasificador + '<->' + this.codrubro + '<->' + this.csubclase;
													this.tabgroup2=3;
													this.valorproyecto = Number(this.valorproyecto) + Number(this.valorrubro);
													var varauxia=[this.clasificador,this.nrubro,this.subclase,this.valorrubro,this.fuentef,this.mediopago, this.subproducto];
													var varauxib=[this.codrubro,this.clasificador,this.cseccion,this.cdivision,this.cgrupo,this.cclase, this.csubclase,this.valorrubro, this.cfuentef,this.mediopago,this.csubproducto];
													var buscaraux=[unionaux];
													this.selectcuetasa.push(varauxia);
													this.selectcuetasb.push(varauxib);
													this.selectbuscar.push(unionaux);
													this.csubproducto=this.subproducto=this.cseccion=this.cdivision=this.cgrupo=this.cclase=this.csubclase= this.seccion=this.division=this.grupo=this.clase=this.subclase=this.valorrubro=this.nrubro=this.codrubro=''; this.clasificador=0;
												}
												else
												{
													this.toggleMensaje();
													this.colortitulosmensaje='crimson';
													this.titulomensaje='Mensaje de Error';
													this.contenidomensaje='Rubro duplicado';
												}
											}
											else
											{
												this.parpadeovalorrubro='parpadea';
												this.toggleMensaje();
												this.colortitulosmensaje='crimson';
												this.titulomensaje='Mensaje de Error';
												this.contenidomensaje='No puede ingresar el valor en decimales!';
											}
										}
										else
										{
											this.parpadeovalorrubro='parpadea';
											this.opcionmensaje='4';
											this.toggleMensaje();
											this.colortitulosmensaje='crimson';
											this.titulomensaje='Mensaje de Error';
											this.contenidomensaje='Falta ingresar el valor para poder agregar';
										}
									}
									else
									{
										this.subclasedobleclick='parpadea colordobleclik';
										this.toggleMensaje();
										this.colortitulosmensaje='crimson';
										this.titulomensaje='Mensaje de Error';
										this.contenidomensaje='Falta ingresar la Subclase para poder agregar';
									}
								}
								else
								{
									this.clasedobleclick='parpadea colordobleclik';
									this.toggleMensaje();
									this.colortitulosmensaje='crimson';
									this.titulomensaje='Mensaje de Error';
									this.contenidomensaje='Falta ingresar una Clase para poder agregar';
								}
							}
							else
							{
								this.grupodobleclick='parpadea colordobleclik';
								this.toggleMensaje();
								this.colortitulosmensaje='crimson';
								this.titulomensaje='Mensaje de Error';
								this.contenidomensaje='Falta ingresar un Grupo para poder agregar';
							}
						}
						else
						{
							this.divisiondobleclick='parpadea colordobleclik';
							this.toggleMensaje();
							this.colortitulosmensaje='crimson';
							this.titulomensaje='Mensaje de Error';
							this.contenidomensaje='Falta ingresar Divisi\xf3n para poder agregar';
						}
					}
					else
					{
						this.secciondobleclick='parpadea colordobleclik';
						this.toggleMensaje();
						this.colortitulosmensaje='crimson';
						this.titulomensaje='Mensaje de Error';
						this.contenidomensaje='Falta ingresar Secci\xf3n para poder agregar';
					}
				}
				else
				{
					this.parpadeomediopago='parpadea'
					this.toggleMensaje();
					this.colortitulosmensaje='crimson';
					this.titulomensaje='Mensaje de Error';
					this.contenidomensaje='Falta ingresar el Medio de Pago';
				}
			}
			else
			{
				this.fuentedobleclick='parpadea colordobleclik';
				this.toggleMensaje();
				this.colortitulosmensaje='crimson';
				this.titulomensaje='Mensaje de Error';
				this.contenidomensaje='Falta ingresar la Fuente para poder agregar';
			}
		},
		eliminacuentas: function(index,valor)
		{
			console.log( this.valorproyecto + "-" + valor)
			this.valorproyecto = Number(this.valorproyecto) - Number(valor);
			this.valorproyecto = Number(this.valorproyecto)
			this.selectcuetasa.splice(index, 1);
			this.selectcuetasb.splice(index, 1);
		},
		agregarcuenta1:function()
		{
			var bandera01=0;
			if(this.selectcuetasc.length>0)
			{
				for (const auxarray in this.selectbuscar1)
				{
					var auxlong=`${this.selectbuscar1[auxarray]}`;
					var auxbusq=this.cfuentef + '<->' + this.codigocuin;
					if(auxlong.includes(auxbusq)==true)
					{
						bandera01=1;
					}
				}
			}
			if(this.cfuentef!='')
			{
				if(this.mediopago!='')
				{
					if(this.identidad!='')
					{
						if(this.valorcuin>0)
						{
							if(!this.valorcuin.includes('.'))
							{
								if(bandera01==0)
								{
									this.tabgroup2=2;
									var unionaux = this.cfuentef + '<->' + this.codigocuin;
									this.valorproyecto = Number(this.valorproyecto) + Number(this.valorcuin);
									var varauxia=[this.identidad,this.nitentidad,this.nomentidad,this.codigocuin,this.valorcuin,this.fuentef,this.mediopago,this.codrubro];
									var varauxib=[this.codrubro,this.identidad,this.nitentidad,this.codigocuin,this.valorcuin,this.cfuentef,this.mediopago];
									this.selectcuetasc.push(varauxia);
									this.selectcuetasd.push(varauxib);
									this.selectbuscar1.push(unionaux);
									this.identidad=this.nitentidad=this.codigocuin=this.nomentidad=this.valorcuin=this.nrubro=this.codrubro='';
									this.clasificador=0;
								}
								else
								{
									this.toggleMensaje();
									this.colortitulosmensaje='crimson';
									this.titulomensaje='Mensaje de Error';
									this.contenidomensaje='Rubro duplicado';
								}
							}
							else
							{
								this.toggleMensaje();
								this.colortitulosmensaje='crimson';
								this.titulomensaje='Mensaje de Error';
								this.contenidomensaje='No puede ingresar el valor en decimales!';
							}
						}
						else
						{
							this.opcionmensaje='4';
							this.toggleMensaje();
							this.colortitulosmensaje='crimson';
							this.titulomensaje='Mensaje de Error';
							this.contenidomensaje='Falta ingresar el valor para poder agregar';
						}
					}
					else
					{
						this.toggleMensaje();
						this.colortitulosmensaje='crimson';
						this.titulomensaje='Mensaje de Error';
						this.contenidomensaje='Falta ingresar la Entidad para poder agregar';
					}
				}
				else
				{
					this.toggleMensaje();
					this.colortitulosmensaje='crimson';
					this.titulomensaje='Mensaje de Error';
					this.contenidomensaje='Falta ingresar el Medio de Pago para poder agregar';
				}
			}
			else
			{
				this.toggleMensaje();
				this.colortitulosmensaje='crimson';
				this.titulomensaje='Mensaje de Error';
				this.contenidomensaje='Falta ingresar Fuente para poder agregar';
			}
		},
		eliminacuenta1:function(index,valor)
		{
			
			this.valorproyecto = Number(this.valorproyecto) - Number(valor);
			this.selectcuetasc.splice(index, 1);
			this.selectcuetasd.splice(index, 1);
		},
		agregarcuenta2:function()
		{
			var bandera01=0;
			if(this.selectcuetasf.length>0)
			{
				for (const auxarray in this.selectbuscar2)
				{
					var auxlong=`${this.selectbuscar2[auxarray]}`;
					var auxbusq=this.cfuentef + '<->' + this.codrubro;
					if(auxlong.includes(auxbusq)==true)
					{
						bandera01=1;
					}
				}
			}
			if(this.cfuentef!='')
			{
				if(this.mediopago)
				{
					if(this.valorsinclasifi!='')
					{
						if(bandera01==0)
						{
							if(!this.valorsinclasifi.includes('.'))
							{
								this.tabgroup2=1;
								var unionaux = this.cfuentef + '<->' + this.codrubro;
								this.valorproyecto = Number(this.valorproyecto) + Number(this.valorsinclasifi);
								var varauxia=[this.codrubro,this.nrubro,this.valorsinclasifi,this.cfuentef,this.mediopago];
								var varauxib=[this.codrubro,this.valorsinclasifi,this.cfuentef,this.mediopago];
								this.selectcuetase.push(varauxia);
								this.selectcuetasf.push(varauxib);
								this.selectbuscar2.push(unionaux);
								this.valorsinclasifi=this.nrubro=this.codrubro='';
								this.clasificador=0;
							}
							else
							{
								this.toggleMensaje();
								this.colortitulosmensaje='crimson';
								this.titulomensaje='Mensaje de Error';
								this.contenidomensaje='No puede ingresar el valor en decimales!';
							}
						}
						else
						{
							this.toggleMensaje();
							this.colortitulosmensaje='crimson';
							this.titulomensaje='Mensaje de Error';
							this.contenidomensaje='Rubro duplicado';
						}
					}
					else
					{
						this.toggleMensaje();
						this.colortitulosmensaje='crimson';
						this.titulomensaje='Mensaje de Error';
						this.contenidomensaje='Falta ingresar el valor para poder agregar';
					}
				}
				else
				{
					this.toggleMensaje();
					this.colortitulosmensaje='crimson';
					this.titulomensaje='Mensaje de Error';
					this.contenidomensaje='Falta ingresar el medio de pago para poder agregar';
				}
			}
			else
			{
				this.toggleMensaje();
				this.colortitulosmensaje='crimson';
				this.titulomensaje='Mensaje de Error';
				this.contenidomensaje='Falta ingresar la Fuente para poder agregar';
			}

		},
		eliminacuenta2:function(index,valor)
		{
			this.valorproyecto = Number(this.valorproyecto) - Number(valor);
			this.selectcuetase.splice(index, 1);
			this.selectcuetasf.splice(index, 1);
		},
		deshacer: function(id)
		{
			switch (id)
			{
				case'0':
					this.codrubro=this.nrubro=this.valorrubro=this.cseccion=this.seccion=this.cdivision=this.division=this.cgrupo=this.grupo='';
					this.clasificador=this.cclase=this.clase=this.csubclase=this.subclase=this.csubproducto=this.subproducto='';
					break;
				case '1':
					this.clasificador=this.valorrubro=this.cseccion=this.seccion=this.cdivision=this.division=this.cgrupo=this.grupo='';
					this.cclase=this.clase=this.csubclase=this.subclase=this.csubproducto=this.subproducto='';
					break;
				case '2':
					this.valorrubro=this.cseccion=this.seccion=this.cdivision=this.division=this.cgrupo=this.grupo='';
					this.cclase=this.clase=this.csubclase=this.subclase=this.csubproducto=this.subproducto='';
					break;
				case '3':
					this.cdivision=this.division=this.cgrupo=this.grupo=this.cclase=this.clase=this.csubclase=this.subclase=this.valorrubro='';
					this.csubproducto=this.subproducto='';
					break;
				case '4':
					this.cgrupo=this.grupo=this.cclase=this.clase=this.csubclase=this.subclase=this.valorrubro=this.csubproducto=this.subproducto='';
					break;
				case '5':
					this.cclase=this.clase=this.csubclase=this.subclase=this.valorrubro=this.csubproducto=this.subproducto='';
					break;
				case '6':
					this.csubclase=this.subclase=this.valorrubro=this.csubproducto=this.subproducto='';
					break;
				case '7':
					this.valorrubro=this.csubproducto=this.subproducto='';
					break; 
				case '8':
					this.cproducto=this.producto=this.cindicadorpro=this.indicadorpro=this.programa=this.cprograma=this.subprograma=this.csubprograma='';
					break;
				case '9':
					this.cproducto=this.producto=this.cindicadorpro=this.indicadorpro='';
					break;
				case '10':
					this.codrubro=this.nrubro=this.clasificador='';
					break;
				case '11':
					this.clasificador=this.valorrubro=this.cdivision=this.division=this.cgrupo=this.grupo='';
					this.cclase=this.clase=this.csubclase=this.subclase='';
					break;
				case '12':
					this.valorrubro=this.cdivision=this.division=this.cgrupo=this.grupo='';
					this.cclase=this.clase=this.csubclase=this.subclase='';
					break;
			}
		},
		preguntaguardar: function()
		{
			this.toggleMensajeSN();
			this.colortitulosmensaje='darkgreen';
			this.titulomensaje='Almacenado en el Sitema';
			this.contenidomensaje='Desea guardar el Proyecto';
		},
		guardarglobal: async function()
		{
			await this.validarguardar();
			this.valida_presupuesto = 'SI';
			if(this.valida_proyecto == 'SI' && this.valida_presupuesto == 'SI')
			{
				await this.conocerid();
				var idnum= this.idproyecto;
				this.guardarcabecera(idnum);
				this.guardarproductos(idnum);
				this.guardarcuin(idnum);
				this.guardarpresupuestob(idnum);
				this.guardarsinclasificador(idnum);
				this.toggleMensaje();
				this.colortitulosmensaje='darkgreen';
				this.titulomensaje='Almacenado en el Sitema';
				this.contenidomensaje='La informaci\xf3n del Proyecto No '+idnum+' se almaceno con exito';
				setTimeout(()=>{location.reload()}, 3000)
			}
		},
		conocerid: async function()
		{
			await axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?numid=si')
			.then((response)=>
			{
				this.idproyecto = response.data.numid;
			});
		},
		guardarcabecera: function(idnum)
		{
			console.log(app.cunidadejecutora)
			var formData = new FormData();
			formData.append("idnum",idnum);
			formData.append("idunidadej", app.cunidadejecutora);
			formData.append("codigo", app.codigo);
			formData.append("vigencia", app.vigencia);
			formData.append("nombre", app.nombre);
			formData.append("descripcion", app.descripcion);
			formData.append("valortotal", app.valorproyecto);
			axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?guardar=cabecera', formData)
			.then();
		},
		guardarproductos: function(idnum)
		{
			var formData = new FormData();
			formData.append("idnum",idnum);
			for(i in this.selecproductosb)
			{
				formData.append(`infproyectos[${i}]`, this.selecproductosb[i]);
			}
			axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?guardar=productos', formData)
			.then();
		},
		guardarpresupuestob: function(idnum)
		{
			var formData = new FormData();
			formData.append("idnum",idnum);
			for(i in this.selectcuetasb)
			{
				formData.append(`infcuentasb[${i}]`, this.selectcuetasb[i]);
			}
			axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?guardar=cuentasb', formData)
			.then();
		},
		guardarcuin: function(idnum)
		{
			var formData = new FormData();
			formData.append("idnum",idnum);
			for(i in this.selectcuetasd)
			{
				formData.append(`infcuentascuin[${i}]`, this.selectcuetasd[i]);
			}
			axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?guardar=ccuentascuin', formData)
			.then();
		},
		guardarsinclasificador: function(idnum)
		{
			var formData = new FormData();
			formData.append("idnum",idnum);
			for(i in this.selectcuetasf)
			{
				formData.append(`infcuentassinclasificador[${i}]`, this.selectcuetasf[i]);
			}
			axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?guardar=ccuentassinclasificador', formData)
			.then();
		},
		validarguardar: async function()
		{
			if(this.codigo.trim()!='')
			{
				if(this.nombre.trim()!='')
				{
					if(this.descripcion.trim()!='')
					{
						if(this.selecproductosa.length > 0){

							this.valida_proyecto = 'SI';
						}
						else
						{
							this.toggleMensaje();
							this.colortitulosmensaje='crimson';
							this.titulomensaje='Mensaje de Error';
							this.contenidomensaje='Falta agregar productos para poder guardar el proyecto';
						}
					}
					else
					{
						this.opcionmensaje='3';
						this.toggleMensaje();
						this.colortitulosmensaje='crimson';
						this.titulomensaje='Mensaje de Error';
						this.contenidomensaje='Falta agregar la descripci\xf3n del proyecto para poder guardar';
					}
				}
				else
				{
					this.opcionmensaje='2';
					this.toggleMensaje();
					this.colortitulosmensaje='crimson';
					this.titulomensaje='Mensaje de Error';
					this.contenidomensaje='Falta agregar el nombre del proyecto para poder guardar';
				}
			}
			else
			{
				this.opcionmensaje='1';
				this.toggleMensaje();
				this.colortitulosmensaje='crimson';
				this.titulomensaje='Mensaje de Error';
				this.contenidomensaje='Falta agregar el c\xf3digo del proyecto para poder guardar';
			}
			
			
		},
		validasubproducto: function(codigo)
		{
			if(codigo.length==7)
			{
				var formData = new FormData();
				var codbuscador='';
				var nivbuscador='';
				if (this.csubclase!='')
				{
					codbuscador=this.csubclase;
					nivbuscador='5';
				}
				else if (this.cclase!='')
				{
					codbuscador=this.cclase;
					nivbuscador='4';
				}
				else if (this.cgrupo!='')
				{
					codbuscador=this.cgrupo;
					nivbuscador='3';
				}
				else if (this.cdivision!='')
				{
					codbuscador=this.cdivision;
					nivbuscador='2';
				}
				else if (this.cseccion!='')
				{
					codbuscador=this.cseccion;
					nivbuscador='1';
				}
				formData.append("seccion",codbuscador);
				formData.append("nivel",nivbuscador);
				formData.append("codigo",codigo);
				axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=valsubproducto',formData)
				.then(
					(response)=>
					{
						if(response.data.codigos[0][0]!='')
						{
							this.csubproducto=codigo;
							this.subproducto=codigo+" - "+response.data.codigos[0][0];
							if(this.cseccion=='')
							{
								this.cseccion=codigo.substr(0,1);
								axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cseccion)
								.then((response)=>{this.seccion=this.cseccion+" - "+response.data.codigos[0][0];});
							}
							if(this.cdivision=='')
							{
								this.cdivision=codigo.substr(0,2);
								axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cdivision)
								.then((response)=>{this.division=this.cdivision+" - "+response.data.codigos[0][0];});
							}
							if(this.cgrupo=='')
							{
								this.cgrupo=codigo.substr(0,3);
								axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cgrupo)
								.then((response)=>{this.grupo=this.cgrupo+" - "+response.data.codigos[0][0];});
							}
							if(this.cclase=='')
							{
								this.cclase=codigo.substr(0,4);
								axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cclase)
								.then((response)=>{this.clase=this.cclase+" - "+response.data.codigos[0][0];});
							}
							if(this.csubclase)
							{
								this.csubclase=codigo.substr(0,5);
								axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.csubclase)
								.then((response)=>{this.subclase=this.csubclase+" - "+response.data.codigos[0][0];});
							}
						}
					}
				);
			}
		},
		validasubclase: function(codigo)
		{
			if(codigo.length==5)
			{
				var formData = new FormData();
				var codbuscador='';
				var nivbuscador='';
				if (this.cclase!='')
				{
					codbuscador=this.cclase;
					nivbuscador='4';
				}
				else if (this.cgrupo!='')
				{
					codbuscador=this.cgrupo;
					nivbuscador='3';
				}
				else if (this.cdivision!='')
				{
					codbuscador=this.cdivision;
					nivbuscador='2';
				}
				else if (this.cseccion!='')
				{
					codbuscador=this.cseccion;
					nivbuscador='1';
				}
				formData.append("seccion",codbuscador);
				formData.append("nivel",nivbuscador);
				formData.append("codigo",codigo);
				if(this.clasificador=='2')
				{
					axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=valsubclaseb',formData)
					.then(
						(response)=>
						{
							if(response.data.codigos[0][0]!='')
							{
								this.csubclase=codigo;
								this.subclase=codigo+" - "+response.data.codigos[0][0];
								if(this.cseccion=='')
								{
									this.cseccion=codigo.substr(0,1);
									axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cseccion)
									.then((response)=>{this.seccion=this.cseccion+" - "+response.data.codigos[0][0];});
								}
								if(this.cdivision=='')
								{
									this.cdivision=codigo.substr(0,2);
									axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cdivision)
									.then((response)=>{this.division=this.cdivision+" - "+response.data.codigos[0][0];});
								}
								if(this.cgrupo=='')
								{
									this.cgrupo=codigo.substr(0,3);
									axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cgrupo)
									.then((response)=>{this.grupo=this.cgrupo+" - "+response.data.codigos[0][0];});
								}
								if(this.cclase=='')
								{
									this.cclase=codigo.substr(0,4);
									axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupo&grupo='+this.cclase)
									.then((response)=>{this.clase=this.cclase+" - "+response.data.codigos[0][0];});
								}
							}
						}
					);
				}
				else
				{
					axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=valsubclases',formData)
					.then(
						(response)=>
						{
							if(response.data.codigos[0][0]!='')
							{
								this.csubclase=codigo;
								this.subclase=codigo+" - "+response.data.codigos[0][0];
								if(this.cseccion=='')
								{
									this.cseccion=codigo.substr(0,1);
									axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupos&grupo='+this.cseccion)
									.then((response)=>{this.seccion=this.cseccion+" - "+response.data.codigos[0][0];});
								}
								if(this.cdivision=='')
								{
									this.cdivision=codigo.substr(0,2);
									axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupos&grupo='+this.cdivision)
									.then((response)=>{this.division=this.cdivision+" - "+response.data.codigos[0][0];});
								}
								if(this.cgrupo=='')
								{
									this.cgrupo=codigo.substr(0,3);
									axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupos&grupo='+this.cgrupo)
									.then((response)=>{this.grupo=this.cgrupo+" - "+response.data.codigos[0][0];});
								}
								if(this.cclase=='')
								{
									this.cclase=codigo.substr(0,4);
									axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=nombregrupos&grupo='+this.cclase)
									.then((response)=>{this.clase=this.cclase+" - "+response.data.codigos[0][0];});
								}
							}
						}
					);
				}
			}
		},
		validaindicadorproducto:function(codigo)
		{
			var bandera1=0;
			if(this.selecproductosa.length!=0)
			{
				if(codigo.length>=4)
				{
					if(codigo.substr(0,4) == this.cprograma)
					{
						bandera1=0;
					}
					else 
					{
						bandera1=1;
						this.toggleMensaje();
						this.colortitulosmensaje='crimson';
						this.titulomensaje='Mensaje de Error';
						this.contenidomensaje='Todos los productos deben ser del mismo Sector y Programa';
					}
				}
			}
			if(codigo.length == 9 && bandera1 == 0)
			{
				
				var formData = new FormData();
				formData.append("codigo",codigo);
				axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=valindicproducto',formData)
				.then(
					(response)=>
					{
						if(response.data.codigos[0][0]!='')
						{
							this.cindicadorpro = codigo;
							this.indicadorpro = codigo +" - " + response.data.codigos[0][0];
							this.cproducto = response.data.codigos[0][1];
							this.producto = response.data.codigos[0][1] + " - " + response.data.codigos[0][2];
							this.cprograma = codigo.substr(0,4);
							this.csector = codigo.substr(0,2);
							if(this.cprograma!='')
							{
								axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=valprograma&programa='+this.cprograma)
								.then(
									(response)=>
									{
										this.programa = this.cprograma + " - "+response.data.programas[0][0];
										this.csubprograma=response.data.programas[0][1];
										this.subprograma=this.csubprograma + " - " + response.data.programas[0][2];
									}
								);
							}
							if(this.csector!='')
							{
								axios.post('vue/presupuesto_ccp/ccp-bancoproyectos.php?buscar=valsector&sector='+this.csector)
								.then(
									(response)=>
									{
										this.sector = this.csector + " - "+response.data.sectores[0][0];
									}
								);
							}
						}
					}
				);
			}
		}
	},
});