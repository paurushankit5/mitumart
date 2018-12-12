@extends('layouts.main')
@section('title')
 {{ env('APP_NAME') }} Payments
@endsection
@section('pagename', 'Payments')
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
<?php
    $active1 = 'active';
    $active2 = '';
    if ($errors->any())
    {
        $active2 = 'active';
        $active1 = '';
    }

?>

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
                          <a class="nav-link <?= $active1; ?> " href="#suppliers" data-toggle="tab">
                            <i class="material-icons">content_paste</i> Payments
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link <?= $active2; ?> " href="#add_suppliers" data-toggle="tab">
                            <i class="fa fa-plus"></i> Add Payment
                            <div class="ripple-container"></div>
                          </a>
                        </li> 
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane <?= $active1; ?> " id="suppliers">
                        <div class="table-responsive">
                            <table class="table table">
                                <thead>
                                    <tr class="bg-success text-white">
                                        <th>Sl. No.</th>
                                        <th>Supplier</th>
                                        <th>Details</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(count($payments))
                                        {
                                            $i = 1;
                                            if(isset($_GET['page']))
                                            {
                                                //$count--;
                                                $i=--$_GET['page']*$count+1;
                                            }
                                            foreach ($payments as $payment) {
                                                if($payment->payment_status == 'Waiting for bank confirmation')
                                                {
                                                    $class =" bg-danger2 ";
                                                }
                                                else if($payment->payment_status == 'Cheque Bounced')
                                                {
                                                    $class =" bg-danger ";
                                                }
                                                else 
                                                {
                                                    $class = '';
                                                }
                                                ?>
                                                    <tr class="text-capitalize <?= $class; ?>">
                                                        <td>{{ $i++ }}</td>
                                                        <td><a href="/supplier/details/{{ $payment->id }}">{{ $payment->supplier->name_to_display }}</a></td>
                                                        <td >
                                                            <table class="table text-black">
                                                                <tr>
                                                                    <td>Payment Id</td>
                                                                    <td>{{ $payment->id }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mode Of Payment</td>
                                                                    <td>{{ $payment->mode_of_payment }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Amount Paid</td>
                                                                    <td>Rs. {{ $payment->bill_amount }}</td>
                                                                </tr>
                                                                @if($payment->mode_of_payment =='Cheque')
                                                                
                                                                    <tr>
                                                                        <td>Cheque No.</td>
                                                                        <td>{{ $payment->cheque_no }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Issue Date</td>
                                                                        <td>{{ date('d/M/y',strtotime($payment->cheque_issue_date)) }}</td>
                                                                    </tr>
                                                                     <tr>
                                                                        <td>Withdrawl Date</td>
                                                                        <td>{{ date('d/M/y',strtotime($payment->cheque_withdrawl_date)) }}</td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td>Paid On</td>
                                                                        <td>{{ date('d/M/y',strtotime($payment->created_at)) }}</td>
                                                                    </tr>

                                                                @endif
                                                                @if($payment->payment_proof_image)
                                                                    <tr>
                                                                        <td>Proof of Payment</td>
                                                                        <td><img src="/images/payments/{{ $payment->payment_proof_image }}" onclick="showimage('/images/payments/{{ $payment->payment_proof_image }}');" class="img img-responsive thumb-image" ></td>
                                                                    </tr>
                                                                @endif  
                                                                <tr>
                                                                    <td>Status</td>
                                                                    <td>{{$payment->payment_status}}</td>
                                                                </tr>
                                                                @if($payment->notes!='')
                                                                    <tr>                                                                        
                                                                        <td colspan="2">{{ $payment->notes }}</td>
                                                                    </tr>
                                                                @endif

                                                            </table>
                                                        </td>
                                                         
                                                        <td><a href="/payments/edit/{{ $payment->id }}" class="btn btn-info"><i class="fa fa-pencil"></i></a></td>
                                                    </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="4">{!! $payments->links() !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane <?= $active2; ?> " id="add_suppliers">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ol>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                        <form class="form form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('storepayments') }}">
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
                                                            <option value="{{ $supplier->id }}">
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
                                            <select class="form-control" required name="mode_of_payment" required id="mode_of_payment" onChange="changeui();" value="{{ old('mode_of_payment') }}">
                                                <option>Cheque</option>
                                                <option>Cash</option>
                                                <option>RTGS/NEFT</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Bill Amount in Rs.*</label>
                                            <input type="number" class="form-control" required name="bill_amount" required onblur="" value="{{ old('bill_amount') }}">
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
                              <div class="row cheque_details">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Cheque No.</label>
                                            <input type="text" class="form-control"   name="cheque_no" value="{{ old('cheque_no') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Cheque Issue Date</label>
                                            <input type="text" id="datepicker" class="form-control"   name="cheque_issue_date" value="{{ old('cheque_issue_date') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Cheque Withdrwal Date</label>
                                            <input type="text" id="datepicker2" class="form-control"   name="cheque_withdrawl_date" value="{{ old('cheque_withdrawl_date') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="bmd-label-floating">Additional Notes</label>
                                        <textarea class="form-control" rows="5" name="notes" value="{{ old('notes') }}"></textarea>
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
                $('.cheque_details').show();
            }
            else{
                $('.cheque_details').hide();
            }
        }
    </script>
@endsection
