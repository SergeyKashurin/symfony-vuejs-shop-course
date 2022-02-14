<template>
  <table class="table table-cart table-mobile table-cart-show">
    <thead>
      <tr>
        <td>Product</td>
        <td>Price</td>
        <td>Quantity</td>
        <td>Total</td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      <CartProductItem
        v-for="cartProduct in cart.cartProducts"
        :key="cartProduct.id"
        :cart-product="cartProduct"
      />
    </tbody>
  </table>
</template>

<script>
import CartProductItem from "./CartProductItem";
import { mapState, mapActions, mapGetters, mapMutations } from "vuex";

export default {
  name: "CartProductList",
  components: { CartProductItem },
  computed: {
    ...mapState("cart", ["cart"]),
  },
};
</script>

<style scoped></style>
