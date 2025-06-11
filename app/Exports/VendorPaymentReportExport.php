<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\OrderVendor;
use Auth;
use Carbon\Carbon;

class VendorPaymentReportExport implements WithMapping, WithHeadings, FromCollection
{
    /**
     * @var array
     */
    protected $data;

    public function __construct($request)
    {
        $this->data = $request->all();
    }

    public function collection()
    {
        $vendor_orders = OrderVendor::with(['orderDetail.paymentOption', 'user', 'vendor', 'payment']);
        $request_data = $this->data;

        // Apply filters based on request data
        if (isset($request_data['start_date']) && isset($request_data['end_date'])) {
            $vendor_orders = $vendor_orders->whereBetween('created_at', [$request_data['start_date'], $request_data['end_date']]);
        } elseif (isset($request_data['start_date']) && !isset($request_data['end_date'])) {
            $vendor_orders = $vendor_orders->whereDate('created_at', '=', $request_data['start_date']);
        } else {
            $vendor_orders = $vendor_orders->where('created_at', '>=', Carbon::now()->subHours(24));
        }

        // Group and aggregate data
        $vendor_orders = $vendor_orders->selectRaw('
            vendor_id,
            COUNT(*) as order_count,
            SUM(payable_amount) as total_payable_amount,
            SUM(CASE WHEN is_exchanged_or_returned = 2 THEN 1 ELSE 0 END) as refund_count,
            SUM(CASE WHEN is_exchanged_or_returned = 2 THEN payable_amount ELSE 0 END) as refund_amount,
            SUM(CASE WHEN order_status_option_id = 3 THEN 1 ELSE 0 END) as cancelled_count,
            SUM(CASE WHEN order_status_option_id = 3 THEN payable_amount ELSE 0 END) as cancelled_amount
        ')
        ->groupBy('vendor_id')
        ->get();

        return $vendor_orders;
    }

    public function headings(): array
    {
        return [
            'Vendor Id',
            'Vendor Name',
            'Total Orders',
            'Total Amount',
            'Total Refund Count',
            'Total Refund Amount',
            'Total Cancelled Count',
            'Total Cancelled Amount',
            'Contact Person Details',
        ];
    }

    public function map($order_vendors): array
    {
        return [
            $order_vendors->vendor_id,
            $order_vendors->vendor ? $order_vendors->vendor->name : '',
            $order_vendors->order_count,
            $order_vendors->total_payable_amount,
            $order_vendors->refund_count,
            $order_vendors->refund_amount,
            $order_vendors->cancelled_count,
            $order_vendors->cancelled_amount,
            $order_vendors->vendor ? $order_vendors->vendor->email.','.$order_vendors->vendor->phone_no : '', // Assuming the 'contact_person' is a field in the vendor relation
        ];
    }
}
