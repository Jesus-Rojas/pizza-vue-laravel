<template>
  <modal
    v-if="condicion"
    classCustom="size-modal-pizza"
  >
    <template v-slot:header>
      <h3>Nueva Pizza</h3>
    </template>
    <template v-slot:body>
      <div class="row pb-4">
        <div class="col-4 align-self-center">
          Nombre: 
        </div>
        <div class="col-8 text-start">
          <input type="text" class="w-75 form-control" v-model="nombre">
        </div>
      </div>
      <div class="row pb-4">
        <div class="col-4 align-self-center">
          Precio: 
        </div>
        <div class="col-8 text-start">
          <input type="number" class="w-75 form-control" v-model="precio">
        </div>
      </div>
      <div class="row pb-4">
        <div class="col-4 align-self-center">
          Stock: 
        </div>
        <div class="col-8 text-start">
          <input type="number" class="w-75 form-control" v-model="stock">
        </div>
      </div>
      <div class="row pb-4">
        <div class="col-4 align-self-center">
          Imagen: 
        </div>
        <div class="col-8 text-start">
          <input type="file" accept="image/*" class="w-75 form-control" @change="toggleImage">
        </div>
      </div>
      <div class="row">
        <div class="col-4 align-self-center">
          Ingredientes: 
        </div>
        <div class="col-8">
          <Multiselect
            v-model="ingredientes"
            mode="tags"
            class="w-75 mx-0"
            :options="options"
          />
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
import Modal from '@/utility/Modal';
import api from '@/services/pizza';
import Multiselect from '@vueform/multiselect'

export default {
  components: {
    Modal,
    Multiselect,
  },
  props: ['condicion','ingredientesOptions'],
  watch: {
    ingredientesOptions(value){
      this.options = value;
    }
  },
  methods: {
    validar(){
      if (!this.nombre) {
        this.mensaje('El nombre es requerido')
        return
      }
      if (!this.precio || this.precio < 0) {
        this.mensaje('El precio es requerido')
        return
      }
      if (!this.stock || this.stock < 0) {
        this.mensaje('El stock es requerido')
        return
      }
      if (!this.imagen || this.imagen.value == '') {
        this.mensaje('La imagen es requerida')
        return
      }
      if (this.ingredientes.length == 0) {
        this.mensaje('El campo ingredientes es requerido')
        return
      }
      this.agregar()
    },
    async agregar(){
      let ingredientes = JSON.parse(JSON.stringify(this.ingredientes))
      ingredientes = ingredientes.map( data => data.id)
      const formData = new FormData()
      formData.append('nombre', this.nombre);
      formData.append('stock', this.stock);
      formData.append('precio', this.precio);
      formData.append('imagen', this.imagen.files[0]);
      formData.append('ingredientes', JSON.stringify(ingredientes));
      const { mensaje, error } = await api.add(formData)
      if (error) {
        this.mensaje(error)
        return
      }
      this.mensaje(mensaje,'success')
      this.hide(true)
    },
    toggleImage({target}){
      this.imagen = {
        value: target.value,
        files: target.files,
      }
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
      imagen: null,
      precio: null,
      stock: null,
      ingredientes:[],
      options:[],
    }
  }
}
</script>

<style scoped lang='scss'>
</style>