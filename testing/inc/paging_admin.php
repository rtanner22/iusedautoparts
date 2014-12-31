<?php
function AdminPaging($pageNumber,$numofrows,$rowsPerPage,$selfurl)
{
	echo '<tr><td height="5px"></td></tr>';
	//echo '<tr><td colspan="5">&nbsp;</td></tr>';					
	
	// how many rows we have in database
	
	//$numrows = $result[0]['numrows'];
	
	$numrows = $numofrows;
					
	// how many pages we have when using paging?
	$maxPage = ceil($numrows/$rowsPerPage);
	
	//$self = ADM_INDEX_PARAMETER.base64_encode(SEARCH_MEMBER).'&txtsearch='.$keyword;
	
	
	if ($pageNumber > 1)
	{
		
		$page = $pageNumber - 1;
		$prev = " <a href=\"".$selfurl."page=$page\" class=\"editlink\"><img src=\"../images/prev.png\" border=\"0\"></a> ";
		
		$first = " <a href=\"".$selfurl."page=1\" class=\"editlink\"><img src=\"../images/first.png\" border=\"0\"></a> ";
	} 
	else
	{
		$prev  = " <img src=\"../images/next_gray.png\" border=\"0\"> ";  // we're on page one, don't enable 'previous' link
		$first = " <img src=\"../images/first_gray.png\" border=\"0\"> "; // nor 'first page' link
	}
	
	// print 'next' link only if we're not
	// on the last page
	if ($pageNumber  < $maxPage)
	{
		$page = $pageNumber + 1;
		$next = " <a href=\"".$selfurl."page=$page\" class=\"editlink\"><img src=\"../images/next.png\" border=\"0\"></a> ";
		
		$last = " <a href=\"".$selfurl."page=$maxPage\" class=\"editlink\"><img src=\"../images/last.png\" border=\"0\"></a> ";
	} 
	else
	{
		$next = " <img src=\"../images/prev_gray.png\" border=\"0\"> ";      // we're on the last page, don't enable 'next' link
		$last = " <img src=\"../images/last_gray.png\" border=\"0\"> "; // nor 'last page' link
	}
	
	if($maxPage != 1 )
	{
		if($maxPage==0){$maxPage=1;}
		echo  '<tr><td height="5px"></td></tr>';
		echo  '<tr><td colspan="10" align="right" class="browsedcontent" style="padding-right:10px;" valign="top">';
		// print the page navigation link
		echo   $first . "<span>" . $prev . "</span>" . " Showing page <strong>$pageNumber</strong> of <strong>$maxPage</strong> pages  <span>" . $next . "</span>" . $last;
		echo   '</td></tr>';
		echo   '<tr><td height="5px"></td></tr>';
	}	
	
}
?>