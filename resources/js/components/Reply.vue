<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['attributes'],
        data() {
            return {
                editing: false,
                body: this.attributes.body
            };
        },
        created() {
            this.original = this.attributes.body;
        },
        methods: {
            update() {
                if (this.body !== '') {
                    axios.patch(
                        '/replies/' + this.attributes.id,
                        {body: this.body}
                    );
                    this.editing = false;
                    flash('Reply updated.');
                }
            },
            cancel() {
                this.body = this.original;
                this.editing = false;
            },
            edit() {
                this.editing = true;
            },
            destroy() {
                axios.delete('/replies/' + this.attributes.id);

                $(this.$el).fadeOut(500, function () {
                    flash('Reply deleted.');
                });
            }
        },
        components: {
            Favorite
        }
    }
</script>
