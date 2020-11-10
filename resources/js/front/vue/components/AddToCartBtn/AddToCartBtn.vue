<template>
    <div class="cart mb-0 d-flex align-items-center">
        <div class="quantity clearfix">
            <input type="button" value="-" class="minus" @click="subtractQuantity()">
            <input type="text" v-model="quantity" class="qty" />
            <input type="button" value="+" class="plus" @click="addQuantity()">
        </div>
        <button class="btn btn-green" @click="addToCart()">Dodaj u Košaricu</button>
    </div>
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
            this.checkCart()
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
            },

            subtractQuantity() {
                if (this.quantity > 1) {
                    this.quantity = this.quantity - 1;
                }
            },

            addQuantity() {
                this.quantity = this.quantity + 1;
            },

            checkCart() {
                let found = this.$store.state.cart.items.find(product => product.id == this.id);

                if (found) {
                    this.quantity = found.quantity
                }
            }
        }
    };
</script>
