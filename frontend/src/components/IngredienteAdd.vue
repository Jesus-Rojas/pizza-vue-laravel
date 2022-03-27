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
import Modal from '@/utility/Modal';
import api from '@/services/ingrediente';
// import carrito from '@/assets/cart-shopping.svg';

export default {
  components: {
    Modal
  },
  methods: {
    async agregar(){
      if (this.nombre.length > 0) {
        const datos = {
          nombre: this.nombre
        };
        const { mensaje, status } = await api.add(datos)
        const type = status == 'ok' ? 'success' : 'danger';
        this.mensaje(mensaje,type)
        this.hide()
        return
      }
      this.mensaje('El campo nombre es requerido')
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
      show: false,
      nombre: '',
    }
  }
}
</script>

<style scoped lang='scss'>
</style>