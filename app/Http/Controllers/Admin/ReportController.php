<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventCategory;
use App\Models\Event;


class ReportController extends Controller
{
    public function studentManagement(){
        return view('admin.reports.student-management');
    }
    public function employeeStaffManagement(){
        return view('admin.reports.employee-staff-management');
    }
    public function feePaymenTracking(){
        return view('admin.reports.fee-payment-tracking');
    }
    public function hostelManagement(){
        return view('admin.reports.hostel-management');
    }
    public function payroll(){
        return view('admin.reports.payroll');
    }
    public function idCardsIssue(){
        return view('admin.reports.id-cards-issue');
    }
    public function vendorManagement(){
        return view('admin.reports.vendor-management');
    }
    public function inventoryManagement(){
        return view('admin.reports.inventory-management');
    }
    public function transportationManagement(){
        return view('admin.reports.transportation-management');
    }
    public function assetManagement(){
        return view('admin.reports.asset-management');
    }
    public function receiptsAndInvoices(){
        return view('admin.reports.receipts-and-invoices');
    }
    public function accounting(){
        return view('admin.reports.accounting');
    }
    public function dailyReports(){
        return view('admin.reports.daily-reports');
    }
    public function awardReports(){

        $data['title'] = 'Award Reports';
            // return view($this->view.'.index');
        $category = EventCategory::where('name','Award')->first();  
        $data['rows'] = Event::where('category_id',$category->id)->where('status',1)->get();  
        
        return view('admin.reports.award-reports',$data);
    }
}
