/*
 #1) Insert a client into the clients table
 */
INSERT INTO clients (
        clientFirstname,
        clientLastname,
        clientEmail,
        clientPassword,
        comment
    )
VALUES (
        'Tony',
        'Stark',
        'tony@starkent.com',
        'IamIronM@n',
        'I am the real Ironman'
    );
/*
 #2) Modify the Tony Stark record to change the clientLevel to 3
 */
UPDATE clients
SET clientLevel = 3
WHERE clientEmail = 'tony@starkent.com';
/*
 #3) Modify the "GM Hummer" record to read "spacious interior" rather than "small interior"
 */
UPDATE inventory
SET invDescription = replace(
        invDescription,
        'small interior',
        'spacious interior'
    )
WHERE invMake = 'GM'
    AND invModel = 'Hummer';
/*
 #4) "SUV" category, 4 rows
 */
SELECT invModel
FROM inventory i
    JOIN carclassification c ON c.classificationId = i.classificationId
WHERE classificationName = 'SUV';
/*
 #5) Delete the Jeep Wrangler from the database.
 */
DELETE FROM inventory
WHERE invMake = 'Jeep'
    AND invModel = 'Wrangler';
/*
 #6) add "/phpmotors" to the beginning of the file path in the invImage and invThumbnail columns
 */
UPDATE inventory
SET invImage = concat('/phpmotors', invImage),
    invThumbnail = concat('/phpmotors', invThumbnail);