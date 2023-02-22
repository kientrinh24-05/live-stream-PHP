$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Tiền thu nhập nhỏ hơn Đến số tiền
    $.validator.addMethod("lessThanCurrent", function (value, element) {
        var item = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/\D/g, "");
        var params = $("#filter3").val().replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/\D/g, "");

        if (params !== '' || params > item) {
            if (!/Invalid|NaN/.test(item)) {
                return item <= params;
            }

            return isNaN(item) && isNaN(params) || (Number(item) <= Number(params));
        } else {
            return true;
        }
    }, 'Phải nhỏ hơn hoặc bằng "Đến số tiền".');

    // Đến số tiền lớn hơn Tiền thu nhập, Tiền thanh toán
    $.validator.addMethod("greaterThanCurrent", function (value, element) {
        var item = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/\D/g, "");
        var params = $("#filter2").val().replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/\D/g, "");

        if (params !== '' || params > item) {
            if (!/Invalid|NaN/.test(item)) {
                return item >= params;
            }

            return isNaN(item) && isNaN(params) || (Number(item) >= Number(params));
        } else {
            return true;
        }
    }, 'Phải lớn hơn hoặc bằng "' + $('#money_filter').text() + ' "');

    // validate form
    // =======================================================
    $("#filter").validate({
        rules: {
            filter1: {
                date: true
            },
            filter2: {
                required: function (element) { // Bắt buộc nhập nếu filter2 khác rỗng
                    return $("#filter3").val() !== "";
                },
                lessThanCurrent: true
            },
            filter3: {
                required: function (element) { // Bắt buộc nhập nếu filter2 khác rỗng
                    return $("#filter2").val() !== "";
                },
                greaterThanCurrent: true
            },
            datatableSearch: {
                maxlength: 255
            },
            start_date: {
                date: true,
                lessThan: '#end_date'
            },
            end_date: {
                required: function (element) { // Bắt buộc nhập nếu start_date khác rỗng
                    return $("#start_date").val() !== "";
                },
                date: true,
                greaterThan: "#start_date"
            }
        },
        messages: {
            filter1: {
                date: 'Không đúng định dạng ngày tháng.',
            },
            filter2: {
                required: 'Trường này bắt buộc nhập.'
            },
            filter3: {
                required: 'Trường này bắt buộc nhập.'
            },
            datatableSearch: {
                maxlength: 'Tối đa 255 ký tự.'
            },
            start_date: {
                date: 'Không đúng định dạng ngày tháng'
            },
            end_date: {
                date: 'Không đúng định dạng ngày tháng',
            }
        }
    });

    $("#addModal").validate({
        rules: {
            payment_date: {
                required: true,
                date: true
            },
            expense_cate: {
                required: true
            },
            received_date: {
                required: true,
                date: true
            },
            income_cate: {
                required: true
            },
            amount_vnd: {
                required: true
            },
            bank_name: {
                required: function (element) {
                    return $("#account").val() !== "" || $("#name").val() !== "";
                }
            },
            account: {
                required: function (element) {
                    return $("#bank_name").val() !== "" || $("#name").val() !== "";
                }
            },
            name: {
                required: function (element) {
                    return $("#account").val() !== "" || $("#bank_name").val() !== "";
                }
            }
        },
        messages: {
            payment_date: {
                required: 'Bạn chưa nhập ngày giờ thanh toán',
                date: 'Không đúng định dạng ngày tháng.'
            },
            expense_cate: {
                required: 'Bạn chưa chọn loại chi phí.'
            },
            received_date: {
                required: 'Bạn chưa nhập ngày giờ nhận thu nhập',
                date: 'Không đúng định dạng ngày tháng.'
            },
            income_cate: {
                required: 'Bạn chưa chọn loại thu nhập.'
            },
            amount_vnd: {
                required: 'Bạn chưa nhập số tiền.'
            },
            bank_name: {
                required: 'Bạn chưa chọn ngân hàng, ví điện tử.'
            },
            account: {
                required: 'Bạn chưa nhập số tài khoản.'
            },
            name: {
                required: 'Bạn chưa nhập họ và tên.'
            }
        }
    });

    $("#editModal").validate({
        rules: {
            payment_date1: {
                required: true,
                date: true
            },
            expense_cate1: {
                required: true
            },
            received_date1: {
                required: true,
                date: true
            },
            income_cate1: {
                required: true
            },
            amount_vnd1: {
                required: true
            },
            bank_name1: {
                required: function (element) {
                    return $("#account1").val() !== "" || $("#name1").val() !== "";
                }
            },
            account1: {
                required: function (element) {
                    return $("#bank_name1").val() !== "" || $("#name1").val() !== "";
                }
            },
            name1: {
                required: function (element) {
                    return $("#account1").val() !== "" || $("#bank_name1").val() !== "";
                }
            }
        },
        messages: {
            payment_date1: {
                required: 'Bạn chưa nhập ngày giờ thanh toán',
                date: 'Không đúng định dạng ngày tháng.'
            },
            expense_cate1: {
                required: 'Bạn chưa chọn loại chi phí.'
            },
            received_date1: {
                required: 'Bạn chưa nhập ngày giờ nhận thu nhập',
                date: 'Không đúng định dạng ngày tháng.'
            },
            income_cate1: {
                required: 'Bạn chưa chọn loại thu nhập.'
            },
            amount_vnd1: {
                required: 'Bạn chưa nhập số tiền.'
            },
            bank_name1: {
                required: 'Bạn chưa chọn ngân hàng, ví điện tử.'
            },
            account1: {
                required: 'Bạn chưa nhập số tài khoản.'
            },
            name1: {
                required: 'Bạn chưa nhập họ và tên.'
            }
        }
    });

    // Thay đổi giao diện khi đổi phương thức thanh toán
    $('body').on('change', '.payment_method_type', function (event) {
        event.preventDefault();
        if ($(this).val() === 'Cash' || $(this).val() === 'Other') {
            $('.payment_online').css('display', 'none').find(':input').val('').trigger("change").attr('disabled', '');
        } else {
            $('.payment_online').removeAttr('style').find(':input').val('').trigger("change").removeAttr('disabled');
            if ($(this).val() === 'Transfer') {
                $('.pay_bank').css('display', 'block');
                $('.pay_eCash').css('display', 'none');
                $('#eCash').attr('disabled', '');
            }
            if ($(this).val() === 'E-Cash') {
                $('.pay_eCash').css('display', 'block');
                $('.pay_bank').css('display', 'none');
                $('#bank_name').attr('disabled', '');
            }
        }
    });

    // Thay đổi giao diện khi Click action edit mà hình thức thanh toán thay đổi
    $('body').on('click', '.action_edit', function (event) {
        event.preventDefault();
        $('#payment_method_type1').change(function () {
            $('#payment_method_type').val($('#payment_method_type1').val()).trigger("change");
        })
    })

    $('input.convert-number').keyup(function (event) {
        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40) return;

        // format number
        $(this).val(function (index, value) {
            return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
    });
});

