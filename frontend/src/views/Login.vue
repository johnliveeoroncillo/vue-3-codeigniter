<template>
    <div class="login-container">
        <div class="form-signin">
            <img class="mb-4" src="assets/vue-ci.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <p>Username: admin, Password: admin</p>
            <label class="sr-only">Username</label>
            <input @keyup.enter="signin" type="text" class="form-control" placeholder="Username" v-model="username" required autofocus>
            <label class="sr-only">Password</label>
            <input @keyup.enter="signin" type="password" class="form-control" placeholder="Password" v-model="password" required>
            <CustomButton :class="'btn-lg btn-primary btn-block'" :loading="btnLoading" @click="signin">Sign In</CustomButton>
            <AlertMessage :class="alertClass" :alertMessage="alertMessage" />
            <p class="mt-5 mb-3 text-muted">&copy; 2020 {{appname}}</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            appname: process.env.VUE_APP_APPNAME,
            btnLoading: false,
            alertClass: 'alert-danger',
            alertMessage: '',
            username: '',
            password: ''
        }
    },
    methods: {
        signin() {
            this.btnLoading = true; 
            this.$axios.post('api/login', this.$qs.stringify({username:this.username,password:this.password})).then((response) => {
                let data = response.data;
                if(data.flag && data.access_token && data.id) {
                    this.$cookie.setCookie('vue-ci-token', data.access_token, { expire: '1d'});
                    this.$cookie.setCookie('vue-ci-id', data.id, { expire: '1d'});
                    this.$router.push({name:'home'});
                }
                else {
                    this.alertMessage = data.message;
                }
                this.btnLoading = false;
            }).catch((error) => {
                this.alertMessage = error;
                this.btnLoading = false;
            });
        }
    },
    mounted() {
        if(this.$route.query.show401) {
            this.$emit("show401", true);
        }
    }
}
</script>

<style scoped>

.login-container {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
  height: 100%;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>