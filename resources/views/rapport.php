<?php
include('public/connect.php');
?>

<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.1.min.js" > </script>
<script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'my div','');
        mywindow.document.write('<html><head><title>Sale reports</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>
<div class="span9" >
    <div class="content">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/tcal.css" />
        <script type="text/javascript" src="<?php echo base_url()?>public/tcal.js"></script>


<h3 align="center"> RAPPORT</h3>
        <div class="module">

            <div class="module-body">

                <form action="<?php echo base_url();?>rapport/salesreportbn" method="POST">
                    <center><strong>De : <input type="text"  autocomplete="off"style="width: 223px; padding:14px;" name="d1" class="tcal" value="" /> A: <input type="text" autocomplete="off" style="width: 223px; padding:14px;" name="d2" class="tcal" value="" />
                            <button class="btn btn-info" style="width: 123px; height:35px; margin-top:-8px;margin-left:8px;" type="submit"><i class="icon icon-search icon-large"></i> Rechercher</button>
                        </strong></center>
                    </br></br>
                </form>
                </br>
                <div class="content" id="content">
      
                           <table class="table table-bordered" id="resultTable" data-responsive="table" style="text-align: left;">
              
                        <thead>

                        <tr style="font-size:18px; color:black;">

                            <th colspan="4" style="border-top:1px solid #999999"> Somme: </th>
                          
                            <th colspan="4" style="border-top:1px solid #999999">
                           
							<?php if(!empty( $somme)){
                                    foreach($somme AS $key){
										if($key->somme ==null){
											echo $sommvent = 0;
										}else{
											$sommvent = $key->somme; echo $key->somme." $";
										}
                                    }}else{
										 
									}

                                ?>
     
                            </th>

                        </tr>
			
						
						
						<tr style="font-size:18px; color:black;">

                            <th colspan="4" style="border-top:1px solid #999999"> Depense </th>
                       
                            <th colspan="4" style="border-top:1px solid #999999; color:red;">
                                		<?php if(!empty( $depense)){
                                    foreach($depense AS $key){
										if($key->cash ==null){
											echo $depenses = 0;
										}else{
											$depenses = $key->cash; echo $key->cash." $";
										}
                                    }}else{
										 
									}

                                ?>
                               
     
                            </th>

                        </tr>
						
						<tr style="font-size:18px; color:black;">

                            <th colspan="4" style="border-top:1px solid #999999"> Profit: </th>
                       
                            <th colspan="4" style="border-top:1px solid #999999">
                                		<?php if(!empty( $profit)){
                                    foreach($profit AS $key){

                                        $profits = $key->Profit; 
										echo bcdiv($key->Profit,1,1)." $";
                                    }}

                                ?>
                               
     
                            </th>

                        </tr>
						
						<tr style="font-size:20px; color:#2969b0;">

                            <th colspan="4" style="border-top:1px solid #999999"> Rapport: </th>
                       
                            <th colspan="4" style="border-top:1px solid #999999">
							
                                <?php
								
									if(isset($sommvent)){
									  $pr = $profits - $depenses;
									  if($pr > -1){
										  echo "Profit: ".bcdiv($pr,1,1)." $";
									  }else{
										  
										 $val = strval($pr);
										 echo "Perte: ".substr($val, 1)." $";
									  }
									} 
                                ?>
                               
                            </th>

                        </tr>
						
						
                        </thead>
                    </table>
                    </br></br>
                    <div class="pull-right" style="margin-right:100px;">
                        <a href="rapport" onclick="PrintElem('#content')" class="btn btn-success btn-large"/>IMPRIMER</a>
                    </div>
                </div>






            </div>
        </div>


        <br />

    </div><!--/.content-->
</div><!--/.span9-->

