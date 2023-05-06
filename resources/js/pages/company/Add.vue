<template>
    <div class="mx-auto w-full py-12">
        <div class="flex justify-end mb-4">
            <router-link :to='{name:"companyList"}' class="inline-flex items-center gap-2 w-fit text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg> Back to company list
            </router-link>
        </div>
        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mb-4 px-5 py-4">
            <div class="mb-5">
                <div v-for="(errorArray, idx) in notifmsg" :key="idx">
                    <span class="text-red-500 font-bold">{{ errorArray}} </span>
                </div>
            </div>
            <form class="w-full" @submit.prevent="create" enctype="multipart/form-data">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                            Company Name
                        </label>
                        <input v-model="company.name" class="appearance-none block w-full text-gray-700 border border-gray-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="name" type="text" placeholder="Jane" required>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                            Email
                        </label>
                        <input v-model="company.email" class="appearance-none block w-full text-gray-700 border border-gray-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" type="email" placeholder="john@doe.com">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="website">
                            website
                        </label>
                        <input v-model="company.website" class="appearance-none block w-full text-gray-700 border border-gray-300 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="website" type="text" placeholder="www.company.com">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="logo">
                            Choose Logo
                        </label>
                        <input ref="file" @change="onFileChange()" class="appearance-none block w-full text-gray-700 border border-gray-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="file" placeholder="john@doe.com">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="mt-4 mr-3 w-full flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 w-fit text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center">
                        Save company
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name:"add-company",
    data(){
        return {
            successMessage: '',
            notifmsg: '',
            company:{
                name:"",
                email:"",
                logo:"",
                website:"",
            }
        }
    },
    methods:{
        onFileChange(){    
            this.company.logo = this.$refs.file.files[0]
        },
        async create(){
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append("name", this.company.name);
            formData.append("email", this.company.email);
            formData.append("website", this.company.website);
            formData.append('logo', this.company.logo);

            await axios.post('/api/companies', formData, config)
            .then(response=>{
                alert(response.data.message)
                this.$router.push({name:"companyList"})
            }).catch(error=>{
                if(error.response.status==401){
                    localStorage.removeItem('AUTH_TOKEN')
                    this.$router.push('/')
                }
                console.log(error)
                this.notifmsg = error.response.data.errors
            })
        }
    }
}
</script>