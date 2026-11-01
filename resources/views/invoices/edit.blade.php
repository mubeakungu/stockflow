@extends('layouts.layout')
@section('title','Create a new invoice.')

@push('css')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush


@section('main')
<form method="POST" action="{{ route('invoices.update',$invoice->id) }}" x-data="{
    total_invoice: {{ $invoice->total }},
    previously_paid: {{ $invoice->total - $invoice->due }},
    current_due: {{ $invoice->due }},
    additional_payment: 0,
    setStatus: function(){
        let total_paid = this.previously_paid + this.additional_payment;
        let new_remaining_due = this.total_invoice - total_paid;
        
        // Update hidden field with new due amount
        this.$refs.hidden_due.value = new_remaining_due;
        
        // Set status based on new remaining due
        if(new_remaining_due == 0){
            this.$refs.status.value = 'paid';
        }else if(new_remaining_due == this.total_invoice){
            this.$refs.status.value = 'due';
        }else if(new_remaining_due > 0 && new_remaining_due < this.total_invoice){
            this.$refs.status.value = 'partial';
        }
    }   
}">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h5>Create Invoice</h5>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label for="total">Total Invoice Amount<small class="text-info">[Ksh]</small></label>
                        <input type="number" class="form-control" id="total" x-model.number="total_invoice" readonly style="background-color: #e8f4f8;">
                    </div>

                    <div class="form-group">
                        <label for="previously_paid">Previously Paid<small class="text-info">[Ksh]</small></label>
                        <input type="number" class="form-control" id="previously_paid" x-model.number="previously_paid" readonly style="background-color: #e8f4f8;">
                    </div>

                    <div class="form-group">
                        <label for="current_due">Current Remaining Due<small class="text-info">[Ksh]</small></label>
                        <input type="number" class="form-control" id="current_due" x-model.number="current_due" readonly style="background-color: #e8f4f8;">
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="additional_payment">Additional Payment Now <small class="text-info text-danger">[Enter amount to add]</small></label>
                        <input type="number" class="form-control" id="additional_payment" x-model.number="additional_payment" placeholder="Enter additional payment amount"
                            x-on:input="setStatus()" x-on:blur="setStatus()" min="0">
                    </div>

                    <div class="form-group">
                        <label for="total_paid">New Total Paid<small class="text-info">[Ksh]</small></label>
                        <input type="number" class="form-control" id="total_paid" 
                            x-model.number="previously_paid + additional_payment" readonly style="background-color: #d4edda; font-weight: bold;">
                    </div>

                    <div class="form-group">
                        <label for="new_due">New Remaining Due<small class="text-info">[Ksh]</small></label>
                        <input type="number" class="form-control" id="new_due" 
                            x-model.number="total_invoice - (previously_paid + additional_payment)" readonly style="background-color: #d4edda; font-weight: bold;">
                    </div>

                    <input type="hidden" name="due_amount" x-ref="hidden_due" :value="total_invoice - (previously_paid + additional_payment)">

                    <div class="form-group">
                        <label for="status">Payment Status<small class="text-info">[Auto-calculated]</small></label>
                        <select name="status" id="status" x-ref="status" class="form-control" readonly style="font-weight: bold;">
                            <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>✓ Paid</option>
                            <option value="partial" {{ $invoice->status == 'partial' ? 'selected' : '' }}>⊕ Partial</option>
                            <option value="due" {{ $invoice->status == 'due' ? 'selected' : '' }}>✗ Due</option>
                        </select>
                    </div>

                    <button type="submit" class="btn  btn-primary show btn-block">Adjust Invoice</button>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h5>Products Details</h5>
                </div>
                <div class="card-body">
                    <table>
                        <tbody>
                            <tr>
                                <th>Invoice NO:</th>
                                <td>{{ $invoice->invoice_no }}</td>
                            </tr>
                            <tr>
                                <th>Customer Name:</th>
                                <td>{{ $invoice->customer->name }}</td>
                            </tr>
                            <tr>
                                <th>Total Amount:</th>
                                <td>@ksh($invoice->total)</td>
                            </tr>
                            <tr>
                                <th>Paid:</th>
                                <td>@ksh($invoice->total - $invoice->due)</td>
                            </tr>

                            <tr>
                                <th>Due:</th>
                                <td>@ksh($invoice->due)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
@endpush