<template>
    <modal-edit v-model="value"
                title="Склад"
                model="warehouse"
                @added="added"
                @close="$emit('close')"
    >
        <template v-slot:body="{ editingValue }">
            <v-text-field label="Название" v-model="editingValue.name" />
            <supplier-select v-model="editingValue.supplier_id" />
        </template>
    </modal-edit>
</template>

<script>
import SupplierSelect from "../Supplier/SupplierSelect";
import ModalEdit from "../ModalEdit";
export default {
    name: "WarehouseModalEdit",
    components: {ModalEdit, SupplierSelect},
    props: {
        value: {
            validator: prop => typeof prop === 'string' || prop === null,
            required: true,
            default: null,
        }
    },
    methods: {
        added(value) {
            this.$emit('input', value);
        }
    }
}
</script>

<style scoped>

</style>
