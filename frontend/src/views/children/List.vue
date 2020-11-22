<template>
    <main role="main" class="container py-2">
        <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
            <img class="mr-3" src="assets/vue-ci.png" alt="" width="48" height="48">
            <div class="lh-100">
            <h6 class="mb-0 text-white lh-100">{{appname}}</h6>
            <small>Created 2020 by JL</small>
            </div>
        </div>

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0">User Lists</h6>

            <div class="media text-center d-flex flex-row justify-content-center py-4" v-if="userLists.length <= 0 && dataLoading == false">
                <h5 class="text-muted">No Data found</h5>
            </div>

            <div class="media text-center d-flex flex-row justify-content-center py-4" v-if="dataLoading">
                <div class="spinner-border text-primary"  role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div class="media text-muted pt-3" :key="user.user_id" v-for="(user, index) in userLists">
                <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" :fill="(user.status == 'ATV' ? '#007bff' : '#dc3545')"/><text x="50%" y="50%" :fill="(user.status == 'ATV' ? '#007bff' : '#dc3545')" dy=".3em">32x32</text></svg>
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray text-ellipsis">
                    <strong class="d-block text-gray-dark">{{user.username}}</strong>
                    {{user.password}}
                </p>
                <button class="btn btn-danger ml-4 btn-sm" @click="deleteUser(index)">Delete User</button>
            </div>
            
            <small class="d-block text-right mt-3">
                <router-link to="/home/create">Create New User</router-link>
            </small>
        </div>
        
        <CustomDialog 
            :title="modalTitle"
            :subtitle="modalSubtitle"
            :yestext="modalYes" 
            @yesfn="save"
            @cancelfn="cancel"
            :showDialog="modalShow" /> 
    </main> 
</template>

<script>
export default {
    data() {
        return {
            userLists: [],
            appname: process.env.VUE_APP_APPNAME,
            modalTitle: '',
            modalSubtitle: '',
            modalShow: false,
            modalYes: '',
            save: '',
            currentIndex: '',
            dataLoading: false
        }
    },
    methods: {
        getUserLists() {
            this.dataLoading = true;
            this.$axios.get('api/users',{})
            .then((response) => {
                var data = response.data;
                if(data.length) {
                    this.userLists = data;
                }
                else {
                    this.userLists = [];
                }
                this.dataLoading = false;
            })
            .catch((error) => {
                console.log(error);
                this.dataLoading = false;
            });
        },
        deleteUser(index) {
            this.currentIndex = index;
            this.save = eval("this.executeDelete");
            this.modalShow = true;
            this.modalTitle = "Delete";
            this.modalSubtitle = "Do you want to delete this user ?";
            this.modalYes = "Delete";
        },
        executeDelete() {
            this.$axios.post('/api/delete',this.$qs.stringify({id:this.userLists[this.currentIndex].user_id}))
            .then((response) => {
                let data = response.data;
                this.$emit("showalert", {message:data.message,error:data.error});

                if(data.error !== undefined) {
                    this.userLists.splice(this.currentIndex, 1);
                }
                this.modalShow = false; 
            })
            .catch((error) => {
                this.$emit("showalert", {message:error});
            });
        },
        cancel() {
            this.modalShow = false;
        },
    },
    mounted() {
        this.getUserLists();
    }
}
</script>