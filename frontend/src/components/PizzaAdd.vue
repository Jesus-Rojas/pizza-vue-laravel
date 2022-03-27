<template>
  <modal
    v-if="condicion"
  >
    <template v-slot:header>
      <h3>Nueva Pizza</h3>
    </template>
    <template v-slot:body>
      <div class="row pb-4">
        <div class="col-4">
          Nombre: 
        </div>
        <div class="col-8 text-start">
          <input type="text" class="w-75 " v-model="nombre">
        </div>
      </div>
      <div class="row pb-4">
        <div class="col-4">
          Imagen: 
        </div>
        <div class="col-8 text-start">
          <input type="file" accept="image/*" class="w-75 " @change="toggleImage">
        </div>
      </div>
      <div class="row">
        <div class="col-4">
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
      <button class="btn btn-success me-2" @click="agregar">Agregar</button>
      <button class="btn btn-danger" @click="hide">Cancelar</button>
    </template>
  </modal>
</template>

<script>
import Modal from '@/utility/Modal';
import api from '@/services/pizza';
import Multiselect from '@vueform/multiselect'
// import carrito from '@/assets/cart-shopping.svg';

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
    async agregar(){
      if (
        this.nombre.length > 0 && 
        this.ingredientes.length > 0 && 
        this.imagen && 
        this.imagen.value !== ''
      ) {
        let ingredientes = JSON.parse(JSON.stringify(this.ingredientes))
        ingredientes = ingredientes.map( data => data.id)
        const formData = new FormData()
        formData.append('nombre', 'John');
        formData.append('imagen', this.imagen.files[0]);
        formData.append('ingredientes', `${ingredientes}`);
        const { mensaje, status } = await api.add(formData)
        return
        const type = status == 'ok' ? 'success' : 'danger';
        this.mensaje(mensaje,type)
        this.hide(true)
        return
      }
      this.mensaje('Algunos campos son requeridos')
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
      ingredientes:[],
      options:[],
    }
  }
}
</script>

<style scoped lang='scss'>
</style>