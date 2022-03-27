<template>
  <NavClient />
  <div class="pb-custom"/>
  <h2>Checkout</h2>
  <!-- <Products class="pt-5" /> -->
</template>

<script>
// @ is an alias to /src
// import Products from "@/components/Products";
import NavClient from "@/components/NavClient";

export default {
  components: {
    // Products,
    NavClient,
  },
};
</script>

<style lang="scss" scoped>
  .pb-custom{
    height: 123px;
  }
</style>
