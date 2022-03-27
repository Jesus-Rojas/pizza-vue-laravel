<template>
  <modal
    v-if="condicion"
    classCustom="size-modal-pizza"
  >
    <template v-slot:header>
      <h3>Editar Pizza</h3>
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
          Precio: 
        </div>
        <div class="col-8 text-start">
          <input type="number" class="w-75 " v-model="precio">
        </div>
      </div>
      <div class="row pb-4">
        <div class="col-4">
          Stock: 
        </div>
        <div class="col-8 text-start">
          <input type="number" class="w-75 " v-model="stock">
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
            ref="multi"
          />
        </div>
      </div>
    </template>
    <template v-slot:footer>
      <button class="btn btn-success me-2" @click="validar">Editar</button>
      <button class="btn btn-danger" @click="hide()">Cancelar</button>
    </template>
  </modal>
</template>

<script>
import Modal from '@/utility/Modal';
import api from '@/services/pizza';
import Multiselect from '@vueform/multiselect'
import { ref } from '@vue/reactivity';

export default {
  components: {
    Modal,
    Multiselect,
  },
  props: ['condicion','ingredientesOptions','pizza'],
  watch: {
    ingredientesOptions(value){
      this.options = value;
    },
    pizza(value){
      const { ingrediente_pizzas, nombre, stock, precio } = value
      this.nombre = nombre
      this.stock = stock
      this.precio = precio
      /* this.ingredientes = ingrediente_pizzas.map(data => {
        return {
          ...data.ingredientes
        }
      }) */
      /* this.ingredientes = ingrediente_pizzas.map(data => {
        return {
          value: {
            ...data.ingredientes
          },
          label: data.ingredientes.nombre
        }
      }) */
    },
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
      if (this.ingredientes.length == 0) {
        this.mensaje('El campo ingredientes es requerido')
        return
      }
      this.editar()
    },
    async editar(){
      let ingredientesRaw = JSON.parse(JSON.stringify(this.ingredientes))
      let ingredientes = [], tmp;
      for (const iterator of ingredientesRaw) {
        tmp = ingredientes.filter( data => data.id == iterator.id)
        if (tmp.length == 0) {
          ingredientes.push(iterator)
        }
      }
      ingredientes = ingredientes.map( data => data.id)
      const formData = new FormData()
      formData.append('nombre', this.nombre);
      formData.append('stock', this.stock);
      formData.append('precio', this.precio);
      formData.append('imagen', this.condicionImagen ? this.imagen.files[0] : '');
      formData.append('ingredientes', JSON.stringify(ingredientes));
      const { mensaje, status } = await api.update(formData, this.pizza.id)
      const type = status == 'ok' ? 'success' : 'danger';
      this.mensaje(mensaje,type)
      this.hide(true)
    },
    toggleImage({target}){
      if (target.value == '') {
        this.condicionImagen = false
      } else {
        this.condicionImagen = true
      }
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
      condicionImagen: false,
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