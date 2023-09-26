<?php

if ( ! function_exists( 'px_pagination' ) ) {
	function px_pagination($total_records, $per_page, $qrystr = '') {
		$html = '';
		$dot_pre = '';
		$dot_more = '';
		$previous = __("Anterior",'Kingsclub');
		if(isset($px_theme_option["trans_switcher"]) && $px_theme_option["trans_switcher"] == "on") { $previous = __("Anterior",'Kingsclub'); }elseif(isset($px_theme_option["trans_previous"]) && $px_theme_option["trans_previous"] <> ''){  $previous = $px_theme_option["trans_previous"];}
		$total_page = ceil($total_records / $per_page);
		$loop_start = $_GET['page_id_all'] - 2;
		$loop_end = $_GET['page_id_all'] + 2;
		
		if ($_GET['page_id_all'] < 3) {
			$loop_start = 1;
			
			if ($total_page < 5)$loop_end = $total_page; else $loop_end = 5;
		} else
		if ($_GET['page_id_all'] >= $total_page - 1) {
			
			if ($total_page < 5)$loop_start = 1; else $loop_start = $total_page - 4;
			$loop_end = $total_page;
		}

		
		if ($_GET['page_id_all'] > 1)$html .= "<li  class='prev'>
		<a href='?page_id_all=" . ($_GET['page_id_all'] - 1) . "$qrystr' ><i class='fa fa-long-arrow-left'></i>".__('Anterior','Kingsclub')."</a></li>";
		
		if ($_GET['page_id_all'] > 3 and $total_page > 5)$html .= "<li><a href='?page_id_all=1$qrystr'>1</a></li>";
		
		if ($_GET['page_id_all'] > 4 and $total_page > 6)$html .= "<li> <a>. . .</a> </li>";
		
		if ($total_page > 1) {
			for ($i = $loop_start; $i <= $loop_end; $i++) {
				
				if ($i <> $_GET['page_id_all'])$html .= "<li><a href='?page_id_all=$i$qrystr'>" . $i . "</a></li>"; else $html .= "<li>
				<span class='active'>" . $i . "</span></li>";
			}

		}
			
		if ($loop_end <> $total_page and $loop_end <> $total_page - 1)$html .= "<li> <a>. . .</a> </li>";
		
		if ($loop_end <> $total_page)$html .= "<li><a href='?page_id_all=$total_page$qrystr'>$total_page</a></li>";
		
		if ($_GET['page_id_all'] < $total_records / $per_page)$html .= "<li class='next'><a href='?page_id_all=" . ($_GET['page_id_all'] + 1) . "$qrystr' >".__('Siguiente','Kingsclub')."<i class='fa fa-long-arrow-right'></i></a></li>";
		return $html;
	}

}

?>