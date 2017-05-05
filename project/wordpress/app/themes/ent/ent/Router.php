<?php
namespace Ent;

class Router {
    protected $context = [];
    protected $routes  = [];

    public function __construct() {
    }

    public function load_routes($folder) {
        foreach (glob($folder .'/*.php') as $file) {
            require_once($file);
        }
    }

    protected function match($condition, &$context) {
        $match = [];

        for ($i = -1; $i < count($condition); $i++) {
            if ($i > -1) {
                $match[] = $condition[$i];
            }

            $this->run_match($match, $context);
        }        
    }

    public function handle($route, $cb) {
        $route = trim(strtolower($route), ' *');

        if (!array_key_exists($route, $this->routes)) {
            $this->routes[$route] = [];
        }

        $this->routes[$route][] = $cb;
    }

    public function handle_request() {
        $context = \Timber::get_context();

        $context['_layout']         = $this->context['layout'];
        $context['_layout_sidebar'] = $this->context['layout_sidebar'];
        $context['_sidebar_name']   = $this->context['sidebar_name'];

        if (is_home() || is_archive() || is_search()) {
            $context['_template'] = 'archive.twig';
            $context['entries']   = new \Timber\PostQuery();

            if (is_home()) {
                $context['_type']      = 'home';
                $context['_post_type'] = 'post';

                $this->match(['home'], $context);
            } elseif (is_archive()) {
                $q = get_queried_object();

                if (is_post_type_archive()) {
                    $context['_type']      = 'archive.post-type';
                    $context['_post_type'] = $q->name;

                    $this->match(['archive', 'post-type', $q->name], $context);
                } elseif (is_category() || is_tag() || is_tax()) {
                    $context['_type'] = 'archive.term';
                    $context['_term'] = \Timber::get_term($q->term_taxonomy_id, $q->taxonomy);

                    $this->match(['archive', 'term', $q->taxonomy], $context);
                } elseif (is_author()) {
                    $context['_type']   = 'archive.author';
                    $context['_author'] = new \Timber\User($q->ID);

                    $this->match(['archive', 'author'], $context);
                } elseif (is_year()) {
                    $context['_type'] = 'archive.date.year';
                    $context['_year'] = get_the_date(__('ent.archive.year_format'));

                    $this->match(['archive', 'date', 'year'], $context);
                } elseif (is_month()) {
                    $context['_type']  = 'archive.date.month';
                    $context['_month'] = get_the_date(__('ent.archive.month_format'));

                    $this->match(['archive', 'date', 'month'], $context);
                } elseif (is_day()) {
                    $context['_type'] = 'archive.date.day';
                    $context['_day']  = get_the_date(__('ent.archive.day_format'));

                    $this->match(['archive', 'date', 'day'], $context);
                }
            } elseif (is_search()) {
                $context['_query'] = get_search_query();
                $context['_type']  = 'search';

                $this->match(['search'], $context);
            }
        } elseif (is_front_page() || is_singular()) {
            $context['_template'] = 'page.twig';
            $context['_type']     = 'post-type';
            $context['entry']     = \Timber::get_post();

            if (is_front_page()) {
                $context['_type'] = 'front-page';

                $this->match(['front-page'], $context);
            } elseif (is_page()) {
                $this->match(['post-type', 'page'], $context);
            } elseif (is_single()) {
                $context['_template'] = 'post.twig';
                $q = get_queried_object();

                $this->match(['post-type', $q->post_type], $context);
            }
        } elseif (is_404()) {
            $context['_template'] = '404.twig';
            $context['_type']     = '404';

            $this->match(['404'], $context);
        } else {
            $context['_template'] = 'index.twig';

            $this->match([], $context);
        }

        $template = $context['_template'];
        \Timber::render([$template, 'ent/'. $template], $context);
    }

    protected function run_match($match, &$context) {
        $match = implode('.', $match);

        if (array_key_exists($match, $this->routes)) {
            foreach ($this->routes[$match] as $cb) {
                $cb($context);
            }
        }
    }

    public function set_context_data($context) {
        $this->context = $context;
    }
}
