<template>
  <header class="header">
		<div class="container pt-2">
			<div class="row">
				<div class="col-xl-3 col-lg-3 col-md-3 display-flex flex-center">
					<div class="header-logo transition pt-4">
						<router-link :to="{ name: 'home'}">
							<img :src="logo" alt="Restaurano Logo">
						</router-link>
					</div>
				</div>
				<div class="col-xl-9 col-lg-9 col-md-9 display-flex flex-center justify-right">
					<div class="menu-toggle">
						<span class="transition"></span>
					</div>
					<div class="main-menu">
						<ul>
							<li>
								<a href="#" @click="logout" v-if="user.name">{{ user.name }}</a>
								<a href="#" @click="toggleModal" v-else>Iniciar Sesion</a>
							</li>
							<li>
								<div class="position-relative" @click="$router.push({ name: 'checkout'})">
									<span 
										v-if="this.carrito.length > 0"
										class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
									>
										{{ this.carrito.length }}
									</span>
									<CarritoIcon />
								</div>
							</li>
							<li>
								<router-link 
									class="book-now" 
									:to="{ name: 'dashboard' }"
								>
									Administracion
								</router-link>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="pb-custom"/>
	<router-view />

	<modal
    v-if="condicionModal"
    :classCustom="titulo == 'Login' ? 'size-modal-login' : 'size-modal-register'"
    :showHeader="false"
  >
    <template v-slot:body>
      <h3 class="text-center py-2">{{ titulo }}</h3>
      <form :action="($event) => $event.preventDefault()">
        <div class="row pb-2" v-if="titulo != 'Login'">
          <div class="col-4 align-self-center">
            Nombre: 
          </div>
          <div class="col-8 text-start">
            <input type="text" class="w-75 form-control" v-model="name">
          </div>
        </div>
        <div class="row pb-2">
          <div class="col-4 align-self-center">
            Correo: 
          </div>
          <div class="col-8 text-start">
            <input type="email" class="w-75 form-control" v-model="email">
          </div>
        </div>
        <div class="row pb-2">
          <div class="col-4 align-self-center">
            Contraseña: 
          </div>
          <div class="col-8 text-start">
            <input type="password" autocomplete="new-pass" class="w-75 form-control" v-model="password">
          </div>
        </div>
        <div class="py-2 text-center text-info">
          <span 
            class="cursor-pointer" 
            @click="titulo = titulo == 'Login' ? 'Registrarse' : 'Login'"
          >
            {{ titulo == 'Login' ? 'Registrarse' : 'Login' }} ?
          </span>
        </div>
      </form>
    </template>
    <template v-slot:footer>
      <button 
        v-if="titulo == 'Login'"
        class="btn btn-success me-2"
        @click="login"
      >
        Iniciar Sesion
      </button>
      <button 
        v-else
        class="btn btn-success me-2"
        @click="register"
      >
        Registrarse
      </button>
      <button class="btn btn-danger" @click="hide">Salir</button>
    </template>
  </modal>
</template>

<script>
import logo from '@/assets/logo.png';
import CarritoIcon from '@/utility/CarritoIcon';
import { mapState } from 'vuex'
import utility from "@/utility";
import apiU from '@/services/user.js'
import Modal from "@/utility/Modal";

export default {
	components: {
		CarritoIcon,
		Modal,
	},
	computed: {
    ...mapState(['carrito','user']),
  },
	methods: {
		async logout() {
			if (confirm('Esta seguro de cerrar sesion ?')) {
				const { message } = await apiU.logout();
				this.mensaje(message,'success')
			}
		},
		toggleModal(){
			this.condicionModal = true
		},
		async login(){
      const condicion = this.validar()
      if (condicion) {
        const datos = {
          email: this.email,
          password: this.password,
        }
        const { error } = await apiU.login(datos);
        if (error) {
          this.mensaje(error)
          return
        }
        this.mensaje('Iniciando Sesion ...', 'success')
        this.resetModal()
      }
    },
		validar(condicion = false){
      if (condicion) {
        if (!this.name) {
          this.mensaje('El nombre es requerido')
          return false
        }
      }
      if (!this.email) {
        this.mensaje('El correo es requerido')
        return false
      }
      if (!this.validarEmail.test(this.email)) {
        this.mensaje('El correo no es valido')
        return false
      }
      if (!this.password) {
        this.mensaje('La contraseña es requerida')
        return false
      }
      return true
    },
		async register(){
      const condicion = this.validar(true)
      if (condicion) {
        const datos = {
          email: this.email,
          password: this.password,
          name: this.name,
        }
        const { error } = await apiU.register(datos);
        if (error) {
          this.mensaje(error)
          return
        }
        this.mensaje('Se registro usuario con exito', 'success')
				this.resetModal()
      }
    },
		mensaje(message = '', type = 'error'){
      this.$toast.open({
        message,
        type,
        duration: 1500,
      });
    },
    hide(){
      this.resetModal()
    },
		resetModal(){
			this.name = ''
			this.email = ''
			this.password = ''
			this.titulo = 'Login'
			this.condicionModal = false;
		}
	},
  data(){
		const validarEmail = /^[\w\._]{5,30}\+?[\w]{0,10}@[\w\.\-]{3,}\.\w{2,5}$/i;
    return {
			validarEmail,
			logo,
			condicionModal: false,
			name: '',
			email: '',
			password: '',
			titulo: 'Login'
    }
  }
}
</script>

<style scoped lang='scss'>
	/* Plantilla */
	.header {
		position: fixed; 
		top: 0; 
		left: 0; 
		width: 100%; 
		z-index: 999; 
		border-bottom: 1px solid #545454;
		background-color: #1c1c1c;

		.header-logo:hover {
			opacity: 0.8;
		}

		.main-menu > ul {
			display: flex; 
			align-items: center; 
			width: 100%; justify-content: 
			flex-end;

			li {
				display: inline-block; 
				position: relative;

				a {
					color: #fff; 
					font-size: 14px; 
					padding: 39px 25px; 
					text-transform: uppercase; 
					display: block;
					text-decoration: none;
					transition: all ease-in-out .4s;

					&.book-now{
						background: #d02529; 
						border-radius: 50px; 
						font-size: 16px; 
						padding: 14px 37px; 
						margin-left: 25px; 
						border: 2px solid #d02529; 
						color: #fff !important; 
						text-decoration: unset !important;

						&:hover{
							background: transparent; 
							color: #d02529 !important;
						}
					}
				}

				&:hover > a{
					color: #d02529;
				}
			}
		}
	}
	.pb-custom{
    height: 123px;
  }
</style>