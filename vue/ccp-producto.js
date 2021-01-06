var app = new Vue({
    el: '#myapp',
    data:{
        sectores: [], 
        programas_subprogramas: [],
        productos: [],
        sector_p: '',
        programa_p: '',
        mostrarProgramas: false,
        mostrarProductos: false,
        search: {keyword: ''},
        searchProgram: {keywordProgram: ''},
        searchProduct: {keywordProduct: ''},
        sombra: ''
    },
  
    mounted: function(){
        this.fetchMembers();
    },
  
    methods:{
        searchMonitor: function() {
            var keyword = app.toFormData(app.search);
            //console.log(keyword);
            axios.post('vue/ccp-producto.php?action=searchSector', keyword)
                .then(function(response){
                    
                    app.sectores = response.data.codigos;
                    //console.log(response.data.codigos);
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

        changeBackground: function(producto){
            this.sombra = producto[0];
        },

        searchMonitorPrograms: function() {
            var keywordProgram = app.toFormData(app.searchProgram);
            //console.log(keyword);
            axios.post('vue/ccp-producto.php?action=searchProgram&sectorSearch='+this.sector_p, keywordProgram)
                .then(function(response){
                    
                    app.programas_subprogramas = response.data.programas;   
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

        searchMonitorProducts: function() {
            var keywordProduct = app.toFormData(app.searchProduct);
            //console.log(this.programa_p);
            axios.post('vue/ccp-producto.php?action=searchProduct&programSearch='+this.programa_p, keywordProduct)
                .then(function(response){
                    app.productos = response.data.productos;   
                    //console.log(app.productos);
                    if(response.data.productos == ''){
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
            axios.post('vue/ccp-producto.php')
                .then(function(response){
                    app.sectores = response.data.codigos;
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

        programas: function(sector)
        {
            //
            app.searchProgram = {keywordProgram: ''};
            app.programas_subprogramas = [];
            app.productos = [];
            this.programa_p = '';
            app.mostrarProductos = false;
            if(this.sector_p == '' || this.sector_p == sector[0] || !app.mostrarProgramas)
            {
                app.mostrarProgramas = !app.mostrarProgramas;
                
            }
            
            if(app.mostrarProgramas)
            {
                //app.mostrarProductos = !app.mostrarProductos;
                this.sector_p = sector[0];
                axios.post('vue/ccp-producto.php?sector='+this.sector_p)
                    .then(function(response){
                        app.programas_subprogramas = response.data.programas;
                        if(response.data.programas == ''){
                            app.mostrarProgramas = false;
                        }
                        else{
                            app.mostrarProgramas = true;
                        }
                    });
            }
            setTimeout(function(){ document.getElementById("end_page").scrollIntoView({block: "end", behavior: "smooth"}); }, 1)
        },

        buscarProductos: function(programa)
        {
            app.searchProduct = {keywordProduct: ''};
            app.productos = [];
            if(this.programa_p == '' || this.programa_p == programa[0] || !app.mostrarProductos)
            {
                app.mostrarProductos = !app.mostrarProductos;
            }
            
            if(app.mostrarProductos)
            {
                //app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.programa_p = programa[0];
                //console.log();
                axios.post('vue/ccp-producto.php?programa='+this.programa_p)
                    .then(function(response){
                        app.productos = response.data.productos;
                        if(response.data.productos == ''){
                            app.mostrarProductos = false;
                        }
                        else{
                            app.mostrarProductos = true;
                        }
                    });
            }
            setTimeout(function(){ document.getElementById("end_page").scrollIntoView({behavior: "smooth"}); }, 1)
        },
    }
});