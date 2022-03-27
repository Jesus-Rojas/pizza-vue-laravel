<template>
  <section class="blog bg-color ptb-100">
    <div class="container">
      <div class="section-headding text-center pb-5 pt-4">
        <h2 class="head-title wow fadeInUp">Carrito</h2>
      </div>
      <template v-if="carrito.length > 0">
        <div class="mx-2">
          <table class="table table-primary">
            <thead>
              <tr>
                <th
                  v-for="(value, index) of fields" 
                  :key="'thead-'+index"
                  class="text-center"
                >
                  {{value}}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="(value) of carrito" 
                :key="'tbody-'+value.id"
              >
                <td class="text-center">{{ value.nombre }}</td>
                <td class="text-center">
                  <img :src="imgUrl+value.imagen" :alt="value.nombre" class="rounded-3">
                </td>
                <td class="text-center">{{ formatearPrecio(value.precio) }}</td>
                <td class="text-center">
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="decrement(value)"
                  >
                    -
                  </button>
                  <button
                    type="button"
                    class="btn btn-dark mx-1"
                  >
                    {{ value.cantidad }}
                  </button>
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="increment(value)"
                  >
                    +
                  </button>
                </td>
                <td class="text-center">{{ formatearPrecio(value.precio * value.cantidad) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="text-end py-3">
          <span class="me-3">
            Valor Total: 
            <b class="ms-2">{{ formatearPrecio(totalCarrito) }}</b>
          </span>
          <button 
            class="btn btn-warning rounded mx-4"
            @click="pagar"
          >Pagar</button>
        </div>
      </template>
    </div>
  </section>
  <modal
    v-if="condicionModal"
    classCustom='size-modal-login'
    :showHeader="false"
  >
    <template v-slot:body>
      <h3 class="text-center py-2">{{ titulo }}</h3>
      <div class="row pb-2">
        <div class="col-4 align-self-center">
          Correo: 
        </div>
        <div class="col-8 text-start">
          <input type="email" class="w-75 form-control" v-model="email">
        </div>
      </div>
      <div class="row pb-2">
        <div class="col-4 align-self-center">
          Contraseña: 
        </div>
        <div class="col-8 text-start">
          <input type="password" class="w-75 form-control" v-model="password">
        </div>
      </div>
      <span class="text-center text-info d-block py-2 cursor-pointer">
        {{ titulo == 'Login' ? 'Registrarse' : 'Loguearse' }} ?
      </span>
    </template>
    <template v-slot:footer>
      <button 
        v-if="titulo == 'Login'"
        class="btn btn-success me-2"
        @click="login"
      >
        Iniciar Sesion
      </button>
      <button 
        v-else
        class="btn btn-success me-2"
        @click="register"
      >
        Registrarse
      </button>
      <button class="btn btn-danger" @click="hide">Salir</button>
    </template>
  </modal>
</template>

<script>
import api from '@/services/pizza.js'
import { mapState } from 'vuex'
import Product from "@/components/Product";
import Modal from "@/utility/Modal";
import utility from "@/utility";

export default {
  components: {
    Product,
    Modal,
  },
  computed: {
    ...mapState(['carrito','imgUrl']),
    totalCarrito(){
      let total = 0
      for (const iterator of this.carrito) {
        total += (iterator.cantidad * iterator.precio)
      }
      return total
    }
  },
  methods: {
    decrement(value){
      const filtro = this.carrito.filter(data => data.id !== value.id);
      if (value.cantidad == 1) {
        this.$store.commit('setCarrito', filtro);
      } else {
        const carrito = [
          ...filtro, 
          {
            ...value,
            cantidad: value.cantidad -1
          }
        ]
        this.$store.commit('setCarrito', carrito);
      }
    },
    increment(value){
      if (value.cantidad == value.stock) {
        return
      }
      const filtro = this.carrito.filter(data => data.id !== value.id);
      const carrito = [
        ...filtro, 
        {
          ...value,
          cantidad: value.cantidad + 1
        }
      ]
      this.$store.commit('setCarrito', carrito);
    },
    formatearPrecio(value){
      return utility.formatearPrecio(value)
    },
    pagar(){
      const token = localStorage.getItem('access_token')
      if (token) {
        // pagarApi
      } else {
        // autenticacion
        this.condicionModal = true
      }
    },
    mensaje(message = '', type = 'error'){
      this.$toast.open({
        message,
        type,
        duration: 1500,
      });
    },
    login(){
      //
    },
    register(){
      //
    },
    hide(){
      this.condicionModal = false
    },
  },
  data() {
    const fields = ['Nombre', 'Imagen', 'Precio', 'Cantidad', 'Total'];
    return {
      fields,
      email: '',
      password: '',
      condicionModal: false,
      titulo: 'Login',
    }
  },
}
</script>

<style lang="scss" scoped>
.table {
  td {
    vertical-align: middle;
  }

  img {
    width: 5rem;
    height: 5rem;
  }
}
</style>