export default {
    data() {
        return {
            items: []
        };
    },

    removeItem(index) {
        this.items.splice(index, 1);
        this.$emit('remove');
    },

    addItem(item) {
        this.items.push(item);
        this.$emit('add');
    }
}
