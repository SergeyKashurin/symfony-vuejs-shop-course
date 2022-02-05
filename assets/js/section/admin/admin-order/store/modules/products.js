import {concatUrlByParams, getUrlProductsByCategory} from "../../../../../utils/url-generator";
import axios from "axios";
import {StatusCodes} from "http-status-codes";
import {apiConfig} from "../../../../../utils/settings";

const state = () => ({
    categories: [],
    categoryProducts: [],
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

        if (result.data && result.status === StatusCodes.OK) {
            commit("setCategoryProducts", result.data["hydra:member"]);
        }
    },

    async getCategories({ commit, state }) {
        const url = staticStore.urlAPICategory;

        const result = await axios.get(url, apiConfig);

        if (result.data && result.status === StatusCodes.OK) {
            commit("setCategories", result.data["hydra:member"]);
        }
    },

    async addNewProductOrder({ state, dispatch }) {
        const url = state.staticStore.url.apiOrderProduct;
        const data = {
            pricePerOne: state.newOrderProduct.pricePerOne,
            quantity:    parseInt(state.newOrderProduct.quantity),
            product:     "/api/products/" + state.newOrderProduct.productId,
            appOrder:    "/api/orders/" + state.staticStore.orderId,
        };

        const result = await axios.post(url, data, apiConfig);

        if (result.data && result.status === StatusCodes.CREATED) {
            console.log('Ok');
        }
    },

    async removeOrderProduct({ dispatch }, orderProductId) {
        const url = concatUrlByParams(
            staticStore.urlAPIOrderProduct,
            orderProductId
        );
        const result = await axios.delete(url, apiConfig);
        if (result.status === StatusCodes.NO_CONTENT) {
            dispatch('getOrderProducts');
        }
    }
};

const mutations = {
    setCategories(state, categories) {
        state.categories = categories;
    },
    setCategoryProducts(state, categoryProducts) {
        state.categoryProducts = categoryProducts;
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