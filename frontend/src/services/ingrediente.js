import store from "@/store";
import utility from '@/utility';

const ruta = store.state.apiUrl

const read =  async () => {
  try {
    const { exist, token } = utility.getToken();
    if(exist) {
      const respuesta = await fetch(`${ruta}/ingrediente`, {
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

const add =  async (datos) => {
  try {
    const { exist, token } = utility.getToken();
    if(exist) {
      const respuesta = await fetch(`${ruta}/ingrediente`, {
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

const update =  async (datos, id) => {
  try {
    const { exist, token } = utility.getToken();
    if(exist) {
      const respuesta = await fetch(`${ruta}/ingrediente/${id}`, {
        method: 'PUT',
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

const remove =  async (id) => {
  try {
    const { exist, token } = utility.getToken();
    if(exist) {
      const respuesta = await fetch(`${ruta}/ingrediente/${id}`, {
        method: 'DELETE',
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

const all =  async () => {
  try {
    const { exist, token } = utility.getToken();
    if(exist) {
      const respuesta = await fetch(`${ruta}/ingrediente/all`, {
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
  update,
  remove,
  all,
}