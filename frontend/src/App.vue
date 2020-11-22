<template>
    <AlertNotification :show="showAlert" :message="messageAlert" />
    <router-view @show401="show401Alert" />
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
        showAlert: false,
        messageAlert: '',
        timer: ''
    }
  },
  methods: {
      show401Alert() {
          this.$router.replace({query:undefined});
          if(this.timer) {
              clearTimeout(this.timer);
          }

          this.showAlert = true;
          this.messageAlert = "Unauthorized Access, please relogin";
          this.timer = setTimeout(() => {
              this.showAlert = false;
              this.messageAlert = '';
          }, 2000)
      },
  }
}
</script>

<style>
html, body, #app {
  width: 100%;
  height: 100%;
}

body {
  -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;
}

.b-0 {
  border: 0;;
}

.modal.show {
  display: block;
}

.modal.show:before {
  background: #0000006e;
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
}

.home {
  padding-top: 56px;
}

@media (max-width: 991.98px) {
  .offcanvas-collapse {
    position: fixed;
    top: 56px; /* Height of navbar */
    bottom: 0;
    left: 100%;
    width: 100%;
    padding-right: 1rem;
    padding-left: 1rem;
    overflow-y: auto;
    visibility: hidden;
    background-color: #343a40;
    transition: visibility .3s ease-in-out, -webkit-transform .3s ease-in-out;
    transition: transform .3s ease-in-out, visibility .3s ease-in-out;
    transition: transform .3s ease-in-out, visibility .3s ease-in-out, -webkit-transform .3s ease-in-out;
  }
  .offcanvas-collapse.open {
    visibility: visible;
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%);
  }
}

.nav-scroller {
  position: relative;
  z-index: 2;
  height: 2.75rem;
  overflow-y: hidden;
}

.nav-scroller .nav {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: nowrap;
  flex-wrap: nowrap;
  padding-bottom: 1rem;
  margin-top: -1px;
  overflow-x: auto;
  color: rgba(255, 255, 255, .75);
  text-align: center;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
}

.nav-underline .nav-link {
  padding-top: .75rem;
  padding-bottom: .75rem;
  font-size: .875rem;
  color: #6c757d;
}

.nav-underline .nav-link:hover {
  color: #007bff;
}

.nav-underline .active {
  font-weight: 500;
  color: #343a40;
}

.text-white-50 { color: rgba(255, 255, 255, .5); }

.bg-purple { background-color: #6f42c1; }

.lh-100 { line-height: 1; }
.lh-125 { line-height: 1.25; }
.lh-150 { line-height: 1.5; }

.text-ellipsis {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}


.btn-loading {
    position: relative;
    text-align: center;
    vertical-align: middle;
    display: flex;
    justify-content: center;
    align-items: center;
    align-self: center;
}

.btn-loading:before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: inherit;
  width: 100%;
  height: 100%;
}

.btn-loading:after {
  content: '';
  position: absolute;
  display: flex;
  width: 30px;
  height: 30px;
  vertical-align: text-bottom;
  border: .25em solid #ffffff9c;
  border-right-color: transparent;
  border-radius: 50%;
  -webkit-animation: spinner-border .75s linear infinite;
  animation: spinner-border .75s linear infinite;
}


@-webkit-keyframes spinner-border {
  to {
      -webkit-transform:rotate(360deg);transform:rotate(360deg)
    }
}

@keyframes spinner-border {
  to {
    -webkit-transform:rotate(360deg);transform:rotate(360deg)
  }
}

.alert-float {
    position: absolute;
    right: 10px;
    top: 10px;
    max-width: 30%;
    width: 100%;
    opacity: 0;
    z-index: 9999;;
}


@media screen and (max-width: 991px) {
  .alert-float {
    max-width: 80%;
  }
}

.fade {
  opacity: 0;
  -webkit-transition: opacity 0.5s linear;
  -moz-transition: opacity 0.5s linear;
  -o-transition: opacity 0.5s linear;
  transition: opacity 0.5s linear;
}

.fade.in {
  opacity: 1;
}
</style>
