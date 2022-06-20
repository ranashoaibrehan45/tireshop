<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <div v-if="success" class="alert alert-success" role="alert">
                            <strong>Well done!</strong> {{msg}}</a>.
                        </div>
                        <div v-if="error" class="alert alert-danger" role="alert">
                            There was an error, unable to sign in with those credentials.
                        </div>

                        <form @submit.prevent="login" method="post" aria-label="Login" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" id="email" v-model="email" v-bind:class="[errorEmail? is_invalid:'', form_control]" required autofocus>

                                    <span v-if="errorEmail" class="invalid-feedback" role="alert">
                                        <div v-for="msg in error.email">
                                            <strong>{{ msg }}</strong>
                                        </div>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <input type="password" id="password" v-model="password" v-bind:class="[errorPassword? is_invalid:'', form_control]" required>

                                    <span v-if="errorPassword" class="invalid-feedback" role="alert">
                                        <div v-for="msg in error.password">
                                            <strong>{{ msg }}</strong>
                                        </div>
                                    </span>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block">
                                    <i class="fas fa-sign-in-alt"></i> Login
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
                email: null,
                password: null,
                error: false,
                success: false,
                errorEmail: false,
                errorPassword: false,
                is_invalid:'is-invalid', 
                form_control: 'form-control',
                siteURL: 'https://www.localhost.dev/leadrop3/#/'
            }
        },
        methods: {
            login(){
                var app = this
                this.$auth.login({
                    params: {
                        email: app.email,
                        password: app.password
                    }, 
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (error) {
                    	this.error = true;
                    },
                    rememberMe: true,
                    redirect: '/dashboard',
                    fetchUser: true,
                });       
            },
            

        }, // methods end
    }
</script>

<style>
.fb-signin-button {
  /* This is where you control how the button looks. Be creative! */
  display: inline-block;
  padding: 4px 8px;
  border-radius: 3px;
  background-color: #4267b2;
  color: #fff;
}

.g-signin-button {
  /* This is where you control how the button looks. Be creative! */
  display: inline-block;
  padding: 4px 8px;
  border-radius: 3px;
  background-color: #3c82f7;
  color: #fff;
  box-shadow: 0 3px 0 #0f69ff;
}
</style>