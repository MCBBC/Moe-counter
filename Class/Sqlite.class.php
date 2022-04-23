<?php
class dbManager
{
    public $db;
    function __construct()
    {
        if(!file_exists('DB.db'))
        {
            $this->init();
            echo "数据库文件不存在";
            return;
        }
        $this->db = new SQLite3('DB.db');
    }
    function init()
    {
        $this->db = new SQLite3('DB.db');
        // TODO:
    }

    function changes()
    {
        return $this->db->changes();
    }

    function query($sql, $param = null, $memb = null)
    {
        $stmt = $this->db->prepare($sql);
        if(!$stmt)
        {
            return false;
        }
        
        if($param)
        {
            if(is_array($param))
            {
                for($i = 0; $i < count($param); $i++)
                {
                    $stmt->bindValue($i + 1, $param[$i]);
                }
            } else {
                $stmt->bindValue(1,$param);
            }
        }
        $rs = $stmt->execute();
        if(!$rs)
        {
            $stmt->close();
            return false;
        }
        $arr = $rs->fetchArray(SQLITE3_NUM);
        $rs->finalize();
        $stmt->close();
        if(!$arr)
        {
            return null;
        }
        if(!$memb)
        {
            return $arr;
        }
        $res = array();
        for($i=0; $i<count($memb); $i++)
        {
            $res[$memb[$i]] = $arr[$i];
        }
        return $res;
    }

    function queryAll($sql, $param = null, $memb = null)
    {
        $stmt = $this->db->prepare($sql);
        if(!$stmt)
        {
            return false;
        }
        if($param)
        {
            if(is_array($param))
            {
                for($i = 0; $i < count($param); $i++)
                {
                    $stmt->bindValue($i + 1, $param[$i]);
                }
            } else {
                $stmt->bindValue(1, $param);
            }
        }
        $rs = $stmt->execute();
        if(!$rs)
        {
            $stmt->close();
            return false;
        }
        
        $res = array();
        while($arr = $rs->fetchArray(SQLITE3_NUM))
        {
            if(!$memb) 
            {
                $res[] = $arr;
                continue;
            }
            if(count($memb) == 1 && $memb[0] == null)
            {
                $res[] = $arr[0];
                continue;
            }
            $it = array();
            for($i = 0; $i < count($memb); $i++)
            {
                $it[$memb[$i]] = $arr[$i];
            }
            $res[] = $it;
        }
        $rs->finalize();
        $stmt->close();
        return $res;
    }

    function querySingle($sql, $param = null)
    {
        $res = $this->query($sql, $param);
        if(!$res)
        {
            return false;
        }
        return $res[0];
    }
    
    function querySingleAll($sql, $param = null)
    {
        $stmt = $this->db->prepare($sql);
        if(!$stmt)
        {
            return false;
        }
        if($param)
        {
            if(is_array($param))
            {
                for($i = 0; $i < count($param); $i++)
                {
                    $stmt->bindValue($i + 1, $param[$i]);
                }
            }else{
                $stmt->bindValue(1, $param);
            }
        }
        $rs = $stmt->execute();
        if(!$rs)
        {
            $stmt->close();
            return false;
        }
        
        $res = array();
        while($arr = $rs->fetchArray(SQLITE3_NUM))
        {
            $res[] = $arr[0];
        }
        $rs->finalize();
        $stmt->close();
        
        return $res;
    }

    function exec($sql, $param = null)
    {
        $stmt = $this->db->prepare($sql);
        if(!$stmt)
        {
            return false;
        }
        if($param)
        {
            if(is_array($param))
            {
                for($i = 0 ;$i < count($param); $i++)
                    $stmt->bindValue($i + 1, $param[$i]);
            } else {
                $stmt->bindValue(1, $param);
            }
        }
        $rs = $stmt->execute();
        if($rs) 
        {
            $res=true;
            $rs->finalize();
        } else {
            $res=false;
        }
        $stmt->close();
        return $res;
    }
    
    function begin()
    {
        return $this->exec('BEGIN');
    }
    function rollback()
    {
        return $this->exec('ROLLBACK');
    }
    function commit()
    {
        return $this->exec('COMMIT');
    }
    
    function escapeString($s)
    {
        return $this->db->escapeString($s);
    }
    //最新插入的id
    function lastInsertRowID()
    {
        return $this->db->lastInsertRowID();
    }
    
    function lastErrorMsg ()
    {
        return $this->db->lastErrorMsg();
    }
}
?>