import {concatUrlByParams, getUrlProductsByCategory} from "../../../../../utils/url-generator";
import axios from "axios";
import {StatusCodes} from "http-status-codes";
import {apiConfig} from "../../../../../utils/settings";

const state = () => ({
    categories: [],
    newOrderProduct: {
        categoryId: "",
        productId: "",
        quantity: "",
        pricePerOne: ""
    },
    staticStore: {
        orderId: window.staticStore.orderId,
        orderProducts: window.staticStore.orderProducts,
        url: {
          viewProduct: window.staticStore.urlViewProduct,
          apiOrderProduct: window.staticStore.urlAPIOrderProduct,
          apiCategory: window.staticStore.urlAPICategory,
          apiProduct: window.staticStore.urlAPIProduct,
        },
    },
    viewProductCountLimit: 25,
});

const getters = {

};

// TODO Понять из-за чего не работает передача параметра orderProductId если он перед { state, dispatch }
const actions = {
    async getProductsByCategory({commit, state}) {
        const url = getUrlProductsByCategory(
            state.staticStore.url.apiProduct,
            state.newOrderProduct.categoryId,
            1,
            state.viewProductCountLimit
        );

        const result = await axios.get(url, apiConfig);
        console.log(url, result);
    },
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
    },
    setNewProductInfo(state, formData) {
        state.newOrderProduct.categoryId = formData.categoryId;
        state.newOrderProduct.productId = formData.productId;
        state.newOrderProduct.quantity = formData.quantity;
        state.newOrderProduct.pricePerOne = formData.pricePerOne;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};