{{-- Show detail Modal --}}
<div class="modal fade" id="invoiceModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background-image: url(/assets/svg/components/abstract-shapes-18.svg);">
            <div class="modal-close">
                <button type="button" class="btn btn-icon btn-sm" data-dismiss="modal"
                        aria-label="Close"><i class="tio-clear tio-lg"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="bg-img-hero">
                    <div class="text-center mb-7">
                        <h1 class="text-primary">
                            <img class="mb-2" src="../../assets/svg/logos/logo-short.svg" alt="Logo">
                            <span class="titleType"></span>
                        </h1>
                    </div>

                    <!-- Bill To -->
                    <div class="mb-3">
                        <h3 id="category"></h3>
                    </div>
                    <div class="row justify-content-md-between mb-7">
                        <div class="col-md-7 col-lg-7">
                            <h3>Bill to: Tribe Team</h3>
                            <address class="text-body mb-0">179 Trương Định, Hoàng Mai, Hà Nội</address>
                        </div>

                        <div class="col-md-5 col-lg-4">
                            <dl class="row">
                                <dt class="col-7 col-md-6 text-body">Start date:</dt>
                                <dd class="col-5 col-md-6 text-dark font-weight-bold" id="start_date"></dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-7 col-md-6 text-body">End date:</dt>
                                <dd class="col-5 col-md-6 text-dark font-weight-bold" id="end_date"></dd>
                            </dl>
                        </div>
                    </div>
                    <!-- End Bill To -->

                    <!-- Table -->
                    <div class="table-responsive-lg">
                        <table class="table table-align-middle table-heighlighted font-size-1 mb-0">
                            <thead class="thead-light text-center">
                            <tr class="text-uppercase text-body">
                                <th scope="col" class="font-weight-bold">Code</th>
                                <th scope="col" class="font-weight-bold pay_re"></th>
                                <th scope="col" class="font-weight-bold">VND</th>
                                <th scope="col" class="font-weight-bold">USD</th>
                                <th scope="col" class="font-weight-bold">Rate</th>
                                <th scope="col" class="font-weight-bold">Type</th>
                                <th scope="col" class="font-weight-bold">Note</th>
                            </tr>
                            </thead>
                            <tbody class="text-dark text-center" id="item_money"></tbody>
                        </table>
                    </div>
                    <!-- End Table -->

                    <!-- Total -->
                    <div class="border-top border-dark pt-2 mb-9 h4">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-dark pl-2">Total</div>
                            </div>
                            <div class="col-6 text-right">
                                <div class="text-dark pr-2" id="sum"></div>
                            </div>
                        </div>
                    </div>
                    <!-- End Total -->

                    <!-- Contacts -->
                    <div class="mb-7">
                        <h3>Thank you!</h3>
                        <p>If you have any questions, please contact us.</p>
                    </div>
                    <!-- End Contacts -->

                    <div class="row justify-content-lg-between">
                        <div class="col-md-3 col-lg-3 order-md-1 align-self-center">
                            <p class="small text-muted mb-0">&copy; Tribe Team.</p>
                        </div>
                        <div class="col-md-6 col-lg-6 order-md-1 text-center align-self-center">
                            <p class="small text-muted mb-0"><i class="tio-email mr-2"></i>Email:
                                support@idoltainang.com</p>
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
            </div>
        </div>
    </div>
</div>


