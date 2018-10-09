<?php
/**
 * Created by PhpStorm.
 * User: Rahul K
 * Date: 30-10-2017
 * Time: 13:40
 * @author: iamRahul1973.github.io
 * @package: DB_Crud
 */

use mysqli;

class Database
{
    /**
     * @var object mysqli $db
     */
    public $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $table name of table to deal with
     * @param string $field fields to select
     * @param string $where where clause
     * @param string $conditions limit, offset, order by conditions.
     *
     * only the table name is mandatory here. if nothing passed for the field
     * parameter it will select * from the table. if you need to select multiple
     * fields but not * from a table, please separate the field names with a
     * comma and pass it.
     * if not passed anything, the where clause will be empty. if there is only
     * one where clause, just pass it. If there is more than one where clause,
     * pass it as an array.
     * the parameter conditions, will hold more conditions for a select
     * statement - ORDER BY, LIMIT, OFFSET, (add more here)
     *
     * structure of a conditions parameter
     *
     * $conditions = array(
     *                     $order   = array(
     *                                      $field_name = 'stud_id',
     *                                      $order      = 'asc / desc'
     *                                     ),
     *                     limit    = '$limit_value',
     *                     offset   = '$offset_value'
     *                    );
     *
     * if u r expecting a single row only, just access the values like this,
     * --------------------------------------------------------------------
     *
     * $fetch = $dbObj->fetchDB('table', 'field', 'where');
     * $value_1 = $fetch[0]['column_name'];
     * Just add a [0] as we are returning the same processed array for a
     * query, this is because,
     * On some occasions we know already that we are fetching a single row
     * only, just like fetching the details of a single student. But some
     * we will fetch rows from a table but that table contain only one row.
     * There is no way that we can know the query will return a single row
     * before executing the query. So it is not a good idea (i think so) to
     * return different arrays according to which case returns a sinle row.
     * Here, just add a [0].. that will solve everything...
     *
     * --------------------------------------------------------------------
     * @return array|int
     */

    function fetchDB($table, $field = '*', $where = '', $conditions = '')
    {
        $field = ($field == '') ? '*' : $field;

        if ($where == '') // means, there is no where clause to deal with
        {
            $whereClause = '';
        }
        else // preparing the where clause
        {
            if (is_array($where))
            {
                $whereClause = " WHERE ";
                $last = count($where);
                $i = 0;

                foreach($where as $value)
                {
                    $i++;
                    $whereClause .= $value;
                    if ($i != $last) {$whereClause .= " AND ";}
                }
            }
            else
            {
                $whereClause = " WHERE ".$where;
            }
        }

        // looking for additional conditions in the query

        if (!empty($conditions) && is_array($conditions))
        {
            // ORDER BY

            if (!empty($conditions[0]))
            {
                if (is_array($conditions[0]))
                {
                    if ($conditions[0][1] != 'ASC' && $conditions[0][1] != 'DESC')
                    {
                        trigger_error('Unknown query parameter given in order clause');
                        return;
                    }
                    $orderBy = ' ORDER BY '.$conditions[0][0].' '.$conditions[0][1];
                }
                else
                {
                    if ($conditions[0] == 'rand')
                    {
                        $orderBy = ' ORDER BY rand()';
                    }
                    else
                    {
                        trigger_error('Unknown query parameter given in order clause');
                        return;
                    }
                }
            }
            else
            {
                $orderBy = '';
            }

            // LIMIT & OFFSET

            $limit  = (empty($conditions[1])) ? '' : " LIMIT $conditions[1]";
            $offset = (empty($conditions[2])) ? '' : " OFFSET $conditions[2]";

            // final query

            $conditionQuery = $orderBy.$limit.$offset;
        }
        else
        {
            $conditionQuery = '';
        }

        $sql = "SELECT $field FROM $table".$whereClause.$conditionQuery;
        $result = $this->db->query($sql);

        // echo $sql;

        // If there is nothing to fetch from the table, we are returning zero.
        // To indicate that the table we need to fetch is empty

        if ($result->num_rows == 0) {return 0;}

        $dbResult = array();
        while ($row = $result->fetch_array(MYSQLI_ASSOC))
        {
            $dbResult[] = $row;
        }

        return $dbResult;
    }

    /**
     * @param string $table
     * @param string $where
     *
     * just getting the table name and where condition, preparing the
     * where condition and performing the deletion
     *
     * @return bool
     */

    public function deleteDB($table, $where = '')
    {
        if (is_array($where))
        {
            $whereClause = " WHERE ";
            $last = count($where);
            $i = 0;

            foreach($where as $value)
            {
                $i++;
                $whereClause .= $value;
                if ($i != $last) {$whereClause .= " AND ";}
            }
        }
        else
        {
            $whereClause = " WHERE ".$where;
        }

        $sql = "DELETE FROM $table".$whereClause;
        return ($this->db->query($sql)) ? true : false;
    }
}
