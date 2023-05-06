import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: () => import('./pages/auth/Login.vue')
        },
        {
            name: 'companyList',
            path: '/companies',
            component: () => import('./pages/company/List.vue')
        },
        {
            name: 'companyEdit',
            path: '/company/:id/edit',
            component: () => import('./pages/company/Edit.vue')
        },
        {
            name: 'companyAdd',
            path: '/company/add',
            component: () => import('./pages/company/Add.vue')
        },
        {
            name: 'employeeList',
            path: '/employees',
            component: () => import('./pages/employee/List.vue')
        },
        {
            name: 'employeeEdit',
            path: '/employee/:id/edit',
            component: () => import('./pages/employee/Edit.vue')
        },
        {
            name: 'employeeAdd',
            path: '/employee/add',
            component: () => import('./pages/employee/Add.vue')
        }
    ],
})
router.beforeEach((to, from, next) => {
    if (to.path !== '/' && !isAuthenticated()) {
        return next({path: '/'})
    }
    return next()
})

function isAuthenticated() {
    return Boolean(localStorage.getItem('AUTH_TOKEN'))
}

export default router;
