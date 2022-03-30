import store from "@/store";
import utility from '@/utility';

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
    const data = await respuesta.json();
    let { access_token: payload } = data;
    if (payload) {
      payload = JSON.parse(atob(payload.split('.')[1]))
      store.commit('setUser', payload)
      utility.editToken(data.access_token);
    }
    return data
  } catch (error) {
    console.log(error)
  }
}

const logout =  async () => {
  try {
    const { token } = utility.getToken();
    const respuesta = await fetch(`${ruta}/logout`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
    store.commit('setUser', {})
    utility.removeToken();
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
    const data = await respuesta.json();
    let { access_token: payload } = data;
    if (payload) {
      payload = JSON.parse(atob(payload.split('.')[1]))
      store.commit('setUser', payload)
      utility.editToken(data.access_token);
    }
    return data
  } catch (error) {
    console.log(error)
  }
}

export default {
  register,
  logout,
  login,
}