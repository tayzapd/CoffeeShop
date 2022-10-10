import { createRouter, createWebHistory } from "vue-router";
import Main from './components/Main.vue';
import About from './components/Layouts/About.vue';
// import Welcome from './components/Layouts/Welcome.vue';
import Login from './components/Auth/Login.vue';
import Register from './components/Auth/Register.vue';
import Manager from './components/Manager/Dashboard.vue';
import MRole from './components/Manager/Role/MRole.vue';


// Managers , Waiter and Coustumer 
import Managers from './components/Manager/Role/Manager.vue';
import Waiters from './components/Manager/Role/Waiter.vue';
import Customers from './components/Manager/Role/Customer.vue';

// Product And Category 
import Categories from './components/Manager/Category/Categories.vue';
import Products from './components/Manager/Product/Products.vue';

// Report And Feedbacks 
import Report from './components/Manager/Report/Reports.vue';

const Welcome = {
    template: "Hello"
}

// routes 
const routes = 
[
    {
        path:`/`,
        name:"Welcome",
        component:Welcome
    },

    {
        path:`/about`,
        name:"About",
        component:About
    },

    {
        path:`/login`,
        name:"Login",
        component:Login
    },

    {
        path:`/register`,
        name:"Register",
        component:Register
    },

    {
        path:`/manager/`,
        name:"Manager",
        component:Manager,
        children: [
            {
                path:'/',
                name:"Manager Dashboard",
                component:Welcome
            },
            {
                path: 'role/',
                name:"Roles Setting ",
                component: MRole
            },
            {
                path: 'role/manager',
                name:"Managers ",
                component: Managers
            },
            {
                path: 'role/waiter',
                name:"Waiters ",
                component: Waiters
            },
            {
                path: 'role/customers',
                name:"Customers ",
                component: Customers
            },
            {
                path: 'categories',
                name:"Categories ",
                component: Categories
            },

            {
                path: 'products',
                name:"Products ",
                component: Products
            },
            {
                path: 'reports',
                name:"Reports ",
                component: Report
            },
        ]
          ,
         beforeEnter: async (to, from) => {
             // Checking User Has Manger Role  ? 
            if(localStorage.getItem('token' == null)) return `/login`;
            var  res = await axios.post(`/api/check-manager`,{user_id:localStorage.getItem('user_id')}).then(res => res.data);
            if(res != true) return `/login`;
            return res;
          },
    },

];

const router = createRouter({
    history:createWebHistory(),
    routes
});

export default router;
