## How to setup Afaqy api example ?

- git clone https://github.com/sedemy/afaqy.git
- add database name to .env file 
- composer install
- You can access to this route **/get-expenses** with **GET** method from postman or browser

### The following parameters uses for filtering and sorting results..
- **vehicle_name** uses for filtering by vehicle name
- **expense_type**  to filter by type, set a string included one or more type separated with comma "," like "fuel,insurance,service"
- **min_cost**  set any value to this parameter to get minimum cost
- **max_cost**  set any value to this parameter to get maximum cost
- **min_creation_date**  set any value to this parameter to get minimum creation_date
- **max_creation_date**  set any value to this parameter to get maximum creation_date
- **sort_by**  to make sorting add "cost" or "creation_date"
- **sort_direction**  add "asc" or "desc"
