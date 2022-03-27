<template>
  <div class='d-flex min-h-screen'>
    <div class="w-25 bg-blue-900 px-5 py-10">
      <div class="position-fixed">
        <h2 class="text-4xl font-black text-white text-center">Administracion</h2>
        <nav class="mt-10">
          <router-link 
            class="d-block text-white fs-5"
            :to="{ name: 'dashboard' }"

          >
            Dashboard
          </router-link>
          <router-link 
            class="d-block text-white fs-5"
            :to="{ name: 'pizza' }"
          >
            Pizza
          </router-link>
          <router-link 
            class="d-block text-white fs-5"
            :to="{ name: 'ingrediente' }"
          >
            Ingrediente
          </router-link>
          <hr class="text-white" />
          <router-link 
            class="d-block text-white fs-5"
            :to="{ name: 'home' }"
          >
            Regresar
          </router-link>
        </nav>
      </div>
    </div>
    <div class="w-75 p-10">
      <router-view />
    </div>
  </div>
</template>

<script>
export default {
  setup() {
    return {
      
    }
  },
}
</script>

<style lang="scss" scoped>
  .router-link-exact-active {
    color: #000 !important;
  }
  .min-h-screen {
    min-height: 100vh;
  }
  .bg-blue-900 {
    background-color: rgb(30 58 138);
  }
  .py-10 {
    padding-top: 2.5rem; /* 40px */
    padding-bottom: 2.5rem; /* 40px */
  }
  .text-4xl {
    font-size: 2.25rem; /* 36px */
    line-height: 2.5rem; /* 40px */
  }
  .h-screen {
    height: 100vh;
  }
  .font-black {
    font-weight: 900;
  }
  .p-10 {
    padding: 2.5rem; /* 40px */
  }
  .mt-10 {
    margin-top: 2.5rem; /* 40px */
  }
</style>