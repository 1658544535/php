<?php
/**
 * 原创来源：网络
 * 修改者：Will
 * QQ：252075062
 * E-mail：shaoweizheng@163.com
 */

/**
 * 分页类
 *
 * 方法调用：
 *	$config = array(
 *		'show_page_num'		=> 5,						设置显示的页数
 *		'cur_index_page'	=> 3,						设置当前页在分页栏中的位置
 *		'first_page_text'	=> '第一页',				设置链接第一页显示的文字
 *		'last_page_text'	=> '最后一页',				设置链接最后一页显示的文字
 *		'pre_page_text'		=> '上一页',				设置链接上一页显示的文字
 *		'next_page_text'	=> '下一页',				设置链接下一页显示的文字
 *		'page_css'			=> 'page_class_name',		设置各分页码css样式的class名称
 *		'cur_page_css'		=> 'cur_page_class_name',	设置当前页码css样式的class名称
 *		'page_style'		=> 'page_style_item',		设置各分页码的样式，即style属性
 *		'cur_page_style'	=> 'cur_page_style_item',	设置当前页码的样式，即style属性
 *		'link_symbol'		=> '=',						设置地址链接中页码与变量的连接符，如page=2中的“=”
 *		'show_first_last'	=> true,					设置是否显示第一页与最后一页的链接
 *		'show_simple_page'	=> true,					设置当只有一页时是否显示分页
 *      'show_items'        => true,                    设置是否显示1,2,3..的分页列表
 *	);
 *	$pages = new Pages($count, $pagenum, $page, 'showpage.php?page', $config);	创建对象
 *	$pageCount = $pages->getTotalPageNum();	获取总页数
 *	$pageStr = $pages->generatePages();	获取分页栏
 *
 *
 *  对象实例化各参数说明：
 *  @param integer $count 总条目数
 *  @param integer $pagenum 每页显示的条目数
 *  @param integer $page 当前页数
 *  @param string 'showpage.php?page' 每个分页的链接
 *  @param array $config 相关信息设置
 */

class Pages{
	/**
	 * 每页显示的条目数
	 * @var integer
	 */
	private $eachDisNums;

	/**
	 * 总条目数
	 * @var integer
	 */
	private $nums;

	/**
	 * 当前被选中的页
	 * @var integer
	 */
	private $currentPage;

	/**
	 * 每次显示的页数，如1 2 3 4 5
	 * @var integer
	 */
	private $showPageNum = 5;

	/**
	 * 当前页在分页中的位置，如1 2 [3] 4 5
	 * @var integer
	 */
	private $curIndexPage = 3;

	/**
	 * 总页数
	 * @var integer
	 */
	private $totalPageNum;

	/**
	 * 用来构造分页的数组
	 * @var array
	 */
	private $arrPage = array();

	/**
	 * 每个分页的链接
	 * @var string
	 */
	private $subPageLink;

	/**
	 * 第一页显示的文字
	 * @var string
	 */
	private $firstPageText = '1..';

	/**
	 * 最后一页显示的文字
	 * @var string
	 */
	private $lastPageText;

	/**
	 * 上一页显示的文字
	 * @var string
	 */
	private $prePageText = '<';

	/**
	 * 下一页显示的文字
	 * @var string
	 */
	private $nextPageText = '>';

	/**
	 * 一般页的样式名称
	 * @var string
	 */
	private $pageCss = '';

	/**
	 * 当前页的样式名称
	 * @var string
	 */
	private $curPageCss = '';

	/**
	 * 一般页的样式
	 * @var string
	 */
	private $pageStyle = '';

	/**
	 * 当前页的样式
	 * @var string
	 */
	private $curPageStyle = '';

	/**
	 * url链接地址中page与页数之间的符号
	 * @var string
	 */
	private $linkSymbol = '=';

	/**
	 * 是否显示第一页和最后一页
	 * @var boolean
	 */
	private $isShowFirstLast = true;

	/**
	 * 当没有分页时(即总条目数不大于每页显示的条目数)是否显示分页栏
	 * @var boolean
	 */
	private $isShowForSimplePage = false;

	/**
	 * 是否显示1,2,3...的分页列表
	 * @var boolean
	 */
	private $isShowItems = true;

