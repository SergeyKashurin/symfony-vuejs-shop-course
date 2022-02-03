<template>
  <div>
    vue app {{ testProperty }}
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {
    computed: {
      ...mapState("products", ["testProperty"]),
      productsCount: () => {
        return 123;
      }
    }
  }
</script>