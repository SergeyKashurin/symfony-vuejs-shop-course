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

}

const actions = {
    removeOrderProduct({ state, dispatch }, orderProductId) {
        const url = state.staticStore.url.apiOrderProduct + '/' + orderProductId;
        console.log(url);
    }
}

const mutations = {

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}