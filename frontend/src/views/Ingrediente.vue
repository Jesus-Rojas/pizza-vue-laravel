<template>
  <div>
    <div class="py-2 mb-3 pb-4">
      <div class="row">
        <div class="col-3"></div>
        <div class="col-6 text-center">
          <h3>Ingredientes</h3>
        </div>
        <div class="col-3">
          <button 
            type="button" 
            class="btn btn-warning"
            @click="showAdd = true"
          >
            Nuevo Ingrediente
          </button>
        </div>
      </div>
    </div>
    <Add 
      :condicion="showAdd" 
      @backdropEvent="messageAdd" 
    />
    <Edit 
      :condicion="showEdit"
      :ingrediente="ingrediente"
      @backdropEvent="messageEdit" 
    />
    
    <template v-if="items.length > 0">
      <div class="w-75 mx-auto">
        <table class="table table-light">
          <thead>
            <tr>
              <th
                v-for="(value, index) of fields" 
                :key="'thead-'+index"
              >
                {{value}}
              </th>
            </tr>
          </thead>
          <tbody>
            <tr 
              v-for="(value, index) of items" 
              :key="'tbody-'+index"
            >
              <td>{{ value.nombre }}</td>
              <td>
                <span class="size-icon d-inline-block" @click="editar(value)">
                  <svg 
                    class="edit-icon"
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 512 512"
                  >
                    <path d="M490.3 40.4C512.2 62.27 512.2 97.73 490.3 119.6L460.3 149.7L362.3 51.72L392.4 21.66C414.3-.2135 449.7-.2135 471.6 21.66L490.3 40.4zM172.4 241.7L339.7 74.34L437.7 172.3L270.3 339.6C264.2 345.8 256.7 350.4 248.4 353.2L159.6 382.8C150.1 385.6 141.5 383.4 135 376.1C128.6 370.5 126.4 361 129.2 352.4L158.8 263.6C161.6 255.3 166.2 247.8 172.4 241.7V241.7zM192 63.1C209.7 63.1 224 78.33 224 95.1C224 113.7 209.7 127.1 192 127.1H96C78.33 127.1 64 142.3 64 159.1V416C64 433.7 78.33 448 96 448H352C369.7 448 384 433.7 384 416V319.1C384 302.3 398.3 287.1 416 287.1C433.7 287.1 448 302.3 448 319.1V416C448 469 405 512 352 512H96C42.98 512 0 469 0 416V159.1C0 106.1 42.98 63.1 96 63.1H192z"/>
                  </svg>
                </span>
              </td>
              <td>
                <span class="size-icon d-inline-block" @click="eliminar(value.id)">
                  <svg 
                    class="trash-icon"
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 448 512"
                  >
                    <path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z"/>
                  </svg>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
  </div>
</template>

<script>
import Add from '@/components/IngredienteAdd';
import Edit from '@/components/IngredienteEdit';
import api from '@/services/ingrediente';

export default {
  components: {
    Add,
    Edit,
  },
  methods: {
    messageAdd(condicion){
      this.showAdd = false;
      if(condicion) {
        this.read();
      }
    },
    messageEdit(condicion){
      this.showEdit = false;
      if(condicion) {
        this.read();
      }
    },
    async read(){
      let { data } = await api.read();
      this.items = data;
    },
    mensaje(message = '', type = 'error'){
      this.$toast.open({
        message,
        type,
        duration: 1500,
      });
    },
    async eliminar(id) {
      const condicion = confirm('Estas seguro de eliminar este ingrediente ?')
      if(condicion){
        const { status, mensaje } = await api.remove(id);
        const type = status == 'ok' ? 'success' : 'danger';
        this.mensaje(mensaje,type);
        this.read();
      }
    },
    editar(item){
      this.ingrediente = item;
      this.showEdit = true;
    }
  },
  mounted() {
    this.read();
  },
  data() {
    // data
    const fields = ['Nombre', 'Editar', 'Eliminar'];
    const items = []

    return {
      showAdd: false,
      showEdit: false,
      fields,
      items,
      ingrediente: null,
    }
  },
}
</script>

<style lang="scss" scoped>
  .size-icon{
    width: 2rem;
    height: 2rem;
    cursor: pointer;
  }
  .edit-icon {
    fill: rgb(11, 92, 158);
  }
  .trash-icon {
    fill: rgb(145, 12, 19);
  }
  .modal {
    width: 300px;
    padding: 30px;
    box-sizing: border-box;
    background-color: #fff;
    font-size: 20px;
    text-align: center;
  }
</style>