// PrimeVue theming helpers aligned with Tailwind CSS tokens
// Usage: import { datatablePt, datatableEditorsCSS } from '@/utils/themePrimevue';

export function datatablePt() {
  return {
    root: { class: 'bg-transparent text-foreground' },
    table: { class: 'bg-card text-foreground border border-border' },
    header: { class: 'bg-card text-foreground border-b border-border' },
    thead: { class: 'bg-card' },
    tbody: { class: 'bg-card' },
    tfoot: { class: 'bg-card' },
    column: {
      headercell: { class: 'bg-card text-foreground border-border' },
      bodycell: { class: 'bg-card text-foreground border-border' },
      footercell: { class: 'bg-card text-foreground border-border' },
    },
    row: { class: 'bg-card text-foreground border-border' },
    emptyMessage: { class: 'text-gray-500' },
  };
}

// Returns CSS string to inject with <style scoped> using :deep()
export function datatableEditorsCSS() {
  return `
:deep(.p-datatable){background:transparent}
:deep(.p-datatable .p-datatable-thead>tr>th){@apply bg-card text-foreground border-border}
:deep(.p-datatable .p-datatable-tbody>tr>td){@apply bg-card text-foreground border-border}
:deep(.p-datatable .p-datatable-tbody input),
:deep(.p-datatable .p-datatable-tbody select),
:deep(.p-datatable .p-datatable-tbody textarea){@apply bg-background text-foreground border-border rounded-md}
:deep(.p-datatable .p-datatable-tbody input::placeholder),
:deep(.p-datatable .p-datatable-tbody textarea::placeholder){@apply text-gray-500}
`;
}


