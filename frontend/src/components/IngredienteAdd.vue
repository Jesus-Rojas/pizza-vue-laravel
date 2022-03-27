<template>
  <modal
    v-if="condicion"
  >
    <template v-slot:header>
      <h3>Nuevo Ingrediente</h3>
    </template>
    <template v-slot:body>
      <div class="row">
        <div class="col-4 align-self-center">
          Nombre: 
        </div>
        <div class="col-8 text-start">
          <input type="text" class="w-75 form-control" v-model="nombre">
        </div>
      </div>
    </template>
    <template v-slot:footer>
      <button class="btn btn-success me-2" @click="agregar">Agregar</button>
      <button class="btn btn-danger" @click="hide()">Cancelar</button>
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
  props: ['condicion'],
  methods: {
    async agregar(){
      if (this.nombre.length > 0) {
        const datos = {
          nombre: this.nombre
        };
        const { mensaje, status } = await api.add(datos)
        const type = status == 'ok' ? 'success' : 'danger';
        this.mensaje(mensaje,type)
        this.hide(true)
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
    hide(condicion = false){
      this.$emit('backdropEvent', condicion);
    },
  },
  data(){
    return {
      nombre: '',
    }
  }
}
</script>

<style scoped lang='scss'>
</style>