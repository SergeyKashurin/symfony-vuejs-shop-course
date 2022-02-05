import {concatUrlByParams} from "../../../../../utils/url-generator";
import axios from "axios";
import {StatusCodes} from "http-status-codes";
import {apiConfig} from "../../../../../utils/settings";

const state = () => ({
    categories: [],
    staticStore: {
        orderId: window.staticStore.orderId,
        orderProducts: window.staticStore.orderProducts,
        url: {
          viewProduct: window.staticStore.urlViewProduct,
          apiOrderProduct: window.staticStore.urlAPIOrderProduct,
          apiCategory: window.staticStore.urlAPICategory,
        },
    }
});

const getters = {

};

// TODO Понять из-за чего не работает передача параметра orderProductId если он перед { state, dispatch }
const actions = {
    async getCategories({ commit, state }) {
        const url = staticStore.urlAPICategory;

        const result = await axios.get(url, apiConfig);

        if (result.data && result.status === StatusCodes.OK) {
            commit("setCategories", result.data["hydra:member"]);
        }
    },

    //{ state, dispatch }
    async removeOrderProduct({ dispatch }, orderProductId) {
        //console.log(orderProductId);
        const url = concatUrlByParams(
            staticStore.urlAPIOrderProduct,
            orderProductId
        );
        const result = await axios.delete(url, apiConfig);
        console.log(result);
        if (result.status === StatusCodes.NO_CONTENT) {
            dispatch('getOrderProducts');
        }
    }
};

const mutations = {
    setCategories(state, categories) {
        state.categories = categories;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};