<div class="row">
    <div class="col-sm-3">
        <div class="form-group required">
            <label for="payment_method_type1" class="input-label">Hình thức</label>
            <select class="js-select2-custom js-datatable-filter custom-select payment_method_type"
                    style="opacity: 0;" id="payment_method_type1" name="payment_method_type1" size="1"
                    data-hs-select2-options='{"minimumResultsForSearch": "Infinity"}' required>
                <option value="Cash" selected>Tiền mặt</option>
                <option value="Transfer">Chuyển khoản</option>
                <option value="E-Cash">Ví điện tử</option>
                <option value="Other">Khác</option>
            </select>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group required">
            <label for="amount_vnd" class="input-label">Số tiền VND</label>
            <input type="text" class="form-control convert-number" id="amount_vnd1"
                   name="amount_vnd" required placeholder="Nhập số tiền VND"
                   value="{{ old('amount_vnd') }}">
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label for="amount_usd" class="input-label">Số tiền USD (nếu có)</label>
            <input type="number" class="form-control" id="amount_usd1" name="amount_usd"
                   placeholder="Nhập số tiền USD" step=".01"
                   value="{{ old('amount_usd') }}">
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label for="rate" class="input-label">Tỉ giá USD (nếu có)</label>
            <input type="text" class="form-control convert-number" id="rate1"
                   name="rate"
                   placeholder="Tỉ giá quy đổi USD" value="{{ old('rate') }}">
        </div>
    </div>
</div>

<div class="row payment_online">
    <div class="col-sm-4">
        <div class="form-group pay_bank" style="display: none">
            <label for="bank_name1" class="input-label">Tên ngân hàng</label>
            <select class="js-select2-custom custom-select" size="1" style="opacity: 0;" id="bank_name1" name="bank_name1"
                    disabled data-hs-select2-options='{"placeholder": "Chọn tên ngân hàng",
                    "searchInputPlaceholder": "Search a bank name"}'>
                <option value=""></option>
                @foreach(config('bank.bank_name') as $moduleItem)
                    <option value="{{$moduleItem}}">{{$moduleItem}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group pay_eCash" style="display: none">
            <label for="eCash1" class="input-label">Ví điện tử</label>
            <select class="js-select2-custom custom-select" size="1" style="opacity: 0;" id="eCash1" name="eCash1"
                    disabled data-hs-select2-options='{"placeholder": "Chọn ví điện tử",
                    "searchInputPlaceholder": "Search a e cash"}'>
                <option value=""></option>
                @foreach(config('bank.vi_dien_tu') as $moduleItem)
                    <option value="{{$moduleItem}}">{{$moduleItem}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="account1" class="input-label">Số tài khoản người nhận</label>
            <input type="number" class="form-control" value="{{old('account')}}"
                   name="account1" id="account1" placeholder="Số tài khoản">
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="name1" class="input-label">Họ và tên chủ tài khoản</label>
            <input type="text" class="form-control " name="name1" id="name1"
                   value="{{ old('name') }}" placeholder="Tên chủ tài khoản">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="note1" class="input-label">Nội dung giao dịch (ghi chú)</label>
            <textarea class="form-control" id="note1" name="note1" rows="1"
                      placeholder="Mô tả thông tin chi tiết"
                      value="{{ old('note') }}"></textarea>
        </div>
    </div>
</div>
