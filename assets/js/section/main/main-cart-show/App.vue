<template>
  <div class="row">
    <div class="col-lg-12 order-block">
      <div class="order-content">
        <div v-if="showCartContent">
          <CartProductList/>
          <CartTotalPrice/>
          <a
            class="btn btn-success mb-3 text-white"
            @click="makeOrder"
          >
            MAKE ORDER
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import CartProductList from "./components/CartProductList";
  import CartTotalPrice from "./components/CartTotalPrice";
  import {mapState, mapActions, mapGetters, mapMutations} from "vuex";

  export default {
    name: "App",
    components: {CartTotalPrice, CartProductList},
    created() {
      this.getCart();
    },
    computed: {
      showCartContent() {
        return true;
      },
    },
    methods: {
      ...mapActions("cart", ["getCart"]),
      makeOrder() {
        return true;
      },
    },
  }
</script>

<style scoped>

</style>