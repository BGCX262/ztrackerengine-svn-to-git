<?php

/**
 * Smarty {pagelinks} function plugin
 *
 * Type:     function<br>
 * Name:     pagelinks<br>
 * Input:<br>
 *           - request    (required) - string
 *           - offset     (required) - number
 *           - total      (required) - number
 *           - rpp        (optional) - number default 20 (result rows per page)
 *           - lpp        (optional) - number default 12 (pagelinks per page)
 *           - back       (optional) - string default ""
 *           - forw       (optional) - string default ""
 *           - to_first   (optional) - string default ""
 *           - to_last    (optional) - string default ""
 *           - separator  (optional) - string default "..."
 * Purpose:  Prints a list of HTML pagelinks generated from
 *           the passed parameters
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_pagelinks($params, &$smarty)
{
    $rpp        = isset($params['rpp']) ? $params['rpp'] : 20;
    $lpp        = isset($params['lpp']) ? $params['lpp'] : 20;
    $offset     = $params['offset'];
    $total      = $params['total'];
    $request    = $params['request'];

    if (isset($params['assign']) && empty($params['assign'])) {
        $compiler->_syntax_error("pagelinks: 'assign' parameter may not be empty.", E_USER_WARNING);
        return;
    }

    $write_output = !isset($params['assign']);

    //localized titles
    $back       = isset($params['back']) ? " title=\"".$params['back']."\" " : "";
    $forw       = isset($params['forw']) ? " title=\"".$params['forw']."\" " : "";
    $to_first   = isset($params['to_first']) ? " title=\"".$params['to_first']."\" " : "";
    $to_last    = isset($params['to_last']) ? " title=\"".$params['to_last']."\" " : "";

    //separator between pagelinks
    $separator  = isset($params['separator']) ? $params['separator'] : "&nbsp;&nbsp;&nbsp;";

   //fits on one site, do nothing!
   if ($total <= $rpp)
    {
      return "";
   }

    //check if the request already contains some GET parameters
    //if not, append a "?" otherwise a "&"
    $request .= (strpos($request,"?")===false) ? "?" : "&";

    $curpage      = floor($offset/$rpp);

   //this is needed to set the right number of $totalpages for plane numbers
   if ($total % $rpp == 0)
    {
      $totalpages      = floor($total/$rpp)-1;
   }
    else
    {
      $totalpages      = ceil($total/$rpp)-1;
   }

   $maxleftright   = ceil($lpp/2);
   //only display first and last item if left/right pagelinks are cutted
   $leftdots       = false;
   $rightdots      = false;

   //determine how many pagelinks must be shown on the left and right
   //side of the current page
   if ($curpage<=$maxleftright)
    {
        //only right padding
      $leftpages   = $curpage;
      if ($lpp>$totalpages)
        {
         $rightpages   =  $totalpages-$leftpages;
      }
        else
        {
         $rightpages   = $lpp-$leftpages;
         $rightdots    = true;
      }
   }
    else if (($curpage+$maxleftright)>=$totalpages)
    {
        //only left padding
      $rightpages   = $totalpages-$curpage;
      if ($lpp>$totalpages)
        {
         $leftpages   = $totalpages-$rightpages;
      }
        else
        {
         $leftpages   = $lpp-$rightpages;
         $leftdots   = true;
      }
   }
    else
    {
        //for padding on both sides
      $leftpages   = $maxleftright;
      $rightpages   = $maxleftright;
      $leftdots = $rightdots = true;
   }

    $html = "";


   if ($leftdots)
    {
      $html .= "<a href=\"".$request."offset=0\" ".$to_first."'>&lt;&lt;</a>&nbsp;".$separator;
   }

   if ($curpage!=0)
    {
      $html .= "<a href=\"".$request."offset=".($offset-$rpp)."\" ".$back."'>&lt;</a>&nbsp;".$separator;
   }

   //set the page number of the first page link (zero based)
   $pageno = $curpage - $leftpages;

   //show navig for left ($i is not used)
   for($i=0;$i<$leftpages;$i++)
    {
      $html .= "<a href=\"".$request."offset=".($pageno*$rpp)."\">".
                 ($pageno+1)."</a>".$separator."\n";
      $pageno++;
   }

   //display current page number
   $html .= "&nbsp;<b>".($pageno+1)."</b>&nbsp;\n";
   $pageno++;

   //show navig for right ($i is not used)
   for($i=0;$i<$rightpages;$i++)
    {
      $html .= "&nbsp;<a href=\"".$request."offset=".($pageno*$rpp)."\">".
                 ($pageno+1)."</a>&nbsp;".$separator."\n";
      $pageno++;
   }

   if ($curpage!=$totalpages)
    {
      $html .= $separator."&nbsp;<a href=\"".$request."offset=".($offset+$rpp)."\" ".
                 $forw.">&gt;</a>";
   }

   if ($rightdots)
    {
      $html .= $separator."&nbsp;<a href=\"".$request."offset=".($totalpages*$rpp)."\" ".
                 $to_last.">&gt;&gt;</a>";
   }

    if ($write_output) return $html."\n";

    return $smarty->assign($params['assign'], $html."\n");
}

?>