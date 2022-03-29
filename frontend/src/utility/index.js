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
      exist: false,
      payload: atob(token[1]),
      footer: atob(token[2]),
      header: atob(token[0]),
      token : localStorage.getItem('access_token')
    }
  }
  return { exist: false }
}

export default {
  formatearPrecio,
  getToken,
}