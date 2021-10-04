 <!-- Modal -->
 <div class="modal fade" id="deploymentDataModal" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title">Deployment Data</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm bg-light">
                            <h4 class="text-center"><b>Elastic search</b></h4>
                            <table class="table table-bordered">
                                    <tr>
                                        <th>Cluster Id :</th>
                                        <td><div id="clusterIdElasticSearch"></div></td>
                                    </tr>
                                    <tr>
                                        <th>Cluster Name :</th>
                                        <td><div id="clusterNameElasticSearch"></div></td>
                                    </tr>
                                    <tr>
                                        <th>Status :</th>
                                        <td><div id="statusElasticSearch"></div></td>
                                    </tr>
                              </table>
                    </div>
                    <div class="col-sm bg-light">
                            <h4 class="text-center"><b>Kibana</b></h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Cluster Id :</th>
                                    <td><div id="clusterIdKibana"></div></td>
                                </tr>
                                <tr>
                                    <th>Cluster Name :</th>
                                    <td><div id="clusterNameKibana"></div></td>
                                </tr>
                                <tr>
                                    <th>Status :</th>
                                    <td><div id="statusKibana"></div></td>
                                </tr>
                          </table>
                    </div>
                    <div class="col-sm bg-light">
                         <h4 class="text-center"><b>APM & Fleet</b></h4>
                         <table class="table table-bordered">
                            <tr>
                                <th>Cluster Id :</th>
                                <td><div id="clusterIdApn"></div></td>
                            </tr>
                            <tr>
                                <th>Cluster Name :</th>
                                <td><div id="clusterNameApn"></div></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td><div id="statusApn"></div></td>
                            </tr>
                      </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


