<div class="row">
    <div class="col-sm-3">
        <div class="form-group required">
            <label for="payment_method_type" class="input-label">Hình thức</label>
            <select class="js-select2-custom js-datatable-filter custom-select payment_method_type"
                    style="opacity: 0;" id="payment_method_type" name="payment_method_type" size="1"
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
            <input type="text" class="form-control convert-number" id="amount_vnd"
                   name="amount_vnd" required placeholder="Nhập số tiền VND"
                   value="{{ old('amount_vnđ') }}">
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label for="amount_usd" class="input-label">Số tiền USD (nếu có)</label>
            <input type="number" class="form-control" id="amount_usd" name="amount_usd"
                   placeholder="Nhập số tiền USD" step=".01" value="0">
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label for="rate" class="input-label">Tỉ giá USD (nếu có)</label>
            <input type="text" class="form-control convert-number" id="rate" name="rate"
                   placeholder="Tỉ giá quy đổi USD" value="0">
        </div>
    </div>
</div>

<div class="row payment_online" style="display: none">
    <div class="col-sm-4">
        <div class="form-group pay_bank" style="display: none">
            <label for="bank_name" class="input-label">Tên ngân hàng</label>
            <select class="js-select2-custom custom-select" size="1" style="opacity: 0;" id="bank_name" name="bank_name"
                    disabled data-hs-select2-options='{"placeholder": "Chọn tên ngân hàng",
                    "searchInputPlaceholder": "Search a bank name"}'>
                <option value=""></option>
                @foreach(config('bank.bank_name') as $moduleItem)
                    <option value="{{$moduleItem}}">{{$moduleItem}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group pay_eCash" style="display: none">
            <label for="eCash" class="input-label">Ví điện tử</label>
            <select class="js-select2-custom custom-select" size="1" style="opacity: 0;" id="eCash" name="eCash"
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
            <label for="account" class="input-label">Số tài khoản người nhận</label>
            <input type="number" class="form-control" value="{{old('account')}}"
                   name="account" id="account" placeholder="Số tài khoản">
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="name" class="input-label">Họ và tên chủ tài khoản</label>
            <input type="text" class="form-control " name="name" id="name"
                   value="{{ old('name') }}" placeholder="Tên chủ tài khoản">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="note" class="input-label">Nội dung giao dịch (ghi chú)</label>
            <textarea class="form-control" id="note" name="note" rows="1"
                      placeholder="Mô tả thông tin chi tiết"
                      value="{{ old('note') }}"></textarea>
        </div>
    </div>
</div>
