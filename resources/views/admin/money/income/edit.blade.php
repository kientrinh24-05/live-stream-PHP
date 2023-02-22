<div class="modal fade" id="showEditModal" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="showEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editModal">@csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading">Cập nhật thu nhập</h4>
                    <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary"
                            data-dismiss="modal" aria-label="Close"><i class="tio-clear tio-lg"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group required">
                                <label for="received_date" class="input-label">Thời gian nhận thu nhập</label>
                                <div class="js-flatpickr flatpickr-custom input-group input-group-merge"
                                     id="dateReceived1" data-hs-flatpickr-options='{"appendTo": "#dateReceived1",
                                             "dateFormat": "Y-m-d H:i:ss", "wrap": true, "enableTime": true, "time_24hr": true}'>
                                    <div class="input-group-prepend" data-toggle="">
                                        <div class="input-group-text"><i class="tio-calendar-month"></i>
                                        </div>
                                    </div>

                                    <input type="text" id="received_date1" name="received_date" data-input=""
                                           class="flatpickr-custom-form-control form-control" required
                                           placeholder="Ngày giờ nhận thu nhập"
                                           value="{{ old('received_date') }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="form-group required">
                                <label for="income_cate" class="input-label">Loại thu nhập</label>
                                <select size="1" style="opacity: 0;" id="income_cate1" name="income_cate"
                                        class="js-select2-custom custom-select" required
                                        data-hs-select2-options='{"searchInputPlaceholder": "Tìm kiếm loại thu nhập",
                                                "placeholder": "Chọn loại thu nhập"}'>
                                    <option value=""></option>
                                    @foreach($category as $cate)
                                        <option value="{{$cate->id}}">{{$cate->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    @include('admin.money.modal.edit')

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
