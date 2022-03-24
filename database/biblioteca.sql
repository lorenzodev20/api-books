create schema biblioteca collate utf8mb4_0900_ai_ci;

create table autores
(
	id int unsigned auto_increment
		primary key,
	nombre varchar(255) null,
	apellido varchar(255) null
);

create table generos
(
	id int unsigned auto_increment
		primary key,
	nombre varchar(255) not null,
	ranking int unsigned null,
	activo int(1) default 1 not null,
	fecha_de_creacion datetime null,
	constraint ranking
		unique (ranking)
);

create table libros
(
	id int auto_increment
		primary key,
	titulo varchar(255) not null,
	id_autor int unsigned null,
	id_genero int unsigned null,
	constraint libros_autores_id_fk
		foreign key (id_autor) references autores (id),
	constraint libros_generos_id_fk
		foreign key (id_genero) references generos (id)
);


