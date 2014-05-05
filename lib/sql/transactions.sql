CREATE TABLE transactions ( 
    code CHAR( 39 )  PRIMARY KEY
                     UNIQUE,
    xml  TEXT,
    date DATETIME 
);
