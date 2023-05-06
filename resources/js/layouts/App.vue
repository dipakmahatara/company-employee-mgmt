<template>
    <div class="bg-white">
        <header v-if="checkLoggedIn!=0" class="fixed inset-x-0 top-0 z-50 shadow-lg">
        <nav class="flex items-center justify-between p-6 lg:px-8 bg-white" aria-label="Global">
        <div class="flex lg:flex-1">
            <div class="flex gap-x-5 lg:gap-x-4">
                <router-link exact-active-class="text-blue-700" to="/companies" class="text-md font-semibold leading-6">Companies</router-link>
                <router-link exact-active-class="text-blue-700" to="/employees" class="text-md font-semibold leading-6">Employees</router-link>
            </div>
        </div>
        
        <div class="flex lg:flex-1 lg:justify-end">
            <button type="button" @click="handleLogout" class="text-md font-semibold leading-6 text-gray-900 inline-flex items-center gap-1">Log out
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
            </button>
        </div>
        </nav>
    </header>
    
        <div class="relative isolate" :class="{  'px-6 pt-14 lg:px-8' : checkLoggedIn }">
            <router-view></router-view>
        </div>   
    </div>
</template>

<script>
import {ref, onMounted} from 'vue'
import { useRouter } from 'vue-router';

export default {
    data(){
        return {
            
        }
    },
    mounted(){
        this.loggedIn()
    },

    computed:{
        checkLoggedIn() {
        return this.$route.path != '/';
        }
    },
    methods:{
        handleLogout(){    
            localStorage.removeItem('AUTH_TOKEN')
            this.$router.push('/')
        },

        loggedIn() {
            if(localStorage.getItem('AUTH_TOKEN')){
                this.$router.push({path:"/companies"})
            }
            else{
                this.$router.push({path:"/"})
            }
        },
    }
}
</script>