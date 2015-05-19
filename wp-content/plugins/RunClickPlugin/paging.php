<?php
function Ghangoutpagination($totalposts,$p,$lpm1,$prev,$next,$url){

    $adjacents = 3;
    if($totalposts > 1)
    {
        $pagination .= "<div class='gh-page'>
							<ul>";
        //previous button
        if ($p > 1)
        $pagination.= "<li><a href=\"$url&pg=$prev\"><< Previous</a></li> ";
        else
        $pagination.= "<li class='disable'><< Previous</li>";
        if ($totalposts < 7 + ($adjacents * 2)){
            for ($counter = 1; $counter <= $totalposts; $counter++){
                if ($counter == $p)
                $pagination.= "<li class='phone_hide onpage'>$counter</li>";
                else
                $pagination.= " <li class='phone_hide'><a href=\"$url&pg=$counter\">$counter</a></li> ";}
        }elseif($totalposts > 5 + ($adjacents * 2)){
            if($p < 1 + ($adjacents * 2)){
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $p)
                    $pagination.= " <li class='phone_hide onpage'>$counter</span> ";
                    else
                    $pagination.= " <li class='phone_hide'><a href=\"$url&pg=$counter\">$counter</a></li> ";
                }
                $pagination.= " ... ";
                $pagination.= " <li class='phone_hide'><a href=\"$url&pg=$lpm1\">$lpm1</a> ";
                $pagination.= " <li class='phone_hide'><a href=\"$url&pg=$totalposts\">$totalposts</a> </li>";
            }
            //in middle; hide some front and some back
            elseif($totalposts - ($adjacents * 2) > $p && $p > ($adjacents * 2)){
                $pagination.= " <li class='phone_hide'><a href=\"$url&pg=1\">1</a> </li>";
                $pagination.= " <li class='phone_hide'><a href=\"$url&pg=2\">2</a> </li>";
                $pagination.= " ... ";
                for ($counter = $p - $adjacents; $counter <= $p + $adjacents; $counter++){
                    if ($counter == $p)
                    $pagination.= " <li class='phone_hide onpage'>$counter</span> ";
                    else
                    $pagination.= " <li class='phone_hide'><a href=\"$url&pg=$counter\">$counter</a> </li>";
                }
                $pagination.= " ... ";
                $pagination.= " <li class='phone_hide'><a href=\"$url&pg=$lpm1\">$lpm1</a> </li>";
                $pagination.= " <li class='phone_hide'><a href=\"$url&pg=$totalposts\">$totalposts</a> </li>";
            }else{
                $pagination.= " <li class='phone_hide'><a href=\"$url&pg=1\">1</a> </li>";
                $pagination.= " <li class='phone_hide'><a href=\"$url&pg=2\">2</a> </li>";
                $pagination.= " ... ";
                for ($counter = $totalposts - (2 + ($adjacents * 2)); $counter <= $totalposts; $counter++){
                    if ($counter == $p)
                    $pagination.= " <li class='phone_hide onpage'>$counter</span> ";
                    else
                    $pagination.= " <li class='phone_hide'><a href=\"$url&pg=$counter\">$counter</a> </li>";
                }
            }
        }
        if ($p < $counter - 1)
        $pagination.= " <li class='phone_hide'><a href=\"$url&pg=$next\">Next >></a></li>";
        else
        $pagination.= " <li class=\"disable\">Next >></li>";
        $pagination.= "</ul><div class='clear'></div>
							</div>";
    }
    return $pagination;
}
