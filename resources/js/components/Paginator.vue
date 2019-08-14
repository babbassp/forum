<template>
    <div v-show="shouldPaginate">
        <ul class="pagination">
            <li class="page-item" v-show="hasPreviousUrl" @click.prevent="page--">
                <a class="page-link" href="#" rel="prev">&laquo; Previous</a>
            </li>
            <li class="page-item" v-show="hasNextUrl">
                <a class="page-link" href="#" rel="next" @click.prevent="page++">Next &raquo;</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "Paginator",

        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false
            };
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },
            page() {
                this.updatePaginator().updateUrl();
            }
        },

        computed: {
            shouldPaginate() {
                return !!this.prevUrl || !!this.nextUrl;
            },
            hasPreviousUrl() {
                return this.prevUrl !== null;
            },
            hasNextUrl() {
                return this.nextUrl != null;
            }
        },

        methods: {
            updatePaginator() {
                return this.$emit('updated', this.page);
            },
            updateUrl() {
                history.replaceState(null, 'page ' + this.page, '?page=' + this.page);
            }
        }
    }
</script>
