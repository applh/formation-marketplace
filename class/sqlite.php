<?php
/**
 * class: sqlite
 * created: 2023-01-11 13:16:39
 * license: MIT
 * author: appLH
 */

/**
 * sqlite
 */
class sqlite 
{
    //_class_start_

    static function db_create ()
    {
        $path_root = framework::$root;
        $path_db = "$path_root/my-data/sqlite.db";
        if (!file_exists($path_db)) {
            // create sqlite database in file my-data/sqlite.db with PDO
            $db = new PDO("sqlite:$path_root/my-data/sqlite.db");

        }
        if ($db) {
            // create table post
            $db->exec('CREATE TABLE IF NOT EXISTS post (id INTEGER PRIMARY KEY, uri TEXT, template TEXT, title TEXT, image TEXT, description TEXT)');

            // create table user with columns id, email, username, level, role, passhash, created, modified
            $db->exec('CREATE TABLE IF NOT EXISTS user (id INTEGER PRIMARY KEY, email TEXT, username TEXT, level INTEGER, role TEXT, passhash TEXT, created TEXT, modified TEXT)');

            // create table contact with columns id, name, email, message, created, modified, ip, user_agent
            $db->exec('CREATE TABLE IF NOT EXISTS contact (id INTEGER PRIMARY KEY, name TEXT, email TEXT, message TEXT, created TEXT, modified TEXT, ip TEXT, user_agent TEXT)');
            
        }        
    }

    static function pdo ()
    {
        static $db = null;
        if ($db) {
            return $db;
        }

        // only create the connexion once if it does not exist
        $path_root = framework::$root;
        $path_db = "$path_root/my-data/sqlite.db";
        if (!file_exists($path_db)) {
            sqlite::db_create();
        }
        $db = new PDO("sqlite:$path_db");
        return $db;
    }

    //_class_end_
}

//_file_end_
