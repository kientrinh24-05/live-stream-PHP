<div class="modal fade" id="showAddModal" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="showAddModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="addModal">@csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading">Create a new expense</h4>
                    <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary"
                            data-dismiss="modal" aria-label="Close">
                        <i class="tio-clear tio-lg"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group required">
                                <label for="payment_date" class="input-label">Thời gian thanh toán</label>
                                <div class="js-flatpickr flatpickr-custom input-group input-group-merge"
                                     id="datePayment" data-hs-flatpickr-options='{"appendTo": "#datePayment",
                                             "dateFormat": "Y-m-d H:i:ss","wrap": true, "enableTime": true, "time_24hr": true}'>
                                    <div class="input-group-prepend" data-toggle="">
                                        <div class="input-group-text"><i class="tio-calendar-month"></i>
                                        </div>
                                    </div>

                                    <input type="text" id="payment_date" name="payment_date" data-input=""
                                           class="flatpickr-custom-form-control form-control" required
                                           placeholder="Ngày giờ thanh toán"
                                           value="{{ old('payment_date') }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="form-group required">
                                <label for="expense_cate" class="input-label">Loại chi phí</label>
                                <select size="1" style="opacity: 0;" id="expense_cate" name="expense_cate"
                                        class="js-select2-custom custom-select" required
                                        data-hs-select2-options='{"searchInputPlaceholder": "Tìm kiếm loại chi phí",
                                                "placeholder": "Chọn loại chi phí thanh toán"}'>
                                    <option value=""></option>
                                    @foreach($category as $cate)
                                        <option value="{{$cate->id}}">{{$cate->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    @include('admin.money.modal.add')

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
