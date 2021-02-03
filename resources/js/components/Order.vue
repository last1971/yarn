<template>
    <v-container>
        <v-row>
            <v-col cols="1">
                <v-icon>mdi-phone</v-icon>
            </v-col>
            <v-col>
                Чтобы сделать заказ, позвоните по номеру
                <a :href="'tel:' + phone">{{ phone }}</a>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="1">
                <v-icon>mdi-email</v-icon>
            </v-col>
            <v-col>
                или напишите на почту
                <a :href="'mailto:' + email">{{ email }}</a>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="1">
                <v-icon>mdi-instagram</v-icon>
            </v-col>
            <v-col>
                Так же можно связаться через
                <a :href="instagram" target="_blank">директ Инстаграм</a>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "Order",
    computed: {
        email() {
            return process.env.MIX_EMAIL;
        },
        phone() {
            return process.env.MIX_PHONE;
        },
        instagram() {
            return process.env.MIX_INSTAGRAM
        }
    }
}
</script>

<style scoped>

</style>
