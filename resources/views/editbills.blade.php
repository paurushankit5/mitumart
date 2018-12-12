@extends('layouts.main')
@section('title')
 {{ env('APP_NAME') }} Edit Bill
@endsection
@section('pagename', 'Edit Bill')
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
                            <i class="fa fa-pencil"></i> Edit Bill
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
                        <form class="form form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('updatebills') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Select Supplier*</label>
                                        <select class="form-control" required name="supplier_id">
                                            <?php
                                                if(count($suppliers))
                                                {
                                                    foreach ($suppliers as $supplier) {
                                                        ?>
                                                            <option value="{{ $supplier->id }}" @if($supplier->id == $bill->id) selected @endif >
                                                                {{ $supplier->name_to_display }}
                                                            </option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <input type="hidden" name="id" value="{{ $bill->id }}">
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                	<div class="form-check-inline">
	                                    <label class="bmd-label-floating">Bill status* &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
	                                    <label class="form-check-label">
	                                    	<input type="radio" name="bill_status" value="Pending" onclick="pending();" @if($bill->status =='Pending') checked @endif class="form-check-input">Pending  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                                    </label>
	                                    <label class="form-check-label">
	                                    	<input type="radio" name="bill_status" @if($bill->status =="Partially Paid") checked @endif class="form-check-input" value="Partially Paid">Partially Paid  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                                    </label>
	                                    <label class="form-check-label">
	                                    	<input type="radio" name="bill_status" onclick="fullypaid();" @if($bill->status =="Fully Paid") checked @endif class="form-check-input" value="Fully Paid">Fully Paid 
	                                    </label>
	                                </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Amount Paid in Rs.*</label>
                                            <input type="number" class="form-control" required name="amount_paid" id="amount_paid" value="{{ $bill->amount_paid }}">
                                        </div>
                                    </div>
                                </div>               
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Bill Amount in Rs.*</label>
                                            <input type="number" class="form-control" id="bill_amount" required name="bill_amount" value="{{ $bill->bill_amount }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Bill Date*</label>
                                            <input type="text" id="datepicker" class="form-control" required name="bill_date" value="{{ $bill->bill_date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Bill Image</label>
                                            <input type="file" class="form-control" accept="image/*" name="bill_image">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="bmd-label-floating">Additional Notes</label>
                                        <textarea class="form-control" rows="5" name="notes" value="">{{ $bill->notes }}</textarea>
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
    	function fullypaid(){
    		var bill_amount = $("#bill_amount").val();
    		$("#amount_paid").val(bill_amount);
    	}
    	function pending(){
    		$("#amount_paid").val(0);
    	}

    </script>
@endsection
