<template>
    <div id="scatt-lobby">
        <v-card color="accent" class="mb-4">
            <v-card-title>Partie {{ stateGame.id }}</v-card-title>
            <v-card-actions>
                <v-btn icon :href="facebookUrl">
                    <v-icon>mdi-facebook-messenger</v-icon>
                </v-btn>
                <v-btn icon @click="copyUrl">
                    <v-icon>mdi-content-copy</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>

        <v-card color="white" class="mb-4">
            <v-card-title>Renseignements sur la partie</v-card-title>
            <v-card-text>
                <v-list>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon>mdi-timer</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title v-if="stateGame.timer === 0">
                                Sans limite
                            </v-list-item-title>
                            <v-list-item-title v-else-if="1 < stateGame.timer < 59">
                                {{ stateGame.timer }} secondes
                            </v-list-item-title>
                            <v-list-item-title v-else>
                                {{ stateGame.timer / 60 }} minute(s)
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon>mdi-gamepad-square</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>
                                {{ stateGame.rounds && stateGame.rounds.length }} rondes
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-divider></v-divider>
                    <v-subheader>Catégories</v-subheader>

                    <v-list-item v-for="category in stateGame.categories" :key="category.id">
                        <v-list-item-content>
                            <v-list-item-title>{{ category.title }}</v-list-item-title>
                            <v-list-item-subtitle v-if="category.rules">{{ category.rules }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" v-if="stateGame.userId == stateUser.id" @click="apiStartGame">
                    <v-icon left>mdi-play</v-icon>
                    Démarrer
                </v-btn>
            </v-card-actions>
        </v-card>

        <v-card color="white">
            <v-card-title>Joueurs</v-card-title>
            <v-card-text>
                <v-chip v-for="user in stateGame.users" :key="user.id" class="mr-2"
                        :style="{ 'cyan': user.id == stateGame.userId }">
                    <v-avatar left>
                        <img :src="user.avatar" :alt="user.name">
                    </v-avatar>
                    {{ user.name }}
                </v-chip>
            </v-card-text>
            <v-card-actions>
                <v-btn @click="apiJoinGame" v-if="!isInGame" color="success">
                    <v-icon left>mdi-account-plus</v-icon>
                    Rejoindre la partie
                </v-btn>
            </v-card-actions>
        </v-card>
        <input type="hidden" :value="'https://gtgames.com/#/scatt-game/' + stateGame.id" id="gameUrl">
    </div>
</template>

<script>
// Todo : click to copy

  import {
    VAvatar,
    VBtn,
    VCard,
    VCardActions,
    VCardText,
    VCardTitle,
    VChip,
    VDivider,
    VIcon,
    VList,
    VListItem,
    VListItemAction,
    VListItemContent,
    VListItemIcon,
    VListItemSubtitle,
    VListItemTitle,
    VSpacer,
    VSubheader
  } from 'vuetify/lib'

  export default {
    name: 'ScattLobby',
    components: {
      VCard, VCardTitle, VCardActions, VBtn, VIcon, VCardText, VList, VListItem, VListItemAction,
      VListItemIcon, VListItemContent, VListItemTitle, VDivider, VSubheader, VListItemSubtitle, VChip,
      VAvatar, VSpacer
    },
    computed: {
      stateUser() {
        return this.$store.state.user.data
      },
      stateGame() {
        return this.$store.state.scattGame.data
      },
      isInGame() {
        return this.$store.state.scattGame.data.users.filter(user => (user.id === this.stateUser.id)).length
      },
      facebookUrl() {
        return 'fb-messenger://share/?link=' + window.location.href + '&app_id=509740746484749'
      }
    },
    methods: {
      apiJoinGame () {
        this.$axios.post('/scatt/games/' + this.stateGame.id + '/join', null, {
          params: {api_token: window.userApiToken}
        })
          .then(response => {
            console.log(response)
          })
      },
      apiStartGame () {
        this.$axios.post('/scatt/games/' + this.stateGame.id + '/start', null, {
          params: {api_token: window.userApiToken}
        })
          .then(response => {
            console.log(response)
          })
      },
      copyUrl () {
        const copyField = document.getElementById('gameUrl')

        copyField.select()
        copyField.setSelectionRange(0, 99999)

        document.execCommand('copy')
      }
    }
  }
</script>

<style scoped>

</style>