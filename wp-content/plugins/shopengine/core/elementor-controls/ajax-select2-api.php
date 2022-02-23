<?php

namespace ShopEngine\Core\Elementor_Controls;

defined('ABSPATH') || exit;

class Controls_Ajax_Select2_Api extends \ShopEngine\Base\Api {

	public function config() {
		$this->prefix = 'ajaxselect2';
	}

	public function get_post_list() {

		if(!current_user_can('edit_posts')) {
			return;
		}

		$query_args = [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
		];

		if(isset($this->request['ids'])) {
			$ids                    = explode(',', $this->request['ids']);
			$query_args['post__in'] = $ids;
		}
		if(isset($this->request['s'])) {
			$query_args['s'] = $this->request['s'];
		}

		$query   = new \WP_Query($query_args);
		$options = [];
		if($query->have_posts()):
			while($query->have_posts()) {
				$query->the_post();
				$options[] = ['id' => get_the_ID(), 'text' => get_the_title()];
			}
		endif;

		return ['results' => $options];
		wp_reset_postdata();
	}

	public function get_page_list() {
		if(!current_user_can('edit_posts')) {
			return;
		}
		$query_args = [
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
		];

		if(isset($this->request['ids'])) {
			$ids                    = explode(',', $this->request['ids']);
			$query_args['post__in'] = $ids;
		}
		if(isset($this->request['s'])) {
			$query_args['s'] = $this->request['s'];
		}

		$query   = new \WP_Query($query_args);
		$options = [];
		if($query->have_posts()):
			while($query->have_posts()) {
				$query->the_post();
				$options[] = ['id' => get_the_ID(), 'text' => get_the_title()];
			}
		endif;

		return ['results' => $options];
		wp_reset_postdata();
	}

	public function get_singular_list() {
		$query_args = [
			'post_status'    => 'publish',
			'posts_per_page' => 15,
			'post_type'      => 'any',
		];

		if(isset($this->request['ids'])) {
			$ids                    = explode(',', $this->request['ids']);
			$query_args['post__in'] = $ids;
		}
		if(isset($this->request['s'])) {
			$query_args['s'] = $this->request['s'];
		}

		$query   = new \WP_Query($query_args);
		$options = [];
		if($query->have_posts()):
			while($query->have_posts()) {
				$query->the_post();
				$options[] = ['id' => get_the_ID(), 'text' => get_the_title()];
			}
		endif;

		return ['results' => $options];
		wp_reset_postdata();
	}

	public function get_category() {

		$taxonomy   = 'category';
		$query_args = [
			'taxonomy'   => ['category'], // taxonomy name
			'orderby'    => 'name',
			'order'      => 'DESC',
			'hide_empty' => true,
			'number'     => 10,
		];

		if(isset($this->request['ids'])) {
			$ids                   = explode(',', $this->request['ids']);
			$query_args['include'] = $ids;
		}
		if(isset($this->request['s'])) {
			$query_args['name__like'] = $this->request['s'];
		}

		$terms = get_terms($query_args);


		$options = [];

		if(is_countable($terms) && count($terms) > 0):

			foreach($terms as $term) {
				$options[] = ['id' => $term->term_id, 'text' => $term->name];
			}
		endif;

		return ['results' => $options];
	}

	public function get_product_list() {
		$query_args = [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
		];

		if(isset($this->request['ids'])) {
			$ids                    = explode(',', $this->request['ids']);
			$query_args['post__in'] = $ids;
		}
		if(isset($this->request['s'])) {
			$query_args['s'] = $this->request['s'];
		}

		$query   = new \WP_Query($query_args);
		$options = [];
		if($query->have_posts()):
			while($query->have_posts()) {
				$query->the_post();
				$options[] = ['id' => get_the_ID(), 'text' => get_the_title()];
			}
		endif;

		return ['results' => $options];
		wp_reset_postdata();
	}

	public function get_product_cat() {

		$query_args = [
			'taxonomy'   => ['product_cat'], // taxonomy name
			'orderby'    => 'name',
			'order'      => 'DESC',
			'hide_empty' => false,
			'number'     => 12,
		];

		if(isset($this->request['ids'])) {
			$ids                   = explode(',', $this->request['ids']);
			$query_args['include'] = $ids;
		}

		if(isset($this->request['s'])) {
			$query_args['name__like'] = $this->request['s'];
		}

		$terms = get_terms($query_args);


		$options = [];

		if(is_countable($terms) && count($terms) > 0):
			foreach($terms as $term) {
				$options[] = ['id' => $term->term_id, 'text' => $term->name];
			}
		endif;

		return ['results' => $options];
	}

	public function get_product_authors() {

		$options = [];

		$filter_args = [
			'orderby'        => 'display_name',
			'order'          => 'ASC',
			'search_columns' => [
				//'user_email',
				'display_name',
			],
		];

		if(isset($this->request['s'])) {
			$filter_args['search'] = '*' . esc_attr($this->request['s']) . '*';
		}

		if(!empty($this->request['ids'])) {
			$filter_args['include'] = explode(',', $this->request['ids']);
		}

		$authors = get_users($filter_args);

		foreach($authors as $author) {
			$options[] = [
				'id'   => $author->ID,
				'text' => $author->display_name,
			];
		}

		return ['results' => $options];
	}

	public function get_product_tags() {

		$query_args = [
			'taxonomy'   => ['product_tag'],
			'orderby'    => 'name',
			'order'      => 'DESC',
			'hide_empty' => false,
			'number'     => 12,
		];

		if(isset($this->request['ids'])) {
			$ids                   = explode(',', $this->request['ids']);
			$query_args['include'] = $ids;
		}

		if(isset($this->request['s'])) {
			$query_args['name__like'] = esc_attr($this->request['s']);
		}

		$terms = get_terms($query_args);

		$options = [];

		if(is_countable($terms) && count($terms) > 0) {
			foreach($terms as $term) {
				$options[] = ['id' => $term->term_id, 'text' => $term->name];
			}
		}

		return ['results' => $options];
	}


	public function get_product_pa_list() {

		$options = [];
		$taxonomies = wc_get_attribute_taxonomies();

		if(empty($taxonomies)) {

			return ['results' => $options];
		}

		$filter = false;

		if(isset($this->request['s'])) {
			$filter_text = esc_attr($this->request['s']);
			$filter = !empty($filter_text);
		}

		$saved_only = false;
		$filter_ids = [];

		if(!empty($this->request['ids'])) {

			$filter_ids = explode(',', $this->request['ids']);
			$saved_only = true;
		}

		foreach($taxonomies as $idd => $taxonomy) {

			$txo = wc_attribute_taxonomy_name($taxonomy->attribute_name);
			$terms = get_terms($txo, 'orderby=name&hide_empty=0');

			if(!empty($terms)) {

				foreach($terms as $term) {

					$t_id = $term->term_id.'||'.$term->taxonomy;

					if($filter) {

						$nm = strtolower($term->name);

						if(strpos($nm, $filter_text) === false) {

							continue;
						}
					}

					if($saved_only) {

						if(!in_array($t_id, $filter_ids)) {

							continue;
						}
					}

					$options[] = [
						'id'   => $t_id,
						'text' => $term->name.'('.$taxonomy->attribute_label.')',
					];
				}
			}
		}

		return ['results' => $options];
	}

}

new Controls_Ajax_Select2_Api();
