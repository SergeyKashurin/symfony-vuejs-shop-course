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
        },
    }
});

const getters = {

};

const actions = { //{ state, dispatch }
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

};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};