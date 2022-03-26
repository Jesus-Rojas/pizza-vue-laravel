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

export default {
  read
}