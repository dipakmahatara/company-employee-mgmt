<template>
    <div class="mx-auto w-full py-12">
        <div class="flex justify-end mb-4">
            <router-link :to='{name:"companyAdd"}' class="inline-flex items-center gap-2 w-fit text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                </svg> Add new company
            </router-link>
        </div>
        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mb-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Company Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Logo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Website
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody v-if="companies && companies.data">
                    <tr v-for="(company,index) in companies.data" :key="index">
                        <td class="px-6 py-4">{{ company.name }} </td>
                        <td class="px-6 py-4">{{ company.email }}</td>
                        <td class="px-6 py-4">
                            <div class="flex -space-x-1 overflow-hidden">
                                <img v-if="company.logo" class="inline-block h-8 w-8 rounded-full ring-2 ring-white" :src="company.logo" alt="">
                                <span v-else class="bg-blue-100 text-blue-800 text-sm font-semibold inline-flex justify-center items-center h-8 w-8 p-2.5 rounded-full dark:bg-gray-700 dark:text-blue-400 capitalize">
                                    {{ (company.name).charAt(0) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ company.website }}</td>
                        <td class="px-6 py-4">
                            <router-link :to='{name:"companyEdit",params:{id:company.id}}' class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-3">Edit</router-link>
                            <button type="button" @click="deleteCompany(company.id)"  class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td class="text-md flex justify-center items-center text-center" colspan="5">No data found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <TailwindPagination
            :item-classes="['bg-blue-500 rounded-md text-white']"               
            :active-classes="['bg-orange-500 rounded-md text-white']"               
            :data="companies"
            @pagination-change-page="list"
        />
    </div>
</template>
   
<script>
    import { TailwindPagination } from 'laravel-vue-pagination';
    export default {
        name:"companies",
        components:{
            TailwindPagination
        },
        data(){
            return {
                companies:{
                    type:Object,
                    default:null
                }
            }
        },
        mounted(){
            this.list()
        },
        methods:{
            async list(page=1){
                await axios.get(`/api/companies?page=${page}`).then(({data})=>{
                    this.companies = data
                }).catch(({ response })=>{
                    if(response.status==401){
                        localStorage.removeItem('AUTH_TOKEN')
                        this.$router.push('/')
                    }
                    console.error(response)
                })
            },
            deleteCompany(id){
                if(confirm("Are you sure to delete this company?")){
                    axios.delete(`/api/companies/${id}`).then(response=>{
                        this.list()
                    }).catch(error=>{
                        console.log(error)
                    })
                }
            }
        }
    }
</script>

<style scoped>
    .pagination{
        margin-bottom: 0;
    }
</style>