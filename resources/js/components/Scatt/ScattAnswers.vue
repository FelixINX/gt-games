<template>
    <div id="scatt-round">
        <v-card color="cyan" class="mb-4">
            <v-card-title>Réponses pour la lettre {{ stateRound.letter }}</v-card-title>
        </v-card>
        <v-card class="mb-4" v-for="category in stateCategories" :key="category.id" :loading="selfRoundAccepted"
                v-if="loadingComplete">
            <v-card-title>{{ category.title }}</v-card-title>
            <v-card-text v-if="stateReceivedAnswers[category.id].items">
                <v-sheet width="100%" class="px-2 pb-2 mb-2" v-for="answer in stateReceivedAnswers[category.id].items"
                         :key="answer.id" :class="{ refused: !answer.approved }">
                    <div class="d-flex">
                        <v-avatar class="mr-2 align-self-center" size="36px">
                            <img :src="answer.user.avatar" :alt="answer.user.name">
                        </v-avatar>
                        <div class="align-self-center">
                            <b>{{ answer.user.name }}</b><br>
                            <span>
                                {{ answer.content }}
                                <v-btn icon @click="launchSearch(category.title ,answer.content)">
                                    <v-icon>mdi-magnify</v-icon>
                                </v-btn>
                            </span>
                        </div>
                        <div class="align-self-center ml-auto">
                            <v-switch v-model="selfAcceptedAnswers[answer.id]"
                                      v-on:change="apiAcceptAnswer(answer.id)"></v-switch>
                        </div>
                    </div>
                    <div class="user-approval">
                        <v-chip v-for="player in statePlayers" :key="player.id" class="mr-2" small>
                            <v-icon left color="success" v-if="answer.approval[player.id]">
                                mdi-check
                            </v-icon>
                            <v-icon left color="red" v-else>mdi-close</v-icon>
                            {{ player.name.split(' ')[0] }}
                        </v-chip>
                    </div>
                </v-sheet>
            </v-card-text>
            <v-card-text v-else>Aucune réponse pour cette catégorie!</v-card-text>
        </v-card>
        <v-card>
            <v-card-title>Confirmation des réponses</v-card-title>
            <v-card-text>
                <v-chip v-for="player in statePlayers" :key="player.id" class="mr-2 mb-2" v-if="stateRoundApproval[stateRound.id]">
                    <v-icon left color="success" v-if="stateRoundApproval[stateRound.id][player.id]">
                        mdi-check
                    </v-icon>
                    <v-icon left color="red" v-else>mdi-close</v-icon>
                    {{ player.name }}
                </v-chip>
            </v-card-text>
            <v-card-actions>
                <v-btn color="secondary" @click="apiConfirmRound(!selfRoundAccepted)">
                    <v-icon left v-if="selfRoundAccepted">mdi-cancel</v-icon>
                    <v-icon left v-else>mdi-send-check</v-icon>
                    <span v-if="selfRoundAccepted">Annuler</span>
                    <span v-else>Confirmer</span>
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn color="primary" text v-if="selfRoundAccepted && isMod" @click="apiContinueRound()">
                    <v-icon left>mdi-transfer-right</v-icon>
                    Poursuivre
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
  import {
    VAvatar,
    VBtn,
    VCard,
    VCardActions,
    VCardText,
    VCardTitle,
    VChip,
    VIcon,
    VSheet,
    VSpacer,
    VSwitch
  } from 'vuetify/lib'

  export default {
    name: 'ScattAnswers',
    components: {VAvatar, VBtn, VCard, VCardActions, VCardText, VCardTitle, VChip, VIcon, VSheet, VSpacer, VSwitch},
    computed: {
      isMod() {
        return this.$store.state.user.data.id == this.$store.state.scattGame.data.userId
      },
      stateCategories() {
        return this.$store.state.scattGame.data.categories
      },
      stateReceivedAnswers() {
        return this.$store.state.scattGame.receivedAnswers
      },
      stateRound() {
        return this.$store.state.scattGame.activeRound
      },
      stateRoundApproval() {
        return this.$store.state.scattGame.roundApproval
      },
      statePlayers() {
        return this.$store.state.scattGame.data.users
      }
    },
    data: () => ({
      selfAcceptedAnswers: [],
      selfRoundAccepted: false,
      loadingComplete: false
    }),
    methods: {
      apiConfirmRound(confirmed) {
        this.selfRoundAccepted = true

        this.$axios.post('/scatt/rounds/' + this.stateRound.id + '/confirm', {
          api_token: window.userApiToken,
          confirmed: confirmed
        })
          .then(response => {
            this.selfRoundAccepted = confirmed
            console.log(response)
          })
      },
      apiContinueRound() {
        this.$axios.post('/scatt/rounds/' + this.stateRound.id + '/continue', {
          api_token: window.userApiToken
        })
          .then(response => {
            console.log(response)
          })
      },
      apiAcceptAnswer(answerId) {
        this.$axios.post('/scatt/answers/' + answerId + '/accept', {
          api_token: window.userApiToken,
          accept: this.selfAcceptedAnswers[answerId]
        })
          .then(response => {
            console.log(response)
          })
      },
      launchSearch(categoryTitle, answerContent) {
        const newWindow = window.open('https://google.com/search?q=' + categoryTitle + '+' + answerContent, '_blank')
        newWindow.focus()
      }
    },
    mounted() {
      this.$axios.get('/scatt/rounds/' + this.stateRound.id + '/answers', {
        params: {api_token: window.userApiToken}
      })
        .then(response => {
          this.$store.commit('scattGame/setReceivedAnswers', response.data.data)

          response.data.data.forEach((answer) => {
            this.selfAcceptedAnswers[answer.id] = answer.approval[this.$store.state.user.data.id]
          })

          this.loadingComplete = true
        })

      if (this.stateRoundApproval[this.stateRound.id][this.$store.state.user.data.id]) {
        this.selfRoundAccepted = true
      }
    }
  }
</script>

<style scoped>
    .user-approval {
        overflow: auto;
        white-space: nowrap;
    }

    .refused {
        background-color: rgba(255, 223, 1, 0.5);
    }
</style>