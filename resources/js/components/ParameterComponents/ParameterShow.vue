<template>
    <div class="text-body-2">
        <span v-if="parameterName.type === 'string' || parameterName.type === 'complex'">
            {{ value.string_value }}
        </span>
        <span v-if="parameterName.type !== 'string'">
            {{
                new Intl.NumberFormat('ru-RU', { minimumFractionDigits: value.fraction }).format(value.numeric_value)
            }}
            {{  abbreviation }}
        </span>
    </div>
</template>

<script>
export default {
    name: "ParameterShow",
    props: {
        parameterName: {
            type: Object,
            required: true,
        },
        value: {
            type: Object,
            required: true,
        }
    },
    computed: {
        abbreviation() {
            if (this.value.parameter_unit) {
                return this.value.parameter_unit.abbreviation;
            }
            if (this.parameterName.parameter_unit.id === this.value.parameter_unit_id) {
                return this.parameterName.parameter_unit.abbreviation;
            }
            const unit = _.find(this.parameterName.parameter_unit.parameter_units, { id: this.value.parameter_unit_id });
            return unit.abbreviation;
        }
    }
}
</script>

<style scoped>

</style>
