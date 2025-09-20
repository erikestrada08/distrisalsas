<template>
  <Head title="DPanel" />
  <PrincipalLayout :modulo-actual="moduloActual" @seleccionarModulo="obtenerSubModulos">
    <!-- aviso de modulo no encontrado -->
    <div v-if="!nombreComponente && subModulos.length < 1" class="absolute inset-0 flex flex-col items-center justify-center overflow-hidden bg-gray-100 leading-none text-gray-500">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.8" stroke="currentColor" class="size-16">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
      </svg>
      No se encontró el módulo
    </div>

    <!-- spinner -->
    <div v-show="spinner" class="absolute inset-0 flex flex-col items-center justify-center overflow-hidden bg-gray-100 z-20">
      <div class="w-12 h-12 border-4 border-blue-500 border-dashed rounded-full animate-spin" />
      <span class="text-blue-500 font-bold animate-pulse">Cargando...</span>
    </div>

    <!-- submodulos -->
    <div v-if="subModulos.length > 0" class="flex gap-1">
      <!-- scroll horizontal de submódulos en móvil -->
      <div class="flex gap-1 overflow-x-auto w-full">
        <div v-for="submodulo in subModulos" :key="submodulo.id" class="min-w-[200px] bg-white rounded-md shadow flex items-center justify-center p-2 cursor-pointer border hover:border-blue-600" :title="submodulo.descripcion" @click="renderizar(submodulo)">
          <div class="basis-1/3 flex-shrink-0 flex items-center justify-center">
            <div class="bg-blue-600 text-white font-bold text-2xl rounded-full w-[40px] h-[40px] flex items-center justify-center">{{ submodulo.abreviatura }}</div>
          </div>
          <div class="basis-2/3 flex-shrink-0 flex items-center justify-center leading-none">
            {{ submodulo.sub_modulo }}
          </div>
        </div>
      </div>
    </div>

    <!-- componente del submodulo -->
    <keep-alive>
      <Transition enter-active-class="transition-all duration-300 transform" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100">
        <component :is="componenteActual" />
      </Transition>
    </keep-alive>
  </PrincipalLayout>
  
</template>

<script>
import { defineAsyncComponent, nextTick } from 'vue';
import { Head } from '@inertiajs/vue3';
import PrincipalLayout from '@/Layouts/PrincipalLayout.vue';

export default {
  components: { Head, PrincipalLayout },
  data() {
    return {
      subModulos: [],
      nombreComponente: null,
      spinner: false,
      moduloActual: null
    }
  },
  computed: {
    componenteActual() {
      if (!this.nombreComponente) return null;
      return defineAsyncComponent(() => import(`./Modulos/subModulos/${this.nombreComponente}.vue`));
    }
  },
  methods: {
    renderizar(_subModulo) {
      this.nombreComponente = _subModulo?.componente;
    },
    async obtenerSubModulos(_modulo) {
      this.moduloActual = _modulo.nombre;
      this.spinner = true;
      try {
        const { data: { data: RESPONSE } } = await axios.get('submodulo/listar', { params: { modulo: _modulo.id } });
        if (RESPONSE.length > 1) {
          this.nombreComponente = null;
          this.subModulos = RESPONSE;
        } else if (RESPONSE.length == 1) {
          this.subModulos = [];
          this.nombreComponente = RESPONSE[0].componente;
          await nextTick();
        } else {
          this.subModulos = [];
          this.nombreComponente = null;
        }
      } catch (error) {
        console.error(error);
      } finally {
        setTimeout(() => { this.spinner = false; }, 1000);
      }
    }
  },
  mounted() {
    const params = new URLSearchParams(window.location.search);
    const moduloId = params.get('modulo');
    if (moduloId) {
      const mod = (this.$page.props.modulos || []).find(m => String(m.id) === String(moduloId));
      if (mod) this.obtenerSubModulos(mod);
    }
  }
}
</script>

<style scoped></style>
