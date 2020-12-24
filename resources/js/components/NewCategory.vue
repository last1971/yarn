<template>
    <v-dialog v-model="addCategory">
        <template v-slot:activator="{ on }">
            <v-btn rounded color="success" v-on="on">
                <v-icon left>mdi-plus</v-icon>
                Новая категория
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="headline">
                <span class="headline">Создать новую категорию</span>
                <v-spacer/>
                <v-btn @click="close" icon right>
                    <v-icon color="red">
                        mdi-close
                    </v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field v-model="name"
                              label="Новая категория"
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
    name: "NewCategory",
    props: {
        parent_id: {
            type: String
        },
    },
    data() {
        return {
            name: '',
            errors: {},
            addCategory: false,
            model: 'CATEGORY',
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
            this.addCategory = false;
        },
        async save() {
            const { name, model, parent_id } = this;
            try {
                await this.$store.dispatch(model + '/CREATE', { name, parent_id });
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
