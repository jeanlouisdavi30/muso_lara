@extends('tmp.muso')

@section('content')

<div class="row-fluid">


    <?php $info = DB::table('musos')->where('users_id',Auth::user()->id)->first();  $id_musos = $info->id; ?>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-9">

                    <div class="alert  alert-dismissible col-md-7">
                        <h2>
                            REMBOURSEMENT </h2>
                    </div>
                    <div class="card">



                        <div class="card-body">



                            <div class="tab-pane">

                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
                                </script>


                                <div class="row">
                                    <div class="col-md-6">
                                        <script type="text/javascript">
                                        function fetch_select(val) {
                                            $.ajax({
                                                type: 'post',
                                                url: 'http://localhost/muso_app/public/remboursement.blade.php',
                                                data: {
                                                    get_option: val
                                                },
                                                success: function(response) {
                                                    document.getElementById("new_select").innerHTML =
                                                        response;
                                                }
                                            });
                                        }

                                        function sumeBalance() {


                                            var balanceBN = document.getElementById('balanceBN').value;
                                            var mpayeb = document.getElementById('mpayeb').value;

                                            if (parseFloat(balanceBN) === parseFloat(mpayeb)) {
                                                document.getElementById('balance_ver_b').value = 0;

                                            }
                                        }

                                        function sumeEmprunt() {

                                            var intere_mensuel = document.getElementById('intere_mensuel').value;
                                            var ppayer = document.getElementById('ppayer').value;

                                            var mpaye = document.getElementById('mpaye').value;
                                            var ttalmensuel = document.getElementById('ttalmensuel').value;

                                            if (parseFloat(mpaye) === parseFloat(ttalmensuel)) {
                                                document.getElementById('balance_ver').value = 0;
                                                document.getElementById('inmensuel').value = intere_mensuel;
                                                document.getElementById('ppayer').value = parseFloat(ttalmensuel) -
                                                    parseFloat(intere_mensuel);;
                                            } else if (parseFloat(mpaye) < parseFloat(ttalmensuel)) {

                                                if (parseFloat(mpaye) < parseFloat(intere_mensuel)) {
                                                    document.getElementById('inmensuel').value = mpaye
                                                } else if (parseFloat(intere_mensuel) == parseFloat(mpaye)) {
                                                    document.getElementById('inmensuel').value = intere_mensuel;
                                                } else {
                                                    document.getElementById('ppayer').value = parseFloat(mpaye) -
                                                        parseFloat(intere_mensuel);
                                                    document.getElementById('inmensuel').value = intere_mensuel;
                                                }
                                                var result = parseFloat(ttalmensuel) - parseFloat(mpaye);
                                                document.getElementById('balance_ver').value = result;

                                            } else if (parseFloat(mpaye) > parseFloat(ttalmensuel)) {

                                                document.getElementById('balance_ver').value = 0;
                                            }



                                        }
                                        </script>



                                        @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif

                                        @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                        @endif


                                        <span class="autAff" style="color:red; margin-left:20%; font-size:18px;"></span>

                                        <!-- /.card-header -->


                                        <form method="post" action="{{ route('save-remboursement') }}"
                                            accept-charset="utf-8" enctype="multipart/form-data">


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Emprunt</label>
                                                <select name="emprunt_apayers_id" class="form-control"
                                                    onchange="fetch_select(this.value);">


                                                    <option value=""> Selectionner emprunt </option>
                                                    @if(!empty($all_emprunt))
                                                    @foreach($all_emprunt as $key)
                                                    <option value="{{ $key->id }}">
                                                        {{ $key->titre }} , {{ $key->date_decaissement }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>

                                            </div>


                                            @csrf


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Date</label>
                                                <input type="date" name="date_pay" class="form-control"
                                                    id="exampleInputEmail1" placeholder="">
                                                @error('date_pay')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1"># PC</label>
                                                <input type="text" name="numeropc" class="form-control" id="montant"
                                                    placeholder="">
                                                @error('numeropc')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>




                                            <div class="form-group">
                                                <span id="new_select">
                                                </span>
                                            </div>



                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Balance Total du pret</label>
                                                <input type="text" name="balance_tt_pret" class="form-control"
                                                    id="intere_mensuel" placeholder="">
                                                @error('balance_tt_pret')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">D'escription du Pret </label>
                                                <textarea type="text" name="description"
                                                    class="form-control"></textarea>

                                                @error('description')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                    </div>
                                    <div class="col-md-4">

                                        <div style="margin-left:25%; width:250px; padding:15px; border:1px solid;">
                                            <div class="form-group">
                                                <p> Attache piece jointes </p>
                                                <input type="file" name="file[]" multiple>
                                            </div>
                                            <span class="file_error" style="color:red;">
                                            </span>
                                        </div>
                                        <div style="margin-left:25%; width:300px; padding:15px; float:left;">
                                            <div class="form-group">
                                                <div class="col-md-6 col-md-offset-4">
                                                    <button type="submit" class="btn btn-danger">Envoyer</button>
                                                </div>
                                            </div>
                                        </div>
                                        </form>

                                    </div>
                                </div>

                            </div>



                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection