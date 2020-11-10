<template>
    <div class="b-mini_cart">
        <div class="b-mini_cart_header">
            VAŠA KOŠARICA
            <span class="b-close_search" id="b-close_cart"></span>
        </div>
        <ul v-if="$store.state.cart.count" class="b-mini_cart_items mb-0 list-unstyled">
            <li v-for="item in $store.state.cart.items" class="clearfix">
                <img :src="base_path + item.associatedModel.image" width="50" :alt="item.name">
                <span class="item-name">{{ item.name }}</span>
                <span class="item-price">{{ item.quantity }}&nbsp;x&nbsp;<span>{{ item.price ? Number(item.price).toFixed(2) : item.price }} kn</span></span>
                <span @click.prevent="removeFromCart(item)" class="item-name float-right">x</span>
            </li>
        </ul>
        <div v-if="$store.state.cart.count" class="shopping-cart-total clearfix pl-3 pr-3 mb-4">
            <span class="lighter-text float-left">Sveukupno:</span>
            <span class="main-color-text float-right">{{ $store.state.cart.subtotal ? Number($store.state.cart.subtotal).toFixed(2) : $store.state.cart.subtotal }} kn</span>
        </div>
        <div v-if="$store.state.cart.count" class="pl-3 pr-3">
            <a :href="carturl" class="btn d-block mb-2">Košarica</a>
            <a :href="checkouturl" class="btn btn-bg d-block">Checkout</a>

        </div>

        <!-- Empty Cart -->
        <ul v-else class="b-mini_cart_items mb-0 list-unstyled">
            <li class="clearfix">
                <span class="lighter-text float-left">Imate Praznu Košaricu</span>
                <button @click="test()" class="btn d-block mb-2">Košarica</button>
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        props: {
            carturl: String,
            checkouturl: String,
        },
        data() {
            return {
                base_path: window.location.origin + '/'
            }
        },

        mounted() {},

        methods: {
            removeFromCart(item) {
                this.$store.dispatch('removeItem', item);
            }
        }
    };
</script>
