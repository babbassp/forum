<template>
    <div>
        <div class="form-group" v-if="signedIn">
            <textarea class="form-control rounded"
                      type="text" id="body" name="body"
                      placeholder="Add a public reply..."
                      rows="5" v-model="body" required>
            </textarea>
            <button class="btn btn-primary mt-2" type="submit" @click="add()" :disabled="!body">REPLY</button>
        </div>
        <p class="text-center" v-else>Please <a href="/login">sign in</a> to participate.</p>
    </div>
</template>

<script>
    export default {
        name: "NewReply.vue",

        data() {
            return {
                body: ''
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            add() {
                axios.post(location.pathname + '/replies', {body: this.body})
                    .then(({data}) => {
                        this.body = '';

                        flash('Your reply has been posted.');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
