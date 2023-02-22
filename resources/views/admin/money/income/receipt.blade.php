<div class="modal fade" id="receiptDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-top-cover bg-dark text-center">
                <figure class="position-absolute right-0 bottom-0 left-0 ie-modal-curved-shape">
                    <svg preserveaspectratio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                         viewbox="0 0 1920 100.1" style="margin-bottom: -2px;">
                        <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"></path>
                    </svg>
                </figure>

                <div class="modal-close">
                    <button type="button" class="btn btn-icon btn-sm btn-ghost-light" data-dismiss="modal"
                            aria-label="Close"><i class="tio-clear tio-lg"></i>
                    </button>
                </div>
            </div>
            <!-- End Header -->

            <div class="modal-top-cover-icon">
                <span class="icon icon-lg icon-light icon-circle icon-centered shadow-soft">
                  <i class="tio-receipt-outlined"></i>
                </span>
            </div>

            <!-- Body -->
            <div class="modal-body pt-3 pb-sm-5 px-sm-5">
                <div class="text-center mb-7">
                    <h2 class="mb-1">Payment Receipt</h2>
                    <span class="d-block bank_info"></span>
                </div>

                <div class="row mb-6">
                    <div class="col-md-4 mb-3">
                        <small class="text-cap">VND Amount:</small>
                        <span class="text-dark vnd_amount"></span>
                    </div>

                    <div class="col-md-4 mb-3">
                        <small class="text-cap">USD Amount:</small>
                        <i class="tio-dollar mr-1"></i>
                        <span class="text-dark usd_amount"></span>
                    </div>

                    <div class="col-md-4 mb-3">
                        <small class="text-cap">Payment method:</small>
                        <div class="d-flex align-items-center">
                            <img class="avatar avatar-xss avatar-4by3 mr-2 payment_method_icon" alt="Payment method"
                                  src="">
                            <span class="text-dark payment_method"></span>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6 text-left">
                        <small class="text-cap">Summary</small>
                    </div>

                    <div class="col-md-6 text-right">
                        <small class="text-cap created_at"></small>
                    </div>
                </div>

                <ul class="list-group mb-10">
                    <li class="list-group-item text-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Details of Payment</span>
                            <span class="payment_to"></span>
                        </div>
                    </li>

                    <li class="list-group-item text-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Amount (USD - VND)</span>
                            <span class="amount_usd_vnd"></span>
                        </div>
                    </li>

                    <li class="list-group-item text-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Exchange rate</span>
                            <span class="exchange_rate"></span>
                        </div>
                    </li>

                    <li class="list-group-item text-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Payment description</span>
                            <span class="details"></span>
                        </div>
                    </li>

                    <li class="list-group-item list-group-item-light text-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Amount received</span>
                            <span class="font-weight-bold amount_paid"></span>
                        </div>
                    </li>
                </ul>

                <div class="row justify-content-lg-between">
                    <div class="col-md-3 col-lg-3 order-md-1 align-self-center">
                        <p class="small text-muted mb-0">&copy; Tribe Team.</p>
                    </div>
                    <div class="col-md-6 col-lg-6 order-md-1 text-center align-self-center">
                        <p class="small text-muted mb-0"><i class="tio-email mr-2"></i>Email: support@idoltainang.com
                        </p>
                    </div>
                    <div class="col-md-3 col-lg-3 order-md-1 text-right align-self-center">
                        <p class="small text-muted mb-0"><i class="tio-call-talking mr-2"></i>0349368866</p>
                    </div>
                </div>

                <hr class="my-1 mb-5">

                <div class="d-flex justify-content-end">
                    <a class="btn btn-white mr-2" href="#">
                        <i class="tio-download-to mr-1"></i> PDF
                    </a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
                </div>
            </div>
            <!-- End Body -->
        </div>
    </div>
</div>
