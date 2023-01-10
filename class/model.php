<?php

/**
 * class: model
 * created: 2023-01-10 16:54:23
 * license: MIT
 * author: appLH
 */

/**
 * model
 */
class model
{
    //_class_start_

    // make an associative array to better retrieve individual post
    static $posts = [
        'post-1' => [
            'uri' => 'post-1',
            'template' => 'post',
            'title' => 'Post 1',
            'image' => 'https://picsum.photos/id/1/640/640.jpg',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ],
        'post-2' => [
            'uri' => 'post-2',
            'template' => 'post',
            'title' => 'Post 2',
            'image' => 'https://picsum.photos/id/2/640/640.jpg',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ],
        'post-3' => [
            'uri' => 'post-3',
            'template' => 'post',
            'title' => 'Post 3',
            'image' => 'https://picsum.photos/id/3/640/640.jpg',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ],
        'post-4' => [
            'uri' => 'post-4',
            'template' => 'post',
            'title' => 'Post 4',
            'image' => 'https://picsum.photos/id/4/640/640.jpg',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ],
    ];
    
    // pages
    static $pages = [
        'index' => [
            'template' => 'home',
        ],
        'api' => [
            'template' => 'api',
        ],
        'credits' => [
            'uri' => 'credits',
            'template' => 'post',
            'title' => 'Credits',
            'image' => 'https://picsum.photos/id/4/640/640.jpg',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ],
    ];

    static function load ()
    {
        // load posts from my-data/posts.json
        $path_data = framework::$root . '/my-data';
        $path_posts = $path_data . '/posts.json';

        // if file exists
        if (file_exists($path_posts)) {
            $posts = json_decode(file_get_contents($path_posts), true);
            if (is_array($posts)) {
                // update the posts
                model::$posts = $posts;
            }
        }

        // load pages from my-data/pages.json
        $path_pages = $path_data . '/pages.json';
        // if file exists
        if (file_exists($path_pages)) {
            $pages = json_decode(file_get_contents($path_pages), true);
            if (is_array($pages)) {
                // update the pages
                model::$pages = $pages;
            }
        }
    }

    //_class_end_
}

//_file_end_
