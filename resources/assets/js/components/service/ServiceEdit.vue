<template>
    <div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" @click="clearModel" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="editServiceModalLabel">Edit Service</h4>
                </div>

                <div class="modal-body">
                    <div v-if="success" class="alert alert-success" role="alert">
                        <strong>Well done!</strong> Service has been updated successfully.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.name)? has_error:'', form_group]">
                                <label for="name" class="required">Name</label>
                                <input type="text" v-model="service.name" id="name" class="form-control">

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
                                <input type="text" v-model="service.price" id="price" class="form-control">

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
                                <textarea v-model="service.description" id="description" class="form-control"></textarea>

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
                    <button type="button" @click="clearModel" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" @click="updateRecode" class="btn btn-primary">Update Service</button>
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
        props:['service'],
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
                price:0,
                description:'',
                
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
                axios.post("service/" + this.service.id,{
                    'name': this.service.name,
                    'price': this.service.price,
                    'description': this.service.description,
                    '_method': 'PUT'
                })
                .then(data => {
                    this.$emit('serviceUpdated', data);
                    this.name='';
                    this.price=0;
                    this.description='';

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