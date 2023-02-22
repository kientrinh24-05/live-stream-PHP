$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Add Income
    $("#addModal").submit(function (event) {
        event.preventDefault();
        addModal('transaction/income/add', '#received_date', '#income_cate','Thu nhập mới');
    });

    // Edit Income
    $('body').on('click', '.action_edit', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        editModal('transaction/income/edit/' + id);
    })

    // Update Income
    $("#editModal").submit(function (e) {
        e.preventDefault();
        let id = $("#id").val();
        updateModal('transaction/income/edit/' + id,'#received_date1','#income_cate1', 'Thu nhập');
    });

    // Show Receipt
    $('body').on('click', '.receipt ', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        show_transaction_detail('transaction/income/edit/'  + id, '#receiptDetailModal');
    })

    $('body').on('click', '.deleteAll', function (event) {
        event.preventDefault();
        let idsArr = [];
        $(".checkbox:checked").each(function () {
            idsArr.push($(this).attr('id'));
        });
        deleteAll(idsArr, 'transaction/income/category/delete/', 'Thu nhập')
    });
});

