<template>
    <button v-bind:class="classes" type="submit" v-on:click="updateFavoriteCount()">
        <i class="fa fa-thumbs-o-up"></i>
        <span class="badge badge-light" v-text="count"></span>
        <span class="sr-only">number of favorites</span>
    </button>
</template>

<script>
    export default {
        props: {
            reply: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                count: this.reply.favoritesCount,
                favorited: this.reply.isFavorited
            }
        },
        computed: {
            classes() {
                return ['btn', this.favorited ? 'btn-info' : ''];
            },
            path() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },
        methods: {
            updateFavoriteCount() {
                if (this.favorited) {
                    this.destroy();
                } else {
                    this.create();
                }
            },
            destroy() {
                axios.delete(this.path);
                this.favorited = false;
                this.count--;
            },
            create() {
                axios.post(this.path);
                this.favorited = true;
                this.count++;
            }
        }
    }
</script>
