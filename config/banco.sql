create database filmes;

create sequence filmes_seq;

create table filmes (
id integer NOT NULL DEFAULT nextval('filmes_seq'::regclass),
titulo varchar(200) not null,
titulo_original varchar(200) not null,
titulo_pesquisa varchar(200) not null,
url varchar(200),
ano varchar(4),
genero varchar(400),
sinopse text,
imagem varchar(100)
);

alter table filmes add constraint PK_FILMES primary key (id);

