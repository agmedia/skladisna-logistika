/* */
let ttl = 1000 * 60 * 60 * 2; // milisec * sec * min * hours
let user_ttl = 1000 * 60 * 1; // milisec * sec * min
let storage_cart = {
    name: 'agrocon_cart',
    cart: {
        items: [],
        count: 0,
        subtotal: 0,
        total: 0
    }
};
let storage_user = {
    name: 'agrocon_user'
};
let messages = {
    error: 'Whoops!... Greška u vezi sa poslužiteljem!',
    cartAdd: 'Proizvod dodan u košaricu.',
    cartUpdate: 'Količina proizvoda je promjenjena',
    cartRemove: 'Proizvod maknut iz košarice.',
}


class AgService {
    /**
     *
     * @returns {*}
     */
    getUser() {
        return axios.get('user')
            .then(response => { return response.data })
            .catch(error => { return this.returnError(messages.error) })
    }

    /**
     *
     * @param item
     * @returns {*}
     */
    getProduct(item) {
        return axios.get('product/' + item.id)
            .then(response => { return response.data })
            .catch(error => { return this.returnError(messages.error) })
    }

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
    addCart(item) {
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
     * @param item
     * @returns {*}
     */
    syncCarts(items) {
        return axios.post('cart/sync', {items: items})
            .then(response => {
                //this.returnSuccess(messages.cartAdd);
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
}


class AgStorage {

    /**
     *
     * @param key {key ? user : cart}
     * @returns {JSON}
     */
    get(type = null) {
        let item = localStorage.getItem(type ? storage_user.name : storage_cart.name);

        return (item && item != 'undefined') ? JSON.parse(item) : item;
    }

    /**
     *
     * @param value
     * @param key {key ? user : cart}
     * @returns localStorage item
     */
    set(value, key = null) {
        return localStorage.setItem(
            key ? storage_user.name : storage_cart.name,
            JSON.stringify(value)
        )
    }

    /**
     *
     * @param key {key ? user : cart}
     * @returns {JSON}
     */
    has(type = null) {
        let item = this.get(type);

        return (item && item != 'undefined') ? true : false;
    }

    /**
     * @returns {boolean}
     */
    isEmpty(type = null) {
        let session = this.get(type)

        if (Object.keys(session.items).length && (new Date()).getTime() < session.expire) {
            return false
        }

        return true
    }

    isUserExpired() {
        let session = this.get(true)

        if (session.expire && (new Date()).getTime() < session.expire) {
            return false
        }

        return true
    }

    setUserExpirationTime() {
        return (new Date()).getTime() + user_ttl;
    }
}

/**/
let store = {
    state: {
        user: storage_user,
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
        getUser(context) {
            let state = context.state;

            if (!state.storage.has(true)) {
                return context.commit('setUser');
            } else {
                if (!state.storage.get(true).logged) {
                    return context.commit('setUser');
                }
                if (state.storage.isUserExpired()) {
                    return context.commit('setUser');
                }
            }

            return state.user;
        },

        /**
         *
         * @param context
         * @returns {*}
         */
        getCart(context) {
            let state = context.state;

            if (!state.storage.has()) {
                return state.storage.set(state.cart);
            }

            if (state.storage.has() && !state.storage.get(true).logged) {
                return state.cart = state.storage.get();
            } else {
                if (state.storage.get(true).logged) {
                    context.commit('setCart');
                }
            }

            return state.storage.set(state.cart);
        },

        /**
         *
         * @param context
         * @param item
         */
        addCart(context, item) {
            let state = context.state;

            if (state.storage.get(true).logged) {
                state.service.addCart(item).then(cart => {
                    state.storage.set(cart);
                    state.cart = cart;
                });
            } else {
                let found = state.cart.items.find(cart_product => cart_product.id == item.id);

                if (found) {
                    context.commit('updateToCart', item);
                } else {
                    context.commit('addToCart', item);
                }
            }
        },

        /**
         *
         * @param context
         * @param item
         */
        updateCart(context, item) {
            let state = context.state;

            if (state.storage.get(true).logged) {
                state.service.updateCart(item).then(cart => {
                    state.storage.set(cart);
                    state.cart = cart;
                });
            } else {
                context.commit('addToCart', item);
            }
        },

        /**
         *
         * @param context
         * @param item
         */
        removeItem(context, item) {
            let state = context.state;

            if (state.storage.get(true).logged) {
                state.service.removeItem(item).then(cart => {
                    state.storage.set(cart);
                    state.cart = cart;
                });
            } else {
                context.commit('removeFromCart', item);
            }
        },

        /**
         *
         * @param context
         */
        flushCart(context) {
            context.state.cart = context.state.storage.set(storage_cart.cart);
        },
    },

    mutations: {

        /**
         *
         * @param state
         * @returns {*}
         */
        setUser(state) {
            let expire = state.storage.setUserExpirationTime();

            return state.user = state.service.getUser().then(user => {
                user.id ? user.logged = true : user.logged = false;
                user.expire = expire;
                state.storage.set(user, true);
            });
        },

        /**
         *
         * @param state
         * @returns {*}
         */
        setCart(state) {
            return state.cart = state.service.getCart().then(cart => {
                if (!state.cart.count) {
                    state.cart = cart;
                    return state.storage.set(cart);
                }

                return state.service.syncCarts(state.cart.items).then(synced => {
                    state.cart = synced;
                    return state.storage.set(synced);
                });
            });
        },

        /**
         * Add item to cart
         * and persist state in localStorage.
         *
         * @param state
         * @param item
         */
        addToCart(state, item) {
            let cart = state.cart;
            state.service.getProduct(item).then(product => {
                let found = cart.items.find(cart_product => cart_product.id == product.id);

                if (found) {
                    window.ToastSuccess.fire(state.messages.cartUpdate);
                    found.quantity = item.quantity;
                } else {
                    window.ToastSuccess.fire(state.messages.cartAdd);
                    product.quantity = item.quantity;
                    cart.items.push(product);
                }

                this.commit('recalculate');
            });
        },

        /**
         * Add item to cart
         * and persist state in localStorage.
         *
         * @param state
         * @param item
         */
        updateToCart(state, item) {
            let cart = state.cart;

            console.log(cart.items)

            let found = cart.items.find(cart_product => cart_product.id == item.id);

            console.log(item.quantity)
            console.log(found.quantity)

            if (found) {
                window.ToastSuccess.fire(state.messages.cartUpdate);
                found.quantity = Number(found.quantity) + Number(item.quantity);
            }

            this.commit('recalculate');
        },

        /**
         * Remove item from cart.
         *
         * @param state
         * @param item
         */
        removeFromCart(state, item) {
            let index = state.cart.items.indexOf(item);

            if (index > -1) {
                state.cart.items.splice(index, 1);
            }

            window.ToastSuccess.fire(state.messages.cartRemove);
            this.commit('recalculate');
        },

        /**
         * Commit recalculations methods.
         *
         * @param state
         */
        recalculate(state) {
            let qty = 0;
            let sum = 0;

            for (let product of state.cart.items) {
                qty += Number(product.quantity);
                sum += Number(product.price * product.quantity);
            }

            state.cart.count = qty ? qty : 0;
            state.cart.subtotal = sum ? sum : 0;

            state.storage.set(state.cart);
        },
    },
};

export default store;
