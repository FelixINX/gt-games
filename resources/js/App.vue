<template>
    <div id="app">
        <v-app id="gtg">
            <v-navigation-drawer v-model="drawer" app>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="title">GT Games</v-list-item-title>
                        <v-list-item-subtitle>Version 1.0.0-beta.3</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>

                <v-divider></v-divider>

                <v-list dense subheader>
                    <v-list-item to="/">
                        <v-list-item-action>
                            <v-icon>mdi-home</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Accueil</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/leaderboard">
                        <v-list-item-action>
                            <v-icon>mdi-star</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Classement</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-divider></v-divider>
                    <v-subheader>Scattegories</v-subheader>

                    <v-list-item to="/scatt/all">
                        <v-list-item-action>
                            <v-icon>mdi-format-letter-starts-with</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Toutes les parties</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/scatt/create">
                        <v-list-item-action>
                            <v-icon>mdi-plus</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Créer une partie</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-divider></v-divider>
                    <v-subheader>Traduction - À venir</v-subheader>
                    <v-divider></v-divider>

                    <v-list-item to="/profile" v-if="stateUser.id">
                        <v-list-item-action>
                            <v-icon>mdi-account</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Profil</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/redirect/logout" v-if="stateUser.id">
                        <v-list-item-action>
                            <v-icon>mdi-logout-variant</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Se déconnecter</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item to="/redirect/login" v-if="!stateUser.id">
                        <v-list-item-action>
                            <v-icon>mdi-google</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Se connecter avec Google</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/redirect/login-email" v-if="!stateUser.id">
                        <v-list-item-action>
                            <v-icon>mdi-login-variant</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Se connecter</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-divider></v-divider>

                    <v-list-item to="/about">
                        <v-list-item-action>
                            <v-icon>mdi-information</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>À propos</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/about/whats-new">
                        <v-list-item-action>
                            <v-icon>mdi-party-popper</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Nouveautés</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/redirect/github">
                        <v-list-item-action>
                            <v-icon>mdi-github-circle</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Code source</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-app-bar app color="primary" dark>
                <v-app-bar-nav-icon @click.stop="drawer = !drawer"/>
                <v-toolbar-title>GT Games</v-toolbar-title>

                <v-spacer></v-spacer>

                <v-menu v-if="stateUser.avatar">
                    <template v-slot:activator="{ on }">
                        <v-avatar to="/profile" size="36px" v-on="on">
                            <img :src="stateUser.avatar" :alt="stateUser.name">
                        </v-avatar>
                    </template>
                    <v-list>
                        <v-list-item to="/profile">
                            <v-list-item-title>Profil</v-list-item-title>
                        </v-list-item>
                        <v-list-item to="/redirect/logout">
                            <v-list-item-title>Se déconnecter</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>

                <v-btn icon v-else href="/redirect/login">
                    <v-icon>mdi-login-variant</v-icon>
                </v-btn>
            </v-app-bar>

            <v-content class="mt-4" :style="{ backgroundImage: pageBackground }">
                <v-container>
                    <router-view></router-view>
                </v-container>
            </v-content>
            <component v-bind:is="currentFooter"></component>
        </v-app>
    </div>
</template>

<script>
  import {
    VApp,
    VAppBar,
    VAppBarNavIcon,
    VAvatar,
    VBtn,
    VContainer,
    VContent,
    VDivider,
    VIcon,
    VList,
    VListItem,
    VListItemAction,
    VListItemContent,
    VListItemSubtitle,
    VListItemTitle,
    VMenu,
    VNavigationDrawer,
    VSpacer,
    VSubheader,
    VToolbarTitle
  } from 'vuetify/lib'
  import ScattFooter from './components/Scatt/ScattFooter'

  export default {
    name: 'app',
    components: {
      VApp, VNavigationDrawer, VList, VListItem, VListItemAction, VIcon, VListItemContent, VListItemTitle,
      VListItemSubtitle, VDivider, VSubheader, VAppBar, VAppBarNavIcon, VToolbarTitle, VSpacer, VMenu, VAvatar, VBtn,
      VContent, VContainer, ScattFooter
    },
    data: () => ({
      drawer: false,
      homeBackgrounds: [
        '/img/home-1.jpg',
        '/img/home-2.jpg'
      ],
      currentCssBackground: ''
    }),
    mounted() {
      if (window.userApiToken) {
        this.$axios.get('/user', {
          params: {api_token: window.userApiToken}
        })
          .then(response => {
            this.$store.commit('user/setData', response.data)
          })
      }
    },
    computed: {
      currentFooter() {
        if (this.$route.meta.footer) {
          return this.$route.meta.footer
        } else {
          return null
        }
      },
      stateUser() {
        return this.$store.state.user.data
      },
      pageBackground() {
        if (this.$route.meta.background) {
          return 'url("' + this.homeBackgrounds[Math.floor(Math.random() * this.homeBackgrounds.length)] + '")'
        } else {
          return 'url("/img/background.jpg")'
        }
      }
    }
  }
</script>

<style>
    .v-content {
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    }
</style>