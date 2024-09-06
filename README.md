### a test repo to learn on how to use minio (with docker)

##### Configure minio bucket

1. login to the bucket. uname: minio, pw: minio123
2. create new bucket
3. create new access key. copy and paste into the env
```
AWS_ACCESS_KEY_ID=[OBTAINED FROM MINIO CONSOLE]
AWS_SECRET_ACCESS_KEY=[OBTAINED FROM MINIO CONSOLE]
AWS_DEFAULT_REGION=[OBTAINED FROM MINIO CONSOLE]
AWS_BUCKET=[OBTAINED FROM MINIO CONSOLE]
AWS_URL=[YOUR DOCKER NAME]
AWS_ENDPOINT=[YOUR DOCKER NAME]
AWS_USE_PATH_STYLE_ENDPOINT=true
```
4. Use this config after creating access key
```
{
 "Version": "2012-10-17",
 "Statement": [
  {
   "Effect": "Allow",
   "Action": [
    "s3:DeleteObject",
    "s3:GetObject",
    "s3:ListBucket",
    "s3:PutObject"
   ],
   "Resource": [
    "arn:aws:s3:::laraveltest",
    "arn:aws:s3:::laraveltest/*"
   ]
  }
 ]
}

```
*laraveltest is my bucket name



##### Things that i do with this repo

1. create minio handler for connecting to minio server and handle file upload
2. for uploading file, please refer the FileController in App\Http\Controllers