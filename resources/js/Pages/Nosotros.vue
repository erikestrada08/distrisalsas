<template>
    <Head title="Catálogo" />
    <Plantilla>
  <!-- Hero con imagen de fondo -->
  <section class="relative h-screen bg-cover bg-center flex items-center justify-center text-white" style="background-image: url('https://source.unsplash.com/1600x900/?deli,food');">
    <div class="bg-black bg-opacity-60 w-full h-full absolute top-0 left-0"></div>
    <div class="relative z-10 text-center max-w-2xl px-4" v-scroll-animation>
      <h1 class="text-4xl md:text-5xl font-bold mb-4">Más que embutidos, llevamos sabor y tradición a tu mesa desde hace más de 20 años.</h1>
      <a href="#historia" class="mt-4 inline-block px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">Conócenos más</a>
    </div>
  </section>



<section id="historia" class="relative py-36 bg-gradient-to-tr from-yellow-50 via-white to-red-50 overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24">

    <!-- Encabezado -->
    <h2 class="text-5xl md:text-6xl font-black text-center text-red-700 mb-32 leading-tight tracking-tight">
      Nuestra Historia
    </h2>

    <!-- Línea de Tiempo -->
    <div class="space-y-36">

      <!-- Evento 1 -->
      <div class="flex flex-col md:flex-row gap-10 md:gap-20 items-center group">
        <div class="md:w-1/2 relative overflow-hidden rounded-3xl shadow-xl transform transition duration-500 ease-in-out group-hover:scale-[1.02]">
          <img src="/imagenes/logo.png"
            class="w-full h-[300px] sm:h-[400px] object-cover rounded-3xl">
          <div class="absolute top-4 left-4 bg-red-600 text-white text-sm font-semibold px-4 py-1 rounded-full shadow">
            📜 Tradición Familiar
          </div>
        </div>
        <div class="md:w-1/2 text-center md:text-left">
          <h3 class="text-3xl md:text-4xl font-bold text-red-700 mb-4">2003 — El Comienzo</h3>
          <p class="text-gray-700 text-lg leading-relaxed">
            Todo comenzó con el calor del hogar y el sazón de la abuela. Recetas tradicionales, un pequeño fogón y una gran pasión: así nació nuestro primer chorizo artesanal.
          </p>
        </div>
      </div>

      <!-- Evento 2 -->
      <div class="flex flex-col md:flex-row-reverse gap-10 md:gap-20 items-center group">
        <div class="md:w-1/2 relative overflow-hidden rounded-3xl shadow-xl transform transition duration-500 ease-in-out group-hover:scale-[1.02]">
          <img src="/imagenes/DSC_6659.JPG" alt="Producto Estrella"
            class="w-full h-[300px] sm:h-[400px] object-cover rounded-3xl">
          <div class="absolute top-4 right-4 bg-yellow-400 text-red-800 text-sm font-semibold px-4 py-1 rounded-full shadow">
            🌟 Éxito Local
          </div>
        </div>
        <div class="md:w-1/2 text-center md:text-right">
          <h3 class="text-3xl md:text-4xl font-bold text-yellow-700 mb-4">2008 — Producto Estrella</h3>
          <p class="text-gray-700 text-lg leading-relaxed">
            El salchichón artesanal conquistó paladares. Vecinos, tiendas y ferias locales lo convirtieron en emblema del sabor casero, auténtico y nuestro.
          </p>
        </div>
      </div>

      <!-- Evento 3 -->
      <div class="flex flex-col md:flex-row gap-10 md:gap-20 items-center group">
        <div class="md:w-1/2 relative overflow-hidden rounded-3xl shadow-xl transform transition duration-500 ease-in-out group-hover:scale-[1.02]">
          <img src="/imagenes/DSC_6659.JPG" alt="Hoy"
            class="w-full h-[300px] sm:h-[400px] object-cover rounded-3xl">
          <div class="absolute bottom-4 left-4 bg-red-700 text-white text-sm font-semibold px-4 py-1 rounded-full shadow">
            🏪 Presente & Futuro
          </div>
        </div>
        <div class="md:w-1/2 text-center md:text-left">
          <h3 class="text-3xl md:text-4xl font-bold text-red-700 mb-4">Hoy</h3>
          <p class="text-gray-700 text-lg leading-relaxed">
            Hoy somos más que una marca: somos parte de los almuerzos, celebraciones y recuerdos de quienes eligen sabor con historia. Seguimos creciendo con el mismo amor.
          </p>
        </div>
      </div>

    </div>
  </div>

  <!-- Decorativos suaves -->
  <div class="absolute -top-40 -left-40 w-[500px] h-[500px] bg-red-100 rounded-full opacity-30 blur-3xl -z-10"></div>
  <div class="absolute -bottom-40 right-0 w-[400px] h-[400px] bg-yellow-200 rounded-full opacity-30 blur-3xl -z-10"></div>
