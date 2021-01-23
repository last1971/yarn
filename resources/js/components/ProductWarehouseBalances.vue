<template>
    <v-container>
        <div v-if="editMode">
            <v-row v-for="warehouseBalance in warehouseBalances" :key="warehouseBalance.id">
                <warehouse-blance-edit :value="warehouseBalance" @remove="remove"/>
            </v-row>
            <v-row>
                <warehouse-blance-edit v-model="newWarehouseBalance" @added="insert"/>
            </v-row>
        </div>
        <div v-else-if="warehouseBalances.length > 0">
            <v-alert color="primary" class="text-center">Наличие</v-alert>
            <v-row v-for="warehouseBalance in warehouseBalances" :key="warehouseBalance.id">
                <v-col>
                    {{ warehouseBalance.balance }} шт.
                </v-col>
                <v-col>
                    : {{ warehouseBalance.warehouse.name }}
                </v-col>
            </v-row>
        </div>
    </v-container>
</template>

<script>
import WarehouseBlanceEdit from "./Warehouse/WarehouseBlanceEdit";
import isAdmin from "../mixins/isAdmin";
export default {
    name: "ProductWarehouseBalances",
    components: {WarehouseBlanceEdit},
    mixins: [isAdmin],
    props: {
        value: {
            type: String,
            rqeuired: true,
        }
    },
    data() {
        return {
            newWarehouseBalance: {
                id: null,
                balance: null,
                warehouse_id: null,
                product_id: this.value,
            }
        }
    },
    computed: {
        instance() {
            return this.$store.getters['PRODUCT/GET'](this.value) || { id: this.value, warehouse_balances: [] };
        },
        warehouseBalances() {
            return this.instance.warehouse_balances;
        }
    },
    watch: {
        value(v) {
            this.$set(this.newWarehouseBalance, 'product_id', v);
        }
    },
    methods: {
        insert(warehouseBalance) {
            const proxy = _.cloneDeep(this.instance);
            proxy.warehouse_balances.push(warehouseBalance);
            this.$store.commit('PRODUCT/UPDATE', proxy);
        },
        remove(id) {
            const proxy = _.cloneDeep(this.instance);
            const index = _.findIndex(proxy, { id });
            proxy.warehouse_balances.splice(index, 1);
            this.$store.commit('PRODUCT/UPDATE', proxy);
        }
    }
}
</script>

<style scoped>

</style>
