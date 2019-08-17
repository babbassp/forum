<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from "../components/SubscribeButton";

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

        components: {
            Replies, SubscribeButton
        }
    }
</script>
