<template>
    <div id="home">
        <div v-if="user.name" class="on-top">
            <h1 class="display-2 mb-4 white--text">Bienvenue dans GT Games!</h1>

            <v-card color="white" class="mb-4">
                <v-card-title>
                    Scattegories
                    <v-spacer></v-spacer>
                    <svg height="100" width="100" class="game-icon">
                        <circle cx="50" cy="50" r="40" fill="#28aba9"/>
                        <path d=" M 48.065 32 L 37.468 59 L 41.81 59 L 43.97 53.218 L 56.008 53.218 L 58.19 59 L 62.533 59 L 51.935 32 M 50 37.153 L 54.568 49.348 L 45.41 49.348 M 32 63.5 L 32 56.75 L 27.5 56.75 L 27.5 68 L 72.5 68 L 72.5 63.5 L 32 63.5 Z "
                              fill="#FFFFFF"/>
                    </svg>
                </v-card-title>
                <v-card-text>
                    <v-list v-if="resumeGames.length" color="cyan">
                        <v-list-item :to="'/scatt-game/' + game.id" v-for="game in resumeGames"
                                     :key="game.id">
                            <v-list-item-avatar>
                                <v-img :src="game.user.avatar"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>Reprendre la partie {{ game.id }} par {{ game.user.name }}</v-list-item-title>
                            </v-list-item-content>
                            <v-list-item-icon>
                                <v-icon color="secondary">mdi-arrow-right</v-icon>
                            </v-list-item-icon>
                        </v-list-item>
                    </v-list>
                </v-card-text>
                <v-card-subtitle class="m-0">Rejoindre une partie</v-card-subtitle>
                <v-card-text>
                    <v-skeleton-loader type="list-item-avatar-two-line" v-for="i in 5" v-if="!apiDone"
                                       :key="i"></v-skeleton-loader>
                    <v-list v-if="apiDone">
                        <v-list-item two-line :to="'/scatt-game/' + game.id" v-for="game in availableGames"
                                     :key="game.id">
                            <v-list-item-avatar>
                                <v-img :src="game.user.avatar"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>Partie {{ game.id }} par {{ game.user.name }}</v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ game.rounds }} rondes, {{ game.categories }} catégories,

                                    <span v-if="game.timer === 0">
                                        sans limite
                                    </span>
                                    <span v-else-if="1 < game.timer < 59">
                                        {{ game.timer }} secondes
                                    </span>
                                    <span v-else>
                                        {{ game.timer / 60 }} minute(s)
                                    </span>
                                </v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-icon>
                                <v-icon color="secondary">mdi-arrow-right</v-icon>
                            </v-list-item-icon>
                        </v-list-item>
                    </v-list>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="secondary" to="/scatt/create">
                        <v-icon left>mdi-plus</v-icon>
                        Créer une partie
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="secondary" @click="apiAvailableGame" icon>
                        <v-icon>mdi-refresh</v-icon>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </div>
        <div v-else>
            <div class="landing-text">
                <h1 class="white--text display-2">Bienvenue dans GT Games</h1><br>
                <v-btn x-large color="white" text to="/redirect/login">Étudiants
                    <v-icon right>mdi-chevron-right</v-icon>
                </v-btn>
                <br>
                <v-btn x-large color="white" text to="/redirect/login-email">Autres
                    <v-icon right>mdi-chevron-right</v-icon>
                </v-btn>
            </div>
            <img src="/img/logo.svg" alt="Logo" class="landing-blocks align-self-center">
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate"
             viewBox="0 0 500 400" width="500pt" height="400pt" class="square-design" v-if="user.name">
            <rect x="300" y="200" width="100" height="100" transform="matrix(1,0,0,1,0,0)" fill="rgb(82,43,67)"/>
            <rect x="200" y="200" width="100" height="100" transform="matrix(1,0,0,1,0,0)" fill="rgb(82,43,67)"/>
            <path d="M 23.57 300 L 100 300 L 100 400 L 0 400 L 0 323.57 C 0 310.561 10.561 300 23.57 300 Z"
                  style="stroke:none;fill:#00305B;stroke-miterlimit:10;"/>
            <rect x="100" y="300" width="100" height="100" transform="matrix(1,0,0,1,0,0)" fill="rgb(0,48,91)"/>
            <rect x="200" y="300" width="100" height="100" transform="matrix(1,0,0,1,0,0)" fill="rgb(0,48,91)"/>
            <rect x="300" y="300" width="100" height="100" transform="matrix(1,0,0,1,0,0)" fill="rgb(93,159,110)"/>
            <rect x="400" y="200" width="100" height="100" transform="matrix(1,0,0,1,0,0)" fill="rgb(93,159,110)"/>
            <rect x="400" y="300" width="100" height="100" transform="matrix(1,0,0,1,0,0)" fill="rgb(93,159,110)"/>
            <rect x="400" y="100" width="100" height="100" transform="matrix(1,0,0,1,0,0)" fill="rgb(40,171,169)"/>
            <path d="M 416.667 0 L 500 0 L 500 100 L 400 100 L 400 16.667 C 400 7.468 407.468 0 416.667 0 Z"
                  style="stroke:none;fill:#28ABA9;stroke-miterlimit:10;"/>
            <path d="M 116.667 200 L 200 200 L 200 300 L 100 300 L 100 216.667 C 100 207.468 107.468 200 116.667 200 Z"
                  style="stroke:none;fill:#00305B;stroke-miterlimit:10;"/>
            <path d="M 316.667 100 L 400 100 L 400 200 L 300 200 L 300 116.667 C 300 107.468 307.468 100 316.667 100 Z"
                  style="stroke:none;fill:#522B43;stroke-miterlimit:10;"/>
            <path d=" M 187.5 325 L 112.5 325 C 107.898 325 104.167 328.731 104.167 333.333 L 104.167 366.667 C 104.167 371.269 107.898 375 112.5 375 L 187.5 375 C 192.102 375 195.833 371.269 195.833 366.667 L 195.833 333.333 C 195.833 328.731 192.102 325 187.5 325 Z  M 145.833 354.167 L 133.333 354.167 L 133.333 366.667 L 125 366.667 L 125 354.167 L 112.5 354.167 L 112.5 345.833 L 125 345.833 L 125 333.333 L 133.333 333.333 L 133.333 345.833 L 145.833 345.833 M 164.583 362.5 C 161.132 362.5 158.333 359.702 158.333 356.25 C 158.333 352.798 161.132 350 164.583 350 C 168.035 350 170.833 352.798 170.833 356.25 C 170.833 359.702 168.035 362.5 164.583 362.5 Z  M 181.25 350 C 177.798 350 175 347.202 175 343.75 C 175 340.298 177.798 337.5 181.25 337.5 C 184.702 337.5 187.5 340.298 187.5 343.75 C 187.5 347.202 184.702 350 181.25 350 Z "
                  fill="rgb(255,255,255)"/>
        </svg>
    </div>
