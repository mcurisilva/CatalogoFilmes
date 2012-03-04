<?php
class DAO
{
    public static function getConn()
    {
        if (DRIVER == 'sqlite')
        {
            return new PDO(DRIVER.':'.PROJECT_PATH.'/../db/'.DBNAME);
        }
        else
        {
            return new PDO(DRIVER.':dbname='.DBNAME.';host='.HOST, USER, PWD);            
        }
    }
}