	/**
	 * url相关配置
	 * @var array
	 * @param string func 格式化链接地址函数，此值不为空时，以此为准，余下参数才起作用，且uri不能为空，同时$this->subPageLink与$this->linkSymbol失效
	 * @param string uri func函数要格式化的地址(不包含页数值)，如:
	 * @param string funcFile func指定函数所在文件，此值不为空，将自动加载指定的文件
	 */
	private $urlParams = array('func'=>'', 'uri'=>'', 'funcFile'=>'');

	/**
	 * 获取链接地址
	 * 
	 * @param integer $page 页数
	 * @return string
	 */
	private function _getUrl($page){
		if(empty($this->urlParams['func'])){//以指定地址为准
			$url = $this->subPageLink.$this->linkSymbol.$page;
		}else{//通过函数格式化地址
			$url = $this->urlParams['func']($this->urlParams['uri'].$page);
		}
		return $url;
	}
	
	/**
	 * 设置显示的页数
	 *
	 * @param integer $num 显示的页数
	 * @return void
	 */
	public function setShowPageNum($num){
		$this->showPageNum = $num;
	}

	/**
	 * 设置当前页在分页栏中的位置
	 *
	 * @param integer $num 当前页在分页栏中的位置
	 * @return void
	 */
	public function setCurrentIndexPage($num){
		$this->curIndexPage = $num;
	}

	/**
	 * 设置链接第一页显示的文字
	 *
	 * @param string $text 要显示的文字
	 * @return void
	 */
	public function setFirstPageText($text){
		$this->firstPageText = $text;
	}

	/**
	 * 设置链接最后一页显示的文字
	 *
	 * @param string $text 要显示的文字
	 * @return void
	 */
	public function setLastPageText($text){
		$this->lastPageText = $text;
	}

	/**
	 * 设置链接上一页显示的文字
	 *
	 * @param string $text 要显示的文字
	 * @return void
	 */
	public function setPrePageText($text){
		$this->prePageText = $text;
	}

	/**
	 * 设置链接下一页显示的文字
	 *
	 * @param string $text 要显示的文字
	 * @return void
	 */
	public function setNextPageText($text){
		$this->nextPageText = $text;
	}

	/**
	 * 设置各分页码css样式的class名称
	 *
	 * @param string $css css样式名称
	 * @return void
	 */
	public function setPageCss($css){
		$this->pageCss = $css;
	}

	/**
	 * 设置当前页码css样式的class名称
	 *
	 * @param string $css css样式名称
	 * @return void
	 */
	public function setCurrentPageCss($css){
		$this->curPageCss = $css;
	}

	/**
	 * 设置各分页码的样式，即style属性
	 *
	 * @param string $style style样式
	 * @return void
	 */
	public function setPageStyle($style){
		$this->pageStyle = $style;
	}

	/**
	 * 设置当前页码的样式，即style属性
	 *
	 * @param string $style style样式
	 * @return void
	 */
	public function setCurrentPageStyle($style){
		$this->curPageStyle = $style;
	}

	/**
	 * 设置地址链接中页码与变量的连接符，如page=2中的“=”
	 *
	 * @param string $symbol 连接符号
	 * @return void
	 */
	public function setLinkSymbol($symbol){
		$this->linkSymbol = $symbol;
	}

	/**
	 * 获取总页数
	 *
	 * @access private
	 * @return integer
	 */
	public function getTotalPageNum(){
		return $this->totalPageNum;
	}

	/**
	 * 设置是否显示第一页与最后一页的链接
	 *
	 * @param boolean $is true:显示，false:不显示
	 * @return void
	 */
	public function isShowFirstAndLast($is){
		$this->isShowFirstLast = $is;
	}

	/**
	 * 设置当只有一页时是否显示分页
	 *
	 * @param boolean $is true:显示，false:不显示
	 * @return void
	 */
	public function isShowForSimplePage($is){
		$this->isShowForSimplePage = $is;
	}

    /**
     * 是否显示1,2,3...的分页列表
     *
     * @param boolean $is true:显示，false:不显示
     * @return void
     */
    public function isShowItems($is){
        $this->isShowItems = $is;
    }

