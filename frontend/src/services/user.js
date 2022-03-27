import store from "@/store";

const ruta = store.state.apiUrl

const login =  async (datos) => {
  try {
    const respuesta = await fetch(`${ruta}/login`, {
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

const register =  async (datos) => {
  try {
    const respuesta = await fetch(`${ruta}/register`, {
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
  register,
  login,
}