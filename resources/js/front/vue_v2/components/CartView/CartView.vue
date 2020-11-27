<template>
    <section id="content">
        <div class="content-wrap">
            <div class="container" v-if="$store.state.cart.count">
                <div class="table-responsive mb-5">
                    <table class="table cart">
                        <thead>
                        <tr>
                            <th class="cart-product-remove" v-if="!mobile" style="width: 50px">&nbsp;</th>
                            <th class="cart-product-thumbnail" v-if="!mobile" style="width: 5%">&nbsp;</th>
                            <th class="cart-product-name">Naziv artikla</th>
                            <th class="cart-product-quantity" style="width: 100px">Količina</th>
                            <th class="cart-product-remove" v-if="!mobile" style="width: 30px">&nbsp;</th>
                            <th class="cart-product-price" v-if="!mobile" style="width: 12%">Jed. Cijena</th>
                            <th class="cart-product-price" v-if="!mobile" style="width: 12%">Iznos</th>
                            <th class="cart-product-price" v-if="!mobile" style="width: 12%">Rabat</th>
                            <th class="cart-product-subtotal" style="width: 12%">Ukupno</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="cart_item" v-for="item in $store.state.cart.items">
                            <td class="cart-product-remove text-center" v-if="!mobile">
                                <a @click.prevent="removeFromCart(item)" class="remove" title="Ukloni" v-if="show_delete_btn"><i class="icon-trash2"></i></a>
                            </td>

                            <td class="cart-product-thumbnail" v-if="!mobile">
                                <a :href="base_path + item.attributes.path">
                                    <img width="64" height="64" :src="base_path + item.associatedModel.image" :alt="item.name" :title="item.name">
                                </a>
                            </td>

                            <td class="cart-product-name">
                                <a :href="base_path + item.attributes.path">{{ item.name }}</a>
                            </td>

                            <td class="cart-product-quantity text-right">
                                <input type="number" min="1" step="1" v-model="item.quantity" class="form-control qty-form" />
                            </td>

                            <td class="cart-product-remove text-left" v-if="!mobile">
                                <a @click.prevent="updateCart(item)" class="remove" title="Obnovi"><i class="icon-refresh2" style="margin-left: 10px;"></i></a>
                            </td>

                            <td class="cart-product-price text-right" v-if="!mobile">
                                <span class="amount">{{ Number(item.price).toLocaleString('hr-HR', currency_options) }}</span>
                            </td>

                            <td class="cart-product-price" v-if="!mobile">
                                <span class="amount">{{ Number(item.price * item.quantity).toLocaleString('hr-HR', currency_options) }}</span>
                            </td>

                            <td class="cart-product-price" v-if="!mobile">
                                <span class="amount">{{ Object.keys(item.conditions).length ? '-' + Number(item.conditions.parsedRawValue * item.quantity).toLocaleString('hr-HR', currency_options) : '' }}</span>
                            </td>


                            <td class="cart-product-subtotal">
                                <span class="amount">{{ Object.keys(item.conditions).length ? Number((item.price - item.conditions.parsedRawValue) * item.quantity).toLocaleString('hr-HR', currency_options) : Number(item.price * item.quantity).toLocaleString('hr-HR', currency_options) }}</span>
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
                                        <span class="amount">{{ Number($store.state.cart.subtotal).toLocaleString('hr-HR', currency_options) }}</span>
                                    </td>
                                </tr>
                                <tr class="cart_item" v-for="tax in $store.state.cart.tax">
                                    <td class="cart-product-name">
                                        <strong>{{ tax.title }}</strong>
                                    </td>

                                    <td class="cart-product-name">
                                        <span class="amount">{{ Number(tax.value).toLocaleString('hr-HR', currency_options) }}</span>
                                    </td>
                                </tr>
                                <tr class="cart_item">
                                    <td class="cart-product-name">
                                        <strong>Ukupno</strong>
                                    </td>

                                    <td class="cart-product-name">
                                        <span class="amount color lead"><strong>{{ Number($store.state.cart.total).toLocaleString('hr-HR', currency_options) }}</strong></span>
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
                show_delete_btn: true,
                currency_options: {
                    style: 'currency',
                    currency: 'HRK'
                },
                coupon: ''
            }
        },
        mounted() {
            if (window.innerWidth < 800/* && window.location.pathname == '/kosarica/naplata'*/) {
                this.mobile = true;
            }

            this.checkIfEmpty();
            this.setCoupon();

            if (window.location.pathname == '/kosarica/naplata') {
                this.show_delete_btn = false;
            }
        },

        methods: {
            updateCart(item) {
                this.$store.dispatch('updateCart', item);
            },

            removeFromCart(item) {
                this.$store.dispatch('removeFromCart', item);
            },

            CheckQuantity(qty) {
                if (qty < 1) {
                    return 1;
                }

                return qty;
            },
            checkIfEmpty() {
                let cart = this.$store.state.storage.getCart();

                if ( ! cart.count && window.location.pathname != '/kosarica') {
                    window.location.href = '/kosarica';
                }
            },

            setCoupon() {
                let cart = this.$store.state.storage.getCart();

                this.coupon = cart.coupon;
            },

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
</style>