	/**
	 * 构造方法
	 *
	 * @param integer $nums 总条目数
	 * @param integer $eachDisNums 每页显示的条目数
	 * @param integer $showPageNum 当前页数
	 * @param string $subPageLink 每个分页的链接
	 * @param array $config 相关信息设置
	 * @return void
	 */
	public function __construct($nums, $eachDisNums, $currentPage, $subPageLink, $config=array()){
		$this->eachDisNums=intval($eachDisNums);
		$nums = $nums==0 ? 1: $nums;
		$this->nums = intval($nums);
		$this->totalPageNum = ceil($nums/$eachDisNums);
		$this->currentPage =intval($currentPage);
		$this->currentPage =  $this->currentPage<=0 ? 1: $this->currentPage;
		$this->currentPage = $this->currentPage > $this->totalPageNum ? 1 : $this->currentPage;
		$this->subPageLink = $subPageLink;
		$this->lastPageText = '..'.$this->totalPageNum;
		$this->config($config);
	}

	public function __destruct(){
		unset($this->eachDisNums, $this->nums, $this->currentPage, $this->showPageNum, $this->curIndexPage, $this->totalPageNum, $this->arrPage, $this->subPageLink, $this->firstPageText, $this->lastPageText, $this->prePageText, $this->nextPageText, $this->pageCss, $this->curPageCss, $this->pageStyle, $this->curPageStyle, $this->linkSymbol, $this->isShowFirstLast, $this->isShowForSimplePage, $this->urlParams);		
	}

	/**
	 * 设置相关信息
	 *
	 * @param array $arrConfig 信息设置数组
	 *		数组元素：
	 *			show_page_num:		每次显示的页数，如1 2 3 4 5
	 *			cur_index_page:		当前页在分页中的位置，如1 2 [3] 4 5
	 *			first_page_text:	第一页显示的文字
	 *			last_page_text:		最后一页显示的文字
	 *			pre_page_text:		上一页显示的文字
	 *			next_page_text:		下一页显示的文字
	 *			page_css:			一般页的样式名称
	 *			cur_page_css:		当前页的样式名称
	 *			page_style:			一般页的样式
	 *			cur_page_style:		当前页的样式
	 *			link_symbol:		url链接地址中page与页数之间的符号
	 *			show_first_last:	是否显示第一页和最后一页
	 *			show_simple_page:	当没有分页时(即总条目数不大于每页显示的条目数)是否显示分页栏
     *          isShowItems:        是否显示1,2,3..的分页列表
	 * @return void
	 */
	public function config($arrConfig=array()){
		if(!empty($arrConfig)){
			$this->showPageNum			= $arrConfig['show_page_num'] ? $arrConfig['show_page_num'] : $this->showPageNum;
			$this->curIndexPage			= $arrConfig['cur_index_page'] ? $arrConfig['cur_index_page'] : $this->curIndexPage;
			$this->firstPageText		= $arrConfig['first_page_text'] ? $arrConfig['first_page_text'] : $this->firstPageText;
			$this->lastPageText			= $arrConfig['last_page_text'] ? $arrConfig['last_page_text'] : $this->lastPageText;
			$this->prePageText			= $arrConfig['pre_page_text'] ? $arrConfig['pre_page_text'] : $this->prePageText;
			$this->nextPageText			= $arrConfig['next_page_text'] ? $arrConfig['next_page_text'] : $this->nextPageText;
			$this->pageCss				= $arrConfig['page_css'] ? $arrConfig['page_css'] : $this->pageCss;
			$this->curPageCss			= $arrConfig['cur_page_css'] ? $arrConfig['cur_page_css'] : $this->curPageCss;
			$this->pageStyle			= $arrConfig['page_style'] ? $arrConfig['page_style'] : $this->pageStyle;
			$this->curPageStyle			= $arrConfig['cur_page_style'] ? $arrConfig['cur_page_style'] : $this->curPageStyle;
			$this->linkSymbol			= $arrConfig['link_symbol'] ? $arrConfig['link_symbol'] : $this->linkSymbol;
			$this->isShowFirstLast		= isset($arrConfig['show_first_last']) ? $arrConfig['show_first_last'] : $this->isShowFirstLast;
			$this->isShowForSimplePage	= isset($arrConfig['show_simple_page']) ? $arrConfig['show_simple_page'] : $this->isShowForSimplePage;
            $this->isShowItems		= isset($arrConfig['show_items']) ? $arrConfig['show_items'] : $this->isShowItems;
            if(isset($arrConfig['urlParams'])){
                $this->urlParams = $arrConfig['urlParams'];
                if(!empty($this->urlParams['funcFile'])){
                    include_once($this->urlParams['funcFile']);
                }
            }
		}
	}

