$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Add Expense
    $("#addModal").submit(function (event) {
        event.preventDefault();
        addModal('transaction/expense/add', '#payment_date', '#expense_cate','Chi phí thanh toán mới');
    });

    // Edit Expense
    $('body').on('click', '.action_edit', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        editModal('transaction/expense/edit/' + id);
    })

    // Update Expense
    $("#editModal").submit(function (e) {
        e.preventDefault();
        let id = $("#id").val();
        updateModal('transaction/expense/edit/' + id,'#payment_date1','#expense_cate1', 'Chi phí thanh toán');
    });

    // Show Invoice
    $('body').on('click', '.invoice', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        show_transaction_detail('transaction/expense/edit/' + id, '#invoiceDetailModal');
    })

    $('body').on('click', '.deleteAll', function (event) {
        event.preventDefault();
        let idsArr = [];
        $(".checkbox:checked").each(function () {
            idsArr.push($(this).attr('id'));
        });
        deleteAll(idsArr, 'transaction/expense/category/delete/', 'Chi phí thanh toán')
    });

})
;

