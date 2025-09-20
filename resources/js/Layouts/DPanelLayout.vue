<template>
  <div class="container">
    <!-- Top bar -->
    <div class="nav-bar flex justify-between items-center p-2 shadow-md">
      <img src="/imagenes/logo-rojo-amarillo.png" alt="Logo de distrisalsas" class="h-12 w-auto object-contain" />

      <div class="flex items-center gap-2 relative" ref="userMenu">
        <button class="flex items-center gap-2 hover:opacity-80" @click.stop="userMenuOpen = !userMenuOpen" aria-haspopup="menu" :aria-expanded="userMenuOpen">
          <span>Bienvenid@, <span class="font-bold">{{ usuario.name }}</span></span>
          <img src="/imagenes/iconos/icono-usuario.png" alt="user" class="h-8" />
        </button>
        <!-- Dropdown -->
        <div v-show="userMenuOpen" class="absolute right-0 top-full mt-2 w-44 bg-white border rounded shadow-md z-50">
          <Link :href="route('profile.edit')" class="block px-3 py-2 hover:bg-gray-100">Perfil</Link>
          <Link :href="route('logout')" method="post" as="button" class="w-full text-left px-3 py-2 hover:bg-gray-100">Cerrar sesión</Link>
        </div>
      </div>

      <!-- Toggle sidebar (mobile) -->
      <button class="md:hidden ml-2 p-2 rounded hover:bg-gray-100" @click="sidebarOpen = !sidebarOpen" aria-label="Abrir menú">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
      </button>
    </div>

    <!-- Backdrop (mobile) -->
    <div v-if="sidebarOpen" class="fixed inset-0 bg-black/30 z-30 md:hidden" @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <div class="side-bar"
      :class="{
        'fixed z-40 bg-white top-0 left-0 h-full w-60 shadow transform transition-transform duration-200 -translate-x-full md:translate-x-0 md:static md:w-[80px]': true,
        'translate-x-0': sidebarOpen
      }"
    >
      <nav>
        <ul class="flex flex-col">
          <li v-for="modulo in modulos" :key="modulo.id" :title="modulo.nombre"
              @click="$emit('seleccionarModulo', modulo)"
              :class="{ 'bg-gray-100': moduloActual == modulo.nombre }"
              class="w-full h-[60px] gap-5 px-2 py-1 hover:bg-gray-200 cursor-pointer relative">
            <span class="bg-cyan-500 w-[2px] h-[4px]" />
            <span class="absolute top-1/2 left-1/2 -transform -translate-x-[14px] -translate-y-1/2" v-html="modulo.icono"></span>
          </li>
        </ul>
      </nav>
    </div>

    <!-- Content -->
    <div class="content p-1 bg-gray-100 relative">
      <slot />
    </div>

    <div class="footer text-center">
      &copy; 2025 Distrisalsas del Eje. Todos los derechos reservados.
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
  name: 'DPanelLayout',
  components: { Link },
  props: {
    moduloActual: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      usuario: this.$page.props.user,
      modulos: this.$page.props.modulos,
      sidebarOpen: false,
      userMenuOpen: false
    }
  },
  mounted() {
    document.addEventListener('click', this.onClickOutside);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.onClickOutside);
  },
  methods: {
    onClickOutside(e) {
      const el = this.$refs.userMenu;
      if (el && !el.contains(e.target)) this.userMenuOpen = false;
    }
  }
}
</script>

<style scoped>
.container{
  min-height: 100dvh;
  min-width: 100dvw;
  max-height: 100dvh;
  max-width: 100dvw;
  display: grid;
  grid-template-rows: auto 1fr auto;
  grid-template-columns: 80px auto;
  grid-template-areas:
      "navbar     navbar"
      "sidebar    content"
      "sidebar    content"
      "footer     footer";
}

.nav-bar { grid-area: navbar; }
.side-bar { grid-area: sidebar; overflow-y: auto; }
.content { grid-area: content; overflow-y: auto; height: 100%; }
.footer { grid-area: footer; }

@media (max-width: 768px) {
  .container{
    grid-template-columns: 1fr;
    grid-template-areas:
      "navbar"
      "content"
      "footer";
  }
}
</style>
