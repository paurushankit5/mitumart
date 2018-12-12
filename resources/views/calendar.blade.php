@extends('layouts.main')
@section('title')
 {{ env('APP_NAME') }}Payment Calendar
@endsection
@section('pagename', 'Payment Calendar')
@section('after_scripts')
    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/fullcalendar.js') }}"></script>
    <script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      header: {
        left: '',
        //left: 'prev,next today',
        center: 'title',
        right : ''
        //right: 'month,basicWeek,basicDay'
      },
      defaultDate: '{{ $y }}-{{ $m }}-01',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [

        <?php
            if(count($payments)){
                foreach ($payments as $payment) {
                    echo "{";
                    echo " title : 'Rs. $payment->bill_amount',";
                    echo " start : '$payment->cheque_withdrawl_date'";
                    echo "},";
                }
            }
        ?>
        
      ]
    });

    calendar.render();
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
                            <i class="material-icons">calendar_today</i> Payment Calendar
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
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <select class="form-control" id="month">
                                        <option value="1" @if($m==1) selected @endif  >Jan</option>
                                        <option value="2" @if($m==2) selected @endif>Feb</option>
                                        <option value="3" @if($m==3) selected @endif>Mar</option>
                                        <option value="4" @if($m==4) selected @endif>Apr</option>
                                        <option value="5" @if($m==5) selected @endif>May</option>
                                        <option value="6" @if($m==6) selected @endif>Jun</option>
                                        <option value="7" @if($m==7) selected @endif>Jul</option>
                                        <option value="8" @if($m==8) selected @endif>Aug</option>
                                        <option value="9" @if($m==9) selected @endif>Sep</option>
                                        <option value="10" @if($m==10) selected @endif>Oct</option>
                                        <option value="11" @if($m==11) selected @endif>Nov</option>
                                        <option value="12" @if($m==12) selected @endif>Dec</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <select class="form-control" id="year">
                                        <?php
                                            for($i=2018;$i<=date('Y')+1;$i++)
                                            {
                                                ?>
                                                    <option value="{{$i}}" @if($i==$y) selected @endif>{{ $i }}</option>

                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="com-md-2">
                                <button class="btn btn-primary" onclick="showcalendar();">Show Calendar</button>
                            </div>
                        </div>
                        <div id='calendar'></div>
                        
                    </div>
                  </div>
                </div>
              </div>
            </div>



    </div>
    </div>
   <script type="text/javascript">
        function showcalendar(){
            var year    =   $("#year").val();
            var month    =   $("#month").val();
            location.href ='/calendar/'+month+'/'+year;
        }    
    </script>
@endsection
 
    
    

 