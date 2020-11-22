<template>
    <div class="home h-100">
        <AlertNotification :show="alertShow" :message="alertMessage" :error="alertError"/>

        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
            <router-link to="/home" class="navbar-brand mr-auto mr-lg-0">{{appname}}</router-link>
            <button class="btn btn-outline-success d-block d-lg-none" type="button" @click="logout">
                Logout
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <div class="my-2 my-lg-0 text-right w-100">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="button" @click="logout">Logout</button>
                </div>
            </div>
        </nav>

        <div class="nav-scroller bg-white shadow-sm">
            <nav class="nav nav-underline">
                <router-link to="/home/list" active-class="active" class="nav-link">Lists</router-link>
                <router-link to="/home/create" active-class="active" class="nav-link">Create</router-link>
            </nav>
        </div>

        <router-view name="home_route_view" @forcelogout="save" @showalert="showAlert" @showdialog="showDialog"/>

        <CustomDialog 
            :title="modalTitle"
            :subtitle="modalSubtitle"
            :yestext="modalYes" 
            @yesfn="save"
            @cancelfn="cancel"
            :showDialog="modalShow" /> 
    </div>
</template>

<script>
export default {
    data() {
        return {
            appname: process.env.VUE_APP_APPNAME,
            modalTitle: '',
            modalSubtitle: '',
            modalYes: '',
            modalShow: false,
            alertShow: false,
            alertMessage: '',
            alertError: true,
        }
    },
    methods: {
        save() {
            this.$cookie.removeCookie('vue-ci-token');
            this.$cookie.removeCookie('vue-ci-id');
            this.$router.push({name:'login'});
        },
        cancel() {
            this.modalShow = false;
        },
        logout() {
            this.modalTitle = "Notice";
            this.modalSubtitle = "Do you want to logout";
            this.modalYes = "Logout";
            this.modalShow = true;
        },
        showAlert(args) {
            this.alertShow = true;
            this.alertMessage = args.message;
            this.alertError = args.error;

            this.timer = setTimeout(() => {
                this.alertShow = false;
                this.alertMessage = '';
                 this.alertError = true;
            }, 2000)
        }   
    },
    mounted() {
        this.$router.push({name:'home/list'});
    }
}
</script>

<style>

</style>