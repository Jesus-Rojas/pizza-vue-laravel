<template>
  <section class="blog bg-color ptb-100">
    <div class="container">
      <div class="section-headding text-center pb-5 pt-4">
        <h2 class="head-title wow fadeInUp">Pizzas</h2>
      </div>
      <div class="blog-slider wow fadeInUp">
        <div class="blog-slider-inner">
          <div class="row">
            <Product 
              v-for="value in items" 
              :key="value.id+'-pizza'"
              :product="value"
              @backdropEvent="addModal"
            />
          </div>
        </div>
      </div>
    </div>
  </section>
  <modal
    v-if="condicionModal"
    classCustom="size-modal-addCar"
    :showHeader="false"
  >
    <template v-slot:body>
      <h3 class="text-center py-2">{{ pizza.nombre }}</h3>
      <div class="row py-2">
        <img :src="ruta+pizza.imagen" :alt="pizza.nombre" class="rounded w-auto custom-pizza mx-auto d-block">
      </div>
      <div class="row py-2">
        <div class="col-4">
          Disponible: 
        </div>
        <div class="col-8 text-start">
          {{ disponible }}
        </div>
      </div>
      <div class="row py-2">
        <div class="col-4">
          Descripcion: 
        </div>
        <div class="col-8 text-start">
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius ad corporis voluptas ab minima quas hic! Eligendi corporis libero vero ab, illum voluptate repellendus modi voluptas. Voluptatem nostrum fugiat ullam.
          </p>
        </div>
      </div>
      <div class="row pb-4">
        <div class="col-4 align-self-center">
          Cantidad: 
        </div>
        <div class="col-8 text-start">
          <input type="number" class="w-75 form-control" v-model="cantidad">
        </div>
      </div>
    </template>
    <template v-slot:footer>
      <button class="btn btn-success me-2" @click="addCar">Agregar</button>
      <button class="btn btn-danger" @click="hide()">Cancelar</button>
    </template>
  </modal>
</template>

<script>
import api from '@/services/pizza.js'
import { ref } from '@vue/reactivity'
import store from "@/store";
import Product from "@/components/Product";
import Modal from "@/utility/Modal";

export default {
  components: {
    Product,
    Modal,
  },
  methods: {
    addModal(pizza){
      this.pizza = pizza
      this.disponible = 0
      this.cantidad = 0
      this.condicionModal = true
      
      console.log(pizza)
    },
    async consultarApi(){
      const { data } = await api.read()
      this.items = data
    },
    hide(){
      this.condicionModal = false
    },
    addCar(){
      //
    }
  },
  mounted(){
    this.consultarApi();
  },
  data() {
    return {
      items: [],
      pizza: null,
      cantidad: 0,
      condicionModal: false,
      ruta: this.$store.state.imgUrl
    }
  },
}
</script>

<style lang="scss" scoped>
.custom-pizza{
  height: 8rem;
}
</style>