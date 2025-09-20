<template>
  <Head title="Catálogo" />
  <GuestLayout>
    <section class="bg-gray-50 min-h-screen p-4">

      <!-- Encabezado emocional -->
      <header class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Encuentra lo que hace tu día más fácil</h1>
        <p class="text-sm text-gray-500 mt-2">
          Selecciona lo que necesitas y deja que la inspiración te guíe
        </p>
      </header>

      <div class="flex flex-col lg:flex-row gap-6">

        <!-- Filtros tipo chips -->
        <aside class="lg:w-1/4 space-y-6">

          <!-- Filtros activos -->
          <div v-if="filtros.length > 0" class="flex flex-wrap gap-2 mb-2">
            <span
              v-for="(filtro, i) in filtros"
              :key="i"
              class="bg-blue-100 text-blue-600 text-sm px-3 py-1 rounded-full flex items-center gap-2"
            >
              {{ filtro }}
              <i class="fas fa-times cursor-pointer" @click="removerFiltro(filtro)"></i>
            </span>
            <button
              @click="limpiarFiltros"
              class="text-sm text-red-500 hover:underline ml-2"
            >Limpiar todo</button>
          </div>

          <!-- Categorías -->
          <div>
            <h2 class="text-gray-700 font-semibold mb-2">Explora por categoría</h2>
            <div class="flex flex-wrap gap-2">
              <button
                v-for="(categoria, i) in categorias"
                :key="i"
                class="bg-white border border-gray-300 text-gray-700 rounded-full px-4 py-1 text-sm hover:bg-blue-50"
                @click="agregarFiltro(categoria)"
              >
                {{ categoria.nombre }} ({{ categoria.cantidad }})
              </button>
            </div>
          </div>

          <!-- Marcas -->
          <div>
            <h2 class="text-gray-700 font-semibold mb-2">Marcas reconocidas</h2>
            <ul class="space-y-2">
              <li
                v-for="(marca, i) in marcas"
                :key="i"
                @click="agregarFiltro(marca)"
                class="cursor-pointer text-sm text-gray-600 hover:text-blue-600"
              >
                {{ marca.nombre }}
              </li>
            </ul>
          </div>
        </aside>

        <!-- Productos -->
        <main class="flex-1">
          <div v-show="filtros.length > 0" class="mb-4 text-gray-600 text-sm">
            Resultados filtrados: <span class="font-semibold">{{ filtros.join(', ') }}</span>
          </div>

          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <div
            v-for="(producto, i) in productos"
            :key="i"
            class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col gap-3"
            v-scroll-animation="'fade-in-up'"
            >
              <img
              :src="producto.imagen"
              alt="producto"
              class="h-32 object-contain w-full rounded"
              />

              <div class="text-center">
                <h3 class="text-gray-700 font-medium text-sm">{{ producto.nombre }}</h3>
                <p class="text-blue-600 font-bold">${{ formatoMiles(producto.precio) }}</p>
              </div>

              <!-- Cantidad -->
              <div class="flex items-center justify-center gap-2 text-sm">
                <button @click="producto.cantidad = Math.max(1, producto.cantidad - 1)">
                  <i class="fa-solid fa-minus text-gray-500 hover:text-blue-500"></i>
                </button>
                <input
                  v-model.number="producto.cantidad"
                  type="number"
                  min="1"
                  class="w-12 border rounded text-center text-sm"
                />
                <button @click="producto.cantidad++">
                  <i class="fa-solid fa-plus text-gray-500 hover:text-blue-500"></i>
                </button>
              </div>

              <!-- CTA -->
              <button
                @click.prevent="agregarItem(producto)"
                class="bg-yellow-400 text-gray-800 text-sm font-semibold rounded-md py-1 mt-auto hover:bg-yellow-300 transition"
              >
                Añadir al carrito
              </button>
            </div>
          </div>
        </main>
      </div>
    </section>
  </GuestLayout>
</template>


<script>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

export default {
    components:{
        GuestLayout,
        Head
    },
    data(){
        return {
            productos: [],
            categorias: [
                {
                    id: 1,
                    nombre: 'Salsas',
                    cantidad: 3
                },
                {
                    id: 2,
                    nombre: 'Vasos',
                    cantidad: 8
                },
                {
                    id: 3,
                    nombre: 'Contenedores',
                    cantidad: 13
                },
            ],
            marcas: [
                {
                    nombre: 'wau'
                },
                {
                    nombre: 'Óptima'
                },
                {
                    nombre: 'Darnel'
                },
                {
                    nombre: 'Differ'
                }
            ],
            filtros: []
        }
    },
    methods: {
        agregarFiltro(categoria){
            if( !this.filtros.some(filtro => filtro == categoria.nombre) ) this.filtros.push(categoria.nombre);
        },
        removerFiltro(filtro){
            const INDICE = this.filtros.findIndex(element => element === filtro);
            if (INDICE !== -1) {
                this.filtros.splice(INDICE, 1);
            }
        },
        limpiarFiltros() {
            this.filtros = [];
        },
        formatoMiles(numero){
            if (isNaN(numero) || numero == null) {
                return '0';
            }
            return numero.toLocaleString('es-Co', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2 
            });
        },
        agregarItem(producto){
            this.$store.dispatch('agregarAlCarrito', producto);
        }
    },
    created() {
      ( async () => {
        try {
          const { data: { data: PRODUCTOS } } = await axios.get('/catalogo/listar');
          this.productos = PRODUCTOS
        } catch (error) {
          console.error(error);
        }
      })();
    },
}
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

