<template>
  <header class="header">
		<div class="container pt-2">
			<div class="row">
				<div class="col-xl-3 col-lg-3 col-md-3 display-flex flex-center">
					<div class="header-logo transition pt-4">
						<a href="index.html"><img :src="logo" alt="Restaurano Logo"></a>
					</div>
				</div>
				<div class="col-xl-9 col-lg-9 col-md-9 display-flex flex-center justify-right">
					<div class="menu-toggle">
						<span class="transition"></span>
					</div>
					<div class="main-menu">
						<ul>
							<li>
								<a href="#">Jesus Rojas</a>
							</li>
							<li>
								<div class="position-relative">
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
</template>

<script>
import logo from '@/assets/logo.png';
import CarritoIcon from '@/utility/CarritoIcon';
import { mapState } from 'vuex'

export default {
	components: {
		CarritoIcon
	},
	computed: {
    ...mapState(['carrito']),
  },
  setup(){
    return {
			logo,
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
	
</style>