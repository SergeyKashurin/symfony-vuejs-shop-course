import axios from "axios";
import {StatusCodes} from "http-status-codes";
import {apiConfig} from "../../../../../utils/settings";

const state = () => ({
    cart: {},

    staticStore: {
      url: {
          apiCart: window.staticStore.urlCart,
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