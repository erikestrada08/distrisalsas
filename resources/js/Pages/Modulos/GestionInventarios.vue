<template>
    <Head title="Inventarios" />
    <div class="p-2">
fdf
        <SubModulos
        :modulo="modulo"
        @renderizarSubModulo="renderizar"
        />
        <keep-alive>
            <Transition
            enter-active-class="transition-all duration-300 transform"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            >
                <component :is="componenteActual" />
            </Transition>
        </keep-alive>

    </div>
</template>
<script>
import { Head } from '@inertiajs/vue3';
import SubModulos from '@/Layouts/SubModulos.vue';
import { defineAsyncComponent } from 'vue';


export default {
    components:{
        Head,
        SubModulos
    },
    data(){
        return {
            modulo: 2,
            nombreComponente: null
        }
    },
    computed: {
        componenteActual() {
            if (!this.nombreComponente) return null;

            return defineAsyncComponent(() =>
                import(`./subModulos/${this.nombreComponente}.vue`)
            );
        }
    },
    methods:{
        renderizar(_subModulo){
            this.nombreComponente = _subModulo?.componente;
        },

    }
}
</script>
