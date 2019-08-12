<template>
    <div>
        <div :key="reply.id" v-for="(reply, index) in items">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply @created="add($event)"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from "./NewReply";

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
            },
            add(reply) {
                this.items.push(reply);

                this.$emit('add');
            }
        },

        components: {
            Reply, NewReply
        }
    }
</script>
