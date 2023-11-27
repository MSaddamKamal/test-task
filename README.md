


# Test Task


It is a simple implementation of simulating batch processing of jobs.
The Rest APIs are built on `Laravel(10 Framework)`.

## Technology Stack
It is built on Laravel 10.10 `(Latest)` which requires PHP 8.1 + to run it.
* Laravel 10.10
* MySQL 8+




## Installation

Create `.env` file at the root of the project and add database credentials i.e you need to create a database and puts its credential here.

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yourdb
DB_USERNAME=root
DB_PASSWORD=

```
Now change you queue connection in `.env` to databse so that jobs can go to db.

```bash
QUEUE_CONNECTION=database
```


Install composer vendor packages by following command via [composer]

```bash
composer install
```

Run fresh migrations by following command

```bash
php artisan migrate:fresh
```

To toggle for Failing jobs Randomly you can define the following varible in `.env`, default value is `false`

```bash
FAIL_JOBS_RANDOMLY=true
```

#### If you find any difficulties you can refer to `.env.example` file in the root of the project.

### Start the server
To start the server run the following command in the terminal.
```bash
php artisan serve
```

Then you can access your apis at `http://localhost:8000` or `http://127.0.0.1:8000` or may be other as shown by the command above.

Also do make sure that you have added the above url as `APP_URL` in your `.env` for api docs to work.


for example

```
APP_URL=http://localhost:8000
```

### Clear Cache

After these setup its better to clear caches after configration changes and for that you can use following command.


```bash
php artisan optimize:clear
```

## API Documentation

To load the api documentation run the following command.

```bash
php artisan scribe:generate
```
And make sure you do specify the `APP_URL` in your `.env` file like

for example

```
APP_URL=http://localhost:8000
```

You can access the documentation at
`{APP_URL}/docs` e.g at `http://localhost:8000/docs`.



![Demo1](https://raw.githubusercontent.com/MSaddamKamal/wireMedia/main/sample_records/scribe_new.png)


#### Troubleshooting API Documentation

If you are not able to see the documentation you can run following command in the terminal.

```bash
php artisan scribe:generate
```

## How would do testing? (Find assistance guide below)

After all the above setup and staring the server,you can go to other terminal and start the queue worker with below commands.

```bash
php artisan queue:work

or

php artisan queue:listen

```

#### Want to fail some jobs intentionally.

You you can set the `FAIL_JOBS_RANDOMLY` variable in `.env` to `true`, its default value is `false`

```bash
FAIL_JOBS_RANDOMLY=true
```
If `FAIL_JOBS_RANDOMLY` is set to true approximately `10`% of the total jobs will fail.
`Note if total payload item count is less than 10 than no jobs will be failed` because
No of failed jobs is `floored` e.g sample output

* if there are total 20 jobs then `10% of 20 is 2` so `2 jobs will be failed`.
* if there are total 15 jobs then `10% of 15 is 1.5` so it will be floored to 1, so `1 job will be failed`.
* if there are 9 jobs total so `10% of 9 is 0.9` so it will be floored to 0, so `no job will be failed`.

<h4 style="color:red">Note: Always rerun the command `php artisan queue:work` after changing `FAIL_JOBS_RANDOMLY` env variable</h4>

#### Tips
If you want to change failed percentage you can go to `ProcessDemoTestInquiryPayload` job class and tweak the constant `FAILED_PERCENTAGE`, default value is `10`

### Postman Collection
You can download postman collection [from here .](https://raw.githubusercontent.com/MSaddamKamal/wireMedia/main/sample_records/TestTask.postman_collection.json) 

### Testing endpoint `api/demo/test` to store test inquiry payload and schedule jobs.

You can do a `post` request at your `{APP_URL}api/demo/test` e.g at `http://localhost:8000/api/demo/test`

with request body param `payload`.

Like below

```
{
    "payload": [
        {
            "ref": "T-1",
            "name": "test",
            "description": null
        },
        {
            "ref": "T-2",
            "name": "test",
            "description": "Test description"
        }
    ]
}

```

The jobs will run and you can check the results in database.


##### Sample payloads for testing.

You can download sample payloads below for testing.

*  [sample_20_records](https://raw.githubusercontent.com/MSaddamKamal/wireMedia/main/sample_records/sample_20_records.json)
*  [sample_2000_records](https://raw.githubusercontent.com/MSaddamKamal/wireMedia/main/sample_records/sample_2000_records.json)
*  [sample_2010_records](https://raw.githubusercontent.com/MSaddamKamal/wireMedia/main/sample_records/sample_2010_records.json)


### Testing endpoint `api/demo/test/activate/{ref}` to activate test.

You can do a `post` request at your `{APP_URL}api/demo/test/activate/{ref}` to activate a test

e.g at `http://localhost:8000/api/demo/test/activate/T-2`


### Testing endpoint `api/demo/test/deactivate/{ref}` to deactivate test.

You can do a `post` request at your `{APP_URL}api/demo/test/deactivate/{ref}` to deactivate a test

e.g at `http://localhost:8000/api/demo/test/deactivate/T-2`






[composer]:https://getcomposer.org/



## Troubleshooting

Run following commands for troubleshooting

```bash
php artisan optimize:clear
```

```bash
composer du
```

```bash
npm install
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.



## License
[MIT](https://choosealicense.com/licenses/mit/)

