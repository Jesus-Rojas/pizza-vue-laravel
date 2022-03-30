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
            @click="validarCheckout"
          >Pagar</button>
        </div>
      </template>
    </div>
  </section>
  <modal
    v-if="condicionModal"
    :classCustom="titulo == 'Login' ? 'size-modal-login' : 'size-modal-register'"
    :showHeader="false"
  >
    <template v-slot:body>
      <h3 class="text-center py-2">{{ titulo }}</h3>
      <form :action="($event) => $event.preventDefault()">
        <div class="row pb-2" v-if="titulo != 'Login'">
          <div class="col-4 align-self-center">
            Nombre: 
          </div>
          <div class="col-8 text-start">
            <input type="text" class="w-75 form-control" v-model="name">
          </div>
        </div>
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
            <input type="password" autocomplete="new-pass" class="w-75 form-control" v-model="password">
          </div>
        </div>
        <div class="py-2 text-center text-info">
          <span 
            class="cursor-pointer" 
            @click="titulo = titulo == 'Login' ? 'Registrarse' : 'Login'"
          >
            {{ titulo == 'Login' ? 'Registrarse' : 'Login' }} ?
          </span>
        </div>
      </form>
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
import apiU from '@/services/user.js'
import apiP from '@/services/pedido.js'
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
    async pagar(){
      let carrito = this.carrito.map( ({ cantidad, precio, id }) => {
        return {
          cantidad, 
          precio_unitario: precio, // se puede hacer en backend para restringir el precio, tengo dudas en caso de un descuento por eso lo dejo desde frontend
          pizzas_id: id,
        }
      })
      const datos = {
        venta_total: this.totalCarrito,
        pedido: carrito,
      };
      const { error, mensaje, status, pizza } = await apiP.add(datos)
      if (error) {
        this.mensaje(error)
        return
      }
      if ('success' == status) {
        this.$store.commit('setCarrito', [])
        this.$router.push({ name: 'home'});
        this.mensaje(mensaje, 'success')
        return
      }
      if ('verificar' == status) {
        carrito = this.carrito.filter(data => data.id !== pizza.id)
        if (pizza.cantidad > 0) {
          const pizzaOld = this.carrito.filter(data => data.id === pizza.id)[0]
          this.$store.commit('setCarrito', [
            ...carrito,
            {
              ...pizzaOld,
              cantidad: pizza.cantidad,
              stock: pizza.stock,
            }
          ])
        } else {
          this.$store.commit('setCarrito', carrito)
          if (carrito.length == 0) {
            this.$router.push({ name: 'home'});
          }
        }
        this.mensaje(mensaje, 'warning')
      }
    },
    validarCheckout(){
      const { exist } = utility.getToken();
      if (exist) {
        this.pagar()
        return
      }
      utility.removeToken();
      this.condicionModal = true
    },
    mensaje(message = '', type = 'error'){
      this.$toast.open({
        message,
        type,
        duration: 1500,
      });
    },
    async login(){
      const condicion = this.validar()
      if (condicion) {
        const datos = {
          email: this.email,
          password: this.password,
        }
        const { error } = await apiU.login(datos);
        if (error) {
          this.mensaje(error)
          return
        }
        this.mensaje('Iniciando Sesion ...', 'success')
        this.condicionModal = false;
        this.pagar()
      }
    },
    validar(condicion = false){
      if (condicion) {
        if (!this.name) {
          this.mensaje('El nombre es requerido')
          return false
        }
      }
      if (!this.email) {
        this.mensaje('El correo es requerido')
        return false
      }
      if (!this.validarEmail.test(this.email)) {
        this.mensaje('El correo no es valido')
        return false
      }
      if (!this.password) {
        this.mensaje('La contraseña es requerida')
        return false
      }
      return true
    },
    async register(){
      const condicion = this.validar(true)
      if (condicion) {
        const datos = {
          email: this.email,
          password: this.password,
          name: this.name,
        }
        const { error } = await apiU.register(datos);
        if (error) {
          this.mensaje(error)
          return
        }
        this.mensaje('Se registro usuario con exito', 'success')
        this.condicionModal = false;
        this.pagar()
      }
    },
    hide(){
      this.condicionModal = false
    },
  },
  data() {
    const fields = ['Nombre', 'Imagen', 'Precio', 'Cantidad', 'Total'];
    const validarEmail = /^[\w\._]{5,30}\+?[\w]{0,10}@[\w\.\-]{3,}\.\w{2,5}$/i;
    return {
      fields,
      name: '',
      email: '',
      password: '',
      condicionModal: false,
      titulo: 'Login',
      validarEmail
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