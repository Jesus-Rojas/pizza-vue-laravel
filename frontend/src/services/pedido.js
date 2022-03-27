import store from "@/store";

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
    const respuesta = await fetch(`${ruta}/pedido`, {
      method: 'POST',
      body: JSON.stringify(datos),
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
}