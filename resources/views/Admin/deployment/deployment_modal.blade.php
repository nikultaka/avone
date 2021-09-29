 <!-- Modal -->
 <div class="modal fade" id="deploymentModal" role="dialog">
     <div class="modal-dialog modal-xl">
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Deployment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
             <div class="modal-body">
                 <form id="addNewDeploymentForm" name="addNewDeploymentForm" onsubmit="return false">
                    <h3><b>Name</b></h3>
                    <div class="form-group">
                        <input type="text" class="form-control" id="deploymentName" name="deploymentName" placeholder="My Deployment">
                      </div>
                      <hr>
            {{-- --------------------------------------------------------------------------------------- --}}
                    <h3><b>Elasticsearch</b></h3>
                    <b>Hot data and Content tier:</b>
                    <p>Nodes in this tier ingest and process frequently queried data.</p>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2">
                                <label for="sizePerZone">Size per zone</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" id="sizePerZoneElastic">
                                    <option disabled value="4096">45 GB storage  | 1 GB RAM | Up to 2.5 vCPU</option>
                                    <option disabled value="4096">90 GB storage  | 2 GB RAM | Up to 2.5 vCPU</option>
                                    <option selected value="4096">180 GB storage | 4 GB RAM | Up to 2.5 vCPU</option>
                                  </select>
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2">
                                <label for="Availability zones">Availability zones</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="1zoneElastic" name="availabilityZonesElastic" class="custom-control-input" value ="1">
                                    <label class="custom-control-label" for="1zoneElastic"> 1 zone</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="2zoneElastic" name="availabilityZonesElastic" class="custom-control-input" value ="2" checked="true">
                                    <label class="custom-control-label" for="2zoneElastic"> 2 zone</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="3zoneElastic" name="availabilityZonesElastic" class="custom-control-input" value ="3" disabled>
                                    <label class="custom-control-label" for="3zoneElastic"> 3 zone</label>
                                </div>
                            </div>
                        </div>
                      </div>
                      <hr>
                {{-- --------------------------------------------------------------------------------------- --}}
                    <h3><b>Kibana</b></h3>
                    <b>Kibana nodes:</b>                    </b>
                    <p>Visualize data and interact with the Elastic Stack.</p>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2">
                                <label for="sizePerZoneKibana">Size per zone</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" id="sizePerZoneKibana">
                                    <option selected value="1024">1 GB storage    |     Up to 8 vCPU</option>
                                    <option disabled value="1024">2 GB storage    |     Up to 8 vCPU</option>
                                    <option disabled value="1024">4 GB storage   |     Up to 8 vCPU</option>
                                  </select>
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2">
                                <label for="Availability Zones Kibana">Availability zones</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="1zoneKibana" name="availabilityZonesKibana" class="custom-control-input" value ="1" checked="true">
                                    <label class="custom-control-label" for="1zoneKibana"> 1 zone</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="2zoneKibana" name="availabilityZonesKibana" class="custom-control-input" value ="2" disabled>
                                    <label class="custom-control-label" for="2zoneKibana"> 2 zone</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="3zoneKibana" name="availabilityZonesKibana" class="custom-control-input" value ="3" disabled>
                                    <label class="custom-control-label" for="3zoneKibana"> 3 zone</label>
                                </div>
                            </div>
                        </div>
                      </div>
                      <hr>
                      {{-- --------------------------------------------------------------------------------------- --}}
                    <h3><b>APM & Fleet</b></h3>
                    <b>APM & Fleet nodes:</b>
                    <p>Enable APM and centrally manage Elastic Agents with Fleet Server.</p>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2">
                                <label for="sizePerZoneApm">Size per zone</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" id="sizePerZoneApm">
                                    <option selected value="1024">1 GB storage    |     Up to 8 vCPU</option>
                                    <option disabled value="1024">2 GB storage    |     Up to 8 vCPU</option>
                                    <option disabled value="1024">4 GB storage    |     Up to 8 vCPU</option>
                                  </select>
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2">
                                <label for="Availability Zones Apm">Availability zones</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="1zoneApm" name="availabilityZonesApm" class="custom-control-input" value ="1" checked="true">
                                    <label class="custom-control-label" for="1zoneApm"> 1 zone</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="2zoneApm" name="availabilityZonesApm" class="custom-control-input" value ="2" disabled>
                                    <label class="custom-control-label" for="2zoneApm"> 2 zone</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="3zoneApm" name="availabilityZonesApm" class="custom-control-input" value ="3" disabled>
                                    <label class="custom-control-label" for="3zoneApm"> 3 zone</label>
                                </div>
                            </div>
                        </div>
                      </div>
 
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-success" id="addNewDeploymentBtn">Add</button>
                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
             </div>
         </div>

     </div>
 </div>


