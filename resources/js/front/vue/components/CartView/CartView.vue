<template>
    <section id="content">
        <div class="content-wrap">
            <div class="container" v-if="$store.state.cart.count">
                <div class="table-responsive mb-5">
                    <table class="table cart">
                        <thead>
                        <tr>
                            <th class="cart-product-remove" v-if="!mobile">&nbsp;</th>
                            <th class="cart-product-thumbnail" v-if="!mobile">&nbsp;</th>
                            <th class="cart-product-name">Naziv artikla</th>
                            <th class="cart-product-price" v-if="!mobile">Cijena</th>
                            <th class="cart-product-quantity">Količina</th>
                            <th class="cart-product-remove" v-if="!mobile">&nbsp;</th>
                            <th class="cart-product-subtotal">Ukupno</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="cart_item" v-for="item in $store.state.cart.items">
                            <td class="cart-product-remove" v-if="!mobile">
                                <a @click.prevent="removeFromCart(item)" class="remove" title="Ukloni" v-if="show_delete_btn"><i class="icon-trash2"></i></a>
                            </td>

                            <td class="cart-product-thumbnail" v-if="!mobile">
                                <a :href="item.attributes.url + item.associatedModel.slug">
                                    <img width="64" height="64" :src="base_path + item.associatedModel.image" :alt="item.name" :title="item.name">
                                </a>
                            </td>

                            <td class="cart-product-name">
                                <a :href="item.attributes.url + item.associatedModel.slug">{{ item.name }}</a>
                            </td>

                            <td class="cart-product-price" v-if="!mobile">
                                <span class="amount">{{ item.price ? Number(item.price).toFixed(2) : item.price }} kn</span>
                            </td>

                            <td class="cart-product-quantity">
                                <input type="number" min="1" step="1" v-model="item.quantity" class="form-control qty-form" />
                            </td>

                            <td class="cart-product-remove" v-if="!mobile">
                                <a @click.prevent="recalculateCart(item)" class="remove" title="Ukloni"><i class="icon-refresh2" style="margin-left: 10px;"></i></a>
                            </td>

                            <td class="cart-product-subtotal">
                                <span class="amount">{{ item.price ? Number(item.price * item.quantity).toFixed(2) : item.price * item.quantity }} kn</span>
                            </td>
                        </tr>

                        <tr class="cart_item">
                            <td colspan="7">
                                <div class="row">
                                    <div class="col-lg-12 p-0">
                                        <a v-if="buttons" :href="checkouturl" class="btn btn-green float-right">Plaćanje</a>
                                        <a v-if="buttons" :href="continueurl" class="btn button-border noleftmargin float-right">Nazad na trgovinu</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>

                    </table>
                </div>

                <div class="row col-mb-30">
                    <div class="col-lg-6">
                    </div>

                    <div class="col-lg-6">
                        <h4>Iznos košarice</h4>

                        <div class="table-responsive">
                            <table class="table cart">
                                <tbody>
                                <tr class="cart_item">
                                    <td class="cart-product-name">
                                        <strong>Među suma</strong>
                                    </td>

                                    <td class="cart-product-name">
                                        <span class="amount">{{ $store.state.cart.subtotal ? Number($store.state.cart.subtotal).toFixed(2) : $store.state.cart.subtotal }} kn</span>
                                    </td>
                                </tr>
                                <tr class="cart_item">
                                    <td class="cart-product-name">
                                        <strong>Poštarina</strong>
                                    </td>

                                    <td class="cart-product-name">
                                        <span class="amount">Besplatna</span>
                                    </td>
                                </tr>
                                <tr class="cart_item">
                                    <td class="cart-product-name">
                                        <strong>Ukupno</strong>
                                    </td>

                                    <td class="cart-product-name">
                                        <span class="amount color lead"><strong>{{ $store.state.cart.subtotal ? Number($store.state.cart.subtotal).toFixed(2) : $store.state.cart.subtotal }} kn</strong></span>
                                    </td>
                                </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <div class="container" v-else>
                <div class="table-responsive mb-5">
                    <table class="table cart">
                        <tbody>
                        <tr class="cart_item">
                            <td colspan="6">
                                <div class="row">
                                    <div class="col-12 p-0">
                                        <h2><b>VAŠA KOŠARICA JE TRENUTNO PRAZNA.</b></h2>
                                        <p>
                                            Prije nego odete na Checkout morate staviti nešto u košaricu.
                                            <br>Naći ćete puno različitih stvari u našoj trgovini.
                                        </p>
                                        <a :href="continueurl" class="btn button-border noleftmargin float-right">Nazad na Trgovinu</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" name="order_data" :value="JSON.stringify($store.state.cart)">

        </div>
    </section>

</template>

<script>
    export default {
        props: {
            continueurl: String,
            checkouturl: String,
            buttons: {type: Boolean, default: true},
        },
        data() {
            return {
                base_path: window.location.origin + '/',
                mobile: false,
                show_delete_btn: true
            }
        },
        mounted() {
            if (window.innerWidth < 800/* && window.location.pathname == '/kosarica/naplata'*/) {
                this.mobile = true;
            }

            this.checkIfEmpty();

            if (window.location.pathname == '/kosarica/naplata') {
                this.show_delete_btn = false;
            }
        },

        methods: {
            recalculateCart(item) {
                this.$store.dispatch('updateCart', item);
            },

            removeFromCart(item) {
                this.$store.dispatch('removeItem', item).then((response) => {
                    console.log(response)
                    //this.checkIfEmpty();
                });
            },

            CheckQuantity(qty) {
                if (qty < 1) {
                    return 1;
                }

                return qty;
            },
            checkIfEmpty() {
                let cart = this.$store.state.storage.get();

                if ( ! cart.count && window.location.pathname != '/kosarica') {
                    window.location.href = '/kosarica';
                }
            }
        }
    };
</script>
