<template>
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                    </div>
                    <h4 class="page-title">INFORMATIONS UTILES</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Les Remarques</div>
                    <div class="card-body">
                        <div class="justify-content-center"> 
                                <button @click="getremarques()" class="btn btn-primary waves-effect waves-light" size="large" >Télecharger les Remarques</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>

import axios from 'axios'

export default {
  data () {
    return {
    }
  },
  methods: {
    getremarques(){
        //e.preventDefault()

        let routeUrl = route('exportremarques')
        let data = new FormData()
        data.append('demande','')

        axios.get(routeUrl,data).then((response) => {
           var fileURL = window.URL.createObjectURL(new Blob([response.data]));
           var fileLink = document.createElement('a');

           fileLink.href = fileURL;
           fileLink.setAttribute('download', 'Les_remarques.csv');
           document.body.appendChild(fileLink);

           fileLink.click();
        });
        
    }
  }
}
</script>
