<template>
    <v-card>
        <v-card-title>Résultats</v-card-title>
        <v-card-text>
            <v-list>
                <v-list-item v-for="player in rank" class="mb-2 result-item" :class="player.color" :key="player.id">
                    <v-list-item-avatar>
                        <img :src="player.avatar" :alt="player.name">
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title>{{ player.name }}</v-list-item-title>
                        <v-list-item-subtitle>
                            <b>{{ player.gameReputation }} points </b> sur un total de {{ player.reputation }} points
                        </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-action v-if="rank[0] === player">
                        <v-icon>
                            mdi-trophy-variant
                        </v-icon>
                    </v-list-item-action>
                </v-list-item>
            </v-list>
        </v-card-text>
        <v-card-actions>
            <v-btn color="primary" to="/scatt/create">
                <v-icon left>mdi-autorenew</v-icon>
                Nouvelle partie
            </v-btn>
            <v-btn color="secondary" text to="/">
                <v-icon left>mdi-home</v-icon>
                Accueil
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
  import {  VCard, VCardTitle, VCardText, VList, VListItem, VListItemAvatar, VListItemContent, VListItemTitle,
            VListItemSubtitle, VListItemAction, VIcon, VCardActions, VBtn } from 'vuetify/lib'
  export default {
    name: 'ScattResults',
    components: {   VCard, VCardTitle, VCardText, VList, VListItem, VListItemAvatar, VListItemContent, VListItemTitle,
                    VListItemSubtitle, VListItemAction, VIcon, VCardActions, VBtn },
    data: () => ({
      rank: []
    }),
    mounted() {
      this.$axios.get('/scatt/games/' + this.$store.state.scattGame.data.id + '/results', {
        params: { api_token: window.userApiToken }
      })
        .then(response => {
          response.data.data.users.forEach(user => {
            user.gameReputation = response.data.data.reputation[user.id]
            this.rank.push(user)
          })

          this.rank.sort((a, b) => {
            let comparison = 0
            if (a.gameReputation > b.gameReputation) comparison = -1
            if (b.gameReputation > a.gameReputation) comparison = 1
            return comparison
          })

          this.rank.forEach(player => {
            let color = ''
            if (this.rank[0] === player) color = 'gold'
            if (this.rank[1] === player) color = 'silver'
            if (this.rank[2] === player) color = 'bronze'
            player.color = color
          })
        })
    }
  }
</script>

<style scoped>
    .v-content {
        background: #f8f9fa;
    }
    .v-subheader {
        padding-left: 0;
    }
    .v-input .v-label {
        margin: 0;
    }
    .result-item {
        border-radius: 4px;
    }
    .gold {
        background-color: #f1bd5f;
    }
    .silver {
        background-color: #ababab;
    }
    .bronze {
        background-color: #e38f59;
    }
</style>