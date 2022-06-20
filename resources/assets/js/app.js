require('./bootstrap');


import VueRouter from 'vue-router';

import VueAxios from 'vue-axios';
import Notifications from 'vue-notification'
import App from './App.vue';

import Dashboard from './components/Dashboard.vue';
import Login from './components/Login.vue';
import UpdateAccount from './components/UpdateAccount.vue';

import User from './components/user/UserList.vue';
import Company from './components/company/CompanyList.vue';
import Tiresize from './components/tiresize/SizeList.vue';
import Vender from './components/vender/VenderList.vue';
import Service from './components/service/ServiceList.vue';
import TirePurchase from './components/tires/TireList.vue';
import TireStock from './components/tire_stock/TireStockList.vue';
import CreateInvoice from './components/invoices/InvoiceCreate.vue';
import ShowInvoice from './components/invoices/InvoicePreview.vue';
import InvoicesList from './components/invoices/InvoiceList.vue';
import Expense from './components/expense/ExpenseList.vue';
import ExpensePayment from './components/expense_payment/ExpensePaymentList.vue';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Notifications);

axios.defaults.baseURL = 'http://localhost/tireshop/api';
Vue.prototype.base_url = "http://localhost/tireshop/";

const router = new VueRouter({
    routes: [
                {
                    path: '/login',
                    name: 'login',
                    component: Login,
                    meta: {
                        auth: false
                    }
                },
                {
                    path: '/update_account',
                    name: 'update_account',
                    component: UpdateAccount,
                    meta: {
                        auth: true
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
                    path: '/user',
                    name: 'user',
                    component: User,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/company',
                    name: 'company',
                    component: Company,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/tiresize',
                    name: 'tiresize',
                    component: Tiresize,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/vender',
                    name: 'vender',
                    component: Vender,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/service',
                    name: 'service',
                    component: Service,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/tire_purchase',
                    name: 'tire_purchase',
                    component: TirePurchase,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/tire_stock',
                    name: 'tire_stock',
                    component: TireStock,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/generate_invoice',
                    name: 'generate_invoice',
                    component: CreateInvoice,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/invoice/:invoice',
                    name: 'invoice_preview',
                    component: ShowInvoice,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/invoices',
                    name: 'invoices',
                    component: InvoicesList,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/expense_type',
                    name: 'expense_type',
                    component: Expense,
                    meta: {
                        auth: true
                    }
                },
                {
                    path: '/expense_payment',
                    name: 'expense_payment',
                    component: ExpensePayment,
                    meta: {
                        auth: true
                    }
                },
            ]
});

Vue.router = router

Vue.use(require('@websanova/vue-auth'), {
   auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
   http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
   router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});

Vue.filter('toCurrency', function (value) {
    if (typeof value !== "number") {
        return value;
    }
    var formatter = new Intl.NumberFormat('ur-PK', {
        style: 'currency',
        currency: 'PKR',
        currencyDisplay: 'code',
        minimumFractionDigits: 0
    });
    return formatter.format(value);
});

App.router = Vue.router
new Vue(App).$mount('#app');