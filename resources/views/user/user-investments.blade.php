@extends('templates.user')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">My Investments</h4>
        </div>
        <!--end card-header-->
        <div class="card-body ">
         @if(count($investments)==0)
         <div class="text-center">
           <img src="{{asset('user-assets/images/portfolios/investment.png')}}" width="300" />
           <h3 class="text-center">No Active Investments Yet</h3>
            <br>
            <a  href="view-investments-portfolio" class="btn btn-primary btn-outline-dashed ">Start Investment</a>
         </div>
        @else
            @foreach ($investments as $invest)
             @if ($invest->status=="expired" || $invest->status=="error" || $invest->status=="cancelled" )

             @else
                <div class="row mb-3">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="accordion-item">
                                <div class="card-body ">
                                    <div class="text-center">
                                        <div class="row">
                                            <div class="col">
                                                <h1 class="m-0 fw-semibold text-dark font-24 mt-3">
                                                    {{ $invest->packagename }}</h1>
                                                <a href="#" class="text-muted  mb-0 font-13">
                                                    @if ($invest->status=="completed"|| $invest->status=="mismatch")
                                                    <span class="badge badge-outline-success">Active</span>
                                                    @elseif ($invest->status=="pending" )
                                                    <span class="badge badge-outline-warning">Pending</span>
                                                    @elseif ($invest->status=="pending_reinvest" )
                                                    <span class="badge badge-outline-warning">Pending Reinvestment</span>
                                                    @elseif ($invest->status=="expired" )
                                                    <span class="badge badge-outline-danger">Expired</span>
                                                    @elseif ($invest->status=="error" )
                                                    <span class="badge badge-outline-danger">Payment Error</span>
                                                    @elseif ( $invest->status=="cancelled" )
                                                    <span class="badge badge-outline-danger">Payment Cancelled</span>
                                                    @endif
                                                     <span class="text-dark">Category : </span>{{ $invest->category_name }}</a>

                                            </div>
                                            <div class="col-auto">
                                                @if ($invest->status=="pending" || $invest->status=="cancelled"||$invest->status=="expired" )
                                                    <div></div>
                                                @else
                                                <div class="c100 p{{$invest->daysLeft}} small">
                                                    <span class="days">{{ $invest->days }}</span>
                                                    <div class="slice">
                                                        <div class="bar"></div>
                                                        <div class="fill"></div>
                                                    </div>
                                                </div>
                                                <h5 class="mb-0 text-muted">Days Left</h5>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4 d-flex align-items-center">
                                        <div class="col">
                                            <h5 class="font-22 m-0 fw-bold">${{ $invest->amount }}</h5>
                                            <p class="mb-0 text-muted">Amount Invested</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="font-20 m-0 fw-bold">(ROI) ${{ $invest->returns }}</h5>
                                            <p class="mb-0 text-muted">Daily Returns</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="font-20 m-0 fw-bold">{{ $invest->payout }}</h5>
                                            <p class="mb-0 text-muted">Payout</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="font-18 m-0 fw-bold">{{ $invest->duration }} Months</h5>
                                            <p class="mb-0 text-muted">Duration</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="font-14 m-0 fw-bold">{{ $invest->date }}</h5>
                                            <p class="mb-0 text-muted">Investment Date</p>
                                        </div>


                                    </div>
                                    <hr class="hr-dashed hr-menu">
                                    @if ($invest->status=="pending" )
                                    <div></div>
                                    @else
                                    <div class="row mt-4 d-flex align-items-center">
                                        <div class="col-3">
                                            <a href="#" class="accordion-button collapsed shadow-none  px-4" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $invest->investment_id }}"
                                                aria-expanded="false" aria-controls="collapseTwo{{ $invest->investment_id }}">More Details</a>
                                        </div>

                                        <div class="col">
                                            <a href="#" class="btn btn-sm btn-primary  px-4" data-bs-toggle="modal" data-bs-target="#investModalDefault{{ $invest->investment_id }}">Re-invest</a>
                                        </div>

                                        <div class="col">
                                            <a href="#" class="btn btn-sm btn-secondary  px-4">Withdraw capital</a>
                                        </div>

                                        <div class="col">
                                            <a href="#" class="btn btn-sm btn-secondary  px-4">Re-initiate investment</a>
                                        </div>


                                    </div>
                                    @endif
                                </div>
                                <!--end card-body-->
                                <div class="modal fade" id="investModalDefault{{ $invest->investment_id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalDefaultLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title m-0" id="exampleModalDefaultLabel">Reinvest into portfolio
                                                </h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <!--end modal-header-->
                                            <div class="modal-body">
                                                        <form action="{{ route('user.reinvest.store') }}" method="post" class="form-parsley">
                                                            @csrf
                                                            <input type="hidden" value="{{ $invest->investment_id }}" name="investment_id">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="inputAmount">Category</label>
                                                                <input type="disabled" disabled class="form-control"  value="{{ $invest->category_name }}" >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="inputAmount">Investment Portfolio</label>
                                                                <input type="disabled" disabled class="form-control"  value="{{ $invest->packagename }}" >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="inputAmount">Amount Invested</label>
                                                                <input type="disabled" disabled class="form-control"   value="${{ $invest->amount }}" >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="inputAmount">Add Amount</label>
                                                                <input type="decimal" name="amount" placeholder="Add more funds to this portfolio" class="form-control"  >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="inputAmount">Select payment platform</label>
                                                                <select name="payment_method" id="payment_method" class="form-control" required>
                                                                    <option value="">Select Payment Platform</option>
                                                                    <option value="direct_deposit">Direct Deposit</option>
                                                                    <option value="main_wallet">Main Wallet</option>
                                                                    <option value="compound_wallet">Compound Wallet</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-12"  id="currency">
                                                                <label for="currency">Currency</label>
                                                                <select name="currency" class="form-control" >
                                                                    <option value="">Select Currency</option>
                                                                    <option value="BTC">Bitcoin (BTC)</option>
                                                                    <option value="ETH">Ethereum (ETH)</option>
                                                                    <option value="LTC">Litecoin (LTC)</option>
                                                                    <option value="DASH">Dash (DASH)</option>
                                                                    <option value="TZEC">Zcash (TZEC)</option>
                                                                    <option value="DOGE">Dogecoin (DOGE)</option>
                                                                    <option value="BCH">Bitcoin Cash (BCH)</option>
                                                                    <option value="XMR">Monero (XMR)</option>
                                                                    <option value="USDT">Tether (USDT)</option>
                                                                </select>
                                                            </div>

                                                </div>
                                            </div>
                                            <!--end modal-body-->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary btn-sm">Purchase </button>
                                                <button type="button" class="btn btn-soft-danger btn-sm" data-bs-dismiss="modal">Close</button>
                                            </div>
                                            <!--end modal-footer-->
                                            </form>
                                        </div>
                                        <!--end modal-content-->
                                    </div>
                                    <!--end modal-dialog-->
                                </div>
                                <!--end modal-->

                                <div id="collapseTwo{{ $invest->investment_id }}" class="accordion-collapse collapse"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample-faq">
                                    <div class="card m-3">
                                        <div class="accordion-body">
                                            <div class="card-body ">
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead class="bg-dark text-white">
                                                        <tr>
                                                            <th class="text-white">Action</th>
                                                            <th class="text-white">Date</th>
                                                            <th class="text-white">Amount</th>
                                                            <th class="text-white">Status </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($activities as $act)
                                                        @if($invest->investment_id==$act->user_investments_id)
                                                            <tr>
                                                                <td>{{ $act->title }}</td>
                                                                <td>{{ $act->date}}</td>
                                                                <td>${{ $act->amount }}</td>
                                                                @if ($act->category=="earning" || $act->category=="bonus")
                                                                <td > <span class="bg-success p-1 font-10 text-white">CREDITED</span></td>
                                                                @elseif ($act->category=="withdrawals")
                                                                <td > <span class="bg-danger p-1 font-10 text-white">WITHDRAWAL</span></td>
                                                                @elseif ($act->category=="deposit")
                                                                <td > <span class="bg-primary p-1 font-10 text-white">DEPOSIT</span></td>
                                                                @elseif ($act->category=="expired")
                                                                <td > <span class="bg-danger p-1 font-10 text-white">EXPIRED</span></td>
                                                                @elseif ($act->category=="error")
                                                                <td > <span class="bg-danger p-1 font-10 text-white">ERROR</span></td>
                                                                @elseif ($act->category=="cancelled")
                                                                <td > <span class="bg-danger p-1 font-10 text-white">CANCELLED</span></td>
                                                                @endif
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            <!--end card-->
                        </div>
                        <!--accordion end-->
                    </div>
                    <div class="col-md-1"></div>
                </div>
                @endif
            @endforeach
        @endif




        </div>
        <!--end card-body-->
    </div>
    <!--end card-->
    <script src="{{ asset('user-assets/js/jquery.min.js') }}"></script>
<script>
    $("#payment_method").on('change',function(){

        if($(this).val()=="main_wallet" || $(this).val()=="compound_wallet"){
            $("#currency").hide()
        }else{
            $("#currency").show()
        }
    })
</script>

@endsection

