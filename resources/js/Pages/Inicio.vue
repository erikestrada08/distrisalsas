<template>
    <GuestLayout>
        <div ref="root">
            <!-- Hero / Bienvenida -->
            <section v-scroll-animation class="relative bg-yellow-50 py-12 px-4 text-center sm:py-16 sm:px-6">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-red-600 mb-4 leading-snug">
                    ¡Bienvenido a Distrisalsas del Eje!
                </h1>
                <p class="text-base sm:text-lg text-gray-700 mb-6 max-w-xl mx-auto">
                    Distribuimos los mejores sabores para tu negocio. Explora
                    nuestra variedad de salsas y productos alimenticios de
                    calidad.
                </p>
                <a href="#catalogo" class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-3 rounded-full transition">
                    Ver Catálogo
                </a>
            </section>

            <!-- Catálogo -->
            <section
            id="catalogo"
            v-scroll-animation
            class="bg-white py-12 px-4 sm:py-16 sm:px-6"
            >
                <h2 class="text-2xl sm:text-3xl font-bold text-center text-red-600 mb-10">
                    Nuestro Catálogo
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
                    <div
                    v-for="(producto, i) in productos"
                    :key="i"
                    class="bg-yellow-100 p-5 sm:p-6 rounded-xl shadow hover:shadow-lg transition"
                    v-scroll-animation
                    >
                        <img
                        :src="producto.imagen"
                        :alt="producto.titulo"
                        class="w-full h-40 sm:h-48 object-cover rounded-md mb-4"
                        />
                        <h3 class="text-lg sm:text-xl font-semibold text-red-500">
                            {{ producto.titulo }}
                        </h3>
                        <p class="text-gray-600 mt-2 text-sm sm:text-base">
                            {{ producto.descripcion }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-center py-4">
                    <Link
                    :href="route('catalogo')"
                    class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-3 rounded-full transition"
                    >
                        Ver más
                    </Link>
                </div>
            </section>

            <!-- Sobre Nosotros -->
            <section
            id="sobre-nosotros"
            v-scroll-animation
            class="bg-red-50 py-12 px-4 sm:py-16 sm:px-6"
            >
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-2xl sm:text-3xl font-bold text-red-600 mb-6">
                        Sobre Nosotros
                    </h2>
                    <p class="text-gray-700 text-base sm:text-lg leading-relaxed">
                        Somos una empresa risaraldense comprometida con la
                        calidad y el sabor de nuestros productos. En
                        Distrisalsas del Eje trabajamos día a día para llevar a
                        tu negocio productos alimenticios que marcan la
                        diferencia. Nuestros valores son la confianza, el
                        compromiso y la excelencia.
                    </p>
                </div>
            </section>

            <!-- Misión, Visión y Historia -->
            <section class="bg-white py-16 px-4 sm:px-6">
                <div class="max-w-7xl mx-auto space-y-20">
                    <!-- Historia -->
                    <div class="flex flex-col md:flex-row items-center gap-10" v-scroll-animation>
                        <div class="md:w-1/2 space-y-4 sm:space-y-6 text-center md:text-left">
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-red-600 leading-tight">
                                Un origen con propósito
                            </h2>
                            <p class="text-gray-700 text-base sm:text-lg">
                                Nacimos con un objetivo claro: ser
                                <span class="font-semibold text-red-500">el aliado más confiable del sector HORECA en el Eje Cafetero</span>.
                            </p>
                            <p class="text-gray-600 text-sm sm:text-base">
                                Hoy, abastecemos hoteles, restaurantes y
                                cafeterías con productos para comidas rápidas,
                                empaques y desechables, impulsando negocios
                                desde la confianza, la calidez y la seguridad.
                            </p>
                        </div>
                        <div class="md:w-1/2" v-scroll-animation>
                            <img
                            src="/imagenes/DSC_6659.JPG"
                            alt="Historia de Distrisalsas"
                            class="rounded-3xl shadow-xl w-full object-cover transition-transform duration-500 hover:scale-105"
                            />
                        </div>
                    </div>

                    <!-- Misión y Visión -->
                    <div class="grid gap-8 sm:gap-12 sm:grid-cols-2">
                        <div class="bg-red-50 p-6 sm:p-8 rounded-3xl shadow-xl hover:shadow-2xl transition" v-scroll-animation>
                            <h3 class="text-xl sm:text-2xl font-bold text-red-600 mb-3">
                                Nuestra Misión
                            </h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                                Proveer con excelencia insumos para comidas
                                rápidas y desechables al sector HORECA,
                                fortaleciendo los negocios de nuestros clientes
                                con soluciones confiables, oportunas y humanas.
                            </p>
                        </div>
                        <div class="bg-yellow-50 p-6 sm:p-8 rounded-3xl shadow-xl hover:shadow-2xl transition" v-scroll-animation>
                            <h3 class="text-xl sm:text-2xl font-bold text-yellow-600 mb-3">
                                Nuestra Visión
                            </h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                                Ser reconocidos como el proveedor líder de
                                insumos HORECA en el Eje Cafetero, destacando
                                por nuestra trayectoria, calidez y capacidad de
                                adaptación al cambio.
                            </p>
                        </div>
                    </div>

                    <!-- Valores -->
                    <div class="text-center space-y-10 px-4 sm:px-6 lg:px-8" v-scroll-animation="'fade-up'">
                        <h3 class="text-3xl sm:text-4xl font-extrabold text-red-600 tracking-tight">
                            Nuestros Valores
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6 max-w-6xl mx-auto">
                            <!-- Valor -->
                            <div class="flex flex-col items-center bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition" v-scroll-animation="'zoom-in'">
                                <div class="text-red-500 text-3xl mb-2">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <span class="text-gray-800 font-semibold text-base sm:text-lg">Confianza</span>
                            </div>

                            <div class="flex flex-col items-center bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition" v-scroll-animation="'zoom-in'">
                                <div class="text-red-500 text-3xl mb-2">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <span class="text-gray-800 font-semibold text-base sm:text-lg">Calidez</span>
                            </div>

                            <div class="flex flex-col items-center bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition" v-scroll-animation="'zoom-in'">
                                <div class="text-red-500 text-3xl mb-2">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <span class="text-gray-800 font-semibold text-base sm:text-lg">Compromiso</span>
                            </div>

                            <div class="flex flex-col items-center bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition" v-scroll-animation="'zoom-in'">
                                <div class="text-red-500 text-3xl mb-2">
                                    <i class="fas fa-award"></i>
                                </div>
                                <span class="text-gray-800 font-semibold text-base sm:text-lg">Excelencia</span>
                            </div>

                            <div class="flex flex-col items-center bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition" v-scroll-animation="'zoom-in'">
                                <div class="text-red-500 text-3xl mb-2">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <span class="text-gray-800 font-semibold text-base sm:text-lg">Agilidad</span>
                            </div>

                            <div class="flex flex-col items-center bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition" v-scroll-animation="'zoom-in'">
                                <div class="text-red-500 text-3xl mb-2">
                                    <i class="fas fa-sync-alt"></i>
                                </div>
                                <span class="text-gray-800 font-semibold text-base sm:text-lg">Adaptabilidad</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contacto -->
            <!-- Contacto -->
<section
  id="contacto"
  data-observe
  class="bg-gradient-to-b from-yellow-100 to-yellow-50 py-16 px-4 sm:px-8 lg:px-16"
>
  <div class="max-w-5xl mx-auto space-y-12">
    <!-- Título -->
    <div class="text-center">
      <h2 class="text-3xl sm:text-4xl font-bold text-red-600 mb-2">Contáctanos</h2>
      <p class="text-gray-600 max-w-xl mx-auto text-base sm:text-lg">
        ¿Tienes alguna pregunta o deseas más información? Escríbenos, estamos aquí para ayudarte.
      </p>
    </div>

    <!-- Contenido principal -->
    <div class="grid lg:grid-cols-2 gap-10">
      <!-- Formulario -->
      <form class="space-y-5 bg-white shadow-lg p-6 rounded-2xl">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
          <input
            type="text"
            placeholder="Tu nombre"
            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-400 text-sm"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
          <input
            type="email"
            placeholder="correo@ejemplo.com"
            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-400 text-sm"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
          <textarea
            placeholder="Escribe tu mensaje aquí..."
            class="w-full px-4 py-3 border border-gray-300 rounded-md h-32 resize-none focus:outline-none focus:ring-2 focus:ring-red-400 text-sm"
            required
            ></textarea>
            </div>
            <button
            type="submit"
            class="w-full bg-red-500 hover:bg-red-600 text-white py-3 font-semibold rounded-md transition duration-200"
            >
            Enviar mensaje
            </button>
        </form>

        <!-- Información + Mapa -->
        <div class="space-y-6">
            <!-- Datos de contacto -->
            <div class="bg-yellow-200/60 rounded-xl p-6 space-y-3 text-gray-800 shadow-md">
            <p><i class="fa-solid fa-phone text-red-500 mr-2"></i> <strong>+57 322 689 2892</strong></p>
            <p><i class="fa-solid fa-envelope text-red-500 mr-2"></i> distrisalsasdeleje@gmail.com</p>
            <p><i class="fa-solid fa-location-dot text-red-500 mr-2"></i> Pereira, Risaralda, Colombia</p>
            </div>

            <!-- Mapa -->
            <div class="rounded-xl overflow-hidden shadow-md">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.8338893048475!2d-75.6961113!3d4.8136199!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e388751f28fca23%3A0x28ac4d6472e27a7!2sPereira%2C%20Risaralda!5e0!3m2!1ses-419!2sco!4v1718052634784!5m2!1ses-419!2sco"
                width="100%"
                height="260"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
            </div>
        </div>
        </div>
    </div>
</section>

        </div>
    </GuestLayout>
</template>

<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        GuestLayout,
        Link
    },
    data() {
        return {
            productos: [
                {
                    titulo: "Salsa de Ajo",
                    descripcion:
                        "Deliciosa salsa con sabor casero para acompañar tus comidas.",
                    imagen: "/imagenes/producto1.png",
                },
                {
                    titulo: "Salsa Rosada",
                    descripcion: "Ideal para papas, perros y hamburguesas.",
                    imagen: "/imagenes/producto2.png",
                },
                {
                    titulo: "Mayonesa Especial",
                    descripcion:
                        "Textura cremosa, sabor perfecto para tu negocio.",
                    imagen: "/imagenes/producto3.png",
                },
            ],
        };
    },
    created() {
        (async () => {
            try {
                const x = await axios.get('/producto/listar');
                console.log(x);
            } catch (error) {
                console.error(error);
            }
        })();
    },
};
</script>

<style scoped>
</style>
