var app = new Vue({
    el: '#myapp',
    data:{
        noMember: false,
        search: {keyword: ''},
        results: [],
        results_det: [],
        show_table_search: false,
        show_resultados: false,
        show_results_det: false,
        myStyle: {
            backgroundColor: 'gray',
            color: 'white'
        },
    },
  
    mounted: function(){
        this.getData();
    },

    methods:{

        showClasificador: function(clasificador_cab){
            var formDataDet = new FormData();
            formDataDet.append("id_clasificador", clasificador_cab[0])
            axios.post('vue/ccp-buscaclasificadores.php?action=search_clasificador_det', formDataDet)
                .then(function(response){
                    app.results_det = response.data.clasificadores_det;
                    if(response.data.clasificadores_det != ''){
                        app.show_results_det = true;
                    }else{
                        app.show_results_det = false;
                    }
                })
                .catch((error) => {
                    console.log("Error en la peticion!");
                    console.log(error);
                });
                setTimeout(() => {
                    document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
                }, 50);
        },

        deleteClasificador: function(id_clasificador){
            var formData = new FormData();
            formData.append("id_clasificador", id_clasificador);
            axios.post('vue/ccp-buscaclasificadores.php?action=delete', formData)
            .then(function(response){
                console.log(response)
                app.show_results_det = false;
            });
            this.getData();
        },

        searchMonitor: function() {
            var keyword = app.toFormData(app.search);
            axios.post('vue/ccp-buscaclasificadores.php?action=search', keyword)
                .then(function(response){
                    app.results = response.data.clasificadores;
                    if(response.data.clasificadores == ''){
                        app.show_resultados = false;
                    }
                    else{
                        app.show_resultados = true;
                    }                    
                });
        },

        getData: function(){
            axios.post('vue/ccp-buscaclasificadores.php')
                .then(function(response){
                    app.results = response.data.clasificadores;
                    if(app.results == ''){
                        app.show_resultados = false;
                    }else{
                        app.show_resultados = true;
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
    }
});