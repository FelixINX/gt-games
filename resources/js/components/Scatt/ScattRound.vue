<template>
    <div id="scatt-round">
        <v-card color="cyan" class="mb-4">
            <v-card-title>Lettre {{ stateRound.letter }}</v-card-title>
        </v-card>
        <v-card class="mb-4">
            <v-card-title>Go!</v-card-title>
            <v-card-text>
                <v-text-field v-for="category in stateCategories" :key="category.id"
                              :label="category.title" v-model="stateRoundAnswers[category.id]"></v-text-field>
            </v-card-text>
        </v-card>
        <v-btn block color="error" x-large class="mb-4" :loading="stopLoading" @click="apiStopRound">Arrêter</v-btn>
    </div>
</template>

<script>
  import { VCard, VCardTitle, VCardText, VTextField, VBtn } from 'vuetify/lib'
  export default {
    name: 'ScattRound',
    components: { VCard, VCardTitle, VCardText, VTextField, VBtn },
    computed: {
      stateCategories () {
        return this.$store.state.scattGame.data.categories
      },
      stateRound () {
        return this.$store.state.scattGame.activeRound
      },
      stateRoundAnswers: {
        get () {
          return this.$store.state.scattGame.roundAnswers
        },
        set (answers) {
          this.$store.commit('scattGame/setRoundAnswers', answers)
        }
      },
      isInGame () {
        return this.$store.state.scattGame.data.users.filter(user => (user.id === this.stateUser.id)).length
      }
    },
    data: () => ({
      stopLoading: false,
    }),
    methods: {
      apiStopRound() {
        this.stopLoading = true

        this.$axios.post('/scatt/rounds/' + this.stateRound.id + '/stop', null, {
          params: {api_token: window.userApiToken}
        })
          .then(response => {
            console.log(response)
            this.stopLoading = false
          })
      }
    }
  }
</script>

<style scoped>

</style>