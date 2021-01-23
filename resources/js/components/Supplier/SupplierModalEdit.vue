<template>
    <modal-edit v-model="value"
                title="Поставщик"
                model="supplier"
                @added="added"
                @close="$emit('close')"
    >
        <template v-slot:body="{ editingValue }">
            <v-text-field label="Название" v-model="editingValue.name" />
        </template>
    </modal-edit>
</template>

<script>
import ModalEdit from "../ModalEdit";
export default {
    name: "SupplierModalEdit",
    components: {ModalEdit},
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
