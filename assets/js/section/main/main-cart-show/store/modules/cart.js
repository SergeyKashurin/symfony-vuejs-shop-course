import axios from "axios";
import {StatusCodes} from "http-status-codes";
import {apiConfig} from "../../../../../utils/settings";
import {concatUrlByParams} from "../../../../../utils/url-generator";

const state = () => ({
    cart: {},

    staticStore: {
      url: {
          apiCart:            window.staticStore.urlCart,
          apiCartProduct:     window.staticStore.urlCartProduct,
          viewProduct:        window.staticStore.urlViewProduct,
          assetImageProducts: window.staticStore.urlAssetImageProducts,
      },
    },
});

const getters = {

};


const actions = {
    async getCart({ state, commit }) {
      const url = state.staticStore.url.apiCart;

      const result = await axios.get(url, apiConfig);

      if(result.data && result.status === StatusCodes.OK) {
          commit('setCart', result.data["hydra:member"][0]);
      }
    },
    async removeCartProduct({ state, dispatch }, cartProductId) {
        const url = concatUrlByParams(
            state.staticStore.url.apiCartProduct,
            cartProductId
            );
        console.log(url);
        const result = await axios.delete(url, apiConfig);

        if(result.status === StatusCodes.NO_CONTENT) {
            dispatch('getCart');
        }
    },
};

const mutations = {
    setCart(state, cart) {
        state.cart = cart;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};