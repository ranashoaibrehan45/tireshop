<template>
    <div id="wrapper" v-if="$auth.check()">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">SB Admin v2.0</a>
            </div>
            <!-- /.navbar-header -->
            

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <router-link :to="{name: 'update_account'}">
                                <i class="fa fa-user fa-fw"></i> Update Account
                            </router-link>
                        </li>
                        
                        <li class="divider"></li>
                        <li v-if="$auth.check()">
                            <a href="#" @click.prevent="$auth.logout()"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->


            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.html">
                                <i class="fa fa-dashboard fa-fw"></i> Dashboard
                            </a>
                        </li>
                        
                        <li class="active">
                            <a href="#" class="submenu">
                                <i class="fa fa-bar-chart-o fa-fw"></i> 
                                Add New
                                <span class="fa arrow"></span>
                            </a>
                            
                            <ul class="nav nav-second-level">
                                <li>
                                    <router-link :to="{ name: 'company' }">Companies</router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'tiresize' }">Tire sizes</router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'vender' }">Venders</router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'service' }">Services</router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'tire_purchase' }">Tires Puchasing</router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'expense_type' }">Expense Type</router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'expense_payment' }">Expense Payments</router-link>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#" class="submenu">
                                <i class="fa fa-bar-chart-o fa-fw"></i> 
                                Stock<span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <router-link :to="{ name: 'tire_stock' }">Tires</router-link>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#" class="submenu">
                                <i class="fa fa-bar-chart-o fa-fw"></i> 
                                Sale<span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <router-link :to="{ name: 'generate_invoice' }">Generate Invoice</router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'invoices' }">Invoices List</router-link>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->

        </nav>

        
        <router-view></router-view>
        <notifications group="notification" position="top right" />
    </div>

    <div class="container" v-else>
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

                        <form @submit.prevent="login" method="post" role="form" aria-label="Login">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" v-model="email" placeholder="E-mail" class="form-control" autofocus>
                                </div>

                                <div class="form-group">
                                    <input type="password" v-model="password" class="form-control" placeholder="Password">
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
    import Vue from 'vue';
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
                form_control: 'form-control'
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
                        username: app.email,
                        password: app.password,
                        verified: 1
                    }, 
                    success: function (response) {
                        console.log("login");
                        console.log(response);
                        if(app.$auth.user().role=='admin')
                        {
                            //window.location = this.base_url + "api/admin/";
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
            
        }, // methods end
    }
</script>

<style>
</style>