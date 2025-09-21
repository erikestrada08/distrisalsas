<template>
  <div class="p-1 flex gap-1 w-full items-start flex-col md:flex-row">
    <!-- Panel izquierdo: Carga de factura y opciones -->
    <div class="w-full md:min-w-[380px] md:max-w-[380px] md:w-[380px] flex flex-col gap-1">
      <!-- Cargar factura (opcional) -->
      <div class="flex flex-col gap-1 bg-white p-2 rounded shadow-lg">
        <label
          @dragover.prevent="dragging = true"
          @dragleave.prevent="dragging = false"
          @drop.prevent="handleDrop"
          class="flex flex-col items-center justify-center border-2 border-dashed rounded-md p-6 transition-all cursor-pointer hover:border-blue-400 hover:bg-blue-50"
          :class="dragging ? 'border-blue-400 bg-blue-50' : 'border-gray-300 bg-white'"
          title="Subir foto de la factura para extraer productos"
          for="facturaInput"
        >
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.7" stroke="currentColor" class="size-20 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
          </svg>
          <span class="text-gray-500">Subir factura (opcional)...</span>
        </label>
        <input id="facturaInput" ref="fileInput" type="file" accept="image/*" multiple class="hidden" @change="handleFileChange" />
        <div v-if="images.length" class="flex flex-wrap gap-2">
          <div 
            v-for="(img, i) in images" 
            :key="img.id" 
            class="relative border w-[120px] rounded p-1 hover:shadow group"
          >
            <img :src="img.url" alt="Factura" class="object-cover w-full h-[90px] cursor-pointer" @click="previsualizarAt(i)" />
            <button class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 text-xs opacity-0 group-hover:opacity-100 transition" @click.prevent="removeImage(i)" title="Eliminar">
              ×
            </button>
            <div class="text-center text-[10px] text-gray-500 truncate" :title="img.name">{{ img.name }}</div>
          </div>
        </div>
        <div class="mt-1 text-center text-sm text-gray-600" v-if="loading">Procesando imagen y OCR...</div>
      </div>

      <!-- Parámetros de cálculo -->
      <div class="flex flex-col gap-2 bg-white p-2 rounded shadow-lg">
        <div>
          <label class="block text-sm font-medium text-gray-700">IVA del costo</label>
          <select v-model="ivaModo" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            <option value="incluido">Incluido en el precio</option>
            <option value="mas">Más IVA</option>
          </select>
        </div>
        <div class="flex gap-2">
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">IVA %</label>
            <input type="number" min="0" step="0.01" v-model.number="ivaPorcentaje" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
          </div>
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Utilidad %</label>
            <input type="number" min="0" step="0.01" v-model.number="utilidadPorcentaje" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
          </div>
        </div>
        <div class="text-xs text-gray-500">
          - "Incluido" descuenta IVA del precio unitario para hallar el costo neto.<br />
          - "Más IVA" trata el precio unitario como neto (sin IVA).
        </div>
      </div>
      <vue-easy-lightbox :visible="visible" :imgs="lightboxImgs" :index="index" @hide="visible = false" />
    </div>

    <!-- Panel derecho: Tabla de productos y resultados -->
    <div class="w-full md:flex-1 bg-white p-2 rounded shadow-lg">
      <div class="flex items-center justify-between mb-2">
        <span class="font-semibold">Productos detectados / cargados</span>
        <button @click.prevent="agregarFila" class="py-1 px-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 flex gap-1 items-center" title="Agregar producto manualmente">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Agregar
        </button>
      </div>

      <!-- Solo la tabla hace scroll horizontal -->
      <div class="overflow-x-auto">
        <div class="min-w-[1100px]">
          <DataTable 
            :value="filas" 
            dataKey="_key" 
            size="small" 
            class="cursor-pointer w-full"
            :tableStyle="{ minWidth: '1100px' }"
            editMode="cell" 
            @cell-edit-complete="editarCelda"
          >
          <Column field="nombre" header="Producto" sortable :bodyClass="'text-left'">
            <template #editor="{ data }">
              <select v-model="data._varianteId" @change="onSelectProducto(data)" class="w-full border rounded p-1">
                <option value="" disabled>Seleccionar...</option>
                <option v-for="opt in productosOptions" :key="opt.id" :value="opt.id">{{ opt.label }}</option>
              </select>
            </template>
          </Column>
          <Column field="unidades" header="Unid." sortable :bodyClass="'text-right'" :headerClass="'text-right'">
            <template #body="{ data }"><div class="text-right">{{ data.unidades }}</div></template>
            <template #editor="{ data, field }">
              <input type="number" min="0" step="1" v-model.number="data[field]" class="w-full text-right" />
            </template>
          </Column>
          <Column field="precio_unitario" header="Precio unit." sortable :bodyClass="'text-right'" :headerClass="'text-right'">
            <template #body="{ data }"><div class="text-right">{{ formatoMoneda(data.precio_unitario) }}</div></template>
            <template #editor="{ data, field }">
              <input type="number" min="0" step="0.01" v-model.number="data[field]" class="w-full text-right" />
            </template>
          </Column>

          

            <!-- Calculados -->
          <Column header="Costo neto unit. (sin IVA)" :bodyClass="'text-right'" :headerClass="'text-right'">
            <template #body="{ data }"><div class="text-right">{{ formatoMoneda(costoNetoUnit(data)) }}</div></template>
          </Column>
          <Column header="Sugerido sin IVA" :bodyClass="'text-right'" :headerClass="'text-right'">
            <template #body="{ data }"><div class="text-right">{{ formatoMoneda(precioSugeridoSinIva(data)) }}</div></template>
          </Column>
          <Column header="Sugerido con IVA" :bodyClass="'text-right'" :headerClass="'text-right'">
            <template #body="{ data }"><div class="text-right">{{ formatoMoneda(precioSugeridoConIva(data)) }}</div></template>
          </Column>
          <Column header="Total compra" :bodyClass="'text-right'" :headerClass="'text-right'">
            <template #body="{ data }"><div class="text-right">{{ formatoMoneda(totalCompra(data)) }}</div></template>
          </Column>

            <Column header="Acciones" :bodyClass="'text-center'" :headerClass="'text-center'">
              <template #body="{ data }">
                <div class="flex items-center justify-center">
                  <button 
                    class="text-red-600 hover:text-red-700" 
                    title="Eliminar fila"
                    @click.stop="eliminarFila(data._key)"
                  >
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </template>
            </Column>

          <template #empty>
              <div class="text-center text-gray-500 p-2">Aún no has agregado productos para calcular el precio.</div>
          </template>
          </DataTable>
        </div>
      </div>

      <div class="mt-2 grid grid-cols-2 gap-2">
        <div class="bg-gray-50 border rounded p-2">
          <div class="flex justify-between"><span class="text-gray-600">Unidades:</span><span class="font-semibold">{{ totales.unidades }}</span></div>
          <div class="flex justify-between"><span class="text-gray-600">Subtotal compra (estimado):</span><span class="font-semibold">{{ formatoMoneda(totales.subtotalCompra) }}</span></div>
        </div>
        <div class="bg-gray-50 border rounded p-2">
          <div class="flex justify-between"><span class="text-gray-600">Venta sugerida (sin IVA):</span><span class="font-semibold">{{ formatoMoneda(totales.ventaSinIva) }}</span></div>
          <div class="flex justify-between"><span class="text-gray-600">Venta sugerida (con IVA):</span><span class="font-semibold">{{ formatoMoneda(totales.ventaConIva) }}</span></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import VueEasyLightbox from 'vue-easy-lightbox';

