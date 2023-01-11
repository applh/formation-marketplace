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

    static function create ($table, $data)
    {
        // insert a new line in $table with columns $data
        // return the new id
        // return false if error
        $cols = '';
        $tokens = '';
        foreach ($data as $col => $val) {
            $cols .= "`$col`, ";
            $tokens .= ":$col, ";
        }
        // trim space and last comma
        $cols = trim($cols, ', ');
        $tokens = trim($tokens, ', ');


        $sqlp =
        <<<sql
        INSERT INTO `$table`
        ($cols)
        VALUES
        ($tokens)
        sql;

        $pdost = model::send_sqlp($sqlp, $data);
        if ($pdost) {
            return model::last_id();
        }
        return false;

    }

    static function read ($table, $id = null)
    {
        // read all lines from $table
        // if $id is set, read only the line with id = $id
        // return an array of lines
        // return false if error
        $sqlp =
        <<<sql
        SELECT *
        FROM `$table`
        sql;

        if ($id) {
            $sqlp .= " WHERE `id` = :id";
        }

        $pdost = model::send_sqlp($sqlp, ['id' => $id]);
        if ($pdost) {
            return $pdost->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    static function update ($table, $id, $data)
    {
        // update the line with id = $id in $table with columns $data
        // return true if ok
        // return false if error
        $cols = '';
        foreach ($data as $col => $val) {
            $cols .= "`$col` = :$col, ";
        }
        // trim space and last comma
        $cols = trim($cols, ', ');

        $sqlp =
        <<<sql
        UPDATE `$table`
        SET $cols
        WHERE `id` = :id
        sql;

        $pdost = model::send_sqlp($sqlp, array_merge($data, ['id' => $id]));
        if ($pdost) {
            return true;
        }
        return false;
    }

    static function delete ($table, $id)
    {
        // delete the line with id = $id in $table
        // return true if ok
        // return false if error
        $sqlp =
        <<<sql
        DELETE FROM `$table`
        WHERE `id` = :id
        sql;

        $pdost = model::send_sqlp($sqlp, ['id' => $id]);
        if ($pdost) {
            return true;
        }
        return false;
    }

    static function send_sqlp ($sqlp, $data)
    {
        // send a prepared sql query
        // return the PDOStatement
        // return false if error
        $pdo = sqlite::pdo();
        $pdost = $pdo->prepare($sqlp);
        if ($pdost->execute($data)) {
            return $pdost;
        }
        return false;
    }

    static function last_id ()
    {
        // return the last id of the last insert
        $pdo = sqlite::pdo();
        return $pdo->lastInsertId();
    }
    
    //_class_end_
}

//_file_end_
