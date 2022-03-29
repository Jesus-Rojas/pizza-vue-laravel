import store from "@/store";
import utility from '@/utility';

const ruta = store.state.apiUrl

const read =  async () => {
  try {
    const { exist, token } = utility.getToken();
    if (exist) {
      const respuesta = await fetch(`${ruta}/pizza`, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
      return await respuesta.json();
    }
    throw {
      message: 'El token es invalido',
      error: true
    };
  } catch (error) {
    console.log(error)
    return error
  }
}

const ventaPizza =  async () => {
  try {
    const respuesta = await fetch(`${ruta}/pizza/ventaPizza`)
    return await respuesta.json();
  } catch (error) {
    console.log(error)
  }
}

const add =  async (datos) => {
  try {
    const respuesta = await fetch(`${ruta}/pizza`, {
      method: 'POST',
      body: datos
    })
    return await respuesta.json();
  } catch (error) {
    console.log(error)
  }
}

const update =  async (datos, id) => {
  try {
    const respuesta = await fetch(`${ruta}/pizza/${id}?_method=PUT`, {
      method: 'POST',
      body: datos
    })
    return await respuesta.json();
  } catch (error) {
    console.log(error)
  }
}

const remove =  async (id) => {
  try {
    const respuesta = await fetch(`${ruta}/pizza/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json'
      }
    })
    return await respuesta.json();
  } catch (error) {
    console.log(error)
  }
}

export default {
  read,
  add,
  update,
  remove,
  ventaPizza,
}