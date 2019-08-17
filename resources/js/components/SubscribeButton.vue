<template>
    <div v-show="signedIn">
        <button :class="classes" @click="toggle()">{{ btnLabel }}</button>
    </div>
</template>

<script>
    export default {
        name: "subscribe-button",

        props: ['initialActive'],

        data() {
            return { active: this.initialActive }
        },

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-dark' : 'btn-outline-dark'];
            },
            path() {
                return window.location + '/subscriptions';
            },
            signedIn() {
                return window.App.signedIn;
            },
            btnLabel() {
                return this.active ? 'Unsubscribe' : 'Subscribe';
            }
        },

        methods: {
            toggle() {
                this.active ? this.unsubscribe() : this.subscribe();
            },
            subscribe() {
                axios.post(this.path)
                    .then(() => {
                        this.active = true;
                        flash('Subscribed.');
                    });
            },
            unsubscribe() {
                axios.delete(this.path)
                    .then(() => {
                        this.active = false;
                        flash('Unscribed.');
                    });
            }
        }
    }
</script>
