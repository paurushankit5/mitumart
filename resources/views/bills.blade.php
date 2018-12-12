@extends('layouts.main')
@section('title')
 {{ env('APP_NAME') }} Bills
@endsection
@section('pagename', 'Bills')
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
                            <i class="material-icons">content_paste</i> Bill
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link <?= $active2; ?> " href="#add_suppliers" data-toggle="tab">
                            <i class="fa fa-plus"></i> Add Bill
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
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(count($bills))
                                        {
                                            $i = 1;
                                            if(isset($_GET['page']))
                                            {
                                                //$count--;
                                                $i=--$_GET['page']*$count+1;
                                            }
                                            foreach ($bills as $bill) {
                                                if($bill->status == 'Pending')
                                                {
                                                    $class =" bg-danger2 ";
                                                }
                                                else if($bill->status == 'Partially Paid')
                                                {
                                                    $class = 'bg-info';
                                                }
                                                else{
                                                    $class='';
                                                }
                                                ?>
                                                    <tr class="text-capitalize <?= $class; ?>">
                                                        <td>{{ $i++ }}</td>
                                                        <td> <a href="/supplier/details/{{ $bill->id }}">{{ $bill->supplier->name_to_display }} </a> </td>
                                                        <td>
                                                            <label> Bill Id. </label>  {{ $bill->id }}<br> 
                                                            <label> Bill Amt. </label> Rs. {{ $bill->bill_amount }}<br> 
                                                            <label> Bill Date. </label> 
                                                            {{ date('d/M/y' ,strtotime($bill->bill_date)) }}
                                                             @if($bill->bill_image !='')
                                                                <br>
                                                                <img src="/images/bills/{{ $bill->bill_image }}" onclick="showimage('/images/bills/{{ $bill->bill_image }}');" class="img img-responsive thumb-image" >
                                                            @endif

                                                         </td>
                                                        <td> {{ $bill->status }}  </td>
                                                        <td><a href="/biils/edit/{{ $bill->id }}" class="btn btn-info"><i class="fa fa-pencil"></i></a></td>

                                                    </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="4">{!! $bills->links() !!}</td>
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
                        <form class="form form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('storebills') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Select Supplier*</label>
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
                                            <label class="bmd-label-floating">Bill Amount in Rs.*</label>
                                            <input type="number" class="form-control" required name="bill_amount" value="{{ old('bill_amount') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group bmd-form-group is-filled">
                                            <label class="bmd-label-floating">Bill Date*</label>
                                            <input type="text" id="datepicker" class="form-control" required name="bill_date" value="{{ old('bill_date') }}">
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
@endsection
