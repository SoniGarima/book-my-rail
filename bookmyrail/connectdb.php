<?php
 error_reporting(E_ALL ^ E_WARNING); 
$host        = "host = 127.0.0.1";
$port        = "port = 5432";
$dbname      = "dbname = postgres";
$credentials = "user = postgres password= ********";

$db = pg_connect( "$host $port $dbname $credentials");

$database_command = "create database railway_booking_database";
pg_query($database_command);
$dbname = "dbname = railway_booking_database";
$db = pg_connect( "$host $port $dbname $credentials");
$schema_command = "create schema if not exists rail_data_schema";
pg_query($schema_command);

$admin_table_command = "Create table if not exists rail_data_schema.admins(admin_id serial primary key, name varchar(50) not null, email varchar(50) unique not null, password varchar(20) not null, created_on timestamp)";

$user_table_command = "Create table if not exists rail_data_schema.users(user_id serial primary key, name varchar(50) not null, email varchar(50) unique not null, password varchar(20) not null, credit_card_number integer not null,address varchar(500) not null,  created_on timestamp)";

$train_table_command = "Create table if not exists rail_data_schema.trains(train_id serial ,train_number integer ,train_source varchar(100) not null, train_destination varchar(100) not null ,ac_coaches integer not null, sleeper_coaches integer not null, running boolean not null, released_for date not null, released_till date not null, released_on timestamp not null,admin_id serial, primary key(train_number,train_id),foreign key (admin_id) references rail_data_schema.admins(admin_id))";

$ticket_table_command = "Create table if not exists rail_data_schema.tickets(ticket_no integer primary key,train_number integer,train_id serial,num_of_ticket integer,coach varchar(100) not null,booked varchar(100) not null, released_on timestamp not null,foreign key (train_number,train_id) references rail_data_schema.trains(train_number,train_id))";

$passenger_table_command = "Create table if not exists rail_data_schema.passengers(ticket_no integer, name varchar(50) not null, age integer not null, gender varchar(10), coach_no integer not null, berth_no integer not null, berth_type varchar(2) not null,date date not null,foreign key (ticket_no) references rail_data_schema.tickets(ticket_no), primary key (ticket_no, coach_no, berth_no))";

$books_table_command = "Create table if not exists rail_data_schema.books(user_id serial,train_number integer,train_id serial,ticket_number integer primary key, foreign key (train_id,train_number) references rail_data_schema.trains(train_id,train_number),foreign key (user_id) references rail_data_schema.users(user_id),foreign key (ticket_number) references rail_data_schema.tickets(ticket_no))";

$berth_table_command = "Create table if not exists rail_data_schema.berths(coach varchar(100),berth_number integer not null ,type varchar(4))";

$bookings = "Create table if not exists rail_data_schema.bookings(date_dim_id int not null,train_number integer not null,train_id serial not null,ac_booked integer not null, sleeper_booked integer not null, foreign key (date_dim_id) references rail_data_schema.calender(date_dim_id),foreign key (train_number,train_id) references rail_data_schema.trains(train_number,train_id), primary key(date_dim_id,train_number,train_id))";

$old_train_records = "Create table if not exists rail_data_schema.old_train_records(update_id serial primary key, train_number integer ,train_source varchar(100) not null, train_destination varchar(100) not null ,ac_coaches integer not null, sleeper_coaches integer not null, running boolean not null, released_for date not null, released_till date , updated_on date)";

$r1 = pg_query($admin_table_command);
$r6 = pg_query($user_table_command);
$r2 = pg_query($train_table_command);
$r4 = pg_query($ticket_table_command);
$r7 = pg_query($passenger_table_command);
$r5 = pg_query($books_table_command);
$r8 = pg_query($berth_table_command);
$r9 =pg_query($bookings);
$r10 = pg_query($old_train_records);

if($r1 and $r2 and $r4 and $r5 and $r6 and $r7 and $r8 and $r9 and $r10){
    echo "\n";
}
else{
    
    echo "err in making tables";
}
?>

