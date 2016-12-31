<?php

class Paginator {

	public $results = array();
	public $count = 0;
	public $page = 1;
	public $perpage = 10;

	public $first = 'First';
	public $last = 'Last';
	public $next = 'Next';
	public $prev = 'Previous';

	public function __construct($results, $count, $page, $perpage, $url) {
		$this->results = $results;
		$this->count = $count;
		$this->page = $page;
		$this->perpage = $perpage;
		$this->url = rtrim($url, '/');
	}

	public function next_link($text = null, $default = '') {
		if(is_null($text)) $text = $this->next;

		$pages = ceil($this->count / $this->perpage);

		if($this->page < $pages) {
			$page = $this->page + 1;

			return '<a href="' . $this->url . '/' . $page . '">' . $text . '</a>';
		}

		return $default;
	}

	public function prev_link($text = null, $default = '') {
		if(is_null($text)) $text = $this->prev;

		if($this->page > 1) {
			$page = $this->page - 1;

			return '<a href="' . $this->url . '/' . $page . '">' . $text . '</a>';
		}

		return $default;
	}

	public function links() {
		$html = '';

		$pages = ceil($this->count / $this->perpage);
		$range = 4;

		if($pages > 1) {

			if($this->page > 1) {
				$page = $this->page - 1;

				$html = '<li>
					<a href="' . $this->url . '" aria-label="' . $this->first . '">
						<span aria-hidden="true">&laquo;</span>
					</a>
				</li>';
			}

			for($i = $this->page - $range; $i < $this->page + $range; $i++) {
				if($i < 0) continue;

				$page = $i + 1;

				if($page > $pages) break;

				if($page == $this->page) {
					$html .= '<li><a href="' . $this->url . '/page-' . $page . '">' . $page . '</a></li> ';
				}
				else {
					$html .= '<li><a href="' . $this->url . '/page-' . $page . '">' . $page . '</a></li>';
				}
			}

			if($this->page < $pages) {
				$page = $this->page + 1;

				$html .= '
				<li>
					<a href="' . $this->url . '/page-' . $pages . '" aria-label="' . $this->last . '">
						<span aria-hidden="true">&raquo;</span>
					</a>
				</li>';
			}

		}

		return $html;
	}

}
