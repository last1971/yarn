<template>
    <v-dialog v-model="addProduct">
        <template v-slot:activator="{ on }">
            <v-btn rounded color="success" v-on="on">
                <v-icon left>mdi-plus</v-icon>
                Новый Продукт
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="headline">
                <span class="headline">Создать Создать новый продукт</span>
                <v-spacer/>
                <v-btn @click="close" icon right>
                    <v-icon color="red">
                        mdi-close
                    </v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <category-select v-model="category_id"/>
                <producer-select v-model="producer_id"/>
                <v-text-field v-model="name"
                              label="Новый продукт"
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

import CategorySelect from "./CategorySelect";
import ProducerSelect from "./ProducerSelect";
export default {
    name: "NewProduct",
    components: {ProducerSelect, CategorySelect},
    props: {
        categoryId: { type: String },
        producerId: { type: String },
    },
    data() {
        return {
            name: '',
            category_id: this.categoryId,
            producer_id: this.producerId,
            errors: {},
            addProduct: false,
            model: 'PRODUCT',
        }
    },
    computed: {
        saveNotPossible() {
            return !this.name || !this.categoryId;
        },
    },
    methods: {
        close() {
            this.name = '';
            this.category_id = this.categoryId;
            this.producer_id = this.producerId;
            this.addProduct = false;
        },
        async save() {
            const { name, model,  category_id, producer_id } = this;
            try {
                await this.$store.dispatch(
                    model + '/CREATE',
                    { name, producer_id, category_id }
                );
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
