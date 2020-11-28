<template>
    <div id="top-cart">
        <a :href="carturl" v-if="mobile"><i class="icon-shopping-cart"></i><span>{{ $store.state.cart ? $store.state.cart.count : 0 }}</span></a>
        <a href="#" id="top-cart-trigger" v-else><i class="icon-shopping-cart"></i><span>{{ $store.state.cart ? $store.state.cart.count : 0 }}</span></a>
        <div class="top-cart-content" v-if="$store.state.cart.count">
            <div class="top-cart-title">
                <h4>Košarica</h4>
            </div>
            <div class="top-cart-items">
                <div class="top-cart-item clearfix" v-for="item in $store.state.cart.items">
                    <div class="top-cart-item-image">
                        <a  :href="base_path + item.attributes.path">
                            <img :src="base_path + item.associatedModel.image" :alt="item.name" :title="item.name" />
                        </a>
                    </div>
                    <div class="top-cart-item-desc">
                        <a :href="base_path + item.attributes.path">{{ item.name }}</a>
                        <span class="top-cart-item-price">{{ Object.keys(item.conditions).length ? $store.state.service.formatPrice(item.price - item.conditions.parsedRawValue) : $store.state.service.formatPrice(item.price) }}</span>
                        <span class="top-cart-item-quantity">x {{ item.quantity }}</span>
                    </div>
                </div>
            </div>
            <div class="top-cart-action clearfix">
                <span class="fleft top-checkout-price">{{ $store.state.service.formatPrice($store.state.cart.total) }}</span>
                <a :href="carturl" class="btn btn-green float-right">Košarica</a>
            </div>
        </div>
        <div class="top-cart-content" v-else>
            <div class="top-cart-title text-center" style="padding: 20px">
                <i class="icon-cart icon-2x" style="color: #aaaaaa"></i>
                <h4>Vaša košarica je prazna!</h4>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            carturl: String,
            checkouturl: String
        },
        //
        data() {
            return {
                base_path: window.location.origin + '/',
                success_path: window.location.origin + '/kosarica/success',
                mobile: false
            }
        },
        //
        mounted() {
            this.getCart();

            if (window.location.pathname == '/kosarica/success') {
                this.$store.dispatch('flushCart');
            }

            if (window.innerWidth < 800) {
                this.mobile = true;
            }
        },
        //
        methods: {
            //
            getCart() {
                this.$store.dispatch('getCart')
            },
            //
            removeFromCart(item) {
                //this.$store.dispatch('removeItem', item);
            }
        }
    };
</script>
