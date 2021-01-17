<template>
    <parameter-edit v-model="newParameter" @add="add"/>
</template>

<script>
import ParameterEdit from "./ParameterEdit";
export default {
    name: "ParameterAdd",
    components: {ParameterEdit},
    props: {
        value: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            newParameter: {
                parameter_name: { id: '' },
                parameter_name_id: '',
                product_id: this.value.id,
            },
        }
    },
    methods: {
        add(parameter) {
            this.$emit('add', parameter);
        }
    }
}
</script>

<style scoped>

</style>
