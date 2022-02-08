import axios from "axios";
import {StatusCodes} from "http-status-codes";
import {apiConfig, apiConfigPatch} from "../../../../../utils/settings";
import {concatUrlByParams} from "../../../../../utils/url-generator";


const state = () => ({
    cart: {},

    staticStore: {
        url: {
            apiCart:            window.staticStore.urlCart,
            apiCartProduct:     window.staticStore.urlCartProduct,
            viewProduct:        window.staticStore.urlViewProduct,
            viewCart:           window.staticStore.urlViewCart,
            assetImageProducts: window.staticStore.urlAssetImageProducts,
        },
    },
});

const getters = {
    totalPrice(state) {
        let result = 0;
        console.log(state.cart);
        if(!state.cart.cartProducts) {
            return 0;
        }

        state.cart.cartProducts.forEach(
            cartProduct => {
                result += cartProduct.product.price * cartProduct.quantity
            }
        )

        return result;
    },
};


const actions = {
    async getCart({ state, commit }) {
        const url = state.staticStore.url.apiCart;

        const result = await axios.get(url, apiConfig);

        if(
            result.data
            && result.data["hydra:member"].length
            && result.status === StatusCodes.OK
        ) {
            commit('setCart', result.data["hydra:member"][0]);
        }
    },
    async cleanCart({ state, commit }) {
        const url = concatUrlByParams(
            state.staticStore.url.apiCart
            + '/'
            + state.cart.id
        );

        const result = await axios.delete(url, apiConfig);

        if(result.status === StatusCodes.NO_CONTENT) {
            commit('setCart', {});
        }
    },
    async removeCartProduct({ state, commit, dispatch }, cartProductId) {
        const url = concatUrlByParams(
            state.staticStore.url.apiCartProduct,
            cartProductId
        );

        const result = await axios.delete(url, apiConfig);

        if(result.status === StatusCodes.NO_CONTENT) {
            dispatch('getCart');
        }
    },
    async addCartProduct({state, dispatch}, productData) {
        const url = state.staticStore.url.apiCartProduct;
        const data = {
            cart: "/api/carts/" + state.cart.id,
            product: "/api/products/" + productData.uuid,
            quantity: 1,
        };
        const result = await axios.post(url, data, apiConfig);

        if(result.data && result.status === StatusCodes.CREATED) {
            dispatch('getCart');
        }
    },
};

const mutations = {
    setCart(state, cart) {
        state.cart = cart;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};