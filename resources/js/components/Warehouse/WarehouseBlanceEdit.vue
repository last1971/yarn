<template>
    <v-container>
        <v-text-field v-model="proxy.balance" label="Остаток"/>
        <warehouse-select v-model="proxy.warehouse_id" />
        <v-btn-toggle>
            <v-btn @click="save" :loading="loading">
                <v-icon v-if="!proxy.id" color="green">mdi-plus</v-icon>
                <v-icon v-else color="green">mdi-content-save</v-icon>
            </v-btn>
            <v-btn :disabled="!proxy.id || loading" @click="remove">
                <v-icon color="error">mdi-delete</v-icon>
            </v-btn>
        </v-btn-toggle>
    </v-container>
</template>

<script>
import WarehouseSelect from "./WarehouseSelect";
export default {
    name: "WarehouseBlanceEdit",
    components: {WarehouseSelect},
    props: {
        value: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            proxy: {},
            loading: false
        }
    },
    created() {
        this.setProxy();
    },
    watch: {
        value: {
            deep: true,
            handler: function() {
                this.setProxy();
            }
        }
    },
    methods: {
        setProxy() {
            this.proxy = _.cloneDeep(this.value);
        },
        async save() {
            this.loading = true;
            try {
                const isAdding = !this.proxy.id;
                const action = isAdding ? 'WAREHOUSE-BALANCE/CREATE' : 'WAREHOUSE-BALANCE/UPDATE';
                const res = await this.$store.dispatch(action, this.proxy);
                if (isAdding) {
                    this.$emit('added', res);
                    this.setProxy();
                }
            } catch (e) {
                console.error(e);
            }
            this.loading = false;
        },
        async remove() {
            this.loading = true;
            try {
                await this.$store.dispatch('WAREHOUSE-BALANCE/REMOVE', this.proxy.id);
                this.$emit('removed', this.proxy.id);
            } catch (e) {
                console.error(e);
            }
            this.loading = false;
        }
    }
}
</script>

<style scoped>

</style>
