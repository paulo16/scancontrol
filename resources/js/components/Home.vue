<template>
    <div>

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                    </div>
                    <h4 class="page-title">ACCUEIL</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Example Component</div>

                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2  col-form-label" for="example-fileinput">Default file input</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="example-fileinput">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
