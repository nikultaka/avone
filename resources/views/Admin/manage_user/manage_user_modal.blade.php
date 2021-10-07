 <!-- Modal -->
 <div class="modal fade" id="userModal" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title">Add New User</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
            <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none;">
                        <ul></ul>
                    </div>
                    <form id="addNewUserForm" name="addNewUserForm" onsubmit="return false" autocomplete="off">
                        {{ csrf_field() }}
                        <input type ="hidden" id="userHdnID" name="userHdnID" value="">
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Name :</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="userName" id="userName" placeholder="Enter Full Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Email :</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email" required>
                           
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Password :</label>
                            </div>
                            <div class="col-sm-10 password">
                                    <input type="password" class="form-control " name="password" id="password" placeholder="Enter password" required />
                             
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="is_admin">Is Admin :</label>
                            </div>
                            <div class="col-sm-10">
                                <select class="form-control" id="is_admin" name="is_admin" required>
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                </select>
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
                            <button type="submit" class="btn btn-primary" id="addUserBtn">Add</button>
                        </div>
                </form>
            </div>
        </div>

    </div>
</div>


