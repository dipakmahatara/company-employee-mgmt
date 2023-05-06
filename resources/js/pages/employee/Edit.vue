<template>
      <div class="mx-auto w-full py-12">
        <div class="flex justify-end mb-4">
            <router-link :to='{name:"employeeList"}' class="inline-flex items-center gap-2 w-fit text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg> Back to employee list
            </router-link>
        </div>
        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mb-4 px-5 py-4">
            <div class="mb-5">
                <div v-for="(errorArray, idx) in notifmsg" :key="idx">
                    <span class="text-red-500 font-bold">{{ errorArray}} </span>
                </div>
            </div>
            <form class="w-full" @submit.prevent="update">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="first_name">
                        First Name
                    </label>
                    <input v-model="employee.first_name" class="appearance-none block w-full text-gray-700 border border-gray-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="first_name" type="text" placeholder="Jane" required>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="last_name">
                        Last Name
                    </label>
                    <input v-model="employee.last_name" class="appearance-none block w-full text-gray-700 border border-gray-300 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="last_name" type="text" placeholder="Doe" required>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                        Email
                    </label>
                    <input v-model="employee.email" class="appearance-none block w-full text-gray-700 border border-gray-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" type="email" placeholder="john@doe.com">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="company_id">
                            Select Company
                        </label>
                        <div class="relative">
                            <select v-model="employee.company_id" class="block appearance-none w-full border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="company_id" required>
                                <option value="">Select company</option>
                                <option v-for="option in companies" :value="option.id">
                                    {{ option.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="phone">
                            Phone
                        </label>
                        <input v-model="employee.phone" class="appearance-none block w-full text-gray-700 border border-gray-300 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="phone" type="number" placeholder="014908123">
                    </div>

                    <div class="mt-4 mr-3 w-full flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 w-fit text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                        Update employee
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name:"update-employee",
    data(){
        return {
            companies:[],
            notifmsg: '',
            employee:{
                first_name:"",
                last_name:"",
                phone:"",
                email:"",
                company_id:"",
                _method:"patch",
            }
        }
    },
    mounted(){
        this.showEmployee()
        this.getCompanylist()
    },
    methods:{
        async showEmployee(){
            await axios.get(`/api/employees/${this.$route.params.id}`).then(response=>{
                const { first_name, last_name, phone, email, company_id } = response.data
                this.employee.first_name = first_name
                this.employee.last_name = last_name
                this.employee.phone = phone
                this.employee.company_id = company_id
                this.employee.email = email
            }).catch(error=>{
                if(error.response.status==401){
                    localStorage.removeItem('AUTH_TOKEN')
                    this.$router.push('/')
                }
                console.log(error)
            })
        },
        async getCompanylist(){
            await axios.get(`/api/get-all-companies`).then(({data})=>{
                this.companies = data
            }).catch(({ response })=>{
                console.error(response)
            })
        },
        async update(){
            await axios.post(`/api/employees/${this.$route.params.id}`,this.employee).then(response=>{
                alert(response.data.message)
                this.$router.push({name:"employeeList"})
            }).catch(error=>{
                console.log(error)
                this.notifmsg = error.response.data.errors
            })
        }
    }
}
</script>