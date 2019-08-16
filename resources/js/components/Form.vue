<template>
    <form :id="form_id" v-bind:method="defaultMethod()" v-bind:action="action">
        <input type="hidden" name="_token" v-bind:value="csrf">
        <input type="hidden" name="_method" v-bind:value="uppercaseMethod">
        <slot></slot>
    </form>
</template>

<script>
    export default {
        props: {
            form_id: {
                type: String,
                required: false
            },
            method: {
                type: String,
                required: true,
                validator(value) {
                    return ['GET', 'POST', 'DELETE', 'UPDATE', 'CREATE'].indexOf(value.toUpperCase()) !== -1;
                }
            },
            action: {
                type: String,
                required: true
            },
            csrf: {
                type: String,
                required: true,
                validator(value) {
                    return value != '';
                }
            }
        },
        computed: {
            uppercaseMethod() {
                return this.method.toUpperCase();
            }
        },
        methods: {
            defaultMethod() {
                if (this.uppercaseMethod != 'GET') {
                    return 'POST';
                }

                return 'GET';
            }
        }
    }
</script>
