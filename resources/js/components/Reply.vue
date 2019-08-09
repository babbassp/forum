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
        methods: {
            update() {
                if (this.body !== '') {
                    axios.patch(
                        '/reply/' + this.attributes.id,
                        {body: this.body}
                    );
                    this.editing = false;
                    flash('Reply updated!');
                }
            }
        },
        components: {
            Favorite
        }
    }
</script>