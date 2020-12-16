<template>
    <div class="NotFound">
        <v-container>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card height="400" color="transparent" flat>
                        <div class="display-3 mt-5">Страница не найдена</div>
                        <div class="grey--text lighten-5">
                            Страница к которой Вы обращаетесь никогда не существовала на нашем сайте
                        </div>
                        <div class="paragraph-text mt-2">
                            <br /> Попробуйте вернуться на главную страницу
                        </div>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
export default {
    name: "404"
}
</script>

<style scoped>
    .paragraph-text {
        font-size: 18px;
    }
</style>
