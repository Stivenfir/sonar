<?php
class FunctionsMySQL
{

    public function Insert($values = array(), $tabla, $dbh)
    {

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->exec("SET CHARACTER SET utf8");

        foreach ($values as $field => $v) {
            $ins[] = ':' . $field;
        }

        $ins    = implode(',', $ins);
        $fields = implode(',', array_keys($values));
        $sql    = "INSERT INTO $tabla ($fields) VALUES ($ins)";

        $sth = $dbh->prepare($sql);
        foreach ($values as $f => $v) {
            $sth->bindValue(':' . $f, $v);
        }
        $sth->execute();
        return $this->lastId = $dbh->lastInsertId();
    }

    public function Update($values, $tabla, $dbh)
    {

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->exec("SET CHARACTER SET utf8");
        $dataId = array();
        $dataid = array();
        if (isset($values['FieldIdUpdate'])) {
            $idField = $values['FieldIdUpdate'];
            unset($values['FieldIdUpdate']);
        } else {
            $idField = 'ID';
        }

        foreach ($values as $field => $v) {
            if ($field != 'ID') {
                $ins[] = $field . '= :' . $field;
            } else {
                $dataId['ID'] = $v;
            }
        }

        $ID          = $dataId['ID'];
        $ins         = implode(',', $ins);
        $fields      = implode(',', array_keys($values));
        $sql         = "UPDATE $tabla SET $ins WHERE $idField ='$ID'";
        $sth         = $dbh->prepare($sql);
        $ArrayValues = array();

        foreach ($values as $f => $v) {

            $ArrayValues[':' . $f] = $v;

        }
        unset($ArrayValues[':ID']);
        $sth->execute($ArrayValues);
        return $ID ;
    }

}
