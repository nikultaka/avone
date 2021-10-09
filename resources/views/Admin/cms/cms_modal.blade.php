 <!-- Modal -->
 <div class="modal fade" id="cmsModal" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title">Add Cms</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
            <div class="modal-body">
                <form onsubmit="return false" method="post" id="addcmsform" class="needs-validation" novalidate name="addcmsform">
                    {{ csrf_field() }}
                    <input type="hidden" id="hid" name="hid" value="{{isset($edit_cms->id) ? $edit_cms->id : ''}}">
                        <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="title">Title :</label>
                                </div>
                                <div class="col-sm-10">
                                   <input type="text" class="form-control" id="title" name="title"  placeholder="Enter Title" value="{{isset($edit_cms->title) ? $edit_cms->title : ''}}" required>

                                </div>
                        </div>
                        <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="Slug">Slug</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter Slug" value="{{isset($edit_cms->slug) ? $edit_cms->slug : ''}}" required>

                                </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="description">Description Editor</label>
                            </div>
                            <div class="col-sm-10">
                                <textarea id="description" class="form-control" required class="editor" name="description" rows="10" cols="80" >{{isset($edit_cms->descriptioneditor) ? $edit_cms->descriptioneditor : ''}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="metatitle">Meta Title</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="metatitle" name ="metatitle"  placeholder="Enter Meta Title" value="{{isset($edit_cms->metatitle) ? $edit_cms->metatitle : ''}}" >

                                </div>
                        </div>
                        <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="metakeyword">Meta Keyword</label>
                                </div>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="metakeyword" name = "metakeyword" placeholder="Enter Meta Keyword" value="{{isset($edit_cms->metakeyword) ? $edit_cms->metakeyword : ''}}" >

                              </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="metadescription">Meta Description</label>
                            </div>
                            <div class="col-sm-10">
                               <textarea class="form-control" id="metadescription" name= "metadescription" rows="5" >{{isset($edit_cms->metadescription) ? $edit_cms->metadescription : ''}}</textarea>
                            </div>  
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="status">Status:</label>
                            </div>
                            <div class="col-sm-10">
                                <select class="form-control" id="status" name="status" value="{{isset($edit_cms->status) ? $edit_cms->status : ''}}" >
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>

                            </div>
                        </div>
                        <button type="submit" id="addcms" name="addcms" class="btn btn-primary">Submit</button>
                        <button type="submit" class="btn btn-secondary">Cancle</button>
                 </form>
            </div>
        </div>

    </div>
</div>