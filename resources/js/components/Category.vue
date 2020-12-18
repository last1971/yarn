<template>
    <v-main>
        <v-row v-if="instance">
           <v-col>
               <picture-slider-edit v-model="instance" model="category" />
           </v-col>
        </v-row>
    </v-main>
</template>

<script>
import PictureSliderEdit from "./PictureSliderEdit";
export default {
    name: "Category",
    components: {PictureSliderEdit},
    data() {
        return {
            instanceId: null,
            model: 'CATEGORY',
        }
    },
    computed: {
        instance() {
            return this.$store.getters[this.model + '/GET'](this.instanceId);
        },
    },
    methods: {
        setInstanceId(instanceId) {
            this.$store.dispatch(this.model + '/CACHE', instanceId)
                .then(() => {
                    this.instanceId = instanceId;
                });
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            vm.setInstanceId(to.params.id);
        });
    },
    beforeRouteUpdate (to, from, next) {
        this.setInstanceId(to.params.id);
    }
}
</script>

<style scoped>

</style>
