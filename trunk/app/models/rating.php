<?php

class Rating extends AppModel
{
    var $name = 'Rating';
    
    function getRating($id){
        $res = $this->query("SELECT COUNT(id) as r, SUM(rating) as tot FROM ratings WHERE torrent=".$id);
        if($res[0][0]['r'] == 0) return '0%';
        $perc = ($res[0][0]['tot']/$res[0][0]['r'])*20;     

		$newPerc = round($perc,2);
		return $newPerc.'%';
    }

    function outOfFive($id)
    {
        $res = $this->query("SELECT COUNT(id) as r, SUM(rating) as tot FROM ratings WHERE torrent=".$id);
        if($res[0][0]['r'] == 0) return '0';
        $perc = ($res[0][0]['tot']/$res[0][0]['r']);     

		$newPerc = round($perc,2);
		return $newPerc.'';
 /*
		$perc = ($total/$rows);

		return round($perc,2);
  */		//return round(($perc*2), 0)/2; // 3.5
    }

    function getVotes($id){
        $ret = $this->query("SELECT rating FROM ratings WHERE torrent = '$id'");
        $rows = count($ret);
    	if($rows == 0){
	    	$votes = 'нет голосов';
    	}
	    else if($rows == 1){
		    $votes = '1 голос';
        } elseif($rows == 2) {
            $votes = '2 голоса';
    	} else {
	    	$votes = $rows.' голосов';
    	}
	    return $votes;
    }

    function pullRating($id, $user, $show5 = false, $showPerc = false, $showVotes = false, $static = NULL)
    {
        // Check if they have already voted...
	    $sel = $this->query("SELECT id FROM ratings WHERE user = '".$user."' AND torrent = '$id'");
        if(count($sel) > 0 || $static == 'novote')
        {
		    $text = '';
    		if($show5 || $showPerc || $showVotes){
    			$text .= '<div class="rated_text">';
    		}

			if($show5){
				$text .= 'Оценка <span id="outOfFive_'.$id.'" class="out5Class">'.$this->outOfFive($id).'</span>/5';
			}
			if($showPerc){
				$text .= ' (<span id="percentage_'.$id.'" class="percentClass">'.$this->getRating($id).'</span>)';
			}
			if($showVotes){
				$text .= ' (<span id="showvotes_'.$id.'" class="votesClass">'.$this->getVotes($id).'</span>)';
			}

            if($show5 || $showPerc || $showVotes)
            {
			    $text .= '</div>';
            }
    
            return $text.'
                <ul class="star-rating2" id="rater_'.$id.'">
				<li class="current-rating" style="width:'.$this->getRating($id).';" id="ul_'.$id.'"></li>
				<li><a onclick="return false;" href="#" title="1 звезда из 5" class="one-star" >1</a></li>
				<li><a onclick="return false;" href="#" title="2 звезды из 5" class="two-stars">2</a></li>
				<li><a onclick="return false;" href="#" title="3 звезды из 5" class="three-stars">3</a></li>
				<li><a onclick="return false;" href="#" title="4 звезды из 5" class="four-stars">4</a></li>
                <li><a onclick="return false;" href="#" title="5 звезд из 5" class="five-stars">5</a></li>
            </ul>
            <div id="loading_'.$id.'"></div>';
        } else { /// {{{
            $text ="";
            if($show5 || $showPerc || $showVotes){
                $text .= '<div class="rated_text">';
            }

			if($show5){
				$show5bool = 'true';
				$text .= 'Оценка <span id="outOfFive_'.$id.'" class="out5Class">'.$this->outOfFive($id).'</span>/5';
			} else {
				$show5bool = 'false';
			}
			if($showPerc){
				$showPercbool = 'true';
				$text .= ' (<span id="percentage_'.$id.'" class="percentClass">'.$this->getRating($id).'</span>)';
			} else {
				$showPercbool = 'false';
			}
			if($showVotes){
				$showVotesbool = 'true';
				$text .= ' (<span id="showvotes_'.$id.'" class="votesClass">'.$this->getVotes($id).'</span>)';
			} else {
				$showVotesbool = 'false';
			}
            
            if($show5 || $showPerc || $showVotes){
                $text .= '</div>';
            }

	    	return $text.'
                <ul class="star-rating" id="rater_'.$id.'">
				<li class="current-rating" style="width:'.$this->getRating($id).';" id="ul_'.$id.'"></li>
				<li><a id="i='.$id.'r=1" title="1 звезда из 5" class="one-star" >1</a></li>
				<li><a id="i='.$id.'r=2" title="2 звезды из 5" class="two-stars">2</a></li>
				<li><a id="i='.$id.'r=3" title="3 звезды из 5" class="three-stars">3</a></li>
				<li><a id="i='.$id.'r=4" title="4 звезды из 5" class="four-stars">4</a></li>
				<li><a id="i='.$id.'r=5" title="5 звезд из 5" class="five-stars">5</a></li>
			</ul>
			<div id="loading_'.$id.'"></div>';
	    } // }}}
    }

}
?>
