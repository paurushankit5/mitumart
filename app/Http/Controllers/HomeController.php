<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use App\Bill;
use App\Payment;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('dashboard');
    }

    public function bills()
    {
        $count =20;
        $bills   =   Bill::orderBy('created_at','desc')->paginate($count);
        $suppliers=   Supplier::orderBy('name_to_display')->get();
        return view('bills')
            ->with([
                'suppliers'      => $suppliers,
                'bills'         => $bills,
                'count'         => $count,
            ]);
    }
    public function supplierdetails(request $request){
        $supplier   =   Supplier::findOrFail($request->id);
        $bills      =   Bill::where('supplier_id' ,$request->id)
                            ->orderBy('bill_date','desc')
                            ->get();

        $payments   =   Payment::where('supplier_id' ,$request->id)
                            ->orderBy('created_at','desc')
                            ->get();

        $total_bill_received =   Bill::where('supplier_id' ,$request->id)
                            ->selectRaw('coalesce(sum(bill_amount),0) as total_bill_received')
                            ->first();

        $total_amount_paid  =  Payment::where('supplier_id' ,$request->id)
                                ->selectRaw('coalesce(sum(bill_amount),0) as total_amount_paid')
                                ->where('payment_status','<>','Cheque Bounced')
                                ->first(); 
        $cheque_pending     =  Payment::where('supplier_id' ,$request->id)
                                ->selectRaw('coalesce(sum(bill_amount),0) as cheque_pending')
                                ->where('payment_status','Waiting for bank confirmation')
                                ->first(); 

        $cheque_bounced     =  Payment::where('supplier_id' ,$request->id)
                                ->selectRaw('coalesce(sum(bill_amount),0) as cheque_bounced')
                                ->where('payment_status','Cheque Bounced')
                                ->first(); 

        $total_amount_paid_cash     =  Payment::where('supplier_id' ,$request->id)
                                ->selectRaw('coalesce(sum(bill_amount),0) as total_amount_paid_cash')
                                ->where('payment_status','Amount Paid in cash')
                                ->first(); 

        $total_amount_paid_rtgs     =  Payment::where('supplier_id' ,$request->id)
                                ->selectRaw('coalesce(sum(bill_amount),0) as total_amount_paid_rtgs')
                                ->where('payment_status','Amount Paid through RTGS/NEFT')
                                ->first(); 

         return view('supplierdetails')->with([
            "supplier"              =>   $supplier,
            "bills"                 =>   $bills,
            "payments"              =>   $payments,
            "total_bill_received"   =>   $total_bill_received->total_bill_received,
            "total_amount_paid"     =>   $total_amount_paid->total_amount_paid,
            "cheque_pending"        =>   $cheque_pending->cheque_pending,
            "cheque_bounced"        =>   $cheque_bounced->cheque_bounced,
            "total_amount_paid_cash"=>   $total_amount_paid_cash->total_amount_paid_cash,
            "total_amount_paid_rtgs"=>   $total_amount_paid_rtgs->total_amount_paid_rtgs,

        ]);
    }
    public function storebills(Request $request){
        //echo "<pre>";
         $validatedData = $request->validate([
            'supplier_id'       => 'required',
            'bill_date'         => 'required',
            'bill_amount'       => 'required',
         ]);  
        $bill           =   new Bill;
        $bill->supplier_id      =   $request['supplier_id'];
        $bill->bill_amount      =   $request['bill_amount'];
        $bill->bill_date        =   $request['bill_date'];
        $bill->notes            =   $request['notes'];
        //$bill->status           =   $request['status'];

        //check for image files
        if ($request->hasFile('bill_image')) {
            $image = $request->file('bill_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/bills');
            $image->move($destinationPath, $name);
            $bill->bill_image   =  $name;

         }
        $bill->save();
        Session::flash('message', 'Bill Added Successfully!'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect( route('bills'));
    }
    public function editbills(Request $request){
        $bill   =  Bill::findOrFail($request->id);
        return view('editbills')->with([
            "bill"      =>  $bill,
            'suppliers' =>  Supplier::orderBy('name_to_display')->get()
        ]);
    }

    public function updatebills(Request $request){
         $validatedData = $request->validate([
            'supplier_id'       => 'required',
            'bill_date'         => 'required',
            'bill_amount'       => 'required',
         ]);  
        $bill           =   Bill::findOrFail($request->id);
        $bill->supplier_id      =   $request['supplier_id'];
        $bill->bill_amount      =   $request['bill_amount'];
        $bill->bill_date        =   $request['bill_date'];
        $bill->notes            =   $request['notes'];
        $bill->status           =   $request['bill_status'];
        $bill->amount_paid      =   $request['amount_paid'];

        //check for image files
        if ($request->hasFile('bill_image')) {
            $image = $request->file('bill_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/bills');
            $image->move($destinationPath, $name);
            $bill->bill_image   =  $name;

         }
        $bill->save();
        Session::flash('message', 'Bill Updated Successfully!'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect( route('bills'));
    }


    public function suppliers(){
        $count =20;
        $suppliers   =   Supplier::orderBy('created_at','desc')->paginate($count);
        return view('suppliers')
            ->with([
                'suppliers'=> $suppliers,
                'count'    => $count,

            ]);
         
    }
    public function supplieredit(Request $request){
        $supplier   =   Supplier::findOrFail($request->id);
        return view('editsupplier')
            ->with([
                'supplier'=> $supplier
            ]);

    }
    public function storesuppliers(Request $request){
        //echo "<pre>";
         $validatedData = $request->validate([
            'supplier_name'              => 'required',
            'name_to_display'   => 'required',
            'mobile'            => 'required|unique:suppliers',
         ]);
         $supplier  =   new Supplier;
         $supplier->name                =   $request['supplier_name'];
         $supplier->name_to_display     =   $request['name_to_display'];
         $supplier->vat_no              =   $request['vat_no'];
         $supplier->cst_no              =   $request['cst_no'];
         $supplier->gst_no              =   $request['gst_no'];
         $supplier->tin_no              =   $request['tin_no'];
         $supplier->pan_no              =   $request['pan_no'];
         $supplier->is_preferred_supplier  =   $request['is_preferred_supplier'];
         $supplier->payment_terms       =   $request['payment_terms'];
         $supplier->adl1                =   $request['adl1'];
         $supplier->adl2                =   $request['adl2'];
         $supplier->city                =   $request['city'];
         $supplier->state               =  $request['state'];
         $supplier->mobile              =   $request['mobile'];
         $supplier->telephone           =   $request['telephone'];
         $supplier->email               =   $request['email'];

         $supplier->save();
         Session::flash('message', 'Supplier Added Successfully!'); 
         Session::flash('alert-class', 'alert-success'); 
         return redirect( route('suppliers'));
    }
    public function updatesupplier(Request $request){

        /*echo $request->id;
        exit;*/
        //echo "<pre>";
         $validatedData = $request->validate([
            'supplier_name'     => 'required',
            'name_to_display'   => 'required',
            'mobile'            => 'required|unique:suppliers,mobile,' . $request->id
         ]);
        
         $supplier                      =   Supplier::findOrFail($request->id);
         $supplier->name                =   $request['supplier_name'];
         $supplier->name_to_display     =   $request['name_to_display'];
         $supplier->vat_no              =   $request['vat_no'];
         $supplier->cst_no              =   $request['cst_no'];
         $supplier->gst_no              =   $request['gst_no'];
         $supplier->tin_no              =   $request['tin_no'];
         $supplier->pan_no              =   $request['pan_no'];
         $supplier->is_preferred_supplier  =   $request['is_preferred_supplier'];
         $supplier->payment_terms       =   $request['payment_terms'];
         $supplier->adl1                =   $request['adl1'];
         $supplier->adl2                =   $request['adl2'];
         $supplier->city                =   $request['city'];
         $supplier->state               =  $request['state'];
         $supplier->mobile              =   $request['mobile'];
         $supplier->telephone           =   $request['telephone'];
         $supplier->email               =   $request['email'];

         $supplier->save();
         Session::flash('message', 'Supplier Updated Successfully!'); 
         Session::flash('alert-class', 'alert-success'); 
         return redirect( '/supplier/details/'.$request->id);
    }

    public function payments(){
        $count =20;
        $payments   =   Payment::orderBy('created_at','desc')->paginate($count);
        $suppliers=   Supplier::orderBy('name_to_display')->get();
        return view('payments')
            ->with([
                'suppliers'      => $suppliers,
                'payments'       => $payments,
                'count'          => $count,
            ]);
        //return view('');
    }

    public function storepayments(Request $request){
        //echo "<pre>";=='Cheque'
        if($request->mode_of_payment=='Cheque')
        {   
             $validatedData = $request->validate([
                'supplier_id'               => 'required',
                'bill_amount'               => 'required',
                'cheque_no'                 => 'required',
                'cheque_issue_date'         => 'required',
                'cheque_withdrawl_date'     => 'required',
                'mode_of_payment'           => 'required',
             ]); 
        }
        else{
            $validatedData = $request->validate([
                'supplier_id'               => 'required',
                'bill_amount'               => 'required',
                'mode_of_payment'           => 'required',
             ]); 
        }
        $payment                           =   new Payment;
        $payment->supplier_id              =   $request['supplier_id'];
        $payment->bill_amount              =   $request['bill_amount'];
        $payment->cheque_no                =   $request['cheque_no'];
        $payment->cheque_issue_date        =   $request['cheque_issue_date'];
        $payment->cheque_withdrawl_date    =   $request['cheque_withdrawl_date'];
        $payment->mode_of_payment          =   $request['mode_of_payment'];
        $payment->notes                    =   $request['notes'];

        if($request->mode_of_payment=='Cheque')
        {
            $payment->payment_status = 'Waiting for bank confirmation';
         }
        else if ($request->mode_of_payment=='Cash'){
            $payment->payment_status = 'Amount Paid in cash';
         }
        else if ($request->mode_of_payment=='RTGS/NEFT'){
            $payment->payment_status = 'Amount Paid through RTGS/NEFT';
        }
        //$bill->status           =   $request['status'];

        //check for image files
        if ($request->hasFile('payment_proof_image')) {
            $image = $request->file('payment_proof_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/payments');
            $image->move($destinationPath, $name);
            $payment->payment_proof_image   =  $name;
         }
        $payment->save();
        Session::flash('message', 'Payment Added Successfully!'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect( route('payments'));      
    }

    public function editpayment(){
        $id =  \Request::segment(3);
         try
        {
            $payment = Payment::findOrFail($id);
            return view('editpayment')
            ->with([
                'payment'=> $payment,
                'suppliers' =>   Supplier::orderBy('name_to_display')->get()

            ]);

        }
        catch(ModelNotFoundException $e)
        {
            dd(get_class_methods($e)); // lists all available methods for exception object
            dd($e);
        }
    }
    public function updatepayment(Request $request){
        //echo "<pre>";=='Cheque'
         if($request->mode_of_payment=='Cheque')
        {   
             $validatedData = $request->validate([
                'supplier_id'               => 'required',
                'bill_amount'               => 'required',
                'cheque_no'                 => 'required',
                'cheque_issue_date'         => 'required',
                'cheque_withdrawl_date'     => 'required',
                'mode_of_payment'           => 'required',
             ]); 
        }
        else{
            $validatedData = $request->validate([
                'supplier_id'               => 'required',
                'bill_amount'               => 'required',
                'mode_of_payment'           => 'required',
             ]); 
        }
        $payment                           =   Payment::findOrFail( $request->id);
        $payment->supplier_id              =   $request['supplier_id'];
        $payment->bill_amount              =   $request['bill_amount'];
        $payment->cheque_no                =   $request['cheque_no'];
        $payment->cheque_issue_date        =   $request['cheque_issue_date'];
        $payment->cheque_withdrawl_date    =   $request['cheque_withdrawl_date'];
        $payment->mode_of_payment          =   $request['mode_of_payment'];
        $payment->notes                    =   $request['notes'];

        if($request->mode_of_payment=='Cheque')
        {
            $payment->payment_status = $request->payment_status;
        }
        else if ($request->mode_of_payment=='Cash'){
            $payment->payment_status = 'Amount Paid in cash';
        }
        else if ($request->mode_of_payment=='RTGS/NEFT'){
            $payment->payment_status = 'Amount Paid through RTGS/NEFT';
        }
        //$bill->status           =   $request['status'];

        //check for image files
        if ($request->hasFile('payment_proof_image')) {
            $image = $request->file('payment_proof_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/payments');
            $image->move($destinationPath, $name);
            $payment->payment_proof_image   =  $name;
         }
        $payment->save();
        Session::flash('message', 'Payment Updated Successfully!'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect( route('payments')); 
    }



    public function calendar(Request $request){
        $payments   =   Payment::selectRaw('cheque_withdrawl_date,sum(bill_amount) as bill_amount')
                                ->groupBy('cheque_withdrawl_date')
                                ->where('mode_of_payment','cheque')
                                ->whereRaw('Month(cheque_withdrawl_date)',$request->m)
                                ->whereRaw('YEAR(cheque_withdrawl_date)',$request->y)
                                ->get();
        return view('calendar')
            ->with([
                'payments'=> $payments, 
                'm'       => $request->m,
                'y'       => $request->y,
            ]);
    }




    public function test(){
        $username= 'paurush.ankit@gmail.com';
        $pwd      =     '8901155a0afbb390577ceda9d9132a26';
        $api_url =  'https://gtmetrix.com/api/0.1/test';
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $pwd); 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "url=https://www.bookediz.com");
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);            
        echo "<prE>";
        //print_r($curl_scraped_page);
    }
    public function test1(){
        $username= 'paurush.ankit@gmail.com';
        $pwd      =     '8901155a0afbb390577ceda9d9132a26';
        $api_url =  'https://gtmetrix.com/api/0.1/test/nF8A0Gh7';
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $pwd); 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "url=https://www.bookediz.com");
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);            
        echo "<prE>";
        //print_r($curl_scraped_page);
    }

    public function test2(){
        if(file_exists(public_path() . '/sample.csv'))
        {
            

        $file_name =public_path() . '/sample.csv';
        $target_url='http://www.metamorphsystems.com/index.php/api/custom-csv-sms/';
        $file_name_with_full_path = $file_name;
        if(function_exists('curl_file_create')) { 
          $cFile = curl_file_create($file_name_with_full_path);

        }else{
          $cFile = '@' . realpath($file_name_with_full_path);
        }
        /*print_r($cFile);
        die();*/
        $shedule_date=date('Y-m-d H:i:s',strtotime("+10 minutes"));
        $post = array('username'=>'incdata','password'=>'Incdata@123','to_csv_files[0]'=>$cFile,'from'=>'INCREG','sms _type'=>'2','unicode_sms'=>'2','campaign_name'=>'Dhananjay_state_name','scheduled_sms'=>'0','to_state'=>'30');
        $abc = json_encode($post);

        echo "<pre>";
        print_r($post);
        print_r($abc);
        //exit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$target_url);
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result=curl_exec ($ch);
        print_r($result);
        }
        else{
            echo "no";
        }
    }
}
