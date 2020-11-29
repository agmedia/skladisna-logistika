<template>
    <div class="OrderProducts">
        <label>Upiše Proizvod za Dodati</label>
        <input type="text" v-model="query" @keyup="autoComplete" class="form-control">
        <div class="panel-footer" v-if="results.length">
            <ul class="list-group agm">
                <li class="list-group-item" v-for="result in results" @click="select(result)">
                    {{ result.name }}
                </li>
            </ul>
        </div>

        <div class="block black mt-50" v-if="items.length">
            <!--<div class="block-header block-header-default">
                Proizvodi
            </div>-->
            <div class="block-content-full">
                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr class="bg-light">
                        <th class="text-center px-0" style="width: 3%;"></th>
                        <th class="text-center" style="width: 5%;">#</th>
                        <th>Ime</th>
                        <th class="text-center" style="width: 7%;">Kol.</th>
                        <th class="text-center" style="width: 12%;">Jed.Cijena</th>
                        <th class="text-center" style="width: 12%;">Iznos</th>
                        <th class="text-center" style="width: 12%;">Rabat</th>
                        <th class="text-center" style="width: 12%;">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(product, index) in items">
                        <td class="text-center px-0"><i class="si si-trash text-danger float-right" style="margin-top: 2px; cursor: pointer;" @click="removeRow(index)"></i></td>
                        <td class="text-center">{{ index + 1 }}</td>
                        <td>{{ product.name }}</td>
                        <td class="text-center">
                            <div class="form-material" style="padding-top: 0;">
                                <input type="text" class="form-control py-0" style="height: 26px;" :value="product.quantity" @keyup="ChangeQty(product.id, $event)" @blur="Recalculate()">
                            </div>
                        </td>
                        <td class="text-right">{{ Number(product.org_price).toLocaleString('hr-HR', currency_style) }}</td>
                        <td class="text-right">{{ Number(product.org_price * product.quantity).toLocaleString('hr-HR', currency_style) }}</td>
                        <td class="text-right">-{{ Number((product.org_price - product.price) * product.quantity).toLocaleString('hr-HR', currency_style) }}</td>
                        <td class="text-right font-w600">{{ Number(product.total).toLocaleString('hr-HR', currency_style) }}</td>
                    </tr>

                    <!-- Totals -->
                    <tr v-if="totals.length" v-for="(total, index) in sums">
                        <td colspan="6" class="text-right">{{ total.name }}:</td>
                        <td colspan="2" class="text-right font-w600">{{ Number(total.value).toLocaleString('hr-HR', currency_style) }} kn</td>
                    </tr>

                    <input type="hidden" :value="JSON.stringify(items)" name="items">
                    <input type="hidden" :value="JSON.stringify(sums)" name="sums">

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        products: {
            type: Object,
            required: false,
            default: []
        },
        totals: {
            type: Object,
            required: false,
            default: []
        },
        products_autocomplete_url: {
            type: String,
            required: true
        }
    },
    //
    data() {
        return {
            query: '',
            results: [],
            items: [],
            sums: [],
            selected_product: {},
            is_shipping: true,
            shipping_value: 30,
            is_action: false,
            action_value: 0,
            currency_style: {
                style: 'currency',
                currency: 'HRK'
            }
        }
    },
    //
    mounted() {
        if (this.products.length && this.totals.length) {
            this.products = JSON.parse(this.products)
            this.totals = JSON.parse(this.totals)
            this.Sort()
        }

        console.log(this.products)
        console.log(this.totals)
    },
    //
    methods: {
        //
        Sort() {
            this.products.forEach((item) => {
                this.items.push({
                    id: item.product_id,
                    name: item.name,
                    quantity: item.quantity,
                    price: item.price,
                    org_price: item.org_price,
                    total: item.total
                })
            })

            this.Recalculate()
        },
        //
        select(selected) {
            this.results = [];
            this.query = '';
            let price = selected.price;

            if (selected.actions) {
                if (selected.actions.price) {
                    price = selected.actions.price;
                }
                if (selected.actions.discount) {
                    price = selected.price - (selected.price * (selected.actions.discount / 100));
                }
            }

            this.items.push({
                id: selected.id,
                name: selected.name,
                quantity: 1,
                price: price,
                org_price: selected.price,
                total: price
            })

            this.Recalculate();
        },
        //
        removeRow(row, product) {
            this.items.splice(row, 1);

            if (!this.items.length) {
                this.sums = [];
            }

            this.Recalculate();
        },
        //
        ChangeQty(id, event) {
            for (let i = 0; i < this.items.length; i++) {
                if (this.items[i].id == id) {
                    this.items[i].quantity = Number(event.target.value);
                    this.items[i].total = this.items[i].price * Number(event.target.value);
                }
            }
            this.Recalculate();
        },
        //
        Recalculate() {
            this.sums = [];
            let total = 0;

            this.items.forEach((item) => {
                total = total + Number(item.total);
            });

            let nett = total / 1.25;

            this.sums.push(
                {
                    name: 'Ukupno',
                    value: total,
                    code: 'subtotal'
                },
                {
                    name: 'Iznos bez PDV-a',
                    value: nett,
                    code: 'nett'
                },
                {
                    name: 'PDV (25%)',
                    value: nett * 0.25,
                    code: 'tax'
                },
                {
                    name: 'Sveukupno',
                    value: total,
                    code: 'total'
                }
            );
        },
        //
        autoComplete() {
            this.results = []

            if (this.query.length > 1) {
                axios.get(this.products_autocomplete_url, {params: {query: this.query}}).then(response => {
                    this.results = response.data;
                })
            }
        }
    }
};
</script>

<style>
.panel-footer {
    width: 100%;
    position: absolute;
    z-index: 999;
    padding-right: 30px;
}

ul li agm {
    cursor: pointer;
}

ul li:hover agm {
    background-color: #eeeeee;
}
</style>
