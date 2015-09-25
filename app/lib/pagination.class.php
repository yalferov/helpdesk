<?php

/**
 * @author djjustin
 * @copyright 2012
 */
/*
Использование:

 $obPagination = new Pagination({Всего элементов},{Элементов на странице} );
 $offset=$obPagination->getOffset(); // Получаем сдвиг
 $limit=$obPagination->getLimit(); // Получаем лимит
 $arNav=$obPagination->getLinksArray(); //Получаем массив ссылок
 $navString=$obPagination->getHtmlFromArray($arNav); //Получаем html код из массива

 SELECT * FROM WHERE LIMIT $offset,$limit

*/

class Pagination
{

	var $start_page    = 0;
	private $url       = "";
	private $total_rows; // Всего элементов
	private $page_size; //Количество элементов на странице
	
	private $total_pages; // вычисленное число страниц
	private $max_pages = 10; // Максимальное количество выводимых страниц
	private $page_var  = 'page';
	private $curr_page = 1;
	private $urlQuery;
    
	function __construct($total_rows, $page_size, $page_var = 'page')
	{
		$this->total_rows  = $total_rows;
		$this->page_size   = $page_size;
		$this->page_var    = $page_var;
		
		$this->total_pages = ceil($this->total_rows / $this->page_size);
		$this->curr_page   = isset($_GET[$this->page_var]) && (int)$_REQUEST[$this->page_var] > 0 ? (int)$_REQUEST[$this->page_var] : 1;
		$this->curr_page   = $this->curr_page>$this->total_pages? $this->$total_page:$this->curr_page;

		$this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		//$params=array();
		$queryStr=parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
		parse_str($queryStr,$params);
		unset($params[$this->page_var]);
		$this->urlQuery = http_build_query($params);
		$this->url = $this->url.'?'.$this->urlQuery;
	}

    function getLimit() {

    	return $this->page_size;
    }

    function getOffset()
    {
    	return ($this->curr_page - 1) * $this->page_size;
    }
    

    function getLinksArray(){

    	$arLinksArray=array();

		if ($this->curr_page > 5) {
    		$this->start_page = $this->curr_page - ceil($this->max_pages / 2);
    	} else {
    		$this->start_page = 1;
    	}

    	$prev_link = $this->start_page - $this->max_pages + ceil($this->max_pages / 2);
    	if ($prev_link < 1) {
    		$prev_link = 1;
    	}

    	//$next_link = $this->start_page + $this->max_pages + ceil($this->max_pages / 2);
    	$next_link = $this->curr_page+1;
    	if ($next_link > $this->total_pages) {
    		$next_link = $this->total_pages;
    	}
		$arLinksArray=array();
		//$arLinksArray[]=["NAME"=>'В начало', "LINK"=>"{$this->url}&{$this->page_var}=1", "TYPE"=>"BEGIN", "ACTIVE"=>"Y"];
		$arLinksArray[]=array("NAME"=>'Пред', "LINK"=>"{$this->url}&{$this->page_var}={$prev_link}", "TYPE"=>"PREV", "ACTIVE"=>"Y");

    	for ($i = $this->start_page; ($i < ($this->start_page + $this->max_pages)) and ($i <= $this->total_pages); $i++) {
			if ($i == $this->curr_page) {
				$arLinksArray[]=array("NAME"=>$i, "LINK"=>"{$this->url}&{$this->page_var}={$i}", "TYPE"=>"CURRENT", "ACTIVE"=>"N");
			} else {
				$arLinksArray[]=array("NAME"=>$i, "LINK"=>"{$this->url}&{$this->page_var}={$i}", "TYPE"=>"", "ACTIVE"=>"Y");
				
			}            
		};
		if($this->curr_page==$this->total_pages){
			$arLinksArray[]=array("NAME"=>'Следующая', "LINK"=>"{$this->url}&{$this->page_var}={$next_link}", "TYPE"=>"NEXT", "ACTIVE"=>"N");
		} else {
			$arLinksArray[]=array("NAME"=>'Следующая', "LINK"=>"{$this->url}&{$this->page_var}={$next_link}", "TYPE"=>"NEXT", "ACTIVE"=>"Y");
		}
		$arLinksArray[]=array("NAME"=>'В конец', "LINK"=>"{$this->url}&{$this->page_var}={$this->total_pages}", "TYPE"=>"END", "ACTIVE"=>"Y");

		return $arLinksArray;
    }
	
	function getHtmlFromArray($arLinksArray){
		$linksHtml="";
 		foreach ($arLinksArray as $key => $value) {
 			if($value['ACTIVE']=="N") {
 				$linksHtml.='<span>'.$value['NAME'].'</span> ';
 			} else {
 				$linksHtml.='<a href="'.$value['LINK'].'">'.$value['NAME'].'</a> ';
 			}
 		}
 		return $linksHtml;
	}

    function getHtml()
    {
    	
    	if ($this->curr_page > 5) {
    		$this->start_page = $this->curr_page - ceil($this->max_pages / 2);
    	} else {
    		$this->start_page = 1;
    	}

    	$prev_link = $this->start_page - $this->max_pages + ceil($this->max_pages / 2);
    	if ($prev_link < 1) {
    		$prev_link = 1;
    	}

    	$next_link = $this->start_page + $this->max_pages + ceil($this->max_pages / 2);
    	if ($next_link > $this->total_pages) {
    		$next_link = $this->total_pages;
    	}

    	$linksHtml = <<< HTML
    	<div class="navigation">
    		<a href="{$this->url}&{$this->page_var}=1">В начало</a>
    		<a href="{$this->url}&{$this->page_var}={$prev_link}">Пред.</a>
HTML;
    	for ($i = $this->start_page; ($i < ($this->start_page + $this->max_pages)) and ($i <=
    			$this->total_pages); $i++) {
		if ($i == $this->curr_page) {
			$linksHtml .= $this->getLink($i,false);
		} else {
			$linksHtml .= $this->getLink($i,true);
			
		}            
};

$linksHtml .= <<< HTML
	<a href="{$this->url}&{$this->page_var}={$next_link}">След.</a> 
	<a href="{$this->url}&{$this->page_var}={$this->total_pages}">В конец</a>
	</div> 
HTML;
return $linksHtml;
}

function set_url($url)
{
	//$this->url = $url;
}

function set_pagesize($pagesize)
{
	$this->page_size = $pagesize;
}

function getLink($page,$isActive){
	if($isActive){
 $strLink=<<<HTML
	 <a href="{$this->url}&{$this->page_var}={$page}">{$page}</a>
HTML;
} else {
	$strLink=<<<HTML
	 <span>{$page}</span>
HTML;
}
return $strLink;
	}

}

?>