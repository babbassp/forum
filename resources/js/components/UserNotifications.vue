<template>
    <li class="nav-item dropdown" v-if="hasNotifications">
        <a id="notificationsDropdown" class="nav-link" href="#"
           role="button" data-toggle="dropdown" aria-haspopup="true"
           aria-expanded="false" v-pre>
            <i class="fa fa-bell"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
            <li v-for="(notification, index) in items" :key="notification.id">
                <a class="dropdown-item" :href="notification.data.link" @click="markAsRead(notification, index)">
                    {{ notification.data.message }}
                </a>
            </li>
        </ul>
    </li>
</template>

<script>
    import Collection from "../mixins/Collection.js";

    export default {
        name: "user-notifications",

        mixins: [Collection],

        data() {
            return {
                items: null
            }
        },

        created() {
            axios.get('/profiles/' + window.App.user.name + '/notifications')
                .then(response => this.items = response.data);
        },

        computed: {
            hasNotifications() {
                return this.items !== null && this.items.length !== 0;
            }
        },

        methods: {
            markAsRead(notification, index) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id);
                this.remove(index, 1);
            }
        }
    }
</script>
