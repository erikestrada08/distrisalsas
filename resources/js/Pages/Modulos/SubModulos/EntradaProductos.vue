<template>
    <div class="p-1 flex gap-1 w-full items-start">
        <div class="min-w-[400px] max-w-[400px] w-[400px] flex flex-col gap-1">
            <div class="flex flex-col gap-1 bg-white p-2 rounded shadow-lg">
                <label
                @dragover.prevent="dragging = true"
                @dragleave.prevent="dragging = false"
                @drop.prevent="handleDrop"
                @click="openFileDialog"
                class="flex flex-col items-center justify-center border-2 border-dashed rounded-md p-6 transition-all cursor-pointer hover:border-blue-400 hover:bg-blue-50"
                :class="dragging ? 'border-blue-400 bg-blue-50' : 'border-gray-300 bg-white'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.7" stroke="currentColor" class="size-20 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                    </svg>
                    <span class="text-gray-500">Subir factura...</span>    
                    <input
                    ref="fileInput"
                    type="file"
                    accept="image/*"
                    class="sr-only"
                    @change="handleFileChange"
                    />
                </label>
                <div v-if="file" class="border w-[150px] rounded p-1 cursor-pointer hover:shadow" :title="file.name">
                    <img :src="previsualizar(file)" alt="Imagen factura...">
                    <div class="flex items-center">
                        <span class="w-full truncate text-xs text-gray-500 text-center block">
                            {{ file.name }}
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor" class="size-6 hover:text-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-1 bg-white p-2 rounded shadow-lg">
                <div>
                    <label for="producto" class="block text-sm font-medium text-gray-700">Producto</label>
                    <select
                    v-model="item.nombre"
                    id="producto" 
                    name="producto" 
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="Seleccione...">
                    </select>
                </div>
                <div>
                    <label for="unidades" class="block text-sm font-medium text-gray-700">unidades</label>
                    <input 
                    v-model="item.unidades"
                    type="number" 
                    id="unidades" 
                    name="unidades" 
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="0">
                </div>
                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                    <input 
                    v-model="item.precio_unitario"
                    type="number" 
                    id="precio" 
                    name="precio" 
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="0">
                </div>
                <div class="flex justify-end pt-1">
                    <button
                    @click.prevent="agregarItem"
                    class="py-1 px-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 flex gap-1 items-center"
                    title="Agregar producto a la factura"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Agregar
                    </button>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-white p-2 rounded shadow-lg">
            <span>Factura</span>
            <ul class="flex flex-col gap-1 p-2 bg-white">
                <li>
                    <span class="font-bold">Proveedor:</span>
                    {{ datosFactura?.proveedor }}
                </li>
                <li>
                    <span class="font-bold">Nit:</span>
                    {{ datosFactura?.nit_proveedor }}
                </li>
                <li>
                    <span class="font-bold">Fecha:</span>
                    {{ datosFactura?.fecha_emision }}
                </li>
            </ul>
            <DataTable 
            :value="detallesFactura" 
            dataKey="id" 
            tableStyle="min-width: 50rem"
            size="small"
            class="cursor-pointer"
            selectionMode="single"
            removableSort
            editMode="cell"
            @cell-edit-complete="editarCelda"
            >
                <template #empty>
                    <div class="text-center text-gray-500 p-2">No hay detalles disponibles</div>
                </template>
                <Column field="id" header="Id" sortable/>
                <Column field="nombre" header="Producto" class="text-nowrap" sortable>
                    <template #body="slotProps">
                        {{ slotProps.data.nombre.toUpperCase() }}
                    </template>
                    <template #editor="{ data, field }">
                        <input type="text" v-model="data[field]" class="w-full">
                    </template>
                </Column>
                <Column field="unidades" header="Unidades" sortable>
                    <template #editor="{ data, field }">
                        <input type="text" v-model="data[field]" class="w-full">
                    </template>
                </Column>
                <Column field="precio_unitario" header="Precio" sortable>
                    <template #body="slotProps">
                        {{ formatoMoneda(slotProps.data.precio_unitario) }}
                    </template>
                    <template #editor="{ data, field }">
                        <input type="text" v-model="data[field]" class="w-full">
                    </template>
                </Column>
                <Column field="precio_total" header="Total" sortable>
                    <template #body="slotProps">
                        {{ formatoMoneda(slotProps.data.precio_total) }}
                    </template>
                    <template #editor="{ data, field }">
                        <input type="text" v-model="data[field]" class="w-full">
                    </template>
                </Column>
                <ColumnGroup type="footer" v-if="!!detallesFactura.length">
                    <Row>
                        <Column colspan="3" />
                        <Column footer="TOTAL" />
                        <Column :footer="formatoMoneda(totales?.subtotal)" />
                    </Row>
                    <!-- <Row>
                        <Column colspan="4" footerStyle="text-align:right"/>
                        <Column footer="Iva"/>
                        <Column :footer="formatoMoneda(datosFactura?.iva)"/>
                    </Row>
                    <Row>
                        <Column colspan="4" footerStyle="text-align:right"/>
                        <Column footer="Total"/>
                        <Column :footer="formatoMoneda(
                            !datosFactura?.iva_incluido 
                                ? totales?.subtotal + parseFloat(datosFactura?.iva)
                                : totales?.subtotal
                        )"/>
                    </Row> -->
                </ColumnGroup>
            </DataTable>
            <div class="bg-white text-end p-2">
                <button @click.prevent="guardarEntradaProducto" class="p-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">Guardar</button>
            </div>
            <div class="mt-4 text-center text-sm text-gray-600" v-if="loading">Procesando imagen y OCR...</div>
            <pre v-if="datosFactura" class="mt-4 p-2 bg-green-50 border rounded text-sm whitespace-pre-wrap text-green-800">{{ datosFactura }}</pre>
        </div>
    </div>
