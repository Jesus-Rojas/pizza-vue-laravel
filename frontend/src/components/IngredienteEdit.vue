<template>
  <modal
    v-if="condicion"
  >
    <template v-slot:header>
      <h3>Editar Ingrediente</h3>
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
      <button class="btn btn-success me-2" @click="editar">Editar</button>
      <button class="btn btn-danger" @click="hide()">Cancelar</button>
    </template>
  </modal>
</template>

<script>
import Modal from '@/utility/Modal';
import api from '@/services/ingrediente';

export default {
  components: {
    Modal
  },
  props: ['condicion', 'ingrediente'],
  watch:{
    ingrediente(value){
      if (value.nombre) {
        this.nombre = value.nombre
      }
    }
  },
  methods: {
    async editar(){
      if (this.nombre.length > 0) {
        const datos = {
          nombre: this.nombre
        };
        const { mensaje, error } = await api.update(datos, this.ingrediente.id)
        if(error) {
          this.mensaje(error)
          return
        }
        this.mensaje(mensaje,'success')
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