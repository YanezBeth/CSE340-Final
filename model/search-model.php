<?php
// SEARCH MODEL


function searchPHPMotors($searchWord)
{

    $db = phpmotorsConnect();
    $sql = 'SELECT DISTINCT
    c.classificationName,
    iv.*,
    im.imgPath
FROM
    inventory iv
JOIN carclassification c ON
    iv.classificationId = c.classificationId
JOIN images im ON
    iv.invId = im.invId AND im.imgPath LIKE "%-tn.%" AND im.imgPrimary = 1
WHERE
    iv.invMake LIKE :searchWord OR
    iv.invModel LIKE :searchWord OR
    iv.invDescription LIKE :searchWord OR
    iv.invColor LIKE :searchWord OR
    c.classificationName LIKE :searchWord';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':searchWord',  '%' . $searchWord . '%', PDO::PARAM_STR);
    $stmt->execute();
    $searchOutcome = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $searchOutcome;
}
