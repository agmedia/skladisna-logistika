<template>
    <span class="b-add_cart">
        <i class="icon-basket icons"></i>
        <a href="javascript:void(0);" @click="addToCart()">Dodaj u košaricu</a>
    </span>
</template>

<script>
    export default {
        props: {
            id: String,
            image: String,
            name: String,
            price: String
        },
        data() {
            return {
                quantity: 1
            }
        },
        mounted() {

        },
        methods: {
            addToCart() {
                let item = {
                    id: this.id,
                    name: this.name,
                    image: this.image,
                    price: this.price,
                    quantity: this.quantity
                }
                this.$store.dispatch('addCart', item);
            }
        }
    };
</script>
