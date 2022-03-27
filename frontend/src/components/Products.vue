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
      <button class="btn btn-success me-2" @click="validar">Agregar</button>
      <button class="btn btn-danger" @click="hide()">Cancelar</button>
    </template>
  </modal>
</template>

<script>
import api from '@/services/pizza.js'
import { ref } from '@vue/reactivity'
import { mapState } from 'vuex'
import store from "@/store";
import Product from "@/components/Product";
import Modal from "@/utility/Modal";

export default {
  components: {
    Product,
    Modal,
  },
  computed: {
    ...mapState(['carrito']),
  },
  methods: {
    validar(){
      if (!this.cantidad || this.cantidad < 0) {
        this.mensaje('La cantidad es requerido')
        return
      }
      if (this.cantidad > this.disponible) {
        this.mensaje(`La cantidad debe ser menor o igual a ${this.disponible}`)
        return
      }
      this.addCar()
    },
    mensaje(message = '', type = 'error'){
      this.$toast.open({
        message,
        type,
        duration: 1500,
      });
    },
    addModal(pizza){
      let disponible;
      const filtro = this.carrito.filter( data => data.id == pizza.id)
      if (filtro.length > 0) {
        disponible = pizza.stock - filtro[0].cantidad
        if (disponible <= 0) {
          this.mensaje('Esta pizza no tiene unidades disponibles verfica en el carrito', 'warning')
          return
        }
      } else {
        disponible = pizza.stock
      }
      this.disponible = disponible
      this.cantidad = 0
      this.pizza = pizza
      this.condicionModal = true
    },
    async consultarApi(){
      const { data } = await api.read()
      this.items = data
    },
    hide(){
      this.condicionModal = false
    },
    addCar(){
      let cantidad = 0;
      let carrito = this.carrito.filter( data => data.id !== this.pizza.id )
      const filtro = this.carrito.filter( data => data.id === this.pizza.id )
      if (filtro.length > 0) {
        cantidad = filtro[0].cantidad
      }
      carrito.push({
        ...this.pizza,
        cantidad: this.cantidad + cantidad,
      })
      this.disponible = this.pizza.stock - (this.cantidad + cantidad)
      this.$store.commit('setCarrito', carrito)
      this.hide();
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
      disponible: 0,
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