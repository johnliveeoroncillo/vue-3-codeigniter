<template>
    <main role="main" class="container">
        <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
            <img class="mr-3" src="assets/vue-ci.png" alt="" width="48" height="48">
            <div class="lh-100">
            <h6 class="mb-0 text-white lh-100">{{appname}}</h6>
            <small>Created 2020 by JL</small>
            </div>
        </div>

        <AlertMessage :class="alertClass" :alertMessage="alertMessage" />

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0">Create New User</h6>

            <div class="media text-muted pt-3">
                <div class="row w-100">
                    <div class="col-sm-4">
                        <label>Username</label>
                        <input type="text" class="form-control" required v-model="i_username">
                    </div>
                    <div class="col-sm-4">
                        <label>Password</label>
                        <input type="password" class="form-control" required v-model="i_password">
                    </div>
                    <div class="col-sm-4">
                        <label>Status</label>
                        <select class="form-control" required v-model="i_status">
                            <option v-for="status in statuses" :key="status.id" :value="status.id">{{status.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="d-flex flex-row text-right mt-3 justify-content-end">
                <CustomButton :class="'btn btn-primary'" :loading="btnLoading" @click="save()">Create User</CustomButton>
                <CustomButton :class="'btn btn-light ml-2'" @click="reset()">Reset</CustomButton>
                <router-link to="/home/list" class="btn btn-dark ml-2">List</router-link>
            </div>
        </div>
    </main> 
</template>

<script>
export default {
    data() {
        return {
            appname: process.env.VUE_APP_APPNAME,
            statuses: [{
                        id: 'ATV',
                        name: 'Active'
                        }, 
                        { 
                        id:'ITV',
                        name: 'Inactive'
                        }],
            i_username: '',
            i_password: '',
            i_status: 'ATV',
            alertClass: '',
            alertMessage: '',
            btnLoading: false
        }
    },
    methods: {
        reset() {
            this.i_username = '';
            this.i_password = '';
            this.i_status = 'ATV';
        },
        save() {
            this.btnLoading = true;
            this.$axios.post('/api/create',this.$qs.stringify({u:this.i_username,p:this.i_password,s:this.i_status}))
            .then((response) => {
                let data = response.data;
                if(data.error !== undefined) {
                    this.i_username = '';
                    this.i_password = '';
                    this.i_status = 'ATV';
                }
                this.$emit("showalert",{message:data.message,error:data.error});
                this.btnLoading = false;
                
            })
            .catch((error) => {
                this.btnLoading = false;
                this.$emit("showalert", {message:error});
                
            });
        }
    }
}
</script>