	/**
	 * 生成分页
	 *
	 * @return string
	 */
	public function generatePages(){
		$pageStr = '';

		$isShow = false;
		if(($this->totalPageNum > 1) || $this->isShowForSimplePage){	//设置显示分页栏
			$isShow = true;
		}
		
		if($isShow){
			if($this->currentPage > 1){
				// $prewPageUrl = $this->subPageLink.$this->linkSymbol.($this->currentPage-1);
				$prewPageUrl = $this->_getUrl($this->currentPage-1);
				if($this->isShowFirstLast){
					// $firstPageUrl = $this->subPageLink.$this->linkSymbol."1";
					$firstPageUrl = $this->_getUrl(1);
					$pageStr .= '<a href="'.$firstPageUrl.'" class="'.$this->pageCss.'" style="'.$this->pageStyle.'">'.$this->firstPageText.'</a>';
				}
				$pageStr .= '<a href="'.$prewPageUrl.'" class="'.$this->pageCss.'" style="'.$this->pageStyle.'">'.$this->prePageText.'</a>';
			}

            if($this->isShowItems){
                $a = $this->constructNumPage();
                $tempCount = count($a);
                for($i = 0; $i < $tempCount; $i++){
                    $s = $a[$i];
                    if($s == $this->currentPage ){
                        $pageStr .= '<a href="#" class="'.$this->curPageCss.'" style="'.$this->curPageStyle.'">'.$s.'</a>';
                    }else{
                        // $url = $this->subPageLink.$this->linkSymbol.$s;
                        $url = $this->_getUrl($s);
                        $pageStr .= '<a href="'.$url.'" class="'.$this->pageCss.'" style="'.$this->pageStyle.'">'.$s.'</a>';
                    }
                }
                unset($tempCount, $a);
            }

			if($this->currentPage < $this->totalPageNum){
				// $nextPageUrl = $this->subPageLink.$this->linkSymbol.($this->currentPage+1);
				$nextPageUrl = $this->_getUrl($this->currentPage+1);
				$pageStr .= '<a href="'.$nextPageUrl.'" class="'.$this->pageCss.'" style="'.$this->pageStyle.'">'.$this->nextPageText.'</a>';
				if($this->isShowFirstLast){
					// $lastPageUrl = $this->subPageLink.$this->linkSymbol.$this->totalPageNum;
					$lastPageUrl = $this->_getUrl($this->totalPageNum);
					$pageStr .= '<a href="'.$lastPageUrl.'" class="'.$this->pageCss.'" style="'.$this->pageStyle.'">'.$this->lastPageText.'</a> ';
				}
			}
		}
		return $pageStr;
	}

	/**
	 * 用来给建立分页的数组初始化的函数。
	 *
	 * @return array
	 */
	private function initArray(){
		for($i=0; $i < $this->showPageNum; $i ++){
			$this->arrPage[$i] = $i;
		}
		return $this->arrPage;
	}

	/**
	 * 用来构造显示的条目
	 * 即：[1][2][3][4][5][6][7][8][9][10]
	 *
	 * @return array
	 */
	private function constructNumPage(){
		if($this->totalPageNum < $this->showPageNum){
			$currentArray = array();
			for($i=0; $i < $this->totalPageNum; $i ++){
				$currentArray[$i] = $i + 1;
			}
		}else{
			$currentArray = $this->initArray();
			$curArrayLen = count($currentArray);
			if($this->currentPage <= $this->curIndexPage){
				for($i=0; $i < $curArrayLen; $i ++){
					$currentArray[$i] = $i+1;
				}
			}elseif (($this->currentPage <= $this->totalPageNum) && ($this->currentPage > ($this->totalPageNum - $this->showPageNum + 1))){	
				//构造最后的分页栏，35 36 37 38 39 40 [下一页] [最后一页] 总页数为40
				for($i=0; $i < $curArrayLen; $i ++){
					$currentArray[$i] = $this->totalPageNum - $this->showPageNum + 1 + $i;
				}
			}else{
				for($i=0; $i < $curArrayLen; $i ++){
					$currentArray[$i] = $this->currentPage - $this->curIndexPage + 1 +$i;
				}
			}
		}

		return $currentArray;
	}
}
?>