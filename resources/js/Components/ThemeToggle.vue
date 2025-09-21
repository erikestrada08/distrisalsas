<template>
  <button
    :title="isDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'"
    class="inline-flex items-center gap-2 rounded-md border px-2 py-1 text-sm hover:bg-muted/10 bg-card text-foreground border-border"
    @click="toggleTheme"
  >
    <svg v-if="!isDark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
      <path d="M12 2.25a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75Zm0 15a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5ZM4.72 5.97a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 1 1-1.06 1.06L4.72 7.03a.75.75 0 0 1 0-1.06Zm12.44 9.94a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 1 1-1.06 1.06l-1.06-1.06a.75.75 0 0 1 0-1.06ZM2.25 12a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1-.75-.75Zm15.75-.75h1.5a.75.75 0 0 1 0 1.5H18a.75.75 0 0 1 0-1.5ZM4.72 18.03a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 1 1-1.06 1.06L4.72 19.09a.75.75 0 0 1 0-1.06Zm12.44-12.06a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 1 1-1.06 1.06l-1.06-1.06a.75.75 0 0 1 0-1.06ZM12 18.75a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0V19.5a.75.75 0 0 1 .75-.75Z" />
    </svg>
    <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
      <path d="M21.752 15.002A9.718 9.718 0 0 1 12 21.75c-5.385 0-9.75-4.365-9.75-9.75 0-4.17 2.635-7.72 6.343-9.1a.75.75 0 0 1 .949.969 7.5 7.5 0 0 0 9.24 9.24.75.75 0 0 1 .969.893Z" />
    </svg>
    <span>Modo {{ isDark ? "oscuro" : "claro" }}</span>
  </button>
</template>

<script>
export default {
  name: 'ThemeToggle',
  data() {
    return {
      isDark: false,
    }
  },
  mounted() {
    this.syncFromDom();
  },
  methods: {
    syncFromDom() {
      this.isDark = document.documentElement.classList.contains('dark');
    },
    toggleTheme() {
      const next = !this.isDark;
      document.documentElement.classList.toggle('dark', next);
      try {
        localStorage.setItem('theme', next ? 'dark' : 'light');
      } catch (_) {}
      this.isDark = next;
    },
  },
}
</script>

<style scoped>
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}
</style>

