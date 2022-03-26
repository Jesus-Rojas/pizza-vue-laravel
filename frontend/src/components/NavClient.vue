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
								<svg xmlns="http://www.w3.org/2000/svg" class="carrito" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M96 0C107.5 0 117.4 8.19 119.6 19.51L121.1 32H541.8C562.1 32 578.3 52.25 572.6 72.66L518.6 264.7C514.7 278.5 502.1 288 487.8 288H170.7L179.9 336H488C501.3 336 512 346.7 512 360C512 373.3 501.3 384 488 384H159.1C148.5 384 138.6 375.8 136.4 364.5L76.14 48H24C10.75 48 0 37.25 0 24C0 10.75 10.75 0 24 0H96zM128 464C128 437.5 149.5 416 176 416C202.5 416 224 437.5 224 464C224 490.5 202.5 512 176 512C149.5 512 128 490.5 128 464zM512 464C512 490.5 490.5 512 464 512C437.5 512 416 490.5 416 464C416 437.5 437.5 416 464 416C490.5 416 512 437.5 512 464z"/></svg>
							</li>
							<li>
								<a href="#" class="book-now">Administracion</a>
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
import carrito from '@/assets/cart-shopping.svg';

export default {
  setup(){
    return {
			logo,
			carrito
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
	.carrito {
		width: 2rem;
    fill: #5e5d5d;
		cursor: pointer;
	}
</style>