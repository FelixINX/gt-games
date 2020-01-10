<template>
    <p>Redirection en cours</p>
</template>

<script>
  export default {
    name: 'AuthLogin',
    mounted() {
      window.location = '/login/google'
    }
  }
</script>

<style scoped>

</style>