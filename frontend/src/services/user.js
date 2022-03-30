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
    if (respuesta.status !== 200) {
      return {
        error: 'Error en credenciales, verifica!!'
      }
    }
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
    if (respuesta.status == 403) {
      return {
        error: 'El usuario ya existe en el sistema'
      }
    }
    if (respuesta.status !== 200) {
      return {
        error: 'Problemas en el servidor'
      }
    }
    return await respuesta.json();
  } catch (error) {
    console.log(error)
  }
}

export default {
  register,
  login,
}