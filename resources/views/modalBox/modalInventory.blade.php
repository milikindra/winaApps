<div class="modal fade" id="modalInventory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Inventory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table" id="dtModalInventory" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width: 15%" style="text-align: center;">Id</th>
                                <th style="width: 70%" style="text-align: center;">Name</th>
                                <th style="width: 10%" style="text-align: center;">UoM</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var get_inventory = "{{ URL::to('inventory/data/populate') }}";
</script>