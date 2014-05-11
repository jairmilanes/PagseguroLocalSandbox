CREATE TABLE notification_status_history ( 
    code   VARCHAR( 30 )  PRIMARY KEY
                          NOT NULL,
    status CHAR( 20 )     NOT NULL,
    date   DATETIME 
);
