<?php
//分页
class PageComponent extends Component{
	/**
	 * 分页组件
	 *
	 * @param unknown_type $mpurl    当前地址 ：如 $mpurl = $this->base.'/news/newscontent';
	 * @param unknown_type $page     当前页
	 * @param unknown_type $total    总条数
	 * @param unknown_type $pernum   每页显示的条数
	 * @param 1.普通分页，2.搜索条数过多时候最大支持1000条
	 * @return 分页的html代码
	 */
	function makeMulitpage($mpurl, $page, $total, $pernum, $type = 1) {
			if ($type == 2) {
				// 搜索最多支持一千条数据
				$maxpage = ($total > 1000) ? ceil ( 1000 / $pernum ) : ceil ( $total / $pernum );
			} else {
				$maxpage = ceil ( $total / $pernum );
			}
		$page = $page > $maxpage ? $maxpage : $page;
		$page = $page > 1 ? $page : 1;
		$multipage = "";
		if ($maxpage > 1) {
			
			$offset = 2;
			if ($maxpage <= 5) {
				$from = 1;
				$to = $maxpage;
			} else {
				$from = $page - $offset;
				$to = $from + 4;
				if ($from < 1) {
					$from = 1;
					$to = 5;
				}
				if ($to > $maxpage) {
					$to = $maxpage;
					$from = $maxpage - 4;
				}
			}
			$multipage = $shangyiye="";
			$shangyiye .= $page == 1 ? "" : ("<li class='pre'><a href='{$mpurl}&page=" . ($page - 1) . "' target='_parent'>上一页</a></li>");
			for($i = $from; $i <= $to; $i ++) {
				$multipage .= $i == $page ? "<li class='num on'><a href='#' id='curPage' page={$i} target='_parent'>$i</a></li>" : "<li class='num'><a href='{$mpurl}&page={$i}' target='_parent'>$i</a></li>";
			}
			$xiayiye = $page == $maxpage ? "" : ("<li class='next'><a href='{$mpurl}&page=" . ($page + 1) . "' target='_parent'>下一页</a></li>");
			$resultnum = $total;
			} else {
				$resultnum = $total;
			}
		$shangyiye = isset($shangyiye)?$shangyiye:'';
		$xiayiye = isset($xiayiye)?$xiayiye:'';
		$pagehtml =$shangyiye . $multipage . $xiayiye;
		return $pagehtml;
	}
     function makeMulitpages($mpurl, $page, $total, $pernum, $type = 1) {
			if ($type == 2) {
				// 搜索最多支持一千条数据
				$maxpage = ($total > 1000) ? ceil ( 1000 / $pernum ) : ceil ( $total / $pernum );
			} else {
				$maxpage = ceil ( $total / $pernum );
			}
		$page = $page > $maxpage ? $maxpage : $page;
		$page = $page > 1 ? $page : 1;
		$multipage = "";
		if ($maxpage > 1) {
			
			$offset = 2;
			if ($maxpage <= 5) {
				$from = 1;
				$to = $maxpage;
			} else {
				$from = $page - $offset;
				$to = $from + 4;
				if ($from < 1) {
					$from = 1;
					$to = 5;
				}
				if ($to > $maxpage) {
					$to = $maxpage;
					$from = $maxpage - 4;
				}
			}
			$multipage = $shangyiye="";
			$shangyiye .= $page == 1 ? "" : ("<li class='pre'><a href='{$mpurl}&page=" . ($page - 1) . "' target='_parent'>上一页</a></li>");
			for($i = $from; $i <= $to; $i ++) {
				$multipage .= $i == $page ? "<li class='on'><a href='#' id='curPage' page={$i} class='bh-on' target='_parent'>$i</a></li>" : "<li><a href='{$mpurl}&page={$i}' target='_parent'>$i</a></li>";
			}
			$xiayiye = $page == $maxpage ? "" : ("<li class='next'><a href='{$mpurl}&page=" . ($page + 1) . "' target='_parent'>下一页</a></li>");
			$resultnum = $total;
			} else {
				$resultnum = $total;
			}
		$shangyiye = isset($shangyiye)?$shangyiye:'';
		$xiayiye = isset($xiayiye)?$xiayiye:'';
		$pagehtml =$shangyiye . $multipage . $xiayiye;
		return $pagehtml;
	}
	/**
	 * 分页组件（post方式分页）
	 * @param unknown_type $page     当前页
	 * @param unknown_type $total    总条数
	 * @param unknown_type $pernum   每页显示的条数
	 * @param 1.普通分页，2.搜索条数过多时候最大支持1000条
	 * @return 分页的html代码
	 */
	function makeMulitpageposts($page, $total, $pernum, $type = 1) {
		if ($type == 2) {
			// 搜索最多支持一千条数据
			$maxpage = ($total > 1000) ? ceil ( 1000 / $pernum ) : ceil ( $total / $pernum );
		} else {
			$maxpage = ceil ( $total / $pernum );
		}
		$page = $page > $maxpage ? $maxpage : $page;
		$page = $page > 1 ? $page : 1;
		$multipage = "";
		if ($maxpage > 1) {

			$offset = 2;
			if ($maxpage <= 5) {
				$from = 1;
				$to = $maxpage;
			} else {
				$from = $page - $offset;
				$to = $from + 4;
				if ($from < 1) {
					$from = 1;
					$to = 5;
				}
				if ($to > $maxpage) {
					$to = $maxpage;
					$from = $maxpage - 4;
				}
			}
			$multipage = $shangyiye="";
			$shangyiye .= $page == 1 ? "" : ("<li class='c-previous'><a href='javascript:;' onclick='gotoPage(1," . ($page - 1) . ")' >上一页</a></li>");
			for($i = $from; $i <= $to; $i ++) {
				$multipage .= $i == $page ? "<li class='c-number bh-on'><a href='#' id='curPage' page={$i} class='bh-on' >$i</a></li>" : "<li class='c-number'><a href='javascript:;' onclick='gotoPage(1,".$i.")'>$i</a></li>";
			}
			$xiayiye = $page == $maxpage ? "" : ("<li class='c-next'><a href='javascript:;' onclick='gotoPage(1," . ($page + 1) . ")'>下一页</a></li>");
			$resultnum = $total;
		} else {
			$resultnum = $total;
		}
		$pagehtml =$shangyiye . $multipage . $xiayiye;
		return $pagehtml;
	}
}  

?>