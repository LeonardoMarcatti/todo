drop database todo;
create database todo;
use todo;

create table status(
	id int unsigned auto_increment primary key,
    status varchar(20) unique
);

delimiter $$
create procedure fill_status()
	begin
		insert into status(status) value('A fazer');
        insert into status(status) value('Feito');
        insert into status(status) value('Deletado');
    end $$
delimiter ;

call fill_status();

create table tarefas(
	id int unsigned auto_increment primary key,
    descricao varchar(200),
    status_id int unsigned not null,
    constraint tarefas_status foreign key(status_id) references status(id)
);