<template>
    <div id="wrapper">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <router-link class="navbar-brand" :to="{ name: 'home' }">Laravel</router-link>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li v-if="!$auth.check()" class="nav-item">
                            <router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
                        </li>
                        <li v-if="!$auth.check()" class="nav-item">
                            <router-link :to="{ name: 'register' }" class="nav-link">Register</router-link>
                        </li>

                        <li class="nav-item">
                            <button class="btn btn-success" @click="postNewProject">Post a Project
                            </button>
                        </li>
                        
                        <li v-if="$auth.check() && $auth.user().role=='admin'" class="nav-item">
                            <a class="dropdown-item" href="api/admin/">Admin Panel
                            </a>
                        </li>
                        
                        <li v-if="$auth.check() && $auth.user().role=='client'" class="nav-item">
                            <router-link :to="{ name: 'TaskerCreateProfile_Step1'}" class="nav-link">
                                Become a Tasker
                            </router-link>
                        </li>

                        <li v-if="$auth.check()" class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Menu <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <router-link :to="{ name: 'TaskerCreateProfile_Step2'}" class="nav-link" v-if="$auth.user().role=='expert'">
                                    Profile
                                </router-link>
                                
                                <router-link :to="{ name: 'postedTasks'}" class="nav-link" v-if="$auth.user().role=='expert'">
                                    Find Work
                                </router-link>

                                <router-link :to="{ name: 'inbox'}" class="nav-link">
                                Inbox
                                </router-link>
                                
                                <router-link :to="{ name: 'expertTasks'}" class="nav-link" v-if="$auth.user().role=='expert'">
                                My Jobs
                                </router-link>
                                
                                <router-link :to="{ name: 'clientTasks'}" class="nav-link">
                                My Posted Tasks
                                </router-link>
                                
                                <a class="nav-link" href="#" @click.prevent="$auth.logout()">Logout</a>
                            </div>
                        </li>


                        
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <router-view></router-view>
        </main>
        <notifications group="notification" position="top right" />
    </div>
</template>
<script type="text/javascript">
    export default{
        methods:{
            postNewProject(){
                this.$ls.remove('task');
                this.$router.push({name: 'home'});
            }
        }
    }
</script>