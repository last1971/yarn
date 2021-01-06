<template>
    <v-select
        v-model="proxy"
        :items="items"
        item-text="name"
        item-value="id"
        label="Название параметра"
    ></v-select>
</template>

<script>
export default {
    name: "ParameterNameSelect",
    props: {
        value: { type: String },
    },
    computed: {
        items() {
            return this.$store.getters['PARAMETER-NAME/ALL']
        },
        proxy: {
            get() {
                return this.value;
            },
            set(v) {
                this.$emit('input', v);
            }
        }
    }
}
</script>

<style scoped>

</style>
