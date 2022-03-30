const formatearPrecio = (precio) => { 
  return precio
    .toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 0,
    })
}

const getToken = () => { 
  let token = localStorage.getItem('access_token');
  if (token) {
    token = token.split('.')
    if (token.length !== 3) {
      return { exist: false }
    }
    return { 
      exist: true,
      payload: JSON.parse(atob(token[1])),
      // footer: atob(token[2]), // error de utf-8
      header: atob(token[0]),
      token : localStorage.getItem('access_token')
    }
  }
  return { exist: false }
}

const removeToken = () => { 
  localStorage.removeItem('access_token')
}

const editToken = (token) => { 
  localStorage.setItem('access_token', token)
}

export default {
  formatearPrecio,
  getToken,
  removeToken,
  editToken,
}