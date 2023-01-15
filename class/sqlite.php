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
        // https://www.sqlite.org/datatype3.html
        // https://www.sqlite.org/lang_datefunc.html

        $path_data = os::v("path_data");
        $path_db = os::v("db/sqlite/path") ?? "$path_data/sqlite.db";
        if (!file_exists($path_db)) {
            // create sqlite database in file my-data/sqlite.db with PDO
            $db = new PDO("sqlite:$path_db");
        }

        if ($db) {

            // GEOCMS
            // filesystem
            // cms
            // geo 
            // link
            // product

            // create table geocms with columns 
            // id
            // path, filename, ext, code 
            // uri, template, title, media, content, created, modified, 
            // status, tags, cats, author_id, level
            // x, y, z, t
            // link1, link2, linkname, 
            // quantity, quality, price
            $sql =
            <<<sql
            CREATE TABLE IF NOT EXISTS `geocms` (
                `id` INTEGER PRIMARY KEY,
                `path` TEXT,
                `filename` TEXT,
                `ext` TEXT,
                `code` TEXT,
                `uri` TEXT,
                `template` TEXT,
                `title` TEXT,
                `media` TEXT,
                `content` TEXT,
                `created` TEXT,
                `modified` TEXT,
                `status` TEXT,
                `tags` TEXT,
                `cats` TEXT,
                `author_id` INTEGER,
                `level` INTEGER,
                `x` REAL,
                `y` REAL,
                `z` REAL,
                `t` REAL,
                `link1` INTEGER,
                `link2` INTEGER,
                `linkname` TEXT,
                `notes` TEXT,
                `quantity` REAL,
                `quality` TEXT,
                `price` REAL
            )
            sql;
            $db->exec($sql);

            // add index to geocms on path, filename, ext, uri
            foreach (["path", "filename", "ext", "uri"] as $index) {
                $sql =
                <<<sql
                CREATE INDEX IF NOT EXISTS `$index` ON `geocms` (`$index`)
                sql;
                $db->exec($sql);
            }
 
            // create table user with columns id, path, email, username, level, role, passhash, created, modified
            $sql = 
            <<<sql
            CREATE TABLE IF NOT EXISTS `user` (
                `id` INTEGER PRIMARY KEY,
                `path` TEXT,
                `email` TEXT,
                `username` TEXT,
                `level` INTEGER,
                `role` TEXT,
                `notes` TEXT,
                `passhash` TEXT,
                `created` TEXT,
                `modified` TEXT
            )
            sql;
            $db->exec($sql);

            // create table contact with columns id, path, name, email, message, created, modified, ip, user_agent
            $sql = 
            <<<sql
            CREATE TABLE IF NOT EXISTS `contact` (
                `id` INTEGER PRIMARY KEY,
                `path` TEXT,
                `name` TEXT,
                `email` TEXT,
                `message` TEXT,
                `notes` TEXT,
                `created` TEXT,
                `modified` TEXT,
                `ip` TEXT,
                `user_agent` TEXT
            )
            sql;
            $db->exec($sql);
            
            // create views

            // create view post with columns id, path, filename, ext, uri, template, title, media, description, created, modified, status, tags, cats, author_id, level
            // order by created desc then by id desc
            $sql =
            <<<sql
            CREATE VIEW IF NOT EXISTS `post` AS
            SELECT id, path, filename, ext, uri, template, title, media, content, created, modified, status, tags, cats, notes, author_id, level
            FROM geocms
            WHERE path IN ('post')
            ORDER BY created DESC, id DESC
            sql;
            $db->exec($sql);

            // create view page with columns id, path, filename, ext, uri, template, title, media, description, created, modified, status, tags, cats, author_id, level
            // order by created desc then by id desc
            $sql =
            <<<sql
            CREATE VIEW IF NOT EXISTS `page` AS
            SELECT id, path, filename, ext, uri, template, title, media, content, created, modified, status, tags, cats, notes, author_id, level
            FROM geocms
            WHERE path IN ('page')
            ORDER BY created DESC, id DESC
            sql;
            $db->exec($sql);

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
