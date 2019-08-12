<template>

</template>

<script>
    import Replies from '../components/Replies.vue';

    export default {
        name: "thread-view",

        props: ['initialRepliesCount'],

        data() {
            return {
                repliesCount: this.initialRepliesCount
            };
        },

        computed: {
            repliesString() {
                return pluralize('replies', this.repliesCount);
            }
        },

        components: {Replies}
    }
</script>
