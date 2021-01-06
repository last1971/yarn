<template>
    <div class="pa-2">
        <v-chip-group class="pl-12">
            <v-btn :disabled="disabled" @click="apply" rounded color="primary" class="mx-2">
                <v-icon left>mdi-filter</v-icon>
                Применить
            </v-btn>

            <v-chip v-for="a in appliedStrings" :key="a.parameter_name_id" close @click:close="appliedRemove(a)">
                {{ a.name }} : {{ a.values }}
            </v-chip>
        </v-chip-group>
        <v-slide-group class="pa-2">
            <v-slide-item v-slot="{  }" v-for="parameter in parameters" :key="parameter.parameterName.id">
                <v-card class="ma-2" elevation="4" :key="componentKey" rounded>
                    <v-card-title>
                        {{ parameter.parameterName.name }}
                    </v-card-title>
                    <v-divider/>
                    <v-virtual-scroll
                        :items="parameter.values"
                        :item-height="50"
                        height="300"
                    >
                        <template v-slot:default="{ item }">
                            <v-checkbox dense
                                        hide-details
                                        class="ma-0"
                                        v-model="item.checked"
                                        :disabled="!!item.disabled"
                                        @change="change(item)"
                            >
                                <template v-slot:label>
                                    <parameter-show :parameter-name="parameter.parameterName" :value="item"/>
                                </template>
                            </v-checkbox>
                        </template>
                    </v-virtual-scroll>
                </v-card>
            </v-slide-item>
        </v-slide-group>
    </div>
</template>

<script>
import ParameterShow from "./ParameterShow";

export default {
    name: "ParametersSelect",
    components: {ParameterShow},
    props: {
        value: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            parameters: [],
            selectedParameters: {},
            appliedParameters: {},
            appliedStrings: [],
            componentKey: 0,
        }
    },
    computed: {
        disabled() {
            return _.isEmpty(this.selectedParameters);
        },
    },
    watch: {
        value() {
            this.load();
        },
    },
    async created() {
        await this.load();
    },
    methods: {
        async load(item = null) {
            const product = _.cloneDeep(this.value);
            const {selectedParameters} = this;
            Object.assign(product, {selectedParameters});
            const source = await axios.get(
                this.$store.getters['PARAMETER-VALUE/URL'], {params: {product}}
            );
            if (!item) {
                const values = _.groupBy(source.data, 'parameter_name_id');
                if (_.isEmpty(this.$store.getters['PARAMETER-NAME/ALL'])) {
                    await this.$store.dispatch(
                        'PARAMETER-NAME/ALL',
                        {sortBy: ['name'], sortDesc: [false], with: ['parameterUnit.parameterUnits']}
                    );
                }
                this.parameters = this.$store.getters['PARAMETER-NAME/ALL']
                    .filter((parameterName) => values[parameterName.id] && !this.appliedParameters[parameterName.id]) // && values[parameterName.id].length > 1)
                    .map((parameterName) => {
                        return {parameterName, values: values[parameterName.id]}
                    });
            } else {
                this.parameters.forEach((parameter) => {
                    if (parameter.parameterName.id !== item.parameter_name_id) {
                        parameter.values.forEach((value) => {
                            if (_.find(source.data, _.omit(value, ['checked', 'disabled']))) {
                                value.disabled = false;
                            } else {
                                value.disabled = true;
                            }
                        });
                    }
                });
                this.componentKey += 1;
            }
        },
        async change(item) {
            const selectedParameters = _.cloneDeep(this.selectedParameters);
            if (item.checked) {
                if (selectedParameters[item.parameter_name_id]) {
                    selectedParameters[item.parameter_name_id].push(_.omit(item, ['parameter_name_id', 'checked']));
                } else {
                    selectedParameters[item.parameter_name_id] = [_.omit(item, ['parameter_name_id', 'checked'])];
                }
            } else {
                const index = _.findIndex(
                    selectedParameters[item.parameter_name_id], _.omit(item, ['parameter_name_id', 'checked'])
                );
                selectedParameters[item.parameter_name_id].splice(index, 1);
            }
            this.selectedParameters = selectedParameters;
            await this.load(item);
        },
        apply() {
            const product = _.cloneDeep(this.value);
            const {selectedParameters} = this;
            Object.assign(product, {selectedParameters});
            Object.assign(this.appliedParameters, selectedParameters);

            this.appliedStrings = _.map(this.appliedParameters, (value, key) => {
                const parameterName = this.$store.getters['PARAMETER-NAME/GET'](key);
                const { name } = parameterName;
                const values = value.reduce((res, v) => {
                    if (parameterName.type === 'string') {
                        return res + v.string_value + ', '
                    } else if (parameterName.type === 'numeric') {
                        return res + this.numericValue(v) + this.abbreviation(parameterName, v) + ', '
                    } else {
                        return res + v.string_value + ' - ' + this.numericValue(v)
                            + this.abbreviation(parameterName, v) + ', '
                    }
                }, '').slice(0, -2);
                return { name, values, parameter_name_id: key }
            });


            this.$emit('input', product);
        },
        appliedRemove(a) {
            this.selectedParameters = _.omit(this.selectedParameters, [a.parameter_name_id]);
            this.appliedParameters =_.omit(this.appliedParameters, [a.parameter_name_id]);
            this.apply();
        },
        abbreviation(parameterName, value) {
            const unit = parameterName.parameter_unit.id === value.parameter_unit_id
                ? parameterName.parameter_unit
                : _.find(parameterName.parameter_unit.parameter_units, { id: value.parameter_unit_id });
            return unit.abbreviation;
        },
        numericValue(value) {
            return new Intl.NumberFormat('ru-RU', { minimumFractionDigits: value.fraction })
                .format(value.numeric_value)
        }
    }
}
</script>

<style scoped>

</style>
