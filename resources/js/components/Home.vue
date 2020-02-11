<template>
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                    </div>
                    <h4 class="page-title">ACCUEIL</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Champs d'indexations</div>
                <div class="card-body">
                    <div class="justify-content-center">
                        <form class="form-inline" role="form" id="form_champindexation" @submit="getlesentetes" method="post">
                            <div class="form-group row">
                                    <label class="col-sm-4  col-form-label" for="example-fileinput">Insérer un fichier Excel vide contenant uniquement les champs d'indexations</label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control" id="fileexcel"  ref="fileexcel"  @change="getfile()" placeholder="E:\Scans\excel.xls">
                                    </div>
                            </div>
                            <button class="btn btn-primary waves-effect waves-light col-sm-2" size="large" type="submit">Recupérer les champs </button>
                        
                        </form>
                        <br><br>
                        <hr>
                        <form class="form-inline" role="form" id="form_agarder" @submit="champsasave">
                            <div class="form-group row">
                                <label class="col-sm-4  col-form-label" for="example-fileinput">Selectionner les champs à garder pour le contrôle de l'indexation</label>
                                <v-multiselect-listbox v-model="champsagarder" :options="champsindexations"></v-multiselect-listbox>
                            </div>
                            <button class="btn btn-primary waves-effect waves-light col-sm-2" size="large" >sauvegarder les champs</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

import 'vue-multiselect-listbox/dist/vue-multi-select-listbox.css';

import axios from 'axios'

export default {
  data () {
    return {
      champsindexations: [], //permet d'affichers la liste des chmaps pris depuis excel
      champsagarder: [], //permet de recupérer les champs choisi 
      exel_ref: '',
    }
  },
  methods: {

    getfile(){
      this.exel_ref = document.getElementById('fileexcel').files[0]
    },
    champsasave(e){
        e.preventDefault()
        console.log(this.champsagarder)
    },

    getlesentetes(e){
      e.preventDefault()
      var routeUrl = route('lesentetes')
      //console.log('je suis ici')
      let data = new FormData();
      let fichierxcel = this.exel_ref
      console.log(this.exel_ref)
      data.append('fichierexcel', fichierxcel)
      data.append('nom_fichier',fichierxcel.name);
      //data.append('_method', 'POST');
      axios.post(routeUrl,data)
      .then(response => {
        //console.log(response.data)
        let Laraveldataentetes = response.data.lesentetes
        this.champsindexations =Object.values(Laraveldataentetes);
        console.log(this.champsindexations)
      }).catch(e => {
        //this.errors.push(e)
        console.log(e)
      })
      //console.log('renome ok')
    }
  }
}
</script>
