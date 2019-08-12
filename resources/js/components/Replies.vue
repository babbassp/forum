<template>
    <div>
        <div :key="reply.id" v-for="reply in items">
            <reply :data="reply" @deleted="remove()"></reply>
        </div>
    </div>
</template>

<script>
    import Reply from './Reply.vue';

    export default {
        props: ['data'],

        data() {
            return {
                items: this.data
            }
        },

        methods: {
            remove(index) {
                this.items.splice(index, 1);

                this.$emit('remove');
            }
        },

        components: {Reply}
    }
</script>
