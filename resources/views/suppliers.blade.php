@extends('layouts.main')
@section('title')
 {{ env('APP_NAME') }} Supplier List
@endsection
@section('pagename', 'Supplier List')
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
                          <a class="nav-link <?= $active1; ?>" href="#suppliers" data-toggle="tab">
                            <i class="material-icons">person</i> Suppliers
                            <div class="ripple-container"></div>
                          </a>
                        </li>                       
                        <li class="nav-item">
                          <a class="nav-link <?= $active2; ?> " href="#add_suppliers" data-toggle="tab">
                            <i class="fa fa-plus"></i> Add Suppliers
                            <div class="ripple-container"></div>
                          </a>
                        </li> 
                        
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane <?= $active1; ?>" id="suppliers">
                        <div class="table-responsive">
                            <table class="table table">
                                <thead>
                                    <tr class="bg-success text-white">
                                        <th>Sl. No.</th>
                                        <th>Name</th>
                                        <th>Contact Details</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(count($suppliers))
                                        {
                                            $i = 1;
                                            if(isset($_GET['page']))
                                            {
                                                //$count--;
                                                $i=--$_GET['page']*$count+1;
                                            }
                                            foreach ($suppliers as $supplier) {
                                                ?>
                                                    <tr class="text-capitalize">
                                                        <td>{{ $i++ }}</td>
                                                        <td><a href="/supplier/details/{{ $supplier->id }}"><strong>{{ $supplier->name_to_display }}</strong></a></td>
                                                        <td>
                                                            {{ $supplier->mobile }}<br>
                                                            {{ $supplier->telephone }}<br>
                                                            {{ $supplier->email }}<br>

                                                        </td>
                                                        <td>
                                                            <a href="/supplier/edit/{{$supplier->id}}" class="btn btn-info"><i class="fa fa-pencil"></i> </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="4">{!! $suppliers->links() !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane  <?= $active2; ?>" id="add_suppliers">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ol>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                        <form class="form form-horizontal" method="post" action="{{ route('storesuppliers') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Supplier Name</label>
                                        <input type="text" class="form-control" required name="supplier_name" value="{{ old('supplier_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Name to Display</label>
                                        <input type="text" class="form-control" required name="name_to_display" value="{{ old('name_to_display') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Mobile</label>
                                        <input type="text" class="form-control" required name="mobile" value="{{ old('mobile') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Telephone</label>
                                        <input type="text" class="form-control" name="telephone" value="{{ old('telephone') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">VAT No.</label>
                                        <input type="text" class="form-control" name="vat_no" value="{{ old('vat_no') }}">
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">CST No.</label>
                                        <input type="text" class="form-control" name="cst_no" value="{{ old('cst_no') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">TIN No.</label>
                                        <input type="text" class="form-control" name="tin_no" value="{{ old('tin_no') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">GST No.</label>
                                        <input type="text" class="form-control" name="gst_no" value="{{ old('gst_no') }}">
                                    </div>
                                </div>                   
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">PAN No.</label>
                                        <input type="text" class="form-control" name="pan_no" value="{{ old('pan_no') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Payment Terms.</label>
                                        <select class="form-control" required name="payment_terms">
                                            <?php
                                                for($i=1;$i<=60;$i++)
                                                {
                                                    ?>
                                                    <option <?php if($i==15) { echo "selected"; } ?> > {{ $i }}</option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Preferred Supplier</label> 
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <label>
                                            <input type="radio" checked value="1" name="is_preferred_supplier">Yes   
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label>
                                            <input type="radio"  value="0" name="is_preferred_supplier"> No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Address Line 1</label>
                                        <input type="text" class="form-control"  required name="adl1" value="{{ old('adl1') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Address Line 2</label>
                                        <input type="text" class="form-control" name="adl2" value="{{ old('adl2') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">City</label>
                                        <input type="text" class="form-control" value="Ranchi" required name="city" value="{{ old('city') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">State</label>
                                        <input type="text" class="form-control" value="Jharkhand" required name="state" value="{{ old('state') }}">
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
