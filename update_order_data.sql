

select * from prod.orders_items;
select * from prod.orders;

/*
truncate prod.orders_items;
truncate prod.orders;
*/

update prod.orders set txn_id = 58552022 - id , status = 'Completed', payment_date = now();
update prod.orders_items set txn_id = 58552022 - order_id;