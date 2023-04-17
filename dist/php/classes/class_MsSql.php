<?php
class FunctionsMsSQL
{

    public function Insert($values = array(), $tabla, $dbh)
    {

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        foreach ($values as $field => $v) {
            $ins[] = '?';
        }

        $ins    = implode(',', $ins);
        $fields = implode(',', array_keys($values));
        $SQL    = "INSERT INTO $tabla ($fields) VALUES ($ins)";

        $sql = $dbh->prepare($SQL);
        $sql->execute(array_values($values));
        return $this->lastId = $dbh->lastInsertId();
    }

    public function Update($values, $tabla, $dbh)
    {

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $dataId = array();

        if (isset($values['FieldIdUpdate'])) {
            $idField = $values['FieldIdUpdate'];
            unset($values['FieldIdUpdate']);
        } else {
            $idField = 'id';
        }

        foreach ($values as $field => $v) {
            if ($field != 'id') {
                $ins[] = $field . '= :' . $field;
            } else {
                $dataId['id'] = $v;
            }
        }

        $ID          = $dataId['id'];
        $ins         = implode(',', $ins);
        $fields      = implode(',', array_keys($values));
        $sql         = "UPDATE $tabla SET $ins WHERE $idField ='$ID'";
        $sth         = $dbh->prepare($sql);
        $ArrayValues = array();

        foreach ($values as $f => $v) {

            $ArrayValues[':' . $f] = $v;
        }
        unset($ArrayValues[':id']);
        $sth->execute($ArrayValues);
        return $ID;
    }
 
}
