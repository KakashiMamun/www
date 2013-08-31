<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/17/13
 * Time: 8:34 PM
 * To change this template use File | Settings | File Templates.
 */



class Databse {



    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = '123';
    private $db_name = 'loginAPI';

    private $result = array();
    private $numResults ;

    public function connect()
    {
        if(!$this->con)
        {
            $myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);
            if($myconn)
            {
                $seldb = @mysql_select_db($this->db_name,$myconn);
                if($seldb)
                {
                    $this->con = true;
                    return true;
                } else
                {
                    return false;
                }
            } else
            {
                return false;
            }
        } else
        {
            return true;
        }
    }

    public function disconnect()
    {
        if($this->con)
        {
            if(@mysql_close())
            {
                $this->con = false;
                return true;
            }
            else
            {
                return false;
            }
        }
    }



    private function tableExists($table)
    {
        $tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb)
        {
            if(mysql_num_rows($tablesInDb)==1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    public function select($table, $rows = '*', $where = null, $order = null)
    {
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;

        if($this->tableExists($table))
        {
            $query = @mysql_query($q);
            if($query)
            {
                $this->numResults = mysql_num_rows($query);
                for($i = 0; $i < $this->numResults; $i++)
                {
                    $r = mysql_fetch_array($query);
                    $key = array_keys($r);
                    for($x = 0; $x < count($key); $x++)
                    {
                        // Sanitizes keys so only alphavalues are allowed
                        if(!is_int($key[$x]))
                        {
                            if(mysql_num_rows($query) > 1)
                                $this->result[$i][$key[$x]] = $r[$key[$x]];
                            else if(mysql_num_rows($query) < 1)
                                $this->result = null;
                            else
                                $this->result[$key[$x]] = $r[$key[$x]];
                        }
                    }
                }
                return true;
            }
            else
            {
                return false;
            }
        }
        else
            return false;
    }

    public function insert($table,$values,$rows = null)
    {
        if($this->tableExists($table))
        {
            $insert = 'INSERT INTO '.$table;
            if($rows != null)
            {
                $insert .= ' ('.$rows.')';
            }

            for($i = 0; $i < count($values); $i++)
            {
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';
            $ins = @mysql_query($insert);
            if($ins)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }


    public function delete($table,$where = null)
    {
        if($this->tableExists($table))
        {
            if($where == null)
            {
                $delete = 'DELETE '.$table;
            }
            else
            {
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
            }
            $del = @mysql_query($delete);

            if($del)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }


}