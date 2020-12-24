<template>
    <v-dialog v-model="addProducer">
        <template v-slot:activator="{ on }">
            <v-btn rounded color="success" v-on="on">
                <v-icon left>mdi-plus</v-icon>
                Новый производитель
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="headline">
                <span class="headline">Создать нового производителя</span>
                <v-spacer/>
                <v-btn @click="close" icon right>
                    <v-icon color="red">
                        mdi-close
                    </v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field v-model="name"
                              label="Новый производитель"
                              placeholder="Введите уникальное название"
                              :error-messages="errors.name"
                />
            </v-card-text>
            <v-card-actions>
                <v-btn rounded color="success" :disabled="saveNotPossible" @click="save">
                    <v-icon left>
                        mdi-content-save
                    </v-icon>
                    Сохранить
                </v-btn>
                <v-btn rounded color="danger" @click="close">
                    <v-icon left>
                        mdi-close
                    </v-icon>
                    Отменить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

export default {
    name: "NewProducer",
    data() {
        return {
            name: '',
            errors: {},
            addProducer: false,
            model: 'PRODUCER',
        }
    },
    computed: {
        saveNotPossible() {
            return !this.name;
        }
    },
    methods: {
        close() {
            this.name = '';
            this.addProducer = false;
        },
        async save() {
            const { name, model } = this;
            try {
                await this.$store.dispatch(model + '/CREATE', { name });
                this.$emit('reload');
                this.close();
            } catch (e) {
                this.errors = e.response.data.errors;
            }
        }
    }
}
</script>

<style scoped>

</style>
