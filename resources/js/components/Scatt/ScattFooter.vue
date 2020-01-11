<template>
    <div id="scatt-footer">
        <v-footer color="secondary" dark>
            <v-btn color="error" class="mr-4" v-if="!isMod && isInGame" @click="apiLeaveGame(stateUser.id)">
                <v-icon left>mdi-account-minus</v-icon>
                Quitter
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn @click="playersSheet = true" color="accent">
                <v-icon left>mdi-account-group</v-icon>
                {{ stateGame.users && stateGame.users.length }} joueur(s)
            </v-btn>
        </v-footer>
        <v-bottom-sheet v-model="playersSheet">
            <v-list>
                <v-subheader>Joueurs</v-subheader>
                <v-list-item v-for="player in stateGame.users" :key="player.id" :class="{ 'cyan': player.id == stateGame.userId }">
                    <v-list-item-avatar>
                        <v-avatar size="32px">
                            <img :src="player.avatar" :alt="player.name">
                        </v-avatar>
                    </v-list-item-avatar>
                    <v-list-item-title>{{ player.name }}</v-list-item-title>
                    <v-list-item-action v-if="player.id == stateGame.userId">
                        <v-icon color="white">mdi-account-star</v-icon>
                    </v-list-item-action>
                    <v-list-item-action v-if="isMod && player.id != stateGame.userId">
                        <v-btn icon @click="apiLeaveGame(player.id)">
                            <v-icon color="error">mdi-account-minus</v-icon>
                        </v-btn>
                    </v-list-item-action>
                </v-list-item>
            </v-list>
        </v-bottom-sheet>
    </div>
</template>

<script>
  import {
    VAvatar,
    VBottomSheet,
    VBtn,
    VDivider,
    VFooter,
    VIcon,
    VList,
    VListItem,
    VListItemAction,
    VListItemAvatar,
    VListItemTitle,
    VSpacer,
    VSubheader
  } from 'vuetify/lib'

  export default {
    name: 'ScattFooter',
    components: {   VFooter, VBtn, VIcon, VDivider, VSpacer, VBottomSheet, VList, VSubheader, VListItem,
                    VListItemAvatar, VAvatar, VListItemTitle, VListItemAction },
    computed: {
      stateGame () {
        return this.$store.state.scattGame.data
      },
      stateUser () {
        return this.$store.state.user.data
      },
      isMod () {
        return this.stateGame.userId == this.stateUser.id
      },
      isInGame() {
        return this.$store.state.scattGame.data.users.filter(user => (user.id === this.stateUser.id)).length
      }
    },
    data: () => ({
      playersSheet: false
    }),
    methods: {
      apiLeaveGame (playerId) {
        this.$axios.post('/scatt/games/' + this.stateGame.id + '/leave',
          { userId: playerId },
          { params: { api_token: window.userApiToken }
          })
          .then(response => {
            console.log(response)
          })
      }
    },
    mounted () {
      this.$echo.channel('scatt-' + this.$route.params.id)
        .listen('PlayerList')
    }
  }
</script>

<style scoped>

</style>