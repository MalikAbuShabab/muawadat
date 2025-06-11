<?php

namespace App\Exports;

use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderVendorListExport implements FromCollection,WithHeadings,WithMapping
{

    public function __construct($data)
    {
        $this->data = $data;
    }

    // public function collection()
    // {
    //     return collect($this->data);
    // }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        // $vendors = Vendor::with(['orders' => fn($query) => $query->where('order_status_option_id', '!=', 3)])->where('status', '!=', '2')->where('is_seller', 0);
        
        // $vendors = $vendors ->whereHas('orderDetail',function ($q) {
        //         $q->where('payment_status', 1);
        //          });
        // if (Auth::user()->is_superadmin == 0) {
        //     $vendors = $vendors->whereHas('permissionToUser', function ($query) {
        //         $query->where('user_id', Auth::user()->id);
        //     });
        // }

        // $from_date = "";
        // $to_date = "";
        // if (!empty($request->get('date_filter'))) {
        //     $date_date_filter = explode(' to ', $request->get('date_filter'));
        //     $to_date = (!empty($date_date_filter[1]))?$date_date_filter[1]:$date_date_filter[0];
        //     $from_date = $date_date_filter[0];
        // }
        // $vendors = Vendor::with(['orders' => function($query) use($from_date,$to_date) {
        //     if((!empty($from_date)) && (!empty($to_date))){
        //         $query->between($from_date." 00:00:00", $to_date." 23:59:59");
        //     }
        //      $query->wherehas('orderDetail',function ($q) {
        //         $q->where('payment_status', 1);
        //          });
        // }])->where('status', '!=', '2')->where('is_seller', 0)->orderBy('id', 'desc');
        
        // if (Auth::user()->is_superadmin == 0) {
        //     $vendors = $vendors->whereHas('permissionToUser', function ($query) {
        //         $query->where('user_id', Auth::user()->id);
        //     });
        // }

        // $vendors = $vendors->orderBy('id', 'desc')->get();
        $vendors = $this->data;
        foreach ($vendors as $vendor) {
            $vendor->total_paid = 0.00;
            $vendor->delivery_fee = decimal_format($vendor->orders->where('order_status_option_id', '!=', 3)->sum('delivery_fee'));
            $vendor->service_fee = decimal_format($vendor->orders->where('order_status_option_id', '!=', 3)->sum('service_fee_percentage_amount'));
            $vendor->fixed_fee = decimal_format($vendor->orders->where('order_status_option_id', '!=', 3)->sum('fixed_fee'));
            $vendor->order_value = decimal_format($vendor->orders->where('order_status_option_id', '!=', 3)->sum('payable_amount'));
            $vendor->payment_method = decimal_format($vendor->orders->where('order_status_option_id', '!=', 3)->whereNotIn('payment_option_id', [1,2])->sum('payable_amount'));
            $vendor->promo_admin_amount = decimal_format($vendor->orders->where('order_status_option_id', '!=', 3)->where('coupon_paid_by', 1)->sum('discount_amount'));
            $vendor->promo_vendor_amount = decimal_format($vendor->orders->where('order_status_option_id', '!=', 3)->where('coupon_paid_by', 0)->sum('discount_amount'));
            $vendor->cash_collected_amount = decimal_format($vendor->orders->where('order_status_option_id', '!=', 3)->where('payment_option_id', 1)->sum('payable_amount') + $vendor->orders->sum('taxable_amount') + $vendor->orders->sum('service_fee_percentage_amount'));
            $vendor->admin_commission_amount = decimal_format($vendor->orders->where('order_status_option_id', '!=', 3)->sum('admin_commission_percentage_amount') + $vendor->orders->where('order_status_option_id', '!=', 3)->sum('admin_commission_fixed_amount'));
            $admin_commission_amount = $vendor->orders->where('order_status_option_id', '!=', 3)->sum('admin_commission_percentage_amount') + $vendor->orders->where('order_status_option_id', '!=', 3)->sum('admin_commission_fixed_amount');
            $vendor->vendor_earning = decimal_format(($vendor->orders->where('order_status_option_id', '!=', 3)->sum('payable_amount') - $vendor->promo_vendor_amount - $admin_commission_amount - $vendor->orders->where('order_status_option_id', '!=', 3)->sum('delivery_fee')));
            $vendor->taxable_amount = decimal_format($vendor->orders->where('order_status_option_id', '!=', 3)->sum('taxable_amount'));
        }
        return $vendors;
    }
    
    public function headings(): array{
        return [
            'Vendor Name',
            'Order Value (Without Delivery Fee)',
            'Delivery Fees',
            'Admin Commissions',
            'Promo [Vendor]',
            'Promo [Admin]',
            'Service Fees',
            'Fixed Fees',
            'Cash Collected',
            'Payment Gateway',
            'Vendor Earning',
            'Tax'
        ];
    }
    
    public function map($orders): array
    {
        return [
            $orders->name ? $orders->name : '',
            $orders->order_value,
            $orders->delivery_fee,
            $orders->admin_commission_amount,
            $orders->promo_vendor_amount,
            $orders->promo_admin_amount,
            $orders->service_fee,
            $orders->fixed_fee,
            $orders->cash_collected_amount,
            $orders->payment_method,
            $orders->vendor_earning,
            $orders->taxable_amount
        ];
    }
    
}
