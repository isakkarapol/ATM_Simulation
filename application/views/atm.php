<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__body">
        <!--begin: Search Form -->
        <div class="m-form m-form--label-align-right m--margin-bottom-30">
            <div class="row align-items-center">
                <div class="col-xl-12 order-2 order-xl-1">
                    <div class="form-group m-form__group row align-items-center">
                        <div class="col-md-12">
                            <div class="m-input-icon m-input-icon--left">
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-xl-4 col-6 col-form-label">
                                        How many Bahts you want? : 
                                    </label>
                                    <div class="col-xl-4 col-3">
                                        <input class="form-control m-input" type="text" value="" id="txt_withdraw_cash" onkeypress="return isNumberKey(event);">
                                    </div>
                                    <div class="col-xl-4 col-3">
                                        <button type="button" class="btn btn-outline-success active" id="btn_withdraw_cash" onclick="withdraw();">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end: Search Form -->



<!--begin: Datatable -->
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Remaining of banknote
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">

        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m_datatable" id="m_datatable_avaliable_banknote"></div>
    </div>
</div>
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Withdraw logs
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">

        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m_datatable" id="m_datatable_log_withdraw"></div>
    </div>
</div>

<!--end: Datatable -->


<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (evt.keyCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 37 || charCode > 40))
            return false;
        return true;
    }
    function withdraw() {
        var url = window.location.origin + window.location.pathname + 'Api';
        url = url.replace("Welcome", "");

        var params = {key_request: "d48062f6-1b66-185d-c394-515044961584", withdraw: $('#txt_withdraw_cash').val()};
        $.post(url + '/withdraw', params, function (data, status, result) {
            if (!data.result) {
                swal(
                        'Something went wrong!',
                        data.message,
                        'error'
                        );
            } else {
                swal({
                    title: 'Completed',
                    type: 'success',
                    html: data.message
                })
                jsScript.functionCall('datatableAvaliableBankNote');
                jsScript.functionCall('datatableLogWithdraw');
            }
        }, 'json');
    }
    $(document).ready(function () {
        $('#txt_withdraw_cash').keypress(function (e) {
            if (e.which == 13) {
                withdraw();
            }
        });
    }) // END Jquery Ready
</script>