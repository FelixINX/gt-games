<template>
    <p>Redirection en cours</p>
</template>

<script>
  export default {
    name: 'AuthLoginEmail',
    mounted() {
      if (this.$route.params.method === 'login') {
        window.location = '/login/google'
      }

      if (this.$route.params.method === 'login-email') {
        window.location = '/login'
      }

      if (this.$route.params.method === 'logout') {
        window.location = '/logout'
      }

      if (this.$route.params.method === 'github') {
        var newWindow = window.open('https://github.com/felixinx/gt-games', '_blank')
        newWindow.focus()
        this.$router.go(-1)
      }
    },
  }
</script>

<style scoped>

</style>