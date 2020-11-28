/* */
let storage_cart = {
    name: 'sl_cart',
    cart: { count: 0 }
};
let messages = {
    error: 'Whoops!... Greška u vezi sa poslužiteljem!',
    cartAdd: 'Proizvod dodan u košaricu.',
    cartUpdate: 'Količina proizvoda je promjenjena',
    cartRemove: 'Proizvod maknut iz košarice.',
    couponSuccess: 'Kupon je uspješno dodan u košaricu.',
    couponError: 'Nažalost nema kupona pod tim kodom.',
}


class AgService {

    /**
     *
     * @returns {*}
     */
    getCart() {
        return axios.get('cart/get')
        .then(response => { return response.data })
        .catch(error => { return this.returnError(messages.error) })
    }

    /**
     *
     * @param item
     * @returns {*}
     */
    addToCart(item) {
        return axios.post('cart/add', {item: item})
        .then(response => {
            this.returnSuccess(messages.cartAdd);
            return response.data
        })
        .catch(error => { return this.returnError(messages.error) })
    }

    /**
     *
     * @param item
     * @returns {*}
     */
    updateCart(item) {
        return axios.post('cart/update/' + item.id, {item: item})
        .then(response => {
            this.returnSuccess(messages.cartUpdate);
            return response.data
        })
        .catch(error => { return this.returnError(messages.error) })
    }

    /**
     *
     * @param item
     * @returns {*}
     */
    removeItem(item) {
        return axios.get('cart/remove/' + item.id)
        .then(response => {
            this.returnSuccess(messages.cartRemove);
            return response.data
        })
        .catch(error => { return this.returnError(messages.error) })
    }

    /**
     *
     * @param coupon
     * @returns {*}
     */
    checkCoupon(coupon) {
        if ( ! coupon) {
            coupon = null;
        }
        return axios.get('cart/coupon/' + coupon)
        .then(response => {
            this.returnSuccess(messages.couponSuccess);
            return response.data
        })
        .catch(error => { return this.returnError(messages.error) })
    }

    /**
     *
     * @param msg
     * @returns {*}
     */
    returnError(msg) {
        window.ToastWarning.fire(msg);
    }

    /**
     *
     * @param msg
     * @returns {*}
     */
    returnSuccess(msg) {
        window.ToastSuccess.fire(msg);
    }

    /**
     * Returns HR formated price string.
     *
     * @param price
     * @returns {string}
     */
    formatPrice(price) {
        return Number(price).toLocaleString('hr-HR', {
            style: 'currency',
            currency: 'HRK'
        });
    }
}


class AgStorage {

    /**
     *
     * @returns {JSON}
     */
    getCart() {
        let item = localStorage.getItem(storage_cart.name);

        return (item && item != 'undefined') ? JSON.parse(item) : null;
    }

    /**
     *
     * @param value
     * @returns localStorage item
     */
    setCart(value) {
        return localStorage.setItem(storage_cart.name, JSON.stringify(value));
    }
}

/**/
let store = {
    state: {
        storage: new AgStorage(),
        service: new AgService(),
        cart: storage_cart.cart,
        messages: messages
    },

    actions: {
        /**
         *
         * @param context
         * @returns {*}
         */
        getCart(context) {
            context.commit('setCart');
        },

        /**
         *
         * @param context
         * @param item
         */
        addToCart(context, item) {
            let state = context.state;

            state.service.addToCart(item).then(cart => {
                state.storage.setCart(cart);
                state.cart = cart;
            });
        },

        /**
         *
         * @param context
         * @param item
         */
        updateCart(context, item) {
            let state = context.state;

            state.service.updateCart(item).then(cart => {
                state.storage.setCart(cart);
                state.cart = cart;
            });
        },

        /**
         *
         * @param context
         * @param item
         */
        removeFromCart(context, item) {
            let state = context.state;

            state.service.removeItem(item).then(cart => {
                state.storage.setCart(cart);
                state.cart = cart;
            });
        },

        /**
         *
         * @param context
         * @param coupon
         */
        checkCoupon(context, coupon) {
            let state = context.state;

            state.cart.coupon = coupon;
            state.storage.setCart(state.cart);

            state.service.checkCoupon(coupon).then(response => {
                if (response) {
                    state.service.returnSuccess(messages.couponSuccess);
                } else {
                    state.service.returnError(messages.couponError);
                }

                context.commit('setCart');
            });
        },

        /**
         *
         * @param context
         */
        flushCart(context) {
            context.state.cart = context.state.storage.setCart(storage_cart.cart);
        },
    },

    mutations: {

        /**
         *
         * @param state
         * @returns {*}
         */
        setCart(state) {
            return state.cart = state.service.getCart().then(cart => {
                state.cart = cart;

                return state.storage.setCart(cart);
            });
        }
    },
};

export default store;
