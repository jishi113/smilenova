@extends('layouts.admin')

@section('title', 'Create Invoice')

@section('content')
<div class="space-y-6" x-data="invoiceForm()">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.billing.invoices.index') }}" class="p-2 rounded-lg hover:bg-slate-100">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Create Invoice</h2>
            <p class="text-sm text-slate-500">Generate a new invoice for a patient</p>
        </div>
    </div>

    <form action="{{ route('admin.billing.invoices.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT: Patient & Items --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Patient Info --}}
                <div class="card">
                    <h3 class="font-semibold text-slate-800 mb-4">Patient Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Patient <span class="text-red-500">*</span></label>
                            <select name="patient_id" required class="form-input">
                                <option value="">Select patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->full_name }} ({{ $patient->patient_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Linked Appointment (optional)</label>
                            <select name="appointment_id" class="form-input">
                                <option value="">None</option>
                                @foreach($appointments as $appt)
                                    <option value="{{ $appt->id }}" {{ old('appointment_id') == $appt->id ? 'selected' : '' }}>
                                        #{{ $appt->id }} — {{ $appt->patient->full_name ?? '' }} — {{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Items --}}
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-800">Invoice Items</h3>
                        <button type="button" @click="addItem" class="btn btn-secondary btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add Item
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="grid grid-cols-12 gap-2 items-start bg-slate-50 p-3 rounded-lg">
                                <div class="col-span-4">
                                    <select x-model="item.service_id" @change="onServiceChange(index)" :name="`items[${index}][service_id]`" class="form-input text-sm">
                                        <option value="">Custom item</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" data-name="{{ $service->name }}" data-price="{{ $service->price }}">
                                                {{ $service->name }} (₹{{ $service->price }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-4">
                                    <input type="text" x-model="item.description" :name="`items[${index}][description]`" placeholder="Description" required class="form-input text-sm">
                                </div>
                                <div class="col-span-1">
                                    <input type="number" x-model="item.quantity" @input="calcTotal" :name="`items[${index}][quantity]`" min="1" placeholder="Qty" required class="form-input text-sm">
                                </div>
                                <div class="col-span-2">
                                    <input type="number" x-model="item.unit_price" @input="calcTotal" :name="`items[${index}][unit_price]`" min="0" step="0.01" placeholder="Price" required class="form-input text-sm">
                                </div>
                                <div class="col-span-1 flex items-center justify-end">
                                    <button type="button" @click="removeItem(index)" class="p-1.5 text-red-600 hover:bg-red-50 rounded" x-show="items.length > 1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Summary --}}
            <div class="lg:col-span-1">
                <div class="card sticky top-4">
                    <h3 class="font-semibold text-slate-800 mb-4">Summary</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Subtotal</span>
                            <span class="font-medium">₹<span x-text="subtotal.toFixed(2)">0.00</span></span>
                        </div>
                        <div class="flex justify-between items-center gap-2">
                            <span class="text-slate-600">Discount</span>
                            <input type="number" name="discount" x-model.number="discount" @input="calcTotal" min="0" step="0.01" value="0" class="form-input w-24 text-right text-sm py-1">
                        </div>
                        <div class="flex justify-between items-center gap-2">
                            <span class="text-slate-600">GST %</span>
                            <input type="number" name="tax_rate" x-model.number="taxRate" @input="calcTotal" min="0" max="100" step="0.01" value="18" class="form-input w-24 text-right text-sm py-1">
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Tax</span>
                            <span class="font-medium">₹<span x-text="taxAmount.toFixed(2)">0.00</span></span>
                        </div>
                        <div class="border-t border-slate-200 pt-3 flex justify-between">
                            <span class="font-semibold text-slate-800">Total</span>
                            <span class="font-bold text-lg text-primary-600">₹<span x-text="total.toFixed(2)">0.00</span></span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-100 space-y-3">
                        <div>
                            <label class="form-label text-xs">Due Date</label>
                            <input type="date" name="due_date" value="{{ now()->addDays(15)->format('Y-m-d') }}" class="form-input text-sm">
                        </div>
                        <div>
                            <label class="form-label text-xs">Notes</label>
                            <textarea name="notes" rows="2" class="form-input text-sm" placeholder="Optional notes..."></textarea>
                        </div>
                    </div>

                    <div class="mt-6 space-y-2">
                        <button type="submit" class="btn btn-primary w-full justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Create Invoice
                        </button>
                        <a href="{{ route('admin.billing.invoices.index') }}" class="btn btn-secondary w-full justify-center">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function invoiceForm() {
    return {
        items: [{ service_id: '', description: '', quantity: 1, unit_price: 0 }],
        discount: 0,
        taxRate: 18,
        subtotal: 0,
        taxAmount: 0,
        total: 0,

        addItem() {
            this.items.push({ service_id: '', description: '', quantity: 1, unit_price: 0 });
            this.calcTotal();
        },

        removeItem(index) {
            this.items.splice(index, 1);
            this.calcTotal();
        },

        onServiceChange(index) {
            const select = event.target;
            const option = select.options[select.selectedIndex];
            if (option.value) {
                this.items[index].description = option.dataset.name;
                this.items[index].unit_price = parseFloat(option.dataset.price) || 0;
            }
            this.calcTotal();
        },

        calcTotal() {
            this.subtotal = this.items.reduce((sum, item) => {
                return sum + (parseFloat(item.quantity || 0) * parseFloat(item.unit_price || 0));
            }, 0);

            const taxable = this.subtotal - parseFloat(this.discount || 0);
            this.taxAmount = taxable * (parseFloat(this.taxRate || 0) / 100);
            this.total = taxable + this.taxAmount;
        }
    }
}
</script>
@endsection