<template>
    <section id="content">
        <div class="content-wrap">
            <div class="container" v-if="$store.state.cart ? $store.state.cart.count : 0">
                <!-- Desktop Cart items table -->
                <div class="table-responsive mb-5" v-if="!mobile">
                    <table class="table cart">
                        <thead>
                        <tr>
                            <th class="cart-product-remove"  style="width: 50px">&nbsp;</th>
                            <th class="cart-product-thumbnail"  style="width: 5%">&nbsp;</th>
                            <th class="cart-product-name">Naziv artikla</th>
                            <th class="cart-product-quantity" style="width: 100px">Količina</th>
                            <th class="cart-product-remove"  style="width: 30px">&nbsp;</th>
                            <th class="cart-product-price"  style="width: 12%">Jed. Cijena</th>
                            <th class="cart-product-price"  style="width: 12%">Iznos</th>
                            <th class="cart-product-price"  style="width: 12%">Rabat</th>
                            <th class="cart-product-subtotal" style="width: 12%">Ukupno</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="cart_item" v-for="item in $store.state.cart.items">
                            <td class="cart-product-remove text-center" >
                                <a @click.prevent="removeFromCart(item)" class="remove" title="Ukloni"><i class="icon-trash2 text-danger"></i></a>
                            </td>

                            <td class="cart-product-thumbnail" >
                                <a :href="base_path + item.attributes.path">
                                    <img width="64" height="64" :src="base_path + item.associatedModel.image" :alt="item.name" :title="item.name">
                                </a>
                            </td>

                            <td class="cart-product-name">
                                <a :href="base_path + item.attributes.path">{{ item.name }}</a>
                            </td>

                            <td class="cart-product-quantity text-right" style="padding-right: .1rem !important;">
                                <input type="number" min="1" step="1" v-model="item.quantity" class="form-control qty-form" />
                            </td>

                            <td class="cart-product-remove text-left"  style="padding-left: .1rem !important;">
                                <a @click.prevent="updateCart(item)" class="remove" title="Obnovi"><i class="icon-refresh2 text-info" style="margin-left: 10px;"></i></a>
                            </td>

                            <td class="cart-product-price text-right" >
                                <span class="amount">{{ $store.state.service.formatPrice(item.price) }}</span>
                            </td>

                            <td class="cart-product-price" >
                                <span class="amount">{{ $store.state.service.formatPrice(item.price * item.quantity) }}</span>
                            </td>

                            <td class="cart-product-price">
                                <span class="amount">{{ Object.keys(item.conditions).length ? '-' + $store.state.service.formatPrice(item.conditions.parsedRawValue * item.quantity) : '' }}</span>
                            </td>


                            <td class="cart-product-subtotal">
                                <span class="amount">{{ Object.keys(item.conditions).length ? $store.state.service.formatPrice((item.price - item.conditions.parsedRawValue) * item.quantity) : $store.state.service.formatPrice(item.price * item.quantity) }}</span>
                            </td>
                        </tr>

                        <tr class="cart_item">
                            <td colspan="5">
                                <div class="row">
                                    <div class="col-md-6" style="padding-right: 0;">
                                        <input type="text" v-model="coupon" placeholder="Upišite kupon" class="sm-form-control">
                                    </div>
                                    <div class="col-md-6" style="padding-left: 0;">
                                        <a @click.prevent="checkCoupon()" class="btn button-border" style="margin-left: 10px;">Koristi Kupon</a>
                                    </div>
                                </div>
                            </td>
                            <td colspan="4">
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

                <!-- Mobile Cart items table -->
                <div class="table-responsive mb-0" v-if="mobile">
                    <table class="table cart">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 20%"><i class="icon-cart"></i></th>
                            <th class="cart-product-name">Detalji košarice</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="cart_item" v-for="item in $store.state.cart.items">
                            <td class="cart-product-thumbnail">
                                <a :href="base_path + item.attributes.path">
                                    <img width="64" height="64" :src="base_path + item.associatedModel.image" :alt="item.name" :title="item.name">
                                </a>
                            </td>

                            <td class="cart-product-name">
                                <a :href="base_path + item.attributes.path">{{ item.name }}</a> <span class="float-right"><a @click.prevent="removeFromCart(item)" class="remove" title="Ukloni"><i class="icon-trash2" style="color: #999999;"></i></a></span>
                                <br>
                                <div class="row" style="margin: 5px 0px;">
                                    <div class="col-xs-2">
                                        <input type="number" min="1" step="1" v-model="item.quantity" class="form-control qty-form" style="max-width: 54px;" />
                                    </div>
                                    <div class="col-xs-1" style="padding-top: 7px;">
                                        <a @click.prevent="updateCart(item)" class="remove" title="Obnovi"><i class="icon-refresh2 text-info" style="margin-left: 15px;"></i></a>
                                    </div>
                                    <div class="col-xs-9">
                                        <span class="mobile-prices float-right text-right">
                                            {{ 'x ' + $store.state.service.formatPrice(item.price) + '&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;' + $store.state.service.formatPrice(item.price * item.quantity) }}
                                            <br>
                                            {{ Object.keys(item.conditions).length ? '-' + $store.state.service.formatPrice(item.conditions.parsedRawValue * item.quantity) : '' }}
                                            <br>
                                        </span>
                                        <span class="float-right text-right">
                                            {{ Object.keys(item.conditions).length ? $store.state.service.formatPrice((item.price - item.conditions.parsedRawValue) * item.quantity) : $store.state.service.formatPrice(item.price * item.quantity) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr class="empty">
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-lg-12 p-0">
                                        <input type="text" v-model="coupon" placeholder="Upišite kupon" class="sm-form-control" style="width: 40%; display: inline;">
                                        <span>
                                            <a @click.prevent="checkCoupon()" class="btn button-border float-right" style="width: 55%;">Koristi Kupon</a>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="row col-mb-30 text-right">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <h4 class="text-left">Iznos košarice</h4>
                        <div class="table-responsive">
                            <table class="table cart" style="margin-bottom: 0 !important;">
                                <tbody>
                                <tr class="cart_item">
                                    <td class="cart-product-name">
                                        <strong>Među suma</strong>
                                    </td>
                                    <td class="cart-product-name">
                                        <span class="amount">{{ $store.state.service.formatPrice($store.state.cart.subtotal) }}</span>
                                    </td>
                                </tr>
                                <tr class="cart_item" v-for="tax in $store.state.cart.tax">
                                    <td class="cart-product-name">
                                        <strong>{{ tax.title }}</strong>
                                    </td>
                                    <td class="cart-product-name">
                                        <span class="amount">{{ $store.state.service.formatPrice(tax.value) }}</span>
                                    </td>
                                </tr>
                                <tr class="cart_item">
                                    <td class="cart-product-name">
                                        <strong>Ukupno</strong>
                                    </td>
                                    <td class="cart-product-name">
                                        <span class="amount color lead"><strong>{{ $store.state.service.formatPrice($store.state.cart.total) }}</strong></span>
                                    </td>
                                </tr>

                                <!-- Mobile back / checkout buttons -->
                                <tr class="empty" v-if="mobile">
                                    <td colspan="2">
                                        <div class="row">
                                            <div class="col-lg-12 p-0 mt-3">
                                                <a v-if="buttons" :href="checkouturl" class="btn btn-green float-right">Plaćanje</a>
                                                <a v-if="buttons" :href="continueurl" class="btn button-border noleftmargin float-right">Nazad na trgovinu</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- If Cart is empty -->
            <div class="container" v-else>
                <div class="table-responsive mb-5">
                    <table class="table empty">
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

            <!-- Input for checkout post request -->
            <input v-if="!show_delete_btn" type="hidden" name="order_data" :value="JSON.stringify($store.state.cart)">
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
                show_delete_btn: true,
                coupon: ''
            }
        },
        mounted() {
            if (window.innerWidth < 800) {
                this.mobile = true;
            }

            this.checkIfEmpty();
            this.setCoupon();

            if (window.location.pathname == '/kosarica/naplata') {
                this.show_delete_btn = false;
            }
        },

        methods: {

            /**
             *
             * @param item
             */
            updateCart(item) {
                this.$store.dispatch('updateCart', item);
            },

            /**
             *
             * @param item
             */
            removeFromCart(item) {
                this.$store.dispatch('removeFromCart', item);
            },

            /**
             *
             * @param qty
             * @returns {number|*}
             * @constructor
             */
            CheckQuantity(qty) {
                if (qty < 1) {
                    return 1;
                }

                return qty;
            },

            /**
             *
             */
            checkIfEmpty() {
                let cart = this.$store.state.storage.getCart();

                if (cart && ! cart.count && window.location.pathname != '/kosarica') {
                    window.location.href = '/kosarica';
                }
            },

            /**
             *
             */
            setCoupon() {
                let cart = this.$store.state.storage.getCart();

                this.coupon = cart.coupon;
            },

            /**
             *
             */
            checkCoupon() {
                this.$store.dispatch('checkCoupon', this.coupon);
            }
        }
    };
</script>


<style>
.table th, .table td {
    padding: 0.75rem 0.45rem !important;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.empty th, .empty td {
    padding: 1rem !important;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.mobile-prices {
    font-size: .66rem;
    color: #999999;
}
</style>
