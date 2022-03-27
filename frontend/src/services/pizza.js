import store from "@/store";

const ruta = store.state.apiUrl

const read =  async () => {
  try {
    const respuesta = await fetch(`${ruta}/pizza`)
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
}