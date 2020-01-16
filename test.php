<?php

// URL có chứa hai thông tin name và diachi
$url = 'https://192.168.1.16:9001/employee/check-token?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MjQ1LCJlbWFpbCI6ImR1Y3RkQGFuY2FyYXQuY29tIiwicGFzc3dvcmRfcmVzZXRfdG9rZW4iOm51bGwsInN0YXR1cyI6MTAsInVzZXJfcm9sZSI6OCwiY3JlYXRlZF9hdCI6MTUyMjg5NjkwNSwidXBkYXRlZF9hdCI6MTUzNzUxMzQxNywibmFtZSI6IlRy4bqnbiDEkMOsbmggxJDhu6ljIC0gSVQiLCJwb3NpdGlvbiI6bnVsbCwiaW1nIjoiQUNSLmpwZyIsIkJyYW5jaElEIjoiNEVCMjI2RTMtRkI0Mi00QUI0LUI4MkUtNzAyMUQyMzIyQjQwIiwicm9sZUlEIjpudWxsLCJpc19uZWVkX2NoYW5nZV9wYXNzIjowLCJjb2RlIjoiMTUyMjg5NjkwNTI0NTQiLCJwb3NpdGlvbl9pZCI6MSwiYmVnaW4iOm51bGwsImVuZCI6bnVsbCwic2FsYXJ5IjpudWxsLCJvdmVydGltZV9zYWxhcnkiOm51bGwsIm5pY2tfbmFtZSI6IkR1Y1REIiwicnVuX251bWJlciI6bnVsbCwicnVuX251bWJlcl9pZCI6bnVsbCwiQnJhbmNoSURORVciOm51bGwsIkN1cnJlbnRCcmFuY2hJRCI6bnVsbCwiZGV2ZWxvcGVyX3Blcm1pc3Npb25faWQiOjIsInVzZXJfaWQiOjI0NSwiYWxsb3dzX2xvZ2luX3RvX2FueV9hY2NvdW50IjowLCJzZWVfZXJyb3JfZGV0YWlscyI6MSwiaWF0IjoxNTc5MTQ4NzA5LCJleHAiOjE1NzkxNDkwMDl9.pF_YWpyVN78NaQvRPuF2SPH9ZMV0vkM7PUHXM9vS4DI';
// Khởi tạo CURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
// Thiết lập có return
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

curl_close($ch);

$res = json_decode($result, 1);
$user = $res['data'];
echo "Debug at".__FILE__." ".__LINE__." ".__FUNCTION__; echo "<pre>"; print_r($res); echo "</pre>"; die;
