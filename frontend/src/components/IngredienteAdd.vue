<template>
  <div class="py-2 ps-4 mb-4">
    <button 
      type="button" 
      class="btn btn-warning"
      @click="show = true"
    >
      Nuevo Ingrediente
    </button>
  </div>
  <modal
    v-if="show"
  >
    <template v-slot:header>
      <h1>Nuevo Ingrediente</h1>
    </template>
    <template v-slot:body>
      <label class="me-4">Nombre: </label>
      <input type="text" class="w-50 " v-model="nombre">
    </template>
    <template v-slot:footer>
      <button class="btn btn-success me-2" @click="agregar">Agregar</button>
      <button class="btn btn-danger" @click="hide">Cancelar</button>
    </template>
  </modal>
</template>

<script>
import { ref } from '@vue/reactivity'
import Modal from '@/utility/Modal';
// import carrito from '@/assets/cart-shopping.svg';

export default {
  components: {
    Modal
  },
  methods: {
    async agregar(){
      console.log(this)
      if (this.nombre.length > 0) {
        
        // fetch(``)
        this.mensaje('Creacion de registro con exito','success')
      } else {
        this.mensaje('El campo nombre es requerido')
      }
    },
    mensaje(message = '', type = 'error'){
      this.$toast.open({
        message,
        type,
        duration: 1500,
      });
    },
    hide(){
      this.show = false;
    },
  },
  data(){
    return {
      show: true,
      nombre: '',
    }
  }
}
</script>

<style scoped lang='scss'>
</style>