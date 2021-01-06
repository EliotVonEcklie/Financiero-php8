var app = new Vue({
    el: '#myapp',
    data:{
        secciones: [], 
        divisiones: [],
        grupos: [],
        clases: [],
        subClases: [],
        subClases_captura: [],
        seccion_p: '',
        seccion_p_nombre: '',
        division_p: '',
        division_p_nombre: '',
        grupo_p: '',
        grupo_p_nombre: '',
        clase_p: '',
        clase_p_nombre: '',
        subClase_p: '',
        subClase_p_nombre: '',
        result_search: [],
        codigo_buscar_nombre: [],
        seccion_general: [],
        grupo_general: [],
        clase_general: [],
        division_general: [],
        show_table_search: false,
        show_resultados: false,
        mostrarDivision: false,
        mostrarGrupo: false,
        mostrarClase: false,
        mostrarSubClase: false,
        showModal: false,
        mostrarSeccion: true,
        search: {keyword: ''},
        buscar_g: {codigo_buscar_g: ''},
        searchDivision: {keywordDivision: ''},
        searchGrupo: {keywordGrupo: ''},
        searchClase: {keywordClase: ''},
        searchSubClase: {keywordSubClase: ''},
        searchGeneral: {keywordGeneral: ''},
        sombra: ''
    },
  
    mounted: function(){
        this.fetchMembers();
    },
  
    methods:{

        show_levels: function(codigo){
            
            app.mostrarSeccion = true;
            codigo_final = codigo[0];
            
            codigo_subClase = codigo_final.slice(0,-2);  
            codigo_Clase = codigo_subClase.slice(0,-1); 
            codigo_grupo = codigo_Clase.slice(0,-1);
            codigo_division = codigo_grupo.slice(0,-1);
            codigo_seccion = codigo_division.slice(0,-1);
            //console.log(codigo_seccion);
            this.searchHastaSubclase(codigo_final, codigo_subClase, codigo_Clase, codigo_grupo, codigo_division, codigo_seccion);            
            // else{
            //     console.log(" Este item es de otro nivel! el nivel es " + codigo[4])
            // }
            setTimeout(() => {
                const start_page = document.getElementById("start_page").scrollIntoView({behavior: 'smooth'});  
            }, 50);

        },

        searchHastaSubclase: async function(codigo_final, codigo_subClase, codigo_Clase, codigo_grupo, codigo_division, codigo_seccion)
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

            this.seccion_p = codigo_seccion;
           
            this.fetchMembers();

            // aqui empieza a buscar la seccion 
            var seccion_nombre_buscar =  await this.buscarNombre(this.seccion_p);

            this.seccion_general.push(this.seccion_p);
            //console.log(codigo_seccion);
            this.seccion_general.push(seccion_nombre_buscar);
            //console.log(this.seccion_general);
            this.division(this.seccion_general, scrollArriba = true);
            // aqui termina

            //aqui empiza a buscar el nombre de la division
            var seccion_nombre_buscar =  await this.buscarNombre(codigo_division);

            this.division_general.push(codigo_division);
            this.division_general.push(seccion_nombre_buscar);
            //console.log(this.division_general);
            this.buscarGrupo(this.division_general, scrollArriba = true);
            //qui termina
            //aqui empiza a buscar el nombre del grupo
            var seccion_nombre_buscar =  await this.buscarNombre(codigo_grupo);

            this.grupo_general.push(codigo_grupo);
            this.grupo_general.push(seccion_nombre_buscar);

            this.buscarClase(this.grupo_general, scrollArriba = true);
            //aqui termina
            //aqui empiza a buscar el nombre de la clase
            var seccion_nombre_buscar =  await this.buscarNombre(codigo_Clase);

            this.clase_general.push(codigo_Clase);
            this.clase_general.push(seccion_nombre_buscar);

            this.buscarSubclase(this.clase_general, scrollArriba = true);

            this.subClase_p = codigo_subClase;
            //aqui termina
           // this.subClase_p = codigo_subClase;

           //var seccion_nombre_buscar =  await this.buscarNombre(codigo_subClase);
           app.show_table_search = false;  
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
                app.divisiones = [];
                app.grupos = [];
                app.clases = [];
                app.subClases = [];
                app.result_search = [];
                app.mostrarDivision = false;
                app.mostrarGrupo = false;
                app.mostrarClase = false;
                app.mostrarSubClase = false;   
                app.mostrarSeccion = false;   

                var keywordGeneral = app.toFormData(app.searchGeneral);
                axios.post('vue/ccp-bienestransportables.php?action=searchGeneral', keywordGeneral)
                    .then(function(response){
                        
                        app.result_search = response.data.subClasesGeneral;
                        
                        if(response.data.subClasesGeneral == ''){
                            app.noMember = true;
                            app.show_resultados = false;
                            app.show_table_search = true;
                        }
                        else{
                            app.noMember = false;
                            app.show_resultados = true;
                            app.show_table_search = true;
                        }
                        
                    });
                // Enviar el scroll al final cuando ya esta definido
                /*setTimeout(() => {
                    document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
                }, 50);*/

                setTimeout(function(){ document.getElementById("end_page").scrollIntoView({block: "end", behavior: "smooth"}); }, 1);

                app.search.keyword = '';
            }
        },

        searchMonitor: function() {
            var keyword = app.toFormData(app.search);
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
            //console.log(keyword);
            axios.post('vue/ccp-bienestransportables.php?action=searchSeccion', keyword)
                .then(function(response){
                    
                    app.secciones = response.data.secciones;
                    //console.log(response.data.codigos);
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
            //console.log(keywordDivision);
            app.grupos = [];
            app.clases = [];
            app.subClases = [];
            app.mostrarGrupo = false;
            app.mostrarClase = false;
            app.mostrarSubClase = false;
            this.searchGrupo= {keywordGrupo: ''};
            this.searchClase= {keywordClase: ''};
            this.searchSubClase= {keywordSubClase: ''};
            //console.log(this.seccion_p);
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
            //console.log(this.programa_p);
            axios.post('vue/ccp-bienestransportables.php?action=searchGrupo&divisionSearch='+this.division_p, keywordGrupo)
                .then(function(response){
                    app.grupos = response.data.grupos;   
                    //console.log(app.productos);
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
            //console.log(this.grupo_p);
            axios.post('vue/ccp-bienestransportables.php?action=searchClase&grupoSearch='+this.grupo_p, keywordClase)
                .then(function(response){
                    app.clases = response.data.clases;   
                    //console.log(app.productos);
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
            //console.log(this.programa_p);
            axios.post('vue/ccp-bienestransportables.php?action=searchSubClase&subClaseSearch='+this.clase_p, keywordSubClase)
                .then(function(response){
                    app.subClases = response.data.subClases;   
                    //console.log(app.productos);
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
  
        fetchMembers: function(){
            axios.post('vue/ccp-bienestransportables.php')
                .then(function(response){
                    app.secciones = response.data.secciones;
                });
        },
  
        toFormData: function(obj){
            var form_data = new FormData();
            for(var key in obj){
                form_data.append(key, obj[key]);
            }
            // console.log(form_data); 
            return form_data;
        },

        division: function(seccion, scrollArriba = false)
        {
            //console.log(seccion[0]);
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
            if(this.seccion_p == '' || this.seccion_p == seccion[0] || !app.mostrarDivision)
            {
                app.mostrarDivision = !app.mostrarDivision;
                //console.log(app.mostrarDivision);
            }
            if(app.mostrarDivision)
            {
                //app.mostrarProductos = !app.mostrarProductos;
                
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
            }
            if(!scrollArriba)
            {
                setTimeout(function(){ document.getElementById("end_page").scrollIntoView({block: "end", behavior: "smooth"}); }, 1)
            }
        },

        buscarGrupo: function(division, scrollArriba = false)
        {
            this.searchGrupo= {keywordGrupo: ''};
            this.searchClase= {keywordClase: ''};
            this.searchSubClase= {keywordSubClase: ''};
            app.grupos = [];
            app.clases = [];
            app.subClases = [];
            app.mostrarClase = false;
            app.mostrarSubClase = false;
            this.grupo_p = '';
            this.grupo_p_nombre = '';
            this.clase_p = '';
            this.clase_p_nombre = '';
            this.subClase_p = '';
            this.subClase_p_nombre = '';
            if(this.division_p == '' || this.division_p == division[0] || !app.mostrarGrupo)
            {
                app.mostrarGrupo = !app.mostrarGrupo;
                
            }
            
            if(app.mostrarGrupo)
            {
                //app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.division_p = division[0];
                this.division_p_nombre = division[1];
                //console.log(division);
                axios.post('vue/ccp-bienestransportables.php?division='+this.division_p)
                    .then(function(response){
                        app.grupos = response.data.grupos;
                        //console.log(response);
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
                //console.log();
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
                //console.log();
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

        toggleModal(subClase) {

            //this.showModal = !this.showModal;
            this.subClase_p = subClase[0];
            this.subClase_p_nombre = subClase[1];

            axios.post('vue/ccp-bienestransportables.php?subClase='+this.subClase_p)
            .then(function(response){
                app.subClases_captura = response.data.subClases_captura;
                if(response.data.subClases_captura == ''){
                    app.showModal = false;
                }
                else{
                    app.showModal = true;
                }
            });
            //this.$refs['my-modal'].toggle('#toggle-btn')

        },
    }
});