</template>

<script>
  import {
    VBtn,
    VCard,
    VCardActions,
    VCardSubtitle,
    VCardText,
    VCardTitle,
    VCol,
    VIcon,
    VImg,
    VList,
    VListItem,
    VListItemAvatar,
    VListItemContent,
    VListItemIcon,
    VListItemSubtitle,
    VListItemTitle,
    VRow,
    VSkeletonLoader,
    VSpacer
  } from 'vuetify/lib'

  export default {
    name: 'Home',
    components: {
      VRow, VCol, VCard, VCardTitle, VCardText, VList, VListItem, VListItemAvatar, VImg, VListItemContent,
      VListItemTitle, VListItemSubtitle, VListItemIcon, VCardSubtitle, VCardActions, VBtn, VIcon, VSpacer,
      VSkeletonLoader
    },
    data: () => ({
      availableGames: [],
      resumeGames: [],
      apiDone: false
    }),
    computed: {
      user() {
        return this.$store.state.user.data
      }
    },
    methods: {
      apiAvailableGame() {
        this.apiDone = false

        this.$axios.get('/scatt/available', {
          params: {api_token: window.userApiToken}
        })
          .then(response => {
            this.availableGames = response.data.data
          })
        this.$axios.get('/scatt/resume', {
          params: {api_token: window.userApiToken}
        })
          .then(response => {
            this.resumeGames = response.data.data
            this.apiDone = true
          })
      }
    },
    mounted() {
      if (window.userApiToken) {
        this.apiAvailableGame()
      }
    }
  }
</script>

<style>
    .game-icon {
        position: absolute;
        top: -32px;
        right: 0px;
    }

    @media only screen and (min-width: 600px) {
        .game-icon {
            right: -32px;
        }
    }

    .game-preview {
        position: absolute;
        bottom: -50px;
    }

    .game-1 {
        right: 105px;
    }

    .game-2 {
        right: 5px;
    }

    .square-design {
        width: 250px;
        height: auto;
        position: fixed;
        right: 0;
        bottom: 0;
        z-index: 1;
    }

    .on-top {
        position: relative;
        z-index: 2;
    }

    .landing-text {
        position: absolute;
        bottom: 25px;
        left: 25px;
    }

    .v-content__wrap {
        background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(242, 107, 80, 0.9));
    }

    .landing-text .v-btn {
        padding-left: 4px !important;
    }

    .landing-blocks {
        height: 150px;
        position: absolute;
        bottom: 25px;
        right: 25px;
    }

    @media screen and (max-width: 992px) {
        .landing-blocks {
            height: 75px;
        }
    }
</style>