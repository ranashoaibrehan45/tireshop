<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Update Account Details</h3>
                    </div>
                    <div class="panel-body">
                        <div v-if="success" class="alert alert-success" role="alert">
                            <strong>Well done!</strong> {{msg}}</a>.
                        </div>
                        <div v-if="error" class="alert alert-danger" role="alert">
                            Invalid username or password.
                        </div>

                        <form @submit.prevent="login" method="post" aria-label="Login" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" id="username" v-model="username" v-bind:class="[error.username? is_invalid:'', form_control]" required autofocus>

                                    <span v-if="error && error.username" class="invalid-feedback" role="alert">
                                        <div v-for="msg in error.username">
                                            <strong>{{ msg }}</strong>
                                        </div>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <input type="password" id="password" v-model="password" v-bind:class="[error.password? is_invalid:'', form_control]" required>

                                    <span v-if="error && error.password" class="invalid-feedback" role="alert">
                                        <div v-for="msg in error.password">
                                            <strong>{{ msg }}</strong>
                                        </div>
                                    </span>
                                </div>

                                <h3>New Username & Password</h3>
                                <div class="form-group">
                                    <input type="text" id="username_new" v-model="username_new" v-bind:class="[error.username_new? is_invalid:'', form_control]" required autofocus>

                                    <span v-if="error && error.username_new" class="invalid-feedback" role="alert">
                                        <div v-for="msg in error.username_new">
                                            <strong>{{ msg }}</strong>
                                        </div>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <input type="password" id="password_new" v-model="password_new" v-bind:class="[error.password_new? is_invalid:'', form_control]" required>

                                    <span v-if="error && error.password_new" class="invalid-feedback" role="alert">
                                        <div v-for="msg in error.password_new">
                                            <strong>{{ msg }}</strong>
                                        </div>
                                    </span>
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block">
                                    <i class="fas fa-sign-in-alt"></i> Update Account
                                </button>
                                
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    
    export default {
        data(){
            return {
                username: null,
                password: null,
                username_new: null,
                password_new: null,
                error: false,
                success: false,
                msg: '',
                is_invalid:'is-invalid', 
                form_control: 'form-control',
                siteURL: 'http://localhost/oilshop/#/'
            }
        },
        methods: {
            login(){
                axios.post("/update/account",{
                    username: this.username,
                    password: this.password,
                    username_new: this.username_new,
                    password_new: this.password_new
                })
                .then(response => {
                    console.log("success");
                    console.log(response);

                    this.username = '';
                    this.username_new = '';
                    this.password = '';
                    this.password_new = '';
                    
                    this.success = true;
                    this.error=false;
                    this.errors=[];
                    this.msg = "Account has been updated successfully.";
                })
                .catch(error => {
                    this.error = true;
                    this.errors = error.response.data.errors;
                    
                    console.log("error");
                    console.log(this.error);
                        
                })      
            },
            

        }, // methods end
    }
</script>

<style>
</style>