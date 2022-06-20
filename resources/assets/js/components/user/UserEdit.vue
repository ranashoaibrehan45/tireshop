<template>
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" @click="clearModel" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Edit User</h4>
                </div>

                <div class="modal-body">
                    <div v-if="success" class="alert alert-success" role="alert">
                        <strong>Well done!</strong> User has been updated successfully.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.first_name)? has_error:'', form_group]">
                                <label for="first_name" class="required">First Name</label>
                                <input type="text" v-model="rec.first_name" class="form-control">

                                <span v-if="error && errors.first_name" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.first_name">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.last_name)? has_error:'', form_group]">
                                <label for="last_name" class="required">Last Name</label>
                                <input type="text" v-model="rec.last_name" class="form-control">

                                <span v-if="error && errors.last_name" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.last_name">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.username)? has_error:'', form_group]">
                                <label for="username" class="required">Username</label>
                                <input type="text" v-model="rec.username" class="form-control">

                                <span v-if="error && errors.username" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.username">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.email)? has_error:'', form_group]">
                                <label for="email" class="required">Email</label>
                                <input type="email" v-model="rec.email" class="form-control">

                                <span v-if="error && errors.email" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.email">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Role</label>
                                <label class="radio-inline">
                                    <input type="radio" name="role" value="client" checked>Client
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="role" value="expert">Tasker
                                </label>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="clearModel" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" @click="updateRecode" class="btn btn-primary">Update Record</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script type="text/javascript">
    export default{
        props:['rec'],
        data(){
            return {
                form_group : 'form-group',
                has_error : 'has-error',
                success:false,
                error: false,
                errors: [],

                name:''
            }
        },
        methods:{
            updateRecode(){
                axios.post("user/" + this.rec.id,{
                    _method: 'PUT',
                    first_name: this.rec.first_name,
                    last_name: this.rec.last_name,
                    username: this.rec.username,
                    email: this.rec.email,
                    role: this.rec.role
                })
                .then(data => {
                    this.$emit('userUpdated', data);
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