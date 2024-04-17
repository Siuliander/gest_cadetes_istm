create schema if not exists sistema_escola;

use sistema_escola;

create table if not exists tb_nacionalidade
(
	id_nacionalidade int auto_increment not null primary key,
	nacionalidade varchar(255) not null unique,
	estado_nacionalidade tinyint(1) not null default 1
);

INSERT INTO tb_nacionalidade(nacionalidade) VALUES ('angolana'),('estrangeira');

create table if not exists tb_sexo
(
	id_sexo int auto_increment not null primary key,
	sexo enum('femenino','masculino') not null unique,
	estado_sexo tinyint(1) not null default 1
);

INSERT INTO tb_sexo(sexo) VALUES ('femenino'),('masculino');

create table if not exists tb_sangue
(
	id_sangue int auto_increment not null primary key,
	sangue varchar(255) not null unique,
	estado_sangue tinyint(1) not null default 1
);

INSERT INTO tb_sangue (sangue) VALUES ('A+'),('A-'),('B+'),('B-'),('AB+'),('AB-'),('O+'),('O-');

create table if not exists tb_pessoa
(
    id_pessoa int auto_increment  not null primary key,
    nome_pessoa varchar(255) not null,
    identidade_pessoa varchar(14) not null unique,
    telefone varchar(32) null default null,
    nascimento_pessoa date null,
	email varchar(255) null default null,

	id_sexo int null,
	foreign key (id_sexo) references tb_sexo(id_sexo),
	
	id_nacionalidade int null,
	foreign key (id_nacionalidade) references tb_nacionalidade(id_nacionalidade),
	
	id_sangue int null,
	foreign key (id_sangue) references tb_sangue(id_sangue),

    perfil text null
);

insert into tb_pessoa values (1,'admin','admin',default, now(),null,null,null,null,null);

create table if not exists tb_nivel
(
	id_nivel int not null primary key,
	nivel enum("admin","daac","saac") not null unique,
	estado_nivel  tinyint(1) not null default(1)
);

insert into tb_nivel values ( 1 , "admin" , 1),( 2 , "daac" , 1),( 3 , "saac" , 1);

create table if not exists tb_admin
(
    id_admin int auto_increment  not null primary key,
    id_pessoa int not null unique,
    foreign key (id_pessoa) references tb_pessoa(id_pessoa),
    id_nivel int not null,
    foreign key (id_nivel) references tb_nivel(id_nivel),
    senha_admin varchar(32) not null default (md5(1234)),
    data_admin date null default now(),
	data_actualizacao_admin datetime not null default now(),
    estado_admin tinyint(1) not null default(1)
);

insert into tb_admin values (1,1,1,default,now(),now(),default);

create table if not exists tb_patente
(
	id_patente int auto_increment not null primary key,
	patente varchar(255) not null unique,
	estado_patente tinyint(1) not null default 1
);

INSERT INTO tb_patente (patente) VALUES
('Tenente-General'),
('Brigadeiro'),
('Coronel'),
('Tenente-Coronel'),
('Major'),
('Capitão'),
('Tenente'),
('Sub-Tenente'),
('Aspirante'),
('Cadete'),
('Sargento-Maior'),
('Sargento-Chefe'),
('Sargento-Ajudante'),
('1º Sargento'),
('2º Sargento'),
('Sub-Sargento'),
('1º Cabo'),
('2º Cabo');

create table if not exists tb_quadro
(
	id_quadro int auto_increment not null primary key,
	quadro varchar(255) not null unique,
	estado_quadro tinyint(1) not null default 1
);

INSERT INTO tb_quadro(quadro) VALUES ('meliciano'),('permanente');

create table if not exists tb_ramo
(
	id_ramo int auto_increment not null primary key,
	ramo varchar(255) not null unique,
	estado_ramo tinyint(1) not null default 1
);

INSERT INTO tb_ramo (ramo) VALUES ('exército'),('força aérea nacional'),('marinha de guerra');

create table if not exists tb_militar
(
	id_militar int auto_increment not null primary key,

    id_pessoa int not null unique,
    foreign key (id_pessoa) references tb_pessoa(id_pessoa),

	nip varchar(50) not null unique,
	
	data_corporacao date not null,
	data_militar datetime not null default now(),
	estado_militar tinyint(1) not null default 1,

    id_patente int not null,
    foreign key (id_patente) references tb_patente(id_patente),

    id_quadro int not null,
    foreign key (id_quadro) references tb_quadro(id_quadro),

    id_ramo int not null,
    foreign key (id_ramo) references tb_ramo(id_ramo)
	
);