export default {
  components: { DataTable, Column, VueEasyLightbox },
  data() {
    return {
      loading: false,
      images: [], // [{ id, file, url, name }]
      dragging: false,
      ivaModo: 'incluido', // 'incluido' | 'mas'
      ivaPorcentaje: 19,
      utilidadPorcentaje: 30,
      filas: [], // { _key, nombre, unidades, precio_unitario }
      // lightbox
      visible: false,
      index: 0,
      productos: []
    }
  },
  methods: {
    eliminarFila(key) {
      const idx = this.filas.findIndex(f => f._key === key);
      if (idx > -1) this.filas.splice(idx, 1);
    },
    async handleFileChange(event) {
      const selected = Array.from(event.target.files || []);
      if (!selected.length) return;
      const added = this.addFiles(selected);
      await this.extraerFacturasBatch(added);
      // permitir volver a elegir el mismo archivo después
      event.target.value = '';
    },
    async handleDrop(event) {
      this.dragging = false;
      const dropped = Array.from(event.dataTransfer.files || []);
      if (!dropped.length) return;
      const added = this.addFiles(dropped);
      await this.extraerFacturasBatch(added);
    },
    addFiles(list) {
      const allowed = ['image/jpeg', 'image/png', 'image/jpg'];
      const maxMB = 5;
      const valid = list.filter(f => allowed.includes(f.type) && f.size <= maxMB * 1024 * 1024);
      const created = valid.map((file) => {
        const id = `${Date.now()}_${Math.random().toString(36).slice(2, 8)}`;
        return { id, file, url: URL.createObjectURL(file), name: file.name };
      });
      this.images.push(...created);
      return created;
    },
    async extraerFacturasBatch(addedImages) {
      try {
        this.loading = true;
        const form = new FormData();
        addedImages.forEach(img => form.append('facturas[]', img.file));
        const { data: responses } = await axios.post('/extraer-datos-facturas', form);
        const mapped = [];
        (responses || []).forEach((r, i) => {
          const imageId = addedImages[i]?.id;
          const productos = r?.productos || [];
          productos.forEach((p, idx) => {
            mapped.push({
              _key: `${Date.now()}_${imageId}_${idx}`,
              sourceId: imageId,
              nombre: p.nombre ?? '',
              unidades: Number(p.unidades ?? 0),
              precio_unitario: Number(p.precio_unitario ?? 0)
            });
          });
        });
        this.filas.push(...mapped);
        // Ajustar modo de IVA si todas coinciden, si vienen mezcladas lo dejamos como está
        const modos = new Set((responses || [])
          .map(r => typeof r?.iva_incluido === 'boolean' ? (r.iva_incluido ? 'incluido' : 'mas') : null)
          .filter(Boolean));
        if (modos.size === 1) this.ivaModo = [...modos][0];
      } catch (error) {
        console.error('Error OCR batch:', error);
      } finally {
        this.loading = false;
      }
    },

    agregarFila() {
      this.filas.push({ _key: `${Date.now()}`, nombre: '', unidades: 0, precio_unitario: 0, _varianteId: '' });
    },
    editarCelda({ data, newValue, field }) {
      data[field] = isNaN(newValue) ? newValue : Number(newValue);
    },
    previsualizarAt(index) {
      this.index = index;
      this.visible = true;
    },
    removeImage(idx) {
      const img = this.images[idx];
      if (!img) return;
      try { URL.revokeObjectURL(img.url); } catch (e) {}
      const removedId = img.id;
      this.images.splice(idx, 1);
      // eliminar filas asociadas a esta imagen
      this.filas = this.filas.filter(f => f.sourceId !== removedId);
      // ajustar índice del lightbox si aplica
      if (this.index >= this.images.length) this.index = Math.max(0, this.images.length - 1);
    },
    formatoMoneda(valor) {
      const num = Number(valor ?? 0);
      return num.toLocaleString('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 });
    },
    onSelectProducto(row) {
      const sel = row && row._varianteId;
      if (!sel) return;
      const opt = (this.productos || []).find(p => String(p.id) === String(sel));
      if (opt) {
        row.id = opt.id;
        row.nombre = opt.label;
      }
    },
    costoNetoUnit(row) {
      const iva = this.ivaPorcentaje / 100;
      if (this.ivaModo === 'incluido') {
        return Number(row.precio_unitario || 0) / (1 + iva);
      }
      return Number(row.precio_unitario || 0);
    },
    precioSugeridoSinIva(row) {
      const utilidad = this.utilidadPorcentaje / 100;
      const base = this.costoNetoUnit(row);
      return base * (1 + utilidad);
    },
    precioSugeridoConIva(row) {
      const iva = this.ivaPorcentaje / 100;
      return this.precioSugeridoSinIva(row) * (1 + iva);
    },
    totalCompra(row) {
      const unit = this.costoNetoUnit(row);
      return unit * Number(row.unidades || 0);
    }
  },
  computed: {
    totales() {
      const iva = this.ivaPorcentaje / 100;
      const utilidad = this.utilidadPorcentaje / 100;
      return this.filas.reduce(
        (acc, r) => {
          const neto = this.costoNetoUnit(r);
          const ventaSinIva = neto * (1 + utilidad) * Number(r.unidades || 0);
          const ventaConIva = ventaSinIva * (1 + iva);
          acc.unidades += Number(r.unidades || 0);
          acc.subtotalCompra += neto * Number(r.unidades || 0);
          acc.ventaSinIva += ventaSinIva;
          acc.ventaConIva += ventaConIva;
          return acc;
        },
        { unidades: 0, subtotalCompra: 0, ventaSinIva: 0, ventaConIva: 0 }
      );
    },
    lightboxImgs() {
      return this.images.map(img => img.url);
    },
    productosOptions() {
      return this.productos || [];
    }
  },
  created() {
    (async () => {
      try {
        const { data: { data: productos } } = await axios.get('/producto/listar');
        const listaVariantes = [];
        productos?.forEach(({ producto, variantes }) => {
          variantes?.forEach(({ id: varianteId, atributos_json }) => {
            const attrs = atributos_json ? Object.values(JSON.parse(atributos_json)).join(' ') : '';
            listaVariantes.push({ id: varianteId, label: `${producto} - ${attrs}`.trim() });
          });
        });
        this.productos = listaVariantes;
      } catch (error) { console.error(error); }
    })();
  }
}
</script>

<style scoped>
.hidden { display: none; }
</style>
