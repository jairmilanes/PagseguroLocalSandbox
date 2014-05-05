CREATE TABLE transaction_codes ( 
    code             CHAR( 40 )  PRIMARY KEY
                                 NOT NULL
                                 UNIQUE,
    transaction_code CHAR( 40 )  NOT NULL 
);
