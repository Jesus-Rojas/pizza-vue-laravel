import store from "@/store";

const ruta = store.state.apiUrl

const read =  async () => {
  try {
    const respuesta = await fetch(`${ruta}/ingrediente`)
    return await respuesta.json();
  } catch (error) {
    console.log(error)
  }
}

const add =  async () => {
  try {
    const respuesta = await fetch(`${ruta}/ingrediente`, {
      method: 'POST',
      body: JSON.stringify(datos)
    })
    return await respuesta.json();
  } catch (error) {
    console.log(error)
  }
}

const update =  async (datos, id) => {
  try {
    const respuesta = await fetch(`${ruta}/ingrediente/${id}`, {
      method: 'PUT',
      body: JSON.stringify(datos)
    })
    return await respuesta.json();
  } catch (error) {
    console.log(error)
  }
}

const remove =  async (id) => {
  try {
    const respuesta = await fetch(`${ruta}/ingrediente/${id}`, {
      method: 'DELETE'
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
}