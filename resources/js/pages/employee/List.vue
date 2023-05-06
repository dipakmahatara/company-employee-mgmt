<template>
    <div class="mx-auto w-full py-12">
        <div class="flex justify-end mb-4">
            <router-link :to='{name:"employeeAdd"}' class="inline-flex items-center gap-2 w-fit text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                </svg> Add new employee
            </router-link>
        </div>
        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mb-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            First Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Last Name
                        </th>
                        
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Company
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Phone
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody v-if="employees && employees.data">
                    <tr v-for="(employee,index) in employees.data" :key="index">
                        <td class="px-6 py-4">{{ employee.first_name }} </td>
                        <td class="px-6 py-4">{{ employee.last_name }}</td>
                        <td class="px-6 py-4">{{ employee.email }}</td>
                        <td class="px-6 py-4">{{ employee.company?.name }}</td>
                        <td class="px-6 py-4">{{ employee.phone }}</td>
                        <td class="px-6 py-4">
                            <router-link :to='{name:"employeeEdit",params:{id:employee.id}}' class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-3">Edit</router-link>
                            <button type="button" @click="deleteEmployee(employee.id)"  class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
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
            :data="employees"
            @pagination-change-page="list"
        />
    </div>
</template>
   
<script>
    import { TailwindPagination } from 'laravel-vue-pagination';
    export default {
        name:"employees",
        components:{
            TailwindPagination
        },
        data(){
            return {
                employees:{
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
                await axios.get(`/api/employees?page=${page}`).then(({data})=>{
                    this.employees = data
                }).catch(({ response })=>{
                    if(response.status==401){
                        localStorage.removeItem('AUTH_TOKEN')
                        this.$router.push('/')
                    }
                    console.error(response)
                })
            },
            deleteEmployee(id){
                if(confirm("Are you sure to delete this employee ?")){
                    axios.delete(`/api/employees/${id}`).then(response=>{
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