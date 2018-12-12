@extends('layouts.main')
@section('title')
 {{ env('APP_NAME') }} Edit Supplier Details
@endsection
@section('pagename', 'Edit Supplier Details')
 
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
                            <i class="fa fa-pencil"></i> Edit Supplier
                            <div class="ripple-container"></div>
                          </a>
                        </li> 
                        
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">                    
                    <div class="tab-pane  active" id="add_suppliers">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ol>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                        <form class="form form-horizontal" method="post" action="{{ route('updatesupplier') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Supplier Name</label>
                                        <input type="text" class="form-control" required name="supplier_name" value="{{ $supplier->name }}">
                                        <input type="hidden" class="form-control" required name="id" value="{{ $supplier->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Name to Display</label>
                                        <input type="text" class="form-control" required name="name_to_display" value="{{ $supplier->name_to_display }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Mobile</label>
                                        <input type="text" class="form-control" required name="mobile" value="{{ $supplier->mobile }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Telephone</label>
                                        <input type="text" class="form-control" name="telephone" value="{{ $supplier->telephone }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ $supplier->email }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">VAT No.</label>
                                        <input type="text" class="form-control" name="vat_no" value="{{ $supplier->vat_no }}">
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">CST No.</label>
                                        <input type="text" class="form-control" name="cst_no" value="{{ $supplier->cst_no }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">TIN No.</label>
                                        <input type="text" class="form-control" name="tin_no" value="{{ $supplier->tin_no }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">GST No.</label>
                                        <input type="text" class="form-control" name="gst_no" value="{{ $supplier->gst_no }}">
                                    </div>
                                </div>                   
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">PAN No.</label>
                                        <input type="text" class="form-control" name="pan_no" value="{{ $supplier->pan_no }}">
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
                                                    <option <?php if($i==$supplier->payment_terms) { echo "selected"; } ?> > {{ $i }}</option>
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
                                            <input type="radio"  value="1" @if($supplier->is_preferred_supplier ==1) checked @endif name="is_preferred_supplier">Yes   
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label>
                                            <input type="radio"  value="0"  @if($supplier->is_preferred_supplier ==0) checked @endif name="is_preferred_supplier"> No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Address Line 1</label>
                                        <input type="text" class="form-control"  required name="adl1" value="{{ $supplier->adl1 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Address Line 2</label>
                                        <input type="text" class="form-control" name="adl2" value="{{ $supplier->adl2 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">City</label>
                                        <input type="text" class="form-control" value="Ranchi" required name="city" value="{{ $supplier->city }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">State</label>
                                        <input type="text" class="form-control" value="Jharkhand" required name="state" value="{{ $supplier->state }}">
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
