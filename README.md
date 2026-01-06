SELECT
    strftime('%Y', created_at) AS YEAR,
    SUM(amount) / 100 AS total
FROM 
    account_selfies GROUP BY strftime('%Y', created_at)

```sql
select 
    "recordings".*, 
    COALESCE(SUM(movements.amount), 0) as total_amount 
from "recordings" 
    left join "recordings" as "child_recordings" on 
        "child_recordings"."parent_id" = "recordings"."id" and 
        "child_recordings"."recordable_type" = 'App\Models\Movement' 
    left join "movements" on 
        "movements"."id" = "child_recordings"."recordable_id" 
where 
    "recordings"."recordable_type" = 'App\Models\Bucket' and
    "recordings"."recordable_id" = 1
group by "recordings"."id" 
order by "recordings"."created_at" desc
```