function show_transaction_detail(url, modal) {
    $.get(url, function (data) {
        $("#id").val(data.id);
        if (data.description.account !== null && data.description.name !== null && data.description.bank !== null) {
            $(".bank_info").text(data.description.account + ' - ' + data.description.name + ' - ' + data.description.bank);
        } else {
            $(".bank_info").text('');
        }
        $(".vnd_amount").text((data.amount_vnd).toLocaleString());
        $(".usd_amount").text((data.amount_usd).toLocaleString());
        if (data.description.type === 'E-Cash') {
            $('.payment_method_icon').attr("src", '/assets/images/vi_dien_tu.png');
            $(".payment_method").text('Ví điện tử');
        } else if (data.description.type === 'Transfer') {
            $('.payment_method_icon').attr("src", '/assets/images/chuyen_khoan.png');
            $(".payment_method").text('Chuyển khoản');
        } else if (data.description.type === 'Cash') {
            $('.payment_method_icon').attr("src", '/assets/images/tien_mat.png');
            $(".payment_method").text('Tiền mặt');
        } else {
            $('.payment_method_icon').attr("src", '/assets/images/payment_khac.jpg');
            $(".payment_method").text('Không xác định');
        }
        if (data.title === 'Income') {
            $(".created_at").text(data.received_date);
        } else if (data.title === 'Expense') {
            $(".created_at").text(data.payment_date);
        } else {
            alert('Lỗi không xác định');
        }
        $(".payment_to").text(data.category[0].name);
        $(".amount_usd_vnd").text((data.amount_usd).toLocaleString() + ' USD - ' + (data.amount_vnd).toLocaleString() + ' VND');
        $(".exchange_rate").text((data.rate).toLocaleString() + ' VND');
        $(".details").text(data.description.note);
        $(".amount_paid").text((data.amount_vnd).toLocaleString() + ' VND');
        $(modal).modal('toggle');
    });
}

