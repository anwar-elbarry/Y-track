<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice #{{ $invoice->id }}</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }
    
    body {
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      padding: 20px;
    }
    
    .invoice-container {
      width: 100%;
      max-width: 800px;
      background-color: white;
      border: 1px solid #ddd;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    .invoice-header {
      background-color: #FF6600;
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .invoice-title {
      font-size: 2.5rem;
      font-weight: bold;
    }
    
    .invoice-number {
      font-size: 0.9rem;
      margin-top: 5px;
    }
    
    .draft-badge {
      background-color: white;
      color: #FF6600;
      padding: 5px 15px;
      border-radius: 5px;
      font-weight: bold;
    }
    
    .invoice-body {
      padding: 20px;
    }
    
    .invoice-info {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }
    
    .invoice-from, .invoice-to, .invoice-dates {
      flex: 1;
    }
    
    .info-label {
      color: #667085;
      font-size: 0.8rem;
      margin-bottom: 8px;
    }
    
    .info-value {
      font-weight: bold;
      margin-bottom: 5px;
    }
    
    .date-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
    }
    
    .date-label {
      color: #667085;
    }
    
    .amount-due {
      color: #FF6600;
      font-weight: bold;
      text-align: right;
    }
    
    .invoice-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }
    
    .invoice-table th {
      background-color: #f9fafb;
      text-align: left;
      padding: 12px 15px;
      color: #667085;
      font-weight: normal;
      border-bottom: 1px solid #eee;
    }
    
    .invoice-table td {
      padding: 15px;
      border-bottom: 1px solid #eee;
    }
    
    .table-price, .table-amount {
      text-align: right;
    }
    
    .table-amount {
      font-weight: bold;
    }
    
    .invoice-total {
      display: flex;
      justify-content: flex-end;
      padding: 15px;
      align-items: center;
    }
    
    .total-label {
      margin-right: 50px;
      font-weight: bold;
    }
    
    .total-amount {
      color: #FF6600;
      font-weight: bold;
      font-size: 1.1rem;
    }
    
    .invoice-footer {
        display: flex;
        justify-content: space-evenly;
      padding: 20px;
      border-top: 1px solid #eee;
    }
    
    .footer-section {
      margin-bottom: 20px;
    }
    
    .footer-label {
      color: #667085;
      margin-bottom: 8px;
      font-weight: bold;
    }
    
    .footer-text {
      color: #4b5563;
    }
    
    .thank-you {
      text-align: center;
      color: #4f46e5;
      margin-top: 30px;
      padding-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="invoice-container">
    <div class="invoice-header">
      <div>
        <div class="invoice-title">INVOICE</div>
        <div class="invoice-number">Invoice #INV-{{ $invoice->id }}</div>
      </div>
      <div class="draft-badge">{{ $invoice->status ?? 'UNPAID' }}</div>
    </div>
    
    <div class="invoice-body">
      <div class="invoice-info">
        <div class="invoice-from">
          <div class="info-label">FROM</div>
          <div class="info-value">{{ $invoice->from->company ?? $user->name }}</div>
          <p>{{ $invoice->from->email ?? $user->email }}</p>
        </div>
        
        <div class="invoice-to">
          <div class="info-label">BILL TO</div>
          <div class="info-value">{{ $invoice->to->name ?? $client->name }}</div>
          <p>{{ $invoice->to->email ?? $client->email }}</p>
        </div>
        
        <div class="invoice-dates">
          <div class="date-row">
            <div class="date-label">INVOICE DATE</div>
            <div>{{ $invoice->date ? \Carbon\Carbon::parse($invoice->date)->format('M d, Y') : $invoice->created_at->format('M d, Y') }}</div>
          </div>
          <div class="date-row">
            <div class="date-label">DUE DATE</div>
            <div>{{ $invoice->dueDate ? \Carbon\Carbon::parse($invoice->dueDate)->format('M d, Y') : \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</div>
          </div>
          <div class="date-row">
            <div class="date-label">AMOUNT DUE</div>
            <div class="amount-due">{{ $invoice->currency ?? $user->currency }} {{ number_format($invoice->service_price, 2) }}</div>
          </div>
        </div>
      </div>
      
      <table class="invoice-table">
        <thead>
          <tr>
            <th>SERVICE NAME</th>
            <th>SERVICE DESCRIPTION</th>
            <th class="table-price">SERVICE PRICE</th>
            <th class="table-amount">AMOUNT</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $invoice->service_name }}</td>
            <td>{{ $invoice->service_description }}</td>
            <td class="table-price">{{ $invoice->currency ?? $user->currency }} {{ number_format($invoice->service_price, 2) }}</td>
            <td class="table-amount">{{ $invoice->currency ?? $user->currency }} {{ number_format($invoice->service_price, 2) }}</td>
          </tr>
        </tbody>
      </table>
      
      <div class="invoice-total">
        <div class="total-label">TOTAL:</div>
        <div class="total-amount">{{ $invoice->currency ?? $user->currency }} {{ number_format($invoice->service_price, 2) }}</div>
      </div>
    </div>
    
    <div class="invoice-footer">
      <div class="footer-section">
        <div class="footer-label">NOTES</div>
        <div class="footer-text">{{ $invoice->notes ?: 'No additional notes' }}</div>
      </div>
      
      <div class="footer-section">
        <div class="footer-label">TERMS & CONDITIONS</div>
        <div class="footer-text">{{ $invoice->terms ?: 'Payment due within 30 days' }}</div>
      </div>
      
      <div class="thank-you">Thank you for your business!</div>
    </div>
  </div>
</body>
</html>