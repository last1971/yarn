<template>
    <div v-html="html"></div>
</template>

<script>
export default {
    name: "ArticleShow",
    props: {
        value: { type: String },
    },
    computed: {
        html() {
            const article = this.$store.getters['ARTICLE/GET'](this.value);
            return article ? article.content : '<div></div>'
        }
    },
    async created() {
        if (this.value) await this.$store.dispatch('ARTICLE/CACHE', this.value);
    }
}
</script>

<style scoped>

</style>
