<template>
    <v-dialog v-model="isEdited" max-width="800">
        <template v-slot:activator="{ on }">
            <v-btn icon color="success" v-on="on">
                <v-icon v-if="value">mdi-pencil</v-icon>
                <v-icon v-else>mdi-plus</v-icon>
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="headline">
                <span class="headline">{{ title }}</span>
                <v-spacer/>
                <v-btn @click="close" icon right>
                    <v-icon color="red">mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider/>
            <v-card-text>
                <slot name="body" v-bind:editingValue="proxy"/>
            </v-card-text>
            <v-card-actions class="d-flex justify-end">
                <v-btn rounded color="success" :disabled="saveNotPossible" @click="save" :loading="loading">
                    <v-icon left>mdi-content-save</v-icon>
                    <span>Сохранить</span>
                </v-btn>
                <v-btn rounded color="error" @click="close">
                    <v-icon left>mdi-close</v-icon>
                    <span>Отменить</span>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "ModalEdit",
    props: {
        value: {
            validator: prop => typeof prop === 'string' || prop === null,
            required: true,
        },
        model: {
            type: String,
            required: true,
        },
        title: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
            proxy: {},
            isEdited: false,
            loading: false,
        }
    },
    computed: {
        saveNotPossible() {
            const compare = _.cloneDeep(this.$store.getters[this.MODEL + '/GET'](this.value))
                || _.cloneDeep(this.$store.getters[this.MODEL + '/NEW-VALUE']);
            return _.isEqual(compare, this.proxy);
        },
        MODEL() {
            return _.toUpper(this.model);
        },
    },
    watch: {
        value()  {
            this.setProxy();
        },
        isEdited(v) {
            if (v) this.setProxy();
        }
    },
    created() {
        this.setProxy();
    },
    methods: {
        async setProxy() {
            if (this.value) {
                this.loading = true;
                this.proxy = _.cloneDeep(await this.$store.dispatch(this.MODEL + '/CACHE', this.value));
                this.loading = false;
            } else {
                this.proxy = _.cloneDeep(this.$store.getters[this.MODEL + '/NEW-VALUE']);
            }
        },
        close() {
            this.isEdited = false;
            this.$emit('close');
        },
        async save() {
            this.loading = true;
            try {
                const action = this.proxy.id ? '/UPDATE' : '/CREATE';
                const res = await this.$store.dispatch(this.MODEL + action, _.cloneDeep(this.proxy));
                this.$emit('added', res[this.$store.getters[this.MODEL + '/KEY']]);
                this.close();
            } catch (e) {
                console.error(e)
            }
            this.loading = false;
        }
    }
}
</script>

<style scoped>

</style>
