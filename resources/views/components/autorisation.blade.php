<div>




    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalDelete"><i
            class="far fa-trash-alt">
        </i> {{__("messages.supprimer")}}</button>


    <div class="modal fade" id="myModalDelete" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <h4 class="modal-title"> {{__("messages.autorisation")}} 
                </h4>
                <span class="autAff" style="color:red; margin-left:20%; font-size:18px;"></span>

                <div class="modal-body">

                    <?php if ($autorisation == 'valide'){?>
                    <form class="form-horizontal" method="POST" action="{{ route('delete-autorisation') }}" id="delete">


                        {{ csrf_field() }}

                        <input type="hidden" name="type" value="{{$type}}">

                        <input type="hidden" name="id" value="{{$id}}">
                        <hr>
                        <div class=" form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label"> {{__("messages.password")}} </label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control">

                            </div>
                            <span class="password_error" style="color:red;">
                            </span>

                        </div>



                        </br>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-danger">{{__("messages.envoyer")}}</button>

                            </div>
                        </div>
                    </form>
                    <?php }else{ ?>

                    <div style=" margin-top:10px; width:465px;" class="alert alert-success alert-dismissible">

                        <h4><i class="icon fas fa-check"></i> {{__("messages.Alert")}} !</h4>
                        
						{{__("messages.info_autorisation ")}}
						
                    </div>

                    <?php }?>
                </div>


            </div>

        </div>
    </div>
</div>