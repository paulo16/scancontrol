<template>
    <div>
     <!-- start page title -->
     <div class="row">
         <div class="col-md-12">
             <div class="page-title-box">
                 <div class="page-title-right">
                 </div>
                 <h4 class="page-title">CONTRÔLE DE SCANS</h4>
             </div>
         </div>
     </div>
     <div>       
        <form  @submit="getlesPdfs" method="post">
            <div class="form-row">
                <div class="col-md-4 mb-2">
                    <label  for="pdf_dossiers">Dossiers des Pdfs</label>
                    <input  type="text" class="form-control" v-model="pdf_dossiers" id="pdf_dossiers"  placeholder="E:\Scans\Dossiers_des_scans">
                </div>
                <div class="col-md-4 mb-2">
                    <label  for="excel_file">Fichier Excel de contrôle </label>
                    <input  type="file" class="form-control" id="fileexcel"  ref="fileexcel"  @change="getfile()" placeholder="E:\Scans\excel_de_control.xls">
                </div>
                <div class="col-md-4 mb-3">
                    <label  for="nom_de_dossiers">Lancer </label>
                    <button class="form-control btn btn-primary waves-effect waves-light"  type="submit">Soumettre le choix </button>
                </div>
            </div>
        </form>
    </div>
    <br>
    <br>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <p>ICI LA LISTE DES PDF</p>
            <div class="base-demo">
                <vue-table-dynamic :params="params" @row-click='getChampsindexation'></vue-table-dynamic>
            </div>
        </div>
        <div class="col-md-6">
            <vue-pdf-viewer :url="url" height="500px">
            </vue-pdf-viewer>
        </div>
        <div class="col-md-3">
            <p>LES CHAMPS INDEXATION</p>
            <div  v-html="htmlchamps" name="champsdiv" id="champsdiv" style="height: 400px; overflow-y: scroll;">
            </div>
        </div>
    </div>
</div>
</template>

<script>
import VuePDFViewer from 'vue-instant-pdf-viewer'
import VueTableDynamic from 'vue-table-dynamic'

export default {
    components: {
        'vue-pdf-viewer': VuePDFViewer,
        'VueTableDynamic': VueTableDynamic

    },
    data () {
        return {
            htmlchamps : '',
            pdf_dossiers :'',
            url: 'https://bitcoin.org/bitcoin.pdf',
            les_pdfs: [],
            params: {
                data: [
                ['Nom pdf'],
                ],
                header: 'row',
                border: true,
                enableSearch: true,
                sort: [0],
                stripe: true,
                pagination: true,
                pageSize: 10,
                pageSizes: [5, 10, 20, 50]
            }
        }
    },
    mounted () {
    },
    methods: {
        getfile(){
          this.exel_ref = document.getElementById('fileexcel').files[0]
      },

    getChampsindexation(index ,data){

        let lepdfalire = this.pdf_dossiers+"\\"+data
        //console.log('Row click')
        //console.log(this.url)
        var routeUrl = route('urlpdf')
        //console.log('je suis ici')
        let data1 = new FormData();
        let fichierxcel = this.exel_ref
        //console.log(data)
        //console.log(lepdfalire)
        data1.append('pdf_chemincomplet', lepdfalire)
        data1.append('pdf_nomsimple', data)
          //data.append('_method', 'POST');
          axios.post(routeUrl,data1).then(response => {
            // response.data contient url vers le pdf
            //console.log(response.data)
            let Laravelpdf = response.data.pdf_url
            this.url =Laravelpdf;
            console.log(Laravelpdf)
            console.log(response.data.pdf_champs)
            let leschamps = response.data.pdf_champs
            console.log(leschamps)
            let keyschamps = Object.keys(leschamps)

            for(var key in leschamps) {
                this.htmlchamps += '<div class="col-xs-3">'+'<label for="ex2">'+key+
                '</label><input class="form-control" value='+leschamps[key]+'  type="text"></div>'
            }

        }).catch(e => {
                //this.errors.push(e)
                console.log(e)
            })
          //console.log('renome ok')
      },

    getlesPdfs(e){
          e.preventDefault()
          var routeUrl = route('lespdfs')
          //console.log('je suis ici')
          let data = new FormData();
          let fichierxcel = this.exel_ref
          //console.log(this.exel_ref)
          //console.log(this.pdf_dossiers)
          data.append('fichierexcel', fichierxcel)
          data.append('nom_fichier',fichierxcel.name);
          data.append('dossier_cible',this.pdf_dossiers);
          //data.append('_method', 'POST');
          axios.post(routeUrl,data).then(response => {
            //console.log(response.data)
            let Laravelpdfs = response.data.les_pdfs
            this.les_pdfs =Laravelpdfs;
            for (let i = 0; i < Laravelpdfs.length; i++) {
                this.params.data.push([Laravelpdfs[i].nom_pdf])
            }
            //console.log(Laravelpdfs[1].nom_pdf)
        }).catch(e => {
                //this.errors.push(e)
                console.log(e)
            })
          //console.log('renome ok')
  }
}
}
</script>