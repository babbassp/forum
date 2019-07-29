<template>
    <div class="alert-flash" v-bind:class="alertClassType" role="alert" v-show="show">
        {{ this.status | capitalize }}!
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {
            status: {
                type: String,
                default: 'info',
                validator(value) {
                    return ['success', 'danger', 'warning', 'info'].indexOf(value.toLowerCase()) !== -1;
                }
            }
        },
        data() {
            return {
                show: false
            }
        },
        created() {
            if (!!this.$slots.default) {
                this.flash(this.$slots.default);
            }

            window.events.$on('flash', message => this.flash(message));
        },
        computed: {
            alertClassType() {
                return `alert alert-${this.status}`;
            }
        },
        methods: {
            flash(message) {
                this.$slots.default = message;
                this.show = true;

                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 5000);
            }
        },
        filters: {
            capitalize(value) {
                if (!value) return '';
                value = value.toString();
                return value.charAt(0).toUpperCase() + value.slice(1);
            }
        }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        right: 0;
        bottom: 0;
    }
</style>