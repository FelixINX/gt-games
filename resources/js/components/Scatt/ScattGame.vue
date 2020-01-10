<template>
    <div id="scatt">
        <v-card color="white" class="mb-4 text-center" v-if="transitionData.active" loading="cyan">
            <v-card-title class="transition-title">{{ transitionData.user }} {{ transitionData.reason }}</v-card-title>
        </v-card>
        <div v-else>
            <component v-bind:is="currentStateComponent"></component>
        </div>
    </div>
</template>

<script>
  import ScattLobby from './ScattLobby'
  import ScattRound from './ScattRound'
  import ScattAnswers from './ScattAnswers'
  import ScattResults from './ScattResults'
  import { VCard, VCardTitle } from 'vuetify/lib'

  export default {
    name: 'ScattGame',
    components: { ScattLobby, ScattRound, ScattAnswers, ScattResults, VCard, VCardTitle },
    computed: {
      currentStateComponent () {
        return 'scatt-' + this.$store.state.scattGame.data.currentState
      },
      stateGame () {
        return this.$store.state.scattGame.data
      },
      stateRoundAnswers () {
        return this.$store.state.scattGame.roundAnswers
      },
      stateUser () {
        return this.$store.state.user.data
      }
    },
    data: () => ({
      transitionData: {
        active: false,
        user: '',
        // Todo: transition reason
        reason: '(de sa faute)'
      }
    }),
    mounted() {
      this.$axios.get('/scatt/games/' + this.$route.params.id, {
        params: { api_token: window.userApiToken }
      })
        .then(response => {
          this.$store.commit('scattGame/setGame', response.data.data)
          if (response.data.data.activeRound) {
            this.$store.commit('scattGame/setActiveRound', response.data.data.activeRound)
          }
        })

      this.$echo.channel('scatt-' + this.$route.params.id)
        .listen('.App\\Events\\Scatt\\PlayerList', (e) => {
          this.$store.commit('scattGame/setPlayers', e)
        })
        .listen('.App\\Events\\Scatt\\ChangeState', e => {
          this.transitionData.user = e.responsibleUser
          this.transitionData.active = true
          this.$store.commit('scattGame/setActiveRound', e.newRound)
          setTimeout(() => {
            this.$store.commit('scattGame/setState', e.newState)
            this.transitionData.active = false
          }, e.transitionTime * 1000)
        })
        .listen('.App\\Events\\Scatt\\SendAnswers',e => {
          this.$axios.post('/scatt/answers/massStore', {
            api_token: window.userApiToken,
            roundId: e.roundId,
            answers: this.stateRoundAnswers
          })
            .then(r => {
              console.log(r)
            })
        })
        .listen('.App\\Events\\Scatt\\AnswersList', e => {
          this.$store.commit('scattGame/setReceivedAnswers', e)
        })
        .listen('.App\\Events\\Scatt\\RoundApproval',e => {
          this.$store.commit('scattGame/setRoundApproval', e)
        })
    }
  }
</script>

<style scoped>
    .transition-title {
        word-break: break-word;
        text-align: left;
        opacity: 1;
    }
</style>