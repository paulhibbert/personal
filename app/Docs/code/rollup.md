# A MySQL query with rollup

I made a note of this at the time, as usual in a simplified and generic way, thinking it might come in handy, but I have not in fact needed it again as yet. Still you never know...

In this example there are three queries essentially filling in one column of a result each, these are unioned if that is a verb into a single result set ready for the group by clause. Rollup then provides the grand total. The following table illustrates the combined result which then has group/sum and rollup applied.

| call_id | operator | sales | non_sales | sold |
|---------|----------|-------|-----------|------|
|    1    |  Alice   |   0   |     1     |  0   |
|    2    |  Bob     |   0   |     1     |  0   |
|    3    |  Cindy   |   0   |     1     |  0   |
|    4    |  Alice   |   1   |     0     |  0   |
|    1    |  Bob     |   1   |     0     |  0   |
|    5    |  Cindy   |   1   |     0     |  0   |
|    4    |  Alice   |   0   |     0     |  1   |
|    1    |  Bob     |   0   |     0     |  1   |
|    5    |  Cindy   |   0   |     0     |  1   |

There are 6 distinct calls in total. Alice, Bob, and Cindy have one sale each and one non sales call each. Call 1 was handed from Alice to Bob and is a sales call for Bob.

As always much of the business specific detail has been omitted.

Sold calls are a subset of sales calls hence the need for counting distinct id to total calls.

```sql
SELECT 
COALESCE (operator, 'All') AS Operator,
COUNT(DISTINCT id) AS Calls,
SUM(sales) AS `Sales Calls`,
SUM(sold) AS `Sold`,
SUM(non_sales) AS `Non-Sales Calls` FROM
    (
        (
            SELECT c.id, COUNT(co.client_id) AS clients_count, 1 AS non_sales, 0 AS sales, 0 AS sold, operator FROM call_outcomes co
            JOIN calls c ON c.id = co.call_id
            JOIN outcomes o ON co.outcome_id = o.id AND o.outcome <> 'Unknown' -- exclude unknown and null outcomes
            GROUP BY c.id
            HAVING clients_count < 1 -- non sales call have no clients
        )
        UNION ALL
        (
            SELECT c.id, COUNT(co.client_id) AS clients_count, 0 AS non_sales, 1 AS sales, 0 AS sold, operator FROM call_outcomes co
            JOIN calls c ON c.id = co.call_id
            GROUP BY c.id
            HAVING clients_count > 0 -- sales calls are any calls with at least one client of any status
        )
        UNION ALL
        (
            SELECT c.id, 0 AS clients_count, 0 AS non_sales, 0 AS sales, 1 AS sold, operator FROM call_outcomes co
            JOIN calls c ON c.id = co.call_id
            WHERE co.client_status_id = 'sold'
            GROUP BY c.id
        ) -- among calls with clients count calls with at least one client with sold status
    ) combined
GROUP BY combined.operator WITH ROLLUP;
```

We expect the result to be as follows

| Operator | Calls | Sales Calls | Sold | Non-Sales Calls |
|----------|-------|-------------|------|-----------------|
| Alice    | 3     | 1           | 1    | 1               |
| Bob      | 3     | 1           | 1    | 1               |
| Cindy    | 3     | 1           | 1    | 1               |
| All      | 6     | 3           | 3    | 3               |
