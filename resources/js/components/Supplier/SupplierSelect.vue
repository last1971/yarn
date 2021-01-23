<template>
    <v-autocomplete
        :auto-select-first="true"
        :clearable="true"
        :error="!proxy"
        item-text="name"
        item-value="id"
        :items="items"
        label="Поставщик"
        :loading="isLoading"
        :search-input.sync="search"
        hide-no-data
        hide-selected
        placeholder="Название"
        v-model="proxy"
    >
        <template v-slot:prepend>
            <supplier-modal-edit v-model="proxy"/>
        </template>
    </v-autocomplete>
</template>

<script>
import _ from "lodash";
import SupplierModalEdit from "./SupplierModalEdit";
import selectMixin from "../../mixins/selectMixin";

export default {
    name: "SupplierSelect",
    components: {SupplierModalEdit},
    mixins:[selectMixin],
    data() {
        return {
            model: 'supplier',
        }
    },
}
</script>

<style scoped>

</style>
