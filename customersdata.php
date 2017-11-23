<?php
$dbname ="wieg16";
$host ="localhost";
$username ="root";
$password ="root";
$dsn ="mysql:host=$host;dbname=$dbname";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false];
$pdo = new PDO($dsn, $username, $password, $options);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.milletech.se/invoicing/export/customers",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"name\"\r\n\r\nMarcus Dalgren\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"email\"\r\n\r\nmarcus@raket.co\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"birthday\"\r\n\r\n19800307\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"submit\"\r\n\r\nsubmit\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
        "postman-token: 73c8fb11-7ced-7099-f15c-12b0f23149f1"
    ),
));

$response = json_decode(curl_exec($curl), true);
$err = curl_error($curl);

curl_close($curl);

foreach ($response as $customer) {
    $user = $pdo->prepare("INSERT INTO `user`(
`id`,`email`,`firstname`,`lastname`,`gender`,`customer_activated`,`group_id`,`customer_company`,
`default_billing`,`default_shipping`,`is_active`,`created_at`,`updated_at`,`customer_invoice_email`,`customer_extra_text`,`customer_due_date_period`)
VALUES (
:id, :email, :firstname, :lastname, :gender, :customer_activated, :group_id, :customer_company, 
:default_billing, :default_shipping, :is_active, :created_at, :updated_at, :customer_invoice_email, :customer_extra_text, :customer_due_date_period)");

    $address = $pdo->prepare("INSERT INTO `address`(
`id`,`customer_id`,`customer_address_id`,`email`,`firstname`,`lastname`,`postcode`,`street`,`city`,
`telephone`,`country_id`,`address_type`,`company`,`country`) 
VALUES(
:id, :customer_id, :customer_address_id, :email, :firstname, :lastname, :postcode, :street, :city, 
:telephone, :country_id, :address_type, :company, :country)");

    $user->execute([
        ':id'=>$customer['id'],
        ':email'=>$customer['email'],
        ':firstname'=>$customer['firstname'],
        ':lastname'=>$customer['lastname'],
        ':gender'=>$customer['gender'],
        ':customer_activated'=>$customer['customer_activated'],
        ':group_id'=>$customer['group_id'],
        ':customer_company'=>$customer['customer_company'],
        ':default_billing'=>$customer['default_billing'],
        ':default_shipping'=>$customer['default_shipping'],
        ':is_active'=>$customer['is_active'],
        ':created_at'=>$customer['created_at'],
        ':updated_at'=>$customer['updated_at'],
        ':customer_invoice_email'=>$customer['customer_invoice_email'],
        ':customer_extra_text'=>$customer['customer_extra_text'],
        ':customer_due_date_period'=>$customer['customer_due_date_period'],
    ]);

    if (!is_array($customer['address'])) continue;

    $address->execute([
        ':id'=>$customer['address']['id'],
        ':customer_id'=>$customer['address']['customer_id'],
        ':customer_address_id'=>$customer['address']['customer_address_id'],
        ':email'=>$customer['address']['email'],
        ':firstname'=>$customer['address']['firstname'],
        ':lastname'=>$customer['address']['lastname'],
        ':postcode'=>$customer['address']['postcode'],
        ':street'=>$customer['address']['street'],
        ':city'=>$customer['address']['city'],
        ':telephone'=>$customer['address']['telephone'],
        ':country_id'=>$customer['address']['country_id'],
        ':address_type'=>$customer['address']['address_type'],
        ':company'=>$customer['address']['company'],
        ':country'=>$customer['address']['country'],
        ]);
}