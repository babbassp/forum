<template>
    <div>
        <div :key="reply.id" v-for="(reply, index) in items">
            <reply :data="reply" @delete-reply="remove(index)"></reply>
        </div>

        <paginator :dataSet="dataSet" @updated="fetch($event)"></paginator>

        <new-reply @create-reply="add($event)"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from "./NewReply.vue";
    import Collection from "../mixins/Collection.js";

    export default {
        data() {
            return {
                dataSet: [],
                items: []
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page) {
                axios.get(this.path(page))
                    .then(this.refresh);
            },
            path(page) {
                if (!page) {
                    const url = new URL(location.href);
                    const query = url.searchParams.get("page");
                    page = query ? query : 1;
                }

                return location.pathname + '/replies?page=' + page;
            },
            refresh(response) {
                this.dataSet = response.data;
                this.items = this.dataSet.data;

                window.scrollTo(0, 0);
            }
        },

        components: {
            Reply, NewReply
        },

        mixins: [Collection]
    }
</script>
