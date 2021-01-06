var app = new Vue({
    el: '#myapp',
    data: {
        secciones: [],
        seccionesServicios: [], 
        unidadesejecutoras: [],
        selectMedioPago: 'CSF',
        optionsMediosPagos: [
            { text: 'Con situacion de fondos', value: 'CSF' },
            { text: 'Sin situacion de fodos', value: 'SSF' }
        ],
        fuentes: [], 
        divisiones: [],
        divisionesServicios: [],
        grupos: [],
        gruposServicios: [],
        clases: [],
        clasesServicios: [],
        subClases: [],
        subClasesServicios: [],
        subClases_captura: [],
        ingresos: [],
        clasificadores: [],
        resultsCuin: [],
        resultsClasificador: [],
        verResultsCuin: [],
        verResultsClasificador: [],
        verResultsBienes: [],
        verResultsCuinEliminar: [],
        cuentasCuinAgr: [],
        cuentasSubClaseAgr: [],
        cuentasSelectCuin: [],
        valorIngresoCuenta: [],
        cuentasSelectSubClase: [],
        SelectClasificador: [],
        seccion_p: '',
        seccionServicios_p: '',
        clasificadorActual: '',
        seccion_p_nombre: '',
        seccionServicios_p_nombre: '',
        division_p: '',
        divisionServicios_p: '',
        division_p_nombre: '',
        grupo_p: '',
        grupoServicios_p: '',
        grupo_p_nombre: '',
        clase_p: '',
        clasificador_p: '',
        claseServicios_p: '',
        clase_p_nombre: '',
        subClase_p: '',
        subClaseServicios_p: '',
        subClase_p_nombre: '',
        fuente_p: '',
        selected: '01',
        cuin_p: '',
        mostrarDivision: false,
        mostrarGrupo: false,
        mostrarGrupoServicios: false,
        mostrarClase: false,
        mostrarClaseServicios: false,
        mostrarSubClase: false,
        mostrarSubClaseServicios: false,
        mostrar_resultados_ingresos: false,
        showModal_bienes_transportables: false,
        mostrarSubClaseProducto: false,
        gastos: [],
        verResultsServicios: [],
        cuentasSubClaseServiciosAgr: [],
        cuentasClasificadorAgr: [],
        cuentasSelectSubClaseServicios: [],
        cuentasSelectFuentes: [],
        valorGastoCSF: [],
        valorGastoSSF: [],
        search: {keyword: ''},
        searchCuin : {keywordCuin: ''},
        searchDivision: {keywordDivision: ''},
        searchDivisionServicios: {keywordDivisionServicios: ''},
        searchGrupo: {keywordGrupo: ''},
        searchGrupoServicios: {keywordGrupoServicios: ''},
        searchClase: {keywordClase: ''},
        searchClaseServicios: {keywordClaseServicios: ''},
        searchSubClase: {keywordSubClase: ''},
        searchSubClaseServicios: {keywordSubClaseServicios: ''},
        searchGeneral: {keywordGeneral: ''},
        searchFuente: {keywordFuente: ''},
        mostrar_resultados_gastos: false,
        showModal: false,
        show_table_search: false,
        showModal_servicios: false,
        showModal_fuentes: false,
        showModal_Solo_Presupuesto: false,
        showModal_clasificador: false,
        valorCuin: 0,
        valorClasificador: 0,
        valorTotal: 0,
        valorTotalBienes: 0,
        valorServicios: 0,
        valorTotalServicios: 0,
        valorSolo: 0,
        vigencia: 0,
        valorTotalClasificador: 0,
        valorBienesTranspotables: 0,
        searchBienes: {keyword: ''},
        mostrarSeccion: true,
        mostrarSeccionServicios: true,
        mostrarDivisionServicios: false,
        cuentaActual: ''
    },
    mounted: function(){
        this.buscarIngresos();
    },
    methods: {
        fetchMembersBienes: function(){
            axios.post('vue/ccp-bienestransportables.php')
                .then(function(response){
                    app.secciones = response.data.secciones;
                });
        },

        fetchMembersServicios: function(){
            axios.post('vue/ccp-servicios.php')
                .then(function(response){
                    app.seccionesServicios = response.data.secciones;
                });
        },

        fetchMembersUnidadEjecutora: function(){
            axios.post('vue/ccp-unidadejecutora.php')
                .then(function(response){
                    app.unidadesejecutoras = response.data.unidades;
                    //console.log(response.data.unidades);
                });
        },

        fetchMembersFuente: function(){
            axios.post('vue/ccp-fuentes.php')
                .then(function(response){
                    app.fuentes = response.data.codigos;
                    //console.log(response.data.codigos);
                });
        },

        division: function(seccion, scrollArriba = false)
        {
            this.searchDivision= {keywordDivision: ''};
            this.searchGrupo= {keywordGrupo: ''};
            this.searchClase= {keywordClase: ''};
            this.searchSubClase= {keywordSubClase: ''};
            app.divisiones = [];
            app.grupos = [];
            app.clases = [];
            app.subClases = [];
            this.division_p = '';
            this.division_p_nombre = '';
            this.grupo_p = '';
            this.grupo_p_nombre = '';
            this.clase_p = '';
            this.clase_p_nombre = '';
            this.subClase_p = '';
            this.subClase_p_nombre = '';
            app.mostrarGrupo = false;
            app.mostrarClase = false;
            app.mostrarSubClase = false;
            app.mostrarSubClaseProducto = false;

            this.seccion_p = seccion[0];
            this.seccion_p_nombre = seccion[1];
            axios.post('vue/ccp-bienestransportables.php?seccion='+this.seccion_p)
                .then(function(response){
                    app.divisiones = response.data.divisiones;
                    if(response.data.divisiones == ''){
                        app.mostrarDivision = false;
                    }
                    else{
                        app.mostrarDivision = true;
                    }
                });
            
            if(!scrollArriba)
            {
                setTimeout(function(){ document.getElementById("end_page").scrollIntoView({block: "end", behavior: "smooth"}); }, 1)
            }
        },

        buscarGrupo: function(division, scrollArriba = false)
        {
            this.searchGrupo= {keywordGrupo: ''};
            this.searchClase= {keywordClase: ''};
            this.searchSubClase = {keywordSubClase: ''};
            app.grupos = [];
            app.clases = [];
            app.subClases = [];
            app.mostrarClase = false;
            app.mostrarSubClase = false;
            this.grupoServicios_p = '';
            this.claseServicios_p = '';
            this.subClaseServicios_p = '';
            if(this.division_p == '' || this.division_p == division[0] || !app.mostrarGrupo)
            {
                app.mostrarGrupo = !app.mostrarGrupo;
            }
            
            if(app.mostrarGrupo)
            {
                //app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.division_p = division[0];
                axios.post('vue/ccp-bienestransportables.php?division='+this.division_p)
                    .then(function(response){
                        app.grupos = response.data.grupos;
                        if(response.data.grupos == ''){
                            app.mostrarGrupo = false;
                        }
                        else{
                            app.mostrarGrupo = true;
                        }
                    });
            }
            if(!scrollArriba)
            {
                setTimeout(function(){ document.getElementById("end_page").scrollIntoView({behavior: "smooth"}); }, 1)

            }
        },

        divisionServicios: function(seccion, scrollArriba = false)
        {
            this.searchDivisionServicios = {keywordDivisionServicios: ''};
            this.searchGrupoServicios = {keywordGrupoServicios: ''};
            this.searchClaseServicios = {keywordClaseServicios: ''};
            this.searchSubClaseServicios = {keywordSubClaseServicios: ''};
            app.divisionesServicios = [];
            app.gruposServicios = [];
            app.clasesServicios = [];
            app.subClasesServicios = [];
            this.divisionServicios_p = '';
            this.grupoServicios_p = '';
            this.claseServicios_p = '';
            this.subClaseServicios_p = '';
            app.mostrarGrupoServicios = false;
            app.mostrarClaseServicios = false;
            app.mostrarSubClaseServicios = false;
            
            this.seccionServicios_p = seccion[0];
            this.seccionServicios_p_nombre = seccion[1];

            axios.post('vue/ccp-servicios.php?seccion='+this.seccionServicios_p)
                .then(function(response){
                    app.divisionesServicios = response.data.divisiones;
                    if(response.data.divisiones == ''){
                        app.mostrarDivisionServicios = false;
                    }
                    else{
                        app.mostrarDivisionServicios = true;
                    }
                });
            
            if(!scrollArriba)
            {
                setTimeout(function(){ document.getElementById("end_page_servicios").scrollIntoView({block: "end", behavior: "smooth"}); }, 1)
            }
        },

        buscarGrupoServicios: function(division, scrollArriba = false)
        {
            this.searchGrupoServicios= {keywordGrupoServicios: ''};
            this.searchClaseServicios= {keywordClaseServicios: ''};
            this.searchSubClaseServicios = {keywordSubClaseServicios: ''};
            app.gruposServicios = [];
            app.clasesServicios = [];
            app.subClasesServicios = [];
            app.mostrarClaseServicios = false;
            app.mostrarSubClaseServicios = false;
            this.grupoServicios_p = '';
            this.claseServicios_p = '';
            this.subClaseServicios_p = '';
            if(this.divisionServicios_p == '' || this.divisionServicios_p == division[0] || !app.mostrarGrupoServicios)
            {
                app.mostrarGrupoServicios = !app.mostrarGrupoServicios;
            }
            
            if(app.mostrarGrupoServicios)
            {
                //app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.divisionServicios_p = division[0];
                axios.post('vue/ccp-servicios.php?division='+this.divisionServicios_p)
                    .then(function(response){
                        app.gruposServicios = response.data.grupos;
                        if(response.data.grupos == ''){
                            app.mostrarGrupoServicios = false;
                        }
                        else{
                            app.mostrarGrupoServicios = true;
                        }
                    });
            }
            if(!scrollArriba)
            {
                setTimeout(function(){ document.getElementById("end_page_servicios").scrollIntoView({behavior: "smooth"}); }, 1)

            }
        },

        buscarClaseServicios: function(grupo, scrollArriba = false)
        {
            this.searchClaseServicios= {keywordClaseServicios: ''};
            this.searchSubClaseServicios = {keywordSubClaseServicios: ''};
            app.clasesServicios = [];
            app.subClasesServicios = [];
            app.mostrarSubClaseServicios = false;
            this.claseServicios_p = '';
            this.subClaseServicios_p = '';
            //app.productos = [];
            if(this.grupoServicios_p == '' || this.grupoServicios_p == grupo[0] || !app.mostrarClaseServicios)
            {
                app.mostrarClaseServicios = !app.mostrarClaseServicios;
            }
            
            if(app.mostrarClaseServicios)
            {
                //app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.grupoServicios_p = grupo[0];
                axios.post('vue/ccp-servicios.php?grupo='+this.grupoServicios_p)
                    .then(function(response){
                        app.clasesServicios = response.data.clases;
                        if(response.data.clases == ''){
                            app.mostrarClaseServicios = false;
                        }
                        else{
                            app.mostrarClaseServicios = true;
                        }
                    });
            }
            if(!scrollArriba)
            {
                setTimeout(function(){ document.getElementById("end_page_servicios").scrollIntoView({behavior: "smooth"}); }, 1)

            }
        },

        buscarSubclaseServicios: function(clase, scrollArriba = false)
        {
            this.searchSubClaseServicios = {keywordSubClaseServicios: ''};
            //app.productos = [];
            app.subClasesServicios = [];
            this.subClaseServicios_p = '';
            if(this.claseServicios_p == '' || this.claseServicios_p == clase[0] || !app.mostrarSubClaseServicios)
            {
                app.mostrarSubClaseServicios = !app.mostrarSubClaseServicios;
            }
            
            if(app.mostrarSubClaseServicios)
            {
                //app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.claseServicios_p = clase[0];
                axios.post('vue/ccp-servicios.php?clase='+this.claseServicios_p)
                    .then(function(response){
                        app.subClasesServicios = response.data.subClases;
                        if(response.data.subClases == ''){
                            app.mostrarSubClaseServicios = false;
                        }
                        else{
                            app.mostrarSubClaseServicios = true;
                        }
                    });
            }
            if(!scrollArriba)
            {
                setTimeout(function(){ document.getElementById("end_page_servicios").scrollIntoView({behavior: "smooth"}); }, 1)

            }
        },

        seleccionarServicios: function(subClase){
            this.cuentasSelectSubClaseServicios = subClase;
            this.subClaseServicios_p = subClase[0];
        },

        seleccionarFuente: function(fuente){
            this.cuentasSelectFuentes = fuente;
            this.fuente_p = fuente[0];
        },

        searchMonitorBienes: function() {
            var keyword = app.toFormData(app.searchBienes);
            app.divisiones = [];
            app.grupos = [];
            app.clases = [];
            app.subClases = [];
            app.mostrarDivision = false;
            app.mostrarGrupo = false;
            app.mostrarClase = false;
            app.mostrarSubClase = false;
            this.searchDivision= {keywordDivision: ''};
            this.searchGrupo= {keywordGrupo: ''};
            this.searchClase= {keywordClase: ''};
            this.searchSubClase= {keywordSubClase: ''};
            axios.post('vue/ccp-bienestransportables.php?action=searchSeccion', keyword)
                .then(function(response){
                    
                    app.secciones = response.data.secciones;
                    if(response.data.secciones == ''){
                        app.noMember = true;
                        // app.show_table_search = false
                    }
                    else{
                        app.noMember = false;
                        //app.show_table_search = true
                    }
                    
                });
                
                
        },

        searchMonitorDivision: function() {
            var keywordDivision = app.toFormData(app.searchDivision);
            app.grupos = [];
            app.clases = [];
            app.subClases = [];
            app.mostrarGrupo = false;
            app.mostrarClase = false;
            app.mostrarSubClase = false;
            this.searchGrupo= {keywordGrupo: ''};
            this.searchClase= {keywordClase: ''};
            this.searchSubClase= {keywordSubClase: ''};
            axios.post('vue/ccp-bienestransportables.php?action=searchDivision&grupoSearch='+this.seccion_p, keywordDivision)
                .then(function(response){
                    
                    app.divisiones = response.data.divisiones;   
                    if(response.data.divisiones == ''){
                        app.noMember = true;
                        // app.show_table_search = false
                    }
                    else{
                        app.noMember = false;
                        //app.show_table_search = true
                    }
                    
                });
                
                
        },

        searchMonitorGrupos: function() {
            var keywordGrupo = app.toFormData(app.searchGrupo);
            app.clases = [];
            app.subClases = [];
            app.mostrarClase = false;
            app.mostrarSubClase = false;
            this.searchClase= {keywordClase: ''};
            this.searchSubClase= {keywordSubClase: ''};
            axios.post('vue/ccp-bienestransportables.php?action=searchGrupo&divisionSearch='+this.division_p, keywordGrupo)
                .then(function(response){
                    app.grupos = response.data.grupos;
                    if(response.data.grupos == ''){
                        app.noMember = true;
                        // app.show_table_search = false
                    }
                    else{
                        app.noMember = false;
                        //app.show_table_search = true
                    }
                    
                });
                
                
        },

        searchMonitorClases: function() {
            var keywordClase = app.toFormData(app.searchClase);
            app.subClases = [];
            app.mostrarSubClase = false;
            this.searchSubClase= {keywordSubClase: ''};
            axios.post('vue/ccp-bienestransportables.php?action=searchClase&grupoSearch='+this.grupo_p, keywordClase)
                .then(function(response){
                    app.clases = response.data.clases;
                    if(response.data.clases == ''){
                        app.noMember = true;
                        // app.show_table_search = false
                    }
                    else{
                        app.noMember = false;
                        //app.show_table_search = true
                    }
                    
                });
                
                
        },

        searchMonitorSubClases: function() {
            var keywordSubClase = app.toFormData(app.searchSubClase);
            axios.post('vue/ccp-bienestransportables.php?action=searchSubClase&subClaseSearch='+this.clase_p, keywordSubClase)
                .then(function(response){
                    app.subClases = response.data.subClases;
                    if(response.data.subClases == ''){
                        app.noMember = true;
                        // app.show_table_search = false
                    }
                    else{
                        app.noMember = false;
                        //app.show_table_search = true
                    }
                    
                });
                
                
        },

        searchMonitorFuente: function() {
            var keywordFuente = app.toFormData(app.searchFuente);
            //console.log('aqui entra' + keywordFuente);
            axios.post('vue/ccp-crearpresupuestoingresos.php?action=searchFuente', keywordFuente)
                .then(function(response){
                    app.fuentes = response.data.codigos;
                    if(response.data.codigos == ''){
                        app.noMember = true;
                        // app.show_table_search = false
                    }
                    else{
                        app.noMember = false;
                        //app.show_table_search = true
                    }
                    
                });
                
                
        },

        buscarClase: function(grupo, scrollArriba = false)
        {
            this.searchClase= {keywordClase: ''};
            this.searchSubClase= {keywordSubClase: ''};
            app.clases = [];
            app.subClases = [];
            app.mostrarSubClase = false;
            app.searchProduct = {keywordProduct: ''};
            this.clase_p = '';
            this.clase_p_nombre = '';
            this.subClase_p = '';
            this.subClase_p_nombre = '';
            //app.productos = [];
            if(this.grupo_p == '' || this.grupo_p == grupo[0] || !app.mostrarClase)
            {
                app.mostrarClase = !app.mostrarClase;
            }
            
            if(app.mostrarClase)
            {
                //app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.grupo_p = grupo[0];
                this.grupo_p_nombre = grupo[1];
                axios.post('vue/ccp-bienestransportables.php?grupo='+this.grupo_p)
                    .then(function(response){
                        app.clases = response.data.clases;
                        if(response.data.clases == ''){
                            app.mostrarClase = false;
                        }
                        else{
                            app.mostrarClase = true;
                        }
                    });
            }
            if(!scrollArriba)
            {
                setTimeout(function(){ document.getElementById("end_page").scrollIntoView({behavior: "smooth"}); }, 1)

            }
        },

        buscarSubclase: function(clase, scrollArriba = false)
        {
            this.searchSubClase= {keywordSubClase: ''};
            //app.productos = [];
            app.subClases = [];
            this.subClase_p = '';
            this.subClase_p_nombre = '';
            if(this.clase_p == '' || this.clase_p == clase[0] || !app.mostrarSubClase)
            {
                app.mostrarSubClase = !app.mostrarSubClase;
            }
            
            if(app.mostrarSubClase)
            {
                //app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.clase_p = clase[0];
                this.clase_p_nombre = clase[1];
                axios.post('vue/ccp-bienestransportables.php?clase='+this.clase_p)
                    .then(function(response){
                        app.subClases = response.data.subClases;
                        if(response.data.subClases == ''){
                            app.mostrarSubClase = false;
                        }
                        else{
                            app.mostrarSubClase = true;
                        }
                    });
            }
            if(!scrollArriba)
            {
                setTimeout(function(){ document.getElementById("end_page").scrollIntoView({behavior: "smooth"}); }, 1)

            }
        },

        seleccionarSublaseProducto: async function(subClase, scrollArriba = false)
        {
            //this.showModal = !this.showModal;
            this.subClase_p = subClase[0];
            this.subClase_p_nombre = subClase[1];

            await axios.post('vue/ccp-bienestransportables.php?subClase='+this.subClase_p)
            .then(function(response){
                app.subClases_captura = response.data.subClases_captura;
                if(response.data.subClases_captura == ''){
                    app.mostrarSubClaseProducto = false;
                }
                else{
                    app.mostrarSubClaseProducto = true;
                }
            });
            if(!scrollArriba)
            {
                setTimeout(function(){ document.getElementById("end_page").scrollIntoView({behavior: "smooth"}); }, 1)

            }
        },

        buscarIngresos: function(){
            axios.post('vue/ccp-crearpresupuestoingresos.php?vigencia='+this.vigencia + '&unidadEjecutora='+this.selected + '&medioPago='+this.selectMedioPago)
                .then((response) => {
                    app.ingresos = response.data.ingresos;
                    console.log(response.data);
                    app.valorIngresoCuenta = response.data.valorPorCuenta;
                    if(app.ingresos == ''){
                        app.mostrar_resultados_ingresos = false;
                    }else{
                        app.mostrar_resultados_ingresos = true;
                        this.fetchMembersUnidadEjecutora();
                    }
                });
        },

        searchMonitor: function(){
            var keyword = app.toFormData(app.search);
            axios.post('vue/ccp-crearpresupuestoingresos.php?action=search', keyword)
                .then(function(response){
                    app.ingresos = response.data.ingresosBuscados;
                    if(response.data.ingresosBuscados == ''){
                        app.mostrar_resultados_ingresos = false;
                    }
                    else{
                        app.mostrar_resultados_ingresos = true;
                    }                    
                });
        },

        searchMonitorCuin: function() {
            var parsedobj = JSON.parse(JSON.stringify(app.searchCuin))
            if(parsedobj.keywordCuin == '')
            {
                this.buscaVentanaModal();
            }
            else{
                app.show_table_search = false
                var keyword = app.toFormData(app.searchCuin);
                //console.log(keyword);
                axios.post('vue/ccp-cuin.php?action=search', keyword)
                    .then(function(response){
                        
                        app.resultsCuin = response.data.codigos;
                        //console.log(response.data);
                        if(response.data.codigos == ''){
                            
                        }
                        else{
                            app.show_table_search = true
                        }
                        
                    });
                setTimeout(() => {
                    document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
                }, 50);
                app.searchCuin.keywordCuin = '';
            }
        },



        toFormData: function(obj){
            var form_data = new FormData();
            for(var key in obj){
                form_data.append(key, obj[key]);
            }
            return form_data;
        },

        agregarPresupuesto: async function(cuenta){
            if(this.vigencia != 0 && this.vigencia != ''){
                this.cuin_p = '';
                this.cuentaActual = '';
                this.cuentaActual = cuenta;
                this.valorTotal = 0;
                this.valorTotalBienes = 0;
                this.cuentasCuinAgr = [];
                this.cuentasSubClaseAgr = [];
                await axios.post('vue/ccp-crearpresupuestoingresos.php?action=buscarClasificadores&cuentaIngreso=' + cuenta)
                    .then(function(response){
                        app.clasificadores = response.data.clasificadores;
                        //console.log(response.data.clasificadores);
                        if(response.data.ingresosBuscados == ''){
                            app.mostrar_resultados_ingresos = false;
                        }
                        else{
                            app.mostrar_resultados_ingresos = true;
                        }                    
                    });
                //var parsedobj = JSON.parse(JSON.stringify(this.clasificadores));
                //var partes = parsedobj[0].toString().split(',');
                //console.log(partes[0]);
                //this.buscaVentanaModal(1);
                this.buscarFuente();
            }else{
                alert('Falta digitar la vigencia');
            }
        },

        buscarFuente: function(){
            
            this.fuente_p = '';
            this.cuentasSelectFuentes = [];
            this.showModal_fuentes = true;
            this.showModal_servicios = false;
            this.showModal_bienes_transportables = false;
            this.showModal_Solo_Presupuesto = false;
            app.show_table_search = false;
            this.fetchMembersFuente();
            this.valorFuenteCSF();
            this.valorFuenteSSF();
            app.show_table_search = true;
            //this.verificarUnidadEjecutoraAgr();
        },

        continuar: function(){
            this.cuentasSubClaseAgr = [];
            this.cuentasSubClaseServiciosAgr = [];
            if(this.cuentasSelectFuentes.length > 0){
                this.showModal_fuentes = false;
                if(this.clasificadores[0] != '' && this.clasificadores[0] != undefined){
                    var parsedobj = JSON.parse(JSON.stringify(this.clasificadores));
                    var partes = parsedobj[0].toString().split(',');
                    this.buscaVentanaModal(partes[0]);
                }else{
                    this.buscaVentanaModal("0");
                }
                

            }else{
                alert('Falta seleccionar la fuente');
            }
        },


        buscaVentanaModal: async function(clasificador){
            switch (clasificador){
                case "0":
                    this.showModal_Solo_Presupuesto = true;
                    this.verificarValorSolo();
                break;
                case "1":
                    this.showModal = true;
                    app.show_table_search = false
                    await axios.post('vue/ccp-crearpresupuestoingresos.php?action=cuin')
                    .then(function(response){
                        app.resultsCuin = response.data.codigos;
                        app.show_table_search = true
                        app.show_table_search = true
                        //console.log(response.data.codigos_count);
                    });
                    this.verificarCuinAgr();
                break;
                case "2":
                    this.showModal_bienes_transportables = true;
                    app.show_table_search = false;
                    this.fetchMembersBienes();
                    var ultimoCaracter = this.cuentaActual.substr(-1,1);
                    var cuentaArr = [];
                    cuentaArr[0] = ultimoCaracter;
                    cuentaArr[1] = "nombre";
                    //console.log(cuentaArr);
                    this.division(cuentaArr);
                    app.show_table_search = true
                    this.verificarBienesAgr();
                break;
                case "3":
                    this.showModal_servicios = true;
                    app.show_table_search = false;
                    this.fetchMembersServicios();
                    var ultimoCaracter = this.cuentaActual.substr(-1,1);
                    var cuentaArr = [];
                    cuentaArr[0] = ultimoCaracter;
                    cuentaArr[1] = "nombre";
                    //console.log(cuentaArr);
                    this.divisionServicios(cuentaArr);
                    app.show_table_search = true
                    this.verificarServiciosAgr();
                break;
                default:
                    this.showModal_clasificador = true;
                    this.clasificadorActual = clasificador;
                    await axios.post('vue/ccp-crearpresupuestoingresos.php?action=clasificador&clas='+clasificador)
                    .then(function(response){
                        app.resultsClasificador = response.data.codigos;
                        //console.log(response.data.codigos);
                        app.show_table_search = true;
                        //console.log(response.data.codigos_count);
                    });
                    this.verificarClasificadorAgr();
                break;
            }
        },

        verificarCuinAgr: async function(){
            //console.log(this.resultsCuin);
            await axios.post('vue/ccp-crearpresupuestoingresos.php?action=searchCuentaAgrCuin&cuentaAgr=' + this.cuentaActual + '&fuente=' + this.cuentasSelectFuentes[0] + '&unidadEjecutora=' + this.selected + '&medioPago='+this.selectMedioPago + '&vigencia='+this.vigencia)
            .then((response) => {
                
                app.verResultsCuin = response.data.codigos;
                app.verResultsCuinEliminar = response.data.codigosEliminar;
                app.valorTotal = response.data.valorTotal;
                //console.log(response.data);
                if(response.data.codigos == ''){
                    
                }
                else{
                    //app.show_table_search = true
                }
            });

            for(i=0; i < this.verResultsCuin.length; i++){
                this.cuentasCuinAgr.push(this.verResultsCuin[i]);
                //console.log(this.verResultsCuinEliminar[i]);
                this.removeItemFromArr(this.verResultsCuinEliminar[i]);
                //this.removeItemFromArrCuin(this.verResultsCuin[i]);
            }
            //console.log(this.verResultsCuin);
        },

        verificarClasificadorAgr: async function(){
            this.cuentasClasificadorAgr = [];
            await axios.post('vue/ccp-crearpresupuestoingresos.php?action=searchCuentaAgrClasificador&cuentaAgr=' + this.cuentaActual + '&fuente=' + this.cuentasSelectFuentes[0] + '&unidadEjecutora=' + this.selected + '&medioPago='+this.selectMedioPago + '&vigencia='+this.vigencia)
            .then((response) => {
                
                app.verResultsClasificador = response.data.codigos;
                app.valorTotalClasificador = response.data.valorTotal;
                //console.log(response.data);
                if(response.data.codigos == ''){
                    
                }
                else{
                    //app.show_table_search = true
                }
            });

            for(i=0; i < this.verResultsClasificador.length; i++){
                this.cuentasClasificadorAgr.push(this.verResultsClasificador[i]);
            }
        },

        verificarBienesAgr: async function(){
            //console.log(this.cuentasSelectFuentes);
            await axios.post('vue/ccp-crearpresupuestoingresos.php?action=searchCuentaAgr&cuentaAgr=' + this.cuentaActual + '&fuente=' + this.cuentasSelectFuentes[0] + '&unidadEjecutora=' + this.selected + '&medioPago='+this.selectMedioPago + '&vigencia='+this.vigencia)
            .then((response) => {
                
                app.verResultsbienes = response.data.codigos;
                //console.log(response.data);
                //app.verResultsCuinEliminar = response.data.codigosEliminar;
                app.valorTotalBienes = response.data.valorTotal;
                if(response.data.codigos == ''){
                    
                }
                else{
                    app.show_table_search = true
                }
            });
            for(i=0; i < this.verResultsbienes.length; i++){
                this.cuentasSubClaseAgr.push(this.verResultsbienes[i]);
                //this.removeItemFromArr(this.verResultsCuinEliminar[i]);
                //this.removeItemFromArrCuin(this.verResultsCuin[i]);
            }
        },

        verificarServiciosAgr: async function(){
            await axios.post('vue/ccp-crearpresupuestoingresos.php?action=searchCuentaServiciosAgr&cuentaAgr=' + this.cuentaActual + '&fuente=' + this.cuentasSelectFuentes[0] + '&unidadEjecutora=' + this.selected + '&medioPago='+this.selectMedioPago + '&vigencia='+this.vigencia)
            .then((response) => {
                
                app.verResultsServicios = response.data.codigos;
                //app.verResultsCuinEliminar = response.data.codigosEliminar;
                app.valorTotalServicios = response.data.valorTotalServicios;
                if(response.data.codigos == ''){
                    
                }
                else{
                    app.show_table_search = true
                }
            });
            for(i=0; i < this.verResultsServicios.length; i++){
                this.cuentasSubClaseServiciosAgr.push(this.verResultsServicios[i]);
                //this.removeItemFromArr(this.verResultsCuinEliminar[i]);
                //this.removeItemFromArrCuin(this.verResultsCuin[i]);
            }
        },

        verificarValorSolo: async function(){
            await axios.post('vue/ccp-crearpresupuestoingresos.php?action=searchValorSolo&cuentaAgr=' + this.cuentaActual + '&fuente=' + this.cuentasSelectFuentes[0] + '&unidadEjecutora=' + this.selected + '&medioPago='+this.selectMedioPago + '&vigencia='+this.vigencia)
            .then((response) => {
                app.valorSolo = response.data.valor;
                //console.log(response.data);
                if(response.data.valor == ''){
                    
                }
                else{
                    app.show_table_search = true
                }
            });
        },

        seleccionarCuin: function(cuin){
            this.cuentasSelectCuin = [];
            this.cuin_p = '';
            this.cuentasSelectCuin = cuin;
            
            this.cuin_p = cuin[2];
        },

        seleccionarClasificador: function(clasificador){
            if(clasificador[2] == 'C'){
                this.SelectClasificador = [];
                this.clasificador_p = '';
                this.SelectClasificador = clasificador;
                this.clasificador_p = clasificador[0];
            }            
        },

        seleccionarBienes: function(subClase){
            /*this.cuentasSelectSubClase = [];
            this.cuin_p = '';*/
            this.cuentasSelectSubClase = subClase;
            
            //this.cuin_p = cuin[2];

            this.subClase_p = subClase[0];
            this.subClase_p_nombre = subClase[1];
        },

        agregaBienesTranspotables: function(){
            if(this.cuentasSelectSubClase.length > 0)
            {
                if(this.valorBienesTranspotables > 0){
                    this.searchDivision = {keywordDivision: ''};
                    this.searchGrupo = {keywordGrupo: ''};
                    this.searchClase = {keywordClaseServicios: ''};
                    this.searchSubClase = {keywordSubClase: ''};
                    app.grupos = [];
                    app.clases = [];
                    app.subClases = [];
                    this.division_p = '';
                    this.seccion_p = '';
                    this.grupo_p = '';
                    this.clase_p = '';
                    this.subClase_p = '';
                    app.mostrarGrupo = false;
                    app.mostrarClase = false;
                    app.mostrarSubClase = false;
                    app.mostrarSubClaseProducto = false;
                    this.cuentasSelectSubClase.push(this.valorBienesTranspotables);
                    this.cuentasSubClaseAgr.push(this.cuentasSelectSubClase);
                    ///this.removeItemFromArr(this.cuentasSelectSubClase);
                    this.cuentasSelectSubClase = [];
                    this.cuin_p = '';
                    this.valorTotalBienes = parseFloat(this.valorTotalBienes) + parseFloat(this.valorBienesTranspotables);
                    this.valorBienesTranspotables = 0;
                }else{
                    alert('Falta digitar valor');
                }
                
            }
            else{
                alert('Falta seleccionar la cuenta');
            }
        },

        agregaServicios: function(){
            if(this.cuentasSelectSubClaseServicios.length > 0)
            {
                if(this.valorServicios > 0){
                    this.searchDivisionServicios = {keywordDivisionServicios: ''};
                    this.searchGrupoServicios = {keywordGrupoServicios: ''};
                    this.searchClaseServicios = {keywordClaseServicios: ''};
                    this.searchSubClaseServicios = {keywordSubClaseServicios: ''};
                    app.gruposServicios = [];
                    app.clasesServicios = [];
                    app.subClasesServicios = [];
                    this.seccionServicios_p = '';
                    this.divisionServicios_p = '';
                    this.grupoServicios_p = '';
                    this.claseServicios_p = '';
                    this.subClaseServicios_p = '';
                    app.mostrarGrupoServicios = false;
                    app.mostrarClaseServicios = false;
                    app.mostrarSubClaseServicios = false;

                    this.cuentasSelectSubClaseServicios.push(this.valorServicios);
                    this.cuentasSubClaseServiciosAgr.push(this.cuentasSelectSubClaseServicios);
                    ///this.removeItemFromArr(this.cuentasSelectSubClase);
                    this.cuentasSelectSubClaseServicios = [];
                    this.cuin_p = '';
                    this.valorTotalServicios = parseFloat(this.valorTotalServicios) + parseFloat(this.valorServicios);
                    this.valorServicios = 0;
                }else{
                    alert('Falta digitar valor');
                }
                
            }
            else{
                alert('Falta seleccionar la cuenta');
            }
        },

        eliminarBienes: function(cuenta){
            this.valorTotalBienes = parseFloat(this.valorTotalBienes) - parseFloat(cuenta[5]);
            var i = cuenta.indexOf( cuenta[5] );
         
            if ( i !== -1 ) {
                cuenta.splice( i, 1 );
            }


            //this.resultsCuin.unshift(cuenta);
            this.removeItemFromArrBienes(cuenta);

        },

        eliminarServicios: function(cuenta){
            this.valorTotalServicios = parseFloat(this.valorTotalServicios) - parseFloat(cuenta[4]);
            var i = cuenta.indexOf( cuenta[4] );
         
            if ( i !== -1 ) {
                cuenta.splice( i, 1 );
            }


            //this.resultsCuin.unshift(cuenta);
            this.removeItemFromArrServicios(cuenta);

        },

        agregaCuin: function(){
            //console.log(this.cuentasSelectCuin.length);
            if(this.cuentasSelectCuin.length > 0)
            {
                if(this.valorCuin > 0){
                    
                    this.cuentasSelectCuin.push(this.valorCuin);
                    //console.log(this.cuentasSelectCuin);
                    this.cuentasCuinAgr.push(this.cuentasSelectCuin);
                    this.removeItemFromArr(this.cuentasSelectCuin);
                    this.cuentasSelectCuin = [];
                    this.cuin_p = '';
                    this.valorTotal = parseFloat(this.valorTotal) + parseFloat(this.valorCuin);
                    this.valorCuin = 0;
                }else{
                    alert('Falta digitar valor');
                }
                
            }
            else{
                alert('Falta seleccionar la cuenta');
            }
        },

        agregaClasificador: function(){
            //console.log(this.cuentasSelectCuin.length);
            if(this.SelectClasificador.length > 0)
            {
                if(this.valorClasificador > 0){
                    
                    this.SelectClasificador.push(this.valorClasificador);
                    //console.log(this.cuentasSelectCuin);
                    this.cuentasClasificadorAgr.push(this.SelectClasificador);
                    this.SelectClasificador = [];
                    this.clasificador_p = '';
                    this.valorTotalClasificador = parseFloat(this.valorTotalClasificador) + parseFloat(this.valorClasificador);
                    this.valorClasificador = 0;
                }else{
                    alert('Falta digitar valor');
                }
                
            }
            else{
                alert('Falta seleccionar la cuenta');
            }
        },

        eliminarCuin: function(cuenta){
            //cuenta.remove(cuenta[15]);
            this.valorTotal = parseFloat(this.valorTotal) - parseFloat(cuenta[15]);
            var i = cuenta.indexOf( cuenta[15] );
         
            if ( i !== -1 ) {
                cuenta.splice( i, 1 );
            }


            this.resultsCuin.unshift(cuenta);
            this.removeItemFromArrCuin(cuenta);

        },

        eliminarClasificador: function(cuenta){
            //cuenta.remove(cuenta[15]);
            this.valorTotalClasificador = parseFloat(this.valorTotalClasificador) - parseFloat(cuenta[3]);
            var i = cuenta.indexOf( cuenta[3] );
         
            if ( i !== -1 ) {
                cuenta.splice( i, 1 );
            }
            this.removeItemFromArrClasificador(cuenta);

        },

        removeItemFromArr: function(item){
            var i = this.resultsCuin.indexOf( item );
            if ( i !== -1 ) {
                this.resultsCuin.splice( i, 1 );
            }
        },

        removeItemFromArrCuin: function(item){
            var i = this.cuentasCuinAgr.indexOf( item );
         
            if ( i !== -1 ) {
                this.cuentasCuinAgr.splice( i, 1 );
            }
        },

        removeItemFromArrClasificador: function(item){
            var i = this.cuentasClasificadorAgr.indexOf( item );
         
            if ( i !== -1 ) {
                this.cuentasClasificadorAgr.splice( i, 1 );
            }
        },

        removeItemFromArrBienes: function(item){
            var i = this.cuentasSubClaseAgr.indexOf( item );
         
            if ( i !== -1 ) {
                this.cuentasSubClaseAgr.splice( i, 1 );
            }
        },

        guardarCuin: function(){

            var formData = new FormData();

            for(i = 0; i < this.cuentasCuinAgr.length; i++){
                formData.append("cuentasCuin[]", this.cuentasCuinAgr[i]);
            }

            formData.append("cuentaPresupuestal", this.cuentaActual);
            formData.append("fuente", this.cuentasSelectFuentes[0]);
            formData.append("unidadEjecutora", this.selected);
            formData.append("medioPago", this.selectMedioPago);
            formData.append("valorTotal", this.valorTotal);
            formData.append("vigencia", this.vigencia);
            //formData.append("cuentas", datosjeison);
            //var cuentaAct = this.cuentaActual;
            //console.log(this.valorIngresoCuenta);
            axios.post('vue/ccp-crearpresupuestoingresos.php?action=guardarCuin',
                    formData
                )
                .then(function(response){
                    //console.log(response.data);
                    //console.log(response.data.insertaBien);
                    
                    if(response.data.insertaBien){
                        app.buscarIngresos();
                        app.showModal = false;
                    }
            });
            
            
        },

        guardarClasificador: function(){

            var formData = new FormData();

            for(i = 0; i < this.cuentasClasificadorAgr.length; i++){
                formData.append("cuentasClasificador[]", this.cuentasClasificadorAgr[i]);
            }

            formData.append("cuentaPresupuestal", this.cuentaActual);
            formData.append("fuente", this.cuentasSelectFuentes[0]);
            formData.append("unidadEjecutora", this.selected);
            formData.append("medioPago", this.selectMedioPago);
            formData.append("valorTotalClasificador", this.valorTotalClasificador);
            formData.append("vigencia", this.vigencia);
            formData.append("id_clasificador", this.clasificadorActual);
            //formData.append("cuentas", datosjeison);
            //var cuentaAct = this.cuentaActual;
            //console.log(this.valorIngresoCuenta);
            axios.post('vue/ccp-crearpresupuestoingresos.php?action=guardarClasificador',
                    formData
                )
                .then(function(response){
                    //console.log(response.data);
                    //console.log(response.data.insertaBien);
                    
                    if(response.data.insertaBien){
                        app.buscarIngresos();
                        app.showModal_clasificador = false;
                    }
            });
            
            
        },

        guardarBienes: function(){

            var formData = new FormData();

            for(i = 0; i < this.cuentasSubClaseAgr.length; i++){

                //this.cuentasSubClaseAgr[i][1].replace(/,/g, "");
                var cuentaAgrSub = [];
                cuentaAgrSub.push(this.cuentasSubClaseAgr[i][0]);
                cuentaAgrSub.push(this.cuentasSubClaseAgr[i][3]);

                formData.append("cuentasSubclase[]", cuentaAgrSub);
            }
            
            formData.append("cuentaPresupuestal", this.cuentaActual);
            formData.append("valorTotal", this.valorTotalBienes);
            formData.append("fuente", this.cuentasSelectFuentes[0]);
            formData.append("unidadEjecutora", this.selected);
            formData.append("medioPago", this.selectMedioPago);
            formData.append("vigencia", this.vigencia);
            //formData.append("cuentas", datosjeison);
            //var cuentaAct = this.cuentaActual;
            axios.post('vue/ccp-crearpresupuestoingresos.php?action=guardarBienes',
                    formData
                )
                .then(function(response){
                    if(response.data.insertaBien){
                        app.buscarIngresos();
                        app.showModal_bienes_transportables = false;
                    }
            });
            
            
        },

        guardarServicios: function(){

            var formData = new FormData();

            for(i = 0; i < this.cuentasSubClaseServiciosAgr.length; i++){
                var cuentaAgrSub = [];
                cuentaAgrSub.push(this.cuentasSubClaseServiciosAgr[i][0]);
                cuentaAgrSub.push(this.cuentasSubClaseServiciosAgr[i][4]);
                

                formData.append("cuentasSubclaseServicios[]", cuentaAgrSub);
            }
            
            formData.append("cuentaPresupuestal", this.cuentaActual);
            formData.append("valorTotalServicios", this.valorTotalServicios);
            formData.append("fuente", this.cuentasSelectFuentes[0]);
            formData.append("unidadEjecutora", this.selected);
            formData.append("medioPago", this.selectMedioPago);
            formData.append("vigencia", this.vigencia);
            //formData.append("cuentas", datosjeison);
            //var cuentaAct = this.cuentaActual;
            axios.post('vue/ccp-crearpresupuestoingresos.php?action=guardarServicios',
                    formData
                )
                .then(function(response){
                    if(response.data.insertaBien){
                        app.buscarIngresos();
                        app.showModal_servicios = false;
                    }
            });
        },

        guardarValorSolo: function(){

            var formData = new FormData();
            formData.append("cuentaPresupuestal", this.cuentaActual);
            formData.append("fuente", this.cuentasSelectFuentes[0]);
            formData.append("unidadEjecutora", this.selected);
            formData.append("valorSolo", this.valorSolo);
            formData.append("medioPago", this.selectMedioPago);
            formData.append("vigencia", this.vigencia);
            //formData.append("cuentas", datosjeison);
            //var cuentaAct = this.cuentaActual;
            axios.post('vue/ccp-crearpresupuestoingresos.php?action=guardarValorSolo',
                    formData
                )
                .then(function(response){
                    if(response.data.insertaBien){
                        app.buscarIngresos();
                        app.showModal_Solo_Presupuesto = false;
                    }
            });
            
            
        },


        valorFuenteCSF: function(){
            var formData = new FormData();
            formData.append("cuentaPresupuestal", this.cuentaActual);
            formData.append("unidadEjecutora", this.selected);
            formData.append("medioPago", this.selectMedioPago);
            formData.append("vigencia", this.vigencia);
            //console.log(this.cuentaActual);
            //formData.append("cuentas", datosjeison);
            //var cuentaAct = this.cuentaActual;
            this.valorGastoCSF = [];
            axios.post('vue/ccp-crearpresupuestoingresos.php?action=varlorFuenteCSF',
                    formData
                )
                .then(function(response){
                    //console.log(response.data);
                    app.valorGastoCSF = response.data.valor
                    if(response.data.valor){
                        //app.buscarGastos();
                        //app.showModal_Solo_Presupuesto = false;
                    }
            });
            
        },
        valorFuenteSSF: function(){
            var formData = new FormData();
            formData.append("cuentaPresupuestal", this.cuentaActual);
            formData.append("unidadEjecutora", this.selected);
            formData.append("medioPago", this.selectMedioPago);
            formData.append("vigencia", this.vigencia);
            //formData.append("cuentas", datosjeison);
            //var cuentaAct = this.cuentaActual;
            this.valorGastoSSF = [];
            axios.post('vue/ccp-crearpresupuestoingresos.php?action=varlorFuenteSSF',
                    formData
                )
                .then(function(response){
                    app.valorGastoSSF = response.data.valor
                    if(response.data.valor){
                        //app.buscarGastos();
                        //app.showModal_Solo_Presupuesto = false;
                    }
            });
            
        }
    },
});