</section>



  <!-- Nuestra Pasión -->
  <section class="py-16 bg-yellow-100">
    <div class="max-w-3xl mx-auto px-6 text-center" v-scroll-animation>
      <h2 class="text-3xl font-bold text-red-700 mb-6">¿Por qué lo hacemos?</h2>
      <p class="text-lg leading-relaxed">Desde pequeños, en la cocina de la abuela, aprendimos que los momentos especiales siempre vienen acompañados de un buen sabor. Por eso trabajamos cada día para llevarte productos con historia y corazón.</p>
      <img src="/imagenes/DSC_6659.JPG" alt="Nuestra pasión" class="mx-auto mt-8 rounded-lg shadow-lg">
    </div>
  </section>

  <!-- Nuestro Equipo -->
  <section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">
      <h2 class="text-3xl font-bold text-center text-red-600 mb-12" v-scroll-animation>Detrás del sabor</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div v-scroll-animation>
          <img src="/imagenes/DSC_6659.JPG" class="rounded-full w-28 h-28 mx-auto mb-4">
          <h3 class="font-bold">Don Álvaro</h3>
          <p class="text-sm">Maestro Charcutero por 25 años.</p>
        </div>
        <div v-scroll-animation>
          <img src="/imagenes/DSC_6659.JPG" class="rounded-full w-28 h-28 mx-auto mb-4">
          <h3 class="font-bold">Carolina</h3>
          <p class="text-sm">Experta en atención al cliente, y en sonrisas.</p>
        </div>
        <div v-scroll-animation>
          <img src="/imagenes/DSC_6659.JPG" class="rounded-full w-28 h-28 mx-auto mb-4">
          <h3 class="font-bold">Equipo Artesanal</h3>
          <p class="text-sm">El alma detrás de cada sabor auténtico.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Nuestros Valores -->
  <section class="py-16 bg-yellow-50">
    <div class="max-w-5xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold text-red-700 mb-10" v-scroll-animation>Nuestros Valores</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div v-scroll-animation>
          <div class="text-4xl">🍖</div>
          <h4 class="font-bold mt-2">Tradición</h4>
        </div>
        <div v-scroll-animation>
          <div class="text-4xl">✅</div>
          <h4 class="font-bold mt-2">Calidad</h4>
        </div>
        <div v-scroll-animation>
          <div class="text-4xl">🏘️</div>
          <h4 class="font-bold mt-2">Cercanía</h4>
        </div>
        <div v-scroll-animation>
          <div class="text-4xl">🧡</div>
          <h4 class="font-bold mt-2">Autenticidad</h4>
        </div>
      </div>
    </div>
  </section>

  <!-- Mapa + Testimonios -->
  <section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">
      <h2 class="text-3xl font-bold text-center text-red-600 mb-10" v-scroll-animation>Dónde encontrarnos</h2>
      <div class="grid md:grid-cols-2 gap-8">
        <div v-scroll-animation>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!..." class="w-full h-64 rounded-lg"></iframe>
        </div>
        <div class="flex flex-col justify-center space-y-4" v-scroll-animation>
          <blockquote class="italic">“Siempre frescos y con una atención increíble. ¡No hay nada igual!” – Cliente feliz</blockquote>
          <blockquote class="italic">“El salchichón me recuerda a mi infancia. ¡Gracias por tanto sabor!” – Cliente frecuente</blockquote>
        </div>
      </div>
    </div>
  </section>

  <!-- Galería Viva -->
  <section class="py-16 bg-yellow-100">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold text-red-700 mb-10" v-scroll-animation>Momentos con Sabor</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4" v-scroll-animation>
        <img src="/imagenes/DSC_6659.JPG" class="rounded-lg shadow">
        <img src="/imagenes/DSC_6659.JPG" class="rounded-lg shadow">
        <img src="/imagenes/DSC_6659.JPG" class="rounded-lg shadow">
        <img src="/imagenes/DSC_6659.JPG" class="rounded-lg shadow">
      </div>
    </div>
  </section>

  <!-- Cierre emocional -->
  <section class="py-16 bg-red-600 text-white text-center">
    <div class="max-w-3xl mx-auto px-6" v-scroll-animation>
      <h2 class="text-3xl font-bold mb-6">Ven, descubre por qué en cada bocado hay una historia que contar.</h2>
      <p class="mb-8">Gracias por ser parte de nuestra familia.</p>
      <div class="flex justify-center gap-4">
        <a href="#catalogo" class="px-6 py-3 bg-yellow-400 text-red-800 font-bold rounded-lg hover:bg-yellow-300 transition">Ver nuestro catálogo</a>
        <a href="https://wa.me/1234567890" class="px-6 py-3 bg-white text-red-600 font-bold rounded-lg hover:bg-gray-100 transition">Haz tu pedido</a>
      </div>
    </div>
  </section>

    </Plantilla>
