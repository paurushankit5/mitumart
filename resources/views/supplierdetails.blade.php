@extends('layouts.main')
@section('title')
 {{ env('APP_NAME') }} -supplier - {{ $supplier->name_to_display }}
@endsection
@section('pagename', $supplier->name_to_display)
 
@section('content')
    <div class="container">
    <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                   <h3 class="card-title">&#x20B9; {{ $total_bill_received }}
                    <small></small>
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-danger">content_paste</i>
                    <a href="#">Total Bill Amount</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">money</i>
                  </div>
                   <h3 class="card-title">&#x20B9; {{ $total_amount_paid }}</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Total Amount Paid excluding Bounced Cheque
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-twitter"></i>
                  </div>
                   <h3 class="card-title">&#x20B9; {{ $cheque_pending }}</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> Pending cheque
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">info_outline</i>
                  </div>
                   <h3 class="card-title">&#x20B9; {{ $cheque_bounced }} </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> Bounced cheque
                  </div>
                </div>
              </div>
            </div>
             <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">money</i>
                  </div>
                   <h3 class="card-title">&#x20B9; {{ $total_bill_received- $total_amount_paid }} </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> Amount Due
                  </div>
                </div>
              </div>
            </div>
          </div>
    <div class="row">        
         <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">

                       <ul class="nav nav-tabs" data-tabs="tabs">                        
                         
                      
                        <li class="nav-item float-right">
                          <a href="/supplier/edit/{{ $supplier->id }}" class="btn btn-info float-right"><i class="fa fa-pencil"></i></a>

                        </li>  

                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    
                    <div class="tab-pane active " id="add_suppliers">
                         
                        <div  class="row">
                          <div class="col-md-12 table-responsive">
                              <table class="table">
                                    <tr>
                                        <td>Name</td>
                                        <td class="font-weight-bold">{{ $supplier->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Name To Display</td>
                                        <td class="font-weight-bold"> {{ $supplier->name_to_display }} </td>
                                    </tr>
                                    <tr>
                                        <td>Contact
                                        <td class="font-weight-bold"> 
                                            {{ $supplier->mobile }}
                                            {{ $supplier->telephone }}
                                            {{ $supplier->email }}<br>
                                            {{ $supplier->adl1 }}
                                            {{ $supplier->adl2 }}<br>
                                            {{ $supplier->city }} - {{ $supplier->state }}<br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Preferred Supplier</td>
                                        <td class="font-weight-bold">
                                            @if ($supplier->is_preferred_supplier == 1) Yes @else No @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>VAT No.</td>
                                        <td class="font-weight-bold"> {{ $supplier->vat_no }} </td>
                                    </tr>
                                    <tr>
                                        <td>CST No.</td>
                                        <td class="font-weight-bold"> {{ $supplier->cst_no }} </td>
                                    </tr>
                                    <tr>
                                        <td>GST No.</td>
                                        <td class="font-weight-bold"> {{ $supplier->gst_no }} </td>
                                    </tr>
                                    <tr>
                                        <td>TIN No.</td>
                                        <td class="font-weight-bold"> {{ $supplier->tin_no }} </td>
                                    </tr>
                                    <tr>
                                        <td>PAN No.</td>
                                        <td class="font-weight-bold"> {{ $supplier->pan_no }} </td>
                                    </tr>

                              </table>
                          </div>
                        </div>
                        
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4>Bills</h4>
                    <p class="card-category">List of Bills given by {{ $supplier->name_to_display}}</p>
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <?php
                            if(count($bills))
                            {
                                $i=0;
                                foreach ($bills as $bill) {  
                                    if($bill->status == 'Pending')
                                    {
                                        $class =" bg-danger2 ";
                                    }
                                    else if($bill->status == 'PartiallyPaid')
                                    {
                                        $class = 'bg-info';
                                    }
                                    else{
                                        $class='bg-success';
                                    }                            
                                ?>
                                    <tr class="{{ $class }}">  
                                        <td>{{ ++$i}}</td>                                       
                                        <td class="font-weight-bold">
                                            Bill Id -  {{ $bill->id }} <br>
                                            Bill Amount - Rs. {{ $bill->bill_amount }} <br>
                                            Date -  {{ date('d/M/y' ,strtotime($bill->bill_date)) }} <br>
                                            Status -  {{ $bill->status }} 
                                            @if($bill->bill_image !='')
                                                <br>
                                                <img src="/images/bills/{{ $bill->bill_image }}" onclick="showimage('/images/bills/{{ $bill->bill_image }}');" class="img img-responsive thumb-image" >
                                            @endif
                                        </td>
                                    </tr>
                                <?php
                                }
                            }
                            else{
                                ?>
                                    <tr>
                                        <td class="font-weight-bold">No bills found.</td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
             <div class="card">
                <div class="card-header card-header-primary">
                    <h4>Payments</h4>
                    <p class="card-category">List of Payments </p>
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <?php
                            if(count($payments))
                            {
                                $i=0;
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
                                    <tr class="{{ $class }}">  
                                        <td>{{ ++$i}}</td>                                       
                                        <td class="font-weight-bold">
                                            Payment Id - {{ $payment->id }}<br>
                                            Payment Mode - {{ $payment->mode_of_payment }}<br>
                                            Amount Paid - {{ $payment->bill_amount }}<br>
                                            @if($payment->mode_of_payment =='Cheque')
                                                Cheque No - {{ $payment->bill_amount }}<br>
                                                Issue Date - {{ $payment->cheque_issue_date }}<br>
                                                Withdrawl Date - {{ $payment->cheque_withdrawl_date }}<br>
                                            @else
                                                Paid On - {{ date('d/M/y',strtotime($payment->created_at)) }}<br>
                                            @endif
                                             Status - {{ $payment->payment_status }}
                                             @if($payment->payment_proof_image !='')
                                                <br>
                                                <img src="/images/payments/{{ $payment->payment_proof_image }}" onclick="showimage('/images/payments/{{ $payment->payment_proof_image }}');" class="img img-responsive thumb-image" >
                                            @endif
                                        </td>
                                    </tr>
                                <?php
                                }
                            }
                            else{
                                ?>
                                    <tr>
                                        <td class="font-weight-bold">No payments found.</td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>


    </div>
    </div>
    
@endsection
 
    
    

 