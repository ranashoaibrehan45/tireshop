<template>
    <div>
        <div class="modal fade" id="modalSignup">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Register</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" v-if="success">
                            We sent you an activation code. Check your email and click on the link to verify.
                        </div>

                        <div v-if="error && !success" class="alert alert-danger" role="alert">
                            There was an error, unable to complete registration.
                        </div>

                            <form @submit.prevent="register" method="post">
                                <div class="form-group row">
                                    <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>

                                    <div class="col-md-8">
                                        <input type="text" id="first_name" v-model="first_name" v-bind:class="[errorFName? is_invalid:'', form_control]" required autofocus>

                                        
                                        <span v-if="error && errors.first_name" class="invalid-feedback" role="alert">
                                            <div v-for="msg in errors.first_name">
                                                <strong>{{ msg }}</strong>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>

                                    <div class="col-md-8">
                                        <input type="text" id="last_name" v-model="last_name" v-bind:class="[errorLName? is_invalid:'', form_control]" required autofocus>

                                        
                                        <span v-if="error && errors.last_name" class="invalid-feedback" role="alert">
                                            <div v-for="msg in errors.last_name">
                                                <strong>{{ msg }}</strong>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                                    <div class="col-md-8">
                                        <input type="text" id="username" v-model="username" v-bind:class="[errorUsername? is_invalid:'', form_control]" required>

                                        <span v-if="errorUsername" class="invalid-feedback" role="alert">
                                            <div v-for="msg in errors.username">
                                                <strong>{{ msg }}</strong>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                                            
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                    <div class="col-md-8">
                                        <input type="email" id="email" v-model="email" v-bind:class="[errorEmail? is_invalid:'', form_control]" required>

                                        <span v-if="errorEmail" class="invalid-feedback" role="alert">
                                            <div v-for="msg in errors.email">
                                                <strong>{{ msg }}</strong>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-8">
                                        <input type="password" id="password" v-model="password" v-bind:class="[errorPassword? is_invalid:'', form_control]" required>

                                        <span v-if="errorPassword" class="invalid-feedback" role="alert">
                                            <div v-for="msg in errors.password">
                                                <strong>{{ msg }}</strong>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                    <div class="col-md-8">
                                        <input type="password" v-model="password_confirmation" id="password-confirm" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">Register</button>
                                    </div>
                                </div>
                            </form>
                        
                        <p class="text-center margin-top-20">Or signup with social media:</p>
                        <div class="text-center">
                            <fb-signin-button
                                :params="fbSignInParams"
                                @success="onSignInSuccess"
                                @error="onSignInError">
                                Sign in with Facebook
                              </fb-signin-button>

                              <g-signin-button
                                :params="googleSignInParams"
                                @success="onGoogleSignInSuccess"
                                @error="onGoogleSignInError">
                                Sign in with Google
                              </g-signin-button>
                        </div>

                        <p class="text-center margin-top-20">
                            Have an account? <a href="javascript:void(0)" data-toggle="modal" data-target="#modalLogin" data-dismiss="modal">Login</a>
                        </p>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <Login></Login>
    </div>
</template>

<script>
    window.fbAsyncInit = function() {
        FB.init({
          appId      : '1254483651249303',
          cookie     : true,  // enable cookies to allow the server to access the session
          xfbml      : true,  // parse social plugins on this page
          version    : 'v2.8' // use graph api version 2.8
        });
        };
        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    import Vue from 'vue';
    import FBSignInButton from 'vue-facebook-signin-button'
    import GSignInButton from 'vue-google-signin-button'
    Vue.component('Login', require('./LoginModal.vue').default);
    
    Vue.use(FBSignInButton)
    Vue.use(GSignInButton)

    export default {
        data(){
            return {
                form_control:'form-control',
                is_invalid:'is-invalid',

                first_name: '',
                last_name: '',
                username: '',
                email: '',
                password: '',
                password_confirmation:'',
                errorFName:false,
                errorLName:false,
                errorUsername:false,
                errorEmail:false,
                errorPassword:false,
                error: false,
                errors: {},
                success: false,
                fbSignInParams: {
                    scope: 'email',
                    return_scopes: true
                },
                googleSignInParams: {
                    client_id: '969586418026-83hk93qrmmgf711nqhru9gfbl1ik5k6i.apps.googleusercontent.com'
                }
            };
        },
        methods: {
            register(){
                var app = this
                
                this.$auth.register({
                    params: {
                        first_name: app.first_name,
                        last_name: app.last_name,
                        username: app.username,
                        email: app.email,
                        password: app.password,
                        password_confirmation: app.password_confirmation
                    }, 
                    success: function (response) {
                        app.success = true
                    },
                    error: function (error) {
                        console.log("error");
                        console.log(error.response.data.errors);
                        this.error = true;
                        this.errors = error.response.data.errors;

                        if(this.errors.first_name){
                            this.errorFName = true;
                        }

                        if(this.errors.last_name){
                            this.errorLName = true;
                        }

                        if(this.errors.username)
                        {
                            this.errorUsername = true;
                        }

                        if(this.errors.email)
                        {
                            this.errorEmail = true;
                        }
                        
                        if(this.errors.password)
                        {
                            this.errorPassword = true;
                        }
                    },
                    redirect: null
                });
            }, // end of register method
            onSignInSuccess (response) {
                var app = this

                FB.api('/me', dude => {
                    console.log(dude);
                    
                    axios.post('auth/fb_login',{
                        fb_id: dude.id,
                        name: dude.name
                    })
                    .then(response => {
                        console.log("success");
                        console.log(response.data)

                        app.$auth.login({
                            params: {
                                fb_id : dude.id
                            }, 
                            success: function (response) {
                                console.log(response);
                                if(app.$auth.user().role=='admin')
                                {
                                    window.location = this.base_url + "api/admin/";
                                }
                            },
                            error: function (error) {
                                this.error = true;
                            },
                            rememberMe: true,
                            redirect: '/dashboard',
                            fetchUser: true,
                        }); 
                    })
                    .catch(error => {
                        console.log("error");
                        console.log(error.response);
                    })
                }) //fb login end
            },
            
            onSignInError (error) {
                console.log('OH NOES', error)
            },

            onGoogleSignInSuccess (googleUser) {
                const profile = googleUser.getBasicProfile() // etc etc
                console.log(profile);

                var app = this
                
                axios.post('auth/google_login',{
                    google_id: profile.Eea,
                    first_name: profile.ofa,
                    last_name: profile.wea,
                    email: profile.U3,
                    google_avatar: profile.Paa,
                })
                .then(response => {
                    console.log("success");
                    console.log(response.data)

                    app.$auth.login({
                        params: {
                            google_id : profile.Eea
                        }, 
                        success: function (response) {
                            console.log(response);
                            if(app.$auth.user().role=='admin')
                            {
                                window.location = this.base_url + "api/admin/";
                            }
                        },
                        error: function (error) {
                            this.error = true;
                        },
                        rememberMe: true,
                        redirect: '/dashboard',
                        fetchUser: true,
                    }); 
                })
                .catch(error => {
                    console.log("error");
                    console.log(error.response);
                })

            }, // end of onGoogleSignInSuccess
            onGoogleSignInError (error) {
              console.log('OH NOES', error)
            }
        }
    }
</script>


<style>
.fb-signin-button {
  display: inline-block;
  padding: 10px 10px;
  border-radius: 3px;
  background-color: #4267b2;
  color: #fff;
}

.g-signin-button {
  display: inline-block;
  padding: 10px 12px;
  border-radius: 3px;
  background-color: #3c82f7;
  color: #fff;
}
</style>
