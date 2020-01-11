<template>
    <div id="scatt-create">
        <v-card :loading="gameLoading">
            <v-card-title>Créer une partie</v-card-title>
            <v-card-text>
                <v-form v-model="formValid">
                    <v-select v-model="gameInput.numberOfRounds" :items="numberOfRoundsItems"
                              label="Nombre de rondes"></v-select>
                    <v-select v-model="gameInput.timer" :items="timerItems" label="Minuteur"></v-select>

                    <v-subheader>Catégories</v-subheader>
                    <v-checkbox v-model="gameInput.categories" v-for="category in availableCategories"
                                :label="category.title" :value="category.id" :hint="category.rules"
                                :rules="selectedCategoriesRules" :key="category.id"></v-checkbox>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-btn color="secondary" :disabled="!formValid" @click="createGame">
                    <v-icon left>mdi-dice-multiple</v-icon>
                    Lancer la partie
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn @click="dialogOpen = !dialogOpen" text>
                    <v-icon left>mdi-tag-plus</v-icon>
                    Ajouter une catégorie
                </v-btn>
            </v-card-actions>
        </v-card>

        <v-dialog v-model="dialogOpen">
            <v-card>
                <v-card-title>
                    <span class="headline">Ajouter une catégorie</span>
                </v-card-title>
                <v-card-text>
                    <v-form v-model="dialogValid">
                        <v-text-field label="Nom" v-model="dialogInput.title" :rules="dialogTitleRules"
                                      required></v-text-field>
                        <v-textarea label="Règles" v-model="dialogInput.rules"></v-textarea>
                        <v-btn color="success" @click="createCategory" :disabled="!dialogValid">Ajouter</v-btn>
                    </v-form>
                    <v-btn color="secondary" @click="dialogOpen = !dialogOpen" class="float-right" icon>
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
  import {
    VBtn,
    VCard,
    VCardActions,
    VCardText,
    VCardTitle,
    VCheckbox,
    VDialog,
    VForm,
    VIcon,
    VSelect,
    VSpacer,
    VSubheader,
    VTextarea,
    VTextField
  } from 'vuetify/lib'

  export default {
    name: "ScattCreate",
    components: {
      VBtn, VCard, VCardText, VCardTitle, VCheckbox, VSelect, VSubheader, VCardActions, VSpacer, VIcon,
      VDialog, VTextField, VTextarea, VForm
    },
    data: () => ({
      gameInput: {
        numberOfRounds: 2,
        timer: 0,
        categories: []
      },
      numberOfRoundsItems: [2, 3, 4, 5, 10],
      timerItems: [
        {text: 'Aucune limite', value: 0},
        {text: '15 secondes', value: 15},
        {text: '30 secondes', value: 30},
        {text: '1 minute', value: 60},
        {text: '2 minutes', value: 120}
      ],
      availableCategories: [],
      formValid: false,
      selectedCategoriesRules: [
        v => v.length > 0 || 'Vous devez choisir au moins une catégorie'
      ],
      gameLoading: false,
      dialogOpen: false,
      dialogInput: {
        title: null,
        rules: null
      },
      dialogValid: false,
      dialogTitleRules: [
        v => !!v || 'Un titre est requis'
      ]
    }),
    mounted() {
      this.$axios.get('/scatt/categories', {
        params: {api_token: window.userApiToken}
      })
        .then(response => {
          this.availableCategories = response.data.data
        })
        .catch(error => {
          // Todo: catch
          console.log(error)
        })
    },
    methods: {
      createCategory () {
        this.$axios.post('/scatt/categories', this.dialogInput, {
          params: {api_token: window.userApiToken}
        })
          .then(response => {
            this.availableCategories.push(response.data)
            this.dialogOpen = false
            this.dialogInput.title = null
            this.dialogInput.rules = null
          })
          .catch(error => {
            // Todo: catch
            console.log(error)
          })
      },
      createGame () {
        this.gameLoading = true
        this.$axios.post('/scatt/games', this.gameInput, {
          params: {api_token: window.userApiToken}
        })
          .then(response => {
            this.$router.push('/scatt-game/' + response.data.id)
          })
          .catch(error => {
            // Todo: catch
            console.log(error)
            this.gameLoading = false
          })
      }
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
</style>