function checkPaymentOnline(method, bank, ecash) {
    let bank_name;
    if ($(method).val() === 'Transfer') {
        bank_name = $(bank).val();
    } else if ($(method).val() === 'E-Cash') {
        bank_name = $(ecash).val();
    } else {
        bank_name = "";
    }

    return bank_name;
}

function addModal(url, date, cate, label) {
    $.ajax({
        url: url,
        type: "POST",
        data: {
            date: $(date).val(),
            cate: $(cate).val(),
            payment_method_type: $("#payment_method_type").val(),
            amount_vnd: $("#amount_vnd").val().replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/\D/g, ""),
            amount_usd: $("#amount_usd").val(),
            rate: $("#rate").val().replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/\D/g, ""),
            bank_name: checkPaymentOnline('#payment_method_type', '#bank_name', '#eCash'),
            account: $("#account").val(),
            name: $("#name").val(),
            note: $("#note").val()
        },
        success: function (data) {
            if (data.code === 200) {
                $('#datatable').DataTable().ajax.reload();
                toastr.success(label + ' được thêm thành công.', 'Thêm mới thành công');
                Swal.fire('Thêm mới', label + ' được thêm thành công.', 'success');
                $("#showAddModal").modal('hide');
                $("#addModal")[0].reset();
            }
        },
        error: function (data) {
            let errors = data.responseJSON;
            let errorsHtml = "";
            $.each(errors, function (key, value) {
                errorsHtml += "<li>" + value[0] + "</li>";
            });
            toastr.error(errorsHtml, "Thêm mới lỗi!");
            Swal.fire("Error!", errorsHtml, "error");
        }
    });
}

function editModal(url) {
    $.get(url, function (data) {
        $("#id").val(data.id);
        checkIE(data);
        $("#payment_method_type1").val(data.description.type).trigger('change');
        $("#amount_vnd1").val((data.amount_vnd).toLocaleString());
        $("#amount_usd1").val(data.amount_usd);
        $("#rate1").val((data.rate).toLocaleString());
        if (data.description.type === 'Transfer') {
            $("#bank_name1").val(data.description.bank).trigger('change');
        }
        if (data.description.type === 'E-Cash') {
            $("#eCash1").val(data.description.bank).trigger('change');
        }
        $("#account1").val(data.description.account);
        $("#name1").val(data.description.name);
        $("#note1").val(data.description.note);
        $("#showEditModal").modal('toggle');
    });
}

function checkIE(data) {
    if (data.title === 'Income') {
        $("#received_date1").val(data.received_date);
        $("#income_cate1").val(data.income_cate).trigger('change');
    } else if (data.title === 'Expense') {
        $("#payment_date1").val(data.payment_date);
        $("#expense_cate1").val(data.expense_cate).trigger('change');
    } else {
        alert('Lỗi không xác định');
    }
}

function updateModal(url, date, cate, label) {
    $.ajax({
        url: url,
        type: "PUT",
        data: {
            date: $(date).val(),
            cate: $(cate).val(),
            payment_method_type: $("#payment_method_type1").val(),
            amount_vnd: $("#amount_vnd1").val().replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/\D/g, ""),
            amount_usd: $("#amount_usd1").val(),
            rate: $("#rate1").val().replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/\D/g, ""),
            bank_name: checkPaymentOnline('#payment_method_type1', '#bank_name1', '#eCash1'),
            account: $("#account1").val(),
            name: $("#name1").val(),
            note: $("#note1").val()
        },
        success: function (data) {
            if (data.code === 200) {
                $('#datatable').DataTable().ajax.reload();
                toastr.success(label + ' được cập nhật thành công.', 'Cập nhật thành công');
                Swal.fire('Cập nhật', label + ' được cập nhật thành công.', 'success');
                $("#showEditModal").modal('hide');
                $("#editModal")[0].reset();
            }
        },
        error: function (data) {
            let errors = data.responseJSON;
            let errorsHtml = "";
            $.each(errors, function (key, value) {
                errorsHtml += "<li>" + value[0] + "</li>";
            });
            toastr.error(errorsHtml, "Cập nhật lỗi!");
            Swal.fire("Error!", errorsHtml, "error");
        }
    });
}
