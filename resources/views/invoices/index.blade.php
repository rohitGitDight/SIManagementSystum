<!-- resources/views/invoices/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Invoice List</h1>

    <!-- Table to display invoices -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>User ID</th>
                <th>Course ID</th>
                <th>Amount</th>
                <th>Payment Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->user->name }}</td>
                    <td>{{ $invoice->course->name_of_course }}</td>
                    <td>{{ json_decode($invoice->payment_details)->amount }}</td>
                    <td>{{ json_decode($invoice->payment_details)->transaction_type }}</td>
                    <td>
                        <button class="btn btn-success" onclick="printInvoice({{ $invoice->id }})">Print</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Invoice Print Preview -->
<div id="invoiceModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Invoice #<span id="invoiceId"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="invoiceDetails"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
      </div>
    </div>
  </div>
</div>

<script>
    function printInvoice(invoiceId) {
        // Fetch the invoice details using AJAX
        fetch(`/invoices/${invoiceId}`)
            .then(response => response.json())
            .then(data => {
                // Fill the modal with the invoice details
                document.getElementById('invoiceId').innerText = data.invoice.id;
                const paymentDetails = JSON.parse(data.invoice.payment_details);
                
                // Use user_name and course_name from the response
                let invoiceContent = `
                    <p><strong>User Name:</strong> ${data.user_name}</p>
                    <p><strong>Course Name:</strong> ${data.course_name}</p>
                    <p><strong>Amount:</strong> ${paymentDetails.amount}</p>
                    <p><strong>Payment Type:</strong> ${paymentDetails.transaction_type}</p>
                    <p><strong>Cash Received By:</strong> ${paymentDetails.cash_received_by}</p>
                    <p><strong>Cheque Number:</strong> ${paymentDetails.cheque_number || 'N/A'}</p>
                    <p><strong>Transaction Report:</strong> ${paymentDetails.transaction_report || 'N/A'}</p>
                `;
                document.getElementById('invoiceDetails').innerHTML = invoiceContent;
                
                // Show the modal
                $('#invoiceModal').modal('show');
            })
            .catch(error => {
                console.error('Error fetching invoice data:', error);
            });
    }
</script>


@endsection
