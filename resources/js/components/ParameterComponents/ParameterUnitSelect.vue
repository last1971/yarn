<template>
    <v-select
        v-model="proxy"
        :items="items"
        item-text="name"
        item-value="id"
        label="Единица"
    ></v-select>
</template>

<script>
export default {
    name: "ParameterUnitSelect",
    props: {
        value: { type: String },
        parameterNameId: { type: String, required: true },
    },
    computed: {
        mainUnit() {
            const parameterName = this.$store.getters['PARAMETER-NAME/GET'](this.parameterNameId);
            return parameterName ? parameterName.parameter_unit : false;
        },
        items() {
            if (!this.mainUnit) return [];
            const parameterUnits = _.cloneDeep(this.mainUnit.parameter_units);
            parameterUnits.push(_.omit(this.mainUnit, ['parameter_units']));
            parameterUnits.sort((a, b) => {
                if ( a > b ) return 1;
                if ( b > a ) return -1;
                return 0;
            });
            return parameterUnits;
        },
        proxy: {
            get() {
                return this.value;
            },
            set(v) {
                this.$emit('input', v);
            }
        }
    },
    methods: {
        input(v) {
            this.$emit('input', v);
        }
    }
}
</script>

<style scoped>

</style>
