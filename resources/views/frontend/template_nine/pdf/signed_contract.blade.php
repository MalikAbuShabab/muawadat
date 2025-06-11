<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid Agreement</title>
    <style>
        /* Set the page size to A4 and make sure it's formatted for print */
        @page {
            size: A4;
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            line-height: 1.6;
        }
        h1, h6 {
            color: #015158;
            margin-bottom: 10px;
        }
        p {
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
            page-break-before: always; /* Add page break before images */
        }
        .content-wrapper {
            width: 100%;
            padding: 0 10mm;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <h1>Bid Agreement</h1>
        <div class="modal-body">
            <h6>Binding Commitment</h6>
            <p>The bidder understands that submitting a bid constitutes a legally binding offer to purchase the item or service at the specified bid amount.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

            <h6>Bid Rejection & Withdrawal</h6>
            <p>The bid may be accepted or rejected at the discretion of the seller. Once submitted, bids cannot be withdrawn without prior approval.</p>

            <h6>Payment Obligation</h6>
            <p>If the bid is accepted, the bidder agrees to complete the transaction and make the required payment within the stipulated time frame.</p>

            <!-- Example Table -->
            <table>
                <thead>
                    <tr>
                        <th>Bid No</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Buyer</th>
                        <th>Seller</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> #000{{ $signatureImg[0]['bidData']->id ?? '' }}</td>
                        <td style="color:#015158">{{ ucfirst($signatureImg[0]['bidData']->bid_status ?? '') }}</td>
                        <td> {{ $signatureImg[0]['bidData']->bid_amount ?? '' }}</td>
                        <td> <img   src="{{ $signatureImg[0]['image_fit'] ?? '' }}900/900/sm/0/plain/{{ $signatureImg[0]['original_image'] ?? '' }}" alt="Buyer Signature"></td>
                        <td>  <img   src="{{ $signatureImg[0]['image_fit'] ?? '' }}900/900/sm/0/plain/{{ $signatureImg[0]['original_seller_image'] ?? '' }}" alt="Seller Signature"></td>
                    </tr>  
                </tbody>
            </table>

            <p>The bidder agrees to abide by all applicable terms, conditions, and policies set forth in this agreement.</p>

            <!-- Add two images below -->
            {{-- <h6>Images Related to the Bid:</h6> --}}
            {{-- <div class="d-flex">
            @if(!empty($signatureImg))
                <img class="w-50" src="{{ $signatureImg[0]['image_fit'] ?? '' }}200/200/sm/0/plain/{{ $signatureImg[0]['original_image'] ?? '' }}" alt="Buyer Signature">
                
                <img class="w-50" src="{{ $signatureImg[0]['image_fit'] ?? '' }}200/200/sm/0/plain/{{ $signatureImg[0]['original_seller_image'] ?? '' }}" alt="Seller Signature">
            @endif
            </div> --}}
        </div>
    </div>
</body>
</html>
