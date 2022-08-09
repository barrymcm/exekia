select u.id, r.hourly, c.currency from users u
    join rates r on (u.id = r.user_id)
    join currencies c on (c.id = r.currency_id)
where u.id = 14;

select * from users where id = 14;

select * from rates;