</template>

<script>
import { Head } from "@inertiajs/vue3";
import Plantilla from "@/Layouts/Plantilla.vue";

export default {
    components: {
        Plantilla,
        Head,
    },
    data() {
        return {
            productos: [],
            categorias: [
                {
                    id: 1,
                    nombre: "Salsas",
                    cantidad: 3,
                },
                {
                    id: 2,
                    nombre: "Vasos",
                    cantidad: 8,
                },
                {
                    id: 3,
                    nombre: "Contenedores",
                    cantidad: 13,
                },
            ],
            marcas: [
                {
                    nombre: "wau",
                },
                {
                    nombre: "Óptima",
                },
                {
                    nombre: "Darnel",
                },
                {
                    nombre: "Differ",
                },
            ],
            filtros: [],
        };
    },
    methods: {
        agregarFiltro(categoria) {
            if (!this.filtros.some((filtro) => filtro == categoria.nombre))
                this.filtros.push(categoria.nombre);
        },
        removerFiltro(filtro) {
            const INDICE = this.filtros.findIndex(
                (element) => element === filtro
            );
            if (INDICE !== -1) {
                this.filtros.splice(INDICE, 1);
            }
        },
        limpiarFiltros() {
            this.filtros = [];
        },
        formatoMiles(numero) {
            if (isNaN(numero) || numero == null) {
                return "0";
            }
            return numero.toLocaleString("es-Co", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        },
        agregarItem(producto) {
            this.$store.dispatch("agregarAlCarrito", producto);
        },
    },
    created() {
        (async () => {
            try {
                const {
                    data: { data: PRODUCTOS },
                } = await axios.get("/catalogo/listar");
                this.productos = PRODUCTOS;
            } catch (error) {
                console.error(error);
            }
        })();
    },
};
</script>
<style scoped>
.grid-cols-custom {
    grid-template-columns: repeat(4, minmax(150px, 150px));
}

.grid-container {
    display: grid;
    gap: 2px;
    min-height: 100%;
    grid-template-columns: 200px auto;
    grid-template-areas:
        "herramientas   herramientas"
        "filtros        productos"
        "filtros        productos";
}

.barra-herramientas {
    grid-area: herramientas;
}

.filtros {
    grid-area: filtros;
}

.productos {
    grid-area: productos;
}
</style>
