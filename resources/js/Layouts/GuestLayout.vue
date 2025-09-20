<template>
    <Head title="Inicio" />
    <div
        id="contenedor-principal-welcome"
        class="grid min-h-dvh max-h-dvh grid-rows-[auto_1fr_auto]"
    >
        <!-- encabezado -->
        <header class="shadow-md relative">
            <!-- logo -->
            <img
                src="/imagenes/logo.png"
                alt="Logo de distrisalsas"
                class="absolute left-1 top-2 z-10 h-16 w-auto object-contain"
            />

            <!-- redes sociales -->
            <div class="relative bg-yellow-500 flex justify-end gap-1 p-1">
                <span
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
                    >¡Contactanos!</span
                >

                <a
                :href="`mailto:${contacto.email}`"
                target="_blank"
                class="text-xl"
                >
                    <i class="fa-regular fa-envelope"></i>
                </a>

                <a :href="contacto.instagram" target="_blank" class="text-xl">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a :href="contacto.facebook" target="_blank" class="text-xl">
                    <i class="fa-brands fa-square-facebook"></i>
                </a>

                <a
                :href="`https://wa.me/${+573226892892}`"
                target="_blank"
                class="text-xl"
                >
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
            </div>

            <!-- navegacion -->
            <nav class="relative bg-red-500 flex justify-center gap-1 p-2">
                <Link
                    :href="route('inicio')"
                    class="text-white font-normal hover:font-bold hover:text-white px-1"
                    >Inicio</Link
                >
                <Link
                    :href="route('catalogo')"
                    class="text-white font-normal hover:font-bold hover:text-white px-1"
                    >Productos</Link
                >
                <Link
                    :href="route('nosotros')"
                    class="text-white font-normal hover:font-bold hover:text-white px-1"
                    >Sobre Nosotros</Link
                >
                <Link
                href="#"
                class="text-white font-normal hover:font-bold hover:text-white px-1"
                >
                    Contacto
                </Link>
                <Link href="#" class="text-white font-normal relative px-1">
                    <span
                        class="absolute top-0 right-0 transform -translate-y-1/2 translate-x-1/2 bg-red-500 text-white text-xs font-semibold rounded-lg px-1 py-0.5 flex items-center justify-center border border-white"
                    >
                        {{ this.$store.getters.obtenerCarrito.length }}
                    </span>
                    <i class="fa-solid fa-cart-shopping"></i>
                </Link>
                <Link
                :href="route('login')"
                title="Iniciar Sesión"
                class="absolute right-2 top-1/2 -translate-y-1/2 cursor-pointer z-20"
                >
                    <i
                        class="fa-solid fa-right-to-bracket text-xl text-white"
                    ></i>
                </Link>
            </nav>
        </header>

        <!-- aqui se renderiza el resto -->
        <main class="overflow-y-auto">
            <slot />
        </main>

        <footer class="text-center">
            &copy; 2025 Distrisalsas del Eje. Todos los derechos reservados.d
        </footer>
    </div>
</template>
<script>
import { Head, Link } from "@inertiajs/vue3";

export default {
    data() {
        return {
            contacto: {
                email: "distrisalsasdeleje@gmail.com",
                telefono: "+573226892892",
                instagram:
                    "https://www.instagram.com/distrisalsasdeleje?utm_source=qr&igsh=MXA5bTRua213ZmRpeA==",
                facebook: "https://www.facebook.com/share/1WvWS4ijvc/",
            },
        };
    },
    components: {
        Head,
        Link,
    },
    props: {},
    methods: {},
};
</script>
<style scoped></style>