</template>

<script>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Row from 'primevue/row';

export default {
    name: 'FacturaPreprocesamiento',
    components:{
        DataTable,
        Column,
        ColumnGroup,
        Row
    },
    data() {
        return {
            loading: false,
            ocrText: null,
            datosFactura: null,
            detallesFactura: [],
            file: null,
            dragging: false,
            item: {
                nombre: null,
                unidades: null,
                precio_unitario: null
            },
            productos: []
        }
    },
    methods: {
        async handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.file = file;
                const factura = new FormData();
                factura.append('factura', this.file);
                this.extrearDatosFactura(factura);
            }
        },
        async handleDrop(event) {
            this.dragging = false;
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                this.file = files[0];
                const factura = new FormData();
                factura.append('factura', this.file);
                this.extrearDatosFactura(factura);
            }
        },
        openFileDialog() {
            this.$refs.fileInput.click();
        },
        async extrearDatosFactura(imagen) {
            try {
                this.loading = true;
                const { data: response } = await axios.post('/extraer-datos-factura',imagen);
                this.datosFactura = response;
                this.detallesFactura = this.datosFactura.productos;
            } catch (error) {
                console.error('Error al consultar GPT:', error);
            } finally {
                this.loading = false;
            }
        },
        formatoMoneda(valor) {
            return valor ? valor.toLocaleString('en-US', { style: 'currency', currency: 'COP' }) : null;
        },
        agregarItem(){
            const { nombre: id, ...rest } = this.item;
            const nombre = this.productos.find(({id}) => id == this.item.nombre)?.producto;
            const precio_total = parseFloat(rest.unidades) * parseFloat(rest.precio_unitario);
            this.detallesFactura.push({ id, nombre, precio_total, ...rest });
            Object.keys(this.item).forEach(prop => this.item[prop] = null);
        },
        editarCelda(event) {
            const { data, newValue, field } = event;
            data[field] = isNaN(newValue) ? newValue : Number(newValue);
        },
        previsualizar(img){
            if (!img) return;
            return URL.createObjectURL(img);
        },
        async guardarEntradaProducto(){
            try {
                const { data: response } = await axios.post('/entrada-producto/crear',this.detallesFactura);
                console.log(response);
                // limpiar datos
                Object.keys(this.item).forEach(key => this.item[key]=null);
                this.detallesFactura = [];
            } catch (error) {
                console.error('Error al consultar GPT:', error);
            } finally {
                this.loading = false;
            }
        }
    },
    computed: {
        totales() {
            return this.detallesFactura?.reduce((acc, detalle) => {
                acc.cajas += parseFloat(detalle.cajas || 0);
                acc.unidades += parseFloat(detalle.unidades || 0);
                acc.subtotal += parseFloat(detalle.precio_total || 0);
                return acc;
            }, {
                cajas: 0,
                unidades: 0,
                subtotal: 0
            });
        },
    },
    created() {
        (async () => { // obtener productos
            const { data: { data: productos } } = await axios.get('/producto/listar');
            // this.productos = productos;
            const listaVariantes = [];
            const opciones = productos.map( ({producto, variantes}) => {
                if(variantes.length) {
                    return variantes.map( ({id: varianteId, atributos_json}) => {
                        const atributos = Object.values(JSON.parse(atributos_json)).join(" ");
                        listaVariantes.push({ id: varianteId, producto: `${producto} - ${atributos}` });
                        return `<option value="${varianteId}">${producto} - ${atributos}</option>`;
                    }).join("");
                }
            } );
            this.productos = listaVariantes;
            opciones.unshift('<option selected>Seleccionar...</option>');
            document.querySelector('#producto').innerHTML = opciones.join("");
        })();
    },
}

</script>

<style scoped>
.hidden {
    display: none;
}
</style>
