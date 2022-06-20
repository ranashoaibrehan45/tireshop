<template>
    <div class="modal fade" id="editTireSizeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" @click="clearModel" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Edit Tire Size</h4>
                </div>

                <div class="modal-body">
                    <div v-if="success" class="alert alert-success" role="alert">
                        <strong>Well done!</strong> Tire size has been updated successfully.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.name)? has_error:'', form_group]">
                                <label for="name" class="required">Name</label>
                                <input type="text" v-model="tiresize.name" id="name" class="form-control">

                                <span v-if="error && errors.name" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.name">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="clearModel" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" @click="updateRecode" class="btn btn-primary">Update Tiresize</button>
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
        props:['tiresize'],
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
                expectations: '',
                min_rate: 0,

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
                axios.post("tire_size/" + this.tiresize.id,{
                    'name': this.tiresize.name,
                    '_method': 'PUT'
                })
                .then(data => {
                    this.$emit('tiresizeUpdated', data);
                    this.name='';
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