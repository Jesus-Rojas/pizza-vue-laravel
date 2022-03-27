const formatearPrecio = (precio) => { 
  return precio
    .toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 0,
    })
}

export default {
  formatearPrecio
}