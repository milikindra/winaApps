<div class="modal fade" id="modalGenerelLedger" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">General Ledger</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="col-md-12 row">
                        <div class="col-md-2"><input class="form-control form-control-sm" type="date" id="sdateGeneralLedger" min="2018-01-01" value="2018-01-01"></div>
                        <div class="col-md-2"><input class=" form-control form-control-sm" type="date" id="edateGeneralLedger" max="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}"></div>
                    </div>
                    <br />
                    <table class="table tableModalGeneralLedger minpadding" id="tableModalGeneralLedger" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th>Transaction</th>
                                <th>No. Account</th>
                                <th>Account Name</th>
                                <th>Transaction Number</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Debet (IDR)</th>
                                <th>Credit (IDR)</th>
                                <th>Debet (Valas)</th>
                                <th>Credit (Valas)</th>
                                <th>Dept</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" modal-footer ">
                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>