CREATE table Users(
        username varchar(50) not null,
    email varchar(255),
    password varchar(256) not null,
    nome varchar(50) not null,
    cognome varchar(50) not null,
    dataNascita date not null,
    fotoProfilo varchar(255) default null,
    UNIQUE(username),
    PRIMARY KEY (email)
);


CREATE table UserLogs(
        ID integer AUTO_INCREMENT,
    logTime timeStamp DEFAULT CURRENT_TIMESTAMP,
    User_email varchar(255),
    PRIMARY KEY (ID),
    unique (logTime, User_email),
    FOREIGN KEY (User_email) REFERENCES Users(email) on delete no action
    on update CASCADE
);


create table tipologie(
nome varchar(30),
    descrizione varchar(255),
    PRIMARY KEY(nome)
);


create table Stati(
nome varchar(30) primary key
);




CREATE TABLE Annunci(
        ID integer AUTO_INCREMENT,
    nome varchar(50) not null,
    descrizione varchar(255) default null,
    user_email varchar(255) not null,
stato varchar(30) not null,
tipologia varchar(30) not null,
    PRIMARY KEY(ID),
    FOREIGN KEY(user_email) REFERENCES users(email) on delete cascade on                 
        update cascade,
 FOREIGN KEY(stato) REFERENCES Stati(nome) on delete no action on                 
        update cascade,
FOREIGN KEY(tipologia) REFERENCES tipologie(nome) on delete no action on                 
        update cascade
);




create table foto(
        ID integer AUTO_INCREMENT,
    urlImg varchar(255),
    Annuncio_ID integer not null,
    PRIMARY KEY(ID),
    FOREIGN KEY (Annuncio_ID) REFERENCES Annunci(ID) on delete cascade on update cascade
);






create table Proposte(
ID integer AUTO_INCREMENT primary key,
valore integer not null,
time  timeStamp DEFAULT CURRENT_TIMESTAMP,
Annuncio_ID integer not null,
Stato integer not null,
User_email varchar(255),
  FOREIGN KEY(User_email) REFERENCES users(email) on delete cascade on                 
        update cascade,
 FOREIGN KEY(stato) REFERENCES Stati(nome) on delete no action on                 
        update cascade,
 FOREIGN KEY(Annuncio_ID) REFERENCES Annunci(ID) on delete cascade on                 
        update cascade




)