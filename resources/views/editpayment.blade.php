@extends('layouts.main')
@section('title')
 {{ env('APP_NAME') }}Edit Payments
@endsection
@section('pagename', 'Edit Payments')
@section('after_styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $jq     =   $.noConflict();
    $jq( function() {
        $jq( "#datepicker" ).datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: "+0d"
        });
        $jq( "#datepicker2" ).datepicker({
            dateFormat: "yy-mm-dd",
         });
    });
  </script>
@endsection
@section('content')
    <div class="container">
    <div class="row">        
         <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                       <ul class="nav nav-tabs" data-tabs="tabs">                        
                         
                        <li class="nav-item">
                          <a class="nav-link active " href="#add_suppliers" data-toggle="tab">
                            <i class="fa fa-plus"></i> Edit Payment
                            <div class="ripple-container"></div>
                          </a>
                        </li> 
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                   
                    <div class="tab-pane active " id="add_suppliers">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ol>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                        <form class="form form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('updatepayment') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Select Supplier</label>
                                        <select class="form-control" required name="supplier_id">
                                            <?php
                                                if(count($suppliers))
                                                {
                                                    foreach ($suppliers as $supplier) {
                                                        ?>
                                                            <option value="{{ $supplier->id }}" <?php if($payment->supplier_id == $supplier->id) {echo " selected "; } ?>>
                                                                {{ $supplier->name_to_display }}
                                                            </option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>                 
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Mode Of Payment*</label>
                                            <input type="hidden" name="id" value="{{ $payment->id }}">
                                            <select class="form-control" required name="mode_of_payment" required id="mode_of_payment" onChange="changeui();" }}">
                                                <option <?php if($payment->mode_of_payment == 'Cheque'){echo " selected ";} ?> >Cheque</option>
                                                <option <?php if($payment->mode_of_payment == 'Cash'){echo " selected ";} ?>>Cash</option>
                                                <option <?php if($payment->mode_of_payment == 'RTGS/NEFT'){echo " selected ";} ?>>RTGS/NEFT</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Bill Amount in Rs.*</label>
                                            <input type="number" class="form-control" required name="bill_amount" value="{{ $payment->bill_amount }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Proof of Payment</label>
                                            <input type="file" class="form-control" accept="image/*" name="payment_proof_image">
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="row cheque_details <?php if($payment->mode_of_payment !='Cheque'){echo 'd-none' ;} ?>">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Cheque No.</label>
                                            <input type="text" class="form-control"   name="cheque_no" value="{{ $payment->cheque_no }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Cheque Issue Date</label>
                                            <input type="text" id="datepicker" class="form-control"   name="cheque_issue_date" value="{{ $payment->cheque_issue_date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Cheque Withdrwal Date</label>
                                            <input type="text" id="datepicker2" class="form-control"   name="cheque_withdrawl_date" value="{{ $payment->cheque_withdrawl_date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Payment Status</label>
                                            <select class="form-control" name="payment_status"  id="payment_status">
                                                <option <?php if($payment->payment_status=='Waiting for bank confirmation'){echo "selected"; } ?>>Waiting for bank confirmation</option>
                                                <option <?php if($payment->payment_status=='Payment Approved from bank'){echo "selected"; } ?>>Payment Approved from bank</option>
                                                <option <?php if($payment->payment_status=='Cheque Bounced'){echo "selected"; } ?>>Cheque Bounced</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="bmd-label-floating">Additional Notes</label>
                                        <textarea class="form-control" rows="5" name="notes"> {{ $payment->notes }}</textarea>
                                    </div>
                                </div> 
                            </div>  
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary btn-lg">
                                </div>
                            </div>
                            
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>



    </div>
    </div>
    <script type="text/javascript">
        function changeui(){
            var mode_of_payment     =   $('#mode_of_payment').val();
            if(mode_of_payment=='Cheque')
            {
                $('.cheque_details').removeClass('d-none');
            }
            else{
                $('.cheque_details').addClass('d-none');
            }
        }
    </script>
@endsection
