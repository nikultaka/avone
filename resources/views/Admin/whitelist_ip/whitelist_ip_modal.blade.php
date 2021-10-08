 <!-- Modal -->
 <div class="modal fade" id="whitelistIpModal" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title">Add Whitelist Ip</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
            <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none;">
                        <ul></ul>
                    </div>
                    <form id="whitelistIpForm" name="whitelistIpForm" onsubmit="return false" autocomplete="off">
                        {{ csrf_field() }}
                        <input type ="hidden" id="ipHdnID" name="ipHdnID" value="">
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Ip Address:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ipName" id="ipName" placeholder="Enter Whitelist Ip Address" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="status">Status :</label>
                            </div>
                            <div class="col-sm-10">
                                <select class="form-control" id="status" name="status">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="addWhitelistIpBtn">Add</button>
                        </div>
                </form>
            </div>
        </div>

    </div>
</div>


