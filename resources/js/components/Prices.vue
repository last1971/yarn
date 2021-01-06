<template>
    <v-container v-if="value" >
        <v-row v-for="price in prices" :key="price.id">
            <v-col v-if="!editMode">
                от {{ price.min }} шт.
            </v-col>
            <v-col v-else>
                <v-text-field label="От" v-model="price.min" suffix="шт"/>
            </v-col>
            <v-col v-if="!editMode">
                цена {{ price.price | formatRub }}
            </v-col>
            <v-col v-else>
                <v-text-field label="цена" v-model="price.price" suffix="руб."/>
            </v-col>
            <v-col v-if="editMode">
                <v-btn icon fab @click="remove(price)">
                    <v-icon color="error">mdi-delete</v-icon>
                </v-btn>
            </v-col>
        </v-row>
        <v-row v-if="editMode">
            <v-col>
                <v-text-field label="От" v-model="min" suffix="шт"/>
            </v-col>
            <v-col>
                <v-text-field label="цена" v-model="price" suffix="руб."/>
            </v-col>
            <v-col>
                <v-btn icon fab @click="save">
                    <v-icon color="success">mdi-content-save</v-icon>
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import isAdmin from "../mixins/isAdmin";

export default {
    name: "Prices",
    mixins: [isAdmin],
    props: {
        value: { type: Object, required: true }
    },
    data() {
        return {
            prices: [],
            min: 1,
            price: 1,
        }
    },
    created() {
        this.prices = _.cloneDeep(this.value.prices) || [];
    },
    watch: {
        value() {
            this.prices = _.cloneDeep(this.value.prices) || [];
        }
    },
    methods: {
        async save() {
            try {
                const price = await this.$store.dispatch(
                    'PRICE/CREATE',
                    { product_id: this.value.id, price: this.price, min: this.min }
                );
                const newProduct = _.cloneDeep(this.value);
                this.prices.push(price);
                this.prices.sort((a, b) => a.min - b.min);
                newProduct.prices = this.prices;
                this.$store.commit('PRODUCT/UPDATE', newProduct);
                this.price = 1;
                this.min = 1;
            } catch (e) {
                console.error(e);
            }
        },
        async remove(price) {
            try {
                await this.$store.dispatch('PRICE/REMOVE', price.id);
                const index = _.findIndex(this.prices, { id: price.id });
                this.prices.splice(index, 1);
                const newProduct = _.cloneDeep(this.value);
                newProduct.prices = this.prices;
                this.$store.commit('PRODUCT/UPDATE', newProduct);
            } catch (e) {
                console.error(e);
            }
        }
    }
}
</script>

<style scoped>

</style>
