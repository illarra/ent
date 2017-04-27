<?php
namespace Ent;

class Router {
    public function __construct() {

    }

    public function archive_all($cb) {

    }

    public function archive($cpt, $cb) {

    }

    // Wrapper del router de Timber
    public function custom() {

    }

    public function handle_request() {
        $context = \Timber::get_context();
        $context['page'] = \Timber::get_post();
        \Timber::render('index.twig', $context);

        /*
        $context = Timber::get_context();
        $context['layout'] = isset($opts['layout']) ? $opts['layout'] : 'layout.twig';
        $context['layout_sidebar'] = isset($opts['layout_sidebar']) ? $opts['layout_sidebar'] : 'ent/layouts/sidebar.twig';

        if (is_home() || is_archive() || is_search()) {
            $context['posts'] =  new \Timber\PostQuery();

            if (is_home()) {
                $tpl = 'blog.twig';
            } else if (is_archive()) {
                $q = get_queried_object();

                if (is_category() || is_tag() || is_tax()) {
                    $context['type'] = 'term';
                    $context['term'] = Timber::get_term($q->term_taxonomy_id, $q->taxonomy);
                } else if (is_author()) {
                    $context['type'] = 'author';
                    $context['author'] = new Timber\User($q->ID);
                } else if (is_year()) {
                    $context['type'] = 'year';
                    $context['year'] = get_the_date(__('wp.blog.year_format'));
                } else if (is_month()) {
                    $context['type'] = 'month';
                    $context['month'] = get_the_date(__('wp.blog.month_format'));
                } else if (is_day()) {
                    $context['type'] = 'day';
                    $context['day'] = get_the_date(__('wp.blog.day_format'));
                } else {
                    $context['type'] = '';
                }

                $tpl = 'archive.twig';
            } else if (is_search()) {
                $tpl = 'search.twig';
            }
        } else if (is_single()) {
            $context['post'] = new Timber\Post();
            $tpl = 'post.twig';
        } else if (is_page()) {
            $context['page'] = new Timber\Post();
            $tpl = 'page.twig';
        } else if (is_404()) {
            $tpl = '404.twig';
        } else {
            // Catch-all
            $tpl = 'index.twig';
        }

        Timber::render([$tpl, 'ent/'. $tpl], $context);
        */
    }
}
