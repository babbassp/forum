<script>
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
                axios.patch(
                    '/reply/' + this.attributes.id,
                    {body: this.body}
                );

                this.editing = false;

                flash('Reply updated!');
            }
        }
    }
</script>