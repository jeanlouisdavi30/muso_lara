<?php
if ($type == "admin") {?>
<button type="submit" class="{{$class}}">{{$value}}</button>
<?php } elseif ($type == "Tresorier") {?>
<button type="submit" class="{{$class}}">{{$value}}</button>
<?php } elseif ($type == "President") {?>
<button type="submit" class="{{$class}}">{{$value}}</button>
<?php }?>