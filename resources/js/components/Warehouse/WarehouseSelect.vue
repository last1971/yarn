<template>
    <v-autocomplete
        :auto-select-first="true"
        :clearable="true"
        :error="!proxy"
        item-text="name"
        item-value="id"
        :items="items"
        label="Склад"
        :loading="isLoading"
        :search-input.sync="search"
        hide-no-data
        hide-selected
        placeholder="Название склада"
        v-model="proxy"
    >
        <template v-slot:prepend>
            <warehouse-modal-edit v-model="proxy"/>
        </template>
        <template v-slot:item="{ item }">
            {{ item.supplier.name }} / {{ item.name }}
        </template>
    </v-autocomplete>
</template>

<script>
import WarehouseModalEdit from "./WarehouseModalEdit";
import selectMixin from "../../mixins/selectMixin";
export default {
    name: "WarehouseSelect",
    components: {WarehouseModalEdit},
    mixins:[selectMixin],
    data() {
        return {
            model: 'warehouse',
        }
    },
}
</script>

<style scoped>

</style>
