<template>
  <div class="colxl-5 col-lg-5 col-md-5 card my-2 mx-auto position-relative">
    <div class="row" v-if="product" @click="$emit('backdropEvent', product)">
      <div class="col-5 pt-3">
        <img :src="ruta+product.imagen" :alt="product.nombre" class="rounded custom-pizza d-block">
        <p class="pt-3 text-primary">{{ product.nombre }}</p>
      </div>
      <div class="col-7">
        <span class="text-warning pt-3 d-block">Ingredientes:</span>
        <ul>
          <li 
            v-for="item in product.ingrediente_pizzas"
            :key="item.id+'-ingredientes'"
          >
            {{ item.ingredientes.nombre }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/services/pizza.js'
import { ref } from '@vue/reactivity'
import store from "@/store";

export default {
  props: ['product'],
  setup() {
    return {
      ruta: store.state.imgUrl
    }
  },
}
</script>

<style lang="scss" scoped>
  /*----- Blog Section Css -----*/
  .card {
    border: solid 1px #000;
    cursor: pointer;

    .checkout {
      position: absolute;
      width: 1.5rem;
      top: 0;
      right: 0;
      margin-right: .4rem;
      margin-top: .4rem;

      .carrito {
        fill: #000;
        cursor: pointer;
      }
    }

    &:hover{
      background: #1c1c1c;

      li {
        color: #fff;
      }

      .carrito {
        fill: #fff;
      }
    }
  }
  .custom-pizza {
    height: 8rem;
  }
  
  /*----- Blog Section Css End -----*/
</style>