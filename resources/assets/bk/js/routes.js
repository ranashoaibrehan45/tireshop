import VueRouter from 'vue-router';

import Dashboard from './components/Dashboard.vue';
import Home from './components/Home.vue';
import Register from './components/Register.vue';
import Login from './components/Login.vue';

// tasker profile components
import TaskerCreateProfile_Step1 from './components/tasker/TaskerCreateProfile_Step1.vue';
import TaskerCreateProfile_Step2 from './components/tasker/TaskerCreateProfile_Step2.vue';
import TaskerCreateProfile_Step3 from './components/tasker/TaskerCreateProfile_Step3.vue';
import TaskerCreateProfile_Step4 from './components/tasker/TaskerCreateProfile_Step4.vue';
import TaskerCreateProfile_Step5 from './components/tasker/TaskerCreateProfile_Step5.vue';
import TaskerCreateProfile_Completed from './components/tasker/TaskerCreateProfile_Completed.vue';

// Task components
import TaskInterest from './components/task/CreateTask_Interest.vue';
import TaskLocation from './components/task/CreateTask_Location.vue';
import TaskDetail from './components/task/CreateTask_Detail.vue';
import TaskInstructions from './components/task/CreateTask_Instructions.vue';
import ChooseTaskers from './components/task/CreateTask_ChooseTasker.vue';
import ConfirmTask from './components/task/CreateTask_Confirm.vue';
import  PostedTasks from './components/task/PostedTasks.vue';
import  ExpertTasks from './components/task/ExpertTasks.vue';
import  ClientTasks from './components/task/ClientTasks.vue';
import  TasksBidding from './components/task/TaskBidding.vue';

import  Inbox from './components/conversation/Inbox.vue';
import  InboxDetails from './components/conversation/InboxDetails.vue';


const router = new VueRouter({
    routes: [
                {
                    path: '/',
                    name: 'home',
                    component: Home
                }
                ,{
                    path: '/register',
                    name: 'register',
                    component: Register,
                    meta: {
                        auth: false
                    }
                }
                ,{
                    path: '/login/:verify?/:token?',
                    name: 'login',
                    component: Login,
                    meta: {
                        auth: false
                    }
                },
                {
                    path: '/dashboard',
                    name: 'dashboard',
                    component: Dashboard,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/register/commitment',
                    name: 'TaskerCreateProfile_Step1',
                    component: TaskerCreateProfile_Step1,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/register/eligibility',
                    name: 'TaskerCreateProfile_Step2',
                    component: TaskerCreateProfile_Step2,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/register/categories',
                    name: 'TaskerCreateProfile_Step3',
                    component: TaskerCreateProfile_Step3,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/register/background-consent-first',
                    name: 'TaskerCreateProfile_Step4',
                    component: TaskerCreateProfile_Step4,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/register/background-consent-second',
                    name: 'TaskerCreateProfile_Step5',
                    component: TaskerCreateProfile_Step5,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/register/tasker/success',
                    name: 'TaskerCreateProfile_Completed',
                    component: TaskerCreateProfile_Completed,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/task/interest',
                    name: 'taskInterest',
                    component: TaskInterest
                },
                {
                    path: '/task/location',
                    name: 'taskLocation',
                    component: TaskLocation
                },
                {
                    path: '/task/details',
                    name: 'taskDetail',
                    component: TaskDetail
                },
                {
                    path: '/task/instructions',
                    name: 'taskInstructions',
                    component: TaskInstructions
                },
                {
                    path: '/task/choose-taskers',
                    name: 'chooseTasker',
                    component: ChooseTaskers
                },
                {
                    path: '/task/confirm',
                    name: 'confirmTask',
                    component: ConfirmTask,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/tasks',
                    name: 'postedTasks',
                    component: PostedTasks,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/taskers/tasks',
                    name: 'expertTasks',
                    component: ExpertTasks,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/task/bidding/:id',
                    name: 'taskBidding',
                    component: TasksBidding,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/client/tasks',
                    name: 'clientTasks',
                    component: ClientTasks,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/inbox',
                    name: 'inbox',
                    component: Inbox,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/inbox/message/:bidId',
                    name: 'InboxDetails',
                    component: InboxDetails,
                    meta: {
                        auth: true
                    }
                },
    ]
});

Vue.router = router
