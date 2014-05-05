CREATE TABLE notifications ( 
    id               CHAR( 39 )  PRIMARY KEY
                                 NOT NULL
                                 UNIQUE,
    transaction_code CHAR( 36 )  NOT NULL 
);