create table if not exists tb_disciplina
(
	id_disciplina int auto_increment not null primary key,
	disciplina varchar(255) not null unique,
	id_admin int not null,
	foreign key (id_admin) references tb_admin(id_admin),
	data_disciplina datetime not null default now(),
	estado_disciplina  tinyint(1) not null default(1)
);

create table if not exists tb_curso
(
	id_curso int auto_increment not null primary key,
	curso varchar(255) not null unique,
	id_admin int not null,
	foreign key (id_admin) references tb_admin(id_admin),
	data_curso datetime not null default now(),
	estado_curso  tinyint(1) not null default(1)
);

create table if not exists tb_turma
(
	id_turma int auto_increment not null primary key,
	ano varchar(255) not null unique,
	estado_turma  tinyint(1) not null default(1)
);

INSERT INTO tb_turma ( ano, estado_turma) values ( 'I' , DEFAULT),( 'II' , DEFAULT),( 'III' , DEFAULT),( 'IV' , DEFAULT),('V' , DEFAULT),('VI' , DEFAULT);

create table if not exists tb_turma_curso
(
	id_turma_curso int auto_increment not null primary key,

	id_curso int not null,
	foreign key (id_curso) references tb_curso(id_curso),

	id_turma int not null,
	foreign key (id_turma) references tb_turma(id_turma),

	turma varchar(255) not null unique,
	ano_inicio_turma year not null,
	-- ano_fim_turma year not null,

	id_admin int not null,
	foreign key (id_admin) references tb_admin(id_admin),

	data_turma_curso datetime not null default now(),
	estado_turma_curso  tinyint(1) not null default(2)
);

create table if not exists tb_comunicado
(
	id_comunicado int auto_increment primary key not null,
	imagem_comunicado text null,
	titulo_comunicado varchar(255) not null,
	descricao_comunicado text null,
	data_comunicado datetime not null default now(),
	estado_comunicado tinyint(1) not null default(1),

	id_admin int not null,
	foreign key (id_admin) references tb_admin(id_admin)
);


create table if not exists tb_docente
(
	id_docente int auto_increment  not null primary key,

    id_pessoa int not null unique,
    foreign key (id_pessoa) references tb_pessoa(id_pessoa),

	id_disciplina int not null,
    foreign key (id_disciplina) references tb_disciplina(id_disciplina),
	
	id_disciplina2 int null,
    foreign key (id_disciplina2) references tb_disciplina(id_disciplina),

	id_disciplina3 int null,
    foreign key (id_disciplina3) references tb_disciplina(id_disciplina),

    senha_docente varchar(32) not null default (md5(1234)),
    data_docente date null default now(),
	data_actualizacao_docente datetime not null default now(),
    estado_docente tinyint(1) not null default(1)
);


create table if not exists tb_disciplina_turma
(
	id_disciplina_turma int auto_increment not null primary key,

	id_curso int not null,
	foreign key (id_curso) references tb_curso(id_curso),

	id_turma int not null,
	foreign key (id_turma) references tb_turma(id_turma),

	id_disciplina int not null,
    foreign key (id_disciplina) references tb_disciplina(id_disciplina),
	
	estado_disciplina_turma tinyint(1) not null default 1
);

CREATE TABLE IF NOT EXISTS tb_aluno
(
	id_aluno INT AUTO_INCREMENT NOT NULL PRIMARY KEY,

	id_pessoa INT NOT NULL UNIQUE,
	FOREIGN KEY (id_pessoa) REFERENCES tb_pessoa(id_pessoa),

	id_curso int not null,
	foreign key (id_curso) references tb_curso(id_curso),

	senha_aluno VARCHAR(255) NOT NULL DEFAULT( MD5(1234) ),
	data_aluno DATETIME NOT NULL DEFAULT NOW(),
	estado_aluno tinyint(1) NOT NULL DEFAULT 1
);

create table if not exists tb_matricula
(
	id_matricula int auto_increment not null primary key,

	id_aluno int not null,
	foreign key (id_aluno) references tb_aluno(id_aluno),

	id_turma_curso int not null,
	foreign key (id_turma_curso) references tb_turma_curso(id_turma_curso),
	
	data_matricula datetime not null default NOW(),

	estado_matricula tinyint(1) default 2
);

CREATE TABLE IF NOT EXISTS tb_nota
(
	id_nota int auto_increment not null primary key,
	
	id_matricula int not null,
	foreign key (id_matricula) references tb_matricula(id_matricula),
	
	id_disciplina_turma int not null,
	foreign key (id_disciplina_turma) references tb_disciplina_turma(id_disciplina_turma),
	
	nota1 tinyint(2) null default 0,
	nota2 tinyint(2) null default 0,
	exame tinyint(2) null default 0,
	recurso tinyint(2) null default 0,
	
	estado_nota tinyint(1) not null default 2
);