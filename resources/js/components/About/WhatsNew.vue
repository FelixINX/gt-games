<template>
    <div id="whats-new">
        <v-card>
            <v-card-title>Quoi de neuf?</v-card-title>
            <v-card-text>
                <ul>
                    <li><b>Reprendre une partie :</b> il est maintenant possible de rejoindre une partie déja commencé à partir de l'écran d'accueil</li>
                    <li><b>Quitter une partie :</b> il n'est plus possible de quitter une partie, afin de ne pas impacter le classement</li>
                    <li><b>Nouvelle capacité :</b> le jeu supporte maintenant plus de 100 combinaisons réponses-catégories (à la place d'environ 20)</li>
                    <li><b>Boutton arrêt maintenant corrigé :</b> fini les réponses dédoublés</li>
                </ul>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
  import { VCard, VCardText, VCardTitle } from 'vuetify/lib'

  export default {
    name: 'WhatsNew',
    components: { VCard, VCardText, VCardTitle },
  }
</script>

<style>

</style>