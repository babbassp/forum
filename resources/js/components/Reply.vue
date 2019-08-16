<template>
    <div :id="'reply-' + id" class="card mb-3">
        <div class="card-header">
            <div class="d-flex">
                <div class="p2 mr-auto">
                    <h4>
                        <a class="card-link" :href="'/profiles/' + ownerName" v-text="ownerName"></a> <small>{{ createdAt }} ago</small>
                    </h4>
                </div>
                <div v-if="signedIn">
                    <div class="p2">
                        <favorite :reply="data"></favorite>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" name="textarea-reply" id="textarea-reply" v-model="body"></textarea>
                </div>
                <div class="d-flex">
                    <div class="form-group">
                        <div class="p2 mr-1">
                            <button class="btn btn-sm btn-link"
                                    type="submit" :disabled="!body" @click="update()">Update
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="p2">
                            <button class="btn btn-sm" @click="cancel()">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else v-text="body"></div>
        </div>
        <div class="card-footer" v-if="canUpdate">
            <div class="d-flex">
                <div class="p2 mr-1">
                    <button class="btn btn-sm btn-outline-primary" type="submit"
                            @click="edit()">Edit
                    </button>
                </div>
                <div class="p2">
                    <button class="btn btn-sm btn-outline-danger" type="submit"
                            @click="destroy()">Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['data'],

        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body,
                ownerName: this.data.owner.name
            };
        },

        created() {
            this.original = this.data.body;
            this.createdAt = moment(this.data.created_at).fromNow(true);
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            },
            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id);
            }
        },

        methods: {
            update() {
                if (this.body !== '') {
                    axios.patch(
                        '/replies/' + this.data.id,
                        {body: this.body}
                    );

                    this.original = this.body;
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
                axios.delete('/replies/' + this.data.id);

                flash('Reply removed.');

                this.$emit('delete-reply');
            }
        },

        components: {Favorite}
    }
</script>
