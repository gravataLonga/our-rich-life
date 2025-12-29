SELECT
    strftime('%Y', created_at) AS YEAR,
    SUM(amount) / 100 AS total
FROM 
    account_selfies GROUP BY strftime('%Y', created_at)
