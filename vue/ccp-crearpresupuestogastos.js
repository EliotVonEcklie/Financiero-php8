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
        seccion_p: '',
        seccionServicios_p: '',
        seccion_p_nombre: '',
        seccionServicios_p_nombre: '',
        division_p: '',
        divisionServicios_p: '',
        division_p_nombre: '',
        grupo_p: '',
        grupoServicios_p: '',
        grupo_p_nombre: '',
        clase_p: '',
        claseServicios_p: '',
        clase_p_nombre: '',
        subClase_p: '',
        subClaseServicios_p: '',
        subClase_p_nombre: '',
        fuente_p: '',
        selected: '01',
        mostrarDivision: false,
        mostrarGrupo: false,
        mostrarGrupoServicios: false,
        mostrarClase: false,
        mostrarClaseServicios: false,
        mostrarSubClase: false,
        mostrarSubClaseServicios: false,
        mostrarSubClaseProducto: false,
        gastos: [],
        clasificadores: [],
        resultsCuin: [],
        verResultsCuin: [],
        verResultsBienes: [],
        verResultsServicios: [],
        verResultsCuinEliminar: [],
        cuentasSubClaseAgr: [],
        cuentasSubClaseServiciosAgr: [],
        cuentasSelectSubClase: [],
        cuentasSelectSubClaseServicios: [],
        cuentasSelectFuentes: [],
        valorIngresoCuenta: [],
        valorGastoCSF: [],
        valorGastoSSF: [],
        cuin_p: '',
        mostrar_resultados_gastos: false,
        search: {keyword: ''},
        searchCuin : {keywordCuin: ''},
        showModal: false,
        show_table_search: false,
        showModal_bienes_transportables: false,
        showModal_servicios: false,
        showModal_fuentes: false,
        showModal_Solo_Presupuesto: false,
        valorBienesTranspotables: 0,
        valorServicios: 0,
        valorTotal: 0,
        valorTotalServicios: 0,
        valorSolo: 0,
        vigencia: 0,
        searchBienes: {keyword: ''},
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
        mostrarSeccion: true,
        mostrarSeccionServicios: true,
        mostrarDivisionServicios: false,
        cuentaActual: ''
    },
    mounted: function(){
        this.buscarGastos();
    },
    methods: {

        show_levels: function(codigo){
            
            app.mostrarSeccion = true;
            codigo_final = codigo[0];
            
            //this.subClase_p = codigo_final;
            //console.log(this.subClase_p);
            codigo_subClase = codigo_final.slice(0,-2);  
            codigo_Clase = codigo_subClase.slice(0,-1); 
            codigo_grupo = codigo_Clase.slice(0,-1);
            codigo_division = codigo_grupo.slice(0,-1);
            codigo_seccion = codigo_division.slice(0,-1);
            this.searchHastaSubclase(codigo_final, codigo_subClase, codigo_Clase, codigo_grupo, codigo_division, codigo_seccion, codigo[5]);            
            // else{
            //     console.log(" Este item es de otro nivel! el nivel es " + codigo[4])
            // }
            /*setTimeout(() => {
                const start_page = document.getElementById("start_page").scrollIntoView({behavior: 'smooth'});  
            }, 50);*/

        },

        searchHastaSubclase: async function(codigo_final, codigo_subClase, codigo_Clase, codigo_grupo, codigo_division, codigo_seccion, ud)
        {
            app.secciones = [];
            app.divisiones = [];
            app.grupos = [];
            app.clases = [];
            app.subClases = [];

            this.seccion_general = [];
            this.division_general = [];
            this.grupo_general = [];
            this.clase_general = [];
            this.subClase_general = [];
            this.producto_general = [];

            this.seccion_p = codigo_seccion;

            this.fetchMembersBienes();

            // aqui empieza a buscar la seccion 
            //var seccion_nombre_buscar =  await this.buscarNombre(this.seccion_p);

            this.seccion_general.push(this.seccion_p);
            //console.log(codigo_seccion);
            //this.seccion_general.push(seccion_nombre_buscar);
            //console.log(this.seccion_general);
            this.division(this.seccion_general, false);
            // aqui termina

            //aqui empiza a buscar el nombre de la division
            //var seccion_nombre_buscar =  await this.buscarNombre(codigo_division);

            this.division_general.push(codigo_division);
            //this.division_general.push(seccion_nombre_buscar);
            //console.log(this.division_general);
            this.buscarGrupo(this.division_general, false);
            //qui termina
            //aqui empiza a buscar el nombre del grupo
            //var seccion_nombre_buscar =  await this.buscarNombre(codigo_grupo);

            this.grupo_general.push(codigo_grupo);
            //this.grupo_general.push(seccion_nombre_buscar);

            this.buscarClase(this.grupo_general, false);
            //aqui termina
            //aqui empiza a buscar el nombre de la clase
            //var seccion_nombre_buscar =  await this.buscarNombre(codigo_Clase);

            this.clase_general.push(codigo_Clase);
            //this.clase_general.push(seccion_nombre_buscar);

            this.buscarSubclase(this.clase_general, false);
            //console.log(codigo_final);
            

            this.producto_general.push(codigo_subClase);
            //this.producto_general.push(seccion_nombre_buscar);

            this.seleccionarSublaseProducto(this.producto_general);

            var seccion_nombre_buscar =  await this.buscarNombre(codigo_final);
            this.cuentasSelectSubClase.push(codigo_final);
            this.cuentasSelectSubClase.push(seccion_nombre_buscar);
            this.cuentasSelectSubClase.push(ud);

            this.seleccionarBienes(this.cuentasSelectSubClase);
            
            //aqui termina
            //this.subClase_p = codigo_subClase;

           this.searchGeneral = {keywordGeneral: ''};
        },

        buscarNombre: async function(codigo_buscar){
            await axios.post('vue/ccp-bienestransportables.php?action=buscaNombre', 
            JSON.stringify({
                name: codigo_buscar
                })
            )
            .then((response)  => {
                this.codigo_buscar_nombre = response.data.nombreCodigo;
                //console.log(this.codigo_buscar_nombre);
            });
            //console.log(this.codigo_buscar_nombre);
            //var parsedobj = JSON.parse(JSON.stringify(this.codigo_buscar_nombre))
            //console.log(parsedobj);
            return this.codigo_buscar_nombre;
        },

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
            //console.log('dddddd' + seccion[0]);
            //console.log(this.seccion_p);
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
            //this.subClase_p = '';
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
            //console.log(this.divisiones);
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
            axios.post('vue/ccp-crearpresupuestogastos.php?action=searchFuente', keywordFuente)
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
            //this.subClase_p = '';
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
            //this.subClase_p = '';
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

        buscarGastos: async function(){
            await axios.post('vue/ccp-crearpresupuestogastos.php?vigencia='+this.vigencia + '&unidadEjecutora='+this.selected + '&medioPago='+this.selectMedioPago)
                .then((response) => {
                    app.gastos = response.data.gastos;
                    app.valorIngresoCuenta = response.data.valorPorCuenta;
                    if(app.gastos == ''){
                        app.mostrar_resultados_gastos = false;
                    }else{
                        app.mostrar_resultados_gastos = true;
                        this.fetchMembersUnidadEjecutora();
                    }
                });
                //var cuentaB = '2.1.1.01.01.001.01';
            //console.log(this.valorIngresoCuentaFuente[cuentaB][0]);
        },

        searchMonitor: function(){
            var keyword = app.toFormData(app.search);
            axios.post('vue/ccp-crearpresupuestogastos.php?action=search', keyword)
                .then(function(response){
                    app.gastos = response.data.ingresosBuscados;
                    if(response.data.ingresosBuscados == ''){
                        //app.mostrar_resultados_gastos = false;
                    }
                    else{
                        //app.mostrar_resultados_gastos = true;
                    }                    
                });
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
                this.valorTotalServicios = 0;
                this.valorSolo = 0;
                this.cuentasSubClaseAgr = [];
                this.cuentasSubClaseServiciosAgr = [];
                this.clasificadores = [];
                await axios.post('vue/ccp-crearpresupuestogastos.php?action=buscarClasificadores&cuentaIngreso=' + cuenta)
                    .then(function(response){
                        app.clasificadores = response.data.clasificadores;
                        if(response.data.ingresosBuscados == ''){
                            //app.mostrar_resultados_gastos = false;
                        }
                        else{
                            //app.mostrar_resultados_gastos = true;
                        }                    
                    });
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
                    await axios.post('vue/ccp-crearpresupuestogastos.php?action=cuin')
                    .then(function(response){
                        app.resultsCuin = response.data.codigos;
                        app.show_table_search = true
                        app.show_table_search = true
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
                    this.divisionServicios(cuentaArr);
                    app.show_table_search = true
                    this.verificarServiciosAgr();
                break;
                case "4":

                break;
            }
            
        },

        verificarCuinAgr: async function(){
            await axios.post('vue/ccp-crearpresupuestoingresos.php?action=searchCuentaAgr&cuentaAgr=' + this.cuentaActual)
            .then((response) => {
                
                app.verResultsCuin = response.data.codigos;
                app.verResultsCuinEliminar = response.data.codigosEliminar;
                app.valorTotalCuin = response.data.valorTotal;
                if(response.data.codigos == ''){
                    
                }
                else{
                    //app.show_table_search = true
                }
            });

            for(i=0; i < this.verResultsCuin.length; i++){
                this.cuentasCuinAgr.push(this.verResultsCuin[i]);
                this.removeItemFromArr(this.verResultsCuinEliminar[i]);
                //this.removeItemFromArrCuin(this.verResultsCuin[i]);
            }
        },

        verificarBienesAgr: async function(){
            //console.log(this.cuentasSelectFuentes);
            await axios.post('vue/ccp-crearpresupuestogastos.php?action=searchCuentaAgr&cuentaAgr=' + this.cuentaActual + '&fuente=' + this.cuentasSelectFuentes[0] + '&unidadEjecutora=' + this.selected + '&medioPago='+this.selectMedioPago + '&vigencia='+this.vigencia)
            .then((response) => {
                
                app.verResultsbienes = response.data.codigos;
                //console.log(response.data);
                //app.verResultsCuinEliminar = response.data.codigosEliminar;
                app.valorTotal = response.data.valorTotal;
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

        verificarValorSolo: async function(){
            await axios.post('vue/ccp-crearpresupuestogastos.php?action=searchValorSolo&cuentaAgr=' + this.cuentaActual + '&fuente=' + this.cuentasSelectFuentes[0] + '&unidadEjecutora=' + this.selected + '&medioPago='+this.selectMedioPago + '&vigencia='+this.vigencia)
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

        verificarServiciosAgr: async function(){
            await axios.post('vue/ccp-crearpresupuestogastos.php?action=searchCuentaServiciosAgr&cuentaAgr=' + this.cuentaActual + '&fuente=' + this.cuentasSelectFuentes[0] + '&unidadEjecutora=' + this.selected + '&medioPago='+this.selectMedioPago + '&vigencia='+this.vigencia)
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

        searchMonitorCuin: function() {
            var parsedobj = JSON.parse(JSON.stringify(app.searchCuin))
            if(parsedobj.keywordCuin == '')
            {
                this.buscaVentanaModal();
            }
            else{
                app.show_table_search = false
                var keyword = app.toFormData(app.searchCuin);
                axios.post('vue/ccp-cuin.php?action=search', keyword)
                    .then(function(response){
                        
                        app.resultsCuin = response.data.codigos;
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
                    this.valorTotal = parseFloat(this.valorTotal) + parseFloat(this.valorBienesTranspotables);
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
            this.valorTotal = parseFloat(this.valorTotal) - parseFloat(cuenta[3]);
            var i = cuenta.indexOf( cuenta[3] );
         
            if ( i !== -1 ) {
                cuenta.splice( i, 1 );
            }


            //this.resultsCuin.unshift(cuenta);
            this.removeItemFromArrCuin(cuenta);

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

        removeItemFromArr: function(item){
            var i = this.resultsCuin.indexOf( item );
            if ( i !== -1 ) {
                this.resultsCuin.splice( i, 1 );
            }
        },

        removeItemFromArrCuin: function(item){
            var i = this.cuentasSubClaseAgr.indexOf( item );
         
            if ( i !== -1 ) {
                this.cuentasSubClaseAgr.splice( i, 1 );
            }
        },

        removeItemFromArrServicios: function(item){
            var i = this.cuentasSubClaseServiciosAgr.indexOf( item );
         
            if ( i !== -1 ) {
                this.cuentasSubClaseServiciosAgr.splice( i, 1 );
            }
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
            formData.append("valorTotal", this.valorTotal);
            formData.append("fuente", this.cuentasSelectFuentes[0]);
            formData.append("unidadEjecutora", this.selected);
            formData.append("medioPago", this.selectMedioPago);
            formData.append("vigencia", this.vigencia);
            //formData.append("cuentas", datosjeison);
            //var cuentaAct = this.cuentaActual;
            axios.post('vue/ccp-crearpresupuestogastos.php?action=guardarBienes',
                    formData
                )
                .then(function(response){
                    if(response.data.insertaBien){
                        app.buscarGastos();
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
            axios.post('vue/ccp-crearpresupuestogastos.php?action=guardarServicios',
                    formData
                )
                .then(function(response){
                    if(response.data.insertaBien){
                        app.buscarGastos();
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
            axios.post('vue/ccp-crearpresupuestogastos.php?action=guardarValorSolo',
                    formData
                )
                .then(function(response){
                    if(response.data.insertaBien){
                        app.buscarGastos();
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
            axios.post('vue/ccp-crearpresupuestogastos.php?action=varlorFuenteCSF',
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
            axios.post('vue/ccp-crearpresupuestogastos.php?action=varlorFuenteSSF',
                    formData
                )
                .then(function(response){
                    app.valorGastoSSF = response.data.valor
                    if(response.data.valor){
                        //app.buscarGastos();
                        //app.showModal_Solo_Presupuesto = false;
                    }
            });
            
        },

        buscarGeneral: function() {

            var parsedobj = JSON.parse(JSON.stringify(app.searchGeneral))

            if(parsedobj.keywordGeneral == '')
            {
                app.mostrarSeccion = true;
                app.show_table_search = false;
                this.fetchMembers();
            }
            else
            {
                app.grupos = [];
                app.clases = [];
                app.subClases = [];
                app.result_search = [];
                app.mostrarGrupo = false;
                app.mostrarClase = false;
                app.mostrarSubClase = false;   
                app.mostrarSeccion = false;   

                var keywordGeneral = app.toFormData(app.searchGeneral);
                axios.post('vue/ccp-bienestransportables.php?action=searchGeneral', keywordGeneral)
                    .then(function(response){
                        
                        app.result_search = response.data.subClasesGeneral;
                        //console.log(response.data.subClasesGeneral);
                        if(response.data.subClasesGeneral == ''){
                            app.noMember = true;
                            app.show_table_search = true;
                        }
                        else{
                            app.noMember = false;
                            app.show_levels(app.result_search[0]);
                            app.show_table_search = true;
                        }
                        
                    });
                // Enviar el scroll al final cuando ya esta definido
                /*setTimeout(() => {
                    document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
                }, 50);*/

                setTimeout(function(){ document.getElementById("end_page").scrollIntoView({block: "end", behavior: "smooth"}); }, 1);

                app.search.keywordGeneral = '';
            }
        },
    },
});