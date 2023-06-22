<script>
// import { defineComponent, ref } from 'vue'
// import axios from 'axios'

// export default defineComponent({
// 	setup() {
// 		const resource = 'login';
// 		const form = ref({});
// 		const initForm = () => {
// 			form.value = {
// 				email: null,
// 				password: null
// 			}
// 		}

// 		const resetForm = () => {
// 			initForm()
// 		}

// 		const login = async () => {
// 			try {
// 				const res = await axios.post(`${resource}`, form)
// 				console.log(res)
// 				// resetForm()
// 			} catch (error) {
// 				console.log(error)
// 			}
// 		}

// 		return {
// 			form,
// 			login
// 		}
// 	}
// })
</script>

<template>
	<main>
        <div class="px-4 py-5 text-center">
            <img class="d-block mx-auto mb-4" src="https://cdn-icons-png.flaticon.com/512/8037/8037350.png" alt="" height="57">
            <h1 class="display-5 fw-bold text-body-emphasis">
                <span style="vertical-align: inherit;">
                    Bienvenido
				</span>
            </h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead">
					¡Bienvenido al Sistema de Portal de Trabajos! En nuestra plataforma, encontrarás una amplia gama
					de oportunidades laborales y podrás conectarte con empleadores de manera eficiente. Podrás crear
					un perfil profesional completo y acceder a recursos útiles para destacar tus habilidades.
					Nuestro algoritmo inteligente te mostrará oportunidades relevantes y podrás filtrar las
					búsquedas según tus preferencias. Te brindamos un entorno seguro y confiable para establecer
					conexiones valiosas con empresas de renombre. ¡Explora y encuentra el trabajo de tus sueños!
                </p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <button type="button" class="btn btn-primary btn-lg px-4 gap-3">
                        Ir Registro de trabajos
                    </button>
                </div>
            </div>
        </div>
    </main>
</template>