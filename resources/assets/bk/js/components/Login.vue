<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    
                    <div class="card-body">
                        <div v-if="success" class="alert alert-success" role="alert">
                            <strong>Well done!</strong> {{msg}}</a>.
                        </div>
                        <div v-if="error" class="alert alert-danger" role="alert">
                            There was an error, unable to sign in with those credentials.
                        </div>

                        <form @submit.prevent="login" method="post" aria-label="Login">
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input type="email" id="email" v-model="email" v-bind:class="[errorEmail? is_invalid:'', form_control]" required>

                                    <span v-if="errorEmail" class="invalid-feedback" role="alert">
                                        <div v-for="msg in error.email">
                                            <strong>{{ msg }}</strong>
                                        </div>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input type="password" id="password" v-model="password" v-bind:class="[errorPassword? is_invalid:'', form_control]" required>

                                    <span v-if="errorPassword" class="invalid-feedback" role="alert">
                                        <div v-for="msg in error.password">
                                            <strong>{{ msg }}</strong>
                                        </div>
                                    </span>
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember">Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </button>
    
                                    <a class="btn btn-link" href="#">Forgot Your Password?</a>
                                </div>
                            </div>
                        </form>
                        
                        <p class="text-center margin-top-20">Or login with social media:</p>
                        
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

                    </div>
                </div>
            </div>
        </div>
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
    
    Vue.use(FBSignInButton)
    Vue.use(GSignInButton)

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
                fbSignInParams: {
                    scope: 'email',
                    return_scopes: true
                },
                googleSignInParams: {
                    client_id: '969586418026-83hk93qrmmgf711nqhru9gfbl1ik5k6i.apps.googleusercontent.com'
                }
            }
        },
        created() {
        
            if(this.$route.params.verify!=undefined && this.$route.params.token!=undefined)
            {
                console.log('The id is: ' + this.$route.params.verify);
                console.log('The id is: ' + this.$route.params.token);
            

                this.axios.get(this.axios.defaults.baseURL+"/user/verify/" + this.$route.params.token)
                .then(response => {
                    console.log(response.data);

                    if(response.data.success==1)
                    {
                        this.success = true;
                        this.msg = response.data.msg;                       
                    }
                    else if(response.data.success==0)
                    {
                        this.error = true;
                        this.msg = response.data.msg;
                    }
                })
                .catch(error => {
                    console.log(error.response);
                })
            }
        
        },
        methods: {
            login(){
                var app = this
                this.$auth.login({
                    params: {
                        email: app.email,
                        password: app.password,
                        verified: 1
                    }, 
                    success: function (response) {
                        console.log("login");
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
            },
            
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