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
                if (this.body !== '') {
                    axios.patch(
                        '/reply/' + this.attributes.id,
                        {body: this.body}
                    ).then(function () {
                        flash('Reply updated!');
                    }).catch(function (error) {
                        console.log(error.message);
                        flash('Reply could not be updated!');
                    });

                    this.editing = false;
                }
            }
        }
    }
</script>