<template>
  <div>
    <div class="py-2 mb-3 pb-4">
      <h3 class="text-center">Pedidos</h3>
    </div>
    
    <template v-if="items.length > 0">
      <div class="w-75 mx-auto">
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
              v-for="(value, index) of items" 
              :key="'tbody-'+index"
            >
              <td class="text-center">{{ value.users.name }}</td>
              <td class="text-center">{{ formatFecha(value.created_at) }}</td>
              <td class="text-center">{{ value.venta_total }}</td>
              <td class="text-center">
                <ul>
                  <li 
                    v-for="item in value.detalle_pedidos"
                    :key="'products-'+item.id"
                  >
                    {{ item.pizzas.nombre }}
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
  </div>
</template>

<script>
import api from '@/services/pedido';

export default {
  methods: {
    async read(){
      let { data } = await api.read();
      this.items = data;
    },
    formatFecha(fecha){
      const fechaNueva = new Date(fecha)
      
      return fechaNueva.toLocaleString()
    },
  },
  mounted() {
    this.read();
  },
  data() {
    // data
    const fields = ['Nombre', 'Fecha', 'Precio', 'Productos'];
    const items = []

    return {
      fields,
      items,
    }
  },
}
</script>