<template>
    <div class="modal fade" id="editTireStockModal" tabindex="-1" role="dialog" aria-labelledby="editTireStockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" @click="clearModel" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="editTireStockModalLabel">Edit Tire Sale Price</h4>
                </div>

                <div class="modal-body">
                    <div v-if="success" class="alert alert-success" role="alert">
                        <strong>Well done!</strong> Sale price has been updated successfully.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <label for="company_id" class="required">Company</label>
                                <span v-if="tire.company">{{tire.company.name}}</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form_group">
                                <label for="size_id" class="required">Size</label>
                                <span v-if="tire.size">{{tire.size.name}}</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form_group">
                                <label for="quantity" class="required">Quantity</label>
                                {{tire.quantity}}
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.price)? has_error:'', form_group]">
                                <label for="price" class="required">Sale Price/Unit</label>
                                <input type="number" v-model="tire.price" id="price" min="0" class="form-control">

                                <span v-if="error && errors.price" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.price">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="clearModel" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" @click="updateRecode" class="btn btn-primary">Update Tire Price</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script type="text/javascript">
    import Ckeditor from 'vueckeditor';
    export default{
        props:['tire'],
        components: {
          Ckeditor
        },
        data(){
            return {
                form_group : 'form-group',
                has_error : 'has-error',
                success:false,
                error: false,
                errors: [],

                config:{
                    toolbar: ['Format',
                              ['Bold', 'Italic', 'Strike', 'Underline'],
                              ['BulletedList', 'NumberedList', 'Blockquote'],
                              ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                              ['Link', 'Unlink'],
                              ['FontSize', 'TextColor'],
                              ['Image'],
                              ['Undo', 'Redo'],
                              ['Source', 'Maximize']],
                    defaultLanguage: 'es'
                }
            }
        },
        methods:{
            updateRecode(){
                axios.post("tire_stock/" + this.tire.id, 
                {
                    '_method': 'PUT',
                    price: this.tire.price,
                })
                .then(data => {
                    this.$emit('tireStockUpdated', data);
                    this.success = this.error = true;
                    this.errors=[];
                })
                .catch(error => {
                    console.log("error");
                    console.log(error.response);
                    this.error = true;
                    this.errors = error.response.data.errors;
                        
                })
            },
            clearModel(){
                this.success=false;
                this.error = false;
                this.errors=[];
            }
        }
    }
</script>