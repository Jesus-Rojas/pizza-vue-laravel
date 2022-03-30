import { createStore } from "vuex";

export default createStore({
  state: {
    apiUrl: 'http://localhost:8000/api',
    imgUrl: 'http://localhost:8000',
    carrito: [],
    user: {}
  },
  getters: {},
  mutations: {
    setCarrito(state, payload){
      state.carrito = payload
    },
    setUser(state, payload){
      state.user = payload
    },
  },
  actions: {},
  modules: {},
});
