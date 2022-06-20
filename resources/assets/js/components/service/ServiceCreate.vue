<template>
    <div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="addServiceLabel">Add New Service</h4>
                </div>
                <div class="modal-body">
                    <div v-if="success" class="alert alert-success" role="alert">
                        <strong>Well done!</strong> Service has been added successfully.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.name)? has_error:'', form_group]">
                                <label for="name" class="required">Name</label>
                                <input type="text" v-model="name" id="name" class="form-control">

                                <span v-if="error && errors.name" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.name">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.price)? has_error:'', form_group]">
                                <label for="price" class="required">Price</label>
                                <input type="text" v-model="price" id="price" class="form-control">

                                <span v-if="error && errors.price" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.price">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div v-bind:class="[(error && errors.description)? has_error:'', form_group]">
                                <label for="description">Description</label>
                                <textarea v-model="description" id="description" class="form-control"></textarea>

                                <span v-if="error && errors.description" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.description">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" @click="addRecode" class="btn btn-primary">Save changes</button>
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

                name:'',
                description:'',
                price:0,
               
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
            addRecode(){
                axios.post("/service",{
                    name: this.name,
                    description: this.description,
                    price: this.price,
                })
                .then(response => {
                    console.log("success");
                    console.log(response);

                    this.$emit('serviceCreated', response);
                    
                    this.name='';
                    this.description='';
                    this.price=0;

                    this.success = true;
                    this.error=false;
                    this.errors=[];
                })
                .catch(error => {
                    this.error = true;
                    this.errors = error.response.data.errors;
                    
                    console.log("error");
                    console.log(this.error);
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