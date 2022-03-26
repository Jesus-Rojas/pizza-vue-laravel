<template>
  <section class="blog bg-color ptb-100">
    <div class="container">
      <div class="section-headding text-center pb-5 pt-4">
        <h2 class="head-title wow fadeInUp">Pizzas</h2>
      </div>
      <div class="blog-slider wow fadeInUp">
        <div class="blog-slider-inner">
          <div class="row">
            <div 
              class="colxl-5 col-lg-5 col-md-5 card my-2 mx-auto" 
              v-for="value in items" 
              :key="value.id+'-pizza'"
            >
              <div class="row">
                <div class="col-5 pt-3">
                  <img :src="ruta+value.imagen" :alt="value.nombre" class="rounded custom-pizza d-block">
                  <p class="pt-3 text-primary">{{ value.nombre }}</p>
                </div>
                <div class="col-7">
                  <span class="text-warning pt-3 d-block">Ingredientes:</span>
                  <ul>
                    <li 
                      v-for="item in value.ingrediente_pizzas"
                      :key="item.id+'-ingredientes'"
                    >
                      {{ item.ingredientes.nombre }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import api from '@/services/pizza.js'
import { ref } from '@vue/reactivity'
import store from "@/store";

export default {
  setup() {
    const items = ref([])
    const consultarApi = async () => {
      const { data } = await api.read()
      items.value = data
    }
    consultarApi();
    return {
      items,
      ruta: store.state.imgUrl
    }
  },
}
</script>

<style lang="scss" scoped>
  /*----- Blog Section Css -----*/
  .card {
    border: solid 1px #000;
    
  }
  .custom-pizza {
    height: 8rem;
  }
  /*----- Blog Section Css End -----*/
</style>