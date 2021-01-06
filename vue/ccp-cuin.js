var app = new Vue({
    el: '#myapp',
    data:{
        search: {keyword: ''},
        noMember: false,
        results: [],
        show_table_search: false,
        show_resultados: true,
    },
  
    mounted: function(){
        this.fetchMembers();
    },
  
    methods:{
        searchMonitor: function() {
            var keyword = app.toFormData(app.search);
            axios.post('vue/ccp-cuin.php?action=search', keyword)
                .then(function(response){
                    
                    app.results = response.data.codigos;
                    
                    if(response.data.codigos == ''){
                        app.noMember = true;
                        app.show_resultados = false;
                    }
                    else{
                        app.noMember = false;
                        app.show_resultados = true;
                    }
                    
                });
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            app.search.keyword = '';
        },
  
        fetchMembers: function(){
            axios.post('vue/ccp-cuin.php')
                .then(function(response){
                    app.results = response.data.codigos;
                    app.show_table_search = true
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