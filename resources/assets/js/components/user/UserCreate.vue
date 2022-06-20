<template>
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" @click="clearModel" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add New User</h4>
                </div>
                <div class="modal-body">
                    <div v-if="success" class="alert alert-success" role="alert">
                        <strong>Well done!</strong> New user has been created successfully.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.first_name)? has_error:'', form_group]">
                                <label for="first_name" class="required">First Name</label>
                                <input type="text" v-model="first_name" class="form-control">

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
                                <input type="text" v-model="last_name" class="form-control">

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
                                <input type="text" v-model="username" class="form-control">

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
                                <input type="email" v-model="email" class="form-control">

                                <span v-if="error && errors.email" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.email">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.password)? has_error:'', form_group]">
                                <label for="password" class="required">Password</label>
                                <input type="password" v-model="password" class="form-control">

                                <span v-if="error && errors.password" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.password">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.password_confirmation)? has_error:'', form_group]">
                                <label for="password_confirmation" class="required">Confirm Password</label>
                                <input type="password" v-model="password_confirmation" class="form-control">

                                <span v-if="error && errors.password_confirmation" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.password_confirmation">
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
                    <button type="button" @click="addRecode" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script type="text/javascript">
    
    export default{
        data(){
            return {
                form_group : 'form-group',
                has_error : 'has-error',
                success:false,
                error: false,
                errors: [],

                first_name:'',
                last_name:'',
                username:'',
                email:'',
                password:'',
                password_confirmation: '',
                role:'client',
            }
        },
        methods:{
            addRecode(){
                axios.post("/user",{
                    first_name: this.first_name,
                    last_name: this.last_name,
                    username: this.username,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    role: this.role
                })
                .then(response => {
                    console.log("success");
                    console.log(response);

                    this.$emit('userCreated', response);
                    
                    this.clearFormFields();
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
            clearFormFields()
            {
                this.first_name = '';
                this.last_name = '';
                this.username = '';
                this.email = '';
                this.password = '';
                this.password_confirmation = '';
            },
            clearModel(){
                this.success=false;
                this.error = false;
                this.errors=[];
            }
        }
    }
</script>