import store from "@/store";
import utility from '@/utility';

const ruta = store.state.apiUrl

const read =  async () => {
  try {
    const respuesta = await fetch(`${ruta}/pedido`)
    return await respuesta.json();
  } catch (error) {
    console.log(error)
  }
}

const add =  async (datos) => {
  try {
    const { exist, token } = utility.getToken();
    if (exist) {
      const respuesta = await fetch(`${ruta}/pedido`, {
        method: 'POST',
        body: JSON.stringify(datos),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`
        }
      })
      return await respuesta.json();
    }
    utility.removeToken();
    return {
      error: 'El token es invalido',
    };
  } catch (error) {
    console.log(error)
  }
}

export default {
  read,
  add,
}