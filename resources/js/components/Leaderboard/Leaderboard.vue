<template>
    <v-card color="white">
        <v-card-title>Classement</v-card-title>
        <v-card-text>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-left">Nom</th>
                            <th class="text-left">Pointage</th>
                            <th class="text-left">Nombre de partie jouées</th>
                            <th class="text-left">Moyenne</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="player in leaderboard" :key="player.id">
                        <td>
                            <v-avatar size="24px" class="mr-1">
                                <img :src="player.avatar" :alt="player.name">
                            </v-avatar>
                            {{ player.name }}
                        </td>
                        <td>{{ player.reputation }}</td>
                        <td>{{ player.numberOfGames }}</td>
                        <td>{{ Math.round(player.reputation / player.numberOfGames) }}</td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-card-text>
    </v-card>
</template>

<script>
  import {    VCard, VCardTitle, VCardText, VSimpleTable, VAvatar } from 'vuetify/lib'

  export default {
    name: 'Leaderboard',
    components: {   VCard, VCardTitle, VCardText, VSimpleTable, VAvatar },
    computed: {

    },
    data: () => ({
      leaderboard: []
    }),
    mounted() {
      this.$axios.get('/leaderboard', {
        params: {api_token: window.userApiToken}
      })
        .then(response => {
          this.leaderboard = response.data.data
        })
    }
  }
</script>

<style scoped>

</style>