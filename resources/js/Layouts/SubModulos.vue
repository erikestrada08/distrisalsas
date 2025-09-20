<template>


    <div class="flex gap-1">
        <div
        v-for="submodulo in subModulos"
        :key="submodulo.id"
        class="bg-white rounded-md shadow flex p-2 cursor-pointer border hover:border-cyan-500"
        :title="submodulo.descripcion"
        @click="renderizar(submodulo)"
        >
            <div class="basis-1/3 flex-shrink-0 flex items-center justify-center">
                <div class="bg-cyan-500 text-white font-bold text-2xl rounded-full w-[40px] h-[40px] flex items-center justify-center">{{ submodulo.abreviatura }}</div>
            </div>

            <div class="basis-2/3 flex-shrink-0 flex items-center justify-center leading-none">
                {{ submodulo.sub_modulo }}
            </div>
        </div>
    </div>

</template>
<script>
export default {
    props:{
        modulo: null
    },
    data(){
        return {
            subModulos: []
        }
    },
    methods: {
        async obtenerSubModulos(){
            if (this.modulo) {
                try {
                    const { data: { data: RESPONSE } } = await axios.get('submodulo/listar', {
                        params: {
                            modulo: this.modulo
                        }
                    });
                    this.subModulos = RESPONSE;
                } catch (error) {
                    console.error(error);
                    
                }
            }
        },
        renderizar(_subModulo){
            this.$emit('renderizarSubModulo', _subModulo);
        }
    }
}
</script>